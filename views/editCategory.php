<?php

include "../models/DatabaseConnection.php";

session_start();

$id = $_GET["id"] ?? "";

if(!$id){

    die("Invalid Category ID");

}

$db = new DatabaseConnection();

$connection = $db->openConnection();

$result = $db->getCategoryById($connection, "categories", $id);

$row = $result->fetch_assoc();

$categoryError = $_SESSION["categoryErr"] ?? "";

unset($_SESSION["categoryErr"]);

?>

<html>

<head>

    <title>Edit Category</title>

</head>

<body>

    <h1>Edit Category</h1>

    <form method="post" action="../controllers/EditCategory.php">

        <input type="hidden" name="id" value="<?php echo $row["id"]; ?>"/>

        <table>

            <tr>

                <td>Category Name</td>

                <td>

                    <input
                    type="text"
                    name="category_name"
                    value="<?php echo $row["name"]; ?>"
                    />

                </td>

                <td>

                    <p style="color:red;">

                        <?php echo $categoryError; ?>

                    </p>

                </td>

            </tr>

            <tr>

                <td></td>

                <td>

                    <input type="submit" value="Update Category"/>

                </td>

            </tr>

        </table>

    </form>

</body>

</html>