<?php
    include 'header.php';

    session_start(); // Start the session

    // Check if the user is already logged in
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        header('Location: login_student.php'); // Redirect to login page if not logged in
        exit; // Stop further execution
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EnrollEase: Student Application</title>
    <link rel="icon" href="Images/d92301_79a357f813014ac3957588d11a255055~mv2_d_1969_2362_s_2.png" type="image/x-icon" />

    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400..900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>

    <link rel="stylesheet" href="CSS/normalize.css">
    <link rel="stylesheet" href="CSS/pup.css">
</head>
<body>
    <main>
        <div class="contain">
            <section class="welcome">
                <?php include 'profile_card.php'; ?>
                <div class="application">
                    <div class="application-note">
                        <h2>Complete your application</h2>
                        <p> Initiate the process by completing all essential information in the Application Form, ensuring no fields are left blank. Subsequently, generate the electronic copy by clicking the designated button and wait for 10-30 seconds before advancing to Step 2. </p>
                    </div>
                </div>
            </section>
            <section class="form">
                <?php
                    include 'sidebar.php';
                ?>
                <div class="content">
                    <h1>Application</h1>
                    <hr>
                    <div class="form-row">
                        <?php include 'progress.php'; ?>
                        <div class="tain">
                            <h1>Power Up</h1>
                            <div class="type">
                                <label for="powerUp">Would you like to enroll in the Power Up Class?</label>
                                <select id="powerUp">
                                    <option value="">Select Type</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </div>

                            <div id="averageModal" class="modal" style="display: none;">
                                <div class="modal-content">
                                    <span class="close-button" onclick="closeModal()">&times;</span>
                                    <h1 class="warning">Message</h1>
                                    <p>You have agreed to enroll in the Power Up class of Imus National High School.</p>
                                </div>
                            </div>

                            <div class="button-container">
                                <button class="button" id="continue-button" disabled>Proceed to Power Up Application Form</button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
</body>
    <script src="JavaScript/powerup.js"></script>
    <script src="JavaScript/sessionTimeout.js"></script>
</html>

<?php
    include 'footer.php';
?>