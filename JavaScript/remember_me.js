function togglePasswordVisibility() {
    const passwordInput = document.getElementById('password');
    const togglePasswordIcon = document.querySelector('.toggle-password');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text'; // Show password
        togglePasswordIcon.textContent = '🙈'; // Change icon to indicate password is visible
    } else {
        passwordInput.type = 'password'; // Hide password
        togglePasswordIcon.textContent = '👁️'; // Change icon back to show password
    }
}

const rememberCheckbox = document.getElementById('remember');
const emailInput = document.getElementById('email');
const passwordInput = document.getElementById('password');

rememberCheckbox.addEventListener('change', () => {
    if (rememberCheckbox.checked) {
        localStorage.setItem('email', emailInput.value);
        localStorage.setItem('password', passwordInput.value);
    } else {
        localStorage.removeItem('email');
        localStorage.removeItem('password');
    }
});

// When the page loads, check if there's stored data and pre-fill the inputs
window.onload = () => {
    const storedEmail = localStorage.getItem('email');
    const storedPassword = localStorage.getItem('password');

    if (storedEmail && storedPassword) {
        emailInput.value = storedEmail;
        passwordInput.value = storedPassword;
        rememberCheckbox.checked = true;
    }
};

function openModal(title, message) {
    document.getElementById("modal-title").innerText = title;
    document.getElementById("modal-message").innerText = message;
    document.getElementById("loginModal").style.display = "block";
}

function closeModal() {
    document.getElementById("loginModal").style.display = "none";
}

// Optional: Close modal when clicking outside of it
window.onclick = function(event) {
    const modal = document.getElementById("loginModal");
    if (event.target === modal) {
        closeModal();
    }
};

document.querySelector('form').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the default form submission

    const formData = new FormData(this);
    
    fetch('PHP/login.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            openModal('Success', data.message);
            // Redirect after a short delay if needed
            setTimeout(() => {
                if (data.message.includes('complete your details')) {
                    window.location.href = 'details.php';
                } else {
                    window.location.href = 'home_index.php';
                }
            }, 2000);
        } else {
            openModal('Error', data.message);
        }
    })
    .catch(error => {
        openModal('Error', 'An unexpected error occurred. Please try again later.');
    });
});
