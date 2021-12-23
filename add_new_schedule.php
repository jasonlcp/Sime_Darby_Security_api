




<?php
$date = date("D M d, Y G:i");
$file = fopen("C:/xampp/htdocs/Add_New_RFID.txt","a");

fwrite($file,$date . ": triggered\n");




$curl = curl_init();
$date =  date('Y-m-d');
curl_setopt_array($curl, array(
  CURLOPT_URL => "https://simedarbypropertycommunity.com//offline/entry_schedule?start_date=".$date."&area_id=1",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
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


// echo $data['entry_schedule'];
foreach($data['entry_schedule'] as $entry){
  $curl1 = curl_init();
  curl_setopt_array($curl1, array(
    CURLOPT_URL => "http://localhost/SecurityApp/add_rfid.php",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => $entry,
    CURLOPT_HTTPHEADER => array(
      "cache-control: no-cache",
      "content-type: multipart/form-data",
    ),
  ));

  $response1 = curl_exec($curl1);
  $err1 = curl_error($curl1);

  curl_close($curl1);

  echo $response1;
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
