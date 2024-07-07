<?php 
session_start();
include('connection/conn.php');
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); }

$new_user=$_GET['new_user'];
$password=$_GET['password'];
$new_first_name=$_GET['f_name'];
$new_middle_name=$_GET['m_name'];
$new_last_name=$_GET['l_name'];
$new_position=$_GET['position'];
$department=$_GET['department'];
$company=$_GET['company'];
$username=$_SESSION['username'];

if($department=="SALES" or $department=="FINANCE"){ $bch='main'; }
if($department=="SM SALES" or $department=="SM FINANCE"){ $bch='sm'; }
if($department=="RIZAL SALES" or $department=="RIZAL FINANCE"){ $bch='rzl'; }
if($department=="SANPEDRO SALES" or $department=="SANPEDRO FINANCE"){ $bch='sp'; }
if($department=="SANJOSE SALES" or $department=="SANJOSE FINANCE"){ $bch='sj'; }
//new added branch start
if($department=="ADPLUS SALES" or $department=="ADPLUS FINANCE"){ $bch='adpls'; }
//new added branch end
$sql="insert into users (username,password,first_name,middle_name,last_name,position,department,company,date_created,time_created,created_by,bch)
      values ('$new_user','$password','$new_first_name','$new_middle_name','$new_last_name',$new_position,'$department','$company',curdate(),curtime(),'$username','$bch')";
$query=mysql_query($sql) or die(mysql_error());

$sql1="insert into user_access (username) values ('$new_user')";
$query1=mysql_query($sql1) or die(mysql_error());

$username=$_SESSION['username'];
$trans="create system user $new_user $new_position";
$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
$log_query=mysql_query($log_sql) or die(mysql_error());

$return='Location: admin.php?settings=1&createuser=1&success=1';
header($return);
?>
