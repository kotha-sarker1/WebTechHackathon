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
</head>
<body>

<div class="container">

    <h2>Register</h2>

    <form method="post" action="../controllers/RegistrationValidation.php" enctype="multipart/form-data">

   
        <div>
            <label>Name</label><br>
            <input type="text" name="name" required>
        </div>

        <br>

        
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

        
        <div>
            <label>Role</label><br>

            <input type="radio" name="role" value="employer" required> Employer
            <input type="radio" name="role" value="seeker" required> Seeker
        </div>

        <br>

        <div>
            <label>Upload File (Logo / Resume)</label><br>
            <input type="file" name="fileupload" accept=".jpg,.png,.pdf">
        </div>

        <br>

        <?php if(!empty($err)) { ?>
            <p style="color:red;"><?php echo $err; ?></p>
        <?php } ?>

        <button type="submit" name="register">Register</button>

    </form>

</div>

</body>
</html>