<?php
// admin_home.php
session_start();
require 'config.php';

if (!isset($_SESSION['username']) || $_SESSION['type'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Add new assignment
if (isset($_POST['add'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $due_date = mysqli_real_escape_string($conn, $_POST['due_date']);

    $sql = "INSERT INTO assignments (title, description, due_date, posted_by) VALUES ('$title', '$description', '$due_date', 'admin')";
    mysqli_query($conn, $sql);
    header("Location: admin_home.php");
    exit;
}

// Delete assignment
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $sql = "DELETE FROM assignments WHERE id = $id";
    mysqli_query($conn, $sql);
    header("Location: admin_home.php");
    exit;
}

// Edit assignment
if (isset($_POST['update'])) {
    $id = intval($_POST['id']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $due_date = mysqli_real_escape_string($conn, $_POST['due_date']);

    $sql = "UPDATE assignments SET title='$title', description='$description', due_date='$due_date' WHERE id=$id";
    mysqli_query($conn, $sql);
    header("Location: admin_home.php");
    exit;
}

// Fetch assignment for editing
$edit_assignment = null;
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $result = mysqli_query($conn, "SELECT * FROM assignments WHERE id = $id");
    $edit_assignment = mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - STUDY MATE</title>
</head>
<body>
    <h2>Admin Dashboard</h2>

    <!-- Add New Assignment Form -->
    <form method="POST">
        <h3><?php echo $edit_assignment ? 'Edit Assignment' : 'Add New Assignment'; ?></h3>
        <input type="hidden" name="id" value="<?php echo $edit_assignment['id'] ?? ''; ?>">
        <label for="title">Title:</label>
        <input type="text" name="title" value="<?php echo htmlspecialchars($edit_assignment['title'] ?? ''); ?>" required>
        <br><br>
        <label for="description">Description:</label>
        <textarea name="description" required><?php echo htmlspecialchars($edit_assignment['description'] ?? ''); ?></textarea>
        <br><br>
        <label for="due_date">Due Date:</label>
        <input type="date" name="due_date" value="<?php echo htmlspecialchars($edit_assignment['due_date'] ?? ''); ?>">
        <br><br>
        <button type="submit" name="<?php echo $edit_assignment ? 'update' : 'add'; ?>">
            <?php echo $edit_assignment ? 'Update Assignment' : 'Add Assignment'; ?>
        </button>
        <?php if ($edit_assignment): ?>
            <a href="admin_home.php">Cancel Edit</a>
        <?php endif; ?>
    </form>

    <h3>Existing Assignments</h3>
    <?php
    $result = mysqli_query($conn, "SELECT * FROM assignments ORDER BY due_date ASC");
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div>";
        echo "<h4>" . htmlspecialchars($row['title']) . "</h4>";
        echo "<p>" . htmlspecialchars($row['description']) . "</p>";
        echo "<p>Due Date: " . htmlspecialchars($row['due_date']) . "</p>";
        echo "<a href='admin_home.php?edit=" . $row['id'] . "'>Edit</a> | ";
        echo "<a href='admin_home.php?delete=" . $row['id'] . "' onclick='return confirm(\"Are you sure you want to delete this assignment?\");'>Delete</a>";
        echo "</div><br>";
    }
    ?>

    <a href="logout.php">Logout</a>
</body>
</html>
