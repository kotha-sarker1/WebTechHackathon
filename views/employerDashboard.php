<?php

include "../models/DatabaseConnection.php";

session_start();

$db = new DatabaseConnection();

$connection = $db->openConnection();

$employer_id = 1;

$jobs = $db->getEmployerJobsWithApplicationCount($connection, $employer_id);

?>

<html>

<head>

    <title>Employer Dashboard</title>
    <link rel="stylesheet" href="../config/style2.css">
</head>

<body>

    <h1 class="main-heading">Employer Dashboard</h1>


    <br><br>

    <table border="1" cellpadding="10">

        <tr>

            <th>ID</th>

            <th>Title</th>

            <th>Category</th>

            <th>Salary Range</th>

            <th>Location</th>

            <th>Job Type</th>

            <th>Deadline</th>

            <th>Application Count</th>

            <th>Status</th>

            <th>Action</th>

        </tr>

        <?php

        while($row = $jobs->fetch_assoc()){

            $id = $row["id"];

            $title = $row["title"];

            $category = $row["category_name"];

            $salary_range = $row["salary_range"];

            $location = $row["location"];

            $job_type = $row["job_type"];

            $deadline = $row["deadline"];

            $applicationCount = $row["total_applications"];

            $status = $row["status"];

            ?>

            <tr>

                <td><?php echo $id; ?></td>

                <td><?php echo $title; ?></td>

                <td><?php echo $category; ?></td>

                <td><?php echo $salary_range; ?></td>

                <td><?php echo $location; ?></td>

                <td><?php echo $job_type; ?></td>

                <td><?php echo $deadline; ?></td>

                <td><?php echo $applicationCount; ?></td>

                <td>

                    <button

                    id="statusBtn<?php echo $id; ?>"

                    onclick="toggleStatus(<?php echo $id; ?>)"

                    style="color:white;

                    background-color:

                    <?php

                    if($status == "active"){

                        echo "green";

                    }else{

                        echo "red";

                    }

                    ?>

                    ;"

                    >

                    <?php echo $status; ?>

                    </button>

                </td>

                <td>

                    <a href="editJob.php?id=<?php echo $id; ?>">
                        Edit 
                    </a>
                    
                    <br><br>

                    <a href="../controllers/DeleteJob.php?id=<?php echo $id; ?>">

                        Delete

                    </a>

                </td>

            </tr>

            <?php

        }

        ?>

    </table>

    <br><br>

    <a href="createJob.php">

        Create New Job

    </a>

    <script src="../config/toggleStatus.js"></script>


</body>

</html>