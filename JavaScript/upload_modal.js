function handleFileUpload(event) {
    const files = fileInput.files;
    if (files.length === 0) {
        event.preventDefault(); // Prevent form submission
        document.getElementById('uploadErrorModal').style.display = 'block';
        return false;
    }
    // Continue with the upload process
    return true;
}

function closeModal() {
    document.getElementById('successModal').style.display = 'none';
}

function closeInvalidImageModal() {
    document.getElementById('invalidImageModal').style.display = 'none';
}

function closeUploadErrorModal() {
    document.getElementById('uploadErrorModal').style.display = 'none'; // Hide the error modal
}

// Function to display the success modal
function showSuccessModal() {
    var modal = document.getElementById('successModal');
    if (modal) {
        modal.style.display = 'block';
        document.querySelector('#successModal button').onclick = function() {
            window.location.href = 'submit_reqs.php'; // Redirect after closing modal
        };
    } else {
        console.error('Success modal not found in the DOM.');
    }
}

// Function to display the invalid image modal
function showInvalidImageModal() {
    document.getElementById('invalidImageModal').style.display = 'block';
}

// Ensure to call this function on form submission
document.querySelector('form').addEventListener('submit', handleFileUpload);