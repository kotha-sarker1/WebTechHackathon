<?php

include "../models/DatabaseConnection.php";

session_start();

$id = $_POST["id"];

$title = $_POST["title"] ?? "";

$category_id = $_POST["category_id"] ?? "";

$description = $_POST["description"] ?? "";

$requirements = $_POST["requirements"] ?? "";

$salary_range = $_POST["salary_range"] ?? "";

$location = $_POST["location"] ?? "";

$job_type = $_POST["job_type"] ?? "";

$deadline = $_POST["deadline"] ?? "";

$hasError = false;

if(!$title){

    $_SESSION["titleErr"] = "Job Title is Required";

    $hasError = true;

}else{

    unset($_SESSION["titleErr"]);

}

if($hasError){

    Header("Location: ../views/editJob.php?id=$id");

}else{

    $db = new DatabaseConnection();

    $connection = $db->openConnection();

    $result = $db->updateJob(

        $connection,
        "jobs",
        $id,
        $category_id,
        $title,
        $description,
        $requirements,
        $salary_range,
        $location,
        $job_type,
        $deadline

    );

    if($result){

        Header("Location: ../views/employerDashboard.php");

    }

}

?>