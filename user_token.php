<?php 
include 'config.php';
$token = $_POST['token'];
$security =  $_POST['security_id'];


$sql ="UPDATE security_guards_security SET `token` ='$token' where id ='$security'";
if ($conn->query($sql) === TRUE) {
  
	$json_data = array(
        "status"       =>'success',   // total data array
    );
    echo json_encode($json_data);
}else {
   echo "Error" . $conn->error;
}

?>