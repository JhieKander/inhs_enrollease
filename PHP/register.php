<?php
    header('Content-Type: application/json'); // Set the content type to JSON
    include '../Database/database_conn.php';
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require '../vendor/autoload.php';

    // Function to generate a new student ID
    function generateStudentID() {
        global $conn;
        $year = date("Y");
        $result = $conn->query("SELECT StudentID_Number FROM student_profile WHERE StudentID_Number LIKE '$year%' ORDER BY StudentID_Number DESC LIMIT 1");

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $last_id = $row['StudentID_Number'];
            $increment = (int)substr($last_id, 4) + 1;
        } else {
            $increment = 1;
        }
        
        $student_id = $year . str_pad($increment, 6, '0', STR_PAD_LEFT);
        return $student_id;
    }

    // Function to create a new account
    function createAccount($email, $password) {
        global $conn;

        // Hash the password for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Create a new student ID
        $student_id = generateStudentID();

        // Prepare and bind for inserting into student_profile
        $stmtProfile = $conn->prepare("INSERT INTO student_profile (StudentID_Number, Student_Email, Student_Password) VALUES (?, ?, ?)");
        $stmtProfile->bind_param("sss", $student_id, $email, $hashed_password);

        // Execute the statement for student_profile
        if ($stmtProfile->execute()) {
            // Prepare and bind for inserting into student_addinfo
            $stmtAddInfo = $conn->prepare("INSERT INTO student_addinfo (StudentID_Number, Student_Status) VALUES (?, 'Not Enrolled')");
            $stmtAddInfo->bind_param("s", $student_id);

            // Execute the statement for student_addinfo
            if ($stmtAddInfo->execute()) {
                $emailSent = sendEmailNotification($email);
                if ($emailSent) {
                    echo json_encode(['status' => 'success']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Account created, but email could not be sent.']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => $stmtAddInfo->error]);
            }

            $stmtAddInfo->close();
        } else {
            echo json_encode(['status' => 'error', 'message' => $stmtProfile->error]);
        }

        $stmtProfile->close();
    }

    // Function to send email notification
    function sendEmailNotification($to) {
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com'; // Set the SMTP server to send through
            $mail->SMTPAuth   = true;              // Enable SMTP authentication
            $mail->Username   = 'bucandalainhs@gmail.com'; // SMTP username
            $mail->Password   = ''; // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
            $mail->Port       = 587; // TCP port to connect to

            //Recipients
            $mail->setFrom('bucandalainhs@gmail.com', 'Imus National High School'); // Set the sender's email and name
            $mail->addAddress($to); // Add the recipient's email address

            // Content
            $mail->isHTML(true);
            $mail->Subject = "Successful Account Registration on EnrollEase";
            $mail->Body    = "Dear Student,<br><br>
            We are pleased to inform you that your registration has been successfully completed in EnrollEase: A Smart Web-Based Enrollment System for Imus National High School.<br><br>
            You can now access the system to view your enrollment details, submit requirements, and monitor important updates related to the academic year.<br><br>
            What's Next?<br><br>
            • Log in to the system and go to Profile to complete your account details.<br>
            • Keep an eye on your email for important notifications.<br>
            • If you need assistance or have any questions, feel free to reach out to the school's support team.<br><br>
            We look forward to a smooth and efficient enrollment process. Thank you for choosing Imus National High School!<br><br>
            Best regards,<br>
            Imus National High School<br>
            Enrollment Support Team";

            $mail->send();
            return true; // Email sent successfully
        } catch (Exception $e) {
            error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}"); // Log the error
            return false; // Email not sent
        }
    }

    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $password = isset($_POST['password']) ? trim($_POST['password']) : '';
        $confirm_password = isset($_POST['con-password']) ? trim($_POST['con-password']) : '';

        if (empty($email) || empty($password) || empty($confirm_password)) {
            echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
            exit;
        } elseif ($password !== $confirm_password) {
            echo json_encode(['status' => 'error', 'message' => 'Passwords do not match.']);
            exit;
        }

        // Password validation
        $hasUppercase = preg_match('/[A-Z]/', $password);
        $hasLowercase = preg_match('/[a-z]/', $password);
        $hasNumber = preg_match('/[0-9]/', $password);
        $hasSpecialChar = preg_match('/[!@#$%^&*()_+\-=\[\]{};":\\|,.<>\/?]/', $password);
        $hasMinLength = strlen($password) >= 8;

        if (!$hasUppercase || !$hasLowercase || !$hasNumber || !$hasSpecialChar || !$hasMinLength) {
            echo json_encode(['status' => 'error', 'message' => 'Password must be at least 8 characters long and include at least one uppercase letter, one lowercase letter, one number, and one special character.']);
            exit;
        }

        // Check if email is already taken
        $result = $conn->query("SELECT * FROM student_profile WHERE Student_Email = '$email'");
        if ($result->num_rows > 0) {
            echo json_encode(['status' => 'error', 'message' => 'Email is already taken.']);
            exit;
        } else {
            createAccount($email, $password);
        }
    }

    $conn->close();
?>