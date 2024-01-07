<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\userController;

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
Route::controller(userController::class)->group(function(){
    Route::post('login','loginUser');
});

Route::controller(userController::class)->group(function(){

    Route::get('user','getUserDetail');
    Route::get('logout','userLogout');

})->middleware('auth:api');

// Route::group(['middleware' => 'auth:api'], function () {
//     Route::get('user', [userController::class, 'getuser']);
// });
