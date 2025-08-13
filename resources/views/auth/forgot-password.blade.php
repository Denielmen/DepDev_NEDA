<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>lnd.dro7.depdev</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        .login-container {
            display: flex;
            min-height: 100vh;
        }

        .left-panel {
            width: 40%;
            background-color: #003366;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem;
        }

        .left-panel h1 {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }

        .left-panel p {
            font-size: 0.9rem;
            margin-bottom: 2rem;
            text-align: center;
        }

        .left-panel form {
            width: 100%;
            max-width: 400px;
        }

        .left-panel .form-control {
            margin-bottom: 1rem;
            border-radius: 5px;
        }

        .left-panel .btn-primary {
            background-color: #004080;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            width: 100%;
        }

        .left-panel .btn-primary:hover {
            background-color: #0059b3;
        }

        .left-panel .btn-secondary {
            background-color: #6c757d;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            width: 100%;
            margin-top: 0.5rem;
        }

        .left-panel .btn-secondary:hover {
            background-color: #5a6268;
        }

        .right-panel {
            width: 60%;
            background-image: url('{{ asset('images/neda-building.jpg') }}');
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .right-panel .overlay {
            position: absolute;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.15);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
            padding: 2rem;
        }

        .right-panel .overlay h2 {
            font-size: 1.5rem;
            font-weight: bold;
            color:rgb(255, 255, 255);
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
            letter-spacing: 0.8px;
        }

        .right-panel .overlay h3 {
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 0.9rem;
            color: #ffffff;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
            letter-spacing: 0.5px;
        }

        .right-panel .overlay p {
            font-size: 0.8rem;
        }

        .depdev-logo {
            width: 150px;
            max-width: 90%;
            padding: 1rem;
            filter: brightness(1.9);
        }

        .alert {
            margin-bottom: 1rem;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <!-- Left Panel -->
        <div class="left-panel">
            <h1>Forgot Password</h1>
            <p>Enter your email address and we'll send you a link to reset your password.</p>
            
            <!-- Session Status -->
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary">Send Password Reset Link</button>
                
                <!-- Back to Login -->
                <a href="{{ route('login') }}" class="btn btn-secondary">Back to Login</a>
            </form>
        </div>

        <!-- Right Panel -->
        <div class="right-panel">
            <div class="overlay">
                <div style="display: flex; justify-content: center; align-items: center; gap: 10rem;">
                    <img src="{{ asset('images/DEPDev_logo.png') }}" alt="DEPDEV Logo" class="depdev-logo" style="width: 120px; max-width: 45%; padding:1rem;">
                    <img src="{{ asset('images/repub.png') }}" alt="Republic Logo" class="repub-logo" style="width: 120px; max-width: 45%;padding: 1rem;">
                </div>
                <h3>REPUBLIC OF THE PHILIPPINES</h3>
                <h2>DEPARTMENT OF ECONOMY, PLANNING, AND DEVELOPMENT</h2>
                <h2>CENTRAL VISAYAS REGION</h2>
            </div>
        </div>
    </div>
</body>

</html>
