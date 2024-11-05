<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STUDY MATE - Login</title>
</head>
<body>
    <h2>Login to STUDY MATE</h2>
    <form action="validate.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br><br>
        <button type="submit" name="login">Login</button>
    </form>
    <br>
    // Link to Registration Page 
    <p>Don't have an account? <a href="register.php">Register here</a></p>
</body>
</html> -->
<?php
// Start session if needed
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STUDY MATE - Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="auth-container">
        <div class="logo">
            <h1>STUDY MATE</h1>
            <span>Your Learning Companion</span>
        </div>
        
        <form action="validate.php" method="POST">
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required 
                       placeholder="Enter your username">
            </div>

            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required
                       placeholder="Enter your password">
            </div>

            <button type="submit" name="login">Sign In</button>
        </form>

        <div class="auth-link">
            <p>Don't have an account? <a href="register.php">Register here</a></p>
        </div>

        <!-- Decorative elements -->
        <div class="study-icons icon-right">✏️</div>
        <div class="study-icons icon-left">📚</div>
    </div>
</body>
</html>