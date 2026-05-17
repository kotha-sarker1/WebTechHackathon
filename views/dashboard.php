<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>

    <h2>Welcome <?php echo $_SESSION['name']; ?></h2>
    <h3>Role: <?php echo $_SESSION['role']; ?></h3>

</body>
</html>