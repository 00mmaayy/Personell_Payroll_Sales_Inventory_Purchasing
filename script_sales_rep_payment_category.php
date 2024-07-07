<?php 
if(isset($_REQUEST['search']) and $_REQUEST['search']=="payment_category")
{
	$ss="SELECT 
			(SELECT SUM(payment) FROM sales_jo_payments WHERE or_date>='$sdate' AND or_date<='$edate') AS total,
			(SELECT SUM(payment) FROM sales_jo_payments WHERE pay_mode='Cash' AND or_date>='$sdate' AND or_date<='$edate') AS cash,
			(SELECT SUM(payment) FROM sales_jo_payments WHERE pay_mode='Cheque' AND or_date>='$sdate' AND or_date<='$edate') AS cheque,
			(SELECT SUM(payment) FROM sales_jo_payments WHERE pay_mode='Discount' AND or_date>='$sdate' AND or_date<='$edate') AS discount,
			(SELECT SUM(payment) FROM sales_jo_payments WHERE pay_mode='2306' AND or_date>='$sdate' AND or_date<='$edate') AS w2306,
			(SELECT SUM(payment) FROM sales_jo_payments WHERE pay_mode='2307' AND or_date>='$sdate' AND or_date<='$edate') AS w2307
		";
	
	$qq=mysql_query($ss) or die(mysql_error());
	$rr=mysql_fetch_assoc($qq);
	
  echo "<br/><br/><div class='container'>
		<table class='table' border='1'>
			
					<i> Report from </i> <b> ".date('F d, Y',strtotime($_REQUEST['sdate']))." </b> <i> to </i> <b> ".date('F d, Y',strtotime($_REQUEST['edate']))." </b> <i> (Based on Payments O.R. DATE) </i>
					<br/><b class='w3-text-indigo w3-large'>Total: ".number_format(round($rr['total']-$rr['discount']-$rr['w2306']-$rr['w3-2307'],2),2)."</b>
			
			<tr class='w3-green' align='center'>
				<td>CASH</td>
				<td>CHEQUE</td>
				<td>SALES DISCOUNT</td>
				<td>WITHHELD 2306</td>
				<td>WITHHELD 2307</td>";
	  echo "<tr align='center'>
				<td>".number_format(round($rr['cash'],2),2)."</td>
				<td>".number_format(round($rr['cheque'],2),2)."</td>
				<td class='w3-text-red'>".number_format(round($rr['discount'],2),2)."</td>
				<td class='w3-text-red'>".number_format(round($rr['w2306'],2),2)."</td>
				<td class='w3-text-red'>".number_format(round($rr['w2307'],2),2)."</td>
			</tr>
		</table>
		</div><br/><br/>";		
	
}
?>