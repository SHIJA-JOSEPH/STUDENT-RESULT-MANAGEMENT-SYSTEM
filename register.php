<?php
require_once 'config.php';

$message = '';
$message_type = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect and sanitize input
    $admission_number = sanitize($_POST['admission_number']);
    $student_name = sanitize($_POST['student_name']);
    $class = sanitize($_POST['class']);
    $stream = sanitize($_POST['stream']);
    $region = sanitize($_POST['region']);
    $district = sanitize($_POST['district']);
    $parent_name = sanitize($_POST['parent_name']);
    $parent_phone = sanitize($_POST['parent_phone']);
    $school_fees = floatval($_POST['school_fees']);
    $school_fees_paid = floatval($_POST['school_fees_paid']);
    
    // Validation
    $errors = [];
    
    if (empty($admission_number)) {
        $errors[] = "Admission number is required";
    } elseif (!validateAdmissionNumber($admission_number)) {
        $errors[] = "Invalid admission number format (6-10 alphanumeric characters)";
    }
    
    if (empty($student_name)) {
        $errors[] = "Student name is required";
    }
    
    if (empty($class)) {
        $errors[] = "Class is required";
    }
    
    if (empty($parent_name)) {
        $errors[] = "Parent name is required";
    }
    
    if (empty($parent_phone)) {
        $errors[] = "Parent phone number is required";
    } elseif (!validatePhone($parent_phone)) {
        $errors[] = "Invalid phone number format (10-15 digits)";
    }
    
    if ($school_fees < 0) {
        $errors[] = "School fees must be a positive number";
    }
    
    if ($school_fees_paid < 0 || $school_fees_paid > $school_fees) {
        $errors[] = "School fees paid must be between 0 and total school fees";
    }
    
    if (count($errors) > 0) {
        $message = implode("<br>", $errors);
        $message_type = 'error';
    } else {
        // Check if admission number already exists
        $check_sql = "SELECT id FROM students WHERE admission_number = '$admission_number'";
        $check_result = $conn->query($check_sql);
        
        if ($check_result->num_rows > 0) {
            $message = "Error: Admission number already exists!";
            $message_type = 'error';
        } else {
            // Determine fees status
            if ($school_fees_paid == 0) {
                $fees_status = 'Pending';
            } elseif ($school_fees_paid < $school_fees) {
                $fees_status = 'Partial';
            } else {
                $fees_status = 'Paid';
            }
            
            // Insert into database
            $sql = "INSERT INTO students (admission_number, student_name, class, stream, region, district, parent_name, parent_phone, school_fees, school_fees_paid, fees_status) 
                    VALUES ('$admission_number', '$student_name', '$class', '$stream', '$region', '$district', '$parent_name', '$parent_phone', $school_fees, $school_fees_paid, '$fees_status')";
            
            if ($conn->query($sql) === TRUE) {
                $message = "Student registered successfully! Admission Number: " . $admission_number;
                $message_type = 'success';
                // Clear form
                $_POST = [];
            } else {
                $message = "Error: " . $conn->error;
                $message_type = 'error';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration - Secondary School System</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Secondary School Student Registration System</h1>
            <nav>
                <a href="index.php">Home</a>
                <a href="login.php">Admin Login</a>
            </nav>
        </header>

        <main>
            <div class="form-container">
                <h2>Student Registration Form</h2>
                
                <?php if (!empty($message)): ?>
                    <div class="message <?php echo $message_type; ?>">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="register.php">
                    <div class="form-group">
                        <label for="admission_number">Admission Number *</label>
                        <input type="text" id="admission_number" name="admission_number" 
                               placeholder="e.g., ADM2024001" 
                               value="<?php echo isset($_POST['admission_number']) ? $_POST['admission_number'] : ''; ?>" 
                               required>
                    </div>

                    <div class="form-group">
                        <label for="student_name">Student Name *</label>
                        <input type="text" id="student_name" name="student_name" 
                               placeholder="Full name of student" 
                               value="<?php echo isset($_POST['student_name']) ? $_POST['student_name'] : ''; ?>" 
                               required>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="class">Class *</label>
                            <select id="class" name="class" required>
                                <option value="">Select Class</option>
                                <option value="Form 1">Form 1</option>
                                <option value="Form 2">Form 2</option>
                                <option value="Form 3">Form 3</option>
                                <option value="Form 4">Form 4</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="stream">Stream</label>
                            <select id="stream" name="stream">
                                <option value="">Select Stream</option>
                                <option value="Science">Science</option>
                                <option value="Arts">Arts</option>
                                <option value="Commercial">Commercial</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="region">Region</label>
                            <input type="text" id="region" name="region" 
                                   placeholder="e.g., Western Region"
                                   value="<?php echo isset($_POST['region']) ? $_POST['region'] : ''; ?>">
                        </div>

                        <div class="form-group">
                            <label for="district">District</label>
                            <input type="text" id="district" name="district" 
                                   placeholder="e.g., Kisii"
                                   value="<?php echo isset($_POST['district']) ? $_POST['district'] : ''; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="parent_name">Parent/Guardian Name *</label>
                        <input type="text" id="parent_name" name="parent_name" 
                               placeholder="Full name of parent/guardian" 
                               value="<?php echo isset($_POST['parent_name']) ? $_POST['parent_name'] : ''; ?>" 
                               required>
                    </div>

                    <div class="form-group">
                        <label for="parent_phone">Parent Phone Number *</label>
                        <input type="tel" id="parent_phone" name="parent_phone" 
                               placeholder="e.g., 254712345678" 
                               value="<?php echo isset($_POST['parent_phone']) ? $_POST['parent_phone'] : ''; ?>" 
                               required>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="school_fees">School Fees (KES) *</label>
                            <input type="number" id="school_fees" name="school_fees" 
                                   placeholder="Total school fees" 
                                   step="0.01" min="0"
                                   value="<?php echo isset($_POST['school_fees']) ? $_POST['school_fees'] : ''; ?>" 
                                   required>
                        </div>

                        <div class="form-group">
                            <label for="school_fees_paid">School Fees Paid (KES)</label>
                            <input type="number" id="school_fees_paid" name="school_fees_paid" 
                                   placeholder="Amount already paid" 
                                   step="0.01" min="0"
                                   value="<?php echo isset($_POST['school_fees_paid']) ? $_POST['school_fees_paid'] : '0'; ?>">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Register Student</button>
                </form>
            </div>
        </main>

        <footer>
            <p>&copy; 2024 Secondary School Registration System. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>
