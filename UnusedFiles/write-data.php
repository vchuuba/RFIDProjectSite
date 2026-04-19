<?php
$servername = "richardel.local";
$username = "testUser";
$password = "Shell111";
$dbname = "RFID";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$temp = $_GET['temperature'];
$hum = $_GET['humidity'];

$sql = "INSERT INTO sensor_data (temperature, humidity) VALUES ('$temp', '$hum')";

if ($conn->query($sql) === TRUE) {
  echo "Data Inserted Successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>