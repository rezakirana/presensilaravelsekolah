<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use PHPUnit\Framework\MockObject\Rule\Parameters;

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
Route::get('cek-token', 'Api\UserController@cek_token'); 
Route::group(['middleware' => ['jwt.verify']], function() {
    Route::apiResource('/users', 'Api\UserController');
    Route::apiResource('/guru', 'Api\GuruController');
    Route::apiResource('/mapel', 'Api\MapelController');
    Route::apiResource('/kelas', 'Api\KelasController')->parameters(['kelas' => 'kelas']); 
    Route::apiResource('/siswa', 'Api\SiswaController');
    Route::apiResource('/jadwal', 'Api\JadwalController');
    Route::apiResource('/presensi', 'Api\PresensiController');

    Route::get('info', 'Api\UserController@info'); 
    Route::get('/user-untuk-guru','Api\UserController@get_user_guru');
   });
   
 

 Route::post('/login', 'Api\AuthController@login');

