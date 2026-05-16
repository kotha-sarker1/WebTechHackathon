<?php

include "../Model/DatabaseConnection.php";

$id = $_GET["id"];

$db = new DatabaseConnection();

$connection = $db->openConnection();

$result = $db->deleteJob($connection, "jobs", $id);

if($result){

    Header("Location: ../View/employerDashboard.php");

}

?>