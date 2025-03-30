<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SplitEasy - <?php echo ucfirst(isset($_GET['page']) ? str_replace('_', ' ', $_GET['page']) : 'Dashboard'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Add Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/SplitEasy/public/css/style.css">
    <style>
        /* Your existing styles remain unchanged */
        body {
            font-family: 'Roboto', 'Segoe UI', sans-serif;
            background-color: #f5f7fa;
            color: #2c3e50;
            margin: 0;
            padding: 0;
        }
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 70px;
            height: 100vh;
            background-color: #212529;
            padding-top: 20px;
            color: #fff;
            transition: all 0.3s ease;
            z-index: 1000;
        }
        .sidebar .navbar-brand {
            font-size: 1.2rem;
            font-weight: 700;
            color: #fff;
            padding: 20px 0;
            display: block;
            text-align: center;
        }
        .sidebar .nav-link {
            color: #bdc3c7;
            padding: 15px 0;
            font-size: 1.5rem;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: #34495e;
            color: #fff;
        }
        .content {
            margin-left: 70px;
            padding: 30px;
            min-height: 100vh;
        }
        .breadcrumb {
            background-color: #fff;
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <?php if (isset($_SESSION['user_id'])): ?>
        <!-- Sidebar -->
        <div class="sidebar">
            <a class="navbar-brand" href="index.php?page=dashboard">
                <i class="bi bi-wallet"></i> <!-- Replaced fa-wallet -->
            </a>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link <?php echo ($_GET['page'] === 'dashboard' || !isset($_GET['page'])) ? 'active' : ''; ?>" href="index.php?page=dashboard" title="Dashboard">
                        <i class="bi bi-speedometer2"></i> <!-- Replaced fa-gauge -->
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($_GET['page'] === 'bills') ? 'active' : ''; ?>" href="index.php?page=bills" title="Bills">
                        <i class="bi bi-receipt"></i> <!-- Replaced fa-file-invoice-dollar -->
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($_GET['page'] === 'archive') ? 'active' : ''; ?>" href="index.php?page=archive" title="Archive">
                        <i class="bi bi-archive"></i> <!-- Replaced fa-archive -->
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=logout" title="Logout">
                        <i class="bi bi-box-arrow-right"></i> <!-- Replaced fa-sign-out-alt -->
                    </a>
                </li>
            </ul>
        </div>
    <?php endif; ?>

    <!-- Main Content Area -->
    <div class="content">
        <?php if (isset($_SESSION['user_id']) && isset($_GET['page']) && $_GET['page'] !== 'dashboard'): ?>
            <!-- Breadcrumb Navigation -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php?page=dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <?php echo ucfirst(str_replace('_', ' ', $_GET['page'])); ?>
                    </li>
                </ol>
            </nav>
        <?php endif; ?>