<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Loan;

class LoanController extends Controller
{

    public function store(Request $request)
    {
        // ==========================================
        // SATPAM ANTI DOUBLE BOOKING (LAPIS 2) - CEK BENTROK TANGGAL
        // ==========================================
        // Logika: Cari peminjaman aktif pada motor ini, di mana:
        // Tanggal Pinjam Baru < Tanggal Kembali Lama, DAN Tanggal Kembali Baru > Tanggal Pinjam Lama
        $jadwalBentrok = \App\Models\Loan::where('motor_id', $request->motor_id)
                                ->where('status', 'active')
                                ->where('loan_date', '<', $request->return_date_plan)
                                ->where('return_date_plan', '>', $request->loan_date)
                                ->first();

        // Jika ditemukan jadwal yang bentrok, tolak paksa dan lemparkan kembali ke form!
        if ($jadwalBentrok) {
            // Format tanggal bentrok untuk ditampilkan di pesan error
            $tglSelesaiLama = \Carbon\Carbon::parse($jadwalBentrok->return_date_plan)->format('d M Y, H:i');
            
            return back()
                ->withInput() // Kembalikan isian form agar pelanggan tidak capek ngetik ulang
                ->withErrors(['motor_id' => "Mohon maaf, keamanan sistem mendeteksi motor ini sudah dibooking orang lain hingga $tglSelesaiLama WITA. Silakan sesuaikan jadwal Anda."]);
        }
        // ==========================================


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
            // Upload foto kondisi awal motor (WAJIB)
            $startPhotoPath = $request->file('start_photo_motor')->store('uploads/inspeksi_awal', 'public');

            // Upload foto tambahan (OPSIONAL) - Jika tidak diisi, hasilnya akan 'null'
            $photoRight = $request->hasFile('photo_right') ? $request->file('photo_right')->store('uploads/inspeksi_awal', 'public') : null;
            $photoLeft = $request->hasFile('photo_left') ? $request->file('photo_left')->store('uploads/inspeksi_awal', 'public') : null;
            $photoBack = $request->hasFile('photo_back') ? $request->file('photo_back')->store('uploads/inspeksi_awal', 'public') : null;
            $photoFront = $request->hasFile('photo_front') ? $request->file('photo_front')->store('uploads/inspeksi_awal', 'public') : null;


            // Buat data transaksi peminjaman
            \App\Models\Loan::create([
                'customer_id' => $customerId,
                'motor_id' => $request->motor_id,
                'loan_date' => $request->loan_date,
                'return_date_plan' => $request->return_date_plan,
                'start_km' => $request->start_km,
                'start_fuel_level' => $request->start_fuel_level,
                'start_photo_motor' => $startPhotoPath,
                'photo_right' => $photoRight, // Simpan ke database
                'photo_left' => $photoLeft,   // Simpan ke database
                'photo_back' => $photoBack,   // Simpan ke database
                'photo_front' => $photoFront, // Simpan ke database
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