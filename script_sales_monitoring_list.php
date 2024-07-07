<?php 
session_start();
include('connection/conn.php');
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); }

date_default_timezone_set("Asia/Manila");
$s="select * from company";
$q=mysql_query($s) or die(mysql_error());
$r=mysql_fetch_assoc($q);

echo "<title>".$r['company_name']."</title>";
include("css.php");
$username=$_SESSION['username'];
$qp=mysql_query("select bch,department from users where username='$username'") or die(mysql_error());
$rp=mysql_fetch_assoc($qp);

$sdate=$_REQUEST['sdate'];
$edate=$_REQUEST['edate'];

$sdate1=$_REQUEST['sdate']." 00:00:00";
$edate1=$_REQUEST['edate']." 23:59:59";
?>
<br/>
<div>
<div align='right'><a href='script_sales_forms_monitor.php' target='_blank'><i>SPECIAL REPORT: VIEW IT INSERTED AR LIST</i></a>&nbsp;&nbsp;&nbsp;</div>
<form>
	<b>START</b>
	<input name='sdate' type='date' value='<?php echo $_REQUEST['sdate']; ?>'>
	<input name='edate' type='date' value='<?php echo $_REQUEST['edate']; ?>'>
	<b>END</b> : : 
	<input type='submit' value='CHANGE DATE RANGE'>
</form>
</div>

<?php
echo "<i>Report from</i> <b>".date('F d, Y',strtotime($_REQUEST['sdate']))."</b> <i>to</i> <b>".date('F d, Y',strtotime($_REQUEST['edate']))."</b>"; ?>
<form>
	<input name='sort3' type='hidden' value=''>
	<input name='sdate' type='hidden' value='<?php echo $sdate; ?>'>
	<input name='edate' type='hidden' value='<?php echo $edate; ?>'>
	<input name='branch' type='hidden' value='<?php echo $rp['department']; ?>'>
	<select name='search'>
		<option></option>
		<option value='dr_list'>DR LIST (Based on DR Actual Date)</option>
		<option value='payment'>JO WITH PAYMENTS ONLY (Based on OR Date)</option>
		<option value='jo_actual'>JO LISTS</option>
		<option value='ar_aging'>AR AGING (Based on DR Date)</option>
		<option value='past_due'>AR / PAST DUE (Based on DR Actual Date)</option>
		<option value='over_payment'>OVER IN DELIVERY FINDER (Based on DR Amt > JO Amt. Note: No date filter no this menu.)</option>
		<option value='code_rank'>CODE RANK (Based on DR Actual Date)</option>
		<option value='mismatched'>MISMATCHED AMOUNT OF (J.O. / O.R.) (no date range required)</option>
		<option value='no_or_date'>NO O.R. DATE</option>
		<option value='sales_dept'>REPORT FOR SALES DEPT</option>
		<option value='payment_category'>SALES / SALES DISCOUNT / 2306 / 2307</option>
		<option value='sales_performance'>SALES PERFORMANCE (no date range required)</option>
		<option value='production_performance'>PRODUCTION PERFORMANCE</option>
		<option value='sales_recording'>SALES RECORDING (finance)</option>
		<option value='fg_with_dr'>FG WITH DR SUMMARY</option>
		<option value='summary_per_client_dr_jo_or'>SUMMARY PER CLIENT JO DR OR</option>
		<option value='summary_per_client_history'>SUMMARY PER CLIENT AR (NO DATE RANGE NEEDED)</option>
		<option value='jo_no_dr'>LIST OF JO THAT HAS NO DR YET (1 minute to load data)</option>
	</select>
	<input type='submit' value='SEARCH'>
</form>

<?php
include('script_sales_rep_code_rank.php');
include('script_sales_rep_dr_list.php');
include('script_sales_rep_jo_actual.php');
include('script_sales_rep_ar_aging.php');
include('script_sales_rep_mismatched.php');
include('script_sales_rep_no_or_date.php');
include('script_sales_rep_over_payment.php');
include('script_sales_rep_past_due.php');
include('script_sales_rep_payment.php');
include('script_sales_rep_payment_category.php');
include('script_sales_rep_production_performance.php');
include('script_sales_rep_sales_dept.php');
include('script_sales_rep_sales_performance.php');
include('script_sales_rep_sales_recording.php');
include('script_sales_rep_fg_with_dr.php');
include('script_sales_rep_summary_per_client_dr_jo_or.php');
include('script_sales_rep_summary_per_client_ar.php');
include('script_sales_rep_jo_no_dr.php');
?>

<div align='center'>
<a class='w3-xlarge' href="javascript:window.open('','_self').close();">X</a>
</div>

<?php
/*
RS SLIP RECOEDS LIST

$s="select count(*) as row_count from sales_jo_payments where rs_bch='goc' or rs_bch='main'";
//$s="select count(*) as row_count from sales_jo_payments where rs_bch='sm'";
//$s="select count(*) as row_count from sales_jo_payments where rs_bch='sp'";
//$s="select count(*) as row_count from sales_jo_payments where rs_bch='sj'";
$q=mysql_query($s);
$r=mysql_fetch_assoc($q);
$count = $r['row_count'];

for( $x=1; $x <= $count; $x++ )
{	
	echo $x . " / ";
	
	$s1="select rs_no, rs_bch, payment_datetime from sales_jo_payments where rs_no=$x and (rs_bch='goc' or rs_bch='main')";
	//$s1="select rs_no, rs_bch, payment_datetime from sales_jo_payments where rs_no=$x and rs_bch='sm' ";
	//$s1="select rs_no, rs_bch, payment_datetime from sales_jo_payments where rs_no=$x and rs_bch='sp' ";
	//$s1="select rs_no, rs_bch, payment_datetime from sales_jo_payments where rs_no=$x and rs_bch='sj' ";
	$q1=mysql_query($s1);
	$r1=mysql_fetch_assoc($q1);
	
	if($r1['rs_no'])
	{
		echo $r1['rs_no'] . " / " . $r1['rs_bch'] . " / " . $r1['payment_datetime'];
	}	
	else{ echo "missing-missing-missing-missing-missing-missing-missing-missing-missing-missing-missing-missing"; }
	
	echo "<br/>";
}
*/
?> 