<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Saved Jobs</title>
</head>
<body>

    <div class="nav-bar">
        <a href="job_board.php">Job Board</a>
        <a href="saved_jobs.php">Saved Jobs</a>
        <a href="my_applications.php">My Applications</a>
        <a href="profile_seeker.php">Profile</a>
        <a href="../controllers/logout.php">Logout</a>
        <span class="nav-greeting">Hello, [User Name] (Seeker)</span>
    </div>

    <div class="page-wrapper">

        <h2>Saved Jobs</h2>

        <div id="jobsContainer">
            
            <div class="job-card">
                <div class="job-card-top">
                    <div class="job-card-info">
                        <h3>Software Engineer</h3>
                        <div class="company">Tech Company Ltd.</div>
                        <div class="meta">
                            Dhaka | Full-time | Deadline: 2026-06-30
                        </div>
                    </div>
                    <button class="heart-btn" id="heartBtn_1" onclick="toggleSaveJob(1)" style="color:red;" title="Remove from saved">
                        &#9829;
                    </button>
                </div>
                <div class="job-card-footer">
                    <a class="btn-view" href="job_detail.php?id=1">View & Apply</a>
                </div>
            </div>

            <div class="job-card">
                <div class="job-card-top">
                    <div class="job-card-info">
                        <h3>UI/UX Designer</h3>
                        <div class="company">Creative Agency</div>
                        <div class="meta">
                            Remote | Part-time | Deadline: 2026-06-15
                        </div>
                    </div>
                    <button class="heart-btn" id="heartBtn_2" onclick="toggleSaveJob(2)" style="color:red;" title="Remove from saved">
                        &#9829;
                    </button>
                </div>
                <div class="job-card-footer">
                    <a class="btn-view" href="job_detail.php?id=2">View & Apply</a>
                </div>
            </div>

        </div>

    </div>

</body>
</html>