<?php
include('connection/conn.php');
session_start();
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); }
date_default_timezone_set("Asia/Manila");
$s="select * from company";
$q=mysql_query($s) or die(mysql_error());
$r=mysql_fetch_assoc($q);
?>
<!DOCTYPE html>
<html>
<title><?php echo $r['company_name']; ?></title>

<?php include("css.php"); ?>

<body class="w3-light-grey">

<!-- Top container ----->
<div class="w3-container w3-top w3-green w3-large w3-padding" style="z-index:4">
  <button class="w3-button w3-hide-large w3-padding-0 w3-green w3-hover-none w3-hover-text-light-grey" onclick="w3_open();"><i class="fa fa-bars"></i>  Menu</button>
<span class="w3-right"><?php echo $r['company_name']; ?></span>
</div>
<!-- Top container ----->

<!-- Sidenav/menu -->

<?php include("current_user.php"); ?>

<nav class="w3-sidenav w3-collapse w3-white w3-animate-left" style="z-index:3;width:300px;" id="mySidenav">
  <br/>
  <div class="w3-container w3-row">
    <div class="w3-col s4">
	<img src="img/id/<?php echo $r91['e_no']; ?>.jpg" class="w3-circle" style="width:80%">
	</div>
    <div class="w3-col s8 w3-bar">
	<span class="text-primary">Current User:</span><br>
   <span class="text-primary"><strong><?php echo $r9['first_name']." ".$r9['last_name'];?></strong><br>
   <?php echo $r8['pos_description'];?></span>
     </div>
	</div>
<hr>
  
<?php include("menu.php"); ?>

</nav>

<!-- Overlay effect when opening sidenav on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="mySidenav"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-top:35px;">

  <!-- Header -->
  <header class="w3-container" style="padding-top:22px"></header>
  <div class="w3-row-padding w3-margin-bottom">

<!--Inventory Start-------->
<?php if(isset($_REQUEST['inventory'])) { ?>   
	<div class="w3-col">
      <div class="w3-container w3-blue w3-padding-15">
        <div class="w3-left w3-xlarge"><i class="fa fa-shopping-basket w3-xlarge"></i>  Inventory</div>
      </div>
	  <br>
	  <div class="container">
		<a class='btn btn-danger w3-small' href="inv_po_monitor.php" target='_blank'>PO Monitor</a>&nbsp;&nbsp;&nbsp;
        <a class='btn btn-primary w3-small' href="inv_warehouse.php" target='_blank'>Storage Facilities</a>&nbsp;&nbsp;&nbsp;
		<a class='btn btn-primary w3-small' href="inv_settings.php" target='_blank'>Inventory Settings</a>&nbsp;&nbsp;&nbsp;
		<a class='btn btn-primary w3-small' href="inv_mr.php" target='_blank'>Memo Reciept / Assets</a>
      </br></br>
	  
	  <table class="w3-table w3-border">
		<tr><td>DATE/TIME</td><td>WITHDRAWAL NUMBER</td><td>MATERIAL WITHDRAWAL NUMBER / DATE</td></tr>
		<?php 
			$ss1="SELECT datetime,withdrawal_number,withdrawal_slip_no,withdrawal_slip_date FROM inv_storage_out GROUP BY withdrawal_number order by transact_id DESC limit 10";
			$qq1=mysql_query($ss1)  or die(mysql_error());
			$rr1=mysql_fetch_assoc($qq1);
			$x=1;
			do{
				echo "<tr>
						<td>".date('F d, Y h:i A',strtotime($rr1['datetime']))."</td>
						<td><a href='inv_release_reciept_reprint.php?withdrawal_number=".$rr1['withdrawal_number']."' target='_blank'>".$rr1['withdrawal_number']."</a></td>
						<td>".$rr1['withdrawal_slip_no']." / ".date('F d, Y',strtotime($rr1['withdrawal_slip_date']))."</td>
					  </tr>";
			}while($rr1=mysql_fetch_assoc($qq1));
		?>
	  </table>
	  </br>
	  
	  <table class="w3-table w3-border">
		<tr><td>DATE/TIME</td><td>TRANSACTION</td><td>TRANSACT BY</td></tr>
		<?php 
			$ss="SELECT * FROM inv_logbook order by id DESC limit 10";
			$qq=mysql_query($ss)  or die(mysql_error());
			$rr=mysql_fetch_assoc($qq);
			$x=1;
			do{
				echo "<tr><td>".date('F d, Y h:i A',strtotime($rr['datetime']))."</td><td>".$rr['transaction']."</td><td>".$rr['transact_by']."</td></tr>";
			}while($rr=mysql_fetch_assoc($qq));
		?>
	  </table>
	  
	  
	  </div>

<?php } ?>
<!--Inventory End-------->

 </div>

</div>
</body>
</html>

<script>
// Get the Sidenav
var mySidenav = document.getElementById("mySidenav");

// Get the DIV with overlay effect
var overlayBg = document.getElementById("myOverlay");

// Toggle between showing and hiding the sidenav, and add overlay effect
function w3_open() {
    if (mySidenav.style.display === 'block') {
        mySidenav.style.display = 'none';
        overlayBg.style.display = "none";
    } else {
        mySidenav.style.display = 'block';
        overlayBg.style.display = "block";
    }
}

// Close the sidenav with the close button
function w3_close() {
    mySidenav.style.display = "none";
    overlayBg.style.display = "none";
}
</script>  
