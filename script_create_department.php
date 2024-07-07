<?php 
session_start();
include('connection/conn.php');
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); }

$settings=$_GET['settings'];
$company=$_GET['company'];
$new_department=$_GET['new_department'];
$creator=$_SESSION['username'];

$sql="insert into departments (dept_code,dept_company,dept_name,created_by,created_date) values ('','$company','$new_department','$creator',curdate())";
$query=mysql_query($sql) or die(mysql_error());

$username=$_SESSION['username'];
$trans="create department $new_department";
$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
$log_query=mysql_query($log_sql) or die(mysql_error());

$return='Location: admin.php?settings=1&createdepartment=1&possuccess=1';
header($return);
?>
