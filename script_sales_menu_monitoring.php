<?php // Monitoring Start --->
	  if($access['d23']==1)
	    { 
	      if(isset($_REQUEST['monitoring'])) 
	        { ?>
		      
			  <form method='get' class='w3-tiny'>
								<input name='sales' type='hidden' value='1'>
								<input name='branch' type='hidden' value='ALL'>
								<input name='monitoring' type='hidden' value='1'>
					
				<div class='container'>
					
					<table class='table'>
						<tr>
								<?php 
								if(isset($_REQUEST['sdate']))
								  {	
									echo "<td>START DATE &nbsp; <input required name='sdate' type='date' value='".$_REQUEST['sdate']."'></td>";
									echo "<td>END DATE &nbsp; <input required name='edate' type='date' value='".$_REQUEST['edate']."'></td>";
							      }
							  else{
							        echo "<td>START DATE &nbsp; <input required name='sdate' type='date'></td>";
									echo "<td>END DATE &nbsp; <input required name='edate' type='date'></td>";
								  }
								?>
					
						</tr>
						<tr>	
							<td colspan='2'>
								<input class='btn btn-info w3-tiny' name='booking_code_ranking_monitor' type='submit' value='CODE RANK'>
								<input class='btn btn-info w3-tiny' name='trans_rank' type='submit' value='ENGAGEMENT RANK'>	
								<input class='btn btn-info w3-tiny' name='client_rank' type='submit' value='CLIENT RANK'>									
								<input class='btn btn-danger w3-tiny' name='sales_monitor' type='submit' value='SALES MONITOR'>
								<input class='btn btn-danger w3-tiny' name='paid_jo' type='submit' value='PAID JO'>
								<input class='btn btn-danger w3-tiny' name='for_collections' type='submit' value='UNPAID OR W/ BALANCE'>
								<input class='btn btn-success w3-tiny' name='actual_sale' type='submit' value='PAYMENT REMITTANCE (DR)'>
								<a class='btn btn-warning w3-tiny' href='script_sales_monitoring_list.php?sdate=<?php echo date('Y-m-d'); ?>&edate=<?php echo date('Y-m-d'); ?>' target='_blank'>OTHER REPORTS / JO STATUS REPORTS</a>
								<a class='btn btn-primary w3-tiny' href='page_series_setter.php' target='_blank'>DR SERIES</a>
								<a class='btn btn-primary w3-tiny' href='script_jo_series.php' target='_blank'>JO SERIES</a>
								<a class='btn btn-primary w3-tiny' href='script_sales_jo_pending_list.php' target='_blank'>PENDING PRODUCTION</a>
							</td>
						</tr>
					</table>	
				</div>
			  </form>
			   
 
 
 
			<?php
			if(isset($_REQUEST['booking_code_ranking_monitor']))
			  {
		      //Booking Code Ranking monitoring Start ---	
			  $sdate=$_REQUEST['sdate'];
			  $edate=$_REQUEST['edate'];
			  
			  if($_REQUEST['branch']=="ALL")
			    {
					$s="SELECT code_set,count(*) AS code_top,
					           SUM(b_qty*b_amount) AS b_amount1
						FROM sales_bookings_details 
						WHERE status=1 
						AND b_date>='$sdate' 
						AND b_date<='$edate' 
						GROUP BY code_set 
						ORDER BY code_top DESC,b_amount1 DESC";
			    }
			 else
			    {
					$dept=$_REQUEST['branch'];
					$s="SELECT code_set,count(*) AS code_top,
							   SUM(b_qty*b_amount) AS b_amount1 
					    FROM sales_bookings_details
						JOIN users ON sales_bookings_details.created_by=users.username 
						WHERE users.department='$dept' 
						AND status=1 
						AND b_date>='$sdate' 
						AND b_date<='$edate' 
						GROUP BY code_set 
						ORDER BY code_top DESC,b_amount1 DESC";
			    }
			  $q=mysql_query($s) or die(mysql_error());
			  $r=mysql_fetch_assoc($q);
			  
			  echo "<table class='table'>
			         <tr align='center' class='w3-dark-gray w3-small'>
					   <td colspan='4'>BOOKING CODE RANKING | ".date('D F d, Y',strtotime($_REQUEST['sdate']))." - ".date('D F d, Y',strtotime($_REQUEST['edate']))."</td>
					 </tr>";
					 
			   echo "<tr>
				        <td align='right' colspan='4'>
				 		    <form method='get'>
							  <input name='sales' type='hidden' value='1'>
							  <input name='monitoring' type='hidden' value='1'>
							  <input name='booking_code_ranking_monitor' type='hidden' value='1'>
							  
							  <input name='sdate' type='hidden' value='".$_REQUEST['sdate']."'>
							  <input name='edate' type='hidden' value='".$_REQUEST['edate']."'>
							  <select name='branch'>";
							        echo "<option>ALL</option>";
								 $sa="select users.department as dept,count(department) from users inner join sales_jo on sales_jo.created_by=users.username group by users.department";
								 $qa=mysql_query($sa);
								 $ra=mysql_fetch_assoc($qa);
								 do{
									echo "<option>".$ra['dept']."</option>"; 
								 }while($ra=mysql_fetch_assoc($qa));
						echo "</select>
							  <input class='btn btn-success w3-tiny' type='submit' value='FILTER'>
						    </form>
						</td>
			        </tr>";
					 
			   echo "<tr class='w3-grey w3-tiny w3-text-white'>
						<td>RANK</td>
						<td>SALES CODES</td>
						<td>CODE COUNT</td>
						<td>AMOUNT</td>
					 </tr>";
			  $x=1;
			  $branch=$_REQUEST['branch'];
			  do{
				  $code_set=$r['code_set'];
				  $q5=mysql_query("select code_name,code_desc from sales_codes where code_set='$code_set'") or die(mysql_error());
				  $r5=mysql_fetch_assoc($q5);
				  echo "<tr class='w3-hover-pale-red'>
							<td>".$x++."</td>
							<td><a href='script_sales_monitoring.php?&branch=$branch&sdate=$sdate&edate=$edate&booking_code_ranking_monitor=1&code_set=$code_set&total=".$r['b_amount1']."' target='_blank'>".$r['code_set']." - <span class='w3-small'>".$r5['code_name']." - ".$r5['code_desc']."</span></a></td>
							<td>".$r['code_top']."</td>
							<td><b class='w3-text-red'>".number_format($r['b_amount1'],2)."</b></td>";
				  echo "</tr>";
								//echo "<div class='progress'>";
								//echo "<div class='progress-bar progress-bar-striped active' role='progressbar' style='width:".$r['code_top']."%'>".$r['code_top']."</div>";
					            //echo "</div>";
				
			    } while($r=mysql_fetch_assoc($q));  
			  //Booking Code Ranking Monitoring End ---
			  }
			?>

			
	
	
	
	
	
	
	
			<?php
			if(isset($_REQUEST['trans_rank']))
			  {
		      //Engagement Thru trans Rank Start ---	
			  $sdate=$_REQUEST['sdate']." 00:00:00";
			  $edate=$_REQUEST['edate']." 23:59:59";
			  
			  if($_REQUEST['branch']=="ALL")
			    {
				  $s="select trans_type,count(*) as trans_type_top from sales_jo where created_datetime>='$sdate' and created_datetime<='$edate' group by trans_type order by trans_type_top desc";
			    }
			else
				{
				  $dept=$_REQUEST['branch'];
				  $s="SELECT trans_type,count(*) AS trans_type_top 
				      FROM sales_jo 
					  JOIN users ON sales_jo.created_by=users.username
					  WHERE users.department='$dept' AND created_datetime>='$sdate' AND created_datetime<='$edate' 
					  GROUP BY trans_type 
					  ORDER BY trans_type_top DESC";
				}
				
			    $q=mysql_query($s) or die(mysql_error());
			    $r=mysql_fetch_assoc($q);
			  
			  echo "<table class='table'>
			         <tr align='center' class='w3-dark-gray w3-small'>
					   <td colspan='3'>CUSTOMER ENGAGEMENT RANKING BASED ON JOB ORDER | ".date('D F d, Y',strtotime($_REQUEST['sdate']))." - ".date('D F d, Y',strtotime($_REQUEST['edate']))."</td>
					 </tr>";
					 
					 
			   echo "<tr>
				        <td align='right' colspan='3'>
				 		    <form method='get'>
							  <input name='sales' type='hidden' value='1'>
							  <input name='monitoring' type='hidden' value='1'>
							  <input name='trans_rank' type='hidden' value='1'>
							  
							  <input name='sdate' type='hidden' value='".$_REQUEST['sdate']."'>
							  <input name='edate' type='hidden' value='".$_REQUEST['edate']."'>
							  <select name='branch'>";
							        echo "<option>ALL</option>";
								 $sa="select users.department as dept,count(department) from users inner join sales_jo on sales_jo.created_by=users.username group by users.department";
								 $qa=mysql_query($sa);
								 $ra=mysql_fetch_assoc($qa);
								 do{
									echo "<option>".$ra['dept']."</option>"; 
								 }while($ra=mysql_fetch_assoc($qa));
						echo "</select>
							  <input class='btn btn-success w3-tiny' type='submit' value='FILTER'>
						    </form>
						</td>
			         </tr>";
					 
					 
				echo "<tr class='w3-grey w3-tiny w3-text-white'>
						<td>RANK</td>
						<td>THRU</td>
						<td>COUNT</td>
					 </tr>";
			  $x=1;
			  $branch=$_REQUEST['branch'];
			  do{
				  $trans_no=$r['trans_type'];
				  $q5=mysql_query("select * from sales_transaction_type where trans_no='$trans_no'") or die(mysql_error());
				  $r5=mysql_fetch_assoc($q5);
				  echo "<tr class='w3-hover-pale-red'>
							<td>".$x++."</td>
							<td><span class='w3-small'><a href='script_sales_monitoring.php?&branch=$branch&sdate=$sdate&edate=$edate&trans_no=$trans_no' target='_blank'>".$r5['trans_desc']."</a></span></td>
							<td>".$r['trans_type_top']."</td>";
				  echo "</tr>";
								//echo "<div class='progress'>";
								//echo "<div class='progress-bar progress-bar-striped active' role='progressbar' style='width:".$r['code_top']."%'>".$r['code_top']."</div>";
					            //echo "</div>";
				
			    } while($r=mysql_fetch_assoc($q));  
			  //Engagement Thru trans Rank Start ---	
			  }
			?>	  	

			
			
			
			
			<?php
			if(isset($_REQUEST['client_rank']))
			  {
		      //Client Rank Start ---	
			  $sdate=$_REQUEST['sdate'];
			  $edate=$_REQUEST['edate'];
			  
				$s="SELECT SUM(a.dr_qty*a.b_amount) AS dr_total, c.name, b.client_id
				FROM sales_bookings_details a
				INNER JOIN sales_jo b ON a.b_id=b.b_id
				LEFT JOIN sales_clients c ON b.client_id=c.client_id
				WHERE a.dr_date>='$sdate' AND a.dr_date<='$edate' AND a.dr_qty!=0
				GROUP BY b.client_id
				ORDER BY dr_total DESC";
				
			    $q=mysql_query($s) or die(mysql_error());
			    $r=mysql_fetch_assoc($q);
			  
			  echo "<table class='table'>
			         <tr align='center' class='w3-dark-gray w3-small'>
					   <td colspan='3'>
						CLIENT RANKING BASED ON DELIVERY | ".date('D F d, Y',strtotime($_REQUEST['sdate']))." - ".date('D F d, Y',strtotime($_REQUEST['edate']))."
						<a href='script_sales_client_general_report.php?sdate=".$_REQUEST['sdate']."&edate=".$_REQUEST['edate']."' target='_blank'><i>(VIEW GRAND REPORT)</i></a>
					   </td>
					 </tr>";
					 
				echo "<tr class='w3-grey w3-tiny w3-text-white'>
						<td>RANK</td>
						<td>CLIENT</td>
						<td>DR AMOUNT</td>
					 </tr>";
			  $x=1;
			  do{
				  echo "<tr class='w3-hover-pale-red'>
							<td>".$x++."</td>
							<td><span class='w3-small'><a href='script_sales_monitoring.php?&branch=$branch&sdate=$sdate&edate=$edate&client_id=".$r['client_id']."&dr_total=".$r['dr_total']."' target='_blank'>".$r['name']."</a></span></td>
							<td>".number_format($r['dr_total'],2)."</td>";
				  echo "</tr>";	
			    } while($r=mysql_fetch_assoc($q));  
			  //Client Rank Start ---	
			  }
			?>	  	
			
			
			
			
			<?php
			if(isset($_REQUEST['sales_monitor']))
			  {
		      //Sales monitoring Start ---	
			  $sdate=$_REQUEST['sdate']." 00:00:00";
			  $edate=$_REQUEST['edate']." 23:59:59";
			  
				  if($_REQUEST['branch']=="ALL")
				  { $s="select * from sales_jo where created_datetime>='$sdate' and created_datetime<='$edate' order by created_datetime desc";
					$s1="select sum(jo_amount) as joamount from sales_jo where created_datetime>='$sdate' and created_datetime<='$edate'";
					$s2="select sum(jo_amount) as joamount_notpaid from sales_jo where created_datetime>='$sdate' and created_datetime<='$edate' and paid=0";
					$s3="select sum(jo_amount) as joamount_paid from sales_jo where created_datetime>='$sdate' and created_datetime<='$edate' and paid=1";
					
				  }
			  elseif($_REQUEST['salesperson'])
				  {
					$salesperson=$_REQUEST['salesperson'];
					$s="select * from sales_jo where created_by='$salesperson' and created_datetime>='$sdate' and created_datetime<='$edate' order by created_datetime desc";
					$s1="select sum(jo_amount) as joamount from sales_jo where created_by='$salesperson' and created_datetime>='$sdate' and created_datetime<='$edate'";
					$s2="select sum(jo_amount) as joamount_notpaid from sales_jo where created_by='$salesperson' and created_datetime>='$sdate' and created_datetime<='$edate' and paid=0";
					$s3="select sum(jo_amount) as joamount_paid from sales_jo where created_by='$salesperson' and created_datetime>='$sdate' and created_datetime<='$edate' and paid=1";
				  }
				  else
				  {
					$dept=$_REQUEST['branch'];
					$s="select sales_jo.* from sales_jo inner join users on users.username=sales_jo.created_by where users.department='$dept' and created_datetime>='$sdate' and created_datetime<='$edate' order by created_datetime desc";
					$s1="select sum(jo_amount) as joamount from sales_jo inner join users on users.username=sales_jo.created_by where users.department='$dept' and created_datetime>='$sdate' and created_datetime<='$edate'";
					$s2="select sum(jo_amount) as joamount_notpaid from sales_jo inner join users on users.username=sales_jo.created_by where users.department='$dept' and created_datetime>='$sdate' and created_datetime<='$edate' and paid=0";
					$s3="select sum(jo_amount) as joamount_paid from sales_jo inner join users on users.username=sales_jo.created_by where users.department='$dept' and created_datetime>='$sdate' and created_datetime<='$edate' and paid=1";
				  }
			  
			  $q=mysql_query($s) or die(mysql_error());
			  $r=mysql_fetch_assoc($q);
			  $count=mysql_num_rows($q);
			  
			  //for total sales only
			  $q1=mysql_query($s1) or die(mysql_error());
			  $r1=mysql_fetch_assoc($q1);
			  
			  $q2=mysql_query($s2) or die(mysql_error());
			  $r2=mysql_fetch_assoc($q2);
			  
			  $q3=mysql_query($s3) or die(mysql_error());
			  $r3=mysql_fetch_assoc($q3);
			  
			  echo "<table class='table'>
			         
					 <tr align='center' class='w3-dark-gray w3-small'>
					   <td colspan='8'>TOTAL SALES PER DATE RANGE ONLY | ".date('D F d, Y',strtotime($_REQUEST['sdate']))." - ".date('D F d, Y',strtotime($_REQUEST['edate']))."</td>
					 </tr>";
				echo "<tr>
				
						<td colspan='2' class='w3-large w3-text-red'>UNPAID OR W/ BALANCE</td>
						<td class='w3-text-red'><b class='w3-large'>".number_format($r2['joamount_notpaid'],2)."</b></td>";
				  echo "<td align='right' colspan='5'>
				 		    <form method='get'>
							  <input name='sales' type='hidden' value='1'>
							  <input name='monitoring' type='hidden' value='1'>
							  <input name='sales_monitor' type='hidden' value='1'>
							  
							  <input name='sdate' type='hidden' value='".$_REQUEST['sdate']."'>
							  <input name='edate' type='hidden' value='".$_REQUEST['edate']."'>
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
							  <input class='btn btn-success w3-tiny' type='submit' value='FILTER PER DEPARTMENT'>
						    </form>
						</td>";	
				echo "</tr>";	   
					   
				echo "<tr>
						<td colspan='2' class='w3-large w3-text-green''>POSTED PAYMENTS</td>
						<td class='w3-text-green'><b class='w3-large'>".number_format($r3['joamount_paid'],2)."</b></td>";
				  echo "<td align='right' colspan='5'>
				 		    <form method='get'>
							  <input name='sales' type='hidden' value='1'>
							  <input name='monitoring' type='hidden' value='1'>
							  <input name='sales_monitor' type='hidden' value='1'>
							  
							  <input name='sdate' type='hidden' value='".$_REQUEST['sdate']."'>
							  <input name='edate' type='hidden' value='".$_REQUEST['edate']."'>
							  <select name='salesperson'>";
							        echo "<option></option>";
									
								   $sv="select username,last_name,first_name from users where department like '%SALES%' order by last_name asc";
								   $qv=mysql_query($sv) or die(mysql_error());
								   $rv=mysql_fetch_assoc($qv);
								   do{ echo "<option value='".$rv['username']."'>".$rv['last_name'].", ".$rv['first_name']."</option>"; } while ($rv=mysql_fetch_assoc($qv));
					
					    echo "</select>
							  <input class='btn btn-primary w3-tiny' type='submit' value='FILTER PER SALES PERSON'>
						    </form>
						</td>";	
				echo "</tr>";	   
					
				echo "<tr class='w3-text-indigo'>
						<td colspan='2' class='w3-large'><i class='w3-small'>($count Records)</i> OVERALL TOTAL</p></td>
						<td><b class='w3-large'>".number_format($r1['joamount'],2)."</b></td>
					  </tr>";
					 
				  echo "<tr class='w3-grey w3-tiny w3-text-white' align='center'>
						<td>JO BY</td>
						<td>JO NO.</td>
						<td>BOOKING</td>
						<td>THRU</td>
						<td>CLIENT</td>
						<td>JO DATE</td>
						<td>JO DONE</td>
						<td>PAY STATUS</td>
						<td>AMOUNT</td>
					 </tr>";
					 
					 do{
						//thru
						$trans_no=$r['trans_type'];
						$qa=mysql_query("select trans_desc from sales_transaction_type where trans_no=$trans_no") or die(mysql_error());
						$ra=mysql_fetch_assoc($qa);
						
						//client
						$client_id=$r['client_id'];
						$qb=mysql_query("select name from sales_clients where client_id=$client_id") or die(mysql_error());
						$rb=mysql_fetch_assoc($qb);
						
						//pay status
						if($r['paid']==1){ $pay="<b class='w3-text-green'>PAID</b>"; }
						
						else{   $jo_no=$r['jo_no'];
								$sx1="select sum(payment) as balance from sales_jo_payments where jo_no=$jo_no";
								$qx1=mysql_query($sx1) or die(mysql_error());
								$rx1=mysql_fetch_assoc($qx1);
								$balance=number_format($r['jo_amount']-$rx1['balance'],2);
						        $pay="<b class='w3-text-red'>BALANCE</b><br>$balance"; 
							}
						
						
					  echo "<tr class='w3-hover-pale-red' align='center'>
								<td class='w3-tiny'>".$r['created_by']."</td>
								<td>".$r['jo_no']."</td>
								<td>".$r['bo_no']."</td>
								<td class='w3-tiny'>".$ra['trans_desc']."</td>
								<td><a href='admin_sales.php?client_id=".$r['client_id']."&client=".$rb['name']."&sales=1&newjobs=1&create_quotation=1' target='_blank'>".$rb['name']."</a></td>
								<td class='w3-tiny'>".date('F d, Y h:i A',strtotime($r['created_datetime']))."</td>
								<td class='w3-tiny'>";
									if($r['completed_datetime']!="0000-00-00 00:00:00")
									  { echo "<span class='w3-text-blue'>".date('F d, Y h:i A',strtotime($r['completed_datetime']))."</span>"; }
						  echo "</td>
						        <td class='w3-tiny'>";
								if($r['completed_datetime']!="0000-00-00 00:00:00")
								{	
									echo "<b class='w3-text-blue'>COMPLETED</b>";
								}
								else
								{ echo "$pay"; }
						  
						  echo "</td>
						        <td class='w3-text-red'><b>".number_format($r['jo_amount'],2)."</b></td>
							</tr>";
					   }while($r=mysql_fetch_assoc($q));
					  
			 echo "</table>";
			    //Sales Monitoring End ---
			   }
			?>  

			
			
			
			
	<?php //PAID JO---
      if(isset($_REQUEST['paid_jo']))
		{
		 
			  $sdate=$_REQUEST['sdate']." 00:00:00";
			  $edate=$_REQUEST['edate']." 23:59:59";
			  
			  if(isset($_REQUEST['paid_lang'])){ $paid_lang=" and completed_by=''"; }else{ $paid_lang=""; }
			  if(isset($_REQUEST['completed_lang'])){ $completed_lang=" and completed_by!=''"; }else{ $completed_lang=""; }
			  
			  if($_REQUEST['branch']=="ALL")
			  {
				$s="SELECT * 
				    FROM sales_jo 
					WHERE created_datetime>='$sdate' AND created_datetime<='$edate' AND paid=1 $paid_lang $completed_lang
					ORDER BY created_datetime DESC";
					
				$s2="SELECT SUM(jo_amount) AS payment
				     FROM sales_jo
					 WHERE created_datetime>='$sdate' AND created_datetime<='$edate' AND paid=1 $paid_lang $completed_lang";
			  }
			  
			  else
			  {
			    $dept=$_REQUEST['branch'];
			    $s="SELECT sales_jo.* 
				    FROM sales_jo 
					INNER JOIN users ON users.username=sales_jo.created_by 
					WHERE users.department='$dept' AND created_datetime>='$sdate' AND created_datetime<='$edate' AND paid=1 $paid_lang $completed_lang
					ORDER BY created_datetime desc";
					
			    $s2="SELECT SUM(jo_amount) AS payment 
					 FROM sales_jo 
					 INNER JOIN users ON users.username=sales_jo.created_by 
					 WHERE users.department='$dept' AND created_datetime>='$sdate' AND created_datetime<='$edate' AND paid=1 $paid_lang $completed_lang";
			  }
			  
			  $q=mysql_query($s) or die(mysql_error());
			  $r=mysql_fetch_assoc($q);
			  $count=mysql_num_rows($q);
			  
			  //for total sales only
			  $q2=mysql_query($s2) or die(mysql_error());
			  $r2=mysql_fetch_assoc($q2);
			  
			  echo "<table class='table'>
			         
					 <tr align='center' class='w3-dark-gray w3-small'>
					   <td colspan='8'><b class='w3-text-sand'>(".$_REQUEST['branch'].")</b> PAID JO PER DATE RANGE | ".date('D F d, Y',strtotime($_REQUEST['sdate']))." - ".date('D F d, Y',strtotime($_REQUEST['edate']))."</td>
					 </tr>";
					   
				echo "<tr>
						<td class='w3-text-green' colspan='2' class='w3-large'><i class='w3-small'>($count Records)</i> PAID / COMPLETED J.O.</td>
						<td class='w3-text-green'><b class='w3-large'>".number_format($r2['payment'],2)."</b></td>";
						
					 echo "<td align='right' colspan='5'>
				 		    <form method='get'>
							  <input name='sales' type='hidden' value='1'>
							  <input name='monitoring' type='hidden' value='1'>
							  <input name='paid_jo' type='hidden' value='1'>
							  
							  <input name='sdate' type='hidden' value='".$_REQUEST['sdate']."'>
							  <input name='edate' type='hidden' value='".$_REQUEST['edate']."'>
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
							  <input name='filter' class='btn btn-warning w3-tiny' type='submit' value='FILTER'>
							  <input name='paid_lang' class='btn btn-success w3-tiny' type='submit' value='PAID'>
							  <input name='completed_lang' class='btn btn-info w3-tiny' type='submit' value='COMPLETED'>
						    </form>
						</td>";	
						
				echo "</tr>";	   
					 
				echo "<tr class='w3-grey w3-tiny w3-text-white' align='center'>
						<td>JO BY</td>
						<td>JO NO.</td>
						<td>BOOKING</td>
						<td>THRU</td>
						<td>CLIENT</td>
						<td>JO DATE</td>
						<td>JO DONE</td>
						<td>PAY STATUS</td>
						<td>AMOUNT</td>
					 </tr>";
					 
					 do{
						//thru
						$trans_no=$r['trans_type'];
						$qa=mysql_query("select trans_desc from sales_transaction_type where trans_no=$trans_no") or die(mysql_error());
						$ra=mysql_fetch_assoc($qa);
						
						//client
						$client_id=$r['client_id'];
						$qb=mysql_query("select name from sales_clients where client_id=$client_id") or die(mysql_error());
						$rb=mysql_fetch_assoc($qb);
						
						$jo_no=$r['jo_no'];
						$sx1="select sum(payment) as balance from sales_jo_payments where jo_no=$jo_no";
						$qx1=mysql_query($sx1) or die(mysql_error());
						$rx1=mysql_fetch_assoc($qx1);
						$balance=number_format($r['jo_amount']-$rx1['balance'],2);
						$pay="<b class='w3-text-green'>PAID</b>"; 
						$completed="<b class='w3-text-blue'>COMPLETED</b>"; 
						
					  echo "<tr class='w3-hover-pale-red' align='center'>
								<td class='w3-tiny'>".$r['created_by']."</td>
								<td>".$r['jo_no']."</td>
								<td>".$r['bo_no']."</td>
								<td class='w3-tiny'>".$ra['trans_desc']."</td>
								<td><a href='admin_sales.php?client_id=".$r['client_id']."&client=".$rb['name']."&sales=1&newjobs=1&create_quotation=1' target='_blank'>".$rb['name']."</a></td>
								<td class='w3-tiny'>".date('F d, Y h:i A',strtotime($r['created_datetime']))."</td>
								<td>";
								if($r['completed_datetime']!="0000-00-00 00:00:00")
								  { echo "<span class='w3-tiny w3-text-blue'>".date('F d, Y h:i A',strtotime($r['completed_datetime']))."</span>"; }
						  echo "</td>
						     	<td class='w3-tiny'>";
							
								if($r['completed_datetime']!="0000-00-00 00:00:00")	
								{ echo "$completed"; }
								else
								{ echo "$pay"; }
						  echo "</td>
						        <td><b class='w3-text-red'>".number_format($r['jo_amount'],2)."</b></td>
							</tr>";
					   }while($r=mysql_fetch_assoc($q));
					  
			 echo "</table>";
		}
            //PAID JO----
			?>	
			
			
			
			

		<?php //For Collections---
			if(isset($_REQUEST['for_collections']))
			  {
		 
			  $sdate=$_REQUEST['sdate']." 00:00:00";
			  $edate=$_REQUEST['edate']." 23:59:59";
			  
				  if($_REQUEST['branch']=="ALL")
				  {
					$s="select * from sales_jo where created_datetime>='$sdate' and created_datetime<='$edate' and paid=0 order by created_datetime desc";
					$s1="select sum(jo_amount) as joamount from sales_jo where created_datetime>='$sdate' and created_datetime<='$edate' and paid=0";
				  }
				  else
				  {
					$dept=$_REQUEST['branch'];
					$s="select sales_jo.* from sales_jo inner join users on users.username=sales_jo.created_by where users.department='$dept' and created_datetime>='$sdate' and created_datetime<='$edate' and paid=0 order by created_datetime desc";
					$s1="select sum(jo_amount) as joamount from sales_jo inner join users on users.username=sales_jo.created_by where users.department='$dept' and created_datetime>='$sdate' and created_datetime<='$edate' and paid=0";
				  }
			  
			  $q=mysql_query($s) or die(mysql_error());
			  $r=mysql_fetch_assoc($q);
			  $count=mysql_num_rows($q);
			  
			  //for total sales only
			  $q1=mysql_query($s1) or die(mysql_error());
			  $r1=mysql_fetch_assoc($q1);
			   
			  echo "<table class='table'>
			         
					 <tr align='center' class='w3-dark-gray w3-small'>
					   <td colspan='8'>UNPAID OR W/ BALANCE PER DATE RANGE | ".date('D F d, Y',strtotime($_REQUEST['sdate']))." - ".date('D F d, Y',strtotime($_REQUEST['edate']))."</td>
					 </tr>";
					 
					
					   
				echo "<tr>
						<td class='w3-text-red' colspan='2' class='w3-large'><i class='w3-small'>($count Records)</i> J.O. with UNPAID OR W/ BALANCE</td>
						<td class='w3-text-red'><b class='w3-large'>".number_format($r1['joamount'],2)."</b></td>";
						
					 echo "<td align='right' colspan='5'>
				 		    <form method='get'>
							  <input name='sales' type='hidden' value='1'>
							  <input name='monitoring' type='hidden' value='1'>
							  <input name='for_collections' type='hidden' value='1'>
							  
							  <input name='sdate' type='hidden' value='".$_REQUEST['sdate']."'>
							  <input name='edate' type='hidden' value='".$_REQUEST['edate']."'>
							  <select name='branch'>";
							        echo "<option>ALL</option>";
								 $sa="select users.department as dept,count(department) from users inner join sales_jo on sales_jo.created_by=users.username group by users.department";
								 $qa=mysql_query($sa);
								 $ra=mysql_fetch_assoc($qa);
								 do{
									echo "<option>".$ra['dept']."</option>"; 
								 }while($ra=mysql_fetch_assoc($qa));
						echo "</select>
							  <input class='btn btn-success w3-tiny' type='submit' value='FILTER'>
						    </form>
						</td>";	
						
				echo "</tr>";	   
					 
				echo "<tr class='w3-grey w3-tiny w3-text-white' align='center'>
						<td>JO BY</td>
						<td>JO NO.</td>
						<td>BOOKING</td>
						<td>THRU</td>
						<td>CLIENT</td>
						<td>JO DATE</td>
						<td>JO DONE</td>
						<td>PAY STATUS</td>
						<td>AMOUNT</td>
					 </tr>";
					 
					 do{
						//thru
						$trans_no=$r['trans_type'];
						$qa=mysql_query("select trans_desc from sales_transaction_type where trans_no=$trans_no") or die(mysql_error());
						$ra=mysql_fetch_assoc($qa);
						
						//client
						$client_id=$r['client_id'];
						$qb=mysql_query("select name from sales_clients where client_id=$client_id") or die(mysql_error());
						$rb=mysql_fetch_assoc($qb);
						
						$jo_no=$r['jo_no'];
						$sx1="select sum(payment) as balance from sales_jo_payments where jo_no=$jo_no";
						$qx1=mysql_query($sx1) or die(mysql_error());
						$rx1=mysql_fetch_assoc($qx1);
						$balance=number_format($r['jo_amount']-$rx1['balance'],2);
						$pay="<b class='w3-text-red'>BALANCE</b>"; 
						
					  echo "<tr class='w3-hover-pale-red' align='center'>
								<td class='w3-tiny'>".$r['created_by']."</td>
								<td>".$r['jo_no']."</td>
								<td>".$r['bo_no']."</td>
								<td class='w3-tiny'>".$ra['trans_desc']."</td>
								<td><a href='admin_sales.php?client_id=".$r['client_id']."&client=".$rb['name']."&sales=1&newjobs=1&create_quotation=1' target='_blank'>".$rb['name']."</a></td>
								<td class='w3-tiny'>".date('F d, Y h:i A',strtotime($r['created_datetime']))."</td>
								<td>";
								if($r['completed_datetime']!="0000-00-00 00:00:00"){ echo date('F d, Y h:i A',strtotime($r['completed_datetime'])); }
						  echo "</td>
						        <td class='w3-tiny'>$pay<br>$balance</td>
						        <td><b class='w3-text-red'>".number_format($r['jo_amount'],2)."</b></td>
							</tr>";
					   }while($r=mysql_fetch_assoc($q));
					  
			 echo "</table>";
			   }
            //For Collections ----
			?>	
	
	
	
	
	
	
	
		<?php
			if(isset($_REQUEST['actual_sale']))
			  {
		      //Actual DR Sales Start ---
			  $sdate=$_REQUEST['sdate']." 00:00:00";
			  $edate=$_REQUEST['edate']." 23:59:59";
			  
			  $sdate1=$_REQUEST['sdate'];
			  $edate1=$_REQUEST['edate'];
			   
			  //SHOW ONLY PAID DR (CASH DR)
			  $s11="select sum(a.dr_qty*a.b_amount) as total1 
				   from sales_bookings_details as a
			       inner join sales_jo as b
			       on a.b_id=b.b_id
			       where b.paid=1 and a.dr_posted_date>='$sdate' and a.dr_posted_date<='$edate' and a.dr_no>0";
			  $q11=mysql_query($s11) or die(mysql_error());
			  $r11=mysql_fetch_assoc($q11);
				
				
			  //SHOW ALL ACTUAL DR (SALES ON ACCOUNT)
			  $s1="select sum(dr_qty*b_amount) as total1 from sales_bookings_details where dr_posted_date>='$sdate' and dr_posted_date<='$edate' and dr_no>0";
			  $q1=mysql_query($s1) or die(mysql_error());
			  $r1=mysql_fetch_assoc($q1);
			  
			  $s2="select sum(payment) as payment from sales_jo_payments where payment_datetime>='$sdate' and payment_datetime<='$edate'";
			  $q2=mysql_query($s2) or die(mysql_error());
			  $r2=mysql_fetch_assoc($q2);

			  
			  $unearned_revenue=$r2['payment']-$r1['total1'];
							
			  echo "<table>";
			  
			  echo "<tr>
						<td width='350'>
							<b class='w3-text-indigo'>DR (CASH) TOTAL SALES: </b>
							<a href='script_sales_monitoring.php?cash_dr=1&sdate=".$_REQUEST['sdate']."&edate=".$_REQUEST['edate']."' target='_blank'><i>(view)</i></a>
						</td>
						<td align='right'><b class='w3-text-indigo w3-large'>".number_format($r11['total1'],2)."</b></td>
					</tr>";
					
			  echo "<tr>
						<td>
							<b class='w3-text-indigo'>DR (SALES ON ACCOUNT) TOTAL SALES: </b>
							<a href='script_sales_monitoring.php?sales_on_account=1&sdate=".$_REQUEST['sdate']."&edate=".$_REQUEST['edate']."' target='_blank'><i>(view)</i></a>
						</td>
						<td align='right'><b class='w3-text-indigo w3-large'>".number_format($r1['total1']-$r11['total1'],2)."</b></td>
					</tr>";		
			  echo "<tr>";
				  echo "<td><b class='w3-text-indigo'>DR TOTAL SALES: </b></td>
						<td><b class='w3-text-indigo w3-large'>".number_format($r1['total1']-$r11['total1']+$r11['total1'],2)."</b></td>
					</tr>";
			  echo "<tr class='w3-tiny'>
						<td>&nbsp;</td>
					</tr>";		
				
				/*
				  echo "<tr>
						<td><i class='w3-text-red w3-small'>(PAYMENTS)</i> <b class='w3-text-red'> UNEARNED REVENUE: </b>
						<td align='right'><b class='w3-text-red w3-large'>";
							if($unearned_revenue>0){ echo number_format($unearned_revenue,2); }else{ }
			      echo "</td>
					</tr>";
				*/
			
				switch($r9['bch'])
				{	
					case "main": $branch1="SALES"; break;
					case "sm": $branch1="SM SALES"; break;
					case "rzl": $branch1="RIZAL SALES"; break;
					case "sp": $branch1="SANPEDRO SALES"; break;
					case "sj": $branch1="SANJOSE SALES"; break;
					case "goc": $branch1=""; break;
				}
				
				echo "<tr>
						<td>
							<i class='w3-text-green w3-small'>(PAYMENTS)</i> 
							<b class='w3-text-green'>TOTAL POSTED PAYMENTS: </b>
							<a href='script_sales_monitoring.php?sortby=jo&total_posted=1&sdate=".$_REQUEST['sdate']."&edate=".$_REQUEST['edate']."&branch1=$branch1' target='_blank'><i>(view)</i></a>
						</td>
						<td align='right'><b class='w3-text-green w3-large'>".number_format($r1['total1']+$unearned_revenue,2)."</b></td>
					</tr>";
			  echo "</table>";
			  
			  
			  $user=$_SESSION['username'];
			  if($r9['bch']!="goc")
			  {
				$s="select a.*, b.bch from sales_bookings_details a left join users b on a.bch=b.bch where b.username='$user' and a.dr_posted_date>='$sdate' and a.dr_posted_date<='$edate' and a.dr_no>0 order by a.dr_posted_date desc";
			  }
			  else
			  {
				$s="select * from sales_bookings_details where dr_posted_date>='$sdate' and dr_posted_date<='$edate' and dr_no>0 order by dr_posted_date desc";
			  }
			  
			  $q=mysql_query($s) or die(mysql_error());
			  $r=mysql_fetch_assoc($q);
			  
			  echo "<table class='w3-table' width='100%'>
						<tr><td colspan='11' class='w3-tiny w3-light-blue'>(CASH DR & SALES ON ACCOUNT) LIST OF JOB ORDERS</td></tr>
						<tr class='w3-grey w3-tiny w3-text-white'>
							<td>#</td>
							<td>JO BY</td>
							<td>JO NO</td>
							<td>BOOKING</td>
							<td>THRU</td>
							<td>CLIENT</td>
							<td>DESCRIPTION</td>
							<td>QTY</td>
							<td>UNIT PRICE</td>
							<td>AMOUNT</td>
							<td>DR NO / DATE</td>
						</tr>";
				$x=1;
			  do{
				    $b_id=$r['b_id'];
					$ss1="select * from sales_jo where b_id='$b_id'";
					$qq1=mysql_query($ss1) or die(mysql_error());
					$rr1=mysql_fetch_assoc($qq1);
					
					    //thru
						$trans_no=$rr1['trans_type'];
						$qa=mysql_query("select trans_desc from sales_transaction_type where trans_no=$trans_no") or die(mysql_error());
						$ra=mysql_fetch_assoc($qa);
						
						//client
						$client_id=$rr1['client_id'];
						$qb=mysql_query("select name from sales_clients where client_id=$client_id") or die(mysql_error());
						$rb=mysql_fetch_assoc($qb);
					
					echo "<tr class='w3-hover-pale-red'>
							<td class='w3-tiny'><i>".$x++."</i></td>
							<td class='w3-tiny'>".$rr1['created_by']."</td>
							<td class='w3-tiny'>".$rr1['jo_no']."</td>
							<td class='w3-tiny'>".$rr1['bo_no']."</td>
							<td class='w3-tiny'>".$ra['trans_desc']."</td>
							<td><a href='admin_sales.php?client_id=".$rr1['client_id']."&client=".$rb['name']."&sales=1&newjobs=1&create_quotation=1' target='_blank'>".$rb['name']."</a></td>
							<td class='w3-tiny'>".$r['b_desc']." : ".$r['code_set']."</td>
							<td>".$r['b_qty']."</td>
							<td class='w3-text-red'>".number_format($r['b_amount'],2)."</td>
							<td><b class='w3-text-red'>".number_format($r['dr_qty']*$r['b_amount'],2)."</b></td>
							<td class='w3-tiny'>
								<i class='w3-text-green'>DR NO: ".$r['dr_no']."</i><br/>
								<i class='w3-text-indigo'>DR DATE: ".date('m/d/Y',strtotime($r['dr_date']))."</i>
								<i>POSTED DATE: ".date('m/d/Y',strtotime($r['dr_posted_date']))."</i>
							</td>
						  </tr>";
				}while($r=mysql_fetch_assoc($q));
				echo "</table>";
			  //Actual DR Sales End ---
			  }
		?>  
		
	
	
	
       <?php			
			}     
		} 
		// Monitoring End --->
?>