<?php 
include 'config.php';
$identity_image=$_FILES['identity_image'];
$entry_car_plate_image = $_FILES['entry_car_plate_image'];
$driver_image = $_FILES['driver_image'];
$lot = $_POST['lot'];
$street = $_POST['street'];
$reason = $_POST['reason'];
$community = $_POST['community'];
$area = $_POST['area'];
$status = $_POST['status'];
$entry_type = $_POST['entry_type'];
$visitor_car_plate = $_POST['visitor_car_plate'];
$passNumber_id = $_POST['passNumber_id'];
$deviceNumber_id = $_POST['deviceNumber'];
$with_vehicle = $_POST['with_vehicle'];
$security_id = $_POST['security'];

function generateRandomString($length = 5) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


$sql ="INSERT INTO visitors_track_entry (`status`, entry_type, visitor_name,visitor_car_plate,visitor_phone_number,area_id,community_id,entry_id,lot_id,street_id,visitor_id,resident_id,passNumber_id,reason,deviceNumber_id,with_vehicle,security_id,send_out,force_open,resident_name) 
        VALUES ('$status','$entry_type','','$visitor_car_plate','','$area','$community','','$lot','$street','','','$passNumber_id','$reason','$deviceNumber_id','$with_vehicle','$security_id','0','0','')";
         if ($conn->query($sql) === TRUE) {
             $entry_id = $conn->insert_id;	
             $target_dir = "simedarby.custom_azure.PublicMediaAzureStorage/identity/";
             // Valid file extensions
			$extensions_arr = array("jpg","jpeg","png","gif");

			//identity_image
			// for( $i=0 ; $i < $count ; $i++ ) {
				$target_file = $target_dir . basename(generateRandomString().'_'.$identity_image["name"]);

				// Select file type
				$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

				if( in_array($imageFileType,$extensions_arr) ){
		
					if (!file_exists($target_dir)) {
						mkdir($target_dir, 0777, true);
					}
				// Convert to base64 
					move_uploaded_file($identity_image['tmp_name'],$target_file);
				}
				//entry_car_plate_image
				$target_dir2 = "simedarby.custom_azure.PublicMediaAzureStorage/entry/";

					$target_file2 = $target_dir2 . basename(generateRandomString().'_'.$entry_car_plate_image["name"]);

					// Select file type
					$imageFileType = strtolower(pathinfo($target_file2,PATHINFO_EXTENSION));
	
					if( in_array($imageFileType,$extensions_arr) ){
			
						if (!file_exists($target_dir2)) {
							mkdir($target_dir2, 0777, true);
						}
					// Convert to base64 
						move_uploaded_file($entry_car_plate_image['tmp_name'],$target_file2);

                    //driver_image
					$target_dir3 = "simedarby.custom_azure.PublicMediaAzureStorage/driver/";

						$target_file3 = $target_dir3 . basename(generateRandomString().'_'.$driver_image["name"]);

						// Select file type
						$imageFileType = strtolower(pathinfo($target_file3,PATHINFO_EXTENSION));
		
						if( in_array($imageFileType,$extensions_arr) ){
				
							if (!file_exists($target_dir3)) {
								mkdir($target_dir3, 0777, true);
							}
						// Convert to base64 
							move_uploaded_file($driver_image['tmp_name'],$target_file3);
						}
					$sql2 ="UPDATE visitors_track_entry
                    SET identity_image = 'http://localhost/SecurityApp/$target_file', 
					    entry_car_plate_image = 'http://localhost/SecurityApp/$target_file2',  
						driver_image = 'http://localhost/SecurityApp/$target_file3'  
					 WHERE id = '$entry_id'";
					$conn->query($sql2);
				
				

			
			$json_data = array(
					"status"       =>'success',   // total data array
				);
            echo json_encode($json_data);
         }else {
			echo "Error" . $conn->error;
		 }
        }



?>