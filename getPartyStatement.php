<?php

$id = $_GET['p_id'];
$firstdate = $_GET['f_date'];
$lastdate = $_GET['l_date'];
include_once("shreeLib/dbconn.php");
$sql = "SELECT pt.paydate, pt.id, party_list.party_name, pt.type, pt.credit, pt.debit FROM(select id, party_id, party_due As amount, pay_date As paydate, 'Payment' As type, pay_amount as credit, 0 As debit from payment_list where pay_crdb = 'Credit' union all select id, party_id, party_due As amount, pay_date As paydate, 'Payment' As type, 0 as credit, pay_amount As debit from payment_list where pay_crdb = 'Debit' union all select id, party_id, total_amount as amount, pl_date As paydate, 'Purchase' As type, total_amount as credit, 0 as debit from purchase_list union all select id, party_id, total_amount as amount, sale_date As paydate, 'Sale' As type, 0 as credit, total_amount as debit from sales_list) AS pt INNER JOIN party_list ON pt.party_id = party_list.id where pt.party_id='" . $id . "' and pt.paydate >= '" . $firstdate . "' and pt.paydate <= '" . $lastdate . "' ORDER BY pt.paydate";
$resultset = mysqli_query($con, $sql);
echo "<thead>";
echo "<tr>";
echo "<td>Date</td>";
echo "<td>No.</td>";
echo "<td>Party Name</td>";
echo "<td>Title</td>";
echo "<td>Credit</td>";
echo "<td>Debit</td>";
echo '</tr>';
echo "</thead>";
$credit = 0.0;
$debit = 0.0;
$diff = 0.0;
$difcredt = 0.0;
$difdebit = 0.0;
while ($rows = mysqli_fetch_array($resultset)) {
    $credit += $rows['credit'];
    $debit += $rows['debit'];

    echo "<tbody>";
    echo "<tr>";
    echo "<td>" . $rows['paydate'] . "</td>";
    echo "<td>" . $rows['id'] . "</td>";
    echo "<td>" . $rows['party_name'] . "</td>";
    echo "<td>" . $rows['type'] . "</td>";
    echo "<td>" . $rows['credit'] . "</td>";
    echo "<td>" . $rows['debit'] . "</td>";
    echo '</tr>';
    echo "</tbody>";
}
$diff = $credit - $debit;
if ($diff < 0) {
    $difcredt = $diff;
} else {
    $difdebit = $diff;
}
echo "<tr>";
echo "<td></td>";
echo "<td></td>";
echo "<td></td>";
echo "<td>Current Total</td>";
echo "<td>" . $credit . "</td>";
echo "<td>" . $debit . "</td>";
echo '</tr>';
echo "<tr>";
echo "<td></td>";
echo "<td></td>";
echo "<td></td>";
echo "<td>Closing Balance</td>";
echo "<td>" . $difcredt . "</td>";
echo "<td>" . $difdebit . "</td>";
echo '</tr>';
?>