<?php
ob_start();
//include_once './config/session_info.php';
include_once 'shreeLib/dbconn.php';
include_once 'shreeLib/DBAdapter.php';

if(isset($_POST['old'])) //to check the old password only, not to change
{
	$old=$_POST['old'];
	$en_pass=md5($old);
	$en_pass = stripslashes($en_pass);
	$en_pass= mysqli_real_escape_string($con,$en_pass);
	
	$sql="select `password` from `admin` where id='1'";
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
	$sql="update `admin` set password='".$en_pass."' where id='1'";
	if($result=mysqli_query($con,$sql))
		echo '1';
		else
		echo '0';
}
?>
   