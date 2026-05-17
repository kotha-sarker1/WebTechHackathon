<?php
    require_once('../models/jobModel.php');
    session_start();

    $isLoggedIn = $_SESSION["isLoggedIn"] ?? false;
    if(!$isLoggedIn){ header('location: login.php'); exit(); }

    $role    = $_SESSION["role"]    ?? "";
    $user_id = $_SESSION["user_id"] ?? "";
    $name    = $_SESSION["name"]    ?? "";

    if($role != "seeker"){ header('location: login.php'); exit(); }

    $savedJobs = getSavedJobs($user_id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Saved Jobs</title>
    <link rel="stylesheet" href="style.css"/>
</head>
<body>

    <div class="topnav">
        <a href="job_board.php">Job Board</a>
        <a href="saved_jobs.php">Saved Jobs</a>
        <a href="my_applications.php">My Applications</a>
        <a href="profile_seeker.php">Profile</a>
        <a href="../controllers/logout.php">Logout</a>
        <span class="greet-text"> <?php echo htmlspecialchars($name); ?> (Seeker)</span>
    </div>

    <div class="main-wrap">

        <h2>Saved Jobs</h2>

        <?php if(count($savedJobs) == 0){ ?>
            <p>No saved jobs yet. <a href="job_board.php">Browse jobs</a></p>
        <?php }else{ ?>
            <div id="listWrap">
            <?php foreach($savedJobs as $job){ ?>
            <div class="jcard">
                <div class="jcard-head">
                    <div class="jcard-body">
                        <h3><?php echo htmlspecialchars($job['title']); ?></h3>
                        <div class="cname"><?php echo htmlspecialchars($job['company_name']); ?></div>
                        <div class="jmeta">
                            <?php echo $job['location']; ?> &nbsp;|&nbsp;
                            <?php echo $job['job_type']; ?> &nbsp;|&nbsp;
                            Deadline: <?php echo $job['deadline']; ?>
                        </div>
                    </div>
                    <button class="savebtn"
                        id="sbtn_<?php echo $job['job_id']; ?>"
                        onclick="toggleSaveJob(<?php echo $job['job_id']; ?>)"
                        style="color:red;" title="Remove from saved">
                        &#9829;
                    </button>
                </div>
                <div class="jcard-foot">
                    <a class="viewlink" href="job_detail.php?id=<?php echo $job['job_id']; ?>">View &amp; Apply</a>
                </div>
            </div>
            <?php } ?>
            </div>
        <?php } ?>

    </div>

    <script src="../config/script.js"></script>
</body>
</html>
