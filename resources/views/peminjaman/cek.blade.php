<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Pesanan | Peminjaman Motor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f8fafc; }
        .invoice-card { border: none; border-radius: 1.5rem; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.08); }
        .invoice-header { background: linear-gradient(135deg, #0d6efd, #0b5ed7); color: white; padding: 2rem; border-bottom: 4px dashed rgba(255,255,255,0.3); }
        .invoice-body { background-color: #ffffff; padding: 2rem; }
    </style>
</head>
<body>

    <nav class="navbar navbar-light bg-white shadow-sm py-3 mb-5">
        <div class="container">
            <a class="navbar-brand fw-bold fs-4" href="/"><i class="bi bi-bicycle me-2 text-primary"></i>Peminjaman Motor<span class="text-primary">.</span></a>
            <a href="/" class="btn btn-outline-primary btn-sm rounded-pill px-3"><i class="bi bi-house me-1"></i> Beranda</a>
        </div>
    </nav>

    <div class="container" style="max-width: 700px;">
        
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4 text-center">
                <h4 class="fw-bold mb-3">Cek Status Peminjaman</h4>
                <p class="text-secondary mb-4">Masukkan nomor WhatsApp yang Anda gunakan saat menyewa untuk melihat detail pesanan Anda.</p>
                <form action="/cek-pesanan" method="GET" class="d-flex gap-2 justify-content-center">
                    <input type="text" name="phone_number" class="form-control form-control-lg text-center w-75 rounded-pill border-primary border-opacity-25" placeholder="Contoh: 08123456789" value="{{ request('phone_number') }}" required>
                    <button type="submit" class="btn btn-primary rounded-pill px-4"><i class="bi bi-search"></i> Cari</button>
                </form>
            </div>
        </div>

        @if($searched)
            @if($loan)
                <div class="card invoice-card mb-5">
                    <div class="invoice-header text-center">
                        <span class="badge bg-white text-primary mb-2 rounded-pill px-3 py-2 fw-bold">SEDANG DIPINJAM</span>
                        <h3 class="fw-bold mb-0">Bukti Peminjaman Digital</h3>
                        <p class="mb-0 opacity-75 small">Tunjukkan halaman ini sebagai bukti kepada petugas</p>
                    </div>
                    <div class="invoice-body">
                        <div class="row mb-4">
                            <div class="col-6">
                                <p class="text-secondary small mb-1">Nama Peminjam</p>
                                <h6 class="fw-bold">{{ $loan->customer->name }}</h6>
                            </div>
                            <div class="col-6 text-end">
                                <p class="text-secondary small mb-1">Tanggal Pinjam</p>
                                <h6 class="fw-bold">{{ \Carbon\Carbon::parse($loan->loan_date)->format('d M Y') }}</h6>
                            </div>
                        </div>

                        <div class="p-3 bg-light rounded-3 mb-4 border">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary text-white p-3 rounded-circle me-3">
                                    <i class="bi bi-motorcycle fs-4"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-1">{{ $loan->motor->brand }} {{ $loan->motor->model }}</h5>
                                    <p class="text-secondary mb-0 small">Plat: <span class="fw-bold text-dark">{{ $loan->motor->plate_number }}</span> | Warna: {{ $loan->motor->color }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-6">
                                <p class="text-secondary small mb-1">Batas Pengembalian</p>
                                <h6 class="fw-bold text-danger">{{ \Carbon\Carbon::parse($loan->return_date_plan)->format('d M Y') }}</h6>
                            </div>
                            <div class="col-6 text-end">
                                <p class="text-secondary small mb-1">Status Kendaraan</p>
                                <h6 class="fw-bold text-success"><i class="bi bi-shield-check me-1"></i>Aman</h6>
                            </div>
                        </div>

                        <div class="text-center pt-4 border-top">
                            <p class="text-secondary small mb-3">Waktunya mengembalikan motor? Hubungi Admin untuk konfirmasi pengembalian.</p>
                            @php
                                // Ganti nomor di bawah ini dengan nomor WA Admin (klien Anda)
                                $noAdmin = "6281234567890"; 
                                $pesan = "Halo Admin, saya " . $loan->customer->name . " ingin mengembalikan motor " . $loan->motor->brand . " dengan nomor plat " . $loan->motor->plate_number . ". Apakah saya bisa ke lokasi sekarang?";
                            @endphp
                            <a href="https://wa.me/{{ $noAdmin }}?text={{ urlencode($pesan) }}" target="_blank" class="btn btn-success btn-lg rounded-pill w-100 fw-bold shadow-sm">
                                <i class="bi bi-whatsapp me-2"></i> Konfirmasi Pengembalian
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <div class="alert alert-warning text-center rounded-4 shadow-sm border-warning border-opacity-25 p-4">
                    <i class="bi bi-emoji-frown fs-1 text-warning mb-2 d-block"></i>
                    <h6 class="fw-bold">Pesanan Tidak Ditemukan!</h6>
                    <p class="mb-0 small">Kami tidak menemukan peminjaman aktif untuk nomor WhatsApp tersebut. Pastikan nomor sudah benar atau peminjaman Anda mungkin sudah selesai.</p>
                </div>
            @endif
        @endif

    </div>

</body>
</html>