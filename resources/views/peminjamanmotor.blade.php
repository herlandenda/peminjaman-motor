<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discipline Or Die-Bali</title>
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

        /* 1. HERO SECTION */
        .hero-section {
            position: relative;
            animation: bgAnimation 9s infinite;
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

        /* --- CSS BARU UNTUK INFINITE SCROLL --- */
        .horizontal-scroll-wrapper {
            overflow: hidden;
            width: 100%;
            position: relative;
            padding-bottom: 2rem;
        }

        .scroll-track {
            display: flex;
            gap: 1.5rem;
            width: max-content;
            /* Kecepatan putaran: Sesuaikan angka 25s ini jika ingin lebih cepat/lambat */
            animation: infiniteScroll 25s linear infinite;
        }

        /* Jeda animasi agar pengguna bisa klik saat mouse berada di atas motor */
        .scroll-track:hover {
            animation-play-state: paused;
        }

        .motor-item {
            /* Lebar card tetap agar animasinya lancar */
            flex: 0 0 320px; 
            transition: all 0.4s ease;
        }

        .motor-card {
            border: none;
            border-radius: 1.5rem;
            overflow: hidden;
            box-shadow: 0 15px 30px -12px rgba(0,0,0,0.15);
            transition: transform 0.3s;
        }

        .motor-card:hover {
            transform: scale(1.02);
        }

        /* Rumus ajaib CSS untuk memutar: menggeser sejauh 50% dari total panjang plus setengah jarak gap */
        @keyframes infiniteScroll {
            0% { transform: translateX(0); }
            100% { transform: translateX(calc(-50% - 0.75rem)); } 
        }

        /* --- PENGATURAN MODE GRID (Saat tombol diklik) --- */
        .grid-active .scroll-track {
            animation: none !important; /* Mematikan putaran */
            flex-wrap: wrap; /* Menyusun ke bawah */
            justify-content: center;
            width: 100%;
        }

        .grid-active .motor-item {
            flex: 1 1 320px;
            max-width: 380px;
        }

        /* Sembunyikan motor kloningan agar tidak ada motor kembar saat di mode grid */
        .grid-active .clone-item {
            display: none !important;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-glass sticky-top py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="/">
                <img src="{{ asset('images/motors/IMG_1306.png') }}" alt="logo peminjaman motor" height="60" class="me-2 d-inline-block">
                <span class="fw-bold lh-1">Ride For Unity<span class="text-primary"> Bali</span></span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item">
                        <a class="nav-link active" href="/#">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#keunggulan">Tentang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#motor">Motor</a>
                    </li>
                   
                </ul>
                <a href="/cek-pesanan" class="btn btn-outline-primary rounded-pill px-4 fw-medium"><i class="bi bi-receipt me-2"></i>Cek Pesanan</a>
            </div>
        </div>
        
    </nav>

    <section class="hero-section">
        <div class="container text-center">
            <h1 class="display-3 fw-bold mb-4">Solusi Kendaraan <span class="text-primary">Modern</span> untuk Komunitas</h1>
            <p class="lead mb-5 mx-auto" style="max-width: 700px;">Sewa motor jadi lebih mudah, cepat, dan transparan. Pilih motormu, isi data, dan langsung gas!</p>
            <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                <a href="/#motor" class="btn btn-primary btn-lg rounded-pill px-5 py-3 fs-6 shadow-lg">
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

    <section id="motor" class="bg-light py-5">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="fw-bold display-6">Motor Pilihan</h2>
                <p class="text-secondary">Geser untuk melihat koleksi favorit, atau perluas untuk melihat semuanya.</p>
            </div>
            
            <div id="motorContainer" class="horizontal-scroll-wrapper">
                <div class="scroll-track" id="scrollTrack">
                    @forelse ($motors as $motor)
                    <div class="motor-item">
                        <div class="card motor-card h-100 shadow-sm border-0">
                            @if($motor->image)
                                <img src="{{ asset('storage/' . $motor->image) }}" class="card-img-top" style="height: 220px; object-fit: cover;" alt="{{ $motor->model }}" onerror="this.src='https://via.placeholder.com/800x500?text=Gambar+Rusak'">
                            @else
                                <div class="bg-secondary text-white d-flex justify-content-center align-items-center rounded-top" style="height: 220px;">
                                    <i class="bi bi-image text-muted" style="font-size: 4rem;"></i>
                                </div>
                            @endif
                            
                            <div class="card-body d-flex flex-column p-4">
                                <h5 class="card-title fw-bold mb-1">{{ $motor->brand }} {{ $motor->model }}</h5>
                                <p class="card-text text-secondary mb-3">{{ $motor->color }} · <span class="badge bg-light text-dark border">{{ $motor->plate_number }}</span></p>
                                
                                <div class="d-flex justify-content-between align-items-center mt-auto pt-3 border-top">
                                    <span class="h5 text-primary mb-0 fw-bold">Rp {{ number_format($motor->price ?? 0, 0, ',', '.') }}<span class="fs-6 text-secondary fw-normal">/hari</span></span> 
                                    @php
                                        $sedangDipinjam = \App\Models\Loan::where('motor_id', $motor->id)->where('status', 'active')->exists();
                                    @endphp
                                    <a href="/motor/detail/{{ $motor->id }}" class="btn btn-sm btn-outline-primary rounded-pill px-4">Pinjam Sekarang</a>                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="empty-state text-center py-5 w-100">
                        <i class="bi bi-emoji-frown display-1 text-muted opacity-50 mb-3"></i>
                        <h4 class="text-muted">Belum ada motor yang tersedia saat ini.</h4>
                    </div>
                    @endforelse
                </div>
            </div>

            <div class="text-center mt-4">
                <button id="toggleMotorBtn" onclick="toggleView()" class="btn btn-primary btn-lg rounded-pill px-5 shadow-sm">
                    <i class="bi bi-grid-3x3-gap-fill me-2" id="toggleIcon"></i> <span id="toggleText">Lihat Semua Motor</span>
                </button>
            </div>
        </div>
    </section>

    <footer class="bg-dark text-white pt-5 pb-4">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-4">
                    <a class="navbar-brand fw-bold fs-4 text-white" href="/">
                        <i class="bi bi-bicycle me-2"></i>Ride For Unity<span class="text-primary"> Bali</span>
                    </a>
                    <p class="text-secondary mt-3">Solusi peminjaman motor modern untuk komunitas, tanpa ribet dan terpercaya.</p>
                    <div class="d-flex gap-3">
                        <a href="#"><i class="bi bi-facebook fs-5"></i></a>
                        <a href="https://www.instagram.com/rideforunity.id/" target="_blank" class="text-white"><i class="bi bi-instagram fs-5"></i></a>
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
                <p class="mb-0">© 2026 Discipline Or Die Bali. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const track = document.getElementById("scrollTrack");
            const emptyState = document.querySelector(".empty-state");

            // Kloning data motor agar animasi berjalan mulus tanpa batas
            if (track && !emptyState) {
                const items = Array.from(track.children);
                
                // Pastikan jumlah motor cukup untuk digeser, jika kurang dari 4, gandakan lebih banyak
                const timesToClone = items.length < 4 ? 3 : 1; 

                for (let i = 0; i < timesToClone; i++) {
                    items.forEach(item => {
                        let clone = item.cloneNode(true);
                        clone.classList.add("clone-item"); 
                        track.appendChild(clone);
                    });
                }
            }
        });

        function toggleView() {
            const wrapper = document.getElementById('motorContainer');
            wrapper.classList.toggle('grid-active');

            const icon = document.getElementById('toggleIcon');
            const text = document.getElementById('toggleText');

            if (wrapper.classList.contains('grid-active')) {
                icon.className = 'bi bi-chevron-up me-2';
                text.innerText = 'Tutup Tampilan Penuh';
            } else {
                icon.className = 'bi bi-grid-3x3-gap-fill me-2';
                text.innerText = 'Lihat Semua Motor';
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if(session('success'))
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                title: "Pemesanan Berhasil! 🎉",
                text: "{{ session('success') }}\nSilakan ambil motor sesuai jadwal. Kami juga akan menghubungi Anda via WhatsApp.",
                icon: "success",
                confirmButtonColor: "#0d6efd",
                confirmButtonText: "Siap, Terima Kasih!",
                backdrop: `rgba(0,0,123,0.4)`
            });
        });
    </script>
    @endif
</body>
</html>