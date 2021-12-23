<?php
$date = date("D M d, Y G:i");
$file = fopen("C:/xampp/htdocs/add_new_entry.txt","a");

fwrite($file,$date . ": triggered\n");




$curl = curl_init();
$date =  date('Y-m-d');
curl_setopt_array($curl, array(
  CURLOPT_URL => "http://localhost/SecurityApp/all_entry.php",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
//   CURLOPT_POSTFIELDS => array('start_date' =>  $date),
//   CURLOPT_HTTPHEADER => array(
//     "cache-control: no-cache",
//     "content-type: multipart/form-data",
//     "postman-token: 9d066af8-9d6c-95c4-c188-7197689cc3d2"
//   ),
));



$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);
$data =[];
// if ($err) {
//   echo "cURL Error #:" . $err;
// } else {
  $data =json_decode($response,true);
// }


// echo $json_decode($response['data'],true);
foreach($data['data'] as $row){
    // echo $row['driver_image'];

    //Driver_Image
    // $ch_driver = curl_init();

    // // set URL and other appropriate options
    // curl_setopt($ch_driver, CURLOPT_URL, $row['driver_image']);
    // curl_setopt($ch_driver, CURLOPT_RETURNTRANSFER, 1); 
    // curl_setopt($ch_driver, CURLOPT_HEADER, 0);

    // // grab URL and pass it to the browser
    // $driver = curl_exec($ch_driver);

    // // close cURL resource, and free up system resources
    // curl_close($ch_driver);

    // //IC_Image
    // $ch_ic = curl_init();

    // // set URL and other appropriate options
    // curl_setopt($ch_ic, CURLOPT_URL, $row['identity_image']);
    // curl_setopt($ch_ic, CURLOPT_RETURNTRANSFER, 1); 
    // curl_setopt($ch_ic, CURLOPT_HEADER, 0);

    // // grab URL and pass it to the browser
    // $ic = curl_exec($ch_ic);

    // // close cURL resource, and free up system resources
    // curl_close($ch_ic);

    // //IC_Image
    // $ch_entry = curl_init();

    // // set URL and other appropriate options
    
    // curl_setopt($ch_entry, CURLOPT_URL, $row['entry_car_plate_image']);
    // curl_setopt($ch_entry, CURLOPT_RETURNTRANSFER, 1); 
    // curl_setopt($ch_entry, CURLOPT_HEADER, 0);

    // // grab URL and pass it to the browser
    // $entry = curl_exec($ch_entry);

    // // close cURL resource, and free up system resources
    // curl_close($ch_entry);

    $lot = $row['lot_id'];
    $street = $row['street_id'];
    $reason = $row['reason'];
    $community = $row['community_id'];
    $area = $row['area_id'];
    $status = $row['status'];
    $entry_type = $row['entry_type'];
    $visitor_car_plate = $row['visitor_car_plate'];
    $passNumber_id = $row['passNumber_id'];
    $deviceNumber_id = $row['deviceNumber_id'];
    $with_vehicle = $row['with_vehicle'];
    $security_id = $row['security_id'];
    
    $blob1 = $row['identity_image'];
    $blob2 = $row['entry_car_plate_image'];
    $blob3 = $row['driver_image'];
    $image_ic = (stristr($row['identity_image'],'?',true))?stristr($row['identity_image'],'?',true):$row['identity_image'];
    $image_driver = (stristr($row['driver_image'],'?',true))?stristr($row['driver_image'],'?',true):$row['driver_image'];
    $image_entry = (stristr($row['entry_car_plate_image'],'?',true))?stristr($row['entry_car_plate_image'],'?',true):$row['entry_car_plate_image'];

$pos1 = strrpos($image_ic,'/');
$image_ic = substr($image_ic,$pos1+1);

$pos2 = strrpos($image_driver,'/');
$image_driver = substr($image_driver,$pos2+1);

$pos3 = strrpos($image_entry,'/');
$image_entry = substr($image_entry,$pos3+1);
    // $ic  = base64_encode($blob1);

    // $entry  = base64_encode($blob2);

    // $driver  = base64_encode($blob3);

    if($lot == 0 ){
      $lot = '';
    }

    if($street == 0 ){
      $street = '';
    }
    
  // echo $image_name;
  $curl1 = curl_init();
  $new_record = array(
    'lot' => $lot,
    'driver_image' => curl_file_create($blob3, 'jpg', $image_driver),
    'identity_image' => curl_file_create($blob1, 'jpg', $image_ic),
    'entry_car_plate_image' => curl_file_create($blob2, 'jpg', $image_entry),
    'street' => $street,
    'reason' => $reason,
    'community' => $community,
    'area' => $area,
    'status' => $status,
    'entry_type' => $entry_type,
    'visitor_car_plate' => $visitor_car_plate,
    'passNumber_id' => $passNumber_id,
    'deviceNumber' => $deviceNumber_id,
    'with_vehicle' => $with_vehicle,
    'security' => `$security_id`,

  );
  curl_setopt_array($curl1, array(
    CURLOPT_URL => "https://simedarbypropertycommunity.com/v1/visitor_entry/",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => $new_record,
    CURLOPT_HTTPHEADER => array(
      "cache-control: no-cache",
      "content-type: multipart/form-data",
    ),
  ));

  $response1 = curl_exec($curl1);
  $err1 = curl_error($curl1);

  curl_close($curl1);

  if ($err1) {
    echo "cURL Error #:" . $err1;
    // fwrite($file,$date . ": cURL Error -> ".$card_no." : ".$err1."\n");
  } else {
    // fwrite($file,$date . ": ".$card_no." -> create successfull\n");

    // fwrite($file,$date . ": result -> ".$card_no." : ".$response1."\n");
  }
    

 }
// if($data['data']){

// fwrite($file,$date . ": data get!\n");
// fwrite($file,$date . ": ".json_encode($data['data'])."\n");


// foreach($data['data'] as $card){
//   $card_no =$card['rfid_no'];
//   $owner_name =$card['owner_name'];
//   $car_plate =$card['car_plate'];
//   $lot_id =$card['lot_id'];


//   // fwrite($file,$date . ": ".$card." -> creating\n");

//   $curl1 = curl_init();

//   curl_setopt_array($curl1, array(
//     CURLOPT_URL => "http://localhost/SecurityApp/add_rfid.php",
//     CURLOPT_RETURNTRANSFER => true,
//     CURLOPT_ENCODING => "",
//     CURLOPT_MAXREDIRS => 10,
//     CURLOPT_TIMEOUT => 30,
//     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//     CURLOPT_CUSTOMREQUEST => "POST",
//     CURLOPT_POSTFIELDS => $card,
//     CURLOPT_HTTPHEADER => array(
//       "cache-control: no-cache",
//       "content-type: multipart/form-data",
//     ),
//   ));

//   $response1 = curl_exec($curl1);
//   $err1 = curl_error($curl1);

//   curl_close($curl1);

//   if ($err1) {
//     echo "cURL Error #:" . $err1;
//     fwrite($file,$date . ": cURL Error -> ".$card_no." : ".$err1."\n");
//   } else {
//     fwrite($file,$date . ": ".$card_no." -> create successfull\n");

//     fwrite($file,$date . ": result -> ".$card_no." : ".$response1."\n");
//   }
 


// }


// }else{
//     fwrite($file,$date . ": No data \n");
// }

// fwrite($file,"\n\n");





?>
