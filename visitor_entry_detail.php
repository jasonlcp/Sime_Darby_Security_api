<?php 
include 'config.php';
$id=$_POST['id'];

$sql =  "SELECT * FROM visitors_track_entry where id='$id'";
$result = $conn->query($sql);


while ($row = mysqli_fetch_assoc($result)) 
{   
    // $sql1 = 'SELECT * FROM residents_lot where id='.$row["lot_id"].'';
    // $result1 = $conn->query($sql1);
    // while ($row2 = mysqli_fetch_assoc($result1)) 
    // {   
        
       
    // }
    $data['tracker_id']=$row['id']; 
    $data['community']=$row['community_id'];
    $data['deviceNumber']=$row['deviceNumber_id'];
    $data['driver_image']=$row['driver_image'];
    $data['entry']=$row['entry_id'];
    $data['entry_car_plate_image']=$row['entry_car_plate_image'];
    $data['entry_type']=$row['entry_type'];
    $data['exit_car_plate_image']=$row['exit_car_plate_image'];
    if($row['force_open'] != 0){
      $data['force_open']='false';
    }else{
      $data['force_open']='true';
    }
    $data['identity_image']=$row['identity_image'];
    
    if($row['lot_id'] != ''){
        $sql2 = 'SELECT * FROM residents_lot where id='.$row['lot_id'].'';
        $result2 = $conn->query($sql2);
        while ($row2 = mysqli_fetch_assoc($result2)) 
        {   
            $data['lot']['id']=$row2['id'];
            if($row2['is_lock'] != 0){
                $data['lot']['is_lock']='false';
              }else{
                $data['lot']['is_lock']='true';
              }   
            $data['lot']['name']=$row2['name']; 
            $data['lot']['requestfamily_set']=[]; 
            $data['lot']['residentlotthroughmodel_set']=[];
            $sql3 = 'SELECT * FROM residents_street where id='.$row['street_id'].'';
            $result3 = $conn->query($sql3);
            while ($row3 = mysqli_fetch_assoc($result3)) 
            { 
                $data['lot']['street']['id']=$row3['id']; 
                $data['lot']['street']['name']=$row3['name']; 
                $sql4 = 'SELECT * FROM residents_area where id='.$row['area_id'].'';
                $result4 = $conn->query($sql4);
                while ($row4 = mysqli_fetch_assoc($result4)) 
                { 
                    $data['lot']['street']['area']=$row4;       
                }
            }
        }
    }else{
        $data['lot']=[];
      } 
    $data['passNumber']=[];
    $data['phone_number']=[];
    $data['reason']=$row['reason'];
    $data['resident']=$row['resident_id'];
    $data['resident_name']=$row['resident_name'];
    $data['security']=$row['security_id'];
    $data['status']=$row['status'];
    // $data['tracker_id']=$row['entry_id'];
    $data['updated_at']=$row['updated_at'];
    $data['created_at']=$row['created_at'];
    $data['visitor']=$row['visitor_id'];
    $data['visitor_car_plate']=$row['visitor_car_plate'];
    $data['visitor_name']=$row['visitor_name'];
    $data['visitor_phone_number']=$row['visitor_phone_number'];

    if($row['with_vehicle'] != 0){
        $data['with_vehicle']='false';
      }else{
        $data['with_vehicle']='true';
      }
   
    
    $respone[] =$data;
}
// $json_data = array(
//     "token"       =>'',
//     "user"            => $data   // total data array
//   );
echo json_encode($respone);
$conn->close();
?>