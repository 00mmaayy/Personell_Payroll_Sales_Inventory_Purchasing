<?php
if(isset($_REQUEST['search']) and $_REQUEST['search']=="no_or_date")
{
	if($_REQUEST['sort3']=="jo")       { $order="order by b.jo_no asc"; }
	if($_REQUEST['sort3']=="or_no")    { $order="order by a.or_no asc"; }
	if($_REQUEST['sort3']=="jo_actual"){ $order="order by b.jo_actual asc"; }
	if($_REQUEST['sort3']=="jo_status"){ $order="order by b.paid, b.completed_by asc"; }
	
	 if($rp['bch']=="goc")
	 { 
		if($_REQUEST['branch']=="ALL")
		{
		$s="select a.jo_no as jo_no,
				b.jo_payment_amount as jo_payment_amount,
			    a.jo_amount as jo_amount,
				a.payment as payment,
				a.or_no as or_no,
				a.or_date as or_date,
				a.payment_datetime as payment_datetime,
				b.jo_actual as jo_actual,
				b.jo_actual_date as jo_actual_date,
				b.po_no as po_no,
				b.po_date as po_date,
				b.paid as paid,
				b.completed_by as completed_by,
				b.b_id as b_id,
				c.name as name,
				b.client_id as client_id,
				d.department as department
		from sales_jo_payments as a 
		inner join sales_jo as b
		on a.jo_no=b.jo_no
		inner join sales_clients as c
		on b.client_id=c.client_id
		inner join users as d
		on b.created_by=d.username
		where a.or_date='0000-00-00' 
		$order";
		}
		
		else
		{	
		$branch1=$_REQUEST['branch'];
		$s="select a.jo_no as jo_no,
			    a.jo_amount as jo_amount,
				a.payment as payment,
				a.or_no as or_no,
				a.or_date as or_date,
				a.payment_datetime as payment_datetime,
				b.jo_actual as jo_actual,
				b.jo_actual_date as jo_actual_date,
				b.po_no as po_no,
				b.po_date as po_date,
				b.paid as paid,
				b.completed_by as completed_by,
				b.b_id as b_id,
				c.name as name,
				b.client_id as client_id,
				d.department as department
		from sales_jo_payments as a 
		inner join sales_jo as b
		on a.jo_no=b.jo_no
		inner join sales_clients as c
		on b.client_id=c.client_id
		inner join users as d
		on b.created_by=d.username
		where a.or_date='0000-00-00' 
		and d.department='$branch1'
		$order";
		}
	 }
	 else
	 { 
		$branch1=$rp['department'];
		$s="select a.jo_no as jo_no,
			    a.jo_amount as jo_amount,
				a.payment as payment,
				a.or_no as or_no,
				a.or_date as or_date,
				a.payment_datetime as payment_datetime,
				b.jo_actual as jo_actual,
				b.jo_actual_date as jo_actual_date,
				b.po_no as po_no,
				b.po_date as po_date,
				b.paid as paid,
				b.completed_by as completed_by,
				b.b_id as b_id,
				c.name as name,
				b.client_id as client_id,
				d.department as department
		from sales_jo_payments as a 
		inner join sales_jo as b
		on a.jo_no=b.jo_no
		inner join sales_clients as c
		on b.client_id=c.client_id
		inner join users as d
		on b.created_by=d.username
		where a.or_date='0000-00-00' 
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
					<select required name='sort3'>
						<option><?php if($_REQUEST['sort3']!=""){ echo $_REQUEST['sort3'];} ?></option>
						<option></option>
						<option value='jo'>JO</option>
						<option value='or_no'>OR NO</option>
						<option value='jo_actual'>ACTUAL JO NO</option>
						<option value='jo_status'>JO STATUS</option>
					</select>
					
					
				<?php if($rp['bch']=="goc")
				      { ?>	
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
				<?php } ?>
					
					<input type='submit' value='SORT'>
				</form>
				
		<?php echo "<i><span class='w3-red w3-text-white'>&nbsp;&nbsp;PAYMENTS & OR WITHOUT OR DATE&nbsp;&nbsp;</span></i></b>
				</td>
			</tr>
			<tr class='w3-green'>
				<td>count</td>
				<td>JO NO</td>
				<td>CLIENT</td>
				<td>BRANCH</td>
				<td>JO AMOUNT</td>
				<td>PAYMENT APPLIED</td>
				<td>DR AMOUNT</td>
				<td>OR NO</td>
				<td>OR DATE</td>
				<td>PAYMENT POSTED</td>
				<td>JO ACTUAL</td>
				<td>JO ACTUAL DATE</td>
				<td>PO NO</td>
				<td>PO DATE</td>
				<td>DR NO</td>
				<td>JO STATUS</td>
			</tr>";
		$x=1;
		do
		{
		 echo "<tr class='w3-hover-pale-red'>
				<td align='center' class='w3-text-amber'>".$x++."</td>
				<td align='center'>".$r['jo_no']."</td>
				<td align='left'>";
			echo "<a href='admin_sales.php?client_id=".$r['client_id']."&client=".$r['name']."&sales=1&newjobs=1&create_quotation=1' target='_blank'>".$r['name']."</a>";
		  echo "</td>
				<td align='left'>".$r['department']."</td>
				<td align='right'><b>".number_format($r['jo_amount'],2)."</b></td>
			
				<td align='right'>";
					$jo_x=$r['jo_no'];
					$qjo_x=mysql_query("select sum(payment) as payment_total1 from sales_jo_payments where jo_no='$jo_x'") or die(mysql_error());
					$rjo_x=mysql_fetch_assoc($qjo_x);
					if($rjo_x['payment_total1']>=$r['jo_amount'])
					  { echo "<b class='w3-text-blue'>".number_format($rjo_x['payment_total1'],2)."</b>"; }
				  else{ echo "<b class='w3-text-red'>".number_format($rjo_x['payment_total1'],2)."</b>"; }
		  echo "</td>
				<td>";
				
				    $b_id=$r['b_id'];
					$bid_s="select sum(dr_qty*b_amount) as dr_amount from sales_bookings_details where b_id='$b_id'";
					$bid_q=mysql_query($bid_s) or die(mysql_error());
					$bid_r=mysql_fetch_assoc($bid_q);
					
					if($bid_r['dr_amount']>=$rjo_x['payment_total1'])
					{
						echo "<b class='w3-text-green'>".number_format($bid_r['dr_amount'],2)."</b>";
					}
					else{ echo "<b class='w3-text-red'>".number_format($bid_r['dr_amount'],2)."</b>"; }
		  echo "</td>";
		  
		  echo "<td align='center'>".$r['or_no']."</td>
				
				<td align='center' class='w3-pale-red'>";
				if($r['or_date']!="0000-00-00"){ echo date('m/d/Y',strtotime($r['or_date'])); } else {} 
				echo "</td>
				
				<td align='center'>".date('m/d/Y',strtotime($r['payment_datetime'],2))."</td>
				
				<td align='center'>".$r['jo_actual']."</td>
				<td align='right'>";
					if($r['jo_actual_date']!="0000-00-00"){ echo date('m/d/Y',strtotime($r['jo_actual_date'])); } else {}
		  echo "</td>
				<td align='center'>".$r['po_no']."</td>
				<td align='right'>";
					if($r['po_date']!="0000-00-00"){ echo $r['po_date']; } else {}
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
				if($r['paid']==1 and $r['completed_by']=="" and $rg1['dr_no']!="0"){ echo "<i class='w3-red w3-text-white'>&nbsp;(DR has Issues) PENDING&nbsp;</i>"; }
				if($r['paid']==1 and $r['completed_by']=="" and $rg1['dr_no']=="0"){ echo "<i class='w3-text-purple'>(No DR yet) PENDING</i>"; }
				
		  echo "</td>
			   </tr>";
		} while($r=mysql_fetch_assoc($q));	
	echo "</table>";
}
?>