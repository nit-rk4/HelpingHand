<?php
    $conn = mysqli_connect('localhost', 'root', '', 'helpinghand_db');
    if (!$conn){
        die('Database connection error: '. mysqli_connect_error());
    }
?>