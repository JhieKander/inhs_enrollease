setTimeout(function () {
    const enrolleeType = localStorage.getItem('enrolleeType');
    const gradeLevel = localStorage.getItem('gradeLevel');
    const gradeLevelInput = document.getElementById('grade-level');
    const studentTypeInput = document.getElementById('student-type');
    const gradeLeveReqs = document.getElementById('grade-level');
    const studentTypeReqs = document.getElementById('student-type');
    const torSection = document.querySelector('.tor');

    // Check if elements exist before trying to set their values
    if (studentTypeInput && gradeLevelInput) {
        // Enable the inputs if session values are set
        if (enrolleeType) {
            studentTypeInput.value = enrolleeType; // Set the student type input
        }

        if (gradeLevel) {
            gradeLevelInput.value = gradeLevel; // Set the grade level input
        }

        // Handle specific logic for New Student
        if (enrolleeType === 'New Student') {
            gradeLevelInput.value = 'Grade 7'; // Set to Grade 7 for New Student
            localStorage.setItem('gradeLevel', 'Grade 7'); // Ensure it's stored in localStorage
            torSection.style.display = 'none'; // Hide the tor section
        } else {
            // Set to the stored grade level if not a new student
            gradeLevelInput.value = gradeLevel || ''; // Default to empty if not set
        }
    } else {
        console.error("One or more elements not found: studentTypeInput, gradeLevelInput");
    }
}, 100);