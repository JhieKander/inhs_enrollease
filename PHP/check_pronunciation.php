<?php
header('Content-Type: application/json');
include 'Database/database_conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    set_time_limit(60);
    
    $transcription = $_POST['transcription']; // Get transcription from the AJAX request
    $words = preg_split('/\s+/', $transcription); // Split transcription into words
    $correctPronunciations = 0;

    foreach ($words as $word) {
        $pronunciation = getForvoPronunciation($word);
        if ($pronunciation) {
            $correctPronunciations++;
        }
    }

    echo json_encode(['correctPronunciations' => $correctPronunciations]);
    exit;
}

function getForvoPronunciation($word) {
    if (empty($word) || !is_string($word)) {
        return null; // Return null for invalid words
    }

    $apiKey = '9ae1574871d2c8a3bf24cb2bfbdddb64';
    $url = "https://apifree.forvo.com/action/word-pronunciations/format/json/word/" . urlencode($word) . "/language/tl/key/$apiKey";
    
    $response = @file_get_contents($url); // Suppress warnings
    if ($response === false) {
        return null; // Return null if the request fails
    }

    $data = json_decode($response, true);
    if (isset($data['items']) && count($data['items']) > 0) {
        return $data['items'][0]['pathmp3']; // Return the first pronunciation audio URL
    }

    return null; // No pronunciation found
}
?>