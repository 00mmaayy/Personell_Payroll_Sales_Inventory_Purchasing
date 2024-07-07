<!--Payroll Start-->
  <?php if(isset($_REQUEST['payroll'])) { ?>   
	<div class="w3-col">
      <div class="w3-container w3-blue w3-padding-15">
        <div class="w3-left w3-xlarge"><i class="fa fa-money w3-xlarge"></i>  Payroll</div>
      </div>
	  <br>
	  <div class="container">
         <ul class="nav nav-tabs">
          <?php if($access['a2']==1){ ?>
		  <?php if(isset($_REQUEST['payroll_processing'])) { echo "<li class='active'>"; } else { echo "<li class='inactive'>"; } ?>
		  <a href="admin.php?payroll=1&payroll_processing=1">Payroll Processing</a></li>
		  <?php } ?>
		  
          <?php if($access['a15']==1){ ?>
		  <?php if(isset($_REQUEST['payroll_reports'])) { echo "<li class='active'>"; } else { echo "<li class='inactive'>"; } ?>
		  <a href="admin.php?payroll=1&payroll_reports=1">Payroll Reports</a></li>
		  <?php } ?>
		  
		  <?php if($access['a16']==1){ ?>
		  <?php if(isset($_REQUEST['pay_slip_maintenance'])) { echo "<li class='active'>"; } else { echo "<li class='inactive'>"; } ?>
		  <a href="admin.php?payroll=1&pay_slip_maintenance=1">Payslip Maintenance</a></li>
		  <?php } ?>
		  
		  <?php if($access['a17']==1){ ?>
		  <?php if(isset($_REQUEST['cut_off'])) { echo "<li class='active'>"; } else { echo "<li class='inactive'>"; } ?>
		  <a href="admin.php?payroll=1&cut_off=1">Processing Date Setting</a></li>
			<?php } ?>
			
			<?php if ($access['a17'] == 1) { ?>
				<?php if (isset($_REQUEST['advances'])) {
						echo "<li class='active'>";
					} else {
						echo "<li class='inactive'>";
					} 
					
					$z1="select * from payroll_cutoff";
					$z2=mysql_query($z1) or die(mysql_error());
					$z3=mysql_fetch_assoc($z2);
		   
						if(date('d')>=$z3['c1'] && date('d')<=$z3['c11'])
						{ 
							
						}
		     
						elseif(date('d')>=$z3['c2'] && date('d')<=$z3['c22'])
						{ } 
			  
						else
						{ ?>
				
							<a href="admin.php?payroll=1&advances=1">Advances</a></li>
						
					<?php	
						}
				
					} ?>
		 
		 </ul>
      </div>
	  
	  <?php //PAYROLL PROCESS START
	  if(isset($_REQUEST['payroll_processing']))
	    {  
	       $z1="select * from payroll_cutoff";
           $z2=mysql_query($z1) or die(mysql_error());
           $z3=mysql_fetch_assoc($z2);
		   
			//STEP 1 
			include 'menu_payroll_step_1.php';
		   
			//STEP 2
			include 'menu_payroll_step_2.php';
		   
			//STEP 3
			include 'menu_payroll_step_3.php';
		   
		   
		   if(isset($_REQUEST['other_deduct_final']))
		    { 

				$password=md5($_REQUEST['manager_overide']);
				$valid_user=$_SESSION['username'];
				$s111="select username, password from users where username='$valid_user'";
				$q111=mysql_query($s111) or die(mysql_error());
				$r111=mysql_fetch_assoc($q111);
				
				
					if($password==$r111['password'])
					{
						
							 $pp=$_REQUEST['payroll_period'];
							 $s1="select * from payroll where payroll_period='$pp'";
							 $q1=mysql_query($s1) or die(mysql_error());
							 $r1=mysql_fetch_assoc($q1);
							   
							 do{
							   $e_no=$r1['e_no'];
							   
							   $gross_pay=$r1['e_total_cuttoff_hours_final']
										 +$r1['e_overtime_final']
										 +$r1['e_restday_pay_final']
										 +$r1['e_restday_pay_overtime_final']
										 +$r1['e_nightshift_final']
										 +$r1['e_overtime_nightshift_final']
										 +$r1['e_regular_holiday_final']
										 +$r1['e_regular_holiday_overtime_final']
										 +$r1['e_special_holiday_final']
										 +$r1['e_special_holiday_overtime_final']
										 +$r1['e_sick_leave_final']
										 +$r1['e_vacation_leave_final']
										 +$r1['e_solo_parent_leave_final']
										 +$r1['e_add_allowance']
										 +$r1['e_allowance15']
										 +$r1['e_allowance30']
										 -$r1['e_lates_final']
										 -$r1['e_absences_final']
										 -$r1['e_undertime_final'];
										 
							   $deduction=$r1['e_sss']
										 +$r1['e_pagibig']
										 +$r1['e_philhealth']
										 +$r1['e_tax']
										 +$r1['e_ca']
										 +$r1['e_pagibig_loan']
										 +$r1['e_pagibig_loan_calamity']
										 +$r1['e_salary_loan']
										 +$r1['e_salary_calamity_loan']
										 +$r1['e_sss_calamity_loan']
										 +$r1['e_sss_loan']
										 +$r1['e_other_charges']
										 +$r1['e_veterans_loan']
										 +$r1['e_over_in_previous_pay'];
							   
							   $net_pay=round($gross_pay-$deduction,2);
							   
							   mysql_query("update payroll set step3=1,e_netpay=$net_pay where payroll_period='$pp' and e_no='$e_no'");
							   }while ($r1=mysql_fetch_assoc($q1));
							   
							   $username=$_SESSION['username'];
							   $trans="Compute Netpay and Other deductions on payroll period $pp";
							   $log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
							   $log_query=mysql_query($log_sql) or die(mysql_error());
					
						header('Location: admin.php?payroll=1&payroll_processing=1');
					}
					
					else
					{
						header('Location: admin.php?payroll=1&payroll_processing=1&error=1');
					}
					
				
			}
			  
			  
			if(isset($_REQUEST['returnto_step3']))
			  {  
			     $pp=$_REQUEST['payroll_period'];
			     $s1="update payroll set e_netpay=0, step3=0 where payroll_period='$pp'";
			     $q1=mysql_query($s1) or die(mysql_error());
			       
				   $username=$_SESSION['username'];
			       $trans="Send Back to Step 3 needs revision on payroll period $pp";
                   $log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
                   $log_query=mysql_query($log_sql) or die(mysql_error());
				   
				   header('Location: admin.php?payroll=1&payroll_processing=1');
			  }	
			
			//STEP 4
		   if(isset($_REQUEST['finalize']))
		   { 
	          $pp=$_REQUEST['payroll_period'];
			  $s1="update payroll set finalized=1 where payroll_period='$pp'";
			  $q1=mysql_query($s1) or die(mysql_error());
			  
			  $s9x="update payroll_summary set status=1 where payroll_period='$pp' order by data_id desc limit 1";
			  $q9x=mysql_query($s9x) or die(mysql_error());
			  
			  $s10x="delete from payroll_summary where payroll_period='$pp' and status=0";
			  $q10x=mysql_query($s10x) or die(mysql_error());
			   
			  $username=$_SESSION['username'];
			  $trans="Finalize Payroll period $pp Complete!";
              $log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
              $log_query=mysql_query($log_sql) or die(mysql_error());
			   
			  header('Location: admin.php?payroll=1&payroll_processing=1');
		    }
		
		 ?>
		 
		 
          <br>
		  <table class="table" border="1">
		    <tr class="bg-info"><td>Process Steps / Description</td><td>Task Action</td><td>Task Status</td></tr>
			
			<!--STEP 1 START-->
			<tr>
			 <td>
			  <span class="text-success">Step 1:</span> Sets PAYROLL PERIOD for the month.
			  <span class="text-danger">
			   <?php
			              if(date('d')>=$z3['c1'] && date('d')<=$z3['c11']){ echo date('m')."-".$z3['c1']."-".date('Y');}
					  elseif(date('d')>=$z3['c2'] && date('d')<=$z3['c22']){ echo date('m')."-".$z3['c2']."-".date('Y');} 
                                       else{ echo "NO PAYROLL PROCESSING TODAY";}?>
			  </span>
			 </td>
			 
			  <?php
			 if(date('d')>=$z3['c1'] && date('d')<=$z3['c11'])
			     { $pay_period=date('Y-m')."-".$z3['c1'];
			       $sp="select payroll_period from payroll where payroll_period='$pay_period'"; }
		     
			 elseif(date('d')>=$z3['c2'] && date('d')<=$z3['c22'])
			     { $pay_period=date('Y-m')."-".$z3['c2'];
				   $sp="select payroll_period from payroll where payroll_period='$pay_period'"; } 
			  
			 else{ $pay_period='2000-01-01'; $sp="select payroll_period from payroll where payroll_period='$pay_period'";}
         	  
			  $qp=mysql_query($sp) or die(mysql_error());
			  $rp=mysql_fetch_assoc($qp);
			  
		if($rp['payroll_period']!=""){ echo "<td><span class='text-success'>PAYROLL SET SUCCESS!</span></td><td><span class='text-success'>PAYROLL PERIOD: <strong>SET</strong></span></td>"; }
		else{ 
			  if(date('d')>=$z3['c1'] && date('d')<=$z3['c11'] )
			  { 
			  ?>
			  <td>
			  <?php if($access['a3']==1){ ?>
			  <form method="get">
			  <select required name="cut_days">
			     <option value="" disabled selected>Do Nothing</option>
				 <option value="0">Start Payroll System</option>
				<!-- 
				 <option value="88">11 Days</option>
			     <option value="96">12 Days</option>
				 <option value="104">13 Days</option>
				 <option value="112">14 Days</option>
				-->
			  </select>
			  <input name="payroll" type="hidden" value="1">
			  <input name="payroll_period" type="hidden" value="<?php echo date('Y-m')."-".$z3['c1']; ?>">
			  <input name="payroll_processing" type="hidden" value="1">
			  
			  <input name="set_payroll_period" class="btn btn-danger" type="submit" value="(<?php echo $z3['c1'];?>th) Process Payroll Period Now!" onclick="return confirm('Process Payroll Period Now?')">
		      <?php } else{ echo "NEEDS HR ACTION"; } ?>
			  </form>
			  
			  </td><td><span class="text-danger">PAYROLL PERIOD: <strong>NOT SET</strong></span></td>
			  <?php }
              elseif(date('d')>=$z3['c2'] && date('d')<=$z3['c22']) 
			  { 
		      ?>
			  <td>
			  <form method="get">
			  <select required name="cut_days">
			     <option value="" disabled selected>Do Nothing</option>
				 <option value="0">Start Payroll System</option>
				<!-- 
				 <option value="88">11 Days</option>
			     <option value="96">12 Days</option>
				 <option value="104">13 Days</option>
				 <option value="112">14 Days</option>
				-->
			  </select>
			  <input name="payroll" type="hidden" value="1">
			  <input name="payroll_period" type="hidden" value="<?php echo date('Y-m')."-".$z3['c2']; ?>">
			  <input name="payroll_processing" type="hidden" value="1">
			  
			  <?php if($access['a3']==1){ ?><input name="set_payroll_period" class="btn btn-danger" type="submit" value="(<?php echo $z3['c2'];?>th) Process Payroll Period Now!" onclick="return confirm('Process Payroll Period Now?')">
		      <?php } else{ echo "NEEDS HR ACTION"; } ?>
			  
			  </form>
			  </td><td><span class="text-danger">PAYROLL PERIOD: <strong>NOT SET</strong></span></td>
			  <?php } 
			  else{ echo "<td><span class='text-danger'>NO PAYROLL PROCESSING TODAY</span></td><td><span class='text-danger'>NO PAYROLL PROCESSING TODAY</span></td>"; } 
		      
		     }  ?>
			</tr>
			<!--STEP 1 END-->
			
			<!--STEP 2 START-->
			<tr>
			 <td><span class="text-success">Step 2:</span> Process deductions <span class="text-danger">( 1st CutOff = HDMF, PhilHealth | 2nd CutOff = SSS, Tax )</span></td>
			  
			  <?php
			  if(date('d')>=$z3['c1'] && date('d')<=$z3['c11'])
			     { $pay_period=date('Y-m')."-".$z3['c1'];
			       $sp="select * from payroll where payroll_period='$pay_period' ";
			       $qp=mysql_query($sp) or die(mysql_error());
			       $rp=mysql_fetch_assoc($qp);
			     }
		      
			  elseif(date('d')>=$z3['c2'] && date('d')<=$z3['c22'])
			    { $pay_period=date('Y-m')."-".$z3['c2'];
	              $sp="select * from payroll where payroll_period='$pay_period' ";
			      $qp=mysql_query($sp) or die(mysql_error());
			      $rp=mysql_fetch_assoc($qp);		  
			    } 
         	  else{}
			  
			  
		if($rp['step2']=="1"){ echo "<td><span class='text-success'>DEDUCTIONS SET SUCCESS!</span><td><span class='text-success'>DEDUCTIONS: <strong>SET</strong></span></td>"; }
		else{ 
			  if(date('d')>=$z3['c1'] && date('d')<=$z3['c11'] )
			  { 
			  ?>
			  <td>
			  <form method="get">
			  <input name="payroll" type="hidden" value="1">
			  <input name="payroll_period" type="hidden" value="<?php echo date('Y-m')."-".$z3['c1']; ?>">
			  <input name="payroll_processing" type="hidden" value="1">
			  
			  <?php if($access['a4']==1){ ?><input name="deductions" class="btn btn-danger" type="submit" value="(<?php echo $z3['c1']; ?>th) Process Deductions Now!" onclick="return confirm('Process Deductions Now?')">
		      <?php } else{ echo "NEEDS HR ACTION"; } ?>
			  
			  </form>
			  </td>
			  <td><span class="text-danger">DEDUCTIONS: <strong>NOT SET</strong></span></td>
			  <?php }
              
			  elseif(date('d')>=$z3['c2'] && date('d')<=$z3['c22']) 
			  { 
		      ?>
			  <td>
			  <form method="get">
			  <input name="payroll" type="hidden" value="1">
			  <input name="payroll_period" type="hidden" value="<?php echo date('Y-m')."-".$z3['c2']; ?>">
			  <input name="payroll_processing" type="hidden" value="1">
			  
			  <?php if($access['a4']==1){ ?><input name="deductions" class="btn btn-danger" type="submit" value="(<?php echo $z3['c2']; ?>th) Process Deductions Now!" onclick="return confirm('Process Deductions Now?')">
		      <?php } else{ echo "NEEDS HR ACTION"; } ?>
			  
			  </form>
			  </td>
			  <td><span class="text-danger">DEDUCTIONS: <strong>NOT SET</strong></span></td>
			  <?php }
			  
			  else{ echo "<td><span class='text-danger'>NO PAYROLL PROCESSING TODAY</span></td><td><span class='text-danger'>NO PAYROLL PROCESSING TODAY</span></td>"; } 
		   
		   }  ?>
			 </td>
			 </tr>
			<!--STEP 2 END-->
			
			
			<!--STEP 3 START-->
			<tr>
			 <td><span class="text-success">Step 3:</span> Process OTHER deductions and additions <span class="text-danger">( Loans, CA, Other Payables, Adjustments )</span></td>
			  
			  <?php
			  if(date('d')>=$z3['c1'] && date('d')<=$z3['c11'])
			     { $pay_period=date('Y-m')."-".$z3['c1'];
			       $sp="select * from payroll where payroll_period='$pay_period' ";
			       $qp=mysql_query($sp) or die(mysql_error());
			       $rp=mysql_fetch_assoc($qp);
			     }
		      
			  elseif(date('d')>=$z3['c2'] && date('d')<=$z3['c22'])
			    { $pay_period=date('Y-m')."-".$z3['c2'];
	              $sp="select * from payroll where payroll_period='$pay_period' ";
			      $qp=mysql_query($sp) or die(mysql_error());
			      $rp=mysql_fetch_assoc($qp);		  
			    } 
         	  else{}
			  
			  
		if($rp['step3']=="1"){ echo "<td><span class='text-success'>OTHER DEDUCTIONS SET SUCCESS!</span><td><span class='text-success'>OTHER DEDUCTIONS: <strong>SET</strong></span></td>"; }
		else{ 
			  if(date('d')>=$z3['c1'] && date('d')<=$z3['c11'])
			  { 
			  ?>
			  <td>
			  <form method="get">
			  <input name="payroll" type="hidden" value="1">
			  <input name="payroll_period" type="hidden" value="<?php echo date('Y-m')."-".$z3['c1']; ?>">
			  <input name="payroll_processing" type="hidden" value="1">
			  <?php if($access['a5']==1)
			          {  
						?><input name="other_deductions" class="btn btn-danger" type="submit" value="(<?php echo $z3['c1'];?>th) Process OTHERS Now!">
		      <?php   }
			      else{ 
						echo "NEEDS HR ACTION";
					  } 
				?>
			  </form>
			  <?php if(isset($_REQUEST['error'])){ echo "<span class='w3-text-red w3-tiny'>Password did not match! Please Try Again.</span>"; } ?>
			  </td>
			  <td><span class="text-danger">OTHER: <strong>NOT SET</strong></span></td>
			  <?php }
              
			  
			  elseif(date('d')>=$z3['c2'] && date('d')<=$z3['c22']) 
			  { 
		      ?>
			  <td>
			  <form method="get">
			  <input name="payroll" type="hidden" value="1">
			  <input name="payroll_period" type="hidden" value="<?php echo date('Y-m')."-".$z3['c2']; ?>">
			  <input name="payroll_processing" type="hidden" value="1">
			  <?php if($access['a5']==1)
				      { 
					    ?><input name="other_deductions" class="btn btn-danger" type="submit" value="(<?php echo $z3['c2'];?>th) Process OTHERS Now!">
				<?php } 
				  else{ 
						echo "NEEDS HR ACTION";
					  } 
			 ?>
			  </form>
			  <?php if(isset($_REQUEST['error'])){ echo "<span class='w3-text-red w3-tiny'>Password did not match! Please Try Again.</span>"; } ?>
			  </td>
			  <td><span class="text-danger">OTHERS: <strong>NOT SET</strong></span></td>
			  <?php }
			  
			  else{ echo "<td><span class='text-danger'>NO PAYROLL PROCESSING TODAY</span></td><td><span class='text-danger'>NO PAYROLL PROCESSING TODAY</span></td>"; } 
		   
		   }  ?>
			 </td>
			 </tr>
          <!--STEP 3 END-->
	
	
	      <!--STEP 4 START-->		  
			  <?php
			  if(date('d')>=$z3['c1'] && date('d')<=$z3['c11'])
			     { $pay_period=date('Y-m')."-".$z3['c1'];
			       $sp="select * from payroll where payroll_period='$pay_period' ";
			       $qp=mysql_query($sp) or die(mysql_error());
			       $rp=mysql_fetch_assoc($qp);
			     }
		      
			  elseif(date('d')>=$z3['c2'] && date('d')<=$z3['c22'])
			     { $pay_period=date('Y-m')."-".$z3['c2'];
	               $sp="select * from payroll where payroll_period='$pay_period' ";
			       $qp=mysql_query($sp) or die(mysql_error());
			       $rp=mysql_fetch_assoc($qp);		  
			     } 
         	  else{}
			
			if($rp['finalized']!=1)
			{	
              if($rp['step3']=="1")
			     { ?>
			   <tr>    
			   <td align="right">Review Payroll Details <span class="text-danger">( For Accounting )</span></td>
			   <td>
			   
			   
			   <!--Review dtr_monitor--->
			   <form method='get' action='script_dtr_monitor.php' target='_blank'>
			   <input name='search' type='hidden' value='xxx'>
			   <input name='rh1' type='hidden' value=''>
			   <input name='rh2' type='hidden' value=''>
			   <input name='rh3' type='hidden' value=''>
			   <input name='rh4' type='hidden' value=''>
			   <input name='sh1' type='hidden' value=''>
			   <input name='sh2' type='hidden' value=''>
			   <input name='sh3' type='hidden' value=''>
			   <input name='sh4' type='hidden' value=''>
			   <input name='sdate' type='hidden' value="<?php echo $_REQUEST['payroll_period'];?>">
			   <input name='edate' type='hidden' value="<?php echo $_REQUEST['payroll_period'];?>">
			   
			   <?php 
			   $qqq1=mysql_query("select payroll_period from payroll order by payroll_period desc") or die(mysql_error()); 
			   $rrr1=mysql_fetch_assoc($qqq1);
			   ?>
			   
			   <input name='payroll_period' type='hidden' value='<?php echo $rrr1['payroll_period']; ?>'>
			   <input class='btn btn-info' type='submit' value='DTR Viewer'>
			   </form>
			   <!---Review dtr_monitor--->
			   
			   
               <?php  if(date('d')>=$z3['c1'] && date('d')<=$z3['c11']) { ?>
			   
			   <!--Work Hour Entry--->
			   <form method='get' action='script_actual_hours_calc.php' target='_blank'>
			     <input name='search' type='hidden' value='xxx'>
			     <input name="payroll_period" type="hidden" value="<?php echo date('Y-m')."-".$z3['c1']; ?>">
	             <input class='btn btn-info' type='submit' value='Actual Hours Viewer'>
			   </form>
			   <!--Work Hour Entry--->
			   
			     <form method="get" action="script_payroll_reports.php" target="_blank">
			       <input name="payroll" type="hidden" value="1">
			       <input name="payroll_period" type="hidden" value="<?php echo date('Y-m')."-".$z3['c1']; ?>">
			       <input name="payroll_processing" type="hidden" value="1">
				   <input name="department" type="hidden" value="ALL">
				   <input name="review_final" class="btn btn-info" type="submit" value="Review Payroll">
		         </form>
				 
				 <form method="get" action="script_payroll_entry_review.php" target="_blank">
				     <input name="payroll_period" type="hidden" value="<?php echo date('Y-m')."-".$z3['c1']; ?>">
					 <input type="submit" class="btn btn-info" value="Review Other Deduction Entry">
				 </form>
				 
			   </td>
			   <td>
			     <form method="get">
			       <input name="payroll" type="hidden" value="1">
			       <input name="payroll_period" type="hidden" value="<?php echo date('Y-m')."-".$z3['c1']; ?>">
			       <input name="payroll_processing" type="hidden" value="1">
		           
				   <?php if($access['a11']==1){ ?><input name="returnto_step3" class="btn btn-warning" type="submit" value="Needs Revision: Back to Step 3" onclick="return confirm('Send Back to step 3?')">
		           <?php } else{ echo "FINANCE ACTION";} ?>
				 </form>
				 <?php } ?>
				 
				 <?php  if(date('d')>=$z3['c2'] && date('d')<=$z3['c22']) { ?>

				<!--Work Hour Entry--->
			   <form method='get' action='script_actual_hours_calc.php' target='_blank'>
			     <input name='search' type='hidden' value='xxx'>
			     <input name="payroll_period" type="hidden" value="<?php echo date('Y-m')."-".$z3['c2']; ?>">
	             <input class='btn btn-info' type='submit' value='Actual Hours Viewer'>
			   </form>
			   <!--Work Hour Entry--->
				 
			     <form method="get" action="script_payroll_reports.php" target="_blank">
			       <input name="payroll" type="hidden" value="1">
			       <input name="payroll_period" type="hidden" value="<?php echo date('Y-m')."-".$z3['c2']; ?>">
			       <input name="payroll_processing" type="hidden" value="1">
				   <input name="department" type="hidden" value="ALL">
				   <input name="review_final" class="btn btn-info" type="submit" value="Review Payroll">
		         </form>
				 
				 <form method="get" action="script_payroll_entry_review.php" target="_blank">
				     <input name="payroll_period" type="hidden" value="<?php echo date('Y-m')."-".$z3['c2']; ?>">
					 <input type="submit" class="btn btn-info" value="Review Other Deduction Entry">
				 </form>
				 
			   </td>
			   <td>
			     <form method="get">
			       <input name="payroll" type="hidden" value="1">
			       <input name="payroll_period" type="hidden" value="<?php echo date('Y-m')."-".$z3['c2']; ?>">
			       <input name="payroll_processing" type="hidden" value="1">
		           
				   <?php if($access['a11']==1){ ?><input name="returnto_step3" class="btn btn-warning" type="submit" value="Needs Revision: Back to Step 3" onclick="return confirm('Send Back to step 3?')">
		           <?php } else{ echo "FINANCE ACTION";} 
				         
						 ?>
				 </form>
				 <?php } ?>
				 
			   
			   </td>
			   </tr>
				<?php 
			     }else {}
			}
		      ?>
		  <!--STEP 4 END-->	
			
			
		  <!--STEP 5 START-->		  
			<tr>
			   <td><span class="text-success">Step 4:</span> Finalize Payroll <span class="text-danger">( Accounting: Payroll Reports and Payslip will become available. )</span></td>
			  <?php
			  if(date('d')>=$z3['c1'] && date('d')<=$z3['c11'])
			     { $pay_period=date('Y-m')."-".$z3['c1'];
			       $sp="select * from payroll where payroll_period='$pay_period' ";
			       $qp=mysql_query($sp) or die(mysql_error());
			       $rp=mysql_fetch_assoc($qp);
			     }
		      
			  elseif(date('d')>=$z3['c2'] && date('d')<=$z3['c22'])
			    { $pay_period=date('Y-m')."-".$z3['c2'];
	              $sp="select * from payroll where payroll_period='$pay_period' ";
			      $qp=mysql_query($sp) or die(mysql_error());
			      $rp=mysql_fetch_assoc($qp);		  
			    } 
         	  else{}
			  
     
     if($rp['finalized']=="1"){ echo "<td><span class='text-success'>FINALIZE PAYROLL SUCCESS!</span><td><span class='text-success'>FINALIZE: <strong>SET</strong></span></td>"; }
	 else { 
			  if(date('d')>=$z3['c1'] && date('d')<=$z3['c11'])
			  { 
			  ?>
			  <td>
			  <form method="get">
			  <input name="payroll" type="hidden" value="1">
			  <input name="payroll_period" type="hidden" value="<?php echo date('Y-m')."-".$z3['c1']; ?>">
			  <input name="payroll_processing" type="hidden" value="1">
		      
			  <?php if($access['a12']==1){
			            if($rp['step3']==1){; ?>
			              <input name="finalize" class="btn btn-danger" type="submit" value="(<?php echo $z3['c1']; ?>th) Finalize Now!" onclick="return confirm('Finalize Payroll Now?')">
							<?php } else { echo "NEEDS HR ACTION";} ?>
			  <?php } else{ echo "FINANCE ACTION"; } ?>  
			  
			  </form>
			  </td>
			  <td><span class="text-danger">FINALIZE: <strong>NOT SET</strong></span></td>
			  <?php }
              
			  elseif(date('d')>=$z3['c2'] && date('d')<=$z3['c22'])
			  { ?>
			  <td>
			  <form method="get">
			  <input name="payroll" type="hidden" value="1">
			  <input name="payroll_period" type="hidden" value="<?php echo date('Y-m')."-".$z3['c2']; ?>">
			  <input name="payroll_processing" type="hidden" value="1">
			  
			  <?php if($access['a12']==1){
			              if($rp['step3']==1){; ?>
			              <input name="finalize" class="btn btn-danger" type="submit" value="(<?php echo $z3['c2']; ?>th) Finalize Now!" onclick="return confirm('Finalize Payroll Now?')">
							<?php }else { echo "NEEDS HR ACTION";} ?>
			  <?php } else{ echo "FINANCE ACTION";} ?>
			  
			  </form>
			  </td>
			  <td><span class="text-danger">FINALIZE: <strong>NOT SET</strong></span></td>
			  <?php }
			  
			  else { echo "<td><span class='text-danger'>NO PAYROLL PROCESSING TODAY</span></td><td><span class='text-danger'>NO PAYROLL PROCESSING TODAY</span></td>"; } 
		   }	   
		    ?>
			 </td>
			 </tr>
		  <!--STEP 5 END-->	
		 </table>	
		 
         <table>	
		  <tr align="center" valign="top">


		<!----------RESET PAYROLL START--------> 
		<?php
		if($access['a18']==1)
		{
		$q=mysql_query("SELECT payroll_period FROM payroll WHERE finalized=0 GROUP BY payroll_period ORDER BY payroll_period DESC LIMIT 1");
		$r=mysql_fetch_assoc($q);
		$pp=$r['payroll_period'];
		if($pp){
		?>
		    <td width="300">  
		       <br>
			   <div align='center' class="text-danger">Restart Payroll <b><?php echo date('m-d-Y',strtotime($pp)); ?></b><br>Back to Step1<br>WARNING: Please BACKUP DATABASE Before Proceeding.
			   <?php if(isset($_REQUEST['success'])){ echo " <b class='w3-text-green'>Success!</b>"; } ?></div>
	           <form method='get' action='script_restart_payroll.php'>
	           <input class='form-control btn-warning' type='submit' value='Restart Payroll' onclick='return confirm("WARNING! Becareful what you wish for. Please BACKUP Database on SETTINGS Before You Proceed. Are you Sure to DELETE latest Payroll Period? <?php echo date('m-d-Y',strtotime($pp)); ?>")'>
			   </form>
		    </td>
		<?php } ?>
		<td width="50">&nbsp;</td>	
		<?php } ?>
		<!----------RESET PAYROLL END-------->

			
		   <td width="300">  
		     <br>
			   <?php if($access['a13']==1){ ?>
			   <div align='center' class="text-danger">Use This Menu for Batch entry only:</div>
	           <form method='get' action='script_batch_comp.php' target='_blank'>
	           <input class='form-control btn-danger' type='submit' value='Batch Compensation Entry'>
			   </form>
			   <?php } ?>
		 
		    </td>
			
			<td width="50">&nbsp;</td>
			
			<!--
			<td width="300">
			   <br>
			   <?php //if($access['a14']==1){ ?>
			   <div align='center' class="text-danger">W-Tax Computation</div>
	           <form method='get' action='script_wtax_calc.php' target='_blank'>
	           <input class='form-control btn-danger' type='submit' value='Open Computation' onclick="return confirm('WARNING: This menu updates Witholding-Tax of Employees Automatically. Click OK to continue automatic run. Do you want to continune?')">
			   </form>
			   <?php //} ?>
			</td>
			-->
			
			<td width="50">&nbsp;</td>
			
			<td width="300">
			   <br>
			   <?php if($access['a6']==1){ ?>
			   <div align='center' class="text-danger">DTR Timekeeper</div>
			   
			   <form method='get' action='script_dtr_monitor.php' target='_blank'>
			   <input name='search' type='hidden' value='xxx'>
			   <input name='rh1' type='hidden' value=''>
			   <input name='rh2' type='hidden' value=''>
			   <input name='rh3' type='hidden' value=''>
			   <input name='rh4' type='hidden' value=''>
			   <input name='sh1' type='hidden' value=''>
			   <input name='sh2' type='hidden' value=''>
			   <input name='sh3' type='hidden' value=''>
			   <input name='sh4' type='hidden' value=''>
			   <input name='sdate' type='hidden' value="<?php echo $_REQUEST['payroll_period'];?>">
			   <input name='edate' type='hidden' value="<?php echo $_REQUEST['payroll_period'];?>">
			   
			   <?php 
			   $qqq=mysql_query("select payroll_period from payroll order by payroll_period desc") or die(mysql_error()); 
			   $rrr=mysql_fetch_assoc($qqq);
			   ?>
			   
			   <input name='payroll_period' type='hidden' value='<?php echo $rrr['payroll_period']; ?>'>
	           <!--<input class='form-control btn-danger' type='submit' value='DTR MANAGER FOR <?php //echo date('m/d/Y',strtotime($rrr['payroll_period'])); ?> PAYROLL'>-->
			   </form>
			   
			   <form method='get' action='script_dtr.php' target='_blank'>
				<input type='hidden' name='zkteco' value='1'>
				<input class='form-control btn-danger w3-tiny' type='submit' value='BIOMETRIC DTR MANAGER'>
			   </form>
			   
			   <!--
			   <form method='get' action='script_dtr.php' target='_blank'>
				<input type='hidden' name='realan' value='1'>
				<input class='form-control btn-danger w3-tiny' type='submit' value='DTR MANAGER - REALAND'>
			   </form>
			   -->
			   
			   <?php } ?>
			</td>
			
			
		   </tr>

		 
		  </table>
		  
		  
  <?php } //PAYROLL PROCESS END


  

  
  if(isset($_REQUEST['payroll_reports']))
	    { ?> <br>
	
        <div class="col-xs-6">
		<table>
			<tr valign='top'>
			<td>
                <form method="get" action="script_payroll_reports.php" target="_blank">
					Start Date<input required name="sdate" class="form-control" type="date"><br>
					End Date<input required name="edate" class="form-control" type="date"><br>
				    Per Company<select name="company" class="form-control">
		                 <option></option>
						 <?php
						   $sm3="select company,company_name from company order by company";
						   $qm3=mysql_query($sm3) or die(mysql_error());
						   $rm3=mysql_fetch_assoc($qm3);
						   do{ echo "<option value=".$rm3['company'].">".$rm3['company']." - ".$rm3['company_name']."</option>";
						   }while($rm3=mysql_fetch_assoc($qm3));
						 ?>
					   </select><br>
					   <input class="form-control btn-danger" type="submit" value="Search">
                
				</form>
				
		
				<br>
				<form method="get" action="script_alc_group_salary.php" target="_blank">
								<?php if($access['b3']) { ?>
								<input name='alc_group' type='hidden' value='1'>
								<input class="form-control btn-primary" type="submit" value="ALC Group Salary Share">
								<?php } ?>
				</form>
		
		
			</td>
			<td width='40'>&nbsp;</td>
				<td width=''>
					<?php $qqq=mysql_query("SELECT payroll_period from payroll group by payroll_period DESC") or die(mysql_error()); 
						  $rrr=mysql_fetch_assoc($qqq);
						  echo "<b class='w3-tiny'>Payroll Date Lists</b><br>";
						  echo "dd/mm/yyyy<br>";
						  do{ echo date('d/m/Y',strtotime($rrr['payroll_period']))."<br>"; }while($rrr=mysql_fetch_assoc($qqq));
					?>
			</td>
		
		</tr>	
		</table>
		</div>
		
<?php   }

		
	


	
      if(isset($_REQUEST['pay_slip_maintenance']))
	    { ?> <br>
        
		<div class="col-xs-6">
         <table>
			<tr valign='top'>
			   <td>
			   
					<form method="get" action="script_payslip.php" target="_blank">
					
					<?php 
					$qqq=mysql_query("SELECT payroll_period from payroll group by payroll_period order by payroll_period DESC") or die(mysql_error()); 
					$rrr=mysql_fetch_assoc($qqq);
					echo "<b class='w3-text-indigo'>Payroll Date Lists</b><br>";
					do{ echo "<input type='radio' name='payroll_period' value='".$rrr['payroll_period']."'> &nbsp; <span class='w3-tiny'>".date('F d, Y',strtotime($rrr['payroll_period']))."</span><br>";
					} while($rrr=mysql_fetch_assoc($qqq));
					?>
				</td>
				<td width='40'>&nbsp;</td>
				<td>	
					Per Employee<select name="e_no" class="form-control">
									 <option></option>
									 <?php
									   $sm1="select e_no,e_fname,e_lname from employee order by e_lname asc";
									   $qm1=mysql_query($sm1) or die(mysql_error());
									   $rm1=mysql_fetch_assoc($qm1);
									   do{ echo "<option value=".$rm1['e_no'].">".$rm1['e_lname'].", ".$rm1['e_fname']."</option>";
									   }while($rm1=mysql_fetch_assoc($qm1));
									 ?>
								   </select><br>
					Per Company<select name="company" class="form-control">
									 <option></option>
									 <?php
									   $sm3="select company,company_name from company order by company";
									   $qm3=mysql_query($sm3) or die(mysql_error());
									   $rm3=mysql_fetch_assoc($qm3);
									   do{ echo "<option value=".$rm3['company'].">".$rm3['company']." - ".$rm3['company_name']."</option>";
									   }while($rm3=mysql_fetch_assoc($qm3));
									 ?>
								   </select><br>
					  
					  
					  <input class="form-control btn-danger" type="submit" value="Search"><br>
					 </form>
					 
					 
					 <?php if($_SESSION['username']=='omar' or $_SESSION['username']=='oliver' or $_SESSION['username']=='jireh'){ ?>
					 Owner PaySlip Generator<br/>
					 <form action='script_payslip_owner.php' target='_blank'>
						<input name='payroll_period' type='date'>
						<input type='submit' value='Owner Payslip'>
					 </form>
					<?php } ?>
					 
					 
				</td>
				
			</tr>	
		</table>
		</div>
		
 <?php  }	
		

		
		
		
		
       if(isset($_REQUEST['cut_off']))
	    { 
	      if(isset($_REQUEST['change_cutoff']))
		    {
				
			$reason=$_REQUEST['change_reason'];
			
			  if($_REQUEST['sdate1']!="")
			    { $sdate1=$_REQUEST['sdate1']; mysql_query("update payroll_cutoff set c1=$sdate1"); 
			      
				 $username=$_SESSION['username'];
			     $trans="Update 1st cutoff date start to $sdate1. Reason: $reason";
                 $log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
                 $log_query=mysql_query($log_sql) or die(mysql_error());
				}
			
			  if($_REQUEST['edate1']!="")
			    { $edate1=$_REQUEST['edate1']; mysql_query("update payroll_cutoff set c11=$edate1"); 
			
			     $username=$_SESSION['username'];
			     $trans="Update 1st cutoff date end to $edate1. Reason: $reason";
                 $log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
                 $log_query=mysql_query($log_sql) or die(mysql_error());
				}
			
			  if($_REQUEST['sdate2']!="")
			    { $sdate2=$_REQUEST['sdate2']; mysql_query("update payroll_cutoff set c2=$sdate2"); 
			
			     $username=$_SESSION['username'];
			     $trans="Update 2nd cutoff date start to $sdate2. Reason: $reason";
                 $log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
                 $log_query=mysql_query($log_sql) or die(mysql_error());
			    }
			
			  if($_REQUEST['edate2']!="")
			    { $edate2=$_REQUEST['edate2']; mysql_query("update payroll_cutoff set c22=$edate2"); 
			
			     $username=$_SESSION['username'];
			     $trans="Update 2nd cutoff date end to $edate2. Reason: $reason";
                 $log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
                 $log_query=mysql_query($log_sql) or die(mysql_error());
				}
				
			 header('Location: admin.php?payroll=1&cut_off=1');
			}
	     
	      $off="select * from payroll_cutoff";
	      $coff=mysql_query($off) or die(mysql_error());
          $cutoff=mysql_fetch_assoc($coff); 
		  
		  $date="<option></option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option>
		         <option>6</option><option>7</option><option>8</option><option>9</option><option>10</option><option>11</option>
				 <option>12</option><option>13</option><option>14</option><option>15</option><option>16</option><option>17</option>
				 <option>18</option><option>19</option><option>20</option><option>21</option><option>22</option><option>23</option>
				 <option>24</option><option>25</option><option>26</option><option>27</option><option>28</option><option>29</option>
				 <option>30</option><option>31</option>";
		  ?> <br>
	
        
		<div class="col-xs-4">
		<form method="get">
		
		<input name="payroll" type="hidden" value="1">
		<input name="cut_off" type="hidden" value="1">
			  
		<table class="table" border="1">
		 <tr class="bg-primary"><td colspan="2">1st Processing Dates</td><td colspan="2">2nd Processing Dates</td>
		 <tr><td class="bg-warning">Start</td><td class="bg-warning">End</td><td class="bg-success">Start</td><td class="bg-success">End</td></tr>
		 <tr><td><?php echo $cutoff['c1']; ?></td><td><?php echo $cutoff['c11']; ?></td>
		     <td><?php echo $cutoff['c2']; ?></td><td><?php echo $cutoff['c22']; ?></td></tr>
		 <tr>
		     <td>
			    <select name="sdate1" class="form-control">
			    <?php echo $date; ?>
				</select>
			 </td>
			 <td>
			    <select name="edate1" class="form-control">
			    <?php echo $date; ?>
				</select>
			 </td>
			 <td>
			    <select name="sdate2" class="form-control">
			    <?php echo $date; ?>
				</select>
			 </td>
			 <td>
			    <select name="edate2" class="form-control">
			    <?php echo $date; ?>
				</select>
			 </td>
		 </tr>
		  <td colspan="4">
		  <br><input required name="change_reason" type="text" placeholder="Please Input Reason" class="form-control"><br>
		  <input name="change_cutoff" class="form-control btn-danger" type="submit" value="Change Cut-Off Dates" onclick="return confirm('Change Cut-Off before payroll. Are you sure?')">
        </form>
		  </td>
		 </tr>
		
        
		</div>
		
<?php } ?>

<?php if(isset($_REQUEST['advances']))
		{
			include 'menu_advances.php';
		}
	?>
	  
		</div>
		
  <?php } ?>
 <!--Payroll End-->