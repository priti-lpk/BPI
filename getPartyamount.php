<?php
$id = $_GET['id'];
include_once("shreeLib/dbconn.php");
$sql = "SELECT party_amount FROM party_list WHERE id=" . $id ;
$resultset = mysqli_query($con, $sql);
while ($rows = mysqli_fetch_assoc($resultset)) {
    $amount = $rows['party_amount'];
     
    echo $amount;
}
?>

