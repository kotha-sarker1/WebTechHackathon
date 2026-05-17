<?php
    require_once('../models/jobModel.php');
    session_start();

    $role    = $_SESSION["role"]    ?? "";
    $user_id = $_SESSION["user_id"] ?? "";
    $name    = $_SESSION["name"]    ?? "";

    if($role != "seeker"){
        header('location: login.php');
        exit();
    }

    $jobs       = getAllActiveJobs();
    $categories = getAllCategories();

    foreach($jobs as $key => $job){
        $jobs[$key]['is_saved'] = checkSavedJob($user_id, $job['id']) ? "yes" : "no";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Job Board</title>
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

        <h2>Job Board</h2>

        <div class="section-box">
            <div class="section-title">Search &amp; Filter</div>

            <div>
                <label>Search:&nbsp;</label>
                <input type="text" id="searchKeyword" placeholder="Search by title, company..." onkeyup="searchJobs()" style="width:280px;">
            </div>

            <div class="filter-row">
                <label>Category:</label>
                <select id="filterCategory" onchange="filterJobs()">
                    <option value="">All Categories</option>
                    <?php foreach($categories as $cat){ ?>
                        <option value="<?php echo $cat['id']; ?>"><?php echo $cat['name']; ?></option>
                    <?php } ?>
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
            <?php if(count($jobs) == 0){ ?>
                <p>No jobs found.</p>
            <?php }else{ ?>
                <?php foreach($jobs as $job){ ?>
                <div class="job-card">
                    <div class="job-card-top">
                        <div class="job-card-info">
                            <h3><?php echo htmlspecialchars($job['title']); ?></h3>
                            <div class="company"><?php echo htmlspecialchars($job['company_name']); ?></div>
                            <div class="meta">
                                <?php echo $job['category_name']; ?> &nbsp;|&nbsp;
                                <?php echo $job['location']; ?> &nbsp;|&nbsp;
                                <?php echo $job['job_type']; ?><br>
                                Salary: <?php echo $job['salary_range']; ?> &nbsp;|&nbsp; Deadline: <?php echo $job['deadline']; ?>
                            </div>
                        </div>
                        <button class="heart-btn"
                            id="heartBtn_<?php echo $job['id']; ?>"
                            onclick="toggleSaveJob(<?php echo $job['id']; ?>)"
                            style="color:<?php echo ($job['is_saved'] == 'yes') ? 'red' : '#aaa'; ?>;">
                            <?php echo ($job['is_saved'] == 'yes') ? '&#9829;' : '&#9825;'; ?>
                        </button>
                    </div>
                    <div class="job-card-footer">
                        <a class="btn-view" href="job_detail.php?id=<?php echo $job['id']; ?>">View Details</a>
                    </div>
                </div>
                <?php } ?>
            <?php } ?>
        </div>

    </div>

    <script src="../config/script.js"></script>
</body>
</html>
