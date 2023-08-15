<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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
Route::get('login',[AuthController::class,'login'])->name('login');
Route::post('login',[AuthController::class,'doLogin']);
Route::get('/',function (){
    return redirect()->to('aktivasi');
});
Route::get('/aktivasi',[\App\Http\Controllers\AuthController::class,'halamanAktivasi'])->name('aktivasi');
Route::post('aktivasi',[\App\Http\Controllers\AuthController::class,'aktivasiSubmit']);
Route::post('revoke-aktivasi',[\App\Http\Controllers\AuthController::class,'aktivasiRevoke'])->name('aktivasi.revoke');
Route::get('/daftar-peserta',[\App\Http\Controllers\TesController::class,'halamanDaftar'])->name('daftar-peserta');
Route::get('/pre-tes',[\App\Http\Controllers\TesController::class,'preTes'])->name('pre-test');
Route::post('/mulai-tes',[\App\Http\Controllers\TesController::class,'mulaiTes'])->name('mulai-test');
Route::post('/batal-ujian',[\App\Http\Controllers\TesController::class,'batalUjian'])->name('batal-ujian');
Route::get('/hasil-tes',[\App\Http\Controllers\TesController::class,'hasilTes'])->name('hasil-test');
Route::get('/get-tes',[\App\Http\Controllers\TesController::class,'getTest'])->name('get-test');
Route::post('daftar-peserta',[\App\Http\Controllers\TesController::class,'daftarPeserta']);
Route::post('submit-jawaban',[\App\Http\Controllers\TesController::class,'submitJawaban']);
Route::post('selesai',[\App\Http\Controllers\TesController::class,'selesaiTes']);
Route::post('clear-data',[\App\Http\Controllers\TesController::class,'clearData']);
Route::get('/tes',[\App\Http\Controllers\TesController::class,'runningTes']);
Route::get('/preview',[\App\Http\Controllers\TesController::class,'previewTes'])->name('preview');
Route::group(['middleware' => 'auth','prefix' => 'dashboard'],function (){
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [\App\Http\Controllers\UserController::class,'profile'])->name('dashboard.profile');
    Route::post('/profile', [\App\Http\Controllers\UserController::class,'updateProfile']);
    Route::get('/peserta', [\App\Http\Controllers\PesertaController::class,'index'])->name('dashboard.peserta');

    Route::get('/tes', [\App\Http\Controllers\TesController::class,'index'])->name('dashboard.tes');
    Route::get('/tes/add', [\App\Http\Controllers\TesController::class,'add'])->name('dashboard.tes.add');
    Route::get('/tes/edit/{id}', [\App\Http\Controllers\TesController::class,'edit'])->name('dashboard.tes.edit');
    Route::post('/tes/add', [\App\Http\Controllers\TesController::class,'addPost']);
    Route::post('/tes/edit/{id}', [\App\Http\Controllers\TesController::class,'editPost']);
    Route::post('/tes/{id}/delete', [\App\Http\Controllers\TesController::class,'deleteTes'])->name('dashboard.tes.delete');
    Route::post('/tes/{id}/toggle-aktif', [\App\Http\Controllers\TesController::class,'toggleActiveTes'])->name('dashboard.tes.non-active');

    Route::get('/user', [\App\Http\Controllers\UserController::class,'index'])->name('dashboard.user');
    Route::get('/user/add', [\App\Http\Controllers\UserController::class,'add'])->name('dashboard.user.add');
    Route::get('/user/edit/{id}', [\App\Http\Controllers\UserController::class,'edit'])->name('dashboard.user.edit');
    Route::post('/user/add', [\App\Http\Controllers\UserController::class,'addPost']);
    Route::post('/user/edit/{id}', [\App\Http\Controllers\UserController::class,'editPost']);
    Route::post('/user/{id}/delete', [\App\Http\Controllers\UserController::class,'deleteTes'])->name('dashboard.user.delete');

    Route::get('/soal',[\App\Http\Controllers\SoalController::class,'index'])->name('dashboard.soal');
    Route::get('/soal/add',[\App\Http\Controllers\SoalController::class,'add'])->name('dashboard.soal.add');
    Route::get('/soal/edit/{id}',[\App\Http\Controllers\SoalController::class,'edit'])->name('dashboard.soal.edit');
    Route::post('/soal/add',[\App\Http\Controllers\SoalController::class,'addPost']);
    Route::post('/soal/edit/{id}',[\App\Http\Controllers\SoalController::class,'editPost'])->name('dashboard.soal.edit');
    Route::post('/soal/{id}/delete',[\App\Http\Controllers\SoalController::class,'deleteKelompokSoal'])->name('dashboard.soal.delete');

    Route::get('/soal/{id_kelompok}/kolom',[\App\Http\Controllers\SoalController::class,'kolomSoal'])->name('dashboard.soal.kolom');
    Route::get('/soal/{id_kelompok}/kolom/add',[\App\Http\Controllers\SoalController::class,'addKolom'])->name('dashboard.soal.kolom.add');
    Route::get('/soal/{id_kelompok}/kolom/edit/{id}',[\App\Http\Controllers\SoalController::class,'editKolom'])->name('dashboard.soal.kolom.edit');
    Route::post('/soal/{id_kelompok}/kolom/add',[\App\Http\Controllers\SoalController::class,'addKolomPost']);
    Route::post('/soal/{id_kelompok}/kolom/edit/{id}',[\App\Http\Controllers\SoalController::class,'editKolomPost']);
    Route::post('/soal/{id_kelompok}/kolom/{id}/delete',[\App\Http\Controllers\SoalController::class,'deleteKolom'])->name('dashboard.soal.kolom.delete');
    Route::post('/soal/{id_kelompok}/import',[\App\Http\Controllers\SoalController::class,'importKolom'])->name('dashboard.soal.kolom.import');

    Route::get('/soal/{id_kelompok}/kolom/{id_kolom}/jawaban',[\App\Http\Controllers\SoalController::class,'jawabanSoal'])->name('dashboard.soal.kolom.jawaban');
    Route::get('/soal/{id_kelompok}/kolom/{id_kolom}/jawaban/add',[\App\Http\Controllers\SoalController::class,'addJawabanSoal'])->name('dashboard.soal.kolom.jawaban.add');
    Route::get('/soal/{id_kelompok}/kolom/{id_kolom}/jawaban/edit/{id}',[\App\Http\Controllers\SoalController::class,'editJawabanSoal'])->name('dashboard.soal.kolom.jawaban.edit');
    Route::post('/soal/{id_kelompok}/kolom/{id_kolom}/jawaban/add',[\App\Http\Controllers\SoalController::class,'addJawabanSoalPost']);
    Route::post('/soal/{id_kelompok}/kolom/{id_kolom}/jawaban/edit/{id}',[\App\Http\Controllers\SoalController::class,'editJawabanSoalPost']);
    Route::post('/soal/{id_kelompok}/kolom/{id_kolom}/jawaban/{id}/delete',[\App\Http\Controllers\SoalController::class,'deleteJawabanSoal'])->name('dashboard.soal.kolom.jawaban.delete');

    Route::get('setting',[\App\Http\Controllers\SettingController::class,'index'])->name('dashboard.setting');
    Route::post('setting',[\App\Http\Controllers\SettingController::class,'update']);
    Route::post('logout',[AuthController::class,'logout'])->name('dashboard.logout');
});

