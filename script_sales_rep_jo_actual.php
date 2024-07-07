<?php
if(isset($_REQUEST['search']) and $_REQUEST['search']=="jo_actual")
{
	if($_REQUEST['sort3']=="jo_actual")
	{ 
		$where="where a.jo_actual_date>='$sdate' and a.jo_actual_date<='$edate'";
		$where2="jo_actual_date>='$sdate' and jo_actual_date<='$edate'";
		$order="order by a.jo_actual_date desc";
	}
	
	
	if($_REQUEST['sort3']=="jo_no")
	{ 
		$where="where a.created_datetime>='$sdate1' and a.created_datetime<='$edate1'";
		$where2="created_datetime>='$sdate1' and created_datetime<='$edate1'";
		$order="order by a.jo_no desc"; 
	}
	
	
	 //FOR GOC
	 if($rp['bch']=="goc")
	 { 
		if($_REQUEST['branch']=="ALL")
		{
	    $s="select a.*,
				c.name as name,
				c.vip as vip,
				d.department as department
		from sales_jo as a
		inner join sales_clients as c on a.client_id=c.client_id
		inner join users as d on a.created_by=d.username
		$where
		$order";
		}
		
		else
		{	
		$branch1=$_REQUEST['branch'];
		$s="select a.*,
				c.name as name,
				c.vip as vip,
				d.department as department
		from sales_jo as a
		inner join sales_clients as c on a.client_id=c.client_id
		inner join users as d on a.created_by=d.username
		$where
		and d.department='$branch1'
		$order";
		}
	 }
	 
	 
	 //FOR NOT GOC
	 else
	 { 
		$branch1=$_REQUEST['branch'];
		$s="select a.*,
				c.name as name,
				c.vip as vip,
				d.department as department
		from sales_jo as a
		inner join sales_clients as c on a.client_id=c.client_id
		inner join users as d on a.created_by=d.username
		$where
		and d.department='$branch1'
		$order";
	 }
	
	
	$q=mysql_query($s) or die(mysql_error());
	$r=mysql_fetch_assoc($q);
	
	echo "<table align='center' class='w3-tiny table'>
			<tr>
				<td colspan='16' align='center'>"; ?>
				
				<form>
					<input name='sdate' type='hidden' value='<?php echo $sdate; ?>'>
					<input name='edate' type='hidden' value='<?php echo $edate; ?>'>
					<input name='search' type='hidden' value='<?php echo $_REQUEST['search']; ?>'>
					
				<?php //if($rp['bch']=="goc")
				      //{ ?>	
					<select required name='branch'>
						<option><?php if($_REQUEST['branch']!=""){ echo $_REQUEST['branch'];} ?></option>
						<option></option>
						<option>ALL</option>
				   <?php $sa="select users.department as dept,count(department) from users inner join sales_jo on sales_jo.created_by=users.username group by users.department";
						 $qa=mysql_query($sa);
						 $ra=mysql_fetch_assoc($qa);
						do{
						 echo "<option>".$ra['dept']."</option>"; 
						}while($ra=mysql_fetch_assoc($qa)); ?>
					</select>
				   <input name='sort3' type='submit' value='jo_actual'>
				   <input name='sort3' type='submit' value='jo_no'>
				<?php //} ?>
				
				</form>
				
		<?php echo "<i><span class='w3-red w3-text-white'>&nbsp;LIST OF ACTUAL JO ONLY:&nbsp;</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Report from</i> <b>".date('F d, Y',strtotime($_REQUEST['sdate']))."</b> <i>to</i> <b>".date('F d, Y',strtotime($_REQUEST['edate']))."</b>";
				
	

	//FOR TOTAL AMOUNT ONLY START
	if(isset($_REQUEST['branch']))
	{	
		if($_REQUEST['branch']=="ALL")
		{ 
			$sjot="select sum(jo_amount) as JOTotal from sales_jo where $where2"; 
			$sjot1="select sum(jo_amount) as JOTotal_completed from sales_jo where jo_amount=jo_payment_amount and $where2"; 
			$sjot2="select sum(jo_amount) as JOTotal_partial from sales_jo where jo_amount>jo_payment_amount and jo_payment_amount>0 and $where2"; 
			$sjot3="select sum(jo_amount) as JOTotal_nopay from sales_jo where jo_payment_amount=0 and $where2"; 
		}
		else
		{   
			$branch=$_REQUEST['branch'];
			$sjot="select sum(a.jo_amount) as JOTotal 
			       from sales_jo as a
				   inner join users as b on a.created_by=b.username
				   where b.department='$branch' and $where2";
			
			$sjot1="select sum(a.jo_amount) as JOTotal_completed
			       from sales_jo as a
				   inner join users as b on a.created_by=b.username
				   where jo_amount=jo_payment_amount and b.department='$branch' and $where2";
			
			$sjot2="select sum(a.jo_amount) as JOTotal_partial
			       from sales_jo as a
				   inner join users as b on a.created_by=b.username
				   where jo_amount>jo_payment_amount and jo_payment_amount>0 and b.department='$branch' and $where2";
			
			$sjot3="select sum(a.jo_amount) as JOTotal_nopay
			       from sales_jo as a
				   inner join users as b on a.created_by=b.username
				   where jo_payment_amount=0 and b.department='$branch' and $where2";	   
		}
		
		$qjot=mysql_query($sjot) or die(mysql_error());
		$rjot=mysql_fetch_assoc($qjot);
		
		$qjot1=mysql_query($sjot1) or die(mysql_error());
		$rjot1=mysql_fetch_assoc($qjot1);
		
		$qjot2=mysql_query($sjot2) or die(mysql_error());
		$rjot2=mysql_fetch_assoc($qjot2);
		
		$qjot3=mysql_query($sjot3) or die(mysql_error());
		$rjot3=mysql_fetch_assoc($qjot3);
		
		echo "<br/><br/><table class='w3-border' border='1'>
				<tr><td>JO TOTAL AMOUNT:</td><td align='right'><span class='w3-text-red'>".number_format(round($rjot['JOTotal'],2),2)."</span></td></tr>";
		  echo "<tr><td>TOTAL JO COMPLETED / FULLY PAID</td><td align='right'><span class='w3-text-red'>".number_format(round($rjot1['JOTotal_completed'],2),2)."</span></td></tr>";
		  echo "<tr><td>TOTAL JO WITH PARTIAL PAYMENT</td><td align='right'><span class='w3-text-red'>".number_format(round($rjot2['JOTotal_partial'],2),2)."</span></td></tr>";
		  echo "<tr><td>TOTAL JO NOT PAID</td><td align='right'><span class='w3-text-red'>".number_format(round($rjot3['JOTotal_nopay'],2),2)."</span></td></tr>
		 	 </table>";
	}	
	//FOR TOTAL AMOUNT ONLY END			
				
				
		echo "</td>
			</tr>
			<tr class='w3-green'>
				<td align='center'>count</td>";
				
			if($_REQUEST['sort3']=="jo_no"){ echo "<td align='center' class='w3-red'>JO NO</td>"; }else{ echo "<td align='center'>JO NO</td>"; }
		  
		  echo "<td align='center'>JO DATE</td>
				<td>CLIENT TYPE</td>
				<td>CLIENT</td>
				<td>BRANCH</td>
				<td align='right'>JO AMOUNT</td>
				<td align='right'>PAYMENT APPLIED</td>
				<td align='right'>DR TOTAL</td>";
				
			if($_REQUEST['sort3']=="jo_actual"){ echo "<td align='center' class='w3-red'>JO ACTUAL</td>"; }else{ echo "<td align='center'>JO ACTUAL</td>"; }
				
		  echo "<td>PO NO</td>
				<td>DR NO</td>
				<td align='right'>JO STATUS</td>
				<td></td>
			</tr>";
		$x=1;
		
		
		
		//PPS SALES FROM OR MONITORING START
		
		//totals area start ---
			mysql_select_db("pps");
			$s_total="SELECT SUM(dr_count*price) AS dr_total
					   FROM dr_list
					   WHERE dr_date>='$sdate' AND dr_date<='$edate'";
			$q_total=mysql_query($s_total) or die(mysql_error());
			$r_total=mysql_fetch_assoc($q_total);

			$s_ptotal="SELECT SUM(payment_amount) AS payment_total
					   FROM dr_list
					   WHERE payment_date>='$sdate' AND payment_date<='$edate'";
			$q_ptotal=mysql_query($s_ptotal) or die(mysql_error());
			$r_ptotal=mysql_fetch_assoc($q_ptotal);

			$s_wtotal="SELECT SUM(withheld_amount) AS withheld_total
					   FROM dr_list
					   WHERE withheld_date>='$sdate' AND withheld_date<='$edate'";
			$q_wtotal=mysql_query($s_wtotal) or die(mysql_error());
			$r_wtotal=mysql_fetch_assoc($q_wtotal);

			 
			//totals area end ---
		
			 echo "<tr class='w3-hover-pale-red'>
						<td class='w3-text-amber'>0</td>";
						
						if($_REQUEST['sort3']=="jo_no"){ echo "<td align='center' class='w3-pale-red'></td>"; }else { echo "<td align='center'></td>"; }
				  
				  echo "<td align='center'></td>
						<td></td>
						<td><a href='../pps/reports.php?dr=open&sdate=".$_REQUEST['sdate']."&edate=".$_REQUEST['edate']."&sort=dr_completed' target='_blank'>O.R. PALAWAN PAWNSHOP</a></td>
						<td></td>
						<td align='right'></td>
						<td align='right'>".number_format($r_ptotal['payment_total'],2)."</td>
						<td align='right'>".number_format($r_total['dr_total'],2)."</td>";
						if($_REQUEST['sort3']=="jo_actual"){ echo "<td align='right' class='w3-pale-red'>"; } else { echo "<td align='right'>"; }
				  echo "<td></td>
						<td></td>
						<td align='right'></td>
						<td></td>
					</tr>";
		mysql_select_db("alcsystem");
		//PPS SALES FROM OR MONITORING END
		
		
		
		do
		{
		 echo "<tr class='w3-hover-pale-red'>
				<td class='w3-text-amber'>".$x++."</td>";
			
			if($_REQUEST['sort3']=="jo_no"){ echo "<td align='center' class='w3-pale-red'>".$r['jo_no']."</td>"; }else { echo "<td align='center'>".$r['jo_no']."</td>"; }
			
			echo "<td align='center'>".date('m/d/Y',strtotime($r['created_datetime']))."</td>";
				
			switch($r['vip'])
			{			
				case 0: $vip="Cash"; break;
				case 1: $vip="VIP"; break;
				case 2: $vip="Government"; break;
				case 3: $vip="COD"; break;
				case 4: $vip="X-Deal"; break;
				case 5: $vip="Account"; break;
			}
		
		  echo "<td align='center' class='w3-text-purple'>$vip</td>
				<td align='left'>";
			echo "<a href='admin_sales.php?client_id=".$r['client_id']."&client=".$r['name']."&sales=1&newjobs=1&create_quotation=1' target='_blank'>".$r['name']."</a>";
		  echo "</td>
				<td align='left'>".$r['department']."</td>
				<td align='right'>".number_format($r['jo_amount'],2)."</td>
			

			
				<td align='right'>";
					$jo_x=$r['jo_no'];
					$qjo_x=mysql_query("select sum(payment) as payment_total1 from sales_jo_payments where jo_no='$jo_x'") or die(mysql_error());
					$rjo_x=mysql_fetch_assoc($qjo_x);
					
					if($rjo_x['payment_total1']>=$r['jo_amount'])
					  { echo "<span class='w3-text-blue'>".number_format($rjo_x['payment_total1'],2)."</span>"; }
				  else{ echo "<span class='w3-text-red'>".number_format($rjo_x['payment_total1'],2)."</span>"; }
		  echo "</td>
				<td align='right'>";
			
					$b_id=$r['b_id'];
					$bid_s="select sum(dr_qty*b_amount) as dr_amount from sales_bookings_details where b_id='$b_id'";
					$bid_q=mysql_query($bid_s) or die(mysql_error());
					$bid_r=mysql_fetch_assoc($bid_q);
					
					if($bid_r['dr_amount']>=$rjo_x['payment_total1'])
					{
						echo "<span class='w3-text-green'>".number_format($bid_r['dr_amount'],2)."</span>";
					}
					else{ echo "<span class='w3-text-red'>".number_format($bid_r['dr_amount'],2)."</span>"; }
		  
		  echo "</td>";
				
				if($_REQUEST['sort3']=="jo_actual"){ echo "<td align='right' class='w3-pale-red'>"; } else { echo "<td align='right'>"; }
				
				echo $r['jo_actual']."<br/>";
		  echo "</td>
				<td align='right'>".$r['po_no']."<br/>";
					if($r['po_date']!="0000-00-00"){ echo date('m/d/Y',strtotime($r['po_date'])); } else {}
		  echo "</td>
				<td>";
				
				 $b_id=$r['b_id'];
				 $qg=mysql_query("select dr_no from sales_bookings_details where b_id='$b_id' group by dr_no order by b_count desc") or die(mysql_error());
				 $rg=mysql_fetch_assoc($qg);
				 do{ if($rg['dr_no']!=0){ echo $rg['dr_no']."<br/>"; }else{} } while($rg=mysql_fetch_assoc($qg));
		  
		  echo "</td>
				<td align='right'>";
				
				 $qg1=mysql_query("select dr_no from sales_bookings_details where b_id='$b_id' group by dr_no order by b_count desc") or die(mysql_error());
				 $rg1=mysql_fetch_assoc($qg1);
				 
				if($r['completed_by']!=""){ echo "<i class='w3-text-blue'>COMPLETED</i>"; }
				if($r['paid']==0){ echo "<i class='w3-text-red'>(Partial Only) PENDING</i>"; }
				if($r['paid']==1 and $r['completed_by']=="" and $rg1['dr_no']!="0"){ echo "<i class='w3-red w3-text-white'>&nbsp;AMOUNTS ISSUE or DELIVERY ISSUE&nbsp;</i>"; }
				if($r['paid']==1 and $r['completed_by']=="" and $rg1['dr_no']=="0"){ echo "<i class='w3-text-purple'>(No DR yet) PENDING</i>"; }
				
		  echo "</td>
				<td>";
				if($r['paid']==1 and $r['completed_by']=="" and $rg1['dr_no']!="0")
				{
					if($_SESSION['username']=="omar" or $_SESSION['username']=="oliver")
					{
					echo "<a class='fa fa-check-circle w3-large w3-text-red' target='_blank' href='script_sales_jo_complete_setter.php?jo_no=".$r['jo_no']."&client=".$r['name']."&client_id=".$r['client_id']."'></a>";
					}else{}
				}else{}	
		  echo "</td>
			   </tr>";
		} while($r=mysql_fetch_assoc($q));	
	echo "</table>";
	
}
?>