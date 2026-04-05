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
        body { font-family: 'Inter', sans-serif; background: #f8fafc; }
        .form-container { max-width: 900px; margin: 50px auto; }
        .card-form { border: none; border-radius: 2rem; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25); overflow: hidden; }
        .card-header { background: linear-gradient(135deg, #0d6efd, #0b5ed7); padding: 2rem; border-bottom: none; }
        .step-indicator { display: flex; justify-content: space-between; margin-bottom: 2rem; padding: 0 1rem; }
        .step { flex: 1; text-align: center; position: relative; }
        .step:not(:last-child)::after { content: ''; position: absolute; top: 20px; right: -50%; width: 100%; height: 2px; background: #dee2e6; z-index: 0; }
        .step.active .step-circle { background: #0d6efd; color: white; border-color: #0d6efd; }
        .step-circle { width: 40px; height: 40px; background: white; border: 2px solid #dee2e6; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px; font-weight: 600; position: relative; z-index: 1; transition: all 0.2s; }
        .step.active .step-label { color: #0d6efd; font-weight: 600; }
        .section-title { font-weight: 700; color: #0d6efd; margin-bottom: 1.5rem; padding-bottom: 0.5rem; border-bottom: 2px solid #e9ecef; }
        .form-control, .form-select { border-radius: 0.75rem; padding: 0.75rem 1rem; }
        .btn-submit { background: #0d6efd; border: none; border-radius: 50px; padding: 0.8rem 2rem; font-weight: 600; box-shadow: 0 8px 20px rgba(13,110,253,0.3); }
        .file-upload-box { border: 2px dashed #d2d6da; border-radius: 1rem; padding: 1.5rem; text-align: center; cursor: pointer; }
        .file-upload-box .form-control { display: none; }
        
        /* CSS menyembunyikan tahap yang belum aktif */
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

    <div class="container form-container mb-5">
        <div class="card card-form">
            <div class="card-header text-white text-center">
                <h4 class="mb-1"><i class="bi bi-file-text me-2"></i>Form Peminjaman Motor</h4>
                <p class="mb-0 opacity-75">Isi data dengan lengkap untuk proses cepat</p>
            </div>
            <div class="card-body p-4 p-lg-5">
                
                <div class="step-indicator">
                    <div class="step active" id="indicator-1"><div class="step-circle">1</div><div class="step-label">Data Peminjam</div></div>
                    <div class="step" id="indicator-2"><div class="step-circle">2</div><div class="step-label">Data Kendaraan</div></div>
                    <div class="step" id="indicator-3"><div class="step-circle">3</div><div class="step-label">Kondisi Motor</div></div>
                </div>

                <form action="/pinjam-motor" method="POST" enctype="multipart/form-data">
                    @csrf 
                    
                    <div class="step-content active" id="step-1">
                        <div class="section-title"><i class="bi bi-person-lines-fill"></i> 1. Data Peminjam</div>
                        
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Nomor WhatsApp *</label>
                            <div class="input-group">
                                <input type="text" id="phone_number" name="phone_number" class="form-control form-control-lg" placeholder="Contoh: 08123456789" required>
                                <button type="button" class="btn btn-primary px-4" id="btnCekNomor" onclick="cekNomorHp()">
                                    <i class="bi bi-search me-1"></i> Cek Data
                                </button>
                            </div>
                            <div class="form-text text-secondary"><i class="bi bi-info-circle me-1"></i>Klik "Cek Data" agar tidak perlu upload KTP/SIM lagi jika sudah pernah menyewa.</div>
                        </div>

                        <div id="lamaAlert" class="alert alert-success d-none border-0 shadow-sm rounded-4 mb-4">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-check-circle-fill fs-3 text-success me-3"></i>
                                <div>
                                    <h6 class="mb-0 fw-bold">Selamat datang kembali, <span id="lamaName"></span>!</h6>
                                    <p class="mb-0 small text-success">Data KTP dan SIM Anda sudah tersimpan di sistem kami.</p>
                                </div>
                            </div>
                            <input type="hidden" name="existing_customer_id" id="existing_customer_id">
                        </div>

                        <div id="formPelangganBaru">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nama Lengkap *</label>
                                <input type="text" name="name" id="name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Alamat Domisili / Hotel *</label>
                                <textarea name="address" id="address" class="form-control" rows="2" required></textarea>
                            </div>
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Upload KTP *</label>
                                    <input type="file" name="ktp_image" id="ktp_image" class="form-control" accept="image/*" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Upload SIM C *</label>
                                    <input type="file" name="sim_image" id="sim_image" class="form-control" accept="image/*" required>
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
                                    <option value="">-- Pilih Motor yang Tersedia --</option>
                                    @foreach ($motors as $m)
                                        <option value="{{ $m->id }}" {{ request('motor_id') == $m->id ? 'selected' : '' }}>
                                            {{ $m->brand }} {{ $m->model }} - {{ $m->color }} ({{ $m->plate_number }})
                                        </option>
                                    @endforeach
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
                                    <i class="bi bi-camera fs-3 text-secondary"></i> <p class="mt-2 mb-0">Upload Foto Keseluruhan Motor</p>
                                    <input type="file" id="motorPhoto" name="start_photo_motor" class="form-control" accept="image/*" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-check mt-2 p-3 mb-4 bg-white border border-primary border-opacity-25 rounded-3 shadow-sm">
                            <input class="form-check-input ms-1 mt-2 border-primary" type="checkbox" id="agreement" required>
                            <label class="form-check-label ms-2 small text-secondary" for="agreement">
                                <strong class="text-dark"><i class="bi bi-shield-exclamation text-warning me-1"></i> Persetujuan Sewa:</strong><br>
                                Saya menyetujui untuk bertanggung jawab penuh dan menanggung biaya perbaikan jika terjadi kerusakan (bodi/mesin) selama masa sewa. Saya juga berjanji akan mengembalikan motor dengan kondisi indikator bahan bakar yang sama seperti saat dipinjam.
                            </label>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <button type="button" class="btn btn-outline-secondary px-4 rounded-pill" onclick="prevStep(3)"><i class="bi bi-arrow-left"></i> Sebelumnya</button>
                            <button type="submit" class="btn btn-submit text-white"><i class="bi bi-check2-circle me-2"></i>Proses Peminjaman</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // 1. NAVIGASI FORM NEXT & PREV
        function nextStep(current) {
            let stepDiv = document.getElementById('step-' + current);
            let inputs = stepDiv.querySelectorAll('input[required], select[required], textarea[required]');
            let isValid = true;
            
            inputs.forEach(input => {
                if (!input.checkValidity()) {
                    input.reportValidity();
                    isValid = false;
                }
            });

            if (!isValid) return;

            document.getElementById('step-' + current).classList.remove('active');
            document.getElementById('step-' + (current + 1)).classList.add('active');
            document.getElementById('indicator-' + (current + 1)).classList.add('active');
        }

        function prevStep(current) {
            document.getElementById('step-' + current).classList.remove('active');
            document.getElementById('step-' + (current - 1)).classList.add('active');
            document.getElementById('indicator-' + current).classList.remove('active');
        }

        // Tampilkan nama file setelah dipilih
        document.querySelectorAll('.file-upload-box input[type="file"]').forEach(input => {
            input.addEventListener('change', function() {
                const parent = this.closest('.file-upload-box');
                if (this.files[0]) {
                    let nameTag = parent.querySelector('.file-name');
                    if (!nameTag) {
                        nameTag = document.createElement('small');
                        nameTag.className = 'file-name text-primary d-block mt-2 fw-bold';
                        parent.appendChild(nameTag);
                    }
                    nameTag.textContent = '✔️ ' + this.files[0].name;
                }
            });
        });

        // 2. LOGIKA PELACAK NOMOR HP (AJAX)
        function cekNomorHp() {
            let phone = document.getElementById('phone_number').value;
            let btn = document.getElementById('btnCekNomor');

            if(phone.trim() === '') {
                alert('Silakan masukkan nomor WhatsApp Anda terlebih dahulu!');
                return;
            }

            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Mencari...';
            btn.disabled = true;

            fetch('/cek-pelanggan/' + phone)
                .then(response => response.json())
                .then(data => {
                    let formBaru = document.getElementById('formPelangganBaru');
                    let lamaAlert = document.getElementById('lamaAlert');
                    
                    let inputKtp = document.getElementById('ktp_image');
                    let inputSim = document.getElementById('sim_image');
                    let inputName = document.getElementById('name');
                    let inputAddress = document.getElementById('address');

                    if(data.status === 'found') {
                        lamaAlert.classList.remove('d-none'); 
                        document.getElementById('lamaName').innerText = data.name;
                        document.getElementById('existing_customer_id').value = data.customer_id; 

                        formBaru.classList.add('d-none');
                        inputKtp.removeAttribute('required');
                        inputSim.removeAttribute('required');
                        inputName.removeAttribute('required');
                        inputAddress.removeAttribute('required');
                    } else {
                        lamaAlert.classList.add('d-none'); 
                        document.getElementById('existing_customer_id').value = '';

                        formBaru.classList.remove('d-none');
                        inputKtp.setAttribute('required', 'required');
                        inputSim.setAttribute('required', 'required');
                        inputName.setAttribute('required', 'required');
                        inputAddress.setAttribute('required', 'required');

                        alert('Nomor baru terdeteksi. Silakan lengkapi data diri & dokumen Anda di bawah.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan pada server saat mengecek nomor.');
                })
                .finally(() => {
                    btn.innerHTML = '<i class="bi bi-search me-1"></i> Cek Data';
                    btn.disabled = false;
                });
        }
    </script>
</body>
</html>