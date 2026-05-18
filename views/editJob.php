<?php

include "../models/DatabaseConnection.php";

session_start();

$id = $_GET["id"];

$db = new DatabaseConnection();

$connection = $db->openConnection();

$jobResult = $db->getJobById($connection, "jobs", $id);

$job = $jobResult->fetch_assoc();

$categories = $db->getAllCategories($connection, "categories");

$titleError = $_SESSION["titleErr"] ?? "";

unset($_SESSION["titleErr"]);

?>

<html>

<head>

    <title>Edit Job</title>
    <link rel="stylesheet" href="../config/style.css">

</head>

<body>

<div class="form-container">

    <h1 class="main-heading">Edit Job</h1>

    <form method="post" action="../controllers/EditJob.php">

        <input type="hidden" name="id" value="<?php echo $job['id']; ?>"/>

        <table>

            <tr>

                <td>Job Title</td>

                <td>

                    <input
                    type="text"
                    name="title"
                    value="<?php echo $job['title']; ?>"
                    />

                </td>

                <td>

                    <p class="error">

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

                            $categoryId = $row["id"];

                            $name = $row["name"];

                            ?>

                            <option
                            value="<?php echo $categoryId; ?>"

                            <?php

                            if($job["category_id"] == $categoryId){

                                echo "selected";

                            }

                            ?>

                            >

                            <?php echo $name; ?>

                            </option>

                            <?php

                        }

                        ?>

                    </select>

                </td>

            </tr>

            <tr>

                <td>Description</td>

                <td>

                    <textarea name="description"><?php echo $job["description"]; ?></textarea>

                </td>

            </tr>

            <tr>

                <td>Requirements</td>

                <td>

                    <textarea name="requirements"><?php echo $job["requirements"]; ?></textarea>

                </td>

            </tr>

            <tr>

                <td>Salary Range</td>

                <td>

                    <input
                    type="text"
                    name="salary_range"
                    value="<?php echo $job["salary_range"]; ?>"
                    />

                </td>

            </tr>

            <tr>

                <td>Location</td>

                <td>

                    <input
                    type="text"
                    name="location"
                    value="<?php echo $job["location"]; ?>"
                    />

                </td>

            </tr>

            <tr>

                <td>Job Type</td>

                <td>

                    <input
                    type="radio"
                    name="job_type"
                    value="Full-time"

                    <?php

                    if($job["job_type"] == "Full-time"){

                        echo "checked";

                    }

                    ?>

                    />

                    Full-time

                    <input
                    type="radio"
                    name="job_type"
                    value="Part-time"

                    <?php

                    if($job["job_type"] == "Part-time"){

                        echo "checked";

                    }

                    ?>

                    />

                    Part-time

                    <input
                    type="radio"
                    name="job_type"
                    value="Remote"

                    <?php

                    if($job["job_type"] == "Remote"){

                        echo "checked";

                    }

                    ?>

                    />

                    Remote

                </td>

            </tr>

            <tr>

                <td>Deadline</td>

                <td>

                    <input
                    type="date"
                    name="deadline"
                    value="<?php echo $job["deadline"]; ?>"
                    />

                </td>

            </tr>

            <tr>

                <td></td>

                <td>

                    <input
                    type="submit"
                    name="submit"
                    value="Update Job"
                    />

                </td>

            </tr>

        </table>

    </form>
</div>

</body>

</html>