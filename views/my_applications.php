<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Applications</title>
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

        <h2>My Applications</h2>

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
                    <tr>
                        <td>Software Engineer</td>
                        <td>Tech Company Ltd.</td>
                        <td>15 May 2026</td>
                        <td><span class="badge badge-submitted">Submitted</span></td>
                    </tr>
                    <tr>
                        <td>UI/UX Designer</td>
                        <td>Creative Agency</td>
                        <td>10 May 2026</td>
                        <td><span class="badge badge-shortlisted">Shortlisted</span></td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>

</body>
</html>
