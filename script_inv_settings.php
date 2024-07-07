<?php 
include('connection/conn.php');
session_start();
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); }

$storage_name=$_REQUEST['storage_name'];
$storage_address=$_REQUEST['storage_address'];
$date=date("Y-m-d");

$s="insert into inv_storage_facility (name,address,date_created) values ('$storage_name','$storage_address','$date')";
mysql_query($s) or die(mysql_error());

$username=$_SESSION['username'];
$trans="add new storage $storage_name $date by $username";
$log_sql="insert into inv_logbook (datetime,transaction,transact_by) values (now(),'$trans','$username')";
$log_query=mysql_query($log_sql) or die(mysql_error());

header('Location: inv_settings.php?success=1');
?>