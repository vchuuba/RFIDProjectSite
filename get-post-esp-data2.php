<?php
    $servername = "localhost";
    // Your Database name
    $dbname = "RFID";
    // Your Database user
    $username = "testUser";
    // Your Database user password
    $password = "Shell111";

$raw = file_get_contents('php://input');$data = json_decode($raw, true);
    
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if (test_input($data["keyword"]) == "MFRC522AUT")
        { // client authentication
            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);
            // Check connection
            if ($conn->connect_error)
            {
                die("Connection failed: " . $conn->connect_error);
            }
            $sql = "SELECT tag FROM clientID WHERE tag = '" . test_input($data["cardID"]) . "'";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc())
            {
                $card = $row["tag"];
            }
            if (test_input($data["cardID"]) == $card)
            {
                echo "Authenticated";
            }
            else
            {
                echo "Not authenticated";
            }
            $conn->close();
        }

        else if (test_input($data["keyword"]) == "MFRC522INF")
        { // client authentication
            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);
            // Check connection
            if ($conn->connect_error)
            {
                die("Connection failed: " . $conn->connect_error);
            }
            $sql = "SELECT tag FROM clientID WHERE tag = '" . test_input($data["cardID"]) . "'";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc())
            {
                $card = $row["tag"];
            }
            if (test_input($data["cardID"]) == $card)
            {
                echo "Authenticated";
            }
            else
            {
                echo "Not authenticated";
            }
            $conn->close();
        }

        else if (test_input($data["keyword"]) == "MFRC522REG")
        { // client registration
            $conn = new mysqli($servername, $username, $password, $dbname);
            // Check connection
            if ($conn->connect_error)
            {
                die("Connection failed: " . $conn->connect_error);
            }
            $sql = "SELECT tag FROM clientID WHERE tag = '" . test_input($data["cardID"]) . "'";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc())
            {
                $card = $row["tag"];
            }
            if (test_input($data["cardID"]) == $card)
            {
                echo "Already registered";
            }
            else
            {
                $sql = "SELECT username FROM clientID WHERE username = '" . test_input($data["username"]) . "'";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc())
                {
                    $username = $row["username"];
                }
                if (test_input($data["username"]) == $username)
                {
                    echo "!Duplicate!";
                }
                else
                {
                    $sql = "INSERT INTO clientID (tag, username) VALUES ('" . test_input($data["cardID"]) . "', '" . test_input($data["username"]) . "')";
                    $conn->query($sql);
                    echo "Registered";
                }
            }
            $conn->close();
        }

        else if (test_input($data["keyword"]) == "MFRC522SEL")
        { // item on taking
            $conn = new mysqli($servername, $username, $password, $dbname);
            // Check connection
            if ($conn->connect_error)
            {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT client, itemStatus FROM productList WHERE id = '" . test_input($data["Locker"]) . "'";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc())
            {
                $client = $row["client"];
                $status = $row["itemStatus"];
            }
            $sql = "SELECT username FROM clientID WHERE tag = '" . test_input($data["cardID"]) . "'";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc())
            {
                $username = $row["username"];
            }

            if($status == "Available")
            {
                $sql = "update productList set itemStatus = 'Taken', client = '" . $username . "' WHERE id = '" . test_input($data["Locker"]) . "'";
                $conn->query($sql);
                echo "Obtained";
            }
            else if($status == "Taken")
            {
                if($client == $username)
                {
                    $sql = "update productList set itemStatus = 'Available', client = 'None' WHERE id = '" . test_input($data["Locker"]) . "'";
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
                    $sql = "update productList set itemStatus = 'Taken', client = '" . $username . "' WHERE id = '" . test_input($data["Locker"]) . "'";
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

        else if (test_input($data["keyword"]) == "PN532DET")
        { // item detection
            $conn = new mysqli($servername, $username, $password, $dbname);
            // Check connection
            if ($conn->connect_error)
            {
                die("Connection failed: " . $conn->connect_error);
            }
            $sql = "SELECT id, cardID FROM productList WHERE id = '" . test_input($data["Locker"]) . "'";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc())
            {
                $tag = $row["cardID"];
            }
            if (test_input($data["cardID"]) == $tag)
            {
                echo "Detected";
            }
            else
            {
                echo "Not detected";
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