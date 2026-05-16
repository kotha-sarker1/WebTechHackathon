<?php

include "../Model/DatabaseConnection.php";

$id = $_POST["id"];

$db = new DatabaseConnection();

$connection = $db->openConnection();

$newStatus = $db->toggleJobStatus($connection, $id);

echo $newStatus;

?>