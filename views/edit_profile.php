<?php
include "../models/DatabaseConnection.php";
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$db   = new DatabaseConnection();
$conn = $db->openConnection();

$id   = $_SESSION['user_id'];
$role = $_SESSION['role'];

$profileData = $db->getProfileData($conn, $id, $role);

$err = $_SESSION['err'] ?? "";
unset($_SESSION['err']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile - Job Portal</title>
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body>

<div class="container">

    <h2>Edit Profile</h2>

    <?php if (!empty($err)): ?>
        <p class="error-msg"><?php echo $err; ?></p>
    <?php endif; ?>

    <form method="post" action="../controllers/ProfileController.php" enctype="multipart/form-data">

        <h3>Update File</h3>

        <div>
            <label>Upload New Logo / Resume</label>
            <input type="file" name="fileupload" accept=".jpg,.png,.pdf">
            <small>Max file size: 2 MB. Allowed: JPG, PNG, PDF</small>
        </div>

        <hr>

        <h3>Profile Information</h3>

        <?php if ($role == "employer"): ?>

            <div>
                <label>Company Name</label>
                <input type="text" name="company" value="<?php echo htmlspecialchars($profileData['company_name'] ?? ''); ?>">
            </div>

            <div>
                <label>Industry</label>
                <select name="industry">
                    <option value="">-- Select Industry --</option>
                    <?php
                    $industries = ["Technology", "Finance", "Healthcare", "Education", "Retail", "Manufacturing", "Media", "Other"];
                    foreach ($industries as $ind) {
                        $selected = (isset($profileData['industry']) && $profileData['industry'] == $ind) ? 'selected' : '';
                        echo "<option value=\"$ind\" $selected>$ind</option>";
                    }
                    ?>
                </select>
            </div>

            <div>
                <label>Description</label>
                <textarea name="description"><?php echo htmlspecialchars($profileData['description'] ?? ''); ?></textarea>
            </div>

            <div>
                <label>Website URL</label>
                <input type="url" name="website" value="<?php echo htmlspecialchars($profileData['website'] ?? ''); ?>">
            </div>

        <?php else: ?>

            <div>
                <label>Professional Headline</label>
                <input type="text" name="headline" value="<?php echo htmlspecialchars($profileData['headline'] ?? ''); ?>">
            </div>

            <div>
                <label>Skills (comma-separated)</label>
                <input type="text" name="skills" value="<?php echo htmlspecialchars($profileData['skills'] ?? ''); ?>">
            </div>

            <div>
                <label>Years of Experience</label>
                <input type="number" name="experience" min="0" value="<?php echo htmlspecialchars($profileData['years_experience'] ?? ''); ?>">
            </div>

        <?php endif; ?>

        <hr>

        <h3>Change Password</h3>

        <div>
            <label>Current Password</label>
            <input type="password" name="current_password" placeholder="Leave blank to keep same">
        </div>

        <div>
            <label>New Password (min 8 characters)</label>
            <input type="password" name="new_password">
        </div>

        <button type="submit" name="update_profile">Update Profile</button>

    </form>

    <p class="page-link">
        <a href="dashboard.php">Back to Dashboard</a>
    </p>

</div>

</body>
</html>