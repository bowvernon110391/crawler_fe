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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('version', function () {
    sleep(4);
    return response()->json([
        'version' => '0.1.0',
        'timestamp' => date('Y-m-d H:i:s'),
        'timezone' => date_default_timezone_get()
    ]);
});
