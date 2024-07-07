<?php
if(isset($_REQUEST['search']) and $_REQUEST['search']=="summary_per_client_dr_jo_or")
{

	$s="SELECT a.client_id, a.name 
		FROM sales_clients a 
		JOIN sales_jo b ON a.client_id = b.client_id
		WHERE b.jo_no IS NOT NULL
		GROUP BY a.client_id
		ORDER BY a.name";
	$q=mysql_query($s) or die(mysql_error());
	$r=mysql_fetch_assoc($q);
	
	echo "<table class='w3-table w3-tiny' border='1'>";
			echo "<tr class='w3-light-gray'>
					<td>count</td>
					<td>client_id</td>
					<td>name</td>
					<td>jo_total</td>
					<td>payment_total</td>
					<td>dr_total</td>
			 	  </tr>";
	$x=1;
	do
	{
		$client_id = $r['client_id'];
		$s1="SELECT SUM(jo_amount) AS jo_total, SUM(jo_payment_amount) AS payment_total 
			FROM sales_jo
			WHERE client_id = '$client_id'";
		$q1=mysql_query($s1) or die(mysql_error());
		$r1=mysql_fetch_assoc($q1);
		
		
		$s2="SELECT SUM(a.dr_qty * a.b_amount) AS dr_total
			FROM sales_bookings_details a
			JOIN sales_jo b ON a.b_id = b.b_id
			WHERE b.client_id = '$client_id'";
		$q2=mysql_query($s2) or die(mysql_error());
		$r2=mysql_fetch_assoc($q2);
		
		
			echo "<tr>
					<td>".$x++.".</td>
					<td>".$r['client_id']."</td>
					<td>".$r['name']."</td>
					<td>".$r1['jo_total']."</td>
					<td>".$r1['payment_total']."</td>
					<td>".$r2['dr_total']."</td>
				  </tr>";
			
	}while($r=mysql_fetch_assoc($q));
	echo "</table>";
}
?>