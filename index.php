<?php
require_once 'config.php';

// Get statistics
$stats_sql = "SELECT COUNT(*) as total_students, COUNT(CASE WHEN fees_status = 'Paid' THEN 1 END) as fees_paid FROM students";
$stats_result = $conn->query($stats_sql);
$stats = $stats_result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secondary School Student Registration System</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Secondary School Student Registration System</h1>
            <nav>
                <a href="register.php">Register Student</a>
                <a href="login.php">Admin Login</a>
            </nav>
        </header>

        <main>
            <section class="hero">
                <h2>Welcome to our Student Registration System</h2>
                <p>A secure and efficient platform for managing student information and school fees</p>
            </section>

            <section class="features">
                <h2>System Features</h2>
                <div class="feature-grid">
                    <div class="feature-card">
                        <h3>📝 Easy Registration</h3>
                        <p>Register new students with comprehensive information including personal details, class, stream, and fee status.</p>
                    </div>
                    <div class="feature-card">
                        <h3>🔒 Secure Storage</h3>
                        <p>All student information is safely stored in a secure database with proper access controls.</p>
                    </div>
                    <div class="feature-card">
                        <h3>👨‍💼 Admin Dashboard</h3>
                        <p>Administrators can view all student details, search, filter, and manage records efficiently.</p>
                    </div>
                    <div class="feature-card">
                        <h3>💰 Fee Management</h3>
                        <p>Track school fees, amount paid, and outstanding balances for each student.</p>
                    </div>
                </div>
            </section>

            <section class="system-stats">
                <h2>System Statistics</h2>
                <div class="stats-grid">
                    <div class="stat-box">
                        <p class="stat-label">Total Students</p>
                        <p class="stat-value"><?php echo $stats['total_students']; ?></p>
                    </div>
                    <div class="stat-box">
                        <p class="stat-label">Fees Paid</p>
                        <p class="stat-value"><?php echo $stats['fees_paid']; ?></p>
                    </div>
                </div>
            </section>

            <section class="quick-actions">
                <h2>Quick Actions</h2>
                <div class="action-buttons">
                    <a href="register.php" class="btn btn-primary">Register New Student</a>
                    <a href="login.php" class="btn btn-secondary">Admin Login</a>
                </div>
            </section>

            <section class="information">
                <h2>Student Information Collected</h2>
                <p>The system securely stores the following information for each student:</p>
                <ul>
                    <li><strong>Admission Number:</strong> Unique identifier for each student</li>
                    <li><strong>Student Name:</strong> Full name of the student</li>
                    <li><strong>Class:</strong> Current class level (Form 1-4)</li>
                    <li><strong>Stream:</strong> Science, Arts, or Commercial</li>
                    <li><strong>Region & District:</strong> Geographic location information</li>
                    <li><strong>Parent/Guardian Details:</strong> Name and contact information</li>
                    <li><strong>School Fees:</strong> Total fees and amount paid tracking</li>
                </ul>
            </section>
        </main>

        <footer>
            <p>&copy; 2024 Secondary School Registration System. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>
