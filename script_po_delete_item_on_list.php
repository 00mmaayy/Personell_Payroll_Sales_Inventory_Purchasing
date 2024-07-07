<?php 
session_start();
include('connection/conn.php');
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); }

	$id=$_REQUEST['id'];
	$po_no=$_REQUEST['po_no'];
	mysql_query("DELETE FROM proc_po_details WHERE id='$id' and po_no='$po_no'") or die(mysql_error());
	
	$return='Location: podetails.php?po_no='.$_REQUEST['po_no'];
	header($return);
?>
