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
	
	$sql="select `user_login_password` from `create_user` where id='".$_POST['id']."'";
	$result=mysqli_query($con,$sql);
	$row=mysqli_fetch_array($result);
	if($row['user_login_password']==$en_pass)
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
	$sql="update `create_user` set user_login_password='".$en_pass."' where id='".$_POST['change']."'";
	if($result=mysqli_query($con,$sql))
		echo '1';
		else
		echo '0';
}
?>
   