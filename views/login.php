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
</head>
<body>

    <div class="container">

        <h2>Login</h2>

        <form method="post" action="../controllers/loginValidation.php">

            <div>
                <label>Email</label><br>
                <input type="email" name="email" required>
            </div>

            <br>

            <div>
                <label>Password</label><br>
                <input type="password" name="password" required>
            </div>

            <br>

            <?php if(!empty($err)) { ?>
                <p style="color:red;"><?php echo $err; ?></p>
            <?php } ?>

            <button type="submit" name="login">Login</button>

        </form>

    </div>

</body>
</html>