<?php
// Start the session to access session variables
session_start();

// Destroy all session variables
session_unset();

// Destroy the session itself
session_destroy();

// Redirect to the homepage or login page
header("Location: index.php");  // Redirecting to the homepage
exit();
?>
