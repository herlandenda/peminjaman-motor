<?php

use App\Http\Controllers\LoanController;
use App\Models\Motor; 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminMotorController; 
use App\Http\Controllers\AdminLoanController; 
use App\Http\Controllers\AuthController;

// Halaman utama
Route::get('/', function () {
    $motors = Motor::all(); 
    return view('peminjamanmotor', compact('motors'));
});

// Halaman form peminjaman
Route::get('/pinjam-motor', function () {
    $motors = Motor::all(); 
    return view('peminjaman.create', compact('motors'));
});

// Halaman detail motor dinamis berdasarkan ID
Route::get('/motor/detail/{id}', function ($id) {
    $motor = \App\Models\Motor::findOrFail($id); 
    return view('motor.detail', compact('motor'));
});

// Rute untuk mengecek nomor HP secara live (AJAX)
Route::get('/cek-pelanggan/{phone}', function ($phone) {
    $customer = \App\Models\Customer::where('phone_number', $phone)->first();
    
    if ($customer) {
        return response()->json([
            'status' => 'found',
            'customer_id' => $customer->id,
            'name' => $customer->name,
            'address' => $customer->address
        ]);
    } else {
        return response()->json([
            'status' => 'not_found'
        ]);
    }
}); // <--- NAH, PENUTUPNYA HARUS DI SINI!

Route::post('/pinjam-motor', [LoanController::class, 'store']);

// Rute untuk Pelanggan mengecek pesanan/invoice mereka
Route::get('/cek-pesanan', [App\Http\Controllers\LoanController::class, 'cekPesanan']);

//Rute untuk halaman login

Route::get('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'authenticate']);

//Rute Khusu untuk halaman dashboard admin (hanya bisa diakses jika sudah login)    

Route::middleware('auth')->group(function () {
// Proses simpan data ke database

// Route khusus untuk halaman dahboard admin
Route::get('admin/dashboard', [App\Http\Controllers\AdminMotorController::class, 'dashboard']);

// Route untuk kelola data motor di dashboard admin
Route::get('admin/motor', [AdminMotorController::class, 'index']);

// Route untuk menampilkan form motor baru
Route::get('/admin/motor/create', [AdminMotorController::class, 'create']);

// Rute untuk memproses penyimpanan data motor baru
Route::post('/admin/motor', [AdminMotorController::class, 'store']);

// Rute untuk Halaman Data Pelanggan
Route::get('/admin/pelanggan', [App\Http\Controllers\AdminCustomerController::class, 'index']);


// Rute untuk memproses penghapusan data motor
Route::delete('/admin/motor/{id}', [AdminMotorController::class, 'destroy']);

// Rute untuk menampilkan form edit motor
Route::get('/admin/motor/{id}/edit', [App\Http\Controllers\AdminMotorController::class, 'edit']);

// Rute untuk Halaman Inspeksi
Route::get('/admin/motor/{id}/inspeksi', [App\Http\Controllers\AdminMotorController::class, 'inspeksi']);
Route::put('/admin/motor/{id}/inspeksi', [App\Http\Controllers\AdminMotorController::class, 'updateInspeksi']);

// Rute untuk memproses perubahan (update) data motor
Route::put('/admin/motor/{id}', [App\Http\Controllers\AdminMotorController::class, 'update']);


// =======================================================
// Rute untuk Data Peminjaman (Sekarang sudah bebas di luar!)
// =======================================================
Route::get('/admin/peminjaman', [App\Http\Controllers\AdminLoanController::class, 'index']);
Route::put('/admin/peminjaman/{id}/selesai', [App\Http\Controllers\AdminLoanController::class, 'selesai']);
Route::put('/admin/peminjaman/{id}/batal', [App\Http\Controllers\AdminLoanController::class, 'batalkan']);

// Rute Auth (Login & Logout)
// Rute untuk logout dari Admin
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

