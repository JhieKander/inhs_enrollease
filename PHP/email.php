<?php
    header('Content-Type: application/json'); // Set the content type to JSON
    include '../Database/database_conn.php';

    // Check if the email is set
    if (isset($_POST['email'])) {
        $email = $conn->real_escape_string(trim($_POST['email'])); // Sanitize input

        // Query to check if the email exists in both tables
        $query = "SELECT Student_Email FROM student_profile WHERE Student_Email = '$email' UNION SELECT Admin_Email FROM admin_account WHERE Admin_Email = '$email'";

        $result = $conn->query($query);

        if ($result && $result->num_rows > 0) {
            // Email is taken in either table
            echo json_encode(['status' => 'taken']);
        } else {
            // Email is available
            echo json_encode(['status' => 'available']);
        }
    } else {
        // If email is not set, return an error
        echo json_encode(['status' => 'error', 'message' => 'Email is required.']);
    }

    $conn->close();
?>