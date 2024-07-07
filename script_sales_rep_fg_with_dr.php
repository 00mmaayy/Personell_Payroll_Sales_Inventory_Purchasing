<?php
if(isset($_REQUEST['search']) and $_REQUEST['search']=="fg_with_dr")
{
 $s="SELECT a.*, b.name, c.department
		FROM sales_jo a 
		LEFT JOIN sales_clients b ON a.client_id = b.client_id
		LEFT JOIN users c ON a.created_by = c.username
		WHERE a.production_status<=1 AND a.jo_amount=a.jo_payment_amount AND a.jo_amount!=0 AND a.paid=1
		ORDER BY a.production_status DESC, c.department ASC";
		
 $q=mysql_query($s) or die(mysql_fetch_assoc());
 $r=mysql_fetch_assoc($q);
 $x=1;
 echo "<div class='w3-container'><table class='w3-table w3-tiny' border='1'>
		<tr class='w3-green'>
			<td>BRANCH</td>
			<td>JO STATUS</td>
			<td>PRODUCTION STATUS</td>
			<td>JO NO</td>
			<td>CREATED DATE</td>
			<td>CLIENT</td>
			<td>JO AMOUNT</td>
			<td>PAYMENT</td>
			<td>TOTAL DR</td>
		</tr>
		";
 
 do{
		$b_id=$r['b_id'];
		$s1="SELECT SUM(dr_qty*b_amount) AS dr_total FROM sales_bookings_details WHERE b_id='$b_id'";
		$q1=mysql_query($s1) or die(mysql_error());
		$r1=mysql_fetch_assoc($q1);	
	
		if($r['jo_amount']==$r1['dr_total'])
		{
			echo "<tr class='w3-hover-pale-green'>
					<td><i>".$x++.".</i> ".$r['department']."</td>";
					
					if($r['delivered']==1)
					{ echo "<td class='w3-blue'>COMPLETED</td>"; }
				else{ echo "<td class='w3-red'>NOT COMPLETED</td>"; }
					
					if($r['production_status']==1)
					{ echo "<td class='w3-lime'>READY - IN FG</td>"; }
				elseif($r['production_status']==8)
					{ echo "<td class='w3-pink'>REMOVE FROM FG</td>"; }
				elseif($r['production_status']==9)
					{ echo "<td class='w3-blue'>DELIVERED</td>"; }
				else{ echo "<td class='w3-sand'>INPROGRESS</td>"; }
					
					
			  echo "<td><b><a href='script_sales_fg_tagging.php?find_system_jo=".$r['jo_no']."' target='_blank'>".$r['jo_no']."</a></b></td>
					<td>".date('F d, Y',strtotime($r['created_datetime'],2))."</td>
					<td>".$r['name']."</td>
					<td><b>".$r['jo_amount']."</b></td>
					<td><b>".$r['jo_payment_amount']."</b></td>
					<td><b>".$r1['dr_total']."</b></td>";
			echo "</tr>";
		}else{}  

	}while($r=mysql_fetch_assoc($q));
	
 echo "</table><a href='script_sales_fg_cleaner.php?xxx=1' target='_blank'>if JO=DR=OR { remove from fg }</a></div>";
}
?>