<?php
$servername = "localhost";
$dbname = "RFID";
$username = "testUser";
$password = "Shell111";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT id, tag, username FROM clientID ORDER BY id ASC";

if ($result = $conn->query($sql)) {
    while ($row = $result->fetch_assoc()) {
        $row_id = $row["id"];
        $row_tag = $row["tag"];
        $row_username = $row["username"];
    }
    $result->free();
}

$conn->close();
?>