<?php
session_start();

// Verificacion de token

session_destroy();
header('Location: login.php');
exit();
?>
