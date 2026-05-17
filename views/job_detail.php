<?php
    require_once('../models/jobModel.php');
    session_start();
    
    $role      = $_SESSION["role"]      ?? "";
    $user_id   = $_SESSION["user_id"]   ?? "";
    $name      = $_SESSION["name"]      ?? "";
    $file_path = $_SESSION["file_path"] ?? "";
    $job_id    = $_GET['id']            ?? "";

    if($job_id == ""){ header('location: job_board.php'); exit(); }

    $job = getJobById($job_id);
    if(count($job) == 0){ header('location: job_board.php'); exit(); }

    $alreadyApplied = false;
    if($role == "seeker"){
        $alreadyApplied = checkExistingApplication($job_id, $user_id);
    }

    $applyErr       = $_SESSION["applyErr"]       ?? "";
    $coverLetterErr = $_SESSION["coverLetterErr"] ?? "";
    unset($_SESSION["applyErr"]);
    unset($_SESSION["coverLetterErr"]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo htmlspecialchars($job['title']); ?> - Job Portal</title>
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

        <a class="back-link" href="job_board.php">&larr; Back to Job Board</a>

        <h2><?php echo htmlspecialchars($job['title']); ?></h2>

        <div class="section-box">
            <div class="section-title">Job Details</div>
            <table class="detail-table">
                <tr><td><strong>Company</strong></td><td><?php echo htmlspecialchars($job['company_name']); ?></td></tr>
                <tr><td><strong>Industry</strong></td><td><?php echo htmlspecialchars($job['industry']); ?></td></tr>
                <tr><td><strong>Category</strong></td><td><?php echo htmlspecialchars($job['category_name']); ?></td></tr>
                <tr><td><strong>Location</strong></td><td><?php echo htmlspecialchars($job['location']); ?></td></tr>
                <tr><td><strong>Job Type</strong></td><td><?php echo htmlspecialchars($job['job_type']); ?></td></tr>
                <tr><td><strong>Salary</strong></td><td><?php echo htmlspecialchars($job['salary_range']); ?></td></tr>
                <tr><td><strong>Deadline</strong></td><td><?php echo htmlspecialchars($job['deadline']); ?></td></tr>
                <?php if($job['website'] != ""){ ?>
                <tr><td><strong>Website</strong></td><td><a href="<?php echo htmlspecialchars($job['website']); ?>" target="_blank"><?php echo htmlspecialchars($job['website']); ?></a></td></tr>
                <?php } ?>
            </table>
        </div>

        <br>

        <div class="section-box">
            <div class="section-title">Description</div>
            <p><?php echo nl2br(htmlspecialchars($job['description'])); ?></p>
        </div>

        <br>

        <div class="section-box">
            <div class="section-title">Requirements</div>
            <p><?php echo nl2br(htmlspecialchars($job['requirements'])); ?></p>
        </div>

        <br>

        <?php if($role == "seeker"){ ?>
            <?php if($alreadyApplied){ ?>
                <p class="msg-success"><strong>&#10003; You have already applied for this job.</strong></p>
            <?php }else{ ?>
                <div class="section-box">
                    <div class="section-title">Apply Now</div>

                    <?php if($applyErr != ""){ echo "<p class='msg-error'>".htmlspecialchars($applyErr)."</p>"; } ?>

                    <form method="post" action="../controllers/jobController.php" enctype="multipart/form-data">
                        <input type="hidden" name="action" value="apply">
                        <input type="hidden" name="job_id" value="<?php echo $job_id; ?>">

                        <div class="form-group">
                            <label>Cover Letter:</label>
                            <textarea name="cover_letter" rows="6" placeholder="Write your cover letter..." style="width:100%;"></textarea>
                            <?php if($coverLetterErr != ""){ echo "<span class='msg-error'>".$coverLetterErr."</span>"; } ?>
                        </div>

                        <?php if($file_path != ""){ ?>
                        <div class="form-group">
                            <label><input type="radio" name="use_profile_resume" value="yes" checked> Use my profile resume</label><br>
                            <label><input type="radio" name="use_profile_resume" value="no"> Upload new resume</label>
                        </div>
                        <?php } ?>

                        <div class="form-group">
                            <label>Upload Resume (PDF, max 2MB):</label><br>
                            <input type="file" name="resume_upload" accept=".pdf">
                        </div>

                        <div class="form-group" style="text-align:center;">
                            <input type="submit" value="Submit Application">
                        </div>
                    </form>
                </div>
            <?php } ?>
        <?php } ?>

    </div>

    <script src="../config/script.js"></script>
</body>
</html>
