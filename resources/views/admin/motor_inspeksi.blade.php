<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inspeksi Motor - Admin</title>
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
                <h2 class="fw-bold">Catatan Inspeksi Kendaraan</h2>
                <a href="/admin/motor" class="btn btn-secondary"><i class="bi bi-arrow-left me-2"></i>Kembali</a>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-warning bg-opacity-25 border-0 pt-4 pb-3 px-4">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-tools me-2 text-warning"></i> {{ $motor->brand }} {{ $motor->model }} ({{ $motor->plate_number }})</h5>
                </div>
                <div class="card-body p-4">
                    
                    <form action="/admin/motor/{{ $motor->id }}/inspeksi" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Pilih Kondisi Fisik / Kerusakan (Pilih semua yang berlaku)</label>
                            
                            @php 
                                // Memecah data lama (jika ada) untuk dicentang otomatis
                                $checkedTags = $motor->inspection_notes ? explode(',', $motor->inspection_notes) : []; 
                            @endphp

                            <div class="row g-3 mt-1">
                                @php
                                    $options = ['Ban depan tipis', 'Ban belakang tipis', 'Lampu sein mati', 'Lampu utama redup', 'Bodi lecet (kanan)', 'Bodi lecet (kiri)', 'Rem depan kurang pakem', 'Rem belakang blong', 'Mesin sedikit kasar', 'Klakson mati'];
                                @endphp
                                
                                @foreach($options as $opt)
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="inspection_notes[]" value="{{ $opt }}" id="tag_{{ $loop->index }}" {{ in_array($opt, $checkedTags) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tag_{{ $loop->index }}">{{ $opt }}</label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="mb-4 pt-3 border-top">
                            <label class="form-label fw-semibold">Catatan Tambahan Admin (Opsional)</label>
                            <textarea name="additional_notes" class="form-control" rows="4" placeholder="Ketik riwayat servis atau catatan spesifik lainnya di sini...">{{ $motor->additional_notes }}</textarea>
                        </div>

                        <div class="text-end border-top pt-4">
                            <button type="submit" class="btn btn-warning fw-bold px-5"><i class="bi bi-save me-2"></i>Simpan Inspeksi</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>