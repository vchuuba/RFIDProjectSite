<?php
    $servername = "localhost";
    // Your Database name
    $dbname = "RFID";
    // Your Database user
    $username = "testUser";
    // Your Database user password
    $password = "Shell111";


    //read body
    $raw = file_get_contents('php://input');
    $data = json_decode($raw, true);
    $cardID = test_input($_POST["cardID"]);

    // empty vars
    $default = array("keyword" => "none", "cardID" => "none");
    $fail = ["keyword" => "none", "cardID" => "none"];

        // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
    if ($conn->connect_error)
    {
        die("Connection failed: " . $conn->connect_error);
    }


    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $action = test_input($_POST["keyword"]);
        if ($action == "MFRC522AUT")
        { // client authentication
            // $sql = "SELECT id, cardID FROM clientID WHERE cardID = '" . $cardID . "'";
            // $result = $conn->query($sql);
            // if ($conn->query($result) === TRUE)
            // {
            //     while ($row = $result->fetch_assoc()) {
            //         $rows[$row["id"]] = $row["cardID"];
            //     }
            //     if ($data["cardID"] == $row["cardID"])
            //     {
            //         echo json_encode($rows);
            //     }
            //     else 
            //     {
            //         echo json_encode($default);
            //     }
            // }
            echo json_encode($fail);
            $conn->close();
        }


        else if ($data["keyword"] == "MFRC522REG")
        { // client registration
            $sql = "SELECT id, cardID FROM clientID WHERE cardID = '" . $data["cardID"] . "'";
            $result = $conn->query($sql);
            if ($conn->query($result) === TRUE)
            {
                while ($row = $result->fetch_assoc()) {
                    $rows[$row["id"]] = $row["cardID"];
                }
                if ($data["cardID"] == $row["cardID"])
                {
                    $sql = "INSERT INTO clientID (cardID) VALUES ('" . $data["cardID"] . "')";
                    if ($conn->query($sql) === TRUE)
                    {
                        echo json_encode($rows);
                    }
                }
                else 
                {
                    echo json_encode($default);
                }
            }
            $conn->close();
        }


        else if ($data["keyword"] == "PN532DET")
        { // item detection
            $sql = "SELECT id, cardID FROM productList WHERE cardID = '" . $data["cardID"] . "'";
            $result = $conn->query($sql);
            if ($conn->query($result) === TRUE)
            {
                while ($row = $result->fetch_assoc()) {
                    $rows[$row["id"]] = $row["cardID"];
                }
                if ($data["cardID"] == $row["cardID"])
                {
                    echo json_encode($rows);
                }
                else 
                {
                    echo json_encode($default);
                }
            }
            $conn->close();
        }


        else if ($data["keyword"] == "PN532SEL")
        { // client registration
            $sql = "update productList set cardID = '" . $data["cardID"] . "' where productName = 'realtest'";
            if ($conn->query($sql) === TRUE)
            {
                echo "Record updated successfully";
            }
            else {echo "Error: " . $sql . "<br>" . $conn->error;} 
            $conn->close();
        }


        else
        {
            echo "Wrong Keyword provided.";
            // echo $data["keyword"];
        } // error
    }
    

    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>
