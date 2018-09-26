<?php
ob_start();
if (!isset($_SESSION)) {
    session_start();
}

//session_start();
//echo $_SERVER['REQUEST_URI'];

if (!isset($_SESSION['user_id'])) {
    header('Location:index.php');
} elseif (isset($_SESSION['user_id'])) {
    include 'dbconn.php';
    $uid = $_SESSION['user_id'];
    //print_r($uid);
    $sql = "SELECT module.mod_name,module.mod_pagename FROM role_rights INNER JOIN  module ON role_rights.mod_id= module.id WHERE ((role_rights.role_create=1 and role_rights.role_view=0) or (role_rights.role_create=1 and role_rights.role_view=1) or (role_rights.role_create=0 and role_rights.role_view=1) ) and role_rights.user_id=" . $_SESSION['user_id'] . " order by module.id";
    $result = mysqli_query($con, $sql);
    // print_r($sql);
//    $servername = $_SERVER['REQUEST_URI'];
    $mod_name = "";
    $servername1 = basename($_SERVER['PHP_SELF']);

    while ($row = mysqli_fetch_array($result)) {
        $uid = $row['mod_pagename'];

        if ($uid == $servername1) {
            $mod_name = $row['mod_pagename'];
        }
    }
    if ($servername1 == 'chang_pass.php') {
        
    } else {
        if ($mod_name == $servername1) {
            
        } else {

            header("Location:Dashboard.php");
        }
    }
}
?>
