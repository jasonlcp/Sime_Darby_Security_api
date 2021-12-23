<?php 
include 'config.php';

$sql =  "SELECT * FROM security_guards_security s 
         left join residents_community c on c.id =s.community_id
        ";
$result = $conn->query($sql);


while ($row = mysqli_fetch_assoc($result)) 
{   
   $response[]= $row;
    
  
}
$json_data = array(
    "token"       =>'',
    "user"            => $response   // total data array
  );
echo json_encode($json_data);
$conn->close();
?>