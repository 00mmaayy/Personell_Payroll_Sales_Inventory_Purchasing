<?php
include 'connection/conn.php';
$payroll_select = mysql_query("SELECT payroll_period FROM payroll GROUP BY payroll_period DESC LIMIT 1") or die(mysql_error());
$payroll_result = mysql_fetch_assoc($payroll_select);
$payroll_period = $payroll_result['payroll_period'];

$date = date("d",strtotime($payroll_period));
$month = date("m",strtotime($payroll_period));
$year = date("Y",strtotime($payroll_period));

if($date >= "1" && $date <= "15")
{
  $cutoff_date = "$year-$month-11";
}
elseif($date >= "20" && $date <= "30")
{
 $cutoff_date = "$year-$month-26";
}

$select_adjustments = mysql_query("SELECT * FROM employee_adjustments WHERE payroll_period='$cutoff_date'");
while($row_adjustments = mysql_fetch_assoc($select_adjustments))
{

    $amount = $row_adjustments['adjustment_amount'];
    $remarks = addslashes($row_adjustments['remarks']);
    $e_no = $row_adjustments['e_no'];

    $select_additional = mysql_query("SELECT e_add_allowance,e_add_allowance_rem FROM payroll WHERE e_no='$e_no' AND payroll_period='$payroll_period'");
    $result_additional = mysql_fetch_assoc($select_additional);
    $final_amount = $result_additional['e_add_allowance'] + $amount;
    $final_remarks = $result_additional['e_add_allowance_rem'] . ";" . $remarks;
    $update_payroll = "UPDATE payroll SET e_add_allowance=$final_amount,e_add_allowance_rem='$final_remarks' WHERE e_no='$e_no' AND payroll_period='$payroll_period'";
    $update_adjustments = "UPDATE employee_adjustments SET pay_status = 1 WHERE payroll_period = '$cutoff_date' AND e_no = '$e_no'";
    $post_adjustment_update = mysql_query($update_adjustments) or die(mysql_error());
    $post_update = mysql_query($update_payroll) or die(mysql_error());
}
?>