<?php
ob_start();
include_once 'shreeLib/DBAdapter.php';
include_once 'shreeLib/dbconn.php';
if (!isset($_SESSION)) {
    session_start();
}
$dba = new DBAdapter();
$last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);
if (isset($_GET['inq_id'])) {

    $id = $_GET['inq_id'];
    $sql = "SELECT inquiry_item_list.id,inquiry_item_list.inq_id,create_item.item_name,inquiry_item_list.item_unit,inquiry_item_list.item_quantity,inquiry_item_list.remark,inquiry_item_list.item_id FROM create_item INNER JOIN inquiry_item_list ON inquiry_item_list.item_id = create_item.id WHERE inquiry_item_list.inq_id=" . $id;
    $resultset = mysqli_query($con, $sql);
    $k = 1;
    while ($rows = mysqli_fetch_array($resultset)) {
        echo "<tr id='row" . $k . "' data='yes'>";
        echo "<input type='hidden' id='i_id" . $k . "' name='i_id[]' value=" . $rows['id'] . ">";
        echo "<td><input type = 'checkbox' class = 'case' id='check" . $k . "' name='check[]' value=" . $k . "></td>";
        echo " <td><input type='text' id = 'snum" . $k . "' value='" . $k . "' class='snum' /></td>";
        echo "<td><select style='width:300px;' onchange='getValue(this);'  name='item_id[]' id = 'item_code" . $k . "' class ='form-control select2 chosen' > <option>Select Item</option>";
        $dba = new DBAdapter();
        $Names = $dba->getRow("create_item INNER JOIN main_category ON create_item.cat_id=main_category.id", array("create_item.id", "create_item.item_name"), "1 order by create_item.id asc");

        foreach ($Names as $name) {
            echo" <option " . ($name[1] == $rows['item_name'] ? 'selected' : '') . " value='" . $name[0] . "'>" . $name[1] . "</option> ";
        }
        echo "</select></td>";
        echo "<td><input type='text' id='unit" . $k . "' class='unit1' name='item_unit[]' value=" . $rows['item_unit'] . " required/></td>";
        echo "<td><input type='text' id='qnty" . $k . "' class='qnty1' name='item_quantity[]' value=" . $rows['item_quantity'] . " onchange='changeQnty(this);' required /></td>";
        echo "<td><input type='text' id='remark" . $k . "' class='remark1' name='remark[]' value='" . $rows['remark'] . "' /></td>";

        $k++;
    }
    // Get View Purchase Order Data...
}
//elseif (isset($_GET['inq_main_id'])) {
//
//    $id = $_GET['inq_id'];
//    $sql = "SELECT inquiry_item_list.id,inquiry_item_list.inq_id,create_item.item_name,inquiry_item_list.item_unit,inquiry_item_list.item_quantity,inquiry_item_list.remark,inquiry_item_list.item_id FROM create_item INNER JOIN inquiry_item_list ON inquiry_item_list.item_id = create_item.id WHERE inquiry_item_list.inq_id=" . $id;
//    $resultset = mysqli_query($con, $sql);
//    $k = 1;
//    while ($rows = mysqli_fetch_array($resultset)) {
//        echo "<tr id='row" . $k . "' data='yes'>";
//        echo "<input type='hidden' id='i_id" . $k . "' name='i_id[]' value=" . $rows['id'] . ">";
//        echo "<input type='hidden' id='i_quantity" . $k . "' name='i_quantity[]' value=" . $rows['item_quantity'] . ">";
//        echo "<td><input type = 'checkbox' class = 'case' id='check" . $k . "' name='check[]' value=" . $k . "></td>";
//        echo " <td><input type='text' id = 'snum" . $k . "' value='" . $k . "' class='snum' /></td>";
//        echo "<td><select style='width:300px;' onchange='getValue(this);'  name='item_id[]' id = 'item_code" . $k . "' class ='change_item_dropdown_ajax' > <option>Select Item</option>";
//        $dba = new DBAdapter();
//        $Names = $dba->getRow("create_item INNER JOIN main_category ON create_item.cat_id=main_category.id", array("create_item.id", "create_item.item_name"), "main_category.branch_id=" . $last_id . " order by create_item.id asc");
//
//        foreach ($Names as $name) {
//            echo" <option " . ($name[1] == $rows['item_name'] ? 'selected' : '') . " value='" . $name[0] . "'>" . $name[1] . "</option> ";
//        }
//        echo "</select></td>";
//        echo "<td><input type='text' id='unit" . $k . "' class='unit1' name='item_unit[]' value=" . $rows['item_unit'] . " required/></td>";
//        echo "<td><input type='text' id='qnty" . $k . "' class='qnty1' name='item_quantity[]' value=" . $rows['item_quantity'] . " onchange='changeQnty(this);' required /></td>";
//        echo "<td><input type='text' id='remark" . $k . "' class='remark1' name='remark[]' value='" . $rows['remark'] . "' required /></td>";
//
//        $k++;
//    }
//    // Get View Purchase Order Data...
//}

//elseif (isset($_GET['pr_id'])) {
//    if (!isset($_SESSION)) {
//        session_start();
//    }
//    $userid = $_SESSION['user_id'];
//
//    $id = $_GET['pr_id'];
//    $firstdate = $_GET['f_date'];
//    $lastdate = $_GET['l_date'];
//
//    $del = $_GET['dt_data'];
//    $edit = $_GET['ed_data'];
//    $pur_create = $_GET['purcs_create'];
//
//    $sql = "SELECT purchase_order_list.id,party_list.party_name,purchase_order_list.total_amount,purchase_order_list.note,purchase_order_list.user_id FROM purchase_order_list INNER JOIN party_list ON party_list.id = purchase_order_list.party_id WHERE purchase_order_list.pl_date >='" . $firstdate . "' AND purchase_order_list.pl_date <='" . $lastdate . "' AND  purchase_order_list.party_id=" . $id . " and party_list.branch_id=" . $last_id." AND purchase_order_list.order_status='Pending'";
//
//    $resultset = mysqli_query($con, $sql);
//    while ($rows = mysqli_fetch_array($resultset)) {
////        $uid = $rows['user_id'];
////        if ($uid == $userid) {
//        echo "<tr>";
//        echo "<td>" . $rows['id'] . "</td>";
//        echo "<td>" . $rows['party_name'] . "</td>";
//        echo "<td>" . $rows['total_amount'] . "</td>";
//        echo "<td>" . $rows['note'] . "</td>";
//        if ($edit == 1) {
//            echo "<td><a href='AddPurchaseOrder.php?type=edit&id=" . $rows[0] . "' class='btn btn-primary' id='" . $rows[0] . "'><i class='fa fa-edit'></i> Edit</a></td>";
//        }
//
//        if ($del == 1) {
//            echo "<td><button class='btn btn-danger' id='" . $rows[0] . "' onclick='SetForDelete(this.id);'><i class='fa fa-trash-o'></i>Delete</button></td>";
//        }
//        if ($pur_create == 1) {
//            echo "<td><a href='AddPurchaseList.php?order_id=" . $rows[0] . "' class='btn btn-primary' id='" . $rows[0] . "'><i class='fa fa-save'></i> Purchase Now..</a></td>";
//        }
//        //echo "<td><a href='AddPurchaseOrder.php?type=edit&id=" . $rows[0] . "' class='btn btn-primary' id='" . $rows[0] . "'><i class='fa fa-edit'></i> Edit</a> <button class='btn btn-danger' id='" . $rows[0] . "' onclick='SetForDelete(this.id);'><i class='fa fa-trash-o'></i>Delete</button> <a href='AddPurchaseList.php?order_id=" . $rows[0] . "' class='btn btn-primary' id='" . $rows[0] . "'><i class='fa fa-save'></i> Purchase Now..</a></td></tr>";
//        echo '</tr>';
////        }
//    }
//    // Get View Purchase Item Order Data...
//} elseif (isset($_GET['prl_id'])) {
//    $id = $_GET['prl_id'];
//
//    $sql = "SELECT purchase_order_item_list.id,purchase_order_item_list.prl_id,item_list.item_code,item_list.item_name,unit_list.unit_name,purchase_order_item_list.item_qnty,purchase_order_item_list.item_rate,purchase_order_item_list.sub_total,purchase_order_item_list.gst,purchase_order_item_list.total,purchase_order_item_list.item_id FROM item_list INNER JOIN purchase_order_item_list ON purchase_order_item_list.item_id = item_list.id INNER JOIN unit_list ON item_list.item_unit_id= unit_list.id WHERE purchase_order_item_list.prl_id=" . $id;
//
//    $resultset = mysqli_query($con, $sql);
//    $k = 1;
//    while ($rows = mysqli_fetch_array($resultset)) {
//        echo "<tr id='row" . $k . "' data='yes'>";
//        echo "<input type='hidden' id='pr_id" . $k . "' name='pr_id[]' value=" . $rows['id'] . ">";
//        echo "<input type='hidden' id='pr_qnty" . $k . "' name='pr_qnty[]' value=" . $rows['item_qnty'] . ">";
//        echo "<td><input type = 'checkbox' class = 'case' id='check" . $k . "' name='check[]' value=" . $k . "></td>";
//        echo " <td><input type='text' id = 'snum" . $k . "' value='" . $k . "' class='snum' /></td>";
//        echo "<td><select onchange='getValue(this);'  name='item_id[]' id = 'item_code" . $k . "' class ='itemcode' > <option>Select Item</option>";
//        $dba = new DBAdapter();
//        $Names = $dba->getRow("item_list INNER JOIN category_list ON item_list.category_id=category_list.id", array("item_list.id", "item_list.item_code"), "category_list.branch_id=" . $last_id . " order by item_list.id asc");
//
//        foreach ($Names as $name) {
//            echo" <option " . ($name[1] == $rows['item_code'] ? 'selected' : '') . " value='" . $name[0] . "'>" . $name[1] . "</option> ";
//        }
//        echo "</select></td>";
//        echo "<td><input type='text' id='item_name" . $k . "' class='itemname' name='item_name[]' value='" . $rows['item_name'] . "' required/></td>";
//        echo "<td><input type='text' id='unit" . $k . "' class='unit1' name='unit[]' value=" . $rows['unit_name'] . " required/></td>";
//        echo "<td><input type='text' id='qnty" . $k . "' class='qnty1' name='item_qnty[]' value=" . $rows['item_qnty'] . " onchange='changeQnty(this);' required /></td>";
//        echo "<td><input type='text' id='rate" . $k . "' class='rate1' name='item_rate[]' value=" . $rows['item_rate'] . " onchange='changerate(this);' required/></td>";
//        echo "<td><input type='text' id='sub_total" . $k . "' class='subtotal' name='sub_total[]' value=" . $rows['sub_total'] . " required readonly/></td>";
//        echo "<td><input type='text' id='gst" . $k . "' class='gst1' name='gst[]' value=" . $rows['gst'] . " onchange='changegst(this);' required/></td>";
//        echo "<td><input type='text' id='total" . $k . "' class='total1' name='total[]' value=" . $rows['total'] . " required readonly/></td>";
//       
//        $edba = new DBAdapter();
//        $field = array("item_stock.qnty");
//        $edata = $edba->getRow("purchase_order_item_list INNER JOIN item_stock ON purchase_order_item_list.item_id=item_stock.item_id", $field, "purchase_order_item_list.prl_id = " . $id . " and purchase_order_item_list.item_id =" . $rows['item_id']);
//
//        echo "<td style='border: none;'> <label  class='col-sm-1 control-label' id='itemstock" . $k . "'>" . ($edata[0][0] + $rows['item_qnty']) . "</label> </td>";
//        echo "<input type='hidden' id='dbstock" . $k . "' class='dbitemstock' value='" . $edata[0][0] . "'  name='dbitemstock[]' />";
//        
//        echo '</tr>';
//        $rowcount = mysqli_num_rows($resultset);
//        echo "<input type='hidden' id='item_count' name='item_count' value=" . $rowcount . ">";
//        $k++;
//    }
//    // Get View Sales Return Data...
//} elseif (isset($_GET['sr_id'])) {
//
//    if (!isset($_SESSION)) {
//        session_start();
//    }
//    $userid = $_SESSION['user_id'];
//    $id = $_GET['sr_id'];
//    $firstdate = $_GET['f_date'];
//    $lastdate = $_GET['l_date'];
//    $del = $_GET['dt_data'];
//    $edit = $_GET['ed_data'];
//
//    include_once("shreeLib/dbconn.php");
//    $sql = "SELECT sales_return.id,party_list.party_name,sales_return.total_amount,sales_return.pay_type,sales_return.note, sales_return.user_id FROM sales_return INNER JOIN party_list ON party_list.id = sales_return.party_id WHERE sales_return.sale_date >='" . $firstdate . "' AND sales_return.sale_date <='" . $lastdate . "' AND  sales_return.party_id=" . $id . " and party_list.branch_id=" . $last_id;
//    $resultset = mysqli_query($con, $sql);
//    while ($rows = mysqli_fetch_array($resultset)) {
////        $uid = $rows['user_id'];
////        if ($uid == $userid) {
//        echo "<tr>";
//        echo "<td>" . $rows['id'] . "</td>";
//        echo "<td>" . $rows['party_name'] . "</td>";
//        echo "<td>" . $rows['total_amount'] . "</td>";
//        echo "<td>" . $rows['pay_type'] . "</td>";
//        echo "<td>" . $rows['note'] . "</td>";
//
//        if ($edit == 1) {
//            echo "<td><a href='AddSalesReturn.php?type=edit&id=" . $rows[0] . "' class='btn btn-primary' id='" . $rows[0] . "'><i class='fa fa-edit'></i> Edit</a></td>";
//        }
//
//        if ($del == 1) {
//            echo "<td><button class='btn btn-danger' id='" . $rows[0] . "' onclick='SetForDelete(this.id);'><i class='fa fa-trash-o'>Delete</button></td>";
//        }
//        //  echo "<td><a href='AddSalesReturn.php?type=edit&id=" . $rows[0] . "' class='btn btn-primary' id='" . $rows[0] . "'><i class='fa fa-edit'></i> Edit</a> <button class='btn btn-danger' id='" . $rows[0] . "' onclick='SetForDelete(this.id);'><i class='fa fa-trash-o'>Delete</button></td>";
//
//        echo '</tr>';
//        // }
//    }
//    // Get View Sales Items Return Data...
//} elseif (isset($_GET['sales_return_id'])) {
//    $id = $_GET['sales_return_id'];
//    print_r($id);
//    $sql = "SELECT sales_return_item_list.id,sales_return_item_list.sr_id,item_list.item_code,item_list.item_name,unit_list.unit_name,sales_return_item_list.item_qnty,sales_return_item_list.item_rate,sales_return_item_list.sub_total,sales_return_item_list.gst,sales_return_item_list.total,sales_return_item_list.item_id FROM item_list INNER JOIN sales_return_item_list ON sales_return_item_list.item_id = item_list.id INNER JOIN unit_list ON item_list.item_unit_id= unit_list.id WHERE sales_return_item_list.sr_id=" . $id;
//    $resultset = mysqli_query($con, $sql);
//    print_r($sql);
//    $k = 1;
//    while ($rows = mysqli_fetch_array($resultset)) {
//        $rowcount = mysqli_num_rows($resultset);
//        //print_r($rowcount);
//        echo "<tr id='row" . $k . "' data='yes'>";
//        echo "<input type='hidden' id='sr_id" . $k . "' name='sr_id[]' value=" . $rows['id'] . ">";
//        echo "<input type='hidden' id='sr_qnty" . $k . "' name='sr_qnty[]' value=" . $rows['item_qnty'] . ">";
//        echo "<td><input type = 'checkbox' class = 'case' id='check" . $k . "' name='check[]' value=" . $k . "></td>";
//        echo " <td><input type='text' id = 'snum" . $k . "' value='" . $k . "' class='snum' /></td>";
//        echo "<td><select onchange='getValue(this);'  name='item_id[]' id = 'item_code" . $k . "' class ='itemcode' > <option>Select Item</option>";
//        $dba = new DBAdapter();
//        $Names = $dba->getRow("item_list INNER JOIN category_list ON item_list.category_id=category_list.id", array("item_list.id", "item_list.item_code"), "category_list.branch_id=" . $last_id . " order by item_list.id asc");
//
//        foreach ($Names as $name) {
//            echo" <option " . ($name[1] == $rows['item_code'] ? 'selected' : '') . " value='" . $name[0] . "'>" . $name[1] . "</option> ";
//        }
//        echo "</select></td>";
//        echo "<td><input type='text' id='item_name" . $k . "' class='itemname' name='item_name[]' value='" . $rows['item_name'] . "' required/></td>";
//        echo "<td><input type='text' id='unit" . $k . "' class='unit1' name='unit[]' value=" . $rows['unit_name'] . " required/></td>";
//        echo "<td><input type='text' id='qnty" . $k . "' class='qnty1' name='item_qnty[]' value=" . $rows['item_qnty'] . " onchange='changeQnty(this);' required /></td>";
//        echo "<td><input type='text' id='rate" . $k . "' class='rate1' name='item_rate[]' value=" . $rows['item_rate'] . " onchange='changerate(this);' required/></td>";
//        echo "<td><input type='text' id='sub_total" . $k . "' class='subtotal' name='sub_total[]' value=" . $rows['sub_total'] . " required readonly/></td>";
//        echo "<td><input type='text' id='gst" . $k . "' class='gst1' name='gst[]' value=" . $rows['gst'] . " onchange='changegst(this);' required/></td>";
//        echo "<td><input type='text' id='total" . $k . "' class='total1' name='total[]' value=" . $rows['total'] . " required readonly/></td>";
//       
//         $edba = new DBAdapter();
//        $field = array("item_stock.qnty");
//        $edata = $edba->getRow("sales_return_item_list INNER JOIN item_stock ON sales_return_item_list.item_id=item_stock.item_id", $field, "sales_return_item_list.sr_id = " . $id . " and sales_return_item_list.item_id = " . $rows['item_id']);
//
//        echo "<td style='border: none;'> <label  class='col-sm-1 control-label' id='itemstock" . $k . "'>" . ($edata[0][0] - $rows['item_qnty']) . "</label> </td>";
//        echo "<input type='hidden' id='dbstock" . $k . "' class='dbitemstock' value='" . $edata[0][0] . "'  name='dbitemstock[]' />";
//        
//        echo '</tr>';
//        $rowcount = mysqli_num_rows($resultset);
//        echo "<input type='hidden' id='item_count' name='item_count' value=" . $rowcount . ">";
//        $k++;
//    }
//    // Get View Sales Data...
//} elseif (isset($_GET['s_id'])) {
//
//    if (!isset($_SESSION)) {
//        session_start();
//    }
//    $userid = $_SESSION['user_id'];
//    $id = $_GET['s_id'];
//    $firstdate = $_GET['f_date'];
//    $lastdate = $_GET['l_date'];
//    $del = $_GET['dt_data'];
//    $edit = $_GET['ed_data'];
//
//    include_once("shreeLib/dbconn.php");
//    $sql = "SELECT sales_list.id,party_list.party_name,sales_list.total_amount,sales_list.pay_type,sales_list.note, sales_list.user_id FROM sales_list INNER JOIN party_list ON party_list.id = sales_list.party_id WHERE sales_list.sale_date >='" . $firstdate . "' AND sales_list.sale_date <='" . $lastdate . "' AND  sales_list.party_id=" . $id . " and party_list.branch_id=" . $last_id;
//    $resultset = mysqli_query($con, $sql);
//
//    while ($rows = mysqli_fetch_array($resultset)) {
////        $uid = $rows['user_id'];
////        if ($uid == $userid) {
//        echo "<tr>";
//        echo "<td>" . $rows['id'] . "</td>";
//        echo "<td>" . $rows['party_name'] . "</td>";
//        echo "<td>" . $rows['total_amount'] . "</td>";
//        echo "<td>" . $rows['pay_type'] . "</td>";
//        echo "<td>" . $rows['note'] . "</td>";
//        if ($edit == 1) {
//            echo "<td><a href='AddSalesList.php?type=edit&id=" . $rows[0] . "' class='btn btn-primary' id='" . $rows[0] . "' onclick='SetForEdit(this)'><i class='fa fa-edit'></i> Edit</a></td>";
//        }
//
//        if ($del == 1) {
//            echo "<td><button class='btn btn-danger' id='" . $rows[0] . "' onclick='SetForDelete(this.id);'><i class='fa fa-trash-o'></i>  Delete</button></td>";
//        }
//        echo "<td><a href='Print_Invoice.php?id=" . $rows[0] . "' target='_blank' class='btn btn-primary' id='" . $rows[0] . "' onclick='SetForEdit(this)'><i class='fa fa-print'></i> Print</a></td>";
//        // echo "<td><a href='AddSalesList.php?type=edit&id=" . $rows[0] . "' class='btn btn-primary' id='" . $rows[0] . "' onclick='SetForEdit(this)'><i class='fa fa-edit'></i> Edit</a> <button class='btn btn-danger' id='" . $rows[0] . "' onclick='SetForDelete(this.id);'><i class='fa fa-trash-o'></i>  Delete</button> <a href='Print_Invoice.php?id=" . $rows[0] . "' class='btn btn-primary' id='" . $rows[0] . "' onclick='SetForEdit(this)'><i class='fa fa-print'></i> Print</a></td></tr>";
//        echo "</tr>";
//        // }
//    }
//    // Get View Sales Item Data...
//} elseif (isset($_GET['sales_id'])) {
//
//    $id = $_GET['sales_id'];
//
//    $sql = "SELECT sales_item_list.id,sales_item_list.sl_id,item_list.item_code,item_list.item_name,unit_list.unit_name,sales_item_list.item_qnty,sales_item_list.item_rate,sales_item_list.sub_total,sales_item_list.gst,sales_item_list.total, sales_item_list.item_id FROM item_list INNER JOIN sales_item_list ON sales_item_list.item_id = item_list.id INNER JOIN unit_list ON item_list.item_unit_id= unit_list.id WHERE sales_item_list.sl_id=" . $id;
//    $resultset = mysqli_query($con, $sql);
//    $k = 1;
//    while ($rows = mysqli_fetch_array($resultset)) {
//        echo "<tr id='row" . $k . "' data='yes'>";
//        echo "<input type='hidden' id='s_id" . $k . "' name='s_id[]' value=" . $rows['id'] . ">";
//        echo "<input type='hidden' id='s_qnty" . $k . "' name='s_qnty[]' value=" . $rows['item_qnty'] . ">";
//        echo "<td><input type = 'checkbox' class = 'case' id='check" . $k . "' name='check[]' value=" . $k . "></td>";
//        echo " <td><input type='text' id = 'snum" . $k . "' value='" . $k . "' class='snum' /></td>";
//        echo "<td><select onchange='getValue(this);'  name='item_id[]' id = 'item_code" . $k . "' class ='itemcode' > <option>Select Item</option>";
//        $dba = new DBAdapter();
//        $Names = $dba->getRow("item_list INNER JOIN category_list ON item_list.category_id=category_list.id", array("item_list.id", "item_list.item_code"), "category_list.branch_id=" . $last_id . " order by item_list.id asc");
//
//        foreach ($Names as $name) {
//            echo" <option " . ($name[1] == $rows['item_code'] ? 'selected' : '') . " value='" . $name[0] . "'>" . $name[1] . "</option> ";
//        }
//        echo "</select></td>";
//        echo "<td><input type='text' id='item_name" . $k . "' class='itemname' name='item_name[]' value='" . $rows['item_name'] . "' required/></td>";
//        echo "<td><input type='text' id='unit" . $k . "' class='unit1' name='unit[]' value=" . $rows['unit_name'] . " required/></td>";
//        echo "<td><input type='text' id='qnty" . $k . "' class='qnty1' name='item_qnty[]' value=" . $rows['item_qnty'] . " onchange='changeQnty(this);' required /></td>";
//        echo "<td><input type='text' id='rate" . $k . "' class='rate1' name='item_rate[]' value=" . $rows['item_rate'] . " onchange='changerate(this);' required/></td>";
//        echo "<td><input type='text' id='sub_total" . $k . "' class='subtotal' name='sub_total[]' value=" . $rows['sub_total'] . " required readonly/></td>";
//        echo "<td><input type='text' id='gst" . $k . "' class='gst1' name='gst[]' value=" . $rows['gst'] . " onchange='changegst(this);' required/></td>";
//        echo "<td><input type='text' id='total" . $k . "' class='total1' name='total[]' value=" . $rows['total'] . " required readonly/></td>";
//       
//         $edba = new DBAdapter();
//        $field = array("item_stock.qnty");
//        $edata = $edba->getRow("sales_item_list INNER JOIN item_stock ON sales_item_list.item_id=item_stock.item_id", $field, "sales_item_list.srl_id = " . $id . " and sales_item_list.item_id = " . $rows['item_id']);
//
//        echo "<td style='border: none;'> <label  class='col-sm-1 control-label' id='itemstock" . $k . "'>" . ($edata[0][0] - $rows['item_qnty']) . "</label> </td>";
//        echo "<input type='hidden' id='dbstock" . $k . "' class='dbitemstock' value='" . $edata[0][0] . "'  name='dbitemstock[]' />";
//        
//        echo '</tr>';
//        $rowcount = mysqli_num_rows($resultset);
//        echo "<input type='hidden' id='item_count' name='item_count' value=" . $rowcount . ">";
//        $k++;
//    }
//    // Get View Sales Order Data...
//} elseif (isset($_GET['so_id'])) {
//
//    if (!isset($_SESSION)) {
//        session_start();
//    }
//    $userid = $_SESSION['user_id'];
//    $id = $_GET['so_id'];
//    $firstdate = $_GET['f_date'];
//    $lastdate = $_GET['l_date'];
//    $del = $_GET['dt_data'];
//    $edit = $_GET['ed_data'];
//    $pur_create = $_GET['sale_create'];
//
//    $sql = "SELECT sales_order_list.id,party_list.party_name,sales_order_list.total_amount,sales_order_list.note, sales_order_list.user_id FROM sales_order_list INNER JOIN party_list ON party_list.id = sales_order_list.party_id WHERE sales_order_list.sale_date >='" . $firstdate . "' AND sales_order_list.sale_date <='" . $lastdate . "' AND  sales_order_list.party_id=" . $id . " and party_list.branch_id=" . $last_id." AND sales_order_list.order_status='Pending'";
//
//    $resultset = mysqli_query($con, $sql);
//    while ($rows = mysqli_fetch_array($resultset)) {
////        $uid = $rows['user_id'];
////        if ($uid == $userid) {
//        echo "<tr>";
//        echo "<td>" . $rows['id'] . "</td>";
//        echo "<td>" . $rows['party_name'] . "</td>";
//        echo "<td>" . $rows['total_amount'] . "</td>";
//
//        echo "<td>" . $rows['note'] . "</td>";
//
//        if ($edit == 1) {
//            echo "<td><a href='AddSalesOrder.php?type=edit&id=" . $rows[0] . "' class='btn btn-primary' id='" . $rows[0] . "'><i class='fa fa-edit'></i> Edit</a></td>";
//        }
//
//        if ($del == 1) {
//            echo "<td><button class='btn btn-danger' id='" . $rows[0] . "' onclick='SetForDelete(this.id);'><i class='fa fa-trash-o'></i>Delete</button></td>";
//        }
//        if ($pur_create == 1) {
//            echo "<td><a href='AddSalesList.php?order_id=" . $rows[0] . "' class='btn btn-primary' id='" . $rows[0] . "'><i class='fa fa-save'></i> Sales Now..</a></td>";
//        }
//
//        // echo "<td><a href='AddsalesOrder.php?type=edit&id=" . $rows[0] . "' class='btn btn-primary' id='" . $rows[0] . "'><i class='fa fa-edit'></i> Edit</a> <button class='btn btn-danger' id='" . $rows[0] . "' onclick='SetForDelete(this.id);'><i class='fa fa-trash-o'></i>Delete</button> <a href='AddSalesList.php?order_id=" . $rows[0] . "' class='btn btn-primary' id='" . $rows[0] . "'><i class='fa fa-save'></i> Sales Now..</a></td></tr>";
//        echo '</tr>';
//        // }
//    }
//    // Get View Sales Item Order Data...
//} elseif (isset($_GET['srl_id'])) {
//    $id = $_GET['srl_id'];
//
//    $sql = "SELECT sales_order_item_list.id,sales_order_item_list.srl_id,item_list.item_code,item_list.item_name,unit_list.unit_name,sales_order_item_list.item_qnty,sales_order_item_list.item_rate,sales_order_item_list.sub_total,sales_order_item_list.gst,sales_order_item_list.total, sales_order_item_list.item_id FROM item_list INNER JOIN sales_order_item_list ON sales_order_item_list.item_id = item_list.id INNER JOIN unit_list ON item_list.item_unit_id= unit_list.id WHERE sales_order_item_list.srl_id=" . $id;
//
//    $resultset = mysqli_query($con, $sql);
//    //print_r($sql);
//    $k = 1;
//    while ($rows = mysqli_fetch_array($resultset)) {
//        echo "<tr id='row" . $k . "' data='yes'>";
//        echo "<input type='hidden' id='s_id" . $k . "' name='sr_id[]' value=" . $rows['id'] . ">";
//        echo "<input type='hidden' id='s_qnty" . $k . "' name='sr_qnty[]' value=" . $rows['item_qnty'] . ">";
//        echo "<td><input type = 'checkbox' class = 'case' id='check" . $k . "' name='check[]' value=" . $k . "></td>";
//        echo " <td><input type='text' id = 'snum" . $k . "' value='" . $k . "' class='snum' /></td>";
//        echo "<td><select onchange='getValue(this);'  name='item_id[]' id = 'item_code" . $k . "' class ='itemcode' > <option>Select Item</option>";
//        $dba = new DBAdapter();
//        $Names = $dba->getRow("item_list INNER JOIN category_list ON item_list.category_id=category_list.id", array("item_list.id", "item_list.item_code"), "category_list.branch_id=" . $last_id . " order by item_list.id asc");
//
//        foreach ($Names as $name) {
//            echo" <option " . ($name[1] == $rows['item_code'] ? 'selected' : '') . " value='" . $name[0] . "'>" . $name[1] . "</option> ";
//        }
//        echo "</select></td>";
//        echo "<td><input type='text' id='item_name" . $k . "' class='itemname' name='item_name[]' value='" . $rows['item_name'] . "' required/></td>";
//        echo "<td><input type='text' id='unit" . $k . "' class='unit1' name='unit[]' value=" . $rows['unit_name'] . " required/></td>";
//        echo "<td><input type='text' id='qnty" . $k . "' class='qnty1' name='item_qnty[]' value=" . $rows['item_qnty'] . " onchange='changeQnty(this);' required /></td>";
//        echo "<td><input type='text' id='rate" . $k . "' class='rate1' name='item_rate[]' value=" . $rows['item_rate'] . " onchange='changerate(this);' required/></td>";
//        echo "<td><input type='text' id='sub_total" . $k . "' class='subtotal' name='sub_total[]' value=" . $rows['sub_total'] . " required readonly/></td>";
//        echo "<td><input type='text' id='gst" . $k . "' class='gst1' name='gst[]' value=" . $rows['gst'] . " onchange='changegst(this);' required/></td>";
//        echo "<td><input type='text' id='total" . $k . "' class='total1' name='total[]' value=" . $rows['total'] . " required readonly/></td>";
//       
//         $edba = new DBAdapter();
//        $field = array("item_stock.qnty");
//        $edata = $edba->getRow("sales_order_item_list INNER JOIN item_stock ON sales_order_item_list.item_id=item_stock.item_id", $field, "sales_order_item_list.srl_id = " . $id . " and sales_order_item_list.item_id = " . $rows['item_id']);
//
//        echo "<td style='border: none;'> <label  class='col-sm-1 control-label' id='itemstock" . $k . "'>" . ($edata[0][0] - $rows['item_qnty']) . "</label> </td>";
//        echo "<input type='hidden' id='dbstock" . $k . "' class='dbitemstock' value='" . $edata[0][0] . "'  name='dbitemstock[]' />";
//        
//        echo '</tr>';
//        $rowcount = mysqli_num_rows($resultset);
//        echo "<input type='hidden' id='item_count' name='item_count' value=" . $rowcount . ">";
//        $k++;
//    }
// Get View Sales Return Data...
//}
?>
<script type="text/javascript">
    $(document).ready(function () {
        $('.chosen').select2();
    });

</script> 
