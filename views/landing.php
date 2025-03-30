<?php
// ../views/landing.php
session_start(); // Ensure session is started for checking login status
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SplitEasy - Simplify Bill Splitting</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/SplitEasy/public/css/style.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            color: #333;
            line-height: 1.6;
        }
        .hero-section {
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: white;
            padding: 120px 0;
            text-align: center;
        }
        .hero-section h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        .hero-section p {
            font-size: 1.25rem;
            max-width: 600px;
            margin: 0 auto 2rem;
        }
        .feature-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none;
            background: #fff;
            padding: 20px;
        }
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        .btn-custom {
            padding: 12px 30px;
            font-size: 1.1rem;
            border-radius: 50px;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }
        .btn-custom:hover {
            background-color: #0056b3;
        }
        .cta-section {
            background: #fff;
            padding: 60px 0;
        }
        footer {
            background-color: #212529;
            padding: 40px 0;
            color: #adb5bd;
        }
        footer a {
            color: #fff;
            text-decoration: none;
        }
        footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php?page=landing">SplitEasy</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=login">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=register">Register</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <h1>Split Bills Effortlessly</h1>
            <p>Simplify expense sharing with friends, family, or roommates—no more awkward calculations.</p>
            <div>
            <a href="index.php?page=register" class="btn btn-light btn-custom me-3">Get Started</a>
            <a href="#features" class="btn btn-outline-light btn-custom">Learn More</a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-5">
        <div class="container">
            <h2 class="text-center mb-5 fw-bold">Why SplitEasy?</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card feature-card shadow-sm h-100">
                        <div class="card-body text-center">
                            <h5 class="card-title fw-bold">Effortless Splitting</h5>
                            <p class="card-text">Divide bills equally or customize amounts in seconds.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card shadow-sm h-100">
                        <div class="card-body text-center">
                            <h5 class="card-title fw-bold">Invite Anyone</h5>
                            <p class="card-text">Share with friends or guests using unique invite codes.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card shadow-sm h-100">
                        <div class="card-body text-center">
                            <h5 class="card-title fw-bold">Stay Organized</h5>
                            <p class="card-text">Track all your bills and expenses in one place.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="cta-section text-center">
        <div class="container">
            <h2 class="fw-bold mb-4">Ready to Get Started?</h2>
            <p class="lead mb-4">Join thousands managing their shared costs with ease.</p>
            <a href="index.php?page=register" class="btn btn-primary btn-custom me-3">Sign Up Now</a>
        </div>
    </section>

   

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>