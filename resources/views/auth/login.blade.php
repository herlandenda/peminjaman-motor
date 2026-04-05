<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background-color: #f4f6f9; font-family: 'Inter', sans-serif; display: flex; align-items: center; justify-content: center; min-height: 100vh; }
        .login-card { border: none; border-radius: 1.5rem; box-shadow: 0 10px 30px rgba(0,0,0,0.08); overflow: hidden; width: 100%; max-width: 400px; }
        .login-header { background: #0d6efd; color: white; padding: 2rem; text-align: center; }
    </style>
</head>
<body>

<div class="login-card bg-white">
    <div class="login-header">
        <i class="bi bi-shield-lock-fill display-4 mb-2"></i>
        <h3 class="fw-bold mb-0">Admin Access</h3>
    </div>
    <div class="card-body p-4">
        
        @if ($errors->any())
            <div class="alert alert-danger rounded-3 small">
                @foreach ($errors->all() as $error)
                    <i class="bi bi-exclamation-triangle-fill me-1"></i> {{ $error }}
                @endforeach
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label text-secondary small fw-bold">Email Address</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope text-muted"></i></span>
                    <input type="email" name="email" class="form-control border-start-0 bg-light" placeholder="admin@gmail.com" value="{{ old('email') }}" required autofocus>
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label text-secondary small fw-bold">Password</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-key text-muted"></i></span>
                    <input type="password" name="password" class="form-control border-start-0 bg-light" placeholder="••••••••" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold rounded-pill shadow-sm">Login to Dashboard</button>
        </form>
        <div class="text-center mt-4">
            <a href="/" class="text-decoration-none small text-secondary"><i class="bi bi-arrow-left"></i> Kembali ke Website</a>
        </div>
    </div>
</div>

</body>
</html>