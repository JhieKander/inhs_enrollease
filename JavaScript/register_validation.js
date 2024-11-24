// Get the email input field
const emailInput = document.getElementById('email');

// Add an event listener to the email input field
emailInput.addEventListener('keyup', debounce(checkEmailAvailability, 500));

// Function to check email availability
function checkEmailAvailability() {
    // Get the email value
    const email = emailInput.value.trim();

    // Check if the email is not empty
    if (email !== '') {
        // Make an AJAX request to the server-side script
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'PHP/email.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText.trim()); // Parse JSON response
                updateUI(response); // Pass the parsed response to updateUI
            } else {
                console.log('Error:', xhr.statusText);
                updateUI({ status: 'error' });
            }
        };
        xhr.onerror = function() {
            console.log('Error:', xhr.statusText);
            updateUI({ status: 'error' });
        };
        xhr.send('email=' + encodeURIComponent(email)); // Use encodeURIComponent for safety
    } else {
        // Clear the email input field and remove the error message
        updateUI({ status: 'clear' });
    }
}

// Function to update the UI based on the response
function updateUI(response) {
    const emailAvailabilityDiv = document.getElementById('email-availability');
    if (response.status === 'taken') {
        // Display an error message if the email is taken
        emailInput.style.border = '1px solid red';
        emailAvailabilityDiv.style.color = 'red';
        emailAvailabilityDiv.innerHTML = '✕ This email has been used.';
    } else if (response.status === 'available') {
        // Display a success message if the email is available
        emailInput.style.border = '1px solid green';
        emailAvailabilityDiv.style.color = 'green';
        emailAvailabilityDiv.innerHTML = '✓ This email has not yet been used.';
    } else if (response.status === 'error') {
        // Display an error message if there was an error
        emailInput.style.border = '1px solid red';
        emailAvailabilityDiv.style.color = 'red';
        emailAvailabilityDiv.innerHTML = '✕ Something went wrong.';
    } else {
        // Clear the email input field and remove the error message
        emailInput.style.border = '';
        emailAvailabilityDiv.style.color = '';
        emailAvailabilityDiv.innerHTML = '';
    }
}

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

function togglePasswordVisibility(fieldId) {
    const passwordInput = document.getElementById(fieldId);
    const togglePasswordIcon = document.querySelector(`.toggle-password[onclick="togglePasswordVisibility('${fieldId}')"]`);
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text'; // Show password
        togglePasswordIcon.textContent = '🙈'; // Change icon to indicate password is visible
    } else {
        passwordInput.type = 'password'; // Hide password
        togglePasswordIcon.textContent = '👁️'; // Change icon back to show password
    }
}

const passwordInput = document.getElementById('password');
const confirmPasswordInput = document.getElementById('con-password');

passwordInput.addEventListener('keyup', validatePassword);
confirmPasswordInput.addEventListener('keyup', validatePassword);

function validatePassword() {
    const password = passwordInput.value;
    const confirmPassword = confirmPasswordInput.value;

    // Check if password input field is empty
    if (password.length === 0) {
        // Hide conditions
        const passwordConditions = [
            document.getElementById('password-length-label'),
            document.getElementById('password-uppercase-label'),
            document.getElementById('password-lowercase-label'),
            document.getElementById('password-number-label'),
            document.getElementById('password-special-char-label'),
        ];

        passwordConditions.forEach((condition) => {
            condition.style.color = '';
            condition.innerHTML = '';
        });

        // Hide password match message
        document.getElementById('con-password-match').style.color = '';
        document.getElementById('con-password-match').innerHTML = '';

        return;
    }

    // Check if password meets requirements
    const hasUppercase = /[A-Z]/.test(password);
    const hasLowercase = /[a-z]/.test(password);
    const hasSpecialChar = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password);
    const hasNumber = /[0-9]/.test(password);
    const hasMinLength = password.length >= 8;

    // Check if password and confirm password match
    const passwordsMatch = password === confirmPassword;

    // Update UI
    const passwordConditions = [
        { condition: hasMinLength, label: 'Minimum 8 characters', element: document.getElementById('password-length-label') },
        { condition: hasUppercase, label: 'At least one uppercase letter', element: document.getElementById('password-uppercase-label') },
        { condition: hasLowercase, label: 'At least one lowercase letter', element: document.getElementById('password-lowercase-label') },
        { condition: hasNumber, label: 'At least one numerical character', element: document.getElementById('password-number-label') },
        { condition: hasSpecialChar, label: 'At least one special character', element: document.getElementById('password-special-char-label') },
    ];

    passwordConditions.forEach((condition) => {
        if (condition.condition) {
            condition.element.style.color = 'green';
            condition.element.style.fontSize = '12px';
            condition.element.innerHTML = '✓ ' + condition.label;
        } else {
            condition.element.style.color = 'red';
            condition.element.style.fontSize = '12px';
            condition.element.innerHTML = '✕ ' + condition.label;
        }
    });

    if (confirmPassword.length === 0) {
        document.getElementById('con-password-match').style.color = '';
        document.getElementById('con-password-match').innerHTML = '';
    } else if (passwordsMatch) {
        document.getElementById('con-password-match').style.color = 'green';
        document.getElementById('con-password-match').innerHTML = '<span style="color: green;">✓ Password matched.</span>';
    } else {
        document.getElementById('con-password-match').style.color = 'red';
        document.getElementById('con-password-match').innerHTML = '<span style="color: red;">✕ Password doesn\'t match.</span>';
    }
}

// Function to show the modal
function showModal() {
    const modal = document.getElementById('successModal');
    modal.style.display = 'block';
    // Hide buttons
    document.querySelector('.btn').style.display = 'none';
}

// Function to show the error modal
function showErrorModal(message) {
    const modal = document.getElementById('errorModal');
    document.getElementById('errorMessage').innerText = message; // Set the error message
    modal.style.display = 'block';
    // Hide buttons
    document.querySelector('.btn').style.display = 'none';
}

// Function to close the modal
function closeModal() {
    const modal = document.getElementById('successModal');
    modal.style.display = 'none';
    // Redirect to login page
    window.location.href = 'login_student.php';
}
// Function to close the error modal
function closeErrorModal() {
    const modal = document.getElementById('errorModal');
    modal.style.display = 'none';
    // Show buttons again
    document.querySelector('.btn').style.display = 'flex';
}

// Event listener for closing the modal
document.getElementById('closeModal').addEventListener('click', closeModal);
document.getElementById('closeErrorModal').addEventListener('click', closeErrorModal);

// Close the modal when clicking outside of it
window.onclick = function(event) {
    const successModal = document.getElementById('successModal');
    const errorModal = document.getElementById('errorModal');
    if (event.target === successModal) {
        closeModal(); // This will redirect to the login page
    } else if (event.target === errorModal) {
        closeErrorModal();
    }
};

// Form submission handling
document.querySelector('form').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the default form submission

    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value.trim();
    const confirmPassword = document.getElementById('con-password').value.trim();

    // Check if the email is available before submitting the form
    checkEmailAvailabilityForSubmission(email, password, confirmPassword);
});

// Function to check email availability for submission
function checkEmailAvailabilityForSubmission(email, password, confirmPassword) {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'PHP/email.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText.trim());
            if (response.status === 'available') {
                // Proceed with registration if the email is available
                registerAccount(email, password, confirmPassword);
            } else {
                showErrorModal('Email is already taken.'); // Show error modal
            }
        } else {
            showErrorModal('An unexpected error occurred.'); // Show a generic error message
        }
    };
    xhr.send('email=' + encodeURIComponent(email)); // Use encodeURIComponent for safety
}

// Function to register the account
function registerAccount(email, password, confirmPassword) {
    const formData = new FormData();
    formData.append('email', email);
    formData.append('password', password);
    formData.append('con-password', confirmPassword);

    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'PHP/register.php', true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText.trim());
            if (response.status === 'success') {
                showModal(); // Show the success modal
            } else {
                showErrorModal(response.message); // Show the error modal with the error message
            }
        } else {
            showErrorModal('An unexpected error occurred.'); // Show a generic error message
        }
    };
    xhr.send(formData); // Send the form data
}