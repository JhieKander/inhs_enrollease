document.getElementById('browseLink').addEventListener('click', function() {
    document.getElementById('fileInput').click();
});

document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");
    const fileInput = document.getElementById("fileInput");
    const uploadArea = document.getElementById("uploadArea");

    // Ensure modals exist before using them
    const successModal = document.getElementById('successModal');
    const invalidImageModal = document.getElementById('invalidImageModal');

    // Function to handle file upload
    function handleFileUpload(event) {
        const files = fileInput.files;
        if (files.length === 0) {
            event.preventDefault(); // Prevent form submission
            const uploadErrorModal = document.getElementById('uploadErrorModal');
            if (uploadErrorModal) {
                uploadErrorModal.style.display = 'block'; // Show error modal
            }
            return false;
        }
        
        // Continue with the upload process
        // Prevent default submission to handle the response from the server
        event.preventDefault(); // Prevent form submission
        const formData = new FormData(form);
        
        // Use fetch to submit the form data
        fetch('PHP/upload_picture.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showSuccessModal(); // Show success modal
            } else {
                showInvalidImageModal(); // Show invalid image modal
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });

        return false; // Prevent form submission
    }

    // Attach the handleFileUpload function to form submit event
    if (form) {
        form.addEventListener('submit', handleFileUpload);
    }
});

uploadArea.addEventListener('dragover', (event) => {
    event.preventDefault();
    uploadArea.style.backgroundColor = '#e0f7fa';
});

uploadArea.addEventListener('dragleave', () => {
    uploadArea.style.backgroundColor = '#f9f9f9';
});

uploadArea.addEventListener('drop', (event) => {
    event.preventDefault();
    uploadArea.style.backgroundColor = '#f9f9f9';
    const files = event.dataTransfer.files;
    if (files.length > 0) {
        fileInput.files = files;
        updateFileDetails(files[0]);
    }
});

fileInput.addEventListener('change', (event) => {
    const files = event.target.files;
    if (files.length > 0) {
        updateFileDetails(files[0]);
    }
});

function updateFileDetails(file) {
    fileName.textContent = file.name;
    fileSize.textContent = `${(file.size / (1024 * 1024)).toFixed(2)} MB`;
    const reader = new FileReader();
    reader.onload = function(e) {
        uploadIcon.style.display = 'none';
        uploadText.style.display = 'none';
        const existingImage = uploadArea.querySelector('img');
        if (existingImage) {
            existingImage.remove();
        }
        const img = document.createElement('img');
        img.src = e.target.result;
        img.style.maxWidth = '100%';
        img.style.maxHeight = '100%';
        uploadArea.appendChild(img);
    }
    reader.readAsDataURL(file);
}