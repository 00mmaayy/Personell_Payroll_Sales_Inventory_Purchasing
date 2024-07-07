<!--OR Monitoring Start-------->
<?php if(isset($_REQUEST['or'])) { ?>   
	<div class="w3-col">
      <div class="w3-container w3-blue w3-padding-15">
        <div class="w3-left w3-xlarge"><i class="fa fa-cubes w3-xlarge"></i>  O.R. Monitoring</div>
      </div>
		<br><br><br>
		
		<?php
		//For Production User Status Only, no User Lock Module
		$cur_user=$_SESSION['username'];
		mysql_query("UPDATE users SET user_status=0 where username='$cur_user'") or die(mysql_error()); 
		?>
		
		<div align='center'><a href="http://100.100.100.5/pps" target="_blank" class="w3-padding btn btn-info w3-xxlarge">PALAWAN PAWNSHOP O.R.</a></div>
		<br><br><br>
		<div align='center'><a href="http://100.100.100.5/orwalkin" target="_blank" class="w3-padding btn btn-info w3-xxlarge">WALK-IN O.R.</a></div>
	</div>	  
<?php } ?>
<!--OR Monitoring End-------->