<?php

include "../Model/DatabaseConnection.php";

session_start();

$categoryError = $_SESSION["categoryErr"] ?? "";

$successMsg = $_SESSION["successMsg"] ?? "";

$deleteErr = $_SESSION["deleteErr"] ?? "";

unset($_SESSION["categoryErr"]);
unset($_SESSION["successMsg"]);
unset($_SESSION["deleteErr"]);

$db = new DatabaseConnection();

$connection = $db->openConnection();

$categories = $db->getAllCategories($connection, "categories");

?>

<html>

<head>
    <title>Category Dashboard</title>
</head>

<body>

    <h1>Admin Category Dashboard</h1>

    <form method="post" action="../Controller/CreateCategory.php">

        <table>

            <tr>
                <td>Category Name</td>
                <td>
                    <input type="text" name="category_name" placeholder="Enter Category Name"/>
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
                    <input type="submit" name="submit" value="Add Category"/>
                </td>

            </tr>

        </table>

    </form>

    <p style="color:green;">
        <?php echo $successMsg; ?>
    </p>

    <p style="color:red;">
        <?php echo $deleteErr; ?>
    </p>

    <h2>All Categories</h2>

    <table border="1">

        <tr>

            <th>ID</th>
            <th>Category Name</th>
            <th>Action</th>

        </tr>

        <?php

        while($row = $categories->fetch_assoc()){

            $id = $row["id"];

            $name = $row["name"];

            echo "
            
            <tr>

                <td>$id</td>

                <td>$name</td>

                <td>

                    <a href='../Controller/DeleteCategory.php?id=$id'>
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