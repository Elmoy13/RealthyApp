<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsersController;

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

Route::controller(AuthController::Class)->group(function(){

    Route::post('/register', 'register');
    Route::post('/login', 'login');


});
Route::put('/updateRandom/{email}', [AuthController::class,'updateRandomPassword']);
Route::middleware('auth:sanctum')->delete('/logout', [AuthController::class, 'logout']);
Route::get('/users/show/{id}',[UsersController::class,'showById']);
