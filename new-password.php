<?php
    session_start(); // Start the session if not already started

    // Get the email from the session
    $studentEmail = isset($_SESSION['student_email']) ? $_SESSION['student_email'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INHS Enrollment Forgot Password Page</title>
    <link rel="icon" href="Images/d92301_79a357f813014ac3957588d11a255055~mv2_d_1969_2362_s_2.png" type="image/x-icon" />
    <link rel="stylesheet" href="CSS/normalize.css">
    <link rel="stylesheet" href="CSS/forgotpass.css">
</head>
<body>
    <div class="container">
        <div class="image-container">
            <img src="images/inhs-footer.png" alt="School Image">
        </div>
        <div class="form-container">
            <div class="btn">
                <p>Change Password</p>
            </div>
            <form id="passwordForm" action="PHP/change-password.php" method="post">
                <input type="hidden" id="student_email" name="student_email" value="<?php echo htmlspecialchars($studentEmail); ?>">

                <div>
                    <label for="temp">Temporary Password:</label>
                    <br>
                    <div class="password-container">
                        <input type="password" id="temp" name="temp" placeholder="Enter your Temporary Password">
                        <span class="toggle-password" onclick="togglePasswordVisibility('temp')">👁️</span>
                    </div>
                </div>
                <br>
                <div>
                    <label for="new-password">New Password:</label>
                    <br>
                    <div class="password-container">
                        <input type="password" id="new-password" name="new-password" placeholder="Enter your Password">
                        <span class="toggle-password" onclick="togglePasswordVisibility('new-password')">👁️</span>
                    </div>
                    <div>
                        <span id="password-length-label"></span>
                        <span id="password-length-icon" class="check-icon"></span>
                    </div>
                    <div>
                        <span id="password-uppercase-label"></span>
                        <span id="password-uppercase-icon" class="check-icon"></span>
                    </div>
                    <div>
                        <span id="password-lowercase-label"></span>
                        <span id="password-lowercase-icon" class="check-icon"></span>
                    </div>
                    <div>
                        <span id="password-number-label"></span>
                        <span id="password-number-icon" class="check-icon"></span>
                    </div>
                    <div>
                        <span id="password-special-char-label"></span>
                        <span id="password-special-char-icon" class="check-icon"></span>
                    </div>
                    <br>
                </div>
                <br>
                <div>
                    <label for="con-new-password">Confirm New Password:</label>
                    <br>
                    <div class="password-container">
                        <input type="password" id="con-new-password" name="con-new-password" placeholder="Confirm your Password">
                        <span class="toggle-password" onclick="togglePasswordVisibility('con-new-password')">👁️</span>
                    </div>
                    <br>
                    <span id="con-new-password-match"></span>
                </div>
                <input type="submit" value="Change Password">
            </form>

            <div id="successModal" class="modal">
                <div class="modal-content">
                    <span class="close-button" id="closeModal">&times;</span>
                    <h2>Success!</h2>
                    <p id="successMessage"></p>
                </div>
            </div>

            <div id="errorModal" class="modal">
                <div class="modal-content">
                    <span class="close-button" id="closeErrorModal">&times;</span>
                    <h2>Error!</h2>
                    <p id="errorMessage"></p>
                </div>
            </div>
        </div>
    </div>
    <script src="JavaScript/new-password.js"></script>
</body>
</html>