<?php 
include 'config.php';
$entry_id = $_POST['entry_id'];
$status = $_POST['status'];
$force_open = $_POST['force_open'];


$sql ="UPDATE visitors_track_entry SET `status` ='$status' , `force_open` = '$force_open' where id ='$entry_id'";
if ($conn->query($sql) === TRUE) {
  
	$json_data = array(
        "status"       =>'success',   // total data array
    );
    echo json_encode($json_data);
}else {
   echo "Error" . $conn->error;
}

?>