<?php

ob_start();
if (!isset($_SESSION)) {
    session_start();
}


if (!isset($_SESSION['user_id'])) {
    header('Location:index.php');
} elseif (isset($_SESSION['user_id'])) {
//    include 'dbconn.php';
    $uid = $_SESSION['user_id'];
    include_once 'DBAdapter.php';
    include_once 'dbconn.php';
    $dba = new DBAdapter();

    $data = $dba->getLastID("roles_id", "create_user", "id=" . $_SESSION['user_id']);
//echo'<br><Br><br>';
    //print_r($data);

    $sql = "SELECT module.mod_name,module.mod_pagename,module.id FROM role_rights INNER JOIN module ON role_rights.mod_id= module.id WHERE ((role_rights.role_create=1 and role_rights.role_view=0) or (role_rights.role_create=1 and role_rights.role_view=1) or (role_rights.role_create=0 and role_rights.role_view=1) ) and role_rights.role_id=" . $data . " order by module.mod_order";
    $result = mysqli_query($con, $sql);
//    print_r($sql);
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
