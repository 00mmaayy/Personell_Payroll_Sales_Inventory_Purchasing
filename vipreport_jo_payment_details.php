<?php 
include('connection/conn.php');
include("css.php");
?>
<title>VIP REPORT</title>
<body>
<?php

	$jo_no=$_REQUEST['jo_no'];
	$s="SELECT a.*, b.jo_no, c.name
		FROM sales_jo_payments a
		LEFT JOIN sales_jo b ON a.jo_no = b.jo_no
		LEFT JOIN sales_clients c ON a.client_id = c.client_id
		WHERE a.jo_no=$jo_no";
	$q=mysql_query($s) or die(mysql_error());
	$r=mysql_fetch_assoc($q);
	
	echo "<div class='container'><br/>
		  <table class='table' border='1'>
			<tr class='w3-green'>
				<td>CLIENT</td>
				<td>JO NO</td>
				<td>RS NO</td>
				<td>OR NO</td>
				<td>OR DATE</td>
				<td>PAY TYPE</td>
				<td>PAY MODE</td>
				<td>TOTAL AMOUNT</td>
				<td>REMARKS</td>
			</tr>";
	do{
		echo "<tr>
				<td>".$r['name']."</td>
				<td>".$r['jo_no']."</td>
				<td>".$r['rs_no']."</td>
				<td>".$r['or_no']."</td>
				<td>".$r['or_date']."</td>
				<td>".$r['pay_type']."</td>
				<td>".$r['pay_mode']."</td>
				<td>".number_format($r['payment'],2)."</td>
				<td>".$r['remarks']."</td>
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