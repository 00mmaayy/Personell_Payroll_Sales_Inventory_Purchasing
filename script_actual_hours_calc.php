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

<body align="center"><br>
<strong>WORK HOURS ENTRY</strong><br>
<strong><small class="text-primary">PAYROLL PERIOD: <?php echo date('m/d/Y',strtotime($_REQUEST['payroll_period']));?></small></strong><br>
<hr>
<?php

//---Access Level---
$current_user=$_SESSION['username'];
$spas="select * from user_access where username='$current_user'";
$qpas=mysql_query($spas) or die(mysql_error());
$access=mysql_fetch_assoc($qpas);
//---Access Level---

//---Lates Update Script---------------
if(isset($_REQUEST['update_workhours']))
  { 
    $per_day=$_REQUEST['per_day'];
	$per_hour=$_REQUEST['per_day']/8;
	$per_min=$_REQUEST['per_day']/8/60;
	
    $e_no=$_REQUEST['e_no'];
	$spp="select payroll_period from payroll order by payroll_period desc";
	$qpp=mysql_query($spp) or die(mysql_error());
	$rpp=mysql_fetch_assoc($qpp);
	$pp=$rpp['payroll_period'];
	
	//---total cutoff hours---
		if(isset($_REQUEST['e_total_cuttoff_hours'])){
		
		$e_total_cuttoff_hours=round($_REQUEST['e_total_cuttoff_hours'],2);
		$e_total_cuttoff_hours_final=round($e_total_cuttoff_hours*$per_hour,2);
		
		
		$sxx="select e_employment_status from employee where e_no='$e_no'";
		$qxx=mysql_query($sxx) or die(mysql_error());
	    $rxx=mysql_fetch_assoc($qxx);
		if($rxx['e_employment_status']=="Regular")
		{
		$meal_per_day=($e_total_cuttoff_hours/8)*35;
		$meals=", e_allowance_meal=$meal_per_day";
		}
		else{ echo $meals=""; }
		
		
		$sxx="update payroll set e_total_cuttoff_hours=$e_total_cuttoff_hours,
		                         e_total_cuttoff_hours_final=$e_total_cuttoff_hours_final
								 $meals
								 where e_no='$e_no' and payroll_period='$pp'";
		mysql_query($sxx) or die(mysql_error());
		
		//---logs entry---
		$username=$_SESSION['username'];
		$trans="e_total_cuttoff_hours added to $e_no on $pp cutoff";
		$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
		$log_query=mysql_query($log_sql) or die(mysql_error());
		}
	
    //---overtime---	
		if(isset($_REQUEST['e_overtime'])){
		$e_overtime=round($_REQUEST['e_overtime'],2);
		$e_overtime_final=round($per_hour*$e_overtime*1.25,2);
		$sxx="update payroll set e_overtime=$e_overtime,
                                 e_overtime_final=$e_overtime_final	
		                         where e_no='$e_no' and payroll_period='$pp'";
		mysql_query($sxx) or die(mysql_error());
		
		//---logs entry---
		$username=$_SESSION['username'];
		$trans="e_overtime added to $e_no on $pp cutoff";
		$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
		$log_query=mysql_query($log_sql) or die(mysql_error());
		}
		
	//---restday pay---	
		if(isset($_REQUEST['e_restday_pay'])){
		$e_restday_pay=round($_REQUEST['e_restday_pay'],2);
		$e_restday_pay_final=round($per_hour*$e_restday_pay*1.3,2);
		$sxx="update payroll set e_restday_pay=$e_restday_pay,
								 e_restday_pay_final=$e_restday_pay_final
								 where e_no='$e_no' and payroll_period='$pp'";
		mysql_query($sxx) or die(mysql_error());
		
		//---logs entry---
		$username=$_SESSION['username'];
		$trans="e_restday_pay added to $e_no on $pp cutoff";
		$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
		$log_query=mysql_query($log_sql) or die(mysql_error());
		}
		
	//---restday pay overtime---	
		if(isset($_REQUEST['e_restday_pay_overtime'])){
		$e_restday_pay_overtime=round($_REQUEST['e_restday_pay_overtime'],2);
		$e_restday_pay_overtime_final=round($per_hour*$e_restday_pay_overtime*1.3*1.3,2);
		$sxx="update payroll set e_restday_pay_overtime=$e_restday_pay_overtime,
								 e_restday_pay_overtime_final=$e_restday_pay_overtime_final
								 where e_no='$e_no' and payroll_period='$pp'";
		mysql_query($sxx) or die(mysql_error());
		
		//---logs entry---
		$username=$_SESSION['username'];
		$trans="e_restday_pay_overtime added to $e_no on $pp cutoff";
		$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
		$log_query=mysql_query($log_sql) or die(mysql_error());
		}
		
	//---nightshift---	
		if(isset($_REQUEST['e_nightshift'])){
		$e_nightshift=round($_REQUEST['e_nightshift'],2);
		$e_nightshift_final=round($per_hour*$e_nightshift*0.1,2);
		$sxx="update payroll set e_nightshift=$e_nightshift,
								 e_nightshift_final=$e_nightshift_final
								 where e_no='$e_no' and payroll_period='$pp'";
		mysql_query($sxx) or die(mysql_error());
		
		//---logs entry---
		$username=$_SESSION['username'];
		$trans="e_nightshift added to $e_no on $pp cutoff";
		$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
		$log_query=mysql_query($log_sql) or die(mysql_error());
		}
		
	//---overtime nightshift---	
		if(isset($_REQUEST['e_overtime_nightshift'])){
		$e_overtime_nightshift=round($_REQUEST['e_overtime_nightshift'],2);
		$e_overtime_nightshift_final=round($per_hour*$e_overtime_nightshift*1.25*1.1,2);
		$sxx="update payroll set e_overtime_nightshift=$e_overtime_nightshift,
								 e_overtime_nightshift_final=$e_overtime_nightshift_final
								 where e_no='$e_no' and payroll_period='$pp'";
		mysql_query($sxx) or die(mysql_error());
		
		//---logs entry---
		$username=$_SESSION['username'];
		$trans="e_overtime_nightshift added to $e_no on $pp cutoff";
		$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
		$log_query=mysql_query($log_sql) or die(mysql_error());
		}
		
	//---regular holiday---	
		if(isset($_REQUEST['e_regular_holiday'])){
		$e_regular_holiday=round($_REQUEST['e_regular_holiday'],2);
		$e_regular_holiday_final=round($per_hour*$e_regular_holiday,2);
		//$e_regular_holiday_final=round($per_hour*$e_regular_holiday*2,2); Luma
		$sxx="update payroll set e_regular_holiday=$e_regular_holiday,
								 e_regular_holiday_final=$e_regular_holiday_final
								 where e_no='$e_no' and payroll_period='$pp'";
		mysql_query($sxx) or die(mysql_error());
		
		//---logs entry---
		$username=$_SESSION['username'];
		$trans="e_regular_holiday added to $e_no on $pp cutoff";
		$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
		$log_query=mysql_query($log_sql) or die(mysql_error());
		}
		
	//---regular holiday overtime---	
		if(isset($_REQUEST['e_regular_holiday_overtime'])){
		$e_regular_holiday_overtime=round($_REQUEST['e_regular_holiday_overtime'],2);
		$e_regular_holiday_overtime_final=round($per_hour*$e_regular_holiday_overtime*2.6,2);
		$sxx="update payroll set e_regular_holiday_overtime=$e_regular_holiday_overtime,
								 e_regular_holiday_overtime_final=$e_regular_holiday_overtime_final
								 where e_no='$e_no' and payroll_period='$pp'";
		mysql_query($sxx) or die(mysql_error());
		
		//---logs entry---
		$username=$_SESSION['username'];
		$trans="e_regular_holiday_overtime added to $e_no on $pp cutoff";
		$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
		$log_query=mysql_query($log_sql) or die(mysql_error());
		}
		
	//---special holiday---	
		if(isset($_REQUEST['e_special_holiday'])){
		$e_special_holiday=round($_REQUEST['e_special_holiday'],2);
		$e_special_holiday_final=round($per_hour*$e_special_holiday*1.3,2);
		$sxx="update payroll set e_special_holiday=$e_special_holiday,
								 e_special_holiday_final=$e_special_holiday_final
								 where e_no='$e_no' and payroll_period='$pp'";
		mysql_query($sxx) or die(mysql_error());
		
		//---logs entry---
		$username=$_SESSION['username'];
		$trans="e_special_holiday added to $e_no on $pp cutoff";
		$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
		$log_query=mysql_query($log_sql) or die(mysql_error());
		}
		
	//---special holiday overtime---	
		if(isset($_REQUEST['e_special_holiday_overtime'])){
		$e_special_holiday_overtime=round($_REQUEST['e_special_holiday_overtime'],2);
		$e_special_holiday_overtime_final=round($per_hour*$e_special_holiday_overtime*1.69,2);
		$sxx="update payroll set e_special_holiday_overtime=$e_special_holiday_overtime,
								 e_special_holiday_overtime_final=$e_special_holiday_overtime_final
								 where e_no='$e_no' and payroll_period='$pp'";
		mysql_query($sxx) or die(mysql_error());
		
		//---logs entry---
		$username=$_SESSION['username'];
		$trans="e_special_holiday_overtime added to $e_no on $pp cutoff";
		$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
		$log_query=mysql_query($log_sql) or die(mysql_error());
		}
		
	//---sick leave---	
		if(isset($_REQUEST['e_sick_leave'])){
		$e_sick_leave=round($_REQUEST['e_sick_leave'],2);
		$e_sick_leave_final=round($per_day*$e_sick_leave,2);
		$sxx="update payroll set e_sick_leave=$e_sick_leave,
								 e_sick_leave_final=$e_sick_leave_final
								 where e_no='$e_no' and payroll_period='$pp'";
		mysql_query($sxx) or die(mysql_error());
		
		//---logs entry---
		$username=$_SESSION['username'];
		$trans="e_sick_leave added to $e_no on $pp cutoff";
		$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
		$log_query=mysql_query($log_sql) or die(mysql_error());
		}
	
	//---vacation leave---	
		if(isset($_REQUEST['e_vacation_leave'])){
		$e_vacation_leave=round($_REQUEST['e_vacation_leave'],2);
		$e_vacation_leave_final=round($per_day*$e_vacation_leave,2);
		$sxx="update payroll set e_vacation_leave=$e_vacation_leave,
								 e_vacation_leave_final=$e_vacation_leave_final
								 where e_no='$e_no' and payroll_period='$pp'";
		mysql_query($sxx) or die(mysql_error());
		
		//---logs entry---
		$username=$_SESSION['username'];
		$trans="e_vacation_leave added to $e_no on $pp cutoff";
		$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
		$log_query=mysql_query($log_sql) or die(mysql_error());
		}
		
	//---solo parent leave---	
		if(isset($_REQUEST['e_solo_parent_leave'])){
		$e_solo_parent_leave=round($_REQUEST['e_solo_parent_leave'],2);
		$e_solo_parent_leave_final=round($per_day*$e_solo_parent_leave,2);
		$sxx="update payroll set e_solo_parent_leave=$e_solo_parent_leave,
								 e_solo_parent_leave_final=$e_solo_parent_leave_final
								 where e_no='$e_no' and payroll_period='$pp'";
		mysql_query($sxx) or die(mysql_error());
		
		//---logs entry---
		$username=$_SESSION['username'];
		$trans="e_solo_parent_leave added to $e_no on $pp cutoff";
		$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
		$log_query=mysql_query($log_sql) or die(mysql_error());
		}	
		
	//---Lates---	
		if(isset($_REQUEST['e_lates'])){
		$e_lates=round($_REQUEST['e_lates'],2);
		$e_lates_final=round($per_min*$e_lates,2);
		$sxx="update payroll set e_lates=$e_lates,
								 e_lates_final=$e_lates_final
								 where e_no='$e_no' and payroll_period='$pp'";
		mysql_query($sxx) or die(mysql_error());
		
		//---logs entry---
		$username=$_SESSION['username'];
		$trans="e_lates added to $e_no on $pp cutoff";
		$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
		$log_query=mysql_query($log_sql) or die(mysql_error());
		}
		
	//---Absences---	
		if(isset($_REQUEST['e_absences'])){
		$e_absences=round($_REQUEST['e_absences'],2);
		$e_absences_final=round($per_hour*$e_absences,2);
		$sxx="update payroll set e_absences=$e_absences,
								 e_absences_final=$e_absences_final
								 where e_no='$e_no' and payroll_period='$pp'";
		mysql_query($sxx) or die(mysql_error());
		
		//---logs entry---
		$username=$_SESSION['username'];
		$trans="e_absences added to $e_no on $pp cutoff";
		$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
		$log_query=mysql_query($log_sql) or die(mysql_error());
		}
		
	//---Undertime---	
		if(isset($_REQUEST['e_undertime'])){
		$e_undertime=round($_REQUEST['e_undertime'],2);
		$e_undertime_final=round($per_hour*$e_undertime,2);
		$sxx="update payroll set e_undertime=$e_undertime,
								 e_undertime_final=$e_undertime_final
								 where e_no='$e_no' and payroll_period='$pp'";
		mysql_query($sxx) or die(mysql_error());
		
		//---logs entry---
		$username=$_SESSION['username'];
		$trans="e_undertime added to $e_no on $pp cutoff";
		$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
		$log_query=mysql_query($log_sql) or die(mysql_error());
		}
		
		//---Meal Allowance---	
		if(isset($_REQUEST['e_allowance_meal'])){
		$e_allowance_meal=round($_REQUEST['e_allowance_meal'],2);
		$sxx="update payroll set e_allowance_meal=$e_allowance_meal
								 where e_no='$e_no' and payroll_period='$pp'";
		
		mysql_query($sxx) or die(mysql_error());
		
		//---logs entry---
		$username=$_SESSION['username'];
		$trans="e_allowance_meal added to $e_no on $pp cutoff";
		$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
		$log_query=mysql_query($log_sql) or die(mysql_error());
		}
		
 }	   
//---Lates Update Script---

//---Individual Update---
if(isset($_REQUEST['update']))
   { 
     $sx="select step3 from payroll order by payroll_period desc";
     $qx=mysql_query($sx) or die(mysql_error());
     $rx=mysql_fetch_assoc($qx);

	 $e_no1=$_REQUEST['e_no'];
	 $payroll_period=$_REQUEST['payroll_period'];
	 $s1="select * from payroll where e_no='$e_no1' and payroll_period='$payroll_period'";
     $q1=mysql_query($s1) or die(mysql_error());
     $r1=mysql_fetch_assoc($q1);  
	   
	    $per_day=$r1['e_basic_pay'];
		$per_hour=$r1['e_basic_pay']/8;
		$per_min=$r1['e_basic_pay']/8/60;
		
	    echo "$per_day / day | $per_hour / hr | $per_min / min<br>ID: ".$_REQUEST['e_no']." | ".$_REQUEST['e_lname'].", ".$_REQUEST['e_fname']."<br><br>
	          
			  <table class='small' align='center'>
			    <tr>
				
				 <td width='210'>
							 Total Cutoff Hours (R.HRS)<br>
							 <span class='text-danger'><strong>Time: ".number_format($r1['e_total_cuttoff_hours'],2)."</strong></span>&nbsp;&nbsp;&nbsp;
							 <span class='text-primary'><strong>Value: ".number_format($r1['e_total_cuttoff_hours_final'],2)."</strong></span>
						  <form method='get'>
							<input name='search' type='hidden' value='".$_REQUEST['search']."'>
							<input name='e_no' type='hidden' value='".$r1['e_no']."'>
							<input name='e_fname' type='hidden' value='".$_REQUEST['e_fname']."'>
							<input name='e_lname' type='hidden' value='".$_REQUEST['e_lname']."'>
							<input name='payroll_period' type='hidden' value='".$_REQUEST['payroll_period']."'>
							<input name='per_day' type='hidden' value='$per_day'>
							<input name='update' type='hidden' value=''>
							<input name='e_total_cuttoff_hours' type='number' step='any'>";
							if($access['a7']==1){ if($rx['step3']==0) { echo "<input name='update_workhours' type='submit' value='Update'>"; } } 
					echo "</form>
				 </td>
				 
				 <td width='210'>
							 Overtime (OT)<br>
							 <span class='text-danger'><strong>Time: ".number_format($r1['e_overtime'],2)."</strong></span>&nbsp;&nbsp;&nbsp;
							 <span class='text-primary'><strong>Value: ".number_format($r1['e_overtime_final'],2)."</strong></span>
						  <form method='get'>
							<input name='search' type='hidden' value='".$_REQUEST['search']."'>
							<input name='e_no' type='hidden' value='".$r1['e_no']."'>
							<input name='e_fname' type='hidden' value='".$_REQUEST['e_fname']."'>
							<input name='e_lname' type='hidden' value='".$_REQUEST['e_lname']."'>
							<input name='payroll_period' type='hidden' value='".$_REQUEST['payroll_period']."'>
							<input name='per_day' type='hidden' value='$per_day'>
							<input name='update' type='hidden' value=''>
							<input name='e_overtime' type='number' step='any'>";
							if($access['a7']==1){ if($rx['step3']==0) { echo "<input name='update_workhours' type='submit' value='Update'>"; } }
					echo "</form>
				 </td>
				 
				 <td width='210'>
							 Restday Pay (DOP)<br>
							 <span class='text-danger'><strong>Time: ".number_format($r1['e_restday_pay'],2)."</strong></span>&nbsp;&nbsp;&nbsp;
							 <span class='text-primary'><strong>Value: ".number_format($r1['e_restday_pay_final'],2)."</strong></span>
						  <form method='get'>
							<input name='search' type='hidden' value='".$_REQUEST['search']."'>
							<input name='e_no' type='hidden' value='".$r1['e_no']."'>
							<input name='e_fname' type='hidden' value='".$_REQUEST['e_fname']."'>
							<input name='e_lname' type='hidden' value='".$_REQUEST['e_lname']."'>
							<input name='payroll_period' type='hidden' value='".$_REQUEST['payroll_period']."'>
							<input name='per_day' type='hidden' value='$per_day'>
							<input name='update' type='hidden' value=''>
							<input name='e_restday_pay' type='number' step='any'>";
							if($access['a7']==1){ if($rx['step3']==0) { echo "<input name='update_workhours' type='submit' value='Update'>"; } }
					echo "</form>
				 </td>
				 
			     <td width='210'>
						 Restday Pay / OT (DOP / OT)<br>
						<span class='text-danger'><strong>Time: ".number_format($r1['e_restday_pay_overtime'],2)."</strong></span>&nbsp;&nbsp;&nbsp;
						<span class='text-primary'><strong>Value: ".number_format($r1['e_restday_pay_overtime_final'],2)."</strong></span>
					  <form method='get'>
						<input name='search' type='hidden' value='".$_REQUEST['search']."'>
						<input name='e_no' type='hidden' value='".$r1['e_no']."'>
						<input name='e_fname' type='hidden' value='".$_REQUEST['e_fname']."'>
						<input name='e_lname' type='hidden' value='".$_REQUEST['e_lname']."'>
						<input name='payroll_period' type='hidden' value='".$_REQUEST['payroll_period']."'>
						<input name='per_day' type='hidden' value='$per_day'>
						<input name='update' type='hidden' value=''>
						<input name='e_restday_pay_overtime' type='number' step='any'>";
						if($access['a7']==1){ if($rx['step3']==0) { echo "<input name='update_workhours' type='submit' value='Update'>"; } }
					 echo "</form>
			     </td>
				 
				 <td width='210'>
						 Night Shift (NS)<br>
						 <span class='text-danger'><strong>Time: ".number_format($r1['e_nightshift'],2)."</strong></span>&nbsp;&nbsp;&nbsp;
						 <span class='text-primary'><strong>Value: ".number_format($r1['e_nightshift_final'],2)."</strong></span>
					  <form method='get'>
					    <input name='search' type='hidden' value='".$_REQUEST['search']."'>
						<input name='e_no' type='hidden' value='".$r1['e_no']."'>
						<input name='e_fname' type='hidden' value='".$_REQUEST['e_fname']."'>
						<input name='e_lname' type='hidden' value='".$_REQUEST['e_lname']."'>
						<input name='payroll_period' type='hidden' value='".$_REQUEST['payroll_period']."'>
						<input name='per_day' type='hidden' value='$per_day'>
						<input name='update' type='hidden' value=''>
						<input name='e_nightshift' type='number' step='any'>";
						if($access['a7']==1){ if($rx['step3']==0) { echo "<input name='update_workhours' type='submit' value='Update'>"; } }
					 echo "</form>
			     </td>
				 
				 <td width='210'>
						 Night Shift Overtime (NS / OT)<br>
						 <span class='text-danger'><strong>Time: ".number_format($r1['e_overtime_nightshift'],2)."</strong></span>&nbsp;&nbsp;&nbsp;
						 <span class='text-primary'><strong>Value: ".number_format($r1['e_overtime_nightshift_final'],2)."</strong></span>
					  <form method='get'>
					   <input name='search' type='hidden' value='".$_REQUEST['search']."'>
						<input name='e_no' type='hidden' value='".$r1['e_no']."'>
						<input name='e_fname' type='hidden' value='".$_REQUEST['e_fname']."'>
						<input name='e_lname' type='hidden' value='".$_REQUEST['e_lname']."'>
						<input name='payroll_period' type='hidden' value='".$_REQUEST['payroll_period']."'>
						<input name='per_day' type='hidden' value='$per_day'>
						<input name='update' type='hidden' value=''>
						<input name='e_overtime_nightshift' type='number' step='any'>";
						if($access['a7']==1){ if($rx['step3']==0) { echo "<input name='update_workhours' type='submit' value='Update'>"; } }
					 echo "</form>
			     </td>
				
				</tr>
				 
				 
				 
				<tr>
				
				 <td>
						 Regular Holiday (RH)<br>
						 <span class='text-danger'><strong>Time: ".number_format($r1['e_regular_holiday'],2)."</strong></span>&nbsp;&nbsp;&nbsp;
						 <span class='text-primary'><strong>Value: ".number_format($r1['e_regular_holiday_final'],2)."</strong></span>
					   <form method='get'>
					    <input name='search' type='hidden' value='".$_REQUEST['search']."'>
						<input name='e_no' type='hidden' value='".$r1['e_no']."'>
						<input name='e_fname' type='hidden' value='".$_REQUEST['e_fname']."'>
						<input name='e_lname' type='hidden' value='".$_REQUEST['e_lname']."'>
						<input name='payroll_period' type='hidden' value='".$_REQUEST['payroll_period']."'>
						<input name='per_day' type='hidden' value='$per_day'>
						<input name='update' type='hidden' value=''>
						<input name='e_regular_holiday' type='number' step='any'>";
						if($access['a7']==1){ if($rx['step3']==0) {  echo "<input name='update_workhours' type='submit' value='Update'>"; } }
					 echo "</form>
			     </td>
				 
				 <td>
						 Regular Holiday Overtime (RH / OT)<br>
						 <span class='text-danger'><strong>Time: ".number_format($r1['e_regular_holiday_overtime'],2)."</strong></span>&nbsp;&nbsp;&nbsp;
						 <span class='text-primary'><strong>Value: ".number_format($r1['e_regular_holiday_overtime_final'],2)."</strong></span>
					   <form method='get'>
					    <input name='search' type='hidden' value='".$_REQUEST['search']."'>
						<input name='e_no' type='hidden' value='".$r1['e_no']."'>
						<input name='e_fname' type='hidden' value='".$_REQUEST['e_fname']."'>
						<input name='e_lname' type='hidden' value='".$_REQUEST['e_lname']."'>
						<input name='payroll_period' type='hidden' value='".$_REQUEST['payroll_period']."'>
						<input name='per_day' type='hidden' value='$per_day'>
						<input name='update' type='hidden' value=''>
						<input name='e_regular_holiday_overtime' type='number' step='any'>";
						if($access['a7']==1){ if($rx['step3']==0) { echo "<input name='update_workhours' type='submit' value='Update'>"; } }
					 echo "</form>
			     </td>
				 
				 <td>
						 Special Holiday (SH)<br>
						 <span class='text-danger'><strong>Time: ".number_format($r1['e_special_holiday'],2)."</strong></span>&nbsp;&nbsp;&nbsp;
						 <span class='text-primary'><strong>Value: ".number_format($r1['e_special_holiday_final'],2)."</strong></span>
					   <form method='get'>
					   <input name='search' type='hidden' value='".$_REQUEST['search']."'>
						<input name='e_no' type='hidden' value='".$r1['e_no']."'>
						<input name='e_fname' type='hidden' value='".$_REQUEST['e_fname']."'>
						<input name='e_lname' type='hidden' value='".$_REQUEST['e_lname']."'>
						<input name='payroll_period' type='hidden' value='".$_REQUEST['payroll_period']."'>
						<input name='per_day' type='hidden' value='$per_day'>
						<input name='update' type='hidden' value=''>
						<input name='e_special_holiday' type='number' step='any'>";
						if($access['a7']==1){ if($rx['step3']==0) { echo "<input name='update_workhours' type='submit' value='Update'>"; } }
				echo "</form>
			     </td>
				 
				 <td>
						 Special Holiday Overtime (SH / OT)<br>
						 <span class='text-danger'><strong>Time: ".number_format($r1['e_special_holiday_overtime'],2)."</strong></span>&nbsp;&nbsp;&nbsp;
						 <span class='text-primary'><strong>Value: ".number_format($r1['e_special_holiday_overtime_final'],2)."</strong></span>
					   <form method='get'>
					   <input name='search' type='hidden' value='".$_REQUEST['search']."'>
						<input name='e_no' type='hidden' value='".$r1['e_no']."'>
						<input name='e_fname' type='hidden' value='".$_REQUEST['e_fname']."'>
						<input name='e_lname' type='hidden' value='".$_REQUEST['e_lname']."'>
						<input name='payroll_period' type='hidden' value='".$_REQUEST['payroll_period']."'>
						<input name='per_day' type='hidden' value='$per_day'>
						<input name='update' type='hidden' value=''>
						<input name='e_special_holiday_overtime' type='number' step='any'>";
						if($access['a7']==1){ if($rx['step3']==0) { echo "<input name='update_workhours' type='submit' value='Update'>"; } }
				echo "</form>
			     </td>
				 
				 <td>
						 Sick Leave (SL)<br>
						 <span class='text-danger'><strong>Time: ".number_format($r1['e_sick_leave'],2)."</strong></span>&nbsp;&nbsp;&nbsp;
						 <span class='text-primary'><strong>Value: ".number_format($r1['e_sick_leave_final'],2)."</strong></span>
					   <form method='get'>
					   <input name='search' type='hidden' value='".$_REQUEST['search']."'>
						<input name='e_no' type='hidden' value='".$r1['e_no']."'>
						<input name='e_fname' type='hidden' value='".$_REQUEST['e_fname']."'>
						<input name='e_lname' type='hidden' value='".$_REQUEST['e_lname']."'>
						<input name='payroll_period' type='hidden' value='".$_REQUEST['payroll_period']."'>
						<input name='per_day' type='hidden' value='$per_day'>
						<input name='update' type='hidden' value=''>
						<input name='e_sick_leave' type='number' step='any'>";
						if($access['a7']==1){ if($rx['step3']==0) { echo "<input name='update_workhours' type='submit' value='Update'>"; } }
				echo "</form>
			     </td>
				 
				 <td>
						 Vacation Leave (VL)<br>
						 <span class='text-danger'><strong>Time: ".number_format($r1['e_vacation_leave'],2)."</strong></span>&nbsp;&nbsp;&nbsp;
						 <span class='text-primary'><strong>Value: ".number_format($r1['e_vacation_leave_final'],2)."</strong></span>
					   <form method='get'>
					   <input name='search' type='hidden' value='".$_REQUEST['search']."'>
						<input name='e_no' type='hidden' value='".$r1['e_no']."'>
						<input name='e_fname' type='hidden' value='".$_REQUEST['e_fname']."'>
						<input name='e_lname' type='hidden' value='".$_REQUEST['e_lname']."'>
						<input name='payroll_period' type='hidden' value='".$_REQUEST['payroll_period']."'>
						<input name='per_day' type='hidden' value='$per_day'>
						<input name='update' type='hidden' value=''>
						<input name='e_vacation_leave' type='number' step='any'>";
						if($access['a7']==1){ if($rx['step3']==0) { echo "<input name='update_workhours' type='submit' value='Update'>"; } }
				echo "</form>
			     </td>
				 
				</tr>
				
				
				<tr>
				
				 <td>
						 Lates / Minutes<br>
						 <span class='text-danger'><strong>Time: ".number_format($r1['e_lates'],2)."</strong></span>&nbsp;&nbsp;&nbsp;
						 <span class='text-primary'><strong>Value: ".number_format($r1['e_lates_final'],2)."</strong></span>
					   <form method='get'>
					   <input name='search' type='hidden' value='".$_REQUEST['search']."'>
						<input name='e_no' type='hidden' value='".$r1['e_no']."'>
						<input name='e_fname' type='hidden' value='".$_REQUEST['e_fname']."'>
						<input name='e_lname' type='hidden' value='".$_REQUEST['e_lname']."'>
						<input name='payroll_period' type='hidden' value='".$_REQUEST['payroll_period']."'>
						<input name='per_day' type='hidden' value='$per_day'>
						<input name='update' type='hidden' value=''>
						<input name='e_lates' type='number' step='any'>";
						if($access['a7']==1){ if($rx['step3']==0) { echo "<input name='update_workhours' type='submit' value='Update'>"; } }
				echo "</form>
			     </td>
				 
				 <td>
						 Absent / Hours<br>
						 <span class='text-danger'><strong>Time: ".number_format($r1['e_absences'],2)."</strong></span>&nbsp;&nbsp;&nbsp;
						 <span class='text-primary'><strong>Value: ".number_format($r1['e_absences_final'],2)."</strong></span>
					   <form method='get'>
					   <input name='search' type='hidden' value='".$_REQUEST['search']."'>
						<input name='e_no' type='hidden' value='".$r1['e_no']."'>
						<input name='e_fname' type='hidden' value='".$_REQUEST['e_fname']."'>
						<input name='e_lname' type='hidden' value='".$_REQUEST['e_lname']."'>
						<input name='payroll_period' type='hidden' value='".$_REQUEST['payroll_period']."'>
						<input name='per_day' type='hidden' value='$per_day'>
						<input name='update' type='hidden' value=''>
						<input name='e_absences' type='number' step='any'>";
						if($access['a7']==1){ if($rx['step3']==0) { echo "<input name='update_workhours' type='submit' value='Update'>"; } }
				 echo "</form>
			     </td>
				 
				 <td>
						 Undertime / Hours<br>
						 <span class='text-danger'><strong>Time: ".number_format($r1['e_undertime'],2)."</strong></span>&nbsp;&nbsp;&nbsp;
						 <span class='text-primary'><strong>Value: ".number_format($r1['e_undertime_final'],2)."</strong></span>
					   <form method='get'>
					   <input name='search' type='hidden' value='".$_REQUEST['search']."'>
						<input name='e_no' type='hidden' value='".$r1['e_no']."'>
						<input name='e_fname' type='hidden' value='".$_REQUEST['e_fname']."'>
						<input name='e_lname' type='hidden' value='".$_REQUEST['e_lname']."'>
						<input name='payroll_period' type='hidden' value='".$_REQUEST['payroll_period']."'>
						<input name='per_day' type='hidden' value='$per_day'>
						<input name='update' type='hidden' value=''>
						<input name='e_undertime' type='number' step='any'>";
						if($access['a7']==1){ if($rx['step3']==0) { echo "<input name='update_workhours' type='submit' value='Update'>"; } }
				 echo "</form>
			     </td>
				 
				 
				 <td>
						 Solo Parent Leave (VL)<br>
						 <span class='text-danger'><strong>Time: ".number_format($r1['e_solo_parent_leave'],2)."</strong></span>&nbsp;&nbsp;&nbsp;
						 <span class='text-primary'><strong>Value: ".number_format($r1['e_solo_parent_leave_final'],2)."</strong></span>
					   <form method='get'>
					   <input name='search' type='hidden' value='".$_REQUEST['search']."'>
						<input name='e_no' type='hidden' value='".$r1['e_no']."'>
						<input name='e_fname' type='hidden' value='".$_REQUEST['e_fname']."'>
						<input name='e_lname' type='hidden' value='".$_REQUEST['e_lname']."'>
						<input name='payroll_period' type='hidden' value='".$_REQUEST['payroll_period']."'>
						<input name='per_day' type='hidden' value='$per_day'>
						<input name='update' type='hidden' value=''>
						<input name='e_solo_parent_leave' type='number' step='any'>";
						if($access['a7']==1){ if($rx['step3']==0) { echo "<input name='update_workhours' type='submit' value='Update'>"; } }
				 echo "</form>
					 
			     </td>
				 
				 
				 
				 <td>
						 Meal Allowance (Input Total Amount Only)<br>
						 <span class='text-danger'><strong>Count: ".number_format($r1['e_allowance_meal'],2)."</strong></span>&nbsp;&nbsp;&nbsp;
						 <span class='text-primary'><strong>Value: ".number_format($r1['e_allowance_meal'],2)."</strong></span>
					   <form method='get'>
					   <input name='search' type='hidden' value='".$_REQUEST['search']."'>
						<input name='e_no' type='hidden' value='".$r1['e_no']."'>
						<input name='e_fname' type='hidden' value='".$_REQUEST['e_fname']."'>
						<input name='e_lname' type='hidden' value='".$_REQUEST['e_lname']."'>
						<input name='payroll_period' type='hidden' value='".$_REQUEST['payroll_period']."'>
						<input name='per_day' type='hidden' value='$per_day'>
						<input name='update' type='hidden' value=''>
						<input name='e_allowance_meal' type='number' step='any'>";
						if($access['a7']==1){ if($rx['step3']==0) { echo "<input name='update_workhours' type='submit' value='Update'>"; } }
				 echo "</form>
					 
			     </td>
				 
				 
				 
				 
				 
				 
				</tr>
				
				
			</table>
			   
			   <br>";
   }
//---Individual Update---  

//---Main query---
?>
<br>
<form method='get'>
<input name='payroll_period' type='hidden' value='<?php echo $_REQUEST['payroll_period'];?>'>
&nbsp;<input name='search' type='text' placeholder='INPUT LASTNAME'>
<input type='submit' value='search'>
</form>
<?php

if(isset($_REQUEST['search']))
  { $search=$_REQUEST['search']; 
    $s="select e_no,e_fname,e_lname,e_mname,e_basic_pay,e_company,e_department from employee where (e_lname like '%$search%' or e_fname like '%$search%') and e_employment_status!='Resigned' and e_employment_status!='NotConnected' and e_employment_status!='Agency' order by e_company,e_department,e_lname asc";
  }
else
  { $search=""; 
    $s="select e_no,e_fname,e_lname,e_mname,e_basic_pay,e_company,e_department from employee where e_employment_status!='Resigned' and e_employment_status!='NotConnected' and e_employment_status!='Agency' order by e_lname asc";
  }
$q=mysql_query($s) or die(mysql_error());
$r=mysql_fetch_assoc($q);
$records_found=mysql_num_rows($q);

echo "<table align='center' class='small' border='1'>
       <tr align='center' class='w3-blue'>
	     <td>ID No.</td>
		 <td>Name</td>
		 <td>Company</td>
		 <td>Department</td>
		 <td>Rate / Day</td>
		 <td width='80'>Payroll Date</td>
		 <td width='60'>R/HRS</td>
		 <td width='60'>OT</td>
		 <td width='60'>DOP</td>
		 <td width='60'>DOP OT</td>
		 <td width='60'>NS</td>
		 <td width='60'>NS OT</td>
		 <td width='60'>RH</td>
		 <td width='60'>RH OT</td>
		 <td width='60'>SH</td>
		 <td width='60'>SH OT</td>
		 <td width='60'>SL</td>
		 <td width='60'>VL</td>
		 <td width='60'>SPL</td>
		 <td width='60'>Lates</td>
		 <td width='60'>Absent</td>
		 <td width='60'>Meal</td>
		 <td>Action</td>
	   </tr>";
        
do{
  $payroll_period=$_REQUEST['payroll_period'];
  $e_no=$r['e_no'];
  $sx="select * from payroll where e_no='$e_no' and payroll_period='$payroll_period'";	
  $qx=mysql_query($sx) or die(mysql_error());
  $rx=mysql_fetch_assoc($qx);
  
  $rate_day=number_format($r['e_basic_pay']/26,2);
  echo "<tr align='center' class='w3-hover-lime'>
	     <td>&nbsp;".$r['e_no']."&nbsp;</td>
		 <td align='left'>&nbsp;".$r['e_lname'].", ".$r['e_fname']." ".substr($r['e_mname'],0,1).".</td>
		 <td>&nbsp;".$r['e_company']."&nbsp;</td>
		 <td>&nbsp;".$r['e_department']."&nbsp;</td>
		 <td>$rate_day</td>
	     <td>".date('m/d/Y',strtotime($_REQUEST['payroll_period']))."</td>";
		 
	   if($rx['e_total_cuttoff_hours_final']==0)
	     { echo "<td class='bg-danger'>".number_format($rx['e_total_cuttoff_hours_final'],2)."</td>"; } 
    else { echo "<td class='bg-info'>".number_format($rx['e_total_cuttoff_hours_final'],2)."</td>"; }
		 
	   if($rx['e_overtime_final']!=0)
	     { echo "<td class='bg-info'>".number_format($rx['e_overtime_final'],2)."</td>"; }
	 else{ echo "<td>".number_format($rx['e_overtime_final'],2)."</td>"; }
	 
	   if($rx['e_restday_pay_final']!=0)
	     { echo "<td class='bg-info'>".number_format($rx['e_restday_pay_final'],2)."</td>"; }
	 else{ echo "<td>".number_format($rx['e_restday_pay_final'],2)."</td>"; }
           
	   if($rx['e_restday_pay_overtime_final']!=0)	   
		 { echo "<td class='bg-info'>".number_format($rx['e_restday_pay_overtime_final'],2)."</td>"; }
     else{ echo "<td>".number_format($rx['e_restday_pay_overtime_final'],2)."</td>"; }
	
       if($rx['e_nightshift_final']!=0)
	     { echo "<td class='bg-info'>".number_format($rx['e_nightshift_final'],2)."</td>"; } 
	else { echo "<td>".number_format($rx['e_nightshift_final'],2)."</td>"; }
	
       if($rx['e_overtime_nightshift_final']!=0)
	     { echo "<td class='bg-info'>".number_format($rx['e_overtime_nightshift_final'],2)."</td>"; }
	else { echo "<td>".number_format($rx['e_overtime_nightshift_final'],2)."</td>"; }   
		 
	   if($rx['e_regular_holiday_final']!=0) 
		 { echo "<td class='bg-info'>".number_format($rx['e_regular_holiday_final'],2)."</td>"; }
	 else{ echo "<td>".number_format($rx['e_regular_holiday_final'],2)."</td>"; }
		   
	   if($rx['e_regular_holiday_overtime_final']!=0)	   
		 { echo "<td class='bg-info'>".number_format($rx['e_regular_holiday_overtime_final'],2)."</td>"; }
	 else{ echo "<td>".number_format($rx['e_regular_holiday_overtime_final'],2)."</td>"; }
           
	   if($rx['e_special_holiday_final']!=0)	   
		 { echo "<td class='bg-info'>".number_format($rx['e_special_holiday_final'],2)."</td>"; }
	 else{ echo "<td>".number_format($rx['e_special_holiday_final'],2)."</td>"; }
           
	   if($rx['e_special_holiday_overtime_final']!=0)	   
		 { echo "<td class='bg-info'>".number_format($rx['e_special_holiday_overtime_final'],2)."</td>"; }
	 else{ echo "<td>".number_format($rx['e_special_holiday_overtime_final'],2)."</td>"; }
   
       if($rx['e_sick_leave_final']!=0)
         { echo "<td class='bg-info'>".number_format($rx['e_sick_leave_final'],2)."</td>"; }
     else{ echo "<td>".number_format($rx['e_sick_leave_final'],2)."</td>"; }
     
	   if($rx['e_vacation_leave_final']!=0)
	     { echo "<td class='bg-info'>".number_format($rx['e_vacation_leave_final'],2)."</td>"; }
	 else{ echo "<td>".number_format($rx['e_vacation_leave_final'],2)."</td>"; }
	 
	 if($rx['e_solo_parent_leave_final']!=0)
	     { echo "<td class='bg-info'>".number_format($rx['e_solo_parent_leave_final'],2)."</td>"; }
	 else{ echo "<td>".number_format($rx['e_solo_parent_leave_final'],2)."</td>"; }
	 
	 if($rx['e_lates_final']!=0)
         { echo "<td class='bg-info'>".number_format($rx['e_lates_final'],2)."</td>"; }
     else{ echo "<td>".number_format($rx['e_lates_final'],2)."</td>"; }
     
	   if($rx['e_absences_final']!=0)
	     { echo "<td class='bg-info'>".number_format($rx['e_absences_final'],2)."</td>"; }
	 else{ echo "<td>".number_format($rx['e_absences_final'],2)."</td>"; }
	 
	 if($rx['e_allowance_meal']!=0)
	     { echo "<td class='bg-info'>".number_format($rx['e_allowance_meal'],2)."</td>"; }
	 else{ echo "<td>".number_format($rx['e_allowance_meal'],2)."</td>"; }
	 
	 
   echo "<td>"; ?>
		  <form method='get'>
		  <input name="search" type="hidden" value="<?php echo $_REQUEST['search']; ?>">
		  <input name="e_no" type="hidden" value="<?php echo $r['e_no']; ?>">
		  <input name="e_fname" type="hidden" value="<?php echo $r['e_fname']; ?>">
		  <input name="e_lname" type="hidden" value="<?php echo $r['e_lname']; ?>">
		  <input name="payroll_period" type="hidden" value="<?php echo $payroll_period; ?>">
		  <input name="update" type="submit" value="Update Work Hours">
		  </form>
          </td>
	   </tr>

<?php	   
}while($r=mysql_fetch_assoc($q));
echo "</table>";
?>
</body>