<?php
require_once 'config.php';
requireAdmin();

if (!isset($_GET['id'])) {
    header("Location: admin.php");
    exit();
}

$student_id = intval($_GET['id']);
$sql = "SELECT * FROM students WHERE id = $student_id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    header("Location: admin.php");
    exit();
}

$student = $result->fetch_assoc();
$balance = $student['school_fees'] - $student['school_fees_paid'];
$percentage_paid = ($student['school_fees'] > 0) ? ($student['school_fees_paid'] / $student['school_fees']) * 100 : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Details - Secondary School System</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Secondary School Registration System - Student Details</h1>
            <nav>
                <span>Welcome, <?php echo htmlspecialchars($_SESSION['admin_username']); ?></span>
                <a href="admin.php">Back to Dashboard</a>
                <a href="logout.php">Logout</a>
            </nav>
        </header>

        <main>
            <div class="student-details">
                <h2>Student Information</h2>
                
                <div class="details-section">
                    <h3>Personal Information</h3>
                    <div class="details-grid">
                        <div class="detail-item">
                            <label>Admission Number:</label>
                            <p><?php echo htmlspecialchars($student['admission_number']); ?></p>
                        </div>
                        <div class="detail-item">
                            <label>Student Name:</label>
                            <p><?php echo htmlspecialchars($student['student_name']); ?></p>
                        </div>
                        <div class="detail-item">
                            <label>Class:</label>
                            <p><?php echo htmlspecialchars($student['class']); ?></p>
                        </div>
                        <div class="detail-item">
                            <label>Stream:</label>
                            <p><?php echo htmlspecialchars($student['stream']); ?></p>
                        </div>
                        <div class="detail-item">
                            <label>Region:</label>
                            <p><?php echo htmlspecialchars($student['region']); ?></p>
                        </div>
                        <div class="detail-item">
                            <label>District:</label>
                            <p><?php echo htmlspecialchars($student['district']); ?></p>
                        </div>
                    </div>
                </div>

                <div class="details-section">
                    <h3>Parent/Guardian Information</h3>
                    <div class="details-grid">
                        <div class="detail-item">
                            <label>Parent/Guardian Name:</label>
                            <p><?php echo htmlspecialchars($student['parent_name']); ?></p>
                        </div>
                        <div class="detail-item">
                            <label>Parent/Guardian Phone:</label>
                            <p><?php echo htmlspecialchars($student['parent_phone']); ?></p>
                        </div>
                    </div>
                </div>

                <div class="details-section">
                    <h3>School Fees Information</h3>
                    <div class="details-grid">
                        <div class="detail-item">
                            <label>Total School Fees:</label>
                            <p>KES <?php echo number_format($student['school_fees'], 2); ?></p>
                        </div>
                        <div class="detail-item">
                            <label>Amount Paid:</label>
                            <p>KES <?php echo number_format($student['school_fees_paid'], 2); ?></p>
                        </div>
                        <div class="detail-item">
                            <label>Balance:</label>
                            <p>KES <?php echo number_format($balance, 2); ?></p>
                        </div>
                        <div class="detail-item">
                            <label>Payment Status:</label>
                            <p class="status-<?php echo strtolower($student['fees_status']); ?>">
                                <?php echo $student['fees_status']; ?>
                            </p>
                        </div>
                    </div>
                    
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: <?php echo $percentage_paid; ?>%"></div>
                    </div>
                    <p class="progress-text"><?php echo number_format($percentage_paid, 1); ?>% paid</p>
                </div>

                <div class="details-section">
                    <h3>Registration Details</h3>
                    <div class="details-grid">
                        <div class="detail-item">
                            <label>Registration Date:</label>
                            <p><?php echo date('d/m/Y H:i', strtotime($student['registration_date'])); ?></p>
                        </div>
                        <div class="detail-item">
                            <label>Last Updated:</label>
                            <p><?php echo date('d/m/Y H:i', strtotime($student['last_updated'])); ?></p>
                        </div>
                    </div>
                </div>

                <div class="action-buttons">
                    <a href="admin.php" class="btn btn-secondary">Back to Dashboard</a>
                </div>
            </div>
        </main>

        <footer>
            <p>&copy; 2024 Secondary School Registration System. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>
