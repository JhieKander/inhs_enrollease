<?php
    include 'header.php';
    include 'PHP/englishmaterial.php';

    session_start(); // Start the session

    // Check if the user is already logged in
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        header('Location: login_student.php'); // Redirect to login page if not logged in
        exit; // Stop further execution
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EnrollEase: Student Application</title>
    <link rel="icon" href="Images/d92301_79a357f813014ac3957588d11a255055~mv2_d_1969_2362_s_2.png" type="image/x-icon" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="CSS/normalize.css">
    <link rel="stylesheet" href="CSS/assessment.css">
    <link rel="stylesheet" href="CSS/tele-video.css">
</head>
<body>
    <main>
        <div class="contain">
            <section class="welcome">
                <?php include 'profile_card.php'; ?>
                <div class="application">
                    <div class="application-note">
                        <h2>Complete your application</h2>
                        <p> Complete the reading skills assessment today by recording a video and adhering to the teleprompter displayed on your screen. </p>
                    </div>
                </div>
            </section>
            <section class="form">
                <?php include 'sidebar.php'; ?>
                <div class="content">
                    <h1>Application</h1>
                    <hr>
                    <div class="form-row">
                        <?php include 'progress.php'; ?>
                        <div class="tainer">
                            <h1 class="main-title">Reading Skills Assessment [<?php echo $title; ?> - <?php echo $languageMaterial; ?>]</h1>
                            <div class="description">Complete the reading skills assessment today by recording a video and adhering to the teleprompter displayed on your screen.</div>
                            <div class="divider"></div>
                            <div class="assessment-container">
                                <div class="tele-container">
                                    <div id="teleprompter">
                                        <p><?php echo $context; ?></p>
                                    </div>
                                    <div id="video-container">
                                        <video id="video" autoplay muted></video>
                                        <button id="startRecording">START RECORDING</button>
                                        <button id="stopRecording" style="display: none;">STOP RECORDING</button>
                                    </div>
                                </div>
                            </div>
                            <?php
                                // Check if English_Video exists for current student
                                $checkVideo = $conn->prepare("SELECT English_Video FROM readingskills_result WHERE StudentID_Number = ?");
                                $checkVideo->bind_param("i", $_SESSION['StudentID_Number']);
                                $checkVideo->execute();
                                $result = $checkVideo->get_result();
                                $row = $result->fetch_assoc();
                                
                                // Enable button if video exists
                                $disabled = empty($row['English_Video']) ? 'disabled' : '';
                            ?>
                            <button class="proceed-button" id="proceed-button" <?php echo $disabled; ?> onclick="window.location.href='english_passage.php'">Proceed</button>
                            <script>
                                // Re-check video status after recording
                                document.getElementById('stopRecording').addEventListener('click', function() {
                                    // Use AJAX to check the video status without reloading the page
                                    fetch('PHP/check_video_status.php')
                                        .then(response => response.json())
                                        .then(data => {
                                            const proceedButton = document.getElementById('proceed-button');
                                            proceedButton.disabled = !data.videoExists; // Enable or disable button based on video existence
                                        });
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
    <script src="JavaScript/video-tele.js"></script>
    <script src="JavaScript/sessionTimeout.js"></script>
</body>
<?php
    include 'footer.php';
?>