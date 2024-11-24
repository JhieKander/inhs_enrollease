function openLogoutModal() {
    document.getElementById('logoutModal').style.display = 'block';
}

document.getElementById('confirmLogout').onclick = function() {
    window.location.href = "logout.php"; // Redirect to logout script
}

// Close the modal when the user clicks anywhere outside of it
window.onclick = function(event) {
    var modal = document.getElementById('logoutModal');
    if (event.target == modal) {
        modal.style.display = "none";
    }
}