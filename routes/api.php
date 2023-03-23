<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/', function () {
    return view('welcome');
})->name('login');  // naming route by name method

Route::get('/xdebug', 'App\Http\Controllers\GetXdebugController');

// Log::debug("This is message-------------");


Route::post('/input', 'App\Http\Controllers\Api\RegisterController@tmp_register');
Route::post('/register', 'App\Http\Controllers\Api\RegisterController@def_register');
Route::post('/login', 'App\Http\Controllers\Api\LoginController@login');
Route::post('/change', 'App\Http\Controllers\Api\ChangeController@change');
Route::post('/validate', 'App\Http\Controllers\Api\ResetController@tmp_reset');
Route::post('/reset', 'App\Http\Controllers\Api\ResetController@def_reset');
