<?php 
include('connection/conn.php');
include("css.php");

if(isset($_REQUEST['year'])){ $year=$_REQUEST['year']; $year_link=$_REQUEST['year']; }
else { $year=date("Y"); $year_link=""; }

?>
<title>VIP REPORT</title>
<head>
  <!--<meta http-equiv="refresh" content="60">-->
  
  	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    
</head>
<body>

	<div class='w3-container'>
	<!--<i>NOTE: Page auto refresh every 1 minute.</i>-->
	
	
	
	<?php //SHOW REPORT PER YEAR
	$sxxx=mysql_query("SELECT created_datetime as year1 FROM `sales_jo` GROUP BY YEAR(created_datetime)");
	$rxxx=mysql_fetch_assoc($sxxx);
	do{ ?>
	<a href='<?php echo "vipreport.php?year=".date('Y',strtotime($rxxx['year1'])); ?>'><i>(VIEW <?php echo date('Y',strtotime($rxxx['year1'])); ?>)</i></a>&nbsp;&nbsp;
	<?php }while($rxxx=mysql_fetch_assoc($sxxx)); ?>
	
	
	
	<!-- CURRENT DAY  -->
	<table class='w3-table' border='1'>
		<?php
		$q_jo_common="SELECT SUM(a.jo_amount) FROM sales_jo a LEFT JOIN users b ON a.created_by = b.username";
		$q_dr_common="SELECT SUM(a.dr_qty * a.b_amount) FROM sales_bookings_details a";
		$q_payment_common="SELECT SUM(a.payment) FROM sales_jo_payments a LEFT JOIN sales_jo b ON a.jo_no = b.jo_no LEFT JOIN users c ON b.created_by = c.username";
		
		
		$date=date("Y-m-d");
		
		$query_jo="$q_jo_common WHERE a.created_datetime LIKE '$date%' AND b.department";
		$query_dr="$q_dr_common WHERE a.dr_date LIKE '$date' AND a.bch";
		$query_payment="$q_payment_common WHERE a.payment_datetime LIKE '$date%' AND c.department";
		//$query_payment="$q_payment_common WHERE a.payment_datetime LIKE '$date%' AND b.created_datetime LIKE '$date%' AND c.department";
		
		$s="SELECT
				( $query_jo = 'SALES' ) AS main_total_jo,
				( $query_jo = 'SM SALES' ) AS sm_total_jo,
				( $query_jo = 'SANPEDRO SALES' ) AS sp_total_jo,	
				( $query_jo = 'SANJOSE SALES' ) AS sj_total_jo,
				( $query_jo = 'RIZAL SALES' ) AS rzl_total_jo,
				( $query_jo = 'ADPLUS SALES' ) AS adpls_total_jo,
					
				( $query_dr = 'main' ) AS main_total_dr,
				( $query_dr = 'sm' ) AS sm_total_dr,
				( $query_dr = 'sp' ) AS sp_total_dr,
				( $query_dr = 'sj' ) AS sj_total_dr,	
				( $query_dr = 'rzl' ) AS rzl_total_dr,
				( $query_dr = 'adpls' ) AS adpls_total_dr,
				
				( $query_payment = 'SALES' ) AS main_total_payment,
				( $query_payment = 'SM SALES' ) AS sm_total_payment,
				( $query_payment = 'SANPEDRO SALES' ) AS sp_total_payment,
				( $query_payment = 'SANJOSE SALES' ) AS sj_total_payment,
				( $query_payment = 'RIZAL SALES' ) AS rzl_total_payment,
				( $query_payment = 'ADPLUS SALES' ) AS adpls_total_payment
			";
		
		$q=mysql_query($s) or die(mysql_error());
		$r1=mysql_fetch_assoc($q);
		?>
		
		
		<tr class='w3-green'>
			<td></td>
			<td>TRANSACTION</td>
			<td>ALC TOTAL</td>
			<td>ALC MAIN</td>
			<td>ALC SM</td>
			<td>ALC SAN PEDRO</td>
			<td>ALC SAN JOSE</td>
			<td>ALC RIZAL</td>
			<td>ADPLUS</td>
		</tr>
		
		<tr>
			<td rowspan='4'><?php echo date('F d, Y')." (TODAY) ".date('l'); ?></td>
			<td class='w3-text-indigo'> &nbsp;JO CREATED</td>
			<?php echo "<td><b>".number_format($r1['main_total_jo']+$r1['sm_total_jo']+$r1['sp_total_jo']+$r1['sj_total_jo']+$r1['rzl_total_jo'],2)."</b></td>";
				  if($r1['main_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&current_day=1&jo_main=1' target='_blank'><b>".number_format($r1['main_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r1['sm_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&current_day=1&jo_sm=1' target='_blank'><b>".number_format($r1['sm_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r1['sp_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&current_day=1&jo_sp=1' target='_blank'><b>".number_format($r1['sp_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r1['sj_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&current_day=1&jo_sj=1' target='_blank'><b>".number_format($r1['sj_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r1['rzl_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&current_day=1&jo_rzl=1' target='_blank'><b>".number_format($r1['rzl_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";} 
				  if($r1['adpls_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&current_day=1&jo_adpls=1' target='_blank'><b>".number_format($r1['adpls_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";} ?>
		</tr>
		
		<tr>
			<td class='w3-text-purple'>PAYMENTS RECIEVED</td>
			<?php echo "<td><b>".number_format($r1['main_total_payment']+$r1['sm_total_payment']+$r1['sp_total_payment']+$r1['sj_total_payment']+$r1['rzl_total_payment'],2)."</b></td>";
				  if($r1['main_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&current_day=1&jo_main=1' target='_blank'><b>".number_format($r1['main_total_payment'],2)."</a></b></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r1['sm_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&current_day=1&jo_sm=1' target='_blank'><b>".number_format($r1['sm_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r1['sp_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&current_day=1&jo_sp=1' target='_blank'><b>".number_format($r1['sp_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r1['sj_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&current_day=1&jo_sj=1' target='_blank'><b>".number_format($r1['sj_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r1['rzl_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&current_day=1&jo_rzl=1' target='_blank'><b>".number_format($r1['rzl_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r1['adpls_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&current_day=1&jo_adpls=1' target='_blank'><b>".number_format($r1['adpls_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}?>
		</tr>
		
		<tr>
			<td class='w3-text-brown'>TOTAL DR</td>
			<?php echo "<td><b>".number_format($r1['main_total_dr']+$r1['sm_total_dr']+$r1['sp_total_dr']+$r1['sj_total_dr']+$r1['rzl_total_dr'],2)."</b></td>";
				  if($r1['main_total_dr']){echo "<td><a href='vipreport_detailed.php?dr_list=1&current_day=1&jo_main=1' target='_blank'><b>".number_format($r1['main_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r1['sm_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&current_day=1&jo_sm=1' target='_blank'><b>".number_format($r1['sm_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r1['sp_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&current_day=1&jo_sp=1' target='_blank'><b>".number_format($r1['sp_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r1['sj_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&current_day=1&jo_sj=1' target='_blank'><b>".number_format($r1['sj_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r1['rzl_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&current_day=1&jo_rzl=1' target='_blank'><b>".number_format($r1['rzl_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r1['adpls_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&current_day=1&jo_adpls=1' target='_blank'><b>".number_format($r1['adpls_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";} ?>
		</tr>
	
	
	
	
	<!-- 1 DAY AGO  -->
		<?php
		$date=date(("Y-m-d"),strtotime("-1 day"));
		
		$this_day = date(('F d, Y'),strtotime("-1 day"))." (1 DAY AGO) ".date(('l'),strtotime("-1 day"));
		
		$query_jo="$q_jo_common WHERE a.created_datetime LIKE '$date%' AND b.department";
		$query_dr="$q_dr_common WHERE a.dr_date LIKE '$date' AND a.bch";
		$query_payment="$q_payment_common WHERE a.payment_datetime LIKE '$date%' AND c.department";	
		
		$s="SELECT
				( $query_jo = 'SALES' ) AS main_total_jo,
				( $query_jo = 'SM SALES' ) AS sm_total_jo,
				( $query_jo = 'SANPEDRO SALES' ) AS sp_total_jo,	
				( $query_jo = 'SANJOSE SALES' ) AS sj_total_jo,
				( $query_jo = 'RIZAL SALES' ) AS rzl_total_jo,
				( $query_jo = 'ADPLUS SALES' ) AS adpls_total_jo,	
					
				( $query_dr = 'main' ) AS main_total_dr,
				( $query_dr = 'sm' ) AS sm_total_dr,
				( $query_dr = 'sp' ) AS sp_total_dr,
				( $query_dr = 'sj' ) AS sj_total_dr,	
				( $query_dr = 'rzl' ) AS rzl_total_dr,
				( $query_dr = 'adpls' ) AS adpls_total_dr,
				
				( $query_payment = 'SALES' ) AS main_total_payment,
				( $query_payment = 'SM SALES' ) AS sm_total_payment,
				( $query_payment = 'SANPEDRO SALES' ) AS sp_total_payment,
				( $query_payment = 'SANJOSE SALES' ) AS sj_total_payment,
				( $query_payment = 'RIZAL SALES' ) AS rzl_total_payment,
				( $query_payment = 'ADPLUS SALES' ) AS adpls_total_payment
			";
		$q=mysql_query($s) or die(mysql_error());
		$r2=mysql_fetch_assoc($q);
		?>
		
		
		<tr class='w3-tiny w3-light-gray'>
			<td colspan='7'>&nbsp;</td>
		</tr>
		
		<tr>
			<td rowspan='4'><?php echo $this_day; ?></td>
			<td class='w3-text-indigo'> &nbsp;JO CREATED</td>
			<?php echo "<td><b>".number_format($r2['main_total_jo']+$r2['sm_total_jo']+$r2['sp_total_jo']+$r2['sj_total_jo']+$r2['rzl_total_jo'],2)."</b></td>";
				  if($r2['main_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&1day_ago=1&jo_main=1' target='_blank'><b>".number_format($r2['main_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r2['sm_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&1day_ago=1&jo_sm=1' target='_blank'><b>".number_format($r2['sm_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r2['sp_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&1day_ago=1&jo_sp=1' target='_blank'><b>".number_format($r2['sp_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r2['sj_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&1day_ago=1&jo_sj=1' target='_blank'><b>".number_format($r2['sj_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r2['rzl_total_jo']!=0){ echo "<td><a 0href='vipreport_detailed.php?jo_list=1&1day_ago=1&jo_rzl=1' target='_blank'><b>".number_format($r2['rzl_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r2['adpls_total_jo']!=0){ echo "<td><a 0href='vipreport_detailed.php?jo_list=1&1day_ago=1&jo_adpls=1' target='_blank'><b>".number_format($r2['adpls_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}?>
		</tr>
		
		<tr>
			<td class='w3-text-purple'>PAYMENTS RECIEVED</td>
			<?php echo "<td><b>".number_format($r2['main_total_payment']+$r2['sm_total_payment']+$r2['sp_total_payment']+$r2['sj_total_payment']+$r2['rzl_total_payment'],2)."</b></td>";
				  if($r2['main_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&1day_ago=1&jo_main=1' target='_blank'><b>".number_format($r2['main_total_payment'],2)."</a></b></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r2['sm_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&1day_ago=1&jo_sm=1' target='_blank'><b>".number_format($r2['sm_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r2['sp_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&1day_ago=1&jo_sp=1' target='_blank'><b>".number_format($r2['sp_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r2['sj_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&1day_ago=1&jo_sj=1' target='_blank'><b>".number_format($r2['sj_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r2['rzl_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&1day_ago=1&jo_rzl=1' target='_blank'><b>".number_format($r2['rzl_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r2['adpls_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&1day_ago=1&jo_adpls=1' target='_blank'><b>".number_format($r2['adpls_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}?>
		</tr>
		
		<tr>
			<td class='w3-text-brown'>TOTAL DR</td>
			<?php echo "<td><b>".number_format($r2['main_total_dr']+$r2['sm_total_dr']+$r2['sp_total_dr']+$r2['sj_total_dr']+$r2['rzl_total_dr'],2)."</b></td>";
				  if($r2['main_total_dr']){echo "<td><a href='vipreport_detailed.php?dr_list=1&1day_ago=1&jo_main=1' target='_blank'><b>".number_format($r2['main_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r2['sm_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&1day_ago=1&jo_sm=1' target='_blank'><b>".number_format($r2['sm_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r2['sp_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&1day_ago=1&jo_sp=1' target='_blank'><b>".number_format($r2['sp_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r2['sj_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&1day_ago=1&jo_sj=1' target='_blank'><b>".number_format($r2['sj_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r2['rzl_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&1day_ago=1&jo_rzl=1' target='_blank'><b>".number_format($r2['rzl_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r2['adpls_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&1day_ago=1&jo_adpls=1' target='_blank'><b>".number_format($r2['adpls_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}	?>
		</tr>
		
		
		
		<!-- 2 DAY AGO  -->
		<?php
	
		$date=date(("Y-m-d"),strtotime("-2 day"));
		
		$this_day = date(('F d, Y'),strtotime("-2 day"))." (2 DAYS AGO) ".date(('l'),strtotime("-2 day"));
		
		$query_jo="$q_jo_common WHERE a.created_datetime LIKE '$date%' AND b.department";
		$query_dr="$q_dr_common WHERE a.dr_date LIKE '$date' AND a.bch";
		$query_payment="$q_payment_common WHERE a.payment_datetime LIKE '$date%' AND c.department";	
		
		$s="SELECT
				( $query_jo = 'SALES' ) AS main_total_jo,
				( $query_jo = 'SM SALES' ) AS sm_total_jo,
				( $query_jo = 'SANPEDRO SALES' ) AS sp_total_jo,	
				( $query_jo = 'SANJOSE SALES' ) AS sj_total_jo,
				( $query_jo = 'RIZAL SALES' ) AS rzl_total_jo,
				( $query_jo = 'ADPLUS SALES' ) AS adpls_total_jo,

				( $query_dr = 'main' ) AS main_total_dr,
				( $query_dr = 'sm' ) AS sm_total_dr,
				( $query_dr = 'sp' ) AS sp_total_dr,
				( $query_dr = 'sj' ) AS sj_total_dr,	
				( $query_dr = 'rzl' ) AS rzl_total_dr,
				( $query_dr = 'adpls' ) AS adpls_total_dr,				
				
				( $query_payment = 'SALES' ) AS main_total_payment,
				( $query_payment = 'SM SALES' ) AS sm_total_payment,
				( $query_payment = 'SANPEDRO SALES' ) AS sp_total_payment,
				( $query_payment = 'SANJOSE SALES' ) AS sj_total_payment,
				( $query_payment = 'RIZAL SALES' ) AS rzl_total_payment,
				( $query_payment = 'ADPLUS SALES' ) AS adpls_total_payment
			";
			
		$q=mysql_query($s) or die(mysql_error());
		$r3=mysql_fetch_assoc($q);
		?>
		
		
		<tr class='w3-tiny w3-light-gray'>
			<td colspan='7'>&nbsp;</td>
		</tr>
		
		<tr>
			<td rowspan='4'><?php echo $this_day; ?></td>
			<td class='w3-text-indigo'> &nbsp;JO CREATED</td>
			<?php echo "<td><b>".number_format($r3['main_total_jo']+$r3['sm_total_jo']+$r3['sp_total_jo']+$r3['sj_total_jo']+$r3['rzl_total_jo'],2)."</b></td>";
				  if($r3['main_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&2day_ago=1&jo_main=1' target='_blank'><b>".number_format($r3['main_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r3['sm_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&2day_ago=1&jo_sm=1' target='_blank'><b>".number_format($r3['sm_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r3['sp_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&2day_ago=1&jo_sp=1' target='_blank'><b>".number_format($r3['sp_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r3['sj_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&2day_ago=1&jo_sj=1' target='_blank'><b>".number_format($r3['sj_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r3['rzl_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&2day_ago=1&jo_rzl=1' target='_blank'><b>".number_format($r3['rzl_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r3['adpls_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&2day_ago=1&jo_adpls=1' target='_blank'><b>".number_format($r3['adpls_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}?>
		</tr>
		
		<tr>
			<td class='w3-text-purple'>PAYMENTS RECIEVED</td>
			<?php echo "<td><b>".number_format($r3['main_total_payment']+$r3['sm_total_payment']+$r3['sp_total_payment']+$r3['sj_total_payment']+$r3['rzl_total_payment'],2)."</b></td>";
				  if($r3['main_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&2day_ago=1&jo_main=1' target='_blank'><b>".number_format($r3['main_total_payment'],2)."</a></b></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r3['sm_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&2day_ago=1&jo_sm=1' target='_blank'><b>".number_format($r3['sm_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r3['sp_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&2day_ago=1&jo_sp=1' target='_blank'><b>".number_format($r3['sp_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r3['sj_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&2day_ago=1&jo_sj=1' target='_blank'><b>".number_format($r3['sj_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r3['rzl_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&2day_ago=1&jo_rzl=1' target='_blank'><b>".number_format($r3['rzl_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r3['adpls_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&2day_ago=1&jo_adpls=1' target='_blank'><b>".number_format($r3['adpls_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}	?>
		</tr>
		
		<tr>
			<td class='w3-text-brown'>TOTAL DR</td>
			<?php echo "<td><b>".number_format($r3['main_total_dr']+$r3['sm_total_dr']+$r3['sp_total_dr']+$r3['sj_total_dr']+$r3['rzl_total_dr'],2)."</b></td>";
				  if($r3['main_total_dr']){echo "<td><a href='vipreport_detailed.php?dr_list=1&2day_ago=1&jo_main=1' target='_blank'><b>".number_format($r3['main_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r3['sm_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&2day_ago=1&jo_sm=1' target='_blank'><b>".number_format($r3['sm_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r3['sp_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&2day_ago=1&jo_sp=1' target='_blank'><b>".number_format($r3['sp_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r3['sj_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&2day_ago=1&jo_sj=1' target='_blank'><b>".number_format($r3['sj_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r3['rzl_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&2day_ago=1&jo_rzl=1' target='_blank'><b>".number_format($r3['rzl_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r3['adpls_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&2day_ago=1&jo_adpls=1' target='_blank'><b>".number_format($r3['adpls_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}				  ?>
		</tr>
		
		
		
		<!-- 3 DAYS AGO  -->
		<?php
	
		$date=date(("Y-m-d"),strtotime("-3 day"));
		
		$this_day = date(('F d, Y'),strtotime("-3 day"))." (3 DAYS AGO) ".date(('l'),strtotime("-3 day"));
		
		$query_jo="$q_jo_common WHERE a.created_datetime LIKE '$date%' AND b.department";
		$query_dr="$q_dr_common WHERE a.dr_date LIKE '$date' AND a.bch";
		$query_payment="$q_payment_common WHERE a.payment_datetime LIKE '$date%' AND c.department";	
		
		$s="SELECT
				( $query_jo = 'SALES' ) AS main_total_jo,
				( $query_jo = 'SM SALES' ) AS sm_total_jo,
				( $query_jo = 'SANPEDRO SALES' ) AS sp_total_jo,	
				( $query_jo = 'SANJOSE SALES' ) AS sj_total_jo,
				( $query_jo = 'RIZAL SALES' ) AS rzl_total_jo,
				( $query_jo = 'ADPLUS SALES' ) AS adpls_total_jo,
					
				( $query_dr = 'main' ) AS main_total_dr,
				( $query_dr = 'sm' ) AS sm_total_dr,
				( $query_dr = 'sp' ) AS sp_total_dr,
				( $query_dr = 'sj' ) AS sj_total_dr,	
				( $query_dr = 'rzl' ) AS rzl_total_dr,
				( $query_dr = 'adpls' ) AS adpls_total_dr,
				
				( $query_payment = 'SALES' ) AS main_total_payment,
				( $query_payment = 'SM SALES' ) AS sm_total_payment,
				( $query_payment = 'SANPEDRO SALES' ) AS sp_total_payment,
				( $query_payment = 'SANJOSE SALES' ) AS sj_total_payment,
				( $query_payment = 'RIZAL SALES' ) AS rzl_total_payment,
				( $query_payment = 'ADPLUS SALES' ) AS adpls_total_payment
			";
			
		$q=mysql_query($s) or die(mysql_error());
		$r4=mysql_fetch_assoc($q);
		?>
		
		
		<tr class='w3-tiny w3-light-gray'>
			<td colspan='7'>&nbsp;</td>
		</tr>
		
		<tr>
			<td rowspan='4'><?php echo $this_day; ?></td>
			<td class='w3-text-indigo'> &nbsp;JO CREATED</td>
			<?php echo "<td><b>".number_format($r4['main_total_jo']+$r4['sm_total_jo']+$r4['sp_total_jo']+$r4['sj_total_jo']+$r4['rzl_total_jo'],2)."</b></td>";
				  if($r4['main_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&3day_ago=1&jo_main=1' target='_blank'><b>".number_format($r4['main_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r4['sm_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&3day_ago=1&jo_sm=1' target='_blank'><b>".number_format($r4['sm_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r4['sp_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&3day_ago=1&jo_sp=1' target='_blank'><b>".number_format($r4['sp_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r4['sj_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&3day_ago=1&jo_sj=1' target='_blank'><b>".number_format($r4['sj_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r4['rzl_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&3day_ago=1&jo_rzl=1' target='_blank'><b>".number_format($r4['rzl_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r4['adpls_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&3day_ago=1&jo_adpls=1' target='_blank'><b>".number_format($r4['adpls_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";} ?>
		</tr>
		
		<tr>
			<td class='w3-text-purple'>PAYMENTS RECIEVED</td>
			<?php echo "<td><b>".number_format($r4['main_total_payment']+$r4['sm_total_payment']+$r4['sp_total_payment']+$r4['sj_total_payment']+$r4['rzl_total_payment'],2)."</b></td>";
				  if($r4['main_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&3day_ago=1&jo_main=1' target='_blank'><b>".number_format($r4['main_total_payment'],2)."</a></b></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r4['sm_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&3day_ago=1&jo_sm=1' target='_blank'><b>".number_format($r4['sm_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r4['sp_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&3day_ago=1&jo_sp=1' target='_blank'><b>".number_format($r4['sp_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r4['sj_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&3day_ago=1&jo_sj=1' target='_blank'><b>".number_format($r4['sj_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r4['rzl_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&3day_ago=1&jo_rzl=1' target='_blank'><b>".number_format($r4['rzl_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r4['adpls_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&3day_ago=1&jo_adpls=1' target='_blank'><b>".number_format($r4['adpls_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}?>
		</tr>
		
		<tr>
			<td class='w3-text-brown'>TOTAL DR</td>
			<?php echo "<td><b>".number_format($r4['main_total_dr']+$r4['sm_total_dr']+$r4['sp_total_dr']+$r4['sj_total_dr']+$r4['rzl_total_dr'],2)."</b></td>";
				  if($r4['main_total_dr']){echo "<td><a href='vipreport_detailed.php?dr_list=1&3day_ago=1&jo_main=1' target='_blank'><b>".number_format($r4['main_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r4['sm_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&3day_ago=1&jo_sm=1' target='_blank'><b>".number_format($r4['sm_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r4['sp_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&3day_ago=1&jo_sp=1' target='_blank'><b>".number_format($r4['sp_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r4['sj_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&3day_ago=1&jo_sj=1' target='_blank'><b>".number_format($r4['sj_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r4['rzl_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&3day_ago=1&jo_rzl=1' target='_blank'><b>".number_format($r4['rzl_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r4['adpls_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&3day_ago=1&jo_adpls=1' target='_blank'><b>".number_format($r4['adpls_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}?>
		</tr>
		
		<!-- 4 DAYS AGO  -->
		<?php
	
		$date=date(("Y-m-d"),strtotime("-4 day"));
		
		$this_day = date(('F d, Y'),strtotime("-4 day"))." (4 DAYS AGO) ".date(('l'),strtotime("-4 day"));
		
		$query_jo="$q_jo_common WHERE a.created_datetime LIKE '$date%' AND b.department";
		$query_dr="$q_dr_common WHERE a.dr_date LIKE '$date' AND a.bch";
		$query_payment="$q_payment_common WHERE a.payment_datetime LIKE '$date%' AND c.department";	
		
		$s="SELECT
				( $query_jo = 'SALES' ) AS main_total_jo,
				( $query_jo = 'SM SALES' ) AS sm_total_jo,
				( $query_jo = 'SANPEDRO SALES' ) AS sp_total_jo,	
				( $query_jo = 'SANJOSE SALES' ) AS sj_total_jo,
				( $query_jo = 'RIZAL SALES' ) AS rzl_total_jo,
				( $query_jo = 'ADPLUS SALES' ) AS adpls_total_jo,

				( $query_dr = 'main' ) AS main_total_dr,
				( $query_dr = 'sm' ) AS sm_total_dr,
				( $query_dr = 'sp' ) AS sp_total_dr,
				( $query_dr = 'rzl' ) AS rzl_total_dr,
				( $query_dr = 'adpls' ) AS adpls_total_dr,	
				
				( $query_payment = 'SALES' ) AS main_total_payment,
				( $query_payment = 'SM SALES' ) AS sm_total_payment,
				( $query_payment = 'SANPEDRO SALES' ) AS sp_total_payment,
				( $query_payment = 'SANJOSE SALES' ) AS sj_total_payment,
				( $query_payment = 'RIZAL SALES' ) AS rzl_total_payment,
				( $query_payment = 'ADPLUS SALES' ) AS adpls_total_payment
			";
			
		$q=mysql_query($s) or die(mysql_error());
		$r5=mysql_fetch_assoc($q);
		?>
		
		
		<tr class='w3-tiny w3-light-gray'>
			<td colspan='7'>&nbsp;</td>
		</tr>
		
		<tr>
			<td rowspan='4'><?php echo $this_day; ?></td>
			<td class='w3-text-indigo'> &nbsp;JO CREATED</td>
			<?php echo "<td><b>".number_format($r5['main_total_jo']+$r5['sm_total_jo']+$r5['sp_total_jo']+$r5['sj_total_jo']+$r5['rzl_total_jo'],2)."</b></td>";
				  if($r5['main_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&4day_ago=1&jo_main=1' target='_blank'><b>".number_format($r5['main_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r5['sm_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&4day_ago=1&jo_sm=1' target='_blank'><b>".number_format($r5['sm_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r5['sp_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&4day_ago=1&jo_sp=1' target='_blank'><b>".number_format($r5['sp_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r5['sj_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&4day_ago=1&jo_sj=1' target='_blank'><b>".number_format($r5['sj_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r5['rzl_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&4day_ago=1&jo_rzl=1' target='_blank'><b>".number_format($r5['rzl_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r5['adpls_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&4day_ago=1&jo_adpls=1' target='_blank'><b>".number_format($r5['adpls_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}?>
		</tr>
		
		<tr>
			<td class='w3-text-purple'>PAYMENTS RECIEVED</td>
			<?php echo "<td><b>".number_format($r5['main_total_payment']+$r5['sm_total_payment']+$r5['sp_total_payment']+$r5['sj_total_payment']+$r5['rzl_total_payment'],2)."</b></td>";
				  if($r5['main_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&4day_ago=1&jo_main=1' target='_blank'><b>".number_format($r5['main_total_payment'],2)."</a></b></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r5['sm_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&4day_ago=1&jo_sm=1' target='_blank'><b>".number_format($r5['sm_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r5['sp_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&4day_ago=1&jo_sp=1' target='_blank'><b>".number_format($r5['sp_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r5['sj_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&4day_ago=1&jo_sj=1' target='_blank'><b>".number_format($r5['sj_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r5['rzl_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&4day_ago=1&jo_rzl=1' target='_blank'><b>".number_format($r5['rzl_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r5['adpls_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&4day_ago=1&jo_adpls=1' target='_blank'><b>".number_format($r5['adpls_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}?>
		</tr>
		
		<tr>
			<td class='w3-text-brown'>TOTAL DR</td>
			<?php echo "<td><b>".number_format($r5['main_total_dr']+$r5['sm_total_dr']+$r5['sp_total_dr']+$r5['sj_total_dr']+$r5['rzl_total_dr'],2)."</b></td>";
				  if($r5['main_total_dr']){echo "<td><a href='vipreport_detailed.php?dr_list=1&4day_ago=1&jo_main=1' target='_blank'><b>".number_format($r5['main_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r5['sm_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&4day_ago=1&jo_sm=1' target='_blank'><b>".number_format($r5['sm_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r5['sp_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&4day_ago=1&jo_sp=1' target='_blank'><b>".number_format($r5['sp_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r5['sj_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&4day_ago=1&jo_sj=1' target='_blank'><b>".number_format($r5['sj_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r5['rzl_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&4day_ago=1&jo_rzl=1' target='_blank'><b>".number_format($r5['rzl_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r5['adpls_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&4day_ago=1&jo_adpls=1' target='_blank'><b>".number_format($r5['adpls_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}?>
		</tr>
		
		
		<!-- DECEMBER -->
		<?php
		$date=$year."-12";
		$month="DECEMBER ".$year;
		
		$query_jo="$q_jo_common WHERE a.created_datetime LIKE '$date%' AND b.department";
		$query_dr="$q_dr_common WHERE a.dr_date LIKE '$date%' AND a.bch";
		$query_payment="$q_payment_common WHERE a.payment_datetime LIKE '$date%' AND c.department";	
		
		$s="SELECT
				( $query_jo = 'SALES' ) AS main_total_jo,
				( $query_jo = 'SM SALES' ) AS sm_total_jo,
				( $query_jo = 'SANPEDRO SALES' ) AS sp_total_jo,	
				( $query_jo = 'SANJOSE SALES' ) AS sj_total_jo,
				( $query_jo = 'RIZAL SALES' ) AS rzl_total_jo,
				( $query_jo = 'ADPLUS SALES' ) AS adpls_total_jo,
					
				( $query_dr = 'main' ) AS main_total_dr,
				( $query_dr = 'sm' ) AS sm_total_dr,
				( $query_dr = 'sp' ) AS sp_total_dr,
				( $query_dr = 'sj' ) AS sj_total_dr,	
				( $query_dr = 'rzl' ) AS rzl_total_dr,
				( $query_dr = 'adpls' ) AS adpls_total_dr,
				
				( $query_payment = 'SALES' ) AS main_total_payment,
				( $query_payment = 'SM SALES' ) AS sm_total_payment,
				( $query_payment = 'SANPEDRO SALES' ) AS sp_total_payment,
				( $query_payment = 'SANJOSE SALES' ) AS sj_total_payment,
				( $query_payment = 'RIZAL SALES' ) AS rzl_total_payment,
				( $query_payment = 'ADPLUS SALES' ) AS adpls_total_payment
			";
			
		$q=mysql_query($s) or die(mysql_error());
		$r_dec=mysql_fetch_assoc($q);
		?>
		
		<tr class='w3-tiny w3-green'>
			<td colspan='7'>&nbsp;</td>
		</tr>
		
		<tr>
			<td rowspan='4'><?php echo $month; ?></td>
			<td class='w3-text-indigo'> &nbsp;JO CREATED</td>
			<?php echo "<td><b>".number_format($r_dec['main_total_jo']+$r_dec['sm_total_jo']+$r_dec['sp_total_jo']+$r_dec['sj_total_jo']+$r_dec['rzl_total_jo'],2)."</b></td>";
				  if($r_dec['main_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_dec=1&jo_main=1&year=".$year."' target='_blank'><b>".number_format($r_dec['main_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_dec['sm_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_dec=1&jo_sm=1&year=".$year."' target='_blank'><b>".number_format($r_dec['sm_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_dec['sp_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_dec=1&jo_sp=1&year=".$year."' target='_blank'><b>".number_format($r_dec['sp_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_dec['sj_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_dec=1&jo_sj=1&year=".$year."' target='_blank'><b>".number_format($r_dec['sj_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_dec['rzl_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_dec=1&jo_rzl=1&year=".$year."' target='_blank'><b>".number_format($r_dec['rzl_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_dec['adpls_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_dec=1&jo_adpls=1&year=".$year."' target='_blank'><b>".number_format($r_dec['adpls_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}  ?>
		</tr>
		
		<tr>
			<td class='w3-text-purple'>PAYMENTS RECIEVED</td>
			<?php echo "<td><b>".number_format($r_dec['main_total_payment']+$r_dec['sm_total_payment']+$r_dec['sp_total_payment']+$r_dec['sj_total_payment']+$r_dec['rzl_total_payment'],2)."</b></td>";
				  if($r_dec['main_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_dec=1&jo_main=1&year=".$year."' target='_blank'><b>".number_format($r_dec['main_total_payment'],2)."</a></b></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_dec['sm_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_dec=1&jo_sm=1&year=".$year."' target='_blank'><b>".number_format($r_dec['sm_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_dec['sp_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_dec=1&jo_sp=1&year=".$year."' target='_blank'><b>".number_format($r_dec['sp_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_dec['sj_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_dec=1&jo_sj=1&year=".$year."' target='_blank'><b>".number_format($r_dec['sj_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_dec['rzl_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_dec=1&jo_rzl=1&year=".$year."' target='_blank'><b>".number_format($r_dec['rzl_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_dec['adpls_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_dec=1&jo_adpls=1&year=".$year."' target='_blank'><b>".number_format($r_dec['adpls_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}?>
		</tr>
		
		<tr>
			<td class='w3-text-brown'>TOTAL DR</td>
			<?php echo "<td><b>".number_format($r_dec['main_total_dr']+$r_dec['sm_total_dr']+$r_dec['sp_total_dr']+$r_dec['sj_total_dr']+$r_dec['rzl_total_dr'],2)."</b></td>";
				  if($r_dec['main_total_dr']){echo "<td><a href='vipreport_detailed.php?dr_list=1&m_dec=1&jo_main=1&year=".$year."' target='_blank'><b>".number_format($r_dec['main_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_dec['sm_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&m_dec=1&jo_sm=1&year=".$year."' target='_blank'><b>".number_format($r_dec['sm_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_dec['sp_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&m_dec=1&jo_sp=1&year=".$year."' target='_blank'><b>".number_format($r_dec['sp_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_dec['sj_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&m_dec=1&jo_sj=1&year=".$year."' target='_blank'><b>".number_format($r_dec['sj_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_dec['rzl_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&m_dec=1&jo_rzl=1&year=".$year."' target='_blank'><b>".number_format($r_dec['rzl_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_dec['adpls_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&m_dec=1&jo_adpls=1&year=".$year."' target='_blank'><b>".number_format($r_dec['adpls_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}?>
		</tr>
		
		
		<!-- NOVEMBER -->
		<?php
		$date=$year."-11";
		$month="NOVEMBER ".$year;
		
		$query_jo="$q_jo_common WHERE a.created_datetime LIKE '$date%' AND b.department";
		$query_dr="$q_dr_common WHERE a.dr_date LIKE '$date%' AND a.bch";
		$query_payment="$q_payment_common WHERE a.payment_datetime LIKE '$date%' AND c.department";	
		
		$s="SELECT
				( $query_jo = 'SALES' ) AS main_total_jo,
				( $query_jo = 'SM SALES' ) AS sm_total_jo,
				( $query_jo = 'SANPEDRO SALES' ) AS sp_total_jo,	
				( $query_jo = 'SANJOSE SALES' ) AS sj_total_jo,
				( $query_jo = 'RIZAL SALES' ) AS rzl_total_jo,
				( $query_jo = 'ADPLUS SALES' ) AS adpls_total_jo,
					
				( $query_dr = 'main' ) AS main_total_dr,
				( $query_dr = 'sm' ) AS sm_total_dr,
				( $query_dr = 'sp' ) AS sp_total_dr,
				( $query_dr = 'sj' ) AS sj_total_dr,	
				( $query_dr = 'rzl' ) AS rzl_total_dr,
				( $query_dr = 'adpls' ) AS adpls_total_dr,
				
				( $query_payment = 'SALES' ) AS main_total_payment,
				( $query_payment = 'SM SALES' ) AS sm_total_payment,
				( $query_payment = 'SANPEDRO SALES' ) AS sp_total_payment,
				( $query_payment = 'SANJOSE SALES' ) AS sj_total_payment,
				( $query_payment = 'RIZAL SALES' ) AS rzl_total_payment,
				( $query_payment = 'ADPLUS SALES' ) AS adpls_total_payment
			";
			
		$q=mysql_query($s) or die(mysql_error());
		$r_nov=mysql_fetch_assoc($q);
		?>
		
		<tr class='w3-tiny w3-light-gray'>
			<td colspan='7'>&nbsp;</td>
		</tr>
		
		<tr>
			<td rowspan='4'><?php echo $month; ?></td>
			<td class='w3-text-indigo'> &nbsp;JO CREATED</td>
			<?php echo "<td><b>".number_format($r_nov['main_total_jo']+$r_nov['sm_total_jo']+$r_nov['sp_total_jo']+$r_nov['sj_total_jo']+$r_nov['rzl_total_jo'],2)."</b></td>";
				  if($r_nov['main_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_nov=1&jo_main=1&year=".$year."' target='_blank'><b>".number_format($r_nov['main_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_nov['sm_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_nov=1&jo_sm=1&year=".$year."' target='_blank'><b>".number_format($r_nov['sm_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_nov['sp_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_nov=1&jo_sp=1&year=".$year."' target='_blank'><b>".number_format($r_nov['sp_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_nov['sj_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_nov=1&jo_sj=1&year=".$year."' target='_blank'><b>".number_format($r_nov['sj_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_nov['rzl_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_nov=1&jo_rzl=1&year=".$year."' target='_blank'><b>".number_format($r_nov['rzl_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
			      if($r_nov['adpls_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_nov=1&jo_adpls=1&year=".$year."' target='_blank'><b>".number_format($r_nov['adplus_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}?>
		</tr>
		
		<tr>
			<td class='w3-text-purple'>PAYMENTS RECIEVED</td>
			<?php echo "<td><b>".number_format($r_nov['main_total_payment']+$r_nov['sm_total_payment']+$r_nov['sp_total_payment']+$r_nov['sj_total_payment']+$r_nov['rzl_total_payment'],2)."</b></td>";
				  if($r_nov['main_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_nov=1&jo_main=1&year=".$year."' target='_blank'><b>".number_format($r_nov['main_total_payment'],2)."</a></b></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_nov['sm_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_nov=1&jo_sm=1&year=".$year."' target='_blank'><b>".number_format($r_nov['sm_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_nov['sp_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_nov=1&jo_sp=1&year=".$year."' target='_blank'><b>".number_format($r_nov['sp_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_nov['sj_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_nov=1&jo_sj=1&year=".$year."' target='_blank'><b>".number_format($r_nov['sj_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";} 
				  if($r_nov['rzl_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_nov=1&jo_rzl=1&year=".$year."' target='_blank'><b>".number_format($r_nov['rzl_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_nov['adpls_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_nov=1&jo_adpls=1&year=".$year."' target='_blank'><b>".number_format($r_nov['adpls_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}?>
		</tr>
		
		<tr>
			<td class='w3-text-brown'>TOTAL DR</td>
			<?php echo "<td><b>".number_format($r_nov['main_total_dr']+$r_nov['sm_total_dr']+$r_nov['sp_total_dr']+$r_nov['sj_total_dr']+$r_nov['rzl_total_dr'],2)."</b></td>";
				  if($r_nov['main_total_dr']){echo "<td><a href='vipreport_detailed.php?dr_list=1&m_nov=1&jo_main=1&year=".$year."' target='_blank'><b>".number_format($r_nov['main_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_nov['sm_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&m_nov=1&jo_sm=1&year=".$year."' target='_blank'><b>".number_format($r_nov['sm_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_nov['sp_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&m_nov=1&jo_sp=1&year=".$year."' target='_blank'><b>".number_format($r_nov['sp_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_nov['sj_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&m_nov=1&jo_sj=1&year=".$year."' target='_blank'><b>".number_format($r_nov['sj_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_nov['rzl_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&m_nov=1&jo_rzl=1&year=".$year."' target='_blank'><b>".number_format($r_nov['rzl_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_nov['adpls_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&m_nov=1&jo_adpls=1&year=".$year."' target='_blank'><b>".number_format($r_nov['adpls_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}?>
		</tr>
		
		
		
		<!-- OCTOBER -->
		<?php
		$date=$year."-10";
		$month="OCTOBER ".$year;
		
		$query_jo="$q_jo_common WHERE a.created_datetime LIKE '$date%' AND b.department";
		$query_dr="$q_dr_common WHERE a.dr_date LIKE '$date%' AND a.bch";
		$query_payment="$q_payment_common WHERE a.payment_datetime LIKE '$date%' AND c.department";	
		
		$s="SELECT
				( $query_jo = 'SALES' ) AS main_total_jo,
				( $query_jo = 'SM SALES' ) AS sm_total_jo,
				( $query_jo = 'SANPEDRO SALES' ) AS sp_total_jo,	
				( $query_jo = 'SANJOSE SALES' ) AS sj_total_jo,
				( $query_jo = 'RIZAL SALES' ) AS rzl_total_jo,
				( $query_jo = 'ADPLUS SALES' ) AS adplus_total_jo,	
					
				( $query_dr = 'main' ) AS main_total_dr,
				( $query_dr = 'sm' ) AS sm_total_dr,
				( $query_dr = 'sp' ) AS sp_total_dr,
				( $query_dr = 'sj' ) AS sj_total_dr,
				( $query_dr = 'rzl' ) AS rzl_total_dr,	
				( $query_dr = 'adpls' ) AS adpls_total_dr,	
				
				( $query_payment = 'SALES' ) AS main_total_payment,
				( $query_payment = 'SM SALES' ) AS sm_total_payment,
				( $query_payment = 'SANPEDRO SALES' ) AS sp_total_payment,
				( $query_payment = 'SANJOSE SALES' ) AS sj_total_payment,
				( $query_payment = 'RIZAL SALES' ) AS rzl_total_payment,
				( $query_payment = 'ADPLUS SALES' ) AS adpls_total_payment
			";
			
		$q=mysql_query($s) or die(mysql_error());
		$r_oct=mysql_fetch_assoc($q);
		?>
		
		<tr class='w3-tiny w3-light-gray'>
			<td colspan='7'>&nbsp;</td>
		</tr>
		
		<tr>
			<td rowspan='4'><?php echo $month; ?></td>
			<td class='w3-text-indigo'> &nbsp;JO CREATED</td>
			<?php echo "<td><b>".number_format($r_oct['main_total_jo']+$r_oct['sm_total_jo']+$r_oct['sp_total_jo']+$r_oct['sj_total_jo']+$r_oct['rzl_total_jo'],2)."</b></td>";
				  if($r_oct['main_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_oct=1&jo_main=1&year=".$year."' target='_blank'><b>".number_format($r_oct['main_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_oct['sm_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_oct=1&jo_sm=1&year=".$year."' target='_blank'><b>".number_format($r_oct['sm_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_oct['sp_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_oct=1&jo_sp=1&year=".$year."' target='_blank'><b>".number_format($r_oct['sp_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_oct['sj_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_oct=1&jo_sj=1&year=".$year."' target='_blank'><b>".number_format($r_oct['sj_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_oct['rzl_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_oct=1&jo_rzl=1&year=".$year."' target='_blank'><b>".number_format($r_oct['rzl_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_oct['adpls_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_oct=1&jo_adpls=1&year=".$year."' target='_blank'><b>".number_format($r_oct['adpls_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}	?>
		</tr>
		
		<tr>
			<td class='w3-text-purple'>PAYMENTS RECIEVED</td>
			<?php echo "<td><b>".number_format($r_oct['main_total_payment']+$r_oct['sm_total_payment']+$r_oct['sp_total_payment']+$r_oct['sj_total_payment']+$r_oct['rzl_total_payment'],2)."</b></td>";
				  if($r_oct['main_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_oct=1&jo_main=1&year=".$year."' target='_blank'><b>".number_format($r_oct['main_total_payment'],2)."</a></b></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_oct['sm_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_oct=1&jo_sm=1&year=".$year."' target='_blank'><b>".number_format($r_oct['sm_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_oct['sp_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_oct=1&jo_sp=1&year=".$year."' target='_blank'><b>".number_format($r_oct['sp_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_oct['sj_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_oct=1&jo_sj=1&year=".$year."' target='_blank'><b>".number_format($r_oct['sj_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_oct['rzl_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_oct=1&jo_rzl=1&year=".$year."' target='_blank'><b>".number_format($r_oct['rzl_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_oct['adpls_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_oct=1&jo_adpls=1&year=".$year."' target='_blank'><b>".number_format($r_oct['adpls_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}?>
		</tr>
		
		<tr>
			<td class='w3-text-brown'>TOTAL DR</td>
			<?php echo "<td><b>".number_format($r_oct['main_total_dr']+$r_oct['sm_total_dr']+$r_oct['sp_total_dr']+$r_oct['sj_total_dr']+$r_oct['rzl_total_dr'],2)."</b></td>";
				  if($r_oct['main_total_dr']){echo "<td><a href='vipreport_detailed.php?dr_list=1&m_oct=1&jo_main=1&year=".$year."' target='_blank'><b>".number_format($r_oct['main_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_oct['sm_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&m_oct=1&jo_sm=1&year=".$year."' target='_blank'><b>".number_format($r_oct['sm_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_oct['sp_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&m_oct=1&jo_sp=1&year=".$year."' target='_blank'><b>".number_format($r_oct['sp_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_oct['sj_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&m_oct=1&jo_sj=1&year=".$year."' target='_blank'><b>".number_format($r_oct['sj_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";} 
				  if($r_oct['rzl_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&m_oct=1&jo_rzl=1&year=".$year."' target='_blank'><b>".number_format($r_oct['rzl_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_oct['adpls_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&m_oct=1&jo_adpls=1&year=".$year."' target='_blank'><b>".number_format($r_oct['adpls_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}?>
		</tr>
		
		
		
		<!-- SEPTEMBER -->
		<?php
		$date=$year."-09";
		$month="SEPTEMBER ".$year;
		
		$query_jo="$q_jo_common WHERE a.created_datetime LIKE '$date%' AND b.department";
		$query_dr="$q_dr_common WHERE a.dr_date LIKE '$date%' AND a.bch";
		$query_payment="$q_payment_common WHERE a.payment_datetime LIKE '$date%' AND c.department";	
		
		$s="SELECT
				( $query_jo = 'SALES' ) AS main_total_jo,
				( $query_jo = 'SM SALES' ) AS sm_total_jo,
				( $query_jo = 'SANPEDRO SALES' ) AS sp_total_jo,	
				( $query_jo = 'SANJOSE SALES' ) AS sj_total_jo,
				( $query_jo = 'RIZAL SALES' ) AS rzl_total_jo,
				( $query_jo = 'ADPLUS SALES' ) AS adplus_total_jo,	
					
				( $query_dr = 'main' ) AS main_total_dr,
				( $query_dr = 'sm' ) AS sm_total_dr,
				( $query_dr = 'sp' ) AS sp_total_dr,
				( $query_dr = 'sj' ) AS sj_total_dr,
				( $query_dr = 'rzl' ) AS rzl_total_dr,	
				( $query_dr = 'adpls' ) AS adpls_total_dr,	
				
				( $query_payment = 'SALES' ) AS main_total_payment,
				( $query_payment = 'SM SALES' ) AS sm_total_payment,
				( $query_payment = 'SANPEDRO SALES' ) AS sp_total_payment,
				( $query_payment = 'SANJOSE SALES' ) AS sj_total_payment,
				( $query_payment = 'RIZAL SALES' ) AS rzl_total_payment,
				( $query_payment = 'ADPLUS SALES' ) AS adpls_total_payment
			";
			
		$q=mysql_query($s) or die(mysql_error());
		$r_sep=mysql_fetch_assoc($q);
		?>
		
		<tr class='w3-tiny w3-light-gray'>
			<td colspan='7'>&nbsp;</td>
		</tr>
		
		<tr>
			<td rowspan='4'><?php echo $month; ?></td>
			<td class='w3-text-indigo'> &nbsp;JO CREATED</td>
			<?php echo "<td><b>".number_format($r_sep['main_total_jo']+$r_sep['sm_total_jo']+$r_sep['sp_total_jo']+$r_sep['sj_total_jo']+$r_sep['rzl_total_jo'],2)."</b></td>";
				  if($r_sep['main_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_sep=1&jo_main=1&year=".$year."' target='_blank'><b>".number_format($r_sep['main_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_sep['sm_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_sep=1&jo_sm=1&year=".$year."' target='_blank'><b>".number_format($r_sep['sm_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_sep['sp_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_sep=1&jo_sp=1&year=".$year."' target='_blank'><b>".number_format($r_sep['sp_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_sep['sj_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_sep=1&jo_sj=1&year=".$year."' target='_blank'><b>".number_format($r_sep['sj_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_sep['rzl_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_sep=1&jo_rzl=1&year=".$year."' target='_blank'><b>".number_format($r_sep['rzl_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_sep['adpls_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_sep=1&jo_adpls=1&year=".$year."' target='_blank'><b>".number_format($r_sep['adpls_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}	?>
		</tr>
		
		<tr>
			<td class='w3-text-purple'>PAYMENTS RECIEVED</td>
			<?php echo "<td><b>".number_format($r_sep['main_total_payment']+$r_sep['sm_total_payment']+$r_sep['sp_total_payment']+$r_sep['sj_total_payment']+$r_sep['rzl_total_payment'],2)."</b></td>";
				  if($r_sep['main_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_sep=1&jo_main=1&year=".$year."' target='_blank'><b>".number_format($r_sep['main_total_payment'],2)."</a></b></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_sep['sm_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_sep=1&jo_sm=1&year=".$year."' target='_blank'><b>".number_format($r_sep['sm_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_sep['sp_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_sep=1&jo_sp=1&year=".$year."' target='_blank'><b>".number_format($r_sep['sp_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_sep['sj_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_sep=1&jo_sj=1&year=".$year."' target='_blank'><b>".number_format($r_sep['sj_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_sep['rzl_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_sep=1&jo_rzl=1&year=".$year."' target='_blank'><b>".number_format($r_sep['rzl_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_sep['adpls_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_sep=1&jo_adpls=1&year=".$year."' target='_blank'><b>".number_format($r_sep['adpls_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}	?>
		</tr>
		
		<tr>
			<td class='w3-text-brown'>TOTAL DR</td>
			<?php echo "<td><b>".number_format($r_sep['main_total_dr']+$r_sep['sm_total_dr']+$r_sep['sp_total_dr']+$r_sep['sj_total_dr']+$r_sep['rzl_total_dr'],2)."</b></td>";
				  if($r_sep['main_total_dr']){echo "<td><a href='vipreport_detailed.php?dr_list=1&m_sep=1&jo_main=1&year=".$year."' target='_blank'><b>".number_format($r_sep['main_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_sep['sm_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&m_sep=1&jo_sm=1&year=".$year."' target='_blank'><b>".number_format($r_sep['sm_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_sep['sp_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&m_sep=1&jo_sp=1&year=".$year."' target='_blank'><b>".number_format($r_sep['sp_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_sep['sj_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&m_sep=1&jo_sj=1&year=".$year."' target='_blank'><b>".number_format($r_sep['sj_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_sep['rzl_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&m_sep=1&jo_rzl=1&year=".$year."' target='_blank'><b>".number_format($r_sep['rzl_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_sep['adpls_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&m_sep=1&jo_adpls=1&year=".$year."' target='_blank'><b>".number_format($r_sep['adpls_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}	?>
		</tr>
		
		
		<!-- AUGUST -->
		
		<?php
		$date=$year."-08";
		$month="AUGUST ".$year;
		
		$query_jo="$q_jo_common WHERE a.created_datetime LIKE '$date%' AND b.department";
		$query_dr="$q_dr_common WHERE a.dr_date LIKE '$date%' AND a.bch";
		$query_payment="$q_payment_common WHERE a.payment_datetime LIKE '$date%' AND c.department";	
		
		$s="SELECT
				( $query_jo = 'SALES' ) AS main_total_jo,
				( $query_jo = 'SM SALES' ) AS sm_total_jo,
				( $query_jo = 'SANPEDRO SALES' ) AS sp_total_jo,	
				( $query_jo = 'SANJOSE SALES' ) AS sj_total_jo,
				( $query_jo = 'RIZAL SALES' ) AS rzl_total_jo,
				( $query_jo = 'ADPLUS SALES' ) AS adplus_total_jo,	
					
				( $query_dr = 'main' ) AS main_total_dr,
				( $query_dr = 'sm' ) AS sm_total_dr,
				( $query_dr = 'sp' ) AS sp_total_dr,
				( $query_dr = 'sj' ) AS sj_total_dr,
				( $query_dr = 'rzl' ) AS rzl_total_dr,	
				( $query_dr = 'adpls' ) AS adpls_total_dr,	
				
				( $query_payment = 'SALES' ) AS main_total_payment,
				( $query_payment = 'SM SALES' ) AS sm_total_payment,
				( $query_payment = 'SANPEDRO SALES' ) AS sp_total_payment,
				( $query_payment = 'SANJOSE SALES' ) AS sj_total_payment,
				( $query_payment = 'RIZAL SALES' ) AS rzl_total_payment,
				( $query_payment = 'ADPLUS SALES' ) AS adpls_total_payment
			";
			
		$q=mysql_query($s) or die(mysql_error());
		$r_aug=mysql_fetch_assoc($q);
		?>
		
		<tr class='w3-tiny w3-light-gray'>
			<td colspan='7'>&nbsp;</td>
		</tr>
		
		<tr>
			<td rowspan='4'><?php echo $month; ?></td>
			<td class='w3-text-indigo'> &nbsp;JO CREATED</td>
			<?php echo "<td><b>".number_format($r_aug['main_total_jo']+$r_aug['sm_total_jo']+$r_aug['sp_total_jo']+$r_aug['sj_total_jo']+$r_aug['rzl_total_jo'],2)."</b></td>";
				  if($r_aug['main_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_aug=1&jo_main=1&year=".$year."' target='_blank'><b>".number_format($r_aug['main_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_aug['sm_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_aug=1&jo_sm=1&year=".$year."' target='_blank'><b>".number_format($r_aug['sm_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_aug['sp_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_aug=1&jo_sp=1&year=".$year."' target='_blank'><b>".number_format($r_aug['sp_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_aug['sj_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_aug=1&jo_sj=1&year=".$year."' target='_blank'><b>".number_format($r_aug['sj_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_aug['rzl_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_aug=1&jo_rzl=1&year=".$year."' target='_blank'><b>".number_format($r_aug['rzl_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_aug['adpls_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_aug=1&jo_adpls=1&year=".$year."' target='_blank'><b>".number_format($r_aug['adpls_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}		?>
		</tr>
		
		<tr>
			<td class='w3-text-purple'>PAYMENTS RECIEVED</td>
			<?php echo "<td><b>".number_format($r_aug['main_total_payment']+$r_aug['sm_total_payment']+$r_aug['sp_total_payment']+$r_aug['sj_total_payment']+$r_aug['rzl_total_payment'],2)."</b></td>";
				  if($r_aug['main_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_aug=1&jo_main=1&year=".$year."' target='_blank'><b>".number_format($r_aug['main_total_payment'],2)."</a></b></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_aug['sm_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_aug=1&jo_sm=1&year=".$year."' target='_blank'><b>".number_format($r_aug['sm_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_aug['sp_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_aug=1&jo_sp=1&year=".$year."' target='_blank'><b>".number_format($r_aug['sp_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_aug['sj_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_aug=1&jo_sj=1&year=".$year."' target='_blank'><b>".number_format($r_aug['sj_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_aug['rzl_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_aug=1&jo_rzl=1&year=".$year."' target='_blank'><b>".number_format($r_aug['rzl_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_aug['adpls_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_aug=1&jo_adpls=1&year=".$year."' target='_blank'><b>".number_format($r_aug['adpls_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}	?>
		</tr>
		
		<tr>
			<td class='w3-text-brown'>TOTAL DR</td>
			<?php echo "<td><b>".number_format($r_aug['main_total_dr']+$r_aug['sm_total_dr']+$r_aug['sp_total_dr']+$r_aug['sj_total_dr']+$r_aug['rzl_total_dr'],2)."</b></td>";
				  if($r_aug['main_total_dr']){echo "<td><a href='vipreport_detailed.php?dr_list=1&m_aug=1&jo_main=1&year=".$year."' target='_blank'><b>".number_format($r_aug['main_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_aug['sm_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&m_aug=1&jo_sm=1&year=".$year."' target='_blank'><b>".number_format($r_aug['sm_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_aug['sp_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&m_aug=1&jo_sp=1&year=".$year."' target='_blank'><b>".number_format($r_aug['sp_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_aug['sj_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&m_aug=1&jo_sj=1&year=".$year."' target='_blank'><b>".number_format($r_aug['sj_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_aug['rzl_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&m_aug=1&jo_rzl=1&year=".$year."' target='_blank'><b>".number_format($r_aug['rzl_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_aug['adpls_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&m_aug=1&jo_adpls=1&year=".$year."' target='_blank'><b>".number_format($r_aug['adpls_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}	?>
		</tr>
		
		
		<!-- JULY -->
		<?php
		$date=$year."-07";
		$month="JULY ".$year;
		
		$query_jo="$q_jo_common WHERE a.created_datetime LIKE '$date%' AND b.department";
		$query_dr="$q_dr_common WHERE a.dr_date LIKE '$date%' AND a.bch";
		$query_payment="$q_payment_common WHERE a.payment_datetime LIKE '$date%' AND c.department";	
		
		$s="SELECT
				( $query_jo = 'SALES' ) AS main_total_jo,
				( $query_jo = 'SM SALES' ) AS sm_total_jo,
				( $query_jo = 'SANPEDRO SALES' ) AS sp_total_jo,	
				( $query_jo = 'SANJOSE SALES' ) AS sj_total_jo,
				( $query_jo = 'RIZAL SALES' ) AS rzl_total_jo,
				( $query_jo = 'ADPLUS SALES' ) AS adplus_total_jo,	
					
				( $query_dr = 'main' ) AS main_total_dr,
				( $query_dr = 'sm' ) AS sm_total_dr,
				( $query_dr = 'sp' ) AS sp_total_dr,
				( $query_dr = 'sj' ) AS sj_total_dr,
				( $query_dr = 'rzl' ) AS rzl_total_dr,	
				( $query_dr = 'adpls' ) AS adpls_total_dr,	
				
				( $query_payment = 'SALES' ) AS main_total_payment,
				( $query_payment = 'SM SALES' ) AS sm_total_payment,
				( $query_payment = 'SANPEDRO SALES' ) AS sp_total_payment,
				( $query_payment = 'SANJOSE SALES' ) AS sj_total_payment,
				( $query_payment = 'RIZAL SALES' ) AS rzl_total_payment,
				( $query_payment = 'ADPLUS SALES' ) AS adpls_total_payment
			";
			
		$q=mysql_query($s) or die(mysql_error());
		$r_jul=mysql_fetch_assoc($q);
		?>
		
		<tr class='w3-tiny w3-light-gray'>
			<td colspan='7'>&nbsp;</td>
		</tr>
		
		<tr>
			<td rowspan='4'><?php echo $month; ?></td>
			<td class='w3-text-indigo'> &nbsp;JO CREATED</td>
			<?php echo "<td><b>".number_format($r_jul['main_total_jo']+$r_jul['sm_total_jo']+$r_jul['sp_total_jo']+$r_jul['sj_total_jo']+$r_jul['rzl_total_jo'],2)."</b></td>";
				  if($r_jul['main_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_jul=1&jo_main=1&year=".$year."' target='_blank'><b>".number_format($r_jul['main_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_jul['sm_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_jul=1&jo_sm=1&year=".$year."' target='_blank'><b>".number_format($r_jul['sm_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_jul['sp_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_jul=1&jo_sp=1&year=".$year."' target='_blank'><b>".number_format($r_jul['sp_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_jul['sj_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_jul=1&jo_sj=1&year=".$year."' target='_blank'><b>".number_format($r_jul['sj_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_jul['rzl_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_jul=1&jo_rzl=1&year=".$year."' target='_blank'><b>".number_format($r_jul['rzl_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_jul['adpls_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_jul=1&jo_adpls=1&year=".$year."' target='_blank'><b>".number_format($r_jul['adpls_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}	?>
		</tr>
		
		<tr>
			<td class='w3-text-purple'>PAYMENTS RECIEVED</td>
			<?php echo "<td><b>".number_format($r_jul['main_total_payment']+$r_jul['sm_total_payment']+$r_jul['sp_total_payment']+$r_jul['sj_total_payment']+$r_jul['rzl_total_payment'],2)."</b></td>";
				  if($r_jul['main_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_jul=1&jo_main=1&year=".$year."' target='_blank'><b>".number_format($r_jul['main_total_payment'],2)."</a></b></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_jul['sm_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_jul=1&jo_sm=1&year=".$year."' target='_blank'><b>".number_format($r_jul['sm_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_jul['sp_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_jul=1&jo_sp=1&year=".$year."' target='_blank'><b>".number_format($r_jul['sp_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_jul['sj_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_jul=1&jo_sj=1&year=".$year."' target='_blank'><b>".number_format($r_jul['sj_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_jul['rzl_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_jul=1&jo_rzl=1&year=".$year."' target='_blank'><b>".number_format($r_jul['rzl_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_jul['adpls_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_jul=1&jo_adpls=1&year=".$year."' target='_blank'><b>".number_format($r_jul['adpls_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}	?>
		</tr>
		
		<tr>
			<td class='w3-text-brown'>TOTAL DR</td>
			<?php echo "<td><b>".number_format($r_jul['main_total_dr']+$r_jul['sm_total_dr']+$r_jul['sp_total_dr']+$r_jul['sj_total_dr']+$r_jul['rzl_total_dr'],2)."</b></td>";
				  if($r_jul['main_total_dr']){echo "<td><a href='vipreport_detailed.php?dr_list=1&m_jul=1&jo_main=1&year=".$year."' target='_blank'><b>".number_format($r_jul['main_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_jul['sm_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&m_jul=1&jo_sm=1&year=".$year."' target='_blank'><b>".number_format($r_jul['sm_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_jul['sp_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&m_jul=1&jo_sp=1&year=".$year."' target='_blank'><b>".number_format($r_jul['sp_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_jul['sj_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&m_jul=1&jo_sj=1&year=".$year."' target='_blank'><b>".number_format($r_jul['sj_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_jul['rzl_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&m_jul=1&jo_rzl=1&year=".$year."' target='_blank'><b>".number_format($r_jul['rzl_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_jul['adpls_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&m_jul=1&jo_adpls=1&year=".$year."' target='_blank'><b>".number_format($r_jul['adpls_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}	?>
		</tr>
		
		
		<!-- JUNE -->
		<?php
		$date=$year."-06";
		$month="JUNE ".$year;
		
		$query_jo="$q_jo_common WHERE a.created_datetime LIKE '$date%' AND b.department";
		$query_dr="$q_dr_common WHERE a.dr_date LIKE '$date%' AND a.bch";
		$query_payment="$q_payment_common WHERE a.payment_datetime LIKE '$date%' AND c.department";	
		
		$s="SELECT
				( $query_jo = 'SALES' ) AS main_total_jo,
				( $query_jo = 'SM SALES' ) AS sm_total_jo,
				( $query_jo = 'SANPEDRO SALES' ) AS sp_total_jo,	
				( $query_jo = 'SANJOSE SALES' ) AS sj_total_jo,
				( $query_jo = 'RIZAL SALES' ) AS rzl_total_jo,
				( $query_jo = 'ADPLUS SALES' ) AS adplus_total_jo,	
					
				( $query_dr = 'main' ) AS main_total_dr,
				( $query_dr = 'sm' ) AS sm_total_dr,
				( $query_dr = 'sp' ) AS sp_total_dr,
				( $query_dr = 'sj' ) AS sj_total_dr,
				( $query_dr = 'rzl' ) AS rzl_total_dr,	
				( $query_dr = 'adpls' ) AS adpls_total_dr,	
				
				( $query_payment = 'SALES' ) AS main_total_payment,
				( $query_payment = 'SM SALES' ) AS sm_total_payment,
				( $query_payment = 'SANPEDRO SALES' ) AS sp_total_payment,
				( $query_payment = 'SANJOSE SALES' ) AS sj_total_payment,
				( $query_payment = 'RIZAL SALES' ) AS rzl_total_payment,
				( $query_payment = 'ADPLUS SALES' ) AS adpls_total_payment
			";
			
		$q=mysql_query($s) or die(mysql_error());
		$r_jun=mysql_fetch_assoc($q);
		?>
		
		<tr class='w3-tiny w3-light-gray'>
			<td colspan='7'>&nbsp;</td>
		</tr>
		
		<tr>
			<td rowspan='4'><?php echo $month; ?></td>
			<td class='w3-text-indigo'> &nbsp;JO CREATED</td>
			<?php echo "<td><b>".number_format($r_jun['main_total_jo']+$r_jun['sm_total_jo']+$r_jun['sp_total_jo']+$r_jun['sj_total_jo']+$r_jun['rzl_total_jo'],2)."</b></td>";
				  if($r_jun['main_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_jun=1&jo_main=1&year=".$year."' target='_blank'><b>".number_format($r_jun['main_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_jun['sm_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_jun=1&jo_sm=1&year=".$year."' target='_blank'><b>".number_format($r_jun['sm_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_jun['sp_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_jun=1&jo_sp=1&year=".$year."' target='_blank'><b>".number_format($r_jun['sp_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_jun['sj_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_jun=1&jo_sj=1&year=".$year."' target='_blank'><b>".number_format($r_jun['sj_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_jun['rzl_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_jun=1&jo_rzl=1&year=".$year."' target='_blank'><b>".number_format($r_jun['rzl_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_jun['adpls_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_jun=1&jo_adpls=1&year=".$year."' target='_blank'><b>".number_format($r_jun['adpls_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}	?>
		</tr>
		
		<tr>
			<td class='w3-text-purple'>PAYMENTS RECIEVED</td>
			<?php echo "<td><b>".number_format($r_jun['main_total_payment']+$r_jun['sm_total_payment']+$r_jun['sp_total_payment']+$r_jun['sj_total_payment']+$r_jun['rzl_total_payment'],2)."</b></td>";
				  if($r_jun['main_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_jun=1&jo_main=1&year=".$year."' target='_blank'><b>".number_format($r_jun['main_total_payment'],2)."</a></b></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_jun['sm_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_jun=1&jo_sm=1&year=".$year."' target='_blank'><b>".number_format($r_jun['sm_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_jun['sp_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_jun=1&jo_sp=1&year=".$year."' target='_blank'><b>".number_format($r_jun['sp_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_jun['sj_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_jun=1&jo_sj=1&year=".$year."' target='_blank'><b>".number_format($r_jun['sj_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_jun['rzl_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_jun=1&jo_rzl=1&year=".$year."' target='_blank'><b>".number_format($r_jun['rzl_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_jun['adpls_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_jun=1&jo_adpls=1&year=".$year."' target='_blank'><b>".number_format($r_jun['adpls_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}	?>
		</tr>
		
		<tr>
			<td class='w3-text-brown'>TOTAL DR</td>
			<?php echo "<td><b>".number_format($r_jun['main_total_dr']+$r_jun['sm_total_dr']+$r_jun['sp_total_dr']+$r_jun['sj_total_dr']+$r_jun['rzl_total_dr'],2)."</b></td>";
				  if($r_jun['main_total_dr']){echo "<td><a href='vipreport_detailed.php?dr_list=1&m_jun=1&jo_main=1&year=".$year."' target='_blank'><b>".number_format($r_jun['main_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_jun['sm_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&m_jun=1&jo_sm=1&year=".$year."' target='_blank'><b>".number_format($r_jun['sm_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_jun['sp_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&m_jun=1&jo_sp=1&year=".$year."' target='_blank'><b>".number_format($r_jun['sp_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_jun['sj_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&m_jun=1&jo_sj=1&year=".$year."' target='_blank'><b>".number_format($r_jun['sj_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_jun['rzl_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&m_jun=1&jo_rzl=1&year=".$year."' target='_blank'><b>".number_format($r_jun['rzl_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_jun['adpls_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&m_jun=1&jo_adpls=1&year=".$year."' target='_blank'><b>".number_format($r_jun['adpls_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";} 	?>
		</tr>
		
		
		
		<!-- MAY -->
		<?php
		$date=$year."-05";
		$month="MAY ".$year;
		
		$query_jo="$q_jo_common WHERE a.created_datetime LIKE '$date%' AND b.department";
		$query_dr="$q_dr_common WHERE a.dr_date LIKE '$date%' AND a.bch";
		$query_payment="$q_payment_common WHERE a.payment_datetime LIKE '$date%' AND c.department";	
		
		$s="SELECT
				( $query_jo = 'SALES' ) AS main_total_jo,
				( $query_jo = 'SM SALES' ) AS sm_total_jo,
				( $query_jo = 'SANPEDRO SALES' ) AS sp_total_jo,	
				( $query_jo = 'SANJOSE SALES' ) AS sj_total_jo,
				( $query_jo = 'RIZAL SALES' ) AS rzl_total_jo,
				( $query_jo = 'ADPLUS SALES' ) AS adplus_total_jo,	
					
				( $query_dr = 'main' ) AS main_total_dr,
				( $query_dr = 'sm' ) AS sm_total_dr,
				( $query_dr = 'sp' ) AS sp_total_dr,
				( $query_dr = 'sj' ) AS sj_total_dr,
				( $query_dr = 'rzl' ) AS rzl_total_dr,	
				( $query_dr = 'adpls' ) AS adpls_total_dr,	
				
				( $query_payment = 'SALES' ) AS main_total_payment,
				( $query_payment = 'SM SALES' ) AS sm_total_payment,
				( $query_payment = 'SANPEDRO SALES' ) AS sp_total_payment,
				( $query_payment = 'SANJOSE SALES' ) AS sj_total_payment,
				( $query_payment = 'RIZAL SALES' ) AS rzl_total_payment,
				( $query_payment = 'ADPLUS SALES' ) AS adpls_total_payment
			";
			
		$q=mysql_query($s) or die(mysql_error());
		$r_may=mysql_fetch_assoc($q);
		?>
		
		<tr class='w3-tiny w3-light-gray'>
			<td colspan='7'>&nbsp;</td>
		</tr>
		
		<tr>
			<td rowspan='4'><?php echo $month; ?></td>
			<td class='w3-text-indigo'> &nbsp;JO CREATED</td>
			<?php echo "<td><b>".number_format($r_may['main_total_jo']+$r_may['sm_total_jo']+$r_may['sp_total_jo']+$r_may['sj_total_jo']+$r_may['rzl_total_jo'],2)."</b></td>";
				  if($r_may['main_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_may=1&jo_main=1&year=".$year."' target='_blank'><b>".number_format($r_may['main_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_may['sm_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_may=1&jo_sm=1&year=".$year."' target='_blank'><b>".number_format($r_may['sm_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_may['sp_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_may=1&jo_sp=1&year=".$year."' target='_blank'><b>".number_format($r_may['sp_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_may['sj_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_may=1&jo_sj=1&year=".$year."' target='_blank'><b>".number_format($r_may['sj_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_may['rzl_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_may=1&jo_rzl=1&year=".$year."' target='_blank'><b>".number_format($r_may['rzl_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_may['adpls_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_may=1&jo_adpls=1&year=".$year."' target='_blank'><b>".number_format($r_may['adpls_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}	?>
		</tr>
		
		<tr>
			<td class='w3-text-purple'>PAYMENTS RECIEVED</td>
			<?php echo "<td><b>".number_format($r_may['main_total_payment']+$r_may['sm_total_payment']+$r_may['sp_total_payment']+$r_may['sj_total_payment']+$r_may['rzl_total_payment'],2)."</b></td>";
				  if($r_may['main_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_may=1&jo_main=1&year=".$year."' target='_blank'><b>".number_format($r_may['main_total_payment'],2)."</a></b></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_may['sm_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_may=1&jo_sm=1&year=".$year."' target='_blank'><b>".number_format($r_may['sm_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_may['sp_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_may=1&jo_sp=1&year=".$year."' target='_blank'><b>".number_format($r_may['sp_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_may['sj_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_may=1&jo_sj=1&year=".$year."' target='_blank'><b>".number_format($r_may['sj_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_may['rzl_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_may=1&jo_rzl=1&year=".$year."' target='_blank'><b>".number_format($r_may['rzl_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_may['adpls_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_may=1&jo_adpls=1&year=".$year."' target='_blank'><b>".number_format($r_may['adpls_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}	?>
		</tr>
		
		<tr>
			<td class='w3-text-brown'>TOTAL DR</td>
			<?php echo "<td><b>".number_format($r_may['main_total_dr']+$r_may['sm_total_dr']+$r_may['sp_total_dr']+$r_may['sj_total_dr']+$r_may['rzl_total_dr'],2)."</b></td>";
				  if($r_may['main_total_dr']){echo "<td><a href='vipreport_detailed.php?dr_list=1&m_may=1&jo_main=1&year=".$year."' target='_blank'><b>".number_format($r_may['main_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_may['sm_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&m_may=1&jo_sm=1&year=".$year."' target='_blank'><b>".number_format($r_may['sm_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_may['sp_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&m_may=1&jo_sp=1&year=".$year."' target='_blank'><b>".number_format($r_may['sp_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_may['sj_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&m_may=1&jo_sj=1&year=".$year."' target='_blank'><b>".number_format($r_may['sj_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_may['rzl_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&m_may=1&jo_rzl=1&year=".$year."' target='_blank'><b>".number_format($r_may['rzl_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_may['adpls_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&m_may=1&jo_adpls=1&year=".$year."' target='_blank'><b>".number_format($r_may['adpls_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}	?>
		</tr>
		
		
		
		<!-- APRIL -->
		<?php
		$date=$year."-04";
		$month="APRIL ".$year;
		
		$query_jo="$q_jo_common WHERE a.created_datetime LIKE '$date%' AND b.department";
		$query_dr="$q_dr_common WHERE a.dr_date LIKE '$date%' AND a.bch";
		$query_payment="$q_payment_common WHERE a.payment_datetime LIKE '$date%' AND c.department";	
		
		$s="SELECT
				( $query_jo = 'SALES' ) AS main_total_jo,
				( $query_jo = 'SM SALES' ) AS sm_total_jo,
				( $query_jo = 'SANPEDRO SALES' ) AS sp_total_jo,	
				( $query_jo = 'SANJOSE SALES' ) AS sj_total_jo,
				( $query_jo = 'RIZAL SALES' ) AS rzl_total_jo,
				( $query_jo = 'ADPLUS SALES' ) AS adplus_total_jo,	
					
				( $query_dr = 'main' ) AS main_total_dr,
				( $query_dr = 'sm' ) AS sm_total_dr,
				( $query_dr = 'sp' ) AS sp_total_dr,
				( $query_dr = 'sj' ) AS sj_total_dr,
				( $query_dr = 'rzl' ) AS rzl_total_dr,	
				( $query_dr = 'adpls' ) AS adpls_total_dr,	
				
				( $query_payment = 'SALES' ) AS main_total_payment,
				( $query_payment = 'SM SALES' ) AS sm_total_payment,
				( $query_payment = 'SANPEDRO SALES' ) AS sp_total_payment,
				( $query_payment = 'SANJOSE SALES' ) AS sj_total_payment,
				( $query_payment = 'RIZAL SALES' ) AS rzl_total_payment,
				( $query_payment = 'ADPLUS SALES' ) AS adpls_total_payment
			";
			
		$q=mysql_query($s) or die(mysql_error());
		$r_apr=mysql_fetch_assoc($q);
		?>
		
		<tr class='w3-tiny w3-light-gray'>
			<td colspan='7'>&nbsp;</td>
		</tr>
		
		<tr>
			<td rowspan='4'><?php echo $month; ?></td>
			<td class='w3-text-indigo'> &nbsp;JO CREATED</td>
			<?php echo "<td><b>".number_format($r_apr['main_total_jo']+$r_apr['sm_total_jo']+$r_apr['sp_total_jo']+$r_apr['sj_total_jo']+$r_apr['rzl_total_jo'],2)."</b></td>";
				  if($r_apr['main_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_apr=1&jo_main=1&year=".$year."' target='_blank'><b>".number_format($r_apr['main_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_apr['sm_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_apr=1&jo_sm=1&year=".$year."' target='_blank'><b>".number_format($r_apr['sm_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_apr['sp_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_apr=1&jo_sp=1&year=".$year."' target='_blank'><b>".number_format($r_apr['sp_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_apr['sj_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_apr=1&jo_sj=1&year=".$year."' target='_blank'><b>".number_format($r_apr['sj_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_apr['rzl_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_apr=1&jo_rzl=1&year=".$year."' target='_blank'><b>".number_format($r_apr['rzl_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_apr['adpls_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_apr=1&jo_adpls=1&year=".$year."' target='_blank'><b>".number_format($r_apr['adpls_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}	?>
		</tr>
		
		<tr>
			<td class='w3-text-purple'>PAYMENTS RECIEVED</td>
			<?php echo "<td><b>".number_format($r_apr['main_total_payment']+$r_apr['sm_total_payment']+$r_apr['sp_total_payment']+$r_apr['sj_total_payment']+$r_apr['rzl_total_payment'],2)."</b></td>";
				  if($r_apr['main_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_apr=1&jo_main=1&year=".$year."' target='_blank'><b>".number_format($r_apr['main_total_payment'],2)."</a></b></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_apr['sm_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_apr=1&jo_sm=1&year=".$year."' target='_blank'><b>".number_format($r_apr['sm_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_apr['sp_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_apr=1&jo_sp=1&year=".$year."' target='_blank'><b>".number_format($r_apr['sp_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_apr['sj_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_apr=1&jo_sj=1&year=".$year."' target='_blank'><b>".number_format($r_apr['sj_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_apr['rzl_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_apr=1&jo_rzl=1&year=".$year."' target='_blank'><b>".number_format($r_apr['rzl_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_apr['adpls_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_apr=1&jo_adpls=1&year=".$year."' target='_blank'><b>".number_format($r_apr['adpls_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";} ?>
		</tr>
		
		<tr>
			<td class='w3-text-brown'>TOTAL DR</td>
			<?php echo "<td><b>".number_format($r_apr['main_total_dr']+$r_apr['sm_total_dr']+$r_apr['sp_total_dr']+$r_apr['sj_total_dr']+$r_apr['rzl_total_dr'],2)."</b></td>";
				  if($r_apr['main_total_dr']){echo "<td><a href='vipreport_detailed.php?dr_list=1&m_apr=1&jo_main=1&year=".$year."' target='_blank'><b>".number_format($r_apr['main_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_apr['sm_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&m_apr=1&jo_sm=1&year=".$year."' target='_blank'><b>".number_format($r_apr['sm_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_apr['sp_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&m_apr=1&jo_sp=1&year=".$year."' target='_blank'><b>".number_format($r_apr['sp_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_apr['sj_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&m_apr=1&jo_sj=1&year=".$year."' target='_blank'><b>".number_format($r_apr['sj_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_apr['rzl_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&m_apr=1&jo_rzl=1&year=".$year."' target='_blank'><b>".number_format($r_apr['rzl_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_apr['adpls_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&m_apr=1&jo_adpls=1&year=".$year."' target='_blank'><b>".number_format($r_apr['adpls_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}	?>
		</tr>
		
		
		<!-- MARCH -->
		<?php
		$date=$year."-03";
		$month="MARCH ".$year;
		
		$query_jo="$q_jo_common WHERE a.created_datetime LIKE '$date%' AND b.department";
		$query_dr="$q_dr_common WHERE a.dr_date LIKE '$date%' AND a.bch";
		$query_payment="$q_payment_common WHERE a.payment_datetime LIKE '$date%' AND c.department";	
		
		$s="SELECT
				( $query_jo = 'SALES' ) AS main_total_jo,
				( $query_jo = 'SM SALES' ) AS sm_total_jo,
				( $query_jo = 'SANPEDRO SALES' ) AS sp_total_jo,	
				( $query_jo = 'SANJOSE SALES' ) AS sj_total_jo,
				( $query_jo = 'RIZAL SALES' ) AS rzl_total_jo,
				( $query_jo = 'ADPLUS SALES' ) AS adplus_total_jo,	
					
				( $query_dr = 'main' ) AS main_total_dr,
				( $query_dr = 'sm' ) AS sm_total_dr,
				( $query_dr = 'sp' ) AS sp_total_dr,
				( $query_dr = 'sj' ) AS sj_total_dr,
				( $query_dr = 'rzl' ) AS rzl_total_dr,	
				( $query_dr = 'adpls' ) AS adpls_total_dr,	
				
				( $query_payment = 'SALES' ) AS main_total_payment,
				( $query_payment = 'SM SALES' ) AS sm_total_payment,
				( $query_payment = 'SANPEDRO SALES' ) AS sp_total_payment,
				( $query_payment = 'SANJOSE SALES' ) AS sj_total_payment,
				( $query_payment = 'RIZAL SALES' ) AS rzl_total_payment,
				( $query_payment = 'ADPLUS SALES' ) AS adpls_total_payment
			";
			
		$q=mysql_query($s) or die(mysql_error());
		$r_mar=mysql_fetch_assoc($q);
		?>
		
		<tr class='w3-tiny w3-light-gray'>
			<td colspan='7'>&nbsp;</td>
		</tr>
		
		<tr>
			<td rowspan='4'><?php echo $month; ?></td>
			<td class='w3-text-indigo'> &nbsp;JO CREATED</td>
			<?php echo "<td><b>".number_format($r_mar['main_total_jo']+$r_mar['sm_total_jo']+$r_mar['sp_total_jo']+$r_mar['sj_total_jo']+$r_mar['rzl_total_jo'],2)."</b></td>";
				  if($r_mar['main_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_mar=1&jo_main=1&year=".$year."' target='_blank'><b>".number_format($r_mar['main_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_mar['sm_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_mar=1&jo_sm=1&year=".$year."' target='_blank'><b>".number_format($r_mar['sm_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_mar['sp_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_mar=1&jo_sp=1&year=".$year."' target='_blank'><b>".number_format($r_mar['sp_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_mar['sj_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_mar=1&jo_sj=1&year=".$year."' target='_blank'><b>".number_format($r_mar['sj_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_mar['rzl_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_mar=1&jo_rzl=1&year=".$year."' target='_blank'><b>".number_format($r_mar['rzl_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_mar['adpls_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_mar=1&jo_adpls=1&year=".$year."' target='_blank'><b>".number_format($r_mar['adpls_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}	?>
		</tr>
		
		<tr>
			<td class='w3-text-purple'>PAYMENTS RECIEVED</td>
			<?php echo "<td><b>".number_format($r_mar['main_total_payment']+$r_mar['sm_total_payment']+$r_mar['sp_total_payment']+$r_mar['sj_total_payment']+$r_mar['rzl_total_payment'],2)."</b></td>";
				  if($r_mar['main_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_mar=1&jo_main=1&year=".$year."' target='_blank'><b>".number_format($r_mar['main_total_payment'],2)."</a></b></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_mar['sm_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_mar=1&jo_sm=1&year=".$year."' target='_blank'><b>".number_format($r_mar['sm_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_mar['sp_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_mar=1&jo_sp=1&year=".$year."' target='_blank'><b>".number_format($r_mar['sp_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_mar['sj_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_mar=1&jo_sj=1&year=".$year."' target='_blank'><b>".number_format($r_mar['sj_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_mar['rzl_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_mar=1&jo_rzl=1&year=".$year."' target='_blank'><b>".number_format($r_mar['rzl_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
			      if($r_mar['adpls_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_mar=1&jo_adpls=1&year=".$year."' target='_blank'><b>".number_format($r_mar['adpls_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}		?>
		</tr>
		
		<tr>
			<td class='w3-text-brown'>TOTAL DR</td>
			<?php echo "<td><b>".number_format($r_mar['main_total_dr']+$r_mar['sm_total_dr']+$r_mar['sp_total_dr']+$r_mar['sj_total_dr']+$r_mar['rzl_total_dr'],2)."</b></td>";
				  if($r_mar['main_total_dr']){echo "<td><a href='vipreport_detailed.php?dr_list=1&m_mar=1&jo_main=1&year=".$year."' target='_blank'><b>".number_format($r_mar['main_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_mar['sm_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&m_mar=1&jo_sm=1&year=".$year."' target='_blank'><b>".number_format($r_mar['sm_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_mar['sp_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&m_mar=1&jo_sp=1&year=".$year."' target='_blank'><b>".number_format($r_mar['sp_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_mar['sj_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&m_mar=1&jo_sj=1&year=".$year."' target='_blank'><b>".number_format($r_mar['sj_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_mar['rzl_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&m_mar=1&jo_rzl=1&year=".$year."' target='_blank'><b>".number_format($r_mar['rzl_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_mar['adpls_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&m_mar=1&jo_adpls=1&year=".$year."' target='_blank'><b>".number_format($r_mar['adpls_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}	?>
		</tr>
		
		
		<!-- FEBRUARY -->
		<?php
		$date=$year."-02";
		$month="FEBRUARY ".$year;
		
		$query_jo="$q_jo_common WHERE a.created_datetime LIKE '$date%' AND b.department";
		$query_dr="$q_dr_common WHERE a.dr_date LIKE '$date%' AND a.bch";
		$query_payment="$q_payment_common WHERE a.payment_datetime LIKE '$date%' AND c.department";	
		
		$s="SELECT
				( $query_jo = 'SALES' ) AS main_total_jo,
				( $query_jo = 'SM SALES' ) AS sm_total_jo,
				( $query_jo = 'SANPEDRO SALES' ) AS sp_total_jo,	
				( $query_jo = 'SANJOSE SALES' ) AS sj_total_jo,
				( $query_jo = 'RIZAL SALES' ) AS rzl_total_jo,
				( $query_jo = 'ADPLUS SALES' ) AS adplus_total_jo,	
					
				( $query_dr = 'main' ) AS main_total_dr,
				( $query_dr = 'sm' ) AS sm_total_dr,
				( $query_dr = 'sp' ) AS sp_total_dr,
				( $query_dr = 'sj' ) AS sj_total_dr,
				( $query_dr = 'rzl' ) AS rzl_total_dr,	
				( $query_dr = 'adpls' ) AS adpls_total_dr,	
				
				( $query_payment = 'SALES' ) AS main_total_payment,
				( $query_payment = 'SM SALES' ) AS sm_total_payment,
				( $query_payment = 'SANPEDRO SALES' ) AS sp_total_payment,
				( $query_payment = 'SANJOSE SALES' ) AS sj_total_payment,
				( $query_payment = 'RIZAL SALES' ) AS rzl_total_payment,
				( $query_payment = 'ADPLUS SALES' ) AS adpls_total_payment
			";
			
		$q=mysql_query($s) or die(mysql_error());
		$r_feb=mysql_fetch_assoc($q);
		?>
		
		<tr class='w3-tiny w3-light-gray'>
			<td colspan='7'>&nbsp;</td>
		</tr>
		
		<tr>
			<td rowspan='4'><?php echo $month; ?></td>
			<td class='w3-text-indigo'> &nbsp;JO CREATED</td>
			<?php echo "<td><b>".number_format($r_feb['main_total_jo']+$r_feb['sm_total_jo']+$r_feb['sp_total_jo']+$r_feb['sj_total_jo']+$r_feb['rzl_total_jo'],2)."</b></td>";
				  if($r_feb['main_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_feb=1&jo_main=1&year=".$year."' target='_blank'><b>".number_format($r_feb['main_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_feb['sm_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_feb=1&jo_sm=1&year=".$year."' target='_blank'><b>".number_format($r_feb['sm_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_feb['sp_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_feb=1&jo_sp=1&year=".$year."' target='_blank'><b>".number_format($r_feb['sp_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_feb['sj_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_feb=1&jo_sj=1&year=".$year."' target='_blank'><b>".number_format($r_feb['sj_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_feb['rzl_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_feb=1&jo_rzl=1&year=".$year."' target='_blank'><b>".number_format($r_feb['rzl_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_feb['adpls_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_feb=1&jo_adpls=1&year=".$year."' target='_blank'><b>".number_format($r_feb['adpls_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}?>
		</tr>
		
		<tr>
			<td class='w3-text-purple'>PAYMENTS RECIEVED</td>
			<?php echo "<td><b>".number_format($r_feb['main_total_payment']+$r_feb['sm_total_payment']+$r_feb['sp_total_payment']+$r_feb['sj_total_payment']+$r_feb['rzl_total_payment'],2)."</b></td>";
				  if($r_feb['main_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_feb=1&jo_main=1&year=".$year."' target='_blank'><b>".number_format($r_feb['main_total_payment'],2)."</a></b></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_feb['sm_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_feb=1&jo_sm=1&year=".$year."' target='_blank'><b>".number_format($r_feb['sm_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_feb['sp_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_feb=1&jo_sp=1&year=".$year."' target='_blank'><b>".number_format($r_feb['sp_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_feb['sj_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_feb=1&jo_sj=1&year=".$year."' target='_blank'><b>".number_format($r_feb['sj_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_feb['rzl_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_feb=1&jo_rzl=1&year=".$year."' target='_blank'><b>".number_format($r_feb['rzl_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_feb['adpls_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_feb=1&jo_adpls=1&year=".$year."' target='_blank'><b>".number_format($r_feb['adpls_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}	?>
		</tr>
		
		<tr>
			<td class='w3-text-brown'>TOTAL DR</td>
			<?php echo "<td><b>".number_format($r_feb['main_total_dr']+$r_feb['sm_total_dr']+$r_feb['sp_total_dr']+$r_feb['sj_total_dr']+$r_feb['rzl_total_dr'],2)."</b></td>";
				  if($r_feb['main_total_dr']){echo "<td><a href='vipreport_detailed.php?dr_list=1&m_feb=1&jo_main=1&year=".$year."' target='_blank'><b>".number_format($r_feb['main_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_feb['sm_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&m_feb=1&jo_sm=1&year=".$year."' target='_blank'><b>".number_format($r_feb['sm_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_feb['sp_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&m_feb=1&jo_sp=1&year=".$year."' target='_blank'><b>".number_format($r_feb['sp_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_feb['sj_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&m_feb=1&jo_sj=1&year=".$year."' target='_blank'><b>".number_format($r_feb['sj_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_feb['rzl_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&m_feb=1&jo_rzl=1&year=".$year."' target='_blank'><b>".number_format($r_feb['rzl_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_feb['adpls_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&m_feb=1&jo_adpls=1&year=".$year."' target='_blank'><b>".number_format($r_feb['adpls_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}?>
		</tr>
		
		
		<!-- JANUARY -->
		<?php
		$date=$year."-01";
		$month="JANUARY ".$year;
		
		$query_jo="$q_jo_common WHERE a.created_datetime LIKE '$date%' AND b.department";
		$query_dr="$q_dr_common WHERE a.dr_date LIKE '$date%' AND a.bch";
		$query_payment="$q_payment_common WHERE a.payment_datetime LIKE '$date%' AND c.department";	
		
		$s="SELECT
				( $query_jo = 'SALES' ) AS main_total_jo,
				( $query_jo = 'SM SALES' ) AS sm_total_jo,
				( $query_jo = 'SANPEDRO SALES' ) AS sp_total_jo,	
				( $query_jo = 'SANJOSE SALES' ) AS sj_total_jo,
				( $query_jo = 'RIZAL SALES' ) AS rzl_total_jo,
				( $query_jo = 'ADPLUS SALES' ) AS adplus_total_jo,	
					
				( $query_dr = 'main' ) AS main_total_dr,
				( $query_dr = 'sm' ) AS sm_total_dr,
				( $query_dr = 'sp' ) AS sp_total_dr,
				( $query_dr = 'sj' ) AS sj_total_dr,
				( $query_dr = 'rzl' ) AS rzl_total_dr,	
				( $query_dr = 'adpls' ) AS adpls_total_dr,	
				
				( $query_payment = 'SALES' ) AS main_total_payment,
				( $query_payment = 'SM SALES' ) AS sm_total_payment,
				( $query_payment = 'SANPEDRO SALES' ) AS sp_total_payment,
				( $query_payment = 'SANJOSE SALES' ) AS sj_total_payment,
				( $query_payment = 'RIZAL SALES' ) AS rzl_total_payment,
				( $query_payment = 'ADPLUS SALES' ) AS adpls_total_payment
			";
			
		$q=mysql_query($s) or die(mysql_error());
		$r_jan=mysql_fetch_assoc($q);
		?>
		
		<tr class='w3-tiny w3-light-gray'>
			<td colspan='7'>&nbsp;</td>
		</tr>
		
		<tr>
			<td rowspan='4'><?php echo $month; ?></td>
			<td class='w3-text-indigo'> &nbsp;JO CREATED</td>
			<?php echo "<td><b>".number_format($r_jan['main_total_jo']+$r_jan['sm_total_jo']+$r_jan['sp_total_jo']+$r_jan['sj_total_jo']+$r_jan['rzl_total_jo'],2)."</b></td>";
				  if($r_jan['main_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_jan=1&jo_main=1&year=".$year."' target='_blank'><b>".number_format($r_jan['main_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_jan['sm_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_jan=1&jo_sm=1&year=".$year."' target='_blank'><b>".number_format($r_jan['sm_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_jan['sp_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_jan=1&jo_sp=1&year=".$year."' target='_blank'><b>".number_format($r_jan['sp_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_jan['sj_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_jan=1&jo_sj=1&year=".$year."' target='_blank'><b>".number_format($r_jan['sj_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_jan['rzl_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_jan=1&jo_rzl=1&year=".$year."' target='_blank'><b>".number_format($r_jan['rzl_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_jan['adpls_total_jo']!=0){ echo "<td><a href='vipreport_detailed.php?jo_list=1&m_jan=1&jo_adpls=1&year=".$year."' target='_blank'><b>".number_format($r_jan['adpls_total_jo'],2)."</b></a>"; } else { echo "<td class='w3-text-red'>0.00</td>";}?>
		</tr>
		
		<tr>
			<td class='w3-text-purple'>PAYMENTS RECIEVED</td>
			<?php echo "<td><b>".number_format($r_jan['main_total_payment']+$r_jan['sm_total_payment']+$r_jan['sp_total_payment']+$r_jan['sj_total_payment']+$r_jan['rzl_total_payment'],2)."</b></td>";
				  if($r_jan['main_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_jan=1&jo_main=1&year=".$year."' target='_blank'><b>".number_format($r_jan['main_total_payment'],2)."</a></b></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_jan['sm_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_jan=1&jo_sm=1&year=".$year."' target='_blank'><b>".number_format($r_jan['sm_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_jan['sp_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_jan=1&jo_sp=1&year=".$year."' target='_blank'><b>".number_format($r_jan['sp_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_jan['sj_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_jan=1&jo_sj=1&year=".$year."' target='_blank'><b>".number_format($r_jan['sj_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";} 
				  if($r_jan['rzl_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_jan=1&jo_rzl=1&year=".$year."' target='_blank'><b>".number_format($r_jan['rzl_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_jan['adpls_total_payment']){ echo "<td><a href='vipreport_detailed.php?payment_list=1&m_jan=1&jo_adpls=1&year=".$year."' target='_blank'><b>".number_format($r_jan['adpls_total_payment'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}?>
		</tr>
		
		<tr>
			<td class='w3-text-brown'>TOTAL DR</td>
			<?php echo "<td><b>".number_format($r_jan['main_total_dr']+$r_jan['sm_total_dr']+$r_jan['sp_total_dr']+$r_jan['sj_total_dr']+$r_jan['rzl_total_dr'],2)."</b></td>";
				  if($r_jan['main_total_dr']){echo "<td><a href='vipreport_detailed.php?dr_list=1&m_jan=1&jo_main=1&year=".$year."' target='_blank'><b>".number_format($r_jan['main_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_jan['sm_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&m_jan=1&jo_sm=1&year=".$year."' target='_blank'><b>".number_format($r_jan['sm_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_jan['sp_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&m_jan=1&jo_sp=1&year=".$year."' target='_blank'><b>".number_format($r_jan['sp_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_jan['sj_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&m_jan=1&jo_sj=1&year=".$year."' target='_blank'><b>".number_format($r_jan['sj_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";} 
				  if($r_jan['rzl_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&m_jan=1&jo_rzl=1&year=".$year."' target='_blank'><b>".number_format($r_jan['rzl_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}
				  if($r_jan['adpls_total_dr']){ echo "<td><a href='vipreport_detailed.php?dr_list=1&m_jan=1&jo_adpls=1&year=".$year."' target='_blank'><b>".number_format($r_jan['adpls_total_dr'],2)."</b></a></td>"; } else { echo "<td class='w3-text-red'>0.00</td>";}?>
		</tr>
		
		
	</table>
<hr>
<div align='center' class='w3-xlarge'>ALC LATEST 5 DAYS ( <?php echo date('m/d/Y',strtotime('-4 days'))." - ".date('m/d/Y'); ?> ) PERFORMANCE GRAPHS</div>
<?php
//CHARTS
include 'script_sales_chart_line_5day.php';
?>
<br/><br/><br/>
<hr>
<div align='center' class='w3-xlarge'>ALC YEAR PERFORMANCE GRAPHS</div>

	
<?php
//CHARTS
include 'script_sales_chart_line.php';
include 'script_sales_chart_pie.php';
?>
	
	
	</div>
	<br/>

</body>