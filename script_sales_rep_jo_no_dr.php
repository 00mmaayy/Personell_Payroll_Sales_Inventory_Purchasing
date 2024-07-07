<?php
if(isset($_REQUEST['search']) and $_REQUEST['search']=="jo_no_dr")
{
	 $s="SELECT b.created_datetime,
				b.created_by,
				a.b_id,
				b.jo_no,
				b.client_id, 
				c.name 
		FROM sales_bookings_details as a
		INNER JOIN sales_jo as b USING(b_id) 
		INNER JOIN sales_clients as c USING(client_id) 
		WHERE a.dr_no = '' AND completed_by = ''
		ORDER BY c.name ASC";
	
	$q=mysql_query($s) or die(mysql_error());
	$r=mysql_fetch_assoc($q);
	
	echo "<table border='1' class='w3-table'>
			<tr>
				<td>#</td><td>JO NO WITH NO DR</td><td>CLIENT NAME</td>
			</tr>";
	$x=1;
	do{
	   echo "<tr>";
		echo "<td><i class='w3-text-orange'>".$x++."</i></td>
			  <td><a href='script_sales_addquotation.php?b_date=".$r['created_datetime']."&client=".$r['name']."&jo_no=".$r['jo_no']."&b_id=".$r['b_id']."&client_id=".$r['client_id']."&print_booking_details=1&salesperson=".$r['created_by']."' target='_blank'>
			  ".$r['jo_no']."</a></td>
			  <td><a href='admin_sales.php?client_id=".$r['client_id']."&client=".$r['name']."&sales=1&newjobs=1&create_quotation=1' target='_blank'>".$r['name']."</a></td>
			 </tr>";
		
		
	}while($r=mysql_fetch_assoc($q));
	
	echo "</table>";
}
?>