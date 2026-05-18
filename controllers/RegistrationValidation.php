<?php

include "../models/DatabaseConnection.php";

session_start();


if(isset($_POST['register'])){

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $file = $_FILES['fileupload'];

    if(strlen($password) < 8){

        $_SESSION['err'] = "Password must be at least 8 characters long";

        header("Location: ../views/register.php");

        exit();

    }

    $db = new DatabaseConnection();

    $conn = $db->openConnection();

    $checkEmailSql = "SELECT id FROM users WHERE email = ?";

    $stmtCheck = $conn->prepare($checkEmailSql);

    $stmtCheck->bind_param("s", $email);

    $stmtCheck->execute();

    $resultCheck = $stmtCheck->get_result();

    if($resultCheck->num_rows > 0){

        $_SESSION['err'] = "This email is already registered";

        header("Location: ../views/register.php");

        exit();

    }

    $path = "";

    if($file['name'] != ""){

        $uploadDir = "../public/uploads/";

        if(!is_dir($uploadDir)){

            mkdir($uploadDir, 0777, true);

        }

        $path = $uploadDir . time() . "_" . basename($file['name']);

        move_uploaded_file($file['tmp_name'], $path);

    
    }



    $passHash = password_hash($password, PASSWORD_DEFAULT);

    $result = $db->RegisterUser($conn, $name, $email, $passHash, $role, $path);

    if($result){

        header("Location: ../views/login.php");

    }else{

        $_SESSION['err'] = "Registration Failed";

        header("Location: ../views/register.php");

    }

    exit();

}

?>