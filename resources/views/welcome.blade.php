<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Welcome &mdash; Laravel - Stisla</title>

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">

    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f9f9f9;
            color: #333;
        }
        .header {
            background: linear-gradient(45deg, #6c63ff, #3f3da1);
            color: white;
            text-align: center;
            padding: 80px 20px;
        }
        .header h1 {
            font-size: 3.5rem;
            font-weight: bold;
        }
        .header p {
            font-size: 1.2rem;
        }
        .btn-custom {
            background: #3f3da1;
            color: white;
            padding: 10px 30px;
            font-size: 1.2rem;
            border-radius: 50px;
            transition: all 0.3s ease;
        }
        .btn-custom:hover {
            background: #2b2a82;
            transform: scale(1.1);
        }
        .features-section .card {
            border: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        .features-section .card:hover {
            transform: translateY(-10px);
        }
        .contributors-section {
            background: #ffffff;
            padding: 60px 20px;
        }
        .contributors-section h2 {
            font-size: 2.5rem;
            margin-bottom: 30px;
        }
        .contributor-card {
            margin: 20px 0;
            transition: transform 0.3s ease;
        }
        .contributor-card:hover {
            transform: scale(1.1);
        }
        .contributor-card img {
            border: 3px solid #f0f0f0;
            border-radius: 50%;
            transition: box-shadow 0.3s ease;
        }
        .contributor-card img:hover {
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        footer {
            background: linear-gradient(45deg, #3f3da1, #6c63ff);
            color: white;
            text-align: center;
            padding: 20px 10px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">        <a href="{{ route('login') }}" class="btn btn-custom animate__animated animate__zoomIn">Get Started</a>
    </div>

    <!-- Features Section -->
    <div class="container my-5 features-section">
        <h2 class="text-center mb-4" data-aos="fade-up">Features</h2>
        <div class="row">
            <div class="col-md-4" data-aos="zoom-in">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Laravel 11</h5>
                        <p class="card-text">Explore the latest features and improvements in Laravel 11.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4" data-aos="zoom-in" data-aos-delay="100">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Stisla Bootstrap 5 Template</h5>
                        <p class="card-text">Leverage the modern and responsive design of Stisla.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4" data-aos="zoom-in" data-aos-delay="200">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Laravel Breeze Authentication</h5>
                        <p class="card-text">Quick and easy authentication setup with Laravel Breeze.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Footer -->
    <footer>
        <p>&copy; {{ date('Y') }} Laravel 11 with Stisla Template. All Rights Reserved.</p>    </footer>

    <!-- JS Libraries -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>
</html>
