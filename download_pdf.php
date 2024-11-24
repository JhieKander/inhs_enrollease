<?php
// download_pdf.php
if (isset($_POST['pdf_file'])) {
    $file = $_POST['pdf_file'];

    // Check if the file exists
    if (file_exists($file)) {
        // Set headers for download
        header('Content-Description: File Transfer');
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        header('Content-Length: ' . filesize($file));
        header('Pragma: public');

        // Clear output buffer
        ob_clean();
        flush();

        // Read the file and send it to the user
        readfile($file);
        exit;
    } else {
        echo "File does not exist.";
    }
} else {
    echo "No file specified.";
}
