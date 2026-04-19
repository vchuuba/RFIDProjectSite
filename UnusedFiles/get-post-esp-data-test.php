<?php
    $servername = "localhost";
    // Your Database name
    $dbname = "esp_data";
    // Your Database user
    $username = "testUser";
    // Your Database user password
    $password = "Shell111";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $action = $id = $name = $gpio = $state = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $action = test_input($_POST["action"]);
        if ($action == "output_create") {
            $name = test_input($_POST["name"]);
            $board = test_input($_POST["board"]);
            $gpio = test_input($_POST["gpio"]);
            $state = test_input($_POST["state"]);

    function createOutput($name, $board, $gpio, $state) {
        global $servername, $username, $password, $dbname;

        $sql = "INSERT INTO Outputs (name, board, gpio, state)
        VALUES ('" . $name . "', '" . $board . "', '" . $gpio . "', '" . $state . "')";

       if ($conn->query($sql) === TRUE) {
            return "New output created successfully";
        }
        else {
            return "Error: " . $sql . "<br>" . $conn->error;
        }
        $conn->close();
    }

    function getBoard($board) {
        global $servername, $username, $password, $dbname;

        $sql = "SELECT board, last_request FROM Boards WHERE board='" . $board . "'";
        if ($result = $conn->query($sql)) {
            return $result;
        }
        else {
            return false;
        }
        $conn->close();
    }

    function createBoard($board) {
        global $servername, $username, $password, $dbname;

        $sql = "INSERT INTO Boards (board) VALUES ('" . $board . "')";

       if ($conn->query($sql) === TRUE) {
            return "New board created successfully";
        }
        else {
            return "Error: " . $sql . "<br>" . $conn->error;
        }
        $conn->close();
    }

            $result = createOutput($name, $board, $gpio, $state);

            $result2 = getBoard($board);
            if(!$result2->fetch_assoc()) {
                createBoard($board);
            }
            echo $result;
        }
        else {
            echo "No data posted with HTTP POST.";
        }
    }

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>