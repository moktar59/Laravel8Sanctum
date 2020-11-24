<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TestController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/test', [TestController::class, 'test']);
    Route::get('/user/list', [App\Http\Controllers\Api\UserController::class, 'list']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user/list-dropdown', [App\Http\Controllers\Api\UserController::class, 'userListDropDown']);
    Route::post('/user/address/store', [App\Http\Controllers\Api\UserController::class, 'saveUserAddress']);
});

Route::get('/redis/test', [App\Http\Controllers\Api\UserController::class, 'testCache']);

Route::get('user-list', function() {
    return response()->json([
        'status_code' => 200,
        'data' => \App\Library\DropDowns::userList()
    ]);
});

Route::get('division-list', function() {

});

Route::get('division-list', function() {
    
});

Route::get('division-list', function() {
    
});

Route::get('div-dist-upa-list', function() {
    return response()->json([
        'status_code' => 200,
        'upazilaList' => \App\Library\DropDowns::upazilaList(),
        'data' => [
            'divisionList' => \App\Library\DropDowns::divisionList(),
            'districtList' => \App\Library\DropDowns::districtList(),
            'upazilaList' => \App\Library\DropDowns::upazilaList()
        ]
    ]);
});
