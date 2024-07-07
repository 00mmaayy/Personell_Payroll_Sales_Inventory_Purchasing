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

<style>
@page { size 8.5in 11in; margin: 2cm }
div.page { page-break-after: always }
</style>
<?php
		 //TOTAL TIME REPORT FOR EACH EMPLOYEE START
		 $sdate=$_REQUEST['sdate'];
		 $edate=$_REQUEST['edate'];
		 $pp=$_REQUEST['payroll_period'];
         $sx1="select * from payroll where payroll_period='$pp' order by e_department asc, e_no asc";
		 $qx1=mysql_query($sx1) or die(mysql_error());
		 $rx1=mysql_fetch_assoc($qx1);
		 $count=mysql_num_rows($qx1);
		 
		 echo "<table border='1'>
		        <tr align='center'><td colspan='20'>DTR Period: ".date('m/d/Y',strtotime($_REQUEST['sdate']))." - ".date('m/d/Y',strtotime($_REQUEST['edate']))."</td></tr>
				<tr align='center' class='w3-small w3-blue'>
				<td><small><strong>COMP</strong></td>
				<td><small><strong>DEPT</strong></td>
				<td><small><strong>ID</strong></td>
				<td><small><strong>NAME</strong></td>
				<td colspan='2'><small><strong>&nbsp;REGULAR DAY&nbsp;</strong></td>
				<td colspan='2'><small><strong>&nbsp;OVERTIME&nbsp;</strong></td>
			    <td colspan='2'><small><strong>&nbsp;REGULAR HOLIDAY&nbsp;</strong></td>
				<td colspan='2'><small><strong>&nbsp;REG HOLIDAY OT&nbsp;</strong></td>
				<td colspan='2'><small><strong>&nbsp;SPECIAL HOLIDAY&nbsp;</strong></td>
				<td colspan='2'><small><strong>&nbsp;SPECIAL HOLIDAY OT&nbsp;</strong></td>
				<td colspan='2'><small><strong>&nbsp;RESTDAY&nbsp;</strong></td>
				<td colspan='2'><small><strong>&nbsp;RESTDAY OT&nbsp;</strong></td>
				</tr>
				<tr class='w3-tiny w3-pale-blue' align='center'>
					<td></td><td></td><td></td><td>$count Employees</td>
					<td>HOUR</td><td>RATE</td><td>HOUR</td><td>RATE</td>
					<td>HOUR</td><td>RATE</td><td>HOUR</td><td>RATE</td>
					<td>HOUR</td><td>RATE</td><td>HOUR</td><td>RATE</td>
					<td>HOUR</td><td>RATE</td><td>HOUR</td><td>RATE</td>
				</tr>";
		 
		 do{
			 $e_nox=$rx1['e_no'];
			 $sname="select e_fname,e_lname from employee where e_no='$e_nox'";
			 $qname=mysql_query($sname) or die(mysql_error());
			 $rname=mysql_fetch_assoc($qname);
			 
			 $s_sum="select sum(reg_day_time) as reg_day_time,
			                sum(reg_day_ot_time) as reg_day_ot_time,
							sum(reg_day_amount) as reg_day_amount, 
			                sum(reg_day_ot_amount) as reg_day_ot_amount,
							sum(reg_hol_time) as reg_hol_time, 
							sum(reg_hol_ot_time) as reg_hol_ot_time,
							sum(reg_hol_amount) as reg_hol_amount, 
							sum(reg_hol_ot_amount) as reg_hol_ot_amount,
							sum(spe_hol_time) as spe_hol_time,
							sum(spe_hol_ot_time) as spe_hol_ot_time,
							sum(spe_hol_amount) as spe_hol_amount,
							sum(spe_hol_ot_amount) as spe_hol_ot_amount,
							sum(restday_time) as restday_time,
							sum(restday_ot_time) as restday_ot_time, 
			                sum(restday_amount) as restday_amount,
							sum(restday_ot_amount) as restday_ot_amount 
							from dtr_log where e_no=$e_nox and date>='$sdate' and date<='$edate' ";
							
			 $q_sum=mysql_query($s_sum) or die(mysql_error());
			 $r_sum=mysql_fetch_assoc($q_sum);
			 
			 $reg_day_time=round($r_sum['reg_day_time']/60,2);
			 $reg_day_amount=round($r_sum['reg_day_amount'],2);
			 
			 $reg_day_ot_time=round($r_sum['reg_day_ot_time']/60,2);
			 $reg_day_ot_amount=round($r_sum['reg_day_ot_amount'],2);
			 
			 $reg_hol_time=round($r_sum['reg_hol_time']/60,2);
			 $reg_hol_amount=round($r_sum['reg_hol_amount'],2);
			 
			 $reg_hol_ot_time=round($r_sum['reg_hol_ot_time']/60,2);
			 $reg_hol_ot_amount=round($r_sum['reg_hol_ot_amount'],2);
			 
			 $spe_hol_time=round($r_sum['spe_hol_time']/60,2);
			 $spe_hol_amount=round($r_sum['spe_hol_amount'],2);
			 
			 $spe_hol_ot_time=round($r_sum['spe_hol_ot_time']/60,2);
			 $spe_hol_ot_amount=round($r_sum['spe_hol_ot_amount'],2);
			 
			 $restday_time=round($r_sum['restday_time']/60,2);
			 $restday_amount=round($r_sum['restday_amount'],2);
			 
			 $restday_ot_time=round($r_sum['restday_ot_time']/60,2);
			 $restday_ot_amount=round($r_sum['restday_ot_amount'],2);
			 
	    echo "<tr align='center' class='w3-hover-blue'>
					<td>&nbsp;<small>".$rx1['e_company']."</small>&nbsp;</td>
					<td>&nbsp;<small>".$rx1['e_department']."</small>&nbsp;</td>
					<td>&nbsp;<small>".$rx1['e_no']."&nbsp;</td>
					<td align='left'><small>&nbsp;".$rname['e_lname'].", ".$rname['e_fname']."&nbsp;</small></td>";
					
					
					if($reg_day_time==0){ echo "<td class='w3-pale-red' align='right'><small>$reg_day_time</small></td>"; } else { echo "<td align='right'><small>$reg_day_time</small></td>"; }
			   
			  echo "<td align='right'><small>".number_format($reg_day_amount,2)."</td>
					<td align='right'><small>$reg_day_ot_time</small></td>
					<td align='right'><small>".number_format($reg_day_ot_amount,2)."</td>
					<td align='right'><small>$reg_hol_time</small></td>
					<td align='right'><small>".number_format($reg_hol_amount,2)."</td>
					<td align='right'><small>$reg_hol_ot_time</small></td>
					<td align='right'><small>".number_format($reg_hol_ot_amount,2)."</td>
					<td align='right'><small>$spe_hol_time</small></td>
					<td align='right'><small>".number_format($spe_hol_amount,2)."</td>
					<td align='right'><small>$spe_hol_ot_time</small></td>
					<td align='right'><small>".number_format($spe_hol_ot_amount,2)."</td>
					<td align='right'><small>$restday_time</small></td>
					<td align='right'><small>".number_format($restday_amount,2)."</td>
					<td align='right'><small>$restday_ot_time</small></td>
					<td align='right'><small>".number_format($restday_ot_amount,2)."</td>
			 </tr>";
										
			 }while($rx1=mysql_fetch_assoc($qx1));
			//TOTAL TIME REPORT FOR EACH EMPLOYEE END

