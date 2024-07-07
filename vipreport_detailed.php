<?php 
include('connection/conn.php');
include("css.php");

if(isset($_REQUEST['year'])){ $year=$_REQUEST['year']; }
else { $year=date("Y"); }

?>
<title>VIP REPORT</title>
<body>
	<div class='w3-container'><br/>
	<div align='center'><a class='w3-xlarge' href="javascript:window.open('','_self').close();">X</a></div>
	<table class='table' border='1'>
		
		<?php
		//WHICH BRANCH
		if(isset($_REQUEST['jo_main'])){ $branch1="MAIN BRANCH"; $branch="SALES"; $sorting1="<input name='jo_main' type='hidden' value='1'>"; $bch="main"; }else{}
		if(isset($_REQUEST['jo_sm'])){ $branch1="SM BRANCH"; $branch="SM SALES"; $sorting1="<input name='jo_sm' type='hidden' value='1'>"; $bch="sm"; }else{}
		if(isset($_REQUEST['jo_rzl'])){ $branch1="RIZAL BRANCH"; $branch="RIZAL SALES"; $sorting1="<input name='jo_rzl' type='hidden' value='1'>"; $bch="rzl"; }else{}
		if(isset($_REQUEST['jo_sp'])){ $branch1="SANPEDRO BRANCH"; $branch="SANPEDRO SALES"; $sorting1="<input name='jo_sp' type='hidden' value='1'>"; $bch="sp"; }else{}
		if(isset($_REQUEST['jo_sj'])){ $branch1="SANJOSE BRANCH"; $branch="SANJOSE SALES"; $sorting1="<input name='jo_sj' type='hidden' value='1'>"; $bch="sj"; }else{}
		
		//REPORT SCHEDULE
		if(isset($_REQUEST['current_day']))
		{	$sdate=date("Y-m-d")." 00:00:00"; $edate=date("Y-m-d")." 23:59:59";
			$sdate1=date("Y-m-d"); $edate1=date("Y-m-d");
			$sorting2="<input name='current_day' type='hidden' value='1'>";
		}else{}
			
		if(isset($_REQUEST['1day_ago']))
		{   $sdate=date(("Y-m-d"),strtotime("-1 day"))." 00:00:00"; $edate=date(("Y-m-d"),strtotime("-1 day"))." 23:59:59";
			$sdate1=date(("Y-m-d"),strtotime("-1 day")); $edate1=date(("Y-m-d"),strtotime("-1 day")); 
			$sorting2="<input name='1day_ago' type='hidden' value='1'>";
		}else{}
			
		if(isset($_REQUEST['2day_ago']))
		{   $sdate=date(("Y-m-d"),strtotime("-2 day"))." 00:00:00"; $edate=date(("Y-m-d"),strtotime("-2 day"))." 23:59:59";
			$sdate1=date(("Y-m-d"),strtotime("-2 day")); $edate1=date(("Y-m-d"),strtotime("-2 day")); 
			$sorting2="<input name='2day_ago' type='hidden' value='1'>";
		}else{}
			
		if(isset($_REQUEST['3day_ago']))
		{   $sdate=date(("Y-m-d"),strtotime("-3 day"))." 00:00:00"; $edate=date(("Y-m-d"),strtotime("-3 day"))." 23:59:59";
			$sdate1=date(("Y-m-d"),strtotime("-3 day")); $edate1=date(("Y-m-d"),strtotime("-3 day")); 
			$sorting2="<input name='3day_ago' type='hidden' value='1'>";
		}else{}
			
		if(isset($_REQUEST['4day_ago']))
		{   $sdate=date(("Y-m-d"),strtotime("-4 day"))." 00:00:00"; $edate=date(("Y-m-d"),strtotime("-4 day"))." 23:59:59";
			$sdate1=date(("Y-m-d"),strtotime("-4 day")); $edate1=date(("Y-m-d"),strtotime("-4 day")); 
			$sorting2="<input name='4day_ago' type='hidden' value='1'>";
		}else{}	
		
		
		if(isset($_REQUEST['m_dec']))
		{	$sdate=$year."-12-01 00:00:00"; $edate=$year."-12-31 23:59:59";
			$sdate1=$year."-12-01"; $edate1=$year."-12-31"; 
			$sorting2="<input name='m_dec' type='hidden' value='1'>";
		}else{}
		
		if(isset($_REQUEST['m_nov']))
		{	$sdate=$year."-11-01 00:00:00"; $edate=$year."-11-31 23:59:59";
			$sdate1=$year."-11-01"; $edate1=$year."-11-31"; 
			$sorting2="<input name='m_nov' type='hidden' value='1'>";
		}else{}

		if(isset($_REQUEST['m_oct']))
		{	$sdate=$year."-10-01 00:00:00"; $edate=$year."-10-31 23:59:59";
			$sdate1=$year."-10-01"; $edate1=$year."-10-31"; 
			$sorting2="<input name='m_oct' type='hidden' value='1'>";
		}else{}

		if(isset($_REQUEST['m_sep']))
		{	$sdate=$year."-09-01 00:00:00"; $edate=$year."-09-31 23:59:59";
			$sdate1=$year."-09-01"; $edate1=$year."-09-31"; 
			$sorting2="<input name='m_sep' type='hidden' value='1'>";
		}else{}
			
		if(isset($_REQUEST['m_aug']))
		{	$sdate=$year."-08-01 00:00:00"; $edate=$year."-08-31 23:59:59";
			$sdate1=$year."-08-01"; $edate1=$year."-08-31"; 
			$sorting2="<input name='m_aug' type='hidden' value='1'>";
		}else{}
			
		if(isset($_REQUEST['m_jul']))
		{	$sdate=$year."-07-01 00:00:00"; $edate=$year."-07-31 23:59:59";
			$sdate1=$year."-07-01"; $edate1=$year."-07-31"; 
			$sorting2="<input name='m_jul' type='hidden' value='1'>";
		}else{}

		if(isset($_REQUEST['m_jun']))
		{	$sdate=$year."-06-01 00:00:00"; $edate=$year."-06-31 23:59:59";
			$sdate1=$year."-06-01"; $edate1=$year."-06-31";
			$sorting2="<input name='m_jun' type='hidden' value='1'>";
		}else{}

		if(isset($_REQUEST['m_may']))
		{	$sdate=$year."-05-01 00:00:00"; $edate=$year."-05-31 23:59:59";
			$sdate1=$year."-05-01"; $edate1=$year."-05-31";
			$sorting2="<input name='m_may' type='hidden' value='1'>";
		}else{}

		if(isset($_REQUEST['m_apr']))
		{	$sdate=$year."-04-01 00:00:00"; $edate=$year."-04-31 23:59:59";
			$sdate1=$year."-04-01"; $edate1=$year."-04-31";
			$sorting2="<input name='m_apr' type='hidden' value='1'>";
		}else{}

		if(isset($_REQUEST['m_mar']))
		{	$sdate=$year."-03-01 00:00:00"; $edate=$year."-03-31 23:59:59";
			$sdate1=$year."-03-01"; $edate1=$year."-03-31";
			$sorting2="<input name='m_mar' type='hidden' value='1'>";
		}else{}

		if(isset($_REQUEST['m_feb']))
		{	$sdate=$year."-02-01 00:00:00"; $edate=$year."-02-31 23:59:59";
			$sdate1=$year."-02-01"; $edate1=$year."-02-31";
			$sorting2="<input name='m_feb' type='hidden' value='1'>";
		}else{}

		if(isset($_REQUEST['m_jan']))
		{	$sdate=$year."-01-01 00:00:00"; $edate=$year."-01-31 23:59:59";
			$sdate1=$year."-01-01"; $edate1=$year."-01-31";
			$sorting2="<input name='m_jan' type='hidden' value='1'>";
		}else{}	
		
		
		//JO LISTINGS
		if(isset($_REQUEST['jo_list']))
		{
		
			//$url = "http" . (($_SERVER['SERVER_PORT'] == 443) ? "s" : "") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		
		?>
			<form class="w3-small">
				<input name="jo_list" type="hidden" value="1">
				<?php echo $sorting1; ?>
				<?php echo $sorting2; ?>	
				<select name="sort">
					<option></option>
					<option value="a.jo_amount">JO AMOUNT</option>
					<option value="a.jo_no">JO NUMBER</option>
					<option value="a.bo_no">BOOKING NUMBER</option>
				</select>
				<input type="submit" value="SORT">
			</form>
	<?php	
			//LIST QUERY
			if(isset($_REQUEST['sort']))
			{ $sort=$_REQUEST['sort']; }
			else
			{ $sort='a.jo_amount'; }
			
			$s="SELECT c.name, a.jo_no, a.bo_no, a.jo_amount, a.created_datetime
				FROM sales_jo a 
				LEFT JOIN users b ON a.created_by = b.username 
				LEFT JOIN sales_clients c ON a.client_id = c.client_id
				WHERE a.created_datetime >= '$sdate' AND a.created_datetime <= '$edate' AND b.department = '$branch' AND a.jo_amount != 0
				ORDER BY $sort DESC";
			$q=mysql_query($s) or die(mysql_error());
			$r=mysql_fetch_assoc($q);
			
		  echo "<tr class='w3-green' align='center'>
					<td>".$branch1." - CLIENT</td>
					<td>JO</td>
					<td>JO CREATED</td>
					<td>BOOKING</td>
					<td>AMOUNT</td>
				</tr>";
			
			do{
			echo "<tr class='w3-hover-pale-red'>
					<td>".$r['name']."</td>
					<td><a href='vipreport_jo_details.php?jo_no=".$r['jo_no']."'>".$r['jo_no']."</a></td>
					<td>".date('m/d/Y H:i A',strtotime($r['created_datetime']))."</td>
					<td>".$r['bo_no']."</td>
					<td align='right' class='w3-text-indigo'>".number_format($r['jo_amount'],2)."</td>
				  </tr>";   
				
				$jo_total += $r['jo_amount'];
				
			}while($r=mysql_fetch_assoc($q));
			echo "<tr></tr><td colspan='4' align='right'>TOTAL:</td><td align='right' class='w3-text-indigo'><b>".number_format($jo_total,2)."</b></td>";
		}else{}
		
		
		
		//PAYMENT LISTINGS
		if(isset($_REQUEST['payment_list']))
		{
			$table="a.payment_datetime";
			
			
			?>
			<form class="w3-small">
				<input name="payment_list" type="hidden" value="1">
				<?php echo $sorting1; ?>
				<?php echo $sorting2; ?>	
				<select name="sort">
					<option></option>
					<option value="a.or_no">OR NUMBER</option>
					<option value="a.rs_no">RS NUMBER</option>
					<option value="b.jo_no">JO NUMBER</option>
					<option value="b.bo_no">BOOKING NUMBER</option>
				</select>
				<input type="submit" value="SORT">
			</form>
	<?php	
			//LIST QUERY
			if(isset($_REQUEST['sort']))
			{ $sort=$_REQUEST['sort']; }
			else
			{ $sort='a.payment'; }
			
			
			//LIST QUERY
			 $s="SELECT d.name, b.jo_no, b.bo_no, a.rs_no, a.or_no, a.or_date, a.payment, a.pay_type, a.payment_by, a.payment_datetime
				 FROM sales_jo_payments a
				 LEFT JOIN sales_jo b ON a.jo_no = b.jo_no
				 LEFT JOIN users c ON b.created_by = c.username
				 LEFT JOIN sales_clients d ON a.client_id = d.client_id
				 WHERE $table >= '$sdate' AND $table <= '$edate' AND c.department = '$branch' AND a.payment != 0
				 ORDER BY $sort DESC";
			$q=mysql_query($s) or die(mysql_error());
			$r=mysql_fetch_assoc($q);
			
			echo "<tr class='w3-green' align='center'>
					<td>".$branch1." - CLIENT</td>
					<td>JO</td>
					<td>BOOKING</td>
					<td>RS</td>
					<td>OR</td>
					<td>OR DATE</td>
					<td>PAY TYPE</td>
					<td>PAYMENT BY</td>
					<td>PAYMENT DATE</td>
					<td>PAYMENT</td>
				</tr>";
			
			do{
			echo "<tr class='w3-hover-pale-red'>
					<td>".$r['name']."</td>
					<td><a href='vipreport_jo_details.php?jo_no=".$r['jo_no']."'>".$r['jo_no']."</a></td>
					<td>".$r['bo_no']."</td>
					<td><a href='vipreport_jo_payment_details.php?jo_no=".$r['jo_no']."'>".$r['rs_no']."</a></td>
					<td>".$r['or_no']."</td>
					<td>".$r['or_date']."</td>
					<td>".$r['pay_type']."</td>
					<td>".$r['payment_by']."</td>
					<td>".date('m/d/Y H:i A',strtotime($r['payment_datetime']))."</td>
					<td align='right' class='w3-text-indigo'>".number_format($r['payment'],2)."</td>
				  </tr>"; 			

				$payment_total += $r['payment'];  
				  
			}while($r=mysql_fetch_assoc($q));
			echo "<tr></tr><td colspan='9' align='right'>TOTAL:</td><td align='right' class='w3-text-indigo'><b>".number_format($payment_total,2)."</b></td>";
		}else{}
		
		
		//DR LISTINGS
		if(isset($_REQUEST['dr_list']))
		{
			
			?>
			<form class="w3-small">
				<input name="dr_list" type="hidden" value="1">
				<?php echo $sorting1; ?>
				<?php echo $sorting2; ?>	
				<select name="sort">
					<option></option>
					<option value="a.b_amount*a.dr_qty">DR AMOUNT</option>
					<option value="a.dr_no">DR NUMBER</option>
					<option value="b.jo_no">JO NUMBER</option>
					<option value="b.bo_no">BOOKING NUMBER</option>
					<option value="a.dr_posted_date">DR POSTING DATE</option>
				</select>
				<input type="submit" value="SORT">
			</form>
	<?php	
			//LIST QUERY
			if(isset($_REQUEST['sort']))
			{ $sort=$_REQUEST['sort']; }
			else
			{ $sort='a.b_amount*a.dr_qty'; }
			
			
			//LIST QUERY
			 $s="SELECT d.name, b.jo_no, b.bo_no, a.code_set, a.b_qty, a.dr_qty, a.b_size, a.b_unit, a.b_desc, a.dr_no, a.dr_date, a.b_amount, a.dr_posted_date, a.dr_posted_by
				 FROM sales_bookings_details a
				 LEFT JOIN sales_jo b ON a.b_id = b.b_id
				 LEFT JOIN sales_clients d ON b.client_id = d.client_id
				 WHERE a.dr_date >= '$sdate1' AND a.dr_date <= '$edate1' AND a.bch = '$bch'
				 ORDER BY $sort DESC";
			$q=mysql_query($s) or die(mysql_error());
			$r=mysql_fetch_assoc($q);
			
			/* TOTAL QUERY
			$st="SELECT SUM(a.dr_qty * a.b_amount) as dr_total
				 FROM sales_bookings_details a
				 WHERE a.dr_date >= '$sdate1' AND a.dr_date <= '$edate1' AND a.bch = '$bch'";
			$qt=mysql_query($st) or die(mysql_error());
			$rt=mysql_fetch_assoc($qt);
			*/
			
		  echo "<tr class='w3-green w3-small' align='center'>
					<td>".$branch1." - CLIENT</td>
					<td>JO</td>
					<td>BOOKING</td>
					<td>CODE</td>
					<td>ORDER</td>
					<td>DELIVERED</td>
					<td>DESCRIPTION</td>
					<td>ITEM AMOUNT</td>
					<td>DR NO</td>
					<td>DR DATE</td>
					<td>POSTING DATE</td>
					<td>TOTAL</td>
				</tr>";
			
			do{
			echo "<tr class='w3-hover-pale-red w3-small'>
					<td>".$r['name']."</td>
					<td>".$r['jo_no']."</td>
					<td>".$r['bo_no']."</td>
					<td>".$r['code_set']."</td>
					<td>".$r['b_qty']." ".$r['b_unit']."</td>
					<td>".$r['dr_qty']." ".$r['b_unit']."</td>
					<td>".$r['b_size']." ".$r['b_desc']."</td>
					<td align='right' class='w3-text-indigo'>".number_format($r['b_amount'],2)."</td>
					<td>".$r['dr_no']."</td>
					<td>".date('m/d/Y',strtotime($r['dr_date']))."</td>
					<td>".date('m/d/Y',strtotime($r['dr_posted_date']))."<br/>".$r['dr_posted_by']."</td>
					<td align='right' class='w3-text-indigo'>".number_format($r['b_amount']*$r['dr_qty'],2)."</td>
				  </tr>"; 			

				$dr_total += $r['b_amount']*$r['dr_qty'];
				  
			}while($r=mysql_fetch_assoc($q));
			echo "<tr></tr><td colspan='10' align='right'>TOTAL:</td><td align='right' class='w3-text-indigo'><b>".number_format($dr_total,2)."</b></td>";
		}else{}	
		
		?>

	</table>

</body>