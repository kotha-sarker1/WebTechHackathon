<?php
    session_start();
    require_once('../models/db.php');

    // If already logged in, redirect to job board
    if(isset($_SESSION["isLoggedIn"]) && $_SESSION["isLoggedIn"] === true){
        header('location: job_board.php');
        exit();
    }

    $error = "";

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $email    = trim($_POST['email']    ?? "");
        $password = trim($_POST['password'] ?? "");

        if($email === "" || $password === ""){
            $error = "Please enter both email and password.";
        } else {
            $con = getConnection();
            $email_safe = mysqli_real_escape_string($con, $email);

            $result = mysqli_query($con, "SELECT * FROM users WHERE email = '$email_safe' LIMIT 1");

            if($result && mysqli_num_rows($result) === 1){
                $user = mysqli_fetch_assoc($result);

                if(password_verify($password, $user['password_hash'])){
                    $_SESSION["isLoggedIn"] = true;
                    $_SESSION["user_id"]    = $user['id'];
                    $_SESSION["name"]       = $user['name'];
                    $_SESSION["role"]       = $user['role'];
                    $_SESSION["file_path"]  = $user['file_path'] ?? "";

                    if($user['role'] === 'seeker'){
                        header('location: job_board.php');
                    } else if($user['role'] === 'employer'){
                        header('location: employer_dashboard.php');
                    } else {
                        header('location: job_board.php');
                    }
                    exit();
                } else {
                    $error = "Invalid email or password.";
                }
            } else {
                $error = "Invalid email or password.";
            }
        }
    }
?>
<html lang="en">
<head>
    <title>Login - Job Portal</title>
    <link rel="stylesheet" href="style.css"/>
    <style>
        .login-container {
            max-width: 400px;
            margin: 80px auto;
            padding: 30px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background: #fafafa;
        }
        .login-container h2 {
            margin-top: 0;
            margin-bottom: 20px;
            text-align: center;
        }
        .login-container label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .login-container input[type="email"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .login-container input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 15px;
        }
        .login-container input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .error-msg {
            color: red;
            margin-bottom: 12px;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <h2>Job Portal Login</h2>

        <?php if($error !== ""){ ?>
            <p class="error-msg"><?php echo htmlspecialchars($error); ?></p>
        <?php } ?>

        <form method="POST" action="login.php">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>

            <input type="submit" value="Login">
        </form>
    </div>

</body>
</html>
