<?php

class DatabaseConnection{

    function openConnection(){

        $db_host = "localhost";
        $db_username = "root";
        $db_password = "";
        $db_name = "job_portal_db";

        $connection = new mysqli($db_host, $db_username, $db_password, $db_name);

        if($connection->connect_error){
            die("Database Connection Failed: " . $connection->connect_error);
        }

        return $connection;
    }

    function RegisterUser($connection, $name, $email, $passHash, $role, $path){

        $sql = "INSERT INTO users (name, email, password_hash, role, file_path)
                VALUES (?, ?, ?, ?, ?)";

        $stmt = $connection->prepare($sql);

        $stmt->bind_param("sssss", $name, $email, $passHash, $role, $path);

        return $stmt->execute();
    }

    function GetUserByEmail($connection, $email){

        $sql = "SELECT * FROM users WHERE email = ?";

        $stmt = $connection->prepare($sql);

        $stmt->bind_param("s", $email);

        $stmt->execute();

        return $stmt->get_result();
    }

    function CheckEmailExists($connection, $email){

        $sql = "SELECT id FROM users WHERE email = ?";

        $stmt = $connection->prepare($sql);

        $stmt->bind_param("s", $email);

        $stmt->execute();

        $result = $stmt->get_result();

        return $result->num_rows > 0;
    }
}

?>