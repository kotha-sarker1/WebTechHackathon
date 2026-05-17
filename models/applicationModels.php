<?php

require_once 'db.php';

function getApplicationsByJob($job_id)
{
    global $conn;

    $query = "SELECT applications.id,
                     users.name,
                     applications.cover_letter,
                     applications.status,
                     applications.resume_path

              FROM applications

              JOIN users
              ON applications.seeker_id = users.id

              WHERE applications.job_id = '$job_id'";

    $result = mysqli_query($conn, $query);

    return $result;
}


function getApplicationStatusCount()
{
    global $conn;

    $query = "SELECT status,
                     COUNT(*) as total

              FROM applications

              GROUP BY status";

    $result = mysqli_query($conn, $query);

    return $result;
}


function updateApplicationStatus($application_id, $status)
{
    global $conn;

    $query = "UPDATE applications
              SET status = '$status'
              WHERE id = '$application_id'";

    $result = mysqli_query($conn, $query);

    return $result;
}

?>