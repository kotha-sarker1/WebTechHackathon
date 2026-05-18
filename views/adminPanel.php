<?php

require_once '../models/AdminPanelModel.php';

$categoryFilter = '';
$statusFilter = '';

if(isset($_GET['category']))
{
    $categoryFilter = $_GET['category'];
}

if(isset($_GET['status']))
{
    $statusFilter = $_GET['status'];
}

$jobs = getAllJobsAdmin($categoryFilter, $statusFilter);

$totalJobs = getTotalJobs();

$totalApplications = getTotalApplications();

$categoryData = getApplicationsPerCategory();

?>

<!DOCTYPE html>
<html>

<head>

    <title>Admin Panel</title>

    <style>

        body
        {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 30px;
        }

        h2
        {
            color: #333;
        }

        h3
        {
            color: #333;
        }

        table
        {
            border-collapse: collapse;
            width: 80%;
            background-color: white;
            margin-top: 20px;
        }

        th
        {
            background-color: #007bff;
            color: white;
        }

        th,
        td
        {
            border: 1px solid #ccc;
            padding: 12px;
            text-align: center;
        }

        .summary-box
        {
            width: 80%;
            background-color: white;
            padding: 20px;
            border: 1px solid #ccc;
            margin-bottom: 20px;
        }

        .btn
        {
            background-color: red;
            color: white;
            padding: 8px 12px;
            text-decoration: none;
            border-radius: 4px;
        }

        .filter-box
        {
            margin-bottom: 20px;
        }

        select
        {
            padding: 8px;
            width: 200px;
        }

        button
        {
            padding: 8px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

    </style>

</head>

<body>

    <h2>Admin Panel</h2>

    <div class="filter-box">

        <form method="GET">

            <select name="category">

                <option value=""
                    <?php if($categoryFilter == '') echo 'selected'; ?>>
                    All Categories
                </option>

                <option value="Web Development"
                    <?php if($categoryFilter == 'Web Development') echo 'selected'; ?>>
                    Web Development
                </option>

                <option value="Frontend Development"
                    <?php if($categoryFilter == 'Frontend Development') echo 'selected'; ?>>
                    Frontend Development
                </option>

            </select>

            <select name="status">

                <option value=""
                    <?php if($statusFilter == '') echo 'selected'; ?>>
                    All Status
                </option>

                <option value="open"
                    <?php if($statusFilter == 'open') echo 'selected'; ?>>
                    Open
                </option>

                <option value="closed"
                    <?php if($statusFilter == 'closed') echo 'selected'; ?>>
                    Closed
                </option>

            </select>

            <button type="submit" name="filter">
                Filter
            </button>

        </form>

    </div>

    <div class="summary-box">

        <h3>Summary</h3>

        <p>
            Total Jobs:
            <?php echo $totalJobs; ?>
        </p>

        <p>
            Total Applications:
            <?php echo $totalApplications; ?>
        </p>

    </div>

    <table>

        <tr>

            <th>Job Title</th>
            <th>Category</th>
            <th>Status</th>
            <th>Action</th>

        </tr>

        <?php while($row = mysqli_fetch_assoc($jobs)) { ?>

            <tr>

                <td>
                    <?php echo $row['title']; ?>
                </td>

                <td>
                    <?php echo $row['category']; ?>
                </td>

                <td>
                    <?php echo $row['status']; ?>
                </td>

                <td>

                    <a class="btn"
                    href="../controllers/closeJob.php?id=<?php echo $row['id']; ?>">

                        Close Job

                    </a>

                </td>

            </tr>

        <?php } ?>

    </table>

    <h3>Applications Per Category</h3>

    <table>

        <tr>

            <th>Category</th>
            <th>Total Applications</th>

        </tr>

        <?php while($category = mysqli_fetch_assoc($categoryData)) { ?>

            <tr>

                <td>
                    <?php echo $category['category']; ?>
                </td>

                <td>
                    <?php echo $category['total']; ?>
                </td>

            </tr>

        <?php } ?>

    </table>

</body>
</html>