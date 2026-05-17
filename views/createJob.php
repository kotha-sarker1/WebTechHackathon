<?php

include "../models/DatabaseConnection.php";

session_start();

$titleError = $_SESSION["titleErr"] ?? "";

$successMsg = $_SESSION["successMsg"] ?? "";

unset($_SESSION["titleErr"]);
unset($_SESSION["successMsg"]);

$db = new DatabaseConnection();

$connection = $db->openConnection();

$categories = $db->getAllCategories($connection, "categories");

?>

<html>

<head>

    <title>Create Job</title>

</head>

<body>

    <h1>Create Job</h1>

    <form method="post" action="../controllers/CreateJob.php">

        <table>

            <tr>

                <td>Job Title</td>

                <td>

                    <input type="text" name="title" placeholder="Enter Job Title" />

                </td>

                <td>

                    <p style="color:red;">

                        <?php echo $titleError; ?>

                    </p>

                </td>

            </tr>

            <tr>

                <td>Category</td>

                <td>

                    <select name="category_id">

                        <?php

                        while($row = $categories->fetch_assoc()){

                            $id = $row["id"];

                            $name = $row["name"];

                            echo "<option value='$id'>$name</option>";

                        }

                        ?>

                    </select>

                </td>

            </tr>

            <tr>

                <td>Description</td>

                <td>

                    <textarea name="description" required></textarea>

                </td>

            </tr>

            <tr>

                <td>Requirements</td>

                <td>

                    <textarea name="requirements" required></textarea>

                </td>

            </tr>

            <tr>

                <td>Salary Range</td>

                <td>

                    <input type="text" name="salary_range"/>

                </td>

            </tr>

            <tr>

                <td>Location</td>

                <td>

                    <input type="text" name="location"/>

                </td>

            </tr>

            <tr>

                <td>Job Type</td>

                <td>

                    <input type="radio" name="job_type" value="Full-time"/> Full-time

                    <input type="radio" name="job_type" value="Part-time"/> Part-time

                    <input type="radio" name="job_type" value="Remote"/> Remote

                </td>

            </tr>

            <tr>

                <td>Deadline</td>

                <td>

                    <input type="date" name="deadline"/>

                </td>

            </tr>

            <tr>

                <td></td>

                <td>

                    <input type="submit" name="submit" value="Create Job"/>

                </td>

            </tr>

        </table>

    </form>

    <p style="color:green;">

        <?php echo $successMsg; ?>

    </p>

    <br>

    <a href="employerDashboard.php">

        Go To Dashboard

    </a>

</body>

</html>