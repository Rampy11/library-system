<?php
include '../includes/header.php';
include '../config/db_config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    header("Location: ../login.php");
    exit;
}

$message = "";

// Handle returning a book
if (isset($_GET['return_book_id'])) {
    $book_id = intval($_GET['return_book_id']);

    $checkStmt = $conn->prepare("SELECT id FROM borrowed_books WHERE book_id = ? AND user_id = ? AND return_date IS NULL");
    $checkStmt->bind_param("ii", $book_id, $user_id);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        $checkStmt->bind_result($borrow_id);
        $checkStmt->fetch();
        $checkStmt->close();

        $updateStmt = $conn->prepare("UPDATE borrowed_books SET return_date = NOW() WHERE id = ?");
        $updateStmt->bind_param("i", $borrow_id);
        $updateStmt->execute();
        $updateStmt->close();

        $updateStock = $conn->prepare("UPDATE books SET stock = stock + 1 WHERE id = ?");
        $updateStock->bind_param("i", $book_id);
        $updateStock->execute();
        $updateStock->close();

        $message = "Book returned successfully.";
    } else {
        $message = "You didn’t borrow this book.";
    }
}

// Search logic
$search = $_GET['search'] ?? '';
$searchTerm = '%' . $conn->real_escape_string($search) . '%';

$query = "SELECT * FROM books WHERE (title LIKE ? OR author LIKE ? OR genre LIKE ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Library Catalog</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Library Catalog</h1>

        <?php if (!empty($message)): ?>
            <div class="message"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <form method="GET" action="catalog.php">
            <input type="text" name="search" placeholder="Search books..." value="<?= htmlspecialchars($search) ?>">
            <button type="submit">Search</button>
        </form>

        <?php if ($result && $result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Genre</th>
                        <th>Stock</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($book = $result->fetch_assoc()):
                        $book_id = intval($book['id']);
                    ?>
                        <tr>
                            <td><?= htmlspecialchars($book['title']) ?></td>
                            <td><?= htmlspecialchars($book['author']) ?></td>
                            <td><?= htmlspecialchars($book['genre']) ?></td>
                            <td><?= intval($book['stock']) ?></td>
                            <td>
                                <?php if ($book['stock'] > 0): ?>
                                    <a href="borrow.php?book_id=<?= $book_id ?>">Borrow</a>
                                <?php else: ?>
                                    <span>Out of stock</span>
                                <?php endif; ?>
                                |
                                <a href="catalog.php?return_book_id=<?= $book_id ?>">Return</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No books found.</p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php include '../includes/footer.php'; ?>
