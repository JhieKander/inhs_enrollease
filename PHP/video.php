<?php
require_once __DIR__ . '/../vendor/autoload.php';

use FFMpeg\FFMpeg;
use FFMpeg\Exception\RuntimeException;
use FFMpeg\Format\Audio\Wav; // Import the Wav class

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the video file is uploaded
    if (isset($_FILES['video']) && $_FILES['video']['error'] === UPLOAD_ERR_OK) {
        // Generate a unique identifier for each upload (timestamp + unique id)
        $uniqueId = uniqid('video_', true);
        $videoFileName = $uniqueId . '.' . pathinfo($_FILES['video']['name'], PATHINFO_EXTENSION);
        $audioFileName = $uniqueId . '.wav';  // Use the same unique ID for audio file

        // Define the video and audio file paths
        $videoFilePath = 'C:\\XAMPP2\\htdocs\\inhs\\upload_videos\\' . $videoFileName;
        $audioFilePath = 'C:\\XAMPP2\\htdocs\\inhs\\upload_audio\\' . $audioFileName;

        // Move the uploaded video file
        if (!move_uploaded_file($_FILES['video']['tmp_name'], $videoFilePath)) {
            echo json_encode(['error' => 'Failed to upload video file.']);
            exit;
        }

        // Check if the video file exists and is not empty
        if (!file_exists($videoFilePath) || filesize($videoFilePath) === 0) {
            echo json_encode(['error' => 'Uploaded video file is empty or not found.']);
            exit;
        }

        // Extract audio from the video file using php-ffmpeg
        try {
            $ffmpeg = FFMpeg::create();
            $video = $ffmpeg->open($videoFilePath);
            $audioFormat = new Wav(); // Use the imported Wav class

            // Extract audio
            $video->save($audioFormat, $audioFilePath);

            // Check if the audio file was created and is not empty
            if (file_exists($audioFilePath) && filesize($audioFilePath) > 0) {
                // Transcribe the extracted audio
                $transcription = transcribeAudio($audioFilePath);
                echo json_encode(['transcription' => $transcription]);
            } else {
                echo json_encode(['error' => 'Audio extraction succeeded, but output file is empty.']);
            }
        } catch (RuntimeException $e) {
            echo json_encode(['error' => 'Audio extraction failed: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['error' => 'No video file uploaded.']);
    }
}

function transcribeAudio($audioFilePath) {
    $pocketsphinxPath = 'C:\\Users\\63928\\AppData\\Local\\Programs\\Python\\Python39\\python.exe';
    $dictionaryPath = 'C:\\pocketsphinx\\model\\en-us\\cmudict-en-us.dict';
    $modelPath = 'C:\\pocketsphinx\\model\\en-us\\en-us';

    $command = "$pocketsphinxPath -infile " . escapeshellarg($audioFilePath) . " -dict " . escapeshellarg($dictionaryPath) . " -hmm " . escapeshellarg($modelPath);
    
    $output = [];
    $returnVar = 0;
    exec($command, $output, $returnVar);

    if ($returnVar !== 0) {
        return json_encode(['error' => 'Error transcribing audio.', 'details' => implode("\n", $output)]);
    }

    return implode("\n", $output);
}

// Optional: Ensure correct pronunciation (forvo integration)
function getForvoPronunciation($word) {
    $apiKey = '9ae1574871d2c8a3bf24cb2bfbdddb64'; // Replace with your Forvo API key
    $url = "https://apifree.forvo.com/action/word-pronunciations/format/json/word/" . urlencode ($word) . "/language/tl/key/$apiKey";

    $response = file_get_contents($url);
    $data = json_decode($response, true);

    if (isset($data['items']) && count($data['items']) > 0) {
        return $data['items'][0]['pathmp3']; // Return the first pronunciation audio URL
    }

    return null; // No pronunciation found
}
?>