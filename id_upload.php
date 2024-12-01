<?php
    include 'header.php';

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
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <link rel="stylesheet" href="CSS/normalize.css">
    <link rel="stylesheet" href="CSS/uploadID.css">
</head>
<body>
    <main>
        <div class="contain">
            <section class="welcome">
                <?php include 'profile_card.php'; ?>
                <div class="application">
                    <div class="application-note">
                        <h2>Complete your application</h2>
                        <p>Upload your 1X1 ID picture with white background to be used for your School ID.</p>
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

                        <h3>Attach your ID Picture</h3>
                        <h4>Upload you 1X1 ID Picture with <span style="font-weight: bold;">white background</span> and by wearing an <span style="font-weight: bold;">appropriate attire</span>.</h4>

                        <form method="POST" enctype="multipart/form-data">
                            <div class="upload-container">
                                <div class="upload-area" id="uploadArea">
                                    <i class="fas fa-image" id="uploadIcon"></i>
                                    <p id="uploadText">Drag image here.<br>or</p>
                                    <a id="browseLink"><i class="fas fa-folder-open"></i>Browse image</a>
                                    <input type="file" id="fileInput" name="fileInput" accept="image/*" style="display: none;">
                                </div>
                                <div class="upload-details">
                                    <p class="file-name" id="fileName">attachment.file</p>
                                    <p class="file-size" id="fileSize">0 MB</p>
                                    <div class="thin-line"></div>
                                    <button type="submit" class="upload-button">Upload</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
        
        <!-- Success Modal -->
        <div class='modal' id='successModal' style='display:none;'>
            <div class='modal-content'>
                <h2>Success!</h2>
                <p>ID Picture uploaded successfully!</p>
                <button>OK</button>
            </div>
        </div>

        <!-- Invalid Image Modal -->
        <div class='modal' id='invalidImageModal' style='display:none;'>
            <div class='modal-content'>
                <h2>Invalid Image</h2>
                <p>The image uploaded cannot be used for your ID Picture.</p>
                <button onclick='closeInvalidImageModal()'>OK</button>
            </div>
        </div>

        <!-- Upload Error Modal -->
        <div class='modal' id='uploadErrorModal' style='display:none;'>
            <div class='modal-content'>
                <h2>Warning</h2>
                <p>No file selected. Please upload an image.</p>
                <button onclick='closeUploadErrorModal()'>OK</button>
            </div>
        </div>
    </main>
    <script src="JavaScript/upload_modal.js" defer></script>
    <script src="JavaScript/upload.js" defer></script>
    <script src="JavaScript/sessionTimeout.js"></script>
</body>
</html>

<?php
    include 'footer.php';
?>