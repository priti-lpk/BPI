<?php
ob_start();
include 'shreeLib/dbconn.php';
include_once 'shreeLib/DBAdapter.php';

//    if (!isset($_SESSION)) {
//        session_start();
//    }
   
    $dba = new DBAdapter();
    $last_id1 = $dba->getLastID("id", "main_category", "1");

    echo '<select name="main_cat_id" id="main_category" class="form-control select2" required> ';
    echo '<option>Select Category</option>';
  
    $data = $dba->getRow("main_category", array("id", "name"), "1");
   // print_r($data);
    foreach ($data as $subData) {

        echo" <option " . ($subData[0] == $last_id1 ? 'selected' : '') . " value='" . $subData[0] . "'>" . $subData[1] . "</option> ";
    }

    echo '</select>';
?>

