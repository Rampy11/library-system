<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Get current page name to control visibility
$currentPage = basename($_SERVER['PHP_SELF']);
$hideCatalogOnPages = ['login.php', 'register.php', 'home.php']; // Don't show catalog on these pages
$isLoggedIn = isset($_SESSION['user_id']);
$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';  // Check if user is an admin
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="../pages/home.php">Home</a></li>

                <!-- Show catalog only if logged in and not on excluded pages -->
                <?php if ($isLoggedIn || !in_array($currentPage, $hideCatalogOnPages)): ?>
                    <li><a href="../pages/catalog.php">Catalog</a></li>
                <?php endif; ?>

                <!-- Show Dashboard link only if logged in and the user is an admin -->
                <?php if ($isAdmin): ?>
                    <li><a href="../pages/dashboard.php">Dashboard</a></li>
                <?php endif; ?>

                <!-- Show login if user is not logged in, otherwise show logout -->
                <?php if ($isLoggedIn): ?>
                    <li><a href="../pages/logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="../pages/login.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
