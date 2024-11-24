<?php
    // Include the database connection file
    include 'Database/database_conn.php';

    // Query to get subjects from the tle_subject table
    $query = "SELECT * FROM tle_subject";
    $result = $conn->query($query);

    // Check if the query was successful
    if ($result === false) {
        die("Error executing query: " . $conn->error);
    }

    // Fetch the results into an array
    $sub_ID = []; // Initialize sub_ID array
    $subjects = [];
    while ($row = $result->fetch_assoc()) {
        $sub_ID[] = $row['TLE_ID'];
        $subjects[] = $row['TLE_SpecialtySubject'];
    }

    // Close the database connection
    $conn->close();
?>