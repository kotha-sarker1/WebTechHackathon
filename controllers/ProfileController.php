<?php

include "../models/DatabaseConnection.php";
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../views/login.php");
    exit();
}

$db   = new DatabaseConnection();
$conn = $db->openConnection();

$id   = $_SESSION['user_id'];
$role = $_SESSION['role'];

if (isset($_POST['save_profile'])) {

    if ($role == "employer") {
        $db->saveEmployerProfile($conn, $id, $_POST['company'], $_POST['industry'], $_POST['description'], $_POST['website']);
    } else {
        $db->saveSeekerProfile($conn, $id, $_POST['headline'], $_POST['skills'], $_POST['experience']);
    }

    header("Location: ../views/dashboard.php");
    exit();
}

if (isset($_POST['update_profile'])) {

    if (!empty($_FILES['fileupload']['name'])) {

        $file = $_FILES['fileupload'];
        $maxSize = 2 * 1024 * 1024;
        $allowedTypes = ["image/jpeg", "image/png", "application/pdf"];

        if ($file['size'] > $maxSize) {
            $_SESSION['err'] = "File size must be <= 2 MB";
            header("Location: ../views/edit_profile.php");
            exit();
        }

        if (!in_array($file['type'], $allowedTypes)) {
            $_SESSION['err'] = "Only JPG, PNG, and PDF allowed";
            header("Location: ../views/edit_profile.php");
            exit();
        }

        $uploadDir = "../public/uploads/";

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $path = $uploadDir . time() . "_" . basename($file['name']);
        move_uploaded_file($file['tmp_name'], $path);

        $stmt = $conn->prepare("UPDATE users SET file_path=? WHERE id=?");
        $stmt->bind_param("si", $path, $id);
        $stmt->execute();
    }

    if ($role == "employer") {
        $db->updateEmployerProfile($conn, $id, $_POST['company'], $_POST['industry'], $_POST['description'], $_POST['website']);
    } else {
        $db->updateSeekerProfile($conn, $id, $_POST['headline'], $_POST['skills'], $_POST['experience']);
    }

    if (!empty($_POST['current_password']) && !empty($_POST['new_password'])) {

        $stmt = $conn->prepare("SELECT password_hash FROM users WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $row = $stmt->get_result()->fetch_assoc();

        if (password_verify($_POST['current_password'], $row['password_hash'])) {

            $newPass = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

            $upd = $conn->prepare("UPDATE users SET password_hash=? WHERE id=?");
            $upd->bind_param("si", $newPass, $id);
            $upd->execute();

        } else {

            $_SESSION['err'] = "Wrong current password";
            header("Location: ../views/edit_profile.php");
            exit();
        }
    }

    header("Location: ../views/dashboard.php");
    exit();
}

?>