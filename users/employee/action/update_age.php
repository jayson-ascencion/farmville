<?php
// $start_time = microtime(true);

//database connection, located in the config directory
include('../../../config/database_connection.php');

// Update the age in the database
$query = "UPDATE chickenproduction SET age = age + 1";
$stmt = $conn->prepare($query);
$stmt->execute();

// $end_time = microtime(true);
// $elapsed_time = $end_time - $start_time;

// printf("Elapsed time: %f seconds", $elapsed_time);
?>