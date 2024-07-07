<?php 
include('connection/conn.php');
session_start();
date_default_timezone_set("Asia/Manila");
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); }
include("css.php");

if(isset($_REQUEST['client_id']))
{ 	
	echo ".<br/>";
	$client_id=$_REQUEST['client_id'];
	$s="SELECT a.*, b.name FROM sales_jo_routing a LEFT JOIN sales_clients b ON a.client_id=b.client_id WHERE a.client_id='$client_id' ORDER BY a.bch ASC"; 
}
elseif(isset($_REQUEST['bch']) and $_REQUEST['bch']!="goc")
{
	echo "..<br/>";
	$bch=$_REQUEST['bch'];
	$s="SELECT a.*, b.name FROM sales_jo_routing a LEFT JOIN sales_clients b ON a.client_id=b.client_id WHERE a.bch='$bch' ORDER BY a.routing_no DESC"; 
}
else
{ 
	echo "...<br/>";
	$s="SELECT a.*, b.name FROM sales_jo_routing a LEFT JOIN sales_clients b ON a.client_id=b.client_id ORDER BY a.bch ASC";
}

$q=mysql_query($s) or die(mysql_error());
$r=mysql_fetch_assoc($q);

echo "<br/><div class='container'>";
echo "<table border='1' class='table w3-tiny'>
		<tr class='w3-green'>
			<td>id</td>
			<td>client_id</td>
			<td>name</td>
			<td>b_count</td>
			<td>jo_no</td>
			<td>sales_fname</td>
			<td>sales_lname</td>
			<td>assign_to</td>
			<td>bch</td>
			<td>routing_no</td>
			<td>created_by</td>
			<td>created_datetime</td>
		</tr>";
do{	
echo "<tr class='w3-hover-pale-red'>
		<td>".$r['id']."</td>
		<td>".$r['client_id']."</td>
		<td>".$r['name']."</td>
		<td>".$r['b_count']."</td>
		<td>".$r['jo_no']."</td>
		<td>".$r['sales_fname']."</td>
		<td>".$r['sales_lname']."</td>
		<td>".$r['assign_to']."</td>
		<td>".$r['bch']."</td>
		<td align='center'><b class='w3-text-red'>".$r['routing_no']."</b></td>
		<td>".$r['created_by']."</td>
		<td>".$r['created_datetime']."</td>
	  </tr>";
}while($r=mysql_fetch_assoc($q));

echo "</table>
	  </div>";
?>
