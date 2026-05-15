<?php

include "../Model/DatabaseConnection.php";

session_start();

$category_name = $_POST["category_name"] ?? "";

$hasError = false;

if(!$category_name){

    $_SESSION["categoryErr"] = "Category Name is Required";
    $hasError = true;

}else{

    unset($_SESSION["categoryErr"]);

}

if($hasError){

    Header("Location: ../View/categoryDashboard.php");

}else{

    $db = new DatabaseConnection();

    $connection = $db->openConnection();

    $result = $db->createCategory($connection, "categories", $category_name);

    if($result){

        $_SESSION["successMsg"] = "Category Added Successfully";

        Header("Location: ../View/categoryDashboard.php");

    }

}

?>