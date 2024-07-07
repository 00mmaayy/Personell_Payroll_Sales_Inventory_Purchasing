<?php 
session_start();
include('connection/conn.php');
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); }

	
	
	$transact_id=$_REQUEST['transact_id'];
	mysql_query("DELETE FROM inv_storage_out_temp WHERE transact_id=$transact_id") or die(mysql_error());
	
	$count_out=$_REQUEST['count_out'];
	$item_id=$_REQUEST['item_id'];
	mysql_query("UPDATE inv_storage_in SET for_withdrawal=(for_withdrawal-$count_out) WHERE item_id=$item_id") or die(mysql_error());
		
	$return='Location: inv_withdrawal_list.php?storage='.$_REQUEST['storage'].'&view_withdrawal=View+Withdrawal+List';
	header($return);
?>
