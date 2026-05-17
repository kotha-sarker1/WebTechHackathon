<?php

include "../models/DatabaseConnection.php";

session_start();

$id = $_POST["id"];

$category_name = trim($_POST["category_name"]);

$hasError = false;

if(!$category_name){

    $_SESSION["categoryErr"] = "Category Name is Required";

    $hasError = true;

}else{

    unset($_SESSION["categoryErr"]);

}

if($hasError){

    Header("Location: ../views/editCategory.php?id=$id");

}else{

    $db = new DatabaseConnection();

    $connection = $db->openConnection();

    $result = $db->updateCategory(

        $connection,
        "categories",
        $id,
        $category_name

    );

    if($result){

        Header("Location: ../views/categoryDashboard.php");

    }

}

?>