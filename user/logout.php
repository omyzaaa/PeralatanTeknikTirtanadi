<?php


session_start();
$_SESSION['user'] = NULL;

echo '<script> location.replace("../index.php"); </script>';

?>