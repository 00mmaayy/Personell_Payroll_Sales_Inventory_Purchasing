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

<?php echo "<strong>Current User is: <span class='w3-red'>&nbsp;".$_SESSION['username']."&nbsp;</span></strong>"; ?>

<form>
<input type='hidden' name='payroll_period' value='<?php echo $_REQUEST['payroll_period']; ?>'>
<select name='menu'>
	<option value='' disabled selected>NONE</option>
	<option class='w3-text-blue'>ADJUSTMENTS</option>
	<option class='w3-text-red'>VETERANS LOAN</option>
	<option class='w3-text-red'>SSS LOAN</option>
	<option class='w3-text-red'>PAG-IBIG LOAN</option>
	<option class='w3-text-red'>PAG-IBIG CALAMITY LOAN</option>
	<option class='w3-text-red'>SALARY LOAN</option>
	<option class='w3-text-red'>CALAMITY LOAN</option>
	<option class='w3-text-red'>SSS CALAMITY LOAN</option>
	<option class='w3-text-red'>CASH ADVANCE</option>
	<option class='w3-text-red'>OTHER CHARGES</option>
	<option class='w3-text-red'>OVER IN PREVIOUS PAY</option>	
	
	<?php
		   $z1="select * from payroll_cutoff";
           $z2=mysql_query($z1) or die(mysql_error());
           $z3=mysql_fetch_assoc($z2);
		   
			    if(date('d')>=$z3['c1'] && date('d')<=$z3['c11'])
			    { 
					//echo "<option class='w3-text-red'>OTHER CHARGES</option>
						//  <option class='w3-text-red'>OVER IN PREVIOUS PAY</option>";
				}
		     
				elseif(date('d')>=$z3['c2'] && date('d')<=$z3['c22'])
			    { 
					//echo "<option class='w3-text-red'>OTHER CHARGES</option>
						//  <option class='w3-text-red'>OVER IN PREVIOUS PAY</option>";
				} 
			  
				else
				{ ?> 
					<!--
					<option class='w3-text-red'>SSS LOAN</option>
					<option class='w3-text-red'>PAG-IBIG LOAN</option>
					<option class='w3-text-red'>PAG-IBIG CALAMITY LOAN</option>
					<option class='w3-text-red'>SALARY LOAN</option>
					<option class='w3-text-red'>CASH ADVANCE</option>
					<option class='w3-text-red'>OTHER CHARGES</option>
					<option class='w3-text-red'>OVER IN PREVIOUS PAY</option>	
					-->
		  <?php } 
	?>
	
	
</select>
<input type='submit' value='SELECT'>
</form>

<?php
if(isset($_REQUEST['edit']))
{
     if(isset($_REQUEST['e_add_allowance']))
     {
	  $value=$_REQUEST['e_add_allowance'];
	  $field="e_add_allowance";
	  $e_no=$_REQUEST['e_no'];
	  $pp=$_REQUEST['payroll_period'];
	  $sx="update payroll set $field='$value' where e_no='$e_no' and payroll_period='$pp'"; 
      $qx=mysql_query($sx) or die(mysql_error());
	  $user=$_SESSION['username'];
	  $trans=addslashes($sx);
      $log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$user','$trans')";
      $log_query=mysql_query($log_sql) or die(mysql_error());
	 }
	 
	 if(isset($_REQUEST['e_sss_loan']))
     {
	  $value=$_REQUEST['e_sss_loan'];
	  $field="e_sss_loan";
	  $e_no=$_REQUEST['e_no'];
	  $pp=$_REQUEST['payroll_period'];
	  $sx="update payroll set $field='$value' where e_no='$e_no' and payroll_period='$pp'"; 
      $qx=mysql_query($sx) or die(mysql_error());
	  $user=$_SESSION['username'];
	  $trans=addslashes($sx);
      $log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$user','$trans')";
      $log_query=mysql_query($log_sql) or die(mysql_error());
	 }
	 
	 if(isset($_REQUEST['e_pagibig_loan']))
     {
	  $value=$_REQUEST['e_pagibig_loan'];
	  $field="e_pagibig_loan";
	  $e_no=$_REQUEST['e_no'];
	  $pp=$_REQUEST['payroll_period'];
	  $sx="update payroll set $field='$value' where e_no='$e_no' and payroll_period='$pp'"; 
      $qx=mysql_query($sx) or die(mysql_error());
	  $user=$_SESSION['username'];
	  $trans=addslashes($sx);
      $log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$user','$trans')";
      $log_query=mysql_query($log_sql) or die(mysql_error());
	 }
	 
	 if(isset($_REQUEST['e_pagibig_loan_calamity']))
     {
	  $value=$_REQUEST['e_pagibig_loan_calamity'];
	  $field="e_pagibig_loan_calamity";
	  $e_no=$_REQUEST['e_no'];
	  $pp=$_REQUEST['payroll_period'];
	  $sx="update payroll set $field='$value' where e_no='$e_no' and payroll_period='$pp'"; 
      $qx=mysql_query($sx) or die(mysql_error());
	  $user=$_SESSION['username'];
	  $trans=addslashes($sx);
      $log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$user','$trans')";
      $log_query=mysql_query($log_sql) or die(mysql_error());
	 }
	 
	 if(isset($_REQUEST['e_salary_loan']))
     {
	  $value=$_REQUEST['e_salary_loan'];
	  $field="e_salary_loan";
	  $e_no=$_REQUEST['e_no'];
	  $pp=$_REQUEST['payroll_period'];
	  $sx="update payroll set $field='$value' where e_no='$e_no' and payroll_period='$pp'"; 
      $qx=mysql_query($sx) or die(mysql_error());
	  $user=$_SESSION['username'];
	  $trans=addslashes($sx);
      $log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$user','$trans')";
      $log_query=mysql_query($log_sql) or die(mysql_error());
	 }

	 if(isset($_REQUEST['e_salary_calamity_loan']))
     {
	  $value=$_REQUEST['e_salary_calamity_loan'];
	  $field="e_salary_calamity_loan";
	  $e_no=$_REQUEST['e_no'];
	  $pp=$_REQUEST['payroll_period'];
	  $sx="update payroll set $field='$value' where e_no='$e_no' and payroll_period='$pp'"; 
      $qx=mysql_query($sx) or die(mysql_error());
	  $user=$_SESSION['username'];
	  $trans=addslashes($sx);
      $log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$user','$trans')";
      $log_query=mysql_query($log_sql) or die(mysql_error());
	 }

	 if(isset($_REQUEST['e_sss_calamity_loan']))
     {
	  $value=$_REQUEST['e_sss_calamity_loan'];
	  $field="e_sss_calamity_loan";
	  $e_no=$_REQUEST['e_no'];
	  $pp=$_REQUEST['payroll_period'];
	  $sx="update payroll set $field='$value' where e_no='$e_no' and payroll_period='$pp'"; 
      $qx=mysql_query($sx) or die(mysql_error());
	  $user=$_SESSION['username'];
	  $trans=addslashes($sx);
      $log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$user','$trans')";
      $log_query=mysql_query($log_sql) or die(mysql_error());
	 }
	 
	 if(isset($_REQUEST['e_ca']))
     {
	  $value=$_REQUEST['e_ca'];
	  $field="e_ca";
	  $e_no=$_REQUEST['e_no'];
	  $pp=$_REQUEST['payroll_period'];
	  $sx="update payroll set $field='$value' where e_no='$e_no' and payroll_period='$pp'"; 
      $qx=mysql_query($sx) or die(mysql_error());
	  $user=$_SESSION['username'];
	  $trans=addslashes($sx);
      $log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$user','$trans')";
      $log_query=mysql_query($log_sql) or die(mysql_error());
	 }
	 
	 if(isset($_REQUEST['e_veterans_loan']))
     {
	  $value=$_REQUEST['e_veterans_loan'];
	  $field="e_veterans_loan";
	  $e_no=$_REQUEST['e_no'];
	  $pp=$_REQUEST['payroll_period'];
	  $sx="update payroll set $field='$value' where e_no='$e_no' and payroll_period='$pp'"; 
      $qx=mysql_query($sx) or die(mysql_error());
	  $user=$_SESSION['username'];
	  $trans=addslashes($sx);
      $log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$user','$trans')";
      $log_query=mysql_query($log_sql) or die(mysql_error());
	 }
	 
	 if(isset($_REQUEST['e_other_charges']))
     {
	  $value=$_REQUEST['e_other_charges'];
	  $field="e_other_charges";
	  $e_no=$_REQUEST['e_no'];
	  $pp=$_REQUEST['payroll_period'];
	  $sx="update payroll set $field='$value' where e_no='$e_no' and payroll_period='$pp'"; 
      $qx=mysql_query($sx) or die(mysql_error());
	  $user=$_SESSION['username'];
	  $trans=addslashes($sx);
      $log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$user','$trans')";
      $log_query=mysql_query($log_sql) or die(mysql_error());
	 }
	 
	 if(isset($_REQUEST['e_over_in_previous_pay']))
     {
	  $value=$_REQUEST['e_over_in_previous_pay'];
	  $field="e_over_in_previous_pay";
	  $e_no=$_REQUEST['e_no'];
	  $pp=$_REQUEST['payroll_period'];
	  $sx="update payroll set $field='$value' where e_no='$e_no' and payroll_period='$pp'"; 
      $qx=mysql_query($sx) or die(mysql_error());
	  $user=$_SESSION['username'];
	  $trans=addslashes($sx);
      $log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$user','$trans')";
      $log_query=mysql_query($log_sql) or die(mysql_error());
	 }
	
 header('Location: script_deductions_adjustments_batch.php?payroll_period='.$_REQUEST['payroll_period'].'&menu='.$_REQUEST['menu']);	
}	 

$pp=$_REQUEST['payroll_period'];	
$s="select a.e_no as e_no,
		   a.e_company as e_company,
		   a.e_department as e_department,
		   b.e_fname as e_fname,
		   a.e_lname as e_lname,
		   a.e_add_allowance as e_add_allowance,
		   a.e_sss_loan as e_sss_loan,
		   a.e_pagibig_loan as e_pagibig_loan,
		   a.e_pagibig_loan_calamity as e_pagibig_loan_calamity,
		   a.e_salary_loan as e_salary_loan,
		   a.e_salary_calamity_loan as e_salary_calamity_loan,
		   a.e_sss_calamity_loan as e_sss_calamity_loan,
		   a.e_ca as e_ca,
		   a.e_veterans_loan as e_veterans_loan,
		   a.e_other_charges as e_other_charges,
		   a.e_over_in_previous_pay as e_over_in_previous_pay
		   from payroll as a 
		   inner join employee as b
				on a.e_no=b.e_no
		   where a.payroll_period='$pp' order by a.e_company, a.e_department asc, a.e_lname asc";
$q=mysql_query($s) or die(mysql_error());
$r=mysql_fetch_assoc($q);

echo "<table align='center' border='1' class='table-hover'>
        <tr class='w3-red'>
		  <td>&nbsp;".date('m/d/Y',strtotime($_REQUEST['payroll_period']))."</td>
		</tr>

		<tr class='w3-green' align='center'>
		  <td>Comp</td>
		  <td>Dept</td>
		  <td>ID No</td>
		  <td>Name</td>";
		  
	if($_REQUEST['menu']=="SSS LOAN" 
	or $_REQUEST['menu']=="SSS CALAMITY LOAN"
	or $_REQUEST['menu']=="PAG-IBIG LOAN"
	or $_REQUEST['menu']=="PAG-IBIG CALAMITY LOAN"
	or $_REQUEST['menu']=="SALARY LOAN"
	or $_REQUEST['menu']=="CALAMITY LOAN"
	or $_REQUEST['menu']=="VETERANS LOAN")
	{	  
		echo "<td>Loan No</td>";
	}else{}

    if($_REQUEST['menu']=="ADJUSTMENTS"){ echo "<td class='w3-blue'>ADJUSTMENTS Entry</td>"; }
	if($_REQUEST['menu']=="SSS LOAN"){ echo "<td class='w3-red'>SSS LOAN Entry</td>"; }
	if($_REQUEST['menu']=="PAG-IBIG LOAN"){ echo "<td class='w3-red'>PAG-IBIG LOAN Entry</td>"; }
	if($_REQUEST['menu']=="PAG-IBIG CALAMITY LOAN"){ echo "<td class='w3-red'>PAG-IBIG CALAMITY Entry</td>"; }
	if($_REQUEST['menu']=="SALARY LOAN"){ echo "<td class='w3-red'>SALARY LOAN Entry</td>"; }
	if($_REQUEST['menu']=="CALAMITY LOAN"){ echo "<td class='w3-red'>CALAMITY LOAN Entry</td>"; }
	if($_REQUEST['menu']=="SSS CALAMITY LOAN"){ echo "<td class='w3-red'>SSS CALAMITY LOAN Entry</td>"; }
	if($_REQUEST['menu']=="CASH ADVANCE"){ echo "<td class='w3-red'>CASH ADVANCE Entry</td>"; }
	if($_REQUEST['menu']=="VETERANS LOAN"){ echo "<td class='w3-red'>VETERANS LOAN Entry</td>"; }
	if($_REQUEST['menu']=="OTHER CHARGES"){ echo "<td class='w3-red'>OTHER CHARGES Entry</td>"; }
	if($_REQUEST['menu']=="OVER IN PREVIOUS PAY"){ echo "<td class='w3-red'>OVER IN PREVIOUS PAY Entry</td>"; }
	
	echo "<td></td>
		</tr>";
		
do{
	
	    if($_REQUEST['menu']=="ADJUSTMENTS" or 
		   $_REQUEST['menu']=="OVER IN PREVIOUS PAY" or 
		   $_REQUEST['menu']=="OTHER CHARGES" or 
		   $_REQUEST['menu']=="ADJUSTMENTS" or
		   $_REQUEST['menu']=="CASH ADVANCE" or
		   $_REQUEST['menu']=="0")
		  { $loan_like=""; }
		
    	if($_REQUEST['menu']=="SSS LOAN"){ $loan_like="SS2"; }
		if($_REQUEST['menu']=="SSS CALAMITY LOAN"){ $loan_like="SSL"; }
		if($_REQUEST['menu']=="PAG-IBIG LOAN"){ $loan_like="PL"; }
		if($_REQUEST['menu']=="PAG-IBIG CALAMITY LOAN"){ $loan_like="PCL"; }
		if($_REQUEST['menu']=="SALARY LOAN"){ $loan_like="SL"; }
		if($_REQUEST['menu']=="CALAMITY LOAN"){ $loan_like="CL"; }
		if($_REQUEST['menu']=="VETERANS LOAN"){ $loan_like="VL"; }
	
	$emp=$r['e_no'];
	$pp_plusone = date ("Y-m-d", strtotime("+1 day", strtotime($pp)));
	$sx="select 
				sum(b.loan_payment) as loan_payment, b.loan_code
			from employee_loan a
			inner join employee_loan_todeduct b
				on a.loan_code = b.loan_code
			where a.e_no = '$emp' and (b.loan_date_payment = '$pp' or b.loan_date_payment = '$pp_plusone') and b.loan_code LIKE '$loan_like%'";
	
	$qx=mysql_query($sx) or die(mysql_error());
    $rx=mysql_fetch_assoc($qx);
    
	
echo "<tr>
		<form method='get'>
		    <input name='e_no' type='hidden' value='".$r['e_no']."'>
			<input name='payroll_period' type='hidden' value='".$_REQUEST['payroll_period']."'>
			<input name='menu' type='hidden' value='".$_REQUEST['menu']."'>
		<td>&nbsp;".$r['e_company']."</td>
		<td>&nbsp;".$r['e_department']."</td>	
		<td>&nbsp;".$r['e_no']."</td>
        <td>&nbsp;".$r['e_lname'].", ".$r['e_fname']."</td>";
		
		
		if($_REQUEST['menu']=="SSS LOAN" 
			or $_REQUEST['menu']=="SSS CALAMITY LOAN"
			or $_REQUEST['menu']=="PAG-IBIG LOAN"
			or $_REQUEST['menu']=="PAG-IBIG CALAMITY LOAN"
			or $_REQUEST['menu']=="SALARY LOAN"
			or $_REQUEST['menu']=="CALAMITY LOAN"
			or $_REQUEST['menu']=="VETERANS LOAN")
			{
	echo "<td>&nbsp;".$rx['loan_code']."</td>";
			
	    }else{};
  
  
		
  if($_REQUEST['menu']=="ADJUSTMENTS")           { echo "<td><input value='".$r['e_add_allowance']."' required type='number' name='e_add_allowance' step='any'></td>"; }
  if($_REQUEST['menu']=="SSS LOAN")              { echo "<td><input value='".number_format($rx['loan_payment'],2,'.','')."' required type='number' name='e_sss_loan' step='any'>".number_format($r['e_sss_loan'],2)."</td>"; }
  if($_REQUEST['menu']=="PAG-IBIG LOAN")         { echo "<td><input value='".number_format($rx['loan_payment'],2,'.','')."' required type='number' name='e_pagibig_loan' step='any'>".number_format($r['e_pagibig_loan'],2)."</td>"; }
  if($_REQUEST['menu']=="PAG-IBIG CALAMITY LOAN"){ echo "<td><input value='".number_format($rx['loan_payment'],2,'.','')."' required type='number' name='e_pagibig_loan_calamity' step='any'>".number_format($r['e_pagibig_loan_calamity'],2)."</td>"; }
  if($_REQUEST['menu']=="SALARY LOAN")           { echo "<td><input value='".number_format($rx['loan_payment'],2,'.','')."' required type='number' name='e_salary_loan' step='any'>".number_format($r['e_salary_loan'],2)."</td>"; }
  if($_REQUEST['menu']=="CALAMITY LOAN")         { echo "<td><input value='".number_format($rx['loan_payment'],2,'.','')."' required type='number' name='e_salary_calamity_loan' step='any'>".number_format($rx['e_salary_calamity_loan'],2)."</td>"; } 
  if($_REQUEST['menu']=="SSS CALAMITY LOAN")     { echo "<td><input value='".number_format($rx['loan_payment'],2,'.','')."' required type='number' name='e_sss_calamity_loan' step='any'>".number_format($r['e_sss_calamity_loan'],2)."</td>"; } 
  if($_REQUEST['menu']=="CASH ADVANCE")          { echo "<td><input value='".$r['e_ca']."' required type='number' name='e_ca' step='any'></td>"; }
  if($_REQUEST['menu']=="VETERANS LOAN")         { echo "<td><input value='".number_format($rx['loan_payment'],2,'.','')."' required type='number' name='e_veterans_loan' step='any'>".number_format($r['e_veterans_loan'],2)."</td>"; }
  if($_REQUEST['menu']=="OTHER CHARGES")         { echo "<td><input value='".$r['e_other_charges']."' required type='number' name='e_other_charges' step='any'></td>"; }
  if($_REQUEST['menu']=="OVER IN PREVIOUS PAY")  { echo "<td><input value='".$r['e_over_in_previous_pay']."' required type='number' name='e_over_in_previous_pay' step='any'></td>"; }
		
  echo "<td><input name='edit' type='submit' value='update'>
		    </form>
		</td> 
	 </tr>";

 } while($r=mysql_fetch_assoc($q)); ?>
</table>