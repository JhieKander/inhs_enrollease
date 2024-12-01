<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start(); // Start the session only if it hasn't been started yet
    }
    include 'Database/database_conn.php'; // Include your database connection file

    $fullName = "Enrollee"; // Default to "Enrollee"

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

            // Construct the full name
            $fullName = $studentFirstName;
            if (!empty($studentMiddleName)) {
                $fullName .= " " . $studentMiddleName;
            }
            $fullName .= " " . $studentLastName;
            if (!empty($studentExtName)) {
                $fullName .= " " . $studentExtName;
            }
        }
        $stmt->close();

        // Fetch the ID_Picture from the database
        $query = "SELECT ID_Picture FROM student_requirements WHERE StudentID_Number = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $studentIDNumber);
        $stmt->execute();
        $result = $stmt->get_result();

        $profileImage = "images/blank-profile-picture-973460_1280.png"; // Default image
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (!empty($row['ID_Picture'])) {
                $profileImage = "inhs/" . $row['ID_Picture']; // Use the uploaded image if available
            }else{
                $profileImage = "images/blank-profile-picture-973460_1280.png"; // Default image
            }
        }
        $stmt->close();
    }
?>

<link rel="stylesheet" href="CSS/profilecard.css">

<div class="profile">
    <div class="profile-img">
        <img src="<?php echo htmlspecialchars($profileImage); ?>" alt="Profile Picture">
    </div>
    <div class="profile-info">
        <p class="comewel">Welcome!</p>
        <h2><?php echo htmlspecialchars($fullName); ?></h2> <!-- Displays full name or "Enrollee" -->
        <p>Student</p>
        <button onclick="openLogoutModal()">Log Out</button>
    </div>
</div>

<!-- Logout Confirmation Modal -->
<div id="logoutModal" class="mod" style="display:none;">
    <div class="mod-content">
        <h4>Log Out</h4>
        <p>Are you sure you want to log out?</p>
        <button id="confirmLogout" class="btn-ok">OK</button>
        <button onclick="document.getElementById('logoutModal').style.display='none'" class="btn-cancel">Cancel</button>
    </div>
</div>

<script src="JavaScript/rly_logout.js"></script>