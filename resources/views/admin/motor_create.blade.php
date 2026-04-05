<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Motor - Admin</title>
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
            <h4 class="fw-bold mb-4 text-center border-bottom pb-3"><i class="bi bi-bicycle text-primary"></i> AdminPanel</h4>
            <a href="/admin/dashboard"><i class="bi bi-speedometer2 me-2"></i> Ringkasan</a>
            <a href="/admin/motor" class="active"><i class="bi bi-motorcycle me-2"></i> Kelola Motor</a>
            <a href="#"><i class="bi bi-card-checklist me-2"></i> Data Peminjaman</a>
            <a href="#"><i class="bi bi-people me-2"></i> Data Pelanggan</a>
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
                <h2 class="fw-bold">Tambah Motor Baru</h2>
                <a href="/admin/motor" class="btn btn-secondary"><i class="bi bi-arrow-left me-2"></i>Kembali</a>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="/admin/motor" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Merek Motor (Misal: Honda, Yamaha)</label>
                                <input type="text" name="brand" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tipe/Model (Misal: Vario 150, NMAX)</label>
                                <input type="text" name="model" class="form-control" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Plat Nomor (Misal: DK 1234 ABC)</label>
                                <input type="text" name="plate_number" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Warna Kendaraan</label>
                                <input type="text" name="color" class="form-control" required>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Harga Sewa per Hari (Rp)</label>
                                <input type="number" name="price" class="form-control" placeholder="Contoh: 100000" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Foto Utama Motor</label>
                                <input type="file" name="image" class="form-control" accept="image/*">
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary px-5"><i class="bi bi-save me-2"></i>Simpan Data Motor</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>