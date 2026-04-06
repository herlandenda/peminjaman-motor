<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Motor - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background-color: #f4f6f9; }
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
            <a href="/admin/dashboard" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}"><i class="bi bi-speedometer2 me-2"></i> Ringkasan</a>
            <a href="/admin/motor" class="{{ request()->is('admin/motor*') ? 'active' : '' }}"><i class="bi bi-motorcycle me-2"></i> Kelola Motor</a>
            <a href="/admin/peminjaman" class="{{ request()->is('admin/peminjaman') ? 'active' : '' }}"><i class="bi bi-card-checklist me-2"></i> Data Peminjaman</a>
            <a href="/admin/pelanggan" class="{{ request()->is('admin/pelanggan') ? 'active' : '' }}"><i class="bi bi-people me-2"></i> Data Pelanggan</a>
            
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
                <h2 class="fw-bold">Manajemen Data Motor</h2>
                <a href="/admin/motor/create" class="btn btn-primary"><i class="bi bi-plus-lg me-2"></i>Tambah Motor Baru</a>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Merek & Model</th>
                                    <th>Plat Nomor</th>
                                    <th>Warna</th>
                                    <th>Harga Sewa</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($motors as $index => $motor)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td class="fw-bold">{{ $motor->brand }} {{ $motor->model }}</td>
                                    <td><span class="badge bg-secondary">{{ $motor->plate_number }}</span></td>
                                    <td>{{ $motor->color }}</td>
                                    <td>Rp {{ number_format($motor->price ?? 0, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge bg-success">Tersedia</span>
                                    </td>
                                    <td class="text-center">
                                        <a href="/admin/motor/{{ $motor->id }}/inspeksi" class="btn btn-sm btn-warning text-dark"><i class="bi bi-tools me-1"></i> Inspeksi</a>
                                        <a href="/admin/motor/{{ $motor->id }}/edit" class="btn btn-sm btn-info text-white" title="Edit Motor"><i class="bi bi-pencil-square"></i></a>
                                       <form action="/admin/motor/{{ $motor->id }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus {{ $motor->brand }} {{ $motor->model }} ini? Data yang dihapus tidak bisa dikembalikan.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus Motor"><i class="bi bi-trash"></i></button>
                                    </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">Belum ada data motor. Silakan tambahkan motor baru.</td>
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