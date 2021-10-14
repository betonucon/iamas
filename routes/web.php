<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GetareaController;
use App\Http\Controllers\TiketController;
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
Route::group(['middleware'    => 'auth'],function(){
    Route::get('Unitkerja',[UnitController::class, 'index']);
    Route::get('Unitkerja/ubah',[UnitController::class, 'ubah']);
    Route::post('Unitkerja',[UnitController::class, 'simpan']);
    Route::post('Unitkerja/ubah_data',[UnitController::class, 'simpan_ubah']);
    Route::post('Unitkerja/hapus',[UnitController::class, 'hapus']);
});

Route::group(['middleware'    => 'auth'],function(){
    Route::get('Pengguna',[PenggunaController::class, 'index']);
    Route::get('Pengguna/ubah',[PenggunaController::class, 'ubah']);
    Route::post('Pengguna',[PenggunaController::class, 'simpan']);
    Route::post('Pengguna/ubah_data',[PenggunaController::class, 'simpan_ubah']);
    Route::post('Pengguna/hapus',[PenggunaController::class, 'hapus']);
});

Route::group(['middleware'    => 'auth'],function(){
    Route::get('Tiket',[TiketController::class, 'index']);
    Route::get('Surattugas',[TiketController::class, 'surattugas']);
    Route::get('TiketGL',[TiketController::class, 'index_gl']);
    Route::get('TiketAnggota',[TiketController::class, 'index_anggota']);
    Route::get('TiketPengawas',[TiketController::class, 'index_pengawas']);
    Route::get('TiketHead',[TiketController::class, 'index_head']);
    Route::get('TiketNewHead',[TiketController::class, 'index_tiket_head']);
    Route::get('TiketNew',[TiketController::class, 'index_tiket']);
    Route::get('TiketNew/Create',[TiketController::class, 'create_tiket']);
    Route::get('TiketNew/Update',[TiketController::class, 'update_tiket']);
    Route::get('TiketNew/tampil_pilihan_sumber',[TiketController::class, 'tampil_pilihan_sumber']);
    Route::get('TiketNew/tampil_tim',[TiketController::class, 'tampil_tim']);
    Route::get('TiketNew/cek_tim',[TiketController::class, 'cek_tim']);
    Route::get('TiketNew/hapus_tim',[TiketController::class, 'hapus_tim']);
    Route::get('TiketNew/proses_tiket',[TiketController::class, 'proses_tiket']);
    Route::get('Tiket/ubah',[TiketController::class, 'ubah']);
    Route::get('TiketNew/ubah',[TiketController::class, 'ubah_tiket']);
    Route::get('Tiket/cek_nomor_tiket',[TiketController::class, 'cek_nomor_tiket']);
    Route::get('Tiket/cek_sumber',[TiketController::class, 'cek_sumber']);
    Route::post('Tiket',[TiketController::class, 'simpan']);
    Route::post('Tiket/ubah_data',[TiketController::class, 'simpan_ubah']);
    Route::post('TiketNew/ubah_data',[TiketController::class, 'simpan_ubah_tiket']);
    Route::post('TiketNewHead/approve',[TiketController::class, 'approve_tiket_pengawas']);
    Route::post('Tiket/setujui',[TiketController::class, 'setujui']);
    Route::post('TiketNew/tim',[TiketController::class, 'simpan_tim']);
    Route::post('TiketNew/Proses',[TiketController::class, 'simpan_hasil']);
    Route::post('TiketNew/',[TiketController::class, 'simpan_tiket']);
    Route::post('/TiketNew/Edit',[TiketController::class, 'edit_tiket']);
    Route::post('/TiketNew/Editlampiran',[TiketController::class, 'edit_lampiran_tiket']);
    Route::post('Tiket/hapus',[TiketController::class, 'hapus']);
    Route::post('TiketNew/hapus',[TiketController::class, 'hapus_tiket']);
});


Route::group(['middleware'    => 'auth'],function(){
    Route::get('Home',[HomeController::class, 'index']);
    Route::get('/',[HomeController::class, 'index']);
});




Auth::routes();
Auth::routes(['verify' => true]);
// Route::get('/home', 'HomeController@index')->name('home');
