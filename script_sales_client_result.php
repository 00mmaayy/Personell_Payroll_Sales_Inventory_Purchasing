<?php 
include('connection/conn.php');
session_start();
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); }
$client=$_REQUEST['s'];
if($client==""){}
else
{
	$username=$_SESSION['username'];
	$q99=mysql_query("select bch from users where username='$username'") or die(mysql_error());
	$r99=mysql_fetch_assoc($q99);
	
	if($r99['bch']=="goc")
	{
		$sql=mysql_query("select * from sales_clients where name like '%$client%'");
	}
	
	else
	{	
		$sql=mysql_query("select * from sales_clients where name like '%$client%' and vip!=1");
	}
	
	while ($row = mysql_fetch_array($sql))
	{ 
	echo "<a href='admin_sales.php?client_id=".$row['client_id']."&client=".$row['name']."&sales=1&newjobs=1&create_quotation=1'>".$row['name']."</a><br>";
    } 	
} ?>