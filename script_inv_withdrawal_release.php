<?php 
session_start();
include('connection/conn.php');
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); }

if(isset($_REQUEST['withdrawal_release']))
{
	date_default_timezone_set('Asia/Manila');
	$release_reciept_no=date('mdy-H');
	$requested_by=$_REQUEST['requested_by'];
	$withdrawal_slip_no=$_REQUEST['withdrawal_slip_no'];
	$actual_withdrawal_date=$_REQUEST['actual_withdrawal_date'];
	
		$jo_no=$_REQUEST['jo_no'];
		$sa="SELECT jo_no, client_id FROM sales_jo WHERE jo_no='$jo_no'";
		$qa=mysql_query($sa) or die(mysql_error());
		$ra=mysql_fetch_assoc($qa);
		$client_id=$ra['client_id'];
		
	
	mysql_query("UPDATE inv_storage_out_temp SET withdrawal_number = '$release_reciept_no',
												 withdrawal_slip_date='$actual_withdrawal_date', 
												 withdrawal_slip_no='$withdrawal_slip_no', 
												 withdrawal_slip_date=now(), 
												 for_client='$client_id',
												 for_jo='$jo_no',
												 requested_by='$requested_by'") or die(mysql_error());
	mysql_query("INSERT INTO inv_storage_out SELECT * FROM inv_storage_out_temp") or die(mysql_error());
    
	
	$s="SELECT count_in,for_withdrawal,item_id FROM inv_storage_in WHERE for_withdrawal > 0";
	$q=mysql_query($s) or die(mysql_error());
	$r=mysql_fetch_assoc($q);
	do{
		$item_id=$r['item_id'];
		$new_total=$r['count_in']-$r['for_withdrawal'];
		mysql_query("UPDATE inv_storage_in SET count_in=$new_total WHERE item_id = $item_id") or die(mysql_error());
	}while($r=mysql_fetch_assoc($q));
	
	mysql_query("UPDATE inv_storage_in SET for_withdrawal = 0") or die(mysql_error());
	
	$sql="TRUNCATE TABLE inv_storage_out_temp";
	$query=mysql_query($sql) or die(mysql_error());

	$username=$_SESSION['username'];
    $trans="release reciept: $release_reciept_no with material_withdrawal no: $withdrawal_slip_no / $withdrawal_slip_date JO NO: $jo_no created";
    $log_sql="insert into inv_logbook (datetime,transaction,transact_by) values (now(),'$trans','$username')";
    $log_query=mysql_query($log_sql) or die(mysql_error());
	
	$return='Location: inv_release_reciept.php?storage='.$_REQUEST['storage'].'&withdrawal_list_release_success=1&release_reciept='.$release_reciept_no.'';
	header($return);
}
?>
