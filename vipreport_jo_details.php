<?php 
include('connection/conn.php');
include("css.php");
?>
<title>VIP REPORT</title>
<body>
<?php
	$jo_no=$_REQUEST['jo_no'];
	$s="SELECT b.*, a.*, c.name
		FROM sales_jo a
		INNER JOIN sales_bookings_details b ON a.b_id = b.b_id
		LEFT JOIN sales_clients c ON a.client_id = c.client_id
		WHERE a.jo_no=$jo_no";
	$q=mysql_query($s) or die(mysql_error());
	$r=mysql_fetch_assoc($q);
	
	echo "<div class='container'><br/>
		  <table class='table' border='1'>
			<tr class='w3-green'>
				<td>CLIENT</td>
				<td>CODE</td>
				<td>QTY</td>
				<td>UNIT</td>
				<td>SIZE</td>
				<td>DESCRIPTION</td>
				<td>UNIT AMOUNT</td>
				<td>TOTAL AMOUNT</td>
			</tr>";
	do{
		echo "<tr>
				<td>".$r['name']."</td>
				<td>".$r['code_set']."</td>
				<td>".$r['b_qty']."</td>
				<td>".$r['b_unit']."</td>
				<td>".$r['b_size']."</td>
				<td>".$r['b_desc']."</td>
				<td>".number_format($r['b_amount'],2)."</td>
				<td>".number_format($r['b_qty']*$r['b_amount'],2)."</td>
			  </tr>";
	}while($r=mysql_fetch_assoc($q));
	echo "</table>";
?>
<button onclick="goBack()">Go Back</button>

<script>
function goBack() {
  window.history.back();
}
</script>
</body>