<?php 
//class SendNotification {    
//    private static $API_SERVER_KEY = 'AAAAqDIx5ms:APA91bGsQ9bowqhStmseOIBJ5LlWldA8Uj-ubaeXc4GL0b1RjE-LD91aHI1bo8aLhrhTdDl4zkhDTcvQkcF4Z_s2EaR2KWASnPAv7ftFcxtaHnpQRyz2LezNRMuAjCuODnjU70YhVQbg';
//    private static $is_background = "TRUE";
//    public function __construct() {     
//     
//    }
//    public function sendPushNotificationToFCMSever($token, $message, $notifyID) {
//        $path_to_firebase_cm = 'https://fcm.googleapis.com/fcm/send';
// 
//        $fields = array(
//            'registration_ids' => $token,
//            'priority' => 10,
//            'notification' => array('title' => 'CodeCastra', 'body' =>  $message ,'sound'=>'Default','image'=>'Notification Image' ),
//        );
//        $headers = array(
//            'Authorization:key=' . self::$API_SERVER_KEY,
//            'Content-Type:application/json'
//        );  
//         
//        // Open connection  
//        $ch = curl_init(); 
//        // Set the url, number of POST vars, POST data
//        curl_setopt($ch, CURLOPT_URL, $path_to_firebase_cm); 
//        curl_setopt($ch, CURLOPT_POST, true);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
//        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
//        // Execute post   
//        $result = curl_exec($ch); 
//        // Close connection      
//        curl_close($ch);
//        return $result;
//    }
// }
?>

