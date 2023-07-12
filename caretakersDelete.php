<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// $hostname = 'mysql-127495-0.cloudclusters.net';
// $username = 'zz';
// $password = 'v89RrkVw';
// $database = 'vitals';
// $table = 'vital_signs2';
// $port = '14321';

$hostname = 'mysql-134227-0.cloudclusters.net';
$username = 'admin';
$password = '4kXSHsZC';
$database = 'vitalsDB';
$table = 'vitals2';

// Create MySQL connection
$mysqli = new mysqli($hostname, $username, $password, $database,16063);

if ($mysqli->connect_errno) {
  die("Failed to connect to MySQL: " . $mysqli->connect_error);
}

$caretaker_id = $_POST['caretaker_id'];

// Execute MySQL query
$query = "DELETE FROM caretakers WHERE caretaker_id = ?";

// Create a prepared statement
$stmt = $mysqli->prepare($query);

// Bind the caretaker_id parameter
$stmt->bind_param("i", $caretaker_id);

// Execute the statement
if ($stmt->execute()) {
  // Deletion successful
  echo "Record deleted successfully.";
} else {
  // Deletion failed
  echo "Error: " . $stmt->error;
}

// Close the statement and database connection
$stmt->close();

$mysqli->close();
?>
