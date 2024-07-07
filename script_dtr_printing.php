<?php 
session_start();
include('connection/conn.php');
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); } 
date_default_timezone_set("Asia/Manila");
?>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/w3.css">
<link rel="stylesheet" href="css/font-awesome.min.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>

<?php
if(isset($_REQUEST['print_zkteco']))
{	
			/* Show list of employees */
			
			 $s="select e_lname,
						e_fname,
						e_company,
						e_department
				 from INOUTDATA 
				 group by e_lname, e_fname
				 order by e_company,e_department asc, e_lname asc";
				 
			$q=mysql_query($s) or die(mysql_error());
			$r=mysql_fetch_assoc($q);
			
		do{	
			$e_lname=$r['e_lname'];	
			$e_fname=$r['e_fname'];	
			
			$xs="select e_no, e_lname, e_fname, e_timeclass from employee where e_lname='$e_lname' and e_fname like '%$e_fname%' AND (e_employment_status = 'Regular' OR e_employment_status = 'Probationary')";
			$xq=mysql_query($xs);
			$xr=mysql_fetch_assoc($xq);
			
			if($xr['e_timeclass']!=0)
					  { $time=$xr['e_timeclass']; 
						 $qtime=mysql_query("select timeclass from employee_timeclass where id=$time"); 
						 $rtime=mysql_fetch_assoc($qtime);
					  }else{}
			
			 echo "<tr>
					<td>";
					
						echo "<table>
								<tr>
									<td>";
							  
		//------------------------------------------------------------------					  
					do{
						$e_no=$xr['e_no'];
						$q3=mysql_query("select DATE from INOUTDATA where e_lname='$e_lname' and e_fname='$e_fname' group by DATE order by DATE asc") or die(mysql_error());
						$r3=mysql_fetch_assoc($q3);
						
						$q4=mysql_query("select DATE from INOUTDATA where e_lname='$e_lname' and e_fname='$e_fname' group by DATE order by DATE desc LIMIT 1") or die(mysql_error());
						$r4=mysql_fetch_assoc($q4);

						echo "<table class='table'>
								<tr>
									<td colspan='7'><b>".$r['e_company']."</b> | <b>".$r['e_department']."</b> | <b>".$e_no."</b> | <b class='w3-text-red'>".$e_lname.", ".$e_fname."</b> | <b class='w3-text-blue'>".$rtime['timeclass']."</b></td>
								</tr>
								<tr class='w3-light-gray w3-tiny'>
									<td>COUNT</td>
									<td>DATE</td>
									<td>AM L</td>
									<td>PM L</td>
									<td>UT</td>
									<td>OT</td>
									<td>AM IN</td>
									<td>AM OUT</td>
									<td>PM IN</td>
									<td>PM OUT</td>
									<td>OT IN</td>
									<td>OT OUT</td>
								</tr>";
								
								//$s=date('Y-m-d',strtotime($r3['DATE'].'-1 days'));
								//$e=date('Y-m-d',strtotime($r4['DATE'].'+1 days'));
								
								//palitan ito ng cutoff dates
								$x1=mysql_query("select * from dtr_date_print") or die(mysql_error()); 
								$z1=mysql_fetch_assoc($x1); 
								$s=date('Y-m-d',strtotime($z1['start']));
								$e=date('Y-m-d',strtotime($z1['end']));
								
								$begin = new DateTime($s);
								$end   = new DateTime($e);
								$x=1;
								
								for($i = $begin; $i <= $end; $i->modify('+1 day'))
								{
									$date=$i->format("Y-m-d");
									$qq=mysql_query("select id,TIME,DATE,LOGIN from INOUTDATA where e_lname='$e_lname' and e_fname='$e_fname' and DATE='$date' order by TIME");
									$rr=mysql_fetch_assoc($qq);
									
									 
									 echo "<tr class='w3-hover-pale-red'>";
									 echo "<td class='w3-small'>".$x++."</td>";
									
										    echo "<td class='w3-tiny'>".date('D / M d, Y',strtotime($date))."</td>"; 
											echo "<td class='w3-tiny'>";
											$q41=mysql_query("select AMLATES from INOUTDATALATES where e_no='$e_no' and DATE='$date' order by AMLATES desc") or die(mysql_error());
											$r41=mysql_fetch_assoc($q41);
											if($r41['AMLATES']!=0){ echo $r41['AMLATES']; } else {}
											echo "</td>";
											
											echo "<td class='w3-tiny'>";
											$q42=mysql_query("select PMLATES from INOUTDATALATES where e_no='$e_no' and DATE='$date' order by PMLATES desc") or die(mysql_error());
											$r42=mysql_fetch_assoc($q42);
											if($r42['PMLATES']!=0){ echo $r42['PMLATES']; } else {}
											echo "</td>";
											
											echo "<td class='w3-tiny'>";
											$q43=mysql_query("select UNDERTIME from INOUTDATALATES where e_no='$e_no' and DATE='$date' order by UNDERTIME desc") or die(mysql_error());
											$r43=mysql_fetch_assoc($q43);
											if($r43['UNDERTIME']!=0){ echo $r43['UNDERTIME']; } else {}
											echo "</td>";
											
											echo "<td class='w3-tiny'>";
											$q43=mysql_query("select OVERTIME from INOUTDATALATES where e_no='$e_no' and DATE='$date' order by OVERTIME desc") or die(mysql_error());
											$r43=mysql_fetch_assoc($q43);
											if($r43['OVERTIME']!=0){ echo round($r43['OVERTIME']/60,2); } else {}
											echo "</td>";
										  
										
										do{ 
											if($rr['TIME']){ echo "<td><span class='w3-text-indigo w3-small'>".date('h:i A',strtotime($rr['TIME']))."</span></td>"; }
										  } while($rr=mysql_fetch_assoc($qq));
								}
								
					echo "</tr>";
		 
				}while($xr=mysql_fetch_assoc($xq));
				
				
				echo "<tr><td colspan='2'></td>";	
					$sxxx="select sum(AMLATES) as amlates_total,
						sum(PMLATES) as pmlates_total,
						sum(UNDERTIME) as undertime_total,
						sum(OVERTIME) as overtime_total
						from INOUTDATALATES
						where e_no='$e_no'";
					$qxxx=mysql_query($sxxx);
					$rxxx=mysql_fetch_assoc($qxxx);

					echo "<td><b class='w3-text-red'>".$rxxx['amlates_total']."</b><span class='w3-tiny'>mins</span></td>
						  <td><b class='w3-text-red'>".$rxxx['pmlates_total']."</b><span class='w3-tiny'>mins</span></td>
				          <td><b class='w3-text-red'>".$rxxx['undertime_total']."</b><span class='w3-tiny'>mins</span></td>
						  <td><b class='w3-text-blue'>".round($rxxx['overtime_total']/60,2)."</b><span class='w3-tiny'>hrs</span></td>";
				echo "</tr>";
				

		echo "</table>";
		echo "<br><br><br><br><br><br><br><br>";	
		//------------------------------------------------------------------					  
							   echo "</td>
								</tr>	
							  </table>";

			echo "</td>
			</tr>";
			 
		} while($r=mysql_fetch_assoc($q));
		echo "</table>";
		
		/* Show list of employees */
}





if(isset($_REQUEST['print_realan']))
{

			/* Show list of employees */
			
			 $s="select e_lname,
						e_fname,
						e_company,
						e_department
				 from BIOMETRIC 
				 group by e_lname, e_fname 
				 order by e_company,e_department asc, e_lname asc";
				 
			$q=mysql_query($s) or die(mysql_error());
			$r=mysql_fetch_assoc($q);
			
		do{	
			$e_lname=$r['e_lname'];	
			$e_fname=$r['e_fname'];	
			
			$xs="SELECT e_no, e_lname, e_fname, e_timeclass FROM employee WHERE e_lname='$e_lname' AND e_fname like '%$e_fname%' AND (e_employment_status = 'Regular' OR e_employment_status = 'Probationary')";
			$xq=mysql_query($xs);
			$xr=mysql_fetch_assoc($xq);
			
			if($xr['e_timeclass']!=0)
					  { $time=$xr['e_timeclass']; 
						 $qtime=mysql_query("select timeclass from employee_timeclass where id=$time"); 
						 $rtime=mysql_fetch_assoc($qtime);
					  }else{}
			
			 echo "<tr>
					<td>";
						
						echo "<table>
								<tr>
									<td>";
							  
		//------------------------------------------------------------------					  
			 do{
						$e_no=$xr['e_no'];
						$q3=mysql_query("select DATE from BIOMETRIC where e_lname='$e_lname' and e_fname='$e_fname' group by DATE order by DATE asc") or die(mysql_error());
						$r3=mysql_fetch_assoc($q3);
						
						$q4=mysql_query("select DATE from BIOMETRIC where e_lname='$e_lname' and e_fname='$e_fname' group by DATE order by DATE desc LIMIT 1") or die(mysql_error());
						$r4=mysql_fetch_assoc($q4);

						echo "<table class='table'>
								<tr>
									<td colspan='7'><b>".$r['e_company']."</b> | <b>".$r['e_department']."</b> | <b class='w3-text-red'>".$e_lname.", ".$e_fname."</b> | <b class='w3-text-blue'>".$rtime['timeclass']."</b></td>
								</tr>
								<tr class='w3-light-gray w3-tiny'>
									<td>COUNT</td>
									<td>DATE</td>
									<td>AM L</td>
									<td>PM L</td>
									<td>UT</td>
									<td>OT</td>
									<td>AM IN</td>
									<td>AM OUT</td>
									<td>PM IN</td>
									<td>PM OUT</td>
									<td>OT IN</td>
									<td>OT OUT</td>
								</tr>";
								
								//$s=date('Y-m-d',strtotime($r3['DATE'].'-1 days'));
								//$e=date('Y-m-d',strtotime($r4['DATE'].'+1 days'));
								
								//palitan ito ng cutoff dates
								$x1=mysql_query("select * from dtr_date_print") or die(mysql_error()); 
								$z1=mysql_fetch_assoc($x1); 
								$s=date('Y-m-d',strtotime($z1['start']));
								$e=date('Y-m-d',strtotime($z1['end']));
								
								$begin = new DateTime($s);
								$end   = new DateTime($e);
								$x=1;
								
								for($i = $begin; $i <= $end; $i->modify('+1 day'))
								{
									$date=$i->format("Y-m-d");
									$qq=mysql_query("select id,DATE,AMIN,AMOUT,PMIN,PMOUT,OTIN,OTOUT from BIOMETRIC where e_lname='$e_lname' and e_fname='$e_fname' and DATE='$date'");
									$rr=mysql_fetch_assoc($qq);
										
									 echo "<tr class='w3-hover-pale-red'>";
									 echo "<td class='w3-small'>".$x++."</td>
										   <td class='w3-small'>".date('D / M d, Y',strtotime($date))."</td>";
											
											echo "<td class='w3-tiny'>";
											$q41=mysql_query("select AMLATES from BIOMETRICLATES where e_no='$e_no' and DATE='$date' order by AMLATES desc") or die(mysql_error());
											$r41=mysql_fetch_assoc($q41);
											if($r41['AMLATES']!=0){ echo $r41['AMLATES']; } else {}
											echo "</td>";
										
											echo "<td class='w3-tiny'>";
											$q42=mysql_query("select PMLATES from BIOMETRICLATES where e_no='$e_no' and DATE='$date' order by PMLATES desc") or die(mysql_error());
											$r42=mysql_fetch_assoc($q42);
											if($r42['PMLATES']!=0){ echo $r42['PMLATES']; } else {}
											echo "</td>";
											
											echo "<td class='w3-tiny'>";
											$q43=mysql_query("select UNDERTIME from BIOMETRICLATES where e_no='$e_no' and DATE='$date' order by UNDERTIME desc") or die(mysql_error());
											$r43=mysql_fetch_assoc($q43);
											if($r43['UNDERTIME']!=0){ echo $r43['UNDERTIME']; } else {}
											echo "</td>";
											
											echo "<td class='w3-tiny'>";
											$q43=mysql_query("select OVERTIME from BIOMETRICLATES where e_no='$e_no' and DATE='$date' order by OVERTIME desc") or die(mysql_error());
											$r43=mysql_fetch_assoc($q43);
											if($r43['OVERTIME']!=0){ echo round($r43['OVERTIME']/60,2); } else {}
											echo "</td>";
										
										
										   if($rr['AMIN']){ echo "<td><span class='w3-text-indigo w3-small'>";
																if($rr['AMIN']!="00:00:00"){ echo date('h:i A',strtotime($rr['AMIN'])); } else{}
															echo "</span></td>"; }
															
										   if($rr['AMOUT']){ echo "<td><span class='w3-text-indigo w3-small'>";
																if($rr['AMOUT']!="00:00:00"){ echo date('h:i A',strtotime($rr['AMOUT'])); } else{}
															 echo "</span></td>"; }
															 
										   if($rr['PMIN']){ echo "<td><span class='w3-text-indigo w3-small'>";
																if($rr['PMIN']!="00:00:00"){ echo date('h:i A',strtotime($rr['PMIN'])); } else{}
															echo "</span></td>"; }
															
										   if($rr['PMOUT']){ echo "<td><span class='w3-text-indigo w3-small'>";
																if($rr['PMOUT']!="00:00:00"){ echo date('h:i A',strtotime($rr['PMOUT'])); } else{}
															 echo "</span></td>"; }
															 
										   if($rr['OTIN']){ echo "<td><span class='w3-text-indigo w3-small'>";
																if($rr['OTIN']!="00:00:00"){ echo date('h:i A',strtotime($rr['OTIN'])); } else{}
															echo "</span></td>"; }
															
										   if($rr['OTOUT']){ echo "<td><span class='w3-text-indigo w3-small'>";
																if($rr['OTOUT']!="00:00:00"){ echo date('h:i A',strtotime($rr['OTOUT'])); } else{}
															 echo "</span></td>"; }
								}

					echo "</tr>";
					
					
		 
				} while($xr=mysql_fetch_assoc($xq));

				
				echo "<tr><td colspan='2'></td>";	
					$sxxx="select sum(AMLATES) as amlates_total,
						sum(PMLATES) as pmlates_total,
						sum(UNDERTIME) as undertime_total,
						sum(OVERTIME) as overtime_total
						from BIOMETRICLATES
						where e_no='$e_no'";
					$qxxx=mysql_query($sxxx);
					$rxxx=mysql_fetch_assoc($qxxx);

					echo "<td><b class='w3-text-red'>".$rxxx['amlates_total']."</b><span class='w3-tiny'>mins</span></td>
						  <td><b class='w3-text-red'>".$rxxx['pmlates_total']."</b><span class='w3-tiny'>mins</span></td>
				          <td><b class='w3-text-red'>".$rxxx['undertime_total']."</b><span class='w3-tiny'>mins</span></td>
						  <td><b class='w3-text-blue'>".round($rxxx['overtime_total']/60,2)."</b><span class='w3-tiny'>hrs</span></td>";
				echo "</tr>";
				
				
		echo "</table>";
		echo "<br><br><br><br><br><br><br><br>";		
		//------------------------------------------------------------------					  
							   echo "</td>
								</tr>	
							  </table>";

			echo "</td>
			</tr>";
			 
		} while($r=mysql_fetch_assoc($q));
		echo "</table>";
		
		/* Show list of employees */

}	

?>
