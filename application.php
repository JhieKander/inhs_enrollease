<?php
    include_once 'header.php';
    include_once 'generate_pdf.php'; 
    include_once 'PHP/acadyear.php';

    // Check if the form was submitted to save the data temporarily
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save_form'])) {
        // Store form data in session variables for each field
        $_SESSION['user_data'] = $_POST; 
    }

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
            $studentBirthdate = $row['Student_Birthdate'] ?? ''; // Ensure this column exists in the database
            $studentGender = $row['Student_Gender'];
        }
    }

    // Function to retrieve session data or return an empty string if not set
    function getSessionData($fieldName) {
        return isset($_SESSION['user_data'][$fieldName]) ? $_SESSION['user_data'][$fieldName] : '';
    }

    $formVisible = isset($_SESSION['formVisible']) ? $_SESSION['formVisible'] : true;
    unset($_SESSION['formVisible']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EnrollEase: Student Application</title>
    <link rel="icon" href="Images/d92301_79a357f813014ac3957588d11a255055~mv2_d_1969_2362_s_2.png" type="image/x-icon" />

    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400..900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Include Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Include Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    
    <link rel="stylesheet" href="CSS/normalize.css">
    <link rel="stylesheet" href="CSS/application.css">

    <style>
    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% {
            transform: translateY(0);
        }
        40% {
            transform: translateY(-10px);
        }
        60% {
            transform: translateY(-5px);
        }
    }

        .confirmationMessage {
        font-size: 3rem;
        text-align: center;
    }

    /* Ensure the iframe is responsive */
    #pdfViewer {
        width: 100%; /* Full width */
        height: 80vh; /* 80% of viewport height */
        border: none; /* Remove border */
    }

    /* Optional: Adjust iframe height for smaller screens */
    @media (max-width: 768px) {
        #pdfViewer {
            height: 60vh; /* Adjust height for smaller screens */
        }
    }

    </style>

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
                    <h1>Application</h1>
                    <hr>
                    <div class="form-row">
                        <?php include 'progress.php'; ?>
                       
                        <form action="vision_api.php" id="application_form" name="application_form" method="POST" style="display: <?php echo $formVisible ? 'block' : 'none';?>;">
                            <div class="tain">
                                <h1>Personal Information</h1>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="learner-reference-number">Learner Reference Number</label>
                                        <input type="text" id="learner-reference-number" maxlength="12" name="learner-reference-number" class="long-input" pattern="\d*" oninput="this.value = this.value.replace(/[^0-9]/g, '');" value="<?php echo getSessionData('learner-reference-number'); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="last-name">Last Name<span style="color: red;">*</span></label>
                                        <input type="text" id="last-name" name="last-name" class="long-input" pattern="[A-Za-z]+" oninput="this.value = this.value.replace(/[^A-Za-z]/g, '');" value="<?php echo htmlspecialchars($studentLastName); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="first-name">First Name<span style="color: red;">*</span></label>
                                        <input type="text" id="first-name" name="first-name" class="long-input" pattern="[A-Za-z]+" oninput="this.value = this.value.replace(/[^A-Za-z]/g, '');" value="<?php echo htmlspecialchars($studentFirstName); ?>">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="middle-name">Middle Name <span class="opt">(optional)</span></label>
                                        <input type="text" id="middle-name" name="middle-name" class="long-input" pattern="[A-Za-z]+" oninput="this.value = this.value.replace(/[^A-Za-z]/g, '');" value="<?php echo htmlspecialchars($studentMiddleName); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="extension-name">Extension Name <span class="opt">(optional)</span></label>
                                        <input type="text" id="extension-name" name="extension-name" class="long-input" pattern="[A-Za-z]+" oninput="this.value = this.value.replace(/[^A-Za-z]/g, '');" value="<?php echo htmlspecialchars($studentExtName); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="birthdate">Birthdate <span class="opt">(dd/mm/yyyy)</span><span style="color: red;">*</span></label>
                                        <input type="date" id="birthdate" name="birthdate" class="long-input" value="<?php echo htmlspecialchars($studentBirthdate); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="gender">Gender<span style="color: red;">*</span></label>
                                        <select id="gender" name="gender" class="long-input">
                                        <option value="<?php echo htmlspecialchars($studentGender); ?>"><?php echo htmlspecialchars($studentGender); ?></option>
                                            <option value="Male" <?php echo (getSessionData('gender') == 'Male') ? 'selected' : ''; ?>>Male</option>
                                            <option value="Female" <?php echo (getSessionData('gender') == 'Female') ? 'selected' : ''; ?>>Female</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="mother-tongue">Mother Tongue<span style="color: red;">*</span></label>
                                        <select id="mother-tongue" name="mother-tongue" class="long-input">
                                            <option value="">Select Mother Tongue</option>
                                            <option value="Aklanon" <?php echo (getSessionData('mother-tongue') == 'Aklanon') ? 'selected' : ''; ?>>Aklanon</option>
                                            <option value="Bikol" <?php echo (getSessionData('mother-tongue') == 'Bikol') ? 'selected' : ''; ?>>Bikol</option>
                                            <option value="Cebuano" <?php echo (getSessionData('mother-tongue') == 'Cebuano') ? 'selected' : ''; ?>>Cebuano</option>
                                            <option value="Chavacano" <?php echo (getSessionData('mother-tongue') == 'Chavacano') ? 'selected' : ''; ?>>Chavacano</option>
                                            <option value="Hiligaynon" <?php echo (getSessionData('mother-tongue') == 'Hiligaynon') ? 'selected' : ''; ?>>Hiligaynon</option>
                                            <option value="Ibanag" <?php echo (getSessionData('mother-tongue') == 'Ibanag') ? 'selected' : ''; ?>>Ibanag</option>
                                            <option value="Ilocano" <?php echo (getSessionData('mother-tongue') == 'Ilocano') ? 'selected' : ''; ?>>Ilocano</option>
                                            <option value="Ivatan" <?php echo (getSessionData('mother-tongue') == 'Ivatan') ? 'selected' : ''; ?>>Ivatan</option>
                                            <option value="Kapampangan" <?php echo (getSessionData('mother-tongue') == 'Kapampangan') ? 'selected' : ''; ?>>Kapampangan</option>
                                            <option value="Kinaray-a" <?php echo (getSessionData('mother-tongue') == 'Kinaray-a') ? 'selected' : ''; ?>>Kinaray-a</option>
                                            <option value="Maguindanao" <?php echo (getSessionData('mother-tongue') == 'Maguindanao') ? 'selected' : ''; ?>>Maguindanao</option>
                                            <option value="Maranao" <?php echo (getSessionData('mother-tongue') == 'Maranao') ? 'selected' : ''; ?>>Maranao</option>
                                            <option value="Pangasinan" <?php echo (getSessionData('mother-tongue') == 'Pangasinan') ? 'selected' : ''; ?>>Pangasinan</option>
                                            <option value="Sambal" <?php echo (getSessionData('mother-tongue') == 'Sambal') ? 'selected' : ''; ?>>Sambal</option>
                                            <option value="Surigaonon" <?php echo (getSessionData('mother-tongue') == 'Surigaonon') ? 'selected' : ''; ?>>Surigaonon</option>
                                            <option value="Tagalog" <?php echo (getSessionData('mother-tongue') == 'Tagalog') ? 'selected' : ''; ?>>Tagalog</option>
                                            <option value="Tausug" <?php echo (getSessionData('mother-tongue') == 'Tausug') ? 'selected' : ''; ?>>Tausug</option>
                                            <option value="Waray" <?php echo (getSessionData('mother-tongue') == 'Waray') ? 'selected' : ''; ?>>Waray</option>
                                            <option value="Yakan" <?php echo (getSessionData('mother-tongue') == 'Yakan') ? 'selected' : ''; ?>>Yakan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="place-of-birth">Place of Birth <span class="opt">(Municipality/City)</span><span style="color: red;">*</span></label>
                                        <select id="place-of-birth" name="place-of-birth" class="long-input">
                                            <option value="">Select Place of Birth</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="psa-birth-certificate">PSA Birth Certificate No. (BReN) <span class="opt">(optional)</span></label>
                                        <input type="text" id="psa-birth-certificate" name="psa-birth-certificate" class="long-input" maxlength="13" value="<?php echo getSessionData('psa-birth-certificate'); ?>">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Belonging to any Indigenous People (IP) Community Indigenous Cultural Community<span style="color: red;">*</span></label>
                                        <div class="radio-group">
                                            <input type="radio" id="ip-yes" name="ip" value="Yes" <?php echo (getSessionData('ip') == 'Yes') ? 'checked' : ''; ?> onclick="toggleIPOptions()">
                                            <label for="ip-yes">Yes</label>
                                            <input type="radio" id="ip-no" name="ip" value="No" <?php echo (getSessionData('ip') == 'No') ? 'checked' : ''; ?> onclick="toggleIPOptions()">
                                            <label for="ip-no">No</label>
                                        </div>
                                        
                                        <div id="ip-options" class="<?php echo (getSessionData('ip') == 'Yes') ? '' : 'hidden'; ?>">
                                            <label for="ip-specify">If yes, please specify:<span style="color: red;">*</span></label>
                                            <select id="ip-specify" name="ip-specify" class="long-input" onchange="toggleIOtherTextInput()">
                                                <option value="">Select IP Specify</option>
                                                <option value="Aeta" <?php echo (getSessionData('ip-specify') == 'Aeta') ? 'selected' : ''; ?>>Aeta</option>
                                                <option value="Badjao" <?php echo (getSessionData('ip-specify') == 'Badjao') ? 'selected' : ''; ?>>Badjao</option>
                                                <option value="Igorot" <?php echo (getSessionData('ip-specify') == 'Igorot') ? 'selected' : ''; ?>>Igorot</option>
                                                <option value="Ilongot" <?php echo (getSessionData('ip-specify') == 'Ilongot') ? 'selected' : ''; ?>>Ilongot</option>
                                                <option value="Lumad" <?php echo (getSessionData('ip-specify') == 'Lumad') ? 'selected' : ''; ?>>Lumad</option>
                                                <option value="Mangyan" <?php echo (getSessionData('ip-specify') == 'Mangyan') ? 'selected' : ''; ?>>Mangyan</option>
                                                <option value="Negrito" <?php echo (getSessionData('ip-specify') == 'Negrito') ? 'selected' : ''; ?>>Negrito</option>
                                                <option value="Palawan Tribe" <?php echo (getSessionData('ip-specify') == 'Palawan Tribe') ? 'selected' : ''; ?>>Palawan Tribe</option>
                                                <option value="Tumandok" <?php echo (getSessionData('ip-specify') == 'Tumandok') ? 'selected' : ''; ?>>Tumandok</option>
                                                <option value="Others" <?php echo (getSessionData('ip-specify') == 'Others') ? 'selected' : ''; ?>>Others</option>
                                            </select>
                                        </div>
                                        
                                        <div id="ip-other-options" class="<?php echo (getSessionData('ip-specify') == 'Others') ? '' : 'hidden'; ?>">
                                            <span class="long">If yes, please specify:<span style="color: red;">*</span></span>
                                            <input type="text" id="ip-other" name="ip-other" class="input-long" pattern="[A-Za-z]+" oninput="this.value = this.value.replace(/[^A-Za-z]/g, '');" value="<?php echo getSessionData('ip-other'); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Is the child a learner with disability?<span style="color: red;">*</span></label>
                                        <div class="radio-group">
                                            <input type="radio" id="disability-yes" name="disability" value="Yes" <?php echo (getSessionData('disability') == 'Yes') ? 'checked' : ''; ?> onclick="toggleDisabilityOptions()">
                                            <label for="disability-yes">Yes</label>
                                            <input type="radio" id="disability-no" name="disability" value="No" <?php echo (getSessionData('disability') == 'No') ? 'checked' : ''; ?> onclick="toggleDisabilityOptions()">
                                            <label for="disability-no">No</label>
                                        </div>
                                        
                                        <div id="disability-options" class="<?php echo (getSessionData('disability') == 'yes') ? '' : 'hidden'; ?>">
                                            <label for="disability-specify">If yes, please specify:<span style="color: red;">*</span></label>
                                            <select id="disability-specify" name="disability-specify" class="long-input" onchange="toggleDisabilityTextInput()">
                                                <option value="">Select Disability Specify</option>
                                                <option value="Autism Spectrum Disorder" <?php echo (getSessionData('disability-specify') == 'Autism Spectrum Disorder') ? 'selected' : ''; ?>>Autism Spectrum Disorder</option>
                                                <option value="Blind" <?php echo (getSessionData('disability-specify') == 'Blind') ? 'selected' : ''; ?>>Blind</option>
                                                <option value="Cancer" <?php echo (getSessionData('disability-specify') == 'Cancer') ? 'selected' : ''; ?>>Cancer</option>
                                                <option value="Cerebral Palsy" <?php echo (getSessionData('disability-specify') == 'Cerebral Palsy') ? 'selected' : ''; ?>>Cerebral Palsy</option>
                                                <option value="Emotional-Behavioral Disorder" <?php echo (getSessionData('disability-specify') == 'Emotional-Behavioral Disorder') ? 'selected' : ''; ?>>Emotional-Behavioral Disorder</option>
                                                <option value="Hearing Impairment" <?php echo (getSessionData('disability-specify') == 'Hearing Impairment') ? 'selected' : ''; ?>>Hearing Impairment</option>
                                                <option value="Intellectual Disability" <?php echo (getSessionData('disability-specify') == 'Intellectual Disability') ? 'selected' : ''; ?>>Intellectual Disability</option>
                                                <option value="Learning Disability" <?php echo (getSessionData('disability-specify') == 'Learning Disability') ? 'selected' : ''; ?>>Learning Disability</option>
                                                <option value="Low Vision" <?php echo (getSessionData('disability-specify') == 'Low Vision') ? 'selected' : ''; ?>>Low Vision</option>
                                                <option value="Multiple Disorder" <?php echo (getSessionData('disability-specify') == 'Multiple Disorder') ? 'selected' : ''; ?>>Multiple Disorder</option>
                                                <option value="Orthopedic/Physical Handicap" <?php echo (getSessionData('disability-specify') == 'Orthopedic/Physical Handicap') ? 'selected' : ''; ?>>Orthopedic/Physical Handicap</option>
                                                <option value="Speech/Language Disorder" <?php echo (getSessionData('disability-specify') == 'Speech/Language Disorder') ? 'selected' : ''; ?>>Speech/Language Disorder</option>
                                                <option value="Others" <?php echo (getSessionData('disability-specify') == 'Others') ? 'selected' : ''; ?>>Others</option>
                                            </select>
                                        </div>
                                        
                                        <div id="disability-other-options" class="<?php echo (getSessionData('disability-specify') == 'Others') ? '' : 'hidden'; ?>">
                                            <span class="long">If yes, please specify:<span style="color: red;">*</span></span>
                                            <input type="text" id="disability-other" name="disability-other" class="input-long" pattern="[A-Za-z]+" oninput="this.value = this.value.replace(/[^A-Za-z]/g, '');" value="<?php echo getSessionData('disability-other'); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Is your family a beneficiary of 4Ps?<span style="color: red;">*</span></label>
                                        <div class="radio-group">
                                            <input type="radio" id="beneficiary-yes" name="beneficiary" value="Yes" <?php echo (getSessionData('beneficiary') == 'Yes') ? 'checked' : ''; ?> onclick="toggleBeneficiaryOptions()">
                                            <label for="beneficiary-yes">Yes</label>
                                            <input type="radio" id="beneficiary-no" name="beneficiary" value="No" <?php echo (getSessionData('beneficiary') == 'No') ? 'checked' : ''; ?> onclick="toggleBeneficiaryOptions()">
                                            <label for="beneficiary-no">No</label>
                                        </div>
                                        <div id="beneficiary-options" class="hidden">
                                            <span class="long">If yes, write the 4Ps Household ID Number:</span>
                                            <input type="text" id="beneficiary-specify" name="beneficiary-specify" class="input-long" maxlength="20" pattern="\d*" oninput="this.value = this.value.replace(/[^0-9]/g, '');" value="<?php echo getSessionData('beneficiary-specify'); ?>">
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <div class="add">Current Address</div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="country">Country</label>
                                        <input type="text" id="country" name="country" value="Philippines" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="province">Province<span style="color: red;">*</span></label>
                                        <select id="province" name="province" onchange="updateCity()">
                                            <option value="">Select Province</option>
                                            <!-- Options will be populated based on data -->
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="city">Municipality/City<span style="color: red;">*</span></label>
                                        <select id="city" name="city" onchange="updateBarangay()">
                                            <option value="">Select City</option>
                                            <!-- Options will be populated based on Province selection -->
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="barangay">Barangay<span style="color: red;">*</span></label>
                                        <select id="barangay" name="barangay">
                                            <option value="">Select Barangay</option>
                                            <!-- Options will be populated by JavaScript -->
                                        </select>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="house-number">House Number<span style="color: red;">*</span></label>
                                        <input type="text" id="house-number" name="house-number" value="<?php echo getSessionData('house-number'); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="street-name">Street Name<span style="color: red;">*</span></label>
                                        <input type="text" id="street-name" name="street-name" pattern="[A-Za-z]+" oninput="this.value = this.value.replace(/[^A-Za-z]/g, '');" value="<?php echo getSessionData('street-name'); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="zip-code">Zip Code<span style="color: red;">*</span></label>
                                        <input type="text" id="zip-code" name="zip-code" pattern="^\d{4}$" maxlength="4" oninput="this.value=this.value.replace(/[^0-9]/g, '')" value="<?php echo getSessionData('zip-code'); ?>">
                                    </div>
                                </div>

                                <div class="header1">
                                    <div class="add">Permanent Address</div>
                                    <div class="same-address">
                                        <input type="checkbox" id="same-address" name="same-address" onclick="toggleAddressFields()" <?php echo (getSessionData('same-address') ? 'checked' : ''); ?>>
                                        <label for="same-address"><span class="opt">Same as the current address</span></label>
                                    </div>
                                </div>
                                <div class="input-row input-row-permanent">
                                    <div class="input-group">
                                        <label for="country-permanent">Country<span style="color: red;">*</span></label>
                                        <input type="text" id="country-permanent" name="country-permanent" class="input-row-permanent" value="Philippines" disabled>
                                    </div>
                                    <div class="input-group">
                                        <label for="province-permanent">Province<span style="color: red;">*</span></label>
                                        <select id="province-permanent" name="province-permanent" class="input-row-permanent" onchange="updateCitiesPermanent()">
                                            <option value="">Select Province</option>
                                        </select>
                                    </div>
                                    <div class="input-group">
                                        <label for="city-permanent">Municipality/City<span style="color: red;">*</span></label>
                                        <select id="city-permanent" name="city-permanent" class="input-row-permanent" onchange="updateBarangaysPermanent()">
                                            <option value="">Select City</option>
                                        </select>
                                    </div>
                                    <div class="input-group">
                                        <label for="barangay-permanent">
                                        <label for="barangay-permanent">Barangay<span style="color: red;">*</span></label>
                                        <select id="barangay-permanent" name="barangay-permanent" class="input-row-permanent">
                                            <option value="">Select Barangay</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="input-row-full input-row-permanent">
                                    <div class="input-group">
                                        <label for="house-number-permanent">House Number<span style="color: red;">*</span></label>
                                        <input type="text" id="house-number-permanent" name="house-number-permanent" class="input-row-permanent" value="<?php echo getSessionData('house-number-permanent'); ?>">
                                    </div>
                                    <div class="input-group">
                                        <label for="street-name-permanent">Street Name<span style="color: red;">*</span></label>
                                        <input type="text" id="street-name-permanent" name="street-name-permanent" class="input-row-permanent" pattern="[A-Za-z]+" oninput="this.value = this.value.replace(/[^A-Za-z]/g, '');" value="<?php echo getSessionData('street-name-permanent'); ?>">
                                    </div>
                                    <div class="input-group">
                                        <label for="zip-code-permanent">Zip Code<span style="color: red;">*</span></label>
                                        <input type="text" id="zip-code-permanent" name="zip-code-permanent" class="input-row-permanent" pattern="^\d{4}$" maxlength="4" oninput="this.value=this.value.replace(/[^0-9]/g, '')" value="<?php echo getSessionData('zip-code-permanent'); ?>">
                                    </div>
                                </div>
                                <h1>Parent's Information</h1>

                                <div class="field-row">
                                    <div class="section">
                                        <h3>Father's Name</h3>
                                        <div class="field-group">
                                            <label for="father-last-name">Last Name<span style="color: red;">*</span></label>
                                            <input type="text" id="father-last-name" name="father-last-name" pattern="[A-Za-z]+" oninput="this.value = this.value.replace(/[^A-Za-z]/g, '');" value="<?php echo getSessionData('father-last-name'); ?>">
                                        </div>
                                        <div class="field-group">
                                            <label for="father-first-name">First Name<span style="color: red;">*</span></label>
                                            <input type="text" id="father-first-name" name="father-first-name" pattern="[A-Za-z]+" oninput="this.value = this.value.replace(/[^A-Za-z]/g, '');" value="<?php echo getSessionData('father-first-name'); ?>">
                                        </div>
                                        <div class="field-row">
                                            <div class="field-group">
                                                <label for="father-middle-name">Middle Name <span class="opt">(optional)</span></label>
                                                <input type="text" id="father-middle-name" name="father-middle-name" pattern="[A-Za-z]+" oninput="this.value = this.value.replace(/[^A-Za-z]/g, '');" value="<?php echo getSessionData('father-middle-name'); ?>">
                                            </div>
                                        </div>
                                        <div class="field-group">
                                            <label for="father-contact-number">Contact Number<span style="color: red;">*</span></label>
                                            <input type="text" id="father-contact-number" name="father-contact-number" placeholder="09XXXXXXXXX" maxlength="11" pattern="\d*" oninput="this.value = this.value.replace(/[^0-9]/g, '');" value="<?php echo getSessionData('father-contact-number'); ?>">
                                        </div>
                                    </div>

                                    <div class="section">
                                        <h3>Mother's Name</h3>
                                        <div class="field-group">
                                            <label for="mother-last-name">Last Name<span style="color: red;">*</span></label>
                                            <input type="text" id="mother-last-name" name="mother-last-name" pattern="[A-Za-z]+" oninput="this.value = this.value.replace(/[^A-Za-z]/g, '');" value="<?php echo getSessionData('mother-last-name'); ?>">
                                        </div>
                                        <div class="field-group">
                                            <label for="mother-first-name">First Name<span style="color: red;">*</span></label>
                                            <input type="text" id="mother-first-name" name="mother-first-name" pattern="[A-Za-z]+" oninput="this.value = this.value.replace(/[^A-Za-z]/g, '');" value="<?php echo getSessionData('mother-first-name'); ?>">
                                        </div>
                                        <div class="field-row">
                                            <div class="field-group half">
                                                <label for="mother-middle-name">Middle Name <span class="opt">(optional)</span></label>
                                                <input type="text" id="mother-middle-name" name="mother-middle-name" pattern="[A-Za-z]+" oninput="this.value = this.value.replace(/[^A-Za-z]/g, '');" value="<?php echo getSessionData('mother-middle-name'); ?>">
                                            </div>
                                        </div>
                                        <div class="field-group">
                                            <label for="mother-contact-number">Contact Number<span style="color: red;">*</span></label>
                                            <input type="text" ```php
                                            id="mother-contact-number" name="mother-contact-number" placeholder="09XXXXXXXXX" maxlength="11" pattern="\d*" oninput="this.value = this.value.replace(/[^0-9]/g, '');" value="<?php echo getSessionData('mother-contact-number'); ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="section1">
                                    <h3>Guardian's Name</h3>
                                    <div class="field-row">
                                        <div class="field-group half-width">
                                            <label for="guardian-last-name">Last Name<span style="color: red;">*</span></label>
                                            <input type="text" id="guardian-last-name" name="guardian-last-name" pattern="[A-Za-z]+" oninput="this.value = this.value.replace(/[^A-Za-z]/g, '');" value="<?php echo getSessionData('guardian-last-name'); ?>">
                                        </div>
                                        <div class="field-group half-width">
                                            <label for="guardian-first-name">First Name<span style="color: red;">*</span></label>
                                            <input type="text" id="guardian-first-name" name="guardian-first-name" pattern="[A-Za-z]+" oninput="this.value = this.value.replace(/[^A-Za-z]/g, '');" value="<?php echo getSessionData('guardian-first-name'); ?>">
                                        </div>
                                        <div class="field-group half-width">
                                            <label for="guardian-middle-name">Middle Name <span class="opt">(optional)</span></label>
                                            <input type="text" id="guardian-middle-name" name="guardian-middle-name" pattern="[A-Za-z]+" oninput="this.value = this.value.replace(/[^A-Za-z]/g, '');" value="<?php echo getSessionData('guardian-middle-name'); ?>">
                                        </div>
                                        <div class="field-group half-width">
                                            <label for="guardian-contact-number">Contact Number<span style="color: red;">*</span></label>
                                            <input type="text" id="guardian-contact-number" name="guardian-contact-number" placeholder="09XXXXXXXXX" maxlength="11" pattern="\d*" oninput="this.value = this.value.replace(/[^0-9]/g, '');" value="<?php echo getSessionData('guardian-contact-number'); ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="tor">
                                    <h1>For Returnee o Balik Aral & Transfer</h1>
                                    <div class="input-inline">
                                        <div class="input-container">
                                            <label for="last-grade">Last Grade Level Completed<span style="color: red;">*</span></label>
                                            <input type="text" id="last-grade" name="last-grade" value="<?php echo getSessionData('last-grade'); ?>">
                                        </div>
                                        <div class="input-container">
                                            <label for="last-school-year">Last School Year Attended<span style="color: red;">*</span></label>
                                            <input type="text" id="last-school-year" name="last-school-year" value="<?php echo getSessionData('last-school-year'); ?>">
                                        </div>
                                        <div class="input-container">
                                            <label for="last-school">Last School Attended<span style="color: red;">*</span></label>
                                            <input type="text" id="last-school" name="last-school" value="<?php echo getSessionData('last-school'); ?>">
                                        </div>
                                        <div class="input-container">
                                            <label for="school-id">School ID<span style="color: red;">*</span></label>
                                            <input type="text" id="school-id" name="school-id" maxlength="6" pattern="\d*" oninput="this.value = this.value.replace(/[^0-9]/g, '');" value="<?php echo getSessionData('school-id'); ?>">
                                        </div>
                                    </div>
                                </div>

                                <h1>Enrollment Details</h1>
                                    <div class="input-inline">
                                        <div class="input-container">
                                            <label for="student-type">Student Type</label>
                                            <input type="text" id="student-type" name="studentType" disabled value="<?php echo isset($_SESSION['enrolleeType']) ? htmlspecialchars($_SESSION['enrolleeType']) : ''; ?>">
                                        </div>
                                        <div class="input-container">
                                            <label for="grade-level">Grade Level to Enroll</label>
                                            <input type="text" id="grade-level" name="gradeLevel" disabled value="<?php echo isset($_SESSION['gradeLevel']) ? htmlspecialchars($_SESSION['gradeLevel']) : ''; ?>">
                                        </div>
                                        <div class="input-container">
                                            <label for="school-year">School Year</label>
                                            <input type="text" id="school-year" name="school-year" value="<?php echo htmlspecialchars($academicYear); ?>" readonly>
                                            <input type="hidden" id="acadID" name="acadID" value="<?php echo htmlspecialchars($acadID); ?>">
                                        </div>
                                    </div>

                                    <div class="message">
                                        Complete all required fields and verify the accuracy of your information before submitting.
                                    </div>
                                    <div class="button-container">
                                        <button class="button" id="save-continue-button" name="save_form">Save and Continue</button>
                                    </div>
                            </div>
                        </form>
                        <!-- Confirmation Message After Closing Modal -->
                        <div class="confirmationMessage" id="confirmationMessage" style="display: none;" class="alert alert-success">
                            <div class="mb-2">
                            <i class="fas fa-check-circle" style="font-size: 20vh; width: auto; color: green; animation: bounce 1s; margin-top: 5%;"> <!-- Using Font Awesome -->
                            <!-- For Bootstrap Icons, use this line instead -->
                            <!-- <i class="bi bi-check-circle" style="font-size: 50px; color: green;"></i> -->
                            </i>
                        </div>
                        Your form has been submitted successfully. 
                        <br>
                            <div class="button-container">
                                <button class="button"><a href="requirements.php"> Proceed to Next Step </a></button>
                            </div>
                        </div>
                </div>
            </section>
        </div>
    </main>

      <!-- Modal to display PDF in iframe -->
        <div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- Centered modal -->
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pdfModalLabel">Review Your Filled Enrollment Form</h5>
                    <button type="button" id="closeModalButton" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <iframe id="pdfViewer" src="temp_filled_enrollment_form.pdf?timestamp=<?php echo time(); ?>" style="width: 100%; height: 80vh;" frameborder="0"></iframe>
                </div>
                <div class="modal-footer">
                    <form method="POST" action="download_pdf.php" id="downloadForm">
                        <input type="hidden" name="pdf_file" value="temp_filled_enrollment_form.pdf">
                        <button type="submit" name="download" id="downloadButton" class="btn btn-success">Download PDF</button>
                    </form>
                    <button type="button" class="btn btn-secondary" id="submitButton" name="submit" data-bs-dismiss="modal" onclick="submitApplication()">Submit</button>
                </div>
                </div>
            </div>
        </div>

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Include Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <!-- Include Select2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="JavaScript/radio_button.js"></script>
    <script src="JavaScript/birthplace.js"></script>
    <script src="JavaScript/address.js"></script>
    <script src="JavaScript/button.js"></script>
    <script src="JavaScript/grade_level.js"></script>

<!-- Include Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    const submitButton = document.getElementById('submitButton');
    const downloadButton = document.getElementById('downloadButton');
    const continueButton = document.getElementById('save-continue-button');
    const gradeLevelInput = document.getElementById('grade-level');

    continueButton.addEventListener('click', function(event) {
        event.preventDefault();  // Prevent page refresh

        // Prepare form data
        const formData = new FormData(document.getElementById('application_form'));
        formData.append('gradeLevel', gradeLevelInput.value);  // Include grade level

     // Disable submit button initially
        submitButton.disabled = true;

    // Listen for the download button's form submission
        document.getElementById('downloadForm').addEventListener('submit', function(event) {
            event.preventDefault();  // Prevent the default form submission

            // Simulate the download delay
            setTimeout(function() {
                // Enable submit button after download
                submitButton.disabled = false;

                submitButton.classList.remove('btn-secondary'); // Remove any previous style class if needed
                submitButton.classList.add('btn', 'btn-success'); // Apply btn-success Bootstrap classes


                // Change download button text and style
                downloadButton.innerHTML = 'Downloaded! <i class="fas fa-check"></i>';
                downloadButton.classList.remove('btn-success');
                downloadButton.classList.add('btn-secondary');
                downloadButton.disabled = true;  // Disable download button after one click
            }, 500); // Adjust delay as needed for download completion

            // Proceed with actual download after the delay
            event.target.submit();
        });
        
        // AJAX request to generate PDF
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'generate_pdf.php', true);
        xhr.responseType = 'blob';  // Expect PDF as blob

        xhr.onload = function() {
            if (xhr.status === 200) {
                // Create blob URL for PDF
                const pdfBlob = xhr.response;
                const url = window.URL.createObjectURL(pdfBlob);

                // Set PDF iframe source with a cache-busting parameter
                const iframe = document.getElementById('pdfViewer');
                iframe.src = `temp_filled_enrollment_form.pdf?timestamp=${new Date().getTime()}`;

                // Show modal
                const pdfModal = new bootstrap.Modal(document.getElementById('pdfModal'));
                pdfModal.show();
            }
        };
        xhr.send(formData);  // Send form data
    });
});
</script>

</body>
</html>

<?php
    include 'footer.php';
?>