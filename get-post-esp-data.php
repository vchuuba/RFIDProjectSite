<?php
    $servername = "localhost";
    // Your Database name
    $dbname = "RFID";
    // Your Database user
    $username = "testUser";
    // Your Database user password
    $password = "Shell111";

    $keyword = $cardID = $id = "";

    //read body
    $raw = file_get_contents('php://input');
    $data = json_decode($raw, true);

        // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
    if ($conn->connect_error) {die("Connection failed: " . $conn->connect_error);}

    if ($_SERVER["REQUEST_METHOD"] == "GET") { // return data to esp32
        $sql = "SELECT id, cardID FROM productList WHERE id=26";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            $rows[$row["id"]] = $row["cardID"];
        }
        echo json_encode($rows);
        $conn->close();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $keyword = test_input($_POST["keyword"]);
        if($keyword == "tPmAT5Ab3j7F9") { // test
            $cardID = test_input($_POST["cardID"]);
            $sql = "update productList set cardID = '" . $cardID . "' where id = 26";
            if ($conn->query($sql) === TRUE) {
                echo "Record updated successfully";
            } else {echo "Error: " . $sql . "<br>" . $conn->error;}
            $conn->close();
        } else if ($keyword == "MFRC522POST") { // mfrc522 post
            $cardID = test_input($_POST["cardID"]);
            $sql = "update clientID set tag = '" . $data["cardID"] . "' where username = realtest";
            if ($conn->query($sql) === TRUE) {
                echo "Record updated successfully";
            } else {echo "Error: " . $sql . "<br>" . $conn->error;}
            $conn->close();
        } else {echo "Wrong Keyword provided.";}
    } else {echo "No data posted with HTTP POST.";}

    function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
    }
?>
