<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Motor;
use App\Models\Loan;
use App\Models\Customer;
use Illuminate\Support\Facades\Storage;


class AdminMotorController extends Controller
{

    public function dashboard()
    {
         // Menghitung statistik untuk dashboard admin
        $totalMotor = Motor::count();
        $motorDipinjam = Loan::where('status', 'active')->count();
        $motorTersedia = $totalMotor - $motorDipinjam;
        $totalPelanggan = Customer::count();    

        // Kirim data statistik ke view dashboard admin yang paliing baru

        $recentLoans = Loan::with(['customer', 'motor'])->latest()->take(5)->get();
        return view('admin.dashboard', compact(
            'totalMotor', 
            'motorDipinjam', 
            'motorTersedia', 
            'totalPelanggan',
            'recentLoans'
             ));
    }    

    // 1. Menampilkan halaman tabel daftar motor
    public function index()
    {
        $motors = Motor::latest()->get();
        return view('admin.motor', compact('motors'));
    }

    // 2. Menampilkan halaman form tambah motor
    public function create()
    {
        return view('admin.motor_create');
    }

    // 3. Menyimpan data motor baru ke database
    public function store(Request $request)
    {
        // Proses upload foto utama motor jika ada
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('uploads/motors_cover', 'public');
        }

        // Simpan data ke database
        Motor::create([
            'brand' => $request->brand,
            'model' => $request->model,
            'plate_number' => $request->plate_number,
            'color' => $request->color,
            'price' => $request->price,
            'image' => $imagePath,
            'status' => 'available', // Status bawaan otomatis Tersedia
            'inspection_alerts' => '[]', // Kosongkan inspeksi awal
        ]);

        // Kembali ke halaman kelola motor dengan pesan sukses
        return redirect('/admin/motor')->with('success', 'Motor baru berhasil ditambahkan!');

    }

    // Fungsi untuk menghapus data motor
    public function destroy($id)
    {
        $motor = Motor::findOrFail($id);

        // Fitur pintar: Hapus file foto dari folder laptop agar penyimpanan tidak penuh
        if ($motor->image && Storage::disk('public')->exists($motor->image)) {
            Storage::disk('public')->delete($motor->image);
        }

        // Hapus data dari database
        $motor->delete();

        // Kembali ke halaman tabel
        return redirect('/admin/motor')->with('success', 'Data motor berhasil dihapus!');
    }

    // 4. Menampilkan halaman form edit motor
    public function edit($id)
    {
        $motor = Motor::findOrFail($id);
        return view('admin.motor_edit', compact('motor'));
    }

    // 5. Menyimpan perubahan (Update) data motor
    public function update(Request $request, $id)
    {
        $motor = Motor::findOrFail($id);

        // Cek apakah admin mengupload foto baru
        if ($request->hasFile('image')) {
            // Hapus foto lama dari laptop agar tidak menumpuk
            if ($motor->image && Storage::disk('public')->exists($motor->image)) {
                Storage::disk('public')->delete($motor->image);
            }
            // Simpan foto baru
            $imagePath = $request->file('image')->store('uploads/motors_cover', 'public');
            $motor->image = $imagePath; 
        }

        // Update data lainnya
        $motor->update([
            'brand' => $request->brand,
            'model' => $request->model,
            'plate_number' => $request->plate_number,
            'color' => $request->color,
            'price' => $request->price,
            // image tidak perlu di-update di sini karena sudah diatur di dalam blok if di atas
        ]);

        return redirect('/admin/motor')->with('success', 'Data motor berhasil diperbarui!');
    }

    // Menampilkan halaman inspeksi motor
    public function inspeksi($id)
    {
        $motor = Motor::findOrFail($id);
        return view('admin.motor_inspeksi', compact('motor'));
    }

    // Menyimpan catatan inspeksi
    // Menyimpan catatan inspeksi
    public function updateInspeksi(Request $request, $id)
    {
        $motor = Motor::findOrFail($id);
        
        // Cek apakah ada checkbox yang dicentang. Jika ada, gabungkan jadi teks dipisah koma.
        $tags = $request->inspection_notes ? implode(',', $request->inspection_notes) : null;

        $motor->update([
            'inspection_notes' => $tags,                    // Menyimpan data centangan
            'additional_notes' => $request->additional_notes  // Menyimpan catatan panjang
        ]);

        return redirect('/admin/motor')->with('success', 'Catatan inspeksi motor berhasil diperbarui!');
    }


   
}