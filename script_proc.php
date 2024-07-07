<?php 
session_start();
include('connection/conn.php');
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); }

if(isset($_REQUEST['add_item']))
{
$username=$_SESSION['username'];
$item=$_REQUEST['item'];	
$unit=$_REQUEST['unit'];	
$price=$_REQUEST['price'];
$supplier=$_REQUEST['supplier'];
$cat_main=$_REQUEST['cat_main'];
$cat_sub=$_REQUEST['cat_sub'];
$cat_unique=$_REQUEST['cat_unique'];
mysql_query("INSERT INTO proc_items (item,unit,price,supplier,category_main,category_sub,category_unique,add_by,add_date) VALUES ('$item','$unit','$price','$supplier','$cat_main','$cat_sub','$cat_unique','$username',now())");
//---logs entry---
$trans="add item $item by $username";
$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
$log_query=mysql_query($log_sql) or die(mysql_error());
header('Location: admin_proc.php?procurement=1&items=1&success=1');
}


if(isset($_REQUEST['add_units']))
{
$username=$_SESSION['username'];
$units=$_REQUEST['units'];	
$units_long=$_REQUEST['units_long'];	
mysql_query("INSERT INTO proc_units (unit,unit_long,add_by,add_date) VALUES ('$units','$units_long','$username',now())");
//---logs entry---
$trans="add units $units_long by $username";
$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
$log_query=mysql_query($log_sql) or die(mysql_error());
header('Location: admin_proc.php?procurement=1&units=1&success=1');
}

if(isset($_REQUEST['add_terms']))
{
$username=$_SESSION['username'];
$terms=$_REQUEST['terms'];	
$terms_desc=$_REQUEST['terms_desc'];	
mysql_query("INSERT INTO proc_terms (terms,terms_desc,add_by,add_date) VALUES ('$terms','$terms_desc','$username',now())");
//---logs entry---
$trans="add terms $terms_desc by $username";
$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
$log_query=mysql_query($log_sql) or die(mysql_error());
header('Location: admin_proc.php?procurement=1&terms=1&success=1');
}

if(isset($_REQUEST['add_supplier']))
{
$username=$_SESSION['username'];
$supplier=$_REQUEST['supplier'];	
$address=$_REQUEST['address'];	
$contact=$_REQUEST['contact'];
$email=$_REQUEST['email'];		
mysql_query("INSERT INTO proc_suppliers (supplier,address,contact,email,add_by,add_date) VALUES ('$supplier','$address','$contact','$email','$username',now())");
//---logs entry---
$trans="add supplier $supplier by $username";
$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
$log_query=mysql_query($log_sql) or die(mysql_error());
header('Location: admin_proc.php?procurement=1&suppliers=1&success=1');
}

if(isset($_REQUEST['add_cargo']))
{
$username=$_SESSION['username'];
$cargo=$_REQUEST['cargo'];	
$address=$_REQUEST['address'];	
$contact=$_REQUEST['contact'];
$email=$_REQUEST['email'];		
mysql_query("INSERT INTO proc_cargo (cargo,address,contact,email,add_by,add_date) VALUES ('$cargo','$address','$contact','$email','$username',now())");
//---logs entry---
$trans="add cargo forwarder $supplier by $username";
$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
$log_query=mysql_query($log_sql) or die(mysql_error());
header('Location: admin_proc.php?procurement=1&cargo=1&success=1');
}

if(isset($_REQUEST['add_cat_main']))
{
$username=$_SESSION['username'];
$cat_main=$_REQUEST['cat_main'];	
mysql_query("INSERT INTO proc_category_main (category,add_by,add_date) VALUES ('$cat_main','$username',now())");
//---logs entry---
$trans="add main cat $cat_main by $username";
$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
$log_query=mysql_query($log_sql) or die(mysql_error());
header('Location: admin_proc.php?procurement=1&category=1&success=1');
}


if(isset($_REQUEST['add_cat_sub']))
{
$username=$_SESSION['username'];
$cat_sub=$_REQUEST['cat_sub'];	
mysql_query("INSERT INTO proc_category_sub (category,add_by,add_date) VALUES ('$cat_sub','$username',now())");
//---logs entry---
$trans="add sub cat $cat_sub by $username";
$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
$log_query=mysql_query($log_sql) or die(mysql_error());
header('Location: admin_proc.php?procurement=1&category=1&success=1');
}

if(isset($_REQUEST['add_cat_unique']))
{
$username=$_SESSION['username'];
$cat_unique=$_REQUEST['cat_unique'];	
mysql_query("INSERT INTO proc_category_unique (category,add_by,add_date) VALUES ('$cat_unique','$username',now())");
//---logs entry---
$trans="add unique cat $cat_sub by $username";
$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
$log_query=mysql_query($log_sql) or die(mysql_error());
header('Location: admin_proc.php?procurement=1&category=1&success=1');
}

?>