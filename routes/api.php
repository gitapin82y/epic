<?php

use App\Http\Controllers\SuratController;
use Illuminate\Http\Request;

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

Route::middleware('api')->group(function () {

    // Route::any('/notif', 'HomeController@apinotif');

    Route::any('login', 'loginController@loginApi');

    // User Petugas
    Route::get('/petugas', 'PetugasController@getData');
    Route::post('login', 'loginController@loginApi');

    
    // pemohon
    Route::post('pemohon/register', 'PemohonController@simpan');

    // Surat
    Route::get('list-surat', [SuratController::class, 'getData']);
    Route::get('surat/detail', 'SuratController@edit');
    Route::post('surat/create', 'SuratController@simpan');
    Route::post('surat/upload-dokumen', 'SuratController@uploadDokumenSyarat');
    Route::post('surat/kirim-surat', 'SuratController@kirimSuratPengajuan');
    Route::post('surat/validasi-surat', 'SuratController@validasi');
    Route::post('surat/verifikasi-surat', 'SuratController@validasi');
    Route::post('surat/kembalikan', 'SuratController@kembalikan');


     // Surat Jenis
     Route::get('surat-jenis/', 'SuratJenisController@getData');

     // Surat Syarat
     Route::get('surat-syarat/', 'SuratSyaratController@getData');

    Route::any('/listroom', 'ChatController@apilistroom');
    Route::any('/listchat', 'ChatController@apilistchat');
    Route::any('/sendchat', 'ChatController@apisendchat');
    Route::any('/countchat', 'ChatController@apicountchat');

    Route::any('loginpemohon', 'LoginPemohonController@loginApi');
    Route::any('registerpemohon', 'RegisterPemohonController@apiregister');
});
