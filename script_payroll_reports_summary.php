<?php 
session_start();
include('connection/conn.php');
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); } ?>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/bootstrap.min.css">

<style>
@page { size 8.5in 11in; margin: 2cm }
div.page { page-break-after: always }
.w3-tiny{font-size:10px!important}
.w3-small{font-size:12px!important}
.w3-hover-pale-red:hover{color:#000!important;background-color:#ffdddd!important}
</style>

<?php
$s="select * from company";
$q=mysql_query($s) or die(mysql_error());
$r=mysql_fetch_assoc($q);
	   
//REVIEW PROCESS TO FINALIZE PAYROLL AREA Total Start Only -----------------------
if(isset($_REQUEST['review_final']))
{   
    $payroll_period=$_REQUEST['payroll_period'];
    $query="select 
       sum(e_total_cuttoff_hours_final + e_overtime_final + e_restday_pay_final + e_restday_pay_overtime_final + e_nightshift_final + e_overtime_nightshift_final + e_regular_holiday_final + e_regular_holiday_overtime_final + e_special_holiday_final + e_special_holiday_overtime_final + e_sick_leave_final + e_vacation_leave_final + e_solo_parent_leave_final + e_allowance15 + e_allowance30 + e_add_allowance - e_lates_final - e_absences_final - e_undertime_final) as gross_pay,
	   sum(e_sss + e_pagibig + e_philhealth + e_tax + e_ca + e_pagibig_loan + e_pagibig_loan_calamity + e_salary_loan + e_salary_calamity_loan + e_sss_calamity_loan + e_sss_loan + e_other_charges + e_veterans_loan + e_over_in_previous_pay) as deductions,
       sum(ec_sss) as employer_sss,
	   sum(e_tax) as tax,
	   sum(e_allowance15) as allow15,
	   sum(e_allowance30) as allow30,
	   sum(e_sss) as sss,
	   sum(e_pagibig) as pagibig,
	   sum(e_philhealth) as ph,
	   sum(e_sss_loan) as sss_loan,
	   sum(e_pagibig_loan) as pagibig_loan,
	   sum(e_pagibig_loan_calamity) as calamity,
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
	   sum(e_undertime) as undertime_t";

echo "<table border='1'>";
echo "<tr><td align='center' colspan='52'>".$r['company_name']."</br><small>".$r['company_address']."<br>Payroll Process Period Period ".date('m/d/Y',strtotime($_REQUEST['payroll_period']))."</small></td></tr>"; 

echo "<tr class='w3-tiny' align='center'>
          <td class='bg-success'>COMPANY</td>
		  <td class='bg-success'>DEPARTMENT</td>
		  
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
		  <td class='bg-info'>ALW15</td>
		  <td class='bg-info'>ALW30</td>
		  <td class='bg-info'>Lates</td>
		  <td class='bg-info'>Absences</td>
		  <td class='bg-info'>Undertime</td>
		  
		  <td class='text-primary bg-info'>Gross Pay</td>
		  
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
		  
		  <td class='bg-danger text-danger'>Total Deductions</td>  
		  <td class='bg-success text-success'>Net Pay</td>
		  <td>SSS Employer</td>
		  <td>Philhealth Employer</td>
	  </tr>";
	  
	$s1="$query from payroll where payroll_period='$payroll_period' and e_total_cuttoff_hours>0 and e_department='ADMIN'";	
    $q1=mysql_query($s1) or die(mysql_error());
    $r1=mysql_fetch_assoc($q1);
	echo "<tr align='right' class='w3-hover-pale-red'>
          <td align='center'>ALC</td>
		  <td align='center'>ADMIN</td>";
include('script_payroll_summary_per_dept.php');
echo "</tr>";
	  
	  $s1="$query from payroll where payroll_period='$payroll_period' and e_total_cuttoff_hours>0 and e_department='FINANCE'";	
    $q1=mysql_query($s1) or die(mysql_error());
    $r1=mysql_fetch_assoc($q1);
	echo "<tr align='right' class='w3-hover-pale-red'>
          <td align='center'>ALC</td>
		  <td align='center'>FINANCE</td>";
include('script_payroll_summary_per_dept.php');
echo "</tr>";
	
	$s1="$query from payroll where payroll_period='$payroll_period' and e_total_cuttoff_hours>0 and e_department='IT'";	
    $q1=mysql_query($s1) or die(mysql_error());
    $r1=mysql_fetch_assoc($q1);
	echo "<tr align='right' class='w3-hover-pale-red'>
          <td align='center'>ALC</td>
		  <td align='center'>IT</td>";
include('script_payroll_summary_per_dept.php');
echo "</tr>";
	  
	  $s1="$query from payroll where payroll_period='$payroll_period' and e_total_cuttoff_hours>0 and e_department='ONCALL'";	
    $q1=mysql_query($s1) or die(mysql_error());
    $r1=mysql_fetch_assoc($q1);
	echo "<tr align='right' class='w3-hover-pale-red'>
          <td align='center'>ALC</td>
		  <td align='center'>ONCALL</td>";
include('script_payroll_summary_per_dept.php');
echo "</tr>";
	  
	$s1="$query from payroll where payroll_period='$payroll_period' and e_total_cuttoff_hours>0 and e_department='PRODUCTION'";	
    $q1=mysql_query($s1) or die(mysql_error());
    $r1=mysql_fetch_assoc($q1);
	echo "<tr align='right' class='w3-hover-pale-red'>
          <td align='center'>ALC</td>
		  <td align='center'>PRODUCTION</td>";
include('script_payroll_summary_per_dept.php');
echo "</tr>";
	  
	  $s1="$query from payroll where payroll_period='$payroll_period' and e_total_cuttoff_hours>0 and e_department='SALES'";	
    $q1=mysql_query($s1) or die(mysql_error());
    $r1=mysql_fetch_assoc($q1);
	echo "<tr align='right' class='w3-hover-pale-red'>
          <td align='center'>ALC</td>
		  <td align='center'>SALES</td>";
include('script_payroll_summary_per_dept.php');
echo "</tr>";
	  
	  $s1="$query from payroll where payroll_period='$payroll_period' and e_total_cuttoff_hours>0 and e_department='SANJOSE FINANCE'";	
    $q1=mysql_query($s1) or die(mysql_error());
    $r1=mysql_fetch_assoc($q1);
	echo "<tr align='right' class='w3-hover-pale-red'>
          <td align='center'>ALC</td>
		  <td align='center'>SANJOSE FINANCE</td>";
include('script_payroll_summary_per_dept.php');
echo "</tr>";
	  
	$s1="$query from payroll where payroll_period='$payroll_period' and e_total_cuttoff_hours>0 and e_department='SANJOSE PRODUCTION'";	
    $q1=mysql_query($s1) or die(mysql_error());
    $r1=mysql_fetch_assoc($q1);
	echo "<tr align='right' class='w3-hover-pale-red'>
          <td align='center'>ALC</td>
		  <td align='center'>SANJOSE PRODUCTION</td>";
include('script_payroll_summary_per_dept.php');
echo "</tr>";
	  
	$s1="$query from payroll where payroll_period='$payroll_period' and e_total_cuttoff_hours>0 and e_department='SANJOSE SALES'";	
    $q1=mysql_query($s1) or die(mysql_error());
    $r1=mysql_fetch_assoc($q1);
	echo "<tr align='right' class='w3-hover-pale-red'>
          <td align='center'>ALC</td>
		  <td align='center'>SANJOSE SALES</td>";
include('script_payroll_summary_per_dept.php');
echo "</tr>";
	  
	$s1="$query from payroll where payroll_period='$payroll_period' and e_total_cuttoff_hours>0 and e_department='SANPEDRO FINANCE'";	
    $q1=mysql_query($s1) or die(mysql_error());
    $r1=mysql_fetch_assoc($q1);
	echo "<tr align='right' class='w3-hover-pale-red'>
          <td align='center'>ALC</td>
		  <td align='center'>SANPEDRO FINANCE</td>";
include('script_payroll_summary_per_dept.php');
echo "</tr>";
	  
	$s1="$query from payroll where payroll_period='$payroll_period' and e_total_cuttoff_hours>0 and e_department='SANPEDRO PRODUCTION'";	
    $q1=mysql_query($s1) or die(mysql_error());
    $r1=mysql_fetch_assoc($q1);
	echo "<tr align='right' class='w3-hover-pale-red'>
          <td align='center'>ALC</td>
		  <td align='center'>SANPEDRO PRODUCTION</td>";
include('script_payroll_summary_per_dept.php');
echo "</tr>";
	  
	  $s1="$query from payroll where payroll_period='$payroll_period' and e_total_cuttoff_hours>0 and e_department='SANPEDRO SALES'";	
    $q1=mysql_query($s1) or die(mysql_error());
    $r1=mysql_fetch_assoc($q1);
	echo "<tr align='right' class='w3-hover-pale-red'>
          <td align='center'>ALC</td>
		  <td align='center'>SANPEDRO SALES</td>";
include('script_payroll_summary_per_dept.php');
echo "</tr>";
	  
	  $s1="$query from payroll where payroll_period='$payroll_period' and e_total_cuttoff_hours>0 and e_department='SM FINANCE'";	
    $q1=mysql_query($s1) or die(mysql_error());
    $r1=mysql_fetch_assoc($q1);
	echo "<tr align='right' class='w3-hover-pale-red'>
          <td align='center'>ALC</td>
		  <td align='center'>SM FINANCE</td>";
include('script_payroll_summary_per_dept.php');
echo "</tr>";
	  
	  $s1="$query from payroll where payroll_period='$payroll_period' and e_total_cuttoff_hours>0 and e_department='SM PRODUCTION'";	
    $q1=mysql_query($s1) or die(mysql_error());
    $r1=mysql_fetch_assoc($q1);
	echo "<tr align='right' class='w3-hover-pale-red'>
          <td align='center'>ALC</td>
		  <td align='center'>SM PRODUCTION</td>";
include('script_payroll_summary_per_dept.php');
echo "</tr>";
	  
	  $s1="$query from payroll where payroll_period='$payroll_period' and e_total_cuttoff_hours>0 and e_department='SM SALES'";	
    $q1=mysql_query($s1) or die(mysql_error());
    $r1=mysql_fetch_assoc($q1);
	echo "<tr align='right' class='w3-hover-pale-red'>
          <td align='center'>ALC</td>
		  <td align='center'>SM SALES</td>";
include('script_payroll_summary_per_dept.php');
echo "</tr>";
	  
	  $s1="$query from payroll where payroll_period='$payroll_period' and e_total_cuttoff_hours>0 and e_department='SUPPLY AND PROCUREMENT'";	
    $q1=mysql_query($s1) or die(mysql_error());
    $r1=mysql_fetch_assoc($q1);
	echo "<tr align='right' class='w3-hover-pale-red'>
          <td align='center'>ALC</td>
		  <td align='center'>SUPPLY AND PROCUREMENT</td>";
include('script_payroll_summary_per_dept.php');
echo "</tr>";

$s1="$query from payroll where payroll_period='$payroll_period' and e_total_cuttoff_hours>0 and e_department='COSTPLUS'";	
$q1=mysql_query($s1) or die(mysql_error());
$r1=mysql_fetch_assoc($q1);
echo "<tr align='right' class='w3-hover-pale-red'>
	  <td align='center'>ALC</td>
	  <td align='center'>COSTPLUS</td>";
include('script_payroll_summary_per_dept.php');
echo "</tr>";
	  
	  $s1="$query from payroll where payroll_period='$payroll_period' and e_total_cuttoff_hours>0 and e_department='CBI'";	
    $q1=mysql_query($s1) or die(mysql_error());
    $r1=mysql_fetch_assoc($q1);
	echo "<tr align='right' class='w3-hover-pale-red'>
          <td align='center'>CBI</td>
		  <td align='center'>CIRCON</td>";
include('script_payroll_summary_per_dept.php');
echo "</tr>";
	  
	  $s1="$query from payroll where payroll_period='$payroll_period' and e_total_cuttoff_hours>0 and e_department='KAL'";	
    $q1=mysql_query($s1) or die(mysql_error());
    $r1=mysql_fetch_assoc($q1);
	echo "<tr align='right' class='w3-hover-pale-red'>
          <td align='center'>KAL</td>
		  <td align='center'>KALIPAYAN</td>";
include('script_payroll_summary_per_dept.php');
echo "</tr>";
	  
	$s1="$query from payroll where payroll_period='$payroll_period' and e_total_cuttoff_hours>0 and e_department='KAT'";	
    $q1=mysql_query($s1) or die(mysql_error());
    $r1=mysql_fetch_assoc($q1);
	echo "<tr align='right' class='w3-hover-pale-red'>
          <td align='center'>KAT</td>
		  <td align='center'>KATRINKAS</td>";
include('script_payroll_summary_per_dept.php');
echo "</tr>";
	  
	$s1="$query from payroll where payroll_period='$payroll_period' and e_total_cuttoff_hours>0 and e_department='LH'";	
    $q1=mysql_query($s1) or die(mysql_error());
    $r1=mysql_fetch_assoc($q1);
	echo "<tr align='right' class='w3-hover-pale-red'>
          <td align='center'>LH</td>
		  <td align='center'>LILYHILL</td>";
include('script_payroll_summary_per_dept.php');
echo "</tr>";
	  
echo "</table>";		
		
}
//REVIEW PROCESS TO FINALIZE PAYROLL AREA SUMMARY TOTAL ONLY -----------------------



//REPORTS ONLY SUMMARY ONLY------------------
else
{
	$sdate=$_REQUEST['sdate'];
    $edate=$_REQUEST['edate'];
    $query="select 
       sum(e_total_cuttoff_hours_final + e_overtime_final + e_restday_pay_final + e_restday_pay_overtime_final + e_nightshift_final + e_overtime_nightshift_final + e_regular_holiday_final + e_regular_holiday_overtime_final + e_special_holiday_final + e_special_holiday_overtime_final + e_sick_leave_final + e_vacation_leave_final + e_solo_parent_leave_final + e_allowance15 + e_allowance30 + e_add_allowance - e_lates_final - e_absences_final - e_undertime_final) as gross_pay,
	   sum(e_sss + e_pagibig + e_philhealth + e_tax + e_ca + e_pagibig_loan + e_pagibig_loan_calamity + e_salary_loan + e_salary_calamity_loan + e_sss_calamity_loan + e_sss_loan + e_other_charges + e_veterans_loan + e_over_in_previous_pay) as deductions,
       sum(ec_sss) as employer_sss,
	   sum(e_tax) as tax,
	   sum(e_allowance15) as allow15,
	   sum(e_allowance30) as allow30,
	   sum(e_sss) as sss,
	   sum(e_pagibig) as pagibig,
	   sum(e_philhealth) as ph,
	   sum(e_sss_loan) as sss_loan,
	   sum(e_pagibig_loan) as pagibig_loan,
	   sum(e_pagibig_loan_calamity) as calamity,
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
	   sum(e_undertime) as undertime_t";
	
echo "<table border='1'>";
echo "<tr><td align='center' colspan='52'>".$r['company_name']."</br><small>".$r['company_address']."<br>Payroll Process Period ".date('m/d/Y',strtotime($_REQUEST['sdate']))." - ".date('m/d/Y',strtotime($_REQUEST['edate']))."</small></td></tr>"; 
echo "<tr class='w3-tiny' align='center'>
          <td class='bg-success'>COMPANY</td>
		  <td class='bg-success'>DEPARTMENT</td>
		  
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
		  <td class='bg-info'>ALW15</td>
		  <td class='bg-info'>ALW30</td>
		  <td class='bg-info'>Lates</td>
		  <td class='bg-info'>Absences</td>
		  <td class='bg-info'>Undertime</td>
		  
		  <td class='text-primary bg-info'>Gross Pay</td>
		  
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
		  
		  <td class='bg-danger text-danger'>Total Deductions</td>  
		  <td class='bg-success text-success'>Net Pay</td>
		  <td>SSS Employer</td>
		  <td>Philhealth Employer</td>
	  </tr>";	
	   
	  
    $s1="$query from payroll where payroll_period>='$sdate' and payroll_period<='$edate' and finalized=1 and e_department='ADMIN'";
	$q1=mysql_query($s1) or die(mysql_error());
    $r1=mysql_fetch_assoc($q1);	  
echo "<tr align='right' class='w3-hover-pale-red'>
          <td align='center'>ALC</td>
		  <td align='center'>ADMIN</td>";
		  include('script_payroll_summary_per_dept.php');
echo "</tr>";
	  
	$s1="$query from payroll where payroll_period>='$sdate' and payroll_period<='$edate' and finalized=1 and e_department='FINANCE'";
	$q1=mysql_query($s1) or die(mysql_error());
    $r1=mysql_fetch_assoc($q1);	  
echo "<tr align='right' class='w3-hover-pale-red'>
          <td align='center'>ALC</td>
		  <td align='center'>FINANCE</td>";
		  include('script_payroll_summary_per_dept.php');
echo "</tr>";
	  
	  
	  $s1="$query from payroll where payroll_period>='$sdate' and payroll_period<='$edate' and finalized=1 and e_department='IT'";
	$q1=mysql_query($s1) or die(mysql_error());
    $r1=mysql_fetch_assoc($q1);	  
echo "<tr align='right' class='w3-hover-pale-red'>
          <td align='center'>ALC</td>
		  <td align='center'>IT</td>";
		  include('script_payroll_summary_per_dept.php');
echo "</tr>";
	
	
	$s1="$query from payroll where payroll_period>='$sdate' and payroll_period<='$edate' and finalized=1 and e_department='ONCALL'";
	$q1=mysql_query($s1) or die(mysql_error());
    $r1=mysql_fetch_assoc($q1);	  
echo "<tr align='right' class='w3-hover-pale-red'>
          <td align='center'>ALC</td>
		  <td align='center'>ONCALL</td>";
include('script_payroll_summary_per_dept.php');
echo "</tr>";
	
	$s1="$query from payroll where payroll_period>='$sdate' and payroll_period<='$edate' and finalized=1 and e_department='PRODUCTION'";
	$q1=mysql_query($s1) or die(mysql_error());
    $r1=mysql_fetch_assoc($q1);	  
echo "<tr align='right' class='w3-hover-pale-red'>
          <td align='center'>ALC</td>
		  <td align='center'>PRODUCTION</td>";
include('script_payroll_summary_per_dept.php');
echo "</tr>";
	
	  $s1="$query from payroll where payroll_period>='$sdate' and payroll_period<='$edate' and finalized=1 and e_department='SALES'";
	$q1=mysql_query($s1) or die(mysql_error());
    $r1=mysql_fetch_assoc($q1);	  
echo "<tr align='right' class='w3-hover-pale-red'>
          <td align='center'>ALC</td>
		  <td align='center'>SALES</td>";
include('script_payroll_summary_per_dept.php');
echo "</tr>";
	
	$s1="$query from payroll where payroll_period>='$sdate' and payroll_period<='$edate' and finalized=1 and e_department='SANJOSE FINANCE'";
	$q1=mysql_query($s1) or die(mysql_error());
    $r1=mysql_fetch_assoc($q1);	  
echo "<tr align='right' class='w3-hover-pale-red'>
          <td align='center'>ALC</td>
		  <td align='center'>SANJOSE FINANCE</td>";
include('script_payroll_summary_per_dept.php');
echo "</tr>";
	
	$s1="$query from payroll where payroll_period>='$sdate' and payroll_period<='$edate' and finalized=1 and e_department='SANJOSE PRODUCTION'";
	$q1=mysql_query($s1) or die(mysql_error());
    $r1=mysql_fetch_assoc($q1);	  
echo "<tr align='right' class='w3-hover-pale-red'>
          <td align='center'>ALC</td>
		  <td align='center'>SANJOSE PRODUCTION</td>";
include('script_payroll_summary_per_dept.php');
echo "</tr>";
	
	$s1="$query from payroll where payroll_period>='$sdate' and payroll_period<='$edate' and finalized=1 and e_department='SANJOSE SALES'";
	$q1=mysql_query($s1) or die(mysql_error());
    $r1=mysql_fetch_assoc($q1);	  
echo "<tr align='right' class='w3-hover-pale-red'>
          <td align='center'>ALC</td>
		  <td align='center'>SANJOSE SALES</td>";
include('script_payroll_summary_per_dept.php');
echo "</tr>";
	
	$s1="$query from payroll where payroll_period>='$sdate' and payroll_period<='$edate' and finalized=1 and e_department='SANPEDRO FINANCE'";
	$q1=mysql_query($s1) or die(mysql_error());
    $r1=mysql_fetch_assoc($q1);	  
echo "<tr align='right' class='w3-hover-pale-red'>
          <td align='center'>ALC</td>
		  <td align='center'>SANPEDRO FINANCE</td>";
include('script_payroll_summary_per_dept.php');
echo "</tr>";
	
	$s1="$query from payroll where payroll_period>='$sdate' and payroll_period<='$edate' and finalized=1 and e_department='SANPEDRO PRODUCTION'";
	$q1=mysql_query($s1) or die(mysql_error());
    $r1=mysql_fetch_assoc($q1);	  
echo "<tr align='right' class='w3-hover-pale-red'>
          <td align='center'>ALC</td>
		  <td align='center'>SANPEDRO PRODUCTION</td>";
include('script_payroll_summary_per_dept.php');
echo "</tr>";
	
	$s1="$query from payroll where payroll_period>='$sdate' and payroll_period<='$edate' and finalized=1 and e_department='SANPEDRO SALES'";
	$q1=mysql_query($s1) or die(mysql_error());
    $r1=mysql_fetch_assoc($q1);	  
echo "<tr align='right' class='w3-hover-pale-red'>
          <td align='center'>ALC</td>
		  <td align='center'>SANPEDRO SALES</td>";
include('script_payroll_summary_per_dept.php');
echo "</tr>";
	
	$s1="$query from payroll where payroll_period>='$sdate' and payroll_period<='$edate' and finalized=1 and e_department='SM FINANCE'";
	$q1=mysql_query($s1) or die(mysql_error());
    $r1=mysql_fetch_assoc($q1);	  
echo "<tr align='right' class='w3-hover-pale-red'>
          <td align='center'>ALC</td>
		  <td align='center'>SM FINANCE</td>";
include('script_payroll_summary_per_dept.php');
echo "</tr>";
	
	$s1="$query from payroll where payroll_period>='$sdate' and payroll_period<='$edate' and finalized=1 and e_department='SM PRODUCTION'";
	$q1=mysql_query($s1) or die(mysql_error());
    $r1=mysql_fetch_assoc($q1);	  
echo "<tr align='right' class='w3-hover-pale-red'>
          <td align='center'>ALC</td>
		  <td align='center'>SM PRODUCTION</td>";
include('script_payroll_summary_per_dept.php');
echo "</tr>";
	
	$s1="$query from payroll where payroll_period>='$sdate' and payroll_period<='$edate' and finalized=1 and e_department='SM SALES'";
	$q1=mysql_query($s1) or die(mysql_error());
    $r1=mysql_fetch_assoc($q1);	  
echo "<tr align='right' class='w3-hover-pale-red'>
          <td align='center'>ALC</td>
		  <td align='center'>SM SALES</td>";
include('script_payroll_summary_per_dept.php');
echo "</tr>";
	
	$s1="$query from payroll where payroll_period>='$sdate' and payroll_period<='$edate' and finalized=1 and e_department='SUPPLY AND PROCUREMENT'";
	$q1=mysql_query($s1) or die(mysql_error());
    $r1=mysql_fetch_assoc($q1);	  
echo "<tr align='right' class='w3-hover-pale-red'>
          <td align='center'>ALC</td>
		  <td align='center'>SUPPLY AND PROCUREMENT</td>";
include('script_payroll_summary_per_dept.php');
echo "</tr>";

$s1="$query from payroll where payroll_period>='$sdate' and payroll_period<='$edate' and finalized=1 and e_department='COSTPLUS'";
$q1=mysql_query($s1) or die(mysql_error());
$r1=mysql_fetch_assoc($q1);	  
echo "<tr align='right' class='w3-hover-pale-red'>
	  <td align='center'>ALC</td>
	  <td align='center'>COSTPLUS</td>";
include('script_payroll_summary_per_dept.php');
echo "</tr>";
	
	$s1="$query from payroll where payroll_period>='$sdate' and payroll_period<='$edate' and finalized=1 and e_department='CBI'";
	$q1=mysql_query($s1) or die(mysql_error());
    $r1=mysql_fetch_assoc($q1);	  
echo "<tr align='right' class='w3-hover-pale-red'>
          <td align='center'>CBI</td>
		  <td align='center'>CIRCON</td>";
include('script_payroll_summary_per_dept.php');
echo "</tr>";
	
	$s1="$query from payroll where payroll_period>='$sdate' and payroll_period<='$edate' and finalized=1 and e_department='KAL'";
	$q1=mysql_query($s1) or die(mysql_error());
    $r1=mysql_fetch_assoc($q1);	  
echo "<tr align='right' class='w3-hover-pale-red'>
          <td align='center'>KAL</td>
		  <td align='center'>KALIPAYAN</td>";
include('script_payroll_summary_per_dept.php');
echo "</tr>";
	
	$s1="$query from payroll where payroll_period>='$sdate' and payroll_period<='$edate' and finalized=1 and e_department='KAT'";
	$q1=mysql_query($s1) or die(mysql_error());
    $r1=mysql_fetch_assoc($q1);	  
echo "<tr align='right' class='w3-hover-pale-red'>
          <td align='center'>KAT</td>
		  <td align='center'>KATRINKAS</td>";
include('script_payroll_summary_per_dept.php');
echo "</tr>";
	
	$s1="$query from payroll where payroll_period>='$sdate' and payroll_period<='$edate' and finalized=1 and e_department='LH'";
	$q1=mysql_query($s1) or die(mysql_error());
    $r1=mysql_fetch_assoc($q1);	  
echo "<tr align='right' class='w3-hover-pale-red'>
          <td align='center'>LH</td>
		  <td align='center'>LILYHILL</td>";
include('script_payroll_summary_per_dept.php');
echo "</tr>";
	
echo "</table>";		

}

echo "<br/>";

if(isset($_REQUEST['payroll_period'])) { $payroll_period=$_REQUEST['payroll_period']; }
else { $payroll_period=$_REQUEST['sdate']; }

$sleave="SELECT 
			( SELECT COUNT(e_sick_leave) FROM payroll WHERE e_sick_leave!=0 AND payroll_period='$payroll_period' ) AS count_sl,
			( SELECT COUNT(e_vacation_leave) FROM payroll WHERE e_vacation_leave!=0 AND payroll_period='$payroll_period' ) AS count_vl,
			( SELECT COUNT(e_solo_parent_leave) FROM payroll WHERE e_solo_parent_leave!=0 AND payroll_period='$payroll_period' ) AS count_spl
		";
$qleave=mysql_query($sleave) or die(mysql_error());
$rleave=mysql_fetch_assoc($qleave);		

echo "<table>
		<tr>
			<td> &nbsp;&nbsp;&nbsp; Sick Leave: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$rleave['count_sl']."&nbsp;&nbsp;&nbsp;";
				
				if(isset($_REQUEST['payroll_period']))
				{
					echo "<a class='w3-tiny' href='script_payroll_reports_summary.php?payroll_period=".$_REQUEST['payroll_period']."&sl=1'><i>show</i></a>";
				}
				else
				{ 
					echo "<a class='w3-tiny' href='script_payroll_reports_summary.php?sdate=".$_REQUEST['sdate']."&edate=".$_REQUEST['edate']."&sl=1'><i>show</i></a>";
				}
			
	  echo "</td>
		</tr>
		
		<tr>
			<td> &nbsp;&nbsp;&nbsp; Vacation Leave: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$rleave['count_vl']."&nbsp;&nbsp;&nbsp;";
			
				if(isset($_REQUEST['payroll_period']))
				{ 
					echo "<a class='w3-tiny' href='script_payroll_reports_summary.php?payroll_period=".$_REQUEST['payroll_period']."&vl=1'><i>show</i></a>";
				}
				else
				{
					echo "<a class='w3-tiny' href='script_payroll_reports_summary.php?sdate=".$_REQUEST['sdate']."&edate=".$_REQUEST['edate']."&vl=1'><i>show</i></a>";
				}
				
	  echo "</td>
		</tr>
		
		<tr>
			<td> &nbsp;&nbsp;&nbsp; Solo Parent Leave: &nbsp;&nbsp;&nbsp;&nbsp;".$rleave['count_spl']."&nbsp;&nbsp;&nbsp;";
			
				if(isset($_REQUEST['payroll_period']))
				{ 
					echo "<a class='w3-tiny' href='script_payroll_reports_summary.php?payroll_period=".$_REQUEST['payroll_period']."&spl=1'><i>show</i></a>";
				}
				else
				{
					echo "<a class='w3-tiny' href='script_payroll_reports_summary.php?sdate=".$_REQUEST['sdate']."&edate=".$_REQUEST['edate']."&spl=1'><i>show</i></a>";
				}
				
	  echo "</td>
		</tr>
		
		<tr>
		 <td colspan='5'>
		 <br/><div class='container'>";
		 
			
			//SL LIST
			if(isset($_REQUEST['sl']))
			{
				$s_sl="SELECT e_company,e_lname,e_sick_leave,e_sick_leave_final FROM payroll WHERE e_sick_leave!=0 AND payroll_period='$payroll_period' ORDER BY e_company ASC, e_lname ASC";
				$q_sl=mysql_query($s_sl) or die(mysql_error());
				$r_sl=mysql_fetch_assoc($q_sl);
				
			echo "Sick Leave List<br/><table class='w3-tiny' border='1'>
					
					<tr align='center' class='bg-info'>
						<td>&nbsp;#&nbsp;</td>
						<td>&nbsp;COMP&nbsp;</td>
						<td>&nbsp;NAME&nbsp;</td>
						<td>&nbsp;DAY&nbsp;</td>
						<td>&nbsp;AMOUNT&nbsp;</td>
					</tr>";
					$x=1;
				do{	
					echo "<tr class='w3-hover-pale-red'>
							<td>".$x++."</td>
							<td>".$r_sl['e_company']."</td>
							<td>".$r_sl['e_lname']."</td>
							<td align='center'>".$r_sl['e_sick_leave']."</td>
							<td align='right'>".number_format($r_sl['e_sick_leave_final'],2)."</td>
						  </tr>";
				}while($r_sl=mysql_fetch_assoc($q_sl));	
				
				echo "</table><br/>";
			}	 
			
			//VL LIST
			if(isset($_REQUEST['vl']))
			{
				$s_vl="SELECT e_company,e_lname,e_vacation_leave,e_vacation_leave_final FROM payroll WHERE e_vacation_leave!=0 AND payroll_period='$payroll_period' ORDER BY e_company ASC, e_lname ASC";
				$q_vl=mysql_query($s_vl) or die(mysql_error());
				$r_vl=mysql_fetch_assoc($q_vl);
				
			echo "Vacation Leave List<br/><table class='w3-tiny' border='1'>
					
					<tr align='center' class='bg-info'>
						<td>&nbsp;#&nbsp;</td>
						<td>&nbsp;COMP&nbsp;</td>
						<td>&nbsp;NAME&nbsp;</td>
						<td>&nbsp;DAY&nbsp;</td>
						<td>&nbsp;AMOUNT&nbsp;</td>
					</tr>";
					$x=1;
				do{	
					echo "<tr class='w3-hover-pale-red'>
							<td>".$x++."</td>
							<td>".$r_vl['e_company']."</td>
							<td>".$r_vl['e_lname']."</td>
							<td align='center'>".$r_vl['e_vacation_leave']."</td>
							<td align='right'>".number_format($r_vl['e_vacation_leave_final'],2)."</td>
						  </tr>";
				}while($r_vl=mysql_fetch_assoc($q_vl));	
				
				echo "</table><br/>";
			}	

			//Solo Parent LIST
			if(isset($_REQUEST['spl']))
			{
				$s_spl="SELECT e_company,e_lname,e_solo_parent_leave,e_solo_parent_leave_final FROM payroll WHERE e_solo_parent_leave!=0 AND payroll_period='$payroll_period' ORDER BY e_company ASC, e_lname ASC";
				$q_spl=mysql_query($s_spl) or die(mysql_error());
				$r_spl=mysql_fetch_assoc($q_spl);
				
			echo "Solo Parent Leave List<br/><table class='w3-tiny' border='1'>
					
					<tr align='center' class='bg-info'>
						<td>&nbsp;#&nbsp;</td>
						<td>&nbsp;COMP&nbsp;</td>
						<td>&nbsp;NAME&nbsp;</td>
						<td>&nbsp;DAY&nbsp;</td>
						<td>&nbsp;AMOUNT&nbsp;</td>
					</tr>";
					$x=1;
				do{	
					echo "<tr class='w3-hover-pale-red'>
							<td>".$x++."</td>
							<td>".$r_spl['e_company']."</td>
							<td>".$r_spl['e_lname']."</td>
							<td align='center'>".$r_spl['e_solo_parent_leave']."</td>
							<td align='right'>".number_format($r_spl['e_solo_parent_leave_final'],2)."</td>
						  </tr>";
				}while($r_spl=mysql_fetch_assoc($q_spl));	
				
				echo "</table><br/>";
			}
				 
	echo "</div>
		  </td>
		</tr>
	  </table>";
	  
	  

?>
