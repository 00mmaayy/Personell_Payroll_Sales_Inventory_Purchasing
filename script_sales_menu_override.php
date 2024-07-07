<?php 
				if($access['d25']==1)
				{ 
					$oc=mysql_fetch_assoc(mysql_query("select count(id) as oc1 from sales_client_override"));
					if($oc['oc1']!=0)
					{
					?>
					<li>
					<div class='notification'>
						<a class='btn w3-lime w3-tiny' href='script_sales_override.php' target='_blank'>OVERRIDE
						<span class='badge'>
							<?php echo $oc['oc1']; ?>
						</span>
						</a>
					</div>&nbsp;&nbsp;
					</li>
			  <?php }else{}
				}else{} 
?>