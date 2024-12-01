<?php
    session_start();
    require_once '../Database/database_conn.php';

    $studentID = $_SESSION['StudentID_Number'] ?? null;
    $response = [
        'isReadingSkillsComplete' => false,
        'isStudentIDExists' => false
    ];

    if ($studentID) {
        $query = "SELECT 
                    Result_ID, StudentID_Number, LRN, English_Video, 
                    English_ReadingTime, English_ReadingTimeSpeed, 
                    English_ComprehensionScore, English_ComprehensionRating, 
                    English_ReadingStatus, Filipino_Video, 
                    Filipino_ReadingTime, Filipino_ReadingTimeSpeed, 
                    Filipino_ComprehensionScore, Filipino_ComprehensionRating, 
                    Filipino_ReadingStatus 
                FROM readingskills_result 
                WHERE StudentID_Number = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $studentID);
        $stmt->execute();
        $result = $stmt->get_result();
        $readingSkills = $result->fetch_assoc();

        // Check if the StudentID_Number exists in the table
        if ($readingSkills) {
            $response['isStudentIDExists'] = true;

            // Check if all required fields are non-empty
            $response['isReadingSkillsComplete'] = 
                !empty($readingSkills['Result_ID']) &&
                !empty($readingSkills['StudentID_Number']) &&
                !empty($readingSkills['LRN']) &&
                !empty($readingSkills['English_Video']) &&
                !empty($readingSkills['English_ReadingTime']) &&
                !empty($readingSkills['English_ReadingTimeSpeed']) &&
                !empty($readingSkills['English_ComprehensionScore']) &&
                !empty($readingSkills['English_ComprehensionRating']) &&
                !empty($readingSkills['English_ReadingStatus']) &&
                !empty($readingSkills['Filipino_Video']) &&
                !empty($readingSkills['Filipino_ReadingTime']) &&
                !empty($readingSkills['Filipino_ReadingTimeSpeed']) &&
                !empty($readingSkills['Filipino_ComprehensionScore']) &&
                !empty($readingSkills['Filipino_ComprehensionRating']) &&
                !empty($readingSkills['Filipino_ReadingStatus']);
        }
    }

    header('Content-Type: application/json');
    echo json_encode($response);
?>
