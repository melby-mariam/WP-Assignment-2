<?php
// student_home.php
session_start();
require 'config.php';

if (!isset($_SESSION['username']) || $_SESSION['type'] !== 'student') {
    header("Location: login.php");
    exit;
}

// Fetch assignments
$query = "SELECT * FROM assignments ORDER BY due_date ASC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard - STUDY MATE</title>
    <link rel="stylesheet" href="home.css">
</head>
<body>
    <div class="container">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></h2>
        <p>Here are your tasks and assignments:</p>

        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='assignment'>";
                echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
                echo "<p>" . htmlspecialchars($row['description']) . "</p>";
                if (!empty($row['due_date'])) {
                    echo "<p class='due-date'>Due Date: " . htmlspecialchars($row['due_date']) . "</p>";
                }
                echo "</div>";
            }
        } else {
            echo "<p class='no-assignments'>No assignments available at the moment.</p>";
        }
        ?>

        <a href="logout.php" class="logout-button">Logout</a>
    </div>
</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
