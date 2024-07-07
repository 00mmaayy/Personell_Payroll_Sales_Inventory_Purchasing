<?php 
session_start();
include('connection/conn.php');
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); }

$fullname=$_REQUEST['fullname'];
$position=$_REQUEST['position'];
$form_area=$_REQUEST['form_area'];
$form_name=$_REQUEST['form_name'];

mysql_query("update signatories set fullname = '$fullname', position = '$position' where form_name = '$form_name' and form_area = '$form_area'");

//$username=$_SESSION['username'];
//$trans="create system user $new_user $new_position";
//$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
//$log_query=mysql_query($log_sql) or die(mysql_error());

$return='Location: admin.php?settings=1&signatories=1&success=1';
header($return);
?>
