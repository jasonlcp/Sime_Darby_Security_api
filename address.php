<?php 
include 'config.php';
// $user=$_POST['area'];
// $pass=$_POST['password'];
$sql =  "SELECT id,name FROM residents_street where area_id = '1'";
$result = $conn->query($sql);


while ($row = mysqli_fetch_assoc($result)) 
{  
  $response = [];
  $response["id"] = $row['id'];
  $response['name'] = $row['name'];
  
    
    $sql1 = 'SELECT * FROM residents_lot where street_id='.$row["id"].'';
    $result1 = $conn->query($sql1);
    while ($row2 = mysqli_fetch_assoc($result1)) 
    {
        $response["lot_set"][] = $row2;
        
       
        
    }
    
    $data[] =  $response;
}

echo json_encode($data);
$conn->close();
?>