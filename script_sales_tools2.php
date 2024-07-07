<?php 
session_start();
include('connection/conn.php');
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); }
include("css.php");
$username=$_SESSION['username'];

//---------------sales_bookings------------------
if(isset($_REQUEST['change_client']))
{

	$b_id=$_REQUEST['b_id'];
	$jo_no=$_REQUEST['jo_no'];
	$change_client=$_REQUEST['change_client'];
	mysql_query("update sales_bookings set client_id='$change_client' where b_id=$b_id") or die(mysql_error());
	mysql_query("update sales_jo set client_id='$change_client' where b_id='$b_id' and jo_no='$jo_no'") or die(mysql_error());
	mysql_query("update sales_jo_payments set client_id='$change_client' where jo_no='$jo_no'") or die(mysql_error());
	$trans="Update Client: b_id=".$_REQUEST['b_id']." client_old=".$_REQUEST['client_old']." client_new=".$_REQUEST['change_client'];
	mysql_query("insert into logbook_it (date,transaction,update_by) values (now(),'$trans','$username')") or die(mysql_error());
	header('Location: script_sales_tools.php?b_id='.$_REQUEST['b_id'].'&jo_no='.$_REQUEST['jo_no']);

}
//---------------sales_bookings------------------



//---------------sales_bookings_details------------
if(isset($_REQUEST['update_b_qty']))
{
	$b_count=$_REQUEST['b_count'];
	$update_b_qty=$_REQUEST['update_b_qty'];
	mysql_query("update sales_bookings_details set b_qty=$update_b_qty where b_count=$b_count") or die(mysql_error());
	$trans="Update Booking QTY: b_count=".$_REQUEST['b_count']." b_id=".$_REQUEST['b_id']." old_b_qty=".$_REQUEST['b_qty_old']." new_b_qty=".$_REQUEST['update_b_qty'];
	mysql_query("insert into logbook_it (date,transaction,update_by) values (now(),'$trans','$username')") or die(mysql_error());
	header('Location: script_sales_tools.php?b_id='.$_REQUEST['b_id'].'&jo_no='.$_REQUEST['jo_no']);
}

if(isset($_REQUEST['update_dr_qty']))
{
	$b_count=$_REQUEST['b_count'];
	$update_dr_qty=$_REQUEST['update_dr_qty'];
	mysql_query("update sales_bookings_details set dr_qty=$update_dr_qty where b_count=$b_count") or die(mysql_error());
	$trans="Update DR QTY: b_count=".$_REQUEST['b_count']." b_id=".$_REQUEST['b_id']." old_dr_qty=".$_REQUEST['dr_qty_old']." new_dr_qty=".$_REQUEST['update_dr_qty'];
	mysql_query("insert into logbook_it (date,transaction,update_by) values (now(),'$trans','$username')") or die(mysql_error());
	header('Location: script_sales_tools.php?b_id='.$_REQUEST['b_id'].'&jo_no='.$_REQUEST['jo_no']);
}

if(isset($_REQUEST['update_b_amount']))
{
	$b_count=$_REQUEST['b_count'];
	$update_b_amount=$_REQUEST['update_b_amount'];
	mysql_query("update sales_bookings_details set b_amount=$update_b_amount where b_count=$b_count") or die(mysql_error());
	$trans="Update Booking Amount: b_count=".$_REQUEST['b_count']." b_id=".$_REQUEST['b_id']." old_amount=".$_REQUEST['b_amount_old']." new_amount=".$_REQUEST['update_b_amount'];
	mysql_query("insert into logbook_it (date,transaction,update_by) values (now(),'$trans','$username')") or die(mysql_error());
	header('Location: script_sales_tools.php?b_id='.$_REQUEST['b_id'].'&jo_no='.$_REQUEST['jo_no']);
}

if(isset($_REQUEST['update_b_size']))
{
	$b_count=$_REQUEST['b_count'];
	$update_b_size=$_REQUEST['update_b_size'];
	mysql_query("update sales_bookings_details set b_size='$update_b_size' where b_count=$b_count") or die(mysql_error());
	$trans="Update Booking Size: b_count=".$_REQUEST['b_count']." b_id=".$_REQUEST['b_id']." old_size=".$_REQUEST['b_size_old']." new_size=".$_REQUEST['update_b_size'];
	mysql_query("insert into logbook_it (date,transaction,update_by) values (now(),'$trans','$username')") or die(mysql_error());
	header('Location: script_sales_tools.php?b_id='.$_REQUEST['b_id'].'&jo_no='.$_REQUEST['jo_no']);
}

if(isset($_REQUEST['update_b_desc']))
{
	$b_count=$_REQUEST['b_count'];
	$update_b_desc=$_REQUEST['update_b_desc'];
	mysql_query("update sales_bookings_details set b_desc='$update_b_desc' where b_count=$b_count") or die(mysql_error());
	$trans="Update Booking Desc: b_count=".$_REQUEST['b_count']." b_id=".$_REQUEST['b_id']." old_desc=".$_REQUEST['b_desc_old']." new_desc=".$_REQUEST['update_b_desc'];
	mysql_query("insert into logbook_it (date,transaction,update_by) values (now(),'$trans','$username')") or die(mysql_error());
	header('Location: script_sales_tools.php?b_id='.$_REQUEST['b_id'].'&jo_no='.$_REQUEST['jo_no']);
}

if(isset($_REQUEST['update_code_set']))
{
	$b_count=$_REQUEST['b_count'];
	$update_code_set=$_REQUEST['update_code_set'];
	mysql_query("update sales_bookings_details set code_set='$update_code_set' where b_count=$b_count") or die(mysql_error());
	$trans="Update Booking Code: b_count=".$_REQUEST['b_count']." b_id=".$_REQUEST['b_id']." old_code_set=".$_REQUEST['code_set_old']." new_code_set=".$_REQUEST['update_code_set'];
	mysql_query("insert into logbook_it (date,transaction,update_by) values (now(),'$trans','$username')") or die(mysql_error());
	header('Location: script_sales_tools.php?b_id='.$_REQUEST['b_id'].'&jo_no='.$_REQUEST['jo_no']);
}

if(isset($_REQUEST['update_b_unit']))
{
	$b_count=$_REQUEST['b_count'];
	$update_b_unit=$_REQUEST['update_b_unit'];
	mysql_query("update sales_bookings_details set b_unit='$update_b_unit' where b_count=$b_count") or die(mysql_error());
	$trans="Update Booking Unit: b_count=".$_REQUEST['b_count']." b_id=".$_REQUEST['b_id']." old_b_unit=".$_REQUEST['b_desc_old']." new_b_unit=".$_REQUEST['update_b_unit'];
	mysql_query("insert into logbook_it (date,transaction,update_by) values (now(),'$trans','$username')") or die(mysql_error());
	header('Location: script_sales_tools.php?b_id='.$_REQUEST['b_id'].'&jo_no='.$_REQUEST['jo_no']);
}


if(isset($_REQUEST['update_dr_no']))
{
	$b_count=$_REQUEST['b_count'];
	$update_dr_no=$_REQUEST['update_dr_no'];
	mysql_query("update sales_bookings_details set dr_no='$update_dr_no' where b_count=$b_count") or die(mysql_error());
	$trans="Update DR No: b_count=".$_REQUEST['b_count']." b_id=".$_REQUEST['b_id']." old_dr_no=".$_REQUEST['dr_no_old']." new_dr_no=".$_REQUEST['update_dr_no'];
	mysql_query("insert into logbook_it (date,transaction,update_by) values (now(),'$trans','$username')") or die(mysql_error());
	header('Location: script_sales_tools.php?b_id='.$_REQUEST['b_id'].'&jo_no='.$_REQUEST['jo_no']);
}

if(isset($_REQUEST['update_dr_date']))
{
	$b_count=$_REQUEST['b_count'];
	$update_dr_date=$_REQUEST['update_dr_date'];
	mysql_query("update sales_bookings_details set dr_date='$update_dr_date' where b_count=$b_count") or die(mysql_error());
	$trans="Update DR Date: b_count=".$_REQUEST['b_count']." b_id=".$_REQUEST['b_id']." old_dr_date=".$_REQUEST['dr_date_old']." new_dr_date=".$_REQUEST['update_dr_date'];
	mysql_query("insert into logbook_it (date,transaction,update_by) values (now(),'$trans','$username')") or die(mysql_error());
	header('Location: script_sales_tools.php?b_id='.$_REQUEST['b_id'].'&jo_no='.$_REQUEST['jo_no']);
}
//---------------sales_bookings_details------------


//---------------sales_jo---------
if(isset($_REQUEST['update_jo_actual']))
{
	$update_jo_actual=$_REQUEST['update_jo_actual'];
	$jo_no=$_REQUEST['jo_no'];
	mysql_query("update sales_jo set jo_actual='$update_jo_actual' where jo_no='$jo_no'") or die(mysql_error());
	$trans="Update JO Actual: jo_no=".$_REQUEST['jo_no']." b_id=".$_REQUEST['b_id']." old_actual=".$_REQUEST['jo_actual_old']." new_jo_actual=".$_REQUEST['update_jo_actual'];
	mysql_query("insert into logbook_it (date,transaction,update_by) values (now(),'$trans','$username')") or die(mysql_error());
	header('Location: script_sales_tools.php?b_id='.$_REQUEST['b_id'].'&jo_no='.$_REQUEST['jo_no']);
}


if(isset($_REQUEST['update_jo_actual_date']))
{
	$update_jo_actual_date=$_REQUEST['update_jo_actual_date'];
	$jo_no=$_REQUEST['jo_no'];
	mysql_query("update sales_jo set jo_actual_date='$update_jo_actual_date' where jo_no='$jo_no'") or die(mysql_error());
	$trans="Update JO Actual Date: jo_no=".$_REQUEST['jo_no']." b_id=".$_REQUEST['b_id']." old_actual_date=".$_REQUEST['jo_actual_date_old']." new_jo_actual=".$_REQUEST['update_jo_actual_date'];
	mysql_query("insert into logbook_it (date,transaction,update_by) values (now(),'$trans','$username')") or die(mysql_error());
	header('Location: script_sales_tools.php?b_id='.$_REQUEST['b_id'].'&jo_no='.$_REQUEST['jo_no']);
}


if(isset($_REQUEST['update_bo_no']))
{
	$update_bo_no=$_REQUEST['update_bo_no'];
	$jo_no=$_REQUEST['jo_no'];
	mysql_query("update sales_jo set bo_no='$update_bo_no' where jo_no='$jo_no'") or die(mysql_error());
	$trans="Update Booking No: bo_no=".$_REQUEST['bo_no']." b_id=".$_REQUEST['b_id']." old_bo_no=".$_REQUEST['bo_no_old']." new_bo_no=".$_REQUEST['update_bo_no'];
	mysql_query("insert into logbook_it (date,transaction,update_by) values (now(),'$trans','$username')") or die(mysql_error());
	header('Location: script_sales_tools.php?b_id='.$_REQUEST['b_id'].'&jo_no='.$_REQUEST['jo_no']);
}


if(isset($_REQUEST['update_bo_no_date']))
{
	$update_bo_no_date=$_REQUEST['update_bo_no_date'];
	$jo_no=$_REQUEST['jo_no'];
	mysql_query("update sales_jo set bo_no_date='$update_bo_no_date' where jo_no='$jo_no'") or die(mysql_error());
	$trans="Update Booking Date: jo_no=".$_REQUEST['jo_no']." b_id=".$_REQUEST['b_id']." old_bo_no_date=".$_REQUEST['bo_no_date_old']." new_bo_no=".$_REQUEST['update_bo_no_date'];
	mysql_query("insert into logbook_it (date,transaction,update_by) values (now(),'$trans','$username')") or die(mysql_error());
	header('Location: script_sales_tools.php?b_id='.$_REQUEST['b_id'].'&jo_no='.$_REQUEST['jo_no']);
}



if(isset($_REQUEST['update_po_no']))
{
	$update_po_no=$_REQUEST['update_po_no'];
	$jo_no=$_REQUEST['jo_no'];
	mysql_query("update sales_jo set po_no='$update_po_no' where jo_no='$jo_no'") or die(mysql_error());
	$trans="Update PO NO: jo_no=".$_REQUEST['jo_no']." b_id=".$_REQUEST['b_id']." old_po_no=".$_REQUEST['po_no_old']." new_po_no=".$_REQUEST['update_po_no'];
	mysql_query("insert into logbook_it (date,transaction,update_by) values (now(),'$trans','$username')") or die(mysql_error());
	header('Location: script_sales_tools.php?b_id='.$_REQUEST['b_id'].'&jo_no='.$_REQUEST['jo_no']);
}


if(isset($_REQUEST['update_po_date']))
{
	$update_po_date=$_REQUEST['update_po_date'];
	$jo_no=$_REQUEST['jo_no'];
	mysql_query("update sales_jo set po_date='$update_po_date' where jo_no='$jo_no'") or die(mysql_error());
	$trans="Update PO Date: jo_no=".$_REQUEST['jo_no']." b_id=".$_REQUEST['b_id']." old_po_date=".$_REQUEST['po_date_old']." new_po_date=".$_REQUEST['update_po_date'];
	mysql_query("insert into logbook_it (date,transaction,update_by) values (now(),'$trans','$username')") or die(mysql_error());
	header('Location: script_sales_tools.php?b_id='.$_REQUEST['b_id'].'&jo_no='.$_REQUEST['jo_no']);
}


if(isset($_REQUEST['update_validation']))
{
	$update_validation=$_REQUEST['update_validation'];
	$jo_no=$_REQUEST['jo_no'];
	mysql_query("update sales_jo set validation='$update_validation' where jo_no='$jo_no'") or die(mysql_error());
	$trans="Update validation Status : jo_no=".$_REQUEST['jo_no']." b_id=".$_REQUEST['b_id']." old_status=".$_REQUEST['old_validation']." new_status=".$_REQUEST['update_validation'];
	mysql_query("insert into logbook_it (date,transaction,update_by) values (now(),'$trans','$username')") or die(mysql_error());
	header('Location: script_sales_tools.php?b_id='.$_REQUEST['b_id'].'&jo_no='.$_REQUEST['jo_no']);
}


if(isset($_REQUEST['update_production_status']))
{
	$update_production_status=$_REQUEST['update_production_status'];
	$jo_no=$_REQUEST['jo_no'];
	mysql_query("update sales_jo set production_status='$update_production_status' where jo_no='$jo_no'") or die(mysql_error());
	$trans="Update Production Status : jo_no=".$_REQUEST['jo_no']." b_id=".$_REQUEST['b_id']." old_status=".$_REQUEST['old_production_status']." new_status=".$_REQUEST['update_production_status'];
	mysql_query("insert into logbook_it (date,transaction,update_by) values (now(),'$trans','$username')") or die(mysql_error());
	header('Location: script_sales_tools.php?b_id='.$_REQUEST['b_id'].'&jo_no='.$_REQUEST['jo_no']);
}


if(isset($_REQUEST['update_paid_status']))
{
	$update_paid_status=$_REQUEST['update_paid_status'];
	$jo_no=$_REQUEST['jo_no'];
	mysql_query("update sales_jo set paid='$update_paid_status' where jo_no='$jo_no'") or die(mysql_error());
	$trans="Update Paid Status : jo_no=".$_REQUEST['jo_no']." b_id=".$_REQUEST['b_id']." old_status=".$_REQUEST['old_paid_status']." new_status=".$_REQUEST['update_paid_status'];
	mysql_query("insert into logbook_it (date,transaction,update_by) values (now(),'$trans','$username')") or die(mysql_error());
	header('Location: script_sales_tools.php?b_id='.$_REQUEST['b_id'].'&jo_no='.$_REQUEST['jo_no']);
}


if(isset($_REQUEST['revive_jo']))
{
	$cancelled_by="";
	$jo_no=$_REQUEST['jo_no'];
	mysql_query("update sales_jo set completed_datetime='0000-00-00 00:00:00', completed_by='$cancelled_by', paid=0, delivered=0 where jo_no='$jo_no'") or die(mysql_error());
	
	$trans="Revive JO: jo_no=".$_REQUEST['jo_no']." b_id=".$_REQUEST['b_id'];
	mysql_query("insert into logbook_it (date,transaction,update_by) values (now(),'$trans','$username')") or die(mysql_error());
	
	header('Location: script_sales_tools.php?b_id='.$_REQUEST['b_id'].'&jo_no='.$_REQUEST['jo_no']);
}

if(isset($_REQUEST['cancel_jo']))
{
	$cancelled_by=$_SESSION['username'];
	$jo_no=$_REQUEST['jo_no'];
	mysql_query("update sales_jo set completed_datetime=now(), completed_by='$cancelled_by', paid=1, production_status=9, production_date=now(), delivered=1 where jo_no='$jo_no'") or die(mysql_error());
	
	$trans="Cancel JO: jo_no=".$_REQUEST['jo_no']." b_id=".$_REQUEST['b_id'];
	mysql_query("insert into logbook_it (date,transaction,update_by) values (now(),'$trans','$username')") or die(mysql_error());
	
	header('Location: script_sales_tools.php?b_id='.$_REQUEST['b_id'].'&jo_no='.$_REQUEST['jo_no']);
}
//---------------sales_jo---------



//-------------sales_jo_payments---------
if(isset($_REQUEST['delete_payment_no']))
{
	$delete_payment_no=$_REQUEST['delete_payment_no'];
	mysql_query("delete from sales_jo_payments where id=$delete_payment_no") or die(mysql_error());
	$trans="Deleted Payment: jo_no=".$_REQUEST['jo_no']." 
	                         b_id=".$_REQUEST['b_id']."
							 client_id=".$_REQUEST['p_client_id']." 
							 payment=".$_REQUEST['p_payment']."
							 pay_mode=".$_REQUEST['p_pay_mode']."
							 or_no=".$_REQUEST['p_or_no']."
							 or_date=".$_REQUEST['p_or_date'];
	mysql_query("insert into logbook_it (date,transaction,update_by) values (now(),'$trans','$username')") or die(mysql_error());
	header('Location: script_sales_tools.php?b_id='.$_REQUEST['b_id'].'&jo_no='.$_REQUEST['jo_no']);
}


if(isset($_REQUEST['update_payment']))
{
	$id=$_REQUEST['id'];
	$update_payment=$_REQUEST['update_payment'];
	mysql_query("update sales_jo_payments set payment='$update_payment' where id=$id") or die(mysql_error());
	
	$trans="Update Payment: jo_no=".$_REQUEST['jo_no']." b_id=".$_REQUEST['b_id']." payment_old=".$_REQUEST['payment_old']." payment_new=".$_REQUEST['update_payment'];
	mysql_query("insert into logbook_it (date,transaction,update_by) values (now(),'$trans','$username')") or die(mysql_error());
	header('Location: script_sales_tools.php?b_id='.$_REQUEST['b_id'].'&jo_no='.$_REQUEST['jo_no']);
}


if(isset($_REQUEST['update_or_no']))
{
	$id=$_REQUEST['id'];
	$update_or_no=$_REQUEST['update_or_no'];
	mysql_query("update sales_jo_payments set or_no='$update_or_no' where id=$id") or die(mysql_error());
	
	$trans="Update Payment: jo_no=".$_REQUEST['jo_no']." b_id=".$_REQUEST['b_id']." or_no_old=".$_REQUEST['or_no_old']." or_no_new=".$_REQUEST['update_or_no'];
	mysql_query("insert into logbook_it (date,transaction,update_by) values (now(),'$trans','$username')") or die(mysql_error());
	header('Location: script_sales_tools.php?b_id='.$_REQUEST['b_id'].'&jo_no='.$_REQUEST['jo_no']);
}


if(isset($_REQUEST['update_pay_mode']))
{
	$id=$_REQUEST['id'];
	$update_pay_mode=$_REQUEST['update_pay_mode'];
	mysql_query("update sales_jo_payments set pay_mode='$update_pay_mode' where id=$id") or die(mysql_error());
	
	$trans="Update Payment: jo_no=".$_REQUEST['jo_no']." b_id=".$_REQUEST['b_id']." pay_mode_old=".$_REQUEST['pay_mode_old']." pay_mode_new=".$_REQUEST['update_pay_mode'];
	mysql_query("insert into logbook_it (date,transaction,update_by) values (now(),'$trans','$username')") or die(mysql_error());
	header('Location: script_sales_tools.php?b_id='.$_REQUEST['b_id'].'&jo_no='.$_REQUEST['jo_no']);
}


if(isset($_REQUEST['update_or_date']))
{
	$id=$_REQUEST['id'];
	$update_or_date=$_REQUEST['update_or_date'];
	mysql_query("update sales_jo_payments set or_date='$update_or_date' where id=$id") or die(mysql_error());
	
	$trans="Update Payment: jo_no=".$_REQUEST['jo_no']." b_id=".$_REQUEST['b_id']." or_date_old=".$_REQUEST['or_date_old']." or_date_new=".$_REQUEST['update_or_date'];
	mysql_query("insert into logbook_it (date,transaction,update_by) values (now(),'$trans','$username')") or die(mysql_error());
	header('Location: script_sales_tools.php?b_id='.$_REQUEST['b_id'].'&jo_no='.$_REQUEST['jo_no']);
}

if(isset($_REQUEST['update_or_remarks']))
{
	$id=$_REQUEST['id'];
	$update_or_remarks=$_REQUEST['update_or_remarks'];
	mysql_query("update sales_jo_payments set remarks='$update_or_remarks' where id=$id") or die(mysql_error());
	
	$trans="Update Payment: jo_no=".$_REQUEST['jo_no']." b_id=".$_REQUEST['b_id']." or_date_remarks=".$_REQUEST['or_remarks_old']." or_remarks_new=".$_REQUEST['update_or_remarks'];
	mysql_query("insert into logbook_it (date,transaction,update_by) values (now(),'$trans','$username')") or die(mysql_error());
	header('Location: script_sales_tools.php?b_id='.$_REQUEST['b_id'].'&jo_no='.$_REQUEST['jo_no']);
}

if(isset($_REQUEST['update_or_pay_type']))
{
	$id=$_REQUEST['id'];
	$update_or_pay_type=$_REQUEST['update_or_pay_type'];
	mysql_query("update sales_jo_payments set pay_type='$update_or_pay_type' where id=$id") or die(mysql_error());
	
	$trans="Update Payment: jo_no=".$_REQUEST['jo_no']." b_id=".$_REQUEST['b_id']." or_date_pay_type=".$_REQUEST['or_pay_type_old']." or_pay_type_new=".$_REQUEST['update_or_pay_type'];
	mysql_query("insert into logbook_it (date,transaction,update_by) values (now(),'$trans','$username')") or die(mysql_error());
	header('Location: script_sales_tools.php?b_id='.$_REQUEST['b_id'].'&jo_no='.$_REQUEST['jo_no']);
}
//-------------sales_jo_payments---------



//-------------sales_jo_progress-----------
if(isset($_REQUEST['delete_progress_no']))
{
	$delete_progress_no=$_REQUEST['delete_progress_no'];
	mysql_query("delete from sales_jo_progress where count=$delete_progress_no") or die(mysql_error());
	$trans="Deleted Messege: jo_no=".$_REQUEST['jo_no']." b_id=".$_REQUEST['b_id']." msg=".$_REQUEST['jo_msg']." msg_by=".$_REQUEST['jo_msg_by']." msg_date=".$_REQUEST['msg_date'];
	mysql_query("insert into logbook_it (date,transaction,update_by) values (now(),'$trans','$username')") or die(mysql_error());
	header('Location: script_sales_tools.php?b_id='.$_REQUEST['b_id'].'&jo_no='.$_REQUEST['jo_no']);
}
//-------------sales_jo_progress-----------



//-------------remove cancelled pre jo: galing IT tools na interface-----------
if(isset($_REQUEST['clear_cancelled']))
{
	$d=strtotime("-2 days");
	$yesterday=date("Y-m-d h:i:s", $d);
	
	$xxx="delete from sales_bookings where approved_by='' and created_datetime<='$yesterday'";
	$yyy=mysql_query($xxx) or die(mysql_error());
	
	
	mysql_query("delete from sales_bookings where cancelled_by!=''") or die(mysql_error());
	$trans="Delete: Cancelled PreJO and UnApproved PreJO";
	mysql_query("insert into logbook_it (date,transaction,update_by) values (now(),'$trans','$username')") or die(mysql_error());
	
	header('Location: script_sales_jo_details_search_area.php?cleared=1');
}
//-------------remove cancelled pre jo-----------


//-------------remove cancelled pre jo: galing IT tools na interface-----------
if(isset($_REQUEST['clear_override_list']))
{
	mysql_query("delete from sales_client_override") or die(mysql_error());
	$trans="Delete: PENDING OVERRIDE";
	mysql_query("insert into logbook_it (date,transaction,update_by) values (now(),'$trans','$username')") or die(mysql_error());
	
	header('Location: script_sales_jo_details_search_area.php?override_deleted=1');
}
//-------------remove cancelled pre jo-----------


?>