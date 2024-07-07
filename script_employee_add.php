<?php 
session_start();
include('connection/conn.php');
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); }
$s="select * from company";
$q=mysql_query($s) or die(mysql_error());
$r=mysql_fetch_assoc($q);
?>
<!DOCTYPE html>
<html>
<title><?php echo $r['company_name']; ?></title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/w3.css">
<link rel="stylesheet" href="css/font-awesome.min.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>

<?php
//ADD EMPLOYEE AREA START
if(isset($_REQUEST['add_employee'])){
$username=$_SESSION['username'];
$e_no=$_REQUEST['e_no'];
$e_title=$_REQUEST['e_title'];
$e_fname=$_REQUEST['e_fname'];
$e_mname=$_REQUEST['e_mname'];
$e_lname=$_REQUEST['e_lname'];
$e_gender=$_REQUEST['e_gender'];
$e_civil_status=$_REQUEST['e_civil_status'];
$e_bday=$_REQUEST['e_bday'];
$e_bplace=$_REQUEST['e_bplace'];
$e_height=addslashes($_REQUEST['e_height']);
$e_weight=addslashes($_REQUEST['e_weight']);
$e_religion=$_REQUEST['e_religion'];
$e_blood_type=$_REQUEST['e_blood_type'];
$e_address=addslashes($_REQUEST['e_address']);
$e_address_permanent=addslashes($_REQUEST['e_address_permanent']);
$e_mobile=$_REQUEST['e_mobile'];
$e_email=$_REQUEST['e_email'];
$e_sss=$_REQUEST['e_sss'];
$e_tin=$_REQUEST['e_tin'];
$e_philhealth=$_REQUEST['e_philhealth'];
$e_pagibig=$_REQUEST['e_pagibig'];
$e_drivers_lic=$_REQUEST['e_drivers_lic'];
$e_passport_id=$_REQUEST['e_passport_id'];
$e_entry_date=$_REQUEST['e_entry_date'];
$e_job_title=$_REQUEST['e_job_title'];
$e_employment_status=$_REQUEST['e_employment_status'];
$sql="insert into employee (e_no,e_title,e_fname,e_mname,e_lname,e_gender,e_civil_status,e_bday,e_bplace,e_height,e_weight,e_religion,e_blood_type,e_address,e_address_permanent,e_mobile,e_email,e_sss,e_tin,e_philhealth,e_pagibig,e_drivers_lic,e_passport_id,e_entry_date,e_job_title,e_company,e_department,e_employment_status)
      values ('$e_no','$e_title','$e_fname','$e_mname','$e_lname','$e_gender','$e_civil_status','$e_bday','$e_bplace','$e_height','$e_weight','$e_religion','$e_blood_type','$e_address','$e_address_permanent','$e_mobile','$e_email','$e_sss','$e_tin','$e_philhealth','$e_pagibig','$e_drivers_lic','$e_passport_id','$e_entry_date','$e_job_title','','','$e_employment_status')";
$query=mysql_query($sql) or die(mysql_error());

    if($_REQUEST['e_employment_status']=="Regular")
      {
       $s="update employee set e_permanent_status_date='$e_entry_date' where e_no='$e_no'";
       $q=mysql_query($s) or die(mysql_error());
      }

$trans="add employee success $e_no $e_fname $e_mname $e_lname";
$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
$log_query=mysql_query($log_sql) or die(mysql_error());

$return='Location: admin.php?personnel=1&add_employee_success=1&name='.$_REQUEST['e_fname']." ".$_REQUEST['e_lname'];
header($return);
}//ADD EMPLOYEE AREA END

//EDIT EMPLOYEE DETAILS AREA START
if(isset($_REQUEST['edit_employee_details']))
{   
   $e_no=$_REQUEST['e_no'];
   $s2="select * from employee where e_no='$e_no'";
   $q2=mysql_query($s2) or die(mysql_error());
   $r2=mysql_fetch_assoc($q2);
   
   if(isset($_REQUEST['e_no_edit']))
     {
	  $value=$_REQUEST['e_no_edit'];
	  
	  //change e_no
	  $sx="update employee set e_no='$value' where e_no='$e_no'"; 
      $qx=mysql_query($sx) or die(mysql_error());
	  
	  //e_no for family
	  $sx="update employee_family set e_no='$value' where e_no='$e_no'"; 
      $qx=mysql_query($sx) or die(mysql_error());
	  
	  //e_no for leaves
	  $sx="update employee_leaves set e_no='$value' where e_no='$e_no'"; 
      $qx=mysql_query($sx) or die(mysql_error());
	  
	  //e_no for leaves payroll
	  $sx="update employee_leaves_payroll set e_no='$value' where e_no='$e_no'"; 
      $qx=mysql_query($sx) or die(mysql_error());

	  //e_no for loans
	  $sx="update employee_loan set e_no='$value' where e_no='$e_no'"; 
      $qx=mysql_query($sx) or die(mysql_error());
	  
	  //e_no for movement
	  $sx="update employee_movement set e_no='$value' where e_no='$e_no'"; 
      $qx=mysql_query($sx) or die(mysql_error());
	  
	  //e_no for offense
	  $sx="update employee_offense set e_no='$value' where e_no='$e_no'"; 
      $qx=mysql_query($sx) or die(mysql_error());
	  
	  //e_no for org
	  $sx="update employee_org set e_no='$value' where e_no='$e_no'"; 
      $qx=mysql_query($sx) or die(mysql_error());
	  
	  //e_no for school
	  $sx="update employee_school set e_no='$value' where e_no='$e_no'"; 
      $qx=mysql_query($sx) or die(mysql_error());
	  
	  //e_no for trainings
	  $sx="update employee_trainings set e_no='$value' where e_no='$e_no'"; 
      $qx=mysql_query($sx) or die(mysql_error());
	  
	  //e_no for employment history
	  $sx="update employee_work_history set e_no='$value' where e_no='$e_no'"; 
      $qx=mysql_query($sx) or die(mysql_error());
	  
	  //e_no for payroll
	  $sx="update payroll set e_no='$value' where e_no='$e_no'"; 
	  $qx=mysql_query($sx) or die(mysql_error());

	  //e_no for adjustments
	  $sx="update employee_adjustments set e_no='$value' where e_no='$e_no'"; 
	  $qx=mysql_query($sx) or die(mysql_error());

	   //e_no for charges
	   $sx="update employee_charges set e_no='$value' where e_no='$e_no'"; 
	   $qx=mysql_query($sx) or die(mysql_error());
	   
	   //e_no for negative
	   $sx="update employee_negative set e_no='$value' where e_no='$e_no'"; 
	   $qx=mysql_query($sx) or die(mysql_error());
	  
	//e_no for ca
	$sx="UPDATE employee_cash_advance SET e_no='$value' WHERE e_no='$e_no'";
	$qx=mysql_query($sx) or die(mysql_error());
  
	//e_no for inventory mr
	$sx="UPDATE inv_mr SET e_no='$value' WHERE e_no='$e_no'";
	$qx=mysql_query($sx) or die(mysql_error());
	  
	  
	  //ID should be renamed manually
	  
	  $user=$_SESSION['username'];
	  $trans="update employee ID number $e_no to $value";
      $log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$user','$trans')";
      $log_query=mysql_query($log_sql) or die(mysql_error());
	  
	  header('Location:script_employee_add.php?&e_no='.$_REQUEST['e_no_edit'].'&edit_employee_details=1');
	 }
	 
	if(isset($_REQUEST['e_title']))
     {
	  $value=$_REQUEST['e_title'];
	  $field="e_title";
	  
	  $sx="update employee set $field='$value' where e_no='$e_no'"; 
      $qx=mysql_query($sx) or die(mysql_error());
	  $user=$_SESSION['username'];
	  $trans=addslashes($sx);
      $log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$user','$trans')";
      $log_query=mysql_query($log_sql) or die(mysql_error());
	  header('Location:script_employee_add.php?e_no='.$_REQUEST['e_no'].'&edit_employee_details=1');
	 } 
	 
	 if(isset($_REQUEST['e_fname']))
     {
	  $value=$_REQUEST['e_fname'];
	  $field="e_fname";
	  
	  $sx="update employee set $field='$value' where e_no='$e_no'"; 
      $qx=mysql_query($sx) or die(mysql_error());
	  $user=$_SESSION['username'];
	  $trans=addslashes($sx);
      $log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$user','$trans')";
      $log_query=mysql_query($log_sql) or die(mysql_error());
	  header('Location:script_employee_add.php?e_no='.$_REQUEST['e_no'].'&edit_employee_details=1');
	 }
	 
	 if(isset($_REQUEST['e_mname']))
     {
	  $value=$_REQUEST['e_mname'];
	  $field="e_mname";
	  
	  $sx="update employee set $field='$value' where e_no='$e_no'"; 
      $qx=mysql_query($sx) or die(mysql_error());
	  $user=$_SESSION['username'];
	  $trans=addslashes($sx);
      $log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$user','$trans')";
      $log_query=mysql_query($log_sql) or die(mysql_error());
	  header('Location:script_employee_add.php?e_no='.$_REQUEST['e_no'].'&edit_employee_details=1');
	 }
	 
	 if(isset($_REQUEST['e_lname']))
     {
	  $value=$_REQUEST['e_lname'];
	  $field="e_lname";
	  
	  $sx="update employee set $field='$value' where e_no='$e_no'"; 
      $qx=mysql_query($sx) or die(mysql_error());
	  $user=$_SESSION['username'];
	  $trans=addslashes($sx);
      $log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$user','$trans')";
      $log_query=mysql_query($log_sql) or die(mysql_error());
	  header('Location:script_employee_add.php?e_no='.$_REQUEST['e_no'].'&edit_employee_details=1');
	 }
	 
	 if(isset($_REQUEST['e_gender']))
     {
	  $value=$_REQUEST['e_gender'];
	  $field="e_gender";
	  
	  $sx="update employee set $field='$value' where e_no='$e_no'"; 
      $qx=mysql_query($sx) or die(mysql_error());
	  $user=$_SESSION['username'];
	  $trans=addslashes($sx);
      $log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$user','$trans')";
      $log_query=mysql_query($log_sql) or die(mysql_error());
	  header('Location:script_employee_add.php?e_no='.$_REQUEST['e_no'].'&edit_employee_details=1');
	 }
	 
	 if(isset($_REQUEST['e_civil_status']))
     {
	  $value=$_REQUEST['e_civil_status'];
	  $field="e_civil_status";
	  
	  $sx="update employee set $field='$value' where e_no='$e_no'"; 
      $qx=mysql_query($sx) or die(mysql_error());
	  $user=$_SESSION['username'];
	  $trans=addslashes($sx);
      $log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$user','$trans')";
      $log_query=mysql_query($log_sql) or die(mysql_error());
	  header('Location:script_employee_add.php?e_no='.$_REQUEST['e_no'].'&edit_employee_details=1');
	 }
	 
	 if(isset($_REQUEST['e_bday']))
     {
	  $value=$_REQUEST['e_bday'];
	  $field="e_bday";
	  
	  $sx="update employee set $field='$value' where e_no='$e_no'"; 
      $qx=mysql_query($sx) or die(mysql_error());
	  $user=$_SESSION['username'];
	  $trans=addslashes($sx);
      $log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$user','$trans')";
      $log_query=mysql_query($log_sql) or die(mysql_error());
	  header('Location:script_employee_add.php?e_no='.$_REQUEST['e_no'].'&edit_employee_details=1');
	 }
	 
	 if(isset($_REQUEST['e_bplace']))
     {
	  $value=$_REQUEST['e_bplace'];
	  $field="e_bplace";
	  
	  $sx="update employee set $field='$value' where e_no='$e_no'"; 
      $qx=mysql_query($sx) or die(mysql_error());
	  $user=$_SESSION['username'];
	  $trans=addslashes($sx);
      $log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$user','$trans')";
      $log_query=mysql_query($log_sql) or die(mysql_error());
	  header('Location:script_employee_add.php?e_no='.$_REQUEST['e_no'].'&edit_employee_details=1');
	 }
	 
	 if(isset($_REQUEST['e_height']))
     {
	  $value=addslashes($_REQUEST['e_height']);
	  $field="e_height";
	  
	  $sx="update employee set $field='$value' where e_no='$e_no'"; 
      $qx=mysql_query($sx) or die(mysql_error());
	  $user=$_SESSION['username'];
	  $trans=addslashes($sx);
      $log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$user','$trans')";
      $log_query=mysql_query($log_sql) or die(mysql_error());
	  header('Location:script_employee_add.php?e_no='.$_REQUEST['e_no'].'&edit_employee_details=1');
	 }
	 
	 if(isset($_REQUEST['e_weight']))
     {
	  $value=$_REQUEST['e_weight'];
	  $field="e_weight";
	  
	  $sx="update employee set $field='$value' where e_no='$e_no'"; 
      $qx=mysql_query($sx) or die(mysql_error());
	  $user=$_SESSION['username'];
	  $trans=addslashes($sx);
      $log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$user','$trans')";
      $log_query=mysql_query($log_sql) or die(mysql_error());
	  header('Location:script_employee_add.php?e_no='.$_REQUEST['e_no'].'&edit_employee_details=1');
	 }
	 
	 if(isset($_REQUEST['e_religion']))
     {
	  $value=$_REQUEST['e_religion'];
	  $field="e_religion";
	  
	  $sx="update employee set $field='$value' where e_no='$e_no'"; 
      $qx=mysql_query($sx) or die(mysql_error());
	  $user=$_SESSION['username'];
	  $trans=addslashes($sx);
      $log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$user','$trans')";
      $log_query=mysql_query($log_sql) or die(mysql_error());
	  header('Location:script_employee_add.php?e_no='.$_REQUEST['e_no'].'&edit_employee_details=1');
	 }
	 
	 if(isset($_REQUEST['e_blood_type']))
     {
	  $value=$_REQUEST['e_blood_type'];
	  $field="e_blood_type";
	  
	  $sx="update employee set $field='$value' where e_no='$e_no'"; 
      $qx=mysql_query($sx) or die(mysql_error());
	  $user=$_SESSION['username'];
	  $trans=addslashes($sx);
      $log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$user','$trans')";
      $log_query=mysql_query($log_sql) or die(mysql_error());
	  header('Location:script_employee_add.php?e_no='.$_REQUEST['e_no'].'&edit_employee_details=1');
	 }
	 
	 if(isset($_REQUEST['e_mobile']))
     {
	  $value=$_REQUEST['e_mobile'];
	  $field="e_mobile";
	  
	  $sx="update employee set $field='$value' where e_no='$e_no'"; 
      $qx=mysql_query($sx) or die(mysql_error());
	  $user=$_SESSION['username'];
	  $trans=addslashes($sx);
      $log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$user','$trans')";
      $log_query=mysql_query($log_sql) or die(mysql_error());
	  header('Location:script_employee_add.php?e_no='.$_REQUEST['e_no'].'&edit_employee_details=1');
	 }
	 
	 if(isset($_REQUEST['e_email']))
     {
	  $value=$_REQUEST['e_email'];
	  $field="e_email";
	  
	  $sx="update employee set $field='$value' where e_no='$e_no'"; 
      $qx=mysql_query($sx) or die(mysql_error());
	  $user=$_SESSION['username'];
	  $trans=addslashes($sx);
      $log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$user','$trans')";
      $log_query=mysql_query($log_sql) or die(mysql_error());
	  header('Location:script_employee_add.php?e_no='.$_REQUEST['e_no'].'&edit_employee_details=1');
	 }
   
     if(isset($_REQUEST['e_sss']))
     {
	  $value=$_REQUEST['e_sss'];
	  $field="e_sss";
	  
	  $sx="update employee set $field='$value' where e_no='$e_no'"; 
      $qx=mysql_query($sx) or die(mysql_error());
	  $user=$_SESSION['username'];
	  $trans=addslashes($sx);
      $log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$user','$trans')";
      $log_query=mysql_query($log_sql) or die(mysql_error());
	  header('Location:script_employee_add.php?e_no='.$_REQUEST['e_no'].'&edit_employee_details=1');
	 }
	 
	 if(isset($_REQUEST['e_tin']))
     {
	  $value=$_REQUEST['e_tin'];
	  $field="e_tin";
	  
	  $sx="update employee set $field='$value' where e_no='$e_no'"; 
      $qx=mysql_query($sx) or die(mysql_error());
	  $user=$_SESSION['username'];
	  $trans=addslashes($sx);
      $log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$user','$trans')";
      $log_query=mysql_query($log_sql) or die(mysql_error());
	  header('Location:script_employee_add.php?e_no='.$_REQUEST['e_no'].'&edit_employee_details=1');
	 }
	 
	 if(isset($_REQUEST['e_philhealth']))
     {
	  $value=$_REQUEST['e_philhealth'];
	  $field="e_philhealth";
	  
	  $sx="update employee set $field='$value' where e_no='$e_no'"; 
      $qx=mysql_query($sx) or die(mysql_error());
	  $user=$_SESSION['username'];
	  $trans=addslashes($sx);
      $log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$user','$trans')";
      $log_query=mysql_query($log_sql) or die(mysql_error());
	  header('Location:script_employee_add.php?e_no='.$_REQUEST['e_no'].'&edit_employee_details=1');
	 }
	 
	 if(isset($_REQUEST['e_pagibig']))
     {
	  $value=$_REQUEST['e_pagibig'];
	  $field="e_pagibig";
	  
	  $sx="update employee set $field='$value' where e_no='$e_no'"; 
      $qx=mysql_query($sx) or die(mysql_error());
	  $user=$_SESSION['username'];
	  $trans=addslashes($sx);
      $log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$user','$trans')";
      $log_query=mysql_query($log_sql) or die(mysql_error());
	  header('Location:script_employee_add.php?e_no='.$_REQUEST['e_no'].'&edit_employee_details=1');
	 }
	 
	 if(isset($_REQUEST['e_drivers_lic']))
     {
	  $value=$_REQUEST['e_drivers_lic'];
	  $field="e_drivers_lic";
	  
	  $sx="update employee set $field='$value' where e_no='$e_no'"; 
      $qx=mysql_query($sx) or die(mysql_error());
	  $user=$_SESSION['username'];
	  $trans=addslashes($sx);
      $log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$user','$trans')";
      $log_query=mysql_query($log_sql) or die(mysql_error());
	  header('Location:script_employee_add.php?e_no='.$_REQUEST['e_no'].'&edit_employee_details=1');
	 }
	 
	 if(isset($_REQUEST['e_passport_id']))
     {
	  $value=$_REQUEST['e_passport_id'];
	  $field="e_passport_id";
	  
	  $sx="update employee set $field='$value' where e_no='$e_no'"; 
      $qx=mysql_query($sx) or die(mysql_error());
	  $user=$_SESSION['username'];
	  $trans=addslashes($sx);
      $log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$user','$trans')";
      $log_query=mysql_query($log_sql) or die(mysql_error());
	  header('Location:script_employee_add.php?e_no='.$_REQUEST['e_no'].'&edit_employee_details=1');
	 }
	 
	 if(isset($_REQUEST['e_address']))
     {
	  $value=$_REQUEST['e_address'];
	  $field="e_address";
	  
	  $sx="update employee set $field='$value' where e_no='$e_no'"; 
      $qx=mysql_query($sx) or die(mysql_error());
	  $user=$_SESSION['username'];
	  $trans=addslashes($sx);
      $log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$user','$trans')";
      $log_query=mysql_query($log_sql) or die(mysql_error());
	  header('Location:script_employee_add.php?e_no='.$_REQUEST['e_no'].'&edit_employee_details=1');
	 }

	 if(isset($_REQUEST['e_address_permanent']))
     {
	  $value=$_REQUEST['e_address_permanent'];
	  $field="e_address_permanent";
	  
	  $sx="update employee set $field='$value' where e_no='$e_no'"; 
      $qx=mysql_query($sx) or die(mysql_error());
	  $user=$_SESSION['username'];
	  $trans=addslashes($sx);
      $log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$user','$trans')";
      $log_query=mysql_query($log_sql) or die(mysql_error());
	  header('Location:script_employee_add.php?e_no='.$_REQUEST['e_no'].'&edit_employee_details=1');
	 }
	 
   ?>
    <br>
	<div class="col-xs-8" align="center">
        <?php 
        echo "<a href='admin.php?personnel=1&e_no=".$_REQUEST['e_no']."&e_details=1&details_menu=personal'><strong>RETURN</strong></a><br><br>";
	    echo "<table class='table table-hover' border='0'>";
		echo "<tr><td class='bg-primary' colspan='4' align='center'>Edit Details :: ".$r2['e_fname']." ".$r2['e_mname']." ".$r2['e_lname']."</td></tr>"; ?>
        
		<form method="get"><input name="e_no" type="hidden" value="<?php echo $_REQUEST['e_no'];?>">
		<tr><td>&nbsp;Employee Number</td>
		    <td>&nbsp;<?php echo $r2['e_no']; ?></td>
			<td><input required class="form-control" name="e_no_edit" type="text" value="<?php echo $r2['e_no'];?>"></td>
		    <td width="10"><input name="edit_employee_details" type="submit" value="Update Details"></td>
		</tr>
		</form>
		
		<form method="get"><input name="e_no" type="hidden" value="<?php echo $_REQUEST['e_no'];?>">
		<tr><td width='50'>&nbsp;Title</td>
		    <td width='300'>&nbsp;<?php echo $r2['e_title']; ?></td>
			<td width='300'>
		     <select required class="form-control" name="e_title">
              <option></option><option>Mr</option><option>Ms</option><option>Dr</option><option>Atty</option><option>Engr</option>
             </select></td>
		    <td width="10"><input name="edit_employee_details" type="submit" value="Update Details"></td>
		</tr>
		</form>
		
		<form method="get"><input name="e_no" type="hidden" value="<?php echo $_REQUEST['e_no'];?>">
		<tr><td>&nbsp;First Name</td>
		    <td>&nbsp;<?php echo $r2['e_fname']; ?></td>
			<td><input required class="form-control" name="e_fname" type="text" value="<?php echo $r2['e_fname'];?>"></td>
		    <td width="10"><input name="edit_employee_details" type="submit" value="Update Details"></td>
		</tr>
		</form>
		
		<form method="get"><input name="e_no" type="hidden" value="<?php echo $_REQUEST['e_no'];?>">
		<tr><td>&nbsp;Middle Name</td>
		    <td>&nbsp;<?php echo $r2['e_mname']; ?></td>
			<td><input required class="form-control" name="e_mname" type="text" value="<?php echo $r2['e_mname'];?>"></td>
		    <td width="10"><input name="edit_employee_details" type="submit" value="Update Details"></td>
		</tr>
		</form>
		
		<form method="get"><input name="e_no" type="hidden" value="<?php echo $_REQUEST['e_no'];?>">
		<tr><td>&nbsp;Last Name</td>
		    <td>&nbsp;<?php echo $r2['e_lname']; ?></td>
			<td><input required class="form-control" name="e_lname" type="text" value="<?php echo $r2['e_lname'];?>"></td>
		    <td width="10"><input name="edit_employee_details" type="submit" value="Update Details"></td>
		</tr>
		</form>
		
		<form method="get"><input name="e_no" type="hidden" value="<?php echo $_REQUEST['e_no'];?>">
		<tr><td>&nbsp;Gender</td><td>&nbsp;<?php echo $r2['e_gender']; ?></td>
		    <td><select required class="form-control" name="e_gender">
                  <option></option><option>Male</option><option>Female</option>
                </select>
			</td>
			<td width="10"><input name="edit_employee_details" type="submit" value="Update Details"></td>
		</tr>	
		</form>
		
		<form method="get"><input name="e_no" type="hidden" value="<?php echo $_REQUEST['e_no'];?>">
		<tr><td>&nbsp;Civil Status</td>
		    <td>&nbsp;<?php echo $r2['e_civil_status']; ?></td>
			<td><select required class="form-control" name="e_civil_status">
                  <option></option><option>Single</option><option>Married</option><option>Legally Separated</option><option>Widow</option>
                </select>
		    </td>
		    <td width="10"><input name="edit_employee_details" type="submit" value="Update Details"></td>
		</tr>
		</form>
		
		<form method="get"><input name="e_no" type="hidden" value="<?php echo $_REQUEST['e_no'];?>">
		<tr><td>&nbsp;Birthday</td>
		    <td>&nbsp;<?php echo $r2['e_bday']; ?></td>
			<td><input required class="form-control" name="e_bday" type="date"></td>
		    <td width="10"><input name="edit_employee_details" type="submit" value="Update Details"></td>
		</tr>
		</form>
		
		<form method="get"><input name="e_no" type="hidden" value="<?php echo $_REQUEST['e_no'];?>">
		<tr><td>&nbsp;Birth Place</td>
		    <td>&nbsp;<?php echo $r2['e_bplace']; ?></td>
			<td><input required class="form-control" name="e_bplace" type="text" value="<?php echo $r2['e_bplace'];?>"></td>
		    <td width="10"><input name="edit_employee_details" type="submit" value="Update Details"></td>
		</tr>
		</form>
		
		<form method="get"><input name="e_no" type="hidden" value="<?php echo $_REQUEST['e_no'];?>">
		<tr><td>&nbsp;Present Address</td>
		    <td>&nbsp;<?php echo $r2['e_address']; ?></td>
			<td><input required class="form-control" name="e_address" type="text" value="<?php echo $r2['e_address'];?>"></td>
		    <td width="10"><input name="edit_employee_details" type="submit" value="Update Details"></td>
		</tr>
		</form>
		
		<form method="get"><input name="e_no" type="hidden" value="<?php echo $_REQUEST['e_no'];?>">
		<tr><td>&nbsp;Permanent Address</td>
		    <td>&nbsp;<?php echo $r2['e_address_permanent']; ?></td>
			<td><input required class="form-control" name="e_address_permanent" type="text" value="<?php echo $r2['e_address_permanent'];?>"></td>
		    <td width="10"><input name="edit_employee_details" type="submit" value="Update Details"></td>
		</tr>
		</form>
		
		<form method="get"><input name="e_no" type="hidden" value="<?php echo $_REQUEST['e_no'];?>">
		<tr><td>&nbsp;Height</td>
		    <td>&nbsp;<?php echo $r2['e_height']; ?></td>
			<td><input required class="form-control" name="e_height" type="text" value="<?php echo $r2['e_height'];?>"></td>
		    <td width="10"><input name="edit_employee_details" type="submit" value="Update Details"></td>
		</tr>
		</form>
		
		<form method="get"><input name="e_no" type="hidden" value="<?php echo $_REQUEST['e_no'];?>">
		<tr><td>&nbsp;Weight</td>
		    <td>&nbsp;<?php echo $r2['e_weight']; ?></td>
			<td><input required class="form-control" name="e_weight" type="text" value="<?php echo $r2['e_weight'];?>"></td>
		    <td width="10"><input name="edit_employee_details" type="submit" value="Update Details"></td>
		</tr>
		</form>
		
		<form method="get"><input name="e_no" type="hidden" value="<?php echo $_REQUEST['e_no'];?>">
		<tr><td>&nbsp;Religion</td>
		    <td>&nbsp;<?php echo $r2['e_religion']; ?></td>
			<td><input required class="form-control" name="e_religion" type="text" value="<?php echo $r2['e_religion'];?>"></td>
		    <td width="10"><input name="edit_employee_details" type="submit" value="Update Details"></td>
		</tr>
		</form>
		
		<form method="get"><input name="e_no" type="hidden" value="<?php echo $_REQUEST['e_no'];?>">
		<tr><td>&nbsp;Blood Type</td>
		    <td>&nbsp;<?php echo $r2['e_blood_type']; ?></td>
		    <td><select required class="form-control" name="e_blood_type">
                  <option></option><option>-</option><option>O</option><option>A-</option><option>A+</option><option>B-</option><option>B+</option><option>AB</option>
                </select>
		    </td>
		    <td width="10"><input name="edit_employee_details" type="submit" value="Update Details"></td>
		</tr>
		</form>
		
		<form method="get"><input name="e_no" type="hidden" value="<?php echo $_REQUEST['e_no'];?>">
		<tr><td>&nbsp;Mobile No.</td>
		    <td>&nbsp;<?php echo $r2['e_mobile']; ?></td>
			<td><input required class="form-control" name="e_mobile" type="number" value="<?php echo $r2['e_mobile'];?>"</td>
		    <td width="10"><input name="edit_employee_details" type="submit" value="Update Details"></td>
		</tr>
		</form>
		
		<form method="get"><input name="e_no" type="hidden" value="<?php echo $_REQUEST['e_no'];?>">
		<tr><td>&nbsp;Email</td>
		    <td>&nbsp;<?php echo $r2['e_email']; ?></td>
			<td><input required class="form-control" name="e_email" type="text" value="<?php echo $r2['e_email'];?>"></td>
		    <td width="10"><input name="edit_employee_details" type="submit" value="Update Details"></td>
		</tr>
		</form>
		
		<form method="get"><input name="e_no" type="hidden" value="<?php echo $_REQUEST['e_no'];?>">
		<tr><td>&nbsp;SSS No.</td>
		    <td>&nbsp;<?php echo $r2['e_sss']; ?></td>
			<td><input required class="form-control" name="e_sss" type="text" value="<?php echo $r2['e_sss'];?>"></td>
		    <td width="10"><input name="edit_employee_details" type="submit" value="Update Details"></td>
		</tr>
		</form>
		
		<form method="get"><input name="e_no" type="hidden" value="<?php echo $_REQUEST['e_no'];?>">
		<tr><td>&nbsp;TIN</td>
		    <td>&nbsp;<?php echo $r2['e_tin']; ?></td>
			<td><input required class="form-control" name="e_tin" type="text" value="<?php echo $r2['e_tin'];?>"></td>
		    <td width="10"><input name="edit_employee_details" type="submit" value="Update Details"></td>
		</tr>
		</form>
		
		<form method="get"><input name="e_no" type="hidden" value="<?php echo $_REQUEST['e_no'];?>">
		<tr><td>&nbsp;PhilHealth</td>
		    <td>&nbsp;<?php echo $r2['e_philhealth']; ?></td>
			<td><input required class="form-control" name="e_philhealth" type="text" value="<?php echo $r2['e_philhealth'];?>"></td>
		    <td width="10"><input name="edit_employee_details" type="submit" value="Update Details"></td>
		</tr>
		</form>
		
		<form method="get"><input name="e_no" type="hidden" value="<?php echo $_REQUEST['e_no'];?>">
		<tr><td>&nbsp;Pag-Ibig</td>
		    <td>&nbsp;<?php echo $r2['e_pagibig']; ?></td>
			<td><input required class="form-control" name="e_pagibig" type="text" value="<?php echo $r2['e_pagibig'];?>"></td>
		    <td width="10"><input name="edit_employee_details" type="submit" value="Update Details"></td>
		</tr>
		</form>
		
		<form method="get"><input name="e_no" type="hidden" value="<?php echo $_REQUEST['e_no'];?>">
		<tr><td>&nbsp;Driver's License</td>
		    <td>&nbsp;<?php echo $r2['e_drivers_lic']; ?></td>
			<td><input required class="form-control" name="e_drivers_lic" type="text" value="<?php echo $r2['e_drivers_lic'];?>"></td>
		    <td width="10"><input name="edit_employee_details" type="submit" value="Update Details"></td>
		</tr>
		</form>
		
		<form method="get"><input name="e_no" type="hidden" value="<?php echo $_REQUEST['e_no'];?>">
		<tr><td>&nbsp;Passport No.</td>
		    <td>&nbsp;<?php echo $r2['e_passport_id']; ?></td>
			<td><input required class="form-control" name="e_passport_id" type="text" value="<?php echo $r2['e_passport_id'];?>"></td>
		    <td width="10"><input name="edit_employee_details" type="submit" value="Update Details"></td>
		</tr>
		</form>
		
	 </table>
        
	</div>

<?php } //EDIT EMPLOYEE DETAILS AREA END

//ADD FAMILY START
if(isset($_REQUEST['add_family']))
{
$e_no=$_REQUEST['e_no'];
$e_f_relationship=$_REQUEST['e_f_relationship'];
$e_f_name=$_REQUEST['e_f_name'];
$e_f_bday=$_REQUEST['e_f_bday'];

$sx="insert into employee_family (e_no,e_f_relationship,e_f_name,e_f_bday) values ('$e_no','$e_f_relationship','$e_f_name','$e_f_bday')";
$qx=mysql_query($sx) or die(mysql_error());

$user=$_SESSION['username'];
$trans=addslashes("add family $e_no $e_f_relationship $e_f_name $e_f_bday");
$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$user','$trans')";
$log_query=mysql_query($log_sql) or die(mysql_error());

header('Location: admin.php?personnel=1&e_no='.$_REQUEST['e_no'].'&e_details=1&details_menu=family');
} //ADD FAMILY END

//DELETE FAMILY DETAILS START
if(isset($_REQUEST['delete_family']))
{
$e_no=$_REQUEST['e_no'];
$e_f_name=$_REQUEST['e_f_name'];

$sx="delete from employee_family where e_no='$e_no' and e_f_name='$e_f_name' ";
$qx=mysql_query($sx) or die(mysql_error());

$user=$_SESSION['username'];
$trans=addslashes("delete from family $e_no $e_f_name");
$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$user','$trans')";
$log_query=mysql_query($log_sql) or die(mysql_error());
header('Location: admin.php?personnel=1&e_no='.$_REQUEST['e_no'].'&e_details=1&details_menu=family');
} //DELETE FAMILY DETAILS START


//ADD SCHOOL START
if(isset($_REQUEST['add_academic']))
{
$e_no=$_REQUEST['e_no'];
$e_school=$_REQUEST['e_school'];
$e_school_address=$_REQUEST['e_school_address'];
$e_school_year=$_REQUEST['e_school_year'];
$e_degree=$_REQUEST['e_degree'];

$sx="insert into employee_school (e_no,e_school,e_school_address,e_school_year,e_degree) values ('$e_no','$e_school','$e_school_address','$e_school_year','$e_degree')";
$qx=mysql_query($sx) or die(mysql_error());

$user=$_SESSION['username'];
$trans=addslashes("add school $e_no $e_school");
$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$user','$trans')";
$log_query=mysql_query($log_sql) or die(mysql_error());

header('Location: admin.php?personnel=1&e_no='.$_REQUEST['e_no'].'&e_details=1&details_menu=academic');
} //ADD SCHOOL END

//DELETE SCHOOL DETAILS START
if(isset($_REQUEST['delete_school']))
{
$e_no=$_REQUEST['e_no'];
$e_f_name=$_REQUEST['e_school'];

$sx="delete from employee_school where e_no='$e_no' and e_school='$e_school' ";
$qx=mysql_query($sx) or die(mysql_error());

$user=$_SESSION['username'];
$trans=addslashes("delete from school $e_no $e_school");
$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$user','$trans')";
$log_query=mysql_query($log_sql) or die(mysql_error());
header('Location: admin.php?personnel=1&e_no='.$_REQUEST['e_no'].'&e_details=1&details_menu=academic');
} //DELETE SCHOOL DETAILS START


//ADD WORK HISTORY START
if(isset($_REQUEST['add_work']))
{
$e_no=$_REQUEST['e_no'];
$e_company=$_REQUEST['e_company'];
$e_company_address=$_REQUEST['e_company_address'];
$e_w_position=$_REQUEST['e_w_position'];
$e_w_status=$_REQUEST['e_w_status'];
$e_w_date_in=$_REQUEST['e_w_date_in'];
$e_w_date_out=$_REQUEST['e_w_date_out'];

$sx="insert into employee_work_history (e_no,e_w_position,e_w_agency,e_w_agency_address,e_w_status,e_w_date_in,e_w_date_out) 
                                values ('$e_no','$e_w_position','$e_company','$e_company_address','$e_w_status','$e_w_date_in','$e_w_date_out')";
$qx=mysql_query($sx) or die(mysql_error());

$user=$_SESSION['username'];
$trans=addslashes("add work $e_no $e_company");
$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$user','$trans')";
$log_query=mysql_query($log_sql) or die(mysql_error());

header('Location: admin.php?personnel=1&e_no='.$_REQUEST['e_no'].'&e_details=1&details_menu=employment');
} //ADD WORK HISTORY END

//DELETE WORK HISTORY START
if(isset($_REQUEST['delete_work']))
{
$e_no=$_REQUEST['e_no'];
$count=$_REQUEST['e_count'];

$sx="delete from employee_work_history where e_no='$e_no' and count='$count' ";
$qx=mysql_query($sx) or die(mysql_error());

$user=$_SESSION['username'];
$trans=addslashes("delete from work $e_no $e_company");
$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$user','$trans')";
$log_query=mysql_query($log_sql) or die(mysql_error());
header('Location: admin.php?personnel=1&e_no='.$_REQUEST['e_no'].'&e_details=1&details_menu=employment');
} //DELETE WORK HISTORY START

//ADD TRAINING START
if(isset($_REQUEST['add_training']))
{
$e_no=$_REQUEST['e_no'];
$e_t_name=$_REQUEST['e_t_name'];
$e_t_venue=$_REQUEST['e_t_venue'];
$e_t_date=$_REQUEST['e_t_date'];

$sx="insert into employee_trainings (e_no,e_t_name,e_t_venue,e_t_date) values ('$e_no','$e_t_name','$e_t_venue','$e_t_date')";
$qx=mysql_query($sx) or die(mysql_error());

$user=$_SESSION['username'];
$trans=addslashes("add training $e_no $e_t_name");
$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$user','$trans')";
$log_query=mysql_query($log_sql) or die(mysql_error());

header('Location: admin.php?personnel=1&e_no='.$_REQUEST['e_no'].'&e_details=1&details_menu=trainings');
} //ADD TRAINING END


//DELETE TRAINING DETAILS START
if(isset($_REQUEST['delete_training']))
{
$e_no=$_REQUEST['e_no'];
$e_t_name=$_REQUEST['e_t_name'];

$sx="delete from employee_trainings where e_no='$e_no' and e_t_name='$e_t_name' ";
$qx=mysql_query($sx) or die(mysql_error());

$user=$_SESSION['username'];
$trans=addslashes("delete from trainings $e_no $e_t_name");
$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$user','$trans')";
$log_query=mysql_query($log_sql) or die(mysql_error());
header('Location: admin.php?personnel=1&e_no='.$_REQUEST['e_no'].'&e_details=1&details_menu=trainings');
} //DELETE TRAINING DETAILS START

//ADD MOVEMENT START
if(isset($_REQUEST['add_movement']))
{
$e_no=$_REQUEST['e_no'];
$new_title=$_REQUEST['e_j_title'];
$move_date=$_REQUEST['e_j_date'];
$salary=$_REQUEST['e_j_salary'];
$step=$_REQUEST['e_j_step'];

$sx="insert into employee_movement (e_no,new_title,move_date,salary,step) values ('$e_no','$new_title','$move_date',$salary,'$step')";
$qx=mysql_query($sx) or die(mysql_error());

$user=$_SESSION['username'];
$trans=addslashes("add new title to $e_no $new_title");
$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$user','$trans')";
$log_query=mysql_query($log_sql) or die(mysql_error());

header('Location: admin.php?personnel=1&e_no='.$_REQUEST['e_no'].'&e_details=1&details_menu=movement');
} //ADD MOVEMENT END


//DELETE MOVEMENT DETAILS START
if(isset($_REQUEST['delete_movement']))
{
$e_no=$_REQUEST['e_no'];
$count=$_REQUEST['count'];
$new_title=$_REQUEST['new_title'];

$sx="delete from employee_movement where e_no='$e_no' and count='$count' ";
$qx=mysql_query($sx) or die(mysql_error());

$user=$_SESSION['username'];
$trans=addslashes("delete from movement $e_no $new_title");
$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$user','$trans')";
$log_query=mysql_query($log_sql) or die(mysql_error());
header('Location: admin.php?personnel=1&e_no='.$_REQUEST['e_no'].'&e_details=1&details_menu=movement');
} //DELETE MOVEMENT DETAILS START

//ADD ORGANIZATION START
if(isset($_REQUEST['add_org']))
{
$e_no=$_REQUEST['e_no'];
$org_name=$_REQUEST['org_name'];
$date_joined=$_REQUEST['org_date'];
$status=$_REQUEST['org_status'];

$sx="insert into employee_org (e_no,org_name,date_joined,status) values ('$e_no','$org_name','$date_joined','$status')";
$qx=mysql_query($sx) or die(mysql_error());

$user=$_SESSION['username'];
$trans=addslashes("add Organization to $e_no $new_title");
$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$user','$trans')";
$log_query=mysql_query($log_sql) or die(mysql_error());

header('Location: admin.php?personnel=1&e_no='.$_REQUEST['e_no'].'&e_details=1&details_menu=organizations');
} //ADD ORGANIZATION END


//DELETE MOVEMENT DETAILS START
if(isset($_REQUEST['delete_org']))
{
$e_no=$_REQUEST['e_no'];
$count=$_REQUEST['count'];
$org_name=$_REQUEST['org_name'];

$sx="delete from employee_org where e_no='$e_no' and count='$count' ";
$qx=mysql_query($sx) or die(mysql_error());

$user=$_SESSION['username'];
$trans=addslashes("delete from Organizations $e_no $org_name");
$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$user','$trans')";
$log_query=mysql_query($log_sql) or die(mysql_error());
header('Location: admin.php?personnel=1&e_no='.$_REQUEST['e_no'].'&e_details=1&details_menu=organizations');
} //DELETE MOVEMENT DETAILS START

//EDIT PAYROLL DETAILS START
if(isset($_REQUEST['edit_payroll_details']))
{ 
  $e_no=$_REQUEST['e_no'];
   $s2="select * from employee where e_no='$e_no'";
   $q2=mysql_query($s2) or die(mysql_error());
   $r2=mysql_fetch_assoc($q2);
      
   if(isset($_REQUEST['e_company']))
     {
	  $value=$_REQUEST['e_company'];
	  $field="e_company";
	  
	  $sx="update employee set $field='$value' where e_no='$e_no'"; 
      $qx=mysql_query($sx) or die(mysql_error());
	  $user=$_SESSION['username'];
	  $trans=addslashes($sx);
      $log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$user','$trans')";
      $log_query=mysql_query($log_sql) or die(mysql_error());
	  header('Location:script_employee_add.php?e_no='.$_REQUEST['e_no'].'&edit_payroll_details=1');
	 }
   
   if(isset($_REQUEST['e_department']))
     {
	  $value=$_REQUEST['e_department'];
	  $field="e_department";
	  
	  $sx="update employee set $field='$value' where e_no='$e_no'"; 
      $qx=mysql_query($sx) or die(mysql_error());
	  $user=$_SESSION['username'];
	  $trans=addslashes($sx);
      $log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$user','$trans')";
      $log_query=mysql_query($log_sql) or die(mysql_error());
	  header('Location:script_employee_add.php?e_no='.$_REQUEST['e_no'].'&edit_payroll_details=1');
	 }
   
   if(isset($_REQUEST['e_job_title']))
     {
	  $value=$_REQUEST['e_job_title'];
	  $field="e_job_title";
	  
	  $sx="update employee set $field='$value' where e_no='$e_no'"; 
      $qx=mysql_query($sx) or die(mysql_error());
	  $user=$_SESSION['username'];
	  $trans=addslashes($sx);
      $log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$user','$trans')";
      $log_query=mysql_query($log_sql) or die(mysql_error());
	  header('Location:script_employee_add.php?e_no='.$_REQUEST['e_no'].'&edit_payroll_details=1');
	 }
	 
   if(isset($_REQUEST['e_entry_date']))
     {
	  $value=$_REQUEST['e_entry_date'];
	  $field="e_entry_date";
	  
	  $sx="update employee set $field='$value' where e_no='$e_no'"; 
      $qx=mysql_query($sx) or die(mysql_error());
	  $user=$_SESSION['username'];
	  $trans=addslashes($sx);
      $log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$user','$trans')";
      $log_query=mysql_query($log_sql) or die(mysql_error());
	  header('Location:script_employee_add.php?e_no='.$_REQUEST['e_no'].'&edit_payroll_details=1');
	 }
	 
	 if(isset($_REQUEST['e_permanent_status_date']))
     {
	  $value=$_REQUEST['e_permanent_status_date'];
	  $field="e_permanent_status_date";
	  
	  $sx="update employee set $field='$value' where e_no='$e_no'"; 
      $qx=mysql_query($sx) or die(mysql_error());
	  $user=$_SESSION['username'];
	  $trans=addslashes($sx);
      $log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$user','$trans')";
      $log_query=mysql_query($log_sql) or die(mysql_error());
	  header('Location:script_employee_add.php?e_no='.$_REQUEST['e_no'].'&edit_payroll_details=1');
	 }
	 
	 if(isset($_REQUEST['e_employment_status']))
     {
	  $value=$_REQUEST['e_employment_status'];
	  $field="e_employment_status";
	  
	  $sx="update employee set $field='$value' where e_no='$e_no'"; 
      $qx=mysql_query($sx) or die(mysql_error());
	  $user=$_SESSION['username'];
	  $trans=addslashes($sx);
      $log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$user','$trans')";
      $log_query=mysql_query($log_sql) or die(mysql_error());
	  header('Location:script_employee_add.php?e_no='.$_REQUEST['e_no'].'&edit_payroll_details=1');
	 }
	 
	 
	 if(isset($_REQUEST['e_exit_date']))
     {
	  $value=$_REQUEST['e_exit_date'];
	  $field="e_exit_date";
	  
	  $sx="update employee set $field='$value' where e_no='$e_no'"; 
      $qx=mysql_query($sx) or die(mysql_error());
	  $user=$_SESSION['username'];
	  $trans=addslashes($sx);
      $log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$user','$trans')";
      $log_query=mysql_query($log_sql) or die(mysql_error());
	  header('Location:script_employee_add.php?e_no='.$_REQUEST['e_no'].'&edit_payroll_details=1');
	 }
	 

   
     if(isset($_REQUEST['e_basic_pay']))
     {
	  $value=$_REQUEST['e_basic_pay'];
	  $field="e_basic_pay";
	  
	  $sx="update employee set $field='$value' where e_no='$e_no'"; 
      $qx=mysql_query($sx) or die(mysql_error());
	  $user=$_SESSION['username'];
	  $trans=addslashes($sx);
      $log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$user','$trans')";
      $log_query=mysql_query($log_sql) or die(mysql_error());
	  header('Location:script_employee_add.php?e_no='.$_REQUEST['e_no'].'&edit_payroll_details=1');
	 }
	 
	 if(isset($_REQUEST['e_salary_sched']))
     {
	  $value=$_REQUEST['e_salary_sched'];
	  $field="e_salary_sched";
	 
	 $sx="update employee set $field='$value' where e_no='$e_no'"; 
     $qx=mysql_query($sx) or die(mysql_error());
	  $user=$_SESSION['username'];
	  $trans=addslashes($sx);
      $log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$user','$trans')";
      $log_query=mysql_query($log_sql) or die(mysql_error());
	 header('Location:script_employee_add.php?e_no='.$_REQUEST['e_no'].'&edit_payroll_details=1');
	 }
	 
	 if(isset($_REQUEST['e_tax']))
     {
	  $value=$_REQUEST['e_tax'];
	  $field="e_tax";
	  
	  $sx="update employee set $field='$value' where e_no='$e_no'"; 
      $qx=mysql_query($sx) or die(mysql_error());
	  $user=$_SESSION['username'];
	  $trans=addslashes($sx);
      $log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$user','$trans')";
      $log_query=mysql_query($log_sql) or die(mysql_error());
	  header('Location:script_employee_add.php?e_no='.$_REQUEST['e_no'].'&edit_payroll_details=1');
	 }
	 
	 if(isset($_REQUEST['e_allowance15']))
     {
	  $value=$_REQUEST['e_allowance15'];
	  $field="e_allowance15";
	  
	  $sx="update employee set $field='$value' where e_no='$e_no'"; 
      $qx=mysql_query($sx) or die(mysql_error());
	  $user=$_SESSION['username'];
	  $trans=addslashes($sx);
      $log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$user','$trans')";
      $log_query=mysql_query($log_sql) or die(mysql_error());
	  header('Location:script_employee_add.php?e_no='.$_REQUEST['e_no'].'&edit_payroll_details=1');
	 }
	 
	 if(isset($_REQUEST['e_allowance30']))
     {
	  $value=$_REQUEST['e_allowance30'];
	  $field="e_allowance30";
	  
	  $sx="update employee set $field='$value' where e_no='$e_no'"; 
      $qx=mysql_query($sx) or die(mysql_error());
	  $user=$_SESSION['username'];
	  $trans=addslashes($sx);
      $log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$user','$trans')";
      $log_query=mysql_query($log_sql) or die(mysql_error());
	  header('Location:script_employee_add.php?e_no='.$_REQUEST['e_no'].'&edit_payroll_details=1');
	 }
   
	 if(isset($_REQUEST['e_alcgroup']))
     {
	  $value=$_REQUEST['e_alcgroup'];
	  $field="e_alcgroup";
	  
	  $sx="update employee set $field='$value' where e_no='$e_no'"; 
      $qx=mysql_query($sx) or die(mysql_error());
	  $user=$_SESSION['username'];
	  $trans=addslashes($sx);
      $log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$user','$trans')";
      $log_query=mysql_query($log_sql) or die(mysql_error());
	  header('Location:script_employee_add.php?e_no='.$_REQUEST['e_no'].'&edit_payroll_details=1');
	 }
	 
	 if(isset($_REQUEST['e_timeclass']))
     {
	  $value=$_REQUEST['e_timeclass'];
	  $field="e_timeclass";
	  
	  $sx="update employee set $field='$value' where e_no='$e_no'"; 
      $qx=mysql_query($sx) or die(mysql_error());
	  $user=$_SESSION['username'];
	  $trans=addslashes($sx);
      $log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$user','$trans')";
      $log_query=mysql_query($log_sql) or die(mysql_error());
	  header('Location:script_employee_add.php?e_no='.$_REQUEST['e_no'].'&edit_payroll_details=1');
	 }

	 if(isset($_REQUEST['e_rice']))
     {
	  $value=$_REQUEST['e_rice'];
	  $field="e_rice";
	  
	  $sx="update employee set $field='$value' where e_no='$e_no'"; 
      $qx=mysql_query($sx) or die(mysql_error());
	  $user=$_SESSION['username'];
	  $trans=addslashes($sx);
      $log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$user','$trans')";
      $log_query=mysql_query($log_sql) or die(mysql_error());
	  header('Location:script_employee_add.php?e_no='.$_REQUEST['e_no'].'&edit_payroll_details=1');
	 }
	 
	 
	 if(isset($_REQUEST['e_atm_account']))
     {
	  $value=$_REQUEST['e_atm_account'];
	  $field="e_atm_account";
	  
	  $sx="update employee set $field='$value' where e_no='$e_no'"; 
      $qx=mysql_query($sx) or die(mysql_error());
	  $user=$_SESSION['username'];
	  $trans=addslashes($sx);
      $log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$user','$trans')";
      $log_query=mysql_query($log_sql) or die(mysql_error());
	  header('Location:script_employee_add.php?e_no='.$_REQUEST['e_no'].'&edit_payroll_details=1');
	 }
	
	
?>
<br>
	<div class="col-xs-8" align="center">
        <?php 
        echo "<a href='admin.php?personnel=1&e_no=".$_REQUEST['e_no']."&e_details=1&details_menu=payroll'><strong>RETURN</strong></a><br><br>";
	    echo "<table class='table table-hover' border='0'>";
		echo "<tr><td class='bg-primary' colspan='4' align='center'>Edit Payroll Details :: ".$r2['e_fname']." ".$r2['e_mname']." ".$r2['e_lname']."</td></tr>"; ?>
        
		<form method="get"><input name="e_no" type="hidden" value="<?php echo $_REQUEST['e_no'];?>">
		<tr><td>&nbsp;Job Title</td>
		    <td>&nbsp;<?php echo $r2['e_job_title']; ?></td>
			<td><input required class="form-control" name="e_job_title" type="text" value="<?php echo $r2['e_job_title'];?>"></td>
		    <td width="10"><input name="edit_payroll_details" type="submit" value="Update Details" onclick="return confirm('Are you sure?')"></td>
		</tr>
		</form>
		
		<form method="get"><input name="e_no" type="hidden" value="<?php echo $_REQUEST['e_no'];?>">
		<tr><td>&nbsp;Company</td>
		    <td>&nbsp;<?php echo $r2['e_company']; ?></td>
			<td>
			<select required class="form-control" name="e_company">
			 <?php 
			   $ss11="select company from company order by company asc";
			   $qq11=mysql_query($ss11) or die(mysql_error());
			   $rr11=mysql_fetch_assoc($qq11);
			   do{ echo "<option>".$rr11['company']."</option>"; }while($rr11=mysql_fetch_assoc($qq11));
			 ?>
			</select>
			</td>
		    
			<td width="10"><input name="edit_payroll_details" type="submit" value="Update Details" onclick="return confirm('Are you sure?')"></td>
		</tr>
		</form>
		
		<form method="get"><input name="e_no" type="hidden" value="<?php echo $_REQUEST['e_no'];?>">
		<tr><td>&nbsp;Department</td>
		    <td>&nbsp;<?php echo $r2['e_department']; ?></td>
			<td>
			<select required class="form-control" name="e_department">
			<option></option>
	       <?php $x1="select dept_name from departments order by dept_name asc";
  		         $y1=mysql_query($x1) or die(mysql_error());
				 $z1=mysql_fetch_assoc($y1); 
				 do{
				  echo "<option>".$z1['dept_name']."</option>";
				 }while($z1=mysql_fetch_assoc($y1));
			  ?>
			</select>
			</td>
		    <td width="10"><input name="edit_payroll_details" type="submit" value="Update Details" onclick="return confirm('Are you sure?')"></td>
		</tr>
		</form>
		
		<form method="get"><input name="e_no" type="hidden" value="<?php echo $_REQUEST['e_no'];?>">
		<tr><td>&nbsp;Date Hired</td>
		    <td>&nbsp;<?php echo date('F d, Y',strtotime($r2['e_entry_date'])); ?></td>
			<td><input required class="form-control" name="e_entry_date" type="date" value="<?php echo $r2['e_entry_date'];?>"></td>
		    <td width="10"><input name="edit_payroll_details" type="submit" value="Update Details" onclick="return confirm('Are you sure?')"></td>
		</tr>
		</form>
		
		<form method="get"><input name="e_no" type="hidden" value="<?php echo $_REQUEST['e_no'];?>">
		<tr><td>&nbsp;Date of Regularization</td>
		    <td>&nbsp;<?php echo date('F d, Y',strtotime($r2['e_permanent_status_date'])); ?></td>
			<td><input required class="form-control" name="e_permanent_status_date" type="date" value="<?php echo $r2['e_permanent_status_date'];?>"></td>
		    <td width="10"><input name="edit_payroll_details" type="submit" value="Update Details" onclick="return confirm('Are you sure?')"></td>
		</tr>
		</form>
		
		<form method="get"><input name="e_no" type="hidden" value="<?php echo $_REQUEST['e_no'];?>">
		<tr><td>&nbsp;Employment Status</td>
		    <td>&nbsp;<?php echo $r2['e_employment_status']; ?></td>
		    <td><select required class="form-control" name="e_employment_status">
                 <option></option><option>OnCall</option><option>Contractual</option><option>Probationary</option><option>Regular</option><option>Resigned</option><option>NotConnected</option><option>Agency</option><option>Others</option>
		        </select>
			</td>
			<td width="10"><input name="edit_payroll_details" type="submit" value="Update Details" onclick="return confirm('Are you sure?')"></td>
		</form>	
		
		
		<form method="get"><input name="e_no" type="hidden" value="<?php echo $_REQUEST['e_no'];?>">
		<tr><td>&nbsp;Resignation Date</td>
		    <td>&nbsp;<?php echo date('F d, Y',strtotime($r2['e_exit_date'])); ?></td>
		    <td><input required class="form-control" name="e_exit_date" type="date" value="<?php echo $r2['e_exit_date'];?>"></td>
			<td width="10"><input name="edit_payroll_details" type="submit" value="Update Details" onclick="return confirm('Are you sure?')"></td>
		</form>	
		
		
		<form method="get"><input name="e_no" type="hidden" value="<?php echo $_REQUEST['e_no'];?>">
		<tr><td width="200">&nbsp;Basic Pay</td>
		    <td>&nbsp;<?php echo number_format($r2['e_basic_pay'], 2); ?></td>
			<td><input required class="form-control" name="e_basic_pay" type="number" step="any" value="<?php echo $r2['e_basic_pay'];?>"></td>
		    <td width="10"><input name="edit_payroll_details" type="submit" value="Update Details" onclick="return confirm('Are you sure?')"></td>
		</tr>
		</form>
		
		
		<form method="get"><input name="e_no" type="hidden" value="<?php echo $_REQUEST['e_no'];?>">
		<tr>
		    <td>&nbsp;Witholding Tax</td>
		    <td>&nbsp;<?php echo number_format($r2['e_tax'], 2); ?></td>
			<td><input required class="form-control" name="e_tax" type="number" step="any" value="<?php echo $r2['e_tax'];?>"></td>
			<td width="10"><input name="edit_payroll_details" type="submit" value="Update Details" onclick="return confirm('Are you sure?')"></td>
		</tr>
		</form>
		
		
		
		
		
		
		<form method="get"><input name="e_no" type="hidden" value="<?php echo $_REQUEST['e_no'];?>">
		<tr>
		    <td>&nbsp;Allowance 15th</td>
		    <td>&nbsp;<?php echo number_format($r2['e_allowance15'], 2); ?></td>
			<td><input required class="form-control" name="e_allowance15" type="number" step="any" value="<?php echo $r2['e_allowance15'];?>"></td>
			<td width="10"><input name="edit_payroll_details" type="submit" value="Update Details" onclick="return confirm('Are you sure?')"></td>
		</tr>
		</form>
		
		<form method="get"><input name="e_no" type="hidden" value="<?php echo $_REQUEST['e_no'];?>">
		<tr>
		    <td>&nbsp;Allowance 30th</td>
		    <td>&nbsp;<?php echo number_format($r2['e_allowance30'], 2); ?></td>
			<td><input required class="form-control" name="e_allowance30" type="number" step="any" value="<?php echo $r2['e_allowance30'];?>"></td>
			<td width="10"><input name="edit_payroll_details" type="submit" value="Update Details" onclick="return confirm('Are you sure?')"></td>
		</tr>
		</form>
		
		
		
		
		
		
		<form method="get"><input name="e_no" type="hidden" value="<?php echo $_REQUEST['e_no'];?>">
		<tr>
		    <td>&nbsp;Salary Schedule</td>
		    <td>&nbsp;<?php echo $r2['e_salary_sched']; ?></td>
			<td>
			    <select required class="form-control" name="e_salary_sched">
			      <option></option>
				  <option>Daily</option>
				  <option>Monthly</option>
				</select>
			</td>
			<td width="10"><input name="edit_payroll_details" type="submit" value="Update Details" onclick="return confirm('Are you sure?')"></td>
		</tr>
		</form>
		
		<form method="get"><input name="e_no" type="hidden" value="<?php echo $_REQUEST['e_no'];?>">
		<tr>
		    <td>&nbsp;ALC Group Employee</td>
		    <td>&nbsp;<?php if($r2['e_alcgroup']==1){echo "Yes";}else{echo "No";} ?></td>
			<td>
			    <select required class="form-control" name="e_alcgroup">
			      <option></option>
				  <option value='1'>Yes</option>
				  <option value='0'>No</option>
				</select>
			</td>
			<td width="10"><input name="edit_payroll_details" type="submit" value="Update Details" onclick="return confirm('Are you sure?')"></td>
		</tr>
		</form>
		
		<form method="get"><input name="e_no" type="hidden" value="<?php echo $_REQUEST['e_no'];?>">
		<tr>
			
				<?php
					$tclass=$r2['e_timeclass'];
					$qtx=mysql_query("select timeclass from employee_timeclass where id=$tclass") or die(mysql_error());
					$rtx=mysql_fetch_assoc($qtx); 
				?> 
			
		    <td>&nbsp;Time Class</td>
		    <td>&nbsp;<?php echo $rtx['timeclass']; ?></td>
			<td>
				<?php
					$qt=mysql_query("select * from employee_timeclass order by id asc") or die(mysql_error());
					$rt=mysql_fetch_assoc($qt); 
				?>
				
				<select class='form-control' name='e_timeclass'><option>0</option>
				<?php
				do{
					echo "<option value='".$rt['id']."'>".$rt['timeclass']."</option>";
				}while($rt=mysql_fetch_assoc($qt));	
	            ?>
				</select>
			</td>
			<td width="10"><input name="edit_payroll_details" type="submit" value="Update Details" onclick="return confirm('Are you sure?')"></td>
		</tr>
		</form>
		
		<form method="get"><input name="e_no" type="hidden" value="<?php echo $_REQUEST['e_no'];?>">
		<tr>
		    <td>&nbsp;Rice Allowance</td>
		    <td>&nbsp;<?php echo number_format($r2['e_rice'], 2); ?></td>
			<td><input required class="form-control" name="e_rice" type="number" step="any" value="<?php echo $r2['e_rice'];?>"></td>
			<td width="10"><input name="edit_payroll_details" type="submit" value="Update Details" onclick="return confirm('Are you sure?')"></td>
		</tr>
		</form>
		
		
		<form method="get"><input name="e_no" type="hidden" value="<?php echo $_REQUEST['e_no'];?>">
		<tr>
		    <td>&nbsp;Payroll ATM Account No</td>
		    <td>&nbsp;<?php echo $r2['e_atm_account']; ?></td>
			<td><input required class="form-control" name="e_atm_account" type="text" value="<?php echo $r2['e_atm_account'];?>"></td>
			<td width="10"><input name="edit_payroll_details" type="submit" value="Update Details" onclick="return confirm('Are you sure?')"></td>
		</tr>
		</form>
		
		
	 </table>
        
	</div>	
<?php } //PAYROLL DETAILS END ?>
</body>
</html>