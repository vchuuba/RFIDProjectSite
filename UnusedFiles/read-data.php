<?php
$servername = "richardel.local";
$username = "testUser";
$password = "Shell111";
$dbname = "RFID";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM sensor_data ORDER BY id DESC LIMIT 5";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    echo "Temp: " . $row["temperature"]. " °C | Humidity: " . $row["humidity"]. " % | Time: " . $row["reading_time"]. "<br>";
  }
} else {
  echo "No data found";
}
$conn->close();
?>