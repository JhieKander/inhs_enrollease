<?php
    // Include the existing database connection
    include 'Database/database_conn.php'; // Adjust the path if necessary

    // Start the session to access session variables
    session_start();

    // Check if the StudentID_Number is set in the session
    if (!isset($_SESSION['StudentID_Number'])) {
        // Handle the case where the user is not logged in
        http_response_code(403); // Forbidden
        echo json_encode(['error' => 'User not logged in.']);
        exit;
    }

    // Get the StudentID_Number from the session
    $studentID = $_SESSION['StudentID_Number'];

    // Query to fetch readingskills_result for the specific student
    $sql = "SELECT English_Video, English_ReadingTime, English_ReadingTimeSpeed, 
                English_MisprononounceWords, English_MisprononounceRating, 
                English_ComprehensionScore, English_ComprehensionRating, 
                English_ReadingStatus, Filipino_Video, Filipino_ReadingTime, 
                Filipino_ReadingTimeSpeed, Filipino_MisprononounceWords, 
                Filipino_MisprononounceRating, Filipino_ComprehensionScore, 
                Filipino_ComprehensionRating, Filipino_ReadingStatus 
            FROM readingskills_result 
            WHERE StudentID_Number = ?"; // Use a prepared statement for security

    // Prepare and execute the statement
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo json_encode(['error' => 'Database query preparation failed.']);
        exit;
    }

    $stmt->bind_param("i", $studentID); // Assuming StudentID_Number is a string
    $stmt->execute();
    $result = $stmt->get_result();

    $response = [];

    if ($result->num_rows > 0) {
        // Fetch associative array
        $response = $result->fetch_assoc();
    }

    // Return the result as JSON
    header('Content-Type: application/json');
    echo json_encode($response);

    // Close the statement and connection
    $stmt->close();
    $conn->close();
?>