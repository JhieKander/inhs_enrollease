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

    // Show the number of correct answers in an alert
    alert('Number of correct answers: ' + correctAnswers);

    // Determine the rating based on the correct answers count
    let rating;
    if (correctAnswers >= 8) {
        rating = "Sufficient";
    } else if (correctAnswers >= 5) {
        rating = "Instructional";
    } else if (correctAnswers >= 3) {
        rating = "Failure";
    } else {
        rating = "Unprepared";
    }

    // Show the rating in an alert
    alert('Your rating: ' + rating);

    // You can send this count to the server if needed
    // For example, using fetch or a form submission
    // Here is an example of how you might send the data:
    const formData = new FormData();
    formData.append('correct_answers_count', correctAnswers);

    fetch('your-server-endpoint.php', {
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