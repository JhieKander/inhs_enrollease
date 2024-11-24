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
    <link rel="stylesheet" href="CSS/reqs_hardcopy.css">
</head>
<body>
    <main>
        <div class="contain">
            <section class="welcome">
                <?php include 'profile_card.php'; ?>
                <div class="application">
                    <div class="application-note">
                        <h2>Complete your application</h2>
                        <p>Submit the hard copy of the needed requirement to the School's Registrar Office.</p>
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

                        <h3>Submission of Requirements to the School Registrar (Hard Copy)</h3>

                        <p>
                            Thank you for your enrollment submission. We kindly request you to carefully review and confirm 
                            that all the required documents and information have been submitted to the School Registrar's Office 
                            to facilitate the completion of your enrollment process. If you have any uncertainties or if further 
                            assistance is needed, please do not hesitate to reach out our admission office at:
                        </p>

                        <div class="contact-info">
                            <div class="contact-item">
                                <i class="fas fa-envelope"></i>
                                <a href="mailto:imusnhs@yahoo.com">imusnhs@yahoo.com</a>
                            </div>
                            <div class="contact-item">
                                <i class="fas fa-phone-alt"></i>
                                <span>(046) 544-3601</span>
                            </div>
                            <div class="contact-item">
                                <i class="fas fa-globe"></i>
                                <a href="http://imusnhs.edu.ph">imusnhs.edu.ph</a>
                            </div>
                        </div>

                        <p class="italic">
                            "If you already submitted the requirements and upon checking by the admission officer, this page will 
                            automatically changed once the requirements checked out."
                        </p>
                    </div>
                </div>
            </section>
        </div>
    </main>
</body>
</html>

<?php
    include 'footer.php';
?>