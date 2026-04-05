<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Loan;

class LoanController extends Controller
{

 public function store(Request $request)
    {
        // 1. CEK PELANGGAN: Apakah ini pelanggan lama atau baru?
        if ($request->filled('existing_customer_id')) {
            // Jika Pelanggan LAMA: Langsung pakai ID yang dikirim dari form tersembunyi
            $customerId = $request->existing_customer_id;
        } else {
            // Jika Pelanggan BARU: Proses upload KTP & SIM, lalu buat data baru di database
            $ktpPath = $request->file('ktp_image')->store('uploads/ktp', 'public');
            $simPath = $request->file('sim_image')->store('uploads/sim', 'public');

            $customer = \App\Models\Customer::create([
                'name' => $request->name,
                'phone_number' => $request->phone_number,
                'address' => $request->address,
                'ktp_image' => $ktpPath,
                'sim_image' => $simPath,
            ]);
            $customerId = $customer->id;
        }

        // 2. SIMPAN DATA KENDARAAN & INSPEKSI
        // Upload foto kondisi awal motor
        $startPhotoPath = $request->file('start_photo_motor')->store('uploads/inspeksi_awal', 'public');

        // Buat data transaksi peminjaman
        \App\Models\Loan::create([
            'customer_id' => $customerId,
            'motor_id' => $request->motor_id,
            'loan_date' => $request->loan_date,
            'return_date_plan' => $request->return_date_plan,
            'start_km' => $request->start_km,
            'start_fuel_level' => $request->start_fuel_level,
            'start_photo_motor' => $startPhotoPath,
            'status' => 'active',
        ]);

        // Arahkan kembali ke beranda dengan pesan sukses
        return redirect('/')->with('success', 'Peminjaman berhasil diproses!');
    }

    public function cekPesanan(Request $request)
    {
        $loan = null;
        $searched = false;

        // Jika pelanggan mengetikkan nomor HP dan menekan tombol cari
        if ($request->has('phone_number')) {
            $searched = true;
            $phone = $request->phone_number;
            
            // Cari data pelanggan berdasarkan nomor WhatsApp
            $customer = \App\Models\Customer::where('phone_number', $phone)->first();
            
            if ($customer) {
                // Cari peminjaman mereka yang statusnya masih 'active' (Sedang Dipinjam)
                $loan = \App\Models\Loan::with('motor')
                            ->where('customer_id', $customer->id)
                            ->where('status', 'active')
                            ->latest()
                            ->first();
            }
        }

        return view('peminjaman.cek', compact('loan', 'searched'));
    }
}