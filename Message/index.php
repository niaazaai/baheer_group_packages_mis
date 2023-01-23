

<?php 


require_once ('vendor/autoload.php'); // if you use Composer
//require_once('ultramsg.class.php'); // if you download ultramsg.class.php
    
$token="v6qqlt8k925ci9fr"; // Ultramsg.com token
$instance_id="instance17372"; // Ultramsg.com instance id
$client = new UltraMsg\WhatsAppApi($token,$instance_id);
    
$to="93704432466"; 
// $body="salam Engineer saib "; 
// $api=$client->sendChatMessage($to,$body);
// print_r($api);
    
// $audio="https://localhost:4000/bgis/Message/Audio/file.mp3"; 
// $audio="https://file-example.s3-accelerate.amazonaws.com/audio/2.mp3";    
// $api=$client->sendAudioMessage($to,$audio);
// print_r($api);


// $to="put_your_mobile_number_here"; 
$video="https://file-example.s3-accelerate.amazonaws.com/video/test.mp4"; 
$api=$client->sendVideoMessage($to,$video);
print_r($api);




// 792781462
// 93704432466 - furqan 
// 93780777666 - eng rafiullah 

?>