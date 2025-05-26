<?php
session_start();
include '../includes/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System - Home</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Welcome to the Library Management System</h1>
        <?php if (isset($_SESSION['user_id'])): ?>
            <p>Hello, <?php echo $_SESSION['role']; ?>! You are logged in.</p>
        <?php else: ?>
            <a href="login.php">Login</a> | 
            <a href="register.php">Register</a>
        <?php endif; ?>

        <hr>

        <!-- Web System Details Section -->
        <h2>Web System Details</h2>
        <p><strong>Developed By:</strong> Group 1</p>
        <p><strong>System:</strong> Library Management System</p>
        <p>This Web-Based Library Management System aims to provide a sustainable, user-friendly, and efficient digital library platform for educational institutions.</p> 
        <p>By aligning with SDG 4, the project not only supports quality education but also encourages digital transformation in library services.</p>
        <hr>

        <!-- Member Section -->
        <h3>Members</h3>
        <ul>
            <li>John Steven A. Macapañas</li>
            <li>Leo A. Gabrino</li>
            <li>Cathylyn J. Abaigar</li>
            <li>Charles Glenn D. Avila</li>
            <li>Charles V. Abaigar</li>
        </ul>

        <hr>

        <!-- Course/Year/Section Section -->
        <h3>Course/Year/Section</h3>
        <p><strong>Bachelor of Science in Information Technology 3E</strong></p>

        <hr>

        <!-- Submitted To Section -->
        <h3>Submitted To</h3>
        <p><strong>Mr.Syron Dave Alinso-ot</strong></p>
    </div>
</body>
</html>

<?php
include '../includes/footer.php';
?>
