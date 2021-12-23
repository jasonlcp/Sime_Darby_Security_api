<?php

$servername = "localhost";
$username = "admin";
$password = "admin1288";
$dbname = "IVMS";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
} 


$query= $conn->query("select * from config where config_type = 'relay'");

if ($query->num_rows > 0  ) 
{
    while($row = $query->fetch_assoc()) 
    {
        $data =  $row["ip_address"];
    }

}

$host    = $data ;


$port    = 28899;
$message = hex2bin("110500000000CF5A");
echo "Message To server :".bin2hex($message)."\n";
// create socket
$socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
// connect to server
$result = socket_connect($socket, $host, $port) or die("Could not connect to server\n");  
// send string to server
socket_write($socket, $message, strlen($message)) or die("Could not send data to server\n");
// get server response
//$result = socket_read ($socket, 1024, PHP_NORMAL_READ) or die("Could not read server response\n");
echo "Reply From Server  :".$result;
// close socket
socket_close($socket);