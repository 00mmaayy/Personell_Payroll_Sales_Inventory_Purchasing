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

$select_over = mysql_query("SELECT * FROM employee_negative WHERE payroll_period='$cutoff_date'");
while($row_over = mysql_fetch_assoc($select_over))
{
    $amount = $row_over['amount'];
    $e_no = $row_over['e_no'];
    $update_payroll = "UPDATE payroll SET e_over_in_previous_pay=$amount WHERE e_no='$e_no' AND payroll_period='$payroll_period'";
    $update_over = "UPDATE employee_negative SET pay_status = 1 WHERE payroll_period = '$cutoff_date' AND e_no = '$e_no'";
    $post_over_update = mysql_query($update_over) or die(mysql_error());
    $post_update = mysql_query($update_payroll) or die(mysql_error());
}
?>