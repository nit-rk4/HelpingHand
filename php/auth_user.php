<?php
//Prevents access to user pages unless logged in
session_start();
if (!isset($_SESSION['auth']) || $_SESSION['auth']['type'] !== 'user'){
    header("Location: /index.php");
    exit;
}

?>