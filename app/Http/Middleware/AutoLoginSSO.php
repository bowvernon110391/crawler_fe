<?php

namespace App\Http\Middleware;

use App\Models\SSO\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Jasny\SSO\Broker\Broker;
use Jasny\SSO\Broker\Cookies;
use Jasny\SSO\Broker\Session;

class AutoLoginSSO
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // get broker
        $broker = $this->getBroker();

        // now we're back, but we need to verify
        $verification_string = $request->get('sso_verify');

        // eager verification
        if ($verification_string) {
            $broker->verify($verification_string);

            logger('SSOLogin: verifying', [
                'verify' => $verification_string
            ]);

            // redirect again, without sso_verify
            return redirect($request->fullUrlWithoutQuery('sso_verify'));
        }
        
        // redirect logic and all that bullshit
        if (!$broker->isAttached()) {
            // not attached, redirect!
            $return_url = $request->fullUrl();
            $url = $broker->getAttachUrl(['return_url' => $return_url]);

            logger('SSOLogin: not attached!', [
                'return_url' => $return_url,
                'attach_url' => $url
            ]);

            return redirect()->away($url, 303);
        }

        // attached and verified, check for user info
        $user = $broker->request('GET', '/api/info.php');

        // are we logged in?
        if ($user) {
            logger('SSOLogin: LOGGED IN!', [
                'user' => $user
            ]);

            // cache user + login
            $userModel = User::cacheUserObject($user, $broker->getBearerToken());

            // check user (enabled?)
            if ($userModel->status == 'enabled') {
                logger('SSOLogin: LOGGING IN!', [
                    'userModel' => $userModel
                ]);

                Auth::login($userModel);
            } else {
                // disabled!! must prevent access? just do nothing...
            }
        } else {
            logger('SSOLogin: NOT LOGGED IN!');
            if (Auth::check()) {
                // logout to clear stale sso auth
                Auth::logout();
            }
        }

        return $next($request);
    }

    public function getBroker(): Broker {
        // auto construct
        return (new Broker(
            config('sso.url'), config('sso.broker'), config('sso.secret')
        ));
    }
}
