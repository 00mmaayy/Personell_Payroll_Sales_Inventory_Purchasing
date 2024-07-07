<?php
if(isset($_REQUEST['search']) and $_REQUEST['search']=="production_performance")
{	
	$s="SELECT assign_to FROM sales_jo_assign WHERE b_count!=0 GROUP BY assign_to ORDER BY assign_to ASC";
	$q=mysql_query($s) or die(mysql_error());
	$r=mysql_fetch_assoc($q);
	
	$qq=mysql_query($s) or die(mysql_error());
	$rr=mysql_fetch_assoc($qq);
	
	echo "</br>";
	
	do{ $assign_to=$rr['assign_to'];
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='script_sales_monitoring_list.php?sort3=&sdate=".$_REQUEST['sdate']."&edate=".$_REQUEST['edate']."&branch=".$_REQUEST['branch']."&search=production_performance&assign_to=".$assign_to."'>".$assign_to."</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	}while($rr=mysql_fetch_assoc($qq));
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='script_sales_monitoring_list.php?sort3=&sdate=".$_REQUEST['sdate']."&edate=".$_REQUEST['edate']."&branch=".$_REQUEST['branch']."&search=production_performance&per_artist='>Per Artist</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	
	$sdate=$_REQUEST['sdate']." 00:00:00";
	$edate=$_REQUEST['edate']." 23:59:59";
	
		if(isset($_REQUEST['per_artist']))
		{
				if(isset($_REQUEST['jo_filter']))
				{	
					switch($_REQUEST['jo_filter'])
					{
						case "PENDING";		$filter=" AND b.completed_datetime='0000-00-00 00:00:00'"; 	break;
						case "COMPLETED";	$filter=" AND b.completed_datetime!='0000-00-00 00:00:00'";	break;
					}
				}else{ $filter=""; }
				
				$as="SELECT a.*, b.completed_datetime, b.jo_actual
					 FROM sales_jo_assign a
					 LEFT JOIN sales_jo b ON a.jo_no=b.jo_no
					 WHERE a.b_count=0 $filter ORDER BY a.assign_to ASC, a.assign_date DESC";
				$aq=mysql_query($as) or die(mysql_error());
				$ar=mysql_fetch_assoc($aq); ?>
				
							
							<br/><br/>
							<form class='w3-text-black' method='get'>
								
								<input name='sort3' type='hidden' value='<?php echo $_REQUEST['sort3']; ?>'>
								<input name='sdate' type='hidden' value='<?php echo $_REQUEST['sdate']; ?>'>
								<input name='edate' type='hidden' value='<?php echo $_REQUEST['edate']; ?>'>
								<input name='branch' type='hidden' value='<?php echo $_REQUEST['branch']; ?>'>
								<input name='search' type='hidden' value='<?php echo $_REQUEST['search']; ?>'>
								<input name='per_artist' type='hidden' value=''>
								<select required name='jo_filter'>
									<option disabled selected></option>
									<option>PENDING</option>
									<option>COMPLETED</option>
								</select>
								<input class='w3-tiny' type='submit' value='JO STATUS FILTER'>
							
							</form>	
					
		<?php echo "<table border='1'>
						<tr class='w3-green'><td>JO ACTUAL</td><td>ARTIST</td><td>ASSIGN DATE</td><td>JO STATUS</td></tr>";
				do{
					echo "<tr>
							<td>".$ar['jo_actual']."</td>
							<td>".$ar['assign_to']."</td>
							<td>".date('F d, Y',strtotime($ar['assign_date']))."</td>
							<td>";
					
							if($ar['completed_datetime']=="0000-00-00 00:00:00")
							{ echo "<b class='w3-text-red'>PENDING</b>"; }
							else
							{ echo "<b class='w3-text-blue'>COMPLETED</b>"; }
							
					 
					 echo "</td>
						 </tr>";
				}while($ar=mysql_fetch_assoc($aq));
			
			echo "</table>";
		}
		
		
		if(isset($_REQUEST['assign_to']))	
		{	
				if(isset($_REQUEST['filter']))
				{
					$filter=$_REQUEST['filter'];
					$filter1=" AND b.bch='$filter' ";
				}else{ $filter1=""; }
				
				$assign_to=$_REQUEST['assign_to'];
				$as="SELECT b.b_qty, b.b_amount, b.code_set, b.b_desc, b.bch, b.created_date, c.paid, c.delivered, c.jo_actual
					 FROM sales_jo_assign a
					 LEFT JOIN sales_bookings_details b ON a.b_count=b.b_count
					 LEFT JOIN sales_jo c ON b.b_id=c.b_id
					 WHERE assign_to='$assign_to' AND b.b_count!=0 AND b.created_date>='$sdate' AND b.created_date<='$edate' $filter1 ORDER BY b.bch ASC, assign_date DESC";
				
				$aq=mysql_query($as) or die(mysql_error());
				$ar=mysql_fetch_assoc($aq);
				
			  $as_t="SELECT SUM(b.b_qty*b.b_amount) AS p_total
					 FROM sales_jo_assign a
					 LEFT JOIN sales_bookings_details b ON a.b_count=b.b_count
					 LEFT JOIN sales_jo c ON b.b_id=c.b_id
					 WHERE assign_to='$assign_to' AND b.b_count!=0 AND b.created_date>='$sdate' AND b.created_date<='$edate' $filter1 ";
				
				$aq_t=mysql_query($as_t) or die(mysql_error());
				$ar_t=mysql_fetch_assoc($aq_t);
				
				echo "<table class='table w3-tiny' border='1'>
						<tr class='w3-green w3-small' align='center'>
							<td colspan='9'>
								<b class='w3-large'>".$assign_to." / TASKS</b><br/>"; ?>
								
							<form class='w3-text-black' method='get'>
								
								<input name='sort3' type='hidden' value='<?php echo $_REQUEST['sort3']; ?>'>
								<input name='sdate' type='hidden' value='<?php echo $_REQUEST['sdate']; ?>'>
								<input name='edate' type='hidden' value='<?php echo $_REQUEST['edate']; ?>'>
								<input name='branch' type='hidden' value='<?php echo $_REQUEST['branch']; ?>'>
								<input name='search' type='hidden' value='<?php echo $_REQUEST['search']; ?>'>
								<input name='assign_to' type='hidden' value='<?php echo $_REQUEST['assign_to']; ?>'>
								
								<select name='filter'>
									<option disabled selected></option>
									<option value='main'>MAIN</option>
									<option value='sm'>SM</option>
									<option value='rzl'>RIZAL</option>
									<option value='sp'>SANPEDRO</option>
									<option value='sj'>SANJOSE</option>
									<option value='adpls'>ADPLUS</option>
								</select>
								
								<input class='w3-tiny' type='submit' value='FILTER BRANCH'>
							
							</form>
								
				<?php echo "</td>
						</tr>
						<tr class='w3-pale-green'>
							<td><b>BRANCH</b></td>
							<td><b>ITEM CREATED DATE</b></td>
							<td><b>JO ACTUAL</b></td>
							<td><b>QTY</b></td>
							<td><b>AMOUNT</b></td>
							<td><b>TOTAL</b></td>
							<td><b>CODE</b></td>
							<td><b>DESCRIPTION</b></td>
							<td><b>JO STATUS</b></td>
						</tr>";
						
						do{
							echo "<tr>
									<td>";
									
									switch($ar['bch'])
									{
										case "goc":  echo "MAIN"; break;
										case "main": echo "MAIN"; break;
										case "sm":   echo "SM"; break;
										case "sp":   echo "SANPEDRO"; break;
										case "sj":   echo "SANJOSE"; break;
										case "rzl":  echo "RIZAL"; break;
										case "adpls":  echo "ADPLUS"; break;
									}
							  
							  echo "</td>
									<td>".date('F d Y h:i:s',strtotime($ar['created_date']))."</td>
									<td>".$ar['jo_actual']."</td>
									<td>".$ar['b_qty']."</td>
									<td align='right' class='w3-text-red'>".number_format($ar['b_amount'],2)."</td>
									<td align='right'><b class='w3-text-red'>".number_format($ar['b_qty']*$ar['b_amount'],2)."</b></td>
									<td>".$ar['code_set']."</td>
									<td>".$ar['b_desc']."</td>
									<td>";
										if($ar['paid']==1){ echo "<span class='w3-text-green'>PAID</span>"; }else{ echo "<span class='w3-text-red'>NOT PAID</span>";}
										echo " / ";
										if($ar['delivered']){ echo "<span class='w3-text-green'>DELIVERED</span>"; }else{ echo "<span class='w3-text-red'>DELIVERY PENDING</span>";}
							  echo "</td>
								  </tr>";
						}while($ar=mysql_fetch_assoc($aq));	
						
				echo "<tr><td colspan='6' align='right' class='w3-small w3-text-red w3-pale-green'><b>".number_format($ar_t['p_total'],2)."</b></td></tr></table>";
		}

		
		
}
?>