<?php
    session_start();
    include 'header.php';
    include 'PHP/tle_subject.php';

    // Check if the user is already logged in
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        header('Location: login_student.php'); // Redirect to login page if not logged in
        exit; // Stop further execution
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Assuming you get the values from the submitted form
        if (isset($_POST['enrolleeType'])) {
            $_SESSION['enrolleeType'] = $_POST['enrolleeType'];
        }
        if (isset($_POST['gradeLevel'])) {
            $_SESSION['gradeLevel'] = $_POST['gradeLevel'];
        }

        // Redirect to requirements.php after setting session variables
        header("Location: requirements.php");
        exit();
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
    <link rel="stylesheet" href="CSS/type.css">
</head>
<body>
    <main>
        <div class="contain">
            <section class="welcome">
                <?php include "profile_card.php"; ?>
                <div class="application">
                    <div class="application-note">
                        <h2>Complete your application</h2>
                        <p>Initiate the process by completing all essential information in the Application Form, ensuring no fields are left blank. Subsequently, generate the electronic copy by clicking the designated button and wait for 10-30 seconds before advancing to Step 2.</p>
                    </div>
                </div>
            </section>
            <section class="form">
                <?php include 'sidebar.php'; ?>
                <div class="content">
                    <h1>Application</h1>
                    <hr>
                    <div class="form-row">
                        <?php include 'progress.php'; ?>
                        <div class="tain">
                            <h1>Student Type</h1>
                            <form action="" method="POST" enctype="multipart/form-data">
                                <div class="type">
                                    <label for="enrolleeType">What type of enrollee are you?</label>
                                    <select id="enrolleeType" name="enrolleeType">
                                        <option value="">Select Type</option>
                                        <option value="New Student">New Student</option>
                                        <option value="Transferee">Transferee</option>
                                        <option value="Returnee">Returnee</option>
                                    </select>
                                </div>

                                <div id="gradeLevelContainer" class="type" style="display: none;">
                                    <label for="gradeLevel">What grade level are you going to enroll in?</label>
                                    <select id="gradeLevel" name="gradeLevel">
                                        <!-- Options will be populated by JavaScript -->
                                    </select>
                                </div>

                                <div id="tleSubjectContainer" class="type" style="display: none;">
                                    <label for="tleSubject">What TLE subject would you like to enroll in?</label>
                                    <select id="tleSubject">
                                        <option value="">Select Subject</option>
                                        <?php foreach ($subjects as $index => $subject): ?>
                                            <option value="<?php echo htmlspecialchars($sub_ID[$index]); ?>"><?php echo htmlspecialchars($subject); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            
                                <div class="button-container">
                                    <button class="button" id="continue-button">Proceed to Application Form</button>
                                </div>
                            </form>
                            
                            <div id="warningModal" class="modal" style="display: none;">
                                <div class="modal-content">
                                    <span class="close-button" onclick="closeWarningModal()">&times;</span>
                                    <h1>Warning</h1>
                                    <p>You haven't answered the question yet.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
</body>
    <script src="JavaScript/type.js"></script>
    <script src="JavaScript/sessionTimeout.js"></script>
</html>

<?php
    include 'footer.php';
?>