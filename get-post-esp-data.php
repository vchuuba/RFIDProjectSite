<?php
    $servername = "localhost";
    // Your Database name
    $dbname = "RFID";
    // Your Database user
    $username = "testUser";
    // Your Database user password
    $password = "Shell111";

    // $keyword = $cardID = $id = "";

    //read body
    $raw = file_get_contents('php://input');
    $data = json_decode($raw, true);

        // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
    if ($conn->connect_error) {die("Connection failed: " . $conn->connect_error);}

    if ($_SERVER["REQUEST_METHOD"] == "GET") { // return data to esp32
        if($data["keyword"] == "MFRC522GET") { // mfrc522 get
            $sql = "SELECT id, tag FROM clientID WHERE id=1";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                $rows[$row["id"]] = $row["tag"];
            }
            echo json_encode($rows);
            $conn->close();
        } else if ($data["keyword"] == "PN532GET") { // pn532 get
            $sql = "SELECT id, cardID FROM productList WHERE id=6";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                $rows[$row["id"]] = $row["cardID"];
            }
            echo json_encode($rows);
            $conn->close();
        } else {echo "Wrong Keyword provided.";} // error
    } else {echo "No data gotten with HTTP GET.";}

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // insert $keyword = test_input($_POST["keyword"]) for url encoding
        if($keyword == "tPmAT5Ab3j7F9") { // test with url encoding
            $cardID = test_input($_POST["cardID"]);
            $sql = "update clientID set tag = '" . $cardID . "' where id = 26";
            if ($conn->query($sql) === TRUE) {
                echo "Record updated successfully";
            } else {echo "Error: " . $sql . "<br>" . $conn->error;}
            $conn->close();
        } else if ($data["keyword"] == "MFRC522POST") { // mfrc522 post with json encoding
            $sql = "update clientID set tag = '" . $data["cardID"] . "' where username = 'realtest'";
            if ($conn->query($sql) === TRUE) {
                echo "Record updated successfully";
            } else {echo "Error: " . $sql . "<br>" . $conn->error;} 
            $conn->close();
        } else if ($data["keyword"] == "PN532POST") { // pn532 post with json encoding
            $sql = "update productList set cardID = '" . $data["cardID"] . "' where productName = 'realtest'";
            if ($conn->query($sql) === TRUE) {
                echo "Record updated successfully";
            } else {echo "Error: " . $sql . "<br>" . $conn->error;} 
            $conn->close();
        } else {echo "Wrong Keyword provided.";} // error
    } else {echo "No data posted with HTTP POST.";}

    function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
    }
?>
