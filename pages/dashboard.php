<?php
session_start();
include '../includes/header.php';
include '../config/db_config.php';

if ($_SESSION['role'] !== 'admin') {
    header("Location: home.php");
    exit;
}

// Handle Add Book
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_book'])) {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $isbn = $_POST['isbn'];
    $genre = $_POST['genre'];  // Get Genre
    $stock = $_POST['stock'];  // Get Stock
    $sql = "INSERT INTO books (title, author, isbn, genre, stock) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $title, $author, $isbn, $genre, $stock);
    $stmt->execute();
    $stmt->close();
    header("Location: dashboard.php");
    exit;
}

// Handle Delete Book
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    // Admin can delete books even if they are borrowed
    $conn->query("DELETE FROM books WHERE id = $id");
    header("Location: dashboard.php");
    exit;
}

// Handle Update Book
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_book'])) {
    $id = intval($_POST['id']);
    $title = $_POST['title'];
    $author = $_POST['author'];
    $isbn = $_POST['isbn'];
    $genre = $_POST['genre'];  // Get Genre for update
    $stock = $_POST['stock'];  // Get Stock for update
    $sql = "UPDATE books SET title = ?, author = ?, isbn = ?, genre = ?, stock = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssii", $title, $author, $isbn, $genre, $stock, $id);
    $stmt->execute();
    $stmt->close();
    header("Location: dashboard.php");
    exit;
}

// Get Stats
$books_result = $conn->query("SELECT COUNT(*) AS total_books FROM books");
$books = $books_result->fetch_assoc();

$borrowed_books_result = $conn->query("SELECT COUNT(*) AS total_borrowed_books FROM borrowed_books WHERE return_date IS NULL");
$borrowed_books = $borrowed_books_result->fetch_assoc();

$all_books = $conn->query("SELECT * FROM books");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <style>
        h1, h2, h3 { margin-bottom: 15px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table th, table td { padding: 12px; border: 1px solid #ccc; text-align: left; }
        table th { background-color: #f0f0f0; }
        form.inline-form input[type="text"] {
            width: 150px;
            margin-right: 5px;
        }
        form.inline-form button {
            padding: 6px 10px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        form.inline-form button:hover {
            background-color: #555;
        }
        .delete-link {
            color: red;
            margin-left: 10px;
        }
        .add-book-form input[type="text"] {
            width: 30%;
            padding: 10px;
            margin-right: 10px;
        }
        .add-book-form input[type="number"] {
            width: 20%;
            padding: 10px;
            margin-right: 10px;
        }
        .add-book-form button {
            padding: 10px 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>📊 Admin Dashboard</h1>
    <p><strong>Total Books:</strong> <?php echo $books['total_books']; ?></p>
    <p><strong>Total Borrowed Books:</strong> <?php echo $borrowed_books['total_borrowed_books']; ?></p>

    <hr>
    <h2>📚 Add New Book</h2>
    <form method="POST" class="add-book-form">
        <input type="text" name="title" placeholder="Book Title" required>
        <input type="text" name="author" placeholder="Author" required>
        <input type="text" name="isbn" placeholder="ISBN" required>
        <input type="text" name="genre" placeholder="Genre" required> <!-- Genre input -->
        <input type="number" name="stock" placeholder="Stock" required> <!-- Stock input -->
        <button type="submit" name="add_book">Add Book</button>
    </form>

    <hr>
    <h2>📝 Manage Books</h2>
    <table>
        <tr>
            <th>ID</th><th>Title</th><th>Author</th><th>ISBN</th><th>Genre</th><th>Stock</th><th>Actions</th>
        </tr>
        <?php while ($book = $all_books->fetch_assoc()) { ?>
            <tr>
                <td><?= $book['id'] ?></td>
                <td><?= htmlspecialchars($book['title']) ?></td>
                <td><?= htmlspecialchars($book['author']) ?></td>
                <td><?= htmlspecialchars($book['isbn']) ?></td>
                <td><?= htmlspecialchars($book['genre']) ?></td> <!-- Genre Column -->
                <td><?= htmlspecialchars($book['stock']) ?></td> <!-- Stock Column -->
                <td>
                    <form method="POST" class="inline-form" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $book['id'] ?>">
                        <input type="text" name="title" value="<?= htmlspecialchars($book['title']) ?>" required>
                        <input type="text" name="author" value="<?= htmlspecialchars($book['author']) ?>" required>
                        <input type="text" name="isbn" value="<?= htmlspecialchars($book['isbn']) ?>" required>
                        <input type="text" name="genre" value="<?= htmlspecialchars($book['genre']) ?>" required> <!-- Genre input for update -->
                        <input type="number" name="stock" value="<?= htmlspecialchars($book['stock']) ?>" required> <!-- Stock input for update -->
                        <button type="submit" name="update_book">Update</button>
                    </form>
                    <a href="?delete=<?= $book['id'] ?>" class="delete-link" onclick="return confirm('Are you sure you want to delete this book?')">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>
</body>
</html>

<?php include '../includes/footer.php'; ?>
<?php
