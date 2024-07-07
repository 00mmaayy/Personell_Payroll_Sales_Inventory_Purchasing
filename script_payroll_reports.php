<?php
session_start();
include('connection/conn.php');
if (!isset($_SESSION['username'])) {
	$loc = 'Location: index.php?msg=requires_login ' . $_SESSION['username'];
	header($loc);
} ?>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- <link rel="stylesheet" href="css/w3.css"> -->
<!-- <link rel="stylesheet" href="css/font-awesome.min.css"> -->
<link rel="stylesheet" href="css/bootstrap.min.css">
<!-- <script src="js/jquery.min.js"></script> -->
<!-- <script src="js/bootstrap.min.js"></script> -->

<style>
	@page {
		size 8.5in 11in;
		margin: 2cm
	}

	div.page {
		page-break-after: always
	}

	.w3-tiny {
		font-size: 10px !important
	}

	.w3-small {
		font-size: 12px !important
	}

	.w3-hover-pale-red:hover {
		color: #000 !important;
		background-color: #ffdddd !important
	}
</style>
<br>
<table>
	<tr>

		<!---TOTAL DETAILS PER BRANCH PER DEPARTMENT END--->
		<td>
			<b class='w3-tiny'>Department Filter</b>
			<form method='get'>
				<?php if (isset($_REQUEST['review_final'])) {
					echo "<input name='payroll_period' type='hidden' value='" . $_REQUEST['payroll_period'] . "'>";
					echo "<input name='review_final' type='hidden' value=''>";
				} else {
					echo "<input name='sdate' type='hidden' value='" . $_REQUEST['sdate'] . "'>";
					echo "<input name='edate' type='hidden' value='" . $_REQUEST['edate'] . "'>";
					echo "<input name='company' type='hidden' value='" . $_REQUEST['company'] . "'>";
				} ?>

				<input name='payroll' type='hidden' value='1'>
				<input name='payroll_processing' type='hidden' value='1'>
				
				<!--new added branch -->
				<select required name="department">
					<option></option>
					<option>ALL</option>
					<option>ALC</option>
					<option value='heads'>ALC HEADS(Monthly)</option>
					<option value='main'>ALC MAIN</option>
					<option value='sj'>ALC SANJOSE</option>
					<option value='sm'>ALC SM</option>
					<option value='sp'>ALC SANPEDRO</option>
					<option value='rzl'>ALC RIZAL</option>
					<option value='adpls'>ADPLUS</option>
					<?php $x1 = "select dept_name from departments order by dept_name";
					$y1 = mysql_query($x1) or die(mysql_error());
					$z1 = mysql_fetch_assoc($y1);
					do {
						echo "<option>" . $z1['dept_name'] . "</option>";
					} while ($z1 = mysql_fetch_assoc($y1));
					?>
				</select>
				<input type='submit'>
			</form>
		</td>
		<!---TOTAL DETAILS PER BRANCH PER DEPARTMENT END--->

		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>

		<!---TOTAL SUMMARY PER BRANCH PER DEPARTMENT START--->
		<td>
			<b class='w3-tiny'>Summary Per Company Per Department</b>
			<form method='get' action='script_payroll_reports_summary.php' target='_blank'>

				<?php if (isset($_REQUEST['review_final'])) {
					echo "<input name='payroll_period' type='hidden' value='" . $_REQUEST['payroll_period'] . "'>";
					echo "<input name='review_final' type='hidden' value=''>";
				} else {
					echo "<input name='sdate' type='hidden' value='" . $_REQUEST['sdate'] . "'>";
					echo "<input name='edate' type='hidden' value='" . $_REQUEST['edate'] . "'>";
				} ?>


				<input type='submit' value='Get Summary Data'>
			</form>
		</td>
		<!---TOTAL SUMMARY PER BRANCH PER DEPARTMENT END--->

		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>


		<td>
			<b class='w3-tiny'>Schedule of Taxes Witheld on Compensation</b>
			<form method='get' action='script_payroll_tax_wheld_compensation.php' target='_blank'>

				<?php if (isset($_REQUEST['review_final'])) {
					echo "<input name='payroll_period' type='hidden' value='" . $_REQUEST['payroll_period'] . "'>";
					echo "<input name='review_final' type='hidden' value=''>";
				} else {
					echo "<input name='sdate' type='hidden' value='" . $_REQUEST['sdate'] . "'>";
					echo "<input name='edate' type='hidden' value='" . $_REQUEST['edate'] . "'>";
				} ?>


				<input type='submit' value='Get Data'>
			</form>
		</td>

		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>

		<td>
			<b class='w3-tiny'>Loan Report</b>
			<form method='POST' action='script_loan_payroll_report.php?payroll-period=<?php echo $_REQUEST['sdate']; ?>' target='_blank'>
				<input type='submit' value='View Loans'>
			</form>
		</td>


		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>


		<!------>
		<td>
			<?php
			if (isset($_REQUEST['force_payslip'])) {
				$pp = $_REQUEST['payroll_period'];
				$department = $_REQUEST['department'];

				if ($department == "ALC") {
					$s1 = "select * from payroll where payroll_period='$pp' and e_company='$department'";
				} else {
					$s1 = "select * from payroll where payroll_period='$pp' and e_department='$department'";
				}

				$q1 = mysql_query($s1) or die(mysql_error());
				$r1 = mysql_fetch_assoc($q1);

				do {
					$e_no = $r1['e_no'];

					$gross_pay = $r1['e_total_cuttoff_hours_final'] + $r1['e_overtime_final'] + $r1['e_restday_pay_final'] + $r1['e_restday_pay_overtime_final'] + $r1['e_nightshift_final']
						+ $r1['e_overtime_nightshift_final'] + $r1['e_regular_holiday_final'] + $r1['e_regular_holiday_overtime_final'] + $r1['e_special_holiday_final']
						+ $r1['e_special_holiday_overtime_final'] + $r1['e_sick_leave_final'] + $r1['e_vacation_leave_final'] + $r1['e_solo_parent_leave_final'] + $r1['e_add_allowance'] + $r1['e_allowance_meal'] + $r1['e_allowance15'] + $r1['e_allowance30'] - $r1['e_lates_final'] - $r1['e_absences_final'] - $r1['e_undertime_final'];

					$deduction = $r1['e_sss'] + $r1['e_pagibig'] + $r1['e_philhealth'] + $r1['e_tax'] + $r1['e_ca'] + $r1['e_pagibig_loan'] + $r1['e_pagibig_loan_calamity'] + $r1['e_salary_loan'] + $r1['e_salary_calamity_loan'] + $r1['e_sss_calamity_loan'] 
						+ $r1['e_sss_loan'] + $r1['e_other_charges'] + $r1['e_veterans_loan'] + $r1['e_over_in_previous_pay'];

					$net_pay = round($gross_pay - $deduction, 2);

					if ($department == "ALC") {
						mysql_query("update payroll set step3=1,e_netpay=$net_pay,finalized=1 where payroll_period='$pp' and e_no='$e_no' and e_company='$department'");
					} else {
						mysql_query("update payroll set step3=1,e_netpay=$net_pay,finalized=1 where payroll_period='$pp' and e_no='$e_no' and e_department='$department'");
					}
				} while ($r1 = mysql_fetch_assoc($q1));

				$username = $_SESSION['username'];
				$trans = "Compute Netpay and Other deductions on payroll period $pp for $department";
				$log_sql = "insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
				$log_query = mysql_query($log_sql) or die(mysql_error());

				header('Location: script_payroll_reports.php?payroll=1&payroll_period=' . $_REQUEST['2018-05-2'] . '&payroll_processing=1&department=' . $_REQUEST['department'] . '&review_final=REVIEW+PAYROLL');
			}

			/*
if(isset($_REQUEST['review_final'])){ 
?>
<b class='w3-tiny'>Finalize per Department (bypass_finance)</b>
<form method='get'>
<input name='payroll_period' type='hidden' value='<?php echo $_REQUEST['payroll_period']; ?>'>
<select required name='department'>
	  <option></option>
	  <option>ALC</option>
	  <?php $x1="select dept_name from departments";
	  	    $y1=mysql_query($x1) or die(mysql_error());
			$z1=mysql_fetch_assoc($y1); 
			 do{
			    echo "<option>".$z1['dept_name']."</option>";
			   }while($z1=mysql_fetch_assoc($y1));
	  ?>
	</select>
<input name='force_payslip' type='submit' value='Finalize Dept'>
</form>
<?php } */ ?>

		</td>
		<!------>
	</tr>
</table>

<?php
$s = "select * from company";
$q = mysql_query($s) or die(mysql_error());
$r = mysql_fetch_assoc($q);


//REVIEW PROCESS TO FINALIZE PAYROLL AREA START ------------
if (isset($_REQUEST['review_final'])) {
	if (isset($_REQUEST['department'])) {
		if ($_REQUEST['department'] == 'ALL') {
			$dept = '';
		} elseif ($_REQUEST['department'] == 'heads') {
			$dept = "and head=1";
		} elseif ($_REQUEST['department'] == 'ALC') {
			$d = "ALC";
			$dept = "and e_company='$d'";
		} elseif ($_REQUEST['department'] == 'sj') {
			$d = "ALC";
			$dept = "and e_company='$d' AND e_department LIKE '%SANJOSE%'";
		} elseif ($_REQUEST['department'] == 'sp') {
			$d = "ALC";
			$dept = "and e_company='$d' AND e_department LIKE '%SANPEDRO%'";
		} elseif ($_REQUEST['department'] == 'sm') {
			$d = "ALC";
			$dept = "and e_company='$d' AND e_department LIKE '%SM%'";
		
		//new added branch
		} elseif ($_REQUEST['department'] == 'adpls') {
			$d = "ADPLS";
			$dept = "and e_company='$d' AND e_department LIKE '%ADPLUS%'";
		
		
		} elseif ($_REQUEST['department'] == 'rzl') {
			$d = "ALC";
			$dept = "and e_company='$d' AND e_department LIKE '%RIZAL%'";
		} elseif ($_REQUEST['department'] == 'main') {
			$d = "ALC";
			$dept = "and e_company='$d' AND e_department NOT LIKE '%SANPEDRO%' AND e_department NOT LIKE '%SANJOSE%' AND e_department NOT LIKE '%SM%' AND e_department NOT LIKE '%PRODUCTION%'";
		} else {
			$d = $_REQUEST['department'];
			$dept = "and e_department='$d'";
		}
	}

	$payroll_period = $_REQUEST['payroll_period'];
	$sm2 = "select * from payroll where payroll_period='$payroll_period' $dept order by e_company,e_department,e_lname asc";
}
//REVIEW PROCESS TO FINALIZE PAYROLL AREA END ------------


//REPORTS ONLY START ------------------------------
else {
	if (isset($_REQUEST['company'])) {
		if ($_REQUEST['company'] != "") {
			$company = $_REQUEST['company'];
			$comp = "and e_company='$company'";
		} else {
			$comp = "";
		}
	}

	if (isset($_REQUEST['department'])) {
		if ($_REQUEST['department'] == 'ALL') {
			$dept = '';
		} elseif ($_REQUEST['department'] == 'heads') {
			$dept = "and head=1";
		} elseif ($_REQUEST['department'] == 'ALC') {
			$d = "ALC";
			$dept = "and e_company='$d'";
		} elseif ($_REQUEST['department'] == 'sj') {
			$d = "ALC";
			$dept = "and e_company='$d' AND e_department LIKE '%SANJOSE%'";
		} elseif ($_REQUEST['department'] == 'sp') {
			$d = "ALC";
			$dept = "and e_company='$d' AND e_department LIKE '%SANPEDRO%'";
		} elseif ($_REQUEST['department'] == 'sm') {
			$d = "ALC";
			$dept = "and e_company='$d' AND e_department LIKE '%SM%'";
		
		//new added branch
		} elseif ($_REQUEST['department'] == 'adpls') {
			$d = "ADPLS";
			$dept = "and e_company='$d' AND e_department LIKE '%ADPLUS%'";
		
		
		
		} elseif ($_REQUEST['department'] == 'rzl') {
			$d = "ALC";
			$dept = "and e_company='$d' AND e_department LIKE '%RIZAL%'";
		} elseif ($_REQUEST['department'] == 'main') {
			$d = "ALC";
			$dept = "and e_company='$d' AND e_department NOT LIKE '%SANPEDRO%' AND e_department NOT LIKE '%SANJOSE%' AND e_department NOT LIKE '%SM%' AND e_department NOT LIKE '%PRODUCTION%'";
		} else {
			$d = $_REQUEST['department'];
			$dept = "and e_department='$d'";
		}
	}else{ $dept='';}

	$sdate = $_REQUEST['sdate'];
	$edate = $_REQUEST['edate'];
	$sm2 = "select * from payroll where payroll_period>='$sdate' and payroll_period<='$edate' and finalized=1 $comp $dept order by e_company,e_department,e_lname asc";
}
//REPORTS ONLY END ------------------------------

$qm2 = mysql_query($sm2) or die(mysql_error());
$rm2 = mysql_fetch_assoc($qm2);
$count = mysql_num_rows($qm2);

//REVIEW PROCESS TO FINALIZE PAYROLL AREA Total Start Only -----------------------
if (isset($_REQUEST['review_final'])) {

	if (isset($_REQUEST['department'])) 
	{
		if ($_REQUEST['department'] == 'ALL') {
			$dept = '';
		} elseif ($_REQUEST['department'] == 'heads') {
			$dept = "and head=1";
		} elseif ($_REQUEST['department'] == 'ALC') {
			$dept = "and e_company='ALC'";
		} elseif ($_REQUEST['department'] == 'sj') {
			$d = "ALC";
			$dept = "and e_company='$d' AND e_department LIKE '%SANJOSE%'";
		} elseif ($_REQUEST['department'] == 'sp') {
			$d = "ALC";
			$dept = "and e_company='$d' AND e_department LIKE '%SANPEDRO%'";
		} elseif ($_REQUEST['department'] == 'sm') {
			$d = "ALC";
			$dept = "and e_company='$d' AND e_department LIKE '%SM%'";
		
		//new added branch
		} elseif ($_REQUEST['department'] == 'rzl') {
			$d = "ALC";
			$dept = "and e_company='$d' AND e_department LIKE '%RIZAL%'";
		
	
		} elseif ($_REQUEST['department'] == 'adpls') {
			$d = "ADPLS";
			$dept = "and e_company='$d' AND e_department LIKE '%ADPLUS%'";
		
		} elseif ($_REQUEST['department'] == 'main') {
		

		$d = "ALC";
			$dept = "and e_company='$d' AND e_department NOT LIKE '%SANPEDRO%' AND e_department NOT LIKE '%SANJOSE%' AND e_department NOT LIKE '%SM%' AND e_department NOT LIKE '%PRODUCTION%'";
		} else {
			$d = $_REQUEST['department'];
			$dept = "and e_department='$d'";
		}
	}

	$payroll_period = $_REQUEST['payroll_period'];
	$snet = "select 
       sum(e_total_cuttoff_hours_final + e_overtime_final + e_restday_pay_final + e_restday_pay_overtime_final + e_nightshift_final + e_overtime_nightshift_final + e_regular_holiday_final + e_regular_holiday_overtime_final + e_special_holiday_final + e_special_holiday_overtime_final + e_sick_leave_final + e_vacation_leave_final + e_solo_parent_leave_final + e_allowance_meal + e_allowance15 + e_allowance30 + e_add_allowance - e_lates_final - e_absences_final - e_undertime_final) as gross_pay,
	   sum(e_sss + e_pagibig + e_philhealth + e_tax + e_ca + e_pagibig_loan + e_pagibig_loan_calamity + e_salary_loan + e_salary_calamity_loan + e_sss_calamity_loan + e_sss_loan + e_other_charges + e_veterans_loan + e_over_in_previous_pay) as deductions,
       sum(ec_sss) as employer_sss,
	   sum(e_tax) as tax,
	   sum(e_allowance_meal) as meal,
	   sum(e_allowance15) as allow15,
	   sum(e_allowance30) as allow30,
	   sum(e_sss) as sss,
	   sum(e_sss_loan) as sss_loan,
	   sum(e_pagibig) as pagibig,
	   sum(e_pagibig_loan) as pagibig_loan,
	   sum(e_pagibig_loan_calamity) as calamity,
	   sum(e_philhealth) as ph,
	   sum(e_salary_loan) as sa,
	   sum(e_salary_calamity_loan) as scl,
	   sum(e_sss_calamity_loan) as sssl,
	   sum(e_ca) as ca,
	   sum(e_veterans_loan) as vet,
	   sum(e_other_charges) as charges,
	   sum(e_over_in_previous_pay) as overpay,
	   sum(e_total_cuttoff_hours_final) as basic,
	   sum(e_overtime_final) as basic_ot,
	   sum(e_restday_pay_final) as rd,
	   sum(e_restday_pay_overtime_final) as rd_ot,
	   sum(e_nightshift_final) as ns,
	   sum(e_overtime_nightshift_final) as ns_ot,
	   sum(e_regular_holiday_final) as rh,
	   sum(e_regular_holiday_overtime_final) as rh_ot,
	   sum(e_special_holiday_final) as sh,
	   sum(e_special_holiday_overtime_final) as sh_ot,
	   sum(e_sick_leave_final) as sl,
	   sum(e_vacation_leave_final) as vl,
	   sum(e_solo_parent_leave_final) as spl,
	   sum(e_lates_final) as late,
	   sum(e_absences_final) as absent,
	   sum(e_undertime_final) as undertime,
	   sum(e_add_allowance) as adj,
	   sum(e_total_cuttoff_hours) as basic_t,
	   sum(e_overtime) as basic_ot_t,
	   sum(e_restday_pay) as rd_t,
	   sum(e_restday_pay_overtime) as rd_ot_t,
	   sum(e_nightshift) as ns_t,
	   sum(e_overtime_nightshift) as ns_ot_t,
	   sum(e_regular_holiday) as rh_t,
	   sum(e_regular_holiday_overtime) as rh_ot_t,
	   sum(e_special_holiday) as sh_t,
	   sum(e_special_holiday_overtime) as sh_ot_t,
	   sum(e_sick_leave) as sl_t,
	   sum(e_vacation_leave) as vl_t,
	   sum(e_solo_parent_leave) as spl_t,
	   sum(e_lates) as late_t,
	   sum(e_absences) as absent_t,
	   sum(e_undertime) as undertime_t
	   from payroll where payroll_period>='$payroll_period' $dept";
}
//REVIEW PROCESS TO FINALIZE PAYROLL AREA Total Start Only -----------------------


//REPORTS ONLY Total Only Start ------------------
else {
	if (isset($_REQUEST['company'])) {
		if ($_REQUEST['company'] != "") {
			$company = $_REQUEST['company'];
			$comp = "and e_company='$company'";
		} else {
			$comp = "";
		}
	}

	if (isset($_REQUEST['department'])) 
	{
		if ($_REQUEST['department'] == 'ALL') {
			$dept = '';
		} elseif ($_REQUEST['department'] == 'heads') {
			$dept = "and head=1";
		} elseif ($_REQUEST['department'] == 'ALC') {
			$d = "ALC";
			$dept = "and e_company='$d'";
		} elseif ($_REQUEST['department'] == 'sj') {
			$d = "ALC";
			$dept = "and e_company='$d' AND e_department LIKE '%SANJOSE%'";
		} elseif ($_REQUEST['department'] == 'sp') {
			$d = "ALC";
			$dept = "and e_company='$d' AND e_department LIKE '%SANPEDRO%'";
		} elseif ($_REQUEST['department'] == 'sm') {
			$d = "ALC";
			$dept = "and e_company='$d' AND e_department LIKE '%SM%'";
		
		//new added branch
		} elseif ($_REQUEST['department'] == 'rzl') {
			$d = "ALC";
			$dept = "and e_company='$d' AND e_department LIKE '%RIZAL%'";
		
		} elseif ($_REQUEST['department'] == 'adpls') {
			$d = "ADPLS";
			$dept = "and e_company='$d' AND e_department LIKE '%ADPLUS%'";
		
		} elseif ($_REQUEST['department'] == 'main') {
			$d = "ALC";
			$dept = "and e_company='$d' AND e_department NOT LIKE '%SANPEDRO%' AND e_department NOT LIKE '%SANJOSE%' AND e_department NOT LIKE '%SM%' AND e_department NOT LIKE '%PRODUCTION%'";
		} else {
			$d = $_REQUEST['department'];
			$dept = "and e_department='$d'";
		}
	}else{ $dept='';}

	//sum(Case When e_netpay > 0 then e_netpay else 0 end) netpaytotal_pos_only,	   
	$sdate = $_REQUEST['sdate'];
	$edate = $_REQUEST['edate'];
	$snet = "select 
       sum(e_total_cuttoff_hours_final + e_overtime_final + e_restday_pay_final + e_restday_pay_overtime_final + e_nightshift_final + e_overtime_nightshift_final + e_regular_holiday_final + e_regular_holiday_overtime_final + e_special_holiday_final + e_special_holiday_overtime_final + e_sick_leave_final + e_vacation_leave_final + e_solo_parent_leave_final + e_allowance_meal + e_allowance15 + e_allowance30 + e_add_allowance - e_lates_final - e_absences_final - e_undertime_final) as gross_pay,
	   sum(e_sss + e_pagibig + e_philhealth + e_tax + e_ca + e_pagibig_loan + e_pagibig_loan_calamity + e_salary_loan + e_salary_calamity_loan + e_sss_calamity_loan + e_sss_loan + e_other_charges + e_veterans_loan + e_over_in_previous_pay) as deductions,
       sum(ec_sss) as employer_sss,
	   sum(e_tax) as tax,
	   sum(e_allowance_meal) as meal,
	   sum(e_allowance15) as allow15,
	   sum(e_allowance30) as allow30,
	   sum(e_sss) as sss,
	   sum(e_sss_loan) as sss_loan,
	   sum(e_pagibig) as pagibig,
	   sum(e_pagibig_loan) as pagibig_loan,
	   sum(e_pagibig_loan_calamity) as calamity,
	   sum(e_philhealth) as ph,
	   sum(e_salary_loan) as sa,
	   sum(e_salary_calamity_loan) as scl,
	   sum(e_sss_calamity_loan) as sssl,
	   sum(e_ca) as ca,
	   sum(e_veterans_loan) as vet,
	   sum(e_other_charges) as charges,
	   sum(e_over_in_previous_pay) as overpay,
	   sum(e_total_cuttoff_hours_final) as basic,
	   sum(e_overtime_final) as basic_ot,
	   sum(e_restday_pay_final) as rd,
	   sum(e_restday_pay_overtime_final) as rd_ot,
	   sum(e_nightshift_final) as ns,
	   sum(e_overtime_nightshift_final) as ns_ot,
	   sum(e_regular_holiday_final) as rh,
	   sum(e_regular_holiday_overtime_final) as rh_ot,
	   sum(e_special_holiday_final) as sh,
	   sum(e_special_holiday_overtime_final) as sh_ot,
	   sum(e_sick_leave_final) as sl,
	   sum(e_vacation_leave_final) as vl,
	   sum(e_solo_parent_leave_final) as spl,
	   sum(e_lates_final) as late,
	   sum(e_absences_final) as absent,
	   sum(e_undertime_final) as undertime,
	   sum(e_add_allowance) as adj,
	   sum(e_total_cuttoff_hours) as basic_t,
	   sum(e_overtime) as basic_ot_t,
	   sum(e_restday_pay) as rd_t,
	   sum(e_restday_pay_overtime) as rd_ot_t,
	   sum(e_nightshift) as ns_t,
	   sum(e_overtime_nightshift) as ns_ot_t,
	   sum(e_regular_holiday) as rh_t,
	   sum(e_regular_holiday_overtime) as rh_ot_t,
	   sum(e_special_holiday) as sh_t,
	   sum(e_special_holiday_overtime) as sh_ot_t,
	   sum(e_sick_leave) as sl_t,
	   sum(e_vacation_leave) as vl_t,
	   sum(e_solo_parent_leave) as spl_t,
	   sum(e_lates) as late_t,
	   sum(e_absences) as absent_t,
	   sum(e_undertime) as undertime_t
	   from payroll where payroll_period>='$sdate' and payroll_period<='$edate' and finalized=1 $comp $dept";
}
//REPORTS ONLY Total Only End ------------------


$qnet = mysql_query($snet) or die(mysql_error());
$rnet = mysql_fetch_assoc($qnet);


echo "<table border='1'>";

//REVIEW PROCESS TO FINALIZE PAYROLL AREA START --------------	  
if (isset($_REQUEST['review_final'])) {
	echo "<tr><td align='center' colspan='58'>" . $r['company_name'] . "</br><small>" . $r['company_address'] . "<br>Payroll Process Period Period " . date('m/d/Y', strtotime($_REQUEST['payroll_period'])) . "</small></td></tr>";
}
//REVIEW PROCESS TO FINALIZE PAYROLL AREA END --------------	

//REPORTS ONLY START ------------------------------
else {
	echo "<tr><td align='center' colspan='58'>" . $r['company_name'] . "</br><small>" . $r['company_address'] . "<br>Payroll Process Period " . date('m/d/Y', strtotime($_REQUEST['sdate'])) . " - " . date('m/d/Y', strtotime($_REQUEST['edate'])) . "</small></td></tr>";
}
//REPORTS ONLY START ------------------------------    

echo "<tr align='center'>
		  <td colspan='6' class='bg-success'><small><span class='text-danger'><b>$count</b></span> <strong class='text-success'>EMPLOYEES / DETAILS</small></b></td>
		  
		  <td colspan='16' class='bg-warning text-warning'><b><small>ACTUAL HOURS WORKED</small></b></td>
		  
		  <td colspan='21' class='bg-info text-primary'><b><small>SALARY</small></b></td>
		  <td colspan='15' class='bg-danger text-danger'><b><small>DEDUCTIONS</small></b></td>
		  <td class='bg-success'></td>
		  <td colspan='2' class='w3-tiny'>EMPLOYER SHARE</td>
		  <td class='w3-tiny'>RICE</td>";
echo "</tr>
		
		<tr align='center' class='w3-tiny'>
		  <td class='bg-success'>COMP</td>
		  <td class='bg-success'>DEPT</td>
		  <td class='bg-success'>E NO.</td>
		  <td class='bg-success'>NAME</td>
		  <td class='bg-success'>Rate<br>/ Day</td>
		  <td class='bg-success'>Rate<br>/ Hour</td>
		  
		  <td class='bg-warning'>R HRS</td>
		  <td class='bg-warning'>OT</td>
		  <td class='bg-warning'>DOP</td>
		  <td class='bg-warning'>DOP<br>OT</td>
		  <td class='bg-warning'>NS</td>
		  <td class='bg-warning'>NS<br>OT</td>
		  <td class='bg-warning'>RH</td>
		  <td class='bg-warning'>RH<br>OT</small></td>
		  <td class='bg-warning'>SH</td>
		  <td class='bg-warning'>SH<br>OT</td>
		  <td class='bg-warning'>SL</td>
		  <td class='bg-warning'>VL</td>
		  <td class='bg-warning'>SPL</td>
		  <td class='bg-warning'>Lates</td>
		  <td class='bg-warning'>Absences</td>
		  <td class='bg-warning'>Undertime</td>
		  <td class='bg-info'>R HRS<br>Basic Pay</td>
		  <td class='bg-info'>OT</td>
		  <td class='bg-info'>DOP</td>
		  <td class='bg-info'>DOP<br>OT</td>
		  <td class='bg-info'>NS</td>
		  <td class='bg-info'>NS<br>OT</td>
		  <td class='bg-info'>RH</td>
		  <td class='bg-info'>RH<br>OT</td>
		  <td class='bg-info'>SH</td>
		  <td class='bg-info'>SH<br>OT</td>
		  <td class='bg-info'>SL</td>
		  <td class='bg-info'>VL</td>
		  <td class='bg-info'>SPL</td>
		  <td class='bg-info'>ADJ</td>
		  <td class='bg-info'>ALWMeal</td>
		  <td class='bg-info'>ALW15</td>
		  <td class='bg-info'>ALW30</td>
		  <td class='bg-info'>Lates</td>
		  <td class='bg-info'>Absences</td>
		  <td class='bg-info'>Undertime</td>
		  <td class='text-primary bg-info'><b>Gross Pay</b></td>
		  
		  <td class='bg-danger'>W-Tax</td>
		  <td class='bg-danger'>SSS</td>
		  <td class='bg-danger'>SSS Loan</td>
		  <td class='bg-danger'>PagIbig</td>
		  <td class='bg-danger'>PagIbig Loan</td>
		  <td class='bg-danger'>PagIbig Calamity Loan</td>
		  <td class='bg-danger'>Philhealth</td>
		  <td class='bg-danger'>Salary Loan</td>
		  <td class='bg-danger'>Calamity Loan</td>
		  <td class='bg-danger'>SSS Calamity Loan</td>
		  <td class='bg-danger'>Cash Advance</td>
		  <td class='bg-danger'>Veterans Loan</td>
		  <td class='bg-danger'>Charges</td>
		  <td class='bg-danger'>Over Pay</td>
		  <td class='bg-danger text-danger'><b>Total Deductions</b></td>
		  
		  <td class='bg-success text-success'><b>Net Pay</b></td>
		  <td>SSS Employer</td>
		  <td>Philhealth Employer</td>
		  <td>Complete Day</td>
		</tr>";
do {
	
	$e_no = $rm2['e_no'];
	$sm1 = "select * from employee where e_no='$e_no'";
	$qm1 = mysql_query($sm1) or die(mysql_error());
	$rm1 = mysql_fetch_assoc($qm1);

	
	/*---------------------------------------------------------- */
				
				$e_no=$rm2['e_no'];
				/*
				mysql_query("update payroll set e_tax='0' 
							  where e_no='$e_no' 
								and payroll_period='$payroll_period'
								and finalized = 0");
				*/
				$basic_pay1= $rm2['e_total_cuttoff_hours_final']
							+ $rm2['e_overtime_final']
							+ $rm2['e_restday_pay_final']
							+ $rm2['e_restday_pay_overtime_final']
							+ $rm2['e_nightshift_final']
							+ $rm2['e_overtime_nightshift_final']
							+ $rm2['e_regular_holiday_final']
							+ $rm2['e_regular_holiday_overtime_final']
							+ $rm2['e_special_holiday_final']
							+ $rm2['e_special_holiday_overtime_final']
							+ $rm2['e_sick_leave_final']
							+ $rm2['e_vacation_leave_final']
							+ $rm2['e_solo_parent_leave_final']
							+ $rm2['e_add_allowance']
							- $rm2['e_pagibig']
							- $rm2['e_philhealth']
							- $rm2['e_sss']
							- $rm2['e_lates_final']
							- $rm2['e_absences_final']
							- $rm2['e_undertime_final'];
				
				if($basic_pay1>=10418 && $basic_pay1<=16666)
				{ $tax="tax 2"; 
				  $over_cl=$basic_pay1-10417;
				  $wtax=$over_cl*.15;			
				 mysql_query("update payroll set e_tax=$wtax 
							  where e_no='$e_no' 
								and payroll_period='$payroll_period'
								and finalized = 0");
				}	
				
				elseif($basic_pay1>=16667 && $basic_pay1<=33332)
				{ $tax="tax 3"; 
				  $over_cl=$basic_pay1-16667;
				  $wtax=($over_cl*.20)+937.50;
				  
				  mysql_query("update payroll set e_tax=$wtax 
								where e_no='$e_no'
								and payroll_period='$payroll_period'
								and finalized = 0");
				}

				elseif($basic_pay1>=33333 && $basic_pay1<=83332)
				{ $tax="tax 4"; 
				  $over_cl=$basic_pay1-33333;
				  $wtax=($over_cl*.25)+4270.70;
				  mysql_query("update payroll set e_tax=$wtax 
							where e_no='$e_no' 
								and payroll_period='$payroll_period'
								and finalized = 0");
				}

				elseif($basic_pay1>=83333 && $basic_pay1<=333332)
				{ $tax="tax 5"; 
				  $over_cl=$basic_pay1-83333;
				  $wtax=($over_cl*.30)+16770.70;
				mysql_query("update payroll set e_tax=$wtax 
							where e_no='$e_no' 
								and payroll_period='$payroll_period'
								and finalized = 0");  
				}

				elseif($basic_pay1>=333333 && $basic_pay1<=9999999)
				{ $tax="tax 6"; 
				  $over_cl=$basic_pay1-333333;
				  $wtax=($over_cl*.35)+91770.70;
				mysql_query("update payroll set e_tax=$wtax 
							where e_no='$e_no' 
								and payroll_period='$payroll_period'
								and finalized = 0");
				}else{}		
				
				/*
				//philhealth
					$basic_ph=$rm2['e_basic_pay']*26;
					if($basic_ph>=10000.001 && $basic_ph<=99999.99)
					{
						$ph=$basic_ph*0.05/2;
						mysql_query("update payroll set e_philhealth=$ph 
								where e_no='$e_no' 
									and payroll_period='$payroll_period'
									and finalized = 0");
					
					} //NEW PH FOR 2024
					
					elseif($basic_ph>=100000.00)
					{
						$ph=5000.00;
						mysql_query("update payroll set e_philhealth=$ph 
								where e_no='$e_no' 
									and payroll_period='$payroll_period'
									and finalized = 0");
					}
					
					else{}
                */
           
				
	/*---------------------------------------------------------*/			   

	
	
	echo "<tr align='center' class='w3-hover-pale-red'>
		  <td class='w3-tiny'>";
		  
		  switch($rm1['e_alcgroup'])
			{ 
				case 1: echo "ALCGOC"; break; 
				case 0: echo $rm2['e_company']; break;
			}
		 
	echo "</td>
		  <td class='w3-tiny'>" . $rm2['e_department'] . "</td>
          <td class='w3-tiny'>" . $rm2['e_no'] . "</td>
          <td align='left'><small>" . $rm1['e_lname'] . ", " . $rm1['e_fname'] . "</small></td>
		  
		  <td><small>" . number_format($rm2['e_basic_pay'], 2) . "</small></td>
		  <td><small>" . number_format($rm2['e_basic_pay'] / 8, 2) . "</small></td>
		  
		  <td><small>" . number_format($rm2['e_total_cuttoff_hours'], 2) . "</small></td>
		  <td><small>" . number_format($rm2['e_overtime'], 2) . "</small></td>
		  <td><small>" . number_format($rm2['e_restday_pay'], 2) . "</small></td>
		  <td><small>" . number_format($rm2['e_restday_pay_overtime'], 2) . "</small></td>
		  <td><small>" . number_format($rm2['e_nightshift'], 2) . "</small></td>
		  <td><small>" . number_format($rm2['e_overtime_nightshift'], 2) . "</small></td>
		  <td><small>" . number_format($rm2['e_regular_holiday'], 2) . "</small></td>
		  <td><small>" . number_format($rm2['e_regular_holiday_overtime'], 2) . "</small></td>
		  <td><small>" . number_format($rm2['e_special_holiday'], 2) . "</small></td>
		  <td><small>" . number_format($rm2['e_special_holiday_overtime'], 2) . "</small></td>
		  <td><small>" . number_format($rm2['e_sick_leave'], 2) . "</small></td>
		  <td><small>" . number_format($rm2['e_vacation_leave'], 2) . "</small></td>
		  <td><small>" . number_format($rm2['e_solo_parent_leave'], 2) . "</small></td>
		  <td><small>" . number_format($rm2['e_lates'], 2) . "</small></td>
		  <td><small>" . number_format($rm2['e_absences'], 2) . "</small></td>
		  <td><small>" . number_format($rm2['e_undertime'], 2) . "</small></td>";
	if ($rm2['e_total_cuttoff_hours_final'] == 0) {
		echo "<td class='bg-danger'>";
	} else {
		echo "<td>";
	}
	echo "<small>" . number_format($rm2['e_total_cuttoff_hours_final'], 2) . "</small></td>
	      <td><small>" . number_format($rm2['e_overtime_final'], 2) . "</small></td>
		  <td><small>" . number_format($rm2['e_restday_pay_final'], 2) . "</small></td>
		  <td><small>" . number_format($rm2['e_restday_pay_overtime_final'], 2) . "</small></td>
		  <td><small>" . number_format($rm2['e_nightshift_final'], 2) . "</small></td>
		  <td><small>" . number_format($rm2['e_overtime_nightshift_final'], 2) . "</small></td>
		  <td><small>" . number_format($rm2['e_regular_holiday_final'], 2) . "</small></td>
		  <td><small>" . number_format($rm2['e_regular_holiday_overtime_final'], 2) . "</small></td>
		  <td><small>" . number_format($rm2['e_special_holiday_final'], 2) . "</small></td>
		  <td><small>" . number_format($rm2['e_special_holiday_overtime_final'], 2) . "</small></td>
		  <td><small>" . number_format($rm2['e_sick_leave_final'], 2) . "</small></td>
		  <td><small>" . number_format($rm2['e_vacation_leave_final'], 2) . "</small></td>
		  <td><small>" . number_format($rm2['e_solo_parent_leave_final'], 2) . "</small></td>
		  <td><small>" . number_format($rm2['e_add_allowance'], 2) . "</small></td>
		  <td><small>" . number_format($rm2['e_allowance_meal'], 2) . "</small></td>
		  <td><small>" . number_format($rm2['e_allowance15'], 2) . "</small></td>
		  <td><small>" . number_format($rm2['e_allowance30'], 2) . "</small></td>
		  <td><small>" . number_format($rm2['e_lates_final'], 2) . "</small></td>
		  <td><small>" . number_format($rm2['e_absences_final'], 2) . "</small></td>
		  <td><small>" . number_format($rm2['e_undertime_final'], 2) . "</small></td>
		  <td class='text-primary'><b><small>";

	$earningss = $rm2['e_total_cuttoff_hours_final']
		+ $rm2['e_overtime_final']
		+ $rm2['e_restday_pay_final']
		+ $rm2['e_restday_pay_overtime_final']
		+ $rm2['e_nightshift_final']
		+ $rm2['e_overtime_nightshift_final']
		+ $rm2['e_regular_holiday_final']
		+ $rm2['e_regular_holiday_overtime_final']
		+ $rm2['e_special_holiday_final']
		+ $rm2['e_special_holiday_overtime_final']
		+ $rm2['e_sick_leave_final']
		+ $rm2['e_vacation_leave_final']
		+ $rm2['e_solo_parent_leave_final']
		+ $rm2['e_add_allowance']
		+ $rm2['e_allowance_meal']
		+ $rm2['e_allowance15']
		+ $rm2['e_allowance30']
		- $rm2['e_lates_final']
		- $rm2['e_absences_final']
		- $rm2['e_undertime_final'];
	echo number_format($earningss, 2);

	echo "</small></b></td>
		  <td><small>" . number_format($rm2['e_tax'], 2) . "</small></td>
		  <td><small>" . number_format($rm2['e_sss'], 2) . "</small></td>
		  <td><small>" . number_format($rm2['e_sss_loan'], 2) . "</small></td>
		  <td><small>" . number_format($rm2['e_pagibig'], 2) . "</small></td>
		  <td><small>" . number_format($rm2['e_pagibig_loan'], 2) . "</small></td>
		  <td><small>" . number_format($rm2['e_pagibig_loan_calamity'], 2) . "</small></td>
		  <td><small>" . number_format($rm2['e_philhealth'], 2) . "</small></td>
		  <td><small>" . number_format($rm2['e_salary_loan'], 2) . "</small></td>
		  <td><small>" . number_format($rm2['e_salary_calamity_loan'], 2) . "</small></td>
		  <td><small>" . number_format($rm2['e_sss_calamity_loan'], 2) . "</small></td>
		  <td><small>" . number_format($rm2['e_ca'], 2) . "</small></td>
		  <td><small>" . number_format($rm2['e_veterans_loan'], 2) . "</small></td>
		  <td><small>" . number_format($rm2['e_other_charges'], 2) . "</small></td>
		  <td><small>" . number_format($rm2['e_over_in_previous_pay'], 2) . "</small></td>
		  <td class='text-danger'><b><small>";

	$deductionss = $rm2['e_tax']
		+ $rm2['e_sss']
		+ $rm2['e_sss_loan']
		+ $rm2['e_pagibig']
		+ $rm2['e_pagibig_loan']
		+ $rm2['e_pagibig_loan_calamity']
		+ $rm2['e_philhealth']
		+ $rm2['e_salary_loan']
		+ $rm2['e_salary_calamity_loan']
		+ $rm2['e_sss_calamity_loan']
		+ $rm2['e_ca']
		+ $rm2['e_veterans_loan']
		+ $rm2['e_other_charges']
		+ $rm2['e_over_in_previous_pay'];
	echo number_format($deductionss, 2);

	echo "</small></b>
		  </td>";

	$netpayy = round($earningss - $deductionss, 2);
	if ($netpayy > 0) {
		echo "<td class='text-success'>";
	} else {
		echo "<td class='bg-danger'>";
	}

	echo "<b>
			  <small>";

	echo number_format($netpayy, 2);
	//pang update ng netpay
	//mysql_query("update payroll set e_netpay=$netpayy where e_no='$e_no' ") or die(mysql_error());

	echo "</small>
			</b>
		  </td>
		  
		  <td><small>" . number_format($rm2['ec_sss'], 2) . "</small></td>	
          <td><small>" . number_format($rm2['e_philhealth'], 2) . "</small></td>
		  <td><small>" . $rm2['rice'] . "</small></td>
		  </tr>";
} while ($rm2 = mysql_fetch_assoc($qm2));

echo "<tr>
          <td colspan='6'></td>
		  <td><b><small>" . number_format($rnet['basic_t'], 2) . "</small></b></td>
		  <td><b><small>" . number_format($rnet['basic_ot_t'], 2) . "</small></b></td>
		  <td><b><small>" . number_format($rnet['rd_t'], 2) . "</small></b></td>
		  <td><b><small>" . number_format($rnet['rd_ot_t'], 2) . "</small></b></td>
		  <td><b><small>" . number_format($rnet['ns_t'], 2) . "</small></b></td>
		  <td><b><small>" . number_format($rnet['ns_ot_t'], 2) . "</small></b></td>
		  <td><b><small>" . number_format($rnet['rh_t'], 2) . "</small></b></td>
		  <td><b><small>" . number_format($rnet['rh_ot_t'], 2) . "</small></b></td>
		  <td><b><small>" . number_format($rnet['sh_t'], 2) . "</small></b></td>
		  <td><b><small>" . number_format($rnet['sh_ot_t'], 2) . "</small></b></td>
		  <td><b><small>" . number_format($rnet['sl_t'], 2) . "</small></b></td>
		  <td><b><small>" . number_format($rnet['vl_t'], 2) . "</small></b></td>
		  <td><b><small>" . number_format($rnet['spl_t'], 2) . "</small></b></td>
		  <td><b><small>" . number_format($rnet['late_t'], 2) . "</small></b></td>
		  <td><b><small>" . number_format($rnet['absent_t'], 2) . "</small></b></td>
		  
		  <td><b><small>" . number_format($rnet['undertime_t'], 2) . "</small></b></td>
		  
		  <td><b><small>" . number_format($rnet['basic'], 2) . "</small></b></td>
		  <td><b><small>" . number_format($rnet['basic_ot'], 2) . "</small></b></td>
		  <td><b><small>" . number_format($rnet['rd'], 2) . "</small></b></td>
		  <td><b><small>" . number_format($rnet['rd_ot'], 2) . "</small></b></td>
		  <td><b><small>" . number_format($rnet['ns'], 2) . "</small></b></td>
		  <td><b><small>" . number_format($rnet['ns_ot'], 2) . "</small></b></td>
		  <td><b><small>" . number_format($rnet['rh'], 2) . "</small></b></td>
		  <td><b><small>" . number_format($rnet['rh_ot'], 2) . "</small></b></td>
		  <td><b><small>" . number_format($rnet['sh'], 2) . "</small></b></td>
		  <td><b><small>" . number_format($rnet['sh_ot'], 2) . "</small></b></td>
		  <td><b><small>" . number_format($rnet['sl'], 2) . "</small></b></td>
		  <td><b><small>" . number_format($rnet['vl'], 2) . "</small></b></td>
		  <td><b><small>" . number_format($rnet['spl'], 2) . "</small></b></td>
		  <td><b><small>" . number_format($rnet['adj'], 2) . "</small></b></td>
		  <td><b><small>" . number_format($rnet['meal'], 2) . "</small></b></td>
		  <td><b><small>" . number_format($rnet['allow15'], 2) . "</small></b></td>
		  <td><b><small>" . number_format($rnet['allow30'], 2) . "</small></b></td>
		  <td><b><small>" . number_format($rnet['late'], 2) . "</small></b></td>
		  <td><b><small>" . number_format($rnet['absent'], 2) . "</small></b></td>
		  
		  <td><b><small>" . number_format($rnet['undertime'], 2) . "</small></b></td>
		  
		  <td><b><small>" . number_format($rnet['gross_pay'], 2) . "</small></b></td>
		  <td><b><small>" . number_format($rnet['tax'], 2) . "</small></b></td>
		  <td><b><small>" . number_format($rnet['sss'], 2) . "</small></b></td>
		  <td><b><small>" . number_format($rnet['sss_loan'], 2) . "</small></b></td>
		  <td><b><small>" . number_format($rnet['pagibig'], 2) . "</small></b></td>
		  <td><b><small>" . number_format($rnet['pagibig_loan'], 2) . "</small></b></td>
		  <td><b><small>" . number_format($rnet['calamity'], 2) . "</small></b></td>
		  <td><b><small>" . number_format($rnet['ph'], 2) . "</small></b></td>
		  <td><b><small>" . number_format($rnet['sa'], 2) . "</small></b></td>
		  <td><b><small>" . number_format($rnet['scl'], 2) . "</small></b></td>
		  <td><b><small>" . number_format($rnet['sssl'], 2) . "</small></b></td>
		  <td><b><small>" . number_format($rnet['ca'], 2) . "</small></b></td>
		  <td><b><small>" . number_format($rnet['vet'], 2) . "</small></b></td>
		  <td><b><small>" . number_format($rnet['charges'], 2) . "</small></b></td>
		  <td><b><small>" . number_format($rnet['overpay'], 2) . "</small></b></td>
		  <td><b><small>" . number_format($rnet['deductions'], 2) . "</small></b></td>";

if (isset($_REQUEST['review_final'])) {
	$netnet = $rnet['gross_pay'] - $rnet['deductions'];
	echo "<td><b><small>" . number_format($netnet, 2) . "</small></b></td>";
} else {
	$netnet = $rnet['gross_pay'] - $rnet['deductions'];
	echo "<td><b><small>" . number_format($netnet, 2) . "</small></b></td>";
}

echo "<td><b><small>" . number_format($rnet['employer_sss'], 2) . "</small></b></td>
	      <td><b><small>" . number_format($rnet['ph'], 2) . "</small></b></td>
      </tr>
</table>"; ?>


<br>
<table align='center'>
	<tr>
		<td class='w3-small'>
			Prepared by:_______________________<br><br><br>
			Checked by:<u>&nbsp;&nbsp;_______________________&nbsp;&nbsp;</u><br><br><br>
		<td>
		<td width='50'>
		<td class='w3-small'>
			<!--Reviewed by:<u>&nbsp;&nbsp;SHARMAINE L. MANLAPAZ&nbsp;&nbsp;</u><br><br><br>-->
			Reviewed by:&nbsp;&nbsp;_______________________&nbsp;&nbsp;<br><br><br>
			Approved by:<u>&nbsp;&nbsp;ARCHIE P. BAYONA&nbsp;&nbsp;</u><br><br><br>
		</td>

		<td width='50'>
		</td>

		<td>

			<table align='center' class='w3-small' border='1'>
				<tr>
					<td colspan='2' align='center'>TOTALS FOR PAYROLL PROCESS PERIOD<br>
						<?php
						if (isset($_REQUEST['sdate'])) {
							echo date('m/d/Y', strtotime($_REQUEST['sdate'])) . " - " . date('m/d/Y', strtotime($_REQUEST['edate']));
						} else {
							echo date('m/d/Y', strtotime($_REQUEST['payroll_period']));
						}
						?>
					</td>
				</tr>
				<tr>
					<td><b>DESCRIPTION</b></td>
					<td><b>AMOUNT TOTAL</b></td>
				</tr>
				<tr class='bg-info'>
					<td>GROSS PAY</td>
					<td align='right'><b><?php echo number_format($rnet['gross_pay'], 2); ?></b></td>
				</tr>
				<tr class='bg-danger'>
					<td>DEDUCTIONS</td>
					<td align='right'><b><?php echo number_format($rnet['deductions'], 2); ?></b></td>
				</tr>

				<tr class='bg-success'>
					<td>NET PAY</td>
					<td align='right'><b><?php if (isset($_REQUEST['review_final'])) {
												echo number_format($rnet['gross_pay'] - $rnet['deductions'], 2);
											} else {
												echo number_format($rnet['gross_pay'] - $rnet['deductions'], 2);
											} ?></b>
					</td>
				</tr>

				<tr>
					<td>SSS EMPLOYER</td>
					<td align='right'><b><?php echo number_format($rnet['employer_sss'], 2); ?></b></td>
				</tr>
				<tr>
					<td>PHILHEALTH EMPLOYER</td>
					<td align='right'><b><?php echo number_format($rnet['ph'], 2); ?></b></td>
				</tr>
			</table>
			<br>

		</td>
	</tr>
</table>

<?php
//para sa payroll_summary lang
if (isset($_REQUEST['review_final'])) {
	if ($_REQUEST['department'] == 'ALL') {
		$pp9 = $_REQUEST['payroll_period'];
		$gross9 = $rnet['gross_pay'];
		$deduct9 = $rnet['deductions'];
		$net9 = $rnet['gross_pay'] - $rnet['deductions'];
		$sssemp9 = $rnet['employer_sss'];
		$phemp9 = $rnet['ph'];

		$s9 = "insert into payroll_summary (data_id,payroll_period,grosspay,deductions,netpay,sss_employer,ph_employer,status)
				 values ('','$pp9','$gross9','$deduct9','$net9','$sssemp9','$phemp9',0)";
		mysql_query($s9) or die(mysql_error());
	}
}
?>