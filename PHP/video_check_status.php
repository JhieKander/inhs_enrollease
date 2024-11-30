<?php
    session_start();
    include '../Database/database_conn.php'; // Include your database connection file

    if (isset($_SESSION['StudentID_Number'])) {
        $studentID = $_SESSION['StudentID_Number'];

        $checkVideo = $conn->prepare("SELECT Filipino_Video FROM readingskills_result WHERE StudentID_Number = ?");
        $checkVideo->bind_param("i", $studentID);
        $checkVideo->execute();
        $result = $checkVideo->get_result();
        
        // Debugging output for the number of rows returned
        error_log("Number of rows returned: " . $result->num_rows);

        $row = $result->fetch_assoc();  

        // Debugging output
        error_log("StudentID: $studentID, Video Field: " . print_r($row, true));

        $response = array('videoExists' => empty($row['Filipino_Video']));
        echo json_encode($response);
    }
?> 