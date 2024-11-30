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
    <link rel="stylesheet" href="CSS/subs.css">
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
                <div class="sidebar">
                    <a href="details.php">Accounts & Privacy</a>
                    <a href="application.php">My Application</a>
                    <a href="subjects.php" class="active">Schedule</a>
                </div>
                <div class="content">
                    <h1>Application</h1>
                    <hr>
                    <div class="enrolled">
                        <div class="application">
                            <div class="application-note">
                                <h2>You are enrolled for School Year 2024-2025</h2>
                                <p>Congratulations! You are now officially enrolled student in Imus National High School.</p>
                            </div>
                        </div>
                    </div>
                    
                    <table>
                        <tr>
                            <td colspan="4" class="table-header">GRADE 7 - ADELFA</td>
                        </tr>
                        <tr>
                            <th>SUBJECT</th>
                            <th>TEACHER</th>
                            <th>SCHEDULE</th>
                            <th>ROOM</th>
                        </tr>
                        <tr>
                            <td>Araling Panlipunan</td>
                            <td>Sarah Duts</td>
                            <td>5:30am-6:30am</td>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td>English</td>
                            <td>Harry Roque</td>
                            <td>6:30am-7:30am</td>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td>Filipino</td>
                            <td>Alice Guo</td>
                            <td>7:30am-8:30am</td>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td>Mathematics</td>
                            <td>Inday Sara</td>
                            <td>8:30am-9:30am</td>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td>Music, Arts, P.E. & Health</td>
                            <td>Robin Padilla</td>
                            <td>10:00am-11:00am</td>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td>Science</td>
                            <td>Cynthia Villar</td>
                            <td>11:00am-12:00pm</td>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td>Technology & Livelihood Education</td>
                            <td>Marcos</td>
                            <td>TBA</td>
                            <td>-</td>
                        </tr>
                    </table>

                    <p class="remind">
                        <span class="bold">Reminder:</span>
                        Assigned schedules and teachers may change without prior notice.
                    </p>
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