<?php
header("Access-Control-Allow-Origin: *");
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
$message = hex2bin("1102002000087A96");
//echo "Message To server :".bin2hex($message)."\n";
// create socket
$socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
// connect to server
$result = socket_connect($socket, $host, $port) or die("Could not connect to server\n");  
// send string to server
socket_write($socket, $message, strlen($message)) or die("Could not send data to server\n");
// get server response
$result = socket_read ($socket, 1024, PHP_BINARY_READ) or die("Could not read server response\n");
//echo "Reply From Server  :".bin2hex($result);
$result = bin2hex($result);
$detect = false;
if($result =="110201016488"){
    $detect = true;
 }
socket_close($socket);


if($detect == true){
  //light on
  $message = hex2bin("11050000FF008EAA");
  $socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
  $result = socket_connect($socket, $host, $port) or die("Could not connect to server\n");
  socket_write($socket, $message, strlen($message)) or die("Could not send data to server\n");
  socket_close($socket);
  //capture
//$output = system("ffmpeg -f video4linux2 -s 800x500 -i /dev/video0 -ss 0:0:1  -frames:v 1 /var/www/html/temp/temp.jpg -y");
//$output = system("ffmpeg -itsscale 0.01666 -f video4linux2 -s 1920x1080 -i /dev/video0 -ss 0:0:4 -preset ultrafast /var/www/html/temp/temp.jpg -y");
$output = system("ffmpeg -f video4linux2 -s 800x500 -i /dev/video0 -ss 0:0:1  -frames:v 1 /var/www/html/temp/temp2.jpg -y");
$output = system("ffmpeg -i /var/www/html/temp/temp2.jpg -i /var/www/html/temp/watermark.png -filter_complex 'overlay=(main_w-overlay_w)/2:(main_h-overlay_h)/2' /var/www/html/temp/temp.jpg");    
$image = file_get_contents('temp/temp.jpg');
  //light off
  $message = hex2bin("110500000000CF5A");
  $socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
  $result = socket_connect($socket, $host, $port) or die("Could not connect to server\n");
  socket_write($socket, $message, strlen($message)) or die("Could not send data to server\n");
  socket_close($socket);
  //getimage
  $image = file_get_contents('temp/temp.jpg');
  header("Content-Type: image/jpg");
  header("Content-Length: " . strlen($image));
  echo $image;
  unlink('/var/www/html/temp/temp.jpg');  
  unlink('/var/www/html/temp/temp2.jpg');
}else{
  echo json_encode(array('status' => $detect));
}

?>





