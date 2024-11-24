// Function to debounce the AJAX request
function debounce(func, wait) {
    let timeout;
    return function() {
        const context = this;
        const args = arguments;
        clearTimeout(timeout);
        timeout = setTimeout(function() {
            func.apply(context, args);
        }, wait);
    };
}

// Get the email input field
const emailInput = document.getElementById('email');

// Add an event listener to the email input field
emailInput.addEventListener('keyup', debounce(checkEmailAvailability, 500));

// Function to check email availability
function checkEmailAvailability() {
    const email = emailInput.value.trim();
    if (email !== '') {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'PHP/email.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                const response = xhr.responseText.trim();
                updateUI(response);
            } else {
                updateUI('error');
            }
        };
        xhr.onerror = function() {
            updateUI('error');
        };
        xhr.send('email=' + encodeURIComponent(email));
    } else {
        updateUI('');
    }
}

// Function to update the UI
function updateUI(response) {
    if (response === 'taken') {
        document.getElementById('email').style.border = '1px solid green';
    } else if (response === 'available') {
        document.getElementById('email').style.border = '1px solid red';
    } else if (response === 'error') {
        document.getElementById('email').style.border = '1px solid red';
    } else {
        document.getElementById('email').style.border = '';
    }
}

document.querySelector('form').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the default form submission
    const formData = new FormData(this);
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'PHP/forgot.php', true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            showModal(response.message);
        } else {
            showModal('An error occurred while processing your request.');
        }
    };
    xhr.onerror = function() {
        showModal('An error occurred while processing your request.');
    };
    xhr.send(formData); // Send the form data
});

// Function to show the modal
function showModal(message) {
    const modalMessage = document.getElementById('modal-message');
    const proceedButton = document.getElementById('proceed-button');
    
    modalMessage.innerText = message;
    document.getElementById('successModal').style.display = 'block'; // Show the modal

    // Check if the message indicates success and enable the button
    if (message.includes('Temporary password has been sent')) {
        proceedButton.style.display = 'block'; // Show the proceed button
    } else {
        proceedButton.style.display = 'none'; // Hide the proceed button
    }
}

// Add event listener to the proceed button to redirect to new-password.php
document.getElementById('proceed-button').addEventListener('click', function() {
    window.location.href = 'new-password.php'; // Redirect to new-password.php
});

// Function to close the modal
function closeSuccessModal() {
    document.getElementById('successModal').style.display = 'none';
}