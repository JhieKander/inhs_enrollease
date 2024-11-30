<?php
    // Include database connection
    include '../Database/database_conn.php';

    // Assuming you have a session or some way to identify the student
    session_start();
    $studentID = $_SESSION['StudentID_Number']; // Example of getting student ID from session

    // Fetch student data from the database
    $stmt = $conn->prepare("SELECT StudentID_Number, Student_LastName FROM student_profile WHERE StudentID_Number = ?");
    $stmt->bind_param("i", $studentID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $studentData = $result->fetch_assoc();
        echo json_encode($studentData); // Return data as JSON
    } else {
        echo json_encode([]); // Return empty array if no data found
    }

    $stmt->close();
    $conn->close();
?> 