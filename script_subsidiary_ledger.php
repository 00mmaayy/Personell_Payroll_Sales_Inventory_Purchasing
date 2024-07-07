<?php 
session_start();
include('connection/conn.php');
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); }
?>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/w3.css">
<link rel="stylesheet" href="css/font-awesome.min.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>

<div class='container'>
<div align='right'><a class='w3-xlarge' href="javascript:window.open('','_self').close();">X</a></div>
<div><b>START PERIOD: APRIL 2018 - PRESENT</b></div>
<?php
$e_no=$_REQUEST['e_no'];
 $s="select a.e_no as e_no,
			b.e_fname as e_fname,
			b.e_lname as e_lname,
			b.e_company as e_company,
			b.e_department as e_department,
			a.payroll_period as payroll_period,
			a.e_ca as ca,
			a.e_pagibig_loan as pgl,
			a.e_pagibig_loan_calamity as pglc,
			a.e_salary_loan as sl,
			a.e_sss_loan as sssl,
			a.e_veterans_loan as vetl,
			a.e_salary_calamity_loan as scl,
			a.e_sss_calamity_loan as sscl,
			a.e_other_charges as oc,
			a.e_other_charges_rem as ocr,
			a.e_add_allowance as aa,
			a.e_add_allowance_rem as aar
	from payroll as a
	inner join employee as b
	on a.e_no=b.e_no
	where a.payroll_period>='2018-04-11' and a.e_no='$e_no'
	order by a.payroll_period desc";

$q=mysql_query($s) or die(mysql_error());
$r=mysql_fetch_assoc($q);

$s1="select sum(e_ca) as cat,
			sum(e_pagibig_loan) as pglt,
			sum(e_pagibig_loan_calamity) as pglct,
			sum(e_salary_loan) as slt,
			sum(e_sss_loan) as ssslt,
			sum(e_veterans_loan) as vetlt,
			sum(e_salary_calamity_loan) as sclt,
			sum(e_sss_calamity_loan) as ssclt,
			sum(e_other_charges) as oct,
			sum(e_add_allowance) as aat
	from payroll
	where payroll_period>='2018-04-11' and e_no='$e_no'";
$q1=mysql_query($s1) or die(mysql_error());
$r1=mysql_fetch_assoc($q1);
	
		echo "<br>ID NO: <b class='w3-text-indigo'>".$r['e_no']."</b><br>";
		echo "NAME: <b class='w3-text-indigo'>".$r['e_lname'].", ".$r['e_fname']."</b><br>";
		echo "COMPANY: <b class='w3-text-indigo'>".$r['e_company']."</b><br>";
		echo "DEPT: <b class='w3-text-indigo'>".$r['e_department']."</b>";	
	
echo "<table border='1' class='table'>
		<tr class='w3-green w3-small' align='center'>
			<td align='center'>&nbsp;COUNT&nbsp;</td>
			<td>&nbsp;PAYROLL PERIOD&nbsp;</td>
			<td>&nbsp;CASH ADVANCE&nbsp;</td>
			<td>&nbsp;PAGIBIG LOAN&nbsp;</td>
			<td>&nbsp;PAGIBIG CALAMITY&nbsp;</td>
			<td>&nbsp;SALARY LOAN&nbsp;</td>
			<td>&nbsp;CALAMITY LOAN&nbsp;</td>
			<td>&nbsp;SSS LOAN&nbsp;</td>
			<td>&nbsp;SSS CALAMITY LOAN&nbsp;</td>
			<td>&nbsp;VETERANS LOAN&nbsp;</td>
			<td>&nbsp;OTHER CHARGES&nbsp;</td>
			<td>&nbsp;OTHER CHARGES REMARKS&nbsp;</td>
			<td>&nbsp;ADJUSTMENTS&nbsp;</td>
			<td>&nbsp;ADJUSTMENTS REMARKS&nbsp;</td>
		</tr>";
$x=1;		
do{

echo "<tr class='w3-hover-pale-red'>
		<td align='center' class='w3-small'>".$x++."</td>
		<td align='center' class='w3-small'>".date('m-d-Y',strtotime($r['payroll_period']))."</td>
		<td align='right' class='w3-text-indigo w3-small'><b>";
		if($r['ca']!=0){ echo number_format(round($r['ca'],2),2); }
  echo "</b></td>
		<td align='right' class='w3-text-indigo w3-small'><b>";
		if($r['pgl']!=0){ echo number_format(round($r['pgl'],2),2); }
  echo "</b></td>
		<td align='right' class='w3-text-indigo w3-small'><b>";
		if($r['pglc']!=0){ echo number_format(round($r['pglc'],2),2); }
  echo "</b></td>
		<td align='right' class='w3-text-indigo w3-small'><b>";
		if($r['sl']!=0){ echo number_format(round($r['sl'],2),2); }
  echo "</b></td>
  <td align='right' class='w3-text-indigo w3-small'><b>";
		if($r['scl']!=0){ echo number_format(round($r['scl'],2),2); }
  echo "</b></td>
		<td align='right' class='w3-text-indigo w3-small'><b>";
		if($r['sssl']!=0){ echo number_format(round($r['sssl'],2),2); }
  echo "</b></td>
  <td align='right' class='w3-text-indigo w3-small'><b>";
		if($r['sscl']!=0){ echo number_format(round($r['sscl'],2),2); }
  echo "</b></td>
		<td align='right' class='w3-text-indigo w3-small'><b>";
		if($r['vetl']!=0){ echo number_format(round($r['vetl'],2),2); }
  echo "</b></td>
  <td align='right' class='w3-text-indigo w3-small'><b>";
		if($r['oc']!=0){ echo number_format(round($r['oc'],2),2); }
  echo "</b></td>
  <td align='right' class='w3-text-indigo w3-small'>";
		if($r['ocr']!=""){ echo $r['ocr']; }
  echo "</td>
  <td align='right' class='w3-text-indigo w3-small'><b>";
		if($r['aa']!=0){ echo number_format(round($r['aa'],2),2); }
  echo "</b></td>
  <td align='right' class='w3-text-indigo w3-small'>";
		if($r['aar']!=""){ echo $r['aar']; }
  echo "</td>
	</tr>";
	
}while($r=mysql_fetch_assoc($q));

echo "<tr align='right' class='w3-text-red'>
			<td></td>
			<td align='center'><b>TOTAL</b></td>
			<td><b>";
			if($r1['cat']!=0){ echo number_format(round($r1['cat'],2),2); }
	  echo "</b></td>
			<td><b>";
			if($r1['pglt']!=0){ echo number_format(round($r1['pglt'],2),2); }
	  echo "</b></td>";
	  echo "<td><b>";
			if($r1['pglct']!=0){ echo number_format(round($r1['pglct'],2),2); }
	  echo "</b></td>";
	  echo "<td><b>";
			if($r1['slt']!=0){ echo number_format(round($r1['slt'],2),2); }
	  echo "</b></td>";
	  echo "<td><b>";
	  if($r1['slt']!=0){ echo number_format(round($r1['sclt'],2),2); }
echo "</b></td>";
	  echo "<td><b>";
			if($r1['ssslt']!=0){ echo number_format(round($r1['ssslt'],2),2); }
	  echo "</b></td>";
	  echo "<td><b>";
	  if($r1['ssslt']!=0){ echo number_format(round($r1['ssclt'],2),2); }
echo "</b></td>";
	  echo "<td><b>";
			if($r1['vetlt']!=0){ echo number_format(round($r1['vetlt'],2),2); }
	  echo "</b></td>";
	  echo "<td><b>";
			if($r1['oct']!=0){ echo number_format(round($r1['oct'],2),2); }
	  echo "</b></td><td></td>";
	  echo "<td><b>";
			if($r1['aat']!=0){ echo number_format(round($r1['aat'],2),2); }
	  echo "</b></td>";
	  echo "<td></td>
	  
	</tr>"
?>
</div><?php 
session_start();
include('connection/conn.php');
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); }
?>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/w3.css">
<link rel="stylesheet" href="css/font-awesome.min.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>

<hr>

<table>
 <tr valign='top'>
  <td width='15'></td>
  <td>
   
    <form method='get'>
		<input name='subsidiary' type='hidden' value='1'>
		<?php 
		$qqq=mysql_query("SELECT payroll_period from payroll group by payroll_period order by payroll_period DESC") or die(mysql_error()); 
		$rrr=mysql_fetch_assoc($qqq);
	    echo "<b class='w3-text-indigo'>Payroll Date Lists</b><br><br>";
		do{ echo "<input type='radio' name='payroll_period' value='".$rrr['payroll_period']."'> &nbsp; <span class='w3-tiny'>".date('F d, Y',strtotime($rrr['payroll_period']))."</span><br>";
		} while($rrr=mysql_fetch_assoc($qqq));
		?>
		<br>
		<input class='btn btn-info w3-tiny' type='submit' value='OPEN'>	
	</form>
	
  </td>
  <td width='15'></td>
  <td>
  
	<form method='get'>
		<input name='subsidiary' type='hidden' value='1'>
		<input name='payroll_period' type='hidden' value='<?php echo $_REQUEST['payroll_period']; ?>'>
        <select required name="company">
		            <option></option>
					 <?php $x1="select company from company";
						 $y1=mysql_query($x1) or die(mysql_error());
						 $z1=mysql_fetch_assoc($y1); 
						 do{
						  echo "<option>".$z1['company']."</option>";
						 }while($z1=mysql_fetch_assoc($y1));
					  ?>
		</select>
		<input class='btn btn-info w3-tiny' type='submit' value='sort'>
	</form> 
 
<?php

if(isset($_REQUEST['company'])){ $xcomp=" and a.e_company='".$_REQUEST['company']."'"; }else{ $xcomp='';}

if($_REQUEST['payroll_period']!=1)
{
$pp=$_REQUEST['payroll_period'];	
echo "<b>START PERIOD: ".date('F d, Y',strtotime($_REQUEST['payroll_period']))."</b>";
 $s="select a.e_no as e_no,
			b.e_fname as e_fname,
			b.e_lname as e_lname,
			b.e_company as e_company,
			b.e_department as e_department,
			a.e_ca as ca,
			a.e_pagibig_loan as pgl,
			a.e_pagibig_loan_calamity as pglc,
			a.e_salary_loan as sl,
			a.e_sss_loan as sssl,
			a.e_veterans_loan as vetl,
			a.e_salary_calamity_loan as scl,
			a.e_sss_calamity_loan as sscl,
			a.e_other_charges as oc,
			a.e_other_charges_rem as ocr,
			a.e_add_allowance as aa,
			a.e_add_allowance_rem as aar
	from payroll as a
	inner join employee as b
	on a.e_no=b.e_no
	where a.payroll_period='$pp' $xcomp
	group by a.e_no 
	order by b.e_company, b.e_department, b.e_lname asc";
}	

if($_REQUEST['payroll_period']==1)
{
echo "<b>START PERIOD: APRIL 2018 - PRESENT</b>";
 $s="select a.e_no as e_no,
			b.e_fname as e_fname,
			b.e_lname as e_lname,
			b.e_company as e_company,
			b.e_department as e_department,
			sum(a.e_ca) as ca,
			sum(a.e_pagibig_loan) as pgl,
			sum(a.e_pagibig_loan_calamity) as pglc,
			sum(a.e_salary_loan) as sl,
			sum(a.e_sss_loan) as sssl,
			sum(a.e_veterans_loan) as vetl,
			sum(a.e_salary_calamity_loan) as scl,
			sum(a.e_sss_calamity_loan) as sscl,
			sum(a.e_other_charges) as oc,
			sum(a.e_add_allowance) as aa
	from payroll as a
	inner join employee as b
	on a.e_no=b.e_no
	where a.payroll_period>='2018-04-11' $xcomp
	group by a.e_no 
	order by b.e_company, b.e_department, b.e_lname asc";
}	

$q=mysql_query($s) or die(mysql_error());
$r=mysql_fetch_assoc($q);

if($_REQUEST['payroll_period']!=1)
{
$pp=$_REQUEST['payroll_period'];	
$s1="select sum(a.e_ca) as cat,
			sum(a.e_pagibig_loan) as pglt,
			sum(a.e_pagibig_loan_calamity) as pglct,
			sum(a.e_salary_loan) as slt,
			sum(a.e_sss_loan) as ssslt,
			sum(a.e_veterans_loan) as vetlt,
			sum(a.e_salary_calamity_loan) as sclt,
			sum(a.e_sss_calamity_loan) as ssclt,
			sum(a.e_other_charges) as oct,
			sum(a.e_add_allowance) as aat
	from payroll as a
	where a.payroll_period='$pp' $xcomp";
$q1=mysql_query($s1) or die(mysql_error());
$r1=mysql_fetch_assoc($q1);
}

if($_REQUEST['payroll_period']==1)
{
$s1="select sum(a.e_ca) as cat,
			sum(a.e_pagibig_loan) as pglt,
			sum(a.e_pagibig_loan_calamity) as pglct,
			sum(a.e_salary_loan) as slt,
			sum(a.e_sss_loan) as ssslt,
			sum(a.e_veterans_loan) as vetlt,
			sum(a.e_salary_calamity_loan) as sclt,
			sum(a.e_sss_calamity_loan) as ssclt,
			sum(a.e_other_charges) as oct,
			sum(a.e_add_allowance) as aat
	from payroll as a
	where a.payroll_period>='2018-04-11' $xcomp";
$q1=mysql_query($s1) or die(mysql_error());
$r1=mysql_fetch_assoc($q1);
}

echo "<table border='1' class='table'>
		<tr class='w3-green w3-small' align='center'>
			<td>&nbsp;ID&nbsp;</td>
			<td>&nbsp;NAME&nbsp;</td>
			<td>&nbsp;COMPANY&nbsp;</td>
			<td>&nbsp;DEPARTMENT&nbsp;</td>
			<td>&nbsp;CASH ADVANCE&nbsp;</td>
			<td>&nbsp;PAGIBIG LOAN&nbsp;</td>
			<td>&nbsp;PAGIBIG CALAMITY&nbsp;</td>
			<td>&nbsp;SALARY LOAN&nbsp;</td>
			<td>&nbsp;CALAMITY LOAN&nbsp;</td>
			<td>&nbsp;SSS LOAN&nbsp;</td>
			<td>&nbsp;SSS CALAMITY LOAN&nbsp;</td>
			<td>&nbsp;VETERANS LOAN&nbsp;</td>
			<td>&nbsp;OTHER CHARGES&nbsp;</td>
			<td>&nbsp;ADJUSTMENTS&nbsp;</td>
		</tr>";

do{

if($r['ca']!=0 or $r['pgl']!=0 or $r['pglc']!=0 or $r['sl']!=0 or $r['sssl']!=0 or $r['vetl']!=0 or $r['oc']!=0 or $r['aa']!=0)
	{
  echo "<tr class='w3-hover-pale-red'>
		<td class='w3-small'><a href='script_subsidiary_ledger_individual.php?e_no=".$r['e_no']."' target='_blank'><b>".$r['e_no']."</b></a></td>
		<td class='w3-small'>".$r['e_lname'].", ".$r['e_fname']."</td>
		<td align='center' class='w3-small'>".$r['e_company']."</td>
		<td align='center' class='w3-small'>".$r['e_department']."</td>
		<td align='right' class='w3-text-indigo w3-small'><b>";
		if($r['ca']!=0){ echo number_format(round($r['ca'],2),2); }
  echo "</b></td>
		<td align='right' class='w3-text-indigo w3-small'><b>";
		if($r['pgl']!=0){ echo number_format(round($r['pgl'],2),2); }
  echo "</b></td>
		<td align='right' class='w3-text-indigo w3-small'><b>";
		if($r['pglc']!=0){ echo number_format(round($r['pglc'],2),2); }
  echo "</b></td>
		<td align='right' class='w3-text-indigo w3-small'><b>";
		if($r['sl']!=0){ echo number_format(round($r['sl'],2),2); }
  echo "</b></td>
  <td align='right' class='w3-text-indigo w3-small'><b>";
  if($r['scl']!=0){ echo number_format(round($r['scl'],2),2); }
	echo "</b></td>	
		<td align='right' class='w3-text-indigo w3-small'><b>";
		if($r['sssl']!=0){ echo number_format(round($r['sssl'],2),2); }
  echo "</b></td>
  <td align='right' class='w3-text-indigo w3-small'><b>";
		if($r['sscl']!=0){ echo number_format(round($r['sscl'],2),2); }
  echo "</b></td>
		<td align='right' class='w3-text-indigo w3-small'><b>";
		if($r['vetl']!=0){ echo number_format(round($r['vetl'],2),2); }
  echo "</b></td>
		<td align='right' class='w3-text-indigo w3-small'><b>";
		if($r['oc']!=0){ echo number_format(round($r['oc'],2),2); }
  echo "</b>";
  echo "<br>";
  if($_REQUEST['payroll_period']!=1){ echo $r['ocr']; }
  echo "</td>
  		<td align='right' class='w3-text-indigo w3-small'><b>";
		if($r['aa']!=0){ echo number_format(round($r['aa'],2),2); }
  echo "</b>";
  echo "<br>";
  if($_REQUEST['payroll_period']!=1){ echo $r['aar']; }
  echo "</td>
	   </tr>";
	}
	
}while($r=mysql_fetch_assoc($q));

echo "<tr align='right'>
		<td colspan='4' align='right'>TOTALS</td>
		<td class='w3-text-red'><b>".number_format(round($r1['cat'],2),2)."</b></td>
		<td class='w3-text-red'><b>".number_format(round($r1['pglt'],2),2)."</b></td>
		<td class='w3-text-red'><b>".number_format(round($r1['pglct'],2),2)."</b></td>
		<td class='w3-text-red'><b>".number_format(round($r1['slt'],2),2)."</b></td>
		<td class='w3-text-red'><b>".number_format(round($r1['sclt'],2),2)."</b></td>
		<td class='w3-text-red'><b>".number_format(round($r1['ssslt'],2),2)."</b></td>
		<td class='w3-text-red'><b>".number_format(round($r1['ssclt'],2),2)."</b></td>
		<td class='w3-text-red'><b>".number_format(round($r1['vetlt'],2),2)."</b></td>
		<td class='w3-text-red'><b>".number_format(round($r1['oct'],2),2)."</b></td>
		<td class='w3-text-red'><b>".number_format(round($r1['aat'],2),2)."</b></td>
	</tr>";
?>
  </td>
 </tr>
</table>
