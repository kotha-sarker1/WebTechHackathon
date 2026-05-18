<?php

require_once 'db.php';

function getAllJobsAdmin($category = '', $status = '')
{
    global $conn;

    $query = "SELECT * FROM jobs WHERE 1";

    if($category != '')
    {
        $cat = mysqli_real_escape_string($conn, $category);
        $query .= " AND category = '$cat'";
    }

    if($status != '')
    {
        $st = mysqli_real_escape_string($conn, $status);
        $query .= " AND status = '$st'";
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

    $id = (int) $id;

    $query = "UPDATE jobs
              SET status = 'closed'
              WHERE id = $id";

    mysqli_query($conn, $query);
}

?>