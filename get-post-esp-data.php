<?php
    $servername = "localhost";
    // Your Database name
    $dbname = "esp_data";
    // Your Database user
    $username = "testUser";
    // Your Database user password
    $password = "Shell111";

    // Keep this API Key value to be compatible with the ESP32 code provided in the project page. 
    // If you change this value, the ESP32 sketch needs to match
    $api_key_value = "tPmAT5Ab3j7F9";

    $api_key = "";
    $cardID = "";
    $id = "";

    if ($_SERVER["REQUEST_METHOD"] == "GET") {

            // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
            // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT id, cardID FROM productList WHERE id=26";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
        $rows[$row["id"]] = $row["cardID"];
        }
        echo json_encode($rows);
        $conn->close();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $api_key = test_input($_POST["api_key"]);

        if($api_key == $api_key_value) {

            $cardID = test_input($_POST["cardID"]);
            
            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            } 
            
            $sql = "update productList set cardID = '" . $cardID . "' where id = 26";
            
            if ($conn->query($sql) === TRUE) {
                echo "Record updated successfully";
            } else {echo "Error: " . $sql . "<br>" . $conn->error;}
        
            $conn->close();

        } else {echo "Wrong API Key provided.";}

    } else {echo "No data posted with HTTP POST.";}

    function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
    }
?>
