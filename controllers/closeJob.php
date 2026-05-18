<?php

require_once '../models/AdminModel.php';

if(isset($_GET['id']))
{
    $job_id = $_GET['id'];

    closeJob($job_id);

    header("Location: ../views/adminPanel.php");
}

?>