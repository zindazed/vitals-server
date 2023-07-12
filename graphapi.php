<?php
// Database connection configuration

$hostname = 'mysql-134227-0.cloudclusters.net';
$username = 'admin';
$password = '4kXSHsZC';
$database = 'vitalsDB';

// Establish database connection
$connection = new mysqli($hostname, $username, $password, $database,16063);

if ($connection->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$device_id = $_POST['device_id'];

// Signup API
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['interval'] == 'seconds' ) {

    // Check if username already exists
    $query = "SELECT *
                FROM (
                SELECT *,
                ROW_NUMBER() OVER (PARTITION BY DATE_FORMAT(created_date, '%Y-%m-%d %H:%i:%s') ORDER BY created_date DESC) AS row_num
                FROM vitals2
                ) AS subquery
                WHERE row_num = 1 AND di = $device_id
                ORDER BY created_date DESC
                LIMIT 11";
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
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['interval'] == 'minutes' ) {

    // Check if username already exists
    $query = "SELECT *
            FROM (
            SELECT *,
            ROW_NUMBER() OVER (PARTITION BY DATE_FORMAT(created_date, '%Y-%m-%d %H:%i') ORDER BY created_date DESC) AS row_num
            FROM vitals2
            ) AS subquery
            WHERE row_num = 1 AND di = $device_id
            ORDER BY created_date DESC
            LIMIT 11";
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
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['interval'] == 'hours' ) {
    
    // Check if username already exists
    $query = "SELECT *
    FROM (
      SELECT *,
        ROW_NUMBER() OVER (PARTITION BY DATE_FORMAT(created_date, '%Y-%m-%d %H') ORDER BY created_date DESC) AS row_num
      FROM vitals2
    ) AS subquery
    WHERE row_num = 1 AND di = $device_id
    ORDER BY created_date DESC
    LIMIT 11";
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
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['interval'] == 'days' ) {

    // Check if username already exists
    $query = "SELECT *
    FROM (
      SELECT *,
        ROW_NUMBER() OVER (PARTITION BY DATE_FORMAT(created_date, '%Y-%m-%d') ORDER BY created_date DESC) AS row_num
      FROM vitals2
    ) AS subquery
    WHERE row_num = 1 AND di = $device_id
    ORDER BY created_date DESC
    LIMIT 11";
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
}

?>