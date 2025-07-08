<?php
    $conn = mysqli_connect('database.tambytes.cloud', 'helpinghand_db', 'techit', 'helpinghand_db');
    if (!$conn){
        die('Database connection error: '. mysqli_connect_error());
    }
?>