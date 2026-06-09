<?php
require_once 'config.php';
requireAdmin();

$search = '';
$filter_class = '';
$filter_fees_status = '';

// Search and filter functionality
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['search'])) {
        $search = sanitize($_GET['search']);
    }
    if (isset($_GET['class'])) {
        $filter_class = sanitize($_GET['class']);
    }
    if (isset($_GET['fees_status'])) {
        $filter_fees_status = sanitize($_GET['fees_status']);
    }
}

// Build query with filters
$where_conditions = [];

if (!empty($search)) {
    $where_conditions[] = "(student_name LIKE '%$search%' OR admission_number LIKE '%$search%' OR parent_name LIKE '%$search%')";
}

if (!empty($filter_class)) {
    $where_conditions[] = "class = '$filter_class'";
}

if (!empty($filter_fees_status)) {
    $where_conditions[] = "fees_status = '$filter_fees_status'";
}

$where_clause = '';
if (count($where_conditions) > 0) {
    $where_clause = "WHERE " . implode(" AND ", $where_conditions);
}

// Get all students
$sql = "SELECT * FROM students $where_clause ORDER BY registration_date DESC";
$result = $conn->query($sql);

// Calculate statistics
$stats_sql = "SELECT 
    COUNT(*) as total_students,
    SUM(school_fees) as total_fees,
    SUM(school_fees_paid) as total_paid,
    SUM(school_fees - school_fees_paid) as total_pending
    FROM students";
$stats_result = $conn->query($stats_sql);
$stats = $stats_result->fetch_assoc();

// Delete student functionality
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $delete_sql = "DELETE FROM students WHERE id = $delete_id";
    if ($conn->query($delete_sql) === TRUE) {
        header("Location: admin.php?message=deleted");
        exit();
    }
}

$message = '';
if (isset($_GET['message']) && $_GET['message'] == 'deleted') {
    $message = 'Student record deleted successfully.';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Secondary School System</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Secondary School Registration System - Admin Dashboard</h1>
            <nav>
                <span>Welcome, <?php echo htmlspecialchars($_SESSION['admin_username']); ?></span>
                <a href="register.php">Register Student</a>
                <a href="logout.php">Logout</a>
            </nav>
        </header>

        <main>
            <?php if (!empty($message)): ?>
                <div class="message success">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <!-- Statistics Dashboard -->
            <div class="statistics">
                <div class="stat-card">
                    <h3>Total Students</h3>
                    <p class="stat-number"><?php echo $stats['total_students']; ?></p>
                </div>
                <div class="stat-card">
                    <h3>Total Fees</h3>
                    <p class="stat-number">KES <?php echo number_format($stats['total_fees'], 2); ?></p>
                </div>
                <div class="stat-card">
                    <h3>Total Paid</h3>
                    <p class="stat-number">KES <?php echo number_format($stats['total_paid'], 2); ?></p>
                </div>
                <div class="stat-card">
                    <h3>Total Pending</h3>
                    <p class="stat-number">KES <?php echo number_format($stats['total_pending'], 2); ?></p>
                </div>
            </div>

            <!-- Search and Filter -->
            <div class="search-filter">
                <h2>Search & Filter Students</h2>
                <form method="GET" action="admin.php" class="filter-form">
                    <div class="form-group">
                        <input type="text" name="search" placeholder="Search by name, admission number, or parent name" 
                               value="<?php echo $search; ?>">
                    </div>

                    <div class="form-group">
                        <select name="class">
                            <option value="">All Classes</option>
                            <option value="Form 1" <?php echo $filter_class == 'Form 1' ? 'selected' : ''; ?>>Form 1</option>
                            <option value="Form 2" <?php echo $filter_class == 'Form 2' ? 'selected' : ''; ?>>Form 2</option>
                            <option value="Form 3" <?php echo $filter_class == 'Form 3' ? 'selected' : ''; ?>>Form 3</option>
                            <option value="Form 4" <?php echo $filter_class == 'Form 4' ? 'selected' : ''; ?>>Form 4</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <select name="fees_status">
                            <option value="">All Fee Status</option>
                            <option value="Pending" <?php echo $filter_fees_status == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                            <option value="Partial" <?php echo $filter_fees_status == 'Partial' ? 'selected' : ''; ?>>Partial</option>
                            <option value="Paid" <?php echo $filter_fees_status == 'Paid' ? 'selected' : ''; ?>>Paid</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Search</button>
                    <a href="admin.php" class="btn btn-secondary">Clear Filters</a>
                </form>
            </div>

            <!-- Students Table -->
            <div class="table-container">
                <h2>All Registered Students (<?php echo $result->num_rows; ?> found)</h2>
                
                <?php if ($result->num_rows > 0): ?>
                    <table class="students-table">
                        <thead>
                            <tr>
                                <th>Admission #</th>
                                <th>Student Name</th>
                                <th>Class</th>
                                <th>Stream</th>
                                <th>Region</th>
                                <th>District</th>
                                <th>Parent Name</th>
                                <th>Parent Phone</th>
                                <th>Fees</th>
                                <th>Paid</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['admission_number']); ?></td>
                                    <td><?php echo htmlspecialchars($row['student_name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['class']); ?></td>
                                    <td><?php echo htmlspecialchars($row['stream']); ?></td>
                                    <td><?php echo htmlspecialchars($row['region']); ?></td>
                                    <td><?php echo htmlspecialchars($row['district']); ?></td>
                                    <td><?php echo htmlspecialchars($row['parent_name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['parent_phone']); ?></td>
                                    <td>KES <?php echo number_format($row['school_fees'], 2); ?></td>
                                    <td>KES <?php echo number_format($row['school_fees_paid'], 2); ?></td>
                                    <td class="status-<?php echo strtolower($row['fees_status']); ?>">
                                        <?php echo $row['fees_status']; ?>
                                    </td>
                                    <td><?php echo date('d/m/Y', strtotime($row['registration_date'])); ?></td>
                                    <td class="actions">
                                        <a href="view_student.php?id=<?php echo $row['id']; ?>" class="btn-small">View</a>
                                        <a href="admin.php?delete_id=<?php echo $row['id']; ?>" class="btn-small btn-danger" onclick="return confirm('Are you sure?');">Delete</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="no-data">No students found matching your criteria.</p>
                <?php endif; ?>
            </div>
        </main>

        <footer>
            <p>&copy; 2024 Secondary School Registration System. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>
