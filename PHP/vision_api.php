<?php
    session_start();

    // Google Vision API key
    $apiKey = '';

    // Function to call Google Vision API to extract text from the image
    function extractTextFromImage($imagePath, $apiKey) {
        $imageData = base64_encode(file_get_contents($imagePath));
    
        $url = 'https://vision.googleapis.com/v1/images:annotate?key=' . $apiKey;
    
        $data = [
            'requests' => [
                [
                    'image' => [
                        'content' => $imageData
                    ],
                    'features' => [
                        [
                            'type' => 'TEXT_DETECTION'
                        ]
                    ]
                ]
            ]
        ];
    
        // Initialize cURL
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    
        // Execute the request
        $response = curl_exec($ch);
    
        // Check for errors
        if (curl_errno($ch)) {
            die('Curl error: ' . curl_error($ch));
        }
    
        curl_close($ch);
    
        return json_decode($response, true);
    }

    // Function to extract and return the general average from the extracted text
    function extractGeneralAverage($text) {
        $text = preg_replace('/\s+/', ' ', $text);
        if (preg_match('/(general average|total|average).*?(\d+(\.\d+)?)/i', $text, $matches)) {
            return floatval($matches[2]);
        }
        return null;
    }

    // Handle form submission and file upload
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Fetch studentType and gradeLevel
        $studentType = isset($_POST['student-type']) ? $_POST['student-type'] : ''; // Match the input name
        $gradeLevel = isset($_POST['grade-level']) ? $_POST['grade-level'] : ''; // Match the input name

        // Initialize variable to store general average
        $generalAverage = null;

        // Process the uploaded files
        if (isset($_FILES['sf9_files'])) {
            foreach ($_FILES['sf9_files']['tmp_name'] as $key => $tmpName) {
                if (is_uploaded_file($tmpName)) {
                    $response = extractTextFromImage($tmpName, $apiKey);
                    $text = $response['responses'][0]['textAnnotations'][0]['description'] ?? '';
                    $generalAverage = extractGeneralAverage($text); //extractGeneralAverage($text)
                    break; // Process only the first uploaded file
                }
            }
        }

        // Log the studentType, gradeLevel, and generalAverage for debugging purposes
        error_log("Student Type: $studentType");
        error_log("Grade Level: $gradeLevel");
        error_log("General Average: $generalAverage");

        // Redirect based on conditions
        if ($generalAverage !== null) {
            if ($studentType === "New Student" && $gradeLevel === "Grade 7" && $generalAverage >= 90) {
                header("Location: ../power_up.php");
            } else {
                header("Location: ../rda.php");
            }
            exit();
        } else {
            error_log("Error: No general average found in the uploaded image.");
            echo "Error: No general average found in the uploaded image.";
        }
    }
?>