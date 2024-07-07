<?php // Job Orders Start --->
	  if($access['d22']==1)
	    { 
	      if(isset($_REQUEST['joborders'])) 
	        { 
		      
				//PAGINGNATION
					if(isset($_REQUEST['pageno']))
					{ $pageno = $_REQUEST['pageno']; } 
					else { $pageno = 1; }
									
					$no_of_records_per_page = 30;
					$offset = ($pageno-1) * $no_of_records_per_page;
				//PAGINGNATION	
				
				?>
			  
			   <table>
					<tr>
						<td width='350'>
						   <form method='get'>
							 <input name='sales' type='hidden' value='1'>
							 <input name='joborders' type='hidden' value='1'>
							 <b class='w3-tiny'>START</b> 
							 <input required class='w3-tiny' name='sdate' type='date' value='<?php if(isset($_REQUEST['sdate'])){ echo $_REQUEST['sdate']; }else{ } ?>'>
							 <input required class='w3-tiny' name='edate' type='date' value='<?php if(isset($_REQUEST['edate'])){ echo $_REQUEST['edate']; }else{ } ?>'> 
							 <b class='w3-tiny'>END</b><br/>
						</td>
						
						<td width='250'>
						
							<b class='w3-tiny'>USER:</b>
							 <select class='w3-tiny' required name='user'>
							   <option class='w3-tiny'><?php if(isset($_REQUEST['user'])){ echo $_REQUEST['user']; }else{} ?></option>
							   <option class='w3-tiny'></option>
							   <option class='w3-tiny'>All</option>
							<?php     if($bch=="goc")
										{ $sv="select username,last_name,first_name,bch from users where department like '%SALES%' and user_disable=0 order by last_name"; }
									 else
										{ $sv="select username,last_name,first_name,bch from users where bch='$bch' and user_disable=0 group by last_name order by last_name"; }
									   
									   $qv=mysql_query($sv) or die(mysql_error());
									   $rv=mysql_fetch_assoc($qv);
									   do{ echo "<option class='w3-tiny' value='".$rv['username']."'>".$rv['last_name'].", ".$rv['first_name']." (".$rv['bch'].")</option>"; } while ($rv=mysql_fetch_assoc($qv));
								?>
							 </select>
						
						</td>
						
						
						<td width='300'>
						
							<b class='w3-tiny'>CATEGORY:</b>
							 <select class='w3-tiny' required name='sortby'>
							   <option class='w3-tiny'><?php if(isset($_REQUEST['sortby'])){ echo $_REQUEST['sortby']; }else{} ?></option>
							   <option class='w3-tiny' ></option>
							   <option class='w3-tiny' value='jo'>JOB ORDER NO</option>
							   <option class='w3-tiny' value='client'>CLIENT</option>
							   <option class='w3-tiny' value='total'>TOTAL AMOUNT</option>
							   <option class='w3-tiny' value='date'>DATE</option>
							   <option class='w3-tiny' value='status'>STATUS</option>
							   <option class='w3-tiny' value='completed'>COMPLETED</option>
							 </select>
							 <input class='btn w3-tiny w3-blue' type='submit' value='GO!'>
						   </form>
			   
			            </td>
					
					</tr>
					<tr align='center'>
						<td colspan='4'>
							<?php if(isset($_REQUEST['sdate']) and isset($_REQUEST['edate']))
									{ 
									      if($bch!="goc")
										    {
											echo "<a class='btn w3-tiny' href='script_sales_monitoring_list.php?sdate=".$_REQUEST['sdate']."&edate=".$_REQUEST['edate']."' target='_blank'>SHOW JO STATUS REPORTS</a> |
											      <a class='btn w3-tiny' href='script_sales_monitoring.php?cash_dr=1&sdate=".$_REQUEST['sdate']."&edate=".$_REQUEST['edate']."&bch=".$r9['bch']."&branch1=".$r9['department']."' target='_blank'>SHOW CASH DR</a> | 
												  <a class='btn w3-tiny' href='script_sales_monitoring.php?sales_on_account=1&sdate=".$_REQUEST['sdate']."&edate=".$_REQUEST['edate']."&bch=".$r9['bch']."&branch1=".$r9['department']."' target='_blank'>SHOW SALES ON ACCOUNT DR</a> | 
												  <a class='btn w3-tiny' href='script_sales_monitoring.php?sortby=jo&total_posted=1&sdate=".$_REQUEST['sdate']."&edate=".$_REQUEST['edate']."&bch=".$r9['bch']."&branch1=".$r9['department']."' target='_blank'>SHOW PAYMENT POSTED</a>";
											}	

							        } ?>
						</td>
					</tr>
			   <table>
			   
			   <br/>
			   
			   <table class='table'>
				  <tr align='center' class='w3-sand w3-tiny'>
					 <td colspan='14'><div>JOB ORDER HISTORY <?php if(isset($_REQUEST['sortby'])){ echo "<b>".$_REQUEST['sortby']."</b>"; }else{} ?> <i><a href='script_sales_jo_pending_list.php' target='_blank'>View Printable</a></i></div>
					 
					 
					 <?php
				
	if(isset($_REQUEST['sdate']) and isset($_REQUEST['edate']))
	  {
		$completed_datetime="0000-00-00 00:00:00";   
		$sdate=$_REQUEST['sdate']." 00:00:00";
		$edate=$_REQUEST['edate']." 23:59:59";
		$dateyeah="where created_datetime>='$sdate' and created_datetime<='$edate' and completed_datetime='$completed_datetime'";
		$dateyeah1="and created_datetime>='$sdate' and created_datetime<='$edate' and completed_datetime='$completed_datetime'";
		$dateyeah2="and a.created_datetime>='$sdate' and a.created_datetime<='$edate' and completed_datetime='$completed_datetime'";
	  } 
else  {   
		$completed_datetime="0000-00-00 00:00:00"; 
		$dateyeah="where completed_datetime='$completed_datetime'"; 
		$dateyeah2="and completed_datetime='$completed_datetime'";
	  }	
			//GOC QUERY START
			if($bch=="goc")
			{	
		        if(isset($_REQUEST['sortby']))
				  {
						  if($_REQUEST['user']=="All")
						  { $userx=""; }
						  else
						  { 
							$user=$_REQUEST['user'];
							$userx="and created_by='$user'";
						  }
							

							$total_pages_sql = "select count(jo_no) as count_jo from sales_jo $dateyeah $userx";
							$result = mysql_query($total_pages_sql);
							//$total_rows = mysql_fetch_array($result)[0];
							$total_pages = ceil($total_rows / $no_of_records_per_page);

						
						  if($_REQUEST['sortby']=="jo")       
						  { $x1="select * from sales_jo $dateyeah $userx order by jo_no desc LIMIT $offset, $no_of_records_per_page"; }
						  
						  if($_REQUEST['sortby']=="client")   
						  { $x1="select * from sales_jo $dateyeah $userx order by client_id asc LIMIT $offset, $no_of_records_per_page"; }
						  
						  if($_REQUEST['sortby']=="total")    
						  { $x1="select * from sales_jo $dateyeah $userx order by jo_amount desc LIMIT $offset, $no_of_records_per_page"; }
						  
						  if($_REQUEST['sortby']=="date")     
						  { $x1="select * from sales_jo $dateyeah $userx order by created_datetime desc LIMIT $offset, $no_of_records_per_page"; }
						  
						  if($_REQUEST['sortby']=="status")   
						  { $x1="select * from sales_jo $dateyeah $userx order by paid desc, completed_datetime desc LIMIT $offset, $no_of_records_per_page"; 	}
						  
						  if($_REQUEST['sortby']=="completed")
						  { $completed_datetime="0000-00-00 00:00:00"; 
							$x1="select * from sales_jo where created_datetime>='$sdate' and created_datetime<='$edate' and completed_datetime!='$completed_datetime' $userx order by completed_datetime desc LIMIT $offset, $no_of_records_per_page"; }
				  }
				  
		    	 else
				  { 
					$total_pages_sql = "select count(jo_no) as count_jo from sales_jo $dateyeah";
					$result = mysql_query($total_pages_sql);
					$total_rows1 = mysql_fetch_assoc($result);
					$total_rows = $total_rows1['count_jo'];
					$total_pages = ceil($total_rows / $no_of_records_per_page);
					$x1="select * from sales_jo $dateyeah order by jo_no desc LIMIT $offset, $no_of_records_per_page";
				  }
			}
			//GOC QUERY END
			
			
			//PER BRANCH ONLY QUERY - START
			else
			{
				if(isset($_REQUEST['sortby']))
				  {
					
					
					if($_REQUEST['user']=="All")
					  { $userx=""; }
				  else{ 
						$user=$_REQUEST['user'];
						$userx="and a.created_by='$user'";
					  }  
					  
						$total_pages_sql = "select count(a.jo_no) as count_jo
											from sales_jo as a
											inner join sales_bookings as b
											on a.b_id=b.b_id
											inner join sales_clients as c
											on a.client_id=c.client_id
											where b.bch='$bch' and c.vip!=1 $dateyeah2 $userx
											order by a.jo_no desc";
						$result = mysql_query($total_pages_sql);
						//$total_rows = mysql_fetch_array($result)[0];
						$total_pages = ceil($total_rows / $no_of_records_per_page);
					  
							  if($_REQUEST['sortby']=="jo")    { $x1="select a.* 
																	  from sales_jo as a
																	  inner join sales_bookings as b
																	  on a.b_id=b.b_id
																	  inner join sales_clients as c
																	  on a.client_id=c.client_id
																	  where b.bch='$bch' and c.vip!=1 $dateyeah2 $userx
																	  order by a.jo_no desc LIMIT $offset, $no_of_records_per_page"; }
																	  
							  if($_REQUEST['sortby']=="client"){ $x1="select a.* 
																	  from sales_jo as a
																	  inner join sales_bookings as b
																	  on a.b_id=b.b_id
																	  inner join sales_clients as c
																	  on a.client_id=c.client_id
																	  where b.bch='$bch' and c.vip!=1 $dateyeah2 $userx
																	  order by a.client_id asc LIMIT $offset, $no_of_records_per_page"; }
																	  
							  if($_REQUEST['sortby']=="total") { $x1="select a.* 
																	  from sales_jo as a
																	  inner join sales_bookings as b
																	  on a.b_id=b.b_id
																	  inner join sales_clients as c
																	  on a.client_id=c.client_id
																	  where b.bch='$bch' and c.vip!=1 $dateyeah2 $userx
																	  order by a.jo_amount desc LIMIT $offset, $no_of_records_per_page"; }
																	  
							  if($_REQUEST['sortby']=="date")  { $x1="select a.* 
																	  from sales_jo as a
																	  inner join sales_bookings as b
																	  on a.b_id=b.b_id
																	  inner join sales_clients as c
																	  on a.client_id=c.client_id
																	  where b.bch='$bch' and c.vip!=1 $dateyeah2 $userx
																	  order by a.created_datetime desc LIMIT $offset, $no_of_records_per_page"; }
																	  
							  if($_REQUEST['sortby']=="status"){ $x1="select a.* 
																	  from sales_jo as a
																	  inner join sales_bookings as b
																	  on a.b_id=b.b_id
																	  inner join sales_clients as c
																	  on a.client_id=c.client_id
																	  where b.bch='$bch' and c.vip!=1 $dateyeah2 $userx
																	  order by a.paid desc, a.completed_datetime desc LIMIT $offset, $no_of_records_per_page"; }
																	  
							  if($_REQUEST['sortby']=="completed"){  $completed_datetime="0000-00-00 00:00:00";
																 $x1="select a.* 
																	  from sales_jo as a
																	  inner join sales_bookings as b
																	  on a.b_id=b.b_id
																	  inner join sales_clients as c
																	  on a.client_id=c.client_id
																	  where b.bch='$bch' 
																	  and c.vip!=1 
																	  and a.created_datetime>='$sdate' 
																	  and a.created_datetime<='$edate' 
																	  and a.completed_datetime!='$completed_datetime' $userx
																	  order by a.completed_datetime desc LIMIT $offset, $no_of_records_per_page"; }										  
				  }
		   
				 else
				  {  
					$total_pages_sql = "select count(a.jo_no) as count_jo
					     from sales_jo as a
						 inner join sales_bookings as b
						 on a.b_id=b.b_id
						 inner join sales_clients as c
						 on a.client_id=c.client_id
						 where b.bch='$bch' and c.vip!=1 $dateyeah2 $userx
						 order by a.jo_no desc";
						$result = mysql_query($total_pages_sql);
						
						$total_rows1 = mysql_fetch_assoc($result);
						$total_rows = $total_rows1['count_jo'];
						
						$total_pages = ceil($total_rows / $no_of_records_per_page);
						
					$x1="select a.* 
					     from sales_jo as a
						 inner join sales_bookings as b
						 on a.b_id=b.b_id
						 inner join sales_clients as c
						 on a.client_id=c.client_id
						 where b.bch='$bch' and c.vip!=1 $dateyeah2 $userx
						 order by a.jo_no desc LIMIT $offset, $no_of_records_per_page"; 
				  }
			}
			//PER BRANCH ONLY QUERY - END 
			  
			  
			$q9=mysql_query($x1) or die(mysql_error());
			$rq=mysql_fetch_assoc($q9); 
			
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
			
			
			echo "<br/><div>Total Records Found: <b class='w3-text-red'>".$total_rows."</b></div>"; 
				if(isset($_REQUEST['sdate']))
				{ $magic="&sdate=".$_REQUEST['sdate']."&edate=".$_REQUEST['edate']."&user=".$_REQUEST['user']."&sortby=".$_REQUEST['sortby']; }
				else{ $magic=""; }
			?>
	
						<!--PAGINATION START-->
							<ul class="pagination w3-tiny">
										<li><a href="<?php echo "admin_sales.php?sales=1&joborders=1".$magic; ?>&pageno=1">FIRST</a></li>
										
										<li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
											<a href="<?php if($pageno <= 1){ echo '#'; } else { echo "admin_sales.php?sales=1&joborders=1".$magic."&pageno=".($pageno - 1); } ?>">PREV</a>
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
											<a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "admin_sales.php?sales=1&joborders=1".$magic."&pageno=".($pageno + 1); } ?>">NEXT</a>
										</li>
										
										<li><a href="<?php echo "admin_sales.php?sales=1&joborders=1".$magic."&pageno=$total_pages"; ?>">LAST</a></li>
							</ul>
						<!--PAGINATION END-->
					 
					 </td>
				  </tr>
				  <tr class='w3-tiny w3-khaki' align='center'>
					 <td>#</td>
					 <td>JO BY</td>
					 <td>JOB ORDER NO.</td>
					 <td>JO ACTUAL</td>
					 <td>BOOKING NO.</td>
					 <td>PO NO</td>
					 <td>CLIENT</td>
					 <td>DR NO</td>
					 <td>TOTAL AMOUNT</td>
					 <td>CREATED DATE</td>
					 <td>COMPLETED DATE</td>
					 <td>STATUS</td>
					 <td>VALIDATION</td>
					 <td>PRODUCTION STATUS</td>
				  </tr>
                
                
<?php					
					do{
						
						$client_id=$rq['client_id'];
						$ssa=mysql_query("select name,vip from sales_clients where client_id=$client_id") or die(mysql_error());
						$rsa=mysql_fetch_assoc($ssa);
						
						echo "<tr align='center' class='w3-hover-pale-red w3-tiny'>
								<td><i class='w3-text-orange'>".$z++."</i></td>
						        <td><i>".$rq['created_by']."</i></td>
								<td><i>".$rq['jo_no']."</i></td>";
							
							
							
									echo "<td>";
												echo "<i class='w3-tiny'>";
												
												if($rq['jo_actual']!="")
												{
													if($rq['salesperson']!=""){
													echo "<span class='w3-text-orange'>".$rq['salesperson']."</span><br/>";
													}else{}
													echo $rq['jo_actual']."<br/>".date('m/d/Y',strtotime($rq['jo_actual_date']));
												}
												else{}
												
												echo "</i>";
									 echo "</td>";

											   
											   
									 echo "<td>";
												echo "<i class='w3-tiny'>";
												
												if($rq['bo_no']!=0)
												{
													if($rq['salesperson']!=""){
													echo "<span class='w3-text-orange'>".$rq['salesperson']."</span><br/>";
													}else{}
													echo $rq['bo_no']."<br/>".date('m/d/Y',strtotime($rq['bo_no_date']));
												}
												else{}
												
												echo "</i>";
									 echo "</td>";
											   
											   
							if($rq['po_no']!=""){ echo "<td><i class='w3-text-indigo'>".$rq['po_no']."</i><br/><i>".date('m/d/Y',strtotime($rq['po_date']))."</i></td>"; }
							                   else { echo "<td></td>"; }
						  
						  echo "<td>";
								switch($rsa['vip'])
									{
										case 0: $ctype="<i class='w3-text-orange'>[Cash]</i>"; break;
										case 1: $ctype="<i class='w3-text-green'>[VIP]</i>"; break;
										case 2: $ctype="<i class='w3-text-blue'>[Government]</i>"; break;
										case 3: $ctype="<i class='w3-text-blue'>[COD]</i>"; break;
										case 4: $ctype="<i class='w3-text-blue'>[X-Deal]</i>"; break;
										case 5: $ctype="<i class='w3-text-blue'>[Account]</i>"; break;
									}	
								echo "$ctype<br/>";
						  echo "<a href='admin_sales.php?client_id=".$rq['client_id']."&client=".$rsa['name']."&sales=1&newjobs=1&create_quotation=1' target='_blank'>".$rsa['name']."</a></td>";
						  
						  
						  echo "<td>";
						  
								  $b_id1=$rq['b_id'];
								  $sx1="select sum(dr_qty*b_amount) as dr_total from sales_bookings_details where b_id='$b_id1'";
								  $qx1=mysql_query($sx1) or die(mysql_error());
								  $rx1=mysql_fetch_assoc($qx1);	
											 
								  echo "<i class='w3-text-blue'>DR Total: ".number_format($rx1['dr_total'],2)."</i><br/>";
								  
								  $xyz_b_id=$rq['b_id'];
								  $xyz=mysql_query("select dr_no,dr_date from sales_bookings_details where b_id='$xyz_b_id' group by dr_no") or die(mysql_error());
								  $xyz1=mysql_fetch_assoc($xyz);
								  do{ 
									   if($xyz1['dr_no']!=0)
										   {
											echo "<i>".$xyz1['dr_no']."</i><br/><i>".date('m/d/Y',strtotime($xyz1['dr_date']))."</i><br/>"; 
										   }
										   else{ }
									
									} while($xyz1=mysql_fetch_assoc($xyz));
						  
						  echo "</td>";
						 	
							
						  if($rq['completed_by']=="")
							{ echo "<td class='w3-text-red'><b>".number_format($rq['jo_amount'],2)."</b></td>"; }
							else
							{ echo "<td class='w3-text-blue'><b>".number_format($rq['jo_amount'],2)."</b></td>"; }	
						  
						  echo "<td align='center'>".date('F d, Y h:i A',strtotime($rq['created_datetime']))."</td>";
						 
						if($rq['completed_by']=="") { echo "<td></td>
						                                   <td>
														        <div class='w3-khaki'>INPROGRESS</div>";
																
											
																//Assign Artist
																$jo_no=$rq['jo_no'];
																$sxx="select * from sales_jo_assign where jo_no=$jo_no";
																$qxx=mysql_query($sxx) or die(mysql_error());
																$rxx=mysql_fetch_assoc($qxx);
																$artist=$rxx['assign_to'];											
																
										  if($rq['paid']==1){ echo "<div class='w3-green'>PAID</div><div><b class='text-primary'>$artist</b></div>"; }
													   else { 
																
																//balance and partial separation start
																echo "<div class='w3-red w3-tiny'>BALANCE</div>
																	  <div class='w3-tiny'>".number_format($rq['jo_amount']-$rq['jo_payment_amount'],2)."</div>";
																
																if(($rq['jo_payment_amount']>0) and ($rq['jo_payment_amount']<$rq['jo_amount']))
																	{
																echo "<div class='w3-blue w3-tiny'>PARTIAL</div>
																	  <div class='w3-tiny'>".number_format($rq['jo_payment_amount'],2)."</div>
																	  ";
																	}else{}
																
																echo "<b class='text-primary'>$artist</b>"; 
																//balance and partial separation end
															
															
															}
																
						                             echo "</td>"; 
												    }
													
						                       else { echo "<td align='center' class='w3-text-blue'>".date('F d, Y h:i A',strtotime($rq['completed_datetime']))."</td>
												            <td align='center'><div class='w3-blue'>COMPLETED</div></td>"; } 
															
															
												echo "<td><i>";
													switch ($rq['validation'])
													{
														case 0: echo "<span class='w3-text-red'>NO VALIDATION</span>"; break;
														case 1: echo "<span class='w3-text-blue'>PRINTED</span>"; break;
														case 2: echo "<span class='w3-text-red'>RE-PRINTED</span>"; break;
													}
												echo "</i></td>";
															
															
										
										echo "<td>";
										 
														  if($rq['production_status']!=9)
															{ ?>
											
																	<?php if($rq['production_status']==1)
																			{ 
																				echo "<div class='w3-lime'>(READY)<br/>IN FG</div>";
																				echo "<i><span>".date('m/d/Y h:i A',strtotime($rq['production_date']))."</span></i>";
																			}
																		  elseif($rq['production_status']==8)
																			{ 
																			    if($rq['jo_amount'] > $rx1['dr_total'])
																				{ 
																					if($rx1['dr_total']!=0)
																					{ echo "<div class='w3-blue'>PARTIAL</div>"; }
																					else{}
																				}
																				if($rq['jo_amount'] < $rx1['dr_total'])
																				{ echo "<div class='w3-purple'>OVER IN DR</div>"; }
																				else{}	
																				
																				echo "<div class='w3-pink'>RELEASED FROM FG</div>";
																				
																				if($rq['production_date']!="0000-00-00 00:00:00")
																				{ echo "<i><span>".date('m/d/Y h:i A',strtotime($rq['production_date']))."</span></i>"; }
																				else{ echo "<i><span class='w3-tiny'>system_tool</span></i>"; }
																			}
																		  elseif($rq['production_status']!=0 and $rq['production_status']!=1 and $rq['production_status']!=8 and $rq['production_status']!=9)
																		    {
																				echo "<div class='w3-pink'>ROUTING IN PROCESS</div>";
																		    }
																			else
																			{ echo "<div class='w3-khaki'>INPROGRESS</div>"; } ?>
											<?php        	
															}
															
															else
															{
																echo "<div class='w3-green'>DELIVERED</div>"; 
															}

										echo "</td>";
				       echo "<tr>";
						
						
						
					//Production Status LEGEND
					// * 0 = No Action
					// * 1 = Ready For PuckUp / Delivery
					// * 8 = Released From FG
					// * 9 = Delivered
						
					
					//JO COMPLETE SETTER START
					$username=$_SESSION['username'];
					$jo_no=$rq['jo_no'];
					$b_id=$rq['b_id'];
					$sx1="select sum(dr_qty*b_amount) as dr_total from sales_bookings_details where b_id='$b_id'";
					$qx1=mysql_query($sx1) or die(mysql_error());
					$rx1=mysql_fetch_assoc($qx1);
				
					if($rq['paid']==1 and $rq['completed_by']=="" and $rq['production_status']>=8 and ($rq['jo_actual']!="" or $rq['bo_no']!=0))
				    { 
						if(round($rx1['dr_total'])==round($rq['jo_amount']))
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

					

				 } while($rq=mysql_fetch_assoc($q9));	
				?>
		       </table>
	
	<?php   }	   
        } // Job Orders End ---> 
?>