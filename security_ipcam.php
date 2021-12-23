<?php 
include 'config.php';
$area=$_POST['area'];
// $pass=$_POST['password'];
$sql =  "SELECT * FROM ivms_ipcamera where area_id=$area";
$result = $conn->query($sql);
$count = 0;

while ($row = mysqli_fetch_assoc($result)) 
{   
    $data[] = $row;
}



$json_data = array(
    "results"            => $data   // total data array
  );
echo json_encode($json_data);
$conn->close();

?>