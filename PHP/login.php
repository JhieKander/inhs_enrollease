<?php
    // Start the session
    session_start();

    // Include the database connection file
    include '../Database/database_conn.php'; // Adjust the path as necessary

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get email and password from the form
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $password = isset($_POST['password']) ? trim($_POST['password']) : '';

        // Check if fields are empty
        if (empty($email) && empty($password)) {
            echo json_encode(['status' => 'error', 'message' => 'Email and password are required.']);
            exit;
        } elseif (empty($email) || empty($password)) {
            echo json_encode(['status' => 'error', 'message' => 'Both fields are required.']);
            exit;
        }

        // Prepare and execute the query to fetch user details
        $stmt = $conn->prepare("SELECT StudentID_Number, Student_Password, Student_FirstName, Student_MiddleName, Student_LastName, Student_ExtName FROM student_profile WHERE Student_Email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        // Check if the user exists
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($studentID, $hashed_password, $firstName, $middleName, $lastName, $extName);
            $stmt->fetch();

            // Verify the password
            if (password_verify($password, $hashed_password)) {
                // Password is correct, set session variables
                $_SESSION['loggedin'] = true;
                $_SESSION['email'] = $email; // Store the user's email in session
                $_SESSION['StudentID_Number'] = $studentID;

                // Check if the user's name fields are empty
                if (empty($firstName) && empty($middleName) && empty($lastName) && empty($extName)) {
                    // Return success response for empty names
                    echo json_encode(['status' => 'success', 'message' => 'Login successful! Please complete your details.']);
                } else {
                    // Return success response for filled names
                    echo json_encode(['status' => 'success', 'message' => 'Login successful! Redirecting to home.']);
                }
                exit();
            } else {
                // Password is incorrect
                echo json_encode(['status' => 'error', 'message' => 'Invalid email or password.']);
            }
        } else {
            // User does not exist
            echo json_encode(['status' => 'error', 'message' => 'Invalid email or password.']);
        }

        // Close the statement
        $stmt->close();
    }

    // Close the database connection
    $conn->close();
?>