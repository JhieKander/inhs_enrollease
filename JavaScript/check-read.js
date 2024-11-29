function checkReadingskillsResult() {
        // Use AJAX to fetch readingskills_result from the server
        fetch('PHP/empty-read.php')
            .then(response => response.json())
            .then(data => {
                // Check if readingskills_result is empty
                if (Object.keys(data).length === 0) {
                    document.getElementById('proceed-button').disabled = true;
                    alert("You need to accomplish the reading skills assessment first before proceeding to the next step.");
                } else {
                    document.getElementById('proceed-button').disabled = false;
                }

                // Check English Assessment
                const englishAssessment = data.English_Video && data.English_ReadingTime && 
                                          data.English_ReadingTimeSpeed && data.English_MisprononounceWords && 
                                          data.English_MisprononounceRating && data.English_ComprehensionScore && 
                                          data.English_ComprehensionRating && data.English_ReadingStatus;

                if (englishAssessment) {
                    const englishButton = document.querySelector('.start-english');
                    englishButton.disabled = true;
                    englishButton.style.backgroundColor = '#7DB343';
                    englishButton.style.color = '#fff';
                }

                // Check Filipino Assessment
                const filipinoAssessment = data.Filipino_Video && data.Filipino_ReadingTime && 
                                           data.Filipino_ReadingTimeSpeed && data.Filipino_MisprononounceWords && 
                                           data.Filipino_MisprononounceRating && data.Filipino_ComprehensionScore && 
                                           data.Filipino_ComprehensionRating && data.Filipino_ReadingStatus;

                if (filipinoAssessment) {
                    const filipinoButton = document.querySelector('.start-filipino');
                    filipinoButton.disabled = true;
                    filipinoButton.style.backgroundColor = '#7DB343';
                    filipinoButton.style.color = '#fff';
                }
            })
            .catch(error => console.error('Error fetching readingskills_result:', error));
    }

    document.addEventListener('DOMContentLoaded', function() {
        checkReadingskillsResult();

        // Add event listener for the proceed button after the DOM is fully loaded
        const proceedButton = document.getElementById('proceed-button');
        if (proceedButton) {
            proceedButton.addEventListener('click', function() {
                window.location.href = 'id_upload.php'; // Redirect to id_upload.php
            });
        } else {
            console.error('Proceed button not found');
        }

        // Add event listener for the English Assessment button
        const englishButton = document.querySelector('.start-english');
        if (englishButton) {
            englishButton.addEventListener('click', function() {
                window.location.href = 'english_videoprompt.php'; // Redirect to english_videoprompt.php
            });
        } else {
            console.error('English button not found');
        }
    });