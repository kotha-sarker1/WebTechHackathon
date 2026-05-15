<?php

include "../Model/DatabaseConnection.php";

session_start();

$id = $_GET["id"];

$db = new DatabaseConnection();

$connection = $db->openConnection();

$check = $db->checkCategoryHasJobs($connection, "jobs", $id);

if($check->num_rows > 0){

    $_SESSION["deleteErr"] = "Cannot Delete. Jobs Exist Under This Category";

    Header("Location: ../View/categoryDashboard.php");

}else{

    $result = $db->deleteCategory($connection, "categories", $id);

    if($result){

        $_SESSION["successMsg"] = "Category Deleted Successfully";

        Header("Location: ../View/categoryDashboard.php");

    }

}

?>