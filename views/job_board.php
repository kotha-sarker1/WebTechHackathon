<?php
    require_once('../models/jobModel.php');
    session_start();

    $role    = $_SESSION["role"]    ?? "";
    $user_id = $_SESSION["user_id"] ?? "";
    $name    = $_SESSION["name"]    ?? "";

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

    <div class="nav-bar">
        <a href="job_board.php">Job Board</a>
        <a href="saved_jobs.php">Saved Jobs</a>
        <a href="my_applications.php">My Applications</a>
        <a href="profile_seeker.php">Profile</a>
        <a href="../controllers/logout.php">Logout</a>
        <span class="nav-greeting">Hello, <?php echo htmlspecialchars($name); ?> (Seeker)</span>
    </div>

    <div class="page-wrapper">

        <h2>My Applications</h2>

        <?php if($applySuccess != ""){ ?>
            <p class="msg-success"><?php echo htmlspecialchars($applySuccess); ?></p>
        <?php } ?>

        <?php if(count($applications) == 0){ ?>
            <p>You have not applied to any jobs yet. <a href="job_board.php">Browse jobs</a></p>
        <?php }else{ ?>
            <div class="table-wrapper">
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
                            $status_colors = [
                                "Submitted"   => "badge-submitted",
                                "Reviewed"    => "badge-reviewed",
                                "Shortlisted" => "badge-shortlisted",
                                "Rejected"    => "badge-rejected"
                            ];
                            $badge_class = $status_colors[$app['status']] ?? "badge-default";
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($app['job_title']); ?></td>
                            <td><?php echo htmlspecialchars($app['company_name']); ?></td>
                            <td><?php echo date("d M Y", strtotime($app['created_at'])); ?></td>
                            <td><span class="badge <?php echo $badge_class; ?>"><?php echo $app['status']; ?></span></td>
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
