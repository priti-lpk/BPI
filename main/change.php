<?php
include './shreeLib/dbconn.php';
if(isset($_POST['id'])) //to check the old password only, not to change
{
	$old=$_POST['old'];
	$en_pass=md5($old);
	$en_pass = stripslashes($en_pass);
	$en_pass= mysqli_real_escape_string($con,$en_pass);
	
	$sql="select `password` from admin where id=".$_POST['id'];
	$result=mysqli_query($con,$sql);
	$row=mysqli_fetch_array($result);
	if($row['password']==$en_pass)
		echo '1';
		else
		echo '0';
} //to change the password
if(isset($_POST['change']))
{
	$new = $_POST['new'];
	$en_pass=md5($new);
	$en_pass = stripslashes($en_pass);
	$en_pass= mysqli_real_escape_string($con,$en_pass);
	$sql="update admin set password='".$en_pass."' where id=".$_POST['change'];
	if($result=mysqli_query($con,$sql))
		echo '1';
		else
		echo '0';
}
?>