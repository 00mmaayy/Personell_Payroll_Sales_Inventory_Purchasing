<?php 
session_start();
include('connection/conn.php');
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); }

if(isset($_REQUEST['item_add'])){
$username=$_SESSION['username'];
$po_no=$_REQUEST['po_no'];
$item=$_REQUEST['item'];
$qty=$_REQUEST['qty'];
mysql_query("insert into proc_po_details (po_no,item,qty,add_by,add_date) values ('$po_no','$item','$qty','$username',now())") or die(mysql_error());
header('Location: podetails.php?po_no='.$_REQUEST['po_no']);
}
?>
