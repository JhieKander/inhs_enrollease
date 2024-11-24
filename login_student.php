<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INHS Enrollment Login Page</title>
    <link rel="icon" href="Images/d92301_79a357f813014ac3957588d11a255055~mv2_d_1969_2362_s_2.png" type="image/x-icon" />
    <link rel="stylesheet" href="CSS/normalize.css">
    <link rel="stylesheet" href="CSS/login_student.css">
</head>
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
            <form action="PHP/login.php" method="POST">
                <div>
                    <label for="email">Email:</label>
                    <br>
                    <input type="text" id="email" name="email" placeholder="Enter your Email">
                </div>
                <div>
                    <label for="password">Password:</label>
                    <br>
                    <div class="password-container">
                        <input type="password" id="password" name="password" placeholder="Enter your Password">
                        <span class="toggle-password" onclick="togglePasswordVisibility()">
                            👁️
                        </span>
                    </div>
                </div>
                <div class="rmfp">
                    <input type="checkbox" id="remember">
                    <label for="remember">Remember me</label>
                    <a class="fp" href="forgot-password.php">Forgot Password?</a>
                </div>
                <input type="submit" value="Sign In">
            </form>
        </div>
        <div id="loginModal" class="modal">
            <div class="modal-content">
                <span class="close-button" onclick="closeModal()">&times;</span>
                <h2 id="modal-title"></h2>
                <p id="modal-message"></p>
            </div>
        </div>
    </div>
</body>
<script src="JavaScript/remember_me.js"></script>
</html>