<?php 
session_start();
include('connection/conn.php');
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); }

if(isset($_REQUEST['add_withdraw']))
{
	$item_id=$_REQUEST['item_id'];
	$price=$_REQUEST['price'];
	$withdraw_count=$_REQUEST['withdraw_count'];
	$officer=$_REQUEST['officer'];
	$storage=$_REQUEST['storage'];
	$po_no=$_REQUEST['po_no'];
	$sql="insert into inv_storage_out_temp (item_id,item_price,count_out,datetime,officer,storage,po_no)
	     values ('$item_id','$price','$withdraw_count',now(),'$officer','$storage','$po_no')";
	$query=mysql_query($sql) or die(mysql_error());
	
	mysql_query("UPDATE inv_storage_in SET for_withdrawal = ((SELECT for_withdrawal)+$withdraw_count) WHERE item_id=$item_id") or die(mysql_error());
	
	$return='Location: inv_warehouse.php?add_success=1&withdrawal=1&storage='.$_REQUEST['storage'];
	header($return);
}
?>
