<?php 
include('connection/conn.php');
session_start();
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); }
?>
<link rel="stylesheet" href="css/w3.css">
<link rel="stylesheet" href="css/font-awesome.min.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>

<?php
$jo_no=$_REQUEST['jo_no'];
$username=$_SESSION['username'];

$spas="select * from user_access where username='$username'";
$qpas=mysql_query($spas) or die(mysql_error());
$access=mysql_fetch_assoc($qpas);


//Script for payment database insert start ----
if(isset($_REQUEST['payment']))
  {
	  if($_REQUEST['payment']<=$_REQUEST['remaining'])
	  {
		  $r45=mysql_fetch_assoc(mysql_query("select bch from users where username='$username'"));
		  $bch=$r45['bch'];
		  
		  $q_lt=mysql_query("SELECT rs_no FROM sales_jo_payments where rs_bch='$bch' order by rs_no desc limit 1") or die(mysql_error);
		  $r_lt=mysql_fetch_assoc($q_lt);
		  $rs=$r_lt['rs_no']+1;
		  
		  $q_id=$_REQUEST['q_id'];
		  $b_id=$_REQUEST['b_id'];
		  $jo_no=$_REQUEST['jo_no'];
		  
		  if($_REQUEST['or_no']==''){ $or_no=0; }
		  else{ $or_no=$_REQUEST['or_no']; }
		  
		  
		  
		  $or_date=$_REQUEST['or_date'];
		  $jo_amount=$_REQUEST['jo_amount'];
		  $client_id=$_REQUEST['client_id'];
		  $payment=$_REQUEST['payment'];
		  $remarks=$_REQUEST['remarks'];
		  $pay_type=$_REQUEST['pay_type'];
		  $pay_mode=$_REQUEST['pay_mode'];
		  mysql_query("insert into sales_jo_payments (rs_no,rs_bch,client_id,q_id,b_id,jo_no,jo_amount,payment,or_no,or_date,remarks,payment_by,payment_datetime,pay_type,pay_mode) values ($rs,'$bch',$client_id,$q_id,$b_id,$jo_no,$jo_amount,$payment,$or_no,'$or_date','$remarks','$username',now(),'$pay_type','$pay_mode')") or die(mysql_error());
		  
		  mysql_query("insert into sales_jo_rs_monitor (rs_no,rs_bch,client_id,jo_no,payment_amount,jo_amount) values ($rs,'$bch',$client_id,$jo_no,$payment,$jo_amount)") or die(mysql_error());
		  
		  $payment1=number_format($_REQUEST['payment'],2);
		  $jo_msg="Payment $payment1 applied";
		  mysql_query("insert into sales_jo_progress (jo_no,jo_msg,jo_msg_by,date,time) values ('$jo_no','$jo_msg','$username',curdate(),curtime())") or die(mysql_error());
	  
		  $trans="$pay_mode Payment $payment applied OR $or_no";
		  $log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
		  $log_query=mysql_query($log_sql) or die(mysql_error());
		  
		  $loc='Location: script_sales_jo_payments.php?jo_no='.$_REQUEST['jo_no'];
		  header($loc);
	  }
 else { 
		$loc='Location: script_sales_jo_payments.php?payment_error=1&payment_x='.$_REQUEST['payment'].'&jo_no='.$_REQUEST['jo_no'];
		header($loc); 
	  }
  }	  
//Script for payment database insert End ----
  
  
$q=mysql_query("select * from sales_jo where jo_no=$jo_no") or die(mysql_error());
$r=mysql_fetch_assoc($q);
$q_id=$r['q_id'];
$b_id=$r['b_id'];
$client_id=$r['client_id'];

$s1="select * from sales_jo_payments where q_id=$q_id and b_id=$b_id and jo_no=$jo_no";
$q1=mysql_query($s1) or die(mysql_error());
$r1=mysql_fetch_assoc($q1);

echo "<br><br>";

echo "<div class='container' align='center'>";
echo "<table class='table'>";
  		    $q3=mysql_query("select name from sales_clients where client_id=$client_id") or die(mysql_error());
			$r3=mysql_fetch_assoc($q3);
  echo "<tr class='w3-small w3-light-gray'>
			<td colspan='2'><b>Client</b></td>
			<td><b>Booking ID</b></td>
			<td><b>J.O. No.</b></td>
		</tr>";
  echo "<tr>
			<td colspan='2'>".$r3['name']."</td>
	        <td>".$r['b_id']."</td>
	        <td>".$r['jo_no']."</td>
		</tr>
		<tr height='50'>
			<td colspan='4'></td>
		</tr>";
  echo "<tr class='w3-small w3-light-gray'>
			<td><b>J.O. Amount</b></td>
			<td><b>Payment</b></td>
			<td><b>Remarks / Reference / O.R.</b></td>
			<td><b>Action</b></td>
		</tr>";	
?>		
		<tr>
		<td colspan='4' class='w3-text-purple'><b><?php echo number_format($r['jo_amount'],2);?></b></td>
		<?php 
		$s1="select * from sales_jo_payments where jo_no=$jo_no";
		$q1=mysql_query($s1) or die(mysql_error());
		$r1=mysql_fetch_assoc($q1);
		
		$s2="select sum(payment) as paytotal from sales_jo_payments where jo_no=$jo_no";
		$q2=mysql_query($s2) or die(mysql_error());
		$r2=mysql_fetch_assoc($q2);
		
		do{
			echo "<tr><td></td>";
			echo "<td class='w3-text-indigo'><b>".number_format($r1['payment'],2)."</b></td>";
			echo "<td class='w3-small'>
					RELEASE SLIP NO: <b>".$r1['rs_no']."</b><br/>
					OR NO: <b>".$r1['or_no']."</b><br/>
					PAYMENT TYPE: <b>".$r1['pay_type']."</b><br/>
					PAYMENT MODE: <b>".$r1['pay_mode']."</b><br/>
					REMARKS: <b>".$r1['remarks']."</b></td>";
			echo "<td class='w3-small'>
					OR DATE: <b>".$r1['or_date']."</b><br/>
					POSTED BY: <b>".$r1['payment_by']."</b><br/>
					POSTED DATE: <b>".$r1['payment_datetime']."</b>
				  </td>
				  </tr>";
			
		  }while($r1=mysql_fetch_assoc($q1));
		
		?>
	    </tr>
		
		<tr>
			<td class='w3-text-red' colspan='4'>
				<b>
					<?php
						$totalxxx=$r['jo_amount']-$r2['paytotal'];
						$total=number_format($r['jo_amount']-$r2['paytotal'],2);
						$paytotal_1=$r2['paytotal'];
						mysql_query("update sales_jo set jo_payment_amount='$paytotal_1' where jo_no=$jo_no") or die(mysql_error());
						echo "$total <span class='w3-tiny'>(remaining)</span>";
						if(isset($_REQUEST['payment_error']))
							{ echo "<div align='center'>Payment Error! Over Payment Not Allowed. (Your Entry is ".number_format($_REQUEST['payment_x'],2).")</div>"; } else {}
						if($total<=0){ mysql_query("update sales_jo set paid=1 where jo_no=$jo_no") or die(mysql_error()); }
						         else{ mysql_query("update sales_jo set paid=0 where jo_no=$jo_no") or die(mysql_error()); }	
					?>
				</b>
			</td>
		</tr>
		
		
<?php if($r['completed_by']=="")
		{ ?>
		
		<?php if($access['d17']==1)
		      { ?>
		<tr class='w3-light-gray'>
		<form method="get">
				<input name="remaining" type="hidden" value="<?php echo $totalxxx; ?>">
				<input name="q_id" type="hidden" value="<?php echo $r['q_id']; ?>">
				<input name="b_id" type="hidden" value="<?php echo $r['b_id']; ?>">
				<input name="jo_no" type="hidden" value="<?php echo $r['jo_no']; ?>">
				<input name="client_id" type="hidden" value="<?php echo $r['client_id']; ?>">
				<input name="jo_amount" type="hidden" value="<?php echo $r['jo_amount']; ?>">
			<?php if($r['paid']==0)
			        { ?>
			<td></td>
			<td><i class='w3-tiny'>
				AMOUNT
				<input required name="payment" class="form-control" type="number" step="any" placeholder="Payment Amount">
				OR NO
				<input name="or_no" class="form-control" type="number" step="any" placeholder="OR NO">
				OR DATE
				
				
				<?php if($access['d28']==1)
				      { ?>
						<input required name="or_date" class="form-control" min="2020-03-01" type="date"></i>
				<?php }
				 else { ?>
						<input required name="or_date" class="form-control" min="<?php echo date('Y-m-d'); ?>" type="date"></i> 
			    <?php } ?>
				
				
				
			</td>
			<td><i class='w3-tiny'>
				PAYMENT TYPE
				<select required name="pay_type" class="form-control">
					<option></option>
					<option value='Full'>Full</option>
					<option value='Partial'>Partial</option>
				</select>
				PAYMENT MODE
				<select required name="pay_mode" class="form-control">
					<option></option>
					<option value='Cash'>Cash</option>
					<option value='Cheque'>Cheque</option>
					<option value='CreditMemo'>Credit Memo</option>
					<option value='Discount'>Discount</option>
					<option value='Sponsor'>Sponsor</option>
					<option value='Exdeal'>Ex Deal</option>
					<option value='VatExempt'>Vat Exempt</option>
					<option value='2306'>2306 Witheld</option>
					<option value='2307'>2307 Witheld</option>
				</select>
				CHEQUE NUMBER / ANY PAYMENT REMARKS
				<input required name="remarks" class="form-control" type="text" placeholder="Cheque Number or Any Payment Remarks"></i>
			</td>
			<td>
				  <!--
				  <?php// if($r['jo_no'] > 25428) // 25428 ang pinakalast na jo ng 2019
						//{ ?>
						<input class='form-control btn-danger' type='submit' value='Post Payment' onclick='return confirm("Post Payment Now?")'>
				  <?php //}else { echo "<span class='w3-text-red'>POSTING INVALID<br/>FOR 2019 GENERATED JO'S</span>"; } ?>
				  -->
				  
				  <input class='form-control btn-danger' type='submit' value='Post Payment' onclick='return confirm("Post Payment Now?")'>
				 
			</td>
		      <?php } ?>
			
		</form>
		</tr>
		<?php } ?>
		
  <?php } ?>
		
	  </table>	  

</div>




<?php //DR SUMMARY START
$b_id=$r['b_id'];
$sd="select a.b_qty as b_qty,
			a.b_unit as b_unit,
			a.dr_qty as dr_qty,
			a.b_unit as b_unit,
			a.b_amount as b_amount,
			a.code_set as code_set,
			a.b_size as b_size,
			a.b_desc as b_desc,
			a.dr_no as dr_no, 
			a.dr_date as dr_date,
			b.jo_msg_by as posted_by, 
			b.date as date,
			b.time as time
	 from sales_bookings_details as a
	 inner join sales_jo as c on a.b_id=c.b_id
	 inner join sales_jo_progress as b on c.jo_no=b.jo_no
	 where b.jo_msg like '%Item No.%' and a.b_id='$b_id' group by a.dr_posted_date";
	 
$qd=mysql_query($sd) or die(mysql_error());
$rd=mysql_fetch_assoc($qd);

//DR total Only
$sd1="select sum(dr_qty*b_amount) as dr_total from sales_bookings_details where b_id = '$b_id'";
$qd1=mysql_query($sd1) or die(mysql_error());
$rd1=mysql_fetch_assoc($qd1);

echo "<div class='container'>
	  <table class='table'>
		<tr class='w3-tiny bg-info'><td colspan='10' align='center'>DR SUMMARY</td></tr>
		<tr class='w3-tiny w3-light-gray'>
			<td>QTY</td>
			<td>DR QTY</td>
			<td>UNIT PRICE</td>
			<td>AMOUNT</td>
			<td>CODE</td>
			<td>PARTICULARS</td>
			<td>DR NO</td>
			<td>DR DATE</td>
			<td>DR BY</td>
			<td>DR POSTED DATE</td>
		</tr>";
do{ 
	echo "<tr class='w3-tiny'>
			<td>".$rd['b_qty']." ".$rd['b_unit']."</td>
			<td>".$rd['dr_qty']." ".$rd['b_unit']."</td>
			<td>".number_format($rd['b_amount'],2)."</td>
			<td><b class='w3-text-blue'>".number_format($rd['dr_qty']*$rd['b_amount'],2)."</b></td>
			<td>".$rd['code_set']."</td>
			<td>".$rd['b_size']." ".$rd['b_desc']."</td>
			<td>".$rd['dr_no']."</td>
			<td>".$rd['dr_date']."</td>
			<td>".$rd['posted_by']."</td>
			<td>".$rd['date']." ".$rd['time']."</td>
		 </tr>";
}while($rd=mysql_fetch_assoc($qd));
	echo "<tr>
			<td></td><td></td><td align='right'>DR Total: </td>
			<td class='w3-text-blue'>
				<b>".number_format($rd1['dr_total'],2)."</b>
			</td>
		  </tr>";
echo "</table>
	</div>";
?>

    <br><br>
    <div align='center'>
	
	    <?php 
		if($r['paid']==1 and $r['completed_by']!="")
		{ 
			echo "<b class='w3-blue'>&nbsp;&nbsp;J.O. CLOSED / COMPLETED!&nbsp;&nbsp;</b>";
		}else{}
		?>
		
	</div>
	  


<br><br>
<div align='center'><a class='w3-xlarge' href="javascript:window.open('','_self').close();">X</a></div>