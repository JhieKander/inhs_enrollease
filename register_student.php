<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'PHP/email.php';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INHS Enrollment Register Page</title>
    <link rel="icon" href="Images/d92301_79a357f813014ac3957588d11a255055~mv2_d_1969_2362_s_2.png" type="image/x-icon" />
    <link rel="stylesheet" href="CSS/normalize.css">
    <link rel="stylesheet" href="CSS/register_student.css">
<body>
    <div class="container">
        <div class="image-container">
            <img src="images/inhs-footer.png" alt="School Image">
        </div>
        <div class="form-container">
            <div class="btn">
                <a href="login_student.php">
                     <button class="login">Login</button>
                </a>
                <a href="register_student.php">
                    <button class="signup">Register</button>
                </a>
            </div>
            <form action="PHP/register.php" method="post">
                <div>
                    <label for="email">Email:</label>
                    <br>
                    <input type="text" id="email" name="email" placeholder="Enter your Email">
                    <div id="email-availability"></div>
                </div>
                <br>
                <div>
                    <label for="password">Password:</label>
                    <br>
                    <div class="password-container">
                        <input type="password" id="password" name="password" placeholder="Enter your Password">
                        <span class="toggle-password" onclick="togglePasswordVisibility('password')">👁️</span>
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
                <div>
                    <label for="con-password">Confirm Password:</label>
                    <br>
                    <div class="password-container">
                        <input type="password" id="con-password" name="con-password" placeholder="Confirm your Password">
                        <span class="toggle-password" onclick="togglePasswordVisibility('con-password')">👁️</span>
                    </div>
                    <br>
                    <span id="con-password-match"></span>
                </div>
                <input type="submit" value="Create Account">
            </form>

            <div id="successModal" class="modal">
                <div class="modal-content">
                    <span class="close-button" id="closeModal">&times;</span>
                    <h2>Success!</h2>
                    <p>Account created successfully!</p>
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
    <script src="JavaScript/register_validation.js"></script>
</body>
</html>