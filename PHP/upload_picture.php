<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Start the session only if it hasn't been started yet
}

include '../vendor/autoload.php';
include '../Database/database_conn.php';

// Initialize response array
$response = ['success' => false];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['fileInput'])) {
    if (isset($_SESSION['StudentID_Number'])) {
        $studentID = $_SESSION['StudentID_Number'];
    }
    
    // Check if the file was uploaded without errors
    if ($_FILES['fileInput']['error'] === UPLOAD_ERR_OK) {
        $targetDir = "../requirements/IDPicture/";
        $targetFile = $targetDir . basename($_FILES["fileInput"]["name"]);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Read image file
        $imageContent = file_get_contents($_FILES["fileInput"]["tmp_name"]); // Ensure this is not empty
        if ($imageContent === false) {
            $response['message'] = 'Failed to read the uploaded file.';
            echo json_encode($response);
            exit; // Stop further execution
        }

        // Initialize Google Cloud Vision API client
        $client = new Google\Cloud\Vision\V1\ImageAnnotatorClient([
            'credentials' => '../Database/enrolease-bb69306864d8.json'
        ]);

        // Perform face detection
        $detectResponse = $client->faceDetection($imageContent);
        $faces = $detectResponse->getFaceAnnotations();

        // Check if exactly one face is detected
        $isValidImage = false;
        if (count($faces) === 1) {
            $face = $faces[0];
            
            // Check if face is centered and properly aligned
            $bounds = $face->getBoundingPoly()->getVertices();
            $imageWidth = imagesx(imagecreatefromstring($imageContent));
            $imageHeight = imagesy(imagecreatefromstring($imageContent));
            
            // Calculate face position relative to image
            $faceCenterX = ($bounds[0]->getX() + $bounds[2]->getX()) / 2;
            $faceCenterY = ($bounds[0]->getY() + $bounds[2]->getY()) / 2;
            
            // Check if face is centered (within 20% of center)
            $isCentered = 
                abs($faceCenterX - ($imageWidth / 2)) < ($imageWidth * 0.2) &&
                abs($faceCenterY - ($imageHeight / 2)) < ($imageHeight * 0.2);
                
            // Check if image has white background
            $colorResponse = $client->imagePropertiesDetection($imageContent);
            $imageProperties = $colorResponse->getImagePropertiesAnnotation();
            $hasWhiteBackground = false;

            if ($imageProperties !== null) {
                $colors = $imageProperties->getDominantColors()->getColors();
                foreach ($colors as $color) {
                    $rgb = $color->getColor();
                    if ($rgb->getRed() > 240 && $rgb->getGreen() > 240 && $rgb->getBlue() > 240) {
                        $hasWhiteBackground = true;
                        break;
                    }
                }
            }
            
            $isValidImage = $isCentered && $hasWhiteBackground;
        }

        $client->close();

        // Assuming $isValidImage is the result from Google Vision API check
        if ($isValidImage) {
            // Fetch student's last name from the database
            $query = "SELECT Student_LastName FROM student_profile WHERE StudentID_Number = '$studentID'";
            // Execute the query using your database connection
            $lastName = ''; // Initialize last name variable
            if ($result = mysqli_query($conn, $query)) {
                if ($row = mysqli_fetch_assoc($result)) {
                    $lastName = $row['Student_LastName']; // Corrected key to match database
                }
            }

            // Create a unique filename
            $dateTime = date('Y-m-d_H-i-s'); // Get current date and time
            $uniqueFileName = "ID-Picture-{$studentID}-{$lastName}-{$dateTime}.{$imageFileType}";
            $targetFile = $targetDir . $uniqueFileName; // Update target file with unique name

            if (move_uploaded_file($_FILES["fileInput"]["tmp_name"], $targetFile)) {
                // Check if ID_Upload is not empty
                $query = "SELECT ID_Picture FROM student_requirements WHERE StudentID_Number='$studentID'";
                $result = mysqli_query($conn, $query);
                $row = mysqli_fetch_assoc($result);
                $ID_Upload = $row['ID_Picture'];
                
                if (!empty($ID_Upload) || $ID_Upload === null) {
                    // Update the database with the unique file name
                    $query = "UPDATE student_requirements SET ID_Picture='$targetFile' WHERE StudentID_Number='$studentID'";
                }
                
                if (mysqli_query($conn, $query)) {
                    $response['success'] = true;
                }
            } else {
                $response['message'] = 'Failed to save the uploaded file.';
            }
        } else {
            $response['message'] = 'Invalid image. Please ensure it meets the requirements.';
        }
    } else {
        $response['message'] = 'File upload error. Please try again.';
    }
}

// Return the JSON response
echo json_encode($response);
?>