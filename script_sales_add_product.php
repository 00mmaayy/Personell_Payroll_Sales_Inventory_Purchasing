<?php 
session_start();
include('connection/conn.php');
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); }
?>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/w3.css">
<link rel="stylesheet" href="css/font-awesome.min.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>

<div class='container'>
<?php

if(isset($_REQUEST['add_product']))
{
$code_tag=$_REQUEST['code_tag'];	
$code_set=$_REQUEST['code_set'];
$code_name=$_REQUEST['code_name'];
$code_desc=$_REQUEST['code_descriptions'];
$code_products=$_REQUEST['code_products'];

mysql_query("INSERT INTO sales_codes (code_tag, code_set, code_name, code_desc, code_products) VALUES ('$code_tag', '$code_set', '$code_name', '$code_desc', '$code_products')");

$username=$_SESSION['username'];
$trans="create alc sales code $code_set $code_desc";
$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
$log_query=mysql_query($log_sql) or die(mysql_error());

header('Location: admin_sales.php?sales=1&guides=1&success=1');

}
	
?>
</div>
