<html>
    <link rel="stylesheet" href="CSS/side_bar.css">
    <body>
        <div class="sidebar">
            <a href="details.php" class="<?= (basename($_SERVER['PHP_SELF']) == 'details.php') ? 'active' : '' ?>">Accounts & Privacy</a>
            <a href="student_type.php" class="<?= in_array(basename($_SERVER['PHP_SELF']), [
                    'student_type.php', 
                    'application.php', 
                    'power_up.php',
                    'requirements.php', 
                    'rda.php',
                    'english_videoprompt.php',
                    'english_comprehend.php',
                    'english_passage.php',
                    'filipino_videoprompt.php',
                    'filipino_comprehend.php',
                    'filipino_passage.php',
                    'id_upload.php', 
                    'submit_reqs.php', 
                    'enrolled.php'
                ]) ? 'active' : '' ?>">My Application</a>
            <a href="subjects.php" class="<?= (basename($_SERVER['PHP_SELF']) == 'subjects.php') ? 'active' : '' ?>">Schedule</a>
        </div>
    </body>
    <script src="JavaScript/side.js"></script>
</html>
