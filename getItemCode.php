<?php
ob_start();
include 'shreeLib/dbconn.php';
include_once 'shreeLib/DBAdapter.php';
if (!isset($_SESSION)) {
    session_start();
}

$code = $_GET['item_code'];

$dba = new DBAdapter();

$last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);

$sql = "SELECT create_item.id, create_item.item_name FROM create_item INNER JOIN sub_category ON create_item.sub_cat_id=sub_category.id";
$result = mysqli_query($con, $sql);
//print_r($sql);
?>
<select name='item_id[]' id='item_code<?php echo $code ?>' class='itemcode select2' required="" onchange="getValue(this);">
    <?php if (!isset($_GET['codename'])) { ?>
        <option value="">Select Item</option>
        <?php
        while ($row = mysqli_fetch_array($result)) {
            ?>
            <option value="<?php echo $row['id'] ?>"><?php echo $row["item_name"]; ?></option>

            <?php
        }
    } else {
        $getcodename = $_GET['codename'];
        while ($row = mysqli_fetch_array($result)) {
            ?>
            <option <?php echo ($row['item_name'] == $getcodename ? 'selected' : '') ?> value="<?php echo $row['id'] ?>"><?php echo $row["item_name"]; ?></option>
            <?php
        }
    }
    ?>
</select>

