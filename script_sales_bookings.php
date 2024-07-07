<?php // Bookings Start --->
	  if($access['d21']==1)
	    { 
	      if(isset($_REQUEST['bookings'])) 
	        { ?> 
		       
			   <table>
					<tr>
						<td width='400'>
			   
							   <form method='get'>
								 <input name='sales' type='hidden' value='1'>
								 <input name='bookings' type='hidden' value='1'>
								 <b class='w3-tiny'>SORT BY CATEGORY:</b>
								 <select required name='sortby'>
								   <option class='w3-tiny' ></option>
								   <option class='w3-tiny' value='bid'>BOOKING NO</option>
								   <option class='w3-tiny' value='jo'>JOB ORDER NO</option>
								   <option class='w3-tiny' value='client'>CLIENT</option>
								   <option class='w3-tiny' value='date'>DATE</option>
								   <option class='w3-tiny' value='status'>STATUS</option>
								   <option class='w3-tiny' value='thru'>THRU</option>
								 </select>
								 <input class='btn w3-tiny' type='submit' value='GO!'>
							   </form>
			   
						</td>
						<td>
			   
							   <form method='get'>
								 <input name='sales' type='hidden' value='1'>
								 <input name='bookings' type='hidden' value='1'>
								 <b class='w3-tiny'>SORT PER USER:</b>
								 <select required name='user'>
								   <option></option>
								<?php  if($bch=="goc")
										{ $sv="select username,last_name,first_name from users where department like '%SALES%' and user_disable=0 order by last_name asc"; }
									 else
										{ $sv="select username,last_name,first_name from users where bch='$bch' and user_disable=0 order by last_name asc"; }
									   
									   $qv=mysql_query($sv) or die(mysql_error());
									   $rv=mysql_fetch_assoc($qv);
									   
									   do{ echo "<option class='w3-tiny' value='".$rv['username']."'>".$rv['last_name'].", ".$rv['first_name']."</option>"; } while ($rv=mysql_fetch_assoc($qv));
								?>
								 </select>
								 <input class='btn w3-tiny' type='submit' value='GO!'>
							   </form>
			   
						</td>
					</tr>	
			   <table>
			   
			<br/>

			   <table class='table'>
				  <tr align='center' class='w3-pale-green w3-tiny'>
					 <td colspan='9'>BOOKING HISTORY <?php if(isset($_REQUEST['sortby'])){ echo "<b>".$_REQUEST['sortby']."</b>"; }else{} ?></td>
				  </tr>
				  <tr class='w3-tiny w3-green' align='center'>
					 <td>RECIEVED BY</td><td>THRU</td><td>BOOKING ID.</td><td>JOB ORDER NO.</td><td>CLIENT</td><td>TOTAL AMOUNT</td><td>DATE</td><td>STATUS</td>
				  </tr>
                
            <?php
			$blank="0000-00-00 00:00:00";
			if($bch=="goc")
			{	
				if(isset($_REQUEST['sortby']))
				  {
				  //SORT PER CATEGORY	  
				  if($_REQUEST['sortby']=="bid")   { $x1="select * from sales_bookings where approved_datetime='$blank' order by b_id desc"; }
				  if($_REQUEST['sortby']=="jo")    { $x1="select * from sales_bookings where approved_datetime='$blank' order by b_jo desc"; }
				  if($_REQUEST['sortby']=="client"){ $x1="select * from sales_bookings where approved_datetime='$blank' order by client_id asc"; }
				  if($_REQUEST['sortby']=="date")  { $x1="select * from sales_bookings where approved_datetime='$blank' order by created_datetime desc"; }
				  if($_REQUEST['sortby']=="status"){ $x1="select * from sales_bookings where approved_datetime='$blank' order by approved_datetime,cancelled_datetime desc"; }
				  if($_REQUEST['sortby']=="thru")  { $x1="select * from sales_bookings where approved_datetime='$blank' order by trans_type asc"; }
				  }
			elseif(isset($_REQUEST['user']))
				  { 
					//SORT PER USER ONLY
					$user=$_REQUEST['user'];
				    $x1="select * from sales_bookings where approved_datetime='$blank' and created_by='$user' order by created_datetime desc";
				  }
				 else
				  { 
					//DEFAULT
					$x1="select * from sales_bookings where approved_datetime='$blank' order by created_datetime desc"; 
				  } 					 
			}
			else
			{
				if(isset($_REQUEST['sortby']))
				  {
				  //SORT PER CATEGORY	  
				  if($_REQUEST['sortby']=="bid")   
				    { 
						$x1="select a.* 
						     from sales_bookings as a 
						     inner join sales_clients as b
						     on a.client_id=b.client_id
						     where a.approved_datetime='$blank' and a.bch='$bch' and b.vip!=1 
							 order by a.b_id desc"; 
					}
					
				  if($_REQUEST['sortby']=="jo")    
				    {       
				        $x1="select a.* 
						     from sales_bookings as a 
						     inner join sales_clients as b
						     on a.client_id=b.client_id
						     where a.approved_datetime='$blank' and a.bch='$bch' and b.vip!=1 
							 order by a.b_jo desc"; 
					}
					
				  if($_REQUEST['sortby']=="client")
				    { 
				        $x1="select a.* 
						     from sales_bookings as a 
						     inner join sales_clients as b
						     on a.client_id=b.client_id
						     where a.approved_datetime='$blank' and a.bch='$bch' and b.vip!=1 
							 order by a.client_id asc"; 
					}
					
				  if($_REQUEST['sortby']=="date")
				    { 
				        $x1="select a.* 
						     from sales_bookings as a 
						     inner join sales_clients as b
						     on a.client_id=b.client_id
						     where a.approved_datetime='$blank' and a.bch='$bch' and b.vip!=1 
							 order by a.created_datetime desc"; 
					}
					
				  if($_REQUEST['sortby']=="status")
				    { 
						$x1="select a.* 
						     from sales_bookings as a 
						     inner join sales_clients as b
						     on a.client_id=b.client_id
						     where a.approved_datetime='$blank' and a.bch='$bch' and b.vip!=1 
							 order by a.approved_datetime,a.cancelled_datetime desc";
					}

				  if($_REQUEST['sortby']=="thru")
				    { 
						$x1="select a.* 
						     from sales_bookings as a 
						     inner join sales_clients as b
						     on a.client_id=b.client_id
						     where a.approved_datetime='$blank' and a.bch='$bch' and b.vip!=1 
							 order by a.trans_type asc";
					}
				  
				  }
			elseif(isset($_REQUEST['user']))
				  { 
					//SORT PER USER ONLY
					$user=$_REQUEST['user'];
				    $x1="select a.*
					     from sales_bookings as a
						 inner join sales_clients as b
						 on a.client_id=b.client_id
					     where a.approved_datetime='$blank' and a.bch='$bch' and b.vip!=1 and a.created_by='$user' order by a.created_datetime desc";
				  }
				 else
				  { 
					//DEFAULT
					$x1="select a.* 
						 from sales_bookings as a 
						 inner join sales_clients as b
						 on a.client_id=b.client_id
						 where a.approved_datetime='$blank' and a.bch='$bch' and b.vip!=1 order by a.created_datetime desc";
				  }
			}		
			
					$q9=mysql_query($x1) or die(mysql_error());
				    $rq=mysql_fetch_assoc($q9);
					
					do{
						
						$client_id=$rq['client_id'];
						$ssa=mysql_query("select name from sales_clients where client_id=$client_id") or die(mysql_error());
						$rsa=mysql_fetch_assoc($ssa);
						
						$b_id1=$rq['b_id'];
				        $qx=mysql_query("select sum(b_qty * b_amount) as b_total from sales_bookings_details where b_id='$b_id1' ") or die(mysql_error());
				        $rx1=mysql_fetch_assoc($qx);
						
						$q_id1=$rq['q_id'];
						$qx2=mysql_query("select sum(q_qty * q_amount) as q_total from sales_quotations_details where q_id='$q_id1' ") or die(mysql_error());
				        $rx2=mysql_fetch_assoc($qx2);
						
						$tt1=$rq['trans_type'];
				        $qa1=mysql_query("select * from sales_transaction_type where trans_no=$tt1") or die(mysql_error());
				        $rq1=mysql_fetch_assoc($qa1);
						echo "<tr align='center' class='w3-hover-pale-red'>
								<td class='w3-tiny'><i>";
								echo $rq['created_by']."
								</i></td>
						        <td class='w3-tiny'><i>".$rq1['trans_desc']."</i></td>
						        <td><i class='w3-tiny'>".$rq['b_id']."</i></td>
								<td>";
								if($rq['b_jo']!=0){ echo $rq['b_jo']; }else{ echo "<span class='w3-tiny w3-khaki'>PENDING</span>"; }
						  echo "</td>
								<td>&nbsp;<a href='admin_sales.php?client_id=".$rq['client_id']."&client=".$rsa['name']."&sales=1&newjobs=1&create_quotation=1' target='_blank'>".$rsa['name']."</a></td>";
						 if($rq['q_id']!=0)
						   { echo "<td>".number_format($rx2['q_total'],2)."</td>"; }
					  else { echo "<td class='w3-text-red'><b class='w3-small'>";
									if($rx1['b_total']!=0)
									{
										echo number_format($rx1['b_total'],2);
									}else{}
					       }
						  echo "</b></td>";
						  echo "<td align='center' class='w3-tiny'>".date('F d, Y h:i A',strtotime($rq['created_datetime']))."</td>";
						  echo "<td align='center' class='w3-tiny'>";
						
						if($rq['b_jo']!=0){ echo "<div class='w3-amber'>JO CREATED</div>"; }  
						if($rq['approved_by']==""){ if($rq['cancelled_by']=="") { echo "<div class='w3-khaki'>PENDING</div>"; } else { echo "<div class='w3-red'>CANCELLED</div>"; } }
						
						echo "</td>
						      <tr>";
						
					}while($rq=mysql_fetch_assoc($q9));	
				?>
		       </table>
	
	<?php   }	   
        } 
// bookings End ---> ?>	