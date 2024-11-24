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

document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('new-password');
    const confirmPasswordInput = document.getElementById('con-new-password');
    const tempPasswordInput = document.getElementById('temp');

    // Check if the student_email input exists
    const studentEmailInput = document.getElementById('student_email');
    if (!studentEmailInput) {
        console.error("Student email input not found!");
        return;
    }

    passwordInput.addEventListener('keyup', validatePassword);
    confirmPasswordInput.addEventListener('keyup', validatePassword);

    function validatePassword() {
        const password = passwordInput.value;
        const confirmPassword = confirmPasswordInput.value;

        if (password.length === 0) {
            resetPasswordValidation();
            return;
        }

        const hasUppercase = /[A-Z]/.test(password);
        const hasLowercase = /[a-z]/.test(password);
        const hasSpecialChar = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password);
        const hasNumber = /[0-9]/.test(password);
        const hasMinLength = password.length >= 8;

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
                condition.element.innerHTML = '✓ ' + condition.label;
            } else {
                condition.element.style.color = 'red';
                condition.element.innerHTML = '✕ ' + condition.label;
            }
        });

        // Show matching status for confirm password
        if (confirmPassword.length === 0) {
            document.getElementById('con-new-password-match').style.color = '';
            document.getElementById('con-new-password-match').innerHTML = '';
        } else if (password === confirmPassword) {
            document.getElementById('con-new-password-match').style.color = 'green';
            document.getElementById('con-new-password-match').innerHTML = '✓ Password matched.';
        } else {
            document.getElementById('con-new-password-match').style.color = 'red';
            document.getElementById('con-new-password-match').innerHTML = '✕ Password doesn\'t match.';
        }
    }

    function resetPasswordValidation() {
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

        document.getElementById('con-new-password-match').style.color = '';
        document.getElementById('con-new-password-match').innerHTML = '';
    }

    function showModal(message) {
        const modal = document.getElementById('successModal');
        document.getElementById('successMessage').innerText = message;
        modal.style.display = 'block';

        // Redirect after a delay
        setTimeout(() => {
            window.location.href = 'login_student.php'; // Redirect to the login page
        }, 3000); // Adjust the time as needed (3000ms = 3 seconds)
    }

    function showErrorModal(message) {
        const modal = document.getElementById('errorModal');
        document.getElementById('errorMessage').innerText = message;
        modal.style.display = 'block';
    }

    function closeModal() {
        const modal = document.getElementById('successModal');
        modal.style.display = 'none';
    }

    function closeErrorModal() {
        const modal = document.getElementById('errorModal');
        modal.style.display = 'none';
    }

    document.getElementById('closeModal').addEventListener('click', closeModal);
    document.getElementById('closeErrorModal').addEventListener('click', closeErrorModal);

    window.onclick = function(event) {
        const successModal = document.getElementById('successModal');
        const errorModal = document.getElementById('errorModal');
        if (event.target === successModal) {
            closeModal();
        } else if (event.target === errorModal) {
            closeErrorModal();
        }
    };

    document.getElementById('passwordForm').addEventListener('submit', function(event) {
        event.preventDefault();
    
        const tempPassword = tempPasswordInput.value.trim();
        const newPassword = passwordInput.value.trim();
        const confirmNewPassword = confirmPasswordInput.value.trim();
    
        // Log the values for debugging
        console.log('Temporary Password:', tempPassword);
        console.log('New Password:', newPassword);
        console.log('Confirm New Password:', confirmNewPassword);
        console.log('Student Email:', studentEmailInput.value.trim());
    
        // Check for empty fields
        if (!tempPassword || !newPassword || !confirmNewPassword) {
            showErrorModal('Please fill out all fields.');
            return;
        }
    
        // Check if new password meets requirements
        if (!/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[!@#$%^&*()_+\-=\[\]{};":\\|,.<>\/?]).{8,}$/.test(newPassword)) {
            showErrorModal('New Password does not meet the password requirements.');
            return;
        }
    
        const formData = new FormData();
        formData.append('temp', tempPassword);
        formData.append('new-password', newPassword);
        formData.append('con-new-password', confirmNewPassword);
        formData.append('student_email', studentEmailInput.value.trim()); // Ensure student email is included
    
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'PHP/change-password.php', true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                try {
                    const response = JSON.parse(xhr.responseText.trim());
                    if (response.status === 'success') {
                        showModal(response.message);
                    } else {
                        showErrorModal(response.message);
                    }
                } catch (e) {
                    showErrorModal('An error occurred while processing the response.');
                }
            } else {
                showErrorModal('An unexpected error occurred.');
            }
        };
        xhr.send(formData);
    });
});