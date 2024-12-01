<?php
    // At the top of each protected page
   session_start();
   if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
       header('Location: login_student.php'); // Redirect to login page
       exit; // Stop further execution
   }
   
   include 'header.php';
    
?>

<html>
 <head>
  <title>EnrollEase: About Page</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&amp;display=swap" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Bokor&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="CSS/normalize.css">
  <link rel="stylesheet" href="CSS/abt.css">
 </head>
 <body>
 <div class="banner">
        <img src="images/Rectangle 403.png" alt="Historical Development of INHS" height="600" width="1920"/>
        <div class="overlay">
            <h1>The Historical Development of INHS</h1>
            <p>In 1969, with no funds for a new site, Bukandala Elementary School's teachers decided to build a high school on their grounds. The first public high school in Imus was established in 1971 with four classrooms. Mr. Teofilo Bartolome served as Assistant Principal with a small team, and by 1972, enrollment had grown significantly.</p>
            <p>Mrs. Crispino D. Suarez later managed both schools until Mrs. Nelda G. Datar became principal in 1981. With increasing enrollment, a 17,000 square meter site was secured for a permanent building, completed in 1982.</p>
        </div>
    </div>
    <div class="main-content">
        <div class="image">
            <img src="images/Rectangle 402.png" alt="Imus National High School" height="1000" width="1000"/>
        </div>
        <div class="text">
            <p>Renamed <span class="red">Imus National High School in 1994</span>, the school continued to grow, reaching 1,552 students and 60 teachers. Today, it serves 5,590 students with 96 faculty members and has ongoing expansions, including new classrooms and a school clinic.</p>
        </div>
    </div>
    <div class="info-section">
        <div class="left">
            <h2>PRINCIPAL CORNER</h2>
            <hr class="white-line"/>
            <p class="tit"><strong>Inspirational Message of the Principal</strong></p>
            <img src="images/Ellipse_204.png" alt="Principal Image" height="200" width="200"/>
            <p class="art">Arturo P. Rosaroso Jr.</p>
            <p>Principal IV</p>
            <p class="msg">Imus National High School is focused on the development of a pro-active student welfare management system. Let this website serve as our springboard to achieving greater goals for our school. Our pursuit for Excellence in both academic and extracurricular performances is still on top of our priorities, so let us put into good use this portal to information and communications technology by engaging in various activities that will strengthen our community linkages relationships. I am confident that with the aid of our God Almighty together, we will hit our targets.</p>
        </div>
        <div class="right">
            <h2>ORGANIZATIONAL CHART</h2>
            <hr class="white-line"/>
            <img src="images/school-org-new-format-copy_1_orig 1.png" alt="Organizational Chart" height="600" width="400"/>
        </div>
    </div>
 </body>
 <script src="JavaScript/sessionTimeout.js"></script>
</html>

<?php
    include 'footer.php';
?>