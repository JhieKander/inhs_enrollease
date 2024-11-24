<?php
    include 'header.php';
    include 'Database/database_conn.php';

    // Query to get the latest academic year
    $sql = "SELECT Academic_Year FROM academic_year ORDER BY AcademicYear_ID DESC LIMIT 1";
    $result = $conn->query($sql);

    // Fetch the latest academic year data
    $latestAcademicYear = null;
    if ($result && $result->num_rows > 0) {
        $latestAcademicYear = $result->fetch_assoc();
    }

    // Query to get the latest 10 news items
    $sqlNews = "SELECT News_Title, News_Date, News_Desc, News_Image FROM news ORDER BY News_Date DESC LIMIT 10";
    $resultNews = $conn->query($sqlNews);

    // Query to get the latest 10 images from the gallery
    $sqlGallery = "SELECT Gallery_Image FROM gallery ORDER BY Gallery_ID DESC LIMIT 10";
    $resultGallery = $conn->query($sqlGallery);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>EnrollEase: Home</title>
        <link rel="icon" href="images/d92301_79a357f813014ac3957588d11a255055~mv2_d_1969_2362_s_2.png" type="image/x-icon">
        <link rel="stylesheet" href="CSS/home.css">
    </head>
    <body>
        <section class="hero">
            <h1>School Admission for</h1>
            <h2>School Year: <?php echo $latestAcademicYear ? htmlspecialchars($latestAcademicYear['Academic_Year']) : 'Not Available';?></h2>
            <h2>is now open!</h2>
            <button><a href="student_type.php">Start Application</a></button>
        </section>
        
        <section class="program">
            <h2>PROGRAM</h2>
            <div class="tags">
                <span class="active">SSLG</span>
                <span>Interact Club</span>
                <span>Panitik Imuseño</span>
                <span>YES-O</span>
                <span>Junior Medics</span>
                <span>Junior Polaris</span>
                <span>Teatro Imuseño</span>
            </div>
            <div class="content">
                <div style="display: flex; align-items: center;">
                    <img alt="Program logo" height="200" src="images/Untitled-removebg-preview.png" width="150"/>
                    <div>
                        <h3>Supreme Secondary Learner Government</h3>
                        <p>The official student governing body of Imus National High School.</p>
                    </div>
                    <span class="next-button">&gt;</span>
                </div>
            </div>
        </section>

        <section class="news">
            <h2>NEWS AND UPDATES</h2>
            <p>Stay updated with us!</p>
            
            <div class="news-carousel">
                <button class="previ-button">&lt;</button>
                <div class="news-items-container">
                    <div class="news-items">
                        <?php
                            // Check if there are results and display each news item
                            if ($resultNews && $resultNews->num_rows > 0) {
                                while ($row = $resultNews->fetch_assoc()) {
                                    // Construct the full path to the image
                                    $imagePath = 'images/news/' . htmlspecialchars($row['News_Image']); // Assuming the image is saved in 'images/news/' directory
                                    ?>
                                    <div class="news-item" data-title="<?php echo htmlspecialchars($row['News_Title']); ?>" data-date="<?php echo htmlspecialchars($row['News_Date']); ?>" data-description="<?php echo htmlspecialchars($row['News_Desc']); ?>" data-image="<?php echo $imagePath; ?>">
                                        <img alt="<?php echo htmlspecialchars($row['News_Title']); ?>" src="<?php echo $imagePath; ?>" height="200" width="200"/>
                                        <p><?php echo htmlspecialchars($row['News_Title']); ?></p>
                                        <p><?php 
                                                // Create a DateTime object from the date string
                                                $date = new DateTime($row['News_Date']); 
                                                // Format the date as "November 22, 2024, Friday"
                                                echo htmlspecialchars($date->format('F j, Y, l')); 
                                            ?>
                                        </p>
                                    </div>
                                    <?php
                                }
                            } else {
                                echo "<p>No news items available.</p>";
                            }
                        ?>
                    </div>
                </div>
                <button class="nexti-button">&gt;</button>
            </div>
        </section>

        <!-- Modal Structure -->
        <div id="newsModal" class="modal">
            <div class="modal-content">
                <span class="close-modal">&times;</span>
                <img src="" alt="Full news image" class="modal-img" height="200" width="350">
                <h3 class="modal-title"></h3>
                <p class="modal-date"></p>
                <p class="modal-description"></p>
            </div>
        </div>

        <section class="gallery">
            <div class="head"></div>
            <div class="carousel">
                <?php
                    // Check if there are results and display each image
                    if ($resultGallery && $resultGallery->num_rows > 0) {
                        while ($row = $resultGallery->fetch_assoc()) {
                            // Construct the full path to the image
                            $imagePath = 'images/gallery/' . htmlspecialchars($row['Gallery_Image']); // Assuming images are saved in 'images/gallery/' directory
                            ?>
                                <img alt="Gallery Image" src="<?php echo $imagePath; ?>" height="266" width="288" class="carousel-img"/>
                            <?php
                        }
                    } else {
                        echo "<p>No images available in the gallery.</p>";
                    }
                ?>
            </div>
        </section>
        <div class="modal1" id="myModal">
            <span class="close" id="closeModal"> ×</span>
            <div class="modal-content1">
                <img alt="Modal Image" class="modal-image" id="modalImage" src=""/>
            </div>
        </div>

        <section class="content-section">
            <div class="left-side">
                <div class="profile">
                    <img alt="Principal Profile Picture" height="150" src="images/Ellipse_204.png" width="150"/>
                    <div class="profile-info">
                        <h2>Arturo P. Rosaroso Jr.</h2>
                        <p>Principal IV</p>
                    </div>
                </div>
            </div>
            <div class="right-side">
                <div class="section">
                    <h2>Mission</h2>
                    <p class="mal">To protect and promote the right of every Filipino to quality, equitable, culture-based, and complete basic 
                        education where:</p>
                    <p class="norm">Students learn in a child-friendly, gender-sensitive, safe and motivating environment</p>
                    <p class="norm">Teachers facilitate learning and constantly nurture every learner</p>
                    <p class="norm">Administrators and staff, as stewards of the institution, ensure an enabling and supportive environment for 
                        effective learning to happen</p>
                    <p class="norm">Family, community and other stakeholders are actively engaged and share responsibility for developing 
                        lifelong learners.</p>
                </div>
                <hr class="red-line"/>
                <div class="section">
                    <h2>Vision</h2>
                    <p class="mal">We dream of Filipinos who passionately love their country and whose competencies and values enable 
                        them to realize their full potential and contribute meaningfully to building the nation.</p>
                    <p class="mal">We are a learner-centered public institution, the Department of Education continuously improves 
                        itself to better serve its stakeholders.</p>
                </div>
            </div>
        </section>
    </body>
        <script src="JavaScript/orgs.js" defer></script>
</html>

<?php
    include 'footer.php';
?>