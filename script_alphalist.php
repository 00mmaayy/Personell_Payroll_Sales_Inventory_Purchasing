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

<body>
<br/>

<div class='container w3-tiny' align='left'>

<form>
	<table align='center'>
	<tr>
		<td class='w3-tiny'>
		<input class='btn w3-tiny' name='alphalist72' type='submit' value='Alphalist 7.2'>&nbsp;&nbsp;&nbsp;
		7.2 Alphalist of Employees Terminated Before December 31
		</td>
		<td width='20'></td>
		<td class='w3-tiny'>
		<input class='btn w3-tiny' name='alphalist73' type='submit' value='Alphalist 7.3'>&nbsp;&nbsp;&nbsp;
		7.3 Alphalist of Employees With No Previous Employers within the year
		</td>
	</tr>	
	<tr class='w3-tiny'><td>&nbsp;</td></tr>	
	<tr>
		<td class='w3-tiny'>
		<input class='btn w3-tiny' name='alphalist74' type='submit' value='Alphalist 7.4'>&nbsp;&nbsp;&nbsp;
		7.4 Alphalist of Employees with Employers within the year
		</td>
		<td width='20'></td>
		<td class='w3-tiny'>
		<input class='btn w3-tiny' name='alphalist75' type='submit' value='Alphalist 7.5'>&nbsp;&nbsp;&nbsp;
		7.5 Alphalist of Minimun Wage Earners(MWE)
		</td>
	</tr>
	</table>
</form>
	
</div>
<hr/>

<?php
if(isset($_REQUEST['alphalist72']))
{
	$s="select e_no,
			   e_company,
			   e_fname,
			   e_lname, 
			   e_mname, 
			   e_tin,
			   e_entry_date,
			   e_exit_date,
			   e_employment_status 
		from employee 
		where e_employment_status='Resigned' 
		   or e_employment_status='NotConnected'
		order by e_employment_status desc, e_company, e_lname asc";
	$q=mysql_query($s) or die(mysql_error());
	$r=mysql_fetch_assoc($q);

	echo "<table align='center' class='w3-small' border='1'>
			<tr><td colspan='9' align='center'><i>Alphalist 7.2 | Alphalist of Employees Terminated Before December 31</i></td></tr>
			<tr align='center' class='w3-green'>
				<td width='100'>ID</td>
				<td width='100'>COMPANY</td>
				<td>LAST NAME</td>
				<td>FIRST NAME</td>
				<td>MIDDLE NAME</td>
				<td width='100'>TIN</td>
				<td width='100'>STATUS</td>
				<td width='150'>DATE ENTRY</td>
				<td width='150'>DATE EXIT</td>
			</tr>";
	do{
		echo "<tr class='w3-hover-pale-red'>
				<td align='center'>".$r['e_no']."</td>
				<td align='center'>".$r['e_company']."</td>
				<td>&nbsp;".$r['e_lname']."</td>
				<td>&nbsp;".$r['e_fname']."</td>
				<td>&nbsp;".$r['e_mname']."</td>
				<td align='center'>".$r['e_tin']."</td>
				<td align='center'>".$r['e_employment_status']."</td>
				<td align='right'>";
					if($r['e_entry_date']!="0000-00-00" and $r['e_entry_date']!="0001-01-01"){ echo date('F d, Y',strtotime($r['e_entry_date'])); }
		   echo "</td>
				<td align='right'>";
					if($r['e_exit_date']!="0000-00-00"){ echo date('F d, Y',strtotime($r['e_exit_date'])); }
		   echo "</td>";
		echo "</tr>";
	}while($r=mysql_fetch_assoc($q));
	echo "</table>";	
			
}

if(isset($_REQUEST['alphalist73']))
{
	$s="select b.e_no as e_no,
			   b.e_company as e_company,
			   b.e_fname as e_fname,
			   b.e_lname as e_lname, 
			   b.e_mname as e_mname, 
			   b.e_tin as e_tin,
			   b.e_entry_date as e_entry_date,
			   b.e_exit_date as e_exit_date,
			   b.e_employment_status as e_employment_status 
		from employee as b 
		join employee_work_history as a
		on b.e_no=a.e_no
		where b.e_employment_status!='Resigned' 
		   and b.e_employment_status!='NotConnected'
		   and b.e_entry_date>='2018-01-01'
		   and a.e_w_status='None'
		group by b.e_no
		order by b.e_employment_status desc, b.e_company, b.e_lname asc";
	$q=mysql_query($s) or die(mysql_error());
	$r=mysql_fetch_assoc($q);

	echo "<table align='center' class='w3-small' border='1'>
			<tr><td colspan='9' align='center'><i>Alphalist 7.3 | Alphalist of Employees With No Previous Employers within the year</i></td></tr>
			<tr align='center' class='w3-green'>
				<td width='100'>ID</td>
				<td width='100'>COMPANY</td>
				<td>LAST NAME</td>
				<td>FIRST NAME</td>
				<td>MIDDLE NAME</td>
				<td width='100'>TIN</td>
				<td width='100'>STATUS</td>
				<td width='150'>DATE ENTRY</td>
				<td width='150'>DATE EXIT</td>
			</tr>";
	do{
		echo "<tr class='w3-hover-pale-red'>
				<td align='center'>".$r['e_no']."</td>
				<td align='center'>".$r['e_company']."</td>
				<td>&nbsp;".$r['e_lname']."</td>
				<td>&nbsp;".$r['e_fname']."</td>
				<td>&nbsp;".$r['e_mname']."</td>
				<td align='center'>".$r['e_tin']."</td>
				<td align='center'>".$r['e_employment_status']."</td>
				<td align='right'>";
					if($r['e_entry_date']!="0000-00-00" and $r['e_entry_date']!="0001-01-01"){ echo date('F d, Y',strtotime($r['e_entry_date'])); }
		   echo "</td>
				<td align='right'>";
					if($r['e_exit_date']!="0000-00-00"){ echo date('F d, Y',strtotime($r['e_exit_date'])); }
		   echo "</td>";
		echo "</tr>";
	}while($r=mysql_fetch_assoc($q));
	echo "</table>";	
			
}

if(isset($_REQUEST['alphalist74']))
{
		$s="select b.e_no as e_no,
			   b.e_company as e_company,
			   b.e_fname as e_fname,
			   b.e_lname as e_lname, 
			   b.e_mname as e_mname, 
			   b.e_tin as e_tin,
			   b.e_entry_date as e_entry_date,
			   b.e_exit_date as e_exit_date,
			   b.e_employment_status as e_employment_status 
		from employee as b 
		join employee_work_history as a
		on b.e_no=a.e_no
		where b.e_employment_status!='Resigned' 
		   and b.e_employment_status!='NotConnected'
		   and b.e_entry_date>='2018-01-01'
		   and a.e_w_status!='None'
		group by b.e_no
		order by b.e_employment_status desc, b.e_company, b.e_lname asc";
	$q=mysql_query($s) or die(mysql_error());
	$r=mysql_fetch_assoc($q);

	echo "<table align='center' class='w3-small' border='1'>
			<tr><td colspan='9' align='center'><i>Alphalist 7.4 | Alphalist of Employees with Employers within the year</i></td></tr>
			<tr align='center' class='w3-green'>
				<td width='100'>ID</td>
				<td width='100'>COMPANY</td>
				<td>LAST NAME</td>
				<td>FIRST NAME</td>
				<td>MIDDLE NAME</td>
				<td width='100'>TIN</td>
				<td width='100'>STATUS</td>
				<td width='150'>DATE ENTRY</td>
				<td width='150'>DATE EXIT</td>
			</tr>";
	do{
		echo "<tr class='w3-hover-pale-red'>
				<td align='center'>".$r['e_no']."</td>
				<td align='center'>".$r['e_company']."</td>
				<td>&nbsp;".$r['e_lname']."</td>
				<td>&nbsp;".$r['e_fname']."</td>
				<td>&nbsp;".$r['e_mname']."</td>
				<td align='center'>".$r['e_tin']."</td>
				<td align='center'>".$r['e_employment_status']."</td>
				<td align='right'>";
					if($r['e_entry_date']!="0000-00-00" and $r['e_entry_date']!="0001-01-01"){ echo date('F d, Y',strtotime($r['e_entry_date'])); }
		   echo "</td>
				<td align='right'>";
					if($r['e_exit_date']!="0000-00-00"){ echo date('F d, Y',strtotime($r['e_exit_date'])); }
		   echo "</td>";
		echo "</tr>";
	}while($r=mysql_fetch_assoc($q));
	echo "</table>";	
}

if(isset($_REQUEST['alphalist75']))
{
	$s="select b.e_no as e_no,
			   b.e_company as e_company,
			   b.e_fname as e_fname,
			   b.e_lname as e_lname, 
			   b.e_mname as e_mname, 
			   b.e_tin as e_tin,
			   b.e_entry_date as e_entry_date,
			   b.e_exit_date as e_exit_date,
			   b.e_employment_status as e_employment_status 
		from employee as b 
		where b.e_employment_status!='Resigned' 
		   and b.e_employment_status!='NotConnected'
		   and b.e_entry_date>='2018-01-01'
		   and b.e_basic_pay='8320'
		group by b.e_no
		order by b.e_company asc, b.e_lname asc";
	$q=mysql_query($s) or die(mysql_error());
	$r=mysql_fetch_assoc($q);

	echo "<table align='center' class='w3-small' border='1'>
			<tr><td colspan='9' align='center'><i>Alphalist 7.5 | Alphalist of Minimun Wage Earners(MWE)</i></td></tr>
			<tr align='center' class='w3-green'>
				<td width='100'>ID</td>
				<td width='100'>COMPANY</td>
				<td>LAST NAME</td>
				<td>FIRST NAME</td>
				<td>MIDDLE NAME</td>
				<td width='100'>TIN</td>
				<td width='100'>STATUS</td>
				<td width='150'>DATE ENTRY</td>
				<td width='150'>DATE EXIT</td>
			</tr>";
	do{
		echo "<tr class='w3-hover-pale-red'>
				<td align='center'>".$r['e_no']."</td>
				<td align='center'>".$r['e_company']."</td>
				<td>&nbsp;".$r['e_lname']."</td>
				<td>&nbsp;".$r['e_fname']."</td>
				<td>&nbsp;".$r['e_mname']."</td>
				<td align='center'>".$r['e_tin']."</td>
				<td align='center'>".$r['e_employment_status']."</td>
				<td align='right'>";
					if($r['e_entry_date']!="0000-00-00" and $r['e_entry_date']!="0001-01-01"){ echo date('F d, Y',strtotime($r['e_entry_date'])); }
		   echo "</td>
				<td align='right'>";
					if($r['e_exit_date']!="0000-00-00"){ echo date('F d, Y',strtotime($r['e_exit_date'])); }
		   echo "</td>";
		echo "</tr>";
	}while($r=mysql_fetch_assoc($q));
	echo "</table>";	
}
			
		
	
	
?>


<br>
</body>