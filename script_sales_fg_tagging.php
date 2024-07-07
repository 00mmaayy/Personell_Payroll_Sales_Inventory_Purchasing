<?php 
include('connection/conn.php');
date_default_timezone_set("Asia/Manila");
include("css.php");
?>

<div class='container' align='center'><br/>
<?php
if(isset($_REQUEST['store']))
{ 
		$jo_no=$_REQUEST['jo_no'];
		mysql_query("update sales_jo set production_status=1, production_date=now() where jo_no=$jo_no");
		
		$trans="JO NO:$jo_no Stored to FG by FG Costudian";
		$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
		$log_query=mysql_query($log_sql) or die(mysql_error());
		
		header('Location: script_sales_fg_tagging.php?find_system_jo='.$_REQUEST['jo_no']);
}						  



elseif(isset($_REQUEST['deliver']))
{ 
		$jo_no=$_REQUEST['jo_no'];
		mysql_query("update sales_jo set production_status=8, production_date=now() where jo_no=$jo_no");
		
		$trans="JO NO:$jo_no Removed from FG and mark as Removed by FG Costudian";
		$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
		$log_query=mysql_query($log_sql) or die(mysql_error());
		
		header('Location: script_sales_fg_tagging.php?find_system_jo='.$_REQUEST['jo_no']);
}



elseif(isset($_REQUEST['find']))
{ ?>	
			<form>
				<input required name='find_system_jo' class='w3-jumbo' size='7' type='text'><br/>
				<input class='w3-xxlarge w3-button w3-pink' type='submit' value='&nbsp;&nbsp;FIND SYSTEM JO&nbsp;&nbsp;'>
			</form>
			
			<br/><br/>
			<form>
				<input required name='find_bo' class='w3-jumbo' size='7' type='text'><br/>
				<input class='w3-xxlarge w3-button w3-blue' type='submit' value='&nbsp;FIND BOOKING NO'>
			</form>
			
			<!--
			<br/><br/>
			<form>
				<input required name='find_jo_actual' class='w3-jumbo' size='7' type='text'><br/>
				<input class='w3-xxlarge w3-button w3-green' type='submit' value='&nbsp;&nbsp;FIND ACTUAL JO&nbsp;&nbsp;'>
			</form>
			-->
			
			<br/><br/>
			<a class='w3-xxlarge w3-button w3-green' href='script_sales_fg_tagging.php?view_fg=1'>VIEW FG LIST</a>
			<br/>
			<br/>
<?php
}

elseif(isset($_REQUEST['view_fg']))
{ 
	echo "<div align='left'><a class='w3-button w3-deep-orange' href='script_sales_fg_tagging.php?find=1'>RETURN TO SEARCH</a></div><br/>";
	?>
					
					<!-- select department for filter start -->
					<form>
						<input name='view_fg' type='hidden' value='1'>
						<select required name='branch3'>
			<?php if(isset($_REQUEST['branch3']) and $_REQUEST['branch3']!="ALL")
					{ echo "<option>".$_REQUEST['branch3']."</option>"; } 
			   else {} ?>
						<option>ALL</option>
				  <?php $sa="SELECT a.department 
							 FROM users a 
							 INNER JOIN sales_jo b
								ON b.created_by = a.username
							 GROUP BY a.department";
						$qa=mysql_query($sa);
						$ra=mysql_fetch_assoc($qa);
						do{
						echo "<option>".$ra['department']."</option>"; 
						}while($ra=mysql_fetch_assoc($qa)); ?>
						</select>
					
						<input type='submit' value='FILTER' >
					</form>
					<!-- select department for filter end -->
					
					
	<?php			
					if(isset($_REQUEST['branch3']) and $_REQUEST['branch3']!="ALL")
					{
						$dept11=$_REQUEST['branch3'];
						$branch4=" and c.department='$dept11'";
					}
					else{ $branch4=""; }
					
								$s91="select a.*, b.*, c.department
										  from sales_jo a
										  left join sales_clients b on a.client_id=b.client_id
										  left join users c on a.created_by=c.username
										  where a.production_status=1 and a.delivered=0 $branch4
										  order by a.production_date desc";
										  
							  
								$q91=mysql_query($s91) or die(mysql_error());
								$r91=mysql_fetch_assoc($q91);
								$x=1;
								
								echo "<table class='w3-table' border='1'>
										<tr class='w3-green w3-small'>
											<td>FG Date</td>
											<td>JO NO</td>
											<td>BOOKING NO</td>
											<td>JO ACTUAL</td>
											<td>CLIENT</td>
											<td>ORDER DETAILS</td>
										</tr>";
								do{
									echo "<tr class='w3-hover-light-gray'>";
									
									echo "<td><i class='w3-small w3-text-gray'>".$x++.". </i><br/>
												<b>".date('M d Y',strtotime($r91['production_date']))."</b><br/>";
												$fg_date_old = strtotime($r91['production_date']);
												$now1 = strtotime(date('Y-m-d'));
												$day1 = ((($now1-$fg_date_old)/3600)/24);
												
												if($day1>=1)
												{
												echo "<i class='w3-text-red'><b>".floor($day1)." Day/s on FG</b></i>";
												}else{}
											
									  echo "</td>";
									  echo "<td><a href='script_sales_fg_tagging.php?find_system_jo=".$r91['jo_no']."'>".$r91['jo_no']."</a>";
									  echo "<td>";
											if($r91['bo_no']!=0){
											echo "<a href='script_sales_fg_tagging.php?find_bo=".$r91['bo_no']."'>".$r91['bo_no']."</a>";
											}else{}
									  echo "</td>
										    <td>
												<a href='script_sales_fg_tagging.php?find_jo_actual=".$r91['jo_actual']."'>".$r91['jo_actual']."</a>
											</td>";
									  
									  echo "<td><i class='w3-tiny w3-text-gray'>(".$r91['department'].") &nbsp; paid: "; 
									  
											switch($r91['paid']){ case 0: echo "<span class='w3-text-red'>NO</span>"; break; case 1: echo "<span class='w3-text-blue'>YES</span>"; break; }
											
											echo "&nbsp; | &nbsp;";
											
											if($r91['vip']!=0){ echo "Account/VIP/Gov"; }else{ echo "CASH Client"; }
											
									  echo "</i><br/>".$r91['name']."<br/>
											<span class='w3-small'>JO Amount: <b class='w3-text-indigo'>".number_format($r91['jo_amount'],2)."</b></span>
											</td>";
									  echo "<td>";
									  
												$b_id=$r91['b_id'];
												$s92="select b_qty, code_set, b_desc, dr_qty, dr_no, dr_date from sales_bookings_details where b_id=$b_id";
												$q92=mysql_query($s92) or die(mysql_error());
												$r92=mysql_fetch_assoc($q92);
												
												echo "<table class='w3-table' border='1'><tr class='w3-blue w3-small'><td>ORDER</td><td>ITEM</td><td>DR QTY</td><td>DR DETAILS</td></tr>";
												do{
													echo "<tr>
															<td><span class='w3-text-indigo'>".$r92['b_qty']."</span></td>
															<td><span class='w3-text-red'>".$r92['code_set']."</span> | <span class='w3-small'>".$r92['b_desc']."</span></td>
															<td><span class='w3-text-indigo'>".$r92['dr_qty']."</span></td>
															<td><span class='w3-text-red'>".$r92['dr_no']."</span> | <span class='w3-small'>".$r92['dr_date']."</span></td>
														  </tr>";
												}while($r92=mysql_fetch_assoc($q92));
												echo "</table>";
												
									  echo "</td>";
									echo "</tr>";
								
								$total_jo_amount += $r91['jo_amount'];
									
								}while($r91=mysql_fetch_assoc($q91));
								
								echo "<tr>
										<td>TOTAL JO AMOUNT ON FG: ".number_format($total_jo_amount,2)."</td>
									  </tr>
									</table><br/>
							</div>";
}


 
elseif(isset($_REQUEST['find_bo']) or isset($_REQUEST['find_jo_actual']) or isset($_REQUEST['find_system_jo']))
{
	echo "<div align='left'><a class='w3-button w3-deep-orange' href='script_sales_fg_tagging.php?find=1'>RETURN TO SEARCH</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						    <a class='w3-button w3-deep-purple' href='script_sales_fg_tagging.php?view_fg=1'>VIEW FG</a></div><br/>";
	echo "<br/>";

	if(isset($_REQUEST['find_system_jo'])){ $where="where jo_no=".$_REQUEST['find_system_jo']." "; }else{}
	if(isset($_REQUEST['find_bo'])){ $where="where bo_no=".$_REQUEST['find_bo']." "; }else{}
	if(isset($_REQUEST['find_jo_actual'])){ $where="where jo_actual like '%".$_REQUEST['find_jo_actual']."%'"; }else{}
	
	$sql=mysql_query("select a.*, b.name, b.vip
						from sales_jo a
						left join sales_clients b on a.client_id=b.client_id
						$where");
	
	echo "<table class='w3-table'>";
	while($row=mysql_fetch_array($sql))
	{ 
		echo "<tr><td class='w3-text-indigo'>CLIENT:</td><td>".$row['name']."</td></tr>
			  <tr><td class='w3-text-indigo'>JO NO:</td><td>".$row['jo_no']."</td></tr>
			  <tr><td class='w3-text-indigo'>BOOKING NO:</td><td>".$row['bo_no']."</td></tr>
			  <td class='w3-text-indigo'>PAID:</td><td>(<b>".number_format($row['jo_amount'],2)."</b>) ";
				switch($row['paid']){ case 0: echo "<span class='w3-text-red'>NO</span>"; break; case 1: echo "<span class='w3-text-blue'>YES</span>"; break; }
				
				echo "&nbsp; | &nbsp;";
											
				if($row['vip']!=0){ echo "Account/VIP/Gov"; }else{ echo "CASH Client"; }
			  
		echo "</td></tr>
			  <td class='w3-text-indigo'>ACTUAL JO:</td><td>".$row['jo_actual']."</td></tr>";
		
		echo "<tr><td class='w3-text-indigo'>ORDER DETAILS:</td>
					<td>";
					
					$as="select * from sales_bookings_details where b_id='".$row['b_id']."'";
					$aq=mysql_query($as) or die(mysql_error($as));
					$ar=mysql_fetch_assoc($aq);
					if($row['delivered']==1){ echo "<span class='w3-text-blue'>JO IS COMPLETED!</span><br/>"; } else {} 
					echo "<table class='w3-table' border='1'><tr class='w3-green'><td>ORDER</td><td>SIZE</td><td>ITEM</td></tr>";
					do
					{
						echo "<tr><td>".$ar['b_qty']."</td><td>".$ar['b_size']."</td><td><span class='w3-text-red'>".$ar['code_set']."</span> | ".$ar['b_desc']."</td></tr>";
					}while($ar=mysql_fetch_assoc($aq));
					echo "</table>";
				echo "</td>
			</tr>";
		echo "<tr>
				<td colspan='2'><br/>
					<div align='center'>";
				
				
				
								//if($row['production_status']!=1 and $row['production_status']!=8 and $row['production_status']!=9 and $row['delivered']==0)
								if($row['production_status']!=1 and $row['production_status']!=8 and $row['production_status']!=9)
								  { 
									echo "<b class='w3-xxlarge'>ITEM <span class='w3-text-red'>NOT</span> IN FINISH GOODS ROOM</b>"; ?>

										<br/><br/><a class="w3-xxlarge w3-button w3-blue" href="script_sales_fg_tagging.php?store=1&jo_no=<?php echo $row['jo_no']; ?>" onclick="return confirm('STORE TO FINISH GOODS?')">STORE</a>
							<?php }
							
							elseif($row['production_status']==8)
								  { 
									echo "<span class='w3-text-red w3-xxlarge'>ITEM ALREADY RELEASED!</span>";
								  }
							  else{}
							
							
							
							
							
								if($row['vip']==0)
								{
									//if($row['production_status']==1 and $row['delivered']==0 and $row['paid']==1)
									if($row['production_status']==1 and $row['paid']==1)	
										{
											echo "<b class='w3-xxlarge'>IS IN FINISH GOODS ROOM</b>";
											
											if($row['completed_by']!=""){ echo "<br/><i>(completed already)</i>"; }
											else{}
											
											?>
											
											<br/><br/><a class="w3-xxlarge w3-button w3-red" href="script_sales_fg_tagging.php?deliver=1&jo_no=<?php echo $row['jo_no']; ?>" onclick="return confirm('REMOVE FROM FINISH GOODS?')">RELEASE ITEM</a>
									
								  <?php }
								   elseif($row['production_status']==1 and $row['paid']==0)
										{ echo "<b class='w3-xxlarge w3-red'>&nbsp;CASH CLIENT! NOT YET PAID&nbsp;</b>"; }
									else{}
									
								}
								else
								{
									//if($row['production_status']==1 and $row['delivered']==0)
									if($row['production_status']==1)
										{
											echo "<b class='w3-xxlarge'>IS IN FINISH GOODS ROOM</b>"; 
											
											if($row['completed_by']!=""){ echo "<br/><i>(completed already)</i>"; }
											else{}
											
											?>
											
											<br/><br/><a class="w3-xxlarge w3-button w3-red" href="script_sales_fg_tagging.php?deliver=1&jo_no=<?php echo $row['jo_no']; ?>" onclick="return confirm('REMOVE FROM FINISH GOODS?')">RELEASE ITEM</a>
									
								  <?php }else{}
									
								}	
					
			echo "</div>
				</td>
		      </tr>";	
		
	}
	
	echo "</table>";
	
}
else{}

?>
</div>