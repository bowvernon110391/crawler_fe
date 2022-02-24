<?php

use App\Models\SSO\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', function () {
    // simply redirect to sso login url
    return Inertia::location(config('sso.login_url'));
})->name('login');

Route::get('/about', function () {
    return Inertia::render('About', [
        'title' => 'About Crawler'
    ]);
})->middleware('auth');

Route::get('/', function () {
    // return view('welcome');
    return Inertia::render('Home', [
        'title' => 'Homepage',
        'contents' => [
            "This is the first paragraph. I don't know if it's gonna be rendered just fine",
            "This is the second paragraph. I don't know if it's gonna be rendered just fine",
            "This is the third paragraph. I don't know if it's gonna be rendered just fine",
            Auth::check() ? "You're logged in" : "You're not logged in though"
        ],
        'users' => User::paginate(10)
    ]);
});//->middleware('auth');

Route::get('/test', function () {
    abort(403);
});

Route::post('/logout', function (Request $request, \Jasny\SSO\Broker\Broker $broker) {
    // simply call our broker instance?
    // $broker->request('POST', '/api/logout.php');

    // // make our token unusable
    // $user = $request->user();
    // $user->disableToken();

    // // log our user out
    // Auth::logout();

    // // redirect
    // // return redirect('/');
    // // use external redirect to force mounting
    // return Inertia::location(url('/'));
    return Inertia::location('https://sso.siroleg.xyz/user/logout');
})->middleware('auth');