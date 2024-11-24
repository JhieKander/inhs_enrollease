document.addEventListener('DOMContentLoaded', function() {
    const enrolleeType = document.getElementById('enrolleeType');
    const gradeLevelContainer = document.getElementById('gradeLevelContainer');
    const gradeLevelDropdown = document.getElementById('gradeLevel');
    const continueButton = document.getElementById('continue-button');
    const tleSubjectContainer = document.getElementById('tleSubjectContainer');
    const warningModal = document.getElementById('warningModal');

    if (!enrolleeType || !gradeLevelDropdown || !continueButton || !warningModal) {
        console.error("One or more required elements are missing from the DOM.");
        return; // Exit if any required element is missing
    }

    // Function to reset the form state
    function resetForm() {
        if (gradeLevelDropdown) {
            gradeLevelDropdown.value = ""; // Reset the dropdown value
        }
        if (gradeLevelContainer) {
            gradeLevelContainer.style.display = 'none'; // Hide the grade level container
        }
        if (tleSubjectContainer) {
            tleSubjectContainer.style.display = 'none'; // Hide the TLE subject container
        }
    }

    // Add event listeners
    enrolleeType.addEventListener('change', function() {
        localStorage.setItem('enrolleeType', enrolleeType.value);
        resetForm(); // Reset the form state

        if (enrolleeType.value === 'New Student') {
            gradeLevelDropdown.innerHTML = `<option value="Grade 7">Grade 7</option>`;
            gradeLevelDropdown.value = 'Grade 7'; // Set default value
            continueButton.disabled = false; // Enable button for new students
        } else if (enrolleeType.value === 'Transferee') {
            gradeLevelDropdown.innerHTML = `
                <option value="">Select Grade Level</option>
                <option value="Grade 8">Grade 8</option>
                <option value="Grade 9">Grade 9</option>
                <option value="Grade 10">Grade 10</option>
            `;
            gradeLevelContainer.style.display = 'block'; // Show dropdown container
        } else if (enrolleeType.value === 'Returnee') {
            gradeLevelDropdown.innerHTML = `
                <option value="">Select Grade Level</option>
                <option value="Grade 7">Grade 7</option>
                <option value="Grade 8">Grade 8</option>
                <option value="Grade 9">Grade 9</option>
                <option value="Grade 10">Grade 10</option>
            `;
            gradeLevelContainer.style.display = 'block'; // Show dropdown container
        }
    });

    gradeLevelDropdown.addEventListener('change', function() {
        localStorage.setItem('gradeLevel', gradeLevelDropdown.value);
        continueButton.disabled = !gradeLevelDropdown.value; // Enable button if a grade is selected

        // Show TLE subject dropdown if Transferee or Returnee and Grade 9 or 10 is selected
        if ((enrolleeType.value === 'Transferee' || enrolleeType.value === 'Returnee') && 
            (gradeLevelDropdown.value === 'Grade 9' || gradeLevelDropdown.value === 'Grade 10')) {
            tleSubjectContainer.style.display = 'block'; // Show TLE subject dropdown
        } else {
            tleSubjectContainer.style.display = 'none'; // Hide TLE subject dropdown
        }
    });

    continueButton.addEventListener('click', function(event) {
        event.preventDefault(); // Prevent default form submission

        const selectedTLESubject = document.getElementById('tleSubject') ? document.getElementById('tleSubject').value : null;

        // Check if no enrollee type is selected
        if (!enrolleeType.value) {
            console.log("Warning: No student type selected");
            warningModal.style.display = 'block'; // No student type selected
        } 
        // Check if Transferee or Returnee and no grade level is selected
        else if ((enrolleeType.value === 'Transferee' || enrolleeType.value === 'Returnee') && !gradeLevelDropdown.value) {
            console.log("Warning: No grade level selected");
            warningModal.style.display = 'block'; // No grade level selected
        } 
        // Check if Transferee or Returnee with Grade 9 or 10 and no TLE subject selected
        else if ((enrolleeType.value === 'Transferee' || enrolleeType.value === 'Returnee') && 
                   (gradeLevelDropdown.value === 'Grade 9' || gradeLevelDropdown.value === 'Grade 10') && 
                   !selectedTLESubject) {
            console.log("Warning: No TLE subject selected");
            warningModal.style.display = 'block'; // No TLE subject selected
        } 
        // If all conditions are met, proceed to application.php
        else {
            console.log("Proceeding to application.php");
            window.location.href = "application.php";
        }
    });
});

// Function to close the warning modal
function closeWarningModal() {
    const warningModal = document.getElementById('warningModal');
    warningModal.style.display = 'none'; // Hide the modal
}