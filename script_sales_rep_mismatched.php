<?php
if(isset($_REQUEST['search']) and $_REQUEST['search']=="mismatched")
{	
	$s9="SELECT a.*, b.payment_by, c.name, d.department
		 FROM sales_jo a 
		 LEFT JOIN sales_jo_payments b ON a.jo_no=b.jo_no
		 LEFT JOIN sales_clients c ON a.client_id=c.client_id
		 LEFT JOIN users d ON a.created_by=d.username
		 WHERE a.jo_amount!=a.jo_payment_amount AND a.paid=1
		 ORDER BY d.department ASC";
	$q9=mysql_query($s9) or die(mysql_error());
	$r9=mysql_fetch_assoc($q9);
	
	echo "<div class='container'><br/>
		  <table class='table w3-tiny'>
			<tr><td colspan='8'><b>JO WITH MISMATCHED AMOUNTS</b></td></tr>
			<tr class='w3-green'>
				<td>CREATED BY</td>
				<td>JO NO</td>
				<td>JO ACTUAL</td>
				<td>JO ACTUAL DATE</td>
				<td>CLIENT</td>
				<td align='right'>JO AMOUNT</td>
				<td align='right'>PAYMENT AMOUNT</td>
				<td align='right'>PAYMENT BY</td>
			</tr>";
	do{
		echo "<tr class='w3-hover-pale-red'>
				<td>".$r9['created_by']."</td>
				<td>".$r9['jo_no']."</td>
				<td>".$r9['jo_actual']."</td>
				<td>".$r9['jo_actual_date']."</td>
				<td><a href='admin_sales.php?client_id=".$r9['client_id']."&client=".$r9['name']."&sales=1&newjobs=1&create_quotation=1' target='_blank'>".$r9['name']."</a></td>
				<td align='right'>".$r9['jo_amount']."</td>
				<td align='right'>".$r9['jo_payment_amount']."</td>
				<td align='right'>".$r9['payment_by']."</td>
			  </tr>";
	}while($r9=mysql_fetch_assoc($q9));
	echo "</table>
		  </div>";
}
?>