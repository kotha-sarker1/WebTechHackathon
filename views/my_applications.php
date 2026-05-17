<?php
    require_once('../models/jobModel.php');
    session_start();

    $isLoggedIn = $_SESSION["isLoggedIn"] ?? false;
    if(!$isLoggedIn){ header('location: login.php'); exit(); }

    $role    = $_SESSION["role"]    ?? "";
    $user_id = $_SESSION["user_id"] ?? "";
    $name    = $_SESSION["name"]    ?? "";

    if($role != "seeker"){ header('location: login.php'); exit(); }

    $applySuccess = $_SESSION["applySuccess"] ?? "";
    unset($_SESSION["applySuccess"]);

    $applications = getApplicationsBySeeker($user_id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Applications</title>
    <link rel="stylesheet" href="style.css"/>
</head>
<body>

    <div class="topnav">
        <a href="job_board.php">Job Board</a>
        <a href="saved_jobs.php">Saved Jobs</a>
        <a href="my_applications.php">My Applications</a>
        <a href="profile_seeker.php">Profile</a>
        <a href="../controllers/logout.php">Logout</a>
        <span class="greet-text">Hello, <?php echo htmlspecialchars($name); ?> (Seeker)</span>
    </div>

    <div class="main-wrap">

        <h2>My Applications</h2>

        <?php if($applySuccess != ""){ ?>
            <p class="ok-msg"><?php echo htmlspecialchars($applySuccess); ?></p>
        <?php } ?>

        <?php if(count($applications) == 0){ ?>
            <p>You have not applied to any jobs yet. <a href="job_board.php">Browse jobs</a></p>
        <?php }else{ ?>
            <div class="tbl-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Job Title</th>
                            <th>Company</th>
                            <th>Date Applied</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($applications as $app){
                            $tagMap = [
                                "Submitted"   => "stag-new",
                                "Reviewed"    => "stag-seen",
                                "Shortlisted" => "stag-pick",
                                "Rejected"    => "stag-no"
                            ];
                            $tagClass = $tagMap[$app['status']] ?? "stag-def";
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($app['job_title']); ?></td>
                            <td><?php echo htmlspecialchars($app['company_name']); ?></td>
                            <td><?php echo date("d M Y", strtotime($app['created_at'])); ?></td>
                            <td><span class="stag <?php echo $tagClass; ?>"><?php echo $app['status']; ?></span></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php } ?>

    </div>

    <script src="../config/script.js"></script>
</body>
</html>
