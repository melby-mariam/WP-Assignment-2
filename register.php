<?php
// Start session if needed
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STUDY MATE - Register</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="auth-container">
        <div class="logo">
            <h1>STUDY MATE</h1>
            <span>Join Our Learning Community</span>
        </div>
        
        <div class="welcome-text">
            Create your account and start your learning journey!
        </div>

        <form action="register_user.php" method="POST">
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required 
                       placeholder="Choose your username">
            </div>

            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required
                       placeholder="Create a strong password">
                <div class="password-requirements">
                    Password should be at least 8 characters long
                </div>
            </div>

            <button type="submit" name="register">Create Account</button>
        </form>

        <div class="auth-link">
            <p>Already have an account? <a href="login.php">Login here</a></p>
        </div>

        <!-- Decorative elements -->
        <div class="study-icons icon-right">🎓</div>
        <div class="study-icons icon-left">📝</div>
    </div>
</body>
</html>
