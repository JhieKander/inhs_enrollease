<?php
session_start(); // Start the session

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'PHP/forgot.php';
}
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
                <p>Forgot Password</p>
            </div>
            <form action="new-password.php" method="POST">
                <div>
                    <label for="email">Email:</label>
                    <br>
                    <input type="text" id="email" name="email" placeholder="Enter your Email">
                </div>
                <input type="submit" value="Generate Temporary Password">
                <?php if (isset($_SESSION['student_email'])): ?>
                    <input type="hidden" name="student_email" value="<?php echo htmlspecialchars($_SESSION['student_email']); ?>">
                <?php endif; ?>
            </form>
        </div>
        <div id="successModal" class="modal">
            <div class="modal-content">
                <span class="close-button" onclick="closeSuccessModal()">&times;</span>
                <h2>Message</h2>
                <p id="modal-message"></p>
                <button id="proceed-button" style="display:none;">Proceed</button>
            </div>
        </div>
    </div>
</body>
<script src="JavaScript/pass-forgot.js"></script>
</html>