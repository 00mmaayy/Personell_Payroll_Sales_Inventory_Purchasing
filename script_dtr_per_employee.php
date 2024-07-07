<?php 
session_start();
include('connection/conn.php');
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); } 
date_default_timezone_set("Asia/Manila");

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past 
header('Last-Modified: '.gmdate('D, d M Y H:i:s') . ' GMT');
header('Cache-Control: no-store, no-cache, must-revalidate'); // HTTP/1.1 
header( 'Cache-Control: post-check=0, pre-check=0', false );
header( 'Pragma: no-cache' );
include("css.php");
?>
<hr>

<div class='container'>

<?php
if(isset($_REQUEST['zkteco']))
{	
		if(isset($_REQUEST['success']))
		{ echo "<b class='w3-text-green'>Data Successfully Submitted to Payroll</b><br>"; }

		if(isset($_REQUEST['send_to_payroll']))
		{
			$time_class=$_REQUEST['time_class'];
			$e_no=$_REQUEST['e_no'];
			$e_lname=$_REQUEST['e_lname'];
			$e_fname=$_REQUEST['e_fname'];
			
			mysql_query("update INOUTDATALATES set UPDATED=1 where e_no='$e_no'") or die(mysql_error());
			
			$qz=mysql_query("select e_basic_pay from employee where e_no='$e_no'") or die(mysql_error());
			$rz=mysql_fetch_assoc($qz);
			
			$per_day=$rz['e_basic_pay']/26;
			$per_hour=$per_day/8;
			$per_min=$per_day/8/60;
			
			///
			$e_total_cuttoff_hours=round($_REQUEST['total_completed_day']*8,2) + round(($_REQUEST['total_half_day']-$_REQUEST['total_completed_day'])*4,2);
			$e_total_cuttoff_hours_final=round($e_total_cuttoff_hours*$per_hour,2);
			///
			
			$lates=$_REQUEST['amlates']+$_REQUEST['pmlates'];
			$e_lates=round($lates,2);
			$e_lates_final=round($per_min*$e_lates,2);
				
			$e_undertime=round($_REQUEST['undertime']/60,2);
			$e_undertime_final=round($per_hour*$e_undertime,2);
			
			if($e_undertime>1)
			{
				$undertime_yeah=" e_undertime=$e_undertime, ";
				$undertime_final_yeah=" e_undertime_final=$e_undertime_final, ";
			}	
			else{ $undertime_yeah=""; $undertime_final_yeah=""; }
			
			
			$e_overtime=round($_REQUEST['overtime']/60,2);
			$e_overtime_final=round($per_hour*$e_overtime*1.25,2);
			
			$total_day_meal=($e_total_cuttoff_hours/8)*35;
			
			$s="update payroll
				 set e_total_cuttoff_hours=$e_total_cuttoff_hours,
		             e_total_cuttoff_hours_final=$e_total_cuttoff_hours_final,
					 e_lates=$e_lates,
					 e_lates_final=$e_lates_final,
					 $undertime_yeah
					 $undertime_final_yeah
					 e_overtime=$e_overtime,
					 e_overtime_final=$e_overtime_final,
					 e_allowance_meal=$total_day_meal
				 where e_no='$e_no' and e_lname='$e_lname' and finalized=0";	 
			
			//echo $s;
			$q=mysql_query($s) or die(mysql_error());
			header("Location: script_dtr_per_employee.php?zkteco=1&success=1&time_class=".$_REQUEST['time_class']."&e_no=".$_REQUEST['e_no']."&e_lname=".$_REQUEST['e_lname']."&e_fname=".$_REQUEST['e_fname']);
		}
			
		
		
		if(isset($_REQUEST['remove']))
		{
			$id=$_REQUEST['id'];
			mysql_query("delete from INOUTDATA where id='$id'");
			header("Location: script_dtr_per_employee.php?zkteco=1&time_class=".$_REQUEST['time_class']."&e_no=".$_REQUEST['e_no']."&e_lname=".$_REQUEST['e_lname']."&e_fname=".$_REQUEST['e_fname']);
		}

		
		
		if(isset($_REQUEST['add_time']))
		{
			$e_lname=$_REQUEST['e_lname'];
			$e_fname=$_REQUEST['e_fname'];
			$e_no=$_REQUEST['e_no'];
			$add_time=$_REQUEST['add_time'].":00";
			$add_date=$_REQUEST['date1'];
			
			$s="insert into INOUTDATA (e_lname,e_fname,TIME,DATE) VALUES ('$e_lname','$e_fname','$add_time','$add_date')";
			mysql_query($s) or die(mysql_error());
			header("Location: script_dtr_per_employee.php?zkteco=1&time_class=".$_REQUEST['time_class']."&e_no=".$_REQUEST['e_no']."&e_lname=".$_REQUEST['e_lname']."&e_fname=".$_REQUEST['e_fname']);
		}
		
		
		
		if(isset($_REQUEST['add_date']))
		{
			$e_lname=$_REQUEST['e_lname'];
			$e_fname=$_REQUEST['e_fname'];
			$date=$_REQUEST['date'];
			
			$s="insert into INOUTDATA (e_lname,e_fname,DATE) values ('$e_lname','$e_fname','$date')";
			mysql_query($s) or die(mysql_error());
			header("Location: script_dtr_per_employee.php?zkteco=1&time_class=".$_REQUEST['time_class']."&e_no=".$_REQUEST['e_no']."&e_lname=".$_REQUEST['e_lname']."&e_fname=".$_REQUEST['e_fname']);
		}	

		
		//clear late details
		$e_no=$_REQUEST['e_no'];
		mysql_query("delete from INOUTDATALATES where e_no='$e_no' and UPDATED=0") or die(mysql_error());

		$e_lname=$_REQUEST['e_lname'];
		$e_fname=$_REQUEST['e_fname'];
		$q=mysql_query("select DATE from INOUTDATA where e_lname='$e_lname' and e_fname='$e_fname' group by DATE order by DATE") or die(mysql_error());
		$r=mysql_fetch_assoc($q);
		
		$id11=$_REQUEST['time_class'];
		$q11=mysql_query("select timeclass from employee_timeclass where id='$id11'") or die(mysql_error());
		$r11=mysql_fetch_assoc($q11);

		echo "<table class='table'>
				<tr>
					<td colspan='2'><b class='w3-text-red'>".$e_lname.", ".$e_fname."</b><br><b>".$_REQUEST['e_no']."</b><br><b class='w3-text-blue'>".$r11['timeclass']."</b></td>
				</tr>
				<tr class='w3-green w3-tiny'>
					<td>DATE</td>
					<td>AM LATES</td>
					<td>PM LATES</td>
					<td>UNDERTIME</td>
					<td>OVERTIME</td>
					<td>MANUAL INPUT</td>
					<td>AM IN</td>
					<td>AM OUT</td>
					<td>PM IN</td>
					<td>PM OUT</td>
					<td>OT IN</td>
					<td>OT OUT</td>
				</tr>";
		do{
		   
			  echo "<tr class='w3-hover-pale-red'><td class='w3-small'>";
				echo date('D / M d, Y',strtotime($r['DATE']));
			  echo "</td>";
						
						$date=$r['DATE'];
						$e_lname=$_REQUEST['e_lname'];
						$e_fname=$_REQUEST['e_fname'];
						
						
						$qq11=mysql_query("select id,TIME,DATE,LOGIN from INOUTDATA where e_lname='$e_lname' and e_fname='$e_fname' and DATE='$date' order by TIME");
						$rr11=mysql_fetch_assoc($qq11);
						$x=1;
						do{
							$x++;
							$id2=$rr11['id'];
					
							if($x==2){ $login="AMIN"; }
							if($x==3){ $login="AMOUT"; }
							if($x==4){ $login="PMIN"; }
							if($x==5){ $login="PMOUT"; }
							if($x==6){ $login="OTIN"; }
							if($x==7){ $login="OTOUT"; }
					
							mysql_query("update INOUTDATA set LOGIN='$login' where id=$id2");
							
						}while($rr11=mysql_fetch_assoc($qq11));
						
						
						
						
				
			  //AM  
			  echo "<td>";
			  
				$query_amin=mysql_query("SELECT TIME,LOGIN FROM INOUTDATA WHERE DATE='$date' and e_lname='$e_lname' and e_fname='$e_fname' and LOGIN='AMIN'");
				$result_amin=mysql_fetch_Assoc($query_amin);	
				$query_amout=mysql_query("SELECT TIME,LOGIN FROM INOUTDATA WHERE DATE='$date' and e_lname='$e_lname' and e_fname='$e_fname' and LOGIN='AMOUT'");
				$result_amout=mysql_fetch_Assoc($query_amout);
				
				// note: results are in seconds
				// to get minutes divide to 60
				// to get hours divide to 3600
				
				//AM total
				$amin=date_create($result_amin['TIME']);
				$amout=date_create($result_amout['TIME']);
				$amtotal=date_diff($amin,$amout);
				$amx=$amtotal->format("%h");
				$amy=$amtotal->format("%i");
				$amz=$amx*60+$amy;//minutes computation
				
				
				$q9=mysql_query("select UPDATED from INOUTDATALATES where UPDATED=1 and e_no='$e_no'") or die(mysql_error());
				$r9=mysql_fetch_assoc($q9);
				$xx=$r9['UPDATED'];
				
				
				echo "<span class='w3-text-red'>";
				
				if($_REQUEST['time_class']==1)
				{ 
					$amin=strtotime($result_amin['TIME']); 
					$amclass=strtotime('07:10:59');
					if($amin>$amclass)
					{ 
						$amin1=date_create($result_amin['TIME']);
						$amclass1=date_create('07:11:00');
						$amlate=date_diff($amin1,$amclass1);
						$amlate_total=$amlate->format("%i%");
						echo ($amlate_total+11)." min/s";
						
						$amlates=$amlate_total+11;
						$date=$r['DATE'];
						if($xx!=1){ mysql_query("insert into INOUTDATALATES (e_no,DATE,AMLATES) values ('$e_no','$date','$amlates')") or die(mysql_error()); }
						else{}
					}
					else
					{
						$amlates=0;
						$date=$r['DATE'];
						if($xx!=1){ mysql_query("insert into INOUTDATALATES (e_no,DATE,AMLATES) values ('$e_no','$date','$amlates')") or die(mysql_error()); }
						else{}
					}
				}
				
				if($_REQUEST['time_class']==2)
				{ 
					$amin=strtotime($result_amin['TIME']); 
					$amclass=strtotime('07:10:59');
					if($amin>$amclass)
					{ 
						$amin1=date_create($result_amin['TIME']);
						$amclass1=date_create('07:11:00');
						$amlate=date_diff($amin1,$amclass1);
						$amlate_total=$amlate->format("%i%");
						echo ($amlate_total+11)." min/s";
						
						$amlates=$amlate_total+11;
						$date=$r['DATE'];
						if($xx!=1){ mysql_query("insert into INOUTDATALATES (e_no,DATE,AMLATES) values ('$e_no','$date','$amlates')") or die(mysql_error()); }
						else{}
					}
					else
					{
						$amlates=0;
						$date=$r['DATE'];
						if($xx!=1){ mysql_query("insert into INOUTDATALATES (e_no,DATE,AMLATES) values ('$e_no','$date','$amlates')") or die(mysql_error()); }
						else{}
					}
				}
				
				if($_REQUEST['time_class']==3)
				{ 
					$amin=strtotime($result_amin['TIME']); 
					$amclass=strtotime('07:40:59');
					if($amin>$amclass)
					{ 
						$amin1=date_create($result_amin['TIME']);
						$amclass1=date_create('07:41:00');
						$amlate=date_diff($amin1,$amclass1);
						$amlate_total=$amlate->format("%i%");
						echo ($amlate_total+11)." min/s";
						
						$amlates=$amlate_total+11;
						$date=$r['DATE'];
						if($xx!=1){ mysql_query("insert into INOUTDATALATES (e_no,DATE,AMLATES) values ('$e_no','$date','$amlates')") or die(mysql_error()); }
						else{}
					}
					else
					{
						$amlates=0;
						$date=$r['DATE'];
						if($xx!=1){ mysql_query("insert into INOUTDATALATES (e_no,DATE,AMLATES) values ('$e_no','$date','$amlates')") or die(mysql_error()); }
						else{}
					}
				}
				
				if($_REQUEST['time_class']==4)
				{ 
					$amin=strtotime($result_amin['TIME']); 
					$amclass=strtotime('08:10:59');
					if($amin>$amclass)
					{ 
						$amin1=date_create($result_amin['TIME']);
						$amclass1=date_create('08:11:00');
						$amlate=date_diff($amin1,$amclass1);
						$amlate_total=$amlate->format("%i%");
						echo ($amlate_total+11)." min/s";
						
						$amlates=$amlate_total+11;
						$date=$r['DATE'];
						if($xx!=1){ mysql_query("insert into INOUTDATALATES (e_no,DATE,AMLATES) values ('$e_no','$date','$amlates')") or die(mysql_error()); }
						else{}
					}
					else
					{
						$amlates=0;
						$date=$r['DATE'];
						if($xx!=1){ mysql_query("insert into INOUTDATALATES (e_no,DATE,AMLATES) values ('$e_no','$date','$amlates')") or die(mysql_error()); }
						else{}
					}
				}
				
				if($_REQUEST['time_class']==5)
				{ 
					$amin=strtotime($result_amin['TIME']); 
					$amclass=strtotime('08:40:59');
					if($amin>$amclass)
					{ 
						$amin1=date_create($result_amin['TIME']);
						$amclass1=date_create('08:41:00');
						$amlate=date_diff($amin1,$amclass1);
						$amlate_total=$amlate->format("%i%");
						echo ($amlate_total+11)." min/s";
						
						$amlates=$amlate_total+11;
						$date=$r['DATE'];
						if($xx!=1){ mysql_query("insert into INOUTDATALATES (e_no,DATE,AMLATES) values ('$e_no','$date','$amlates')") or die(mysql_error()); }
						else{}
					}
					else
					{
						$amlates=0;
						$date=$r['DATE'];
						if($xx!=1){ mysql_query("insert into INOUTDATALATES (e_no,DATE,AMLATES) values ('$e_no','$date','$amlates')") or die(mysql_error()); }
						else{}
					}
				}
				
				if($_REQUEST['time_class']==6)
				{ 
					$amin=strtotime($result_amin['TIME']); 
					$amclass=strtotime('09:10:59');
					if($amin>$amclass)
					{ 
						$amin1=date_create($result_amin['TIME']);
						$amclass1=date_create('09:11:00');
						$amlate=date_diff($amin1,$amclass1);
						$amlate_total=$amlate->format("%i%");
						echo ($amlate_total+11)." min/s";
						
						$amlates=$amlate_total+11;
						$date=$r['DATE'];
						if($xx!=1){ mysql_query("insert into INOUTDATALATES (e_no,DATE,AMLATES) values ('$e_no','$date','$amlates')") or die(mysql_error()); }
						else{}
					}
					else
					{
						$amlates=0;
						$date=$r['DATE'];
						if($xx!=1){ mysql_query("insert into INOUTDATALATES (e_no,DATE,AMLATES) values ('$e_no','$date','$amlates')") or die(mysql_error()); }
						else{}
					}
				}
				
				if($_REQUEST['time_class']==7)
				{ 
					$amin=strtotime($result_amin['TIME']); 
					$amclass=strtotime('09:40:59');
					if($amin>$amclass)
					{ 
						$amin1=date_create($result_amin['TIME']);
						$amclass1=date_create('09:41:00');
						$amlate=date_diff($amin1,$amclass1);
						$amlate_total=$amlate->format("%i%");
						echo ($amlate_total+11)." min/s";
						
						$amlates=$amlate_total+11;
						
						$date=$r['DATE'];
						if($xx!=1){ mysql_query("insert into INOUTDATALATES (e_no,DATE,AMLATES) values ('$e_no','$date','$amlates')") or die(mysql_error()); }
						else{}
					}
					else
					{
						$amlates=0;
						$date=$r['DATE'];
						if($xx!=1){ mysql_query("insert into INOUTDATALATES (e_no,DATE,AMLATES) values ('$e_no','$date','$amlates')") or die(mysql_error()); }
						else{}
					}
				}
				
				if($_REQUEST['time_class']==8)
				{ 
					$amin=strtotime($result_amin['TIME']); 
					$amclass=strtotime('10:10:59');
					if($amin>$amclass)
					{ 
						$amin1=date_create($result_amin['TIME']);
						$amclass1=date_create('10:11:00');
						$amlate=date_diff($amin1,$amclass1);
						$amlate_total=$amlate->format("%i%");
						echo ($amlate_total+11)." min/s";
						
						$amlates=$amlate_total+11;
						$date=$r['DATE'];
						if($xx!=1){ mysql_query("insert into INOUTDATALATES (e_no,DATE,AMLATES) values ('$e_no','$date','$amlates')") or die(mysql_error()); }
						else{}
					}
					else
					{
						$amlates=0;
						$date=$r['DATE'];
						if($xx!=1){ mysql_query("insert into INOUTDATALATES (e_no,DATE,AMLATES) values ('$e_no','$date','$amlates')") or die(mysql_error()); }
						else{}
					}
				}
				
				if($_REQUEST['time_class']==9)
				{ 
					$amin=strtotime($result_amin['TIME']); 
					$amclass=strtotime('10:40:49');
					if($amin>$amclass)
					{ 
						$amin1=date_create($result_amin['TIME']);
						$amclass1=date_create('10:41:00');
						$amlate=date_diff($amin1,$amclass1);
						$amlate_total=$amlate->format("%i%");
						echo ($amlate_total+11)." min/s";
						
						$amlates=$amlate_total+11;
						$date=$r['DATE'];
						if($xx!=1){ mysql_query("insert into INOUTDATALATES (e_no,DATE,AMLATES) values ('$e_no','$date','$amlates')") or die(mysql_error()); }
						else{}
					}
					else
					{
						$amlates=0;
						$date=$r['DATE'];
						if($xx!=1){ mysql_query("insert into INOUTDATALATES (e_no,DATE,AMLATES) values ('$e_no','$date','$amlates')") or die(mysql_error()); }
						else{}
					}
				}
				
				if($_REQUEST['time_class']==10)
				{ 
					$amin=strtotime($result_amin['TIME']); 
					$amclass=strtotime('12:10:59');
					if($amin>$amclass)
					{ 
						$amin1=date_create($result_amin['TIME']);
						$amclass1=date_create('12:11:00');
						$amlate=date_diff($amin1,$amclass1);
						$amlate_total=$amlate->format("%i%");
						echo ($amlate_total+11)." min/s";
						
						$amlates=$amlate_total+11;
						$date=$r['DATE'];
						if($xx!=1){ mysql_query("insert into INOUTDATALATES (e_no,DATE,AMLATES) values ('$e_no','$date','$amlates')") or die(mysql_error()); }
						else{}
					}
					else
					{
						$amlates=0;
						$date=$r['DATE'];
						if($xx!=1){ mysql_query("insert into INOUTDATALATES (e_no,DATE,AMLATES) values ('$e_no','$date','$amlates')") or die(mysql_error()); }
						else{}
					}
				}
				
				echo "</span>";
			  
			  echo "</td>";
			  
			  
			  
			  
			  
			  // PM  
			  echo "<td>";
			  
				$query_amout=mysql_query("SELECT TIME,LOGIN FROM INOUTDATA WHERE DATE='$date' and e_lname='$e_lname' and e_fname='$e_fname' and LOGIN='AMOUT'");
				$result_amout=mysql_fetch_Assoc($query_amout);
				
				$query_pmin=mysql_query("SELECT TIME,LOGIN FROM INOUTDATA WHERE DATE='$date' and e_lname='$e_lname' and e_fname='$e_fname' and LOGIN='PMIN'");
				$result_pmin=mysql_fetch_Assoc($query_pmin);	
				
				$query_pmout=mysql_query("SELECT TIME,LOGIN FROM INOUTDATA WHERE DATE='$date' and e_lname='$e_lname' and e_fname='$e_fname' and LOGIN='PMOUT'");
				$result_pmout=mysql_fetch_Assoc($query_pmout);	
				

				//PM total
				$pmin=date_create($result_pmin['TIME']);
				$pmout=date_create($result_pmout['TIME']);
				$pmtotal=date_diff($pmin,$pmout);
				$pm=$pmtotal->format('%h:%i');//hours computation
				
				$pmx=$pmtotal->format("%h");
				$pmy=$pmtotal->format("%i");
				$pmz=$pmx*60+$pmy;//minutes computation
				
				
				
				
				
				//OVER LUNCH BREAK / PM LATES SCRIPT
				$mins=(strtotime($result_pmin['TIME'])-strtotime($result_amout['TIME']))/60;
				echo "<span class='w3-text-red'>";
				if($mins>60)
				{ 
					echo ($mins-60)." mins";
					$pmlates=$mins-60;
					$date=$r['DATE'];
					if($xx!=1){
					mysql_query("insert into INOUTDATALATES (e_no,DATE,PMLATES) values ('$e_no','$date','$pmlates')") or die(mysql_error());
					}else{}
				}
				else
				{
					$pmlates=0;
					$date=$r['DATE'];
					if($xx!=1){
					mysql_query("insert into INOUTDATALATES (e_no,DATE,PMLATES) values ('$e_no','$date','$pmlates')") or die(mysql_error());
					}else{}
				}
				echo "</span>";
			  
			  echo "</td>";
			  
			  
			  
			  
			  
			  //UNDERTIME
			  echo "<td class='w3-text-red'>";
			  
			  $daytotal=$amz+$pmz;
			  $undertime=470-$daytotal;
			  if($daytotal<470)
			  { 
					if($undertime>60)
					{ 
						echo $undertime." min/s"; 
						$date=$r['DATE'];
						if($xx!=1){ mysql_query("insert into INOUTDATALATES (e_no,DATE,UNDERTIME) values ('$e_no','$date','$undertime')") or die(mysql_error()); }
						else{}
					} 
			  }
			  else
			  {	  
					$date=$r['DATE'];
					if($xx!=1){
					mysql_query("insert into INOUTDATALATES (e_no,DATE,UNDERTIME) values ('$e_no','$date','0')") or die(mysql_error());
					}else{}
			  }
			  
			  echo "</td>";
			  
			  
			  
			  
			  
			  
			  
			  
			  //OVERTIME  
			  echo "<td>";
				$query_otin=mysql_query("SELECT TIME,LOGIN FROM INOUTDATA WHERE DATE='$date' and e_lname='$e_lname' and e_fname='$e_fname' and LOGIN='OTIN'");
				$result_otin=mysql_fetch_Assoc($query_otin);	
				
				$query_otout=mysql_query("SELECT TIME,LOGIN FROM INOUTDATA WHERE DATE='$date' and e_lname='$e_lname' and e_fname='$e_fname' and LOGIN='OTOUT'");
				$result_otout=mysql_fetch_Assoc($query_otout);	
				
				//AM total
				$otin=date_create($result_otin['TIME']);
				$otout=date_create($result_otout['TIME']);
				$ottotal=date_diff($otin,$otout);
				$ot=$ottotal->format('%h hr %i mins');//hours computation
				
				$otx=$ottotal->format("%h");
				$oty=$ottotal->format("%i");
				$otz=$otx*60+$oty;//minutes computation
				
				if($ot>0)
				{ 
					echo "<span class='w3-text-blue'>".$ot."</span>"; 
					$date=$r['DATE'];
					mysql_query("insert into INOUTDATALATES (e_no,DATE,OVERTIME) values ('$e_no','$date','$otz')") or die(mysql_error());	
				}
				else
				{
					$date=$r['DATE'];
					mysql_query("insert into INOUTDATALATES (e_no,DATE,OVERTIME) values ('$e_no','$date','0')") or die(mysql_error());	
				}
				
			  echo "</td>";
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  //MANUAL TIME INPUT
			  echo "<td>"; 
			  
							switch($_REQUEST['time_class'])
							{
								case 1:  $time1="07:00"; $time2="7 AM";    $time11="12:01"; $time22="12:01 PM";	$time33="13:01"; $time44="1:01 PM";	$time3="15:01"; $time4="3:01 PM"; break;
								case 2:  $time1="07:00"; $time2="7 AM";    $time11="12:01"; $time22="12:01 PM";	$time33="13:01"; $time44="1:01 PM";	$time3="16:01"; $time4="4:01 PM"; break;
								case 3:  $time1="07:30"; $time2="7:30 AM"; $time11="12:01"; $time22="12:01 PM";	$time33="13:01"; $time44="1:01 PM";	$time3="16:31"; $time4="4:31 PM"; break;
								case 4:  $time1="08:00"; $time2="8 AM";    $time11="12:01"; $time22="12:01 PM";	$time33="13:01"; $time44="1:01 PM";	$time3="17:01"; $time4="5:01 PM"; break;
								case 5:  $time1="08:30"; $time2="8:30 AM"; $time11="12:01"; $time22="12:01 PM";	$time33="13:01"; $time44="1:01 PM";	$time3="17:31"; $time4="5:31 PM"; break;
								case 6:  $time1="09:00"; $time2="9 AM";    $time11="12:01"; $time22="12:01 PM";	$time33="13:01"; $time44="1:01 PM";	$time3="18:01"; $time4="6:01 PM"; break;
								case 7:  $time1="09:30"; $time2="9:30 AM"; $time11="12:01"; $time22="12:01 PM";	$time33="13:01"; $time44="1:01 PM";	$time3="18:31"; $time4="6:31 PM"; break;
								case 8:  $time1="10:00"; $time2="10 AM";   $time11="12:01"; $time22="12:01 PM";	$time33="13:01"; $time44="1:01 PM";	$time3="19:01"; $time4="7:01 PM"; break;
								case 9:  $time1="10:30"; $time2="10:30 AM"; $time11="12:01"; $time22="12:01 PM"; $time33="13:01"; $time44="1:01 PM"; $time3="19:31"; $time4="7:31 PM"; break;
								case 10: $time1="12:00"; $time2="12 NN";   $time11="14:01"; $time22="2:01 PM";	$time33="15:01"; $time44="3:01 PM";	$time3="21:01"; $time4="9:01 PM"; break;
								case 11: $time1="05:00"; $time2="5 PM";    $time11="19:01"; $time22="7:01 PM";	$time33="20:01"; $time44="8:01 PM";	$time3="01:01"; $time4="1:01 AM"; break;
							}
							
							if($_REQUEST['time_class']!=0)
							{ ?> <i class='w3-tiny'>Presets</i><br/>
								<a title='AMIN <?php  echo $time2; ?>'   class='fa fa-sign-in w3-text-pink'  href='script_dtr_per_employee.php?zkteco=1&time_class=<?php echo $_REQUEST['time_class']."&e_lname=".$_REQUEST['e_lname']."&e_fname=".$_REQUEST['e_fname']."&e_no=".$_REQUEST['e_no']."&date1=".$r['DATE']."&add_time=".$time1; ?>'></a>&nbsp;
								<a title='AMOUT <?php echo $time22; ?>'  class='fa fa-sign-out w3-text-pink' href='script_dtr_per_employee.php?zkteco=1&time_class=<?php echo $_REQUEST['time_class']."&e_lname=".$_REQUEST['e_lname']."&e_fname=".$_REQUEST['e_fname']."&e_no=".$_REQUEST['e_no']."&date1=".$r['DATE']."&add_time=".$time11; ?>'></a>&nbsp;
								<a title='PMIN <?php  echo $time44; ?>'  class='fa fa-sign-in w3-text-purple'  href='script_dtr_per_employee.php?zkteco=1&time_class=<?php echo $_REQUEST['time_class']."&e_lname=".$_REQUEST['e_lname']."&e_fname=".$_REQUEST['e_fname']."&e_no=".$_REQUEST['e_no']."&date1=".$r['DATE']."&add_time=".$time33; ?>'></a>&nbsp;
								<a title='PMOUT <?php echo $time4; ?>'   class='fa fa-sign-out w3-text-purple' href='script_dtr_per_employee.php?zkteco=1&time_class=<?php echo $_REQUEST['time_class']."&e_lname=".$_REQUEST['e_lname']."&e_fname=".$_REQUEST['e_fname']."&e_no=".$_REQUEST['e_no']."&date1=".$r['DATE']."&add_time=".$time3; ?>'></a>
					<?php	}
							else
							{ echo "<i class='w3-tiny'>No Time Class</i>"; }
			  
			  ?><i class='w3-tiny'><br/><br/>Manual</i>
				<form method='get'>
					<input name='zkteco' type='hidden' value='1'>
					<input name='time_class' type='hidden' value='<?php echo $_REQUEST['time_class'];?>'>
					<input name='e_lname' type='hidden' value='<?php echo $_REQUEST['e_lname'];?>'>
					<input name='e_fname' type='hidden' value='<?php echo $_REQUEST['e_fname'];?>'>
					<input name='e_no' type='hidden' value='<?php echo $_REQUEST['e_no'];?>'>
					<input name='date1' type='hidden' value='<?php echo $r['DATE'];?>'>
					<input required name='add_time' type='time' class='w3-tiny'><br>
					<input type='submit' value='ADD TIME' class='w3-tiny' onclick='return confirm("Are you OK with this? Sure?")'><br/>
				</form>
				
		<?php echo "</td>";
						
				$date=$r['DATE'];
				$qq=mysql_query("select id,TIME,DATE,LOGIN from INOUTDATA where e_lname='$e_lname' and e_fname='$e_fname' and DATE='$date' order by TIME");
				$rr=mysql_fetch_assoc($qq);
				
				//$x=1;
				
				do{
					echo "<td>";
						//$x++; 
						
						//$id=$rr['id'];
					
						//if($x==2){ $login="AMIN"; }
						//if($x==3){ $login="AMOUT"; }
						//if($x==4){ $login="PMIN"; }
						//if($x==5){ $login="PMOUT"; }
						//if($x==6){ $login="OTIN"; }
						//if($x==7){ $login="OTOUT"; }
					
						//mysql_query("update INOUTDATA set LOGIN='$login' where id=$id");
						
						?>
						<span onclick='return confirm("Are you sure to DELETE entry?")'>
						<?php
						echo "<a class='w3-text-red' href='script_dtr_per_employee.php?time_class=".$_REQUEST['time_class']."&e_no=".$_REQUEST['e_no']."&e_lname=".$_REQUEST['e_lname']."&e_fname=".$_REQUEST['e_fname']."&remove=1&zkteco=1&id=".$rr['id']."'><span class='w3-tiny'>x</span></a></span> ";
						echo "<span class='w3-tiny'>".$rr['LOGIN']."</span><br>";
						echo "<span class='w3-text-indigo'>".date('h:i A',strtotime($rr['TIME']))."</span>";
						
					echo "</td>";
					
				}while($rr=mysql_fetch_assoc($qq));
				
		 echo "</tr>";
		}while($r=mysql_fetch_assoc($q));

		 
		echo "<tr>
				<td></td>";
		 
		$s="select sum(AMLATES) as amlates_total,
				   sum(PMLATES) as pmlates_total,
				   sum(UNDERTIME) as undertime_total,
				   sum(OVERTIME) as overtime_total
			from INOUTDATALATES
			where e_no='$e_no'";
		$q=mysql_query($s);
		$r=mysql_fetch_assoc($q);

		$qq3=mysql_query("SELECT 
								(select COUNT(*) from INOUTDATA where e_lname='$e_lname' and e_fname='$e_fname' and LOGIN='PMOUT') AS completed_days,
								(select COUNT(*) from INOUTDATA where e_lname='$e_lname' and e_fname='$e_fname' and LOGIN='AMOUT') AS half_days
								");
		$rr3=mysql_fetch_assoc($qq3);
		
			echo "<td><b class='w3-text-red w3-large'>".$r['amlates_total']."</b> mins<br><span class='w3-tiny'>total am lates</span></td>
				  <td><b class='w3-text-red w3-large'>".$r['pmlates_total']."</b> mins<br><span class='w3-tiny'>total pm lates</span></td>
				  <td><b class='w3-text-red w3-large'>";
						if($r['undertime_total']>60)
							{ echo $r['undertime_total']; } 
					    else{ echo "0"; }
						echo "</b> mins<br><span class='w3-tiny'>total undertime</span></td>
				  <td><b class='w3-text-red w3-large'>".round($r['overtime_total']/60,2)."</b> hours<br><span class='w3-tiny'>total overtime</span></td>
				  <td>
					<b class='w3-text-blue w3-large'>".$rr3['completed_days']."</b> <span class='w3-small'>Complete Days</span><br/>
					<b class='w3-text-blue w3-large'>".number_format($rr3['half_days']-$rr3['completed_days'])."</b> <span class='w3-small'>Half Days</span>
				  </td>";
		?>

				<form>
					<input name='zkteco' type='hidden' value='1'>
					<input name='total_completed_day' type='hidden' value='<?php echo $rr3['completed_days'];?>'>
					<input name='total_half_day' type='hidden' value='<?php echo $rr3['half_days'];?>'>
					<input name='amlates' type='hidden' value='<?php echo $r['amlates_total'];?>'>
					<input name='pmlates' type='hidden' value='<?php echo $r['pmlates_total'];?>'>
					<input name='undertime' type='hidden' value='<?php echo $r['undertime_total'];?>'>
					<input name='overtime' type='hidden' value='<?php echo $r['overtime_total'];?>'>
					<input name='time_class' type='hidden' value='<?php echo $_REQUEST['time_class'];?>'>
					<input name='e_no' type='hidden' value='<?php echo $_REQUEST['e_no'];?>'>
					<input name='e_lname' type='hidden' value='<?php echo $_REQUEST['e_lname'];?>'>
					<input name='e_fname' type='hidden' value='<?php echo $_REQUEST['e_fname'];?>'>
					<input name='send_to_payroll' type='hidden' value='1'>
					<input type='submit' value='SUBMIT TO PAYROLL' class='btn w3-blue w3-tiny' onclick='return confirm("Are you OK with this? Sure?")'>
				</form>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
				<form>
					<input name='zkteco' type='hidden' value='1'>
					<input name='amlates' type='hidden' value='<?php echo $r['amlates_total'];?>'>
					<input name='pmlates' type='hidden' value='<?php echo $r['pmlates_total'];?>'>
					<input name='e_no' type='hidden' value='<?php echo $_REQUEST['e_no'];?>'>
					<input name='time_class' type='hidden' value='<?php echo $_REQUEST['time_class'];?>'>
					
					<input name='e_lname' type='hidden' value='<?php echo $_REQUEST['e_lname'];?>'>
					<input name='e_fname' type='hidden' value='<?php echo $_REQUEST['e_fname'];?>'>
					<input name='add_date' type='hidden' value='1'>
					<input name='date' type='date' class='btn w3-pale-red w3-tiny' required>&nbsp;
					<input type='submit' value='ADD DATE' class='btn w3-deep-orange w3-tiny' onclick='return confirm("is the date OK? Sure?")'>
				</form>  
				  
		<?php		  
		echo "</tr>"; 

		echo "</table>"; 
		
}





mysql_query("delete from INOUTDATALATES where AMLATES=0 and PMLATES=0 and UNDERTIME=0 and OVERTIME=0 and UPDATED=0") or die(mysql_error());	

?>

</div>