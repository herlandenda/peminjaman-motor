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

// ==========================================
// Rute untuk Halaman Form Pinjam Motor
// ==========================================
Route::get('/pinjam-motor', function () {
    // 1. Tampilkan SEMUA motor (Buka kunci motor agar tetap bisa di-booking)
    $motors = \App\Models\Motor::all(); 

    // 2. Ambil jadwal motor yang sedang dipinjam (Untuk dikirim ke kalender sebagai "Tanggal Merah")
    $activeLoans = \App\Models\Loan::where('status', 'active')
                    ->get(['motor_id', 'loan_date', 'return_date_plan']);

    return view('peminjaman.create', compact('motors', 'activeLoans'));
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
}); 

// Proses simpan data peminjaman
Route::post('/pinjam-motor', [LoanController::class, 'store']);

// Rute untuk Pelanggan mengecek pesanan/invoice mereka
Route::get('/cek-pesanan', [App\Http\Controllers\LoanController::class, 'cekPesanan']);

// ==========================================
// Rute Auth & Login
// ==========================================
Route::get('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'authenticate']);

// ==========================================
// Rute Khusus Admin (Wajib Login)
// ==========================================
Route::middleware('auth')->group(function () {
    
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

    // Rute untuk Data Peminjaman
    Route::get('/admin/peminjaman', [App\Http\Controllers\AdminLoanController::class, 'index']);
    Route::put('/admin/peminjaman/{id}/selesai', [App\Http\Controllers\AdminLoanController::class, 'selesai']);
    Route::put('/admin/peminjaman/{id}/batal', [App\Http\Controllers\AdminLoanController::class, 'batalkan']);

    // Rute untuk logout dari Admin
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});