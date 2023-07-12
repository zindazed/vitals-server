<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
// Database connection configuration
$servername = "mysql-134227-0.cloudclusters.net";
$username = "admin";
$password = "4kXSHsZC";
$dbname = "vitalsDB";

// Establish database connection
$conn = new mysqli($servername, $username, $password, $dbname,16063);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// attach device API
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['attach'])) {
    $dob = $_POST['dob'];
    $deviceId = $_POST['deviceId'];
    $deviceCode = $_POST['deviceCode'];
    $patientId = $_POST['patientId'];

    // Check if device exists
    $query = "SELECT * FROM devices WHERE device_id = '$deviceId'";
    $result = $conn->query($query);
    if ($result->num_rows == 0) {
        $response = array('success' => false, 'message' => 'Device does not exist');
        echo json_encode($response);
        exit;
    }

    // Check if device already used
    $query = "SELECT * FROM patients WHERE device_id = '$deviceId'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        $response = array('success' => false, 'message' => 'Device already used by another patient');
        echo json_encode($response);
        exit;
    }

    // Insert user data into the database
    $query = "INSERT INTO patients (dob, device_id, patient_id, secret_code) VALUES ('$dob', '$deviceId','$patientId', '$deviceCode')";
    if ($conn->query($query) === TRUE) {
              

        $response = array('success' => true, 'message' => 'Attached Device successfully');
        echo json_encode($response);
    } else {
        $response = array('success' => false, 'message' => 'Attaching device failed');
        echo json_encode($response);
    }
}

// monitor patient API
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['monitor'])) {
    $device_id = $_POST['deviceId'];
    $device_code = $_POST['deviceCode'];
    $caretaker_id = $_POST['caretaker_id'];

   // Retrieve the record with device_id = 1234
$query = "SELECT patient_id, secret_code FROM patients WHERE device_id = $device_id";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $patient_id = $row['patient_id'];
    $secret_code = $row['secret_code'];

    // Compare secret_code with device_code
    if ($secret_code == $device_code) {
        // Perform insert into caretakers table
        $insertQuery = "INSERT INTO caretakers (caretaker_id, patient_id) VALUES ($caretaker_id, $patient_id)";
        mysqli_query($conn, $insertQuery);

        $response = array('success' => true, 'message' => 'Added Patient successfully');
        echo json_encode($response);
    } else {
        $response = array('success' => false, 'message' => 'Secret codes do not match.');
        echo json_encode($response);
        exit;
    }
} else {
    $response = array('success' => false, 'message' => "Record not found for device_id = $device_id.");
        echo json_encode($response);
        exit;
}
}




// Close the database connection
$conn->close();
?>

