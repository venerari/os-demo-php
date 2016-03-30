
<html>
 <head>
  <title>Red Hat OpenShift: Hello //build/ !</title>
  <style>
    table, th, td {
      border: 1px solid white;
      border-collapse: collapse;
    } 
    th, td {
      padding: 5px;
      text-align: left;
    }
    h1 {
        font-family: Arial,Verdana,sans-serif;
    }
    body {
        background-color: #0080a6;
        color: #fff;
        font-family: Arial,Verdana,sans-serif;
    }
    
  </style>
 </head>
 <body>   
 <h1>OpenShift: Hello //build/ !</h1>
 <img src="http://build.microsoft.com/img/logo-build-small.png" height="36" width="37" alt="Microsoft"> 
 <br>
 <p>Let's see CI in action!</p>
<?php
error_reporting(E_ERROR);

$host = getenv("MYSQL_SERVICE_HOST");
$port = getenv("MYSQL_SERVICE_PORT");
$database = getenv("MYSQL_SERVICE_DATABASE");
$username = getenv("MYSQL_SERVICE_USERNAME");
$password = getenv("MYSQL_SERVICE_PASSWORD");

$conn = mysqli_connect($host, $username, $password, $database, $port);
if ($conn) {
  echo "Database is available <br/>";
  $sql = "CREATE TABLE visitors (
          id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
          containerip VARCHAR(15) NOT NULL,
          visitstamp VARCHAR(30) NOT NULL)";
  if (mysqli_query($conn, $sql)) {
    echo "Table visitors created successfully <br/>";
  } else {
    echo mysqli_error($conn) . "<br/>";
  }

  $containerip = $_SERVER['SERVER_ADDR'];
  $visitstamp = date("D M j G:i:s T Y");
  $sql = "INSERT INTO visitors (containerip, visitstamp)
          VALUES ('$containerip', '$visitstamp')";

  if (mysqli_query($conn, $sql)) {
    echo "New record created successfully <br/>";
  } else {
    echo "Error: " . $sql . " - " . mysqli_error($conn) . "<br/>";
  }

  echo "<h3> Visitor Log </h3>";
  $sql = "SELECT id, containerip, visitstamp FROM visitors ORDER BY visitstamp DESC LIMIT 30";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0) {
    echo "<table><tr><th>Id</th><th>Container IP</th><th>Timestamp</th></tr>";
    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr><td>" . $row["id"] . "</td><td>" . $row["containerip"] . "</td><td>" . $row["visitstamp"] . "</td></tr>";
    }
    echo "</table>";
  } else {
    echo "0 results";
  }

  mysqli_close($conn);
} else {
  echo "Database is not available";
}
?>
<br>
<img src="http://build.microsoft.com/img/logo-ms.png" alt="Microsoft"> 
 </body>
</html>