<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;

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

//public
//register = signup / create new account
Route::post('signup', [UserController::class, 'signup']);
Route::post('login', [UserController::class, 'login']);

//student
Route::get('schools', [PostController::class, 'index']);
Route::get('schools/{id}', [PostController::class, 'show']);
// private
Route::group(['middleware' => ['auth:sanctum']], function(){
    // school
    Route::post('schools', [PostController::class, 'store']);
    Route::put('schools/{id}', [PostController::class, 'update']);
    Route::delete('schools/{id}', [PostController::class, 'destroy']);
    // user
    Route::post('logout', [UserController::class, 'logout']);
});
