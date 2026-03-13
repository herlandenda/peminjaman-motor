<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peminjaman Motor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            scroll-behavior: smooth;
        }

        /* Navbar */
        .navbar-glass {
            background: rgba(33, 37, 41, 0.85);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .navbar-glass .navbar-brand,
        .navbar-glass .nav-link {
            color: white !important;
        }
        .navbar-glass .btn-primary {
            background: #0d6efd;
            border: none;
            box-shadow: 0 4px 14px rgba(13,110,253,0.4);
        }

        /* 1. HERO SECTION (Animasi Dipercepat menjadi 9s) */
        .hero-section {
            position: relative;
            animation: bgAnimation 9s infinite; /* Dipercepat dari 18s menjadi 9s */
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: white;
            padding: 150px 0;
            min-height: 90vh;
            display: flex;
            align-items: center;
            isolation: isolate;
            transition: background-image 0.8s ease-in-out;
        }

        @keyframes bgAnimation {
            0%, 30% { background-image: url('https://images.unsplash.com/photo-1558981403-c5f9899a28bc?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80'); }
            33%, 63% { background-image: url('https://images.unsplash.com/photo-1568772585407-9361f9bf3a87?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80'); }
            66%, 96% { background-image: url('https://images.unsplash.com/photo-1591637333184-19aa84b3e01f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80'); }
            100% { background-image: url('https://images.unsplash.com/photo-1558981403-c5f9899a28bc?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80'); }
        }

        .hero-section::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.4) 100%);
            z-index: -1;
        }
        .hero-section .display-3 {
            text-shadow: 0 2px 10px rgba(0,0,0,0.3);
        }

        /* Card Keunggulan */
        .feature-card {
            border: none;
            border-radius: 1.5rem;
            background: white;
            box-shadow: 0 20px 40px -15px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            padding: 2rem 1rem;
            height: 100%;
        }
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 30px 50px -20px rgba(0,0,0,0.2);
        }
        .feature-icon {
            font-size: 3.5rem;
            color: #0d6efd;
        }

        /* 2. CSS SLIDER MOTOR (Disempurnakan agar Loop Tidak Terputus) */
        .slider-wrapper {
            overflow: hidden;
            width: 100%;
            padding: 20px 0;
        }
        .slider-track {
            display: flex;
            width: max-content;
            animation: scrollLeft 30s linear infinite;
        }
        .slider-track:hover {
            animation-play-state: paused;
        }
        .slide-group {
            display: flex;
            gap: 1.5rem;
            padding-right: 1.5rem; /* Menjaga jarak antar grup */
        }
        .motor-card {
            border: none;
            border-radius: 1.5rem;
            overflow: hidden;
            box-shadow: 0 15px 30px -12px rgba(0,0,0,0.15);
            transition: transform 0.3s;
            width: 350px;
            flex-shrink: 0;
        }
        .motor-card:hover {
            transform: scale(1.02);
        }
        .motor-card img {
            height: 200px;
            object-fit: cover;
        }
        @keyframes scrollLeft {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); } /* Menggeser persis selebar satu grup */
        }

        .btn-outline-primary {
            border-width: 2px;
            border-radius: 50px;
            padding: 0.5rem 1.8rem;
        }
        footer a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: color 0.2s;
        }
        footer a:hover {
            color: white;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-glass sticky-top py-3">
        <div class="container">
            <a class="navbar-brand fw-bold fs-4" href="/">
                <i class="bi bi-bicycle me-2"></i>Peminjaman Motor<span class="text-primary">.</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item">
                        <a class="nav-link active" href="/">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#keunggulan">Tentang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#motor">Motor</a>
                    </li>
                    <li class="nav-item ms-lg-3">
                        <a class="btn btn-primary rounded-pill px-4 py-2" href="/pinjam-motor">
                            <i class="bi bi-bike me-2"></i>Pinjam Sekarang
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="hero-section">
        <div class="container text-center">
            <span class="badge bg-primary text-uppercase px-3 py-2 mb-4 rounded-pill">Komunitas Terpercaya</span>
            <h1 class="display-3 fw-bold mb-4">Solusi Kendaraan <span class="text-primary">Modern</span> untuk Komunitas</h1>
            <p class="lead mb-5 mx-auto" style="max-width: 700px;">Sewa motor jadi lebih mudah, cepat, dan transparan. Pilih motormu, isi data, dan langsung gas!</p>
            <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                <a href="/pinjam-motor" class="btn btn-primary btn-lg rounded-pill px-5 py-3 fs-6 shadow-lg">
                    <i class="bi bi-bicycle me-2"></i>Mulai Pinjam Motor
                </a>
                <a href="#keunggulan" class="btn btn-outline-light btn-lg rounded-pill px-5 py-3 fs-6">
                    <i class="bi bi-info-circle me-2"></i>Pelajari Dulu
                </a>
            </div>
        </div>
    </section>

    <section id="keunggulan" class="container py-5 my-5">
        <div class="text-center mb-5">
            <h2 class="fw-bold display-6">Kenapa Pilih Kami?</h2>
            <p class="text-secondary">Pengalaman sewa motor yang nyaman dan tanpa ribet</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card text-center">
                    <div class="feature-icon"><i class="bi bi-file-text-fill"></i></div>
                    <h4 class="fw-bold mt-4">Tanpa Ribet</h4>
                    <p class="text-secondary">Tidak perlu buat akun. Cukup siapkan KTP dan SIM, isi formulir, motor siap dibawa.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card text-center">
                    <div class="feature-icon"><i class="bi bi-shield-check"></i></div>
                    <h4 class="fw-bold mt-4">Motor Terawat</h4>
                    <p class="text-secondary">Kondisi mesin, ban, dan rem selalu dicek sebelum dan sesudah disewakan.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card text-center">
                    <div class="feature-icon"><i class="bi bi-people-fill"></i></div>
                    <h4 class="fw-bold mt-4">Harga Sahabat</h4>
                    <p class="text-secondary">Harga khusus untuk anggota komunitas dengan pelayanan maksimal.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="motor" class="bg-light py-5 overflow-hidden">
        <div class="container-fluid py-5 px-0">
            <div class="text-center mb-5">
                <h2 class="fw-bold display-6">Motor Pilihan</h2>
                <p class="text-secondary">Beberapa motor yang siap menemani perjalananmu</p>
            </div>
            
            <div class="slider-wrapper">
                <div class="slider-track">
                    
                    <div class="slide-group">
                        <div class="card motor-card">
                            <img src="{{ asset('images/motors/motor1.jpg') }}" alt="Motor 1">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">Kawasaki W175</h5>
                                <p class="card-text text-secondary">Kuning metalik · B 1234 ABC</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="h5 text-primary mb-0">Rp 150k/hari</span>
                                    <a href="/motor/detail" class="btn btn-outline-primary rounded-pill">Pilih</a>
                                </div>
                            </div>
                        </div>
                        <div class="card motor-card">
                            <img src="{{ asset('images/motors/motor2.jpg') }}" alt="Motor 2">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">Honda Vario 150</h5>
                                <p class="card-text text-secondary">Hitam doff · DK 5678 XYZ</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="h5 text-primary mb-0">Rp 100k/hari</span>
                                    <a href="/motor/detail" class="btn btn-outline-primary rounded-pill">Pilih</a>
                                </div>
                            </div>
                        </div>
                        <div class="card motor-card">
                            <img src="{{ asset('images/motors/motor3.jpg') }}" alt="Motor 3">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">Yamaha NMAX</h5>
                                <p class="card-text text-secondary">Silver · B 4321 DE</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="h5 text-primary mb-0">Rp 175k/hari</span>
                                    <a href="/motor/detail" class="btn btn-outline-primary rounded-pill">Pilih</a>
                                </div>
                            </div>
                        </div>
                        <div class="card motor-card">
                            <img src="{{ asset('images/motors/motor4.jpg') }}" alt="Motor 4">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">Kawasaki W175</h5>
                                <p class="card-text text-secondary">Kuning metalik · B 1234 ABC</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="h5 text-primary mb-0">Rp 150k/hari</span>
                                    <a href="/motor/detail" class="btn btn-outline-primary rounded-pill">Pilih</a>
                                </div>
                            </div>
                        </div>
                        <div class="card motor-card">
                            <img src="{{ asset('images/motors/motor2.jpg') }}" alt="Motor 5">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">Honda Vario 150</h5>
                                <p class="card-text text-secondary">Hitam doff · DK 5678 XYZ</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="h5 text-primary mb-0">Rp 100k/hari</span>
                                    <a href="/motor/detail" class="btn btn-outline-primary rounded-pill">Pilih</a>
                                </div>
                            </div>
                        </div>
                        <div class="card motor-card">
                            <img src="{{ asset('images/motors/motoryamaha.jpg') }}" alt="Motor 6">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">Yamaha NMAX</h5>
                                <p class="card-text text-secondary">Silver · B 4321 DE</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="h5 text-primary mb-0">Rp 175k/hari</span>
                                    <a href="/motor/detail" class="btn btn-outline-primary rounded-pill">Pilih</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="slide-group">
                        <div class="card motor-card">
                            <img src="https://images.unsplash.com/photo-1618773928121-c32242e63f39?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Motor 1">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">Kawasaki W175</h5>
                                <p class="card-text text-secondary">Kuning metalik · B 1234 ABC</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="h5 text-primary mb-0">Rp 150k/hari</span>
                                    <a href="/motor/detail" class="btn btn-outline-primary rounded-pill">Pilih</a>
                                </div>
                            </div>
                        </div>
                        <div class="card motor-card">
                            <img src="https://images.unsplash.com/photo-1591637333184-19aa84b3e01f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Motor 2">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">Honda Vario 150</h5>
                                <p class="card-text text-secondary">Hitam doff · DK 5678 XYZ</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="h5 text-primary mb-0">Rp 100k/hari</span>
                                    <a href="/motor/detail" class="btn btn-outline-primary rounded-pill">Pilih</a>
                                </div>
                            </div>
                        </div>
                        <div class="card motor-card">
                            <img src="https://images.unsplash.com/photo-1568772585407-9361f9bf3a87?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Motor 3">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">Yamaha NMAX</h5>
                                <p class="card-text text-secondary">Silver · B 4321 DE</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="h5 text-primary mb-0">Rp 175k/hari</span>
                                    <a href="/motor/detail" class="btn btn-outline-primary rounded-pill">Pilih</a>
                                </div>
                            </div>
                        </div>
                        <div class="card motor-card">
                            <img src="C:\Herland\Project\laragon\www\peminjaman-motor\public\images\motors/download (5).jpg" alt="Motor 4">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">Kawasaki W175</h5>
                                <p class="card-text text-secondary">Kuning metalik · B 1234 ABC</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="h5 text-primary mb-0">Rp 150k/hari</span>
                                    <a href="/motor/detail" class="btn btn-outline-primary rounded-pill">Pilih</a>
                                </div>
                            </div>
                        </div>
                        <div class="card motor-card">
                            <img src="public/images/motors/download (6).jpg" alt="Motor 5">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">Honda Vario 150</h5>
                                <p class="card-text text-secondary">Hitam doff · DK 5678 XYZ</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="h5 text-primary mb-0">Rp 100k/hari</span>
                                    <a href="/motor/detail" class="btn btn-outline-primary rounded-pill">Pilih</a>
                                </div>
                            </div>
                        </div>
                        <div class="card motor-card">
                            <img src="public/images/motors/download (7).jpg" alt="Motor 6">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">Yamaha NMAX</h5>
                                <p class="card-text text-secondary">Silver · B 4321 DE</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="h5 text-primary mb-0">Rp 175k/hari</span>
                                    <a href="/motor/detail" class="btn btn-outline-primary rounded-pill">Pilih</a>
                                </div>
                            </div>
                        </div>
                        <div class="card motor-card">
                            <img src="public/images/motors/download (8).jpg" alt="Motor 7">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">Honda CBR 150R</h5>
                                <p class="card-text text-secondary">Merah · B 9876 XYZ</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="h5 text-primary mb-0">Rp 200k/hari</span>
                                    <a href="/motor/detail" class="btn btn-outline-primary rounded-pill">Pilih</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="text-center mt-5">
                <a href="/pinjam-motor" class="btn btn-primary btn-lg rounded-pill px-5">
                    <i class="bi bi-bicycle me-2"></i>Lihat Semua Motor
                </a>
            </div>
        </div>
    </section>

    <footer class="bg-dark text-white pt-5 pb-4">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-4">
                    <a class="navbar-brand fw-bold fs-4 text-white" href="/">
                        <i class="bi bi-bicycle me-2"></i>Peminjaman Motor<span class="text-primary">.</span>
                    </a>
                    <p class="text-secondary mt-3">Solusi peminjaman motor modern untuk komunitas, tanpa ribet dan terpercaya.</p>
                    <div class="d-flex gap-3">
                        <a href="#"><i class="bi bi-facebook fs-5"></i></a>
                        <a href="#"><i class="bi bi-instagram fs-5"></i></a>
                        <a href="https://wa.me/6281337977866?text=Halo,%20Admin%20Peminjaman%20Motor,%20saya%20ingin%20bertanya%20seputar%20penyewaan%20motor." target="_blank" class="text-white"><i class="bi bi-whatsapp fs-5"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 offset-lg-2">
                    <h5 class="fw-bold">Menu</h5>
                    <ul class="list-unstyled">
                        <li><a href="/" class="text-secondary text-decoration-none">Beranda</a></li>
                        <li><a href="#keunggulan" class="text-secondary text-decoration-none">Tentang</a></li>
                        <li><a href="#motor" class="text-secondary text-decoration-none">Motor</a></li>
                    </ul>
                </div>
                <div class="col-lg-4">
                    <h5 class="fw-bold">Kontak</h5>
                    <ul class="list-unstyled">
                        <li class="text-secondary mb-2"><i class="bi bi-whatsapp me-2"></i>+62 813-3797-7866</li>
                        <li class="text-secondary mb-2"><i class="bi bi-envelope me-2"></i>info@peminjamanmotor.id</li>
                        <li class="text-secondary"><i class="bi bi-geo-alt me-2"></i>Jl. Bedugul No.30, Sidakarya, Denpasar Selatan</li>
                    </ul>
                </div>
            </div>
            <hr class="border-secondary mt-4">
            <div class="text-center text-secondary">
                <p class="mb-0">© 2026 Peminjaman Motor Komunitas. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>