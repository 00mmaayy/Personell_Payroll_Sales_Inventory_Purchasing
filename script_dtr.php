<?php 
session_start();
include('connection/conn.php');
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); } 
date_default_timezone_set("Asia/Manila");

//$secondsWait = 15;
//header("Refresh:$secondsWait");

if(isset($_REQUEST['update_dtr_print']))
{	
$start=$_REQUEST['start'];
$end=$_REQUEST['end'];
mysql_query("update dtr_date_print set start='$start', end='$end'") or die(mysql_error());

	if(isset($_REQUEST['realan'])){ header('Location: script_dtr.php?realan=1'); }
	if(isset($_REQUEST['zkteco'])){ header('Location: script_dtr.php?zkteco=1'); }
}

?>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/w3.css">
<link rel="stylesheet" href="css/font-awesome.min.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>

<div class='container'>




<?php
//ZKTECO--------------------------------------------------------
if(isset($_REQUEST['zkteco']))
{ echo "<span class='w3-text-deep-orange w3-large'>BIOMETRIC RECORD</span>";
 if(isset($_REQUEST['execute_zkteco']))
 {		
    /* Script After dtr insertion: START */
		$s1="select * from INOUTDATA";
		$q1=mysql_query($s1) or die(mysql_error());	
		$r1=mysql_fetch_assoc($q1);
		
		do{	
		$id=$r1['id'];
		$name=$r1['Name'];
		//$checktime=$r1['CHECKTIME'];

			/* Uncomment this script to convert varchar time to datetime format */
			//mysql_query("update INOUTDATA set DATE=str_to_date('$checktime','%m/%d/%Y'), TIME=str_to_date('$checktime','%m/%d/%Y %l:%i %p') where id='$id'") or die(mysql_error());
		
			/* Data insert for Last Name */
			$s2="SELECT SUBSTRING_INDEX('$name',',',1) AS e_name";
			$q2=mysql_query($s2);
			$r2=mysql_fetch_assoc($q2);
			$lname=$r2['e_name'];
			mysql_query("update INOUTDATA set e_lname='$lname' where id='$id'") or die(mysql_error());

			/* Data Insert for First Name */
			$s3="SELECT SUBSTRING_INDEX('$name',', ',-1) AS e_name";
			$q3=mysql_query($s3);
			$r3=mysql_fetch_assoc($q3);
			$fname=$r3['e_name'];
			mysql_query("update INOUTDATA set e_fname='$fname' where id='$id'") or die(mysql_error());
	
		}while($r1=mysql_fetch_assoc($q1));
    /* Script After dtr insertion: END */

	
	/* Script for removing Middle initial */
		$s4="select * from INOUTDATA";
		$q4=mysql_query($s4) or die(mysql_error());	
		$r4=mysql_fetch_assoc($q4);
		do{	
		
		/* replace '?' text to 'ñ' text */
		mysql_query("UPDATE `INOUTDATA` SET Name=replace(Name,'?','ñ'), e_lname=replace(e_lname,'?','ñ') WHERE Name like '%?%' or e_lname like '%?%'");

		$id=$r4['id'];
		$name=$r4['e_fname'];

		$s5="SELECT SUBSTRING_INDEX('$name',' ',1) AS e_name";
		$q5=mysql_query($s5);
		$r5=mysql_fetch_assoc($q5);
		$fname=$r5['e_name'];
		mysql_query("update INOUTDATA set e_fname='$fname' where id='$id'") or die(mysql_error());
		}while($r4=mysql_fetch_assoc($q4));
	
	/* Name Purge*/
	mysql_query("update INOUTDATA set Name='Ulson, Justine' ,e_lname='Ulson', e_fname='Justine' where Name='1044'") or die(mysql_error());
	mysql_query("update INOUTDATA set Name='Daygo - Bernabe, Fanny' ,e_lname='Bernabe', e_fname='Fanny' where Name='Bernabe, Fanny Mae D.'") or die(mysql_error());

	header("Location: script_dtr.php?zkteco=1");	
}        else if (isset($_REQUEST['add_time'])) {
	header("Location: ../alc-companion-module/time-feature.php");
}
?>
	<br>
	
		<div align='center'>
		<table><tr>
			
			<td>
			<form method='get'>
				<input type='hidden' name='zkteco' value='1'>
				<input class='btn w3-red w3-tiny' name='execute_zkteco' type='submit' value='EXECUTE DTR TRANSFER' onclick='return confirm("Execution may take up to 6 minutes. Continue?")'>
			</form>
			</td>
			<td width='20'></td>
			<td>
			<form method='get' target="_blank">
				<input type='hidden' name='zkteco' value='1'>
				<input class='btn w3-green w3-tiny' name='add_time' type='submit' value='ADD TIME'>
			</form>
			</td>
			<td width='20'></td>
			<td>
			<form method='get' action='script_dtr_printing.php' target='_blank'>
			    <input type='hidden' name='zkteco' value='1'>
				<input class='btn w3-blue w3-tiny' name='print_zkteco' type='submit' value='PRINT DTR' onclick='return confirm("Print. Continue?")'>
			</form>
			</td>
			<td width='20'></td>
			<td class='w3-tiny'>
			<form>
			<?php 
				  $x1=mysql_query("select * from dtr_date_print") or die(mysql_error()); 
				  $z1=mysql_fetch_assoc($x1); 
				  echo "START:&nbsp;&nbsp;<input required class='btn w3-light-gray w3-tiny' name='start' type='date' value='".$z1['start']."'>&nbsp;&nbsp;&nbsp;&nbsp;";
				  echo "END:&nbsp;&nbsp;&nbsp;&nbsp;<input required class='btn w3-light-gray w3-tiny' name='end' type='date' value='".$z1['end']."'>";
			?>
			<input name='zkteco' type='hidden' value='1'>
			<input class='btn w3-tiny w3-blue' name='update_dtr_print' type='submit' value='UPDATE DTR PRINT DATE' onclick='return confirm("Update Now?")'>
			</form>
			</td>
			
		</tr></table>	
		</div>
	
	<hr>

	<?php
	/* Show list of employees */
	
	 $s="select e_lname,
				e_fname 
		 from INOUTDATA 
		 group by e_lname, e_fname
		 order by e_company,e_department,e_lname asc";
		 
	$q=mysql_query($s) or die(mysql_error());
	$r=mysql_fetch_assoc($q);
	
	echo "<table align='center'>
			<tr class='w3-blue w3-large' align='center'>
				<td width='150'>ID NO</td>
				<td width='80'>COMPANY</td>
				<td width='200'>DEPT</td>
				<td width='250'>NAME</td>
				<td width='150'>TIME CLASS</td>
				<td width='150'>SUBMITTED</td>
			</tr>";
	do{	
	$e_lname=$r['e_lname'];	
	$e_fname=$r['e_fname'];	
	
	$xs="select e_no,
				e_lname,
				e_fname,
				e_timeclass,
				e_department,
				e_company
		 from employee
		 where e_lname='$e_lname' 
		 and e_fname like '%$e_fname%' and e_department!='RAPID CARE'";
		 
	$xq=mysql_query($xs);
	$xr=mysql_fetch_assoc($xq);
	
	//ADD COMPANY AND DEPT START-------
	
	//if($r['e_company']==""){
		//$e_company=$xr['e_company'];
		//$e_department=$xr['e_department'];
		//mysql_query("UPDATE INOUTDATA SET e_company='$e_company', e_department='$e_department' WHERE e_lname='$e_lname' and e_fname like '%$e_fname%'") or die(mysql_error());
	//}else{}
	//ADD COMPANY AND DEPT END-------
	
	echo "<tr class='w3-hover-pale-red'>
			<td width='100'>".$xr['e_no']."</td>
			<td width='50'>".$xr['e_company']."</td>
			<td width='100'>".$xr['e_department']."</td>
			<td><a href='script_dtr_per_employee.php?zkteco=1&time_class=".$xr['e_timeclass']."&e_no=".$xr['e_no']."&e_lname=".$r['e_lname']."&e_fname=".$r['e_fname']."' target='_blank'>".$xr['e_lname'].", ".$xr['e_fname']."</a></td>
			<td width='100' align='center'>";
			if($xr['e_timeclass']!=0)
			  { 
		         $time=$xr['e_timeclass']; 
				 $qtime=mysql_query("select timeclass from employee_timeclass where id=$time"); 
				 $rtime=mysql_fetch_assoc($qtime);
				 echo $rtime['timeclass'];
		      }else{}
	  echo "</td>";

	  
	  
	  echo "<td align='center'>";
			
			$e_no11=$xr['e_no'];
			$xs1="select e_no, UPDATED from INOUTDATALATES where e_no='$e_no11'";
			$xq1=mysql_query($xs1);
			$xr1=mysql_fetch_assoc($xq1);
			
			if($xr1['UPDATED']==1){ echo "<span class='w3-text-green'>YES</span>"; } else { echo "<span class='w3-text-red'>".$xr1['UPDATED']."</span>"; }

	  echo "</td>";

	  
	 
	 echo "</tr>";
	}while($r=mysql_fetch_assoc($q));
	echo "</table>";
	
	/* Show list of employees */
	
}
//ZKTECO--------------------------------------------------------





//REALAND--------------------------------------------------------
if(isset($_REQUEST['realan']))
{  echo "<span class='w3-text-deep-orange w3-large'>REALAND BIOMETRIC</span>";
		if(isset($_REQUEST['execute_realan']))
		 {		
			/* Script After dtr insertion: START */
				$s1="select * from BIOMETRIC";
				$q1=mysql_query($s1) or die(mysql_error());	
				$r1=mysql_fetch_assoc($q1);
				
				do{	
				$id=$r1['id'];
				$name=$r1['Name'];
				//$checktime=$r1['RAWDATE'];

					/* Uncomment this script to convert varchar time to datetime format */
					//mysql_query("update BIOMETRIC set DATE=str_to_date('$checktime','%m/%d/%Y') where id='$id'") or die(mysql_error());
				
					/* Data insert for Last Name */
					$s2="SELECT SUBSTRING_INDEX('$name',',',1) AS e_name";
					$q2=mysql_query($s2) or die(mysql_error());
					$r2=mysql_fetch_assoc($q2);
					$lname=$r2['e_name'];
					mysql_query("update BIOMETRIC set e_lname='$lname' where id='$id'") or die(mysql_error());

					/* Data Insert for First Name */
					$s3="SELECT SUBSTRING_INDEX('$name',', ',-1) AS e_name";
					$q3=mysql_query($s3) or die(mysql_error());
					$r3=mysql_fetch_assoc($q3);
					$fname=$r3['e_name'];
					mysql_query("update BIOMETRIC set e_fname='$fname' where id='$id'") or die(mysql_error());
			
				}while($r1=mysql_fetch_assoc($q1));
			/* Script After dtr insertion: END */

			
			/* Script for removing Middle initial */
				$s4="select * from BIOMETRIC";
				$q4=mysql_query($s4) or die(mysql_error());	
				$r4=mysql_fetch_assoc($q4);
				do{	
				
				$id=$r4['id'];
				$name=$r4['e_fname'];

				$s5="SELECT SUBSTRING_INDEX('$name',' ',1) AS e_name";
				$q5=mysql_query($s5) or die(mysql_error());
				$r5=mysql_fetch_assoc($q5);
				$fname=$r5['e_name'];
				mysql_query("update BIOMETRIC set e_fname='$fname' where id='$id'") or die(mysql_error());
				
				}while($r4=mysql_fetch_assoc($q4));
			
			/* Name Purge*/
			mysql_query("update BIOMETRIC set e_lname='Sausa', e_fname='Edison' where Name='Edison Sausa'") or die(mysql_error());
			mysql_query("update BIOMETRIC set e_lname='Ramboyong', e_fname='Sergio' where Name='Rambuyong, Sergio'") or die(mysql_error());
			mysql_query("update BIOMETRIC set e_lname='Magbanua', e_fname='Ricardo' where Name='Ricardo Magbanua'") or die(mysql_error());
			mysql_query("update BIOMETRIC set e_lname='Iligan - Suba', e_fname='Lovely' where Name='Iligan, Lovely G.'") or die(mysql_error());
			mysql_query("update BIOMETRIC set e_lname='Daygo - Bernabe', e_fname='Fanny' where Name='Bernabe, Fanny Mae D.'") or die(mysql_error());
			
			header("Location: script_dtr.php?realan=1");	
		 }
?>
	<br>
	
		<div align='center'>
		<table><tr>
			
			<td>
			<form method='get'>
				<input type='hidden' name='realan' value='1'>
				<input class='btn w3-red w3-tiny' name='execute_realan' type='submit' value='EXECUTE DTR TRANSFER' onclick='return confirm("Execution may take up to 6 minutes. Continue?")'>
			</form>
			</td>
			<td width='20'></td>
			<td>
			<form method='get' action='script_dtr_printing.php' target='_blank'>
				<input type='hidden' name='realan' value='1'>
				<input class='btn w3-blue w3-tiny' name='print_realan' type='submit' value='PRINT DTR' onclick='return confirm("Print. Continue?")'>
			</form>
			<td width='20'></td>
			<td class='w3-tiny'>
			<form>
			<?php 
				  $x1=mysql_query("select * from dtr_date_print") or die(mysql_error()); 
				  $z1=mysql_fetch_assoc($x1); 
				  echo "START:&nbsp;&nbsp;<input required class='btn w3-light-gray w3-tiny' name='start' type='date' value='".$z1['start']."'>&nbsp;&nbsp;&nbsp;&nbsp;";
				  echo "END:&nbsp;&nbsp;&nbsp;&nbsp;<input required class='btn w3-light-gray w3-tiny' name='end' type='date' value='".$z1['end']."'>";
			?>
			<input name='realan' type='hidden' value='1'>
			<input class='btn w3-tiny w3-blue' name='update_dtr_print' type='submit' value='UPDATE DTR PRINT DATE' onclick='return confirm("Update Now?")'>
			</form>
			</td>
			
		</tr></table>	
		</div>
	
	<hr>
<?php 

/* Show list of employees */
	
	 $s="select e_lname,
				e_fname 
		 from BIOMETRIC 
		 group by e_lname, e_fname 
		 order by e_company,e_department,e_lname asc";
		 
	$q=mysql_query($s) or die(mysql_error());
	$r=mysql_fetch_assoc($q);
	
	
	echo "<table align='center'>
			<tr class='w3-blue w3-large' align='center'>
				<td width='150'>ID NO</td>
				<td width='80'>COMPANY</td>
				<td width='200'>DEPT</td>
				<td width='250'>NAME</td>
				<td width='150'>TIME CLASS</td>
				<td width='150'>SUBMITTED</td>
			</tr>";
	do{	
	$e_lname=$r['e_lname'];	
	$e_fname=$r['e_fname'];	
	
	$xs="select e_no,
				e_lname,
				e_fname,
				e_timeclass,
				e_company,
				e_department
		 from employee
		 where e_lname='$e_lname' and e_fname like '%$e_fname%' and e_department!='RAPID CARE'";
		 
	$xq=mysql_query($xs);
	$xr=mysql_fetch_assoc($xq);
	
	//ADD COMPANY AND DEPT START-------
	if($r['e_company']==""){
		$e_company=$xr['e_company'];
		$e_department=$xr['e_department'];
		mysql_query("UPDATE BIOMETRIC SET e_company='$e_company', e_department='$e_department' WHERE e_lname='$e_lname' and e_fname like '%$e_fname%'") or die(mysql_error());
	}else{}
	//ADD COMPANY AND DEPT END-------
	
	
	echo "<tr class='w3-hover-pale-red'>
			<td width='50'>".$xr['e_no']."</td>
			<td width='50'>".$xr['e_company']."</td>
			<td width='100'>".$xr['e_department']."</td>
			<td><a href='script_dtr_per_employee.php?realan=1&time_class=".$xr['e_timeclass']."&e_no=".$xr['e_no']."&e_lname=".$r['e_lname']."&e_fname=".$r['e_fname']."' target='_blank'>".$xr['e_lname'].", ".$xr['e_fname']."</a></td>
			<td width='100' align='center'>";
			if($xr['e_timeclass']!=0)
			  { 
		         $time=$xr['e_timeclass']; 
				 $qtime=mysql_query("select timeclass from employee_timeclass where id=$time"); 
				 $rtime=mysql_fetch_assoc($qtime);
				 echo $rtime['timeclass'];
		      }else{}
	  echo "</td>";

	  
	  
	  echo "<td align='center'>";
			
			$e_no11=$xr['e_no'];
			$xs1="select e_no, UPDATED from BIOMETRICLATES where e_no='$e_no11'";
			$xq1=mysql_query($xs1);
			$xr1=mysql_fetch_assoc($xq1);
			
			if($xr1['UPDATED']==1){ echo "<span class='w3-text-green'>YES</span>"; } else { echo "<span class='w3-text-red'>".$xr1['UPDATED']."</span>"; }

	  echo "</td>";

	  
	 
	 echo "</tr>";
	}while($r=mysql_fetch_assoc($q));
	echo "</table>";
	
	/* Show list of employees */ 

echo "<br/><b class='w3-text-red'>WARNING!<br/>DOUBLE BIOMETRIC ENTRY!<br/>PLEASE MERGE BIOMETRIC DATA ON NAMES LISTED.</b><br/>";

	$m1=mysql_query("select e_lname from BIOMETRIC GROUP BY e_lname") or die(mysql_error());
	$m2=mysql_fetch_assoc($m1);
	do{
		
		$e_lname=$m2['e_lname'];
		$x=mysql_query("select count(RAWDATE) AS rdate from BIOMETRIC where e_lname='$e_lname' GROUP BY RAWDATE ORDER BY rdate DESC LIMIT 1") or die(mysql_error());
		$y=mysql_fetch_assoc($x);
		do
		{
			if($y['rdate']>1)
			{	
				echo "<b class='w3-text-blue'>".$m2['e_lname']."</b>&nbsp;&nbsp;";
				echo "SELECT * FROM `BIOMETRIC` WHERE e_lname='".$m2['e_lname']."' ORDER BY e_lname,e_fname,`DATE` ASC";
				echo "<br/>";
			}
			else{}
			
		}while($y=mysql_fetch_assoc($x));
		
	}while($m2=mysql_fetch_assoc($m1));
	
}
//REALAN--------------------------------------------------------
?>

<hr>
</div>