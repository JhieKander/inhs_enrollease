<?php
    session_start();
    require_once '../Database/database_conn.php';

    $studentID = $_SESSION['StudentID_Number'] ?? null;
    $response = ['hasSavedData' => false];

    if ($studentID) {
        $query = "SELECT StudentID_Number, ID_Picture FROM student_requirements WHERE StudentID_Number = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $studentID);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();

        // Check if both StudentID_Number and ID_Picture are present
        if ($data && !empty($data['StudentID_Number']) && !empty($data['ID_Picture'])) {
            $response['hasSavedData'] = true;
        }
    }

    header('Content-Type: application/json');
    echo json_encode($response);
?>
