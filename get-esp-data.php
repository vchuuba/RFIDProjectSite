<?php
    $servername = "localhost";
    // Your Database name
    $dbname = "esp_data";
    // Your Database user
    $username = "testUser";
    // Your Database user password
    $password = "Shell111";
    include_once('esp-database-card.php');

    $cardID = "";
    $id = "";
    if ($_SERVER["REQUEST_METHOD"] == "GET") {

            // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
            // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // $cardID = test_input($_GET["cardID"]);
        // if ($cardID == "19 6E 28 12") {
        //      $result = updateOutput($id, $cardID);
        //      echo $result;
        //     $board = test_input($_GET["board"]);
        //     $result = getAllOutputStates($id);

            $sql = "SELECT id, cardID FROM productList WHERE id=26";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
            $rows[$row["id"]] = $row["cardID"];
            }
            echo json_encode($rows);
        $conn->close();
    }
?>
