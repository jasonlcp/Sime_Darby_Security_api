<?php 
include 'config.php';
$id = $_POST['id'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$is_notify = $_POST['is_notify'];
$qr_uuid = $_POST['qr_uuid'];
$entry_type	 = $_POST['entry_type'];
$days = $_POST['days'];
$created_at	 = $_POST['created_at'];
$updated_at	 = $_POST['updated_at'];
$visitor_name = $_POST['visitor_name'];
$visitor_car_plate = $_POST['visitor_car_plate'];
$visitor_phone_number = $_POST['visitor_phone_number'];
$resident_id= $_POST['resident_id'];
$visitor_id = $_POST['visitor_id'];
$lot_id = $_POST['lot_id'];
$is_active = $_POST['is_active'];




$sql ="INSERT INTO visitors_entry_schedule (id, `start_date`, `end_date`, is_notify,qr_uuid,entry_type,`days`,created_at,updated_at,visitor_name,visitor_car_plate,visitor_phone_number,resident_id,visitor_id,lot_id,is_active)  
        VALUES ('$id','$start_date','$end_date','$is_notify','$qr_uuid','$entry_type','$days','$created_at','$updated_at','$visitor_name','$visitor_car_plate','$visitor_phone_number','$resident_id','$visitor_id','$lot_id','$is_active')";
         
         if ($conn->query($sql) === TRUE) {
            $json_data = array(
                "status"       =>'success',   // total data array
            );
            echo json_encode($json_data); 
         }

?>