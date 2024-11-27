<?php
    session_start();

    // Google Vision API key
    $apiKey = 'AIzaSyBSGAzrwz-kTKj27YLfgnXZzMQtIRgir4E';

    // Function to extract student details from text
    function extractStudentDetails($text) {
        $details = [
            'lrn' => null,
            'lastName' => null,
            'firstName' => null,
            'generalAverage' => null,
            'birthdate' => null,
            'fatherLastName' => null,
            'fatherFirstName' => null,
            'motherLastName' => null,
            'motherFirstName' => null
        ];

        // Clean and normalize text
        $text = strtoupper($text); // Convert all text to uppercase for consistency
        $text = preg_replace('/\s+/', ' ', $text); // Normalize whitespace

        // Extract LRN (12-digit number)
        if (preg_match('/\b\d{12}\b/', $text, $matches)) {
            $details['lrn'] = $matches[0];
        }

        // Extract General Average - Updated patterns
        $averagePatterns = [
            '/(GENERAL\s+AVERAGE|GEN\.\s*AVE\.|FINAL\s+GRADE)[:\s]*(\d+\.?\d*)/i',
            '/(TOTAL\s+AVERAGE|TOTAL\s+GRADE)[:\s]*(\d+\.?\d*)/i',
            '/AVERAGE[:\s]*(\d+\.?\d*)/i',
            '/GRADE[:\s]*(\d+\.?\d*)/i',
            '/GEN(?:ERAL)?\s*AVE(?:RAGE)?[:\s]*(\d+\.?\d*)/i'
        ];

        foreach ($averagePatterns as $pattern) {
            if (preg_match($pattern, $text, $matches)) {
                $details['generalAverage'] = floatval(end($matches));
                break;
            }
        }

        // Add debug logging for text extraction
        error_log("Extracted Text from SF9: " . $text);
        error_log("Found General Average: " . ($details['generalAverage'] ?? 'not found'));

        // Extract Student Name
        if (preg_match('/NAME[:\s]*(.*?),\s*(.*?)[\s\n]/i', $text, $matches)) {
            $details['lastName'] = trim($matches[1]);
            $details['firstName'] = trim($matches[2]);
        }

        // Extract Birthdate (multiple formats)
        $datePatterns = [
            '/BIRTH\s?DATE[:\s]*(\d{1,2})\s*(JAN(?:UARY)?|FEB(?:RUARY)?|MAR(?:CH)?|APR(?:IL)?|MAY|JUN(?:E)?|JUL(?:Y)?|AUG(?:UST)?|SEP(?:TEMBER)?|OCT(?:OBER)?|NOV(?:EMBER)?|DEC(?:EMBER)?)\s*(\d{4})/i',
            '/DATE\s*OF\s*BIRTH[:\s]*(\d{1,2})\s*(JAN(?:UARY)?|FEB(?:RUARY)?|MAR(?:CH)?|APR(?:IL)?|MAY|JUN(?:E)?|JUL(?:Y)?|AUG(?:UST)?|SEP(?:TEMBER)?|OCT(?:OBER)?|NOV(?:EMBER)?|DEC(?:EMBER)?)\s*(\d{4})/i'
        ];

        foreach ($datePatterns as $pattern) {
            if (preg_match($pattern, $text, $matches)) {
                $day = str_pad($matches[1], 2, '0', STR_PAD_LEFT);
                $month = substr($matches[2], 0, 3); // Take first 3 letters of month
                $year = $matches[3];
                $details['birthdate'] = date('Y-m-d', strtotime("$day $month $year"));
                break;
            }
        }

        // Extract Father's Name
        if (preg_match('/FATHER[\'S]*\s*NAME[:\s]*(.*?),\s*(.*?)[\s\n]/i', $text, $matches)) {
            $details['fatherLastName'] = trim($matches[1]);
            $details['fatherFirstName'] = trim($matches[2]);
        }

        // Extract Mother's Name
        if (preg_match('/MOTHER[\'S]*\s*NAME[:\s]*(.*?),\s*(.*?)[\s\n]/i', $text, $matches)) {
            $details['motherLastName'] = trim($matches[1]);
            $details['motherFirstName'] = trim($matches[2]);
        }

        // Clean up extracted data
        foreach ($details as $key => $value) {
            if ($value !== null) {
                $details[$key] = trim(preg_replace('/\s+/', ' ', $value));
            }
        }

        return $details;
    }

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
        error_log("POST request received");
        error_log("Session variables:");
        error_log("Student_LastName: " . ($_SESSION['Student_LastName'] ?? 'not set'));
        error_log("Student_FirstName: " . ($_SESSION['Student_FirstName'] ?? 'not set'));
        error_log("Student_Birthdate: " . ($_SESSION['Student_Birthdate'] ?? 'not set'));
        error_log("Father_LastName: " . ($_SESSION['Father_LastName'] ?? 'not set'));
        error_log("Mother_LastName: " . ($_SESSION['Mother_LastName'] ?? 'not set'));
        error_log("StudentID_Number: " . ($_SESSION['StudentID_Number'] ?? 'not set'));

        $errors = [];
        $sf9Verified = false;
        $birthCertVerified = false;
        $studentType = isset($_POST['student-type']) ? $_POST['student-type'] : '';
        $gradeLevel = isset($_POST['grade-level']) ? $_POST['grade-level'] : '';

        // Process SF9 files
        if (isset($_FILES['sf9_files'])) {
            $sf9Details = []; // Initialize the array
            $pageNumber = 1; // Use a counter instead of array key

            foreach ($_FILES['sf9_files']['tmp_name'] as $tmpName) {
                if (is_uploaded_file($tmpName)) {
                    try {
                        $response = extractTextFromImage($tmpName, $apiKey);
                        $text = $response['responses'][0]['textAnnotations'][0]['description'] ?? '';
                        $currentDetails = extractStudentDetails($text);
                        
                        // Debug logging
                        error_log("Processing SF9 page {$pageNumber}");
                        error_log("Extracted text: " . substr($text, 0, 500) . "..."); // Log first 500 chars
                        error_log("Found details: " . print_r($currentDetails, true));
                        
                        // If this page has a general average, use it
                        if (!empty($currentDetails['generalAverage'])) {
                            $sf9Details['generalAverage'] = $currentDetails['generalAverage'];
                            error_log("Found general average: {$currentDetails['generalAverage']}");
                        }

                        $pageNumber++;
                        
                    } catch (Exception $e) {
                        $errors[] = "Error processing SF9 page {$pageNumber}: " . $e->getMessage();
                        error_log("Error processing SF9 page {$pageNumber}: " . $e->getMessage());
                    }
                }
            }

            // After processing all pages, verify if we found the general average
            if (empty($sf9Details['generalAverage'])) {
                $errors[] = "Could not find general average in any of the uploaded SF9 pages";
                error_log("General average not found in any page");
            } else {
                $sf9Verified = true;
                error_log("SF9 verification successful. General Average: " . $sf9Details['generalAverage']);
            }
        }

        // Process Birth Certificate - simplified to just mark as verified
        if (isset($_FILES['birth_certificate']) && is_uploaded_file($_FILES['birth_certificate']['tmp_name'])) {
            $birthCertVerified = true;
        }

        // Handle verification results
        if (!empty($errors)) {
            $_SESSION['verification_errors'] = $errors;
            header('Location: ../requirements.php?error=verification');
            exit();
        }

        // If everything is verified, proceed with redirection
        if ($sf9Verified && $birthCertVerified) {
            error_log("Both documents verified successfully");
            
            // Debug the redirection conditions
            error_log("Student Type: " . $studentType);
            error_log("Grade Level: " . $gradeLevel);
            error_log("General Average: " . ($sf9Details['generalAverage'] ?? 'not found'));
            
            // Redirect based on conditions
            if ($studentType === "New Student" && $gradeLevel === "Grade 7" && 
                !empty($sf9Details['generalAverage']) && $sf9Details['generalAverage'] >= 90) {
                error_log("Redirecting to power_up.php");
                header("Location: ../power_up.php");
            } else {
                error_log("Redirecting to rda.php");
                header("Location: ../rda.php");
            }
            exit();
        } else {
            error_log("Verification failed. SF9: $sf9Verified, Birth Cert: $birthCertVerified");
            $_SESSION['verification_errors'] = ["Document verification failed. Please check your uploads."];
            header('Location: ../requirements.php?error=verification');
            exit();
        }

        // Add this to check file uploads
        error_log("Files received:");
        error_log("SF9 files: " . print_r($_FILES['sf9_files'] ?? 'not set', true));
        error_log("Birth certificate: " . print_r($_FILES['birth_certificate'] ?? 'not set', true));
    }
?>