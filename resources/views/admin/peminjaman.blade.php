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
                                    <td>
                                        <div class="fw-bold text-primary">{{ $loan->customer->name ?? 'Terhapus' }}</div>
                                        <div class="small text-secondary"><i class="bi bi-whatsapp"></i> {{ $loan->customer->phone_number ?? '-' }}</div>
                                    </td>
                                    <td>
                                        <span class="fw-semibold">{{ $loan->motor->brand ?? '' }} {{ $loan->motor->model ?? 'Terhapus' }}</span><br>
                                        <span class="badge bg-secondary opacity-75">{{ $loan->motor->plate_number ?? '-' }}</span>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($loan->loan_date)->format('d M Y') }}</td>
                                    <td class="{{ \Carbon\Carbon::parse($loan->return_date_plan)->isPast() && $loan->status == 'active' ? 'text-danger fw-bold' : '' }}">
                                        {{ \Carbon\Carbon::parse($loan->return_date_plan)->format('d M Y') }}
                                        @if(\Carbon\Carbon::parse($loan->return_date_plan)->isPast() && $loan->status == 'active')
                                            <i class="bi bi-exclamation-circle text-danger ms-1" title="Terlambat!"></i>
                                        @endif
                                    </td>
                                    <td>
                                        @if($loan->status == 'active')
                                            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill"><i class="bi bi-hourglass-split me-1"></i> Sedang Dipinjam</span>
                                        @else
                                            <span class="badge bg-success text-white px-3 py-2 rounded-pill"><i class="bi bi-check-circle me-1"></i> Selesai</span>
                                        @endif
                                    </td>
                                   <td class="text-center">
    @if($loan->status == 'active')
        <form action="/admin/peminjaman/{{ $loan->id }}/selesai" method="POST" class="d-inline" onsubmit="return confirm('Apakah motor sudah benar-benar dikembalikan dan kondisinya aman?');">
            @csrf
            @method('PUT')
            <button type="submit" class="btn btn-sm btn-success fw-bold rounded-pill px-3 shadow-sm">
                <i class="bi bi-check2-all me-1"></i> Selesaikan
            </button>
        </form>
    @else
        <form action="/admin/peminjaman/{{ $loan->id }}/batal" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin membatalkan? Status akan kembali menjadi Sedang Dipinjam.');">
            @csrf
            @method('PUT')
            <button type="submit" class="btn btn-sm btn-outline-danger fw-bold rounded-pill px-3 shadow-sm" title="Kembalikan ke status dipinjam">
                <i class="bi bi-arrow-counterclockwise me-1"></i> Batalkan
            </button>
        </form>
    @endif
</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-5">
                                        <i class="bi bi-inbox fs-1 text-light d-block mb-3"></i>
                                        Belum ada data transaksi peminjaman.
                                    </td>
                                </tr>
                                @endforelse
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