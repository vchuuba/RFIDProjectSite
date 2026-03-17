<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dawson Sports Equipment Renting Portal</title>
    <link href="style.css" rel="stylesheet" type="text/css" media="all">
    <script>
    </script>
  </head>
  <body>
    <p><?= var_dump($_SERVER) ?></p>
    
    <?php
    $servername = "localhost"; //your servername
    $username = "testUser";  //your mysql username
    $password = "Shell111";  
    $dbname = "RFID"; 
    //match the setting into your setting

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $rfid_tag = $_POST['rfid_tag'];

        $sql = "INSERT INTO productList (cardID) VALUES ('$rfid_tag')";

        if ($conn->query($sql) === TRUE) {
            echo "Card recorded successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }


    $conn->close();
    ?>
  </body>
</html>

<!-- <?php

// if(isset($_GET["temperature"])) {
//    $temperature = $_GET["temperature"]; // get temperature value from HTTP GET

//    $servername = "localhost";
//    $username = "ESP32";
//    $password = "esp32io.com";
//    $database_name = "db_esp32";

//    // Create MySQL connection fom PHP to MySQL server
//    $connection = new mysqli($servername, $username, $password, $database_name);
//    // Check connection
//    if ($connection->connect_error) {
//       die("MySQL connection failed: " . $connection->connect_error);
//    }

//    $sql = "INSERT INTO tbl_temp (temp_value) VALUES ($temperature)";

//    if ($connection->query($sql) === TRUE) {
//       echo "New record created successfully";
//    } else {
//       echo "Error: " . $sql . " => " . $connection->error;
//    }

//    $connection->close();
// } else {
//    echo "temperature is not set in the HTTP request";
// }
?> -->