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

$select_charges = mysql_query("SELECT * FROM employee_charges WHERE payroll_period='$cutoff_date'");
while($row_charges = mysql_fetch_assoc($select_charges))
{
    $amount = $row_charges['charge_amount'];
    $remarks = addslashes($row_charges['remarks']);
    $e_no = $row_charges['e_no'];

    $select_additional = mysql_query("SELECT e_other_charges,e_other_charges_rem FROM payroll WHERE e_no='$e_no' AND payroll_period='$payroll_period'");
    $result_additional = mysql_fetch_assoc($select_additional);
    $final_amount = $result_additional['e_other_charges'] + $amount;
    $final_remarks = $result_additional['e_other_charges_rem'] . ";" . $remarks;
    $update_payroll = "UPDATE payroll SET e_other_charges=$final_amount,e_other_charges_rem='$final_remarks' WHERE e_no='$e_no' AND payroll_period='$payroll_period'";
    $update_charges = "UPDATE employee_charges SET pay_status = 1 WHERE payroll_period = '$cutoff_date' AND e_no = '$e_no'";
    $post_charges_update = mysql_query($update_charges) or die(mysql_error());
    $post_update = mysql_query($update_payroll) or die(mysql_error());
}
?>