<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan;

class AdminLoanController extends Controller
{
    // 1. Menampilkan Halaman Data Peminjaman
    public function index()
    {
        // Ambil semua data peminjaman beserta relasi pelanggan & motornya
        $loans = Loan::with(['customer', 'motor'])->latest()->get();
        return view('admin.peminjaman', compact('loans'));
    }

    // 2. Fungsi untuk Menyelesaikan Peminjaman (Motor Dikembalikan)
    public function selesai($id)
    {
        $loan = Loan::findOrFail($id);
        
        // Mengubah status dengan cara yang lebih kebal error
        $loan->status = 'selesai';
        $loan->save();

        return redirect('/admin/peminjaman')->with('success', 'Motor berhasil dikembalikan dan status pesanan selesai!');
    }

    // Fungsi untuk Membatalkan Pengembalian (Kembali ke status Active)
    public function batalkan($id)
    {
        $loan = Loan::findOrFail($id);
        
        // Kembalikan statusnya menjadi 'active'
        $loan->status = 'active'; 
        $loan->save();

        return redirect('/admin/peminjaman')->with('success', 'Aksi dibatalkan! Status motor kembali menjadi Sedang Dipinjam.');
    }
}