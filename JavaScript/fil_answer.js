// Initially disable the Proceed button
const proceedButton = document.querySelector('.proceed-button');
proceedButton.disabled = true;

// Add event listeners to all radio buttons
document.querySelectorAll('input[type="radio"]').forEach(radio => {
    radio.addEventListener('change', () => {
        // Count how many answers have been selected
        const questions = document.querySelectorAll('.question');
        let selectedCount = 0;

        questions.forEach(question => {
            const userAnswer = question.querySelector('input[type="radio"]:checked');
            if (userAnswer) {
                selectedCount++;
            }
        });

        // Enable the Proceed button only if exactly 10 answers are selected
        proceedButton.disabled = selectedCount !== 10; // Enable if selectedCount is exactly 10
    });
});

document.querySelector('.proceed-button').addEventListener('click', function() {
    let correctAnswers = 0;
    const questions = document.querySelectorAll('.question');

    questions.forEach(question => {
        const userAnswer = question.querySelector('input[type="radio"]:checked');
        
        if (userAnswer) {
            const selectedValue = userAnswer.value;
            const correctValue = question.querySelector('.correct-answer').value; // Get the correct answer value

            if (selectedValue === correctValue) {
                correctAnswers++;
            }
        }
    });

    // Determine the rating based on the correct answers count
    let rating;
    if (correctAnswers >= 8) {
        rating = "Malaya";
    } else if (correctAnswers >= 5) {
        rating = "Instrukyunal";
    } else if (correctAnswers >= 3) {
        rating = "Kabiguan";
    } else if (correctAnswers >= 0) {
        rating = "Walang Kahandaan";
    }

    // Prepare the data to send to the server
    const formData = new FormData();
    formData.append('correct_answers_count', correctAnswers);

    // Send the data to the server
    fetch('filipino_comprehend.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        console.log(data); // Handle the response from the server if needed
        // Optionally redirect or perform additional actions
    })
    .catch(error => {
        console.error('Error:', error);
    });
});