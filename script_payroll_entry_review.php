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

<?php
$current_user=$_SESSION['username'];
$spas="select * from user_access where username='$current_user'";
$qpas=mysql_query($spas) or die(mysql_error());
$access=mysql_fetch_assoc($qpas);

$payroll_period=$_REQUEST['payroll_period'];

if(isset($_REQUEST['search']))
{
	if($_REQUEST['search']!="")
	{
	$search=$_REQUEST['search'];
	$sx="select e_no,e_fname,e_lname from employee where e_lname like '%$search%' order by e_lname asc";
	$qx=mysql_query($sx) or die(mysql_error());
	$rx=mysql_fetch_assoc($qx);
	$enox=$rx['e_no'];
	
	$s="select * from payroll where e_no='$enox' and payroll_period='$payroll_period' order by e_no asc";
	}
	else
	{
     $s="select * from payroll where payroll_period='$payroll_period' order by e_company asc, e_department asc, e_no asc";
    }
	
}
else
{
$s="select * from payroll where payroll_period='$payroll_period' order by e_company asc, e_department asc, e_no asc";
}

$q=mysql_query($s) or die(mysql_error());
$r=mysql_fetch_assoc($q);

//----Manual Edit Start----------------------
if(isset($_REQUEST['e_add_allowance']))
{
$e_no=$_REQUEST['e_no'];
$payroll_period=$_REQUEST['payroll_period'];
$amount=$_REQUEST['amount'];
$remarks=$_REQUEST['remarks'];
$s="update payroll set e_add_allowance=$amount,e_add_allowance_rem='$remarks' where payroll_period='$payroll_period' and e_no='$e_no' ";
mysql_query($s) or die(mysql_error());;

$username=$_SESSION['username'];
$trans="$e_no Adjustments edited to $amount remarks $remarks";
$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
$log_query=mysql_query($log_sql) or die(mysql_error());
header('Location:script_payroll_entry_review.php?edit=edit&e_no='.$e_no.'&payroll_period='.$payroll_period.'&name='.$_REQUEST['name']);
}

if(isset($_REQUEST['e_sss_loan']))
{
$e_no=$_REQUEST['e_no'];
$payroll_period=$_REQUEST['payroll_period'];
$amount=$_REQUEST['amount'];
$remarks=$_REQUEST['remarks'];
$s="update payroll set e_sss_loan=$amount,e_sss_loan_rem='$remarks' where payroll_period='$payroll_period' and e_no='$e_no' ";
mysql_query($s) or die(mysql_error());;

$username=$_SESSION['username'];
$trans="$e_no SSS Loan edited to $amount remarks $remarks";
$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
$log_query=mysql_query($log_sql) or die(mysql_error());
header('Location:script_payroll_entry_review.php?edit=edit&e_no='.$e_no.'&payroll_period='.$payroll_period.'&name='.$_REQUEST['name']);
}

if(isset($_REQUEST['e_pagibig_loan']))
{
$e_no=$_REQUEST['e_no'];
$payroll_period=$_REQUEST['payroll_period'];
$amount=$_REQUEST['amount'];
$remarks=$_REQUEST['remarks'];
$s="update payroll set e_pagibig_loan=$amount,e_pagibig_loan_rem='$remarks' where payroll_period='$payroll_period' and e_no='$e_no' ";
mysql_query($s) or die(mysql_error());;

$username=$_SESSION['username'];
$trans="$e_no Pagibig Loan edited to $amount remarks $remarks";
$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
$log_query=mysql_query($log_sql) or die(mysql_error());
header('Location:script_payroll_entry_review.php?edit=edit&e_no='.$e_no.'&payroll_period='.$payroll_period.'&name='.$_REQUEST['name']);
}

if(isset($_REQUEST['e_pagibig_loan_calamity']))
{
$e_no=$_REQUEST['e_no'];
$payroll_period=$_REQUEST['payroll_period'];
$amount=$_REQUEST['amount'];
$remarks=$_REQUEST['remarks'];
$s="update payroll set e_pagibig_loan_calamity=$amount,e_pagibig_loan_calamity_rem='$remarks' where payroll_period='$payroll_period' and e_no='$e_no' ";
mysql_query($s) or die(mysql_error());;

$username=$_SESSION['username'];
$trans="$e_no Pagibig Calamity Loan edited to $amount remarks $remarks";
$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
$log_query=mysql_query($log_sql) or die(mysql_error());
header('Location:script_payroll_entry_review.php?edit=edit&e_no='.$e_no.'&payroll_period='.$payroll_period.'&name='.$_REQUEST['name']);
}

if(isset($_REQUEST['e_salary_loan']))
{
$e_no=$_REQUEST['e_no'];
$payroll_period=$_REQUEST['payroll_period'];
$amount=$_REQUEST['amount'];
$remarks=$_REQUEST['remarks'];
$s="update payroll set e_salary_loan=$amount,e_salary_loan_rem='$remarks' where payroll_period='$payroll_period' and e_no='$e_no' ";
mysql_query($s) or die(mysql_error());;

$username=$_SESSION['username'];
$trans="$e_no Salary Loan edited to $amount remarks $remarks";
$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
$log_query=mysql_query($log_sql) or die(mysql_error());
header('Location:script_payroll_entry_review.php?edit=edit&e_no='.$e_no.'&payroll_period='.$payroll_period.'&name='.$_REQUEST['name']);
}

if(isset($_REQUEST['e_ca']))
{
$e_no=$_REQUEST['e_no'];
$payroll_period=$_REQUEST['payroll_period'];
$amount=$_REQUEST['amount'];
$remarks=$_REQUEST['remarks'];
$s="update payroll set e_ca=$amount,e_ca_rem='$remarks' where payroll_period='$payroll_period' and e_no='$e_no' ";
mysql_query($s) or die(mysql_error());;

$username=$_SESSION['username'];
$trans="$e_no Cash Advance edited to $amount remarks $remarks";
$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
$log_query=mysql_query($log_sql) or die(mysql_error());
header('Location:script_payroll_entry_review.php?edit=edit&e_no='.$e_no.'&payroll_period='.$payroll_period.'&name='.$_REQUEST['name']);
}

if(isset($_REQUEST['e_veterans_loan']))
{
$e_no=$_REQUEST['e_no'];
$payroll_period=$_REQUEST['payroll_period'];
$amount=$_REQUEST['amount'];
$remarks=$_REQUEST['remarks'];
$s="update payroll set e_veterans_loan=$amount,e_veterans_loan_rem='$remarks' where payroll_period='$payroll_period' and e_no='$e_no' ";
mysql_query($s) or die(mysql_error());;

$username=$_SESSION['username'];
$trans="$e_no Veterans Loan edited to $amount remarks $remarks";
$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
$log_query=mysql_query($log_sql) or die(mysql_error());
header('Location:script_payroll_entry_review.php?edit=edit&e_no='.$e_no.'&payroll_period='.$payroll_period.'&name='.$_REQUEST['name']);
}

if(isset($_REQUEST['e_other_charges']))
{
$e_no=$_REQUEST['e_no'];
$payroll_period=$_REQUEST['payroll_period'];
$amount=$_REQUEST['amount'];
$remarks=$_REQUEST['remarks'];
$s="update payroll set e_other_charges=$amount,e_other_charges_rem='$remarks' where payroll_period='$payroll_period' and e_no='$e_no' ";
mysql_query($s) or die(mysql_error());;

$username=$_SESSION['username'];
$trans="$e_no Other charges edited to $amount remarks $remarks";
$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
$log_query=mysql_query($log_sql) or die(mysql_error());
header('Location:script_payroll_entry_review.php?edit=edit&e_no='.$e_no.'&payroll_period='.$payroll_period.'&name='.$_REQUEST['name']);
}

if(isset($_REQUEST['e_over_in_previous_pay']))
{
$e_no=$_REQUEST['e_no'];
$payroll_period=$_REQUEST['payroll_period'];
$amount=$_REQUEST['amount'];
$remarks=$_REQUEST['remarks'];
$s="update payroll set e_over_in_previous_pay=$amount,e_over_in_previous_pay_rem='$remarks' where payroll_period='$payroll_period' and e_no='$e_no' ";
mysql_query($s) or die(mysql_error());;

$username=$_SESSION['username'];
$trans="$e_no Over in previous pay edited to $amount remarks $remarks";
$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
$log_query=mysql_query($log_sql) or die(mysql_error());
header('Location:script_payroll_entry_review.php?edit=edit&e_no='.$e_no.'&payroll_period='.$payroll_period.'&name='.$_REQUEST['name']);
}

//-----Manual Edit End------------------------

if(isset($_REQUEST['edit']))
{
$e_no=$_REQUEST['e_no'];
$payroll_period=$_REQUEST['payroll_period'];
$es="select * from payroll where e_no='$e_no' and payroll_period='$payroll_period'";
$eq=mysql_query($es) or die(mysql_error());
$er=mysql_fetch_assoc($eq);

echo "<br>";
echo $_REQUEST['e_no']." <strong>".$_REQUEST['name']."</strong>";
echo "<table border='1'>
        <tr class='w3-light-blue'>
		  <td width='150'><small>Transaction</small></td>
		  <td width='100'><small>Amount</small></td>
		  <td width='250'><small>Remarks</small></td>
		  <td width='100'><small>Amount</small></td>
		  <td width='250'><small>Remarks</small></td>
		</tr>
		
		<tr>
		  <td><small class='w3-blue'>Adjustments</small></td>
		  <td><small>".number_format($er['e_add_allowance'],2)."</small></td>
		  <td><small>".$er['e_add_allowance_rem']."</small></td>"; ?>
		  <form method="get">
		  <input name="e_no" type="hidden" value="<?php echo $_REQUEST['e_no']; ?>">
		  <input name="name" type="hidden" value="<?php echo $_REQUEST['name']; ?>">
		  <input name="payroll_period" type="hidden" value="<?php echo $_REQUEST['payroll_period']; ?>">
		  <td><input value="<?php echo $er['e_add_allowance']; ?>" name="amount" placeholder="Input Amount" type="number" step="any"></td>
		  <td><input name="remarks" placeholder="Remarks" type="text"></td>
		  <td><input name="e_add_allowance" type="submit" value="edit"></td>
		  </form>
		</tr>
		
		
<?php 		
  echo "<tr>
		  <td><small class='w3-red'>Veterans Loan</td>
		  <td><small>".number_format($er['e_veterans_loan'],2)."</small></td>
		  <td><small>".$er['e_veterans_loan_rem']."</small></td>"; ?>
		  <form method="get">
		  <input name="e_no" type="hidden" value="<?php echo $_REQUEST['e_no']; ?>">
		  <input name="name" type="hidden" value="<?php echo $_REQUEST['name']; ?>">
		  <input name="payroll_period" type="hidden" value="<?php echo $_REQUEST['payroll_period']; ?>">
		  <td><input value="<?php echo $er['e_veterans_loan']; ?>" name="amount" placeholder="Input Amount" type="number" step="any"></td>
		  <td><input name="remarks" placeholder="Remarks" type="text"></td>
		  <td><input name="e_veterans_loan" type="submit" value="edit"></td>
		  </form>
		</tr>	
		
<?php		
  echo "<tr>
		  <td><small class='w3-red'>Pag-Ibig Loan</td>
		  <td><small>".number_format($er['e_pagibig_loan'],2)."</small></td>
		  <td><small>".$er['e_pagibig_loan_rem']."</small></td>"; ?>
		  <form method="get">
		  <input name="e_no" type="hidden" value="<?php echo $_REQUEST['e_no']; ?>">
		  <input name="name" type="hidden" value="<?php echo $_REQUEST['name']; ?>">
		  <input name="payroll_period" type="hidden" value="<?php echo $_REQUEST['payroll_period']; ?>">
		  <td><input value="<?php echo $er['e_pagibig_loan']; ?>" name="amount" placeholder="Input Amount" type="number" step="any"></td>
		  <td><input name="remarks" placeholder="Remarks" type="text"></td>
		  <td><input name="e_pagibig_loan" type="submit" value="edit"></td>
		  </form>
		</tr>		
		
<?php
  echo "<tr>
		  <td><small class='w3-red'>SSS Loan</small></td>
		  <td><small>".number_format($er['e_sss_loan'],2)."</small></td>
		  <td><small>".$er['e_sss_loan_rem']."</small></td>"; ?>
		  <form method="get">
		  <input name="e_no" type="hidden" value="<?php echo $_REQUEST['e_no']; ?>">
		  <input name="name" type="hidden" value="<?php echo $_REQUEST['name']; ?>">
		  <input name="payroll_period" type="hidden" value="<?php echo $_REQUEST['payroll_period']; ?>">
		  <td><input value="<?php echo $er['e_sss_loan']; ?>" name="amount" placeholder="Input Amount" type="number" step="any"></td>
		  <td><input name="remarks" placeholder="Remarks" type="text"></td>
		  <td><input name="e_sss_loan" type="submit" value="edit"></td>
		  </form>
		</tr>

<?php		
  echo "<tr>
		  <td><small class='w3-red'>Pag-Ibig Calamity Loan</td>
		  <td><small>".number_format($er['e_pagibig_loan_calamity'],2)."</small></td>
		  <td><small>".$er['e_pagibig_loan_calamity_rem']."</small></td>"; ?>
		  <form method="get">
		  <input name="e_no" type="hidden" value="<?php echo $_REQUEST['e_no']; ?>">
		  <input name="name" type="hidden" value="<?php echo $_REQUEST['name']; ?>">
		  <input name="payroll_period" type="hidden" value="<?php echo $_REQUEST['payroll_period']; ?>">
		  <td><input value="<?php echo $er['e_pagibig_loan_calamity']; ?>" name="amount" placeholder="Input Amount" type="number" step="any"></td>
		  <td><input name="remarks" placeholder="Remarks" type="text"></td>
		  <td><input name="e_pagibig_loan_calamity" type="submit" value="edit"></td>
		  </form>
	    </tr>
<?php		
  echo "<tr>
		  <td><small class='w3-red'>Salary Loan</td>
		  <td><small>".number_format($er['e_salary_loan'],2)."</small></td>
		  <td><small>".$er['e_salary_loan_rem']."</small></td>"; ?>
		  <form method="get">
		  <input name="e_no" type="hidden" value="<?php echo $_REQUEST['e_no']; ?>">
		  <input name="name" type="hidden" value="<?php echo $_REQUEST['name']; ?>">
		  <input name="payroll_period" type="hidden" value="<?php echo $_REQUEST['payroll_period']; ?>">
		  <td><input value="<?php echo $er['e_salary_loan']; ?>" name="amount" placeholder="Input Amount" type="number" step="any"></td>
		  <td><input name="remarks" placeholder="Remarks" type="text"></td>
		  <td><input name="e_salary_loan" type="submit" value="edit"></td>
		  </form>
		</tr>
		
<?php		
  echo "<tr>
		  <td><small class='w3-red'>Cash Advance</td>
		  <td><small>".number_format($er['e_ca'],2)."</small></td>
		  <td><small>".$er['e_ca_rem']."</small></td>"; ?>
		  <form method="get">
		  <input name="e_no" type="hidden" value="<?php echo $_REQUEST['e_no']; ?>">
		  <input name="name" type="hidden" value="<?php echo $_REQUEST['name']; ?>">
		  <input name="payroll_period" type="hidden" value="<?php echo $_REQUEST['payroll_period']; ?>">
		  <td><input value="<?php echo $er['e_ca']; ?>" name="amount" placeholder="Input Amount" type="number" step="any"></td>
		  <td><input name="remarks" placeholder="Remarks" type="text"></td>
		  <td><input name="e_ca" type="submit" value="edit"></td>
		  </form>
		</tr>		
	  
<?php 		
  echo "<tr>
		  <td><small class='w3-red'>Other Charges</td>
		  <td><small>".number_format($er['e_other_charges'],2)."</small></td>
		  <td><small>".$er['e_other_charges_rem']."</small></td>"; ?>
		  <form method="get">
		  <input name="e_no" type="hidden" value="<?php echo $_REQUEST['e_no']; ?>">
		  <input name="name" type="hidden" value="<?php echo $_REQUEST['name']; ?>">
		  <input name="payroll_period" type="hidden" value="<?php echo $_REQUEST['payroll_period']; ?>">
		  <td><input value="<?php echo $er['e_other_charges']; ?>" name="amount" placeholder="Input Amount" type="number" step="any"></td>
		  <td><input name="remarks" placeholder="Remarks" type="text"></td>
		  <td><input name="e_other_charges" type="submit" value="edit"></td>
		  </form>
		</tr>
		
<?php 		
  echo "<tr>
		  <td><small class='w3-red'>Over in Previous Pay</td>
		  <td><small>".number_format($er['e_over_in_previous_pay'],2)."</small></td>
		  <td><small>".$er['e_over_in_previous_pay_rem']."</small></td>"; ?>
		  <form method="get">
		  <input name="e_no" type="hidden" value="<?php echo $_REQUEST['e_no']; ?>">
		  <input name="name" type="hidden" value="<?php echo $_REQUEST['name']; ?>">
		  <input name="payroll_period" type="hidden" value="<?php echo $_REQUEST['payroll_period']; ?>">
		  <td><input value="<?php echo $er['e_over_in_previous_pay']; ?>" name="amount" placeholder="Input Amount" type="number" step="any"></td>
		  <td><input name="remarks" placeholder="Remarks" type="text"></td>
		  <td><input name="e_over_in_previous_pay" type="submit" value="edit"></td>
		  </form>
		</tr>
		
<?php 		
  echo "<tr>
		  <td><small class='w3-red'>Other Charges</td>
		  <td><small>".number_format($er['e_other_charges'],2)."</small></td>
		  <td><small>".$er['e_other_charges_rem']."</small></td>"; ?>
		  <form method="get">
		  <input name="e_no" type="hidden" value="<?php echo $_REQUEST['e_no']; ?>">
		  <input name="name" type="hidden" value="<?php echo $_REQUEST['name']; ?>">
		  <input name="payroll_period" type="hidden" value="<?php echo $_REQUEST['payroll_period']; ?>">
		  <td><input value="<?php echo $er['e_other_charges']; ?>" name="amount" placeholder="Input Amount" type="number" step="any"></td>
		  <td><input name="remarks" placeholder="Remarks" type="text"></td>
		  <td><input name="e_other_charges" type="submit" value="edit"></td>
		  </form>
		</tr>				

		
<?php

			$z1="select * from payroll_cutoff";
			$z2=mysql_query($z1) or die(mysql_error());
			$z3=mysql_fetch_assoc($z2);
		   
			    if(date('d')>=$z3['c1'] && date('d')<=$z3['c11'])
			    { }
		     
				elseif(date('d')>=$z3['c2'] && date('d')<=$z3['c22'])
			    { } 
			  
				else
				{
		?>

		
		
		<?php } //else END ?>
		
		
	  </table><br>	  

<?php 
} ?>
<br>
<form method='get'>
<input name='payroll_period' type='hidden' value='<?php echo $_REQUEST['payroll_period'];?>'>
&nbsp;<input name='search' type='text' placeholder='INPUT LASTNAME'>
<input type='submit' value='search'>
</form>

<?php
echo "<table border='1'>
        <tr align='center'><td class='bg-danger' colspan='18'>Payroll Period: ".date('m-d-Y',strtotime($_REQUEST['payroll_period']))."</td></tr>
		<tr class='w3-blue' align='center'>
		    <td colspan='2'><small>Employee Details</small></td>
			<td colspan='2'><small>SSS Loan</small></td>
			<td colspan='2'><small>Pag-Ibig Loan</small></td>
			<td colspan='2'><small>Pag-Ibig Calamity Loan</small></td>
			<td colspan='2'><small>Salary Loan</small></td>
			<td colspan='2'><small>Cash Advance</small></td>
			<td colspan='2'><small>Veterans Loan</small></td>
			<td colspan='2'><small>Other Charges</small></td>
			<td colspan='2'><small>Over in Previous Pay</small></td>
		</tr>
		<tr align='center' class='w3-light-blue'>
		    <td width='100'><small>ID</small></td><td><small>Name</small></td>
			<td width='100'><small>Amount</small></td><td width='100'><small>Remarks</small></td>
			<td width='100'><small>Amount</small></td><td width='100'><small>Remarks</small></td>
			<td width='100'><small>Amount</small></td><td width='100'><small>Remarks</small></td>
			<td width='100'><small>Amount</small></td><td width='100'><small>Remarks</small></td>
			<td width='100'><small>Amount</small></td><td width='100'><small>Remarks</small></td>
			<td width='100'><small>Amount</small></td><td width='100'><small>Remarks</small></td>
			<td width='100'><small>Amount</small></td><td width='100'><small>Remarks</small></td>
			<td width='100'><small>Amount</small></td><td width='100'><small>Remarks</small></td>
		</tr>";

do{
	  $eno=$r['e_no'];
      $s1="select e_fname,e_mname,e_lname from employee where e_no='$eno'";
	  $q1=mysql_query($s1) or die(mysql_error());
	  $r1=mysql_fetch_assoc($q1);
echo "<tr class='w3-hover-lime'><td><small><span class='w3-tiny'>".$r['e_company']."</span><br><span class='w3-tiny w3-text-red'><b>".$r['e_department']."</b></span><br>".$r['e_no']."<small></td>
          <td><small>".$r1['e_lname'].", ".$r1['e_fname']." ".substr($r1['e_mname'],0,1).".<small></td>
		  <td><small>".number_format($r['e_sss_loan'],2)."</td><td><small>".$r['e_sss_loan_rem']."</small></td>
		  <td><small>".number_format($r['e_pagibig_loan'],2)."</td><td><small>".$r['e_pagibig_loan_rem']."</small></td>
		  <td><small>".number_format($r['e_pagibig_loan_calamity'],2)."</td><td><small>".$r['e_pagibig_loan_calamity_rem']."</small></td>
		  <td><small>".number_format($r['e_salary_loan'],2)."</td><td><small>".$r['e_salary_loan_rem']."</small></td>
		  <td><small>".number_format($r['e_ca'],2)."</td><td><small>".$r['e_ca_rem']."</small></td>
		  <td><small>".number_format($r['e_veterans_loan'],2)."</td><td><small>".$r['e_veterans_loan_rem']."</small></td>
		  <td><small>".number_format($r['e_other_charges'],2)."</td><td><small>".$r['e_other_charges_rem']."</small></td>
		  <td><small>".number_format($r['e_over_in_previous_pay'],2)."</td><td><small>".$r['e_over_in_previous_pay_rem']."</small></td>
		  <td>"; ?>
		  <form method="get">
		  <input name="search" type="hidden" value="<?php echo $_REQUEST['search']; ?>">
		  <input name="e_no" type="hidden" value="<?php echo $r['e_no']; ?>">
		  <input name="name" type="hidden" value="<?php echo $r1['e_lname'].", ".$r1['e_fname']." ".substr($r1['e_mname'],0,1)."."; ?>">
		  <input name="payroll_period" type="hidden" value="<?php echo $_REQUEST['payroll_period']; ?>">
<?php if($access['a8']==1)
        { if($r['step3']==0)
		   { ?>
          <input name="edit" type="submit" value="edit">
     <?php }
        } ?>
		  </form>
<?php echo "</td>
	  </tr>";
 } while($r=mysql_fetch_assoc($q)); ?>
</table>