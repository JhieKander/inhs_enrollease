<?php
    session_start();
    require 'vendor/autoload.php'; // Load Composer's autoloader
    require 'Database/database_conn.php'; // Include the database connection

    // I-check kung naka-login ang user
    if (!isset($_SESSION['StudentID_Number'])) {
        http_response_code(403); // Forbidden
        echo json_encode(['error' => 'User not logged in.']);
        exit;
    }

    // I-upload ang video file
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['video'])) {
        $targetDir = "upload_videos/English/";
        $targetFile = $targetDir . basename($_FILES["video"]["name"]);

        // I-save ang video file sa upload_videos directory
        if (move_uploaded_file($_FILES["video"]["tmp_name"], $targetFile)) {
            // I-save ang impormasyon sa database
            $studentID = $_SESSION['StudentID_Number'];
            $sql = "UPDATE readingskills_result SET English_Video = ? WHERE StudentID_Number = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $targetFile, $studentID); // Assuming StudentID_Number is an integer

            if ($stmt->execute()) {
                echo json_encode(['success' => 'Video uploaded and saved successfully.']);
            } else {
                echo json_encode(['error' => 'Failed to save video information.']);
            }

            // I-clean up
            $stmt->close();
            $conn->close();
            unlink($targetFile); // Delete video file
        } else {
            echo json_encode(['error' => 'Failed to upload video.']);
        }
    } else {
        echo json_encode(['error' => 'No video file uploaded.']);
    }
?> 