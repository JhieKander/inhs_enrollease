<?php
    include 'header.php';
    include 'PHP/vision_api.php';

    require_once 'Database/database_conn.php';

    // Check if the user is already logged in
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        header('Location: login_student.php'); // Redirect to login page if not logged in
        exit; // Stop further execution
    }

    if (isset($_SESSION['verification_errors'])) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                showVerificationError(" . json_encode($_SESSION['verification_errors']) . ");
            });
        </script>";
        unset($_SESSION['verification_errors']); // Clear the errors after displaying
    }

    $studentID = $_SESSION['StudentID_Number'];

    // Fetch student profile details
    $query = "SELECT * FROM student_profile WHERE StudentID_Number = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $studentID);
    $stmt->execute();
    $result = $stmt->get_result();
    $profile = $result->fetch_assoc();

    // Columns to check for completeness
    $requiredColumns = [
        'Student_MotherTongue', 'Student_BirthPlace',
        'Student_IPCommunity', 'Student_WithDisability', 'Student_4PsBeneficiary',
        'Current_Country', 'Current_Province', 'Current_City', 'Current_Barangay',
        'Current_StreetName', 'Current_HouseNumber', 'Current_ZipCode',
        'Permanent_Country', 'Permanent_Province', 'Permanent_City',
        'Permanent_Barangay', 'Permanent_StreetName', 'Permanent_HouseNo',
        'Permanent_ZipCode', 'Father_FirstName', 'Father_LastName', 'Father_ContactNumber', 'Mother_FirstName',
        'Mother_LastName', 'Mother_ContactNumber',
        'Guardian_FirstName', 'Guardian_LastName',
        'Guardian_ContactNumber'
    ];

    $isProfileComplete = true;

    foreach ($requiredColumns as $column) {
        if (empty($profile[$column])) {
            $isProfileComplete = false;
            break;
        }
    }

    if (!$isProfileComplete) {
        // Redirect to application form if profile is incomplete
        header("Location: application.php");
        exit;
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
    <link rel="stylesheet" href="CSS/requirement.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
    <script>
        // Set worker path for PDF.js
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
    </script>
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
                                        <p>SF9 (Learners' Progress Report Card) - Front Page -</p>
                                        <button type="button" onclick="document.getElementById('sf9-front-input').click()">Choose Files</button>
                                        <input type="file" id="sf9-front-input" name="sf9_front_page" style="display: none;">
                                        <div class="selected-file"></div>
                                    </div>
                                    <div class="upload-box">
                                        <i class="fas fa-folder-open"></i>
                                        <p>SF9 (Learners' Progress Report Card) - Back Page -</p>
                                        <button type="button" onclick="document.getElementById('sf9-input').click()">Choose Files</button>
                                        <input type="file" id="sf9-input" name="sf9_files[]" multiple accept="image/*,.pdf" style="display: none;">
                                        <div class="selected-file"></div>
                                    </div>
                                    <div class="upload-box">
                                        <i class="fas fa-folder-open"></i>
                                        <p>PSA/NSO/LCR Birth Certificate</p>
                                        <p>or</p>
                                        <p>Barangay Certificate</p>
                                        <div>
                                            <button type="button" onclick="document.getElementById('file-input-1').click()">Choose Files</button>
                                            <input type="file" id="file-input-1" name="birth_certificate" style="display: none;">
                                            <div class="selected-file"></div>
                                        </div>
                                    </div>
                                    <div class="upload-box">
                                        <i class="fas fa-folder-open"></i>
                                        <p>For Conditionally Promoted Students: Certificate of Recomputed Grade/s <span style="font-style: italic;">(Optional)</span></p>
                                        <div>
                                            <button type="button" onclick="document.getElementById('file-input-2').click()">Choose Files</button>
                                            <input type="file" id="file-input-2" name="recomputed_grade_certificate" style="display: none;">
                                            <div class="selected-file"></div>
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
                        
                        <div id="previewModal" class="modal">
                            <div class="modal-content">
                                <span class="close-button">&times;</span>
                                <h2>File Preview</h2>
                                <div id="previewContent">
                                    <img id="previewImage" alt="Preview">
                                    <iframe id="previewPdf"></iframe>
                                </div>
                                <div class="preview-button-container">
                                    <button class="preview-close-btn">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
<script src="JavaScript/grade_level.js"></script>
<script src="JavaScript/file.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        <?php
        if (isset($_SESSION['verification_errors'])) {
            echo "showVerificationError(" . json_encode($_SESSION['verification_errors']) . ");";
            unset($_SESSION['verification_errors']);
        }
        ?>
    });
</script>
<div id="verificationErrorModal" class="modal">
    <div class="modal-content">
        <span class="close-button" onclick="closeVerificationModal()">&times;</span>
        <div class="modal-header">
            <h2>Document Verification Failed</h2>
        </div>
        <div class="modal-body">
            <div class="error-icon">
                <i class="fas fa-exclamation-circle"></i>
            </div>
            <div class="error-message">
                <h3>The following information does not match our records:</h3>
                <ul id="verificationErrorList">
                    <!-- Errors will be inserted here dynamically -->
                </ul>
            </div>
            <div class="document-instructions">
                <p>Please ensure:</p>
                <ul>
                    <li>You have uploaded the correct documents</li>
                    <li>The documents are clear and readable</li>
                    <li>The information matches what you provided in your application</li>
                </ul>
            </div>
        </div>
        <div class="modal-footer">
            <button onclick="closeVerificationModal()" class="btn-close-modal">Close</button>
        </div>
    </div>
</div>
<script src="JavaScript/sessionTimeout.js"></script>
</body>
</html>

<?php
    include 'footer.php';
?>