<?php
session_start();
include('connection/conn.php');
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); }
include("css.php");

$sdate=$_REQUEST['sdate'];
$edate=$_REQUEST['edate'];

$s="SELECT a.*, b.jo_no, c.name
	FROM sales_bookings_details a
	INNER JOIN sales_jo b ON a.b_id=b.b_id
	LEFT JOIN sales_clients c ON b.client_id=c.client_id
	WHERE a.dr_date>='$sdate' AND a.dr_date<='$edate' AND a.dr_qty!=0
	ORDER BY c.name ASC, b.jo_no ASC";
$q=mysql_query($s) or die(mysql_error());
$r=mysql_fetch_assoc($q);

echo "<table class='w3-table w3-small' border='1'>
		<tr class='w3-green'>
		<td>CLIENT</td>
		<td>JO NO</td>
		<td>DR NO</td>
		<td>DR DATE</td>
		<td>UNIT PRICE</td>
		<td>DR QTY</td>
		<td>UNIT</td>
		<td>SIZE</td>
		<td>CODE</td>
		<td>PARTICULAR</td>
		<td>UNIT TOTAL</td>
	  </tr>";

do{
	echo "<tr><td>".$r['name']."</td><td>".$r['jo_no']."</td><td>".$r['dr_no']."</td><td>".$r['dr_date']."</td><td>".$r['b_amount']."</td><td>".$r['dr_qty']."</td><td>".$r['b_unit']."</td><td>".$r['b_size']."</td><td>".$r['code_set']."</td><td>".$r['b_desc']."</td><td>".number_format($r['dr_qty']*$r['b_amount'],2)."</td></tr>";
}while($r=mysql_fetch_assoc($q));

echo "</table>"; 

?>	