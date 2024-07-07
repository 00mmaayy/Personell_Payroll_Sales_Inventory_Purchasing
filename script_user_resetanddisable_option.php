<?php
include('connection/conn.php');
session_start();
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); }

$useroption=$_REQUEST['useroption'];

//Start for Users Only
if(isset($_REQUEST['update_password']))
{   $newpassword1=md5($_REQUEST['new_password']);
    $newpassword2=md5($_REQUEST['password_repeat']);
    $user_account=$_SESSION['username'];
   
   if($newpassword1==$newpassword2)
     {
	   $s1="update users set password='$newpassword1' where username='$user_account' ";
       $q1=mysql_query($s1) or die(mysql_error());
	   
	   $username=$_SESSION['username'];
       $trans="update password user $user_account";
       $log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
       $log_query=mysql_query($log_sql) or die(mysql_error());

	   $loc1='Location: admin.php?settings=1&passwordupdated=1';
       header($loc1);
	 }
   else	 
     {  
       $loc1='Location: admin.php?settings=1&passworderror=1';
       header($loc1); 
     }	  
}
//End for Users Only

//Start for administrator only
if(isset($_REQUEST['resetpass']))
{
$s1="update users set password='e10adc3949ba59abbe56e057f20f883e' where username='$useroption' ";
$q1=mysql_query($s1) or die(mysql_error());

$username=$_SESSION['username'];
$trans="reset password user $useroption";
$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
$log_query=mysql_query($log_sql) or die(mysql_error());

$loc1='Location: admin.php?settings=1&createuser=1';
header($loc1);
}

if(isset($_REQUEST['disableuser']))
{ 
$s1="update users set user_disable=1 where username='$useroption' ";
$q1=mysql_query($s1) or die(mysql_error());

$username=$_SESSION['username'];
$trans="disable user $useroption";
$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
$log_query=mysql_query($log_sql) or die(mysql_error());

$loc2='Location: admin.php?settings=1&createuser=1';
header($loc2);
}

if(isset($_REQUEST['enableuser']))
{ 
$s1="update users set user_disable=0 where username='$useroption' ";
$q1=mysql_query($s1) or die(mysql_error());

$username=$_SESSION['username'];
$trans="enable user $useroption";
$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
$log_query=mysql_query($log_sql) or die(mysql_error());

$loc2='Location: admin.php?settings=1&createuser=1';
header($loc2); 
}

if(isset($_REQUEST['clearuser']))
{ 
$s1="update users set user_status=0 where username='$useroption' ";
$q1=mysql_query($s1) or die(mysql_error());

$username=$_SESSION['username'];
$trans="clear user $useroption";
$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
$log_query=mysql_query($log_sql) or die(mysql_error());

$loc2='Location: admin.php?settings=1&createuser=1';
header($loc2);
}
//End for administrator only
?>