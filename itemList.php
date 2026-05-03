<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>item view page</title>
    </head>
    <body>
        <?php
            $servername = "localhost";
            $dbname = "RFID";
            $username = "testUser";
            $password = "Shell111";

            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            } 

            $sql = "SELECT id, cardID, productName, itemStatus FROM productList ORDER BY id ASC";

            echo '<table cellspacing="5" cellpadding="5">
                <tr> 
                    <td>Locker #</td> 
                    <td>Card ID</td>
                    <td>Product Name</td>
                    <td>Status</td>
                </tr>';
            
            if ($result = $conn->query($sql)) {
                while ($row = $result->fetch_assoc()) {
                    $row_id = $row["id"];
                    $row_cardID = $row["cardID"];
                    $row_productName = $row["productName"];
                    $row_status = $row["itemStatus"];

                    echo '<tr> 
                            <td>' . $row_id . '</td> 
                            <td>' . $row_cardID . '</td> 
                            <td>' . $row_productName . '</td> 
                            <td>' . $row_status . '</td> 
                        </tr>';
                }   
                $result->free();
            }
            echo '</table>';
            $conn->close();
        ?>

        <br>
        <p><a href="index.html">Go back.</a> &lt;- Go back</p>
    </body>
</html>
