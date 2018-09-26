<?php

include 'shreeLib/dbconn.php';
include_once 'shreeLib/DBAdapter.php';
$dba = new DBAdapter();
if (!isset($_SESSION)) {
    session_start();
}

$last_id1 = $dba->getLastID("id", "create_branch", "1");

echo ' <select name="branch_id" id="create_branch" class="select2" required> ';
echo '<option>Select Branch</option>';

$data = $dba->getRow("create_branch", array("id", "branch_name"), "create_branch.branch_status='true'");

foreach ($data as $subData) {

    echo" <option " . ($subData[0] == $last_id1 ? 'selected' : '') . " value='" . $subData[0] . "'>" . $subData[1] . "</option> ";
}

echo '</select>';
//}
?>
