<?php
include "../models/DatabaseConnection.php";
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$db   = new DatabaseConnection();
$conn = $db->openConnection();

$isIncomplete = $db->checkProfileIncomplete(
    $conn,
    $_SESSION['user_id'],
    $_SESSION['role']
);


if ($isIncomplete) {
    header("Location: profile.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Job Portal</title>
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body>

<div class="dashboard-box">

    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>!</h2>

    <p>
        Role:
        <strong><?php echo ucfirst(htmlspecialchars($_SESSION['role'])); ?></strong>
    </p>

    <?php if ($isIncomplete): ?>
        <div class="banner-warning">
            <strong>Profile Incomplete!</strong>
            <a href="profile.php">Click here to complete your profile.</a>
        </div>
    <?php endif; ?>

    <hr>

    <div class="nav-links">
        <a href="edit_profile.php">Edit Profile</a>
        <a href="../controllers/logout.php">Logout</a>
    </div>

</div>

</body>
</html>