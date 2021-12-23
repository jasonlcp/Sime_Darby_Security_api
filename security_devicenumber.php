<?php 
include 'config.php';
$area=$_POST['area'];
// $pass=$_POST['password'];
$sql =  "SELECT * FROM security_guards_devicenumber where area_id = $area";
$result = $conn->query($sql);


while ($row = mysqli_fetch_assoc($result)) 
{   
    
    $response["id"] = $row['id'];
    $response['device_no'] = $row['device_no'];
    $response['phone_number'] = $row['phone_number'];
    
    $data[] = $response;
}



$json_data = array(
    "token"       =>'',
    "results"            => $data   // total data array
  );
echo json_encode($json_data);
$conn->close();

?>