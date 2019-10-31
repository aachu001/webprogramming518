<?php
session_start();
session_destroy();
echo 'You have been logged out.';
unset($_SESSION['id']);
unset($_SESSION['username']);
unset($_SESSION['email']);
unset($_SESSION['verify']);
header('location: index.php');
?>