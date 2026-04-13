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


        // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
    if ($conn->connect_error)
    {
        die("Connection failed: " . $conn->connect_error);
    }


    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // insert $keyword = test_input($_POST["keyword"]) for url encoding
        // if($keyword == "tPmAT5Ab3j7F9")
        // { // test with url encoding
        //     $cardID = test_input($_POST["cardID"]);
        //     $sql = "update clientID set tag = '" . $cardID . "' where id = 26";
        //     if ($conn->query($sql) === TRUE) 
        //     {
        //         echo "Record updated successfully";
        //     }
        //     else {echo "Error: " . $sql . "<br>" . $conn->error;}
        //     $conn->close();
        // }


        else if ($data["keyword"] == "MFRC522AUT")
        { // client authentication
            $sql = "SELECT cardID FROM clientID ORDER BY id DESC";
            $result = $conn->query($sql);
            $BOOL = false;
            if ($conn->query($result) === TRUE)
            {
                while ($row = $result->fetch_assoc())
                {
                    if ($data["cardID"] == $row["cardID"])
                    {
                        $BOOL = true;
                        break;
                    }
                }
                if (!$BOOL)
                {
                    echo json_encode($row);
                }
                else 
                {
                    echo json_encode($data["cardID"]);
                }
            }
            $result->free();
            $conn->close();
        }


        else if ($data["keyword"] == "MFRC522REG")
        { // client registration
            $sql = "SELECT cardID FROM clientID ORDER BY id DESC";
            $result = $conn->query($sql);
            $BOOL = false;
            if ($conn->query($result) === TRUE)
            {
                while ($row = $result->fetch_assoc())
                {
                    if ($data["cardID"] == $row["cardID"])
                    {
                        $BOOL = true;
                        break;
                    }
                }
                if (!$BOOL)
                {
                    $sql = "INSERT INTO clientID (cardID) VALUES ('" . $data["cardID"] . "')";
                    if ($conn->query($sql) === TRUE)
                    {
                        echo json_encode($row);
                    }
                }
                else 
                {
                    echo json_encode($data["cardID"]);
                }
            }
            $result->free();
            $conn->close();
        }


        else if ($data["keyword"] == "PN532DET")
        { // item detection
            $sql = "SELECT cardID FROM productList ORDER BY id DESC";
            $result = $conn->query($sql);
            $BOOL = false;
            if ($conn->query($result) === TRUE)
            {
                while ($row = $result->fetch_assoc())
                {
                    if ($data["cardID"] == $row["cardID"])
                    {
                        $BOOL = true;
                        break;
                    }
                }
                if (!$BOOL)
                {
                    echo json_encode($row);
                }
                else 
                {
                    echo json_encode($data["cardID"]);
                }
            }
            $result->free();
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
