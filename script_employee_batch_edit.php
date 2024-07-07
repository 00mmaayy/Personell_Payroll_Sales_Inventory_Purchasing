<?php 
session_start();
include('connection/conn.php');
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); }
$username=$_SESSION['username'];

if(isset($_REQUEST['jobtitlenew']))
{
	$e_no=$_REQUEST['e_no'];
	$e_lname=$_REQUEST['e_lname'];
	$e_fname=$_REQUEST['e_fname'];
	$jobtitleold=$_REQUEST['jobtitleold'];
	$jobtitlenew=$_REQUEST['jobtitlenew'];
	mysql_query("update employee set e_job_title='$jobtitlenew' where e_no='$e_no'") or die(mysql_error());

	$trans="update job title of $e_no $e_fname $e_lname from $jobtitleold to $jobtitlenew";
	$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
	$log_query=mysql_query($log_sql) or die(mysql_error());
	
	header('Location: script_employee_batch_edit.php');
	
}

if(isset($_REQUEST['basicpaynew']))
{
	$e_no=$_REQUEST['e_no'];
	$basicpayold=$_REQUEST['basicpayold'];
	$basicpaynew=$_REQUEST['basicpaynew'];
	mysql_query("update employee set e_basic_pay='$basicpaynew' where e_no='$e_no'") or die(mysql_error());

	$trans="update basic pay of $e_no $e_fname $e_lname from $basicpayold to $basicpaynew";
	$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
	$log_query=mysql_query($log_sql) or die(mysql_error());
	
	header('Location: script_employee_batch_edit.php');
	
}

if(isset($_REQUEST['entrydatenew']))
{
	$e_no=$_REQUEST['e_no'];
	$entrydateold=$_REQUEST['entrydateold'];
	$entrydatenew=$_REQUEST['entrydatenew'];
	mysql_query("update employee set e_entry_date='$entrydatenew' where e_no='$e_no'") or die(mysql_error());

	$trans="update entrydate of $e_no $e_fname $e_lname from $entrydateold to $entrydatenew";
	$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
	$log_query=mysql_query($log_sql) or die(mysql_error());
	
	header('Location: script_employee_batch_edit.php');
	
}
?>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/w3.css">
<link rel="stylesheet" href="css/font-awesome.min.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>

<br>
<div>

<form>
	<select required name='company'>
	  <option>ALL</option>
	  <?php $x1="select company from company order by company asc";
	  	    $y1=mysql_query($x1) or die(mysql_error());
			$z1=mysql_fetch_assoc($y1); 
			 do{
			    echo "<option>".$z1['company']."</option>";
			   }while($z1=mysql_fetch_assoc($y1));
	  ?>
	</select>
	<input class='w3-small' type='submit' value='SHOW'>
</form>

<?php 
if(isset($_REQUEST['company']))
{
	$comp=$_REQUEST['company'];
	if($comp!="ALL")
	{
		$company="and e_company='$comp'";
	}
	else{}
}
else{ $company=""; }

$s="select * from employee where e_employment_status!='Resigned' and e_employment_status!='NotConnected' and e_employment_status!='Agency' $company order by e_company asc, e_lname asc";
$q=mysql_query($s) or die(mysql_error());
$r=mysql_fetch_assoc($q);
echo "<table class='table w3-tiny' border='1'>
		<tr>
			<td class='w3-green'>COMPANY</td>
			<td class='w3-green'>NAME / JOB TITLE</td>
			<td class='w3-green' align='right'>BASIC PAY</td>
			<td class='w3-green' align='right'>ENTRY DATE</td>
			<td class='w3-orange' align='right'>JOB TITLE NEW</td>
			<td class='w3-orange' align='right'>BASIC PAY NEW</td>
			<td class='w3-orange' align='right'>ENTRY DATE NEW</td>
		</tr>";

do{
	echo "<tr class='w3-hover-pale-red'>";
		echo "<td><b>".$r['e_company']."</b></td>";
		echo "<td><b>".$r['e_lname'].", ".$r['e_fname']." ".$r['e_mname']."</b><br/><i>".$r['e_job_title']."</i></td>";
		echo "<td align='right'><b>".number_format($r['e_basic_pay'],2)."</b></td>";
		echo "<td align='right'><b>".date('F d,Y',strtotime($r['e_entry_date']))."</b></td>"; ?>
				<form>
				<td align='right'>
					<input name='e_no' type='hidden' value='<?php echo $r['e_no']; ?>'>
					<input name='e_lname' type='hidden' value='<?php echo $r['e_lname']; ?>'>
					<input name='e_fname' type='hidden' value='<?php echo $r['e_fname']; ?>'>
					<input name='company' type='hidden' value='<?php echo $_REQUEST['company']; ?>'>
					<input name='jobtitleold' type='hidden' value='<?php echo $r['e_job_title']; ?>'>
					<input required name='jobtitlenew' type='text' value='<?php echo $r['e_job_title']; ?>' placeholder='<?php echo $r['e_job_title']; ?>'>
					<input type='submit' value='UPDATE'>
				</td>
				</form>
				
				<form>
				<td align='right'>
					<input name='e_no' type='hidden' value='<?php echo $r['e_no']; ?>'>
					<input name='e_lname' type='hidden' value='<?php echo $r['e_lname']; ?>'>
					<input name='e_fname' type='hidden' value='<?php echo $r['e_fname']; ?>'>
					<input name='company' type='hidden' value='<?php echo $_REQUEST['company']; ?>'>
					<input name='basicpayold' type='hidden' value='<?php echo $r['e_basic_pay']; ?>'>
					<input required name='basicpaynew' type='number' step='any' value='<?php echo $r['e_basic_pay']; ?>' placeholder='<?php echo $r['e_basic_pay']; ?>'>
					<input type='submit' value='UPDATE'>
				</td>
				</form>
				
				<form>
				<td align='right'>
					<input name='e_no' type='hidden' value='<?php echo $r['e_no']; ?>'>
					<input name='e_lname' type='hidden' value='<?php echo $r['e_lname']; ?>'>
					<input name='e_fname' type='hidden' value='<?php echo $r['e_fname']; ?>'>
					<input name='company' type='hidden' value='<?php echo $_REQUEST['company']; ?>'>
					<input name='entrydateold' type='hidden' value='<?php echo $r['e_entry_date']; ?>'>
					<input required name='entrydatenew' type='date' step='any' value='<?php echo $r['e_entry_date']; ?>' placeholder='<?php echo $r['e_entry_date']; ?>'>
					<input type='submit' value='UPDATE'>
				</td>
				</form>
				
<?php echo "</tr>";
}while($r=mysql_fetch_assoc($q));
echo "</table>";
?>
</div>
