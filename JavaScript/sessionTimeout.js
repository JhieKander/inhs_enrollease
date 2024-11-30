   // sessionTimeout.js
   // Set the timeout duration (in milliseconds)
   const timeoutDuration = 600000; // 10 minutes

   let timeout;

   // Function to log out the user
   function logout() {
       // Redirect to logout endpoint
       window.location.href = 'logout.php'; // Removed /inhs/ prefix since files appear to be in same directory
   }

   // Function to reset the timeout
   function resetTimeout() {
       clearTimeout(timeout);
       timeout = setTimeout(logout, timeoutDuration);
   }

   // Event listeners to track user activity
   window.onload = resetTimeout;
   window.onmousemove = resetTimeout;
   window.onkeypress = resetTimeout;
   window.onscroll = resetTimeout;