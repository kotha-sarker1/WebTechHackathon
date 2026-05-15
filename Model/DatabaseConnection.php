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
}

?>
