<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Login - IELTS Mock Test by UKG</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>body{background:linear-gradient(135deg,#003366,#0066cc);min-height:100vh;display:flex;align-items:center;justify-content:center}.login-card{max-width:420px;width:100%;border-radius:16px;box-shadow:0 20px 60px rgba(0,0,0,.3)}.login-header{background:#f8f9fa;border-radius:16px 16px 0 0;padding:2rem;text-align:center}.login-header img{height:72px;margin-bottom:12px;border-radius:8px}</style>
</head>
<body>
<div class="card login-card">
    <div class="login-header"><img src="{{ asset('images/logo.png') }}" alt="UKG"><h4 class="mb-0 text-dark">IELTS Mock Test by UKG</h4><small class="text-muted">Computer-Based Practice Platform</small></div>
    <div class="card-body p-4">
        @if($errors->any())<div class="alert alert-danger py-2">{{ $errors->first() }}</div>@endif
        <form method="POST" action="{{ route('login') }}">@csrf
            <div class="mb-3"><label class="form-label fw-semibold">User ID</label><input type="text" name="user_id" class="form-control form-control-lg" value="{{ old('user_id') }}" required autofocus></div>
            <div class="mb-4"><label class="form-label fw-semibold">Password</label><input type="password" name="password" class="form-control form-control-lg" required></div>
            <button type="submit" class="btn btn-primary btn-lg w-100" style="background:#003366;border:none;">Sign In</button>
        </form>
    </div>
</div>
</body></html>