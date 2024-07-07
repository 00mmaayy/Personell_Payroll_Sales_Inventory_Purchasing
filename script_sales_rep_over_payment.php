<?php
if(isset($_REQUEST['search']) and $_REQUEST['search']=="over_payment")
{
 $cr_s="select a.b_count, a.b_id, a.b_date, a.bch, b.jo_no, b.client_id, c.name
        from sales_bookings_details as a 
		inner join sales_jo as b
		on b.b_id=a.b_id
		inner join sales_clients as c
		on b.client_id=c.client_id
		where (a.dr_qty*a.b_amount) > (a.b_qty*a.b_amount)
		group by a.b_id 
		order by a.b_id asc";
 $cr_q=mysql_query($cr_s) or die(mysql_error());
 $cr_r=mysql_fetch_assoc($cr_q);
 $x=1;
 
 echo "<table class='w3-small' border='1'>";
		echo "<tr>
				<td>count</td>
				<td>b_count</td>
				<td>b_id</td>
				<td>BRANCH</td>
				<td>JO NO</td>
				<td>JO TOTAL</td>
				<td>DR TOTAL</td>
				<td>CAPTURED STATUS</td>
			  </tr>";

		do{
		  echo "<tr>";
			echo "<td class='w3-text-amber'>".$x++."</td>";
			echo "<td>".$cr_r['b_count']."</td>";
			echo "<td>".$cr_r['b_id']."</td>";
			echo "<td>".$cr_r['bch']."</td>";
			echo "<td><b><a href='script_sales_addquotation.php?b_date=".$cr_r['b_date']."&client=".$cr_r['name']."&jo_no=".$cr_r['jo_no']."&b_id=".$cr_r['b_id']."&client_id=".$cr_r['client_id']."&print_booking_details=DR%2FJO+DETAILS' target='_blank'>".$cr_r['jo_no']."</a></b></td>";
			echo "<td align='right'>";
						$b_id=$cr_r['b_id'];
						$dr_total_s="select sum(b_qty*b_amount) as b_total, sum(dr_qty*b_amount) as dr_total from sales_bookings_details where b_id='$b_id'";
						$dr_total_q=mysql_query($dr_total_s) or die(mysql_error());
						$dr_total_r=mysql_fetch_assoc($dr_total_q);
						echo number_format($dr_total_r['b_total'],2);
			echo "</td>";
			echo "<td align='right'>".number_format($dr_total_r['dr_total'],2)."</td>";
						$total=$dr_total_r['b_total']-$dr_total_r['dr_total'];
			echo "<td align='right'>";
			
				if ( $dr_total_r['dr_total'] > $dr_total_r['b_total'] ) { echo "<b class='w3-text-red w3-pale-red'>Over Delivery (DR)!</b>"; }
			
			echo "</td>";
		  echo "</tr>";
		}while($cr_r=mysql_fetch_assoc($cr_q));
 
 echo "</table>";
}
?>