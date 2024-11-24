const links = document.querySelectorAll('.sidebar a');

// Check for active class on page load
links.forEach(link => {
  if (link.classList.contains('active')) {
    link.classList.add('active');
  }

  link.addEventListener('click', () => {
    // Remove the 'active' class from all links
    links.forEach(l => l.classList.remove('active'));

    // Add the 'active' class to the clicked link
    link.classList.add('active');
  });
});
