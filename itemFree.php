<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>item select page</title>
    </head>
    <body>
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
                $sql = "SELECT productName, client FROM productList WHERE productName = '" . test_input($_POST["choice"]) . "'";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc())
                {
                    $username = $row["client"];
                }
                if (test_input($_POST["username"]) == $username)
                {
                    $sql = "update productList set itemStatus = 'Available', client = 'None' WHERE productName = '" . test_input($_POST["choice"]) . "'";
                    $result = $conn->query($sql);
                    echo mysqli_error($conn);
                    echo '<p>Item cancelled successfully.</p>';
                }
                else
                {
                    echo '<p>Not permitted.</p>';
                }
                $conn->close();
            }
            else
            {
                echo '<p>No data posted with HTTP POST.</p>';
            }
            
            function test_input($data)
            {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                $data = strtolower($data);
                if ($data == "")
                {
                    return "!";
                }
                return $data;
            }
        ?>
        <br>
        <p><a href="index.html">Go back.</a> &lt;- Go back</p>
    </body>
</html>