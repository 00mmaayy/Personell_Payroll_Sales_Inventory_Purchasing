<?php 
session_start();
include('connection/conn.php');
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); }
?>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/w3.css">
<link rel="stylesheet" href="css/font-awesome.min.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>

<hr>

	<table>
	<tr valign='top'>
		<td width='30'></td>
		<td align='left'>
			<form method='get'>
			<?php 
			$qqq=mysql_query("SELECT payroll_period from payroll group by payroll_period order by payroll_period DESC") or die(mysql_error()); 
			$rrr=mysql_fetch_assoc($qqq);
			echo "<b class='w3-text-indigo'>Payroll Date Lists</b><br><br>";			
			do{ echo "<input type='radio' name='date' value='".$rrr['payroll_period']."'> &nbsp; ".date('F d, Y',strtotime($rrr['payroll_period']))."<br>";
			} while($rrr=mysql_fetch_assoc($qqq));
			?>
			<br>
			<input class='btn btn-info w3-tiny' type='submit' value='OPEN'>	
			</form>
		</td>
		
		<td width='15'></td>
		
		<td>
		<?php
		if(isset($_REQUEST['date']))
		{	
			$date=$_REQUEST['date'];
			$s="select a.e_no as e_no,
					a.e_company as e_company,
					a.e_department as e_department,
					a.e_netpay as e_netpay,
					a.payroll_period as payroll_period,
					a.e_total_cuttoff_hours_final as e_total_cuttoff_hours_final,
					a.e_overtime_final as e_overtime_final,
					a.e_restday_pay_final as e_restday_pay_final,
					a.e_restday_pay_overtime_final as e_restday_pay_overtime_final,
					a.e_nightshift_final as e_nightshift_final,
					a.e_overtime_nightshift_final as e_overtime_nightshift_final,
					a.e_regular_holiday_final as e_regular_holiday_final,
					a.e_regular_holiday_overtime_final as e_regular_holiday_overtime_final,
					a.e_special_holiday_final as e_special_holiday_final,
					a.e_special_holiday_overtime_final as e_special_holiday_overtime_final,
					a.e_sick_leave_final as e_sick_leave_final,
					a.e_vacation_leave_final as e_vacation_leave_final,
					a.e_add_allowance as e_add_allowance,
					a.e_allowance15 as e_allowance15,
					a.e_allowance30 as e_allowance30,
					a.e_lates_final as e_lates_final,
					a.e_absences_final as e_absences_final,
					a.e_undertime_final as e_undertime_final,
					a.e_sss as e_sss,
					a.e_pagibig as e_pagibig,
					a.e_philhealth as e_philhealth,
					a.e_tax as e_tax,
					a.e_ca as e_ca,
					a.e_pagibig_loan as e_pagibig_loan,
					a.e_pagibig_loan_calamity as e_pagibig_loan_calamity,
					a.e_salary_loan as e_salary_loan,
					a.e_sss_loan as e_sss_loan,
					a.e_other_charges as e_other_charges,
					a.e_veterans_loan as e_veterans_loan,
					a.e_over_in_previous_pay as e_over_in_previous_pay,
					b.e_lname as e_fname,
					b.e_fname as e_lname
				from payroll as a
				inner join employee as b
					on a.e_no=b.e_no
				where b.e_alcgroup='1' and a.payroll_period='$date'
				order by a.e_company, a.e_department, a.e_lname asc";
			$q=mysql_query($s) or die(mysql_error());
			$r=mysql_fetch_assoc($q);
			
			
			echo "<table border='1'>
					<tr><td colspan='11' align='center' class='w3-text-indigo w3-xlarge'>ALC GROUP SALARY SHARING<br>".date('F d, Y',strtotime($_REQUEST['date']))."</td></tr>
					<tr align='center' class='bg-success'>
						<td>COMPANY</td>
						<td>DEPT</td>
						<td>ID NO</td>
						<td>NAME</td>
						<td width='100'>GROSS PAY</td>
						<td width='100'>ALC</td>
						<td width='100'>CBI</td>
						<td width='100'>KAL</td>
						<td width='100'>KAT</td>
						<td width='100'>LH</td>
						<td width='100'>PAYROLL PERIOD</td>
					</tr>";
			
			do{    
							   $gross_pay=$r['e_total_cuttoff_hours_final']
										 +$r['e_overtime_final']
										 +$r['e_restday_pay_final']
										 +$r['e_restday_pay_overtime_final']
										 +$r['e_nightshift_final']
										 +$r['e_overtime_nightshift_final']
										 +$r['e_regular_holiday_final']
										 +$r['e_regular_holiday_overtime_final']
										 +$r['e_special_holiday_final']
										 +$r['e_special_holiday_overtime_final']
										 +$r['e_sick_leave_final']
										 +$r['e_vacation_leave_final']
										 +$r['e_add_allowance']
										 +$r['e_allowance15']
										 +$r['e_allowance30'];
										 //-$r['e_lates_final']
										 //-$r['e_absences_final']
										 //-$r['e_undertime_final'];
										 
							  //$deduction=$r['e_sss']
										 //+$r['e_pagibig']
										 //+$r['e_philhealth']
										 //+$r['e_tax']
										 //+$r['e_ca']
										 //+$r['e_pagibig_loan']
										 //+$r['e_pagibig_loan_calamity']
										 //+$r['e_salary_loan']
										 //+$r['e_sss_loan']
										 //+$r['e_other_charges']
										 //+$r['e_veterans_loan']
										 //+$r['e_over_in_previous_pay'];
							   
							   //$net_pay=round($gross_pay-$deduction,2);
							   $gross_pay1=round($gross_pay,2);
							   
							   
			
			echo "<tr>";
			echo "<td>".$r['e_company']."&nbsp;&nbsp;&nbsp;</td>
				  <td>".$r['e_department']."&nbsp;&nbsp;&nbsp;</td>
				  <td>".$r['e_no']."&nbsp;&nbsp;&nbsp;</td>
				  <td>".$r['e_lname'].", ".$r['e_fname']."&nbsp;&nbsp;</td>
				  <td align='right'>".number_format($gross_pay1,2)."</td>
				  <td align='right'>".number_format($gross_pay1/5,2)."</td>
				  <td align='right'>".number_format($gross_pay1/5,2)."</td>
				  <td align='right'>".number_format($gross_pay1/5,2)."</td>
				  <td align='right'>".number_format($gross_pay1/5,2)."</td>
				  <td align='right'>".number_format($gross_pay1/5,2)."</td>
				  <td align='right'>".date('m/d/Y',strtotime($r['payroll_period']))."</td>";
			echo "</tr>";
			
			
				
			}while($r=mysql_fetch_assoc($q));
			
			echo "</table>";
		}
		?>
		</td>
	</tr>
	</table>
