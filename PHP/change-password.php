<?php
    // Include the database connection file
    require_once '../Database/database_conn.php'; // Adjust the path as necessary

    try {
        // Check if the form data is set
        if (isset($_POST['temp']) && isset($_POST['new-password']) && isset($_POST['con-new-password']) && isset($_POST['student_email'])) {
            $tempPassword = $_POST['temp'];
            $newPassword = $_POST['new-password'];
            $confirmPassword = $_POST['con-new-password'];
            $studentEmail = $_POST['student_email'];

            // Check if the new password meets requirements
            if (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[!@#$%^&*()_+\-=\[\]{};":\\|,.<>\/?]).{8,}$/', $newPassword)) {
                echo json_encode(['status' => 'error', 'message' => 'New Password does not meet the password requirements.']);
                exit;
            }

            // Validate the new password and confirm password
            if ($newPassword !== $confirmPassword) {
                echo json_encode(['status' => 'error', 'message' => 'New password and confirmation do not match.']);
                exit;
            }

            // Fetch the current temporary password from the database to validate the temporary password
            $stmt = $conn->prepare("SELECT Student_TempPassword FROM student_addinfo WHERE StudentID_Number = (SELECT StudentID_Number FROM student_profile WHERE Student_Email = ?)");
            $stmt->bind_param("s", $studentEmail);
            $stmt->execute();
            $stmt->bind_result($currentTempPassword); // Renamed for clarity
            $stmt->fetch();
            $stmt->close();

            // Check if the current temporary password is retrieved
            if (empty($currentTempPassword)) {
                echo json_encode(['status' => 'error', 'message' => 'No temporary password found for this email.']);
                exit;
            }

            // Verify the temporary password (ensure it's hashed in the database)
            if (!password_verify($tempPassword, $currentTempPassword)) {
                echo json_encode(['status' => 'error', 'message' => 'Temporary password is incorrect.']);
                exit;
            }

            // Hash the new password
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            // Prepare the SQL statement to update the password
            $stmt = $conn->prepare("UPDATE student_profile SET Student_Password = ? WHERE StudentID_Number = (SELECT StudentID_Number FROM student_profile WHERE Student_Email = ?)");
            $stmt->bind_param("ss", $hashedPassword, $studentEmail); // "ss" means both parameters are strings

            // Execute the statement
            if ($stmt->execute()) {
                echo json_encode(['status' => 'success', 'message' => 'Password changed successfully.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error changing password.']);
            }

            // Close the statement
            $stmt->close();
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Required fields are missing.']);
        }
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'Error: ' . $e->getMessage()]);
    }

    // Close the connection
    $conn->close();
?>