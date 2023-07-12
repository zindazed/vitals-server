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
$connection = mysqli_connect($hostname, $username, $password, $database,16063);

if (!$connection) {
  die('Failed to connect to MySQL: ' . mysqli_connect_error());
}

$patient_id = $_POST['patient_id'];

// Execute MySQL query
$query = "SELECT * FROM `patients` WHERE patient_id = $patient_id";
$result = mysqli_query($connection, $query);

if (!$result) {
  die('Failed to retrieve data from MySQL: ' . mysqli_error($connection));
}

// Fetch data and encode as JSON
$data = [];
while ($row = mysqli_fetch_assoc($result)) {
  $data[] = $row;
}
$json = json_encode($data);

// Close MySQL connection
mysqli_close($connection);

// Output JSON response
echo $json;
?>
