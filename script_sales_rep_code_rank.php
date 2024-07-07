<?php
if(isset($_REQUEST['search']) and $_REQUEST['search']=="code_rank")
{
	     if(isset($_REQUEST['code_name'])) { $sort11="ORDER BY a.code_set ASC"; }
	else if(isset($_REQUEST['code']))	   { $sort11="ORDER BY code_top DESC"; }
	else if(isset($_REQUEST['total']))	   { $sort11="ORDER BY total_amount DESC"; } 
	else { $sort11="ORDER BY code_top DESC"; }
	
	$ss="SELECT a.code_set, COUNT(*) code_top, SUM(a.dr_qty*a.b_amount) total_amount 
	     FROM sales_bookings_details AS a
		 INNER JOIN sales_jo AS c ON a.b_id=c.b_id
		 WHERE a.dr_date!='0000-00-00' AND a.dr_date>='$sdate' AND a.dr_date<='$edate'
		 GROUP BY a.code_set
		 $sort11";
	$qq=mysql_query($ss) or die(mysql_error());
	$rr=mysql_fetch_assoc($qq);
	
	
	
	$ss_t="SELECT SUM(a.dr_qty*a.b_amount) total1
	       FROM sales_bookings_details AS a
		   INNER JOIN sales_jo AS c ON a.b_id=c.b_id
		   WHERE a.dr_date!='0000-00-00' AND a.dr_date>='$sdate' AND a.dr_date<='$edate'";
	$qq_t=mysql_query($ss_t) or die(mysql_error());
	$rr_t=mysql_fetch_assoc($qq_t);
	
	
	$x=1;
	echo "<div class='container'>";
	echo "<table class='w3-small table' border='1'>
			<tr align='center'>
				<td colspan='4'>
					<b class='w3-text-red'> CODE RANK (Based on DR ACTUAL DATE) </b>"; ?>
					
					<form class='w3-tiny'>
						<input name='sort3' type='hidden' value=''>
						<input name='sdate' type='hidden' value='<?php echo $_REQUEST['sdate']; ?>'>
						<input name='edate' type='hidden' value='<?php echo $_REQUEST['edate']; ?>'>
						<input name='search' type='hidden' value='code_rank'>
						<input name='code_name' type='submit' value='SORT BY CODE NAME'>
						<input name='code' type='submit' value='SORT BY CODE TOTAL'>
						<input name='total' type='submit' value='SORT BY AMOUNT TOTAL'>
					</form>
					
	<?php echo "<b class='w3-text-indigo'>TOTAL: ".number_format($rr_t['total1'],2)."</td>
			</tr>
			<tr class='w3-green' align='center'>
				<td>RANK</td>
				<td>SALES CODE</td>
				<td>TRANSACTION COUNT</td>
				<td>TOTAL AMOUNT</td>
			</tr>";
	do{
	echo "<tr class='w3-hover-pale-red'>
			<td align='center'>".$x++."</td>
			<td><b><a target='_blank' href='script_sales_monitoring.php?branch=ALL&code_rank=1&code_set=".$rr['code_set']."&sdate=".$_REQUEST['sdate']."&edate=".$_REQUEST['edate']."'>".$rr['code_set']." - ";
			
			$xxq=mysql_query("select code_name from sales_codes where code_set='".$rr['code_set']."'") or die(mysql_error());
			$xxr=mysql_fetch_assoc($xxq);
			echo $xxr['code_name'];
			
			echo "</a></b></td>
			<td align='center'>".$rr['code_top']."</td>
			<td align='right'><b class='w3-text-indigo'>".number_format($rr['total_amount'],2)."</b></td>
		  </tr>"; 
	}while($rr=mysql_fetch_assoc($qq));	
	echo "</table>";
	echo "</div>";
}
?>