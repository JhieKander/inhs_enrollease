<?php
    include 'Database/database_conn.php';

    // Fetch the latest material
    $query = "SELECT Material_ID, Language_Material, Title FROM readingskills_material WHERE Language_Material = 'Filipino' ORDER BY Material_ID DESC LIMIT 1";
    $result = mysqli_query($conn, $query);

    // Check if we got a result
    if ($result && mysqli_num_rows($result) > 0) {
        $latestMaterial = mysqli_fetch_assoc($result);
        $material_id = $latestMaterial['Material_ID'];
        $languageMaterial = $latestMaterial['Language_Material'];
        $title = $latestMaterial['Title'];
    } else {
        $languageMaterial = "Unknown Language"; // Default value if no data found
        $title = "No Title Available"; // Default value if no data found
    }

    echo '<h3>' .  htmlspecialchars($languageMaterial . ' - ' . $title) . '</h3>';

    // Fetch questions from the database
    $query = "SELECT Questions FROM readingskills_question WHERE Material_ID = $material_id"; // Adjust Material_ID as needed
    $result = mysqli_query($conn, $query);
    $questionsData = mysqli_fetch_assoc($result);
    $questionsJson = json_decode($questionsData['Questions'], true); // Decode the JSON string to an array

    foreach ($questionsJson as $question) {
        echo '<div class="question">';
        echo '<p>' . $question['question_number'] . '. ' . $question['question_text'] . '<span style="color:red;">*</span></p>';
        echo '<ul class="options">';
        foreach ($question['choices'] as $key => $choice) {
            echo '<li>';
            echo '<input type="radio" id="q' . $question['question_number'] . $key . '" name="q' . $question['question_number'] . '" value="' . $key . '">';
            echo '<label for="q' . $question['question_number'] . $key . '">' . $key . '. ' . $choice . '</label>';
        }
        // Add a hidden input for the correct answer
        echo '<input type="hidden" class="correct-answer" value="' . $question['correct_answer'] . '">';
        echo '</li>';
        echo '</ul>';
        echo '</div>';
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $correctAnswersCount = (int)$_POST['correct_answers_count']; // Get the count of correct answers

        // Initialize the rating variable
        $rating = "Not Rated"; // Default value if no conditions are met

        // Determine the rating based on the correct answers count
        if ($correctAnswersCount >= 8) {
            $rating = "Malaya";
        } elseif ($correctAnswersCount >= 5) {
            $rating = "Instrukyunal";
        } elseif ($correctAnswersCount >= 3) {
            $rating = "Kabiguan";
        } elseif ($correctAnswersCount >= 0) {
            $rating = "Walang Kahandaan";
        }

        // Debugging: Check the rating value
        error_log("Rating determined: " . $rating); // Log the rating for debugging

        // Save the score and rating to the database
        $studentID = $_SESSION['StudentID_Number'];
        $stmt = $conn->prepare("UPDATE readingskills_result SET Filipino_ComprehensionScore = ?, Filipino_ComprehensionRating = ? WHERE StudentID_Number = ?");
        $stmt->bind_param("isi", $correctAnswersCount, $rating, $studentID);

        // Debugging: Check if the statement was prepared successfully
        if (!$stmt) {
            error_log("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        }

        if ($stmt->execute()) {
            // Redirect to the next assessment or page
            header('Location: ../rda.php');
            exit();
        } else {
            echo "Error updating record: " . $stmt->error;
        }

        $stmt->close();
    }
?>