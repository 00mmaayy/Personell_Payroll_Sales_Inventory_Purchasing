<?php 
session_start();
include('connection/conn.php');
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); }

if(isset($_REQUEST['add_po'])){
$username=$_SESSION['username'];
$po_no=$_REQUEST['po_no'];
$rfp_no=$_REQUEST['rfp_no'];
mysql_query("update proc_po set rfp_no='$rfp_no' where po_no='$po_no'") or die(mysql_error());

$sx="select sum(po_amount) as rfp_amount from proc_po where rfp_no='$rfp_no'";
$qx=mysql_query($sx) or die(mysql_error());
$rx=mysql_fetch_assoc($qx);
$rfp_amount=$rx['rfp_amount'];
mysql_query("update proc_rfp set rfp_amount='$rfp_amount' where rfp_no='$rfp_no'") or die(mysql_error());

header('Location: rfpdetails.php?rfp_no='.$_REQUEST['rfp_no'].'&po_no='.$_REQUEST['po_no']);
}
?>
