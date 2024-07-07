<?php 
include('connection/conn.php');
session_start();
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); }
date_default_timezone_set("Asia/Manila");
include("css.php");


if(isset($_REQUEST['merge_clients']))
{
	$client_keep = $_REQUEST['client_keep'];
	$client_remove = $_REQUEST['client_remove'];
	
	echo $client_keep . "<br/>";
	echo $client_remove;
	
	$q = mysql_query("select name from sales_clients where client_id = $client_remove") or die(mysql_error());
	$r = mysql_fetch_assoc($q);
	$client_remove_name = $r['name'];
	
	$q1 = mysql_query("select name from sales_clients where client_id = $client_keep") or die(mysql_error());
	$r1 = mysql_fetch_assoc($q1);
	$client_keep_name = $r1['name'];
	
	$username=$_SESSION['username'];
	$trans="Merge Client: $client_remove ($client_remove_name) to $client_keep ($client_keep_name)";
	mysql_query("insert into logbook_it (date,transaction,update_by) values (now(),'$trans','$username')") or die(mysql_error());
	
	mysql_query("UPDATE sales_bookings SET client_id = $client_keep WHERE client_id = $client_remove");
	mysql_query("UPDATE sales_jo SET client_id = $client_keep WHERE client_id = $client_remove");
	mysql_query("UPDATE sales_jo_payments SET client_id = $client_keep WHERE client_id = $client_remove");
	mysql_query("UPDATE sales_jo_routing SET client_id = $client_keep WHERE client_i d= $client_remove");
	mysql_query("UPDATE sales_jo_rs_monitor SET client_id = $client_keep WHERE client_id = $client_remove");
	mysql_query("DELETE FROM sales_clients WHERE client_id = $client_remove");
	
	header('location: script_sales_jo_details_search_area.php?merge_success=1');
}