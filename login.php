<?php 
include 'config.php';
$user=$_POST['username'];
$pass=$_POST['password'];
$sql =  "SELECT * FROM security_guards_security s 
         left join residents_community c on c.id =s.community_id
         where username = '".$user."' and password = '".$pass."'";
$result = $conn->query($sql);

$token = '';
while ($row = mysqli_fetch_assoc($result)) 
{   
    $sql1 = 'SELECT * FROM residents_area where id='.$row["area_id"].'';
    $result1 = $conn->query($sql1);
    while ($row2 = mysqli_fetch_assoc($result1)) 
    {
        $response["area"] = $row2;
        $response['area_name'] = $row2['name'];
        $response['community_name'] = $row['name'];
        $response['first_name'] = $row['first_name'];
        $response['last_name'] = $row['last_name'];
        $response['status'] = $row['status'];
        $response['username'] = $row['username'];
        $response['id'] = $row['id'];
        $token = $row['token'];
        
    }
    
  
}
$json_data = array(
    "token"       =>$token,
    "user"            => $response   // total data array
  );
echo json_encode($json_data);
$conn->close();
?>