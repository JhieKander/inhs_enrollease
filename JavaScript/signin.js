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