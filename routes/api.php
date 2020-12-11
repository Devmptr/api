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
| b624c6319184.ap.ngrok.io
*/

Route::post('login', 'API\UserController@loginPost');
Route::get('test', 'API\UserController@test');
Route::post('register', 'API\UserController@registerPost');

Route::prefix('user')->group(function(){
    Route::resource('keluarga', 'API\KeluargaController');
    Route::resource('anggota', 'API\AnggotaKeluargaController');

    Route::post('keluarga/firstlogin', 'API\KeluargaController@firstLogin');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
