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
    <div class='container'>
	<table class='table'>
		<tr>
			<form method='get'>
			    <td>
				<select class='form-control' required name='sort'>
					<option value='absents'>Absent Ranking</option>
					<option value='comp'>Per Company</option>
				</select>&nbsp;SORT
				</td>
				<td>
					<input class='form-control' required name='start' type='date' value='<?php if(isset($_REQUEST['start'])){ echo $_REQUEST['start']; }else{} ?>'>&nbsp;START DATE
				</td>
				<td>
					<input class='form-control' required name='end' type='date' value='<?php if(isset($_REQUEST['end'])){ echo $_REQUEST['end']; }else{} ?>'>&nbsp;END DATE
				</td>
				<td><input class='btn btn-primary' type='submit' value='Search'></td>
			</form>
		</tr>
	</table>
    </div>	
<?php 
	if(isset($_REQUEST['start']))
	  {
		$start=$_REQUEST['start'];
		$end=$_REQUEST['end'];
		
	    if($_REQUEST['sort']=="absents"){ $q=mysql_query("select * from payroll where payroll_period>='$start' and payroll_period<='$end' and e_absences>0 order by e_absences desc") or die(mysql_error()); }
		if($_REQUEST['sort']=="comp"){ $q=mysql_query("select * from payroll where payroll_period>='$start' and payroll_period<='$end' and e_absences>0 order by e_company,e_department asc, e_absences desc") or die(mysql_error()); }
		
		$r=mysql_fetch_assoc($q);
		echo "<table border='1' align='center'>
		      <tr class='bg-primary'><td colspan='6' align='center'>".date('m/d/Y',strtotime($_REQUEST['start']))." - ".date('m/d/Y',strtotime($_REQUEST['end']))."</td></tr>
		      <tr align='center' class='w3-dark-gray'>
				 <td>&nbsp;RANK&nbsp;</td>
			     <td width='60'>&nbsp;COMPANY&nbsp;</td>
				 <td width='60'>&nbsp;DEPARTMENT&nbsp;</td>
				 <td width='60'>&nbsp;ID&nbsp;</td>
				 <td width='60'>&nbsp;NAME&nbsp;</td>
				 <td>&nbsp;ABSENTS&nbsp;</td>
			  </tr>";
		$x=1;	  
		do{
		
		$absents_hours=$r['e_absences'];
        $absents_days=$absents_hours/8;
		
		$e_no=$r['e_no'];	
		$q1=mysql_query("select e_lname,e_fname from employee where e_no='$e_no'") or die(mysql_error());
		$r1=mysql_fetch_assoc($q1);
		
		echo "<tr>
				  <td align='center'>".$x++."</td>
				  <td>&nbsp;".$r['e_company']."&nbsp;</td>
		          <td>&nbsp;".$r['e_department']."&nbsp;</td>
				  <td>&nbsp;".$r['e_no']."&nbsp;</td>
				  <td>&nbsp;".$r1['e_lname'].", ".$r1['e_fname']."</td>
				  <td align='right'>
						<b class='w3-text-red'>".$absents_days."</b><span class='w3-tiny'> Days</span> or
						<b class='w3-text-red'>".$absents_hours."</b><span class='w3-tiny'> Hrs</span>
				  </td>
			 </tr>";
		
		}while($r=mysql_fetch_assoc($q));
		echo "<tr><td colspan='5'>&nbsp;</td></tr></table>";
	  }	 
	?>
</body>