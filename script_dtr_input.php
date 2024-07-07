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
<br>

<?php
    // Start date
	//$date = '2018-02-26';
	// End date
	//$end_date = '2018-03-10';

	//while (strtotime($date) <= strtotime($end_date)) 
	//{
     //echo "$date\n <br>";
     //$date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
	//}
?>

<?php
if(isset($_REQUEST['manual']))
{
$eno=$_REQUEST['eno'];	
$date=$_REQUEST['date'];
$amin=$_REQUEST['amin'];
$amout=$_REQUEST['amout'];
$pmin=$_REQUEST['pmin'];
$pmout=$_REQUEST['pmout'];
$otin=$_REQUEST['otin'];
$otout=$_REQUEST['otout'];

$s="select e_company,e_department,e_fname,e_mname,e_lname from employee where e_no='$eno' ";
$q=mysql_query($s) or die(mysql_error());
$r=mysql_fetch_assoc($q);

$comp=$r['e_company'];
$dept=$r['e_department'];
$name=$r['e_lname'].", ".$r['e_fname'];

$sa="insert into dtr_log (data_id,company,e_no,dept,name,date,amin,amout,pmin,pmout,otin,otout) 
     values ('','$comp','$eno','$dept','$name','$date','$amin','$amout','$pmin','$pmout','$otin','$otout')";
mysql_query($sa) or die(mysql_error());

$username=$_SESSION['username'];
$trans="insert dtr dated $date to $name";
$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
$log_query=mysql_query($log_sql) or die(mysql_error());

header('Location: script_dtr_input.php?sdate='.$_REQUEST['sdate'].'&edate='.$_REQUEST['edate'].'&date='.$_REQUEST['date']);
}
?>

<?php
if(isset($_REQUEST['7am']))
{
$eno=$_REQUEST['eno'];	
$date=$_REQUEST['date'];
$amin="07:00";
$amout="12:00";
$pmin="13:00";
$pmout="16:00";
$otin="00:00";
$otout="00:00";

$s="select e_company,e_department,e_fname,e_mname,e_lname from employee where e_no='$eno' ";
$q=mysql_query($s) or die(mysql_error());
$r=mysql_fetch_assoc($q);

$comp=$r['e_company'];
$dept=$r['e_department'];
$name=$r['e_lname'].", ".$r['e_fname'];

$sa="insert into dtr_log (data_id,company,e_no,dept,name,date,amin,amout,pmin,pmout,otin,otout) 
     values ('','$comp','$eno','$dept','$name','$date','$amin','$amout','$pmin','$pmout','$otin','$otout')";
mysql_query($sa) or die(mysql_error());

$username=$_SESSION['username'];
$trans="insert dtr dated $date to $name";
$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
$log_query=mysql_query($log_sql) or die(mysql_error());

header('Location: script_dtr_input.php?sdate='.$_REQUEST['sdate'].'&edate='.$_REQUEST['edate'].'&date='.$_REQUEST['date']);
}
?>

<?php
if(isset($_REQUEST['8am']))
{
$eno=$_REQUEST['eno'];	
$date=$_REQUEST['date'];
$amin="08:00";
$amout="12:00";
$pmin="13:00";
$pmout="17:00";
$otin="00:00";
$otout="00:00";

$s="select e_company,e_department,e_fname,e_mname,e_lname from employee where e_no='$eno' ";
$q=mysql_query($s) or die(mysql_error());
$r=mysql_fetch_assoc($q);

$comp=$r['e_company'];
$dept=$r['e_department'];
$name=$r['e_lname'].", ".$r['e_fname'];

$sa="insert into dtr_log (data_id,company,e_no,dept,name,date,amin,amout,pmin,pmout,otin,otout) 
     values ('','$comp','$eno','$dept','$name','$date','$amin','$amout','$pmin','$pmout','$otin','$otout')";
mysql_query($sa) or die(mysql_error());

$username=$_SESSION['username'];
$trans="insert dtr dated $date to $name";
$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
$log_query=mysql_query($log_sql) or die(mysql_error());

header('Location: script_dtr_input.php?sdate='.$_REQUEST['sdate'].'&edate='.$_REQUEST['edate'].'&date='.$_REQUEST['date']);	
}
?>

<?php
if(isset($_REQUEST['830am']))
{
$eno=$_REQUEST['eno'];	
$date=$_REQUEST['date'];
$amin="08:30";
$amout="12:00";
$pmin="13:00";
$pmout="17:30";
$otin="00:00";
$otout="00:00";

$s="select e_company,e_department,e_fname,e_mname,e_lname from employee where e_no='$eno' ";
$q=mysql_query($s) or die(mysql_error());
$r=mysql_fetch_assoc($q);

$comp=$r['e_company'];
$dept=$r['e_department'];
$name=$r['e_lname'].", ".$r['e_fname'];

$sa="insert into dtr_log (data_id,company,e_no,dept,name,date,amin,amout,pmin,pmout,otin,otout) 
     values ('','$comp','$eno','$dept','$name','$date','$amin','$amout','$pmin','$pmout','$otin','$otout')";
mysql_query($sa) or die(mysql_error());

$username=$_SESSION['username'];
$trans="insert dtr dated $date to $name";
$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
$log_query=mysql_query($log_sql) or die(mysql_error());

header('Location: script_dtr_input.php?sdate='.$_REQUEST['sdate'].'&edate='.$_REQUEST['edate'].'&date='.$_REQUEST['date']);	
}
?>

<?php
if(isset($_REQUEST['9am']))
{
$eno=$_REQUEST['eno'];	
$date=$_REQUEST['date'];
$amin="09:00";
$amout="12:00";
$pmin="13:00";
$pmout="18:00";
$otin="00:00";
$otout="00:00";

$s="select e_company,e_department,e_fname,e_mname,e_lname from employee where e_no='$eno' ";
$q=mysql_query($s) or die(mysql_error());
$r=mysql_fetch_assoc($q);

$comp=$r['e_company'];
$dept=$r['e_department'];
$name=$r['e_lname'].", ".$r['e_fname'];

$sa="insert into dtr_log (data_id,company,e_no,dept,name,date,amin,amout,pmin,pmout,otin,otout) 
     values ('','$comp','$eno','$dept','$name','$date','$amin','$amout','$pmin','$pmout','$otin','$otout')";
mysql_query($sa) or die(mysql_error());

$username=$_SESSION['username'];
$trans="insert dtr dated $date to $name";
$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
$log_query=mysql_query($log_sql) or die(mysql_error());

header('Location: script_dtr_input.php?sdate='.$_REQUEST['sdate'].'&edate='.$_REQUEST['edate'].'&date='.$_REQUEST['date']);	
}
?>


<form align='center' class='w3-small'>
    <input name='sdate' type='hidden' value='<?php echo $_REQUEST['sdate']; ?>'>
	<input name='edate' type='hidden' value='<?php echo $_REQUEST['edate']; ?>'>
	<input name='date' type='date'>&nbsp;
	<input type='submit' value='DTR INPUT DATE'>
</form>

<form method='get'>
    <input name='sdate' type='hidden' value='<?php echo $_REQUEST['sdate']; ?>'>
	<input name='edate' type='hidden' value='<?php echo $_REQUEST['edate']; ?>'>
	<input name='date' type='hidden' value='<?php echo $_REQUEST['date']; ?>'>
	
	<table align='center'>
	<tr align='center' class='w3-small'><td>NAME</td><td>DATE</td><td>AM IN</td><td>AM OUT</td><td>PM IN</td><td>PM OUT</td><td>OT IN</td><td>OT OUT</td></tr>
	<tr align='center' class='w3-small'>
	 <td>  
	  <select class='form-control' required name='eno'>  
		<option></option>
		<?php 
		$sxx=mysql_query("select * from employee order by e_lname asc") or die(mysql_error());
		$rxx=mysql_fetch_assoc($sxx);
		do{ echo "<option value='".$rxx['e_no']."'>".$rxx['e_lname'].", ".$rxx['e_fname']."</option>"; } while($rxx=mysql_fetch_assoc($sxx));
		?>
	  </select>
	 <td width='110'>
	 <?php if(isset($_REQUEST['date'])){ $date=$_REQUEST['date']; echo "<span class='w3-text-red w3-large'><b>".date('m-d-Y',strtotime($date))."</b></span>"; } ?>
	 </td>
	 <td width='110'>
		<input name='amin' type='time' value='00:00'>
	 </td>
	 <td width='110'>
		<input name='amout' type='time' value='00:00'>
	 </td>
	 <td width='110'>
		<input name='pmin' type='time' value='00:00'>
	 </td>
	 <td width='110'>
		<input name='pmout' type='time' value='00:00'>
	 </td>
	 <td width='110'>
		<input name='otin' type='time' value='00:00'>
	 </td>
	 <td width='110'>
		<input name='otout' type='time' value='00:00'>
	 </td>
	 <td width='110'>
	   <input name='manual' type='submit' value='MANUAL INPUT' onclick='return confirm("Insert Now?")'>
	 </td>
	 </tr>
	 
	 <tr valign='bottom' class='w3-small' align='center'>
	 <td colspan='2'></td>
	 <td>
	   <br><input name='7am' type='submit' value='7 AM PRESET' onclick='return confirm("Insert Now?")'>
	 </td>
	 <td>
	   <input name='8am' type='submit' value='8 AM PRESET' onclick='return confirm("Insert Now?")'>
	 </td>
	 <td>
	   <input name='830am' type='submit' value='8:30 AM PRESET' onclick='return confirm("Insert Now?")'>
	 </td>
	 <td>
	   <input name='9am' type='submit' value='9 AM PRESET' onclick='return confirm("Insert Now?")'>
	 </td>
	</tr>	  
	</table>
</form>

<hr>
    <div class='w3-tiny' align='center'>NOTE: Set DTR DATE VIEW 1st, then Set DTR INPUT DATE.</div>
	<div align='center' class='w3-small w3-text-red'><b>DTR DATE VIEW<br>
	<?php echo date('m/d/Y',strtotime($_REQUEST['sdate']))." - ".date('m/d/Y',strtotime($_REQUEST['edate'])); ?></b><br><br></div>
    <form align='center' class='w3-small'>
	START DATE&nbsp;<input name='sdate' type='date'>&nbsp;&nbsp;&nbsp;
	END DATE&nbsp;<input name='edate' type='date'>
	<input 	type='submit' value='SET DATE'>
    </form>
	
    <?php
	if(isset($_REQUEST['sdate']))
	{
	$sdate=$_REQUEST['sdate'];
	$edate=$_REQUEST['edate'];
    $ss="select * from dtr_log where date>='$sdate' and date<='$edate' order by  date desc, dept asc, e_no asc";	
	$qq=mysql_query($ss) or die(mysql_error());
	$rr=mysql_fetch_assoc($qq);
	$count=mysql_num_rows($qq);
	
	echo "<table border='1' align='center'>
			<tr class='w3-red w3-small'><td colspan='3'>Records Found: <b>$count</b></td></tr>
			<tr class='w3-blue w3-small' align='center'>
			  <td>&nbsp;<b>DID</b>&nbsp;</td>
			  <td><b>COMP</b></td>
			  <td><b>DEPT</b></td>
			  <td><b>ID</b></td>
			  <td><b>NAME</b></td>
			  <td><b>DATE</b></td>
			  <td><b>AMIN</b></td>
			  <td><b>AMOUT</b></td>
			  <td><b>PMIN</b></td>
			  <td><b>PMOUT</b></td>
			  <td><b>OTIN</b></td>
			  <td><b>OTOUT</b></td>
			</tr>";
	do{
	   echo "<tr class='w3-hover-blue'>";
       echo "<td class='w3-small'>".$rr['data_id']."</td>";
	   echo "<td align='center' class='w3-small'>".$rr['company']."</td>";
	   echo "<td align='center' class='w3-small'>".$rr['dept']."</td>";
	   echo "<td align='right' class='w3-small'>&nbsp;".$rr['e_no']."&nbsp;</td>";
	   echo "<td align='left' class='w3-small'>&nbsp;".$rr['name']."</td>";
	   echo "<td>&nbsp;".date('m/d/Y',strtotime($rr['date']))."&nbsp;</td>";
	   if($rr['amin']!=0){ echo "<td>&nbsp;".$rr['amin']."&nbsp;</td>"; } else { echo "<td class='w3-text-white'>&nbsp;".$rr['amin']."&nbsp;</td>"; }
	   if($rr['amout']!=0){ echo "<td>&nbsp;".$rr['amout']."&nbsp;</td>"; } else { echo "<td class='w3-text-white'>&nbsp;".$rr['amout']."&nbsp;</td>"; }
	   if($rr['pmin']!=0){ echo "<td>&nbsp;".$rr['pmin']."&nbsp;</td>"; } else { echo "<td class='w3-text-white'>&nbsp;".$rr['pmin']."&nbsp;</td>"; }
	   if($rr['pmout']!=0){ echo "<td>&nbsp;".$rr['pmout']."&nbsp;</td>"; } else { echo "<td class='w3-text-white'>&nbsp;".$rr['pmout']."&nbsp;</td>"; }
	   if($rr['otin']!=0){ echo "<td>&nbsp;".$rr['otin']."&nbsp;</td>"; } else { echo "<td class='w3-text-white'>&nbsp;".$rr['otin']."&nbsp;</td>"; }
	   if($rr['otout']!=0){ echo "<td>&nbsp;".$rr['otout']."&nbsp;</td>"; } else { echo "<td class='w3-text-white'>&nbsp;".$rr['otout']."&nbsp;</td>"; }
	}while($rr=mysql_fetch_assoc($qq));
	echo "</table>";
	}
	?>