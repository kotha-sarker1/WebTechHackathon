<?php

include "../models/DatabaseConnection.php";

session_start();

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

    Header("Location: ../views/createJob.php");

}else{

    $employer_id = 1;

    $db = new DatabaseConnection();

    $connection = $db->openConnection();

    $result = $db->createJob(

        $connection,
        "jobs",
        $employer_id,
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

        $_SESSION["successMsg"] = "Job Created Successfully";

        Header("Location: ../views/createJob.php");

    }

}

?>