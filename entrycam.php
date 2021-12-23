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


$query= $conn->query("select * from config where config_type = 'entry'");

if ($query->num_rows > 0  ) 
{
    while($row = $query->fetch_assoc()) 
    {
        $data =  $row["ip_address"];
    }

}

$query= $conn->query("select * from config where config_type = 'relay'");

if ($query->num_rows > 0  ) 
{
    while($row = $query->fetch_assoc()) 
    {
        $dataip =  $row["ip_address"];
    }

}
$host    = $data ;

$curl = curl_init();
header("Content-Type: image/jpg");
header("Access-Control-Allow-Origin: *");


curl_setopt_array($curl, array(
  CURLOPT_URL => "http://".$data."/ISAPI/Streaming/channels/101/picture",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "authorization: Basic YWRtaW46UGFzc3dvcmQ=",
    "cache-control: no-cache",
  ),
));

$time = date('H:i:s',strtotime("7 PM"));
$time1 = date('H:i:s',strtotime("12 AM"));
$time2 = date('H:i:s',strtotime("6 AM"));
if($time < date('H:i:s') || ($time1 <= date('H:i:s') && date('H:i:s') <=$time2)){
  $iphost = $dataip;
  $port    = 28899;
  $message = hex2bin("11050003FF007EAA");
  $socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
  $result = socket_connect($socket, $iphost, $port) or die("Could not connect to server\n");  
  socket_write($socket, $message, strlen($message)) or die("Could not send data to server\n");
  socket_close($socket);
  sleep(1);
  $response = curl_exec($curl);
  $message = hex2bin("1105000300003F5A");
  $socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
  $result = socket_connect($socket, $iphost, $port) or die("Could not connect to server\n");  
  socket_write($socket, $message, strlen($message)) or die("Could not send data to server\n");
  socket_close($socket);

}else{
  $response = curl_exec($curl);
}
echo $response;



