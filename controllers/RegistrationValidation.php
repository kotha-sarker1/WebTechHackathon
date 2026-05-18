<?php

include "../models/DatabaseConnection.php";

session_start();

if (isset($_POST['register'])) {

    $name = $_POST['name'] ?? "";
    $email = $_POST['email'] ?? "";
    $password = $_POST['password'] ?? "";
    $role = $_POST['role'] ?? "";
    $file = $_FILES['fileupload'] ?? null;

    if (strlen($password) < 8) {

        $_SESSION["err"] = "Password must be >= 8 chars";

        header("Location: ../views/register.php");

        exit();
    }

    $path = "";

    if (isset($file) && $file["name"] != "") {

        $maxSize = 2 * 1024 * 1024;

        $allowedTypes = ["image/jpeg", "image/png", "application/pdf"];

        if ($file["size"] > $maxSize) {

            $_SESSION["err"] = "File size must be <= 2 MB";

            header("Location: ../views/register.php");

            exit();
        }

        if (!in_array($file["type"], $allowedTypes)) {

            $_SESSION["err"] = "Only JPG, PNG, and PDF allowed";

            header("Location: ../views/register.php");

            exit();
        }

        $uploadDir = "../public/uploads/";

        if (!is_dir($uploadDir)) {

            mkdir($uploadDir, 0777, true);
        }

        $path = $uploadDir . time() . "_" . basename($file["name"]);

        move_uploaded_file($file["tmp_name"], $path);
    }

    $db = new DatabaseConnection();

    $conn = $db->openConnection();

    $passHash = password_hash($password, PASSWORD_DEFAULT);

    $stmtCheck = $conn->prepare("SELECT id FROM users WHERE email = ?");

    $stmtCheck->bind_param("s", $email);

    $stmtCheck->execute();

    if ($stmtCheck->get_result()->num_rows > 0) {

        $_SESSION["err"] = "Email already exists!";

        header("Location: ../views/register.php");

        exit();
    }

    $result = $db->RegisterUser($conn, $name, $email, $passHash, $role, $path);

    if ($result) {

        header("Location: ../views/login.php");

    } else {

        $_SESSION["err"] = "Registration failed!";

        header("Location: ../views/register.php");
    
        }

    exit();

}

?>