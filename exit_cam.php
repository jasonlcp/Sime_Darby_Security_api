<?php
if(isset($_POST['qr_uuid'])){
    
    echo "  ".$_POST['qr_uuid']."  ";

$servername = "localhost";
$username = "admin";
$password = "admin1288";
$dbname = "IVMS";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
} 

$query= $conn->query("select * from config where config_type = 'domain'");

if ($query->num_rows > 0  ) 
{
    while($row = $query->fetch_assoc()) 
    {
        $domain =  $row["ip_address"];
    }

}

$query= $conn->query("select * from config where config_type = 'relay'");

if ($query->num_rows > 0  ) 
{
    while($row = $query->fetch_assoc()) 
    {
        $dataip =  $row["ip_address"];
    }

}

    
    
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => $domain."/v1/visitors/check_qr_exit/",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_SSL_VERIFYPEER => false,
      CURLOPT_SSL_VERIFYHOST=>false,
      CURLOPT_DNS_USE_GLOBAL_CACHE => false,
      CURLOPT_DNS_CACHE_TIMEOUT => 2,
      CURLOPT_POSTFIELDS => "qr_uuid=".$_POST['qr_uuid'],
      CURLOPT_HTTPHEADER => array(
        "Content-Type: application/x-www-form-urlencoded",
      ),
    ));
  
    
    $response = curl_exec($curl);
    $err = curl_error($curl);
    $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);
    
    if ($err) {
      echo "cURL Error #:" . $err;
    } else {
        $data = json_decode($response);
        
        $img = file_get_contents("http://localhost/exitcam.php");
        file_put_contents("temp/temp2.jpg",$img);
        $save_file = realpath("temp/temp2.jpg");
        /////
        echo $save_file;

        $curl2 = curl_init();
        curl_setopt_array($curl2, array(
          CURLOPT_URL => $domain."/v1/visitor_entry/".$data->tracker_id."/",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_CUSTOMREQUEST => "PUT",
          CURLOPT_DNS_USE_GLOBAL_CACHE => false,
          CURLOPT_DNS_CACHE_TIMEOUT => 2,
          CURLOPT_SSL_VERIFYPEER => false,
          CURLOPT_SSL_VERIFYHOST=>false,
        ));
      
        
	if($httpcode==226) {
	        $post = array('status' => 'OUT','exit_car_plate_image'=>makeCurlFile($save_file)  );
	}else{
	        $post = array('status' => 'PEX','exit_car_plate_image'=>makeCurlFile($save_file)  );
	}


        curl_setopt($curl2, CURLOPT_POSTFIELDS, $post);
        $r = curl_exec($curl2);
        $err = curl_error($curl2);
        echo $r;
        echo $err;
        curl_close($curl2);
        
    }


}
function makeCurlFile($file){
    $mime = mime_content_type($file);
    $info = pathinfo($file);
    $name = $info['basename'];
    $output = new CURLFile($file, $mime, $name);
    return $output;
    }
