<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/Database/database_conn.php';

use setasign\Fpdi\TcpdfFpdi;

// Variables to hold the temporary PDF path and confirmation message
$tempPdfPath = '';
$_SESSION['formVisible'] = true;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_SESSION['StudentID_Number'])) {
        $studentIDNumber = $_SESSION['StudentID_Number'];
    }

    // Capture form data from POST
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
    $indigenous_people = isset($_POST['ip']) ? $_POST['ip'] : ''; 
    $indigenous_people_specify = isset($_POST['ip-specify']) ? $_POST['ip-specify'] : '';
    $indigenous_other = isset($_POST['ip-other']) ? $_POST['ip-other'] : '';
    $disability = isset($_POST['disability']) ? $_POST['disability'] : '';
    $disability_specify = isset($_POST['disability-specify']) ? $_POST['disability-specify'] : '';
    $disability_other = isset($_POST['disability-other']) ? $_POST['disability-other'] : '';
    $beneficiary = isset($_POST['beneficiary']) ? $_POST['beneficiary'] : '';
    $beneficiary_specify = $_POST['beneficiary-specify'];

    // Capture form data from POST
    $school_year = $_POST['schoolYear'];
    $LRN = $_POST['learner-reference-number'];
    $student_lastname = strtoupper($_POST['last-name']);
    $student_firstname = strtoupper($_POST['first-name']);
    $student_middlename = strtoupper($_POST['middle-name']);
    $student_extension_name = strtoupper($_POST['extension-name']);
    $birthdate = isset($_POST['birthdate']) ? $_POST['birthdate'] : '';
    $mother_tongue = $_POST['mother-tongue'];
    $place_of_birth = $_POST['place-of-birth'];
    $psa_birth_certificate = $_POST['psa-birth-certificate'];
    $house_number = $_POST['house-number-current'];
    $street_name =$_POST['street-name-current'];
    $barangay = $_POST['barangay-current'];
    $city = $_POST['city-current'];
    $province = $_POST['province-current'];
    $country = isset($_SESSION['country-current']) ? $_SESSION['country-current'] : "PHILIPPINES";
    $zip_code = $_POST['zip-code-current'];
    $same_address = isset($_POST['same-address']) ? true : false;
    $permanent_house_number = $_POST['house-number-permanent'];
    $permanent_street_name = $_POST['street-name-permanent'];
    $permanent_barangay = $_POST['barangay-permanent'];
    $permanent_city = $_POST['city-permanent'];
    $permanent_province = $_POST['province-permanent'];
    $permanent_country = isset($_SESSION['country-permanent']) ? $_SESSION['country-permanent'] : "PHILIPPINES";
    $permanent_zip_code = $_POST['zip-code-permanent'];
    $father_lastname = strtoupper($_POST['father-last-name']);
    $father_firstname = strtoupper($_POST['father-first-name']);
    $father_middlename = strtoupper($_POST['father-middle-name']);
    $father_contact = $_POST['father-contact-number'];
    $mother_lastname = strtoupper($_POST['mother-last-name']);
    $mother_firstname = strtoupper($_POST['mother-first-name']);
    $mother_middlename = strtoupper($_POST['mother-middle-name']);
    $mother_contact = $_POST['mother-contact-number'];
    $guardian_lastname = strtoupper($_POST['guardian-last-name']);
    $guardian_firstname = strtoupper($_POST['guardian-first-name']);
    $guardian_middlename = strtoupper($_POST['guardian-middle-name']);
    $guardian_contact = $_POST['guardian-contact-number'];
    $last_grade = strtoupper($_POST['last-grade']);
    $last_school_year = $_POST['last-school-year'];
    $last_school = strtoupper($_POST['last-school']);
    $school_id = $_POST['school-id'];
    $student_type = $_POST['studentType'];
    $studentID = isset($_POST['studentID']) ? $_POST['studentID'] : 'Not specified';
    $grade_level = isset($_POST['gradeLevel']) ? $_POST['gradeLevel'] : 'Not specified';
    $grade_input = preg_replace('/[^0-9]/', '', $grade_level); // Extract the numeric part
    $formatted_grade = sprintf('%02d', $grade_input);
    $submission_date = strtoupper(date('F j, Y')); // Example format: October 21, 2024

    // Create new PDF document using FPDI
    $pdf = new TcpdfFpdi('P', 'mm', 'A4', true, 'UTF-8', false);

    // Set document information
    $pdf->SetCreator('Enrollment System');
    $pdf->SetAuthor('DepEd');
    $pdf->SetTitle('Filled Enrollment Form');
    $pdf->SetMargins(10, 10, 10);
    $pdf->SetFontSpacing(1.8);
    $pdf->SetFont('helvetica', 'B', 10);

    // Load the DepEd form PDF as a template
    $pageCount = $pdf->setSourceFile('Annex-1_BEEF-SY-2023-2024.pdf'); // Load the PDF

    // Import the first page
    $tplIdx1 = $pdf->importPage(1);
    $pdf->AddPage();
    $pdf->useTemplate($tplIdx1, 0, 0, 210, 297);

    // Header
    $pdf->SetXY(30, 34.5); $pdf->Cell(100, 10, $school_year, 0, 1);
    $pdf->SetXY(37, 40.5); $pdf->Cell(100, 10, $formatted_grade, 0, 1);

    $pdf->SetFontSpacing(1.7);
    $pdf->SetXY(93, 65); $pdf->Cell(100, 10, $LRN, 0, 1, 'R');

    $pdf->SetFontSpacing(1.8);
    // If LRN is provided, check "Yes", otherwise check "No"
    if (!empty($LRN)) {
        $pdf->SetXY(101.5, 43); // Adjust the position to the LRN "Yes" checkbox
        $pdf->Cell(3, 3, 'X', 0, 1);
    } else {
        $pdf->SetXY(112.5, 42.5); // Adjust the position to the LRN "No" checkbox
        $pdf->Cell(3, 3, 'X', 0, 1);
    }

    // If returnee is provided, check "Yes", otherwise check "No"
    if (!empty($last_grade) && !empty($last_school_year) && !empty($last_school) && !empty($school_id)) {
        $pdf->SetXY(163.5, 42.7); // Adjust the position to the returnee "Yes" checkbox
        $pdf->Cell(3, 3, 'X', 0, 1);
    } else {
        $pdf->SetXY(174.5, 42.5); // Adjust the position to the LRN "No" checkbox
        $pdf->Cell(3, 3, 'X', 0, 1);
    }

    $pdf->SetFontSpacing(1.3);
    $pdf->SetXY(21.5, 76.5); $pdf->Cell(100, 10, $student_lastname, 0, 1);
    $pdf->SetXY(22, 87.5); $pdf->Cell(100, 10, $student_firstname, 0, 1);
    $pdf->SetXY(22, 97); $pdf->Cell(100, 10, $student_middlename, 0, 1);
    $pdf->SetXY(22, 107); $pdf->Cell(100, 10, $student_extension_name, 0, 1);

    $date = new DateTime($birthdate);
    $formatted_birthdate = $date->format('m/d/Y');
    if (!empty($birthdate)) {
        $birthDate = new DateTime($birthdate);
        $today = new DateTime('today'); 
        $age = $birthDate->diff($today )->y; // Get the difference in years
    } else {
        $formatted_birthdate = ''; 
        $age = ''; 
    }

    $pdf->SetFontSpacing(1.85);
    $pdf->SetXY(38.5, 76.5); $pdf->Cell(100, 10, $formatted_birthdate, 0, 0, 'R');
    $pdf->SetFontSpacing(0);
    $pdf->SetXY(36, 86); $pdf->Cell(100, 10, $age, 0, 1, 'R'); 

    // Sex section
    $pdf->SetXY(109, 90); // Adjust X and Y coordinates for the "Yes" checkbox
    $pdf->Cell(3, 3, $gender === 'Female' ? 'X' : '', 0, 1); // Mark "Female" with "X" if selected

    $pdf->SetXY(109, 85); // Adjust X and Y coordinates for the "No" checkbox
    $pdf->Cell(3, 3, $gender === 'Male' ? 'X' : '', 0, 1); // Mark "Male" with "X" if selected

    $pdf->SetXY(60, 86); $pdf->Cell(100, 10, $mother_tongue, 0, 1, 'R');
    $pdf->SetXY(63, 75); $pdf->Cell(120, 10, $place_of_birth, 0, 1, 'R');
    $pdf->SetXY(68, 65); $pdf->Cell(100, 10, $psa_birth_certificate, 0, 1, 'L');

    // Indigenous People section
    $pdf->SetXY(98, 100); 
    $pdf->Cell(3, 3, $indigenous_people === 'Yes' ? 'X' : '', 0, 1); 

    $pdf->SetXY(109, 99.5); 
    $pdf->Cell(3, 3, $indigenous_people === 'No' ? 'X' : '', 0, 1); 

    // Display specified IP community or user's input for "Others"
    if ($indigenous_people === 'Yes') {
        if ($indigenous_people_specify === 'Others' && !empty($indigenous_other)) {
            $pdf->SetXY(145, 97); 
            $pdf->Cell(100, 10, $indigenous_other, 0, 1); 
            $indigenousToSave = $indigenous_other;
        } elseif (!empty($indigenous_people_specify) && $indigenous_people_specify !== 'Others') {
            $pdf->SetXY(145, 97); 
            $pdf->Cell(100, 10, $indigenous_people_specify, 0, 1); 
            $indigenousToSave = $indigenous_people_specify;
        }
    } else if($indigenous_people === 'No'){
        $indigenousToSave = 'No';
    }

    $pdf->SetXY(68.5, 122); // Adjust X and Y coordinates for the "Yes" checkbox
    $pdf->Cell(3, 3, $disability === 'Yes' ? 'X' : '', 0, 1); // Mark "Yes" with "X" if selected

    $pdf->SetXY(79, 122.5); // Adjust X and Y coordinates for the "No" checkbox
    $pdf->Cell(3, 3, $disability === 'No' ? 'X' : '', 0, 1); // Mark "No" with "X" if selected

    // Determine the value to save for disability
    if ($disability === 'Yes') {
        if (!empty($disability_specify) && $disability_specify !== 'Others') {
            // Save the specified disability
            $disabilityToSave = $disability_specify;
        } elseif ($disability_specify === 'Others' && !empty($disability_other)) {
            // Save the user-defined input for "Others"
            $disabilityToSave = $disability_other;
        } else {
            // If no specific disability is provided, set a default value
            $disabilityToSave = 'Not Specified'; // or handle as needed
        }
    } else if($disability === 'No') {
        // If the user said "No" to having a disability
        $disabilityToSave = 'No';
    }

    // Define X and Y coordinates for each disability
    $coordinates = [
        'Autism Spectrum Disorder' => [62.5, 138],
        'Blind' => [34.7, 138],
        'Cancer' => [146, 148],
        'Cerebral Palsy' => [100.5, 143],
        'Emotional-Behavioral Disorder' => [100.5, 138],
        'Hearing Impairment' => [62.5, 132.5],
        'Intellectual Disability' => [138.5, 132.5],
        'Learning Disability' => [100.5, 132.5],
        'Low Vision' => [34.7, 143],
        'Multiple Disorder' => [28, 148],
        'Orthopedic/Physical Handicap' => [138.5, 138],
        'Speech/Language Disorder' => [62.5, 143],
        'Others' => [60, 190], // If "Others" is selected, we will handle it separately
    ];

    // Optionally display the specified disability on the PDF
    if ($disability === 'Yes') {
        if (!empty($disability_specify) && $disability_specify !== 'Others') {
            // Check if the specified disability exists in the coordinates array
            if (array_key_exists($disability_specify, $coordinates)) {
                $pdf->SetXY($coordinates[$disability_specify][0], $coordinates[$disability_specify][1]);
                $pdf->Cell(3, 3, 'X', 0, 1); // Mark the selected disability with "X"
            }
        } elseif ($disability_specify === 'Others' && !empty($disability_other)) {
            $pdf->SetXY(60, 125.5); // Adjust X and Y to the position for "Others"
            $pdf->Cell(100, 10, $disability_other, 0, 1); // Display user input from the "Others" field
        }
    }

    $pdf->SetFontSpacing(2.2);
    $pdf->SetXY(142, 104.5); // Adjust X and Y coordinates for the "Yes" checkbox
    $pdf->Cell(3, 3, $beneficiary === 'Yes' ? 'X' : '', 0, 1); // Mark "Yes" with "X" if selected

    $pdf->SetXY(153, 104.5); // Adjust X and Y coordinates for the "No" checkbox
    $pdf->Cell(3, 3, $beneficiary === 'No' ? 'X' : '', 0, 1); // Mark "No" with "X" if selected

    // Optionally display the specified beneficiary
    if($beneficiary === 'Yes'){
        if (!empty($beneficiary_specify)) {
            $pdf->SetXY(103, 111.5); // Adjust X and Y to the position of the specify field
            $pdf->Cell(100, 10, $beneficiary_specify, 0, 1); // Display specified beneficiary
            $beneficiarytoSave = $beneficiary_specify;
        }
    } else if($beneficiary === 'No'){
        $beneficiarytoSave = 'No';
    }

    $pdf->SetFontSpacing(0);
    // Current address
    $pdf->SetXY(25, 166); $pdf->Cell(100, 10, strtoupper($house_number), 0, 1);
    $pdf->SetXY(61, 166); $pdf->Cell(100, 10, strtoupper($street_name), 0, 1);
    $pdf->SetXY(123.5, 166); $pdf->Cell(100, 10, strtoupper($barangay), 0, 1);
    $pdf->SetXY(25, 177); $pdf->Cell(100, 10, strtoupper($city), 0, 1);
    $pdf->SetXY(72, 177); $pdf->Cell(100, 10, strtoupper($province), 0, 1);
    $pdf->SetXY(123.5, 177); $pdf->Cell(100, 10, strtoupper($country), 0, 1);
    $pdf->SetXY(80, 177); $pdf->Cell(100, 10, $zip_code, 0, 1, 'R');

    // Permanent address section
    if ($same_address) {
        $pdf->SetXY(83.5, 189); // Adjust to where the checkbox is located on the PDF
        $pdf->Cell(5, 5, 'X', 0, 1); // Mark with an "X"

        $permanent_house_number = $house_number;
        $permanent_street_name = $street_name;
        $permanent_barangay = $barangay;
        $permanent_city = $city;
        $permanent_province = $province;
        $permanent_zip_code = $zip_code;

        $pdf->SetXY(25, 196); $pdf->Cell(100, 10, strtoupper($house_number), 0, 1);
        $pdf->SetXY(61, 196); $pdf->Cell(100, 10, strtoupper($street_name), 0, 1);
        $pdf->SetXY(123.5, 196); $pdf->Cell(100, 10, strtoupper($barangay), 0, 1);
        $pdf->SetXY(25, 207); $pdf->Cell(100, 10, strtoupper($city), 0, 1);
        $pdf->SetXY(72, 207); $pdf->Cell(100, 10, strtoupper($province), 0, 1);
        $pdf->SetXY(123.5, 207); $pdf->Cell(100, 10, strtoupper($country), 0, 1);
        $pdf->SetXY(80, 207); $pdf->Cell(100, 10, $zip_code, 0, 1, 'R');
    } else { 
        $pdf->SetXY(94.5, 189); // Adjust the position to the LRN "No" checkbox
        $pdf->Cell(5, 5, 'X', 0, 1);

        $pdf->SetXY(25, 196); $pdf->Cell(100 , 10, strtoupper($permanent_house_number), 0, 1);
        $pdf->SetXY(60, 196); $pdf->Cell(100, 10, strtoupper($permanent_street_name), 0, 1);
        $pdf->SetXY(123.5, 196); $pdf->Cell(100, 10, strtoupper($permanent_barangay), 0, 1);
        $pdf->SetXY(25, 207); $pdf->Cell(100, 10, strtoupper($permanent_city), 0, 1);
        $pdf->SetXY(72, 207); $pdf->Cell(100, 10, strtoupper($permanent_province), 0, 1);
        $pdf->SetXY(123.5, 207); $pdf->Cell(100, 10, strtoupper($permanent_country), 0, 1);
        $pdf->SetXY(80, 207); $pdf->Cell(100, 10, $permanent_zip_code, 0, 1, 'R');
    }

    // PARENT'S/GUARDIAN'S INFORMATION
    $pdf->SetXY(25, 232); $pdf->Cell(100, 10, $father_lastname, 0, 1);
    $pdf->SetXY(63, 232); $pdf->Cell(100, 10, $father_firstname, 0, 1);
    $pdf->SetXY(105, 232); $pdf->Cell(100, 10, $father_middlename, 0, 1);
    $pdf->SetXY(150, 232); $pdf->Cell(100, 10, $father_contact, 0, 1);

    $pdf->SetXY(25, 249); $pdf->Cell(100, 10, $mother_lastname, 0, 1);
    $pdf->SetXY(63, 249); $pdf->Cell(100, 10, $mother_firstname, 0, 1);
    $pdf->SetXY(105, 249); $pdf->Cell(100, 10, $mother_middlename, 0, 1);
    $pdf->SetXY(150, 249); $pdf->Cell(100, 10, $mother_contact, 0, 1);

    $pdf->SetXY(25, 265.5); $pdf->Cell(100, 10, $guardian_lastname, 0, 1);
    $pdf->SetXY(63, 265.5); $pdf->Cell(100, 10, $guardian_firstname, 0, 1);
    $pdf->SetXY(105, 265.5); $pdf->Cell(100, 10, $guardian_middlename, 0, 1);
    $pdf->SetXY(150, 265.5); $pdf->Cell(100, 10, $guardian_contact, 0, 1);

    // Now import the second page
    $tplIdx2 = $pdf->importPage(2);
    $pdf->AddPage();
    $pdf->useTemplate($tplIdx2, 0, 0, 210, 297);

    $pdf->SetXY(50, 22); $pdf->Cell(100, 10, $last_grade, 0, 1);
    $pdf->SetXY(56, 22); $pdf->Cell(100, 10, $last_school_year, 0, 1, 'R');
    $pdf->SetXY(45, 31); $pdf->Cell(100, 10, $last_school, 0, 1, 'L');
    $pdf->SetFontSpacing(1.8);
    $pdf->SetXY(90, 30.5); $pdf->Cell(100, 10, $school_id, 0, 1, 'R');

    $pdf->SetFontSpacing(0);
    $pdf->SetXY(142, 164); $pdf->Cell(0, 10, $submission_date, 0, 1); // Display the date in the PDF

    // Save the filled PDF to a temporary path
    $tempPdfPath = __DIR__ . '/temp_filled_enrollment_form.pdf';
    $pdf->Output($tempPdfPath, 'F'); // Save the PDF to a file

    $showModal = true;

    // Update query for student_profile
    $updateProfileQuery = "UPDATE student_profile SET 
        Student_LRN = ?, 
        Student_FirstName = ?, 
        Student_MiddleName = ?, 
        Student_LastName = ?, 
        Student_ExtName = ?, 
        Student_Gender = ?, 
        Student_Birthdate = ?, 
        Student_MotherTongue = ?, 
        Student_BirthPlace = ?, 
        Student_PSABCNo = ?, 
        Student_IPCommunity = ?, 
        Student_WithDisability = ?, 
        Student_4PsBeneficiary = ?, 
        Current_Country = ?, 
        Current_Province = ?, 
        Current_City = ?, 
        Current_Barangay = ?, 
        Current_StreetName = ?, 
        Current_HouseNumber = ?,
        Current_ZipCode = ?, 
        Permanent_Country = ?, 
        Permanent_Province = ?, 
        Permanent_City = ?, 
        Permanent_Barangay = ?, 
        Permanent_StreetName = ?, 
        Permanent_HouseNo = ?, 
        Permanent_ZipCode = ?,
        Father_FirstName = ?, 
        Father_MiddleName = ?, 
        Father_LastName = ?, 
        Father_ContactNumber = ?, 
        Mother_FirstName = ?, 
        Mother_MiddleName = ?, 
        Mother_LastName = ?, 
        Mother_ContactNumber = ?, 
        Guardian_FirstName = ?, 
        Guardian_MiddleName = ?, 
        Guardian_LastName = ?, 
        Guardian_ContactNumber = ?, 
        Last_GradeLevel = ?, 
        Last_SchoolYear = ?, 
        Last_SchoolName = ?, 
        Last_SchoolID = ? 
        WHERE StudentID_Number = ?";

    // Prepare and bind parameters for the update query
    $stmt = $conn->prepare($updateProfileQuery);

    // Check if each variable is empty and assign NULL if so
    $LRN = empty($LRN) ? null : $LRN;
    $student_middlename = empty($student_middlename) ? null : $student_middlename;
    $student_extension_name = empty($student_extension_name) ? null : $student_extension_name;
    $psa_birth_certificate = empty($psa_birth_certificate) ? null : $psa_birth_certificate;
    $father_middlename = empty($father_middlename) ? null : $father_middlename;
    $mother_middlename = empty($mother_middlename) ? null : $mother_middlename;
    $guardian_middlename = empty($guardian_middlename) ? null : $guardian_middlename;
    $school_id = empty($school_id) ? null : $school_id;

    // Set defaults for optional fields
    $indigenousToSave = empty($indigenousToSave) ? null : $indigenousToSave;
    $disabilityToSave = empty($disabilityToSave) ? null : $disabilityToSave;
    $beneficiarytoSave = empty($beneficiarytoSave) ? null : $beneficiarytoSave;

    // Bind parameters
    $stmt->bind_param("sssssssssssssssssssssssssssssssssssssssssssi", 
 $LRN, 
    $student_firstname, 
    $student_middlename, 
    $student_lastname, 
    $student_extension_name, 
    $gender, 
    $birthdate, 
    $mother_tongue, 
    $place_of_birth, 
    $psa_birth_certificate, 
    $indigenousToSave, 
    $disabilityToSave, 
    $beneficiarytoSave, 
    $country, 
    $province, 
    $city, 
    $barangay, 
    $street_name, 
    $house_number, 
    $zip_code,
    $permanent_country, 
    $permanent_province, 
    $permanent_city, 
    $permanent_barangay, 
    $permanent_street_name, 
    $permanent_house_number, 
    $permanent_zip_code,
    $father_firstname, 
    $father_middlename, 
    $father_lastname, 
    $father_contact, 
    $mother_firstname, 
    $mother_middlename, 
    $mother_lastname, 
    $mother_contact, 
    $guardian_firstname, 
    $guardian_middlename, 
    $guardian_lastname, 
    $guardian_contact, 
    $last_grade, 
    $last_school_year, 
    $last_school, 
    $school_id, 
    $studentIDNumber
);

    // Execute the update query
    if ($stmt->execute()) {
        // Update query for student_addinfo
        $updateAddInfoQuery = "UPDATE student_addinfo SET 
            Student_Type = ?, 
            Current_AcademicYear = ?, 
            Current_YearLevel = ? 
            WHERE StudentID_Number = ?";

        // Prepare and bind parameters for the update query
        $stmtAddInfo = $conn->prepare($updateAddInfoQuery);
        $stmtAddInfo->bind_param("sssi", 
            $student_type, 
            $school_year, 
            $grade_level, 
            $studentIDNumber
        );

        // Execute the update query
        if (!$stmtAddInfo->execute()) {
            // Handle error for student_addinfo update
            error_log("Error updating student_addinfo: " . $stmtAddInfo->error);
        }
    } else {
        // Handle error for student_profile update
        error_log("Error updating student_profile: " . $stmt->error);
    }

    // Close statements
    $stmt->close();
    $stmtAddInfo->close();
    $conn->close();
}
?>