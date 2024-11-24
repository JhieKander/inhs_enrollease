let mediaRecorder;
let recordedChunks = [];
let videoStream;
let startTime;  // Variable to store the start time of the recording

// Access user's webcam and microphone
document.getElementById('startRecording').onclick = async () => {
    // Request both video and audio
    videoStream = await navigator.mediaDevices.getUserMedia({ video: true, audio: true });
    const video = document.getElementById('video');
    video.srcObject = videoStream;

    // Initialize media recorder with video and audio stream
    mediaRecorder = new MediaRecorder(videoStream);
    mediaRecorder.start();

    // Store the start time
    startTime = Date.now();

    mediaRecorder.ondataavailable = event => {
        recordedChunks.push(event.data);
    };

    mediaRecorder.onstop = async () => {
        const blob = new Blob(recordedChunks, { type: 'video/mp4' });
        const videoFile = new File([blob], 'recorded_video.mp4', { type: 'video/mp4' });
        const formData = new FormData();
        formData.append('video', videoFile);
        
        // Send video file to server for processing
        const response = await fetch('PHP/video.php', {
            method: 'POST',
            body: formData
        });
        
        const textResponse = await response.text();
        console.log("Video Processing Response:", textResponse);  // Log the raw response
    
        try {
            const result = JSON.parse(textResponse);
            const transcription = result.transcription; // Assume this is the transcription returned
    
            // Now check pronunciation
            const pronunciationResponse = await fetch('PHP/check_pronunciation.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'transcription=' + encodeURIComponent(transcription)
            });
    
            const pronunciationTextResponse = await pronunciationResponse.text();
            console.log("Pronunciation Checking Response:", pronunciationTextResponse);  // Log the raw response
    
            const pronunciationResult = JSON.parse(pronunciationTextResponse);
            console.log("Number of correctly pronounced words: " + pronunciationResult.correctPronunciations);
        } catch (error) {
            console.error("Error parsing JSON:", error);
            console.error("Server Response (HTML):", textResponse);
        }
    
        // Get the video duration in seconds and log it
        const videoLength = getVideoDurationInSeconds();
        console.log('Video Duration (in seconds):', videoLength);
    };

    // Show Stop Recording button and hide Start Recording button
    document.getElementById('stopRecording').style.display = 'block';
    document.getElementById('startRecording').style.display = 'none';
};

document.getElementById('stopRecording').onclick = () => {
    mediaRecorder.stop();
    videoStream.getTracks().forEach(track => track.stop()); // Stop all video and audio tracks
    
    // Hide Stop Recording button and show Start Recording button
    document.getElementById('stopRecording').style.display = 'none';
    document.getElementById('startRecording').style.display = 'block';
};

// Function to calculate the video's length in seconds
function getVideoDurationInSeconds() {
    if (startTime) {
        const endTime = Date.now();
        const durationInMillis = endTime - startTime;  // Duration in milliseconds
        return Math.floor(durationInMillis / 1000);  // Convert to seconds
    }
    return 0;
}

function uploadVideo() {
    const videoDuration = getVideoDurationInSeconds();
    const formData = new FormData();
    const videoFile = document.getElementById('videoInput').files[0]; // Assuming there's an input with id 'videoInput'

    formData.append('video', videoFile);
    formData.append('duration', videoDuration); // Append duration

    fetch('PHP/video.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
