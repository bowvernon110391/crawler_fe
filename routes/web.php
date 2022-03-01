<?php

use App\Http\Controllers\CrawlingJobController;
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

// Use setiadi's sso to handle login + logout
Route::get('/login', function () {
    // simply redirect to sso login url
    return Inertia::location(config('sso.login_url'));
})->name('login');

// logout only possible if we're auth-ed
Route::post('/logout', function () {
    // simply redirect to sso logout url
    return Inertia::location('https://sso.siroleg.xyz/user/logout');
})->middleware('auth')->name('logout');

// sample pages
Route::get('/about', function () {
    return Inertia::render('About', [
        'title' => 'About Crawler'
    ]);
})->middleware('auth');

Route::get('/dummy/{id}', function ($id) {
    sleep(random_int(0, 5));

    $type = [
        2 => 'warning',
        3 => 'success',
        4 => 'error',
    ];

    return Inertia::render('Dummy', [
        'id' => (int) $id
    ])
    ->with([
        'message' => "Dummy #{$id} is checked",
        'messageType' => $type[$id] ?? 'info' 
    ]);
});

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

// resource controller
Route::middleware('auth')->group(function() {
    // crawling jobs
    Route::resource('jobs', CrawlingJobController::class);
});

