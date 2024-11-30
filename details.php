<?php
    include 'header.php';
    session_start();

    include 'Database/database_conn.php'; // Include your database connection file

    // Initialize variables
    $studentEmail = ''; // Default value
    $dataExists = false; // Flag to check if data exists
    $firstNameDisabled = false; // Default to false
    $middleNameDisabled = false; // Default to false
    $lastNameDisabled = false; // Default to false
    $extensionNameDisabled = false; // Default to false
    $birthdateDisabled = false; // Default to false
    $genderDisabled = false; // Default to false
    $emergencyContactNameDisabled = false; // Default to false
    $emergencyContactNumberDisabled = false; // Default to false

    if (isset($_SESSION['StudentID_Number'])) {
        $studentIDNumber = $_SESSION['StudentID_Number'];

        // Fetch the email from the database
        $query = "SELECT * FROM student_profile WHERE StudentID_Number = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $studentIDNumber);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $dataExists = true; // Data exists
            $row = $result->fetch_assoc();
            $studentFirstName = $row['Student_FirstName'];
            $studentMiddleName = $row['Student_MiddleName'];
            $studentLastName = $row['Student_LastName'];
            $studentExtName = $row['Student_ExtName'];
            $studentEmail = $row['Student_Email'];
            $studentBirthdate = $row['Student_Birthdate'];
            $studentGender = $row['Student_Gender'];

            // Set disabled state for middle name and extension name
            $firstNameDisabled = !is_null($studentFirstName);
            $middleNameDisabled = !is_null($studentMiddleName); // Disable if it exists
            $lastNameDisabled = !is_null($studentLastName);
            $extensionNameDisabled = !is_null($studentExtName); // Disable if it exists
            $genderDisabled = !is_null($studentGender);
            $birthdateDisabled = !is_null($studentBirthdate);
        } 

        // Fetch additional info
        $query = "SELECT Emergency_ContactName, Emergency_ContactNumber FROM student_addinfo WHERE StudentID_Number = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $studentIDNumber);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $emergencyContactName = $row['Emergency_ContactName'];
            $emergencyContactNumber = $row['Emergency_ContactNumber'];

            $emergencyContactNameDisabled = !is_null($emergencyContactName);
            $emergencyContactNumberDisabled = !is_null($emergencyContactNumber);
        } 
        $stmt->close();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EnrollEase: Student Account</title>
    <link rel="icon" href="Images/d92301_79a357f813014ac3957588d11a255055~mv2_d_1969_2362_s_2.png" type="image/x-icon" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400..900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="CSS/normalize.css">
    <link rel="stylesheet" href="CSS/detail.css">
</head>
<body>
    <main>
        <div class="contain">
            <section class="welcome">
                <?php include "profile_card.php"; ?>
                <div class="application">
                    <div class="application-note">
                        <h2>Complete your application</h2>
                        <p>Initiate the process by completing all essential information in the Application Form, ensuring no fields are left blank.</p>
                    </div>
                    <div class="application-button">
                        <button>Start Now</button>
                    </div>
                </div>
            </section>
            <section class="form">
                <?php include 'sidebar.php'; ?>
                <div class="content">
                    <h1>Basic Information, Account and Privacy</h1>
                    <hr>
                    <form id="studentForm" method="POST">
                        <h2>Basic Information</h2>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="last-name">Last Name<span style="color: red;">*</span></label>
                                <input type="text" id="last-name" name="last_name" value="<?php echo htmlspecialchars($studentLastName); ?>" <?php echo $lastNameDisabled ? 'disabled' : ''; ?>>
                            </div>
                            <div class="form-group">
                                <label for="first-name">First Name<span style="color: red;">*</span></label>
                                <input type="text" id="first-name" name="first_name" value="<?php echo htmlspecialchars($studentFirstName); ?>" <?php echo $firstNameDisabled ? 'disabled' : ''; ?>>
                            </div>
                            <div class="form-group">
                                <label for="middle-name">Middle Name <span style="font-style: italic; font-weight: 100;">(optional)</span></label>
                                <input type="text" id="middle-name" name="middle_name" value="<?php echo htmlspecialchars($studentMiddleName); ?>" <?php echo $middleNameDisabled ? 'disabled' : ''; ?>>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="extension-name">Extension Name <span style="font-style: italic; font-weight: 100;">(optional)</span></label>
                                <input type="text" id="extension-name" name="extension_name" value="<?php echo htmlspecialchars($studentExtName); ?>" <?php echo $extensionNameDisabled ? 'disabled' : ''; ?>>
                            </div>
                            <div class="form-group">
                                <label for="birthdate">Birthdate<span style="color: red;">*</span></label>
                                <input type="date" id="birthdate" name="birthdate" value="<?php echo htmlspecialchars($studentBirthdate); ?>" <?php echo $birthdateDisabled ? 'disabled' : ''; ?>>
                            </div>
                            <div class="form-group">
                                <label for="gender">Gender<span style="color: red;">*</span></label>
                                <select id="gender" name="gender" <?php echo $genderDisabled ? 'disabled' : ''; ?>>
                                    <option value="<?php echo htmlspecialchars($studentGender); ?>"><?php echo htmlspecialchars($studentGender); ?></option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="emergency-contact-name">Emergency Contact Name<span style="color: red;">*</span></label>
                                <input type="text" id="emergency-contact-name" name="emergency_contact_name" value="<?php echo htmlspecialchars($emergencyContactName); ?>" <?php echo $emergencyContactNameDisabled ? 'disabled' : ''; ?>>
                            </div>
                            <div class="form-group">
                                <label for="emergency-contact">Emergency Contact No.<span style="color: red;">*</span></label>
                                <input type="text" id="emergency-contact" name="emergency_contact_number" placeholder="09XXXXXXXXX" maxlength="11" pattern="\d*" oninput="this.value = this.value.replace(/[^0-9]/g, '');" value="<?php echo htmlspecialchars($emergencyContactNumber); ?>" <?php echo $emergencyContactNumberDisabled ? 'disabled' : ''; ?>>
                            </div>
                        </div>
                        <h2>Account</h2>
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="text" id="email" value="<?php echo htmlspecialchars($studentEmail); ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <div class="password-container">
                                <input type="password" id="password" name="password" value="">
                                <span class="toggle-password" onclick="togglePasswordVisibility('password')">👁️</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="con-password">Confirm Password</label>
                            <div class="password-container">
                                <input type="password" id="con-password" name="con_password" value="">
                                <span class="toggle-password" onclick="togglePasswordVisibility('con-password')">👁️</span>
                            </div>
                        </div>
                        <div class="save-button">
                            <button type="submit">Save Changes</button>
                        </div>
                    </form>

                    <div id="modal" class="model">
                        <div class="model-content">
                            <span class="close" id="closeModal">&times;</span>
                            <h2>Notice</h2>
                            <p id="modalMessage"></p>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
    <script src=" JavaScript/update_profile.js"></script>
    <script src="JavaScript/sessionTimeout.js"></script>
</body>
</html>

<?php
    include 'footer.php';
?>