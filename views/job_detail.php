<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Software Engineer - Job Portal</title>
</head>
<body>

    <div class="nav-bar">
        <a href="job_board.php">Job Board</a>
        <a href="saved_jobs.php">Saved Jobs</a>
        <a href="my_applications.php">My Applications</a>
        <a href="profile_seeker.php">Profile</a>
        <a href="../controllers/logout.php">Logout</a>
        <span class="nav-greeting">Hello, <?php echo $_SESSION['user_name']; ?> (Seeker)</span>
    </div>

    <div class="page-wrapper">

        <a class="back-link" href="job_board.php">&larr; Back to Job Board</a>

        <h2>Software Engineer</h2>

        <div class="section-box">
            <div class="section-title">Job Details</div>
            <table class="detail-table">
                <tr><td><strong>Company</strong></td><td>Tech Company Ltd.</td></tr>
                <tr><td><strong>Industry</strong></td><td>IT & Software</td></tr>
                <tr><td><strong>Category</strong></td><td>Engineering</td></tr>
                <tr><td><strong>Location</strong></td><td>Dhaka</td></tr>
                <tr><td><strong>Job Type</strong></td><td>Full-time</td></tr>
                <tr><td><strong>Salary</strong></td><td>50,000 - 70,000 BDT</td></tr>
                <tr><td><strong>Deadline</strong></td><td>2026-06-30</td></tr>
                <tr><td><strong>Website</strong></td><td><a href="https://example.com" target="_blank">https://example.com</a></td></tr>
            </table>
        </div>

        <br>

        <div class="section-box">
            <div class="section-title">Description</div>
            <p>We are looking for a skilled Software Engineer to join our core development team. You will be working on building scalable web applications and optimizing system performance.</p>
        </div>

        <br>

        <div class="section-box">
            <div class="section-title">Requirements</div>
            <p>Proficiency in OOP languages (C#, Java, or C++).<br> Experience with web frameworks and SQL databases.<br> Strong problem-solving skills.</p>
        </div>

        <br>

        <div class="section-box">
            <div class="section-title">Apply Now</div>

            <form method="post" action="../controllers/jobController.php" enctype="multipart/form-data">
                <input type="hidden" name="action" value="apply">
                <input type="hidden" name="job_id" value="1">

                <div class="form-group">
                    <label>Cover Letter:</label>
                    <textarea name="cover_letter" rows="6" placeholder="Write your cover letter..." style="width:100%;"></textarea>
                </div>

                <div class="form-group">
                    <label><input type="radio" name="use_profile_resume" value="yes" checked> Use my profile resume</label><br>
                    <label><input type="radio" name="use_profile_resume" value="no"> Upload new resume</label>
                </div>

                <div class="form-group">
                    <label>Upload Resume (PDF, max 2MB):</label><br>
                    <input type="file" name="resume_upload" accept=".pdf">
                </div>

                <div class="form-group" style="text-align:center;">
                    <input type="submit" value="Submit Application">
                </div>
            </form>
        </div>

    </div>

</body>
</html>