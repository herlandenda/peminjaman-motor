<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Discipline Or Die Bali</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { 
            /* Menggunakan gambar background pemandangan Bali. Anda bisa mengganti URL-nya nanti jika punya ilustrasi sendiri */
            background: url('{{ asset("images/motors/Login.jpg") }}') no-repeat center center fixed; 
            background-size: cover;
            font-family: 'Inter', sans-serif; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            min-height: 100vh; 
            margin: 0;
            position: relative;
            z-index: 1;
        }
        
        /* Memberikan efek gelap transparan (overlay) agar form tetap terbaca jelas */
        body::before {
            content: "";
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: -1;
        }

        .login-card { 
            border: none; 
            border-radius: 8px; /* Sudut lebih tegas seperti referensi DomaiNesia */
            box-shadow: 0 15px 35px rgba(0,0,0,0.2); 
            width: 100%; 
            max-width: 400px; 
            background: white;
            padding: 2.5rem 2rem;
        }

        .logo-container {
            text-align: center;
            margin-bottom: 2rem;
        }

        .logo-container img {
            max-height: 65px; /* Menggunakan ukuran yang proporsional */
            margin-bottom: 1rem;
        }

        /* Styling Input Form yang minimalis */
        .form-control {
            border-radius: 4px;
            padding: 0.8rem 1rem;
            background-color: #f8f9fa;
            border: 1px solid #ced4da;
            font-size: 0.95rem;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #0d6efd;
            background-color: #fff;
        }

        /* Styling Tombol */
        .btn-primary {
            border-radius: 4px;
            padding: 0.7rem;
            font-weight: 600;
            background-color: #0d6efd;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0b5ed7;
        }

        .btn-secondary-link {
            background-color: #6c757d;
            color: white;
            border-radius: 4px;
            padding: 0.7rem;
            text-decoration: none;
            display: block;
            text-align: center;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .btn-secondary-link:hover {
            background-color: #5a6268;
            color: white;
        }
    </style>
</head>
<body>

<div class="login-card">
    
    <div class="logo-container">
        <img src="{{ asset('images/motors/IMG_1306.png') }}" alt="Logo Discipline Or Die Bali">
    </div>
    
    @if ($errors->any())
        <div class="alert alert-danger rounded-3 small py-2 mb-4">
            @foreach ($errors->all() as $error)
                <div class="mb-1"><i class="bi bi-exclamation-triangle-fill me-1"></i> {{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form action="{{ route('login') }}" method="POST">
        @csrf
        <div class="mb-3">
            <input type="email" name="email" class="form-control" placeholder="Email Address" value="{{ old('email') }}" required autofocus>
        </div>
        <div class="mb-4">
            <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>
        
        <button type="submit" class="btn btn-primary w-100 mb-3 shadow-sm">Sign In</button>
    </form>

    <div class="mt-2">
        <a href="/" class="btn-secondary-link shadow-sm">Kembali ke Website</a>
    </div>
</div>

</body>
</html>