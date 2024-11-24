<?php
    // Include the database connection file
    include 'Database/database_conn.php';

    // Initialize a variable to hold the academic year
    $acadID = '';
    $academicYear = '';

    // Prepare and execute the SQL query
    $sql = "SELECT * FROM academic_year LIMIT 1"; // Adjust the query as needed
    $result = $conn->query($sql);

    // Check if the query returned any results
    if ($result && $result->num_rows > 0) {
        // Fetch the result
        $row = $result->fetch_assoc();
        $acadID = $row['AcademicYear_ID'];
        $academicYear = $row['Academic_Year']; // Get the academic year
    }
?>