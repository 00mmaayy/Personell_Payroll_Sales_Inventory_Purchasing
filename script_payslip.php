<title>PaySlip</title>
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
//START OF 1ST PAGE PAYSLIP--------------

$payroll_period=$_REQUEST['payroll_period'];

//search per company only
if($_REQUEST['company']!="")
  { 
    $company=$_REQUEST['company']; 
	$sql_company="and e_company='$company' "; 
  }
  else
  { $sql_company=""; }


//search per employee only
if($_REQUEST['e_no']!="")
  { 
    $e_no=$_REQUEST['e_no']; 
    $sql_eno="and e_no='$e_no' ";
  }
  else
  { $sql_eno=""; }


$sm2="select * from payroll where finalized=1 and payroll_period='$payroll_period' $sql_eno $sql_company order by e_company,e_department,e_lname asc limit 1 ";
$qm2=mysql_query($sm2) or die(mysql_error());
$rm2=mysql_fetch_assoc($qm2);

echo "<table border='1'><tr>";

do{

$e_no=$rm2['e_no'];
$sm1="select * from employee where e_no='$e_no'";
$qm1=mysql_query($sm1) or die(mysql_error());
$rm1=mysql_fetch_assoc($qm1);

$e_comp=$rm1['e_company'];
$s="select * from company where company='$e_comp'";
$q=mysql_query($s) or die(mysql_error());
$r=mysql_fetch_assoc($q);

$company_name=$r['company_name'];
$company_address=$r['company_address'];

?>
<div class="page">
<td>

 <table width='380' border="1">
 <tr height="50">
   <td colspan="2" align="center">
     <table>
	   <tr>
	     <td>
		  <img src="img/<?php echo $r['company']; ?>.jpg" height="35" width="80"/>
		 </td>
		 <td align="center">
          <div class='w3-tiny'><strong><?php echo "$company_name"; ?></strong><br><?php echo "$company_address"; ?></div>
         </td>
	   </tr>
	 </table>      
   </td>
 </tr>
 
 <tr align='center'>
   <td colspan='2'><span class='w3-tiny'>DEPT:</span> <small><strong><?php echo $rm2['e_department']; ?></strong></small></td>
 </tr>
 <tr>
   <td><small>&nbsp;ID No. <strong><?php echo $rm2['e_no']; ?></strong></small></td>
   <td><small>&nbsp;<strong><?php echo $rm1['e_lname'].", ".$rm1['e_fname']; ?></strong></small></td>
 </tr>
 
 <tr>
   <td><small>&nbsp;Payroll Period: <strong><?php echo date('m/d/Y', strtotime($rm2['payroll_period'])); ?></strong></small></td>
   <td><small>&nbsp;Rate/Day: <strong><?php echo number_format($rm2['e_basic_pay'],2); ?></strong></small></td>
 </tr>
 
 <tr align='center' class='w3-tiny'>
   <td>EARNINGS</td><td>DEDUCTIONS</td>
 </tr>
 
 <tr>
   <td>
   
	   <table width='190' border='0'>
	   <tr align='center'>
	   <td>&nbsp;</td>
	   <td class='w3-tiny'>Hours&nbsp;</td>
	   <td class='w3-tiny'>Amount</td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Basic Pay</td>
	   <td align='center'><small><?php echo number_format($rm2['e_total_cuttoff_hours'],2); ?></small></td>
	   <td align='right'><small><?php echo number_format($rm2['e_total_cuttoff_hours_final'],2); ?>&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Overtime</td>
	   <td align='center'><small><?php echo number_format($rm2['e_overtime'],2); ?></small></td>
	   <td align='right'><small><?php echo number_format($rm2['e_overtime_final'],2); ?>&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Day Off</td>
	   <td align='center'><small><?php echo number_format($rm2['e_restday_pay'],2); ?></small></td>
	   <td align='right'><small><?php echo number_format($rm2['e_restday_pay_final'],2); ?>&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Day Off OT</td>
	   <td align='center'><small><?php echo number_format($rm2['e_restday_pay_overtime'],2); ?></small></td>
	   <td align='right'><small><?php echo number_format($rm2['e_restday_pay_overtime_final'],2); ?>&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Night Diff</td>
	   <td align='center'><small><?php echo number_format($rm2['e_nightshift'],2); ?></small></td>
	   <td align='right'><small><?php echo number_format($rm2['e_nightshift_final'],2); ?>&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Night Diff OT</td>
	   <td align='center'><small><?php echo number_format($rm2['e_overtime_nightshift'],2); ?></small></td>
	   <td align='right'><small><?php echo number_format($rm2['e_overtime_nightshift_final'],2); ?>&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Reg Holiday</td>
	   <td align='center'><small><?php echo number_format($rm2['e_regular_holiday'],2); ?></small></td>
	   <td align='right'><small><?php echo number_format($rm2['e_regular_holiday_final'],2); ?>&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Reg Holiday OT</td>
	   <td align='center'><small><?php echo number_format($rm2['e_regular_holiday_overtime'],2); ?></small></td>
	   <td align='right'><small><?php echo number_format($rm2['e_regular_holiday_overtime_final'],2); ?>&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Special Holiday</td>
	   <td align='center'><small><?php echo number_format($rm2['e_special_holiday'],2); ?></small></td>
	   <td align='right'><small><?php echo number_format($rm2['e_special_holiday_final'],2); ?>&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Spec. Holiday OT</td>
	   <td align='center'><small><?php echo number_format($rm2['e_special_holiday_overtime'],2); ?></small></td>
	   <td align='right'><small><?php echo number_format($rm2['e_special_holiday_overtime_final'],2); ?>&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Sick Leave</td>
	   <td align='center'><small><?php echo number_format($rm2['e_sick_leave'],2); ?></small></td>
	   <td align='right'><small><?php echo number_format($rm2['e_sick_leave_final'],2); ?>&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Vacation Leave</td>
	   <td align='center'><small><?php echo number_format($rm2['e_vacation_leave'],2); ?></small></td>
	   <td align='right'><small><?php echo number_format($rm2['e_vacation_leave_final'],2); ?>&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Solo Parent Leave</td>
	   <td align='center'><small><?php echo number_format($rm2['e_solo_parent_leave'],2); ?></small></td>
	   <td align='right'><small><?php echo number_format($rm2['e_solo_parent_leave_final'],2); ?>&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Lates</td>
	   <td align='center' class='w3-tiny'><?php echo "(".$rm2['e_lates']." min)"; ?></td>
	   <td align='right' class='w3-tiny'><?php echo "(".number_format($rm2['e_lates_final'],2).")"; ?>&nbsp;</td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Absences</td>
	   <td align='center' class='w3-tiny'><?php echo "(".number_format($rm2['e_absences'],2).")"; ?></td>
	   <td align='right' class='w3-tiny'><?php echo "(".number_format($rm2['e_absences_final'],2).")"; ?>&nbsp;</td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Undertime</td>
	   <td align='center' class='w3-tiny'><?php echo "(".number_format($rm2['e_undertime'],2).")"; ?></td>
	   <td align='right' class='w3-tiny'><?php echo "(".number_format($rm2['e_undertime_final'],2).")"; ?>&nbsp;</td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Meal Allowance</td>
	   <td></td>
	   <td align='right'><small><?php echo number_format($rm2['e_allowance_meal'],2); ?>&nbsp;</small></td>
	   </tr>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Allowance 15th</td>
	   <td></td>
	   <td align='right'><small><?php echo number_format($rm2['e_allowance15'],2); ?>&nbsp;</small></td>
	   </tr>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Allowance 30th</td>
	   <td></td>
	   <td align='right'><small><?php echo number_format($rm2['e_allowance30'],2); ?>&nbsp;</small></td>
	   </tr>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Adjustment</td>
	   <td></td>
	   <td align='right'><small><?php echo number_format($rm2['e_add_allowance'],2); ?>&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <?php $gross_pay=$rm2['e_total_cuttoff_hours_final']+
	                    $rm2['e_overtime_final']+
						$rm2['e_restday_pay_final']+
						$rm2['e_restday_pay_overtime_final']+
						$rm2['e_nightshift_final']+
						$rm2['e_overtime_nightshift_final']+
						$rm2['e_regular_holiday_final']+
						$rm2['e_regular_holiday_overtime_final']+
						$rm2['e_special_holiday_final']+
						$rm2['e_special_holiday_overtime_final']+
						$rm2['e_sick_leave_final']+
						$rm2['e_vacation_leave_final']+
						$rm2['e_solo_parent_leave_final']+
						$rm2['e_allowance_meal']+
						$rm2['e_allowance15']+
						$rm2['e_allowance30']+
						$rm2['e_add_allowance']-
						$rm2['e_lates_final']-
						$rm2['e_absences_final']-
						$rm2['e_undertime_final'];
						 ?>
	   <td class='w3-tiny'><strong>&nbsp;GROSS PAY</strong></td>
	   <td></td>
	   <td align='right'><small><strong><?php echo number_format($gross_pay,2); ?>&nbsp;</strong></small></td>
	   </tr>
	   </table>
   
   </td>
   
   <td>
   
	   <table width='190' border='0'>
	   <tr align='center'>
	   <td>&nbsp;</td>
	   <td class='w3-tiny'>Amount</td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;W-Tax</td>
	   <td align='right'><small><?php echo number_format($rm2['e_tax'],2); ?>&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;SSS</td>
	   <td align='right'><small><?php echo number_format($rm2['e_sss'],2); ?>&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;SSS Loan</td>
	   <td align='right'><small><?php echo number_format($rm2['e_sss_loan'],2); ?>&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;Pag-Ibig</td>
	   <td align='right'><small><?php echo number_format($rm2['e_pagibig'],2); ?>&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;Pag-Ibig Loan</td>
	   <td align='right'><small><?php echo number_format($rm2['e_pagibig_loan'],2); ?>&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;Pag-Ibig Calamity Loan</td>
	   <td align='right'><small><?php echo number_format($rm2['e_pagibig_loan_calamity'],2); ?>&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;PhilHealth</td>
	   <td align='right'><small><?php echo number_format($rm2['e_philhealth'],2); ?>&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;Salary Loan</td>
	   <td align='right'><small><?php echo number_format($rm2['e_salary_loan'],2); ?>&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;Calamity Loan</td>
	   <td align='right'><small><?php echo number_format($rm2['e_salary_calamity_loan'],2); ?>&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;SSS Calamity Loan</td>
	   <td align='right'><small><?php echo number_format($rm2['e_sss_calamity_loan'],2); ?>&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;Cash Advance</td>
	   <td align='right'><small><?php echo number_format($rm2['e_ca'],2); ?>&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;Veterans Loan</td>
	   <td align='right'><small><?php echo number_format($rm2['e_veterans_loan'],2); ?>&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;Charges</td>
	   <td align='right'><small><?php echo number_format($rm2['e_other_charges'],2); ?>&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;Over in Previous Pay</td>
	   <td align='right'><small><?php echo number_format($rm2['e_over_in_previous_pay'],2); ?>&nbsp;</small></td>
	   </tr>
	   
	   <tr><td class='w3-tiny'>&nbsp;</td></tr>
	   <tr><td class='w3-tiny'>&nbsp;</td></tr>
	   <tr><td class='w3-tiny'>&nbsp;</td></tr>
	   <tr><td class='w3-tiny'>&nbsp;</td></tr>
	   <tr><td class='w3-tiny'>&nbsp;</td></tr>
	   <tr><td class='w3-tiny'>&nbsp;</td></tr>
	   <tr><td class='w3-tiny'>&nbsp;</td></tr>
	   <tr><td class='w3-tiny'>&nbsp;</td></tr>
	   <tr><td class='w3-tiny'>&nbsp;</td></tr>
	   
	   <tr>
	   <?php $total_deductions=$rm2['e_tax']+
	                           $rm2['e_sss']+
							   $rm2['e_sss_loan']+
							   $rm2['e_pagibig']+
							   $rm2['e_pagibig_loan']+
							   $rm2['e_pagibig_loan_calamity']+
							   $rm2['e_philhealth']+
							   $rm2['e_salary_loan']+
							   $rm2['e_ca']+
							   $rm2['e_veterans_loan']+
							   $rm2['e_other_charges']+
							   $rm2['e_over_in_previous_pay']+
							   $rm2['e_salary_calamity_loan']+
							   $rm2['e_sss_calamity_loan'];
	                           ?>
	   <td class='w3-tiny'><strong>&nbsp;TOTAL DEDUCTIONS</strong></td>
	   <td align='right'><strong><small><?php echo number_format($total_deductions,2); ?>&nbsp;</small></strong></td>
	   </tr>
	   </table>
   
   </td>
 </tr>
 
 <tr>
	<td colspan='2' align='center'><strong><br><span class='w3-small'>NET PAY:</span>&nbsp;&nbsp;&nbsp;<span class='w3-large'><?php echo number_format($gross_pay-$total_deductions,2); ?></span></strong><br><br></td>
 </tr> 
 <tr>
	<td colspan='2' align='center'><br><span class='w3-tiny'>I acknowledge that ALL DEDUCTIONS herein are with my<br>PRIOR CONSENT and are therefore AUTHORIZED.</span>
	<br><br>
	<small><strong><?php echo $rm1['e_lname'].", ".$rm1['e_fname']; ?></strong></small>
	</td>
 </tr> 
 <tr>
	<td colspan='2' align='center'>
	<span class='w3-tiny'>SIGNATURE OVER PRINTED NAME</span>
	<br><br>
	</td>
 </tr>
 
</table>

</td>
</div>
<?php } while($rm2=mysql_fetch_assoc($qm2)); 

//END OF 1ST PAYSLIP--------------
?>


<?php

if($_REQUEST['e_no']!=""){}
else
{

$rec_count=mysql_num_rows(mysql_query("select count from payroll where payroll_period='$payroll_period' $sql_company"));
$total=$rec_count;

for($i=1; $i<=$total; $i++)
{ $limit=$i*1;   

  if($limit<=$total)
    {

$sm2="select * from payroll where finalized=1 and payroll_period='$payroll_period' $sql_company order by e_company,e_department,e_lname asc limit $limit, 1 "; 
$qm2=mysql_query($sm2) or die(mysql_error());
$rm2=mysql_fetch_assoc($qm2);

echo "<tr>";

do{

$e_no=$rm2['e_no'];
$sm1="select * from employee where e_no='$e_no'";
$qm1=mysql_query($sm1) or die(mysql_error());
$rm1=mysql_fetch_assoc($qm1);

$e_comp=$rm1['e_company'];
$s="select * from company where company='$e_comp'";
$q=mysql_query($s) or die(mysql_error());
$r=mysql_fetch_assoc($q);

$company_name=$r['company_name'];
$company_address=$r['company_address'];


?>
<div class="page">
<td>

 <table width='380' border="1">
 <tr height="50">
   <td colspan="2" align="center">
     <table>
	   <tr>
	     <td>
		  <img src="img/<?php echo $r['company']; ?>.jpg" height="35" width="80"/>
		 </td>
		 <td align="center">
          <div class='w3-tiny'><strong><?php echo "$company_name"; ?></strong><br><?php echo "$company_address"; ?></div>
         </td>
	   </tr>
	 </table>      
   </td>
 </tr>
 
 <tr align='center'>
   <td colspan='2'><span class='w3-tiny'>DEPT:</span> <small><strong><?php echo $rm2['e_department']; ?></strong></small></td>
 </tr>
 <tr>
   <td><small>&nbsp;ID No. <strong><?php echo $rm2['e_no']; ?></strong></small></td>
   <td><small>&nbsp;<strong><?php echo $rm1['e_lname'].", ".$rm1['e_fname']; ?></strong></small></td>
 </tr>
 
 <tr>
   <td><small>&nbsp;Payroll Period: <strong><?php echo date('m/d/Y', strtotime($rm2['payroll_period'])); ?></strong></small></td>
   <td><small>&nbsp;Rate/Day: <strong><?php echo number_format($rm2['e_basic_pay']); ?></strong></small></td>
 </tr>
 
 <tr align='center' class='w3-tiny'>
   <td>EARNINGS</td><td>DEDUCTIONS</td>
 </tr>
 
 <tr>
   <td>
   
	   <table width='190' border='0'>
	   <tr align='center'>
	   <td>&nbsp;</td>
	   <td class='w3-tiny'>Hours&nbsp;</td>
	   <td class='w3-tiny'>Amount</td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;Basic Pay</td>
	   <td align='center'><small><?php echo number_format($rm2['e_total_cuttoff_hours'],2); ?></small></td>
	   <td align='right'><small><?php echo number_format($rm2['e_total_cuttoff_hours_final'],2); ?>&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;Overtime</td>
	   <td align='center'><small><?php echo number_format($rm2['e_overtime'],2); ?></small></td>
	   <td align='right'><small><?php echo number_format($rm2['e_overtime_final'],2); ?>&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;Day Off</td>
	   <td align='center'><small><?php echo number_format($rm2['e_restday_pay'],2); ?></small></td>
	   <td align='right'><small><?php echo number_format($rm2['e_restday_pay_final'],2); ?>&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;Day Off OT</td>
	   <td align='center'><small><?php echo number_format($rm2['e_restday_pay_overtime'],2); ?></small></td>
	   <td align='right'><small><?php echo number_format($rm2['e_restday_pay_overtime_final'],2); ?>&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;Night Diff</td>
	   <td align='center'><small><?php echo number_format($rm2['e_nightshift'],2); ?></small></td>
	   <td align='right'><small><?php echo number_format($rm2['e_nightshift_final'],2); ?>&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;Night Diff OT</td>
	   <td align='center'><small><?php echo number_format($rm2['e_overtime_nightshift'],2); ?></small></td>
	   <td align='right'><small><?php echo number_format($rm2['e_overtime_nightshift_final'],2); ?>&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;Reg Holiday</td>
	   <td align='center'><small><?php echo number_format($rm2['e_regular_holiday'],2); ?></small></td>
	   <td align='right'><small><?php echo number_format($rm2['e_regular_holiday_final'],2); ?>&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;Reg Holiday OT</td>
	   <td align='center'><small><?php echo number_format($rm2['e_regular_holiday_overtime'],2); ?></small></td>
	   <td align='right'><small><?php echo number_format($rm2['e_regular_holiday_overtime_final'],2); ?>&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;Special Holiday</td>
	   <td align='center'><small><?php echo number_format($rm2['e_special_holiday'],2); ?></small></td>
	   <td align='right'><small><?php echo number_format($rm2['e_special_holiday_final'],2); ?>&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;Spec. Holiday OT</td>
	   <td align='center'><small><?php echo number_format($rm2['e_special_holiday_overtime'],2); ?></small></td>
	   <td align='right'><small><?php echo number_format($rm2['e_special_holiday_overtime_final'],2); ?>&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;Sick Leave</td>
	   <td align='center'><small><?php echo number_format($rm2['e_sick_leave'],2); ?></small></td>
	   <td align='right'><small><?php echo number_format($rm2['e_sick_leave_final'],2); ?>&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;Vacation Leave</td>
	   <td align='center'><small><?php echo number_format($rm2['e_vacation_leave'],2); ?></small></td>
	   <td align='right'><small><?php echo number_format($rm2['e_vacation_leave_final'],2); ?>&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Solo Parent Leave</td>
	   <td align='center'><small><?php echo number_format($rm2['e_solo_parent_leave'],2); ?></small></td>
	   <td align='right'><small><?php echo number_format($rm2['e_solo_parent_leave_final'],2); ?>&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Lates</td>
	   <td align='center' class='w3-tiny'><?php echo "(".$rm2['e_lates']." min)"; ?></td>
	   <td align='right' class='w3-tiny'><?php echo "(".number_format($rm2['e_lates_final'],2).")"; ?>&nbsp;</td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Absences</td>
	   <td align='center' class='w3-tiny'><?php echo "(".number_format($rm2['e_absences'],2).")"; ?></td>
	   <td align='right' class='w3-tiny'><?php echo "(".number_format($rm2['e_absences_final'],2).")"; ?>&nbsp;</td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Undertime</td>
	   <td align='center' class='w3-tiny'><?php echo "(".number_format($rm2['e_undertime'],2).")"; ?></td>
	   <td align='right' class='w3-tiny'><?php echo "(".number_format($rm2['e_undertime_final'],2).")"; ?>&nbsp;</td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Meal Allowance</td>
	   <td></td>
	   <td align='right'><small><?php echo number_format($rm2['e_allowance_meal'],2); ?>&nbsp;</small></td>
	   </tr>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Allowance 15th</td>
	   <td></td>
	   <td align='right'><small><?php echo number_format($rm2['e_allowance15'],2); ?>&nbsp;</small></td>
	   </tr>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Allowance 30th</td>
	   <td></td>
	   <td align='right'><small><?php echo number_format($rm2['e_allowance30'],2); ?>&nbsp;</small></td>
	   </tr>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Adjustment</td>
	   <td></td>
	   <td align='right'><small><?php echo number_format($rm2['e_add_allowance'],2); ?>&nbsp;</small></td>
	   </tr>
	   <tr>
	   <?php $gross_pay=$rm2['e_total_cuttoff_hours_final']+
	                    $rm2['e_overtime_final']+
						$rm2['e_restday_pay_final']+
						$rm2['e_restday_pay_overtime_final']+
						$rm2['e_nightshift_final']+
						$rm2['e_overtime_nightshift_final']+
						$rm2['e_regular_holiday_final']+
						$rm2['e_regular_holiday_overtime_final']+
						$rm2['e_special_holiday_final']+
						$rm2['e_special_holiday_overtime_final']+
						$rm2['e_sick_leave_final']+
						$rm2['e_vacation_leave_final']+
						$rm2['e_solo_parent_leave_final']+
						$rm2['e_allowance_meal']+
						$rm2['e_allowance15']+
						$rm2['e_allowance30']+
						$rm2['e_add_allowance']-
						$rm2['e_lates_final']-
						$rm2['e_absences_final']-
						$rm2['e_undertime_final'];
						 ?>
	   <td class='w3-tiny'><strong>&nbsp;GROSS PAY</strong></td>
	   <td></td>
	   <td align='right'><small><strong><?php echo number_format($gross_pay,2); ?>&nbsp;</strong></small></td>
	   </tr>
	   </table>
   
   </td>
   
   <td>
	   <table width='190' border='0'>
	   <tr align='center'>
	   <td>&nbsp;</td>
	   <td class='w3-tiny'>Amount</td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;W-Tax</td>
	   <td align='right'><small><?php echo number_format($rm2['e_tax'],2); ?>&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;SSS</td>
	   <td align='right'><small><?php echo number_format($rm2['e_sss'],2); ?>&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;SSS Loan</td>
	   <td align='right'><small><?php echo number_format($rm2['e_sss_loan'],2); ?>&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;Pag-Ibig</td>
	   <td align='right'><small><?php echo number_format($rm2['e_pagibig'],2); ?>&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;Pag-Ibig Loan</td>
	   <td align='right'><small><?php echo number_format($rm2['e_pagibig_loan'],2); ?>&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;Pag-Ibig Calamity Loan</td>
	   <td align='right'><small><?php echo number_format($rm2['e_pagibig_loan_calamity'],2); ?>&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;PhilHealth</td>
	   <td align='right'><small><?php echo number_format($rm2['e_philhealth'],2); ?>&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;Salary Loan</td>
	   <td align='right'><small><?php echo number_format($rm2['e_salary_loan'],2); ?>&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;Calamity Loan</td>
	   <td align='right'><small><?php echo number_format($rm2['e_salary_calamity_loan'],2); ?>&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;SSS Calamity Loan</td>
	   <td align='right'><small><?php echo number_format($rm2['e_sss_calamity_loan'],2); ?>&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;Cash Advance</td>
	   <td align='right'><small><?php echo number_format($rm2['e_ca'],2); ?>&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;Veterans Loan</td>
	   <td align='right'><small><?php echo number_format($rm2['e_veterans_loan'],2); ?>&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;Charges</td>
	   <td align='right'><small><?php echo number_format($rm2['e_other_charges'],2); ?>&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;Over in Previous Pay</td>
	   <td align='right'><small><?php echo number_format($rm2['e_over_in_previous_pay'],2); ?>&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;</td>
	   <td align='right'><small>&nbsp;</small></td>
	   </tr>
	   
	   <tr><td class='w3-tiny'>&nbsp;</td></tr>
	   <tr><td class='w3-tiny'>&nbsp;</td></tr>
	   <tr><td class='w3-tiny'>&nbsp;</td></tr>
	   <tr><td class='w3-tiny'>&nbsp;</td></tr>
	   <tr><td class='w3-tiny'>&nbsp;</td></tr>
	   <tr><td class='w3-tiny'>&nbsp;</td></tr>
	   <tr><td class='w3-tiny'>&nbsp;</td></tr>
	   <tr><td class='w3-tiny'>&nbsp;</td></tr>
	   <tr><td class='w3-tiny'>&nbsp;</td></tr>
	   
	   <tr>
	   <?php $total_deductions=$rm2['e_tax']+
	                           $rm2['e_sss']+
							   $rm2['e_sss_loan']+
							   $rm2['e_pagibig']+
							   $rm2['e_pagibig_loan']+
							   $rm2['e_pagibig_loan_calamity']+
							   $rm2['e_philhealth']+
							   $rm2['e_salary_loan']+
							   $rm2['e_ca']+
							   $rm2['e_veterans_loan']+
							   $rm2['e_other_charges']+
							   $rm2['e_over_in_previous_pay']+
							   $rm2['e_salary_calamity_loan']+
							   $rm2['e_sss_calamity_loan'];
	                           ?>
	   <td class='w3-tiny'><strong>&nbsp;TOTAL DEDUCTIONS</strong></td>
	   <td align='right'><strong><small><?php echo number_format($total_deductions,2); ?>&nbsp;</small></strong></td>
	   </tr>
	   </table>
   
   </td>
 </tr>
 
 <tr>
	<td colspan='2' align='center'><strong><br><span class='w3-small'>NET PAY:&nbsp;&nbsp;&nbsp;</span><span class='w3-large'><?php echo number_format($gross_pay-$total_deductions,2); ?></span></strong><br><br></td>
 </tr> 
 
 <tr>
	<td colspan='2' align='center'><br><span class='w3-tiny'>I acknowledge that ALL DEDUCTIONS herein are with my<br>PRIOR CONSENT and are therefore AUTHORIZED.</span>
	<br><br>
	<small><strong><?php echo $rm1['e_lname'].", ".$rm1['e_fname']; ?></strong></small>
	</td>
 </tr> 
 <tr>
	<td colspan='2' align='center'>
	<span class='w3-tiny'>SIGNATURE OVER PRINTED NAME</span>
	<br><br>
	</td>
 </tr>

</table>

</td>
</div>
   <?php }  while($rm2=mysql_fetch_assoc($qm2)); 
   
  } 
 } 
}?>

</tr></table>