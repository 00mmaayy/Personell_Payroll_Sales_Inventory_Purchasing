<?php
session_start();
include('connection/conn.php');
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); }

$user=$_SESSION['username'];

if(isset($_REQUEST['storage_in']))
{
	$po_amount=$_REQUEST['po_amount'];
	$po_no=$_REQUEST['po_no'];
	$storage=$_REQUEST['storage'];
	
	
	$update_po_status="update proc_po set recieved_by='$user', recieved_date=now(), status=1 where po_no='$po_no'";
	mysql_query($update_po_status) or die(mysql_error());
	
	$s1="select a.item,
				a.qty,
				b.price 
		from proc_po_details a
		join proc_items b on b.id=a.item
		where a.po_no='$po_no'";
		
	$q1=mysql_query($s1) or die(mysql_error());
	$r1=mysql_fetch_assoc($q1);
	do{
	$item_id=$r1['item'];
	$count_in=$r1['qty'];
	$item_price=$r1['price'];
	
	$storage_in="insert into inv_storage_in (item_id,item_price,count_in,datetime,officer,storage,po_no) 
				values ('$item_id','$item_price','$count_in',now(),'$user','$storage','$po_no') ";
	mysql_query($storage_in) or die(mysql_error());
	}while($r1=mysql_fetch_assoc($q1));
	
	$date1=date('Y-m-d h:i A');
	
	$username=$_SESSION['username'];
    $trans="PO: $po_no recieved by $user on $date1";
    $log_sql="insert into inv_logbook (datetime,transaction,transact_by) values (now(),'$trans','$username')";
    $log_query=mysql_query($log_sql) or die(mysql_error());
}


header("Location: inv_po_monitor.php");
?>