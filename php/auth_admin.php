<<?php
//Prevents access to admin pages unless logged in
session_start();
if (!isset($_SESSION['auth']) || $_SESSION['auth']['type'] !== 'admin'){
    header("Location: /index.php");
    exit;
}

?>