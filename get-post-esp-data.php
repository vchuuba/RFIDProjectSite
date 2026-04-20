<?php
    $servername = "localhost";
    // Your Database name
    $dbname = "RFID";
    // Your Database user
    $username = "testUser";
    // Your Database user password
    $password = "Shell111";
    
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
    if ($conn->connect_error)
    {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if (test_input($_POST["keyword"]) == "MFRC522AUT")
        { // client authentication
            $sql = "SELECT id, cardID FROM clientID WHERE cardID = '" . test_input($_POST["cardID"]) . "'";
            if ($conn->query($sql) === TRUE)
            {
                echo "Authenticated";
            }
            else 
            {
                echo "Not authenticated";
            }
            $conn->close();
        }


        else if (test_input($_POST["keyword"]) == "MFRC522REG")
        { // client registration
            $sql = "SELECT id, cardID FROM clientID WHERE cardID = '" . test_input($_POST["cardID"]) . "'";
            if ($conn->query($sql) === TRUE)
            {
                $sql = "INSERT INTO clientID (cardID) VALUES ('" . test_input($_POST["cardID"]) . "')";
                if ($conn->query($sql) === TRUE)
                {
                    echo "Registered";
                }
                else 
                {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
            else 
            {
                echo "Not registered";
            }
            $conn->close();
        }


        // else if (test_input($_POST["keyword"]) == "PN532DET")
        // { // item detection
        //     $sql = "SELECT id, cardID FROM productList WHERE cardID = '" . test_input($_POST["cardID"]) . "'";
        //     $result = $conn->query($sql);
        //     if ($conn->query($result) === TRUE)
        //     {
        //         while ($row = $result->fetch_assoc()) {
        //             $rows[$row["id"]] = $row["cardID"];
        //         }
        //         if (test_input($_POST["cardID"]) == $row["cardID"])
        //         {
        //             echo "Detected";
        //         }
        //         else 
        //         {
        //             echo "Not detected";
        //         }
        //     }
        //     $conn->close();
        // }


        // else if (test_input($_POST["keyword"]) == "PN532SEL")
        // { // client registration
        //     $sql = "update productList set cardID = '" . test_input($_POST["cardID"]) . "' where productName = 'realtest'";
        //     if ($conn->query($sql) === TRUE)
        //     {
        //         echo "Record updated successfully";
        //     }
        //     else {echo "Error: " . $sql . "<br>" . $conn->error;} 
        //     $conn->close();
        // }

        else
        {
            echo "Wrong keyword provided.";
        } // error
    }
    else
    {
        echo "No data posted with HTTP POST.";
    }
    
    echo "test3";

    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>
