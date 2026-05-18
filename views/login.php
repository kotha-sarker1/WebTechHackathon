<?php
session_start();

$err = $_SESSION["err"] ?? "";
unset($_SESSION["err"]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Job Portal</title>
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body>

<div class="container">

    <h2>Login</h2>

    <form method="post" action="../controllers/loginValidation.php">

        <div>
            <label>Email</label>
            <input type="email" name="email" required>
        </div>

        <div>
            <label>Password</label>
            <input type="password" name="password" required>
        </div>

        <?php if (!empty($err)) { ?>
            <p class="error-msg"><?php echo $err; ?></p>
        <?php } ?>

        <button type="submit" name="login">Login</button>

    </form>

    <p class="page-link">
        Don't have an account?
        <a href="register.php">Register here</a>
    </p>

</div>

</body>
</html>