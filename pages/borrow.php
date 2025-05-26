<?php
include '../config/db_config.php';

// Start the session to access session variables
session_start();

// Check if the user is logged in and has a valid session
if (!isset($_SESSION['user_id'])) {
    // Redirect to login if the user is not logged in
    header("Location: login.php");
    exit();
}

if (isset($_GET['book_id'])) {
    $book_id = $_GET['book_id'];
    $user_id = $_SESSION['user_id']; // Access the user_id from the session

    // Get book details
    $sql = "SELECT * FROM books WHERE id = $book_id";
    $result = $conn->query($sql);
    $book = $result->fetch_assoc();

    // Set due date to 14 days from now
    $due_date = date('Y-m-d H:i:s', strtotime('+14 days'));

    // Borrow the book and update stock
    $stmt = $conn->prepare("INSERT INTO borrowed_books (user_id, book_id, due_date) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $user_id, $book_id, $due_date);

    if ($stmt->execute()) {
        // Update the book stock
        $conn->query("UPDATE books SET stock = stock - 1 WHERE id = $book_id");
        header("Location: catalog.php");
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System - Borrow Book</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Borrow Book</h1>
        <p>Are you sure you want to borrow this book?</p>
        <p><strong>Title:</strong> <?php echo $book['title']; ?></p>
        <p><strong>Author:</strong> <?php echo $book['author']; ?></p>
        <form action="" method="POST">
            <button type="submit">Confirm Borrow</button>
        </form>
    </div>
</body>
</html>
