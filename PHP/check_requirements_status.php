<?php
    session_start();
    require_once '../Database/database_conn.php';

    $studentID = $_SESSION['StudentID_Number'] ?? null;
    $response = [
        'isRequirementsComplete' => false,
        'isStudentIDExists' => false
    ];

    if ($studentID) {
        $query = "SELECT StudentID_Number, SF9_ReportCardFront, SF9_ReportCardBack, B_Certificate 
                  FROM student_requirements 
                  WHERE StudentID_Number = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $studentID);
        $stmt->execute();
        $result = $stmt->get_result();
        $requirements = $result->fetch_assoc();

        // Check if the StudentID_Number exists in the table
        if ($requirements) {
            $response['isStudentIDExists'] = true;

            // Check if all required columns are non-empty
            $response['isRequirementsComplete'] = 
                !empty($requirements['SF9_ReportCardFront']) &&
                !empty($requirements['SF9_ReportCardBack']) &&
                !empty($requirements['B_Certificate']);
        }
    }

    header('Content-Type: application/json');
    echo json_encode($response);
?>
