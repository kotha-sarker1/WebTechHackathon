<?php

class DatabaseConnection{

    function openConnection(){

        $db_host = "localhost";
        $db_username = "root";
        $db_password = "";
        $db_name = "job_portal_db";

        $conn = new mysqli($db_host,$db_username,$db_password,$db_name);

        if($conn->connect_error){

            die("Database Connection Failed".$conn->connect_error);

        }

        return $conn;
    }

}
?>

