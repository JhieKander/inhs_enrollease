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
    <link rel="stylesheet" href="CSS/done.css">
</head>
<body>
    <main>
        <div class="contain">
            <section class="welcome">
                <div class="profile">
                    <div class="profile-img">
                        <img src="images/user_profile_female_icon_192701.png" alt="Profile Picture">
                    </div>
                    <div class="profile-info">
                        <p class="comewel">Welcome!</p>
                        <h2>Sakura Miyawaki</h2>
                        <p>Student</p>
                        <button>Log Out</button>
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
                    <div class="application">
                        <div class="application-note">
                            <h2>You are enrolled for School Year 2024-2025</h2>
                            <p>Congratulations! You are now officially enrolled student in Imus National High School.</p>
                        </div>
                        <div class="image-pencil">
                            <img src="images/pencil.png">
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