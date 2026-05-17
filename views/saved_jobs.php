<?php
    require_once('../models/jobModel.php');
    session_start();

    $role    = $_SESSION["role"]    ?? "";
    $user_id = $_SESSION["user_id"] ?? "";
    $name    = $_SESSION["name"]    ?? "";

    $savedJobs = getSavedJobs($user_id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Saved Jobs</title>
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

        <h2>Saved Jobs</h2>

        <?php if(count($savedJobs) == 0){ ?>
            <p>No saved jobs yet. <a href="job_board.php">Browse jobs</a></p>
        <?php }else{ ?>
            <div id="jobs_container">
            <?php foreach($savedJobs as $job){ ?>
            <div class="job-card">
                <div class="job-card-top">
                    <div class="job-card-info">
                        <h3><?php echo htmlspecialchars($job['title']); ?></h3>
                        <div class="company"><?php echo htmlspecialchars($job['company_name']); ?></div>
                        <div class="meta">
                            <?php echo $job['location']; ?> &nbsp;|&nbsp;
                            <?php echo $job['job_type']; ?> &nbsp;|&nbsp;
                            Deadline: <?php echo $job['deadline']; ?>
                        </div>
                    </div>
                    <button class="heart-btn"
                        id="heart_btn_<?php echo $job['job_id']; ?>"
                        onclick="toggleSaveJob(<?php echo $job['job_id']; ?>)"
                        style="color:red;" title="Remove from saved">
                        &#9829;
                    </button>
                </div>
                <div class="job-card-footer">
                    <a class="btn-view" href="job_detail.php?id=<?php echo $job['job_id']; ?>">View &amp; Apply</a>
                </div>
            </div>
            <?php } ?>
            </div>
        <?php } ?>

    </div>

    <script src="../config/script.js"></script>
</body>
</html>
