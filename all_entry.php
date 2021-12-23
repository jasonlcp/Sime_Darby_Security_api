<?php 
include 'config.php';

$sql =  "SELECT * FROM visitors_track_entry";
$result = $conn->query($sql);


while ($row = mysqli_fetch_assoc($result)) 
{   
    $respone[]=$row;
}
$json_data = array(
    "data"            => $respone   // total data array
  );
echo json_encode($json_data);
$conn->close();
?>