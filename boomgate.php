
<?php
header("Access-Control-Allow-Origin: *");

$servername = "localhost";
$username = "admin";
$password = "admin1288";
$dbname = "IVMS";

$action=$_GET['action'];

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

if($action=="in"){
$message = hex2bin("11050005FF009EAB");
$messge2 = hex2bin("110500050000DF5B");
}else if($action=="out"){
$message = hex2bin("11050006FF006EAB");
$messge2 = hex2bin("1105000600002F5B");

}




echo "Message To server :".bin2hex($message)."\n";
// create socket
$socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
// connect to server
$result = socket_connect($socket, $host, $port) or die("Could not connect to server\n");  
// send string to server
socket_write($socket, $message, strlen($message)) or die("Could not send data to server\n");
socket_close($socket);
//add delay
//sleep(1)
$socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
// connect to server
$result = socket_connect($socket, $host, $port) or die("Could not connect to server\n");  
//$result = socket_read ($socket, 2, PHP_NORMAL_READ) or die("Could not read server response\n");
socket_write($socket, $messge2, strlen($messge2)) or die("Could not send data to server\n");
// close socket
socket_close($socket);

echo true;
?>