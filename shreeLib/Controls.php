<?php
ob_start();
class Controls {

    //put your code here

    function uploadFile($filename, $fileType, $destPath, $myName) {

        if (is_uploaded_file($_FILES[$filename]['tmp_name'])) {

            $path = $_FILES[$filename]['name'];

            $ext = pathinfo($path, PATHINFO_EXTENSION);

            if (in_array($ext, $fileType)) {

                $myName = $myName . "." . $ext;

                $destPath = $destPath . $myName;

                if (move_uploaded_file($_FILES[$filename]['tmp_name'], $destPath)) {

                    $result = array(true, $myName, "Upload Successfully");

                    return $result;
                } else {

                    $result = array(FALSE, "File upload fail!");

                    return $result;
                }
            } else {

                $result = array(false, "File type not supported");

                return $result;
            }
        } else {

            $result = array(false, "File read fail");

            return $result;
        }
    }

    function get_client_ip() {

        $ipaddress = '';

        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];

        else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];

        else if (isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];

        else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];

        else if (isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];

        else if (isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';

        return $ipaddress;
    }

    function sendsms($mobileNumber, $senderId, $routeId, $message, $serverUrl, $authKey) {

        $getData = 'mobileNos=' . $mobileNumber . '&message=' . urlencode($message) . '&senderId=' . $senderId . '&routeId=' . $routeId;

        //API URL

        $url = "http://" . $serverUrl . "/rest/services/sendSMS/sendGroupSms?AUTH_KEY=" . $authKey . "&" . $getData;

        // init the resource

        $ch = curl_init();

        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0
        ));

        //get response

        $output = curl_exec($ch);

        //Print error if any

        if (curl_errno($ch)) {

            echo 'error:' . curl_error($ch);
        }

        curl_close($ch);
        //echo $output;
        return $output;
    }
}

//    function sendSMS($msg, $mob_number) {
//       // echo $msg;
//        $curl = curl_init();
//
//        curl_setopt_array($curl, array(
//            CURLOPT_PORT => "8080",
//            CURLOPT_URL => "http://sms.shreesoftech.com/rest/services/sendSMS/sendGroupSms?AUTH_KEY=27a97f896f4d26c7ec084ffa4b4a69&message=" . $msg . "&senderId=DEMOOS&routeId=1&mobileNos=" . $mob_number . "&smsContentType=english",
//            CURLOPT_RETURNTRANSFER => true,
//            CURLOPT_ENCODING => "",
//            CURLOPT_MAXREDIRS => 10,
//            CURLOPT_TIMEOUT => 30,
//            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//            CURLOPT_CUSTOMREQUEST => "GET",
//            CURLOPT_HTTPHEADER => array(
//                "Cache-Control: no-cache"
//            ),
//        ));
//
//        $response = curl_exec($curl);
////        echo $response;
//        $err = curl_error($curl);
//
//        curl_close($curl);
//
//        if ($err) {
//            echo "cURL Error #:" . $err;
//        } else {
//            echo $response;
//        }
//    }
  //  }
    ?>



