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

<body><br>

 <form method="get">
 <div class='w3-text-green' align='center'><b>SEARCH EMPLOYEE</b></div>
 <table align='center'>         
	<tr class='w3-tiny' align='right'><td><b>COMPANY</b></td><td><b>DEPARTMENT</b></td><td><b>EMPLOYMENT STATUS</b></td></tr>
    <tr>
		<td>
		  <select required name="company">
		            <option></option>
					<option>ALL</option>
				   <?php $x1="select company from company";
						 $y1=mysql_query($x1) or die(mysql_error());
						 $z1=mysql_fetch_assoc($y1); 
						 do{
						  echo "<option>".$z1['company']."</option>";
						 }while($z1=mysql_fetch_assoc($y1));
					  ?>
		  </select>
		</td>
        <td>&nbsp;		
		  <select required name="department">
					<option></option>
					<option>ALL</option>
				   <?php $x1="select dept_name from departments";
						 $y1=mysql_query($x1) or die(mysql_error());
						 $z1=mysql_fetch_assoc($y1); 
						 do{
						  echo "<option>".$z1['dept_name']."</option>";
						 }while($z1=mysql_fetch_assoc($y1));
					  ?>
		  </select>
        </td>
		<td>&nbsp;		
		  <select name="emp_stat">
					<option></option>
					<option>ALL</option>
					<option value='Regular'>REGULAR</option>
					<option value='Probationary'>PROBATIONARY</option>
					<option value='Contractual'>CONTRACTUAL</option>
					<option value='OnCall'>ONCALL</option>
					<option value='Resigned'>RESIGNED</option>
                    <option value='NotConnected'>NOTCONNECTED</option>
					<option value='Agency'>AGENCY</option>
					<option value='Others'>OTHERS</option>
		  </select>
		</td>
    </tr>
    </table>	
 <br>

<table align='center'> 
  <tr><td align='left' class='w3-tiny'><input class='w3-check' name='c1' type='checkbox'> <b>ADDRESS</b></td><td width='20'>&nbsp;</td><td align='left' class='w3-tiny'><input class='w3-check' name='c5' type='checkbox'> <b>MOBILE <span class='w3-text-red'> & </span> EMAIL</b></td></tr>
  <tr><td align='left' class='w3-tiny'><input class='w3-check' name='c2' type='checkbox'> <b>BIRTHDAY <span class='w3-text-red'> & </span> BIRTH PLACE</b></td><td></td><td align='left' class='w3-tiny'><input class='w3-check' name='c6' type='checkbox'> <b>EMPLOYMENT STATUS <span class='w3-text-red'> & </span> JOB TITLE <span class='w3-text-red'> & </span> DATE ENTRY <span class='w3-text-red'> & </span> DATE EXIT</b></td></tr>      
  <tr><td align='left' class='w3-tiny'><input class='w3-check' name='c3' type='checkbox'> <b>GENDER <span class='w3-text-red'> & </span> CIVIL STATUS <span class='w3-text-red'> & </span> RELIGION</b></td><td></td><td align='left' class='w3-tiny'><input class='w3-check' name='c7' type='checkbox'> <b>SSS <span class='w3-text-red'> & </span> TIN <span class='w3-text-red'> & </span> PHILHEALTH <span class='w3-text-red'> & </span> PAGIBIG <span class='w3-text-red'> & </span> DRIVERS LIC <span class='w3-text-red'> & </span> PASSPORT <span class='w3-text-red'> & </span> ATM ACCOUNT NO</b></td></tr>
  <tr><td align='left' class='w3-tiny'><input class='w3-check' name='c4' type='checkbox'> <b>HEIGHT <span class='w3-text-red'> & </span> WEIGHT <span class='w3-text-red'> & </span> BLOOD TYPE</b></td><td></td><td align='left' class='w3-tiny'><input class='w3-check' name='c8' type='checkbox'> <b>BASIC PAY <span class='w3-text-red'> & </span> RATES <span class='w3-text-red'> & </span> SALARY SCHEDULE <span class='w3-text-red'> & </span> TIME CLASS</b></td></tr>
</table> 
  <div align='center'><br><input name='search' type='submit'></div>
 </form>
</table>
<hr>

<?php
if(isset($_REQUEST['search']))
{	
		if($_REQUEST['company']=="ALL")
		{ 
			$company="where e_company!='ALL'"; 
			
			if($_REQUEST['department']=="ALL")
			{ $department=""; } 
			else { $department1=$_REQUEST['department']; $department="and e_department='$department1'"; }
			
			if($_REQUEST['emp_stat']=="ALL")
			{ $emp_stat=""; } 
			else { $emp_stat1=$_REQUEST['emp_stat']; $emp_stat="and e_employment_status='$emp_stat1'"; }
		}
	else{
			$company1=$_REQUEST['company']; 
			$company="where e_company='$company1'"; 
			
			if($_REQUEST['department']=="ALL")
			{ $department=""; } 
			else { $department1=$_REQUEST['department']; $department="and e_department='$department1'"; }
			
			if($_REQUEST['emp_stat']=="ALL")
			{ $emp_stat=""; } 
			else { $emp_stat1=$_REQUEST['emp_stat']; $emp_stat="and e_employment_status='$emp_stat1'"; }
		}
		
		$s="select * from employee $company $department $emp_stat order by e_company,e_department,e_lname asc";
	
	
	$q=mysql_query($s) or die(mysql_error());
	$r=mysql_fetch_assoc($q);
	$count=mysql_num_rows($q);
	
	echo "<div class='w3-tiny w3-text-deep-orange' align='center'>Your search tag is: Company=<b>".$_REQUEST['company']."</b>, Department=<b>".$_REQUEST['department']."</b>, EmploymentStatus=<b>".$_REQUEST['emp_stat']."</b>";
	if(isset($_REQUEST['c1'])){ echo "<br><b>ADDRESS</b>"; }
	if(isset($_REQUEST['c2'])){ echo "<br><b>BIRTHDAY & AGE & BIRTH PLACE</b>"; }
	if(isset($_REQUEST['c3'])){ echo "<br><b>GENDER & CIVIL STATUS & RELIGION</b>"; }
	if(isset($_REQUEST['c4'])){ echo "<br><b>HEIGHT & WEIGTH & BLOOD TYPE</b>"; }
	if(isset($_REQUEST['c5'])){ echo "<br><b>MOBILE NO. & EMAIL</b>"; }
	if(isset($_REQUEST['c6'])){ echo "<br><b>EMPLOYMENT STATUS & REGULARIZATION DATE & JOB TITLE & DATE ENTRY & DATE EXIT</b>"; }
	if(isset($_REQUEST['c7'])){ echo "<br><b>SSS & TIN & PHILHEALTH & PAGIBIG & DRIVERS LIC & PASSPORT & ATM ACCOUNT</b>"; }
	if(isset($_REQUEST['c8'])){ echo "<br><b>BASIC PER MONTH & BASIC PER DAY & SALARY SCHEDULE & TIME CLASS</b>"; }
	echo  "</div><br>";
	
	echo "<table align='center' border='1'>";
	echo "<tr><td class='w3-tiny w3-red'>RECORDS FOUND: $count</td></tr>";
	echo "<tr align='center' class='w3-tiny w3-blue'>
	       <td>COMPANY</td>
		   <td align='center'>DEPT</td>
		   <td>ID NO</td>
		   <td>EMPLOYEE NAME</td>";
	 	  
    if(isset($_REQUEST['c1'])){ echo "<td>ADDRESS</td>"; }
	if(isset($_REQUEST['c2'])){ echo "<td>BIRTHDAY</td><td>AGE</td><td>BIRTH PLACE</td>"; }
	if(isset($_REQUEST['c3'])){ echo "<td>GENDER</td><td>CIVIL STATUS</td><td>RELIGION</td>"; }
	if(isset($_REQUEST['c4'])){ echo "<td>HEIGHT</td><td>WEIGTH</td><td>BLOOD TYPE</td>"; }
	if(isset($_REQUEST['c5'])){ echo "<td>MOBILE NO.</td><td>EMAIL</td>"; }
	if(isset($_REQUEST['c6'])){ echo "<td>EMPLOYMENT STATUS</td><td>JOB TITLE</td><td>TENURE</td><td width='80'>DATE ENTRY</td><td>REG TARGET</td><td>REGULARIZATION</td><td width='80'>DATE EXIT</td>"; }
	if(isset($_REQUEST['c7'])){ echo "<td>SSS</td><td>TIN</td><td>PHILHEALTH</td><td>PAGIBIG</td><td>DRIVERS LIC</td><td>PASSPORT</td><td>ATM ACCOUNT NO</td>"; }
	if(isset($_REQUEST['c8'])){ echo "<td>BASIC PER MONTH</td><td>BASIC PER DAY</td><td>SALARY SCHEDULE</td><td>TIME CLASS</td>"; }
		  
	echo "</tr>";
	do{
		
	  echo "<tr class='w3-hover-pale-red w3-small'>
	          <td align='center'>".$r['e_company']."</td>
			  <td align='center'>".$r['e_department']."</td>
			  <td align='center'>".$r['e_no']."</td>
			  <td>&nbsp;".$r['e_lname'].", ".$r['e_fname']." ".$r['e_mname']."</td>";
	  
	  if(isset($_REQUEST['c1']))
	    {
		 echo "<td>&nbsp;".$r['e_address']."</td>";	
		}
		
	  if(isset($_REQUEST['c2']))
	    {
		 $age_base=$r['e_bday'];
		 $aa="SELECT TIMESTAMPDIFF(YEAR, '$age_base', CURDATE()) AS age";
		 $aq=mysql_query($aa);
		 $ar=mysql_fetch_assoc($aq);	
		 
		 echo "<td>".date('m/d/Y',strtotime($r['e_bday']))."</td><td align='center'>".$ar['age']."</td>
		       <td>&nbsp;".$r['e_bplace']."</td>";
		}
		
	  if(isset($_REQUEST['c3']))
	    {
		 echo "<td>&nbsp;".$r['e_gender']."&nbsp;</td>
		       <td>&nbsp;".$r['e_civil_status']."</td>	
			   <td>&nbsp;".$r['e_religion']."</td>";	
		}
		
	  if(isset($_REQUEST['c4']))
	    {
		 echo "<td>&nbsp;".$r['e_height']."&nbsp;</td>
		       <td>&nbsp;".$r['e_weight']."</td>
			   <td>&nbsp;".$r['e_blood_type']."</td>";			   
		}
		
	  if(isset($_REQUEST['c5']))
	    {
		 echo "<td>&nbsp;".$r['e_mobile']."&nbsp;</td>
		       <td>&nbsp;".$r['e_email']."</td>";			
		}
		
		
	 //employment length
	  if(isset($_REQUEST['c6']))
	    {
		 echo "<td>&nbsp;".$r['e_employment_status']."&nbsp;</td>
		       <td>&nbsp;".$r['e_job_title']."&nbsp;</td>";
			   
		 echo "<td align='right'>";
			  if($r['e_entry_date']=="0000-00-00" OR $r['e_entry_date']=="0001-01-01"){}
			else{
				
				$sdate111 = $r['e_entry_date'];
				
				if($r['e_exit_date']!="0000-00-00" OR $r['e_exit_date']=="0001-01-01")
				{ $edate111 = $r['e_exit_date']; }
				else { $edate111 = date('Y-m-d'); }
					

				$date_diff = abs(strtotime($edate111) - strtotime($sdate111));

				$years = floor($date_diff / (365*60*60*24));
				$months = floor(($date_diff - $years * 365*60*60*24) / (30*60*60*24));
				$days = floor(($date_diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

				printf("%dY %dM %dD", $years, $months, $days);
				printf("\n");
				}
		 echo "</td>";	   
			   
		 echo "<td align='right'>";
			   if($r['e_entry_date']=="0000-00-00" or $r['e_entry_date']=="0001-01-01"){ } 
		       else { echo date('m/d/Y',strtotime($r['e_entry_date'])); }
		 echo "</td>";
		 
		 
		 echo "<td align='right'>";
			if($r['e_employment_status']=="Probationary"){   
			   if($r['e_entry_date']=="0000-00-00" or $r['e_entry_date']=="0001-01-01"){ } 
		       else { echo date('m/d/Y',strtotime($r['e_entry_date'].' + '.(180).' days')); }
			}else{}
		 echo "</td>";
		 
		 echo "<td align='right'>";
			   if($r['e_permanent_status_date']=="0000-00-00" or $r['e_permanent_status_date']=="0001-01-01"){ }
			   else { echo date('m/d/Y',strtotime($r['e_permanent_status_date'])); }
		 echo "</td>";
		 
		 
		 echo "<td align='right'>";
			   if($r['e_exit_date']=="0000-00-00" or $r['e_exit_date']=="0001-01-01"){ }
			   else { echo date('m/d/Y',strtotime($r['e_exit_date'])); }
		 echo "</td>";
		}
		
		
		
	  if(isset($_REQUEST['c7']))
	    {
		 echo "<td>".$r['e_sss']."</td>
		       <td>".$r['e_tin']."</td>
			   <td>".$r['e_philhealth']."</td>
			   <td>".$r['e_pagibig']."</td>
			   <td>".$r['e_drivers_lic']."</td>
			   <td>".$r['e_passport_id']."</td>
			   <td>".$r['e_atm_account']."</td>";
	    }
		
	  if(isset($_REQUEST['c8']))
	    {
		 echo "<td align='right'>".number_format($r['e_basic_pay'],2)."</td>
		       <td align='right'>".number_format($r['e_basic_pay']/26,2)."</td>
			   <td align='center'>".$r['e_salary_sched']."</td>";
			
			$tclass=$r['e_timeclass'];
			$qtx=mysql_query("select timeclass from employee_timeclass where id=$tclass") or die(mysql_error());
			$rtx=mysql_fetch_assoc($qtx); 
		
		 echo "<td align='center'>".$rtx['timeclass']."</td>";	
		}	
		
	  echo "</tr>";
	
	}while($r=mysql_fetch_assoc($q));
    echo "</table>";

}	  
?>
<br>
</body>