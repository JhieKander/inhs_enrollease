<?php
    include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EnrollEase: Student Application</title>
    <link rel="icon" href="Images/d92301_79a357f813014ac3957588d11a255055~mv2_d_1969_2362_s_2.png" type="image/x-icon" />

    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400..900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    
    <link rel="stylesheet" href="CSS/normalize.css">
    <link rel="stylesheet" href="CSS/assessment.css">
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
                <?php
                    include 'sidebar.php';
                ?>
                <div class="content">
                    <h1>Application</h1>
                    <hr>
                    <div class="form-row">
                        <?php include 'progress.php'; ?>
                        <div class="tainer">
                            <h1 class="main-title">Reading Skills Assessment</h1>
                                <div class="description">Complete the reading skills assessment today by recording a video and adhering to the teleprompter displayed on your screen. Make sure that you understand the story as after submitting the recording, you will be answering some question about the story.</div>
                                <div class="divider"></div>
                                <div class="assessment-container">
                                    <div class="assessment-card">
                                        <i class="fas fa-video icon"></i>
                                        <h2>English Assessment</h2>
                                        <button class="start-english" id="record-button">Start Recording</button>
                                    </div>
                                    <div class="assessment-card">
                                        <i class="fas fa-video icon"></i>
                                        <h2>Filipino Assessment</h2>
                                        <button class="start-filipino">Start Recording</button>
                                    </div>
                                </div>
                                <button class="proceed-button">Proceed</button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <script src="JavaScript/read.js"></script>
    <script src="JavaScript/check-read.js"></script>
</body>
</html>

<?php
    include 'footer.php';
?>