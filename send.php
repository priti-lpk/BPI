<?php

define('SERVER_API_KEY', 'AIzaSyDgH8FynOdg2s_30p6Bpgp9GD6-1w5qT6Q');

$tokens = ['f5KGxZTGkJA:APA91bHfWLlkdWoZolfQAuOHzQKL9NJ0-jGVbtqi8UY78Bn8WziEP5d21L_MFCeGHGFdsAmebq2bMX5i72p0pWRGn-Nl4cBn8YT6YBNqRz86W0OFiDqIalXyk1YwrsZsSqstqd0CXLDT'];

$header = [
    'Authorization:Key=' . SERVER_API_KEY,
    'Content-Type:Application/json'
];

$msg = [
    'title' => 'Testing Notification',
    'body' => 'TestingNotification from BPIINDIA',
//    'icon' => '',
//    '' => ''
];
$payload = [
    'registration_ids' => $tokens,
    'data' => $msg
];

//<?php

$curl = curl_init();

curl_setopt_array($curl, array(
CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
 CURLOPT_RETURNTRANSFER => true,
 CURLOPT_CUSTOMREQUEST => "POST",
 CURLOPT_POSTFIELDS => json_encode($payload),
 CURLOPT_HTTPHEADER => $header,
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    echo $response;
}
?>

