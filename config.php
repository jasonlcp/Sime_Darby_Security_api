<?php
header("Access-Control-Allow-Origin: *");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "simedarby";

$conn = mysqli_connect($servername, $username , $password, $dbname);

if (mysqli_connect_errno()) {
echo "error";
} 

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$conn->set_charset("utf8mb4");

?>