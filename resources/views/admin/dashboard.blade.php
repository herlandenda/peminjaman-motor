<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ringkasan Dasbor - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background-color: #f4f6f9; font-family: 'Inter', sans-serif; }
        .sidebar { min-height: 100vh; background-color: #212529; color: white; }
        .sidebar a { color: #adb5bd; text-decoration: none; padding: 12px 20px; display: block; border-radius: 8px; margin-bottom: 5px; transition: 0.2s; }
        .sidebar a:hover, .sidebar a.active { background-color: #0d6efd; color: white; }
        .main-content { padding: 30px; }
        
        /* Gaya Khusus Kartu Dasbor */
        .stat-card { border: none; border-radius: 1rem; color: white; overflow: hidden; position: relative; }
        .stat-card .icon-bg { position: absolute; right: -10px; bottom: -20px; font-size: 6rem; opacity: 0.2; transform: rotate(-15deg); }
    </style>
</head>
<body>

<div class="container-fluid p-0">
    <div class="row g-0">
        <div class="col-md-2 sidebar p-3">
            <a class="navbar-brand d-flex align-items-center" href="/">
                <img src="{{ asset('images/motors/IMG_1306.png') }}" alt="logo peminjaman motor" height="60" class="me-2 d-inline-block">
            </a>
            <a href="/admin/dashboard" class="active"><i class="bi bi-speedometer2 me-2"></i> Ringkasan</a>
            <a href="/admin/motor"><i class="bi bi-motorcycle me-2"></i> Kelola Motor</a>
            <a href="/admin/peminjaman"><i class="bi bi-card-checklist me-2"></i> Data Peminjaman</a>
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
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold text-dark">Ringkasan Dasbor</h2>
                <div class="bg-white px-3 py-2 rounded-pill shadow-sm border">
                    <i class="bi bi-person-circle text-primary me-2"></i><span class="fw-medium">{{ Auth::user()->name }}</span>
                </div>
            </div>

            <div class="row g-4 mb-5">
                <div class="col-md-3">
                    <div class="card stat-card bg-primary shadow">
                        <div class="card-body p-4">
                            <h6 class="text-white-50 fw-bold text-uppercase mb-1">Total Motor</h6>
                            <h2 class="display-5 fw-bold mb-0">{{ $totalMotor }}</h2>
                            <i class="bi bi-motorcycle icon-bg"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stat-card bg-warning shadow">
                        <div class="card-body p-4">
                            <h6 class="text-dark-50 fw-bold text-uppercase mb-1" style="color: rgba(0,0,0,0.5)">Sedang Dipinjam</h6>
                            <h2 class="display-5 fw-bold mb-0 text-dark">{{ $motorDipinjam }}</h2>
                            <i class="bi bi-key icon-bg text-dark"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stat-card bg-success shadow">
                        <div class="card-body p-4">
                            <h6 class="text-white-50 fw-bold text-uppercase mb-1">Motor Tersedia</h6>
                            <h2 class="display-5 fw-bold mb-0">{{ $motorTersedia }}</h2>
                            <i class="bi bi-check2-circle icon-bg"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stat-card bg-info shadow">
                        <div class="card-body p-4">
                            <h6 class="text-white-50 fw-bold text-uppercase mb-1">Total Pelanggan</h6>
                            <h2 class="display-5 fw-bold mb-0 text-white">{{ $totalPelanggan }}</h2>
                            <i class="bi bi-people icon-bg"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0"><i class="bi bi-clock-history text-primary me-2"></i>5 Peminjaman Terbaru</h5>
                    <a href="/admin/peminjaman" class="btn btn-sm btn-outline-primary rounded-pill">Lihat Semua</a>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Pelanggan</th>
                                    <th>Motor</th>
                                    <th>Tgl Pinjam</th>
                                    <th>Rencana Kembali</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recentLoans as $loan)
                                <tr>
                                    <td class="fw-bold">{{ $loan->customer->name ?? 'Data Terhapus' }}</td>
                                    <td>
                                        <span class="badge bg-dark">{{ $loan->motor->brand ?? '' }} {{ $loan->motor->model ?? 'Terhapus' }}</span>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($loan->loan_date)->format('d M Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($loan->return_date_plan)->format('d M Y') }}</td>
                                    <td><span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split me-1"></i>Aktif</span></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">Belum ada transaksi peminjaman.</td>
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

</body>
</html>