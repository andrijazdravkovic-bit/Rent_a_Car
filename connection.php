<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "rent";

    $conn = new mysqli($servername, $username, $password, $database);
    if($conn->connect_error)
    {
        die("Neuspesna konekcija: " . $conn->connect_error);
    }
    $conn->set_charset('utf8');
?>