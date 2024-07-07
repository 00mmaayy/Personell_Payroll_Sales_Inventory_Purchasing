<?php 
session_start();
include('connection/conn.php');
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); }

$settings=$_GET['settings'];
$new_position=$_GET['new_position'];
$creator=$_SESSION['username'];

$sql="insert into user_positions (pos_description,created_by,created_date) values ('$new_position','$creator',curdate())";
$query=mysql_query($sql) or die(mysql_error());

$username=$_SESSION['username'];
$trans="create position $new_position";
$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
$log_query=mysql_query($log_sql) or die(mysql_error());

$return='Location: admin.php?settings=1&createposition=1&possuccess=1';
header($return);
?>
