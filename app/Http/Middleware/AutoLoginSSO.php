<?php

namespace App\Http\Middleware;

use App\Models\SSO\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jasny\SSO\Broker\Broker;

/**
 * AutoLoginSSO
 * -------------------------------
 * This middleware automatically login our user
 * if we're logged in the SSO.
 */
class AutoLoginSSO {
    // the broker instance
    protected $broker;

    // Use dependency injection to get broker...
    public function __construct(Broker $broker) {
        $this->broker = $broker;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next) {
        // get broker from our service provider?
        // $broker = app()->make(Broker::class);

        // special case if we're in dev mode
        if (app()->environment(['local', 'dev', 'development', 'staging', 'test'])) {
            // authenticate using mock user
            $mockup_user_id = config('sso.mock_user_id');
            $user = User::find($mockup_user_id);
            if (!$user) {
                // then we don't even have mockup user. SAD!
                abort(403, "Mockup user with id({$mockup_user_id}) doesn't exist. SAD! generate some, bucko!");
            }
            // the mockup user exist. login using that
            Auth::login($user);
            // log
            logger('Mock Auth with', [ 'user' => $user ]);
            // continue chain
            return $next($request);
        }

        // ==================================================================================================
        // PRODUCTION MODE!
        // now we're back, but we need to verify
        $verification_string = $request->get('sso_verify');

        // eager verification
        if ($verification_string) {
            $this->broker->verify($verification_string);

            logger('SSOLogin: verifying', [
                'verify' => $verification_string
            ]);

            // redirect again, without sso_verify
            return redirect($request->fullUrlWithoutQuery('sso_verify'));
        }

        // redirect logic and all that bullshit
        if (!$this->broker->isAttached()) {
            // not attached, redirect!
            $return_url = $request->fullUrl();
            $url = $this->broker->getAttachUrl(['return_url' => $return_url]);

            logger('SSOLogin: not attached!', [
                'return_url' => $return_url,
                'attach_url' => $url
            ]);

            return redirect()->away($url, 303);
        }

        // attached and verified, check for user info
        $user = $this->broker->request('GET', '/api/info.php');

        // are we logged in?
        if ($user) {
            logger('SSOLogin: LOGGED IN!', [
                'user' => $user
            ]);

            // cache user + login
            $userModel = User::cacheUserObject($user, $this->broker->getBearerToken());

            // check user (enabled?)
            if ($userModel->status == 'enabled') {
                logger('SSOLogin: LOGGING IN!', [
                    'userModel' => $userModel
                ]);

                Auth::login($userModel);
            } else {
                // well if in some cases the user is disabled mid-way...
                // let's tell them they're banned!
                if (Auth::check()) {
                    abort(403, "Your user has been disabled. Contact administrator!");
                }
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
}
