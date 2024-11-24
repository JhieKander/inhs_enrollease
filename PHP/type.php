<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $studentType = isset($_POST['studentType']) ? $_POST['studentType'] : '';
        $gradeLevel = isset($_POST['gradeLevel']) ? $_POST['gradeLevel'] : '';

        if ($studentType === 'New Student' && $gradeLevel === 'Grade 7') {
            echo "
            <form id='redirectForm' action='vision_api.php' method='POST'>
                <input type='hidden' name='studentType' value='" . htmlspecialchars($studentType) . "'>
                <input type='hidden' name='gradeLevel' value='" . htmlspecialchars($gradeLevel) . "'>
            </form>
            <script>
                document.getElementById('redirectForm').submit();
            </script>";
            exit();
        } else {
            echo "
            <script>
                console.log('Condition not met: studentType = \"$studentType\", gradeLevel = \"$gradeLevel\"');
            </script>";
        }
    }
?>
