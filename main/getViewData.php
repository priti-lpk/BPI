<?php

include_once 'shreeLib/DBAdapter.php';
include_once 'shreeLib/dbconn.php';
// Get View Purchase Data...
if (isset($_GET['user_id'])) {

    $id = $_GET['user_id'];
    // print_r($id);
    $sql = "SELECT role_rights.id,module.mod_name, module.mod_order,role_rights.mod_id,role_rights.role_create,role_rights.role_edit,role_rights.role_view,role_rights.role_delete FROM role_rights INNER JOIN module ON role_rights.mod_id=module.id WHERE role_rights.role_id=" . $id . " order by module.mod_order asc Limit 11";

    $resultset = mysqli_query($con, $sql);
    //print_r($sql);

    while ($rows = mysqli_fetch_array($resultset)) {
        echo " <tr>";
        echo " <input type='hidden'  class='roleid' name='role_id[]' id='role_id' value=" . $rows['id'] . "  />";
        echo "  <td style='text-align:center;'><span id = 'snum'>" . $rows['mod_order'] . "</span></td>";
        echo "  <td style='text-align:center;width: 200px;'>" . $rows['mod_name'] . "</td>";
//        . "<input type='text' id='module_name' class='module_name' name='mod_name[]' value='" . $rows['mod_name'] . "' /></td>";
        echo " <input type='hidden' id='mod_id' class='module_name' name='mod_id[]' value=" . $rows['mod_id'] . " />";
        echo " <td style='text-align:center;width: 100px;'><input type = 'checkbox'" . (1 == $rows['role_create'] ? "checked='checked'" : '') . " class = 'create' name='role_create[" . $rows['mod_order'] . "]'  /></td>";
        echo " <td style='text-align:center;width: 100px;'><input type = 'checkbox'" . (1 == $rows['role_edit'] ? "checked='checked'" : '') . " class = 'edit' id=edit" . $rows['mod_id'] . " name='role_edit[" . $rows['mod_order'] . "]' onclick=edit(" . $rows['mod_id'] . ")  /></td>";
        echo " <td style='text-align:center;width: 80px;'><input type = 'checkbox'" . (1 == $rows['role_view'] ? "checked='checked'" : '') . " class = 'view' id=view" . $rows['mod_id'] . " name='role_view[" . $rows['mod_order'] . "]' onclick=view(" . $rows['mod_id'] . ") /></td>";
        echo "  <td style='text-align:center;width: 80px;'><input type = 'checkbox'" . (1 == $rows['role_delete'] ? "checked='checked'" : '') . " class = 'delete1' name='role_delete[" . $rows['mod_order'] . "]' /></td>";
        echo "  </tr>";
    }
}
?>
