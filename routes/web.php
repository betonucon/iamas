<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GetareaController;
use App\Http\Controllers\TiketController;
use App\Http\Controllers\AuditplanController;
use App\Http\Controllers\DeskauditController;
use App\Http\Controllers\QcController;
use App\Http\Controllers\ComplianceController;
use App\Http\Controllers\SubstantiveController;
use App\Http\Controllers\LhaController;
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

Route::get('/cache-clear', function() {
    $exitCode = Artisan::call('cache:clear');
    return '<h1>Cache facade value cleared</h1>';
});
Route::get('/config-cache', function() {
    $exitCode = Artisan::call('config:cache');
    return '<h1>Cache facade value cleared</h1>';
});
Route::group(['middleware'    => 'auth'],function(){
    Route::get('Unitkerja',[UnitController::class, 'index']);
    Route::get('get_organisasi',[UnitController::class, 'get_organisasi']);
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
    Route::get('Tiket/view',[TiketController::class, 'view']);
    Route::get('Surattugas',[TiketController::class, 'surattugas']);
    Route::get('TiketGL',[TiketController::class, 'index_gl']);
    Route::get('TiketHD',[TiketController::class, 'index_hd']);
    Route::get('TiketAnggota',[TiketController::class, 'index_anggota']);
    Route::get('TiketKetua',[TiketController::class, 'index_ketua']);
    Route::get('TiketPengawas',[TiketController::class, 'index_pengawas']);
    Route::get('AccTiketPengawas',[TiketController::class, 'index_acc_pengawas']);
    Route::get('AccTiketHead',[TiketController::class, 'index_acc_head']);
    Route::get('AccTiketPengawas/acc',[TiketController::class, 'view_tiket_pengawas']);
    Route::get('TiketHead',[TiketController::class, 'index_head']);
    Route::get('TiketNewHead',[TiketController::class, 'index_tiket_head']);
    Route::get('TiketNew',[TiketController::class, 'index_tiket']);
    Route::get('TiketNew/Create',[TiketController::class, 'create_tiket']);
    Route::get('TiketNew/Update',[TiketController::class, 'update_tiket']);
    Route::get('TiketNew/view',[TiketController::class, 'view_tiket']);
    Route::get('TiketNew/tampil_pilihan_sumber',[TiketController::class, 'tampil_pilihan_sumber']);
    Route::get('TiketNew/tampil_tim',[TiketController::class, 'tampil_tim']);
    Route::get('TiketNew/cek_tim',[TiketController::class, 'cek_tim']);
    Route::get('TiketNew/hapus_judul',[TiketController::class, 'hapus_judul']);
    Route::get('TiketNew/hapus_tim',[TiketController::class, 'hapus_tim']);
    Route::get('TiketNew/tampil_judul',[TiketController::class, 'tampil_judul']);
    Route::get('TiketNew/proses_tiket',[TiketController::class, 'proses_tiket']);
    Route::get('Tiket/ubah',[TiketController::class, 'ubah']);
    Route::get('TiketNew/ubah',[TiketController::class, 'ubah_tiket']);
    Route::get('Tiket/cek_nomor_tiket',[TiketController::class, 'cek_nomor_tiket']);
    Route::get('Tiket/cek_sumber',[TiketController::class, 'cek_sumber']);
    Route::post('Tiket',[TiketController::class, 'simpan']);
    Route::post('Tiket/ubah_data',[TiketController::class, 'simpan_ubah']);
    Route::post('TiketNew/ubah_data',[TiketController::class, 'simpan_ubah_tiket']);
    Route::post('AccTiketPengawas',[TiketController::class, 'approve_pengawas']);
    Route::post('AccTiketHead',[TiketController::class, 'approve_head']);
    Route::post('TiketNewHead/approve',[TiketController::class, 'approve_tiket_pengawas']);
    Route::post('TiketNew/save_judul',[TiketController::class, 'save_judul']);
    Route::post('Tiket/setujui',[TiketController::class, 'setujui']);
    Route::post('Tiket/setujui_head',[TiketController::class, 'setujui_head']);
    Route::post('TiketNew/tim',[TiketController::class, 'simpan_tim']);
    Route::post('TiketNew/Proses',[TiketController::class, 'simpan_hasil']);
    Route::post('TiketNew/',[TiketController::class, 'simpan_tiket']);
    Route::post('/TiketNew/Edit',[TiketController::class, 'edit_tiket']);
    Route::post('/TiketNew/Approve',[TiketController::class, 'approve_tiket']);
    Route::post('/TiketNew/Editlampiran',[TiketController::class, 'edit_lampiran_tiket']);
    Route::post('Tiket/hapus',[TiketController::class, 'hapus']);
    Route::post('TiketNew/hapus',[TiketController::class, 'hapus_tiket']);
});


Route::group(['middleware'    => 'auth'],function(){
    Route::get('/home','HomeController@index')->name('home');
    Route::get('/DashboardStia','HomeController@index');
    Route::get('/DashboardKodifikasi','HomeController@index_kodifikasi');
    Route::get('/','HomeController@index')->name('home');
});

Route::group(['middleware'    => 'auth'],function(){
    Route::get('Auditplan',[AuditplanController::class, 'index']);
    Route::get('Auditplan/file',[AuditplanController::class, 'file']);
    Route::get('AccAuditplan',[AuditplanController::class, 'index_acc']);
    Route::get('Auditplan/pilih_surat_tugas',[AuditplanController::class, 'pilih_surat_tugas']);
    Route::get('Auditplan/Create',[AuditplanController::class, 'create']);
    Route::get('Auditplan/send_to_head',[AuditplanController::class, 'send_to_head']);
    Route::get('Auditplan/Acc',[AuditplanController::class, 'acc']);
    Route::get('Auditplan/Edit',[AuditplanController::class, 'edit']);
    Route::post('Auditplan',[AuditplanController::class, 'save']);
    Route::post('Auditplan/acc_head',[AuditplanController::class, 'acc_head']);
    Route::post('Auditplan/Update',[AuditplanController::class, 'update']);
    Route::post('Auditplan/Delete',[AuditplanController::class, 'delete']);
});

Route::group(['middleware'    => 'auth'],function(){
    Route::get('Lha',[LhaController::class, 'index']);
    Route::get('Lha/ubah',[LhaController::class, 'ubah']);
    Route::get('Lha/view',[LhaController::class, 'view']);
    Route::get('Lha/tampiltambahtemuan',[LhaController::class, 'tampiltambahtemuan']);
    Route::get('Lha/tampiltambahrekomendasi',[LhaController::class, 'tampiltambahrekomendasi']);
    Route::get('Lha/word',[LhaController::class, 'word']);
    Route::get('Lha/ubah_rekomendasi',[LhaController::class, 'ubah_rekomendasi']);
    Route::get('AccLha',[LhaController::class, 'index_acc']);
    Route::get('Lha/pilih_surat_tugas',[LhaController::class, 'pilih_surat_tugas']);
    Route::get('Lha/Create',[LhaController::class, 'create']);
    Route::get('Lha/Catatanhead',[LhaController::class, 'view_head']);
    Route::get('Lha/Createrekomendasi',[LhaController::class, 'createrekomendasi']);
    Route::get('Lha/send_to_head',[LhaController::class, 'send_to_head']);
    Route::get('Lha/Acc',[LhaController::class, 'acc']);
    Route::get('Lha/hapus',[LhaController::class, 'delete']);
    Route::get('Lha/hapus_rekomendasi',[LhaController::class, 'delete_rekomendasi']);
    Route::get('Lha/Edit',[LhaController::class, 'edit']);
    Route::post('Lha/simpan',[LhaController::class, 'save']);
    Route::post('Lha/send_data',[LhaController::class, 'send_data']);
    Route::post('Lha/approve_pengawas',[LhaController::class, 'send_to_pengawas']);
    Route::post('Lha/approve_head',[LhaController::class, 'send_to_head']);
    Route::post('Lha/simpan_rekomendasi',[LhaController::class, 'save_rekomendasi']);
    Route::post('Lha/ubah',[LhaController::class, 'update']);
    Route::post('Lha/ubah_rekomendasi',[LhaController::class, 'update_rekomendasi']);
});

Route::group(['middleware'    => 'auth'],function(){
    Route::get('Deskaudit',[DeskauditController::class, 'index']);
    Route::get('Deskaudit/ubah_pokok',[DeskauditController::class, 'ubah_pokok']);
    Route::get('Deskauditcatatan',[DeskauditController::class, 'index_catatan']);
    Route::get('Deskauditpengawas',[DeskauditController::class, 'index_pengawas']);
    Route::get('Deskaudithead',[DeskauditController::class, 'index_head']);
    Route::get('Deskaudit/Catatanhead',[DeskauditController::class, 'view_catatan_head']);
    Route::get('Deskauditcatatanpengawas',[DeskauditController::class, 'index_catatanpengawas']);
    Route::get('Deskauditanggota',[DeskauditController::class, 'index_anggota']);
    Route::get('AccDeskaudit',[DeskauditController::class, 'index_acc']);
    Route::get('Deskaudit/tampil_langkah_kerja',[DeskauditController::class, 'tampil_langkah_kerja']);
    Route::get('Deskaudit/hapus_pokok',[DeskauditController::class, 'hapus_pokok']);
    Route::get('Deskaudit/Create',[DeskauditController::class, 'create']);
    Route::get('Deskaudit/Catatan',[DeskauditController::class, 'catatan']);
    
    Route::get('Deskaudit/Isicatatan',[DeskauditController::class, 'isi_catatan']);
    Route::get('Deskaudit/Approvepengawas',[DeskauditController::class, 'approve_pengawas']);
    Route::get('Deskaudit/Approvecatatanpengawas',[DeskauditController::class, 'approve_catatanpengawas']);
    Route::get('Deskaudit/send_to_pengawas',[DeskauditController::class, 'send_to_pengawas']);
    Route::get('Deskaudit/send_catatan_to_pengawas',[DeskauditController::class, 'send_catatan_to_pengawas']);
    Route::get('Deskaudit/send_to_head',[DeskauditController::class, 'send_to_head']);
    Route::get('Deskaudit/Acc',[DeskauditController::class, 'acc']);
    Route::get('Deskaudit/Edit',[DeskauditController::class, 'edit']);
    Route::post('Deskaudit/proses_approve_pengawas',[DeskauditController::class, 'proses_approve_pengawas']);
    Route::post('Deskaudit/proses_approve_catatan_pengawas',[DeskauditController::class, 'proses_approve_catatan_pengawas']);
    Route::post('Deskaudit/langkah',[DeskauditController::class, 'save_langkah']);
    Route::post('Deskaudit/proses_catatan',[DeskauditController::class, 'proses_catatan']);
    Route::get('Deskaudit/hapus_langkah',[DeskauditController::class, 'hapus_langkah']);
    Route::post('Deskaudit',[DeskauditController::class, 'save']);
    Route::post('Deskaudit/acc_head',[DeskauditController::class, 'acc_head']);
    Route::post('Deskaudit/Update',[DeskauditController::class, 'update']);
    Route::post('Deskaudit/Delete',[DeskauditController::class, 'delete']);
});


Route::group(['middleware'    => 'auth'],function(){
    Route::get('Compliance',[ComplianceController::class, 'index']);
    Route::get('Compliance/ubah_pokok',[ComplianceController::class, 'ubah_pokok']);
    Route::get('Compliancecatatan',[ComplianceController::class, 'index_catatan']);
    Route::get('Compliancehead',[ComplianceController::class, 'index_head']);
    Route::get('Compliance/Catatanhead',[ComplianceController::class, 'view_catatan_head']);
    Route::get('Compliancepengawas',[ComplianceController::class, 'index_pengawas']);
    Route::get('Compliancecatatanpengawas',[ComplianceController::class, 'index_catatanpengawas']);
    Route::get('Complianceanggota',[ComplianceController::class, 'index_anggota']);
    Route::get('AccCompliance',[ComplianceController::class, 'index_acc']);
    Route::get('Compliance/tampil_langkah_kerja',[ComplianceController::class, 'tampil_langkah_kerja']);
    Route::get('Compliance/hapus_pokok',[ComplianceController::class, 'hapus_pokok']);
    Route::get('Compliance/Create',[ComplianceController::class, 'create']);
    Route::get('Compliance/Catatan',[ComplianceController::class, 'catatan']);
    Route::get('Compliance/Isicatatan',[ComplianceController::class, 'isi_catatan']);
    Route::get('Compliance/Approvepengawas',[ComplianceController::class, 'approve_pengawas']);
    Route::get('Compliance/Approvecatatanpengawas',[ComplianceController::class, 'approve_catatanpengawas']);
    Route::get('Compliance/send_to_pengawas',[ComplianceController::class, 'send_to_pengawas']);
    Route::get('Compliance/send_catatan_to_pengawas',[ComplianceController::class, 'send_catatan_to_pengawas']);
    Route::get('Compliance/send_to_head',[ComplianceController::class, 'send_to_head']);
    Route::get('Compliance/Acc',[ComplianceController::class, 'acc']);
    Route::get('Compliance/Edit',[ComplianceController::class, 'edit']);
    Route::post('Compliance/proses_approve_pengawas',[ComplianceController::class, 'proses_approve_pengawas']);
    Route::post('Compliance/proses_approve_catatan_pengawas',[ComplianceController::class, 'proses_approve_catatan_pengawas']);
    Route::post('Compliance/langkah',[ComplianceController::class, 'save_langkah']);
    Route::post('Compliance/proses_catatan',[ComplianceController::class, 'proses_catatan']);
    Route::get('Compliance/hapus_langkah',[ComplianceController::class, 'hapus_langkah']);
    Route::post('Compliance',[ComplianceController::class, 'save']);
    Route::post('Compliance/acc_head',[ComplianceController::class, 'acc_head']);
    Route::post('Compliance/Update',[ComplianceController::class, 'update']);
    Route::post('Compliance/Delete',[ComplianceController::class, 'delete']);
});

Route::group(['middleware'    => 'auth'],function(){
    Route::get('Qc',[QcController::class, 'index']);
    Route::get('Qcrevisi',[QcController::class, 'index_revisi']);
    Route::post('Qc/proses_revisi',[QcController::class, 'proses_revisi']);
    Route::get('Qc/proses_pengerjaan',[QcController::class, 'proses_pengerjaan']);
    Route::get('Qc/send_to_head',[QcController::class, 'send_to_head']);
    Route::get('Qcview',[QcController::class, 'view']);

});
Route::group(['middleware'    => 'auth'],function(){
    Route::get('Substantive',[SubstantiveController::class, 'index']);
    Route::get('Substantive/ubah_pokok',[SubstantiveController::class, 'ubah_pokok']);
    Route::get('Substantivecatatan',[SubstantiveController::class, 'index_catatan']);
    Route::get('Substantivehead',[SubstantiveController::class, 'index_head']);
    Route::get('Substantive/Catatanhead',[SubstantiveController::class, 'view_catatan_head']);
    Route::get('Substantivepengawas',[SubstantiveController::class, 'index_pengawas']);
    Route::get('Substantivecatatanpengawas',[SubstantiveController::class, 'index_catatanpengawas']);
    Route::get('Substantiveanggota',[SubstantiveController::class, 'index_anggota']);
    Route::get('AccSubstantive',[SubstantiveController::class, 'index_acc']);
    Route::get('Substantive/tampil_langkah_kerja',[SubstantiveController::class, 'tampil_langkah_kerja']);
    Route::get('Substantive/hapus_pokok',[SubstantiveController::class, 'hapus_pokok']);
    Route::get('Substantive/Create',[SubstantiveController::class, 'create']);
    Route::get('Substantive/Catatan',[SubstantiveController::class, 'catatan']);
    Route::get('Substantive/Isicatatan',[SubstantiveController::class, 'isi_catatan']);
    Route::get('Substantive/Approvepengawas',[SubstantiveController::class, 'approve_pengawas']);
    Route::get('Substantive/Approvecatatanpengawas',[SubstantiveController::class, 'approve_catatanpengawas']);
    Route::get('Substantive/send_to_pengawas',[SubstantiveController::class, 'send_to_pengawas']);
    Route::get('Substantive/send_catatan_to_pengawas',[SubstantiveController::class, 'send_catatan_to_pengawas']);
    Route::get('Substantive/send_to_head',[SubstantiveController::class, 'send_to_head']);
    Route::get('Substantive/Acc',[SubstantiveController::class, 'acc']);
    Route::get('Substantive/Edit',[SubstantiveController::class, 'edit']);
    Route::post('Substantive/proses_approve_pengawas',[SubstantiveController::class, 'proses_approve_pengawas']);
    Route::post('Substantive/proses_approve_catatan_pengawas',[SubstantiveController::class, 'proses_approve_catatan_pengawas']);
    Route::post('Substantive/langkah',[SubstantiveController::class, 'save_langkah']);
    Route::post('Substantive/proses_catatan',[SubstantiveController::class, 'proses_catatan']);
    Route::get('Substantive/hapus_langkah',[SubstantiveController::class, 'hapus_langkah']);
    Route::post('Substantive',[SubstantiveController::class, 'save']);
    Route::post('Substantive/acc_head',[SubstantiveController::class, 'acc_head']);
    Route::post('Substantive/Update',[SubstantiveController::class, 'update']);
    Route::post('Substantive/Delete',[SubstantiveController::class, 'delete']);
});


Auth::routes();
Auth::routes(['verify' => true]);
