<?php
// Start the session...
session_start();
// ... so we can destroy it.
session_destroy();
// Redirect to login page.
header('Location: login.php');
