<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Job Board</title>
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

        <h2>Job Board</h2>

        <div class="section-box">
            <div class="section-title">Search & Filter</div>

            <div>
                <label>Search:</label>
                <input type="text" id="searchKeyword" placeholder="Search by title, company..." onkeyup="searchJobs()" style="width:280px;">
            </div>

            <div class="filter-row">
                <label>Category:</label>
                <select id="filterCategory" onchange="filterJobs()">
                    <option value="">All Categories</option>
                    <option value="1">Category Placeholder 1</option>
                    <option value="2">Category Placeholder 2</option>
                </select>

                <label>Type:</label>
                <select id="filterType" onchange="filterJobs()">
                    <option value="">All Types</option>
                    <option value="Full-time">Full-time</option>
                    <option value="Part-time">Part-time</option>
                    <option value="Remote">Remote</option>
                </select>

                <label>Location:</label>
                <input type="text" id="filterLocation" placeholder="e.g. Dhaka" onkeyup="filterJobs()" style="width:130px;">

                <label>Salary:</label>
                <input type="text" id="filterSalary" placeholder="e.g. 17000" onkeyup="filterJobs()" style="width:110px;">
            </div>
        </div>

        <div id="jobsContainer">
            
            <div class="job-card">
                <div class="job-card-top">
                    <div class="job-card-info">
                        <h3>Software Engineer</h3>
                        <div class="company">Tech Company Ltd.</div>
                        <div class="meta">
                            IT & Software | Dhaka | Full-time<br>
                            Salary: 50,000 - 70,000 BDT | Deadline: 2026-06-30
                        </div>
                    </div>
                    <button class="heart-btn" id="heartBtn_1" onclick="toggleSaveJob(1)" style="color: red;">
                        &#9829;
                    </button>
                </div>
                <div class="job-card-footer">
                    <a class="btn-view" href="job_detail.php?id=1">View Details</a>
                </div>
            </div>

            <div class="job-card">
                <div class="job-card-top">
                    <div class="job-card-info">
                        <h3>UI/UX Designer</h3>
                        <div class="company">Creative Agency</div>
                        <div class="meta">
                            Design | Remote | Part-time<br>
                            Salary: 30,000 BDT | Deadline: 2026-06-15
                        </div>
                    </div>
                    <button class="heart-btn" id="heartBtn_2" onclick="toggleSaveJob(2)" style="color: #aaa;">
                        &#9825;
                    </button>
                </div>
                <div class="job-card-footer">
                    <a class="btn-view" href="job_detail.php?id=2">View Details</a>
                </div>
            </div>

        </div>

    </div>

    
</body>
</html>