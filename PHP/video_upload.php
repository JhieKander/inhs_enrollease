<?php
// include 'db_connection.php'; // Include your database connection file

$response = array(); // Initialize response array

// Check if the video file is uploaded
if (isset($_FILES["video"]) && $_FILES["video"]["error"] == UPLOAD_ERR_OK) {
    $targetDir = "../upload_videos/Filipino/";
    
    // Check if the directory exists, if not, create it
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true); // Create the directory with appropriate permissions
    }

    $targetFile = $targetDir . basename($_FILES["video"]["name"]);

    // Move the uploaded file to the target directory
    if (move_uploaded_file($_FILES["video"]["tmp_name"], $targetFile)) {
        // Return the file location for further processing
        $response['fileLocation'] = $targetFile;
        $response['status'] = 'success';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Failed to move uploaded file.';
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'No file uploaded or upload error.';
}

// Set the content type to application/json
header('Content-Type: application/json');
echo json_encode($response); // Return the response as JSON
?> 