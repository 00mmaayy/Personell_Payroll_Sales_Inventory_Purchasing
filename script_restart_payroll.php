<?php 
include('connection/conn.php');
session_start();
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); }

$q=mysql_query("SELECT payroll_period FROM payroll GROUP BY payroll_period ORDER BY payroll_period DESC LIMIT 1");
$r=mysql_fetch_assoc($q);
$pp=$r['payroll_period'];

if(date('d',strtotime($pp)) <= 15)
{
    $date = date('Y-m',strtotime($pp));
    $cutoff_period = "$date-11";
}
elseif(date('d',strtotime($pp)) <= 30 && date('d',strtotime($pp)) >= 16)
{
    $date = date('Y-m',strtotime($pp));
    $cutoff_period = "$date-26";
}

/* mysqli_query($syshubconn,"UPDATE employee_loan_schedule SET loan_payment_status = 0 WHERE loan_date_payment = '$cutoff_period' AND loan_payment_status = 1"); */
mysqli_query($syshubconn,"UPDATE employee_loan_todeduct SET loan_payment_status = 0 WHERE date_paid = '$pp'");
mysqli_query($syshubconn,"UPDATE employee_adjustments SET pay_status = 0 WHERE payroll_period = '$cutoff_period'");
mysql_query("DELETE FROM payroll WHERE payroll_period='$pp'");

$username=$_SESSION['username'];
$trans="delete payroll period $pp";
$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
$log_query=mysql_query($log_sql) or die(mysql_error());

header('Location: admin.php?payroll=1&payroll_processing=1&success=1');
?>