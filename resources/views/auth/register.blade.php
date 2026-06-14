<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Konser Ticket</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #07070a, #3f0071, #0066ff);
            padding: 20px 0;
        }

        .register-box {
            width: 500px;
            padding: 40px;
            border-radius: 35px;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            box-shadow: 0 0 40px #7b2cff;
            color: white;
        }

        .input-group {
            margin-bottom: 15px;
            background: #1c1c1c;
            padding: 10px;
            border-radius: 20px;
        }

        .input-group-text {
            background: none;
            border: none;
            color: #00aaff;
        }

        .form-control, .form-select {
            background: none;
            border: none;
            color: white;
        }

        .form-control:focus, .form-select:focus {
            background: none;
            box-shadow: none;
            color: white;
        }

        .form-control::placeholder { color: #aaa; }

        /* Dropdown role */
        .form-select option {
            background: #1c1c1c;
            color: white;
        }

        /* Role cards */
        .role-selection {
            display: flex;
            gap: 12px;
            margin-bottom: 15px;
        }

        .role-card {
            flex: 1;
            border: 2px solid rgba(123, 44, 255, 0.3);
            border-radius: 16px;
            padding: 14px 10px;
            cursor: pointer;
            text-align: center;
            transition: all 0.3s;
            background: rgba(28, 28, 28, 0.8);
        }

        .role-card:hover {
            border-color: #7b2cff;
            background: rgba(123, 44, 255, 0.15);
        }

        .role-card.selected-admin {
            border-color: #f59e0b;
            background: rgba(245, 158, 11, 0.15);
            box-shadow: 0 0 15px rgba(245, 158, 11, 0.3);
        }

        .role-card.selected-user {
            border-color: #7b2cff;
            background: rgba(123, 44, 255, 0.2);
            box-shadow: 0 0 15px rgba(123, 44, 255, 0.4);
        }

        .role-card .role-icon {
            font-size: 1.8rem;
            margin-bottom: 6px;
        }

        .role-card .role-title {
            font-weight: 700;
            font-size: 0.9rem;
            margin-bottom: 4px;
        }

        .role-card .role-desc {
            font-size: 0.72rem;
            color: #aaa;
            line-height: 1.4;
        }

        .role-card.selected-admin .role-title { color: #f59e0b; }
        .role-card.selected-user  .role-title { color: #a78bfa; }

        .role-label {
            font-size: 0.8rem;
            color: #aaa;
            margin-bottom: 8px;
        }

        /* Hidden radio */
        input[name="role"] { display: none; }

        .btn-register {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 25px;
            background: linear-gradient(90deg, #7b2cff, #0066ff);
            color: white;
            font-weight: bold;
            transition: 0.3s;
            margin-top: 5px;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 0 20px #7b2cff;
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
        }

        .login-link a {
            color: #00aaff;
            text-decoration: none;
            font-weight: bold;
        }

        .login-link a:hover { color: #66ccff; }
        .alert { border-radius: 15px; }
    </style>
</head>

<body>
<div class="register-box">

    <h1 class="text-center mb-4">🎵 REGISTER</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('register.process') }}" method="POST" id="registerForm">
        @csrf

        {{-- Nama --}}
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-person"></i></span>
            <input type="text" name="name" class="form-control"
                   placeholder="Nama Lengkap"
                   value="{{ old('name') }}" required>
        </div>

        {{-- Email --}}
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
            <input type="email" name="email" class="form-control"
                   placeholder="Email"
                   value="{{ old('email') }}" required>
        </div>

        {{-- Password --}}
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-lock"></i></span>
            <input type="password" name="password" class="form-control"
                   placeholder="Password" required>
        </div>

        {{-- Konfirmasi Password --}}
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
            <input type="password" name="password_confirmation" class="form-control"
                   placeholder="Konfirmasi Password" required>
        </div>

        {{-- ===== PILIHAN ROLE ===== --}}
        <p class="role-label"><i class="bi bi-person-badge me-1"></i> Daftar sebagai:</p>

        {{-- Hidden input role (diisi JS) --}}
        <input type="radio" name="role" value="user"
               id="roleUser" {{ old('role', 'user') == 'user' ? 'checked' : '' }}>
        <input type="radio" name="role" value="admin"
               id="roleAdmin" {{ old('role') == 'admin' ? 'checked' : '' }}>

        <div class="role-selection">

            {{-- Card USER --}}
            <div class="role-card {{ old('role', 'user') == 'user' ? 'selected-user' : '' }}"
                 id="cardUser" onclick="selectRole('user')">
                <div class="role-icon">👤</div>
                <div class="role-title">User</div>
                <div class="role-desc">Melihat & membeli tiket konser</div>
            </div>

            {{-- Card ADMIN --}}
            <div class="role-card {{ old('role') == 'admin' ? 'selected-admin' : '' }}"
                 id="cardAdmin" onclick="selectRole('admin')">
                <div class="role-icon">🛡️</div>
                <div class="role-title">Admin</div>
                <div class="role-desc">Mengelola event, tiket & transaksi</div>
            </div>

        </div>

        @error('role')
            <div class="text-danger small mb-2 ms-2">{{ $message }}</div>
        @enderror

        <button type="submit" class="btn-register">
            <i class="bi bi-person-plus-fill"></i> DAFTAR
        </button>
    </form>

    <div class="login-link">
        Sudah punya akun? <a href="{{ route('login') }}">Login</a>
    </div>

</div>

<script>
function selectRole(role) {
    // Reset semua card
    document.getElementById('cardUser').classList.remove('selected-user');
    document.getElementById('cardAdmin').classList.remove('selected-admin');

    if (role === 'user') {
        document.getElementById('roleUser').checked = true;
        document.getElementById('cardUser').classList.add('selected-user');
    } else {
        document.getElementById('roleAdmin').checked = true;
        document.getElementById('cardAdmin').classList.add('selected-admin');
    }
}
</script>
</body>
</html>