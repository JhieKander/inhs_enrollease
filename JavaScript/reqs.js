document.addEventListener('DOMContentLoaded', function () {
    const warningModal = document.getElementById('warningModal');
    const modalOkButton = document.getElementById('modalOkButton');
    const sf9Input = document.getElementById("sf9-input");
    const birthCertInput = document.getElementById("birth-cert-input");
    const submitButton = document.querySelector(".button-container button");
    const form = document.getElementById("upload-form");

    // Ensure modal elements exist before adding listeners
    if (warningModal && modalOkButton) {
        // Function to show the warning modal
        function showWarningModal() {
            warningModal.style.display = 'block';
        }

        // Close the warning modal when the user clicks the "OK" button or the close icon
        modalOkButton.addEventListener('click', function () {
            warningModal.style.display = 'none';
        });

        document.querySelector('.close-button').addEventListener('click', function () {
            warningModal.style.display = 'none';
        });
    }

    // Event listener for form submission
    form.addEventListener('submit', function (event) {
        const sf9 = sf9Input.files.length > 0;
        const birthCert = birthCertInput.files.length > 0;

        // If required files are missing, prevent submission and show modal
        if (!sf9 || !birthCert) {
            event.preventDefault(); // Prevent form submission
            if (warningModal) {
                showWarningModal();
            }
        }
    });

    // Enable or disable the submit button dynamically based on file inputs
    form.addEventListener('change', function () {
        const sf9 = sf9Input.files.length > 0;
        const birthCert = birthCertInput.files.length > 0;

        submitButton.disabled = !(sf9 && birthCert);
    });

    // Function to show the file name after selection
    function displayFileName(inputId, outputId) {
        const fileInput = document.getElementById(inputId);
        const fileNameDisplay = document.getElementById(outputId);
        fileInput.addEventListener('change', function() {
            const fileNames = Array.from(fileInput.files).map(file => file.name).join(', ');
            fileNameDisplay.textContent = fileNames;
        });
    }

    // Call the function for each file input
    displayFileName('sf9-input', 'sf9-file-name');
    displayFileName('birth-cert-input', 'birth-cert-file-name');
    displayFileName('grade-cert-input', 'grade-cert-file-name');
});