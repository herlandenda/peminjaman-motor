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
                    <img src="{{ asset('storage/' . $motor->image) }}" alt="{{ $motor->name }}" class="img-fluid w-100" style="height: 400px; object-fit: cover;">
                </div>
            </div>

            <div class="col-lg-6">
                <h2>{{ $motor->brand }} {{ $motor->model }}</h2>
                <p>{{ $motor->color }} · {{ $motor->plate_number }}</p>

                <h3 class="text-primary">Rp {{ number_format($motor->daily_rate, 0, ',', '.') }} 
                    <span class="fs-6 text-secondary fw-normal">/ hari</span></h3>

                <div class="card border-warning border-opacity-50 bg-warning bg-opacity-10 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">
                        <h5 class="text-dark fw-bold mb-3">
                            <i class="bi bi-exclamation-triangle-fill text-warning me-2"></i>Status Inspeksi Terkini
                        </h5>
                        <p class="text-secondary small mb-3">Catatan kondisi sebelum dipinjam. Harap diperhatikan:</p>
                        
                        <div class="d-flex flex-wrap gap-2 mb-4">
                            @if($motor->inspection_notes)
                                @php $tags = explode(',', $motor->inspection_notes); @endphp
                                @foreach($tags as $tag)
                                    <span class="badge bg-white text-dark border border-secondary border-opacity-25 shadow-sm fw-medium px-3 py-2 rounded-pill">
                                        <i class="bi bi-wrench me-1 text-muted"></i> {{ trim($tag) }}
                                    </span>
                                @endforeach
                            @else
                                <span class="badge bg-success text-white shadow-sm fw-medium px-3 py-2 rounded-pill">
                                    <i class="bi bi-check-circle me-1"></i>Kondisi Prima (Tidak ada catatan minor)
                                </span>
                            @endif
                        </div>

                        <div class="border-top border-warning border-opacity-25 pt-3">
                            <h6 class="fw-bold text-dark mb-2"><i class="bi bi-journal-text text-secondary me-2"></i>Catatan Tambahan Admin</h6>
                            
                            <div class="bg-white p-3 rounded-3 border border-secondary border-opacity-10 text-secondary small fst-italic shadow-sm">
                                "{{ $motor->additional_notes ?? 'Motor dalam kondisi standar penyewaan. Siap digunakan.' }}"
                            </div>
                            
                            <p class="text-secondary small mb-0 mt-3 pt-3 border-top border-warning border-opacity-25">
                                <i class="bi bi-info-circle me-1"></i> Dengan melanjutkan, Anda menyetujui kondisi motor sesuai hasil inspeksi di atas.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="card border-0 bg-white shadow-sm rounded-4 p-4 mt-4">
                    <p class="mb-3 text-muted">Dengan melanjutkan, Anda menyetujui kondisi motor seperti yang tertera pada hasil inspeksi di atas.</p>
                    <a href="/pinjam-motor?motor_id={{ $motor->id }}" class="btn btn-primary btn-lg rounded-pill w-100 fw-bold">
                        <i class="bi bi-check2-circle me-2"></i>Saya Setuju & Lanjut Pinjam
                    </a>
                </div>
            </div>
        </div>
    </div>

</body>
</html>