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

// Fetch assignment for display based on select
$selected_assignment = null;
if (isset($_GET['select'])) {
    $id = intval($_GET['select']);
    $result = mysqli_query($conn, "SELECT * FROM assignments WHERE id = $id");
    $selected_assignment = mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - STUDY MATE</title>
    <link rel="stylesheet" href="home.css">
</head>
<body>
    <div class="container">
        <h2>Admin Dashboard</h2>

        <!-- Add/Edit Assignment Form -->
        <form method="POST" class="assignment-form">
            <h3><?php echo $edit_assignment ? 'Edit Assignment' : 'Add New Assignment'; ?></h3>
            <input type="hidden" name="id" value="<?php echo $edit_assignment['id'] ?? ''; ?>">

            <label for="title">Title:</label>
            <input type="text" name="title" value="<?php echo htmlspecialchars($edit_assignment['title'] ?? ''); ?>" required>

            <label for="description">Description:</label>
            <textarea name="description" required><?php echo htmlspecialchars($edit_assignment['description'] ?? ''); ?></textarea>

            <label for="due_date">Due Date:</label>
            <input type="date" name="due_date" value="<?php echo htmlspecialchars($edit_assignment['due_date'] ?? ''); ?>">

            <button type="submit" name="<?php echo $edit_assignment ? 'update' : 'add'; ?>" class="form-button">
                <?php echo $edit_assignment ? 'Update Assignment' : 'Add Assignment'; ?>
            </button>
            <?php if ($edit_assignment): ?>
                <a href="admin_home.php" class="cancel-button">Cancel Edit</a>
            <?php endif; ?>
        </form>

        <h3>Existing Assignments</h3>

        <?php
        $result = mysqli_query($conn, "SELECT * FROM assignments ORDER BY due_date ASC");
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='assignment'>";
            echo "<h4>" . htmlspecialchars($row['title']) . "</h4>";
            echo "<p>" . htmlspecialchars($row['description']) . "</p>";
            echo "<p class='due-date'>Due Date: " . htmlspecialchars($row['due_date']) . "</p>";
            echo "<a href='admin_home.php?edit=" . $row['id'] . "' class='edit-link'>Edit</a> | ";
            echo "<a href='admin_home.php?delete=" . $row['id'] . "' class='delete-link' onclick='return confirm(\"Are you sure you want to delete this assignment?\");'>Delete</a> | ";
            echo "<a href='admin_home.php?select=" . $row['id'] . "' class='select-link'>Select</a>";
            echo "</div>";
        }
        ?>

        <!-- Display selected assignment details -->
        <?php if ($selected_assignment): ?>
            <h3>Selected Assignment Details</h3>
            <table border="1" cellpadding="10">
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Due Date</th>
                    <th>Posted By</th>
                </tr>
                <tr>
                    <td><?php echo htmlspecialchars($selected_assignment['id']); ?></td>
                    <td><?php echo htmlspecialchars($selected_assignment['title']); ?></td>
                    <td><?php echo htmlspecialchars($selected_assignment['description']); ?></td>
                    <td><?php echo htmlspecialchars($selected_assignment['due_date']); ?></td>
                    <td><?php echo htmlspecialchars($selected_assignment['posted_by']); ?></td>
                </tr>
            </table>
        <?php endif; ?>

        <a href="logout.php" class="logout-button">Logout</a>
    </div>
</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
