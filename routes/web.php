<?php

use App\Http\Controllers\PenugasanSurveyController;
use App\Http\Controllers\SurveyController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', 'PublicController@index')->name('homepage');

Route::get('/buat-permohonan', 'PublicController@buatPermohonan')->name('buat-perizinan');
Route::get('/ajukan-perizinan', 'PublicController@ajukanPerizinan')->name('ajukan-perizinan');
Route::get('/ajukan-syarat-perizinan', 'PublicController@ajukanSyaratPerizinan')->name('ajukan-syarat-perizinan');
Route::post('/create-perizinan', 'PublicController@createPerizinan');
Route::get('/perizinan-berhasil-diajukan', 'PublicController@success')->name('pengajuan-berhasil');
Route::get('/generate-pdf', 'PublicController@cetakRegisPdf');
Route::get('/cetak-perizinan', 'PerizinanPemohonController@cetakPerizinan');

Route::get('/lacak-perizinan', 'PublicController@lacakPerizinan')->name('lacak-perizinan');
Route::post('/lacak-perizinan', 'PublicController@detailPerizinan')->name('detail-perizinan');
// Route::get('/detail-perizinan/{id}', 'PublicController@getDetailPerizinan')->name('detail-perizinan');
Route::get('/permohonan-saya', 'PerizinanPemohonController@index')->name('list-perizinan');
Route::get('/get-data-perizinan', 'PublicController@getDataByJenis');




Route::group(['middleware' => 'guest'], function () {
    Route::get('/admin', 'loginController@admin')->name('admin');

    Route::get('login', 'loginController@authenticate')->name('login');
    Route::get('register', 'RegisterController@index')->name('register');
    Route::get('doregister', 'RegisterController@doregister')->name('doregister');
    Route::get("verification/{id}", 'VerificationController@index');
    Route::get("resendverification/{id}", 'VerificationController@resend');
    Route::get("doverification", 'VerificationController@doverification');
    Route::get("forgotpassword", 'ForgotpasswordController@index');
    Route::get("doforgot", 'ForgotpasswordController@doforgot');
    Route::get("forgotlink/{id}/{accesstoken}", 'ForgotpasswordController@forgotlink');
    Route::get("doforgotlink", 'ForgotpasswordController@doforgotlink');
    Route::get("forgotlogin/{id}", 'ForgotpasswordController@forgotlogin');

    Route::get("generatetagihan", 'TagihanController@generatetagihan');

    Route::get("tesemail", 'VerificationController@tesemail');
    // Route::post('login', 'loginController@authenticate')->name('login');

    Route::get('loginpemohon', 'LoginPemohonController@index');
    Route::get('loginpemohon/auth', 'LoginPemohonController@authenticate');
    Route::get('registerpemohon', 'RegisterPemohonController@index');
    Route::post('registerpemohon/register', 'RegisterPemohonController@register');
    Route::get('loginGoogle', 'LoginPemohonController@google');
    // routes/web.php
    Route::get('login/google', 'LoginPemohonController@redirectToGoogle');
    Route::get('login/google/callback', 'LoginPemohonController@handleGoogleCallback');

});


Route::group(['middleware' => 'auth'], function () {

//pemohon
Route::get('perizinan', 'PerizinanPemohonController@index');
Route::get('perizinantable/{status}', 'PerizinanPemohonController@datatable');
Route::get('editperizinan', 'PerizinanPemohonController@edit');
Route::post('penilaian-app', 'PertanyaanSurveyKepuasanController@sendSurveyKepuasan')->name('penilaian-app');

// Route::get('pemohonaccjadwalperizinan', 'PerizinanPemohonController@pemohonAccJadwalSurvey');
// Route::get('jadwalulang', 'PerizinanPemohonController@jadwalulang');

Route::get('profil-pengguna', 'PublicController@profilPengguna');
Route::put('/profil-pengguna/{id}', 'PublicController@profilPenggunaUpdate')->name('profil-pengguna.update');
Route::post('/update-password-pemohon', 'PublicController@updatePassword');
//end pemohon


Route::get('/home', 'HomeController@index')->name('index');
Route::get('logout', 'HomeController@logout')->name('logout');

Route::get('petugas', 'PetugasController@index');
Route::get('petugastable', 'PetugasController@datatable');
Route::get('editpetugas', 'PetugasController@edit');
Route::get('simpanpetugas', 'PetugasController@simpan');
Route::get('hapuspetugas', 'PetugasController@hapus');

Route::get('pemohon', 'PemohonController@index');
Route::get('pemohontable', 'PemohonController@datatable');
Route::get('editpemohon', 'PemohonController@edit');
Route::get('simpanpemohon', 'PemohonController@simpan');
Route::get('hapuspemohon', 'PemohonController@hapus');
Route::get('approvepemohon', 'PemohonController@approve');
Route::get('tolakpemohon', 'PemohonController@tolak');
Route::get('tolakprocesspemohon', 'PemohonController@tolakprocess');

Route::get('surat-jenis', 'SuratJenisController@index');
Route::get('suratjenistable', 'SuratJenisController@datatable');
Route::get('editsuratjenis', 'SuratJenisController@edit');
Route::get('simpansuratjenis', 'SuratJenisController@simpan');
Route::get('hapussuratjenis', 'SuratJenisController@hapus');

Route::get('surat-syarat', 'SuratSyaratController@index');
Route::get('suratsyarattable/{surat_jenis_id}', 'SuratSyaratController@datatable');
Route::get('suratsyarattableall', 'SuratSyaratController@datatableNoFilter');
Route::get('editsuratsyarat', 'SuratSyaratController@edit');
Route::post('simpansuratsyarat', 'SuratSyaratController@simpan');
Route::get('hapussuratsyarat', 'SuratSyaratController@hapus');

Route::get('chatbot', 'ChatbotController@index');
Route::post('chatbot/save', 'ChatbotController@save');


Route::get('surat', 'SuratController@index');
Route::get('surattable/{status}', 'SuratController@datatable');
Route::get('editsurat', 'SuratController@edit');
Route::get('validasisurat', 'SuratController@validasi');
Route::get('kembalikansurat', 'SuratController@kembalikan');
// Route::get('simpansuratsyarat', 'SuratSyaratController@simpan');
// Route::get('hapussuratsyarat', 'SuratSyaratController@hapus');

// Arsip
Route::get('arsip', 'ArsipController@index');
Route::get('arsiptable/{jenis_surat}', 'ArsipController@datatable');
Route::get('editarsip', 'ArsipController@edit');

Route::get('/chat', 'ChatController@index');
Route::get('/listroom', 'ChatController@listroom');
Route::get('/listchat', 'ChatController@listchat');
Route::get('/sendchat', 'ChatController@sendchat');
Route::get('/newroom', 'ChatController@newroom');
// Video Panduan
Route::get('video-panduan', 'VideoPanduanController@index');
Route::get('videopanduantable', 'VideoPanduanController@datatable');
Route::get('editvideopanduan', 'VideoPanduanController@edit');
Route::get('simpanvideopanduan', 'VideoPanduanController@simpan');
Route::get('hapusvideopanduan', 'VideoPanduanController@hapus');

// Management pertanyaan survey kepuasan
Route::get('survey-kepuasan/management-pertanyaan', 'PertanyaanSurveyKepuasanController@index');
Route::get('pertanyaansurveykepuasantable', 'PertanyaanSurveyKepuasanController@datatable');
Route::get('editpertanyaansurveykepuasan', 'PertanyaanSurveyKepuasanController@edit');
Route::get('simpanpertanyaansurveykepuasan', 'PertanyaanSurveyKepuasanController@simpan');
Route::get('hapuspertanyaansurveykepuasan', 'PertanyaanSurveyKepuasanController@hapus');
Route::get('survey-kepuasan/ubahstatus', 'PertanyaanSurveyKepuasanController@updateStatus');

}); 

// Survey
Route::get('survey/jadwal', 'SurveyController@index');
Route::get('surveyjadwaltable', 'SurveyController@datatable');
Route::get('simpansurveyjadwal', 'SurveyController@simpan');
Route::get('editsurveyjadwal', 'SurveyController@edit');


Route::get('survey/penugasan-survey', 'PenugasanSurveyController@index');
Route::get('surveypenugasantable', 'PenugasanSurveyController@datatable');
Route::get('simpansurveypenugasan', 'PenugasanSurveyController@simpan');
Route::get('editsurveypenugasan', 'PenugasanSurveyController@edit');
Route::get('survey/penugasan/laporan/{id}',  [PenugasanSurveyController::class, 'laporan']);
Route::post('kirim-laporan', 'SurveyController@submitFormLaporanPertama');

Route::get('survey/hasil-survey', 'SuratController@getListHasilSurvey');
Route::get('hasilsurveytable', 'SuratController@datatableHasilSurvey');
Route::get('survey/penugasan/laporan/{id}',  [PenugasanSurveyController::class, 'laporan']);

 // Verifikasi Hasil Survey
 Route::post('surat/verifikasi-survey', 'SuratController@approveHasilSurvey');
 Route::post('surat/tolak-survey', 'SuratController@tolakHasilSurvey');



// End Route Groub middleware auth
// Route::get('petugas', 'PetugasController@index');
// Route::get('petugastable', 'PetugasController@datatable');
// Route::get('editpetugas', 'PetugasController@edit');
// Route::get('simpanpetugas', 'PetugasController@simpan');
// Route::get('hapuspetugas', 'PetugasController@hapus');


// Route::get('/', function () {
//     return view('pages.landingpage');
// });

// Route::get('/dashboard', function () {
//     return view('pages.dashboard');
// });


// Route::get('/login', function () {
//     return view('login-system.login');
// });


// Route::get('/register', function () {
//     return view('login-system.register');
// });