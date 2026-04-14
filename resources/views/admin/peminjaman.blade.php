<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Peminjaman - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background-color: #f4f6f9; font-family: 'Inter', sans-serif; }
        .sidebar { min-height: 100vh; background-color: #212529; color: white; }
        .sidebar a { color: #adb5bd; text-decoration: none; padding: 12px 20px; display: block; border-radius: 8px; margin-bottom: 5px; }
        .sidebar a:hover, .sidebar a.active { background-color: #0d6efd; color: white; }
        .main-content { padding: 30px; }
        
        /* TAMBAHAN KECIL: Membatasi lebar kolom motor agar tidak terlalu memakan tempat */
        .col-motor { max-width: 200px; }
    </style>
</head>
<body>

<div class="container-fluid p-0">
    <div class="row g-0">
        <div class="col-md-2 sidebar p-3">
            <a class="navbar-brand d-flex align-items-center" href="/">
                <img src="{{ asset('images/motors/IMG_1306.png') }}" alt="logo peminjaman motor" height="60" class="me-2 d-inline-block">
            </a>
            <a href="/admin/dashboard"><i class="bi bi-speedometer2 me-2"></i> Ringkasan</a>
            <a href="/admin/motor"><i class="bi bi-motorcycle me-2"></i> Kelola Motor</a>
            <a href="/admin/peminjaman" class="active"><i class="bi bi-card-checklist me-2"></i> Data Peminjaman</a>
            <a href="/admin/pelanggan"><i class="bi bi-people me-2"></i> Data Pelanggan</a>
            <div class="mt-5 border-top pt-3">
                <a href="/" target="_blank"><i class="bi bi-box-arrow-up-right me-2"></i> Lihat Website</a>
            </div>
            <div class="mt-auto pt-3">
                <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin keluar dari Dasbor?');">
                    @csrf
                    <button type="submit" class="btn btn-danger w-100 rounded-pill text-start px-3">
                        <i class="bi bi-box-arrow-left me-2"></i> Keluar
                    </button>
                </form>
            </div>
        </div>

        <div class="col-md-10 main-content">
            <h2 class="fw-bold mb-4 text-dark">Manajemen Data Peminjaman</h2>

            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Data Peminjam</th>
                                    <th>Kendaraan (Motor)</th>
                                    <th>Tgl Pinjam</th>
                                    <th>Batas Kembali</th>                                    
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($loans as $loan)
                                <tr>
                                    {{-- Data Peminjam --}}
                                    <td>
                                        <div class="fw-bold text-primary">{{ $loan->customer->name ?? 'Terhapus' }}</div>
                                        <div class="small text-secondary"><i class="bi bi-whatsapp"></i> {{ $loan->customer->phone_number ?? '-' }}</div>
                                    </td>

                                    {{-- PERBAIKAN: Tambah class col-motor agar namanya tidak kepanjangan --}}
                                    <td class="fw-bold col-motor text-wrap">
                                        {{ $loan->motor->brand ?? '' }} {{ $loan->motor->model ?? '' }}
                                    </td>

                                    {{-- PERBAIKAN: Tambah class 'text-nowrap' agar tulisan Tgl & Jam tidak terpotong jadi 2 baris --}}
                                    <td class="text-nowrap">
                                        {{ \Carbon\Carbon::parse($loan->loan_date)->format('d M Y, H:i') }} WITA
                                    </td>

                                    {{-- PERBAIKAN: Tambah class 'text-nowrap' agar rapi --}}
                                    <td class="text-nowrap {{ \Carbon\Carbon::parse($loan->return_date_plan)->isPast() && $loan->status == 'active' ? 'text-danger fw-bold' : '' }}">
                                        {{ \Carbon\Carbon::parse($loan->return_date_plan)->format('d M Y, H:i') }} WITA
                                        @if(\Carbon\Carbon::parse($loan->return_date_plan)->isPast() && $loan->status == 'active')
                                            <i class="bi bi-exclamation-circle text-danger ms-1" title="Terlambat!"></i>
                                        @endif
                                    </td>

                                    {{-- Status --}}
                                    <td>
                                        @if($loan->status == 'active')
                                            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill"><i class="bi bi-hourglass-split me-1"></i> Sedang Dipinjam</span>
                                        @else
                                            <span class="badge bg-success text-white px-3 py-2 rounded-pill"><i class="bi bi-check-circle me-1"></i> Selesai</span>
                                        @endif
                                    </td>
                                    
                                    <td class="text-center">
                                        {{-- 
                                            PERBAIKAN UTAMA (Aksi): 
                                            Membungkus semua tombol dalam div "d-flex justify-content-center flex-wrap gap-2".
                                            - d-flex: Membuat elemen berjejer rapi.
                                            - justify-content-center: Posisi tombol di tengah kolom.
                                            - flex-wrap: Jika layar sangat sempit, tombol akan turun ke bawah secara otomatis tanpa merusak desain.
                                            - gap-2: Memberikan jarak otomatis antar tombol (tidak perlu pakai margin manual mb-1 me-1 lagi).
                                        --}}
                                        <div class="d-flex justify-content-center flex-wrap gap-2">
                                            
                                            @php
                                                $nomorWa = preg_replace('/^0/', '62', $loan->customer->phone_number ?? '');
                                                $pesan = "Halo kak *" . ($loan->customer->name ?? '') . "*,\n\n";
                                                $pesan .= "Berikut adalah bukti peminjaman motor Anda di *Ride For Unity Bali*:\n\n";
                                                $pesan .= "🏍️ *Motor:* " . ($loan->motor->brand ?? '') . " " . ($loan->motor->model ?? '') . "\n";
                                                $pesan .= "📅 *Tgl Pinjam:* " . \Carbon\Carbon::parse($loan->loan_date)->format('d M Y, H:i') . " WITA\n";
                                                $pesan .= "⏳ *Batas Kembali:* " . \Carbon\Carbon::parse($loan->return_date_plan)->format('d M Y, H:i') . " WITA\n";
                                                $pesan .= "🛠️ *Kondisi Awal:* " . ($loan->motor->inspection_notes ?? 'Kondisi Prima') . "\n\n";
                                                $pesan .= "Terima kasih dan hati-hati di jalan! 🌴";
                                            @endphp

                                            <a href="https://wa.me/{{ $nomorWa }}?text={{ urlencode($pesan) }}" target="_blank" class="btn btn-sm btn-success rounded-pill px-3">
                                                <i class="bi bi-whatsapp"></i> Nota WA
                                            </a>
                                            
                                            <button type="button" class="btn btn-sm btn-info text-white rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#fotoModal-{{ $loan->id }}">
                                                <i class="bi bi-image"></i> Cek Foto
                                            </button>

                                            @if($loan->status == 'active')
                                                {{-- PERBAIKAN: Menambahkan 'm-0 p-0' pada form agar form tidak merusak jejeran tombol flexbox --}}
                                                <form action="/admin/peminjaman/{{ $loan->id }}/selesai" method="POST" class="m-0 p-0" onsubmit="return confirm('Apakah motor sudah benar-benar dikembalikan dan kondisinya aman?');">
                                                    @csrf @method('PUT')
                                                    <button type="submit" class="btn btn-sm btn-success fw-bold rounded-pill px-3 shadow-sm">
                                                        <i class="bi bi-check2-all me-1"></i> Selesaikan
                                                    </button>
                                                </form>
                                            @else
                                                <form action="/admin/peminjaman/{{ $loan->id }}/batal" method="POST" class="m-0 p-0" onsubmit="return confirm('Yakin ingin membatalkan? Status akan kembali menjadi Sedang Dipinjam.');">
                                                    @csrf @method('PUT')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger fw-bold rounded-pill px-3 shadow-sm" title="Kembalikan ke status dipinjam">
                                                        <i class="bi bi-arrow-counterclockwise me-1"></i> Batalkan
                                                    </button>
                                                </form>
                                            @endif

                                        </div> </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-5">
                                        <i class="bi bi-inbox fs-1 text-light d-block mb-3"></i>
                                        Belum ada data transaksi peminjaman.
                                    </td>
                                </tr>
                                @endforelse

                                {{-- Kerangka Foto pop up --}}
                                @foreach ($loans as $loan)
                                <div class="modal fade" id="fotoModal-{{ $loan->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header bg-dark text-white">
                                                <h5 class="modal-title"><i class="bi bi-camera"></i> Bukti Kondisi Motor: {{ $loan->motor->brand ?? '' }} {{ $loan->motor->model ?? '' }}</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body bg-light">
                                                <div class="row g-3">
                                                    <div class="col-12 text-center mb-3">
                                                        <h6 class="fw-bold">Foto Keseluruhan (Wajib)</h6>
                                                        @if($loan->start_photo_motor)
                                                            <a href="{{ asset('storage/' . $loan->start_photo_motor) }}" target="_blank" title="Klik untuk perbesar">
                                                                <img src="{{ asset('storage/' . $loan->start_photo_motor) }}" class="img-fluid rounded shadow-sm border" style="max-height: 300px;" alt="Foto Utama">
                                                            </a>
                                                        @else
                                                            <span class="text-muted fst-italic">Tidak ada foto</span>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-6 text-center">
                                                        <h6 class="small fw-bold text-secondary">Sisi Depan</h6>
                                                        @if($loan->photo_front)
                                                            <a href="{{ asset('storage/' . $loan->photo_front) }}" target="_blank" title="Klik untuk perbesar">
                                                                <img src="{{ asset('storage/' . $loan->photo_front) }}" class="img-fluid rounded shadow-sm border" style="max-height: 200px;" alt="Depan">
                                                            </a>
                                                        @else
                                                            <div class="border rounded bg-white p-4 text-muted small">Tidak diunggah</div>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-6 text-center">
                                                        <h6 class="small fw-bold text-secondary">Sisi Belakang</h6>
                                                        @if($loan->photo_back)
                                                            <a href="{{ asset('storage/' . $loan->photo_back) }}" target="_blank" title="Klik untuk perbesar">
                                                                <img src="{{ asset('storage/' . $loan->photo_back) }}" class="img-fluid rounded shadow-sm border" style="max-height: 200px;" alt="Belakang">
                                                            </a>
                                                        @else
                                                            <div class="border rounded bg-white p-4 text-muted small">Tidak diunggah</div>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-6 text-center">
                                                        <h6 class="small fw-bold text-secondary">Sisi Kiri</h6>
                                                        @if($loan->photo_left)
                                                            <a href="{{ asset('storage/' . $loan->photo_left) }}" target="_blank" title="Klik untuk perbesar">
                                                                <img src="{{ asset('storage/' . $loan->photo_left) }}" class="img-fluid rounded shadow-sm border" style="max-height: 200px;" alt="Kiri">
                                                            </a>
                                                        @else
                                                            <div class="border rounded bg-white p-4 text-muted small">Tidak diunggah</div>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-6 text-center">
                                                        <h6 class="small fw-bold text-secondary">Sisi Kanan</h6>
                                                        @if($loan->photo_right)
                                                            <a href="{{ asset('storage/' . $loan->photo_right) }}" target="_blank" title="Klik untuk perbesar">
                                                                <img src="{{ asset('storage/' . $loan->photo_right) }}" class="img-fluid rounded shadow-sm border" style="max-height: 200px;" alt="Kanan">
                                                            </a>
                                                        @else
                                                            <div class="border rounded bg-white p-4 text-muted small">Tidak diunggah</div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>