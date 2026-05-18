<?php

require_once '../models/JobModel.php';
require_once '../models/ApplicationModel.php';

$jobs = getAllJobs();

$statusData = getApplicationStatusCount();

$submitted = 0;
$reviewed = 0;
$rejected = 0;

while($statusRow = mysqli_fetch_assoc($statusData))
{
    if($statusRow['status'] == 'Submitted')
    {
        $submitted = $statusRow['total'];
    }

    else if($statusRow['status'] == 'Reviewed')
    {
        $reviewed = $statusRow['total'];
    }

    else if($statusRow['status'] == 'Rejected')
    {
        $rejected = $statusRow['total'];
    }
}

$applications = null;

$job_id = "";

if(isset($_GET['job_id']))
{
    $job_id = $_GET['job_id'];

    $applications = getApplicationsByJob($job_id);
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Employer Dashboard</title>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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

        button
        {
            background-color: #007bff;

            color: white;

            border: none;

            padding: 8px 15px;

            cursor: pointer;

            border-radius: 4px;
        }

        button:hover
        {
            background-color: #0056b3;
        }

        select
        {
            padding: 5px;
        }

        a
        {
            text-decoration: none;

            color: #007bff;
        }

        a:hover
        {
            text-decoration: underline;
        }

        .chart-box
        {
            width: 80%;

            background-color: white;

            padding: 20px;

            margin-top: 30px;

            border: 1px solid #ccc;
        }

        .headline
        {
            color: #666;

            font-size: 14px;

            margin-top: 5px;
        }

    </style>

</head>

<body>

    <h2>Employer Dashboard</h2>

    <form method="GET">

        <label>Select Job:</label>

        <select name="job_id">

            <?php while($job = mysqli_fetch_assoc($jobs)) { ?>

                <option value="<?php echo $job['id']; ?>">

                    <?php echo $job['title']; ?>

                </option>

            <?php } ?>

        </select>

        <button type="submit">
            Show Applications
        </button>

    </form>

    <br><br>

    <?php if(isset($_GET['job_id']) && $applications != null) { ?>

        <table>

            <tr>
                <th>Seeker Name</th>
                <th>Headline</th>
                <th>Cover Letter</th>
                <th>Resume</th>
                <th>Status</th>
            </tr>

            <?php while($row = mysqli_fetch_assoc($applications)) { ?>

                <tr>

                    <td>
                        <?php echo $row['name']; ?>
                    </td>

                    <td>

                        <div class="headline">

                            <?php echo $row['headline']; ?>

                        </div>

                    </td>

                    <td>
                        <?php echo $row['cover_letter']; ?>
                    </td>

                    <td>

                        <a href="../<?php echo $row['resume_path']; ?>"
                        target="_blank">

                            Download Resume

                        </a>

                    </td>

                    <td>

                        <form method="POST">

                            <input type="hidden"
                            name="application_id"
                            value="<?php echo $row['id']; ?>">

                            <input type="hidden"
                            name="job_id"
                            value="<?php echo $job_id; ?>">

                            <select name="status"
                            onchange="updateStatus(this)"
                            style="width: 140px; height: 35px;">

                                <option value="Submitted"
                                <?php if($row['status'] == 'Submitted') echo 'selected'; ?>>

                                    Submitted

                                </option>

                                <option value="Reviewed"
                                <?php if($row['status'] == 'Reviewed') echo 'selected'; ?>>

                                    Reviewed

                                </option>

                                <option value="Rejected"
                                <?php if($row['status'] == 'Rejected') echo 'selected'; ?>>

                                    Rejected

                                </option>

                            </select>

                        </form>

                    </td>

                </tr>

            <?php } ?>

        </table>

        <div class="chart-box">

            <h3>Application Status Report</h3>

            <canvas id="statusChart"></canvas>

        </div>

    <?php } ?>

<script>

function updateStatus(selectElement)
{
    let form = selectElement.parentElement;

    let formData = new FormData(form);

    fetch("../controllers/updateStatus.php",
    {
        method: "POST",
        body: formData
    })

    .then(response => response.text())

    .then(data =>
    {
        alert("Status Updated Successfully");
    });
}

<?php if(isset($_GET['job_id'])) { ?>

const ctx = document.getElementById('statusChart');

new Chart(ctx,
{
    type: 'bar',

    data:
    {
        labels: ['Submitted', 'Reviewed', 'Rejected'],

        datasets:
        [{
            label: 'Applications',

            data:
            [
                <?php echo $submitted; ?>,
                <?php echo $reviewed; ?>,
                <?php echo $rejected; ?>
            ],

            borderWidth: 1
        }]
    },

    options:
    {
        responsive: true,

        scales:
        {
            y:
            {
                beginAtZero: true
            }
        }
    }
});

<?php } ?>

</script>

</body>
</html>