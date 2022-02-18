<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('version', function () {
    return response()->json([
        'version' => '0.1.0',
        'timestamp' => date('Y-m-d H:i:s'),
        'timezone' => date_default_timezone_get()
    ]);
});


Route::get('check-token', function (Request $request) {
    $user = $request->user();

    if ($user) {
        return response()->json($user);
    }
})->middleware('auth:api');
