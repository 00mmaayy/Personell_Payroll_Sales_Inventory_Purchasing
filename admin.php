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
<body style='background:#f2f2f2'>

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
   <?php echo $r8['pos_description']; ?>
	</span>
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

<?php include('menu_home.php'); ?>
  
<?php include('menu_payroll.php'); ?>
  
<?php include('menu_personnel.php'); ?>

<?php include('menu_inventory.php'); ?>

<?php include('menu_or_monitoring.php'); ?>

<?php include('menu_sales.php'); ?>

<?php include('menu_settings.php'); ?>
		
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
