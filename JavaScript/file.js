document.addEventListener('DOMContentLoaded', function () {
    const warningModal = document.getElementById('warningModal');
    const sf9 = document.getElementById("sf9-input").files.length > 0;
    const birthCert = document.getElementById("birth-cert-input").files.length > 0;
    const submitButton = document.querySelector(".button-container button");

    if (!sf9 || !birthCert) {
        event.preventDefault(); // Prevent the default action (form submission)
        showWarningModal(); // Show the modal
    }

    submitButton.disabled = !(sf9 && birthCert);

    // Function to show the warning modal
    function showWarningModal() {
        warningModal.style.display = 'block'; // Display the warning modal
    }
});