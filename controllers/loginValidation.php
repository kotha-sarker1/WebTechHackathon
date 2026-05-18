<?php

include "../models/DatabaseConnection.php";

session_start();

if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $db = new DatabaseConnection();

    $conn = $db->openConnection();

    $result = $db->GetUserByEmail($conn, $email);

    if ($result->num_rows == 1) {

        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password_hash'])) {

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name']    = $user['name'];
            $_SESSION['role']    = $user['role'];

            
            if ($user['role'] == 'admin') {
                header("Location: ../views/dashboard.php");
            } elseif ($user['role'] == 'employer') {
                header("Location: ../views/dashboard.php");
            } else {
                header("Location: ../views/dashboard.php");
            }

        } else {

            $_SESSION['err'] = "Wrong Password";
            header("Location: ../views/login.php");
        }

    } else {

        $_SESSION['err'] = "User Not Found";
        header("Location: ../views/login.php");
    }

    exit();
}

?>