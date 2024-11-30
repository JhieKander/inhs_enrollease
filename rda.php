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
                                        <?php
                                            // Check if English_Video exists for current student
                                            $checkEnglishVideo = $conn->prepare("SELECT English_Video FROM readingskills_result WHERE StudentID_Number = ?");
                                            $checkEnglishVideo->bind_param("i", $_SESSION['StudentID_Number']);
                                            $checkEnglishVideo->execute();
                                            $resultEnglishVideo = $checkEnglishVideo->get_result();
                                            $rowEnglishVideo = $resultEnglishVideo->fetch_assoc();

                                            // Enable button if video exists
                                            $disabled = !empty($rowEnglishVideo['English_Video']) ? 'disabled' : '';
                                        ?>
                                        <button class="start-english" id="record-button" <?php echo $disabled; ?> onclick="window.location.href='english_videoprompt.php'">Start Recording</button>
                                    </div>
                                    <div class="assessment-card">
                                        <i class="fas fa-video icon"></i>
                                        <h2>Filipino Assessment</h2>
                                        <?php
                                            // Check if Filipino_Video exists for current student
                                            $checkFilipinoVideo = $conn->prepare("SELECT Filipino_Video FROM readingskills_result WHERE StudentID_Number = ?");
                                            $checkFilipinoVideo->bind_param("i", $_SESSION['StudentID_Number']);
                                            $checkFilipinoVideo->execute();
                                            $resultFilipinoVideo = $checkFilipinoVideo->get_result();
                                            $rowFilipinoVideo = $resultFilipinoVideo->fetch_assoc();

                                            // Enable button if video exists
                                            $disabled = !empty($rowFilipinoVideo['Filipino_Video']) ? 'disabled' : '';
                                        ?>
                                        <button class="start-filipino" <?php echo $disabled; ?> onclick="window.location.href='filipino_videoprompt.php'">Start Recording</button>
                                    </div>
                                </div>
                                <?php
                                    // Check if English_Video exists for current student
                                    $checkVideo = $conn->prepare("SELECT English_Video, Filipino_Video FROM readingskills_result WHERE StudentID_Number = ?");
                                    $checkVideo->bind_param("i", $_SESSION['StudentID_Number']);
                                    $checkVideo->execute();
                                    $result = $checkVideo->get_result();
                                    $row = $result->fetch_assoc();
                                    
                                    // Enable button if video exists
                                    $disabled = empty($row['English_Video']) && empty($row['Filipino_Video']) ? 'disabled' : '';
                                ?>
                                <button class="proceed-button" <?php echo $disabled; ?> onclick="window.location.href='id_upload.php'">Proceed</button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
    <script src="JavaScript/sessionTimeout.js"></script>
</body>
</html>

<?php
    include 'footer.php';
?>