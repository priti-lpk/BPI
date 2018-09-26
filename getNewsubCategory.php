<?php
ob_start();
include 'shreeLib/dbconn.php';
include_once 'shreeLib/DBAdapter.php';

    if (!isset($_SESSION)) {
        session_start();
    }
   
    $dba = new DBAdapter();
    $last_id1 = $dba->getLastID("id", "sub_category", "1");

    echo '  <select name="sub_cat_id" id="sub_category" class="select2" required> ';
    echo '<option>Select Category</option>';
   
    //$last_id = $dba->getLastID("branch_id", "system_user", "id=" . $_SESSION['user_id']);
    $data = $dba->getRow("sub_category", array("id", "sub_cat_name"), "1");
    print_r($data);
    foreach ($data as $subData) {

        echo" <option " . ($subData[0] == $last_id1 ? 'selected' : '') . " value='" . $subData[0] . "'>" . $subData[1] . "</option> ";
    }

    echo '</select>';
?>



