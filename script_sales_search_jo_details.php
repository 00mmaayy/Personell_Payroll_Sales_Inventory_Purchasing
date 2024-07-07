<?php 
include('connection/conn.php');
session_start();
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); }
$item=$_REQUEST['s'];

echo "<table border='1'>";


if($item!="")
{
	  echo "<tr class='w3-tiny'>
				<td><b>&nbsp;<i>JO NO</i></b>&nbsp;</td>
				<td><b>&nbsp;<i>JO ACTUAL</i></b>&nbsp;</td>
				<td><b>&nbsp;<i>BOOKING</i></b>&nbsp;</td>
				<td><b>&nbsp;<i>PARTICULAR</i>&nbsp;</b></td>
			</tr>";
}	


if($item!="")
{	
	$sql=mysql_query("select a.b_desc, b.jo_actual, b.jo_no, b.bo_no
					  from sales_bookings_details as a 
					  left join sales_jo as b on a.b_id=b.b_id
					  where a.b_desc like '%$item%'");
	while($row = mysql_fetch_array($sql))
	{ 
	  echo "<tr class='w3-hover-pale-red'>
				<td class='w3-tiny'>
					<b>".$row['jo_no']."</b>
				</td>
				<td class='w3-tiny'>
					<b>".$row['jo_actual']."</b>
				</td>
				<td class='w3-tiny'>
					<b>".$row['bo_no']."</b>
				</td>
				<td class='w3-tiny'><i>".$row['b_desc']."</i></td>
			</tr>";
    }
}


echo "</table>";
?>
