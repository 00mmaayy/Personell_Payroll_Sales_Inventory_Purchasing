<?php 
session_start();
include('connection/conn.php');
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); }

if(isset($_REQUEST['delete_list']))
{
	mysql_query("UPDATE inv_storage_in SET for_withdrawal = 0") or die(mysql_error());
	
	$sql="TRUNCATE TABLE inv_storage_out_temp";
	$query=mysql_query($sql) or die(mysql_error());

	$username=$_SESSION['username'];
    $trans="withdrawal list deleted";
    $log_sql="insert into inv_logbook (datetime,transaction,transact_by) values (now(),'$trans','$username')";
    $log_query=mysql_query($log_sql) or die(mysql_error());
		
	$return='Location: inv_warehouse.php?storage='.$_REQUEST['storage'].'&withdrawal_list_deleted_success=1';
	header($return);
}
?>
