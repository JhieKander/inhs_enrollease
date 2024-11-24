<?php
    session_start(); 

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    // Start output buffering
    ob_start();

    header('Content-Type: application/json'); // Set the content type to JSON
    include '../Database/database_conn.php'; // Ensure this path is correct

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require '../vendor/autoload.php';

    // Function to send email using PHPMailer
    function sendEmail($to, $subject, $message) {
        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                 // Enable SMTP authentication
            $mail->Username   = 'bucandalainhs@gmail.com';            // SMTP username (your Gmail address)
            $mail->Password   = '';                  // SMTP password (your Gmail password or app password)
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;      // Enable TLS encryption
            $mail->Port       = 587;                                  // TCP port to connect to

            // Recipients
            $mail->setFrom('bucandalainhs@gmail.com', 'Imus National High School'); // Sender's email and name
            $mail->addAddress($to);                                   // Add a recipient

            // Content
            $mail->isHTML(false);                                     // Set email format to plain text
            $mail->Subject = $subject;
            $mail->Body    = $message;

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false; // Return false if sending fails
        }
    }

    // Function to generate a random temporary password
    function generateTemporaryPassword($length = 10) {
        return bin2hex(random_bytes($length / 2)); // Generates a random password
    }

    $response = array();

    // Check if the email is set
    if (isset($_POST['email'])) {
        $studentEmail = $conn->real_escape_string(trim($_POST['email'])); // Sanitize input
    
        // Query to check if the email exists in the student_profile table
        $query = "SELECT StudentID_Number FROM student_profile WHERE Student_Email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $studentEmail);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result && $result->num_rows > 0) {
            // Email exists
            $row = $result->fetch_assoc();
            $studentID = $row['StudentID_Number']; // Get the StudentID_Number
    
            $temporaryPassword = generateTemporaryPassword();
            $hashedPassword = password_hash($temporaryPassword, PASSWORD_DEFAULT);
    
            // Prepare the update statement
            $insertQuery = "UPDATE student_addinfo SET Student_TempPassword = ? WHERE StudentID_Number = ?";
            $stmtUpdate = $conn->prepare($insertQuery);
            $stmtUpdate->bind_param("ss", $hashedPassword, $studentID);
    
            if ($stmtUpdate->execute()) {
                // Prepare email content
                $subject = "Temporary Password Request";
                $message = "Dear User,\n\nWe received your request for a temporary password. Please find your new temporary password below:\n\nYour temporary password is: $temporaryPassword\n\nYou can use this password to change your account password.\n\nIf you have any issues or need further assistance, feel free to reach out.\n\nBest regards,\nImus National High School\nBucandala I, City of Imus, Cavite";
    
                // Send email
                if (sendEmail($studentEmail, $subject, $message)) {
                    $response['status'] = 'success';
                    $response['message'] = 'Temporary password has been sent to your email.';
    
                    // Store the email in the session
                    $_SESSION['student_email'] = $studentEmail; // Store the email for later use
                } else {
                    $response['status'] = 'error';
                    $response['message'] = 'Failed to send email.';
                }
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Failed to update temporary password in the database.';
            }
            $stmtUpdate->close();
        } else {
            // Email does not exist
            $response['status'] = 'error';
            $response['message'] = 'The inputted email does not exist in the system.';
        }
        $stmt->close();
    } else {
        // If email is not set, return an error
        $response['status'] = 'error';
        $response['message'] = 'Email is not set.';
    }
    
    // Output the JSON response
    echo json_encode($response);
    
    // Clean the output buffer and end buffering
    ob_end_flush();
    $conn->close();
?>