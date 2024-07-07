<?php 
include('connection/conn.php');
session_start();
date_default_timezone_set("Asia/Manila");
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); }

include("css.php"); 
include("current_user.php");
$bch=$r9['bch'];

$department=$r9['department'];

if($r9['bch']=="goc")
{
	if(isset($_REQUEST['sort']))
	{ 
		switch($_REQUEST['sort'])
		{
			case "main": $dept="and c.department='SALES'"; break; 
			case "sm": $dept="and c.department='SM SALES'"; break; 
			case "rzl": $dept="and c.department='RIZAL SALES'"; break;
			case "sp": $dept="and c.department='SANPEDRO SALES'"; break; 
			case "sj": $dept="and c.department='SANJOSE SALES'"; break;
		}
		$filter="";
		$date_filter="";
	}
	
	elseif(isset($_REQUEST['filter']))
	{
		$dept="";
		
		$filter1=$_REQUEST['filter']; $filter=" and client_id=$filter1";
		
		if(isset($_REQUEST['sdate']))
		{	$sdate=$_REQUEST['sdate']; $edate=$_REQUEST['edate'];
			$date_filter=" and a.jo_actual_date>='$sdate' and a.jo_actual_date<='$edate'";
		}else{ $date_filter=""; }
		
		
	}
	elseif(isset($_REQUEST['sdate']))
	{
		$dept="";
		
		if(isset($_REQUEST['filter']))
		{ 	$filter=" and client_id=$filter1";
		}else{ $filter=""; }
		
		$sdate=$_REQUEST['sdate']; $edate=$_REQUEST['edate'];
		$date_filter=" and a.jo_actual_date>='$sdate' and a.jo_actual_date<='$edate'";
	}
	else
	{ 
		$dept=""; 
		$filter=""; 
		$date_filter="";
	}
}

else{ 
		$dept="and c.department='$department'"; 
		$filter=""; 
		$date_filter=""; 
	}


//TOTAL COMPUTATION
$ps2="select sum(b.b_qty*b.b_amount) as jo_total_amount
      from sales_jo as a
      inner join sales_bookings_details as b on a.b_id=b.b_id
	  left join users as c on a.created_by=c.username
	  where (select sum(dr_qty) from sales_bookings_details where b_id=b.b_id) < (select sum(b_qty) from sales_bookings_details where b_id=b.b_id)
	  and a.completed_by='' $dept $filter $date_filter";
	 
	 $pq2=mysql_query($ps2) or die(mysql_error());
	 $pr2=mysql_fetch_assoc($pq2);

?>
<table border='1'>
	<tr align='center' class='w3-small w3-green'>
		<td colspan='14'>&nbsp;
				<i>JOB ORDER : PENDING : <b class='w3-large w3-text-sand'><?php echo "PENDING AMOUNT&nbsp;&nbsp;&nbsp;&nbsp;".number_format(round($pr2['jo_total_amount'],2),2); ?></b></i>
		  <?php if($r9['bch']=="goc")
				{ 
					echo "<div>";
					echo "<a class='w3-text-sand' href='script_sales_jo_pending_list.php'>SHOW ALL</a>&nbsp;&nbsp;&nbsp;&nbsp;";
					echo "<a class='w3-text-sand' href='script_sales_jo_pending_list.php?sort=main'>SHOW MAIN</a>&nbsp;&nbsp;&nbsp;&nbsp;";
					echo "<a class='w3-text-sand' href='script_sales_jo_pending_list.php?sort=sm'>SHOW SM</a>&nbsp;&nbsp;&nbsp;&nbsp;";
					echo "<a class='w3-text-sand' href='script_sales_jo_pending_list.php?sort=rzl'>SHOW RIZAL</a>&nbsp;&nbsp;&nbsp;&nbsp;";
					echo "<a class='w3-text-sand' href='script_sales_jo_pending_list.php?sort=sp'>SHOW SANPEDRO</a>&nbsp;&nbsp;&nbsp;&nbsp;";
					echo "<a class='w3-text-sand' href='script_sales_jo_pending_list.php?sort=sj'>SHOW SANJOSE</a></div><br/>";

					
					echo "<form class='w3-tiny'>";
							
						    if(isset($_REQUEST['sdate']))
							{ 
								echo "<input name='sdate' type='hidden' value='".$_REQUEST['sdate']."'>"; 
								echo "<input name='edate' type='hidden' value='".$_REQUEST['edate']."'>"; 
							}else{}
							
							echo "<input class='w3-text-indigo' name='filter' type='number' placeholder='input client_id'>";
							echo "<input class='w3-text-indigo' type='submit' value='client filter'>
						  </form>";
					
					
					echo "<form class='w3-tiny'>";
							
							if(isset($_REQUEST['filter']))
							{ echo "<input name='filter' type='hidden' value='".$_REQUEST['filter']."'>"; }else{}
						
							echo "<input class='w3-text-indigo' name='sdate' type='date' value='".$_REQUEST['sdate']."'>";
							echo "<input class='w3-text-indigo' name='edate' type='date' value='".$_REQUEST['edate']."'>";
							echo "<input class='w3-text-indigo' type='submit' value='date filter'>
						  </form>";	  
				}
				?>
		</td>
	</tr>
	
	<tr class='w3-tiny w3-pale-green'>
	    <td>#</td>
		<td><b>CLIENT ID</b></td>
		<td><b>CLIENT</b></td>
		<td><b>CREATED DATE</b></td>
		<td align='center'><b>JO ACTUAL</b></td>
		<td align='center'><b>JO BY</b></td>
		<td align='center'><b>BOOKING</b></td>
		<td align='center'><b>JO BY</b></td>
		<td align='center'><b>BRANCH</b></td>
		<td align='center'><b>DAYS PENDING</b></td>
		<td align='center'><b>DR DETAILS</b></td>
		<td><b>TOTAL AMOUNT</b></td>
		<td><b>BALANCE</b></td>
		<td><b>STATUS</b></td>
		<td align='right'><b>ARTIST</b></td>
	</tr>


	
<?php
	//QUERY LIST
	$ps="select a.*, c.department
		 from sales_jo as a
		 inner join sales_bookings_details as b on a.b_id=b.b_id
		 left join users as c on a.created_by=c.username
		 where 
			(select sum(dr_qty) from sales_bookings_details where b_id=b.b_id) < (select sum(b_qty) from sales_bookings_details where b_id=b.b_id)
		 and a.completed_by='' $dept $filter $date_filter group by a.jo_no order by c.department asc, a.jo_actual_date desc";
	
	$pq=mysql_query($ps) or die(mysql_error());
	$pr=mysql_fetch_assoc($pq);
	$x=1;
	
//QUERY RESULT	
do{
	echo "<tr class='w3-tiny w3-hover-pale-red' align='right' valign='top'>";
		echo "<td align='left'>".$x++."</td>";
		echo "<td align='left'>".$pr['client_id']."</td>";
		echo "<td align='left'>";
		
			$client_id=$pr['client_id'];
			$ssa=mysql_query("select name from sales_clients where client_id=$client_id") or die(mysql_error());
			$rsa=mysql_fetch_assoc($ssa);
			echo "<a href='admin_sales.php?client_id=".$pr['client_id']."&client=".$rsa['name']."&sales=1&newjobs=1&create_quotation=1' target='_blank'><b>".$rsa['name']."</b></a>";
		
		echo "</td>";
		echo "<td align='center'>".date('m/d/Y',strtotime($pr['created_datetime']))."</td>";
		echo "<td><b>".$pr['jo_actual']."</b></td>";
		echo "<td><b>".$pr['bo_no']."</b></td>";
		echo "<td align='center'>".$pr['created_by']."</td>";
		
		echo "<td align='center'>".$pr['department']."</td>";
		
		echo "<td align='center'>";
			$dr_date_old = strtotime($pr['jo_actual_date']);
			$now = strtotime(date('Y-m-d'));
			$day = ((($now-$dr_date_old)/3600)/24) ;
			echo "<i class='w3-tiny w3-text-red'><b>".$day."</b></i>";
		echo "</td>";
		echo "<td>";
			$b_id=$pr['b_id'];
		
			$sbid1="select code_set from sales_bookings_details where b_id=$b_id";
			$qbid1=mysql_query($sbid1) or die(mysql_error());
			$rbid1=mysql_fetch_assoc($qbid1);
			do{ echo $rbid1['code_set']."&nbsp;"; }while($rbid1=mysql_fetch_assoc($qbid1));
			
			
			$sbid="select * from sales_bookings_details where b_id=$b_id and b_qty!=dr_qty";
			$qbid=mysql_query($sbid) or die(mysql_error());
			$rbid=mysql_fetch_assoc($qbid);
			
			if($rbid['dr_qty']!=0)
			{
				echo "<table class='w3-tiny' border='1' width='100%'>
							<tr class='w3-light-gray'>
								<td>prejo</td><td>code</td><td>jo_qty</td><td>dr_qty</td><td>dr_no</td><td>dr_date</td><td>type</td>
							</tr>";
				do{
					echo "<tr>";
						echo "<td class='w3-text-green'>".$rbid['b_id']."</td>
							  <td>".$rbid['code_set']."</td>
							  <td class='w3-text-indigo'><b>".$rbid['b_qty']."</b></td>
							  <td class='w3-text-orange'><b>".$rbid['dr_qty']."</b></td>
							  <td>".$rbid['dr_no']."</td>
							  <td>".date('m/d/Y',strtotime($rbid['dr_date']))."</td>
							  <td>";
								if($rbid['dr_partial']==1){ echo "<i class='w3-text-red'>partial</i>"; } else {}
						echo "</td>";
					echo "</tr>";
				}while($rbid=mysql_fetch_assoc($qbid));
				
				echo "</table>";
			}
		
		
		echo "</td>";
		echo "<td><b class='w3-text-blue'>".number_format($pr['jo_amount'],2)."</b></td>";
		echo "<td>
				<b class='w3-text-red'>";
				$balance=$pr['jo_amount']-$pr['jo_payment_amount'];
				if($balance!=0)
				{ echo number_format($pr['jo_amount']-$pr['jo_payment_amount'],2); }else{}
		  echo "</b>
			  </td>";
		echo "<td align='center'>";
			 if($pr['paid']==1){ echo "<i class='w3-text-green'>PAID</i>"; } else { echo "<i class='w3-text-red'>&nbsp;NOT PAID</i>"; }
		echo "</td>";
		echo "<td>";
			  $jo_nox=$pr['jo_no'];
			  $qjo=mysql_query("select * from sales_jo_assign where jo_no=$jo_nox") or die(mysql_error());
			  $rjo=mysql_fetch_assoc($qjo);
			  if($rjo['assign_to']!=''){ echo $rjo['assign_to']." ".date('d/m/Y',strtotime($rjo['assign_date'])); }
		echo "</td>";
	echo "</tr>"; 
}while($pr=mysql_fetch_assoc($pq));	
?>
	
</table>
<br/>	
