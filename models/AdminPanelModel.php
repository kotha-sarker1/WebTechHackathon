<?php

require_once 'db.php';

function getAllJobsAdmin($category = '', $status = '')
{
    global $conn;

    $query = "SELECT * FROM jobs WHERE 1";

    if($category != '')
    {
        $query .= " AND category = '$category'";
    }

    if($status != '')
    {
        $query .= " AND status = '$status'";
    }

    $result = mysqli_query($conn, $query);

    return $result;
}

function getTotalJobs()
{
    global $conn;

    $query = "SELECT COUNT(*) as total FROM jobs";

    $result = mysqli_query($conn, $query);

    $row = mysqli_fetch_assoc($result);

    return $row['total'];
}

function getTotalApplications()
{
    global $conn;

    $query = "SELECT COUNT(*) as total FROM applications";

    $result = mysqli_query($conn, $query);

    $row = mysqli_fetch_assoc($result);

    return $row['total'];
}

function getApplicationsPerCategory()
{
    global $conn;

    $query = "SELECT jobs.category,
                     COUNT(applications.id) as total

              FROM jobs

              LEFT JOIN applications
              ON jobs.id = applications.job_id

              GROUP BY jobs.category";

    $result = mysqli_query($conn, $query);

    return $result;
}

function closeJob($id)
{
    global $conn;

    $query = "UPDATE jobs
              SET status = 'closed'
              WHERE id = '$id'";

    mysqli_query($conn, $query);
}

?>