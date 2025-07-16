<?php
    $conn = mysqli_connect('mysql-helpinghand.alwaysdata.net', '423063_user', 'techitorleaveit', 'helpinghand_db');
    if (!$conn){
        die('Database connection error: '. mysqli_connect_error());
    }
?>
