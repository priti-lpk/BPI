<?php
ob_start();
include 'shreeLib/dbconn.php';
include_once 'shreeLib/DBAdapter.php';

    if (!isset($_SESSION)) {
        session_start();
    }
   
    $dba = new DBAdapter();
    $last_id1 = $dba->getLastID("id", "create_party", "1");
   // print_r($last_id1);
    echo ' <select name = "party_id" id = "create_party" class = "form-control select2" required> ';
    echo '<option>Select Party</option>';
   
    $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);
    $data = $dba->getRow("create_party", array("id", "party_name"), "1");

    foreach ($data as $subData) {

        echo" <option " . ($subData[0] == $last_id1 ? 'selected' : '') . " value='" . $subData[0] . "'>" . $subData[1] . "</option> ";
    }

    echo '</select>';

?>

