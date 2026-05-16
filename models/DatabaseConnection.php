<?php

class DatabaseConnection{

    function openConnection(){

        $db_host = "localhost";
        $db_username = "root";
        $db_password = "";
        $db_name = "job_portal_db";

        $connection = new mysqli($db_host,$db_username,$db_password,$db_name);

        if($connection->connect_error){

            die("Database Connection Failed".$connection->connect_error);

        }

        return $connection;

    }

    function createCategory($connection, $tableName, $category_name){

        $sql = "INSERT INTO $tableName (name) VALUES('$category_name')";

        $result = $connection->query($sql);

        return $result;

    }

    function getAllCategories($connection, $tableName){

        $sql = "SELECT * FROM $tableName";

        $result = $connection->query($sql);

        return $result;

    }

    function deleteCategory($connection, $tableName, $id ){

        $sql = "DELETE FROM $tableName WHERE id = $id";

        $result = $connection->query($sql);

        return $result;

    }

    function checkCategoryHasJobs($connection, $tableName, $id){

        $sql = "SELECT * FROM jobs WHERE category_id = $id";

        $result = $connection->query($sql);

        return $result;

    }

    function createJob($connection, $tableName, $employer_id, $category_id, $title, $description, $requirements, $salary_range, $location, $job_type, $deadline){

        $sql = "INSERT INTO $tableName
        (employer_id, category_id, title, description, requirements, salary_range, location, job_type, deadline, status)

        VALUES

        ('$employer_id','$category_id','$title','$description','$requirements','$salary_range','$location','$job_type','$deadline','active')";

        $result = $connection->query($sql);

        return $result;

    }

    function getEmployerJobs($connection, $tableName, $employer_id){

        $sql = "SELECT jobs.*, categories.name as category_name

        FROM jobs

        JOIN categories

        ON jobs.category_id = categories.id

        WHERE employer_id = $employer_id";

        $result = $connection->query($sql);

        return $result;

    }

    function deleteJob($connection, $tableName, $id){

        $sql = "DELETE FROM $tableName WHERE id = $id";

        $result = $connection->query($sql);

        return $result;

    }

    function getEmployerJobsWithApplicationCount($connection, $employer_id){

    $sql = "SELECT jobs.*,
    
    categories.name as category_name,

    COUNT(applications.id) as total_applications

    FROM jobs

    JOIN categories

    ON jobs.category_id = categories.id

    LEFT JOIN applications

    ON jobs.id = applications.job_id

    WHERE jobs.employer_id = $employer_id

    GROUP BY jobs.id";

    $result = $connection->query($sql);

    return $result;
    }

    function toggleJobStatus($connection, $id){

    $checkSql = "SELECT status FROM jobs WHERE id = $id";

    $checkResult = $connection->query($checkSql);

    $row = $checkResult->fetch_assoc();

    $currentStatus = $row["status"];

    if($currentStatus == "active"){

        $newStatus = "closed";

    }else{

        $newStatus = "active";

    }

    $sql = "UPDATE jobs SET status = '$newStatus' WHERE id = $id";

    $result = $connection->query($sql);

    return $newStatus;
    }

}

?>