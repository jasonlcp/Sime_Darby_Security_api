<?php 
include 'config.php';
// $area=$_POST['area'];
// $pass=$_POST['password'];
$sql =  "SELECT * FROM residents_street where area_id= 1";

$result = $conn->query($sql);
$count = 0;

while ($row = mysqli_fetch_assoc($result)) 
{   
    $data['id']=$row['id'];
    $data['name']=$row['name'];
    $sql2 = 'SELECT * FROM residents_lot where street_id='.$row['id'].'';
    $result2 = $conn->query($sql2);
    while ($row2 = mysqli_fetch_assoc($result2)) 
    {   
        $data2['id']=$row2['id'];
        $data2['name']=$row2['name'];
        $data2['has_resident']='true';
        if($row2['is_lock'] != 0){
            $data2['is_lock']='false';
          }else{
            $data2['is_lock']='true';
          }   
        $data['lot_set'][] = $data2;
    }
    $response[] = $data;
}



$json_data = array(
    "results"            => $response   // total data array
  );
echo json_encode($json_data);
$conn->close();

?>