<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// $hostname = 'mysql-127495-0.cloudclusters.net';
// $username = 'zz';
// $password = 'v89RrkVw';
// $database = 'vitals';
// $table = 'vital_signs2';
// $port = '14321';

$hostname = 'mysql-135911-0.cloudclusters.net';
$username = 'admin';
$password = 'zYCCq3G7';
$database = 'PatientVitalsDB';
$table = 'Vitals2';

// Create MySQL connection
$connection = mysqli_connect($hostname, $username, $password, $database,19993);

if (!$connection) {
  die('Failed to connect to MySQL: ' . mysqli_connect_error());
}

// Execute MySQL query
$query = "SELECT *
            FROM patients
            WHERE device_id IN (
            SELECT v.di
            FROM Vitals2 v
            JOIN (
            SELECT di, MAX(created_date) AS latest_date
            FROM Vitals2
            GROUP BY di
            ) subquery
            ON v.di = subquery.di AND v.created_date = subquery.latest_date
            )";
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
