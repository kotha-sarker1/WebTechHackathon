<?php

include "../models/DatabaseConnection.php";

$id = $_GET["id"];

$db = new DatabaseConnection();

$connection = $db->openConnection();

$result = $db->deleteJob($connection, "jobs", $id);

if($result){

    Header("Location: ../views/employerDashboard.php");

}

?>