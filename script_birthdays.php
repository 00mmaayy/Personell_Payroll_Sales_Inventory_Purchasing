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

<br>
<div class='container'>
	
		<form method='get'>
		<input name='birthdays' type='hidden' value='1'>
		<select name='month' class='btn'>
			<option value='' disabled selected>none</option>
			<option value='01'>January</option><option value='02'>February</option><option value='03'>March</option><option value='04'>April</option>
			<option value='05'>May</option><option value='06'>June</option><option value='07'>July</option><option value='08'>August</option>
			<option value='09'>September</option><option value='10'>October</option><option value='11'>November</option><option value='12'>December</option>
		</select>
		<input type='submit' class='btn btn-primary w3-tiny' value='SEARCH PER MONTH'>
		</form>
	
<?php
$month=$_REQUEST['month'];
$s="SELECT e_lname,e_mname,e_fname,e_bday,day(e_bday) as day FROM employee where month(e_bday)='$month' and e_employment_status!='NotConnected' and e_employment_status!='Resigned' order by day asc";
$q=mysql_query($s) or die(mysql_error());
$r=mysql_fetch_assoc($q);
$count=mysql_num_rows($q);

echo "<br>
      <table class='table'>
		<tr><td colspan='3' align='center'><b class='w3-text-red w3-xlarge'>$count Employee/s</b> <b class='text-primary w3-xlarge'>with Birthday!</b></td></tr>
		<tr class='w3-light-gray'><td>EMPLOYEE NAME</td><td>BIRTHDAY</td><td>AGE</td></tr>";
do{
	
	$age_base=$r['e_bday'];
    $aa="SELECT TIMESTAMPDIFF(YEAR, '$age_base', CURDATE()) AS age";
    $aq=mysql_query($aa);
	$ar=mysql_fetch_assoc($aq);
		 
	echo "<tr class='w3-hover-pale-red'>";
       echo "<td>".$r['e_lname'].", ".$r['e_fname']." ".$r['e_mname']."</td><td>".date('F d, Y',strtotime($r['e_bday']))."</td><td class='w3-text-indigo'>".$ar['age']."</td>
		  </tr>";

}while($r=mysql_fetch_assoc($q));	

echo "</table>";

?>
</div>
