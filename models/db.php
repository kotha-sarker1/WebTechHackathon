<?php

$conn = mysqli_connect("localhost", "root", "", "job_portal");

if (!$conn) {
    die("Database Connection Failed");
}

function getConnection(){
    global $conn;
    return $conn;
}

?>
