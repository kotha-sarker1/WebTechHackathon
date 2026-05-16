<?php

include "../Model/DatabaseConnection.php";

session_start();

$db = new DatabaseConnection();

$connection = $db->openConnection();

$employer_id = 1;

$jobs = $db->getEmployerJobs($connection, "jobs", $employer_id);

?>

<html>

<head>

    <title>Employer Dashboard</title>

</head>

<body>

    <h1>Employer Dashboard</h1>

    <a href="createJob.php">

        Create New Job

    </a>

    <br><br>

    <table border="1">

        <tr>

            <th>ID</th>

            <th>Title</th>

            <th>Category</th>

            <th>Location</th>

            <th>Job Type</th>

            <th>Status</th>

            <th>Deadline</th>

            <th>Action</th>

        </tr>

        <?php

        while($row = $jobs->fetch_assoc()){

            $id = $row["id"];

            $title = $row["title"];

            $category = $row["category_name"];

            $location = $row["location"];

            $job_type = $row["job_type"];

            $status = $row["status"];

            $deadline = $row["deadline"];

            echo "

            <tr>

                <td>$id</td>

                <td>$title</td>

                <td>$category</td>

                <td>$location</td>

                <td>$job_type</td>

                <td>$status</td>

                <td>$deadline</td>

                <td>

                    <a href='../Controller/DeleteJob.php?id=$id'>

                        Delete

                    </a>

                </td>

            </tr>

            ";

        }

        ?>

    </table>

</body>

</html>