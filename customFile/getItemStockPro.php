<?php
ob_start();
if ($_POST) {
    include '../shreeLib/dbconn.php';
    include_once '../shreeLib/DBAdapter.php';
    if (!isset($_SESSION)) {
        session_start();
    }
    if ($_POST['isFilter']) {
        $catid = $_GET['category_list'];
        print_r($catid);
        $dba = new DBAdapter();
        $last_id = $dba->getLastID("branch_id", "system_user", "id=" . $_SESSION['user_id']);
        print_r($last_id);
        $sql = "SELECT item_list.id,item_list.item_code,item_list.item_name,item_list.item_rate,item_list.item_opstock,item_stock.qnty FROM item_list LEFT JOIN item_stock ON item_list.id=item_stock.item_id INNER JOIN category_list ON item_list.category_id=category_list.id WHERE category_list.branch_id=" . $last_id . " and item_list.category_id=" . $catid . "  ORDER BY id ASC";
        print_r($sql);
        $result = mysqli_query($con, $sql);
        $data = array();
        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['item_code'] . "</td>";
            echo "<td>" . $row['item_name'] . "</td>";
            echo "<td>" . $row['item_rate'] . "</td>";
            echo "<td>" . $row['item_opstock'] . "</td>";
            echo "<td>" . $row['qnty'] . "</td>";

            echo "</tr>";
        }
        $response = array("status" => true, "msg" => "Success", "data" => $data);
    }
    echo json_encode($response);
}
?>

