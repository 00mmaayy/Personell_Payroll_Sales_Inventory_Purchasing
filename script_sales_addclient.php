<?php 
session_start();
include('connection/conn.php');
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); }

if(isset($_REQUEST['addclient']))
{
	$newclient=$_GET['newclient'];
	$tin=$_GET['tin'];
	$cp=$_GET['cp'];
	$email=$_GET['email'];
	$telno=$_GET['telno'];
	$clientaddr=$_GET['clientaddr'];
	$contact_person=$_GET['contact_person'];
	$username=$_SESSION['username'];

	$sql="insert into sales_clients (client_id,name,tin,mobile,telno,contact_person,email,address,add_by,add_date)
	     values ('','$newclient','$tin','$cp','$telno','$contact_person','$email','$clientaddr','$username',curdate())";
	$query=mysql_query($sql) or die(mysql_error());

	
	$trans="create new sales client $newclient";
	$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
	$log_query=mysql_query($log_sql) or die(mysql_error());

	$return='Location: admin_sales.php?sales=1&clients=1&add_success=1';
	header($return);
}
?>
