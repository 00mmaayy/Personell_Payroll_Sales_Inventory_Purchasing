<?php 
session_start();
include('connection/conn.php');
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); } ?>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/w3.css">
<link rel="stylesheet" href="css/font-awesome.min.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>

<?php
$username=$_SESSION['username'];
$spas="select * from user_access where username='$username'";
$qpas=mysql_query($spas) or die(mysql_error());
$access=mysql_fetch_assoc($qpas);


if(isset($_REQUEST['update_dr']))
{	
	$dr_qty=$_REQUEST['dr_qty'];
	$b_count=$_REQUEST['b_count'];
	$b_id=$_REQUEST['b_id'];
	$dr_no=$_REQUEST['dr_no'];
	$dr_date=$_REQUEST['dr_date'];
	mysql_query("update sales_bookings_details set dr_qty='$dr_qty', dr_date='$dr_date', dr_no='$dr_no', dr_posted_by='$username', dr_posted_date=now() where b_id='$b_id' and b_count='$b_count'") or die(mysql_error());
	
	$item_amount=number_format($_REQUEST['b_amount']*$_REQUEST['dr_qty'],2);
	$jo_no=$_REQUEST['jo_no'];
	$jo_msg="Item No.$b_count with amount of $item_amount from JO No.$jo_no selected for DR $dr_no and DR Date of $dr_date";
	mysql_query("insert into sales_jo_progress (jo_no,jo_msg,jo_msg_by,date,time,dr_set) values ('$jo_no','$jo_msg','$username',curdate(),curtime(),1)") or die(mysql_error());
	
	header('Location: script_sales_addquotation.php?b_date='.$_REQUEST['b_date'].'&client='.$_REQUEST['client'].'&b_id='.$_REQUEST['b_id'].'&client_id='.$_REQUEST['client_id'].'&print_booking_details='.$_REQUEST['print_booking_details'].'&dr_no='.$_REQUEST['dr_no'].'&dr_date='.$_REQUEST['dr_date'].'&set_dr='.$_REQUEST['set_dr']);
}


if(isset($_REQUEST['dr_partial']))
{	
	$b_count=$_REQUEST['b_count'];
	$h=mysql_query("select * from sales_bookings_details where b_count='$b_count'") or die(mysql_error());
	$h1=mysql_fetch_assoc($h);
	
	$b_count=$h1['b_count'];
	$b_id=$h1['b_id'];
	$code_set=$h1['code_set'];
	$b_unit=$h1['b_unit'];
	$b_size=$h1['b_size'];
	$b_desc=$h1['b_desc']." / PARTIAL";
	$b_amount=$h1['b_amount'];
	$b_date=$h1['b_date'];
	$created_by=$h1['created_by'];
	$created_date=$h1['created_date'];
	$status=$h1['status'];
	$dr_no=$h1['dr_no'];
	$dr_date=$h1['dr_date'];
	$bch=$h1['bch'];

	mysql_query("insert into sales_bookings_details (b_id,code_set,b_unit,b_size,b_desc,b_amount,b_date,created_by,created_date,status,dr_no,dr_date,dr_partial,bch)
				 values ('$b_id','$code_set','$b_unit','$b_size','$b_desc','$b_amount','$b_date','$created_by','$created_date','$status','$dr_no','$dr_date',1,'$bch')") or die(mysql_error());	
		
	$jo_no=$_REQUEST['jo_no'];
	$jo_msg="Partial DR Created for item ID $b_id $b_desc";
	mysql_query("insert into sales_jo_progress (jo_no,jo_msg,jo_msg_by,date,time,dr_set) values ('$jo_no','$jo_msg','$username',curdate(),curtime(),1)") or die(mysql_error());
		
	header('Location: script_sales_addquotation.php?b_date='.$_REQUEST['b_date'].'&client='.$_REQUEST['client'].'&b_id='.$_REQUEST['b_id'].'&client_id='.$_REQUEST['client_id'].'&print_booking_details='.$_REQUEST['print_booking_details'].'&dr_no='.$_REQUEST['dr_no'].'&dr_date='.$_REQUEST['dr_date'].'&set_dr='.$_REQUEST['set_dr']);
}


//ADD NEW BOOKING START -----
if(isset($_REQUEST['add_booking']))
{
	$cid=$_GET['client_id'];
	$c=$_GET['client'];
	$trans_type=$_GET['trans_type'];
	$username=$_SESSION['username'];
	
	$qqqq=mysql_query("select department from users where username='$username'") or die(mysql_error());
	$rrrr=mysql_fetch_assoc($qqqq);
	
	if($rrrr['department']=="SALES"){ $dept="main"; }
	if($rrrr['department']=="SM SALES"){ $dept="sm"; }
	if($rrrr['department']=="RIZAL SALES"){ $dept="rzl"; }
	if($rrrr['department']=="SANPEDRO SALES"){ $dept="sp"; }
	if($rrrr['department']=="SANJOSE SALES"){ $dept="sj"; }
	
	$sql="insert into sales_bookings (client_id,created_datetime,created_by,trans_type,bch) values ('$cid',now(),'$username',$trans_type,'$dept')";
	$query=mysql_query($sql) or die(mysql_error());

	$trans="create new booking for $c";
	$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
	$log_query=mysql_query($log_sql) or die(mysql_error());

	$return='Location: admin_sales.php?client_id='.$_REQUEST['client_id'].'&client='.$_REQUEST['client'].'&sales=1&newjobs=1&create_quotation=1';
	header($return);
}
//ADD NEW BOOKING END -----



//ADD BOOKING DETAILS START -----
if(isset($_REQUEST['add_booking_details']))
{
     if(isset($_REQUEST['add_b_details']))
	   {
		$username=$_SESSION['username'];
		$qqqq=mysql_query("select department from users where username='$username'") or die(mysql_error());
	    $rrrr=mysql_fetch_assoc($qqqq);
	
		if($rrrr['department']=="SALES"){ $dept="main"; }
		if($rrrr['department']=="SM SALES"){ $dept="sm"; }
		if($rrrr['department']=="RIZAL SALES"){ $dept="rzl"; }
		if($rrrr['department']=="SANPEDRO SALES"){ $dept="sp"; }
		if($rrrr['department']=="SANJOSE SALES"){ $dept="sj"; }
		
		$add_booking_details=$_REQUEST['add_booking_details'];
		
		$book_qty=$_REQUEST['book_qty'];
		$code_set=$_REQUEST['code_set'];
		$book_unit=$_REQUEST['book_unit'];
		
			if($_REQUEST['client_id']==1055) //PPS
			  {
				$book_desc=$_REQUEST['pps_branch']." | ".$_REQUEST['book_desc']; 
			  }
			  else
			  {
				$book_desc=$_REQUEST['book_desc']; 
			  }
		
		
		$book_size=$_REQUEST['book_size'];
		$book_amount=$_REQUEST['book_amount'];
		
		$b_id=$_REQUEST['b_id'];

	    $s="insert into sales_bookings_details (b_id,b_qty,b_unit,b_size,b_desc,b_amount,b_date,created_by,created_date,code_set,bch)
		      values ($b_id,$book_qty,'$book_unit','$book_size','$book_desc','$book_amount',curdate(),'$username',now(),'$code_set','$dept')";
	    mysql_query($s) or die(mysql_error());
		
		
				$qw1=mysql_query("select b_count from sales_bookings_details order by b_count desc limit 1") or die(mysql_error());
				$rw1=mysql_fetch_assoc($qw1);
				$b_count=$rw1['b_count'];
				
				$assign_to=$_REQUEST['assign_to'];
				mysql_query("insert into sales_jo_assign (b_count,assign_to,assign_date) values ($b_count,'$assign_to',now())") or die(mysql_error());
				
				$trans="assign $assign_to to $b_count";
				$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
				$log_query=mysql_query($log_sql) or die(mysql_error());
			
		
		
		header('Location: script_sales_addquotation.php?b_date='.$_REQUEST['b_date'].'&b_id='.$_REQUEST['b_id'].'&client='.$_REQUEST['client'].'&client_id='.$_REQUEST['client_id'].'&add_booking_details=ADD+DETAILS');
	   }

	$b_id=$_REQUEST['b_id'];
	$b_date=date('D m/d/Y',strtotime($_REQUEST['b_date']));
	$client=$_REQUEST['client'];
	$client_id=$_REQUEST['client_id'];
	
echo "<div class='w3-container w3-light-gray'><br>";
echo "<table>";
echo "<tr><td width='150'>CLIENT:</td><td>$client</td></tr>";
echo "<tr><td>DATE:</td><td>$b_date</td></tr>";
echo "<tr><td>SYS BOOKING ID:</td><td>$b_id</td></tr>";
echo "</table>";
echo "<br></div>";	
?>
                     <table class='table'>
						  <tr align='left' class='bg-info'>
						     <td colspan='10'>
							      
								  <table>
								    
								  <form method='get'>
									<input name='b_date' type='hidden' value='<?php echo $_REQUEST['b_date']; ?>'>
									<input name='b_id' type='hidden' value='<?php echo $_REQUEST['b_id']; ?>'>
									<input name='client_id' type='hidden' value='<?php echo $_REQUEST['client_id']; ?>'>
									<input name='client' type='hidden' value='<?php echo $_REQUEST['client']; ?>'>
									<input name='add_booking_details' type='hidden' value='1'>
									
									<tr>
										<td>QTY&nbsp;&nbsp;</td>
										<td><input class='form-control' required name='book_qty' type='number'>&nbsp;</td>
										<td width='100'></td>
										<td>CODE&nbsp;&nbsp;</td>
										<td>
										        <select class='form-control' required name='code_set'>
											      <option></option>
												   <?php 
												   $qcode=mysql_query("select * from sales_codes order by count asc") or die(mysql_error());
												   $rcode=mysql_fetch_assoc($qcode);
												   do{
													   echo "<option value='".$rcode['code_set']."'>".$rcode['code_set']." - ".$rcode['code_desc']."</option>";
													 } while($rcode=mysql_fetch_assoc($qcode));
												   ?>
											    </select>
										   </td>
									</tr>
									
									<tr>
										<td>UNIT&nbsp;&nbsp;</td>
										<td><input class='form-control' required name='book_unit' type='text' placeholder='Unit'>&nbsp;</td>
										<td width='100'></td>
										<td>DESCRIPTION&nbsp;&nbsp;</td>
										<td><input class='form-control' required name='book_desc' type='text' placeholder='Description'>&nbsp;</td>
									</tr>
									
									<tr>
										<td>SIZE&nbsp;&nbsp;</td>
										<td><input class='form-control' required name='book_size' type='text' placeholder='Size'>&nbsp;</td>
										<td width='100'></td>
										<td>UNIT AMOUNT&nbsp;&nbsp;</td><td><input class='form-control' required name='book_amount' type='number' step='any'>&nbsp;</td>
									</tr>
									
									<tr>
										<td>ASSIGN PRODUCTION&nbsp;&nbsp;</td>
										<td>
											<select required class='form-control' name='assign_to'>
												<option value='' disabled selected></option>
												<option>ALC MAIN Production Team</option>
												<option>ALC SM Production Team</option>
												<option>ALC SANPEDRO Production Team</option>
												<option>ALC SANJOSE Production Team</option>
											</select>
										</td>
										<td width='100'></td>
										
										
										
											<?php if($_REQUEST['client_id']==1055) //PPS
												  { 
													$db_pps=mysql_select_db("pps") or die("I Couldn't select your database");
													$pps_s="select tin, branch, trade_name from branch order by branch asc";
													$pps_q=mysql_query($pps_s);
													$pps_r=mysql_fetch_assoc($pps_q);
														echo "<td width='100'>PPS BRANCH</td><td>
															<select class='form-control' name='pps_branch'><option selected></option>";
														do{
															echo "<option value='".$pps_r['tin']."'>".$pps_r['branch']." - ".$pps_r['tin']."</option>";
														}while($pps_r=mysql_fetch_assoc($pps_q));
														echo "</select>
															  </td>
															  <td width='100'></td>";
													
													} 
											   else { ?>
														<td width='100'></td>
														<td width='100'></td>
											  <?php } $db=mysql_select_db($database) or die("I Couldn't select your database"); ?>
										
										
										<!--
										<td width='100'></td>
										<td width='100'></td>
										-->
										
										<td>
												<?php if($access['d14']==1){ ?>
												<input class='btn btn-danger' name='add_b_details' type='submit' value='ADD DETAIL' onclick='return confirm("Add Details Now?")'>
											    <?php } ?>
										</td>
									</tr>	
									</form>
										  
								   </table>	  
								  
								  
								  
							 </td>
						  </tr>
						  <tr align='center' class='w3-tiny bg-primary'>
							<td>QTY</td><td>UNIT</td><td>CODE</td><td>SIZE</td><td>DESCRIPTION</td><td>UNIT AMOUNT</td><td width='200' >TOTAL AMOUNT</td><td align='right'>ACTION</td>
						  </tr>
						  
	<?php
	        $qx=mysql_query("select sum(b_qty * b_amount) as b_total from sales_bookings_details where b_id='$b_id' ") or die(mysql_error());
			$rx1=mysql_fetch_assoc($qx);
			 
            $q=mysql_query("select * from sales_bookings_details where b_id='$b_id' order by b_count asc");
			$r=mysql_fetch_assoc($q);
			do{
				echo "<tr class='w3-hover-pale-red' align='center'>
				       <td>".$r['b_qty']."</td>
					   <td>".$r['b_unit']."</td>
					   <td>".$r['code_set']."</td>
					   <td>".$r['b_size']."</td>
					   <td align='left'>".$r['b_desc']."</td>
					   <td align='right'>".number_format($r['b_amount'],2)."</td>
					   <td align='right'>".number_format($r['b_qty']*$r['b_amount'],2)."</td>
					   <td align='right'>";
					   
		        echo "<form method='get'>
				       <input name='add_booking_details' type='hidden' value=''>				
                       <input name='b_count' type='hidden' value='".$r['b_count']."'>				
					   <input name='b_date' type='hidden' value='".$_REQUEST['b_date']."'>				
					   <input name='b_id' type='hidden' value='".$_REQUEST['b_id']."'>				
					   <input name='client' type='hidden' value='".$_REQUEST['client']."'>				
					   <input name='client_id' type='hidden' value='".$_REQUEST['client_id']."'>";?>			
				       
					   <?php if($access['d15']==1){ ?>
					   <span class='w3-tiny'>
				          <input name='delete_booking_item' type='submit' value='remove' onclick='return confirm("Delete Item?")'>
					   </span>
					   <?php } ?>
					   
			<?php echo "</form>
				       </td>
					 </tr>";
			  }while($r=mysql_fetch_assoc($q));	
			 echo "<tr><td align='right' colspan='6'>Total Order: </td><td class='w3-text-red' align='right'><b>".number_format($rx1['b_total'],2)."</b></td><td></td></tr></table>";
}
//ADD BOOKING DETAILS END -----



//DELETE BOOKING ITEM START -----
if(isset($_REQUEST['delete_booking_item']))
{	
   $b_count=$_REQUEST['b_count'];
   $b_id=$_REQUEST['b_id'];
   $client=$_REQUEST['client'];
   
   $username=$_SESSION['username'];
   
   mysql_query("delete from sales_bookings_details where b_count=$b_count and b_id=$b_id") or die(mysql_error());
   
   $trans="delete booking item for $client";
   $log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
   $log_query=mysql_query($log_sql) or die(mysql_error());

   header('Location: script_sales_addquotation.php?b_date='.$_REQUEST['b_date'].'&b_id='.$_REQUEST['b_id'].'&client='.$_REQUEST['client'].'&client_id='.$_REQUEST['client_id'].'&add_booking_details=ADD+DETAILS');
}
//DELETE BOOKING ITEM END -----



//PRINT BOOKING DETAILS START -----
if(isset($_REQUEST['print_booking_details']))
{	
        $b_id=$_REQUEST['b_id'];
	    $client_id=$_REQUEST['client_id'];
		$cq=mysql_query("select * from sales_clients where client_id=$client_id") or die(mysql_error());
		$cr=mysql_fetch_assoc($cq);
	    
		$qt=mysql_query("select * from sales_bookings_details where b_id=$b_id order by created_date asc") or die(mysql_error());
		$rt=mysql_fetch_assoc($qt);
		
		$qt1=mysql_query("select sum(b_qty * b_amount) as b_total, sum(dr_qty * b_amount) as dr_total from sales_bookings_details where b_id=$b_id") or die(mysql_error());
		$rt1=mysql_fetch_assoc($qt1);
		
		$qt2=mysql_query("select * from sales_bookings where b_id=$b_id") or die(mysql_error());
		$rt2=mysql_fetch_assoc($qt2);
		$trans_type=$rt2['trans_type'];
		
		$qt3=mysql_query("select * from sales_transaction_type where trans_no=$trans_type") or die(mysql_error());
		$rt3=mysql_fetch_assoc($qt3);
		
		$q_comp=mysql_query("select company_name from company") or die(mysql_error());
		$r_comp=mysql_fetch_assoc($q_comp);

		
 echo "<br/>
	   <div class='container'>
	   <table class='table' border='1'><tr><td>
		<table class='table' align='center'>";
        //-----------------------------------  
        echo "<tr>
				<td align='center' colspan='2' class='bg-info'>
					<b>".$r_comp['company_name']."</b>
				</td>
			  </tr>";
		
		echo "<tr>
				<td>
					<span class='w3-small'>DATE AND TIME: ".date('F d, Y h:ia',strtotime($rt2['created_datetime']))."</span>
				</td>
				<td align='right' class='w3-tiny'>
					<span>BOOKING ID. ".$rt2['b_id']."</span> <i>(".$rt2['bch'].")</i>&nbsp;
				</td>
			  </tr>";
			  
			  if(isset($_REQUEST['jo_no']))
			  {
				$jo_no=$_REQUEST['jo_no'];
				$jo_s="select jo_actual, jo_actual_date, bo_no, bo_no_date from sales_jo where jo_no='$jo_no'";  
				$jo_q=mysql_query($jo_s) or die(mysql_error());
				$jo_r=mysql_fetch_assoc($jo_q);
			  }
			  
		echo "<tr>
				<td><span class='w3-small'>ORDERED BY: <b>".$cr['name']."</b></span></td>
				<td align='right'>";
				if(isset($_REQUEST['jo_no']))
			    {
					if($jo_r['jo_actual']!=""){ echo "<span class='w3-small'>JO ACTUAL: <b>".$jo_r['jo_actual']."</b></span>"; }
					if($jo_r['bo_no']!=0){ echo "<span class='w3-small'>BOOKING NO: <b>".$jo_r['bo_no']."</b></span>"; }
				}
		  echo "</td>
			  </tr>";
			  
		echo "<tr>
				<td><span class='w3-small'>ADDRESS: ".$cr['address']."</span></td>
				<td align='right'>";
				if(isset($_REQUEST['jo_no']))
			    {
					if($jo_r['jo_actual']!=""){ echo "<span class='w3-small'>JO ACTUAL DATE: <b>".date('m/d/Y',strtotime($jo_r['jo_actual_date']))."</b></span>"; }
					if($jo_r['bo_no']!=0){ echo "<span class='w3-small'>BOOKING DATE: <b>".date('m/d/Y',strtotime($jo_r['bo_no_date']))."</b></span>"; }
				}
		  echo "</td>
			  </tr>";
			  
		echo "<tr>
				<td>
					<span class='w3-tiny'>CONTACT PERSON AND NO. ".$cr['contact_person']." ".$cr['mobile']." ".$cr['telno']."</span>
				</td>
				<td align='right'>
					<span class='w3-small'>THRU: </span><span class='w3-text-blue w3-small'>".$rt3['trans_desc']."</span>
				</td>
			  </tr>";
		
		$bbb_id=$_REQUEST['b_id'];
		$cx1=mysql_query("select po_no, po_date, completed_by, paid, production_status from sales_jo where b_id='$bbb_id'") or die(mysql_error());
		$zx1=mysql_fetch_assoc($cx1);
		
		echo "<tr>
				<td class='small' colspan='2'>PO NO: ".$zx1['po_no']." / ".$zx1['po_date']."</td>
			  </tr>";
		
	    echo "<tr>
				<td colspan='2' align='right'>"; 
				
				
				
				
				
				
				//DR INPUT BOX
				//IF NOT YET COMPLETED & FG STATUS IS (RELEASED FROM FG)
				if($zx1['completed_by']=="" and $zx1['production_status']==8)
				{ ?>
					<form>
					<input name='b_date' type='hidden' value='<?php echo $_REQUEST['b_date']; ?>'>
					<input name='client' type='hidden' value='<?php echo $_REQUEST['client']; ?>'>
					<input name='jo_no' type='hidden' value='<?php echo $_REQUEST['jo_no']; ?>'>
					<input name='b_id' type='hidden' value='<?php echo $_REQUEST['b_id']; ?>'>
					<input name='client_id' type='hidden' value='<?php echo $_REQUEST['client_id']; ?>'>
					<input name='print_booking_details' type='hidden' value='<?php echo $_REQUEST['print_booking_details']; ?>'>
					
		      <?php if($rt2['b_jo']!=0)
					{ //echo $zx1['paid']; ?>
					<input required class='w3-tiny' name='dr_no' type='number' placeholder='INPUT DR' value='<?php if(isset($_REQUEST['dr_no'])){ echo $_REQUEST['dr_no']; }else{}; ?>'>
					
					<!-- no back posting -->
					<?php if($access['d29']==1)
							{ ?>
					
						<?php if($_SESSION['username']=="kath" OR $_SESSION['username']=="kath_sj" OR $_SESSION['username']=="shiela" OR $_SESSION['username']=="fanny")
								{ ?>
									<input required class='w3-tiny' name='dr_date' type='date' min="2020-03-01" value='<?php if(isset($_REQUEST['dr_date'])){ echo $_REQUEST['dr_date']; } else { echo date('Y-m-d'); } ?>'>
						  <?php } 
						    else{ ?>
									<input required class='w3-tiny' name='dr_date' type='date' min="2020-03-01" value='<?php if(isset($_REQUEST['dr_date'])){ echo $_REQUEST['dr_date']; } else { echo date('Y-m-d'); } ?>'>
									<!-- <input required class='w3-tiny' name='dr_date' type='date' value='<?php //if(isset($_REQUEST['dr_date'])){ echo $_REQUEST['dr_date']; } else { echo date('Y-m-d',strtotime('-1 day')); } ?>'> -->
						  <?php } ?>
					
					
					  <?php } 
					   else { ?>
								<input required class='w3-tiny' name='dr_date' type='date' min="<?php echo date('Y-m-d',strtotime('-1 day')); ?>" value='<?php if(isset($_REQUEST['dr_date'])){ echo $_REQUEST['dr_date']; } else { echo date('Y-m-d'); } ?>'>
					  <?php } ?>
					
					<input class='w3-tiny' name='set_dr' type='submit' value='SET DR INFO'>
			  <?php }else{} ?> 
					</form>
					
		  <?php } else{ } ?>
					
					
					
					
					
					
					
		<?php echo "<table width='100%' border='1'>
						<tr align='center'>
							<td width='80'>&nbsp;<span class='w3-tiny'>QTY</span></td>
							<td width='80'>&nbsp;<span class='w3-tiny'>DR QTY</span></td>
							<td width='400'>&nbsp;<span class='w3-tiny'>DESCRIPTION</span></td>
							<td width='100'>&nbsp;<span class='w3-tiny'>UNIT PRICE</span></td>
							<td width='100'>&nbsp;<span class='w3-tiny'>AMOUNT</span></td>
							<td width='100'>&nbsp;<span class='w3-tiny'>DR AMOUNT</span></td>
							<td colspan='2' align='center' class='w3-tiny'></td>
							<td align='center' class='w3-tiny'>DR NO | DATE</td>
							<td align='center' class='w3-tiny'>ROUTING FORM</td>
						</tr>";
					do {
							
						$code_set=$rt['code_set'];
						$qqq=mysql_query("select code_set,code_desc from sales_codes where code_set='$code_set'");
						$rrr=mysql_fetch_assoc($qqq);
						
						echo "<form>";
						echo "<tr class='w3-hover-pale-red'>
								<td align='center'>";
								if($rt['dr_partial']==0){ echo $rt['b_qty']." ".$rt['b_unit']; } else {}
						  echo "</td>
								<td align='center'>";
								
						  	  if(isset($_REQUEST['dr_no']) and $_REQUEST['dr_no']!="" and $rt['dr_qty']<=0)
							 	{
									echo "<input required class='w3-tiny' name='dr_qty' type='number'>";
								}
						  elseif(isset($_REQUEST['dr_no']) and $_REQUEST['dr_no']!="" and $rt['dr_qty']>=1)
								{ 
									echo "<input required class='w3-tiny' name='dr_qty' type='number' value='".$rt['dr_qty']."' placeholder='".$rt['dr_qty']."'>";
								}
							  else
							    { echo $rt['dr_qty']; }								  
								
						  echo "</td>
								<td align='center'><span class='w3-tiny'>".$rrr['code_set']."-".$rrr['code_desc']." - ".$rt['b_size']." ".wordwrap($rt['b_desc'],40,"<br>\n")."</span></td>
								<td align='right'>".number_format($rt['b_amount'],2)."</td>
								<td align='right'>".number_format($rt['b_qty']*$rt['b_amount'],2)."</td>
								<td align='right'><i>";
								
								if(isset($_REQUEST['dr_no']) and $_REQUEST['dr_no']!="")
								{
									echo number_format($rt['dr_qty']*$rt['b_amount'],2);
								}
								elseif($rt['dr_qty']!=0)
								{ 
									echo number_format($rt['dr_qty']*$rt['b_amount'],2);
								}
								else{}
								
						  echo "</i></td>";
								
								if(isset($_REQUEST['dr_no']) and $_REQUEST['dr_no']!="")
								{ ?>
							
									<td align='center'>
									
											    <input name='item_amount' type='hidden' value='<?php echo $rt['b_qty']*$rt['b_amount']; ?>'>
												<input name='jo_no' type='hidden' value='<?php echo $rt2['b_jo']; ?>'>
												<input name='b_count' type='hidden' value='<?php echo $rt['b_count']; ?>'>
												<input name='b_amount' type='hidden' value='<?php echo $rt['b_amount']; ?>'>
												<input name='b_date' type='hidden' value='<?php echo $_REQUEST['b_date']; ?>'>
												<input name='client' type='hidden' value='<?php echo $_REQUEST['client']; ?>'>
												<input name='update_dr' type='hidden' value='1'>
												<input name='b_id' type='hidden' value='<?php echo $_REQUEST['b_id']; ?>'>
												<input name='client_id' type='hidden' value='<?php echo $_REQUEST['client_id']; ?>'>
												<input name='print_booking_details' type='hidden' value='<?php echo $_REQUEST['print_booking_details']; ?>'>
												<input name='dr_no' type='hidden' value='<?php echo $_REQUEST['dr_no']; ?>'>
												<input name='dr_date' type='hidden' value='<?php echo $_REQUEST['dr_date']; ?>'>
												
									   <?php if($rt['dr_no']==0)
									         { 
											   ?>	
												<input class='w3-text-red w3-tiny' type='submit' value='SET DR' onclick='return confirm("Are You Sure?")'>
									   <?php } 
									         else 
											 { ?>
											    <input class='w3-text-green w3-tiny' type='submit' value='UPDATE DR' onclick='return confirm("Are You Sure?")'>
									   <?php } ?>
									   
								
									   
									</td>
						  
						  <?php } else { echo "<td></td>";}
								
						  echo "</form>";		
						  
						  echo "<form><td>"; 
						  
						  if(isset($_REQUEST['dr_no']) and $_REQUEST['dr_no']!="")
						    {
						       if($rt['dr_partial']==0)
							    { ?>
								
									<input name='item_amount' type='hidden' value='<?php echo $rt['b_qty']*$rt['b_amount']; ?>'>
									<input name='jo_no' type='hidden' value='<?php echo $rt2['b_jo']; ?>'>
									<input name='b_count' type='hidden' value='<?php echo $rt['b_count']; ?>'>
									<input name='bch' type='hidden' value='<?php echo $rt['bch']; ?>'>
									<input name='b_amount' type='hidden' value='<?php echo $rt['b_amount']; ?>'>
									<input name='b_date' type='hidden' value='<?php echo $_REQUEST['b_date']; ?>'>
									<input name='client' type='hidden' value='<?php echo $_REQUEST['client']; ?>'>
									<input name='b_id' type='hidden' value='<?php echo $_REQUEST['b_id']; ?>'>
									<input name='client_id' type='hidden' value='<?php echo $_REQUEST['client_id']; ?>'>
									<input name='print_booking_details' type='hidden' value='<?php echo $_REQUEST['print_booking_details']; ?>'>
									<input name='dr_no' type='hidden' value='<?php echo $_REQUEST['dr_no']; ?>'>
									<input name='dr_date' type='hidden' value='<?php echo $_REQUEST['dr_date']; ?>'>
									<input class='w3-text-blue w3-tiny' name='dr_partial' type='submit' value='DR PARTIAL (ID:<?php echo $rt['b_count']; ?>)' onclick='return confirm("Are You Sure?")'>
								
						  <?php } else {}
					        }
					
					      echo "</td></form>";
						  
						  echo "<td align='right'>";
								if($rt['dr_no']==0)
								{ }
								else
								{ echo "<i class='w3-text-green'><b>".$rt['dr_no']."</b></i> | <i class='w3-text-green'><b>".date('m/d/Y',strtotime($rt['dr_date']))."</b></i>"; }
									
						  echo "</td>";
						  
						  echo "<td>"; 
						  
						  $q15=mysql_query("SELECT b_count,bch,routing_no FROM sales_jo_routing WHERE b_count=".$rt['b_count']."");
						  $r15=mysql_fetch_assoc($q15);
						  
						  $qqx=mysql_query("SELECT bch FROM users WHERE username='$username'") or die(mysql_error());
						  $rrx=mysql_fetch_assoc($qqx);
						  
						  if($rt['b_count']!=$r15['b_count'])
						  {
						    if($rrx['bch']!="goc")
							{
								
								if($zx1['completed_by']=="")
								{	
								?>
								 <form method='get' action='script_sales_jo_routing.php' target='_blank'>
								    <input name='b_count' type='hidden' value='<?php echo $rt['b_count']; ?>'>
								    <input name='jo_no' type='hidden' value='<?php echo $_REQUEST['jo_no']; ?>'>
									<input name='form' class='w3-tiny' type='submit' value='CREATE ROUTING' onclick='return confirm("Create Routing?")'>
								 </form>
						<?php	}else{}
								
							}else{ echo "<div align='center'><i class='w3-tiny w3-text-red'>Account: goc<br><b>Not Allowed</b></i></i>"; }
						  
						  }
						  else
						  { echo "<div align='center'><i class='w3-tiny'>(item#".$rt['b_count'].")<br/>ROUTING# : ".$r15['bch']."-".$r15['routing_no']."</i></div>"; }
							
							
							echo "</td>";
						  
						echo "</tr>"; 
		   
		   
						} while($rt=mysql_fetch_assoc($qt));
						
						echo "<tr><td colspan='4' align='right'><span class='w3-tiny'>TOTAL AMOUNT:&nbsp;&nbsp;</span></td><td align='right'>".number_format($rt1['b_total'],2)."</td><td align='right'><i>".number_format($rt1['dr_total'],2)."</i></td><td></td><td></td><td></td><td></td></tr>";   
			  echo "</table>";   
	    //-----------------------------------	
		  echo "</td>
	         </tr>
		     <tr>
				<td colspan='2'><br/>
				  <table width='100%' align='center'>
				    <tr>
				      <td>Forwarded by:</td>
				      <td>JO No. <b class='w3-text-red'>".$rt2['b_jo']."</b></td>
				      <td>Received by:</td>
					</tr>
					<tr><td>&nbsp;</td></tr> 
					<tr>
				      <td width='200'>Close Deal: 
					  <b>";
						$salesperson1=$_REQUEST['salesperson'];
						$s_salesperson="select first_name, last_name from users where username='$salesperson1'";
						$q_salesperson=mysql_query($s_salesperson) or die(mysql_error());
						$r_salesperson=mysql_fetch_assoc($q_salesperson);
						echo $r_salesperson['first_name']." ".$r_salesperson['last_name'];
					  echo "</b>
					  </td>
				      <td width='200'>On Process: </td>
				      <td width='200'>Remarks: ";
					
					if($rt2['approved_by']!="")
				      { echo "<span class='w3-text-orange'><b>Approved & JO Created</b></span>"; }	
 
                    if($rt2['cancelled_by']!="")
				      { echo "<span class='w3-text-red'><b>Cancelled Booking</b></span>"; } 
					
				echo "</td>
					</tr>
					</table>					
				</td>
			</tr>
	  </table>
	  </td></tr></table>
	 </div>";	
	 
}
//PRINT BOOKING DETAILS END -----
?>

<br/>




<?php
//CREATE JO START -----------------------
if(isset($_REQUEST['approve_booking']))
  {	
    $b_id=$_GET['b_id'];
	$client_id=$_GET['client_id'];
	
		if(isset($_REQUEST['jo_actual']))
		{
		$jo_actual=$_REQUEST['jo_actual'];
		$jo_actual_date=$_REQUEST['jo_actual_date'];
		$salesperson=$_REQUEST['salesperson'];
		
		$bo_no='';
		$bo_no_date='';
		}
		
		if(isset($_REQUEST['bo_no']))
		{
		$bo_no=$_REQUEST['bo_no'];
		$bo_no_date=$_REQUEST['bo_no_date'];
		$salesperson=$_REQUEST['salesperson'];
		
		$jo_actual='';
		$jo_actual_date='';
		}
	
	$username=$_SESSION['username'];
    
	$q11=mysql_query("select * from sales_bookings where client_id=$client_id and b_id=$b_id order by b_id desc");
	$r11=mysql_fetch_assoc($q11);
 	$trans_type=$r11['trans_type'];
	
	
	if(isset($_REQUEST['q_id']))
	  { $q_id=$_GET['q_id'];
        $qt=mysql_query("select sum(q_qty * q_amount) as jo_amount from sales_quotations_details where q_id=$q_id") or die(mysql_error()); 
	  }
	else
	  { 
        $qt=mysql_query("select sum(b_qty * b_amount) as jo_amount from sales_bookings_details where b_id=$b_id") or die(mysql_error()); 
      }	
	    
		$rt=mysql_fetch_assoc($qt);
	
	    $jo_amount=$rt['jo_amount'];
	
	if(isset($_REQUEST['q_id']))
	  { 
		$q_id=$_GET['q_id'];
        $sql="insert into sales_jo (q_id,b_id,trans_type,jo_amount,client_id,created_datetime,created_by) values ('$q_id','$b_id','$trans_type','$jo_amount','$client_id',now(),'$username')";
	  }
	else
	  {	
		$sql="insert into sales_jo (b_id,trans_type,jo_amount,client_id,created_datetime,created_by,jo_actual,jo_actual_date,salesperson,bo_no,bo_no_date) values ('$b_id','$trans_type','$jo_amount','$client_id',now(),'$username','$jo_actual','$jo_actual_date','$salesperson','$bo_no','$bo_no_date')";
	  }
	
	$query=mysql_query($sql) or die(mysql_error());
    
	$sql4="select jo_no from sales_jo where q_id='$q_id' and b_id='$b_id' and client_id='$client_id'";
	$query4=mysql_query($sql4) or die(mysql_error());
	$rquery4=mysql_fetch_assoc($query4);
	$jo_no=$rquery4['jo_no'];
	
	$sx1="update sales_bookings set b_jo='$jo_no',approved_datetime=now(),approved_by='$username' where b_id='$b_id'";
	$qx1=mysql_query($sx1) or die(mysql_error());
	
	$sx12="update sales_quotations set b_jo='$jo_no' where b_id='$b_id'";
	$qx12=mysql_query($sx12) or die(mysql_error());
	
	$sx2="update sales_bookings_details set status=1 where b_id='$b_id'";
	$qx2=mysql_query($sx2) or die(mysql_error());
	
	$sx22="update sales_quotations_details set status=1 where q_id='$q_id'";
	$qx22=mysql_query($sx22) or die(mysql_error());
	
	
	$trans="create new jo for $client_id";
	$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
	$log_query=mysql_query($log_sql) or die(mysql_error());
	
	$trans1="set actual jo $jo_actual $jo_actual_date to jo no $jo_no client $client_id";
    $log_sql1="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans1')";
    $log_query1=mysql_query($log_sql1) or die(mysql_error());

	//$return='Location: script_sales_addquotation.php?q_id='.$_REQUEST['q_id'].'&b_id='.$_REQUEST['b_id'].'&client_id='.$_REQUEST['client_id'].'&print_booking_details=VIEW+DETAILS';
    $return='Location: script_sales_validation.php?vprint=1&jo_no='.$jo_no;
	header($return);

  } 
//CREATE JO END ---------------------




//CANCEL JO START -----
if(isset($_REQUEST['cancel_booking']))
  {	
    $q_id=$_GET['q_id'];
    $b_id=$_GET['b_id'];
	$client_id=$_GET['client_id'];
	$username=$_SESSION['username'];
    
	$sx1="update sales_bookings set cancelled_datetime=now(),cancelled_by='$username' where b_id='$b_id'";
	$qx1=mysql_query($sx1) or die(mysql_error());
	
	$sx2="update sales_bookings_details set status=0 where b_id='$b_id'";
	$qx2=mysql_query($sx2) or die(mysql_error());
	
	$sx3="update sales_quotations_details set status=0 where q_id='$q_id'";
	$qx3=mysql_query($sx3) or die(mysql_error());
	
	$trans="cancel booking $b_id for client $client_id";
	$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
	$log_query=mysql_query($log_sql) or die(mysql_error());

	$return='Location: script_sales_addquotation.php?b_id='.$_REQUEST['b_id'].'&client_id='.$_REQUEST['client_id'].'&print_booking_details=VIEW+DETAILS';
    header($return);
  }
//CANCEL JO END -----
?>



<div align='center'>
<?php 
//FOR BOOKING APPROVE JO AND CANCEL BUTTON AREA -----
if(isset($_REQUEST['print_booking_details'])) 
        { 
	      //$q_id=$_REQUEST['q_id'];
	      $qqq=mysql_query("select * from sales_bookings where b_id=$b_id") or die(mysql_error());
          $rqq=mysql_fetch_assoc($qqq);
		  
		  
		  
				//FOR O.R. SHORTCUT
				if($_REQUEST['client_id']==1055)
				{
					$db_pps=mysql_select_db("pps") or die("I Couldn't select your database");
					$pps_s="select tin, branch from branch order by branch asc";
					$pps_q=mysql_query($pps_s);
					$pps_r=mysql_fetch_assoc($pps_q);
					echo "<form action='../pps/create_jo.php' target='_blank'>";
					echo "<select name='tin'>
							<option selected></option>";
							do{
								echo "<option value='".$pps_r['tin']."'> ".$pps_r['branch']." - ".$pps_r['tin']."</option>";
							}while($pps_r=mysql_fetch_assoc($pps_q));
								echo "</select>";
								echo "<input type='submit' value='CREATE PPS OR JO'>
									  </form>
							  <br/>";
												
					$db=mysql_select_db($database) or die("I Couldn't select your database"); 		
				}
				else{} ?>
		  
		  
		  
		  
		  <form method='get'>
		  <?php if(isset($_REQUEST['q_id'])) { ?>
		  <input name='q_id' type='hidden' value='<?php echo $_REQUEST['q_id']; ?>'>
		  <?php } ?>
		  <input name='b_id' type='hidden' value='<?php echo $_REQUEST['b_id']; ?>'>
		  <input name='client_id' type='hidden' value='<?php echo $_REQUEST['client_id']; ?>'>
		  
		  <?php if($rqq['approved_by']=="") 
		          { 
					if($rqq['cancelled_by']=="")   
					  {  ?>
						
				  <?php 
							$qtxx=mysql_query("select b_count from sales_bookings_details where b_id=$b_id") or die(mysql_error());
							$rtxx=mysql_fetch_assoc($qtxx);
							if($rtxx['b_count'])
							  { ?>
							
							   <?php if($access['d13']==1)
							   { 
							   
								$username=$_SESSION['username'];
								$qqqq=mysql_query("select department from users where username='$username'") or die(mysql_error());
								$rrrr=mysql_fetch_assoc($qqqq);
	
								if($rrrr['department']=="SALES"){ $dept="main"; }
								elseif($rrrr['department']=="SM SALES"){ $dept="sm"; }
								elseif($rrrr['department']=="RIZAL SALES"){ $dept="rzl"; }
								elseif($rrrr['department']=="SANPEDRO SALES"){ $dept="sp"; }
								elseif($rrrr['department']=="SANJOSE SALES"){ $dept="sj"; }
								else{ $dept="goc";}
							    
								
								
								
								
									//if($dept=="sp" or $dept=="main" or $dept=="goc")
										//{ ?>
										    <input name='bo_no' class='btn w3-pale-blue w3-tiny' type='number' placeholder='BOOKING NO'>
								 <?php //}
								 
								  //else { ?>
										<!--	<input name='jo_actual' class='btn w3-pale-green w3-tiny' type='number' placeholder='JO ACTUAL'> -->
								 <?php //}
								 
								 
								 
								 
								 
								 
								if($dept=="main" or $dept=="goc")
								       { ?>
													<i>
														<select required name='salesperson'>
															<option>Walk-in</option>
															<option>Aldrine</option>
															<option>Archie</option>
															<option>Fanny</option>
															<option>Jeremy</option>
															<option>Raven</option>
															<option>Kath</option>
															<option>Mona</option>
															<option>Rose</option>
															<option>Sheila</option>
															<option>Mike</option>
															<option>Ben</option>
														</select>
													</i>
														<br/><br/>
								  <?php } 
								   else {} ?>
								
								
								
								
								
								
							<?php // if($dept=="sp" or $dept=="main" or $dept=="goc")
							        //{ ?>
										<input name='bo_no_date' class='btn w3-pale-blue w3-tiny' type='date' value='<?php echo date('Y-m-d'); ?>'>
							  <?php //}
							    //else{ ?>
										
										<!--<input name='jo_actual_date' class='btn w3-pale-green w3-tiny' type='date' value='<?php //echo date('Y-m-d'); ?>'> -->
							  <?php //} ?> 
							   
							   
							   
							   
							   
							   
							   <input name='approve_booking' class='btn btn-success w3-tiny' type='submit' value='PROCEED TO JO CREATION' onclick='return confirm("CREATE JO, Are you sure?")'>&nbsp;&nbsp;&nbsp;
					   <?php } ?>
							   
							   
							   <?php if($access['d12']==1){ ?><br/><br/>
							   <input name='cancel_booking' class='btn btn-danger w3-tiny' type='submit' value='CANCEL THIS ORDER' onclick='return confirm("CANCEL BOOKING? Are you sure?")'>
							   <?php } ?>

					  <?php   } ?>
						   
			<?php     }
			      } ?>
		  </form>
<?php  } 
//FOR BOOKING APPROVE JO AND CANCEL BUTTON AREA -----  
?>



<?php 
$remaining=$rt1['b_total']-$rt1['dr_total'];
if($remaining<=0)
{ ?>
    <br><br>
    <div align='center'>
	
	    <?php 	
				$jo_no=$_REQUEST['jo_no'];
				$sky="select paid, completed_by, jo_actual, jo_amount, b_id, production_status from sales_jo where jo_no='$jo_no'";
				$qky=mysql_query($sky) or die(mysql_error());
				$rky=mysql_fetch_assoc($qky);
				 
				if($rky['paid']==1 and $rky['completed_by']!="")
				{ 
					echo "<b class='w3-blue'>&nbsp;&nbsp;J.O. CLOSED / COMPLETED!&nbsp;&nbsp;</b>"; 
				}else{}
		?>
	</div>
<?php 
} 
else 
{} ?>	  


<br/><br/>
  <a class='w3-xlarge' href="javascript:window.open('','_self').close();">X</a>
</div>
<br><br>