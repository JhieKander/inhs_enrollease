<?php
    session_start();
    
    // Include database connection
    include '../Database/database_conn.php';
    
    $studentID = $_SESSION['StudentID_Number'];

    // Get the JSON input
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    // Extract video location
    $videoLocation = $data['videoLocation'];
    $readingTime = $data['readingTime'];

    // Fetch the latest Word_Count for English material
    $sql = "SELECT Word_Count FROM readingskills_material WHERE Language_Material = 'English' ORDER BY Material_ID DESC LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch the latest story's word count
        $row = $result->fetch_assoc();
        $wordCount = $row['Word_Count'];

            // Calculate English Reading Time Speed
        $readingTimeSpeed = ($wordCount / $readingTime) * 60; // Calculate speed in words per minute
    }

    // Determine Reading Status
    $readingStatus = ($readingTime <= 300) ? 'Reader' : 'Non-Reader';

    // Prepare and bind the SQL statement for UPDATE
    $stmt = $conn->prepare("UPDATE readingskills_result SET English_Video = ?, English_ReadingTime = ?, English_ReadingTimeSpeed = ?, English_ReadingStatus = ? WHERE StudentID_Number = ?");
    $stmt->bind_param("siisi", $videoLocation, $readingTime, $readingTimeSpeed, $readingStatus, $studentID);

    // Execute the statement and check for success
    if ($stmt->execute()) {
        if ($stmt->affected_rows === 0) {
            // If no rows were updated, perform an INSERT
            $stmt->close(); // Close the previous statement
            $stmt = $conn->prepare("INSERT INTO readingskills_result (StudentID_Number, English_Video, English_ReadingTime, English_ReadingTimeSpeed, English_ReadingStatus) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("isiii", $studentID, $videoLocation, $readingTime, $readingTimeSpeed, $readingStatus);
            if ($stmt->execute()) {
                echo json_encode(["status" => "success", "message" => "Video location inserted successfully."]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error inserting video location: " . $stmt->error]);
            }
        } else {
            echo json_encode(["status" => "success", "message" => "Video location updated successfully."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Error updating video location: " . $stmt->error]);
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
?>