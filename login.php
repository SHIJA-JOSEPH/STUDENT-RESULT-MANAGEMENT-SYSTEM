<?php
require_once 'config.php';

$message = '';
$message_type = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = sanitize($_POST['username']);
    $password = $_POST['password'];
    
    if (empty($username) || empty($password)) {
        $message = "Username and password are required";
        $message_type = 'error';
    } else {
        // MD5 hash of password for demo (in production, use password_hash and password_verify)
        $password_hash = md5($password);
        
        $sql = "SELECT id, username FROM admin WHERE username = '$username' AND password = '$password_hash'";
        $result = $conn->query($sql);
        
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $_SESSION['admin_id'] = $row['id'];
            $_SESSION['admin_username'] = $row['username'];
            header("Location: admin.php");
            exit();
        } else {
            $message = "Invalid username or password";
            $message_type = 'error';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Secondary School System</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Secondary School Registration System</h1>
        </header>

        <main>
            <div class="login-container">
                <h2>Admin Login</h2>
                
                <?php if (!empty($message)): ?>
                    <div class="message <?php echo $message_type; ?>">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>

                <div class="login-info">
                    <p><strong>Demo Credentials:</strong></p>
                    <p>Username: <code>admin</code></p>
                    <p>Password: <code>admin123</code></p>
                </div>

                <form method="POST" action="login.php">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" 
                               placeholder="Enter your username" 
                               value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>" 
                               required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" 
                               placeholder="Enter your password" 
                               required>
                    </div>

                    <button type="submit" class="btn btn-primary">Login</button>
                </form>

                <div class="login-footer">
                    <p><a href="index.php">Back to Home</a></p>
                </div>
            </div>
        </main>

        <footer>
            <p>&copy; 2024 Secondary School Registration System. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>
