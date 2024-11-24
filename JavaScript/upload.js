document.getElementById('browseLink').addEventListener('click', function() {
    document.getElementById('fileInput').click();
});

const uploadArea = document.getElementById('uploadArea');
const fileInput = document.getElementById('fileInput');
const fileName = document.getElementById('fileName');
const fileSize = document.getElementById('fileSize');
const uploadIcon = document.getElementById('uploadIcon');
const uploadText = document.getElementById('uploadText');

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