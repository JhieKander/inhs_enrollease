<?php
    session_start();
    include '../Database/database_conn.php'; // Include your database connection file

    // Prepare the SQL statement to check for the video
    $checkVideo = $conn->prepare("SELECT English_Video FROM readingskills_result WHERE StudentID_Number = ?");
    $checkVideo->bind_param("i", $_SESSION['StudentID_Number']);
    $checkVideo->execute();
    $result = $checkVideo->get_result();
    $row = $result->fetch_assoc();

    // Check if the video exists and return the result as JSON
    $response = array('videoExists' => !empty($row['English_Video']));
    echo json_encode($response);
?> 