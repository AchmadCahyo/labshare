<?php
session_start();
unset($_SESSION['username']);
unset($_SESSION['password']);
unset($_SESSION['name']);
unset($_SESSION['role']);

session_destroy();
echo "<script>alert('You have logged out!'); document.location='../home.php'</script>";
