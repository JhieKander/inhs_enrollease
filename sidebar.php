<?php
include 'Database/database_conn.php';
$StudentID_Number = $_SESSION['StudentID_Number'];

// Initialize variables
$disable_application = true;
$disable_schedule = true;

// Check if student profile and additional info are filled out
$profile_query = "SELECT Student_LastName, Student_FirstName, Student_Birthdate, Student_Gender 
                  FROM student_profile 
                  WHERE StudentID_Number = '$StudentID_Number'";
$profile_result = mysqli_query($conn, $profile_query);

$addinfo_query = "SELECT Emergency_ContactName, Emergency_ContactNumber, Student_Status 
                  FROM student_addinfo 
                  WHERE StudentID_Number = '$StudentID_Number'";
$addinfo_result = mysqli_query($conn, $addinfo_query);

$profile_row = mysqli_fetch_assoc($profile_result);
$addinfo_row = mysqli_fetch_assoc($addinfo_result);

// Check My Application access
if ($profile_row && $addinfo_row) {
    if (!empty($profile_row['Student_LastName']) && 
        !empty($profile_row['Student_FirstName']) && 
        !empty($profile_row['Student_Birthdate']) && 
        !empty($profile_row['Student_Gender']) && 
        !empty($addinfo_row['Emergency_ContactName']) && 
        !empty($addinfo_row['Emergency_ContactNumber'])) {
        $disable_application = false;
    }
} else {
    $disable_application = true; // Ensure it's disabled if profile or addinfo is not found
}

// Check Schedule access
if ($addinfo_row && $addinfo_row['Student_Status'] === 'Enrolled') {
    $disable_schedule = false;
} else {
    $disable_schedule = true; // Ensure it's disabled if status is not 'Enrolled'
}
?>

<html>
    <link rel="stylesheet" href="CSS/side_bar.css">
    <body>
        <div class="sidebar">
            <li class="nav-item">
                <a href="details.php" class="<?= (basename($_SERVER['PHP_SELF']) == 'details.php') ? 'active' : '' ?>">
                    <i class="nav-icon fas fa-cog"></i>
                    <p>Accounts & Privacy</p>
                </a>
            </li>
            <li class="nav-item">
                <a <?php echo !$disable_application ? 'href="student_type.php"' : 'href="#" class="disabled"'; ?> 
                   class="nav-link <?= (in_array(basename($_SERVER['PHP_SELF']), ['student_type.php', 'application.php', 'requirements.php', 'rda.php', 'english_videoprompt.php', 'english_passage.php', 'english_comprehend.php', 'filipino_videoprompt.php', 'filipino_passage.php', 'filipino_comprehend.php', 'id_upload.php', 'submit_reqs.php'])) ? 'active' : '' ?>">
                    <i class="nav-icon fas fa-edit"></i>
                    <p>My Application</p>
                </a>
            </li>
            <li class="nav-item">
                <a <?php echo !$disable_schedule ? 'href="subjects.php"' : 'href="#"'; ?> 
                   class="nav-link <?php echo $disable_schedule ? 'disabled' : ''; ?>">
                    <i class="nav-icon fas fa-calendar-alt"></i>
                    <p>Schedule</p>
                </a>
            </li>
        </div>
    </body>
    <script src="JavaScript/side.js"></script>
</html>
