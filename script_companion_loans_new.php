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
<strong>LOAN MANAGEMENT</strong><br>
<strong><small class="text-primary">PAYROLL PERIOD: <?php echo date('m/d/Y',strtotime($_REQUEST['payroll_period']));?></small></strong><br>
<hr>
<?php
//---Access Level---
$current_user=$_SESSION['username'];
$spas="select * from user_access where username='$current_user'";
$qpas=mysql_query($spas) or die(mysql_error());
$access=mysql_fetch_assoc($qpas);
//---Access Level---
?>

<?php
$payroll_period=$_REQUEST['payroll_period'];
$payroll_period_plusoneday = date ("Y-m-d", strtotime("+1 day", strtotime($payroll_period)));

if(isset($_REQUEST['load_loan']))
{
	$ssx="INSERT INTO employee_loan_todeduct (transaction_ID, loan_code, loan_principal_payment, loan_interest_payment, loan_payment, loan_balance, loan_date_payment, loan_payment_status)
                                  SELECT transaction_ID, loan_code, loan_principal_payment, loan_interest_payment, loan_payment, loan_balance, loan_date_payment, loan_payment_status
            FROM employee_loan_schedule WHERE (loan_date_payment = '$payroll_period' OR loan_date_payment = '$payroll_period_plusoneday') AND loan_payment_status = 0";
	$qqx=mysql_query($ssx) or die(mysql_error());
	
	$loc2='Location: script_companion_loans_new.php?menu=0&payroll_period='.$_REQUEST['payroll_period'];
	header($loc2);
	
	echo "<script>window.close();</script>";
}
else
{} 
?>

<?php
$sz="SELECT loan_date_payment 
	FROM employee_loan_todeduct 
	WHERE (loan_date_payment = '$payroll_period' OR loan_date_payment = '$payroll_period_plusoneday')
	LIMIT 1"; 
$qz=mysql_query($sz) or die(mysql_error());
$rz=mysql_fetch_assoc($qz);

if($rz['loan_date_payment']==Null){ 
?>
<form method="get">
	<input type="hidden" name="payroll_period" value="<?php echo $payroll_period; ?>">
	<input type="submit" name="load_loan" value="LOAD LOANS">
</form>	
<?php }else{} ?>





<?php
$s="select a.*,
			c.e_lname, c.e_fname
	from employee_loan_todeduct as a 
	inner join employee_loan as b on a.loan_code = b.loan_code
	inner join employee as c on b.e_no = c.e_no
	where loan_date_payment >= '$payroll_period' order by e_lname asc";
$q=mysql_query($s) or die(mysql_error());
$r=mysql_fetch_assoc($q);
echo "<table class='w3-table'>
		<tr class='w3-red'>
			<td>Name</td>
			<td>Loan Code</td>
			<td>Amort Amount</td>
			<td>Payment Status</td>
			<td>Amort Date</td>
			<td>Loan Balance</td>
		</tr>";
do{
	echo "<tr class='w3-hover-pale-red'>
			<td>".$r['e_lname'].", ".$r['e_fname']."</td>
			<td>".$r['loan_code']."</td>
			<td>".number_format($r['loan_payment'],2)."</td>
			<td>".$r['loan_payment_status']."</td>
			<td>".$r['loan_date_payment']."</td>
			<td>".number_format($r['loan_balance'],2)."</td>
		  </tr>";
}while($r=mysql_fetch_assoc($q));
echo "</table>";
?>



</body>