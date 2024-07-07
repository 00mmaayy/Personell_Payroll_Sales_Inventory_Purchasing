<?php 
include('connection/conn.php');
session_start();
date_default_timezone_set("Asia/Manila");
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); }
include("css.php");

$username=$_SESSION['username'];
$jo_no=$_REQUEST['jo_no'];	
$client_id=$_REQUEST['client_id'];
$client=$_REQUEST['client'];

mysql_query("update sales_jo set completed_datetime=now(), completed_by='$username', delivered=1 where jo_no='$jo_no'") or die(mysql_error());
											
$jo_msg="JO $jo_no COMPLETED!";
mysql_query("insert into sales_jo_progress (jo_no,jo_msg,jo_msg_by,date,time) values ('$jo_no','$jo_msg','$username',curdate(),curtime())") or die(mysql_error());
		
$trans1="AUTO SET jo $jo_no completed.";
$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans1')";
$log_query=mysql_query($log_sql) or die(mysql_error());

mysql_query("update sales_jo set production_status=1, production_date=now() where jo_no='$jo_no'");
$trans="AUTO SET production status to Delivered to jo no:$jo_no client:$client set by ".$_SESSION['username']." time: ".date('m/d/Y h:i A')." ";
$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
$log_query=mysql_query($log_sql) or die(mysql_error());

echo "<div align='center' class='w3-xxxlarge'><br/>NOTE: JO CLOSED, STATUS SET TO DELIVERED COMPLETED.<br/>PLEASE CLOSE THIS WINDOW<br/></div>"
?>
