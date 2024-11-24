<?php
    include 'header.php';
    include 'PHP/vision_api.php';
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
    <link rel="stylesheet" href="CSS/requirement.css">
</head>
<body>
    <main>
        <div class="contain">
            <section class="welcome">
                <?php include 'profile_card.php'; ?>
                <div class="application">
                    <div class="application-note">
                        <h2> Complete your application</h2>
                        <p> Upon completing the Application Form, gather all required documents indicated below and upload it. </p>
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
                            <div class="flex-wrapper">
                                <div class="left">
                                    <h3> Requirements</h3>
                                    <p>1. SF9 (Learners Progress Report Card)</p>
                                    <p>2. Photocopy of PSA/NSO/LCR Birth Certificate or Original Copy of Barangay Certificate</p>
                                    <p>3. For Conditionally Promoted Students: Certificate of Recomputed Grade/s</p>
                                </div>
                                <div class="right">
                                    <h3>Barangay Certificate should have these information:</h3>
                                    <p>1. Name of the Child/Student</p>
                                    <p>2. Name of Parents (First Name, Middle Name, Last Name)</p>
                                    <p>3. Date of Birth of the Child/Student</p>
                                    <p>4. Sex</p>
                                </div>
                            </div>
                        </div>
                        <div class="main-container">
                            <div class="main-header">
                                <i class="fas fa-upload"></i>
                                <h1>Upload Files</h1>
                            </div>
                            <div class="divider"></div>
                            <form id="upload-form" method="POST" action="PHP/vision_api.php" enctype="multipart/form-data">
                                <input type="hidden" name="student-type" id="student-type" value="<?php echo isset($_SESSION['enrolleeType']) ? htmlspecialchars($_SESSION['enrolleeType']) : ''; ?>">
                                <input type="hidden" name="grade-level" id="grade-level" value="<?php echo isset($_SESSION['gradeLevel']) ? htmlspecialchars($_SESSION['gradeLevel']) : ''; ?>">
                                <div class="upload-section">
                                    <div class="upload-box">
                                        <i class="fas fa-folder-open"></i>
                                        <p>SF9 (Learners' Progress Report Card)</p>
                                        <p>Front and Back Image</p>
                                        <button type="button" onclick="document.getElementById('sf9-input').click()">Choose Files</button>
                                        <input type="file" id="sf9-input" name="sf9_files[]" multiple style="display: none;">
                                    </div>
                                    <div class="upload-box">
                                        <i class="fas fa-folder-open"></i>
                                        <p>PSA/NSO/LCR Birth Certificate</p>
                                        <p>or</p>
                                        <p>Barangay Certificate</p>
                                        <div>
                                            <button type="button" onclick="document.getElementById('file-input-1').click()">Choose Files</button>
                                            <input type="file" id="file-input-1" name="birth_certificate" style="display: none;">
                                        </div>
                                    </div>
                                    <div class="upload-box">
                                        <i class="fas fa-folder-open"></i>
                                        <p>For Conditionally Promoted Students: Certificate of Recomputed Grade/s</p>
                                        <div>
                                            <button type="button" onclick="document.getElementById('file-input-2').click()">Choose Files</button>
                                            <input type="file" id="file-input-2" name="recomputed_grade_certificate" style="display: none;">
                                        </div>
                                    </div>
                                </div>
                                <p class="note">Please check and ensure that all necessary requirements have been submitted before proceeding to the next step.</p>
                                <div class="button-container">
                                    <button type="submit" class="button">Proceed</button>
                                </div>
                            </form>
                        </div>
                        <div id="warningModal" class="modal">
                            <div class="modal-content">
                                <span class="close-button">&times;</span>
                                <h2>Warning</h2>
                                <p>Please upload the required files for SF9 (Learners' Progress Report Card) and PSA/NSO/LCR Birth Certificate before proceeding.</p>
                                <button id="modalOkButton">OK</button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
<script src="JavaScript/grade_level.js"></script>
<script src="JavaScript/file.js"></script>
</body>
</html>

<?php
    include 'footer.php';
?>