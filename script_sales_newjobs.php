<?php // New Jobs Start --->
	  if($access['d2']==1)
	    { 
	      if(isset($_REQUEST['newjobs'])) 
	        { ?> 
				<!---Ajax Search Start--->
		        <script>
				function showHint(str)
				{
				var s=document.getElementById("search").value;
				var xmlhttp;
				if (window.XMLHttpRequest)
				  {// code for IE7+, Firefox, Chrome, Opera, Safari
				  xmlhttp=new XMLHttpRequest();
				  }
				else
				  {// code for IE6, IE5
				  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
				  }
				xmlhttp.onreadystatechange=function()
				  {
				  if (xmlhttp.readyState==4 && xmlhttp.status==200)
					{
					document.getElementById("view_result").innerHTML=xmlhttp.responseText;
					}
				  }
				xmlhttp.open("GET","script_sales_client_result.php?s="+s,true);
				xmlhttp.send();
				}
				</script>
			    
				<table><tr><td class='w3-text-red w3-tiny'><b>CLIENT SEARCH</b></td></tr>
				       <tr valign='top'>
			               <td><input class='form-control' type="text" placeholder='Input Client Name' id="search" name="search" onkeyup="showHint('x')"/>&nbsp;&nbsp;</td><td><div id="view_result"></div></td>
					   </tr>	   
                </table>
				<!---Ajax Search End--->
				
				
				
	 <?php //Create Quotation & Booking Start-----
	       if(isset($_REQUEST['create_quotation'])){ ?>
		                <br>
						
						
				<table>
					<tr>
						<td width='400'>
					
						<!--Create New Quotation and Booking Button Start-->
						<div>
						  <span class='w3-tiny'>JOB FOR CLIENT: <i class='w3-text-blue'>(Client ID: <?php echo $_REQUEST['client_id']; ?> &nbsp;&nbsp;<?php echo "<a class='fa fa-pencil' href='script_sales_edit_clients.php?client_id=".$_REQUEST['client_id']."' target='_blank'></a>"; ?> )</i></span><br/><b><?php echo $_REQUEST['client']; ?></b><br>
						  <?php 
						  $client_id=$_REQUEST['client_id'];
						  $q_client=mysql_query("select mobile,telno,contact_person,email from sales_clients where client_id=$client_id") or die(mysql_error());
						  $r_client=mysql_fetch_assoc($q_client);
						  echo "<span class='w3-tiny'>".$r_client['mobile']." | ".$r_client['telno']." | ".$r_client['email']." | Contact Person: ".$r_client['contact_person']."</span><br><br>";
						  ?>
						</div>
						
						
		  <?php  
						     //Killer! Start1
								$sx="SELECT * FROM sales_clients WHERE client_id=$client_id";
								$qx=mysql_query($sx) or die(mysql_error());
								$rx=mysql_fetch_assoc($qx);

									switch($rx['vip'])
									{
										case 0: $ctype="Cash"; break;
										case 1: $ctype="VIP"; break;
										case 2: $ctype="Government"; break;
										case 3: $ctype="COD"; break;
										case 4: $ctype="X-Deal"; break;
										case 5: $ctype="Account"; break;
									}	
								
									//view client status only
									echo "<i class='w3-tiny'>Client Type: <b class='w3-text-red'>".$ctype."</b></i><br/>";
									if($rx['terms']!=0)
									{ if($rx['terms']!=999)
									  { 
										echo "<i class='w3-tiny'>Terms: <b class='w3-text-red'>".$rx['terms']." days</b></i><br/>"; 
									  }
								  else{} 
								    }
									if($rx['credit_limit']!=0)
									{ 
										echo "<i class='w3-tiny'>Credit Limit: <b class='w3-text-red'>".number_format($rx['credit_limit'],2)."</b></i>"; 
									}
									
									$s_ob="SELECT SUM(jo_amount-jo_payment_amount) AS jo_ob_total 
										   FROM sales_jo
										   WHERE client_id=$client_id and paid=0";
									$q_ob=mysql_query($s_ob) or die(mysql_error());
									$r_ob=mysql_fetch_assoc($q_ob);
									
									
									
									//for CASH clients
									if($rx['vip']==0 or $rx['vip']==1)
									{
										if($r_ob['jo_ob_total']!=0)
										{
											echo "<div class='w3-pale-red'>";
											
										
										
										$booking = array();
$date_today = date('Y-m-d');
$total_amount = 0;
$total_ten = 0;
$total_trty = 0;
$total_sxty = 0;
$total_otwty = 0;
$total_oety = 0;
$total_trsxty = 0;
$total_gtrsxty = 0;
$full_total_amount = 0;
										
										$select_delivered = mysql_query("SELECT sbd.dr_date,
										sbd.dr_no,
										sbd.b_desc,
										sbd.b_qty,
										sbd.dr_qty,
										sbd.b_amount,
										sbd.b_unit,
										sj.jo_actual,
										sj.bo_no,
										sj.completed_by,
										sj.jo_payment_amount 
								FROM sales_bookings_details AS sbd 
								LEFT JOIN sales_jo AS sj USING(b_id) 
								LEFT JOIN sales_bookings AS sb USING(b_id) 
								LEFT JOIN sales_clients AS sc ON sb.client_id = sc.client_id 
								WHERE sc.client_id = $client_id 
									AND sbd.dr_no <> 0 
									AND (sbd.dr_qty <> 0 AND sbd.b_amount <> 0)
									AND sj.completed_by = ''
								ORDER BY sbd.dr_date ASC") or die(mysql_error());	
								
								 while ($dr_row = mysql_fetch_assoc($select_delivered)) :


								$total_amnt = ($dr_row['dr_qty'] * $dr_row['b_amount']);

								if ($dr_row['jo_actual'] != '') 
								{
									if(array_key_exists($dr_row['jo_actual'],$booking))
									{
										$total_pay = $booking[$dr_row['jo_actual']]['payBalance'];
									} else {
										$total_pay = $dr_row['jo_payment_amount'];
									}
								} elseif ($dr_row['jo_actual'] == '') 
								{
									if(array_key_exists($dr_row['bo_no'],$booking))
									{
										$total_pay = $booking[$dr_row['bo_no']]['payBalance'];
									} else {
										$total_pay = $dr_row['jo_payment_amount'];
									}
								} 


		
									if($total_amnt >= $total_pay)
									{
										$dr_balance = $total_amnt - $total_pay;
										$pay_balance = 0;
									} else {
										$pay_balance = $total_pay - $total_amnt;
										$dr_balance = 0;
									}

									if ($dr_row['jo_actual'] != '') 
									{
										$booking[$dr_row['jo_actual']] = array (
											"payBalance" =>	$pay_balance			
															
										);
									} elseif ($dr_row['jo_actual'] == '') 
									{
										$booking[$dr_row['bo_no']] = array (
											"payBalance" =>	$pay_balance	
										);
									} 

									if($dr_balance == 0)
									{
										continue;
									}
									
		
			$total_amount += ($dr_row['dr_qty'] * $dr_row['b_amount']);
			$full_total_amount += $dr_balance;
		endwhile;
		
	
	//echo number_format($total_amount, 2);

										
										
										
										
										
										
											echo "ACCOUNT BALANCE (BASED ON DR): <b class='w3-text-red w3-large'>".number_format($full_total_amount, 2)."</b></br>";
											echo "TOTAL ACTIVE JO WITH LESS PAYMENTS: &nbsp <b class='w3-text-red w3-large'>P ".number_format($r_ob['jo_ob_total'],2)."</b>
												  </div>";
											$day=0;
										}else{}							
									}
									
									
									
									//for regular, vip, cod, government with CREDIT LIMIT clients
									else
									{
										if($rx['credit_limit']!=0)
										{
											if($r_ob['jo_ob_total'] >= $rx['credit_limit'])
											{	
											
											  echo "<div class='w3-pale-red' align='center'>
													CREDIT LIMIT REACHED!!!
													<br/>
													PLEASE SETTLE OUTSTANDING BALANCE TO CONTINUE TRANSACTION
													<br/>
													<b class='w3-text-red w3-large'>BALANCE: &nbsp; P ".number_format($r_ob['jo_ob_total'],2)."</b>
													</div>";
											
											}
											else
											{
												echo "<div class='w3-pale-red'>
														ACCOUNT HAS AN OUTSTANDING BALANCE OF:<br/><b class='w3-text-red w3-large'>P ".number_format($r_ob['jo_ob_total'],2)."</b>
													  </div>";
											}
										}else{}
										
										if($rx['terms']!=0)
										{
											$s_dr="SELECT b.dr_no, b.dr_date
													FROM sales_jo a
													INNER JOIN sales_bookings_details b
														ON a.b_id=b.b_id
													WHERE a.paid=0 AND b.dr_date!='0000-00-00' AND a.client_id=$client_id
													ORDER BY a.jo_actual_date ASC
														LIMIT 1";
											$q_dr=mysql_query($s_dr) or die(mysql_error());
											$r_dr=mysql_fetch_assoc($q_dr);
											
											
												 if($r_dr['dr_date']=="0000-00-00")
													{ 
													$day=0;
													echo "<div><i class='w3-text-red'>* No DR on pending JO</i></i>"; 
													}
												elseif($r_dr['dr_date']=="")
													{
													$day=0;
													echo "<div><i class='w3-text-red'>* No DR on pending JO</i></i>"; 
													}														
												else{ 
													//oldest pending DR here, parameter shoul be placed here
													echo "<i class='w3-tiny w3-text-red'><br/>Oldest Pending DR: <span class='w3-text-gray'>".$r_dr['dr_no']."</span> / ".date('m/d/Y',strtotime($r_dr['dr_date']))."</i><br/>";
													$dr_date_old = strtotime($r_dr['dr_date']);
													$now = strtotime(date('Y-m-d'));
													$day = ((($now-$dr_date_old)/3600)/24) - $rx['terms'];
													if($day > $rx['terms'])
														{
															echo "<b class='w3-text-red'>* ".$day." DAYS OVER DUE *</b>&nbsp;&nbsp;&nbsp;
																  <i class='w3-tiny'>Please Settle Oldest Pending JO</i>";
														}else{}
													}
													
													
										}
									}
			
			
					if($access['d4']==1)
						{
							//credit limit cheker
							if( ((1+$rx['credit_limit']) >= (1+$r_ob['jo_ob_total'])) or ($rx['credit_limit']==0) )
							{  
						
								//Terms Checker
								$day = 0;
								if($day<=$rx['terms'])
								{
								
								?>
						
							<form method='get' action='script_sales_addquotation.php'>
								<input name='client_id' type='hidden' value='<?php echo $_REQUEST['client_id']; ?>'>
								<input name='client' type='hidden' value='<?php echo $_REQUEST['client']; ?>'>
								
								  <span class='w3-tiny'>THRU: </span> 
								  <select required name='trans_type'>
									 <option disabled selected></option>
									 <?php
									 $sd=mysql_query("select * from sales_transaction_type") or die(mysql_error());
									 $rd=mysql_fetch_assoc($sd);
									 do
									 {
									 echo "<option value=".$rd['trans_no'].">".$rd['trans_desc']."</option>";
									 }while($rd=mysql_fetch_assoc($sd));	 
									 ?>
								  </select>
								
								<input class='w3-tiny btn btn-primary' name='add_booking' type='submit' value='BOOKING' onclick='return confirm("Create Now? Are you sure?")'>
							</form>
							
						<?php 	}
							
							}	
						
						}
						// Killer! End ?>
						</td>
						
						
						
						<td class="w3-tiny" valign="top" align="center">
						* GENARATE JO AMOUNT PER DATE RANGE
						<form>
							<input name="client_id" type="hidden" value="<?php echo $_REQUEST['client_id']; ?>">
							<input name="client" type="hidden" value="<?php echo $_REQUEST['client']; ?>">
							<input name="sales" type="hidden" value="1">
							<input name="newjobs" type="hidden" value="1">
							<input name="create_quotation" type="hidden" value="1">
				 START&nbsp;<input name="historyStart" type="date" value="<?php if(isset($_REQUEST['historyStart'])){ echo $_REQUEST['historyStart']; } else{ echo date('Y-m-d'); } ?>">
							<input name="historyEnd" type="date" value="<?php if(isset($_REQUEST['historyEnd'])){ echo $_REQUEST['historyEnd']; } else{ echo date('Y-m-d'); } ?>">&nbsp;END<br/>
							<input name="history" type="submit" value="GENERATE JO TOTAL AMOUNT"><br/><br/>
						</form>
						<?php 
						if(isset($_REQUEST['history']))
						{
							$client_id=$_REQUEST['client_id'];
							
							$historyStart=$_REQUEST['historyStart'];
							$historyEnd=$_REQUEST['historyEnd'];
							
							$sHistory="select sum(jo_amount) as jo_amount from sales_jo where client_id='$client_id' and created_datetime>='$historyStart 00:00:00' and created_datetime<='$historyEnd 23:59:59'";
							$qHistory=mysql_query($sHistory) or die(mysql_error());
							$rHistory=mysql_fetch_assoc($qHistory);
							
							$sHistory_actual="select sum(jo_amount) as jo_amount from sales_jo where client_id='$client_id' and jo_actual_date>='$historyStart' and jo_actual_date<='$historyEnd'";
							$qHistory_actual=mysql_query($sHistory_actual) or die(mysql_error());
							$rHistory_actual=mysql_fetch_assoc($qHistory_actual);
							
							echo "<b class='w3-text-indigo'>".number_format(round($rHistory['jo_amount'],2),2)." </b>&nbsp;Based on System Creation. <a href='script_sales_clients_history.php?system=1&client_id=$client_id&historyStart=$historyStart&historyEnd=$historyEnd' target='_blank'>View Details</a><br/>";
							echo "<b class='w3-text-red'>".number_format(round($rHistory_actual['jo_amount'],2),2)." </b>&nbsp;Based on Actual JO Date. <a href='script_sales_clients_history.php?actual=1&client_id=$client_id&historyStart=$historyStart&historyEnd=$historyEnd' target='_blank'>View Details</a>";
							
						}
						?>
						
						
						<br/>
						<br/>
						<br/>
						
						GENERATOR TOOL
							<form action='script_sales_soa_generator.php' method='get' target='_blank'>
								<input name='client_id' type='hidden' value='<?php echo $_REQUEST['client_id']; ?>' >
								<input type='submit' value='GENERATE SOA'>
							</form>
							
							<form action='script_sales_subsidiary.php' method='get' target='_blank'>
								<input name='client_id' type='hidden' value='<?php echo $_REQUEST['client_id']; ?>' >
								<input type='submit' value='SUBSIDIARY'>
							</form>
						
						
						</td>
						
						<td class="w3-tiny" valign="top" align="center" width="300">
						
							* ROUTING RECORDS<br/></br>
							<a href="script_sales_routing_forms.php?client_id=<?php echo $_REQUEST['client_id']; ?>" target="_blank">View List</a>
							<br/><br/>
							<?php
							//FOR DEP ED DIVISION START
							if($_REQUEST['client_id']==16279)
							{	
								$mm=mysql_query("SELECT jo_no, jo_amount, count(*) as jo_count1 FROM sales_jo where client_id=16279 group by jo_amount order by jo_amount desc");
								$nn=mysql_fetch_assoc($mm);
								echo "<table class='w3-tiny'>
										<tr class='w3-green'>
											<td>&nbsp;&nbsp;jo_no&nbsp;&nbsp;</td>
											<td>&nbsp;&nbsp;jo_amount&nbsp;&nbsp;</td>
											<td>&nbsp;&nbsp;count&nbsp;&nbsp;</td>
										</tr>";
								do{
									echo "<tr>
											<td align='right'>".$nn['jo_no']."</td>
											<td align='right'>".number_format($nn['jo_amount'],2)."</td>
											<td align='right'>".$nn['jo_count1']."</td>
										  </tr>";
								}while($nn=mysql_fetch_assoc($mm));
								echo "</table>";
							}
							else{}
							//FOR DEP ED DIVISION END ?>
						</td>
					</tr>	
				</table>		
						
						
						<br/>
						<!--Create New Quotation and Booking Button End-->
					
					
			 <!--BOOKING VIEW AREA START-->			
			<table class='table'>
			  <tr align='center' class='w3-pale-green w3-tiny'>
			     <td colspan='10'><b class='w3-text-green'>BOOKING</b> HISTORY FOR <b><?php echo $_REQUEST['client']; ?></b></td>
			  </tr>
			  <tr class='w3-tiny w3-green' align='center'>
				 <td>RECIEVED BY</td><td>THRU</td><td>BOOKING ID.</td><td>JOB ORDER NO.</td><td>TOTAL AMOUNT</td><td>DATE CREATED</td><td>STATUS DATE</td><td>STATUS</td><td width='200'>ACTION</td>
			  </tr>
						  
	  <?php 
	          $client_id=$_REQUEST['client_id'];
			  $blank="0000-00-00 00:00:00";
			  $q11=mysql_query("select * from sales_bookings where client_id=$client_id and approved_datetime='$blank' order by b_id desc");
			  $r11=mysql_fetch_assoc($q11);
							
				do{
				    if($r11['b_id'])
					  {	
					    $b_id1=$r11['b_id'];
					    $qx11=mysql_query("select sum(b_qty * b_amount) as b_total from sales_bookings_details where b_id='$b_id1' ") or die(mysql_error());
					    $rx11=mysql_fetch_assoc($qx11);
					
					    $q_id1=$r11['q_id'];	
					    $qx11a=mysql_query("select sum(q_qty * q_amount) as q_total from sales_quotations_details where q_id='$q_id1' ") or die(mysql_error());
					    $rx11a=mysql_fetch_assoc($qx11a);
									
						$tt1=$r11['trans_type'];
						$qa1=mysql_query("select * from sales_transaction_type where trans_no=$tt1") or die(mysql_error());
						$ra11=mysql_fetch_assoc($qa1);
						echo "<tr class='w3-hover-pale-red' align='center'>
									   <td class='w3-tiny'>".$r11['created_by']."</td>
									   <td class='w3-tiny'>".$ra11['trans_desc']."</td>
									   <td><i class='w3-tiny'>".$r11['b_id']."</i></td>
									   <td>".$r11['b_jo']."</td>";
			if($r11['q_id']==0){ echo "<td>".number_format($rx11['b_total'],2)."</td>"; }
						   else{ echo "<td>".number_format($rx11a['q_total'],2)."</td>"; }
								 echo "<td class='w3-tiny'>".date('F d, Y h:i A',strtotime($r11['created_datetime']))."</td>";
		 if($r11['approved_by']!=""){ echo "<td class='w3-text-orange w3-tiny'>".date('F d, Y h:i A',strtotime($r11['approved_datetime']))."</td>"; }
	elseif($r11['cancelled_by']!=""){ echo "<td class='w3-text-red w3-tiny'>".date('F d, Y h:i A',strtotime($r11['cancelled_datetime']))."</td>"; }else{ echo "<td></td>"; }
								 echo "<td class='w3-tiny'>";
								if($r11['approved_by']=="" && $r11['cancelled_by']==""){ echo "<div class='w3-khaki'>PENDING</div>"; }
								if($r11['approved_by']!="" && $r11['b_jo']==0){ echo "<div class='w3-green'>FOR JO APPROVAL</div>"; } 
								if($r11['cancelled_by']!=""){ echo "<div class='w3-red'>CANCELLED</div>"; }
								if($r11['b_jo']!=0){ echo "<div class='w3-amber'>JO CREATED</div>"; }
								 echo "</td>
									   <td class='w3-tiny'>";
										   
												if($r11['q_id']==0)
												  {	   
												  //FOR BOOKINGS W/OUT QUOTATION ACTION FIELD
													
													   
															 echo "<form method='get' action='script_sales_addquotation.php' target='_blank'>
																   <input name='b_date' type='hidden' value='".$r11['created_datetime']."'>
																   <input name='client' type='hidden' value='".$_REQUEST['client']."'>
																   <input name='b_id' type='hidden' value='".$r11['b_id']."'>
																   <input name='client_id' type='hidden' value='".$r11['client_id']."'>";
													if($r11['approved_by']=="") 
													  { 
														if($r11['cancelled_by']=="") 
														  { 
															  if($access['d7']==1)
																{
																  echo "<input name='add_booking_details' type='submit' value='ADD DETAILS'>&nbsp;";
																}  
														  }
													  }
													         if($access['d8']==1)
															   { 
																	if($r11['b_jo']==0){
																		echo "<input name='print_booking_details' type='submit' value='JO DETAILS'>";
																	}
															   }
															   
														   echo "</form>";
												  }
											  else{	
												   //FOR BOOKING W/ QUOTATION ACTION FIELD
													$q_idx=$r11['q_id'];
													$q=mysql_query("select * from sales_quotations where q_id=$q_idx");
													$r=mysql_fetch_assoc($q);
													 
															 echo "<form method='get' action='script_sales_addquotation.php' target='_blank'>
																   <input name='b_date' type='hidden' value='".$r11['created_datetime']."'>
																   <input name='client' type='hidden' value='".$_REQUEST['client']."'>
																   <input name='q_id' type='hidden' value='".$r['q_id']."'>
																   <input name='b_id' type='hidden' value='".$r11['b_id']."'>
																   <input name='client_id' type='hidden' value='".$r11['client_id']."'>";
													if($r11['approved_by']=="")
													  { 
														if($r11['cancelled_by']=="")
														  { echo "<input name='add_quotation_details' type='submit' value='ADD DETAILS'>&nbsp;"; }
													  } 
															 echo "<input name='print_booking_details' type='submit' value='JO DETAILS'>
																   </form>";
												  }	
												  
												  
										echo "</td>
								  </tr>";
								}
							else{}
										   
							  } while($r11=mysql_fetch_assoc($q11));	
							 
					echo "</table>";
					?>
		<!--BOOKING VIEW AREA END-->	
			 
			 
			 <hr>
			 
			 
		<!--JO VIEW AREA START-->
		<?php 
				//PAGINGNATION
				if(isset($_REQUEST['pageno']))
				{ $pageno = $_REQUEST['pageno']; } 
				else { $pageno = 1; }
								
				$no_of_records_per_page = 30;
				$offset = ($pageno-1) * $no_of_records_per_page;
				//PAGINGNATION			
							
				$client_id=$_REQUEST['client_id'];
				//FOR BOOKINGS----
			    if($bch=="goc")
			    {
					
					if(isset($_REQUEST['show_complete']))
					{
						$total_pages_sql = "select count(jo_no) as count_jo from sales_jo where client_id='$client_id' and completed_by!=''";
						$result = mysql_query($total_pages_sql);
						//$total_rows = mysql_fetch_array($result)[0];
						$total_pages = ceil($total_rows / $no_of_records_per_page);
						
						$s111="select * from sales_jo where client_id=$client_id and completed_by!='' order by jo_no desc LIMIT $offset, $no_of_records_per_page";
					}
					else
					{ 	
						$total_pages_sql = "select count(jo_no) as count_jo from sales_jo where client_id='$client_id' and completed_by=''";
						$result = mysql_query($total_pages_sql);
						$total_rows1 = mysql_fetch_assoc($result);
						$total_rows = $total_rows1['count_jo'];
						$total_pages = ceil($total_rows / $no_of_records_per_page);
						
						$s111="select * from sales_jo where client_id=$client_id and completed_by='' order by jo_no desc LIMIT $offset, $no_of_records_per_page";
					}
				}
				else
				{
					if(isset($_REQUEST['show_complete']))
					{	
						$total_pages_sql = "select count(a.jo_no) as count_jo 
						      from sales_jo as a
						      inner join sales_bookings as b on a.b_id=b.b_id
						      where a.client_id=$client_id and b.bch='$bch' and completed_by!=''";
						$result = mysql_query($total_pages_sql);
						//$total_rows = mysql_fetch_array($result)[0];
						$total_pages = ceil($total_rows / $no_of_records_per_page);
						
						$s111="select a.* 
						      from sales_jo as a 
						      inner join sales_bookings as b on a.b_id=b.b_id
						      where a.client_id=$client_id and b.bch='$bch' and completed_by!=''
						      order by jo_no desc, created_datetime desc LIMIT $offset, $no_of_records_per_page";
					}
					else
					{	
						$total_pages_sql = "select count(a.jo_no) as count_jo 
						      from sales_jo as a
						      inner join sales_bookings as b on a.b_id=b.b_id
						      where a.client_id=$client_id and b.bch='$bch' and completed_by=''";
						$result = mysql_query($total_pages_sql);
						//$total_rows = mysql_fetch_array($result)[0];
						$total_pages = ceil($total_rows / $no_of_records_per_page);
						
						$s111="select a.* 
						      from sales_jo as a 
						      inner join sales_bookings as b on a.b_id=b.b_id
						      where a.client_id=$client_id and b.bch='$bch' and completed_by=''
						      order by jo_no desc, created_datetime desc LIMIT $offset, $no_of_records_per_page";
					}
				}
			   
			   $q111=mysql_query($s111) or die(mysql_error());
			   $r111=mysql_fetch_assoc($q111);
			   
			   //PAGINGNATION
			   if(isset($_REQUEST['pageno']))
			   {
					if($_REQUEST['pageno']!=1)
					{	
						$pageno=$_REQUEST['pageno'];
						$z=$offset+1;
					}
					else { $z=1; }
			   }
			   else { $z=1; }
			   //PAGINGNATION
			   
		?>
		
			<table class='table'>
			  <tr align='center' class='w3-sand w3-tiny'>
			     <td colspan='14'>
					<b class='w3-text-orange'>JOB ORDER</b> HISTORY FOR <b><?php echo $_REQUEST['client']; ?></b>
						<br/><br/>
					
						<a href='<?php echo "admin_sales.php?client_id=".$_REQUEST['client_id']."&client=".$_REQUEST['client']."&sales=1&newjobs=1&create_quotation=1"; ?>'>SHOW PENDING <?php if(!isset($_REQUEST['show_complete'])){ echo "(<b class='w3-text-red'>".$total_rows."</b>)"; } ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;
						<a href='<?php echo "admin_sales.php?client_id=".$_REQUEST['client_id']."&client=".$_REQUEST['client']."&sales=1&newjobs=1&create_quotation=1&show_complete=1"; ?>'>SHOW COMPLETED <?php if(isset($_REQUEST['show_complete'])){ echo "(<b class='w3-text-red'>".$total_rows."</b>)"; } ?></a>
						
						<br/>
					
				 	<!--PAGINATION START-->
							<ul class="pagination w3-tiny">
							
							  <?php if(isset($_REQUEST['show_complete']))
									{ ?>
										<li><a href="<?php echo "admin_sales.php?client_id=".$_REQUEST['client_id']."&client=".$_REQUEST['client']."&sales=1&newjobs=1&create_quotation=1&show_complete=1"; ?>&pageno=1">FIRST</a></li>
										
										<li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
											<a href="<?php if($pageno <= 1){ echo '#'; } else { echo "admin_sales.php?client_id=".$_REQUEST['client_id']."&client=".$_REQUEST['client']."&sales=1&newjobs=1&create_quotation=1&show_complete=1&pageno=".($pageno - 1); } ?>">PREV</a>
										</li>
										
										
										<li>
										<?php 
										if(isset($_REQUEST['pageno']))
										  { echo "<span class='w3-text-purple'><b>".$_REQUEST['pageno']."</b></span>"; } 
										  else 
										  { echo "<span class='w3-text-purple'><b>1</b></span>"; }
										?>
										</li>
										
										
										<li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
											<a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "admin_sales.php?client_id=".$_REQUEST['client_id']."&client=".$_REQUEST['client']."&sales=1&newjobs=1&create_quotation=1&show_complete=1&pageno=".($pageno + 1); } ?>">NEXT</a>
										</li>
										
										<li><a href="<?php echo "admin_sales.php?client_id=".$_REQUEST['client_id']."&client=".$_REQUEST['client']."&sales=1&newjobs=1&create_quotation=1&show_complete=1&pageno=$total_pages"; ?>">LAST</a></li>
							  <?php }
									else
									{ ?>
										<li><a href="<?php echo "admin_sales.php?client_id=".$_REQUEST['client_id']."&client=".$_REQUEST['client']."&sales=1&newjobs=1&create_quotation=1"; ?>&pageno=1">FIRST</a></li>
										
										<li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
											<a href="<?php if($pageno <= 1){ echo '#'; } else { echo "admin_sales.php?client_id=".$_REQUEST['client_id']."&client=".$_REQUEST['client']."&sales=1&newjobs=1&create_quotation=1&pageno=".($pageno - 1); } ?>">PREV</a>
										</li>
										
										
										<li>
										<?php 
										if(isset($_REQUEST['pageno']))
										  { echo "<span class='w3-text-purple'><b>".$_REQUEST['pageno']."</b></span>"; } 
										  else 
										  { echo "<span class='w3-text-purple'><b>1</b></span>"; }
										?>
										</li>
										
										
										<li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
											<a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "admin_sales.php?client_id=".$_REQUEST['client_id']."&client=".$_REQUEST['client']."&sales=1&newjobs=1&create_quotation=1&pageno=".($pageno + 1); } ?>">NEXT</a>
										</li>
										
										<li><a href="<?php echo "admin_sales.php?client_id=".$_REQUEST['client_id']."&client=".$_REQUEST['client']."&sales=1&newjobs=1&create_quotation=1&pageno=$total_pages"; ?>">LAST</a></li>
							 <?php }
									?>
							
							</ul>
					<!--PAGINATION END-->
					
				</td>
			  </tr>
			  
			  <tr class='w3-tiny w3-khaki' align='center'>
				 <td>#</td><td>CREATED BY</td><td>JOB ORDER NO.</td><td><i>JO ACTUAL</i></td><td><i>BOOKING NO.</i></td><td><i>PO NO</i></td><td><i>DR NO</i></td><td>TOTAL AMOUNT</td><td>CREATED DATE</td><td>COMPLETED DATE</td><td>STATUS</td><td width='200'>ACTION</td><td>PRODUCTION STATUS</td>
			  </tr>
						  
	          
<?php			   
			do{
				if($r111['b_id'])
				  {	
				   $b_id1=$r111['b_id'];
				   $jo_no1=$r111['jo_no'];
				   
				   $q112=mysql_query("select * from sales_bookings where client_id=$client_id and b_id='$b_id1'");
				   $r112=mysql_fetch_assoc($q112);
				   
				   $tt=$r111['trans_type'];
				   $qtt1=mysql_query("select trans_desc from sales_transaction_type where trans_no=$tt") or die(mysql_error());
				   $rtt1=mysql_fetch_assoc($qtt1);
				   
				   echo "<tr class='w3-hover-pale-red w3-tiny' align='center'>
										   <td class='w3-text-orange'><i>".$z++."</i></td>	
										   <td><i>".$r111['created_by']."</i></td>
										   <td><i>".$r111['jo_no']."</i></td>
										   
										   
										   
										   <td>";
										    	echo "<i class='w3-tiny'>";
												
												if($r111['jo_actual']!='')
												{
													if($r111['salesperson']!=""){
													echo "<span class='w3-text-orange'>".$r111['salesperson']."</span><br/>";
													}else{}
													echo $r111['jo_actual']."<br/>".date('m/d/Y',strtotime($r111['jo_actual_date']));
												}
												else{}
												
												echo "</i>";
									 echo "</td>
									 
									 
									 
										  <td>";
												echo "<i class='w3-tiny'>";
												
												if($r111['bo_no']!=0)
												{
													echo "<span class='w3-text-orange'>".$r111['salesperson']."</span><br/>";
													echo $r111['bo_no']."<br/>".date('m/d/Y',strtotime($r111['bo_no_date']));
												}
												else{}
												
												echo "</i>";
									 echo "</td>
									 
									 
									 
									       <td>";
										    if($r111['po_no']=="")
											{ 
												if($r111['completed_by']=="")
												  {
										?>
												<form>
													<input name='sales' type='hidden' value='1'>
													<input name='newjobs' type='hidden' value='1'>
													<input name='create_quotation' type='hidden' value='1'>
													<input name='jo_no' type='hidden' value='<?php echo $r111['jo_no']; ?>'>
													<input name='client_id' type='hidden' value='<?php echo $_REQUEST['client_id']; ?>'>
													<input name='client' type='hidden' value='<?php echo $_REQUEST['client']; ?>'>
													<i><input required class='w3-tiny' name='po_no' type='text' placeholder='PO NO INPUT'></i><br/>
													<i><input required class='w3-tiny' name='po_date' type='date'></i>
													<i><input class='w3-tiny' type='submit' value='SET' onclick='return confirm("Sure?")'></i>
												</form>
											
									  <?php        } else { }
									        }
											else
											{
											echo "<i class='w3-tiny'>".$r111['po_no']."<br/>".date('m/d/Y',strtotime($r111['po_date']))."</i>";
											}
										   
									 echo "</td>";
									 
									 
									 echo "<td>";
										$b_id=$r111['b_id'];
										$sx1="select sum(dr_qty*b_amount) as dr_total from sales_bookings_details where b_id='$b_id'";
										$qx1=mysql_query($sx1) or die(mysql_error());
										$rx1=mysql_fetch_assoc($qx1);	
									 
										echo "<i class='w3-text-blue'>DR Total: ".number_format($rx1['dr_total'],2)."</i><br/>";
									 
										$xyz_b_id=$r111['b_id'];
										$xyz=mysql_query("select dr_no,dr_date from sales_bookings_details where b_id='$xyz_b_id' group by dr_no") or die(mysql_error());
										$xyz1=mysql_fetch_assoc($xyz);
										
										do{ 
											if($xyz1['dr_no']!=0)
											  { echo "<i>".$xyz1['dr_no']."</i><br/><i class='w3-tiny'>".date('m/d/Y',strtotime($xyz1['dr_date']))."</i><br/>"; }else{ }
										  } while($xyz1=mysql_fetch_assoc($xyz));
						             echo "</td>";
									 
									 
									 echo "<td><b class='w3-small w3-text-red'>".number_format($r111['jo_amount'],2)."</b></td>
										   <td>".date('F d, Y h:i A',strtotime($r111['created_datetime']))."</td>";
										   
										   
			   if($r111['completed_by']==""){ echo "<td></td>
												    <td>
														<div class='w3-khaki w3-tiny'>INPROGRESS</div>";
											
											$jo_no=$r111['jo_no'];
																    
											$sxx="select * from sales_jo_assign where jo_no=$jo_no";
											$qxx=mysql_query($sxx) or die(mysql_error());
											$rxx=mysql_fetch_assoc($qxx);
											$artist=$rxx['assign_to'];
											
											if($r111['paid']==1){ echo "<div class='w3-green w3-tiny'>PAID</div><div><b class='w3-tiny text-primary'>$artist</b></div>"; }
														   else { 
																	$sx1="select sum(payment) as balance from sales_jo_payments where jo_no=$jo_no";
																    $qx1=mysql_query($sx1) or die(mysql_error());
																    $rx1=mysql_fetch_assoc($qx1);
																    $balance=number_format($r111['jo_amount']-$rx1['balance'],2);
											
																
																//balance and partial separation start
																echo "<div class='w3-red w3-tiny'>BALANCE</div>
																	  <div class='w3-tiny'>$balance</div>";
																
																if(($rx1['balance']>0) and ($rx1['balance']<$r111['jo_amount']))
																	{
																echo "<div class='w3-blue w3-tiny'>PARTIAL</div>
																	  <div class='w3-tiny'>".number_format($rx1['balance'],2)."</div>
																	  ";
																	}else{}
																
																echo "<b class='text-primary'>$artist</b>"; 
																//balance and partial separation end
																
																}
											  echo "</td>"; 
											}
							  
							           else { 
												echo "<td class='w3-text-blue'>".date('F d, Y h:i A',strtotime($r111['completed_datetime']))."</td>
											          <td><div class='w3-blue'>COMPLETED</div></td>"; 
											} ?>
													
													
													<td class='w3-xlarge'>
												<?php 	
													
													switch ($r111['validation'])
													{
														case 0: echo "<span class='w3-tiny w3-text-red'>NO VALIDATION</span><br/>"; break;
														case 1: echo "<span class='w3-tiny w3-text-blue'>VALIDATION PRINTED</span><br/>"; break;
														case 2: echo "<span class='w3-tiny w3-text-red'>VALIDATION RE-PRINTED</span><br/>"; break;
													}
													
													
												if($r111['completed_by']=="")
											      {
														if($r111['validation']==0)
														{ ?>
															<a title='PRINT VALIDATION' class='fa fa-print' target='_blank' href='script_sales_validation.php?vprint=1&jo_no=<?php echo $r111['jo_no']; ?>' onclick='return confirm("PRINT VALIDATION?")'></a>
												  <?php }
														elseif(($r111['validation']==1)) 
												        {	?>
															<a title='RE-PRINT VALIDATION' class='fa fa-print w3-text-red' target='_blank' href='script_sales_validation.php?re_vprint=1&jo_no=<?php echo $r111['jo_no']; ?>' onclick='return confirm("PRINT VALIDATION?")'></a>
												  <?php }else{}
														
											      } else {} ?>
													
													<?php
													$client_id=$_REQUEST['client_id'];
													$q112=mysql_query("select * from sales_bookings where client_id=$client_id order by b_id desc");
													$r112=mysql_fetch_assoc($q112);
													
													echo "<a title='DR/JO DETAILS' class='fa fa-truck' target='_blank' href='script_sales_addquotation.php?b_date=".$r112['created_datetime']."&client=".$_REQUEST['client']."&jo_no=".$r111['jo_no']."&b_id=".$r111['b_id']."&client_id=".$r112['client_id']."&print_booking_details=1&salesperson=".$r111['created_by']."'></a>";
													?>
													
													
													
													<?php if($access['d9']==1)
													{ 
															$jo_note=$r111['jo_no'];
															$q_note=mysql_query("select count(jo_no) as jo_count1 from sales_jo_progress where jo_no=$jo_note");
															$r_note=mysql_fetch_assoc($q_note);
														
														if($r_note['jo_count1']!=0)
														{ ?>
																<a title='NOTES / PROGRESS' class='notification' target='_blank' href='script_sales_jo_progress.php?client=<?php echo $_REQUEST['client']; ?>&jo_no=<?php echo $r111['jo_no']; ?>'>
																<span class='fa fa-sticky-note-o text-primary'></span>
																<span class='badge w3-red w3-tiny'><?php echo $r_note['jo_count1']; ?></span>
																</a>
												  <?php } else { ?>
																<a title='NOTES / PROGRESS' class='fa fa-sticky-note-o text-primary' target='_blank' href='script_sales_jo_progress.php?client=<?php echo $_REQUEST['client']; ?>&jo_no=<?php echo $r111['jo_no']; ?>'></a>
															<?php } ?>
															
											  <?php } ?>  
													
													
													
													
													
													
													<?php if($access['d11']==1)
															{ 
																if($r111['completed_by']=="")
																{ ?>
																
															<a title='ASSIGN' class='fa fa-male' target='_blank' href='script_sales_jo_assign.php?client=<?php echo $_REQUEST['client']; ?>&jo_no=<?php echo $r111['jo_no']; ?>'></a>
															<?php }
															} ?>  
													
													<?php if($access['d10']==1){ ?>
													<a title='PAYMENT' class='fa fa-money' target='_blank' href='script_sales_jo_payments.php?jo_no=<?php echo $r111['jo_no']; ?>'></a>
													<?php } ?>  
													
													<a title='INVENTORY' class='fa fa-cube' target='_blank' href='inv_client_data.php?client=<?php echo $_REQUEST['client']; ?>&jo_no=<?php echo $r111['jo_no']; ?>'></a>
													</td>
													
													
													
													
											<!----PICKUP / DELIVERY STATUS---->
											<?php echo "<td>";
										
														  if($r111['production_status']!=9)
															{ ?>
											
																	<?php if($r111['production_status']==1)
																			{ 
																				echo "<div class='w3-lime w3-tiny'>(READY)<br/>IN FG</div>";
																				echo "<i><span class='w3-tiny'>".date('m/d/Y h:i A',strtotime($r111['production_date']))."</span></i>";
																			}
																			
																			
																			
																			
																	  elseif($r111['production_status']==8)
																			{ 
																				$sx1="select sum(dr_qty*b_amount) as dr_total from sales_bookings_details where b_id='$b_id'";
																				$qx1=mysql_query($sx1) or die(mysql_error());
																				$rx1=mysql_fetch_assoc($qx1);	
									 
																			    if($r111['jo_amount'] > $rx1['dr_total'])
																				{ 
																					if($rx1['dr_total']!=0)
																					{ echo "<div class='w3-blue'>PARTIAL</div>"; }
																					else{}
																			    }
																				
																				if($r111['jo_amount'] < $rx1['dr_total'])
																				{ echo "<div class='w3-purple'>OVER IN DR</div>"; }
																				else{}	
																				
																				echo "<div class='w3-pink'>RELEASED FROM FG</div>";
																				
																				if($r111['production_date']!="0000-00-00 00:00:00")
																				{ echo "<i><span class='w3-tiny'>".date('m/d/Y h:i A',strtotime($r111['production_date']))."</span></i>"; }
																				else{ echo "<i><span class='w3-tiny'>system_tool</span></i>"; }
																			}
																			
																			
																			
																			
																	  elseif($r111['production_status']!=0 and $r111['production_status']!=1 and $r111['production_status']!=8 and $r111['production_status']!=9)
																		    {
																				echo "<div class='w3-pink w3-tiny'>ROUTING IN PROCESS</div>";
																		    }
																			else
																			{ echo "<div class='w3-khaki w3-tiny'>INPROGRESS</div>"; } ?>
																		
																		
											<?php        	
															
															}
															
															else
															{
																echo "<div class='w3-green w3-tiny'>DELIVERED</div>"; 
															}
										echo "</td>";
									
					
							echo "</tr>";
					}
			    else{}
				
				
				
				//Production Status LEGEND
				// * 0 = No Action
				// * 1 = Ready For PuckUp / Delivery
				// * 8 = Released From FG
				// * 9 = Delivered
				
				//JO COMPLETE SETTER START
				$username=$_SESSION['username'];
				$jo_no=$r111['jo_no'];
				$b_id=$r111['b_id'];
				$sx1="select sum(dr_qty*b_amount) as dr_total from sales_bookings_details where b_id='$b_id'";
				$qx1=mysql_query($sx1) or die(mysql_error());
				$rx1=mysql_fetch_assoc($qx1);
				
				if($r111['paid']==1 and $r111['completed_by']=="" and $r111['production_status']>=8 and ($r111['jo_actual']!="" or $r111['bo_no']!=0))
				{ 
					if(round($rx1['dr_total'])==round($r111['jo_amount']))
					{
						mysql_query("update sales_jo set completed_datetime=now(), completed_by='$username', production_status=9, production_date=now(), delivered=1 where jo_no='$jo_no'") or die(mysql_error());
							
						$jo_msg="JO $jo_no COMPLETED!";
						mysql_query("insert into sales_jo_progress (jo_no,jo_msg,jo_msg_by,date,time) values ('$jo_no','$jo_msg','$username',curdate(),curtime())") or die(mysql_error());
							
						$trans="jo $jo_no completed";
						$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
						$log_query=mysql_query($log_sql) or die(mysql_error());
					}else{}
				}else{}
				//JO COMPLETE SETTER END
			  
			  
			  
			  
			  } while($r111=mysql_fetch_assoc($q111));
						 
			   echo "</table>"; ?>
			   
			 <!--JO VIEW AREA END-->
			 
			 
			 
			<?php }
		  //Create Quotation & Booking End-----	?>

	<?php }	   
       }
// New Jobs End -----> 
?>