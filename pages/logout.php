<?php
//for testing purposes only -- up for revision
session_start();
session_unset();
session_destroy();

header("Location: /index.php");
?>