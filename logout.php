<?php
session_start();
session_destroy();  // Destroy the session to log the user out
header("Location: index.php");  // Redirect to the login page
exit();
?>
