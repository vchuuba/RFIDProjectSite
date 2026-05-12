<?php
    $servername = "localhost";
    // Your Database name
    $dbname = "RFID";
    // Your Database user
    $username = "testUser";
    // Your Database user password
    $password = "Shell111";

    $raw = file_get_contents('php://input');
    $data = json_decode($raw, true);

    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error)
    {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if (($data["keyword"]) == "MFRC522AUT")
        { // client authentication
            $sql = "SELECT tag FROM clientID WHERE tag = '" . ($data["cardID"]) . "'";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc())
            {
                $card = $row["tag"];
            }
            if (($data["cardID"]) == $card)
            {
                echo "Authenticated";
            // $data = [ "tag" => "Authenticated" ];
            // echo json_encode($data);
            }
            else
            {
                echo "Not authenticated";
            }
            $conn->close();
        }

        else if (($data["keyword"]) == "MFRC522REG")
        { // client registration
            $sql = "SELECT tag FROM clientID WHERE tag = '" . ($data["cardID"]) . "'";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc())
            {
                $card = $row["tag"];
            }
            if (($data["cardID"]) == $card)
            {
                echo "Already registered";
            }
            else
            {
                $sql = "SELECT username FROM clientID WHERE username = '" . ($data["username"]) . "'";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc())
                {
                    $username = $row["username"];
                }
                if (($data["username"]) == $username)
                {
                    echo "!Duplicate!";
                }
                else
                {
                    $sql = "INSERT INTO clientID (tag, username) VALUES ('" . ($data["cardID"]) . "', '" . ($data["username"]) . "')";
                    $conn->query($sql);
                    echo "Registered";
                }
            }
            $conn->close();
        }

        else if (($data["keyword"]) == "MFRC522SEL")
        { // item selection
            $sql = "SELECT client, itemStatus FROM productList WHERE id = '" . ($data["Locker"]) . "'";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc())
            {
                $client = $row["client"];
                $status = $row["itemStatus"];
            }
            $sql = "SELECT username FROM clientID WHERE tag = '" . ($data["cardID"]) . "'";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc())
            {
                $username = $row["username"];
            }

            if($status == "Available")
            {
                $sql = "update productList set itemStatus = 'Taken', lockStatus = 1, client = '" . $username . "' WHERE id = '" . ($data["Locker"]) . "'";
                $conn->query($sql);
                echo "Obtained";
            }
            else if($status == "Taken")
            {
                if($client == $username)
                {
                    $sql = "update productList set itemStatus = 'Available', lockStatus = 1, client = 'None' WHERE id = '" . ($data["Locker"]) . "'";
                    $conn->query($sql);
                    echo "Returned";
                }
                else
                {
                    echo "Unauthorized";
                }
            }
            else if ($status == "Reserved")
            {
                if ($client == $username)
                {
                    $sql = "update productList set itemStatus = 'Taken', client = '" . $username . "' WHERE id = '" . ($data["Locker"]) . "'";
                    $conn->query($sql);
                    echo "Obtained";
                }
                else
                {
                    echo "Unauthorized";
                }
            }
            else
            {
                echo "Error";
            }
            $conn->close();
        }

        else if (($data["keyword"]) == "MFRC522INF")
        { // item client association information
            $sql = "SELECT * FROM productList";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc())
            {
                $rows[$row["ID"]] = $row["client"];
            }
            echo json_encode($rows);
            $conn->close();
        }

        else if (($data["keyword"]) == "MFRC522STA")
        { // item position status check
            $sql = "SELECT * FROM productList";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc())
            {
                $rows[$row["ID"]] = $row["itemStatus"];
            }
            echo json_encode($rows);
            $conn->close();
        }

        else if (($data["keyword"]) == "PN532DET")
        { // item detection
            $sql = "SELECT id, cardID, itemStatus FROM productList WHERE id = '" . ($data["Locker"]) . "'";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc())
            {
                $id = $row["id"];
                $tag = $row["cardID"];
                $status = $row["itemStatus"];
            }
            if ($status == "Taken")
            {
                echo "In use";
            }
            else
            {
                if (($data["cardID"]) == $tag)
                {
                    echo "Detected";
                }
                else
                {
                    echo "Not detected";
                }
            }
            $conn->close();
        }

        else if (($data["keyword"]) == "PN532LOC")
        { // item lock status check
            $sql = "SELECT * FROM productList";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc())
            {
                $rows[$row["ID"]] = $row["lockStatus"];
            }
            echo json_encode($rows);
            
            for ($i = 1; $i <= 3; $i++)
            {
                $sql = "update productList set lockStatus = 0 WHERE id = '" . $i . "'";
                $conn->query($sql);
            }

            $conn->close();
        }

        else
        {
            echo "Wrong keyword provided.";
        }
    }
    else
    {
        echo "No data posted with HTTP POST.";
    }

    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>