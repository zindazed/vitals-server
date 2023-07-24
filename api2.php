<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
// Database connection configuration

$servername = "mysql-135911-0.cloudclusters.net";
$username = "admin";
$password = "zYCCq3G7";
$dbname = "PatientVitalsDB";
$table = 'Vitals2';

// Establish database connection
$conn = new mysqli($servername, $username, $password, $dbname,19993);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Signup API
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signup'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if username already exists
    $query = "SELECT * FROM users WHERE user_name = '$username'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        $response = array('success' => false, 'message' => 'Username already exists');
        echo json_encode($response);
        exit;
    }

    // Insert user data into the database
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $query = "INSERT INTO users (user_name, password) VALUES ('$username', '$hashedPassword')";
    if ($conn->query($query) === TRUE) {
              
        $query = "SELECT * FROM users WHERE user_name = '$username'";
        $result = mysqli_query($conn, $query);
        
        if (!$result) {
            die('Failed to retrieve data from MySQL: ' . mysqli_error($conn));
          }
        
          while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['user_id'];
          }

        $response = array('id' => $id, 'success' => true, 'message' => 'Signup successful');
        echo json_encode($response);
    } else {
        $response = array('success' => false, 'message' => 'Signup failed');
        echo json_encode($response);
    }
}

// Login API
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Retrieve user data from the database
    $query = "SELECT * FROM users WHERE user_name = '$username'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $id = $user['user_id'];
            $response = array('id' => $id,'success' => true, 'message' => 'Login successful');
            echo json_encode($response);
        } else {
            $response = array('success' => false, 'message' => 'Wrong password');
            echo json_encode($response);
        }
    } else {
        $response = array('success' => false, 'message' => 'User not found');
        echo json_encode($response);
    }
}



// Close the database connection
$conn->close();
?>
