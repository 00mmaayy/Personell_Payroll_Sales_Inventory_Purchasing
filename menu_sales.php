<!--Sales Start-------->
<?php if(isset($_REQUEST['sales'])) { ?>   
	<div class="w3-col">
      <div class="w3-container w3-blue w3-padding-15">
        <div class="w3-left w3-xlarge"><i class="fa fa-calculator w3-xlarge"></i>  Sales</div>
      </div>
	  <br>
	  <div class="container">
         <ul class="nav nav-tabs">
          <?php if($access['d2']==1){ ?><li class="active"><a href="sales_main.php">Sales</a></li><?php } ?>
          </ul>
      </div>
	</div>  
<?php } ?>
<!--Sales End------------>