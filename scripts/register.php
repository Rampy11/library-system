<?php
include '../config/db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect username and password from the form
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);  // Hash the password for security

    // Assign role based on the username
    if ($username === 'administrator') {
        $role = 'admin';  // Hardcode role to admin for this username
    } else {
        $role = 'user';   // Default role for all other users
    }

    // Prepare and execute the SQL query to insert the new user
    $sql = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $password, $role);

    // Check if insertion was successful
    if ($stmt->execute()) {
        // Redirect to login page after successful registration
        header("Location: ../pages/login.php");
        exit;
    } else {
        // Handle errors if the query fails
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}
?>
