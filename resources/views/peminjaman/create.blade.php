<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Peminjaman Motor | SewaMotor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #f8fafc;
        }
        .form-container { max-width: 900px; margin: 50px auto; }
        .card-form {
            border: none; border-radius: 2rem;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25); overflow: hidden;
        }
        .card-header {
            background: linear-gradient(135deg, #0d6efd, #0b5ed7);
            padding: 2rem; border-bottom: none;
        }
        .step-indicator {
            display: flex; justify-content: space-between; margin-bottom: 2rem; padding: 0 1rem;
        }
        .step { flex: 1; text-align: center; position: relative; }
        .step:not(:last-child)::after {
            content: ''; position: absolute; top: 20px; right: -50%;
            width: 100%; height: 2px; background: #dee2e6; z-index: 0;
        }
        .step.active .step-circle { background: #0d6efd; color: white; border-color: #0d6efd; }
        .step-circle {
            width: 40px; height: 40px; background: white; border: 2px solid #dee2e6;
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            margin: 0 auto 10px; font-weight: 600; position: relative; z-index: 1; transition: all 0.2s;
        }
        .step.active .step-label { color: #0d6efd; font-weight: 600; }
        .section-title {
            font-weight: 700; color: #0d6efd; margin-bottom: 1.5rem;
            padding-bottom: 0.5rem; border-bottom: 2px solid #e9ecef;
        }
        .form-control, .form-select { border-radius: 0.75rem; padding: 0.75rem 1rem; }
        .btn-submit {
            background: #0d6efd; border: none; border-radius: 50px;
            padding: 0.8rem 2rem; font-weight: 600; box-shadow: 0 8px 20px rgba(13,110,253,0.3);
        }
        .file-upload-box {
            border: 2px dashed #d2d6da; border-radius: 1rem; padding: 1.5rem;
            text-align: center; cursor: pointer;
        }
        .file-upload-box .form-control { display: none; }
        
        /* Tambahan CSS untuk menyembunyikan tahap yang belum aktif */
        .step-content { display: none; }
        .step-content.active { display: block; animation: fadeIn 0.5s; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body>

    <nav class="navbar navbar-light bg-white shadow-sm py-3">
        <div class="container">
            <a class="navbar-brand fw-bold fs-4" href="/"><i class="bi bi-bicycle me-2 text-primary"></i>Peminjaman Motor<span class="text-primary">.</span></a>
        </div>
    </nav>

    <div class="container form-container">
        <div class="card card-form">
            <div class="card-header text-white text-center">
                <h4 class="mb-1"><i class="bi bi-file-text me-2"></i>Form Peminjaman Motor</h4>
                <p class="mb-0 opacity-75">Isi data dengan lengkap untuk proses cepat</p>
            </div>
            <div class="card-body p-4 p-lg-5">
                
                <div class="step-indicator">
                    <div class="step active" id="indicator-1">
                        <div class="step-circle">1</div><div class="step-label">Data Peminjam</div>
                    </div>
                    <div class="step" id="indicator-2">
                        <div class="step-circle">2</div><div class="step-label">Data Kendaraan</div>
                    </div>
                    <div class="step" id="indicator-3">
                        <div class="step-circle">3</div><div class="step-label">Kondisi Motor</div>
                    </div>
                </div>

                <form action="/pinjam-motor" method="POST" enctype="multipart/form-data">
                    @csrf 
                    
                    <div class="step-content active" id="step-1">
                        <div class="section-title"><i class="bi bi-person-badge"></i> 1. Data Peminjam</div>
                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Nomor HP (WhatsApp) *</label>
                                <input type="text" name="phone_number" class="form-control" placeholder="08123456789" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nama Lengkap *</label>
                                <input type="text" name="name" class="form-control" placeholder="John Doe" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Alamat Lengkap *</label>
                                <textarea name="address" class="form-control" rows="2" required></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Upload Foto KTP *</label>
                                <div class="file-upload-box" onclick="document.getElementById('ktpFile').click()">
                                    <i class="bi bi-cloud-upload"></i> <p class="mt-2 mb-0">Upload KTP</p>
                                    <input type="file" id="ktpFile" name="ktp_image" class="form-control" accept="image/*" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Upload Foto SIM *</label>
                                <div class="file-upload-box" onclick="document.getElementById('simFile').click()">
                                    <i class="bi bi-cloud-upload"></i> <p class="mt-2 mb-0">Upload SIM</p>
                                    <input type="file" id="simFile" name="sim_image" class="form-control" accept="image/*" required>
                                </div>
                            </div>
                        </div>
                        <div class="text-end mt-4">
                            <button type="button" class="btn btn-primary px-4 rounded-pill" onclick="nextStep(1)">Selanjutnya <i class="bi bi-arrow-right"></i></button>
                        </div>
                    </div>

                    <div class="step-content" id="step-2">
                        <div class="section-title"><i class="bi bi-bike"></i> 2. Data Kendaraan</div>
                        <div class="row g-4 mb-4">
                            <div class="col-12">
                                <label class="form-label">Pilih Motor *</label>
                                <select name="motor_id" class="form-select" required>
                                    <option value="" selected disabled>-- Pilih Motor yang Tersedia --</option>
                                    <option value="1">Kawasaki W175 Kuning</option>
                                    <option value="2">Honda Vario 150 Hitam</option>
                                    <option value="3">Yamaha NMAX Silver</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tanggal Pengambilan *</label>
                                <input type="date" name="loan_date" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Rencana Kembali *</label>
                                <input type="date" name="return_date_plan" class="form-control" required>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-outline-secondary px-4 rounded-pill" onclick="prevStep(2)"><i class="bi bi-arrow-left"></i> Sebelumnya</button>
                            <button type="button" class="btn btn-primary px-4 rounded-pill" onclick="nextStep(2)">Selanjutnya <i class="bi bi-arrow-right"></i></button>
                        </div>
                    </div>

                    <div class="step-content" id="step-3">
                        <div class="section-title"><i class="bi bi-clipboard-check"></i> 3. Kondisi Motor</div>
                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Kilometer Awal *</label>
                                <input type="number" name="start_km" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Kondisi Bahan Bakar</label>
                                <select name="start_fuel_level" class="form-select">
                                    <option value="Penuh">Penuh</option>
                                    <option value="Setengah">Setengah</option>
                                    <option value="Kurang">Kurang / Mau Habis</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Upload Foto Kondisi Motor *</label>
                                <div class="file-upload-box" onclick="document.getElementById('motorPhoto').click()">
                                    <i class="bi bi-camera"></i> <p class="mt-2 mb-0">Upload Foto Keseluruhan Motor</p>
                                    <input type="file" id="motorPhoto" name="start_photo_motor" class="form-control" accept="image/*" required>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-5">
                            <button type="button" class="btn btn-outline-secondary px-4 rounded-pill" onclick="prevStep(3)"><i class="bi bi-arrow-left"></i> Sebelumnya</button>
                            <button type="submit" class="btn btn-submit text-white"><i class="bi bi-check2-circle me-2"></i>Proses Peminjaman</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script>
        // FUNGSI UNTUK PINDAH TAHAP (NEXT)
        function nextStep(current) {
            // Validasi apakah form di step ini sudah diisi (HTML5 Validation)
            let stepDiv = document.getElementById('step-' + current);
            let inputs = stepDiv.querySelectorAll('input[required], select[required], textarea[required]');
            let isValid = true;
            
            inputs.forEach(input => {
                if (!input.checkValidity()) {
                    input.reportValidity(); // Memunculkan peringatan "Harap isi bidang ini"
                    isValid = false;
                }
            });

            if (!isValid) return; // Kalau belum diisi, berhenti di sini

            // Sembunyikan step saat ini, tampilkan step berikutnya
            document.getElementById('step-' + current).classList.remove('active');
            document.getElementById('step-' + (current + 1)).classList.add('active');
            
            // Nyalakan warna biru di indikator angka atas
            document.getElementById('indicator-' + (current + 1)).classList.add('active');
        }

        // FUNGSI UNTUK KEMBALI (PREV)
        function prevStep(current) {
            document.getElementById('step-' + current).classList.remove('active');
            document.getElementById('step-' + (current - 1)).classList.add('active');
            document.getElementById('indicator-' + current).classList.remove('active');
        }

        // Menampilkan nama file saat upload
        document.querySelectorAll('.file-upload-box input[type="file"]').forEach(input => {
            input.addEventListener('change', function() {
                const parent = this.closest('.file-upload-box');
                if (this.files[0]) {
                    let nameTag = parent.querySelector('.file-name');
                    if (!nameTag) {
                        nameTag = document.createElement('small');
                        nameTag.className = 'file-name text-primary d-block mt-2 font-weight-bold';
                        parent.appendChild(nameTag);
                    }
                    nameTag.textContent = '✔️ ' + this.files[0].name;
                }
            });
        });
    </script>
</body>
</html>