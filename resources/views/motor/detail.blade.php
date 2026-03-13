<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail & Inspeksi Motor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background-color: #f8f9fa; font-family: 'Inter', sans-serif; }
        .inspection-card {
            background-color: #1e2125; /* Warna gelap mirip referensi gambar Anda */
            color: #f8f9fa;
            border-radius: 12px;
        }
        .alert-badge {
            background-color: rgba(255, 255, 255, 0.1);
            color: #e9ecef;
            border: 1px solid rgba(255, 255, 255, 0.2);
            font-weight: normal;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 0.9rem;
        }
        /* Jika ada alert kategori bahaya, warnanya merah */
        .alert-badge.danger {
            background-color: rgba(220, 53, 69, 0.2);
            color: #ffc107;
            border-color: rgba(220, 53, 69, 0.5);
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-dark bg-dark py-3 mb-5">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/"><i class="bi bi-arrow-left me-2"></i>Kembali ke Beranda</a>
        </div>
    </nav>

    <div class="container mb-5">
        <div class="row g-5">
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden sticky-top" style="top: 20px;">
                    <img src="{{ asset('images/motors/motor1.jpg') }}" alt="Honda Vario 150" class="img-fluid w-100" style="height: 400px; object-fit: cover;">
                </div>
            </div>

            <div class="col-lg-6">
                <h2 class="fw-bold mb-1">Honda Vario 150</h2>
                <p class="text-secondary fs-5 mb-4">Hitam doff · DK 5678 XYZ</p>
                
                <h3 class="text-primary fw-bold mb-4">Rp 100.000 <span class="fs-6 text-secondary fw-normal">/ hari</span></h3>

                <div class="inspection-card p-4 mb-4 shadow-sm">
                    <h5 class="text-warning fw-bold mb-3">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>Status Inspeksi Terkini
                    </h5>
                    <p class="text-secondary mb-3 small">Pilih semua yang berlaku (Catatan sebelum dipinjam):</p>
                    
                    <div class="d-flex flex-wrap gap-2 mb-4">
                        <span class="badge alert-badge">Ban depan tipis</span>
                        <span class="badge alert-badge">Lampu sein kiri mati</span>
                        <span class="badge alert-badge">Bodi lecet (samping kanan)</span>
                        <span class="badge alert-badge danger">Rem belakang sedikit blong</span>
                    </div>

                    <div class="mt-3 pt-3 border-top border-secondary">
                        <h6 class="fw-bold text-light mb-2"><i class="bi bi-file-earmark-text me-2"></i>Catatan Tambahan Admin</h6>
                        <p class="text-secondary mb-0 small">"Motor ini baru saja servis rutin ganti oli bulan lalu. Lecet di bodi kanan karena peminjam sebelumnya. Harap berhati-hati dengan rem belakang, gunakan rem depan lebih dominan."</p>
                    </div>
                </div>

                <div class="card border-0 bg-white shadow-sm rounded-4 p-4 mt-4">
                    <p class="mb-3 text-muted">Dengan melanjutkan, Anda menyetujui kondisi motor seperti yang tertera pada hasil inspeksi di atas.</p>
                    <a href="/pinjam-motor" class="btn btn-primary btn-lg rounded-pill w-100 fw-bold">
                        <i class="bi bi-check2-circle me-2"></i>Saya Setuju & Lanjut Pinjam
                    </a>
                </div>
            </div>
        </div>
    </div>

</body>
</html>