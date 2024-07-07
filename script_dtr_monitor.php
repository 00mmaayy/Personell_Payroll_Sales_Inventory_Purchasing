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

<body>
<?php
//---Access Level---
$current_user=$_SESSION['username'];
$spas="select * from user_access where username='$current_user'";
$qpas=mysql_query($spas) or die(mysql_error());
$access=mysql_fetch_assoc($qpas);
//---Access Level---		 
		 
//---insert to database new edited time---
if(isset($_REQUEST['submit']))
{
$rh1=$_REQUEST['rh1'];
$rh2=$_REQUEST['rh2'];
$rh3=$_REQUEST['rh3'];
$rh4=$_REQUEST['rh4'];
$sh1=$_REQUEST['sh1'];
$sh2=$_REQUEST['sh2'];
$sh3=$_REQUEST['sh3'];
$sh4=$_REQUEST['sh4'];
	
$data_id=$_REQUEST['data_id'];	
$amin=$_REQUEST['amin'];	
$amout=$_REQUEST['amout'];
$pmin=$_REQUEST['pmin'];
$pmout=$_REQUEST['pmout'];
$otin=$_REQUEST['otin'];
$otout=$_REQUEST['otout'];
$sx="update dtr_log set amin='$amin',amout='$amout',pmin='$pmin',pmout='$pmout',otin='$otin',otout='$otout' where data_id=$data_id";
$qx=mysql_query($sx) or die(mysql_error());

$username=$_SESSION['username'];
$trans="update dtr entries to data_id $data_id";
$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
$log_query=mysql_query($log_sql) or die(mysql_error());

header("Location: script_dtr_monitor.php?rh1=$rh1&rh2=$rh2&rh3=$rh3&rh4=$rh4&sh1=$sh1&sh2=$sh2&sh3=$sh3&sh4=$sh4&search=".$_REQUEST['search']."&payroll_period=".$_REQUEST['payroll_period']."&sdate=".$_REQUEST['sdate']."&edate=".$_REQUEST['edate']."&data_id=$data_id&success=");
}
//---insert to database new edited time---
?>

<table>
<tr>
<td>

<table>
  <tr class='w3-small' align='center'>
     <td colspan='2'><strong>SET DTR COVERAGE</strong></td>
  </tr>
  <tr>
    <td class='w3-small'>
	<form method='get'>
	<input name='search' type='hidden' value='xxx'>
	<input name='rh1' type='hidden' value='<?php echo $_REQUEST['rh1']; ?>'>
	<input name='rh2' type='hidden' value='<?php echo $_REQUEST['rh2']; ?>'>
	<input name='rh3' type='hidden' value='<?php echo $_REQUEST['rh3']; ?>'>
	<input name='rh4' type='hidden' value='<?php echo $_REQUEST['rh4']; ?>'>
	<input name='sh1' type='hidden' value='<?php echo $_REQUEST['sh1']; ?>'>
	<input name='sh2' type='hidden' value='<?php echo $_REQUEST['sh2']; ?>'>
	<input name='sh3' type='hidden' value='<?php echo $_REQUEST['sh3']; ?>'>
	<input name='sh4' type='hidden' value='<?php echo $_REQUEST['sh4']; ?>'>
	<input name='payroll_period' type='hidden' value='<?php echo $_REQUEST['payroll_period']; ?>'>
	<br>
	&nbsp;
	START DATE:<br>
	&nbsp;<input name='sdate' type='date'>
	</td>
    <td class='w3-small'>
	&nbsp;&nbsp;&nbsp;
	END DATE:<br>&nbsp;&nbsp;&nbsp;
	<input name='edate' type='date'>
	</td>
	
  </tr>  

<?php

if(isset($_REQUEST['search']))
{ $search=$_REQUEST['search'];
  $sdate=$_REQUEST['sdate'];
  $edate=$_REQUEST['edate'];
  $payroll_period=$_REQUEST['payroll_period'];
  $s="select * from dtr_log where name like '%$search%' and date>='$sdate' and date<='$edate' order by data_id asc"; 
}
else
{ $sdate=$_REQUEST['sdate'];
  $edate=$_REQUEST['edate'];
  $payroll_period=$_REQUEST['payroll_period']; 
  $s="select * from dtr_log where date>='$sdate' and date<='$edate' order by data_id asc";
}

$q=mysql_query($s) or die(mysql_error());
$r=mysql_fetch_assoc($q);
$records_found=mysql_num_rows($q);

echo "<tr>
       <td class='w3-small' align='center' colspan='2'>
	   <input type='submit' value='SET DATE'>
	   </form>
	   </td>
	  </tr>
      <tr>	  
       <td colspan='2' align='center'><br>
		<div class='text-success w3-small'>
			&nbsp;Date Start: <strong class='w3-text-blue'>".date('m/d/Y',strtotime($sdate))."</strong><br>
			&nbsp;Date End: <strong class='w3-text-blue'>".date('m/d/Y',strtotime($edate))."</strong><br>
		</div>
	   </td>
	  </tr>
</table>";
?>

</td>
<td width='1200' valign='top' align='center'>

<table>
 <tr align='center'>
  <td colspan='5' width='1200'><span class='w3-small'></span><br><br></td>
 </tr>
 <tr align='center' class='w3-small'>
  <td colspan='2'><strong>REGULAR HOLIDAYS</strong><br><br></td>
  <td colspan='2'><strong>SPECIAL HOLIDAYS</strong><br><br></td>
  <td></td>
 </tr>
  
<!--Regular Holiday-->
 <tr class='w3-small' align='center'> 
  <td>
    <form method='get'>
	<input name='rh2' type='hidden' value='<?php echo $_REQUEST['rh2']; ?>'>
	<input name='rh3' type='hidden' value='<?php echo $_REQUEST['rh3']; ?>'>
	<input name='rh4' type='hidden' value='<?php echo $_REQUEST['rh4']; ?>'>
	<input name='sh1' type='hidden' value='<?php echo $_REQUEST['sh1']; ?>'>
	<input name='sh2' type='hidden' value='<?php echo $_REQUEST['sh2']; ?>'>
	<input name='sh3' type='hidden' value='<?php echo $_REQUEST['sh3']; ?>'>
	<input name='sh4' type='hidden' value='<?php echo $_REQUEST['sh4']; ?>'>
	<input name='sdate' type='hidden' value='<?php echo $_REQUEST['sdate']; ?>'>
	<input name='edate' type='hidden' value='<?php echo $_REQUEST['edate']; ?>'>
	<input name='search' type='hidden' value='xxx'>
    <input name='payroll_period' type='hidden' value='<?php echo $_REQUEST['payroll_period']; ?>'>
    <input required name='rh1' type='date'><br>
    <input type='submit' value='REGULAR HOLIDAY (1)'>
    </form>
	<form method='get'>
	<input name='rh1' type='hidden' value='<?php echo $_REQUEST['rh1']; ?>'>
	<input name='rh2' type='hidden' value='<?php echo $_REQUEST['rh2']; ?>'>
	<input name='rh4' type='hidden' value='<?php echo $_REQUEST['rh4']; ?>'>
	<input name='sh1' type='hidden' value='<?php echo $_REQUEST['sh1']; ?>'>
	<input name='sh2' type='hidden' value='<?php echo $_REQUEST['sh2']; ?>'>
	<input name='sh3' type='hidden' value='<?php echo $_REQUEST['sh3']; ?>'>
	<input name='sh4' type='hidden' value='<?php echo $_REQUEST['sh4']; ?>'>
	<input name='sdate' type='hidden' value='<?php echo $_REQUEST['sdate']; ?>'>
	<input name='edate' type='hidden' value='<?php echo $_REQUEST['edate']; ?>'>
	<input name='search' type='hidden' value='xxx'>
    <input name='payroll_period' type='hidden' value='<?php echo $_REQUEST['payroll_period']; ?>'>
    <input required name='rh3' type='date'><br>
    <input type='submit' value='REGULAR HOLIDAY (3)'>
    </form>
  </td>
  <td>
    <form method='get'>
	<input name='rh1' type='hidden' value='<?php echo $_REQUEST['rh1']; ?>'>
	<input name='rh3' type='hidden' value='<?php echo $_REQUEST['rh3']; ?>'>
	<input name='rh4' type='hidden' value='<?php echo $_REQUEST['rh4']; ?>'>
	<input name='sh1' type='hidden' value='<?php echo $_REQUEST['sh1']; ?>'>
	<input name='sh2' type='hidden' value='<?php echo $_REQUEST['sh2']; ?>'>
	<input name='sh3' type='hidden' value='<?php echo $_REQUEST['sh3']; ?>'>
	<input name='sh4' type='hidden' value='<?php echo $_REQUEST['sh4']; ?>'>
    <input name='sdate' type='hidden' value='<?php echo $_REQUEST['sdate']; ?>'>
	<input name='edate' type='hidden' value='<?php echo $_REQUEST['edate']; ?>'>
	<input name='search' type='hidden' value='xxx'>
    <input name='payroll_period' type='hidden' value='<?php echo $_REQUEST['payroll_period']; ?>'>
    <input required name='rh2' type='date'><br>
	<input type='submit' value='REGULAR HOLIDAY (2)'>
    </form>
	<form method='get'>
	<input name='rh1' type='hidden' value='<?php echo $_REQUEST['rh1']; ?>'>
	<input name='rh2' type='hidden' value='<?php echo $_REQUEST['rh2']; ?>'>
	<input name='rh3' type='hidden' value='<?php echo $_REQUEST['rh3']; ?>'>
	<input name='sh1' type='hidden' value='<?php echo $_REQUEST['sh1']; ?>'>
	<input name='sh2' type='hidden' value='<?php echo $_REQUEST['sh2']; ?>'>
	<input name='sh3' type='hidden' value='<?php echo $_REQUEST['sh3']; ?>'>
	<input name='sh4' type='hidden' value='<?php echo $_REQUEST['sh4']; ?>'>
	<input name='sdate' type='hidden' value='<?php echo $_REQUEST['sdate']; ?>'>
	<input name='edate' type='hidden' value='<?php echo $_REQUEST['edate']; ?>'>
	<input name='search' type='hidden' value='xxx'>
    <input name='payroll_period' type='hidden' value='<?php echo $_REQUEST['payroll_period']; ?>'>
    <input required name='rh4' type='date'><br>
    <input type='submit' value='REGULAR HOLIDAY (4)'>
    </form>
  </td>
<!--Regular Holiday-->

<!--Special Holiday-->    
  <td>
    <form method='get'>
	<input name='rh1' type='hidden' value='<?php echo $_REQUEST['rh1']; ?>'>
	<input name='rh2' type='hidden' value='<?php echo $_REQUEST['rh2']; ?>'>
	<input name='rh3' type='hidden' value='<?php echo $_REQUEST['rh3']; ?>'>
	<input name='rh4' type='hidden' value='<?php echo $_REQUEST['rh4']; ?>'>
	<input name='sh2' type='hidden' value='<?php echo $_REQUEST['sh2']; ?>'>
	<input name='sh3' type='hidden' value='<?php echo $_REQUEST['sh3']; ?>'>
	<input name='sh4' type='hidden' value='<?php echo $_REQUEST['sh4']; ?>'>
	<input name='sdate' type='hidden' value='<?php echo $_REQUEST['sdate']; ?>'>
	<input name='edate' type='hidden' value='<?php echo $_REQUEST['edate']; ?>'>
	<input name='search' type='hidden' value='xxx'>
    <input name='payroll_period' type='hidden' value='<?php echo $_REQUEST['payroll_period']; ?>'>
    <input required name='sh1' type='date'><br>
    <input type='submit' value='SPECIAL HOLIDAY (1)'>
    </form>
	<form method='get'>
	<input name='rh1' type='hidden' value='<?php echo $_REQUEST['rh1']; ?>'>
	<input name='rh2' type='hidden' value='<?php echo $_REQUEST['rh2']; ?>'>
	<input name='rh3' type='hidden' value='<?php echo $_REQUEST['rh3']; ?>'>
	<input name='rh4' type='hidden' value='<?php echo $_REQUEST['rh4']; ?>'>
	<input name='sh1' type='hidden' value='<?php echo $_REQUEST['sh1']; ?>'>
	<input name='sh2' type='hidden' value='<?php echo $_REQUEST['sh2']; ?>'>
	<input name='sh4' type='hidden' value='<?php echo $_REQUEST['sh4']; ?>'>
	<input name='sdate' type='hidden' value='<?php echo $_REQUEST['sdate']; ?>'>
	<input name='edate' type='hidden' value='<?php echo $_REQUEST['edate']; ?>'>
	<input name='search' type='hidden' value='xxx'>
    <input name='payroll_period' type='hidden' value='<?php echo $_REQUEST['payroll_period']; ?>'>
    <input required name='sh3' type='date'><br>
    <input type='submit' value='SPECIAL HOLIDAY (3)'>
    </form>
  </td>
  <td>
    <form method='get'>
	<input name='rh1' type='hidden' value='<?php echo $_REQUEST['rh1']; ?>'>
	<input name='rh2' type='hidden' value='<?php echo $_REQUEST['rh2']; ?>'>
	<input name='rh3' type='hidden' value='<?php echo $_REQUEST['rh3']; ?>'>
	<input name='rh4' type='hidden' value='<?php echo $_REQUEST['rh4']; ?>'>
	<input name='sh1' type='hidden' value='<?php echo $_REQUEST['sh1']; ?>'>
	<input name='sh3' type='hidden' value='<?php echo $_REQUEST['sh3']; ?>'>
	<input name='sh4' type='hidden' value='<?php echo $_REQUEST['sh4']; ?>'>
    <input name='sdate' type='hidden' value='<?php echo $_REQUEST['sdate']; ?>'>
	<input name='edate' type='hidden' value='<?php echo $_REQUEST['edate']; ?>'>
	<input name='search' type='hidden' value='xxx'>
    <input name='payroll_period' type='hidden' value='<?php echo $_REQUEST['payroll_period']; ?>'>
    <input required name='sh2' type='date'><br>
	<input type='submit' value='SPECIAL HOLIDAY (2)'>
    </form>
	<form method='get'>
	<input name='rh1' type='hidden' value='<?php echo $_REQUEST['rh1']; ?>'>
	<input name='rh2' type='hidden' value='<?php echo $_REQUEST['rh2']; ?>'>
	<input name='rh3' type='hidden' value='<?php echo $_REQUEST['rh3']; ?>'>
	<input name='rh4' type='hidden' value='<?php echo $_REQUEST['rh4']; ?>'>
	<input name='sh1' type='hidden' value='<?php echo $_REQUEST['sh1']; ?>'>
	<input name='sh2' type='hidden' value='<?php echo $_REQUEST['sh2']; ?>'>
	<input name='sh3' type='hidden' value='<?php echo $_REQUEST['sh3']; ?>'>
	<input name='sdate' type='hidden' value='<?php echo $_REQUEST['sdate']; ?>'>
	<input name='edate' type='hidden' value='<?php echo $_REQUEST['edate']; ?>'>
	<input name='search' type='hidden' value='xxx'>
    <input name='payroll_period' type='hidden' value='<?php echo $_REQUEST['payroll_period']; ?>'>
    <input required name='sh4' type='date'><br>
    <input type='submit' value='SPECIAL HOLIDAY (4)'>
    </form>
  </td>
  <td>
<?php 
 if($access['a6']==1)
   { ?>
	<form method='get' action='script_dtr_input.php' target='_blank'>
	 <input class='form-control btn-success' type='submit' value='INPUT DTR'>
	</form>
  </td>
   <?php } ?>  
 
 <tr align='center' class='w3-small'>
  <td colspan='2' class='text-success'>
      <?php if($_REQUEST['rh1']=="")
	          { echo "Regular Holiday 1: <strong><span class='w3-text-red'>NOT SET</span></strong><br>";}else{ echo "Regular Holiday 1: <strong><span class='w3-text-blue'>".date('m/d/Y',strtotime($_REQUEST['rh1']))."</span></strong><br>";} 
		    if($_REQUEST['rh2']=="")
	          { echo "Regular Holiday 2: <strong><span class='w3-text-red'>NOT SET</span></strong><br>";}else{ echo "Regular Holiday 2: <strong><span class='w3-text-blue'>".date('m/d/Y',strtotime($_REQUEST['rh2']))."</span></strong><br>";} 
		    if($_REQUEST['rh3']=="")
	          { echo "Regular Holiday 3: <strong><span class='w3-text-red'>NOT SET</span></strong><br>";}else{ echo "Regular Holiday 3: <strong><span class='w3-text-blue'>".date('m/d/Y',strtotime($_REQUEST['rh3']))."</span></strong><br>";} 
		    if($_REQUEST['rh4']=="")
	          { echo "Regular Holiday 4: <strong><span class='w3-text-red'>NOT SET</span></strong><br>";}else{ echo "Regular Holiday 4: <strong><span class='w3-text-blue'>".date('m/d/Y',strtotime($_REQUEST['rh4']))."</span></strong><br>";} 
	  ?>
		  
  </td>
  <td colspan='2' class='text-success'>
      <?php if($_REQUEST['sh1']=="")
	          { echo "Special Holiday 1: <strong><span class='w3-text-red'>NOT SET</span></strong><br>";}else{ echo "Special Holiday 1: <strong><span class='w3-text-blue'>".date('m/d/Y',strtotime($_REQUEST['sh1']))."</span></strong><br>";} 
		    if($_REQUEST['sh2']=="")
	          { echo "Special Holiday 2: <strong><span class='w3-text-red'>NOT SET</span></strong><br>";}else{ echo "Special Holiday 2: <strong><span class='w3-text-blue'>".date('m/d/Y',strtotime($_REQUEST['sh2']))."</span></strong><br>";} 
		    if($_REQUEST['sh3']=="")
	          { echo "Special Holiday 3: <strong><span class='w3-text-red'>NOT SET</span></strong><br>";}else{ echo "Special Holiday 3: <strong><span class='w3-text-blue'>".date('m/d/Y',strtotime($_REQUEST['sh3']))."</span></strong><br>";} 
		    if($_REQUEST['sh4']=="")
	          { echo "Special Holiday 4: <strong><span class='w3-text-red'>NOT SET</span></strong><br>";}else{ echo "Special Holiday 4: <strong><span class='w3-text-blue'>".date('m/d/Y',strtotime($_REQUEST['sh4']))."</span></strong><br>";} 
	  ?>
		  
  </td>
 </tr>
</table>
  
</td>
</tr>
</table>

<hr>
<table>
  <tr valign='top'>
    <td>
	<form method='get'>
	<input name='payroll_period' type='hidden' value='<?php echo $_REQUEST['payroll_period']; ?>'>
	<input name='sdate' type='hidden' value='<?php echo $_REQUEST['sdate']; ?>'>
	<input name='edate' type='hidden' value='<?php echo $_REQUEST['edate']; ?>'>
	<input name='rh1' type='hidden' value='<?php echo $_REQUEST['rh1']; ?>'>
	<input name='rh2' type='hidden' value='<?php echo $_REQUEST['rh2']; ?>'>
	<input name='rh3' type='hidden' value='<?php echo $_REQUEST['rh3']; ?>'>
	<input name='rh4' type='hidden' value='<?php echo $_REQUEST['rh4']; ?>'>
	<input name='sh1' type='hidden' value='<?php echo $_REQUEST['sh1']; ?>'>
	<input name='sh2' type='hidden' value='<?php echo $_REQUEST['sh2']; ?>'>
	<input name='sh3' type='hidden' value='<?php echo $_REQUEST['sh3']; ?>'>
	<input name='sh4' type='hidden' value='<?php echo $_REQUEST['sh4']; ?>'>
	<small>&nbsp;&nbsp;<input name='search' type='text' placeholder='Input Name'>
	             &nbsp;<input type='submit' value='search'></small>
	</form>
	</td>
	
	<td width='200'>
	<div class='w3-text-red w3-tiny'>&nbsp;search tag: <strong><?php echo $search;?></strong><br>&nbsp;records found: <strong><?php echo $records_found;?></strong></div>
    </td>
	
	<td>
	<?php if($access['a6']==1)
	{ ?>
	
	<?php $cs="select * from payroll_cutoff";
		  $cq=mysql_query($cs) or die(mysql_error());
		  $rq=mysql_fetch_assoc($cq); 
		  $today=date('d');?> 
	
	<form method='get'>
	<input name='payroll_period' type='hidden' value='<?php echo $_REQUEST['payroll_period']; ?>'>
	<input name='sdate' type='hidden' value='<?php echo $_REQUEST['sdate']; ?>'>
	<input name='edate' type='hidden' value='<?php echo $_REQUEST['edate']; ?>'>
	<input name='rh1' type='hidden' value='<?php echo $_REQUEST['rh1']; ?>'>
	<input name='rh2' type='hidden' value='<?php echo $_REQUEST['rh2']; ?>'>
	<input name='rh3' type='hidden' value='<?php echo $_REQUEST['rh3']; ?>'>
	<input name='rh4' type='hidden' value='<?php echo $_REQUEST['rh4']; ?>'>
	<input name='sh1' type='hidden' value='<?php echo $_REQUEST['sh1']; ?>'>
	<input name='sh2' type='hidden' value='<?php echo $_REQUEST['sh2']; ?>'>
	<input name='sh3' type='hidden' value='<?php echo $_REQUEST['sh3']; ?>'>
	<input name='sh4' type='hidden' value='<?php echo $_REQUEST['sh4']; ?>'>
	<input name='search' type='hidden' value=''>
	<input name='finalize' type='hidden' value=''>

<?php 
   $sx="select step3 from payroll order by payroll_period desc";
   $qx=mysql_query($sx) or die(mysql_error());
   $rx=mysql_fetch_assoc($qx);
 
  if($rx['step3']==0)
     { ?>
 <?php if( $today>=$rq['c1'] && $today<=$rq['c11'] ) { ?><small>&nbsp;&nbsp;<input class='form-control btn-danger' type='submit' value='FINALIZE COMPUTATION 1stCut' onclick="return confirm('WARNING: Finalize Day Rates Computation? Are you sure?')"></small><?php } else {} ?>
 <?php if( $today>=$rq['c2'] && $today<=$rq['c22'] ) { ?><small>&nbsp;&nbsp;<input class='form-control btn-danger' type='submit' value='FINALIZE COMPUTATION 2ndCut' onclick="return confirm('WARNING: Finalize Day Rates Computation? Are you sure?')"></small><?php } else {} ?>
<?php } ?>
 </form>

   
 <?php   
   echo "<div align='center'>
			<form method='get' action='script_dtr_totaltime.php' target='_blank'>
				<input name='sdate' type='hidden' value='".$_REQUEST['sdate']."'>
				<input name='edate' type='hidden' value='".$_REQUEST['edate']."'>
				<input name='payroll_period' type='hidden' value='".$_REQUEST['payroll_period']."'>
				<small><input class='form-control btn-primary' type='submit' value='Print DTR Summary'></small>
			</form>
		</div>"; 	
 ?>
   
 <?php } ?>
	
      <?php	
	    if(isset($_REQUEST['finalize']))
		{
		 $sx="select e_no from payroll where payroll_period='$payroll_period' order by e_no asc";
		 $qx=mysql_query($sx) or die(mysql_error());
		 $rx=mysql_fetch_assoc($qx);
		 do{
			 $e_nox=$rx['e_no'];
			 $s_sum="select sum(reg_day_time) as reg_day_time,
			                sum(reg_day_ot_time) as reg_day_ot_time,
							sum(reg_day_amount) as reg_day_amount, 
			                sum(reg_day_ot_amount) as reg_day_ot_amount,
							sum(reg_hol_time) as reg_hol_time, 
							sum(reg_hol_ot_time) as reg_hol_ot_time,
							sum(reg_hol_amount) as reg_hol_amount, 
							sum(reg_hol_ot_amount) as reg_hol_ot_amount,
							sum(spe_hol_time) as spe_hol_time,
							sum(spe_hol_ot_time) as spe_hol_ot_time,
							sum(spe_hol_amount) as spe_hol_amount,
							sum(spe_hol_ot_amount) as spe_hol_ot_amount,
							sum(restday_time) as restday_time,
							sum(restday_ot_time) as restday_ot_time, 
			                sum(restday_amount) as restday_amount,
							sum(restday_ot_amount) as restday_ot_amount from dtr_log where date>='$sdate' and date<='$edate' and e_no=$e_nox ";
							
			 $q_sum=mysql_query($s_sum) or die(mysql_error());
			 $r_sum=mysql_fetch_assoc($q_sum);
			 
			 $reg_day_time=round($r_sum['reg_day_time']/60,2);
			 $reg_day_ot_time=round($r_sum['reg_day_ot_time']/60,2);
			 $reg_day_amount=round($r_sum['reg_day_amount'],2);
			 $reg_day_ot_amount=round($r_sum['reg_day_ot_amount'],2);
			 
			 $reg_hol_time=round($r_sum['reg_hol_time']/60,2);
			 $reg_hol_ot_time=round($r_sum['reg_hol_ot_time']/60,2);
			 $reg_hol_amount=round($r_sum['reg_hol_amount'],2);
			 $reg_hol_ot_amount=round($r_sum['reg_hol_ot_amount'],2);
			 
			 $spe_hol_time=round($r_sum['spe_hol_time']/60,2);
			 $spe_hol_ot_time=round($r_sum['spe_hol_ot_time']/60,2);
			 $spe_hol_amount=round($r_sum['spe_hol_amount'],2);
			 $spe_hol_ot_amount=round($r_sum['spe_hol_ot_amount'],2);
			 
			 $restday_time=round($r_sum['restday_time']/60,2);
			 $restday_ot_time=round($r_sum['restday_ot_time']/60,2);
			 $restday_amount=round($r_sum['restday_amount'],2);
			 $restday_ot_amount=round($r_sum['restday_ot_amount'],2);
			 
			 $s_pay="update payroll set e_total_cuttoff_hours=$reg_day_time,
			                            e_total_cuttoff_hours_final=$reg_day_amount,
									    e_overtime=$reg_day_ot_time,
									    e_overtime_final=$reg_day_ot_amount,
									    e_restday_pay=$restday_time,
			                            e_restday_pay_final=$restday_amount,
									    e_restday_pay_overtime=$restday_ot_time,
										e_restday_pay_overtime_final=$restday_ot_amount,
										e_regular_holiday=$reg_hol_time,
			                            e_regular_holiday_final=$reg_hol_amount,
									    e_regular_holiday_overtime=$reg_hol_ot_time,
									    e_regular_holiday_overtime_final=$reg_hol_ot_amount,
										e_special_holiday=$spe_hol_time,
			                            e_special_holiday_final=$spe_hol_amount,
										e_special_holiday_overtime=$spe_hol_ot_time,
										e_special_holiday_overtime_final=$spe_hol_ot_amount
		  						  where e_no='$e_nox' and payroll_period='$payroll_period' ";
			 //echo "$s_pay<br><br>";
			 mysql_query($s_pay) or die(mysql_error);
			 
			$username=$_SESSION['username'];
			$trans="finalized update payroll dtr details for ID No $e_nox";
			$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
			$log_query=mysql_query($log_sql) or die(mysql_error());
			 
		   }while($rx=mysql_fetch_assoc($qx));
		 
        } 	
	  ?>  
	  
	</td>	
  </tr>
</table>

<?php
//---Edit per Employee----------
if(isset($_REQUEST['data_id']))
{ 
  $data_id=$_REQUEST['data_id'];
  $s1="select * from dtr_log where data_id=$data_id";
  $q1=mysql_query($s1) or die(mysql_error());
  $r1=mysql_fetch_assoc($q1);
  echo "<br><table>";

echo "<tr align='center'>
	   <td><strong><small>&nbsp;DID&nbsp;</td>
	   <td><strong><small>&nbsp;COMPANY&nbsp;</td>
	   <td width='150'><strong><small>DEPT</td>
	   <td width='100'><strong><small>ID NO</td>
	   <td width='150'><strong><small>NAME</td>
	   <td width='100'><strong><small>DATE</td>
	   <td width='80'><strong><small>AM IN</td>
	   <td width='80'><strong><small>AM OUT</td>
	   <td width='80'><strong><small>PM IN</td>
	   <td width='80'><strong><small>PM OUT</td>
	   <td width='80'><strong><small>OT IN</td>
	   <td width='80'><strong><small>OT OUT</td>
	</tr>
	
	<tr align='center'>
    <td><small>".$r1['data_id']."</td>
	<td><small>".$r1['company']."</td>
	<td><small>".$r1['dept']."</td>
	<td><small>".$r1['e_no']."</td>
	<td><small>".$r1['name']."</td>
	<td><small>".date('m/d/Y',strtotime($r1['date']))."</td>
		 <form method='get'>
		 
		 <input name='search' type='hidden' value='".$_REQUEST['search']."'>
		 <input name='payroll_period' type='hidden' value='".$_REQUEST['payroll_period']."'>
		 <input name='sdate' type='hidden' value='".$_REQUEST['sdate']."'>
		 <input name='edate' type='hidden' value='".$_REQUEST['edate']."'>
		 <input name='data_id' type='hidden' value='$data_id'>
		 <input name='rh1' type='hidden' value='".$_REQUEST['rh1']."'>
		 <input name='rh2' type='hidden' value='".$_REQUEST['rh2']."'>
		 <input name='rh3' type='hidden' value='".$_REQUEST['rh3']."'>
		 <input name='rh4' type='hidden' value='".$_REQUEST['rh4']."'>
		 <input name='sh1' type='hidden' value='".$_REQUEST['sh1']."'>
		 <input name='sh2' type='hidden' value='".$_REQUEST['sh2']."'>
		 <input name='sh3' type='hidden' value='".$_REQUEST['sh3']."'>
	 	 <input name='sh4' type='hidden' value='".$_REQUEST['sh4']."'>
	<td><small><input class='form-control' name='amin' type='time' value='".$r1['amin']."'></td>
	<td><small><input class='form-control' name='amout' type='time' value='".$r1['amout']."'></td>
	<td><small><input class='form-control' name='pmin' type='time' value='".$r1['pmin']."'></td>
	<td><small><input class='form-control' name='pmout' type='time' value='".$r1['pmout']."'></td>
	<td><small><input class='form-control' name='otin' type='time' value='".$r1['otin']."'></td>
	<td><small><input class='form-control' name='otout' type='time' value='".$r1['otout']."'></td>
	</tr>
    
	<tr>
	<td colspan='6'></td>
	<td colspan='6' align='center'>";
	
	if(isset($_REQUEST['success'])){ echo "<br><div class='text-success'><strong>Update Success!</strong></div>";}
	
	if($access['a6']==1){ echo "<br><input name='submit' type='submit' value='Update'></td>"; }
	echo "</tr>
		</form>
	</table>";  

	echo "<hr>";
//---Edit per Employee----------	
}

//loop start	
echo "<table border='1'>
      <tr align='center' class='w3-tiny'>
	   <td><strong>&nbsp;DID&nbsp;</td>
	   <td><strong>&nbsp;COMP&nbsp;</td>
	   <td><strong>DEPT</td>
	   <td><strong>ID</small></td>
	   <td><strong>NAME</td>
	   <td><strong>DATE</td>
	   <td><strong>AM IN</td>
	   <td><strong>AM OUT</td>
	   <td><strong>PM IN</td>
	   <td><strong>PM OUT</td>
	   <td><strong>OT IN</td>
	   <td><strong>OT OUT</td>
	   <td><strong>AM TOTAL</td>
	   <td><strong>PM TOTAL</td>
	   <td><strong>&nbsp;UNDER / OVER&nbsp;</td>
	   <td><strong>&nbsp;REG HRS TOTAL&nbsp;</td>
	   <td><strong>OT TOTAL</td>
	   <td><strong>&nbsp;DAY RATE&nbsp;</td>
	   <td><strong>&nbsp;DAY AMT&nbsp;</td>
	   <td><strong>&nbsp;OT AMT&nbsp;</td>
	  </tr>";

$date=$_REQUEST['edate'];
$sun1=date('Y-m-d', strtotime($date.'1 sunday ago'));
$sun2=date('Y-m-d', strtotime($date.'2 sunday ago'));
$sun3=date('Y-m-d', strtotime($date.'3 sunday ago'));
$sun4=date('Y-m-d', strtotime($date.'4 sunday ago'));
$rh1=$_REQUEST['rh1'];
$rh2=$_REQUEST['rh2'];
$rh3=$_REQUEST['rh3'];
$rh4=$_REQUEST['rh4'];
$sh1=$_REQUEST['sh1'];
$sh2=$_REQUEST['sh2'];
$sh3=$_REQUEST['sh3'];
$sh4=$_REQUEST['sh4'];	

$clear_dtr_amount="update dtr_log set reg_day_time=0,
									  reg_day_amount=0,
									  reg_day_ot_time=0,
									  reg_day_ot_amount=0,
									  reg_hol_time=0,
									  reg_hol_amount=0,
									  reg_hol_ot_time=0,
									  reg_hol_ot_amount=0,
									  spe_hol_time=0,
									  spe_hol_amount=0,
									  spe_hol_ot_time=0,
									  spe_hol_ot_amount=0,
									  restday_time=0,
									  restday_amount=0,
									  restday_ot_time=0,
									  restday_ot_amount=0
									  where date>='$sdate' and date<='$edate'";
//echo "$clear_dtr_amount";
mysql_query($clear_dtr_amount) or die(mysql_error());
			
	  
do{	    
      
       //sunday dayoff		
		if($r['date']==$sun1 || $r['date']==$sun2 || $r['date']==$sun3 || $r['date']==$sun4)	
		{ echo "<tr class='w3-pale-red w3-hover-blue' align='center'>"; }
	   
	   //regular holiday
		elseif($r['date']==$rh1 || $r['date']==$rh2 || $r['date']==$rh3 || $r['date']==$rh4)
		{ echo "<tr class='w3-pale-yellow w3-hover-blue' align='center'>"; }
		 
	   //special holiday
		elseif($r['date']==$sh1 || $r['date']==$sh2 || $r['date']==$sh3 || $r['date']==$sh4)
		{ echo "<tr class='w3-pale-green w3-hover-blue' align='center'>"; }
	   
	    //regular day
		else{ echo "<tr align='center' class='w3-hover-blue'>";}	     

    echo "<td><small>".$r['data_id']."</td>
	<td><small>".$r['company']."</td>
	<td class='w3-small'>&nbsp;".$r['dept']."&nbsp;</td>
	<td><small>".$r['e_no']."</td>
	<td><small>&nbsp;<a href='script_dtr_monitor.php?rh1=$rh1&rh2=$rh2&rh3=$rh3&rh4=$rh4&sh1=$sh1&sh2=$sh2&sh3=$sh3&sh4=$sh4&payroll_period=$payroll_period&sdate=$sdate&edate=$edate&search=$search&data_id=".$r['data_id']."&e_no=".$r['e_no']."'>".$r['name']."</a>&nbsp;</td>
	<td>";
    
	if($r['date']==$sun1 || $r['date']==$sun2 || $r['date']==$sun3 || $r['date']==$sun4)
	{ echo "<span class='w3-text-red w3-tiny'>Sunday</span><br>"; }
	
	if($r['date']==$rh1 || $r['date']==$rh2 || $r['date']==$rh3 || $r['date']==$rh4)
	{ echo "<span class='w3-tiny w3-text-orange'>Regular Holiday</span><br>"; }		
	
	if($r['date']==$sh1 || $r['date']==$sh2 || $r['date']==$sh3 || $r['date']==$sh4)
	{ echo "<span class='w3-tiny w3-text-green'>Special Holiday</span><br>"; }		
	
	echo "&nbsp;<span class='w3-small'><strong>".date('m-d-Y',strtotime($r['date']))."</strong></span>&nbsp;";

	//note: results are in seconds
	// to get minutes divide to 60
	// to get hours divide to 3600
	
	//AM total
	$amin=date_create($r['amin']);
    $amout=date_create($r['amout']);
    $amtotal=date_diff($amin,$amout);
    $am=$amtotal->format('%h:%i');//hours computation
	
	$amx=$amtotal->format("%h");
	$amy=$amtotal->format("%i");
	$amz=$amx*60+$amy;//minutes computation
	
	//PM total
	$pmin=date_create($r['pmin']);
    $pmout=date_create($r['pmout']);
    $pmtotal=date_diff($pmin,$pmout);
    $pm=$pmtotal->format('%h:%i');//hours computation
	
	$pmx=$pmtotal->format("%h");
	$pmy=$pmtotal->format("%i");
	$pmz=$pmx*60+$pmy;//minutes computation			
	
	//OT total
	$otin=date_create($r['otin']);
    $otout=date_create($r['otout']);
    $ottotal=date_diff($otin,$otout);
    $ot=$ottotal->format('%h:%i');//hours computation
		
	$otx=$ottotal->format("%h");
	$oty=$ottotal->format("%i");
	$otz=$otx*60+$oty;//minutes computation
	
	$totaltime=$amz+$pmz;
	$totaltimex=date('H:i', mktime(0,$totaltime));
	
	//over or under 8 hours
	$totalampm=$totaltime-480;
	$totalampmx=date('H:i', mktime(0,$totalampm));

	echo "</td>
	<td>&nbsp;<small>".$r['amin']."</small>&nbsp;</td>
	<td>&nbsp;<small>".$r['amout']."</small>&nbsp;</td>
	<td>&nbsp;<small>".$r['pmin']."</small>&nbsp;</td>
	<td>&nbsp;<small>".$r['pmout']."</small>&nbsp;</td>
	<td>&nbsp;<small>".$r['otin']."</small>&nbsp;</td>
	<td>&nbsp;<small>".$r['otout']."</small>&nbsp;</td>";
	
	echo "<td width='80' class='w3-text-blue w3-small'><strong class='text-success'>$am hr</strong> or<br><strong class='text-danger'>$amz mins</strong></td>
	      <td width='80' class='w3-text-blue w3-small'><strong class='text-success'>$pm hr</strong> or<br><strong class='text-danger'>$pmz mins</strong></td>";
	
	if($totaltime!=0) { echo "<td class='w3-text-blue w3-small'>
	                            <strong class='text-success'>$totalampmx hr</strong> or<br> 
								<strong class='text-danger'>$totalampm mins</strong>
							  </td>
							  
							  <td class='w3-text-blue w3-small'>
							    <strong class='text-success'>$totaltimex hr</strong> or<br> 
								<strong class='text-danger'>$totaltime mins</strong>
							  </td>"; }
	              else{ echo "<td><small></small></td><td><small></small></td>"; }
	
	echo "<td width='80' class='w3-text-blue w3-small'><strong class='text-success'>$ot</strong> or<br><strong class='text-danger'>$otz mins</strong></td>";

	
	$e_no=$r['e_no'];
    $sxx="select e_basic_pay from employee where e_no=$e_no ";
	$qxx=mysql_query($sxx) or die(mysql_error());
	$rxx=mysql_fetch_assoc($qxx);
	
	$day_rate=$rxx['e_basic_pay']/26;
    $hour_rate=$rxx['e_basic_pay']/26/8;
	
    echo "<td><small>&nbsp;".number_format($day_rate,2)."&nbsp;</small></td>";	
       
	   //total time +10 mins grace period
	   if($totaltime>=470)
	        { $totaltime1=480/60; 
		      $totaltime2=480; }
			  
	   else { $totaltime1=$totaltime/60; 
	          $totaltime2=$totaltime; }
	   
	   $data_id=$r['data_id'];
	   //sunday dayoff		
		if($r['date']==$sun1 || $r['date']==$sun2 || $r['date']==$sun3 || $r['date']==$sun4)	
		{ 
		    $dop_amount=round($hour_rate*$totaltime1*1.3,2);
			$dop_amount_ot=round($hour_rate*$otz/60*1.3*1.3,2);
			echo "<td class='w3-small w3-text-red'><strong>".number_format($dop_amount,2)."</strong></td>";
			echo "<td class='w3-small w3-text-red'><strong>".number_format($dop_amount_ot,2)."</strong></td>";
			
			$sx1="update dtr_log set restday_time=$totaltime2,
			                         restday_amount=$dop_amount,
									 restday_ot_time=$otz,
									 restday_ot_amount=$dop_amount_ot 
									 where data_id=$data_id";
		    $qx1=mysql_query($sx1) or die(mysql_error());
			
		}
	   
	   //regular holiday
		elseif($r['date']==$rh1 || $r['date']==$rh2 || $r['date']==$rh3 || $r['date']==$rh4)
		{
			$rh_amount=round($hour_rate*$totaltime1*2,2);
			$rh_amount_ot=round($hour_rate*$otz/60*2.6,2);
			echo "<td class='w3-small w3-text-orange'><strong>".number_format($rh_amount,2)."</strong></td>";
			echo "<td class='w3-small w3-text-orange'><strong>".number_format($rh_amount_ot,2)."</strong></td>";
			
			$sx1="update dtr_log set reg_hol_time=$totaltime2,
			                         reg_hol_amount=$rh_amount,
									 reg_hol_ot_time=$otz,
									 reg_hol_ot_amount=$rh_amount_ot 
									 where data_id=$data_id";
		    $qx1=mysql_query($sx1) or die(mysql_error());
		}
	   
	    //special holiday
		elseif($r['date']==$sh1 || $r['date']==$sh2 || $r['date']==$sh3 || $r['date']==$sh4)
		{
			$sh_amount=round($hour_rate*$totaltime1*1.3,2);
			$sh_amount_ot=round($hour_rate*$otz/60*1.69,2);
			echo "<td class='w3-small w3-text-green'><strong>".number_format($sh_amount,2)."</strong></td>";
			echo "<td class='w3-small w3-text-green'><strong>".number_format($sh_amount_ot,2)."</strong></td>";
			
			$sx1="update dtr_log set spe_hol_time=$totaltime2,
			                         spe_hol_amount=$sh_amount,
									 spe_hol_ot_time=$otz,
									 spe_hol_ot_amount=$sh_amount_ot 
									 where data_id=$data_id";
		    $qx1=mysql_query($sx1) or die(mysql_error());
		}
	   
	    //regular day
		else
	    {   
			$day_earning=round($totaltime1*$hour_rate,2);
			$ot_amount=round($hour_rate*$otz/60*1.25,2);    
			echo "<td><small><strong>".number_format($day_earning,2)."</strong></small></td>";
			echo "<td><small><strong>".number_format($ot_amount,2)."</strong></small></td>";	

			$sx1="update dtr_log set reg_day_time=$totaltime2,
			                         reg_day_amount=$day_earning,
									 reg_day_ot_time=$otz,
									 reg_day_ot_amount=$ot_amount 
									 where data_id=$data_id";
		    $qx1=mysql_query($sx1) or die(mysql_error());
		}	        
		
echo "</tr>";

}while($r=mysql_fetch_assoc($q));

if(isset($_REQUEST['finalize']))
{
	//---logs entry---
		$username=$_SESSION['username'];
		$trans="e_total_cuttoff_hours added to $e_no on $payroll_period cutoff";
		$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
		$log_query=mysql_query($log_sql) or die(mysql_error());
		
echo "<div align='center'><strong class='w3-text-green'>FINALIZE COMPLETE!</strong> You can now <span class='w3-text-red'>CLOSE THIS WINDOW</span> and proceed to <span class='w3-text-red'>WORK HOURS ENTRY</span> for review.</div><br>";
}          

echo "</table>"; 

?>
</body>