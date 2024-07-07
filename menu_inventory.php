<!--Inventory Start-------->
<?php if(isset($_REQUEST['inventory'])) { ?>   
	<div class="w3-col">
      <div class="w3-container w3-blue w3-padding-15">
        <div class="w3-left w3-xlarge"><i class="fa fa-barcode w3-xlarge"></i>  Inventory</div>
      </div>
	  <br>
	  <div class="container">
         <ul class="nav nav-tabs">
          <?php if($access['c2']==1){ ?><li class="active"><a href="inv_main.php">Input Inventory Item</a></li><?php } ?>
          </ul>
      </div>
	</div>
<?php } ?>
<!--Inventory End-------->