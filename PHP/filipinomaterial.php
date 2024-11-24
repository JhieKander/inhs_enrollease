<?php
include 'Database/database_conn.php';

// Query to get the latest data from readingskills_material table where Language_Material is 'Filipino'
$sql = "SELECT Language_Material, Title, Context FROM readingskills_material WHERE Language_Material = 'Filipino' ORDER BY Material_ID DESC LIMIT 1"; 
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch the latest row
    $row = $result->fetch_assoc();
    $languageMaterial = htmlspecialchars($row["Language_Material"]);
    $title = htmlspecialchars($row["Title"]);
    $context = nl2br(htmlspecialchars($row["Context"]));
} else {
    $languageMaterial = "N/A";
    $title = "N/A";
    $context = "No data available.";
}

$conn->close();
?>