<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

include '../Database/database_conn.php';

if (isset($_SESSION['StudentID_Number'])) {
    $studentIDNumber = $_SESSION['StudentID_Number'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $firstName = trim($_POST['first_name']);
        $middleName = trim($_POST['middle_name']);
        $lastName = trim($_POST['last_name']);
        $extensionName = trim($_POST['extension_name']);
        $gender = trim($_POST['gender']);
        $birthdate = trim($_POST['birthdate']);
        $emergencyContactName = trim($_POST['emergency_contact_name']);
        $emergencyContactNumber = trim($_POST['emergency_contact_number']);
        $newpass = isset($_POST['password']) ? trim($_POST['password']) : '';
        $conNewPass = isset($_POST['con_password']) ? trim($_POST['con_password']) : '';

        // Check if passwords match
        if ($newpass !== $conNewPass) {
            echo json_encode(['status' => 'error', 'message' => 'Passwords do not match.']);
            exit;
        }

        // Hash the password
        $hashedPassword = password_hash($newpass, PASSWORD_DEFAULT);

        // Set middle name and extension name to NULL if they are empty
        $middleName = !empty($middleName) ? $middleName : null;
        $extensionName = !empty($extensionName) ? $extensionName : null;

        // Prepare the update statement for student_profile
        $stmt1 = $conn->prepare("UPDATE student_profile SET Student_FirstName = ?, Student_MiddleName = ?, Student_LastName = ?, Student_ExtName = ?, Student_Gender = ?, Student_Birthdate = ?, Student_Password = ? WHERE StudentID_Number = ?");
        
        // Use "s" for string and "i" for integer, NULL values should be handled accordingly
        $stmt1->bind_param("sssssssi", $firstName, $middleName, $lastName, $extensionName, $gender, $birthdate, $hashedPassword, $studentIDNumber);

        // Prepare the update statement for student_addinfo
        $stmt2 = $conn->prepare("UPDATE student_addinfo SET Emergency_ContactName = ?, Emergency_ContactNumber = ? WHERE StudentID_Number = ?");
        
        // Assuming Emergency_ContactNumber is a string
        $stmt2->bind_param("ssi", $emergencyContactName, $emergencyContactNumber, $studentIDNumber);

        // Execute the statements
        if ($stmt1->execute() && $stmt2->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Profile updated successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update profile: ' . $stmt1->error . ' | ' . $stmt2->error]);
        }

        $stmt1->close();
        $stmt2->close();
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'User  not logged in.']);
}

// Close the database connection
$conn->close();
?>