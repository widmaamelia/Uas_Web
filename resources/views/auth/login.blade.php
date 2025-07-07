<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login • SIPUSKA</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Fonts & Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(to right, #e0ecff, #f5f7fa);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            background-color: white;
            border-radius: 1rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            padding: 2.5rem;
            max-width: 420px;
            width: 100%;
        }

        .login-title {
            font-weight: 600;
            color: #1e40af;
            margin-bottom: 1rem;
            text-align: center;
        }

        .form-label {
            font-weight: 500;
        }

        .btn-primary {
            background-color: #1e40af;
            border-color: #1e40af;
            font-weight: 500;
        }

        .btn-primary:hover {
            background-color: #1e3a8a;
        }

        .alert {
            border-radius: 0.5rem;
        }

        .login-logo {
            font-size: 2rem;
            font-weight: bold;
            color: #1e40af;
            text-align: center;
            margin-bottom: 1rem;
        }

    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-logo">
            <i class="bi bi-book"></i> SIPUSKA
        </div>

        <h4 class="login-title">Login </h4>

        @if ($errors->any())
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <i class="bi bi-exclamation-circle-fill me-2"></i>
                <div>{{ $errors->first() }}</div>
            </div>
        @endif


        <form method="POST" action="{{ route('login.submit') }}" autocomplete="off">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input 
                    type="email" 
                    name="email" 
                    class="form-control" 
                    id="email" 
                    placeholder="admin@example.com" 
                    required autofocus>
            </div>

            <div class="mb-4">
                <label for="password" class="form-label">Password</label>
                <input 
                    type="password" 
                    name="password" 
                    class="form-control" 
                    id="password" 
                    placeholder="********" 
                    required>
            </div>

            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-box-arrow-in-right me-1"></i> Login
            </button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
