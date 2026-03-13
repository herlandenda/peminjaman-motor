<?php

use Illuminate\Support\Facades\Route;

//Halaman utama
Route::get('/', function () {
    return view('peminjamanmotor');
});

//in untuk halaman peminjaman motor
Route::get('/pinjam-motor', function () {
    return view('peminjaman.create');
});

// Route sementara untuk menangkap data dari form agar tidak error
Route::post('/pinjam-motor', function (\Illuminate\Http\Request $request) {
    // Nanti logika penyimpanan ke database taruh di sini (atau di Controller)
    return "Berhasil! Data " . $request->name . " sudah ditangkap oleh sistem Laravel, tahap selanjutnya tinggal simpan ke database.";
});

Route::get('/motor/detail', function () {
    return view('motor.detail');
});