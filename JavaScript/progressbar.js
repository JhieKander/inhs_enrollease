document.addEventListener('DOMContentLoaded', function() {
        const currentPage = window.location.pathname.split('/').pop(); // Get the current page name
        const steps = {
            'application.php': 'step1',
            'requirements.php': 'step2',
            'power_up.php': 'step3',
            'rda.php': 'step3',
            'english_videoprompt.php': 'step3',
            'english_passage.php': 'step3',
            'english_comprehend.php': 'step3',
            'filipino_videoprompt.php': 'step3',
            'filipino_passage.php': 'step3',
            'filipino_comprehend.php': 'step3',
            'id_upload.php': 'step4',
            'submit_reqs.php': 'step5'
        };

        // Check if the current page matches any of the defined steps
        if (steps[currentPage]) {
            const currentStepId = steps[currentPage];
            const currentStep = document.getElementById(currentStepId);
            
            // Add active class to the current step
            currentStep.classList.add('active');

            // Mark previous steps as completed based on step numbers
            const currentStepNumber = parseInt(currentStepId.replace('step', ''));
            for (let i = 1; i < currentStepNumber; i++) {
                document.getElementById('step' + i).classList.add('completed');
            }
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        const requirementsLink = document.querySelector('a[href="requirements.php"]');

        fetch('PHP/check_profile_status.php') // Server-side script to check profile completion
            .then(response => response.json())
            .then(data => {
                if (!data.isProfileComplete) {
                    requirementsLink.classList.add('inactive'); // Add a visual indicator
                    requirementsLink.href = "#"; // Prevent navigation
                    requirementsLink.title = "Complete your application form first.";
                }
            })
            .catch(err => console.error('Error checking profile status:', err));
    });

    document.addEventListener('DOMContentLoaded', function() {
        const rdaLink = document.querySelector('a[href="rda.php"]');

        fetch('PHP/check_requirements_status.php') // Server-side script to check requirements completion
            .then(response => response.json())
            .then(data => {
                if (!data.isRequirementsComplete) {
                    rdaLink.classList.add('inactive'); // Add a visual indicator
                    rdaLink.href = "#"; // Prevent navigation
                    rdaLink.title = "Complete the required documents first.";
                }
            })
            .catch(err => console.error('Error checking requirements status:', err));
    });

    document.addEventListener('DOMContentLoaded', function() {
        const idUploadLink = document.querySelector('a[href="id_upload.php"]');

        fetch('PHP/check_reading_skills_status.php') // Server-side script to check reading skills completion
            .then(response => response.json())
            .then(data => {
                if (!data.isReadingSkillsComplete) {
                    idUploadLink.classList.add('inactive'); // Add a visual indicator
                    idUploadLink.href = "#"; // Prevent navigation
                    idUploadLink.title = "Complete the Reading Skills Assessment first.";
                }
            })
            .catch(err => console.error('Error checking reading skills status:', err));
    });

    document.addEventListener('DOMContentLoaded', function () {
        const submitReqsLink = document.querySelector('a[href="submit_reqs.php"]');

        fetch('PHP/check_submission_status.php') // Server-side script to check submission status
            .then(response => response.json())
            .then(data => {
                if (!data.hasSavedData) {
                    submitReqsLink.classList.add('inactive'); // Add a visual indicator
                    submitReqsLink.href = "#"; // Prevent navigation
                    submitReqsLink.title = "Ensure that your Student ID and ID Picture are saved in the system.";
                }
            })
            .catch(err => console.error('Error checking submission status:', err));
    });