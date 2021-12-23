<!DOCTYPE html>

<html style="height:100%;width:100%;">



<head>

    <link rel="stylesheet" href="css/bootstrap.min.css">

    <link rel=" stylesheet" type="text/css" href="css/style.css">

</head>



<?php   



$servername = "localhost";

$username = "admin";

$password = "admin1288";

$dbname = "IVMS";

system("sudo /etc/init.d/exitscanner.sh restart");

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

        //$data =  "https://vmsdjangoapp01-clone1.azurewebsites.net";

        $data =  $row["ip_address"];

    }



}



$query1= $conn->query("select * from config where config_type = 'message'");



if ($query1->num_rows > 0  ) 

{

    while($row1 = $query1->fetch_assoc()) 

    {

        $message =  $row1["ip_address"];

    }



}



$query2= $conn->query("select * from config where config_type = 'area'");



if ($query2->num_rows > 0  ) 

{

    while($row2 = $query2->fetch_assoc()) 

    {

        $area =  $row2["ip_address"];

    }

   

}else{

    echo "<script>alert('Area is undefinded!')</script>";  

}

?>







<style>

.loader {

  border: 8px solid #f3f3f3;

  border-radius: 50%;

  border-top: 8px solid transparent;

  width: 60px;

  height: 60px;

  -webkit-animation: spin 2s linear infinite; /* Safari */

  animation: spin 2s linear infinite;

}



/* Safari */

@-webkit-keyframes spin {

  0% { -webkit-transform: rotate(0deg); }

  100% { -webkit-transform: rotate(360deg); }

}



@keyframes spin {

  0% { transform: rotate(0deg); }

  100% { transform: rotate(360deg); }

}

</style>















<body  style="

background: linear-gradient( rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)), url('temp/bg.jpg');

background-repeat: no-repeat;

background-size:cover;

min-width:100%;

min-height:100%;

"

>

   

        <form class="formSubmit">

            <input class="hidden-input scanner" type="text" />

        </form>

    

        <div class="display" style='padding-top:5%;'>

        <center>

            <?php

                if (file_exists('temp/logo2.png'))

                {    

                        echo '<img id="logo" src="temp/logo2.png" style="object-fit: contain;width:15%;"><br> <br><br> ';

                } 

            if($message!=''){

                echo "<p id='message' style='color:white;font-size:6vw'>".$message."</p>";

            

            }else{

                echo "<p id='message' style='color:white;font-size:6vw;'>Welcome!</p>";

                

            }

            ?>

            <br>

            <div id='entry_details' style='font-size:4.5vw'>

            </div><br>

  

            <div id='error_message' style='font-size:4.5vw'>

             <p style="color:white;max-width:90%;">Please present your Identity Card <br>and QR Code</p> 

            </div>

             

            <div id="show_video">

            

            </div>



        </center>

      

        </div>





       





        <audio id="welcome">

            <source src="welcome.mp3" type="audio/mpeg">

        </audio>

        <audio id="no_ic">

            <source src="no_ic.mp3" type="audio/mpeg">

        </audio>

        <audio id="qr_invalid">

            <source src="qr_invalid.mp3" type="audio/mpeg">

        </audio>

        <audio id="entry_posting">

            <source src="entry_posting.mp3" type="audio/mpeg">

        </audio>

        <audio id="entry_posted">

            <source src="entry_posted.mp3" type="audio/mpeg">

        </audio>



       

        <audio id="secutity_approved">

            <source src="secutity_approved.mp3" type="audio/mpeg">

        </audio>

        <audio id="rejected">

            <source src="rejected.mp3" type="audio/mpeg">

        </audio>



        <audio id="approved">

            <source src="resident_approved.mp3" type="audio/mpeg">

        </audio>

		

	    <audio id="onhold">

            <source src="onhold.mp3" type="audio/mpeg">

        </audio>

        

        <audio id="insertIC">

            <source src="insert_ic.mp3" type="audio/mpeg">

        </audio>

        

        <audio id="removeIC">

            <source src="remove_ic.mp3" type="audio/mpeg">

        </audio>

        

         <audio id="pending">

            <source src="waiting_resident_approve.mp3" type="audio/mpeg">

        </audio>





    <!-- JS Files-->

    <script src="js/jquery.js"></script>

    <script src="js/poper.js"></script>

    <script src="js/bootstrap.min.js"></script>

    <script src="js/swal.js"></script>

    <script> $("#error_message").html('<p style="color:white;max-width:80%;">connecting to server...</p>') 

                    

                    window.onerror = function(error) {

                    window.location.href = window.location.href;

                  $("#error_message").html('<p style="color:red;max-width:80%;">Something went wrong!</p>') 

                };

                    

    </script>

    <script src="https://vmsnodejsweb.azurewebsites.net/socket.io/socket.io.js"></script>

    <script>

         

        

        var track_id="";

  



        var no_ic_audio = document.getElementById("no_ic"); 

        var qr_invalid_audio = document.getElementById("qr_invalid"); 

      

        var entry_posting_audio = document.getElementById("entry_posting"); 





	



        var secutity_approved = document.getElementById("secutity_approved"); 

        var rejected = document.getElementById("rejected"); 

		

        var approved = document.getElementById("approved");

        var onhold = document.getElementById("onhold"); 	

        

        

        var insert_ic = document.getElementById("insertIC");

        var remove_ic = document.getElementById("removeIC");

        

        var pending = document.getElementById("pending");

        no_ic_audio.pause(); 

        no_ic_audio.currentTime = 0;



        qr_invalid_audio.pause(); 

        qr_invalid_audio.currentTime = 0;



     

        entry_posting_audio.pause(); 

        entry_posting_audio.currentTime = 0;



        entry_posted.pause(); 

        entry_posted.currentTime = 0;



        secutity_approved.pause(); 

        secutity_approved.currentTime = 0;





        rejected.pause(); 

        rejected.currentTime = 0;



        approved.pause(); 

        approved.currentTime = 0;



        onhold.pause(); 

        onhold.currentTime = 0;

        

        

        insert_ic.pause(); 

        insert_ic.currentTime = 0;



        remove_ic.pause(); 

        remove_ic.currentTime = 0;

        

        

pending.pause(); 

            pending.currentTime = 0;





    //socket

   // var socket = io.connect( 'http://139.162.60.53:3000' );

     var socket = io.connect( 'https://vmsnodejsweb.azurewebsites.net' );

 

     // Global events are bound against socket

        socket.on('connect_failed', function(){

            $("#error_message").html('<p style="color:red;max-width:80%;">Connection Failed!</p>');

        });

        socket.on('connect', function(){

                                     $("#error_message").html('<p style="color:white;max-width:80%;">Please insert your identity card and scan QR code...</p>');



        });

        socket.on('disconnect', function () {

              $("#error_message").html('<p style="color:red;max-width:80%;">Server Disconnected!</p>');
              var socket = io.connect( 'http://192.168.0.104:3002',{secure:false} );


        });





        socket.on('disconnect', function () {

              $("#error_message").html('<p style="color:red;max-width:80%;">Server Disconnected!</p>');

        });

        

        socket.on('impromptu_arrive', function (data) {

            

            if(track_id == ""){

            if(data == true){

                

               var scan_video = "<img width='520' height='240' src='scan.gif' style='object-contain:fit' />";

               setTimeout(function(){  insert_ic.play() }, 600);

               setTimeout(function(){ $("#error_message").html('<p style="color:green;max-width:80%;">Please Insert Identity Card...</p>');}, 600);

               setTimeout(function(){ $("#show_video").html(scan_video);},600); 

            }else if(data == false){

               setTimeout(function(){  insert_ic.pause() }, 300);

               setTimeout(function(){    $("#error_message").html('<p style="color:white;max-width:80%;">Please insert your identity card and scan QR code...</p>') }, 600);

               setTimeout(function(){   $("#entry_details").html('') }, 600);

               setTimeout(function(){   $("#show_video").html('') }, 600);

            }

        }

        });

    //socket.emit('security_user',{role:"ivms",id:1,area:<?=$area?>});

    socket.emit('user',{role:"ivms",id:1,area:<?=$area?>});

 

    

        

    socket.on('visitor_arrive',function(data){

        console.log(data);

        var no_ic_audio = document.getElementById("no_ic"); 

        var qr_invalid_audio = document.getElementById("qr_invalid"); 

      

        var entry_posting_audio = document.getElementById("entry_posting"); 





	    var insert_ic = document.getElementById("insertIC");

        var remove_ic = document.getElementById("removeIC");



        var secutity_approved = document.getElementById("secutity_approved"); 

        var rejected = document.getElementById("rejected"); 

		

        var approved = document.getElementById("approved");

        var onhold = document.getElementById("onhold"); 

        var pending = document.getElementById("pending");

        if( track_id!="" && data.track_id==track_id){



            no_ic_audio.pause(); 

            no_ic_audio.currentTime = 0;



            qr_invalid_audio.pause(); 

            qr_invalid_audio.currentTime = 0;



         

            entry_posting_audio.pause(); 

            entry_posting_audio.currentTime = 0;



            entry_posted.pause(); 

            entry_posted.currentTime = 0;



            secutity_approved.pause(); 

            secutity_approved.currentTime = 0;



        

  	        rejected.pause(); 

            rejected.currentTime = 0;



            approved.pause(); 

            approved.currentTime = 0;



            onhold.pause(); 

            onhold.currentTime = 0;





            insert_ic.pause(); 

            insert_ic.currentTime = 0;



            remove_ic.pause(); 

            remove_ic.currentTime = 0;

            

            

pending.pause(); 

            pending.currentTime = 0;

            //do something here

            console.log(data.status)

           if(data.status=="RIR"){

            //rejected by resident

            setTimeout(function(){  rejected.play() }, 600);

            setTimeout(function(){  $("#error_message").html('<p style="color:red;max-width:80%;">Entry Request Rejected.<br>Please contact the security guards on duty for assistance</p>');}, 600);

            setTimeout(function(){   $("#show_video").html('') }, 600);



            setTimeout(function(){  var node = document.getElementById('error_message'),



            htmlContent = node.innerHTML 

            if(htmlContent=='<p style="color:red;max-width:80%;">Entry Request Rejected.<br>Please contact the security guards on duty for assistance</p>'){

                $("#error_message").html('<p style="color:white;max-width:80%;">Please insert your identity card and scan QR code...</p>');

                }}, 10000);



            }else if(data.status=="AIR"){

            //approved by resident

            

            setTimeout(function(){  approved.play() }, 600);

            setTimeout(function(){ $("#error_message").html('<p style="color:green;max-width:80%;">Resident Approved<br>Waiting for open boomgate</p>');}, 600);

            setTimeout(function(){   $("#show_video").html('') }, 600);







            }else if(data.status=="AIS"){

            //approved by security guard

            track_id ="";

            setTimeout(function(){  secutity_approved.play() }, 600);

            setTimeout(function(){ $("#error_message").html('<p style="color:green;max-width:80%;">Entry Request Approved.<br>Have a nice day!</p>');}, 600);



            setTimeout(function(){   $("#show_video").html('') }, 600);



            setTimeout(function(){    $("#error_message").html('<p style="color:white;max-width:80%;">Please insert your identity card and scan QR code...</p>') }, 5000);

            setTimeout(function(){   $("#entry_details").html('') }, 5000);



            }else if(data.status=="OEN"){

            //onhold

            track_id ="";

            setTimeout(function(){  onhold.play() }, 600);

            setTimeout(function(){ $("#error_message").html('<p style="color:green;max-width:80%;">Your entry will be on hold until further notice from Security Guard. Thanks for your patience.</p>');}, 600);

setTimeout(function(){   $("#show_video").html('') }, 600);





            setTimeout(function(){    $("#error_message").html('<p style="color:white;max-width:80%;">Please insert your identity card and scan QR code...</p>') }, 10000);

            setTimeout(function(){   $("#entry_details").html('') }, 10000);







            }else if(data.status=="RIS"){

            //rejected by security guard

            track_id ="";

            setTimeout(function(){  rejected.play() }, 600);

            setTimeout(function(){$("#error_message").html('<p style="color:red;max-width:80%;">Entry Request Rejected.<br>Please contact the security guards on duty for assistance</p>');}, 600);

setTimeout(function(){   $("#show_video").html('') }, 600);



            setTimeout(function(){  var node = document.getElementById('error_message'),



            htmlContent = node.innerHTML 

            if(htmlContent=='<p style="color:red;max-width:80%;">Entry Request Rejected.<br>Please contact the security guards on duty for assistance</p>'){

                $("#error_message").html('<p style="color:white;max-width:80%;">Please insert your identity card and scan QR code...</p>');

                }}, 10000);



                }

            }else if(data.track_id != ''){

            if(data.resident == 0){

                track_id == ''

                $("#error_message").html('<p style="color:green;max-width:85%;font-size:3vw">You may remove your Identity Card now.<div class="loader"></div>');

                setTimeout(function(){  remove_ic.play() }, 300);

            setTimeout(function(){   $("#show_video").html('') }, 600);



            setTimeout(function(){    $("#error_message").html('<p style="color:white;max-width:80%;">Please insert your identity card and scan QR code...</p>') }, 5000);

            setTimeout(function(){   $("#entry_details").html('') }, 5000);

            }else if(track_id == ''){    

            no_ic_audio.pause(); 

            no_ic_audio.currentTime = 0;



            qr_invalid_audio.pause(); 

            qr_invalid_audio.currentTime = 0;



         

            entry_posting_audio.pause(); 

            entry_posting_audio.currentTime = 0;



            entry_posted.pause(); 

            entry_posted.currentTime = 0;

         

            secutity_approved.pause(); 

            secutity_approved.currentTime = 0;



        

            rejected.pause(); 

            rejected.currentTime = 0;



            approved.pause(); 

            approved.currentTime = 0;



            onhold.pause(); 

            onhold.currentTime = 0;

 

            insert_ic.pause(); 

            insert_ic.currentTime = 0;



            remove_ic.pause(); 

            remove_ic.currentTime = 0;



pending.pause(); 

            pending.currentTime = 0;



            //do something here

            console.log(data.status)

           if(data.status=="RIR"){

            //rejected by resident

            setTimeout(function(){  rejected.play() }, 600);

            setTimeout(function(){  $("#error_message").html('<p style="color:red;max-width:80%;">Entry Request Rejected.<br>Please contact the security guards on duty for assistance</p>');}, 600);

setTimeout(function(){   $("#show_video").html('') }, 600);





            setTimeout(function(){  var node = document.getElementById('error_message'),



            htmlContent = node.innerHTML 

            if(htmlContent=='<p style="color:red;max-width:80%;">Entry Request Rejected.<br>Please contact the security guards on duty for assistance</p>'){

            $("#error_message").html('<p style="color:white;max-width:80%;">Please insert your identity card and scan QR code...</p>');

            }}, 10000);



            }else if(data.status=="AIR"){

            //approved by resident

            

            setTimeout(function(){  approved.play() }, 600);

            setTimeout(function(){ $("#error_message").html('<p style="color:green;max-width:80%;">Resident Approved<br>Waiting for open boomgate</p>');}, 600);

            setTimeout(function(){   $("#show_video").html('') }, 600);







            }else if(data.status=="PEN"){

            //pending

            

            $("#error_message").html('<p style="color:green;max-width:85%;font-size:3vw">You may remove your Identity Card now.<br>Your host has been alerted and is currently validating your entry request.<br>This may take a few minutes</p>  <div class="loader"></div>');

            setTimeout(function(){  entry_posted.play() }, 300);

            $("#show_video").html('') 





            }else if(data.status=="AIS"){

            //approved by security guard

            track_id ="";

            setTimeout(function(){  secutity_approved.play() }, 600);

            setTimeout(function(){ $("#error_message").html('<p style="color:green;max-width:80%;">Entry Request Approved.<br>Have a nice day!</p>');}, 600);



setTimeout(function(){   $("#show_video").html('') }, 600);



            setTimeout(function(){    $("#error_message").html('<p style="color:white;max-width:80%;">Please insert your identity card and scan QR code...</p>') }, 5000);

            setTimeout(function(){   $("#entry_details").html('') }, 5000);



            }else if(data.status=="OEN"){

            //onhold

            track_id ="";

            setTimeout(function(){  onhold.play() }, 600);

            setTimeout(function(){ $("#error_message").html('<p style="color:green;max-width:80%;">Your entry will be on hold until further notice from Security Guard. Thanks for your patience.</p>');}, 600);

setTimeout(function(){   $("#show_video").html('') }, 600);





            setTimeout(function(){    $("#error_message").html('<p style="color:white;max-width:80%;">Please insert your identity card and scan QR code...</p>') }, 10000);

            setTimeout(function(){   $("#entry_details").html('') }, 10000);







            }else if(data.status=="RIS"){

            //rejected by security guard

            track_id ="";

            setTimeout(function(){  rejected.play() }, 600);

            setTimeout(function(){$("#error_message").html('<p style="color:red;max-width:80%;">Entry Request Rejected.<br>Please contact the security guards on duty for assistance</p>');}, 600);

setTimeout(function(){   $("#show_video").html('') }, 600);



            setTimeout(function(){  var node = document.getElementById('error_message'),



                        htmlContent = node.innerHTML 

                        if(htmlContent=='<p style="color:red;max-width:80%;">Entry Request Rejected.<br>Please contact the security guards on duty for assistance</p>'){

                            $("#error_message").html('<p style="color:white;max-width:80%;">Please insert your identity card and scan QR code...</p>');

                            }}, 10000);



                }

            }

            

            

        }

        });















          

        $('.scanner').focus();

        console.log($('.scanner').focus());

        // Force focus

        $('.scanner').focusout(function () {

            $('.scanner').focus();

            console.log('abc')

        });

        //new form

        var fd;



      

        

        $('.formSubmit').submit(function (e) {

            e.preventDefault();

            $("#error_message").html('<p style="color:white;max-width:80%;">Please insert your identity card and scan QR code...</p>')

            $("#entry_details").html('')

           //$("#show_video").html('') 



            console.log("form submit")

          

            no_ic_audio.pause(); 

            no_ic_audio.currentTime = 0;



            qr_invalid_audio.pause(); 

            qr_invalid_audio.currentTime = 0;



         

            entry_posting_audio.pause(); 

            entry_posting_audio.currentTime = 0;

            

			

			onhold.pause(); 

            onhold.currentTime = 0;



            

            approved.pause(); 

            approved.currentTime = 0;

            

            insert_ic.pause(); 

            insert_ic.currentTime = 0;



            remove_ic.pause(); 

            remove_ic.currentTime = 0;

            

            

pending.pause(); 

            pending.currentTime = 0;



            $.get("ic_detector.php", function (data) {

                data = JSON.parse(data);

                if (data.status == false) {

                 

                //no ic 

                    

                    setTimeout(function(){  no_ic_audio.play() }, 500);

                    $("#error_message").html('<p style="color:white;max-width:80%;">Please insert your identity card and scan QR code...</p>');

$("#show_video").html('') 



                } else {

                    $("#error_message").html('<p style="color:green;max-width:80%;">Scanning your Identity Card and QR Code</p> <div class="loader"></div>');

                    setTimeout(function(){  entry_posting_audio.play() }, 500);

$("#show_video").html('') 

                    $.post('<?php echo $data ?>/v1/visitors/check_qr/', {

                qr_uuid: $('.scanner').val(),

                area_id: <?php echo $area ?>

            }, function (data) {

                console.log(data)

                console.log(data.track_entry.tracker_id)

				if(data.track_entry.tracker_id != '-'){

					if(data.track_entry.status == 'OEN'){

                    track_id ="";

					setTimeout(function(){  onhold.play() }, 600);

					setTimeout(function(){ $("#error_message").html('<p style="color:green;max-width:80%;">Your entry will be on hold until further notice from Security Guard. Thanks for your patience.</p>');}, 600);

                    $("#show_video").html('') 



					setTimeout(function(){    $("#error_message").html('<p style="color:white;max-width:80%;">Please insert your identity card and scan QR code...</p>') }, 10000);

					setTimeout(function(){   $("#entry_details").html('') }, 10000);

					}else if(data.track_entry.status=="AIR"){

					//approved by resident

					track_id = data.track_entry.tracker_id;

					setTimeout(function(){  approved.play() }, 600);

					setTimeout(function(){ $("#error_message").html('<p style="color:green;max-width:80%;">Resident Approved<br>Waiting for open boomgate</p>');}, 600);

                    fd = new FormData();

                    fd.append('status', 'AIR');

                    $.ajax({

                        type: "PUT",

                        url: '<?php echo $data ?>/v1/visitor_entry/'+data.track_entry.tracker_id+'/',

                        data: fd,

                        contentType: false,

                        processData: false,

                        headers:{"Authorization": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoxNCwidXNlcm5hbWUiOiJndWFyZF9ldjMiLCJleHAiOjE2NjMwMzc4MjUsIm9yaWdfaWF0IjoxNjMxNTAxODI1fQ.S-wirUJTSJLWPSyMVlFKIp8e2abJWpZwoop1bmiDu50"},

                        success: function (data) {

                            console.log("server respone success")

                            console.log(data);

                           





                        },



                    });





					}else{

                    $("#entry_details").html('<p style="color:white">Hi '+data.visitor_name.toUpperCase()+'</p>');

					$("#error_message").html('<p style="color:green;max-width:80%;">Scanning your Identity Card and QR Code</p> <div class="loader"></div>');

					

                     $("#show_video").html('') 

					$('.display').append($('.scanner').val());

					fd = new FormData();

					console.log(data);

					fd.append('status', 'PEN');

					fd.append('visitor_name', data.visitor_name);

					fd.append('visitor_car_plate', data.visitor_car_plate);

					fd.append('visitor_phone_number', data.visitor_phone_number);

					if (data.visitor != null) {

						fd.append('visitor', data.visitor);

					}



					fd.append('entry_type', data.entry_type);

					fd.append('entry', data.id);

					fd.append('lot', data.lot);

					fd.append('resident', data.resident);

					fd.append('community', data.community);

					fd.append('area', data.area);

					fd.append('street', data.street);

               



                    console.log("start capture image")

                    $.get("lighton.php").done(function () {

                       

                       

                            captureIC();



                        })

                        

                        

                    }

						

                }else{

					

					$("#entry_details").html('<p style="color:white">Hi '+data.visitor_name.toUpperCase()+'</p>');

					$("#error_message").html('<p style="color:green;max-width:80%;">Scanning your Identity Card and QR Code</p> <div class="loader"></div>');

					//setTimeout(function(){  entry_posting_audio.play() }, 500);

					$("#show_video").html('') 



					$('.display').append($('.scanner').val());

					fd = new FormData();

					console.log(data);

					fd.append('status', 'PEN');

					fd.append('visitor_name', data.visitor_name);

					fd.append('visitor_car_plate', data.visitor_car_plate);

					fd.append('visitor_phone_number', data.visitor_phone_number);

					if (data.visitor != null) {

						fd.append('visitor', data.visitor);

					}



					fd.append('entry_type', data.entry_type);

					fd.append('entry', data.id);

					fd.append('lot', data.lot);

					fd.append('resident', data.resident);

					fd.append('community', data.community);

					fd.append('area', data.area);

					fd.append('street', data.street);

               



                console.log("start capture image")

                $.get("lighton.php").done(function () {

                   

                   

                        captureIC();



                    })

                }







            }).fail(function (data) {

         

               console.log(data)

                    entry_posting_audio.pause();

        

             

                    $("#error_message").html('<p style="color:red">Invalid or Expired QR Code.<br>Please contact your host for assistance.</p>');

                    setTimeout(function(){  qr_invalid_audio.play() }, 300);

                    $("#show_video").html('');

              setTimeout(function(){  var node = document.getElementById('error_message'),

                        htmlContent = node.innerHTML 

                        if(htmlContent=='<p style="color:red">Invalid or Expired QR Code.<br>Please contact your host for assistance.</p>'){

                            $("#error_message").html('<p style="color:white;max-width:80%;">Please insert your identity card and scan QR code...</p>');

                            }}, 10000);

                                    

            })



            







                }

            $('.scanner').val('').focus();

            });







       

});

      



    //     function play_audio_after_welcome(audio_var){

    // if ( isPlaying(welcome_audio)) {

    //     //Its playing...do your job

    //     console.log("call back")

      

    //   setTimeout(function(){  play_audio_after_welcome(audio_var); }, 300);  



      

    //     } else {

    //         console.log("play")

    //         setTimeout(function(){  audio_var.play() }, 500);

    //     //Not playing...maybe paused, stopped or never played.



    //     }

    //     }





  //      function isPlaying(audelem) { return !audelem.paused; }





        function captureIC() {

            $.ajax({

                        type: "GET",

                        url: "facecam.php",

                        xhrFields: {

                            responseType: 'blob'

                        },

                        success: function (data) {

                            console.log("get driver image")

                            fd.append('driver_image', data, 'FC.jpg');

                        },

                        complete: function () {

                $.ajax({

                        type: "GET",

                        url: "entrycam.php",

                        xhrFields: {

                            responseType: 'blob'

                        },

                        success: function (data) {

                            console.log("get car plate image")

                            fd.append('entry_car_plate_image', data,

                                'EC.jpg');

                        },

                        complete: function () {

                    $.ajax({

                        type: "GET",

                        url: "capture_ic.php",

                        xhrFields: {

                            responseType: 'blob'

                        },

                        success: function (data) {

                            console.log("get identity card image")

                            fd.append('identity_image', data, 'IC.jpg');

                        },

                        complete: function () {

                console.log("start post to server")

                            

                                    $.ajax({

                                        type: "POST",

                                        url: '<?php echo $data ?>/v1/visitor_entry/',

                                        data: fd,

                                        contentType: false,

                                        processData: false,

                                        success: function (data) {

                                            console.log("server respone success")

                                            console.log(data);

                                            track_id=data.data.tracker_id;

                                            console.log(track_id);





                                           
                                                $("#error_message").html('<p style="color:green;max-width:85%;font-size:3vw">You may remove your Identity Card now.<br>Your host has been alerted and is currently validating your entry request.<br>This may take a few minutes</p>  <div class="loader"></div>');

                                                setTimeout(function(){  entry_posted.play() }, 300);





                                                


                                            $("#show_video").html(''); 

                                        },



                                    });

                                    $.get("lightoff.php");

                               

                                },

                            })

                        },

                    })

                },

            })



          

        }

    </script>

</body>



</html>

