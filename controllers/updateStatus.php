<?php

require_once '../models/ApplicationModel.php';

if(isset($_POST['application_id']))
{
    $application_id = $_POST['application_id'];

    $status = $_POST['status'];

    $result = updateApplicationStatus($application_id, $status);

    if($result)
    {
        echo "success";
    }
    else
    {
        echo "failed";
    }
}

?>