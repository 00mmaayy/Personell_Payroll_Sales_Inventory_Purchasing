<?php 
include('connection/conn.php');
date_default_timezone_set("Asia/Manila");
?>

<!DOCTYPE html>
<html>
<title>DTR</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/w3.css">
<link rel="stylesheet" href="css/font-awesome.min.css">
<link rel="stylesheet" href="css/bootstrap.min.css">

<script src="css/jquery.min.js"></script>


<style>
html,body,h1,h2,h3,h4,h5 {font-family: "Century Gothic", sans-serif}
/* latin-ext */
@font-face {
  font-family: 'Century Gothic';
  font-style: normal;
  font-weight: 100;
  src: local('Raleway'), local('Raleway-Regular'), url(fonts/fontawesome-webfont.woff2) format('woff2');
  unicode-range: U+0100-024F, U+1E00-1EFF, U+20A0-20AB, U+20AD-20CF, U+2C60-2C7F, U+A720-A7FF;
}
/* latin */
@font-face {
  font-family: 'Century Gothic';
  font-style: normal;
  font-weight: 100;
  src: local('Raleway'), local('Raleway-Regular'), url(fonts/fontawesome-webfont.woff2) format('woff2');
  unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2212, U+2215;
}
header{
	background-color: #C6CAC8;
}
.btn {
  padding: 1% 1%;
  font-size: 130%;
  font-style: normal;
  text-align: center;
  cursor: pointer;
  outline: none;
  color: #fff;
  border: none;
  border-radius: 15px;
  box-shadow: 0 2px 2px #6D6D6A;
  width: 10%;
  margin: 0 7px;
  height: 100%;
}
.text {
  padding: 0% 0%;
  font-size: 130%;
  font-style: normal;
  text-align: center;
  outline: none;
  color: #444444;
  background-color: #EAEDED;
  border: none;
  border-radius: 12px;
  box-shadow: 0px 0px 0px 0px #444;
  width: 20%;
  margin: 0 5px;
  height: 45px;
}
.submit {
  padding: 1% 0%;
  font-size: 130%;
  font-style: normal;
  text-align: center;
  cursor: pointer;
  outline: none;
  color: #fff;
  border: none;
  border-radius: 12px;
  box-shadow: 0 2px 2px #444;
  width: 10%;
  margin: 0 7px;
  height: 100%;
}

.submit:active{
    background:#9B0303;
}
h1{
	
  font-family: 'Century Gothic;
  font-style: normal;
	font-size:65px;
}


</style>

<body class="w3-white" onload="updateClock(); setInterval('updateClock()', 1000 )">

<!-- Top container -->
<div class="w3-bar w3-top w3-white w3-medium" style="z-index:1" >
	<span class="w3-bar-item"></span>
	<span class="w3-bar-item"></span>
	<span class="w3-bar-item"></span>

</div>
<header class="w3-container w3-theme" id="myHeader"> 
  <div class="w3-center">
	<h1><strong><div  id="clock"></div></strong></h1> 
	<h2><div  id="date"><?php $today = date("l, F j, Y"); echo $today;?></div></h2>
  </div>
</header>

<br />
<form method="get">
<?php
if(isset($_REQUEST['amin'])){ $btncolor1="btn-danger"; }else{ $btncolor1="btn-success"; } 
if(isset($_REQUEST['amout'])){ $btncolor2="btn-danger"; }else{ $btncolor2="btn-success"; } 
if(isset($_REQUEST['pmin'])){ $btncolor3="btn-danger"; }else{ $btncolor3="btn-success"; } 
if(isset($_REQUEST['pmout'])){ $btncolor4="btn-danger"; }else{ $btncolor4="btn-success"; } 
if(isset($_REQUEST['otin'])){ $btncolor5="btn-danger"; }else{ $btncolor5="btn-success"; } 
if(isset($_REQUEST['otout'])){ $btncolor6="btn-danger"; }else{ $btncolor6="btn-success"; } 
?>

<div class="w3-" align="center">

	<button class="btn <?php echo $btncolor1; ?>" name="amin" id="amin" value="AMIN">AM IN</button>
	<button class="btn <?php echo $btncolor2; ?>" name="amout" id="amout" value="AMOUT">AM OUT</button>
	<button class="btn <?php echo $btncolor3; ?>" name="pmin" id="pmin" value="PMIN">PM IN</button>
	<button class="btn <?php echo $btncolor4; ?>" name="pmout" id="pmout" value="PMOUT">PM OUT</button>
	<button class="btn <?php echo $btncolor5; ?>" name="otin" id="otin" value="OTIN">OT IN</button>
	<button class="btn <?php echo $btncolor6; ?>" name="otout" id="otout" value="OTOUT">OT OUT</button>
<br /><br />
</form>
<form method="POST" >
	<?php if(isset($_REQUEST['amin'])){ echo "<input type='text' name='scanto' class='text' value=".$_REQUEST['amin'];} ?>	
	<?php if(isset($_REQUEST['amout'])){ echo "<input type='text' name='scanto' class='text' value=".$_REQUEST['amout'];} ?>
	<?php if(isset($_REQUEST['pmin'])){ echo "<input type='text' name='scanto' class='text' value=".$_REQUEST['pmin'];} ?>
	<?php if(isset($_REQUEST['pmout'])){ echo "<input type='text' name='scanto' class='text' value=".$_REQUEST['pmout'];} ?>
	<?php if(isset($_REQUEST['otin'])){ echo "<input type='text' name='scanto' class='text' value=".$_REQUEST['otin'];} ?>
	<?php if(isset($_REQUEST['otout'])){ echo "<input type='text' name='scanto' class='text' value=".$_REQUEST['otout'];} ?>
	<input type="text" name="scanto" class="text" readonly>
	<input type="text" id="idnumber" name="idnumber" class="text">
	<br /><br />
	<button type="submit" name="submit" class="btn btn-warning">SUBMIT</button>
	<br /><br />
</form>		

	<?php
if (isset($_POST['submit'])) 
	{

			$date=date('Y-m-d');
			$time=date('H:i:s');	

			$idnumber=$_POST['idnumber'];
			$scanto=$_POST['scanto'];
			
		$sql1="SELECT * FROM employee WHERE e_no='$idnumber'";
		$result1=mysql_query($sql1) or die(mysql_error());
		$row1=mysql_fetch_assoc($result1);
		
		
		$sql2="SELECT * FROM dtr_log WHERE e_no='$idnumber' and date='$date' and scanto='$scanto'";
		$result2=mysql_query($sql2) or die(mysql_error());
		$row2=mysql_fetch_assoc($result2);
		
		$sql3="SELECT * FROM dtr_log WHERE e_no='$idnumber' and date='$date' and scanto='AMOUT'";
		$result3=mysql_query($sql3) or die(mysql_error());
		$row3=mysql_fetch_assoc($result3);
		
		$sql4="SELECT * FROM dtr_log WHERE e_no='$idnumber' and date='$date' and scanto='PMOUT'";
		$result4=mysql_query($sql4) or die(mysql_error());
		$row4=mysql_fetch_assoc($result4);
		
		$sql5="SELECT * FROM dtr_log WHERE e_no='$idnumber' and date='$date' and scanto='PMIN'";
		$result5=mysql_query($sql5) or die(mysql_error());
		$row5=mysql_fetch_assoc($result5);
		
		$sql6="SELECT * FROM dtr_log WHERE e_no='$idnumber' and date='$date' and scanto='AMIN'";
		$result6=mysql_query($sql6) or die(mysql_error());
		$row6=mysql_fetch_assoc($result6);
		
			if($idnumber!=$row1['e_no'] || $scanto=="" && $idnumber=="" || $scanto=="" || $idnumber=="")
			{
				echo "<div class='w3-container w3-panel w3-red' id='ex'><h4><strong>ERROR!</strong> Scan failed.No selected button or Unknown ID Number.<h4></div>";
			}
			elseif($idnumber==$row1['e_no'])
			{
				//AM IN
				if($scanto=="AMIN")
					{
						if($row2['scanto']=="AMIN")
						{
							echo "<div class='w3-container w3-panel w3-red' id='ex'><h4><strong>You are already log.<strong><h4></div>";
						}
						elseif($row3['scanto']=="AMOUT")
						{
							echo "<div class='w3-container w3-panel w3-red' id='ex'><h4><strong>AM IN Failed, AM OUT has been recorded.<strong><h4></div>";
						}
						elseif($row4['scanto']=="PMOUT")
						{
							echo "<div class='w3-container w3-panel w3-red' id='ex'><h4><strong>AM IN Failed, PM OUT has been recorded.<strong><h4></div>";
						}
						elseif($row5['scanto']=="PMIN")
						{
							echo "<div class='w3-container w3-panel w3-red' id='ex'><h4><strong>PM IN Failed, PM IN has been recorded.<strong><h4></div>";
						}
						else
						{
							
						$sql4="INSERT INTO dtr_log (date, e_no, time, scanto) VALUES ('$date', '$idnumber', '$time', '$scanto')";
						$result4= mysql_query($sql4) or die(mysql_error());
						echo "<div id='ex'><div class='w3-container w3-panel w3-yellow' >
						<h4><strong>Successfully Logged!</strong><h4>
						</div>";
						
						//followed by the info of the employee
						$sql5="SELECT * FROM employee WHERE e_no='$idnumber'";
						$result5= mysql_query($sql5) or die(mysql_error());
						$row5=mysql_fetch_assoc($result5);
						
						echo "<table width='35%' align='center'><tr><td>";
						echo "<div class='w3-container w3-light-grey w3-padding-16'>";
						echo "<div align='center'><img src=img/id/".$row5['e_no'].".jpg class='img-circle' width='100' height='100'></div.";
						?>		
						<div align="center"><h4><?php echo $row5['e_fname']."&nbsp;".$row5['e_lname']?></h4></div>		
						<?php			
							$sql6 = "select * from dtr_log where e_no='$idnumber' and date='$date'";
							$result6 = mysql_query($sql6);
							if (!$result6)
							{	echo "Could not successfully run query ($sql6) from DB: " . mysql_error();
								exit;
							}
							if (mysql_num_rows($result6) == 0) { }
						?>
							<table width="15%" align="center">
							<?php while ($row6 = mysql_fetch_assoc($result6)) { ?>
							<tr><td align="right"><?php echo $row6['scanto']?>&nbsp;&nbsp;</td>
							<td align="left">&nbsp;<?php echo $row6['time'] ?></td></tr>							
							<?php }
							echo "</div></td></tr></table></div>";
						}
					}
					//AM OUT
				if($scanto=="AMOUT")
					{
						if($row2['scanto']=='AMOUT')
						{
							echo "<div class='w3-container w3-panel w3-red' id='ex'><h4><strong>You are already log.<strong><h4></div>";
						}
						elseif($row4['scanto']=="PMOUT")
						{
							echo "<div class='w3-container w3-panel w3-red' id='ex'><h4><strong>AM OUT Failed, PM OUT has been recorded.<strong><h4></div>";
						}
						elseif($row5['scanto']=="PMIN")
						{
							echo "<div class='w3-container w3-panel w3-red' id='ex'><h4><strong>AM OUT Failed, PM IN has been recorded.<strong><h4></div>";
						}
						elseif($row6['scanto']=="AMIN")
						{
							$sql1="INSERT INTO dtr_log (date, e_no, time, scanto) VALUES ('$date', '$idnumber', '$time', '$scanto')";
							$result1= mysql_query($sql1) or die(mysql_error());
							
							echo "<div class='w3-container w3-panel w3-yellow' id='ex'><h4><strong>Successfully Logged!<strong><h4></div>";
							
							//followed by the info of the employee
							$sql5="SELECT * FROM employee WHERE e_no='$idnumber'";
							$result5= mysql_query($sql5) or die(mysql_error());
							$row5=mysql_fetch_assoc($result5);
							
							echo "<table width='35%' align='center'><tr><td>";
							echo "<div class='w3-container w3-light-grey w3-padding-16'>";
							echo "<div align='center'><img src=img/id/".$row5['e_no'].".jpg class='img-circle' width='100' height='100'></div.";
							?>		
							<div align="center"><h4><?php echo $row5['e_fname']."&nbsp;".$row5['e_lname']?></h4></div>		
							<?php			
								$sql6 = "select * from dtr_log where e_no='$idnumber' and date='$date'";
								$result6 = mysql_query($sql6);
								if (!$result6)
								{	echo "Could not successfully run query ($sql6) from DB: " . mysql_error();
									exit;
								}
								if (mysql_num_rows($result6) == 0) { }
							?>
								<table width="15%" align="center">
								<?php while ($row6 = mysql_fetch_assoc($result6)) { ?>
								<tr><td align="right"><?php echo $row6['scanto']?>&nbsp;&nbsp;</td>
								<td align="left">&nbsp;<?php echo $row6['time'] ?></td></tr>							
								<?php }
								echo "</div></td></tr></table></div>";
						}
						else
						{
							$sql="INSERT INTO dtr_log (date, e_no, time, scanto) VALUES ('$date', '$idnumber', '', 'AMIN')";
							$result= mysql_query($sql) or die(mysql_error());
							
							$sql="INSERT INTO dtr_log (date, e_no, time, scanto) VALUES ('$date', '$idnumber', '$time', '$scanto')";
							$result= mysql_query($sql) or die(mysql_error());
							echo "<div id='ex'><div class='w3-container w3-panel w3-yellow' >
							<h4><strong>Successfully Logged!</strong><h4>
							</div>";
							
							//followed by the info of the employee
							$sql5="SELECT * FROM employee WHERE e_no='$idnumber'";
							$result5= mysql_query($sql5) or die(mysql_error());
							$row5=mysql_fetch_assoc($result5);
							
							echo "<table width='35%' align='center'><tr><td>";
							echo "<div class='w3-container w3-light-grey w3-padding-16'>";
							echo "<div align='center'><img src=img/id/".$row5['e_no'].".jpg class='img-circle' width='100' height='100'></div.";
							?>		
							<div align="center"><h4><?php echo $row5['e_fname']."&nbsp;".$row5['e_lname']?></h4></div>		
							<?php			
								$sql6 = "select * from dtr_log where e_no='$idnumber' and date='$date'";
								$result6 = mysql_query($sql6);
								if (!$result6)
								{	echo "Could not successfully run query ($sql6) from DB: " . mysql_error();
									exit;
								}
								if (mysql_num_rows($result6) == 0) { }
							?>
								<table width="15%" align="center">
								<?php while ($row6 = mysql_fetch_assoc($result6)) { ?>
								<tr><td align="right"><?php echo $row6['scanto']?>&nbsp;&nbsp;</td>
								<td align="left">&nbsp;<?php echo $row6['time'] ?></td></tr>							
								<?php }
								echo "</div></td></tr></table></div>";
						}
					}
					//PM IN
				if($scanto=="PMIN")
					{
						if($row2['scanto']=="PMIN")
						{
							echo "<div class='w3-container w3-panel w3-red' id='ex'><h4><strong>You are already log.<strong><h4></div>";
						}
						elseif($row4['scanto']=="PMOUT")
						{
							echo "<div class='w3-container w3-panel w3-red' id='ex'><h4><strong>PM IN Failed, PM OUT has been recorded.<strong><h4></div>";
						}
						else
						{
							
						$sql4="INSERT INTO dtr_log (date, e_no, time, scanto) VALUES ('$date', '$idnumber', '$time', '$scanto')";
						$result4= mysql_query($sql4) or die(mysql_error());
						echo "<div id='ex'><div class='w3-container w3-panel w3-yellow' >
						<h4><strong>Successfully Logged!</strong><h4>
						</div>";
						
						//followed by the info of the employee
						$sql5="SELECT * FROM employee WHERE e_no='$idnumber'";
						$result5= mysql_query($sql5) or die(mysql_error());
						$row5=mysql_fetch_assoc($result5);
						
						echo "<table width='35%' align='center'><tr><td>";
						echo "<div class='w3-container w3-light-grey w3-padding-16'>";
						echo "<div align='center'><img src=img/id/".$row5['e_no'].".jpg class='img-circle' width='100' height='100'></div.";
						?>		
						<div align="center"><h4><?php echo $row5['e_fname']."&nbsp;".$row5['e_lname']?></h4></div>		
						<?php			
							$sql6 = "select * from dtr_log where e_no='$idnumber' and date='$date'";
							$result6 = mysql_query($sql6);
							if (!$result6)
							{	echo "Could not successfully run query ($sql6) from DB: " . mysql_error();
								exit;
							}
							if (mysql_num_rows($result6) == 0) { }
						?>
							<table width="15%" align="center">
							<?php while ($row6 = mysql_fetch_assoc($result6)) { ?>
							<tr><td align="right"><?php echo $row6['scanto']?>&nbsp;&nbsp;</td>
							<td align="left">&nbsp;<?php echo $row6['time'] ?></td></tr>							
							<?php }
							echo "</div></td></tr></table></div>";
						}
					}
					//PM OUT
				if($scanto=="PMOUT")
					{
						if($row2['scanto']=='PMOUT')
						{
							echo "<div class='w3-container w3-panel w3-red' id='ex'><h4><strong>You are already log.<strong><h4></div>";
						}
						elseif($row5['scanto']=="PMIN")
						{
							$sql="INSERT INTO dtr_log (date, e_no, time, scanto) VALUES ('$date', '$idnumber', '$time', '$scanto')";
							$result= mysql_query($sql) or die(mysql_error());
							echo "<div id='ex'><div class='w3-container w3-panel w3-yellow' >
							<h4><strong>Successfully Logged!</strong><h4>
							</div>";
							
							//followed by the info of the employee
							$sql5="SELECT * FROM employee WHERE e_no='$idnumber'";
							$result5= mysql_query($sql5) or die(mysql_error());
							$row5=mysql_fetch_assoc($result5);
							
							echo "<table width='35%' align='center'><tr><td>";
							echo "<div class='w3-container w3-light-grey w3-padding-16'>";
							echo "<div align='center'><img src=img/id/".$row5['e_no'].".jpg class='img-circle' width='100' height='100'></div.";
							?>		
							<div align="center"><h4><?php echo $row5['e_fname']."&nbsp;".$row5['e_lname']?></h4></div>		
							<?php			
								$sql6 = "select * from dtr_log where e_no='$idnumber' and date='$date'";
								$result6 = mysql_query($sql6);
								if (!$result6)
								{	echo "Could not successfully run query ($sql6) from DB: " . mysql_error();
									exit;
								}
								if (mysql_num_rows($result6) == 0) { }
							?>
								<table width="15%" align="center">
								<?php while ($row6 = mysql_fetch_assoc($result6)) { ?>
								<tr><td align="right"><?php echo $row6['scanto']?>&nbsp;&nbsp;</td>
								<td align="left">&nbsp;<?php echo $row6['time'] ?></td></tr>							
								<?php }
								echo "</div></td></tr></table></div>";
						}
						else
						{
							$sql="INSERT INTO dtr_log (date, e_no, time, scanto) VALUES ('$date', '$idnumber', '', 'PMIN')";
							$result= mysql_query($sql) or die(mysql_error());
							
							$sql="INSERT INTO dtr_log (date, e_no, time, scanto) VALUES ('$date', '$idnumber', '$time', '$scanto')";
							$result= mysql_query($sql) or die(mysql_error());
							echo "<div id='ex'><div class='w3-container w3-panel w3-yellow' >
							<h4><strong>Successfully Logged!</strong><h4>
							</div>";
							
							//followed by the info of the employee
							$sql5="SELECT * FROM employee WHERE e_no='$idnumber'";
							$result5= mysql_query($sql5) or die(mysql_error());
							$row5=mysql_fetch_assoc($result5);
							
							echo "<table width='35%' align='center'><tr><td>";
							echo "<div class='w3-container w3-light-grey w3-padding-16'>";
							echo "<div align='center'><img src=img/id/".$row5['e_no'].".jpg class='img-circle' width='100' height='100'></div.";
							?>		
							<div align="center"><h4><?php echo $row5['e_fname']."&nbsp;".$row5['e_lname']?></h4></div>		
							<?php			
								$sql6 = "select * from dtr_log where e_no='$idnumber' and date='$date'";
								$result6 = mysql_query($sql6);
								if (!$result6)
								{	echo "Could not successfully run query ($sql6) from DB: " . mysql_error();
									exit;
								}
								if (mysql_num_rows($result6) == 0) { }
							?>
								<table width="15%" align="center">
								<?php while ($row6 = mysql_fetch_assoc($result6)) { ?>
								<tr><td align="right"><?php echo $row6['scanto']?>&nbsp;&nbsp;</td>
								<td align="left">&nbsp;<?php echo $row6['time'] ?></td></tr>							
								<?php }
								echo "</div></td></tr></table></div>";
						}
					}
					//OT IN
				if($scanto=="OTIN")
					{
						if($row2['scanto']=="OTIN")
						{
							echo "<div class='w3-container w3-panel w3-red' id='ex'><h4><strong>You are already log.<strong><h4></div>";
						}
						else
						{
							
						$sql4="INSERT INTO dtr_log (date, e_no, time, scanto) VALUES ('$date', '$idnumber', '$time', '$scanto')";
						$result4= mysql_query($sql4) or die(mysql_error());
						echo "<div id='ex'><div class='w3-container w3-panel w3-yellow' >
						<h4><strong>Successfully Logged!</strong><h4>
						</div>";
						
						//followed by the info of the employee
						$sql5="SELECT * FROM employee WHERE e_no='$idnumber'";
						$result5= mysql_query($sql5) or die(mysql_error());
						$row5=mysql_fetch_assoc($result5);
						
						echo "<table width='35%' align='center'><tr><td>";
						echo "<div class='w3-container w3-light-grey w3-padding-16'>";
						echo "<div align='center'><img src=img/id/".$row5['e_no'].".jpg class='img-circle' width='100' height='100'></div.";
						?>		
						<div align="center"><h4><?php echo $row5['e_fname']."&nbsp;".$row5['e_lname']?></h4></div>		
						<?php			
							$sql6 = "select * from dtr_log where e_no='$idnumber' and date='$date'";
							$result6 = mysql_query($sql6);
							if (!$result6)
							{	echo "Could not successfully run query ($sql6) from DB: " . mysql_error();
								exit;
							}
							if (mysql_num_rows($result6) == 0) { }
						?>
							<table width="15%" align="center">
							<?php while ($row6 = mysql_fetch_assoc($result6)) { ?>
							<tr><td align="right"><?php echo $row6['scanto']?>&nbsp;&nbsp;</td>
							<td align="left">&nbsp;<?php echo $row6['time'] ?></td></tr>							
							<?php }
							echo "</div></td></tr></table></div>";
						}
					}
					//OT OUT
				if($scanto=="OTOUT")
					{
						if($row2['scanto']=='OTOUT')
						{
							echo "<div class='w3-container w3-panel w3-red' id='ex'><h4><strong>You are already log.<strong><h4></div>";
						}
						else
						{
							$sql="INSERT INTO dtr_log (date, e_no, time, scanto) VALUES ('$date', '$idnumber', '$time', '$scanto')";
							$result= mysql_query($sql) or die(mysql_error());
							echo "<div id='ex'><div class='w3-container w3-panel w3-yellow' >
							<h4><strong>Successfully Logged!</strong><h4>
							</div>";
							
							//followed by the info of the employee
							$sql5="SELECT * FROM employee WHERE e_no='$idnumber'";
							$result5= mysql_query($sql5) or die(mysql_error());
							$row5=mysql_fetch_assoc($result5);
							
							echo "<table width='35%' align='center'><tr><td>";
							echo "<div class='w3-container w3-light-grey w3-padding-16'>";
							echo "<div align='center'><img src=img/id/".$row5['e_no'].".jpg class='img-circle' width='100' height='100'></div.";
							?>		
							<div align="center"><h4><?php echo $row5['e_fname']."&nbsp;".$row5['e_lname']?></h4></div>		
							<?php			
								$sql6 = "select * from dtr_log where e_no='$idnumber' and date='$date'";
								$result6 = mysql_query($sql6);
								if (!$result6)
								{	echo "Could not successfully run query ($sql6) from DB: " . mysql_error();
									exit;
								}
								if (mysql_num_rows($result6) == 0) { }
							?>
								<table width="15%" align="center">
								<?php while ($row6 = mysql_fetch_assoc($result6)) { ?>
								<tr><td align="right"><?php echo $row6['scanto']?>&nbsp;&nbsp;</td>
								<td align="left">&nbsp;<?php echo $row6['time'] ?></td></tr>							
								<?php }
								echo "</div></td></tr></table></div>";
						}
					}

//end of elseif	 				
			}
//end of if submit				
	}
				?>
				
				</table>


				
				</div>
				
			
				
				
				
				
<script>
$(document).ready(function(){
    $("button").click(function(){
        $("#ex").remove();
    });
});
</script>




<script>
<!--
function updateClock ( )
{
  var currentTime = new Date ( );

  var currentHours = currentTime.getHours ( );
  var currentMinutes = currentTime.getMinutes ( );
  var currentSeconds = currentTime.getSeconds ( );

  // Pad the minutes and seconds with leading zeros, if required
  currentMinutes = ( currentMinutes < 10 ? "0" : "" ) + currentMinutes;
  currentSeconds = ( currentSeconds < 10 ? "0" : "" ) + currentSeconds;

  // Choose either "AM" or "PM" as appropriate
  var timeOfDay = ( currentHours < 12 ) ? "AM" : "PM";

  // Convert the hours component to 12-hour format if needed
  currentHours = ( currentHours > 12 ) ? currentHours - 12 : currentHours;

  // Convert an hours component of "0" to "12"
  currentHours = ( currentHours == 0 ) ? 12 : currentHours;

  // Compose the string for display
  var currentTimeString = currentHours + ":" + currentMinutes + ":" + currentSeconds + " " + timeOfDay;

  // Update the time display
  document.getElementById("clock").innerHTML = currentTimeString;
}
// -->

</script>
</body>