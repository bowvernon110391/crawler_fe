<?php

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

Route::get('/abuud', function () {
    return Inertia::render('About');
})->middleware('auth:web');

Route::get('/', function () {
    // return view('welcome');
    return Inertia::render('Home', [
        'title' => 'Hello, welcome to inertia',
        'contents' => [
            "This is the first paragraph. I don't know if it's gonna be rendered just fine",
            "This is the second paragraph. I don't know if it's gonna be rendered just fine",
            "This is the third paragraph. I don't know if it's gonna be rendered just fine"
        ]
    ]);
});
