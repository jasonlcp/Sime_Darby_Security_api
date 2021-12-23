<?php 
include 'config.php';
// $area=$_POST['area'];
// $pass=$_POST['password'];
$sql =  "SELECT * FROM security_guards_reasonsetting where is_active='1' order by seq asc";
$result = $conn->query($sql);
$count = 0;

while ($row = mysqli_fetch_assoc($result)) 
{   

    $data['id'] = $row['id'];
    $data['reason'] = $row['reason'];
    $data['is_active'] = $row['is_active'];
    $data['thumbnail'] = $row['thumbnail'];
    
    if($row['address'] == '1'){
      $data['address'] = true;
    }else{
      $data['address'] = false;
    }

    $response[]=$data;
    $count++;
}



$json_data = array(
    "count"       =>$count,
    "next"       =>'',
    "previous"       =>'',
    "results"            => $response   // total data array
  );
echo json_encode($json_data);
$conn->close();

?>