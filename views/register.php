<?php
session_start();

$err = $_SESSION["err"] ?? "";
unset($_SESSION["err"]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Job Portal</title>
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body>

<div class="container">

    <h2>Register</h2>

    <form method="post" action="../controllers/RegistrationValidation.php" enctype="multipart/form-data">

        <div>
            <label>Name</label>
            <input type="text" name="name" >
        </div>

        <div>
            <label>Email</label>
            <input type="email" name="email" >
        </div>

        <div>
            <label>Password (min 8 characters)</label>
            <input type="password" name="password" >
        </div>

        <div>
            <label>Role</label>
            <div class="radio-group">
                <input type="radio" name="role" value="employer" >
                <label>Employer</label>

                <input type="radio" name="role" value="seeker" >
                <label>Job Seeker</label>
            </div>
        </div>

        <div>
            <label>Upload File (Logo for Employer / Resume for Job Seeker)</label>
            <input type="file" name="fileupload" accept=".jpg,.png,.pdf">
            <small>Max file size: 2 MB. Allowed: JPG, PNG, PDF</small>
        </div>

        <?php if (!empty($err)) { ?>
            <p class="error-msg"><?php echo $err; ?></p>
        <?php } ?>

        <button type="submit" name="register">Register</button>

    </form>

    <p class="page-link">
        Already have an account?
        <a href="login.php">Login here</a>
    </p>

</div>

</body>
</html>