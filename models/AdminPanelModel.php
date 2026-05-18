<?php

require_once 'db.php';

function getAllJobsAdmin($category = '', $status = '')
{
    global $conn;

    if ($category !== '' && $status !== '') {
        $stmt = mysqli_prepare($conn, "SELECT * FROM jobs WHERE category = ? AND status = ?");
        mysqli_stmt_bind_param($stmt, "ss", $category, $status);
    } elseif ($category !== '') {
        $stmt = mysqli_prepare($conn, "SELECT * FROM jobs WHERE category = ?");
        mysqli_stmt_bind_param($stmt, "s", $category);
    } elseif ($status !== '') {
        $stmt = mysqli_prepare($conn, "SELECT * FROM jobs WHERE status = ?");
        mysqli_stmt_bind_param($stmt, "s", $status);
    } else {
        $stmt = mysqli_prepare($conn, "SELECT * FROM jobs");
    }

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    return $result;
}

function getTotalJobs()
{
    global $conn;

    $stmt = mysqli_prepare($conn, "SELECT COUNT(*) as total FROM jobs");
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    return $row['total'];
}

function getTotalApplications()
{
    global $conn;

    $stmt = mysqli_prepare($conn, "SELECT COUNT(*) as total FROM applications");
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
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

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    return $result;
}

function closeJob($id)
{
    global $conn;
    $stmt = mysqli_prepare($conn, "UPDATE jobs SET status = 'closed' WHERE id = ?");
    $id = (int) $id;
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
}

?>