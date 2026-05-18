<?php

require_once '../models/AdminPanelModel.php';

if(isset($_GET['id']))
{
    $job_id = $_GET['id'];

    closeJob($job_id);

    header("Location: ../views/adminPanel.php");
}

?>