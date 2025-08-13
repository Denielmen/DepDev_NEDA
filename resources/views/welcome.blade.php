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
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .welcome-container {
            text-align: center;
            padding: 2rem;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            max-width: 600px;
            width: 90%;
        }
        .welcome-title {
            color: #003366;
            margin-bottom: 1.5rem;
        }
        .neda-logo {
            max-width: 150px;
            margin-bottom: 2rem;
        }
        .btn-primary {
            background-color: #003366;
            border-color: #003366;
            padding: 0.5rem 2rem;
            font-weight: 500;
        }
        .btn-primary:hover {
            background-color: #004080;
            border-color: #004080;
        }
    </style>
</head>
<body>
    <div class="welcome-container">
        <img src="/images/neda-logo.png" alt="NEDA Logo" class="neda-logo">
        <h1 class="welcome-title">Welcome to DEPDEV</h1>
        <p class="mb-4">Learning and Development Database System Region VII</p>
        <a href="{{ route('user.training.profile') }}" class="btn btn-primary">
            <i class="bi bi-person-vcard me-2"></i>View Training Profile
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 