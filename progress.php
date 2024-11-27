<link rel="stylesheet" href="CSS/progressing.css">

<div class="progress-container">
    <a href="application.php" class="step" id="step1">
        <div class="step-number">1</div>
        <div class="step-text">
            <div>Filling Up The</div>
            <div>Application Form</div>
        </div>
    </a>
    <div class="arrow">></div>
    <a href="requirements.php" class="step" id="step2">
        <div class="step-number inactive">2</div>
        <div class="step-text inactive">
            <div>Gather & Submit</div>
            <div>Requirements</div>
        </div>
    </a>
    <div class="arrow">></div>
    <div class="step" id="step3">
        <div class="step-number inactive">3</div>
        <div class="step-text inactive">
            <div>Take the Reading</div>
            <div>Skills Assessment</div>
        </div>
    </div>
    <div class="arrow">></div>
    <a href="id_upload.php" class="step" id="step4">
        <div class="step-number inactive">4</div>
        <div class="step-text inactive">
            <div>Upload your</div>
            <div>1X1 ID Picture</div>
        </div>
    </a>
    <div class="arrow">></div>
    <a href="submit_reqs.php" class="step" id="step5">
        <div class="step-number inactive">5</div>
        <div class="step-text inactive">
            <div>Submission of Hard</div>
            <div>Copy Requirements</div>
        </div>
    </a>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const currentPage = window.location.pathname.split('/').pop(); // Get the current page name
        const steps = {
            'application.php': 'step1',
            'requirements.php': 'step2',
            'power_up.php': 'step2',
            'rda.php': 'step3',
            'english_videoprompt.php': 'step3',
            'english_passage.php': 'step3',
            'english_comprehend.php': 'step3',
            'filipino_videoprompt.php': 'step3',
            'filipino_passage.php': 'step3',
            'filipino_comprehend.php': 'step3', // Make step 2 active for power_up.php as well
            'id_upload.php': 'step4',
            'submit_reqs.php': 'step5'
        };

        // Check if the current page matches any of the defined steps
        if (steps[currentPage]) {
            const activeStep = document.getElementById(steps[currentPage]);
            activeStep.classList.add('active'); // Add active class to the current step

            // If the step is clickable, make previous steps active too
            const stepKeys = Object.keys(steps);
            for (let i = 0; i < stepKeys.length; i++) {
                if (stepKeys[i] === currentPage) break;
                const stepId = steps[stepKeys[i]];
                document.getElementById(stepId).classList.add('completed'); // Mark previous steps as completed
            }
        }
    });
</script>