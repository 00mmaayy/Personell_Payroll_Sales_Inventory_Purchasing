<?php
if(isset($_REQUEST['search']) and $_REQUEST['search']=="past_due")
{
	$sdate=$_REQUEST['sdate'];
	$edate=$_REQUEST['edate'];
	
	if(isset($_REQUEST['hanapin']))
	{
		$branch=$_REQUEST['branch'];
		if($branch!='ALL')
		{ $ggg="and c.department='$branch'"; }
		else
		{ $ggg=""; }
	}
	else { $ggg=""; }
	
echo "<form class='w3-tiny'>
		<input name='sdate' type='hidden' value='".$sdate."'>
		<input name='edate' type='hidden' value='".$edate."'>
		<input name='search' type='hidden' value='".$_REQUEST['search']."'>
		<select name='branch'>";
			echo "<option>".$_REQUEST['branch']."</option>";
			echo "<option>ALL</option>";
			$sa="select users.department as dept,count(department) from users inner join sales_jo on sales_jo.created_by=users.username group by users.department";
			$qa=mysql_query($sa);
			$ra=mysql_fetch_assoc($qa);
			do{
				echo "<option>".$ra['dept']."</option>"; 
			}while($ra=mysql_fetch_assoc($qa));
  echo "</select>
		<input name='hanapin' type='submit' value='FILTER'>
	  </form>";
		
		

//-------------------------------------------------------
/* UNEARNED
if($username!='collections'){
//Based on jo_actual_date
	$sg="select (select sum(dr_qty*b_amount) from sales_bookings_details where b_id=a.b_id) as dr_total,
				b.name as name,
				c.department as department,
				a.*
		 from sales_jo as a
		 inner join sales_clients as b on a.client_id=b.client_id
		 inner join users as c on a.created_by=c.username
		 where a.jo_actual_date>='$sdate' 
		 and a.jo_actual_date<='$edate'
		 and paid=0
		 and (select sum(dr_qty*b_amount) from sales_bookings_details where b_id=a.b_id)=0
		 and jo_amount!=0 $ggg
		 order by b.name asc, a.jo_actual_date desc";
	
	$qg=mysql_query($sg) or die(mysql_error());
	$rg=mysql_fetch_assoc($qg);
	$count=mysql_num_rows($qg);
	
	
	//Totals Based on jo_actual_date
	$sg4="select sum(a.jo_amount) as jo_amount_total,
				 sum(a.jo_payment_amount) as jo_payment_amount_total
		 from sales_jo as a
		 inner join sales_clients as b on a.client_id=b.client_id
		 inner join users as c on a.created_by=c.username
		 where a.jo_actual_date>='$sdate' 
		 and a.jo_actual_date<='$edate'
		 and paid=0
		 and (select sum(dr_qty*b_amount) from sales_bookings_details where b_id=a.b_id)=0
		 and jo_amount!=0 $ggg";
	
	$qg4=mysql_query($sg4) or die(mysql_error());
	$rg4=mysql_fetch_assoc($qg4);
	
	
	echo "<table class='table w3-tiny' border='1'>
			<tr class='w3-light-blue'>";
		  echo "<td colspan='7'><b>$count</b> Past Due J.O. as of ".date('F d, Y',strtotime($sdate))." - ".date('F d, Y',strtotime($edate))." BASED ON ACTUAL JO DATE</td>
				<td align='right'>JO TOTAL AMOUNT: <b class='w3-text-red'>".number_format($rg4['jo_amount_total'],2)."</b></td>
				<td align='right'>DR TOTAL AMOUNT: <b class='w3-text-red'>".number_format($rg4['dr_gtotal'],2)."</b></td>
				<td align='right'>PAYMENT TOTAL AMOUNT: <b class='w3-text-red'>".number_format($rg4['jo_payment_amount_total'],2)."</b></td>
				<td align='right'>ADVANCE TOTAL: <b class='w3-text-red'>".number_format($rg4['jo_payment_amount_total'],2)."</b></td>
			</tr>
			<tr class='w3-light-gray'>
				<td>CLIENT</td>
				<td>BRANCH</td>
				<td>JO BY</td>
				<td>JO ACTUAL</td>
				<td>JO ACTUAL DATE</td>
				<td>PO NO</td>
				<td>DR DATE</td>
				<td align='right'>JO AMOUNT</td>
				<td align='right'>DR AMOUNT</td>
				<td align='right'>APPLIED PAYMENT</td>
				<td align='right'>DR ADVANCE</td>
			</tr>";
	do { 
		echo "<tr class='w3-hover-pale-red'>
				<td><a href='admin_sales.php?client_id=".$rg['client_id']."&client=".$rg['name']."&sales=1&newjobs=1&create_quotation=1' target='_blank'>".$rg['name']."</a></td>
				<td>".$rg['department']."</td>
				<td>".$rg['created_by']."</td>
				<td>".$rg['jo_actual']."</td>
				<td>".$rg['jo_actual_date']."</td>
				<td>".$rg['po_no']."</td>
				<td class='w3-text-deep-orange'>".$rg['dr_date']."</td>
				<td align='right' class='w3-text-indigo'><b>".number_format($rg['jo_amount'],2)."</b></td>
				<td align='right' class='w3-text-blue'><b>".number_format($rg['dr_total'],2)."</b></td>
				<td align='right' class='w3-text-green'><b>".number_format($rg['jo_payment_amount'],2)."</b></td>
				<td align='right' class='w3-text-purple'><b>".number_format($rg['jo_payment_amount'],2)."</b></td>
				";
		echo "</tr>";
	} while($rg=mysql_fetch_assoc($qg));
	echo "</table>";
}
*/	
	
//-------------------------------------------------------
	//Based on dr_actual_date
	$sg="select (select sum(dr_qty*b_amount) from sales_bookings_details where b_id=a.b_id) as dr_total,
				b.name as name,
				b.vip as vip,
				c.department as department,
				a.*
		 from sales_jo as a
		 left join sales_clients as b on a.client_id=b.client_id
		 left join users as c on a.created_by=c.username
		 where (select dr_date from sales_bookings_details where b_id=a.b_id group by dr_date order by dr_date desc limit 1)>='$sdate' 
		 and (select dr_date from sales_bookings_details where b_id=a.b_id group by dr_date order by dr_date desc limit 1)<='$edate'  
		 and a.paid=0
		 and a.jo_amount!=0 $ggg
		 order by b.name asc, a.jo_actual_date desc";
	
	$qg=mysql_query($sg) or die(mysql_error());
	$rg=mysql_fetch_assoc($qg);
	
	$count=mysql_num_rows($qg);
	
	
	//Totals Based on dr_actual_date
	$sg4="select sum(a.jo_amount) as jo_amount_total,
				 sum(a.jo_payment_amount) as payment_amount_total
		 from sales_jo as a
		 inner join sales_clients as b on a.client_id=b.client_id
		 inner join users as c on a.created_by=c.username
		 where (select dr_date from sales_bookings_details where b_id=a.b_id and dr_date!='0000-00-00' group by dr_date order by dr_date asc limit 1)>='$sdate' 
		 and (select dr_date from sales_bookings_details where b_id=a.b_id and dr_date!='0000-00-00' group by dr_date order by dr_date desc limit 1)<='$edate'  
		 and a.paid=0
		 and a.jo_amount!=0 $ggg";
	$qg4=mysql_query($sg4) or die(mysql_error());
	$rg4=mysql_fetch_assoc($qg4);
	
	$sg5="select sum(f.dr_qty*f.b_amount) as dr_gtotal
		 from sales_jo as a
		 inner join sales_bookings_details as f on a.b_id=f.b_id
		 inner join sales_clients as b on a.client_id=b.client_id
		 inner join users as c on a.created_by=c.username
		 where (select dr_date from sales_bookings_details where b_id=a.b_id and dr_date!='0000-00-00' group by dr_date order by dr_date asc limit 1)>='$sdate' 
		 and (select dr_date from sales_bookings_details where b_id=a.b_id and dr_date!='0000-00-00' group by dr_date order by dr_date desc limit 1)<='$edate'  
		 and a.paid=0
		 and a.jo_amount!=0 $ggg";
	$qg5=mysql_query($sg5) or die(mysql_error());
	$rg5=mysql_fetch_assoc($qg5);
	
	
	echo "<table class='table w3-tiny' border='1'>
			<tr class='w3-light-blue'>";
		  echo "<td colspan='10'><b>$count</b> Past Due J.O. as of ".date('F d, Y',strtotime($sdate))." - ".date('F d, Y',strtotime($edate))." BASED ON ACTUAL DR DATE</td>
				<td align='right'>JO TOTAL AMOUNT: <b class='w3-text-red'>".number_format($rg4['jo_amount_total'],2)."</b></td>
				<td align='right'>DR TOTAL AMOUNT: <b class='w3-text-red'>".number_format($rg5['dr_gtotal'],2)."</b></td>
				<td align='right'>PAYMENT TOTAL AMOUNT: <b class='w3-text-red'>".number_format($rg4['payment_amount_total'],2)."</b></td>
				<td align='right'>JO BALANCE AMOUNT: <b class='w3-text-red'>".number_format($rg4['jo_amount_total']-$rg4['payment_amount_total'],2)."</b></td>
				<td align='right'>DR BALANCE AMOUNT: <b class='w3-text-red'>".number_format($rg5['dr_gtotal']-$rg4['payment_amount_total'],2)."</b></td>
			</tr>
			<tr class='w3-light-gray'>
				<td>PAY TYPE</td>
				<td>CLIENT</td>
				<td>BRANCH</td>
				<td>JO</td>
				<td>JO ACTUAL</td>
				<td>PO NO</td>
				<td>DR DETAILS</td>
				<td>DAYS<br/>PAST DUE</td>
				<td>TERMS<br/>DETAILS</td>
				<td align='right'>JO AMOUNT</td>
				<td align='right'>DR AMOUNT</td>
				<td align='right'>APPLIED PAYMENT</td>
				<td align='right'>PAYMENT DETAILS</td>
				<td align='right'>JO BALANCE</td>
				<td align='right'>DR BALANCE</td>
			</tr>";
	do { 
		echo "<tr class='w3-hover-pale-red'>
				<td>";
					switch($rg['vip'])
					{
						case 0: echo "Cash"; break;
						case 1: echo "VIP"; break;
						case 2: echo "Government"; break;
						case 3: echo "COD"; break;
						case 4: echo "X-Deal"; break;
						case 5: echo "Account"; break;
					}	
				echo "</td>
				<td><a href='admin_sales.php?client_id=".$rg['client_id']."&client=".$rg['name']."&sales=1&newjobs=1&create_quotation=1' target='_blank'>".$rg['name']."</a>
				</td>
				<td>".$rg['department']."</td>
				<td><b>".$rg['jo_no']."</b><br/>".date('m/d/Y',strtotime($rg['created_datetime']))."<br/>".date('h:i a',strtotime($rg['created_datetime']))."</td>
				<td><b>".$rg['jo_actual']."</b><br/>".date('m/d/Y',strtotime($rg['jo_actual_date']))."</td>
				<td>".$rg['po_no']."</td>
				
				<td class='w3-text-deep-orange'>";
				$b_id=$rg['b_id'];
				$qbid=mysql_query("select dr_no,dr_date,dr_qty,b_amount from sales_bookings_details where b_id='$b_id'") or die(mysql_error());
				$rbid=mysql_fetch_assoc($qbid);
				do{
					echo $rbid['dr_no']." / <span class='w3-text-blue'>".number_format($rbid['dr_qty']*$rbid['b_amount'],2)."</span> / ".date('m/d/Y',strtotime($rbid['dr_date']))."<br/>";
				}while($rbid=mysql_fetch_assoc($qbid));
				
		  echo "</td>
				<td>";
					
					//date past due couter
					$qbid1=mysql_query("select dr_date from sales_bookings_details where b_id='$b_id'") or die(mysql_error());
					$rbid1=mysql_fetch_assoc($qbid1);
					$datexx=$rbid1['dr_date'];
					$dr_date_old = strtotime($rbid1['dr_date']);
					$now = strtotime(date('Y-m-d'));
					$day = ((($now-$dr_date_old)/3600)/24);
					
					$client_id=$rg['client_id'];
					$qxxy=mysql_query("select terms from sales_clients where client_id=$client_id");
					$rxxy=mysql_fetch_assoc($qxxy);
					$terms_set=$rxxy['terms']; 
					
					if($rxxy['terms']!=0)
					{ 
						if($day>$terms_set)
						{
							$days_due=$day-$terms_set;
							echo "Days Due: <b class='w3-text-red'>".$days_due."</b>";
						}
						else
						{
							echo "Date Due: <b class='w3-text-blue'>".date('m/d/Y', strtotime($datexx.' + '.$terms_set.' days'))."</b>";
						}
					}
					else{ echo "Days Due: <b class='w3-text-red'>".$day."</b>"; }
						
		  echo "</td>";
			
		  echo "<td>";
		  
					if($rxxy['terms']!=0)
					{ 
						echo "<span class='w3-text-blue'>Terms: ".$terms_set."</span><br/>";
						if($day>$terms_set)
						{
							$days_due=$day-$terms_set;
							echo "Due Date: <br/><span class='w3-text-red'>".date('m/d/Y', strtotime($datexx.' + '.$days_due.' days'))."</span>"; 
						}
						else{}
					}
					else{ echo "Due Date: <br/><span class='w3-text-red'>".date('m/d/Y', strtotime($datexx.' + '.$day.' days'))."</span>"; }
					
		  echo "</td>";
			
		  echo "<td align='right' class='w3-text-indigo'><b>".number_format($rg['jo_amount'],2)."</b></td>
				<td align='right' class='w3-text-blue'><b>".number_format($rg['dr_total'],2)."</b></td>
				<td align='right' class='w3-text-green'><b>".number_format($rg['jo_payment_amount'],2)."</b></td>";
			
		  echo "<td>";	
				$jo_nox=$rg['jo_no'];
				$qbid1=mysql_query("select * from sales_jo_payments where jo_no=$jo_nox") or die(mysql_error());
				$rbid1=mysql_fetch_assoc($qbid1);
				$orcount=mysql_num_rows($qbid1);
				
				if($orcount!=0)
				{
					echo "<table class='w3-tiny' border='1'>
							<tr><td>PAYMNT</td><td>RSNO</td><td>ORNO</td><td>ORDATE</td></tr>";
					do{
						echo "<tr><td>".number_format($rbid1['payment'],2)."</td><td>".$rbid1['rs_no']."</td><td>".$rbid1['or_no']."</td><td>".date('m/d/Y',strtotime($rbid1['or_date']))."</td></tr>";
					}while($rbid1=mysql_fetch_assoc($qbid1));
					echo "</table>";
				}else{}
				
		  echo "</td>";		
				
		  echo "<td align='right' class='w3-text-red'><b>".number_format(($rg['jo_amount']-$rg['jo_payment_amount']),2)."</b></td>
				<td align='right' class='w3-text-red'><b>".number_format(($rg['dr_total']-$rg['jo_payment_amount']),2)."</b></td>
				";
		echo "</tr>";
	} while($rg=mysql_fetch_assoc($qg));
	echo "</table>";
	
}
?>