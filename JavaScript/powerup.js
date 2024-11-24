document.addEventListener('DOMContentLoaded', function() {
    const powerUp = document.getElementById('powerUp');
    const gradeContainer = document.getElementById('gradeContainer');
    const continueButton = document.getElementById('continue-button');
    const gradeAveInput = document.getElementById('grade-ave');
    const averageModal = document.getElementById('averageModal');

    // Show the gradeContainer if "Yes" is selected
    powerUp.addEventListener('change', function() {
        if (powerUp.value === 'Yes') {
            gradeContainer.style.display = 'block';
        } else {
            gradeContainer.style.display = 'none';
        }
    });

    // Enable or disable the continue button based on the input value
    gradeAveInput.addEventListener('input', function() {
        const value = parseFloat(gradeAveInput.value);
        continueButton.disabled = isNaN(value) || value < 0; // Disable if not a number or negative
    });

    // Event listener for the continue button
    continueButton.addEventListener('click', function(event) {
        event.preventDefault(); // Prevent the default link behavior

        const generalAverage = parseFloat(gradeAveInput.value);

        // Check if the general average is less than 90
        if (generalAverage < 90) {
            averageModal.style.display = 'block'; // Show the modal
        } else {
            // Proceed to the next page if the average is valid
            window.location.href = "requirements.php"; // Redirect to the next page
        }
    });
});

// Function to close the modal
function closeModal() {
    const averageModal = document.getElementById('averageModal');
    averageModal.style.display = 'none'; // Hide the modal
}