<?php
session_start();
include('connection/conn.php');
if (!isset($_SESSION['username'])) {
	$loc = 'Location: index.php?msg=requires_login ' . $_SESSION['username'];
	header($loc);
}
include("css.php");
$client_id = $_REQUEST['client_id'];
$s = "SELECT jo_no, jo_amount, jo_payment_amount FROM sales_jo WHERE jo_amount != jo_payment_amount and client_id = $client_id";
$q = mysql_query($s) or die(mysql_error());
$r = mysql_fetch_assoc($q);
?>
<br/>
<div class="w3-container">
<table class="w3-table" border='1'>
	<tr>CLIENT: <?php echo $_REQUEST['name']; ?></tr>
	<tr class="w3-green">
		<td>#</td>
		<td>JO NO</td>
		<td>JO AMOUNT</td>
		<td>PAYMENT APPLIED</td>
	</tr>
	
<?php
$x=1;
do
{ 
	echo "<tr>
			<td>".$x++."</td>
			<td><a href='script_sales_rep_summary_per_client_detailed2.php?jo_no=".$r['jo_no']."'>".$r['jo_no']."</a></td>
			<td>".number_format($r['jo_amount'],2)."</td>
			<td>".number_format($r['jo_payment_amount'],2)."</td>
		 </tr>";
}while($r = mysql_fetch_assoc($q));
?>
</div>

