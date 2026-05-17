<?php
include "../models/DatabaseConnection.php";
session_start();

if(isset($_POST['login'])){

    $email = $_POST['email'] ?? "";
    $password = $_POST['password'] ?? "";

    $db = new DatabaseConnection();
    $conn = $db->openConnection();

    $res = $conn->query("SELECT * FROM users WHERE email='$email'");

    if($res && $res->num_rows == 1){

        $user = $res->fetch_assoc();

        if(password_verify($password, $user['password_hash'])){

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['role'] = $user['role'];

            header("Location: ../views/dashboard.php");
            exit();

        } else {
            $_SESSION["err"] = "wrong password";git push origin feature/task1-auth
            header("Location: ../views/login.php");
            exit();
        }

    } else {
        $_SESSION["err"] = "User not found";
        header("Location: ../views/login.php");
        exit();
    }
}
?>