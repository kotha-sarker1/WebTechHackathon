<?php

require_once 'db.php';

function getAllJobs()
{
    global $conn;

    $query = "SELECT * FROM jobs";

    $result = mysqli_query($conn, $query);

    return $result;
}

?>