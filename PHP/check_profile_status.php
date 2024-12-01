<?php
    session_start();
    require_once '../Database/database_conn.php';

    $studentID = $_SESSION['StudentID_Number'] ?? null;
    $response = ['isProfileComplete' => false]; // Default response

    if ($studentID) {
        $query = "SELECT * FROM student_profile WHERE StudentID_Number = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $studentID);
        $stmt->execute();
        $result = $stmt->get_result();
        $profile = $result->fetch_assoc();

        if ($profile) {
            // Columns to check for completeness
            $requiredColumns = [
                'Student_MotherTongue', 'Student_BirthPlace',
                'Student_IPCommunity', 'Student_WithDisability', 'Student_4PsBeneficiary',
                'Current_Country', 'Current_Province', 'Current_City', 'Current_Barangay',
                'Current_StreetName', 'Current_HouseNumber', 'Current_ZipCode',
                'Permanent_Country', 'Permanent_Province', 'Permanent_City',
                'Permanent_Barangay', 'Permanent_StreetName', 'Permanent_HouseNo',
                'Permanent_ZipCode', 'Father_FirstName', 'Father_LastName', 'Father_ContactNumber', 'Mother_FirstName',
                'Mother_LastName', 'Mother_ContactNumber',
                'Guardian_FirstName', 'Guardian_LastName',
                'Guardian_ContactNumber'
            ];

            $isProfileComplete = true;

            foreach ($requiredColumns as $column) {
                if (empty($profile[$column])) {
                    $isProfileComplete = false;
                    break;
                }
            }

            $response['isProfileComplete'] = $isProfileComplete; // Update response
        }
    }

    header('Content-Type: application/json');
    echo json_encode($response);
?>