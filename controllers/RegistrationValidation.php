<?php
include "../models/DatabaseConnection.php";
session_start();


if(isset($_POST['register'])){

    $name = $_POST['name'] ?? "";
    $email = $_POST['email'] ?? "";
    $password = $_POST['password'] ?? "";
    $role = $_POST['role'] ?? "";

    $file = $_FILES['fileupload'] ?? null;

  
    unset($_SESSION["err"]);

   
    if(strlen($password) < 8){
        $_SESSION["err"] = "Password must be 8 chars";
        header("Location: ../views/register.php");
        exit();
    }

    
    $path = "";

    if(isset($file) && $file["name"] != ""){

        $uploadDir = "../public/uploads/";

        if(!is_dir($uploadDir)){
            mkdir($uploadDir, 0777, true);
        }

        $path = $uploadDir . time() . "_" . basename($file["name"]);

        move_uploaded_file($file["tmp_name"], $path);
    }

   
    $db = new DatabaseConnection();
    $conn = $db->openConnection();

    $passHash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users(name,email,password_hash,role,file_path)
            VALUES('$name','$email','$passHash','$role','$path')";

    $conn->query($sql);

   
    header("Location: ../views/login.php");
    exit();
}
?>