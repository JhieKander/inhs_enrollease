document.addEventListener('DOMContentLoaded', function() {
    const submitButton = document.getElementById('submitButton');
    const downloadButton = document.getElementById('downloadButton');
    const continueButton = document.getElementById('save-continue-button');
    const gradeLevelInput = document.getElementById('grade-level');

    continueButton.addEventListener('click', function(event) {
        event.preventDefault();  // Prevent page refresh

        // Array of required fields
        const requiredFields = [
            'last-name',
            'first-name',
            'birthdate',
            'gender',
            'mother-tongue',
            'place-of-birth',
            'ip-specify', // Assuming this is the ID for Indigenous People Community
            'disability',
            'beneficiary', // Assuming this is the ID for 4Ps
            'province',
            'city',
            'barangay',
            'house-number',
            'street-name',
            'zip-code',
            'father-last-name',
            'father-first-name',
            'father-contact-number',
            'mother-last-name',
            'mother-first-name',
            'mother-contact-number',
            'guardian-last-name',
            'guardian-first-name',
            'guardian-contact-number',
            'last-grade',
            'last-school-year',
            'last-school'
        ];

        // Check if any required field is empty
        let isEmpty = false;
        requiredFields.forEach(function(fieldId) {
            const field = document.getElementById(fieldId);
            if (field && !field.value.trim()) {
                isEmpty = true;
            }
        });

        // Show warning modal if any field is empty
        if (isEmpty) {
            const warningModal = new bootstrap.Modal(document.getElementById('warningModal'));
            warningModal.show();
            return; // Exit the function to prevent PDF generation
        }

        // Prepare form data
        const formData = new FormData(document.getElementById('application_form'));
        formData.append('gradeLevel', gradeLevelInput.value);  // Include grade level

        // Disable submit button initially
        submitButton.disabled = true;

        // AJAX request to generate PDF
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'generate_pdf.php', true);
        xhr.responseType = 'blob';  // Expect PDF as blob

        xhr.onload = function() {
            if (xhr.status === 200) {
                // Create blob URL for PDF
                const pdfBlob = xhr.response;
                const url = window.URL.createObjectURL(pdfBlob);

                // Set PDF iframe source with a cache-busting parameter
                const iframe = document.getElementById('pdfViewer');
                iframe.src = url; // Use the blob URL for the iframe

                // Show modal
                const pdfModal = new bootstrap.Modal(document.getElementById('pdfModal'));
                pdfModal.show();
            }
        };
        xhr.send(formData);  // Send form data
    });

    // Listen for the download button's form submission
    document.getElementById('downloadForm').addEventListener('submit', function(event) {
        event.preventDefault();  // Prevent the default form submission

        // Simulate the download delay
        setTimeout(function() {
            // Enable submit button after download
            submitButton.disabled = false;

            submitButton.classList.remove('btn-secondary'); // Remove any previous style class if needed
            submitButton.classList.add('btn', 'btn-success'); // Apply btn-success Bootstrap classes

            // Change download button text and style
            downloadButton.innerHTML = 'Downloaded! <i class="fas fa-check"></i>';
            downloadButton.classList.remove('btn-success');
            downloadButton.classList.add('btn-secondary');
            downloadButton.disabled = true;  // Disable download button after one click
        }, 500); // Adjust delay as needed for download completion

        // Proceed with actual download after the delay
        event.target.submit();
    });
});