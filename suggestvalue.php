<?php

ob_start();
include_once 'shreeLib/DBAdapter.php';
include_once 'shreeLib/dbconn.php';
if (isset($_GET['id'])) {
    $dba = new DBAdapter();
    $id = $_GET['id'];

    $data = $dba->getRow("create_item inner join unit_list on create_item.item_unit_id=unit_list.id", array("create_item.id", "unit_list.unit_name"), " create_item.id=" . $id);
    foreach ($data as $subData) {
        $unit_id = $subData[1];
        echo $unit_id;
    }
} elseif (isset($_GET['order_id'])) {
    // print_r($_GET['order_id']);
    $id = $_GET['order_id'];

    $sql = "SELECT purchase_order_item_list.id, purchase_order_item_list.prl_id, item_list.item_code, item_list.item_name, unit_list.unit_name, purchase_order_item_list.item_qnty, purchase_order_item_list.item_rate, purchase_order_item_list.sub_total, purchase_order_item_list.gst, purchase_order_item_list.total,purchase_order_item_list.item_id FROM item_list INNER JOIN purchase_order_item_list ON purchase_order_item_list.item_id = item_list.id INNER JOIN unit_list ON item_list.item_unit_id = unit_list.id WHERE purchase_order_item_list.prl_id = " . $id;

    $resultset = mysqli_query($con, $sql);
    $k = 1;
    while ($rows = mysqli_fetch_array($resultset)) {
        echo "<tr id = 'row" . $k . "' data = 'no'>";
        echo "<input type = 'hidden' id = 'p_id" . $k . "' name = 'p_id[]' value = " . $rows['id'] . ">";
        echo "<input type = 'hidden' id = 'p_qnty" . $k . "' name = 'p_qnty[]' value = " . $rows['item_qnty'] . ">";
        echo "<td><input type = 'checkbox' class = 'case' id = 'check" . $k . "' name = 'check[]' value = " . $k . "></td>";
        echo " <td><input type = 'text' id = 'snum" . $k . "' value = '" . $k . "' class = 'snum' /></td>";
        echo "<td><select onchange = 'getValue(this);' name = 'item_id[]' id = 'item_code" . $k . "' class = 'itemcode' > ";
        $dba = new DBAdapter();
        $Names = $dba->getRow("item_list ", array("id", "item_code"), "1");

        foreach ($Names as $name) {
            echo" <option " . ($name[1] == $rows['item_code'] ? 'selected' : '') . " value = '" . $name[0] . "'>" . $name[1] . "</option> ";
        }
        echo "</select></td>";
        echo "<td><input type = 'text' id = 'item_name" . $k . "' class = 'itemname' name = 'item_name[]' value ='" . $rows['item_name'] . "' required/></td>";
        echo "<td><input type = 'text' id = 'unit" . $k . "' class = 'unit1' name = 'unit[]' value = " . $rows['unit_name'] . " required/></td>";
        echo "<td><input type = 'text' id = 'qnty" . $k . "' class = 'qnty1' name = 'item_qnty[]' value = " . $rows['item_qnty'] . " onchange = 'changeQnty(this);' required /></td>";
        echo "<td><input type = 'text' id = 'rate" . $k . "' class = 'rate1' name = 'item_rate[]' value = " . $rows['item_rate'] . " onchange = 'changerate(this);' required/></td>";
        echo "<td><input type = 'text' id = 'sub_total" . $k . "' class = 'subtotal' name = 'sub_total[]' value = " . $rows['sub_total'] . " required readonly/></td>";
        echo "<td><input type = 'text' id = 'gst" . $k . "' class = 'gst1' name = 'gst[]' value = " . $rows['gst'] . " onchange = 'changegst(this);' required/></td>";
        echo "<td><input type = 'text' id = 'total" . $k . "' class = 'total1' name = 'total[]' value = " . $rows['total'] . " required readonly/></td>";

        $edba = new DBAdapter();
        $field = array("item_stock.qnty");
        $edata = $edba->getRow("purchase_order_item_list INNER JOIN item_stock ON purchase_order_item_list.item_id=item_stock.item_id", $field, "purchase_order_item_list.prl_id = " . $id . " and purchase_order_item_list.item_id =" . $rows['item_id']);

        echo "<td style='border: none;'> <label  class='col-sm-1 control-label' id='itemstock" . $k . "'>" . ($edata[0][0] + $rows['item_qnty']) . "</label> </td>";
        echo "<input type='hidden' id='dbstock" . $k . "' class='dbitemstock' value='" . $edata[0][0] . "'  name='dbitemstock[]' />";
        echo '</tr>';
        $rowcount = mysqli_num_rows($resultset);
        echo "<input type = 'hidden' id = 'item_count' name = 'item_count' value = " . $rowcount . ">";
        $k++;
    }
} elseif (isset($_GET['sales_order_id'])) {

    $id = $_GET['sales_order_id'];

    $sql = "SELECT sales_order_item_list.id, sales_order_item_list.srl_id, item_list.item_code, item_list.item_name, unit_list.unit_name, sales_order_item_list.item_qnty, sales_order_item_list.item_rate, sales_order_item_list.sub_total, sales_order_item_list.gst, sales_order_item_list.total,sales_order_item_list.item_id FROM item_list INNER JOIN sales_order_item_list ON sales_order_item_list.item_id = item_list.id INNER JOIN unit_list ON item_list.item_unit_id = unit_list.id WHERE sales_order_item_list.srl_id = " . $id;
    //print_r($sql);
    $resultset = mysqli_query($con, $sql);
    $k = 1;
    while ($rows = mysqli_fetch_array($resultset)) {
        echo "<tr id = 'row" . $k . "' data = 'no'>";
        echo "<input type = 'hidden' id = 'p_id" . $k . "' name = 'p_id[]' value = " . $rows['id'] . ">";
        echo "<input type = 'hidden' id = 'p_qnty" . $k . "' name = 'p_qnty[]' value = " . $rows['item_qnty'] . ">";
        echo "<td><input type = 'checkbox' class = 'case' id = 'check" . $k . "' name = 'check[]' value = " . $k . "></td>";
        echo " <td><input type = 'text' id = 'snum" . $k . "' value = '" . $k . "' class = 'snum' /></td>";
        echo "<td><select onchange = 'getValue(this);' name = 'item_id[]' id = 'item_code" . $k . "' class = 'itemcode' > ";
        $dba = new DBAdapter();
        $Names = $dba->getRow("item_list", array("id", "item_code"), "1");

        foreach ($Names as $name) {
            echo" <option " . ($name[1] == $rows['item_code'] ? 'selected' : '' ) . " value = '" . $name[0] . "'>" . $name[1] . "</option> ";
        }
        echo "</select></td>";
        echo "<td><input type = 'text' id = 'item_name" . $k . "' class = 'itemname' name = 'item_name[]' value ='" . $rows['item_name'] . "' required/></td>";
        echo "<td><input type = 'text' id = 'unit" . $k . "' class = 'unit1' name = 'unit[]' value = " . $rows['unit_name'] . " required/></td>";
        echo "<td><input type = 'text' id = 'qnty" . $k . "' class = 'qnty1' name = 'item_qnty[]' value = " . $rows['item_qnty'] . " onchange = 'changeQnty(this);' required /></td>";
        echo "<td><input type = 'text' id = 'rate" . $k . "' class = 'rate1' name = 'item_rate[]' value = " . $rows['item_rate'] . " onchange = 'changerate(this);' required/></td>";
        echo "<td><input type = 'text' id = 'sub_total" . $k . "' class = 'subtotal' name = 'sub_total[]' value = " . $rows['sub_total'] . " required readonly/></td>";
        echo "<td><input type = 'text' id = 'gst" . $k . "' class = 'gst1' name = 'gst[]' value = " . $rows['gst'] . " onchange = 'changegst(this);' required/></td>";
        echo "<td><input type = 'text' id = 'total" . $k . "' class = 'total1' name = 'total[]' value = " . $rows['total'] . " required readonly/></td>";

        $edba = new DBAdapter();
        $field = array("item_stock.qnty");
        $edata = $edba->getRow("sales_order_item_list INNER JOIN item_stock ON sales_order_item_list.item_id=item_stock.item_id", $field, "sales_order_item_list.srl_id = " . $id . " and sales_order_item_list.item_id = " . $rows['item_id']);

        echo "<td style='border: none;'> <label  class='col-sm-1 control-label' id='itemstock" . $k . "'>" . ($edata[0][0] - $rows['item_qnty']) . "</label> </td>";
        echo "<input type='hidden' id='dbstock" . $k . "' class='dbitemstock' value='" . $edata[0][0] . "'  name='dbitemstock[]' />";

        echo '</tr>';
        $rowcount = mysqli_num_rows($resultset);
        echo "<input type = 'hidden' id = 'item_count' name = 'item_count' value = " . $rowcount . ">";
        $k ++;
    }
}
?>

