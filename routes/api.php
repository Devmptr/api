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

    Route::get('anggota/{id}/selected', 'API\AnggotaKeluargaController@getAnggotaKeluarga');
    Route::post('keluarga/firstlogin', 'API\KeluargaController@firstLogin');
});

Route::prefix('admin')->group(function(){
    //crud user
    Route::get('user/all', 'API\AdminController@getUser');
    Route::get('user/show/{id}', 'API\AdminController@showUser');
    Route::post('user/create', 'API\AdminController@createUser');
    Route::post('user/update/{id}', 'API\AdminController@updateUser');
    Route::get('user/delete/{id}', 'API\AdminController@deleteUser');

    //crud keluarga
    Route::get('keluarga/all', 'API\AdminController@getKeluarga');
    Route::get('keluarga/show/{id}', 'API\AdminController@showKeluarga');
    Route::post('keluarga/create', 'API\AdminController@createKeluarga');
    Route::post('keluarga/update/{id}', 'API\AdminController@updateKeluarga');
    Route::get('keluarga/delete/{id}', 'API\AdminController@deleteKeluarga');

    //crud anggota
    Route::get('anggota/all', 'API\AdminController@getAnggota');
    Route::get('anggota/show/{id}', 'API\AdminController@showAnggota');
    Route::post('anggota/create', 'API\AdminController@createAnggota');
    Route::post('anggota/update/{id}', 'API\AdminController@updateAnggota');
    Route::get('anggota/delete/{id}', 'API\AdminController@deleteAnggota');

    //validasi
    Route::post('anggota/validasi/{id}', 'API\AdminController@validasiAnggota');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
