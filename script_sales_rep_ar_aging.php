<?php
if(isset($_REQUEST['search']) and $_REQUEST['search']=="ar_aging")
{
	$s9="select a.dr_no, 
	            a.dr_date, 
				a.dr_qty, 
				a.b_amount, 
				b.jo_no,
				b.jo_amount,
			    b.jo_payment_amount,
				c.name, 
				c.terms, 
				d.department
		from sales_bookings_details a
		left join sales_jo b 
			on a.b_id=b.b_id
		left join sales_clients c 
			on b.client_id=c.client_id	
		left join users d 
			on b.created_by=d.username	
		where b.paid=0 and a.dr_no!=0
		order by a.dr_date desc";
	$q9=mysql_query($s9) or die(mysql_error());
	$r9=mysql_fetch_assoc($q9);
	$countxx=mysql_num_rows($q9);
	
	//current date
	$date1=date('Y-m-d');
	$date2=date('Y-m-d', strtotime($r9['dr_date'].' - 10 days'));
	$date3=date('Y-m-d', strtotime($r9['dr_date'].' - 30 days'));
	$date4=date('Y-m-d', strtotime($r9['dr_date'].' - 60 days'));
	$date5=date('Y-m-d', strtotime($r9['dr_date'].' - 120 days'));
	$date6=date('Y-m-d', strtotime($r9['dr_date'].' - 180 days'));
	$date7=date('Y-m-d', strtotime($r9['dr_date'].' - 360 days'));
	
	$s91="select sum(a.dr_qty * a.b_amount - b.jo_payment_amount) as current_total
		from sales_bookings_details a
		inner join sales_jo b 
			on a.b_id=b.b_id
		where b.paid=0 and a.dr_no!=0 and a.dr_date>='$date1'";
	$q91=mysql_query($s91) or die(mysql_error());
	$r91=mysql_fetch_assoc($q91);
	
	
	$s92="select sum(a.dr_qty * a.b_amount - b.jo_payment_amount) as current_total
		from sales_bookings_details a
		inner join sales_jo b 
			on a.b_id=b.b_id
		where b.paid=0 and a.dr_no!=0 and a.dr_date<'$date1' and a.dr_date>'$date2'";
	$q92=mysql_query($s92) or die(mysql_error());
	$r92=mysql_fetch_assoc($q92);
	
	$s93="select sum(a.dr_qty * a.b_amount - b.jo_payment_amount) as current_total
		from sales_bookings_details a
		inner join sales_jo b 
			on a.b_id=b.b_id
		where b.paid=0 and a.dr_no!=0 and a.dr_date<'$date2' and a.dr_date>'$date3'";
	$q93=mysql_query($s93) or die(mysql_error());
	$r93=mysql_fetch_assoc($q93);
	
	$s94="select sum(a.dr_qty * a.b_amount - b.jo_payment_amount) as current_total
		from sales_bookings_details a
		inner join sales_jo b 
			on a.b_id=b.b_id
		where b.paid=0 and a.dr_no!=0 and a.dr_date<'$date3' and a.dr_date>'$date4'";
	$q94=mysql_query($s94) or die(mysql_error());
	$r94=mysql_fetch_assoc($q94);
	
	$s95="select sum(a.dr_qty * a.b_amount - b.jo_payment_amount) as current_total
		from sales_bookings_details a
		inner join sales_jo b 
			on a.b_id=b.b_id
		where b.paid=0 and a.dr_no!=0 and a.dr_date<'$date4' and a.dr_date>'$date5'";
	$q95=mysql_query($s95) or die(mysql_error());
	$r95=mysql_fetch_assoc($q95);
	
	$s96="select sum(a.dr_qty * a.b_amount - b.jo_payment_amount) as current_total
		from sales_bookings_details a
		inner join sales_jo b 
			on a.b_id=b.b_id
		where b.paid=0 and a.dr_no!=0 and a.dr_date<'$date5' and a.dr_date>'$date6'";
	$q96=mysql_query($s96) or die(mysql_error());
	$r96=mysql_fetch_assoc($q96);
	
	$s97="select sum(a.dr_qty * a.b_amount - b.jo_payment_amount) as current_total
		from sales_bookings_details a
		inner join sales_jo b 
			on a.b_id=b.b_id
		where b.paid=0 and a.dr_no!=0 and a.dr_date<'$date6' and a.dr_date>'$date7'";
	$q97=mysql_query($s97) or die(mysql_error());
	$r97=mysql_fetch_assoc($q97);
	
	$s98="select sum(a.dr_qty * a.b_amount - b.jo_payment_amount) as current_total
		from sales_bookings_details a
		inner join sales_jo b 
			on a.b_id=b.b_id
		where b.paid=0 and a.dr_no!=0 and a.dr_date<'$date7'";
	$q98=mysql_query($s98) or die(mysql_error());
	$r98=mysql_fetch_assoc($q98);
	
	
	
	
	
	echo "<table class='w3-table w3-tiny' border='1'>";
	  echo "<tr><td colspan='18'>Sorted by Date Delivered (DR DATE)</td></tr>";
	  echo "<tr class='w3-green'>
				<td>DR NO</td>
				<td>TERMS</td>
				<td>CLIENT</td>
				<td>BRANCH</td>
				<td>JO</td>
				<td>JO AMOUNT</td>
				<td class='w3-red'>DATE DELIVERED</td>
				<td>DR AMOUNT</td>
				<td>PAYMENT</td>
				<td>DATE DUE</td>
				<td>CURRENT DAY</td>
				<td><=10 days</td>
				<td>> 10 days<br/><=30 days</td>
				<td>> 30 days<br/><=60 days</td>
				<td>> 60 days<br/><=120 days</td>
				<td>> 120 days<br/><=180 days</td>
				<td>> 180 days<br/><=360 days</td>
				<td>> 360 days</td>
			</tr>";
			
	  echo "<tr class='w3-pale-green'>
				<td>count: ".$countxx."</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td class='w3-pale-red'></td>
				<td></td>
				
				<td></td>
				<td></td>
				<td><b>".number_format($r91['current_total'],2)."</b></td>
				<td><b>".number_format($r92['current_total'],2)."</b></td>
				<td><b>".number_format($r93['current_total'],2)."</b></td>
				<td><b>".number_format($r94['current_total'],2)."</b></td>
				<td><b>".number_format($r95['current_total'],2)."</b></td>
				<td><b>".number_format($r96['current_total'],2)."</b></td>
				<td><b>".number_format($r97['current_total'],2)."</b></td>
				<td><b>".number_format($r98['current_total'],2)."</b></td>
			
			</tr>";
			
	do{
		if($r9['terms']==0){
		echo "<tr class='w3-hover-light-gray'>";
		}else{
		echo "<tr class='w3-pale-blue w3-hover-light-gray'>";
		}
			echo "<td>".$r9['dr_no']."</td>";
			echo "<td>".$r9['terms']."</td>";
			echo "<td>".$r9['name']."</td>";
			echo "<td>".$r9['department']."</td>";
			echo "<td>".$r9['jo_no']."</td>";	
			echo "<td align='right'>".number_format($r9['jo_amount'],2)."</td>";
			echo "<td class='w3-pale-red' align='right'>".$r9['dr_date']."</td>";
			
			$dr_total=$r9['dr_qty']*$r9['b_amount'];
			echo "<td align='right'>".number_format($dr_total,2)."</td>";
			echo "<td align='right'>".number_format($r9['jo_payment_amount'],2)."</td>";
			$aging=$dr_total-$r9['jo_payment_amount'];
			
			echo "<td>".date('Y-m-d', strtotime($r9['dr_date'].' + '.$r9['terms'].' days'))."</td>";
					
			$dr_date_old = strtotime($r9['dr_date']);
			$now = strtotime(date('Y-m-d'));
			$day = ((($now-$dr_date_old)/3600)/24);
			
			echo "<td align='right'>";
				if($day < 1){ echo number_format($aging,2); }else{}
			echo "</td>";
			
			echo "<td align='right'>";
				if($day > 0 and $day <= 10){ echo number_format($aging,2); }else{}
			echo "</td>";
			
			echo "<td align='right'>";
				if($day > 10 and $day <= 30){ echo number_format($aging,2); }else{}
			echo "</td>";
			
			echo "<td align='right'>";
				if($day > 30 and $day <= 60){ echo number_format($aging,2); }else{}
			echo "</td>";
			
			echo "<td align='right'>";
				if($day > 60 and $day <= 120){ echo number_format($aging,2); }else{}
			echo "</td>";
			
			echo "<td align='right'>";
				if($day > 120 and $day <= 180){ echo number_format($aging,2); }else{}
			echo "</td>";
			
			echo "<td align='right'>";
				if($day > 180 and $day <= 360){ echo number_format($aging,2); }else{}
			echo "</td>";
			
			echo "<td align='right'>";
				if($day > 360){ echo number_format($aging,2); }else{}
			echo "</td>";
		
		echo "</tr>";
		
		
	}while($r9=mysql_fetch_assoc($q9));
	echo "</table>";
}
?>