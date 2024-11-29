// Assuming you have a way to check the readingskills_result data
const readingskillsResult = {}; // Replace with actual data fetching logic

// Function to update button states
function updateButtonStates() {
    const proceedButton = document.getElementById('proceed-button');
    const englishButton = document.getElementById('record-button');
    const filipinoButton = document.querySelector('.start-filipino');

    // Debugging: Check if elements are found
    console.log('Proceed Button:', proceedButton);
    console.log('English Button:', englishButton);
    console.log('Filipino Button:', filipinoButton);

    // Check if readingskills_result is empty
    const isResultEmpty = Object.keys(readingskillsResult).length === 0;

    // Disable/Enable Proceed button
    proceedButton.disabled = isResultEmpty; // Disable if no results

    // Disable/Enable English Assessment button
    englishButton.disabled = readingskillsResult.English_Video; // Disable if English Assessment is done
    if (!readingskillsResult.English_Video) {
        englishButton.style.backgroundColor = '#7DB343';
        englishButton.style.color = '#fff';
    } else {
        englishButton.style.backgroundColor = '';
        englishButton.style.color = '';
    }

    // Disable/Enable Filipino Assessment button
    filipinoButton.disabled = !readingskillsResult.English_Video; // Disable if English is not done
    if (readingskillsResult.Filipino_Video) {
        filipinoButton.disabled = true;
        filipinoButton.style.backgroundColor = '#7DB343';
        filipinoButton.style.color = '#fff';
    } else {
        filipinoButton.disabled = false;
        filipinoButton.style.backgroundColor = '';
        filipinoButton.style.color = '';
    }
}

// Call the function to set initial button states after DOM is loaded
document.addEventListener('DOMContentLoaded', updateButtonStates);