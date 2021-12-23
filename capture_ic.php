<?php
//$output = system("ffmpeg -f video4linux2 -s 1920x1080   -i /dev/video0 -ss 00:00:00.01 -frames:v 1 -q:v 1 -preset ultrafast /var/www/html/temp/temp2.png -y");
//$output = system("ffmpeg -i /var/www/html/temp/temp2.png -i /var/www/html/temp/watermark.png -filter_complex 'overlay=(main_w-overlay_w)/2:(main_h-overlay_h)/2' /var/www/html/temp/temp.png");  
//unlink('/var/www/html/temp/temp.png');

header("Access-Control-Allow-Origin: *");
$output = system("ffmpeg -f video4linux2 -s 800x500 -i /dev/video0 -ss 0:0:1  -frames:v 1 /var/www/html/temp/temp2.jpg -y");
$output = system("ffmpeg -i /var/www/html/temp/temp2.jpg -i /var/www/html/temp/watermark.png -filter_complex 'overlay=(main_w-overlay_w)/2:(main_h-overlay_h)/2' /var/www/html/temp/temp.jpg");    
$image = file_get_contents('temp/temp.jpg');
header("Content-Type: image/jpg");
header("Content-Length: " . strlen($image));
echo $image;
unlink('/var/www/html/temp/temp.jpg');  
unlink('/var/www/html/temp/temp2.jpg'); 
?>
