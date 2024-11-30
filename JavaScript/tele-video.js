let mediaRecorder;
let recordedChunks = [];
let videoStream;
let startTime;  // Variable to store the start time of the recording
let studentData; // Declare studentData variable

// Function to fetch student data
async function fetchStudentData() {
    try {
        const response = await fetch('PHP/get_student_data.php');
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        studentData = await response.json(); // Assuming the response is in JSON format
        console.log("Student Data:", studentData); // Log the student data for debugging
    } catch (error) {
        console.error("Error fetching student data:", error);
    }
}

// Call the function to fetch student data
fetchStudentData();

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
        // Get the video duration in seconds and log it
        const videoLength = getVideoDurationInSeconds();
        console.log('Video Duration (in seconds):', videoLength);

        const blob = new Blob(recordedChunks, { type: 'video/mp4' });
        const date = new Date().toLocaleString('en-US', { 
            year: 'numeric',
            month: '2-digit', 
            day: '2-digit',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        }).replace(/[/:,\s]/g, ''); // Format as YYYYMMDDhhmmss
        // Construct a unique filename using StudentID_Number, Student_LastName, and Date
        const videoFileName = `${studentData.StudentID_Number}-${studentData.Student_LastName}-${date}.mp4`; 
        const videoFile = new File([blob], videoFileName, { type: 'video/mp4' });
        const formData = new FormData();
        formData.append('video', videoFile);
        
        // Send video file to server for processing
        const response = await fetch('PHP/video_upload.php', {
            method: 'POST',
            body: formData
        });
        
        const textResponse = await response.text();
        console.log("Video Processing Response:", textResponse);  // Log the raw response

        try {
            const videoLocation = `upload_videos/Filipino/${videoFileName}`; // Construct the video location
            const saveLocationResponse = await fetch('PHP/video_save_location.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    studentID: studentData.StudentID_Number,
                    videoLocation: videoLocation,
                    readingTime: videoLength // Include video length in the request
                })
            });

            const saveLocationTextResponse = await saveLocationResponse.text(); // Get raw response text
            console.log("Save Video Location Response:", saveLocationTextResponse); // Log the raw response

            try {
                const saveLocationResult = JSON.parse(saveLocationTextResponse); // Attempt to parse JSON
                console.log("File Location:", saveLocationResult.fileLocation);
            } catch (error) {
                console.error("Error parsing JSON:", error);
                console.error("Server Response (HTML):", saveLocationTextResponse); // Log the raw response for debugging
            }

        } catch (error) {
            console.error("Error parsing JSON:", error);
            console.error("Server Response (HTML):", textResponse);
        }
    };

    // Show Stop Recording button and hide Start Recording button
    document.getElementById('stopRecording').style.display = 'inline'; // Show stop button
    document.getElementById('startRecording').style.display = 'none';
};

document.getElementById('stopRecording').addEventListener('click', () => {
    if (mediaRecorder) {
        console.log("Stop button clicked. MediaRecorder state:", mediaRecorder.state); // Log the state of mediaRecorder
        if (mediaRecorder.state === "recording") {
            mediaRecorder.stop(); // Stop the recording
            videoStream.getTracks().forEach(track => track.stop()); // Stop all video and audio tracks
            
            // Hide the stop button and show the start button
            document.getElementById('stopRecording').style.display = 'none'; // Hide stop button
            document.getElementById('startRecording').style.display = 'inline'; // Show start button
            console.log("Recording stopped."); // Debugging statement
        } else {
            console.warn("MediaRecorder is not in the recording state."); // Log warning if not recording
        }
    } else {
        console.warn("MediaRecorder is not initialized."); // Log warning if not initialized
    }
});

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

    fetch('PHP/upload_video.php', {
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
