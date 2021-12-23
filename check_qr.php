<?php 
include 'config.php';
$qrcode=$_POST['qr_uuid'];
$area=$_POST['area_id'];
$sql =  "SELECT a.name as area_name,v.id as schedule_id,l.name as lot_name,s.name as street_name, v.*,l.*,s.*,a.* FROM `visitors_entry_schedule` v
          left join residents_lot l on l.id = v.lot_id
          left join residents_street s on s.id = l.street_id
          left join residents_area a on a.id = s.area_id
          Where v.qr_uuid ='$qrcode' and s.area_id= $area";
$result = $conn->query($sql);


while ($row = mysqli_fetch_assoc($result)) 
{   
    // $response[] = $row;

    if( $row['is_notify'] == 0){
      $notify = false;
    }else{
      $notify = true;
    }

    if( $row['is_active'] == 0){
      $notify = 'Inactive';
    }else{
      $notify = 'Active';
    }

    $data['area'] = $row['area_id'];
    $data['area_name'] = $row['area_name'];
    $data['community'] = $row['community_id'];
    $data['days'] = $row['days'];
    $data['end_date'] = $row['end_date'];
    $data['entry_type'] = $row['entry_type'];
    $data['id'] = $row['schedule_id'];
    $data['is_notify'] = $row['is_notify'];
    $data['lot'] = $row['lot_id'];
    $data['lot_name'] = $row['lot_name'];
    $data['qr_uuid'] = $row['qr_uuid'];
    $data['resident'] = $row['resident_id'];
    $data['start_date'] = $row['start_date'];
    $data['status'] = $row['is_active'];
    $data['street'] = $row['street_id'];
    $data['street_name'] = $row['street_name'];
    $data['track_entry']['status'] = '-';
    $data['track_entry']['tracker_id'] = '-';
    $data['visitor_id'] = $row['visitor_id'];
    $data['visitor_car_plate'] = $row['visitor_car_plate'];
    $data['visitor_name'] = $row['visitor_name'];
    $data['visitor_phone_number'] = $row['visitor_phone_number'];


    $response = $data;

  
}
$json_data = array(
    "token"       =>'',
    "user"            => $response   // total data array
  );
echo json_encode($response);
$conn->close();
?>