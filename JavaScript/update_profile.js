document.getElementById('studentForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const firstName = document.getElementById('first-name').value.trim();
    const middleName = document.getElementById('middle-name').value.trim();
    const lastName = document.getElementById('last-name').value.trim();
    const extensionName = document.getElementById('extension-name').value.trim();
    const gender = document.getElementById('gender').value.trim();
    const birthdate = document.getElementById('birthdate').value.trim();
    const emergencyContactName = document.getElementById('emergency-contact-name').value.trim();
    const emergencyContactNumber = document.getElementById('emergency-contact').value.trim();
    const password = document.getElementById('password').value.trim();
    const conPassword = document.getElementById('con-password').value.trim();

    // Check if required fields are not empty
    if (firstName && lastName && birthdate && gender && emergencyContactName && emergencyContactNumber) {
        // Create an AJAX request to send the data to the server-side script
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'PHP/update_student.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            const modalMessage = document.getElementById('modalMessage');
            const modal = document.getElementById('modal');
        
            console.log(xhr.responseText); // Log the server response
        
            if (xhr.status === 200) {
                try {
                    const response = JSON.parse(xhr.responseText);
                    if (response.status === 'success') {
                        modalMessage.textContent = 'Profile updated successfully.';
                        
                        // Disable fields after successful update
                        const fieldsToDisable = [
                            'first-name',
                            'last-name',
                            'middle-name',
                            'extension-name',
                            'gender',
                            'birthdate',
                            'emergency-contact-name',
                            'emergency-contact'
                        ];
            
                        fieldsToDisable.forEach(function(id) {
                            const element = document.getElementById(id);
                            if (element) {
                                element.disabled = true; // Disable the field if it exists
                            } else {
                                console.warn(`Element with ID ${id} not found.`);
                            }
                        });
                    } else {
                        modalMessage.textContent = 'Failed to update the profile. Please try again.';
                    }
                } catch (e) {
                    console.error('Parsing error:', e);
                    modalMessage.textContent = 'An error occurred while processing the response.';
                }
                modal.style.display = 'block'; // Show the modal
            } else {
                // Handle server error
                modalMessage.textContent = 'An error occurred while updating the profile. Please try again.';
                modal.style.display = 'block'; // Show the modal
            }
        };
        xhr.send(`first_name=${firstName}&middle_name=${middleName}&last_name=${lastName}&extension_name=${extensionName}&gender=${gender}&birthdate=${birthdate}&emergency_contact_name=${emergencyContactName}&emergency_contact_number=${emergencyContactNumber}&password=${password}&con_password=${conPassword}`);
    } else {
        // Handle empty fields
        const modalMessage = document.getElementById('modalMessage');
        const modal = document.getElementById('modal');
        modalMessage.textContent = 'Please fill in all required fields.';
        modal.style.display = 'block'; // Show the modal
    }
});

// Close the modal when the user clicks on <span> (x)
document.getElementById('closeModal').onclick = function() {
    const modal = document.getElementById('modal');
    modal.style.display = 'none'; // Hide the modal
}

// Close the modal when the user clicks anywhere outside of the modal
window.onclick = function(event) {
    const modal = document.getElementById('modal');
    if (event.target === modal) {
        modal.style.display = 'none'; // Hide the modal
    }
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