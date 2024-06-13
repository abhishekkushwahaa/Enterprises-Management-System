<?php 
  $host = "localhost";
  $dbUsername = "root";
  $dbPassword = "Genius@1234";
  $dbname = "iitspath";
  $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

?>