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

            $sql = "SELECT id, cardID, productName, itemStatus FROM productList ORDER BY id DESC";
            $result = $conn->query($sql);

            echo
            '
                <table cellspacing="5" cellpadding="5">
                    <tr> 
                        <td>Locker #</td> 
                        <td>Card ID</td>
                        <td>Product Name</td>
                        <td>Status</td>
                    </tr>
            ';
            
            while ($row = $result->fetch_assoc())
            {
                echo
                '
                    <tr>
                        <td>' . $row["id"] . '</td>
                        <td>' . $row["cardID"] . '</td>
                        <td>' . $row["productName"] . '</td>
                        <td>' . $row["itemStatus"] . '</td>
                    </tr>
                ';
            }
            echo '</table>';

            echo '<form method="POST" action="itemReserved.php">';
            echo '<p>Which do you prefer?</p>';
            while ($result->fetch_assoc())
            {
                echo
                '
                    <input type="radio" id="' . $row["productName"] . '" name="choice" value="' . $row["productName"] . '">
                    <label for="' . $row["productName"] . '">' . $row["productName"] . '</label><br>
                ';
            }
            echo
            '
                <p>What is your username?</p>
                    <label for="username">Username:</label><br>
                    <input type="text" id="username" name="username" title="Latin alphabet only." placeholder="Joesopher"><br>
                    <input type="submit" value="Submit">
                </form>
            ';
        ?>
        <br>
        <p><a href="index.html">Go back.</a> &lt;- Go back</p>
    </body>
</html>