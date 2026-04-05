<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pelanggan - Admin</title>
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
            <a href="/admin/motor"><i class="bi bi-motorcycle me-2"></i> Kelola Motor</a>
            <a href="/admin/peminjaman"><i class="bi bi-card-checklist me-2"></i> Data Peminjaman</a>
            <a href="/admin/pelanggan" class="active"><i class="bi bi-people me-2"></i> Data Pelanggan</a>
            
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
                <h2 class="fw-bold">Database Pelanggan</h2>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Lengkap</th>
                                    <th>Nomor WhatsApp</th>
                                    <th>Alamat Domisili</th>
                                    <th>Tgl Terdaftar</th>
                                    <th>Dokumen Identitas</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($customers as $index => $customer)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td class="fw-bold text-primary">{{ $customer->name }}</td>
                                    <td>
                                        <a href="https://wa.me/{{ preg_replace('/^0/', '62', $customer->phone_number) }}" target="_blank" class="text-decoration-none text-success fw-semibold">
                                            <i class="bi bi-whatsapp"></i> {{ $customer->phone_number }}
                                        </a>
                                    </td>
                                    <td>{{ Str::limit($customer->address, 40) }}</td>
                                    <td>{{ $customer->created_at->format('d M Y') }}</td>
                                    <td>
                                        @if($customer->ktp_image)
                                            <a href="{{ asset('storage/' . $customer->ktp_image) }}" target="_blank" class="btn btn-sm btn-outline-primary mb-1" title="Lihat KTP"><i class="bi bi-person-vcard"></i> KTP</a>
                                        @endif
                                        @if($customer->sim_image)
                                            <a href="{{ asset('storage/' . $customer->sim_image) }}" target="_blank" class="btn btn-sm btn-outline-info mb-1" title="Lihat SIM"><i class="bi bi-card-heading"></i> SIM</a>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">Belum ada data pelanggan yang terdaftar.</td>
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