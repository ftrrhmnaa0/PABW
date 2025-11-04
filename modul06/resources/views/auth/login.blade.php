<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Peukan Rumoh</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: #f0f0f0;
        }

        .container {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            height: 100vh;
            padding-left: 7%;
            background-image: url('/images/loginBackground.jpg');
            background-size: cover;
            background-position: center;
            overflow: hidden;
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            background-color: #ffffff;
            padding: 2rem;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 8px;
        }

        .login-header {
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .login-form label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
        }

        .login-form input[type="email"],
        .login-form input[type="password"] {
            width: 100%;
            padding: 0.75rem;
            margin-bottom: 1.2rem;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .login-form button {
            width: 100%;
            padding: 0.75rem;
            background-color: #1e90ff;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .login-form button:hover {
            background-color: #0f6dc2;
        }

        .register-link {
            margin-top: 1rem;
            text-align: center;
        }

        .alert-error {
            color: red;
            background-color: #ffe0e0;
            border: 1px solid red;
            padding: 0.75rem;
            margin-bottom: 1rem;
            border-radius: 4px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="login-container">
            <div class="login-header">
                <h1>Login</h1>
            </div>

            <div class="login-form">
                @if ($errors->any())
                    <div class="alert-error">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <label for="email">Email:</label>
                    <input id="email" type="email" name="email" placeholder="Masukkan email Anda" required autofocus>

                    <label for="password">Password:</label>
                    <input id="password" type="password" name="password" placeholder="Masukkan password Anda" required>

                    <button type="submit">Login</button>

                    <div class="register-link">
                        <p>Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
