<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Complete Your Profile - Job Portal</title>
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body>

<div class="container">

    <h2>Complete Your Profile</h2>
    <p>Please fill in the details below to get started.</p>

    <form method="post" action="../controllers/ProfileController.php">

        <?php if ($role == "employer"): ?>

            <div>
                <label>Company Name</label>
                <input type="text" name="company" >
            </div>

            <div>
                <label>Industry</label>
                <select name="industry" >
                    <option value="">-- Select Industry --</option>
                    <option value="Technology">Technology</option>
                    <option value="Finance">Finance</option>
                    <option value="Healthcare">Healthcare</option>
                    <option value="Education">Education</option>
                    <option value="Retail">Retail</option>
                    <option value="Manufacturing">Manufacturing</option>
                    <option value="Media">Media</option>
                    <option value="Other">Other</option>
                </select>
            </div>

            <div>
                <label>Description</label>
                <textarea name="description" rows="4" placeholder="Brief description of your company"></textarea>
            </div>

            <div>
                <label>Website URL</label>
                <input type="url" name="website" placeholder="https://brainstation-23.com/">
            </div>

        <?php else: ?>

            <div>
                <label>Professional Headline</label>
                <input type="text" name="headline" placeholder="e.g. Software Engineer" required>
            </div>

            <div>
                <label>Skills (comma-separated)</label>
                <textarea name="skills" placeholder="e.g. PHP, Java, Python"></textarea>
            </div>

            <div>
                <label>Years of Experience</label>
                <input type="number" name="experience" min="0" >
            </div>

        <?php endif; ?>

        <button type="submit" name="save_profile">Save Profile</button>

    </form>

</div>

</body>
</html>
