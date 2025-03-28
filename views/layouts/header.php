<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SplitEasy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/SplitEasy/public/css/style.css">
</head>
<body>
    <?php if (isset($_SESSION['user_id'])): ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">SplitEasy</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php?page=dashboard">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?page=bills">Bills</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?page=archive">Archive</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?page=logout">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <?php endif; ?>
    <div class="container mt-4">
        <!-- Breadcrumb Navigation (Optional Enhancement) -->
        <?php if (isset($_SESSION['user_id']) && isset($_GET['page']) && $_GET['page'] !== 'dashboard'): ?>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php?page=dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <?php echo ucfirst(str_replace('_', ' ', $_GET['page'])); ?>
                    </li>
                </ol>
            </nav>
        <?php endif; ?>