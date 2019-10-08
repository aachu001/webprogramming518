<?php
session_start();
session_destroy();
echo 'You have been logged out.';
unset($_SESSION['username']);
header('location: index.php');
?>