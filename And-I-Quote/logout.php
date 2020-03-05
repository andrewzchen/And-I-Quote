<?php
// destroy session and redirect user to home page
session_start();
session_destroy();
header("Location: index.php");
?>
