<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\UserLevelController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RestoreEditController;
use App\Http\Controllers\RestoreDeleteController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\DataController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [Controller::class, 'dashboard'])->name('dashboard');
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/aksi_login', [LoginController::class, 'aksi_login'])->name('aksi_login');
Route::get('/register', [LoginController::class, 'register'])->name('register');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/tambah_akun', [LoginController::class, 'tambah_akun'])->name('tambah_akun');
Route::get('/captcha', [LoginController::class, 'captcha'])->name('captcha');


// ROUTE SETTING
Route::get('settings', [SettingController::class, 'edit'])
    ->middleware('check.permission:setting')
    ->name('settings.edit');
Route::post('settings', [SettingController::class, 'update'])
    ->name('settings.update');

// ROUTE LOG ACTIVITY
Route::get('log', [LogController::class, 'index'])
    ->middleware('check.permission:setting')
    ->name('log');

// ROUTE PERMISSION
Route::get('/user-levels', [UserLevelController::class, 'index'])
    ->middleware('check.permission:setting')
    ->name('user.levels');
Route::get('/menu-permissions/{userLevel}', [UserLevelController::class, 'showMenuPermissions'])
    ->name('menu.permissions');
Route::post('/save-permissions', [UserLevelController::class, 'savePermissions'])
    ->name('save.permissions');

// ROUTE RESTORE EDIT
Route::get('/restore_e', [RestoreEditController::class, 'restore_e'])
    ->middleware('check.permission:setting')
    ->name('restore_e');
Route::post('/user/restore/{id_user}', [RestoreEditController::class, 'restoreEdit'])->name('user.restoreEdit');
Route::delete('/user_history/{id_user_history}', [RestoreEditController::class, 're_destroy'])->name('re.destroy');

// ROUTE RESTORE DELETE
Route::get('/restore_d', [RestoreDeleteController::class, 'restore_d'])
    ->middleware('check.permission:setting')
    ->name('restore_d');
Route::post('/user/restore-delete/{id}', [RestoreDeleteController::class, 'user_restore'])->name('user.restore');
Route::delete('/user/{id}', [RestoreDeleteController::class, 'rd_destroy'])->name('rd.destroy');

// ROUTE USER
Route::get('/user', [UserController::class, 'user'])
    ->middleware('check.permission:setting')
    ->name('user');
Route::post('/t_user', [UserController::class, 't_user'])->name('t_user');
Route::post('/user/reset-password/{id}', [UserController::class, 'resetPassword'])->name('user.resetPassword');
Route::post('/user/update', [UserController::class, 'updateDetail'])->name('update.user');
Route::delete('/user-destroy/{id_user}', [UserController::class, 'user_destroy'])->name('user.destroy');
Route::get('/user/detail/{id}', [UserController::class, 'detail'])->name('detail');

// ROUTE BARANG
Route::get('/barang', [BarangController::class, 'barang'])
->middleware('check.permission:item')
    ->name('barang');
Route::post('/t_barang', [BarangController::class, 't_barang'])->name('t_barang');
Route::post('/barang/update', action: [BarangController::class, 'updateDetail'])->name('update.barang');
Route::delete('/barang-destroy/{id_barang}', [BarangController::class, 'barang_destroy'])->name('barang.destroy');
Route::get('/barang/detail/{id}', [BarangController::class, 'e_barang'])
->middleware('check.permission:item')
    ->name('e_barang');


// ROUTE BARANG MASUK
Route::get('/BarangMasuk', [BarangMasukController::class, 'BarangMasuk'])
->middleware('check.permission:item')
    ->name('BarangMasuk');
Route::post('/t_BarangMasuk', [BarangMasukController::class, 't_BarangMasuk'])->name('t_BarangMasuk');
Route::post('/BarangMasuk/update', action: [BarangMasukController::class, 'updateDetail'])->name('update.BarangMasuk');
Route::delete('/BarangMasuk-destroy/{id_masuk}', [BarangMasukController::class, 'BarangMasuk_destroy'])->name('BarangMasuk.destroy');
Route::get('/BarangMasuk/detail/{id}', [BarangMasukController::class, 'e_BarangMasuk'])
->middleware('check.permission:item')
    ->name('e_BarangMasuk');



// ROUTE BARANG Keluar
Route::get('/BarangKeluar', [BarangKeluarController::class, 'BarangKeluar'])
->middleware('check.permission:item')
    ->name('BarangKeluar');
Route::post('/t_BarangKeluar', [BarangKeluarController::class, 't_BarangKeluar'])->name('t_BarangKeluar');
Route::post('/BarangKeluar/update', action: [BarangKeluarController::class, 'updateDetail'])->name('update.BarangKeluar');
Route::delete('/BarangKeluar-destroy/{id_keluar}', [BarangKeluarController::class, 'BarangKeluar_destroy'])->name('BarangKeluar.destroy');
Route::get('/BarangKeluar/detail/{id}', [BarangKeluarController::class, 'e_BarangKeluar'])
->middleware('check.permission:item')
    ->name('e_BarangKeluar');


// ROUTE KEUANGAN
Route::get('/data', [DataController::class, 'data'])
->middleware('check.permission:data')
    ->name('data');
Route::get('/laporan', [DataController::class, 'laporan'])
->middleware('check.permission:data')
    ->name('laporan');
Route::get('/laporan_index', [DataController::class, 'index'])->name('laporan.index');


Route::get('/barang/{kode_barang}', [BarangController::class, 'getBarangByKode'])->name('barang.getByKode');
