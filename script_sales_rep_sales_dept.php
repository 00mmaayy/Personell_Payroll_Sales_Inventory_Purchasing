<?php
if(isset($_REQUEST['search']) and $_REQUEST['search']=="sales_dept")
{
	echo "<br/><br/><div class='container'>";
	
	//CASH SALES MAIN------------------------------------------------------
	$ss_main="SELECT SUM(a.dr_qty*a.b_amount) as main_cash_sales
			  FROM sales_bookings_details a
			  INNER JOIN sales_jo b
				ON a.b_id=b.b_id 
		      WHERE a.dr_date>='$sdate'
				AND a.dr_date<='$edate'
				AND b.delivered=1
				AND a.bch='main'
				AND b.client_id!=1055";
	$qq_main=mysql_query($ss_main) or die(mysql_error());
	$rr_main=mysql_fetch_assoc($qq_main);
	
	//SALES ON ACCOUNT MAIN
	$ss1_main="SELECT SUM(a.dr_qty*a.b_amount) as main_sales_on_account
			   FROM sales_bookings_details a
		       INNER JOIN sales_jo b
				 ON a.b_id=b.b_id 
			   WHERE a.dr_date>='$sdate'
				 AND a.dr_date<='$edate'
				 AND b.delivered=0
				 AND a.bch='main'
				 AND b.client_id!=1055";
	$qq1_main=mysql_query($ss1_main) or die(mysql_error());
	$rr1_main=mysql_fetch_assoc($qq1_main);
	
	
	
	
	
	
	
	//CASH SALES SM-------------------------------------------------------
	$ss_sm="SELECT SUM(a.dr_qty*a.b_amount) as sm_cash_sales
			  FROM sales_bookings_details a
			  INNER JOIN sales_jo b
				ON a.b_id=b.b_id 
		      WHERE a.dr_date>='$sdate'
				AND a.dr_date<='$edate'
				AND b.delivered=1
				AND a.bch='sm'
				AND b.client_id!=1055";
	$qq_sm=mysql_query($ss_sm) or die(mysql_error());
	$rr_sm=mysql_fetch_assoc($qq_sm);
	
	//SALES ON ACCOUNT SM
	$ss1_sm="SELECT SUM(a.dr_qty*a.b_amount) as sm_sales_on_account
			   FROM sales_bookings_details a
		       INNER JOIN sales_jo b
				 ON a.b_id=b.b_id 
			   WHERE a.dr_date>='$sdate'
				 AND a.dr_date<='$edate'
				 AND b.delivered=0
				 AND a.bch='sm'
				 AND b.client_id!=1055";
	$qq1_sm=mysql_query($ss1_sm) or die(mysql_error());
	$rr1_sm=mysql_fetch_assoc($qq1_sm);
	

	
	
	
	
	//CASH SALES SP------------------------------------------------------
	$ss_sp="SELECT SUM(a.dr_qty*a.b_amount) as sp_cash_sales
			  FROM sales_bookings_details a
			  INNER JOIN sales_jo b
				ON a.b_id=b.b_id 
		      WHERE a.dr_date>='$sdate'
				AND a.dr_date<='$edate'
				AND b.delivered=1
				AND a.bch='sp'
				AND b.client_id!=1055";
	$qq_sp=mysql_query($ss_sp) or die(mysql_error());
	$rr_sp=mysql_fetch_assoc($qq_sp);
	
	//SALES ON ACCOUNT SP
	$ss1_sp="SELECT SUM(a.dr_qty*a.b_amount) as sp_sales_on_account
			   FROM sales_bookings_details a
		       INNER JOIN sales_jo b
				 ON a.b_id=b.b_id 
			   WHERE a.dr_date>='$sdate'
				 AND a.dr_date<='$edate'
				 AND b.delivered=0
				 AND a.bch='sp'
				 AND b.client_id!=1055";
	$qq1_sp=mysql_query($ss1_sp) or die(mysql_error());
	$rr1_sp=mysql_fetch_assoc($qq1_sp);
	
	
	
	
	
	
	//CASH SALES SJ------------------------------------------------------
	$ss_sj="SELECT SUM(a.dr_qty*a.b_amount) as sj_cash_sales
			  FROM sales_bookings_details a
			  INNER JOIN sales_jo b
				ON a.b_id=b.b_id 
		      WHERE a.dr_date>='$sdate'
				AND a.dr_date<='$edate'
				AND b.delivered=1
				AND a.bch='sj'
				AND b.client_id!=1055";
	$qq_sj=mysql_query($ss_sj) or die(mysql_error());
	$rr_sj=mysql_fetch_assoc($qq_sj);
	
	//SALES ON ACCOUNT SJ
	$ss1_sj="SELECT SUM(a.dr_qty*a.b_amount) as sj_sales_on_account
			   FROM sales_bookings_details a
		       INNER JOIN sales_jo b
				 ON a.b_id=b.b_id 
			   WHERE a.dr_date>='$sdate'
				 AND a.dr_date<='$edate'
				 AND b.delivered=0
				 AND a.bch='sj'
				 AND b.client_id!=1055";
	$qq1_sj=mysql_query($ss1_sj) or die(mysql_error());
	$rr1_sj=mysql_fetch_assoc($qq1_sj);
	
	
	
	
	//CASH SALES RIZAL------------------------------------------------------
	$ss_rzl = "SELECT SUM(a.dr_qty*a.b_amount) as rzl_cash_sales
			  FROM sales_bookings_details a
			  INNER JOIN sales_jo b
				ON a.b_id=b.b_id 
		      WHERE a.dr_date>='$sdate'
				AND a.dr_date<='$edate'
				AND b.delivered=1
				AND a.bch='rzl'
				AND b.client_id!=1055";
	$qq_rzl = mysql_query($ss_rzl) or die(mysql_error());
	$rr_rzl = mysql_fetch_assoc($qq_rzl);

	//SALES ON ACCOUNT RIZAL
	$ss1_rzl = "SELECT SUM(a.dr_qty*a.b_amount) as rzl_sales_on_account
			   FROM sales_bookings_details a
		       INNER JOIN sales_jo b
				 ON a.b_id=b.b_id 
			   WHERE a.dr_date>='$sdate'
				 AND a.dr_date<='$edate'
				 AND b.delivered=0
				 AND a.bch='rzl'
				 AND b.client_id!=1055";
	$qq1_rzl = mysql_query($ss1_rzl) or die(mysql_error());
	$rr1_rzl = mysql_fetch_assoc($qq1_rzl);

	
	//CASH SALES ADPLUS------------------------------------------------------
	$ss_adpls = "SELECT SUM(a.dr_qty*a.b_amount) as adpls_cash_sales
			  FROM sales_bookings_details a
			  INNER JOIN sales_jo b
				ON a.b_id=b.b_id 
		      WHERE a.dr_date>='$sdate'
				AND a.dr_date<='$edate'
				AND b.delivered=1
				AND a.bch='adpls'
				AND b.client_id!=1055";
	$qq_adpls = mysql_query($ss_adpls) or die(mysql_error());
	$rr_adpls = mysql_fetch_assoc($qq_adpls);

	//SALES ON ACCOUNT ADPLUS
	$ss1_adpls = "SELECT SUM(a.dr_qty*a.b_amount) as adpls_sales_on_account
			   FROM sales_bookings_details a
		       INNER JOIN sales_jo b
				 ON a.b_id=b.b_id 
			   WHERE a.dr_date>='$sdate'
				 AND a.dr_date<='$edate'
				 AND b.delivered=0
				 AND a.bch='adpls'
				 AND b.client_id!=1055";
	$qq1_adpls = mysql_query($ss1_adpls) or die(mysql_error());
	$rr1_adpls = mysql_fetch_assoc($qq1_adpls);


	
	//CASH SALES PPS------------------------------------------------------
	$ss_pps="SELECT SUM(a.dr_qty*a.b_amount) as pps_cash_sales
			   FROM sales_bookings_details a
			  INNER JOIN sales_jo b
				 ON a.b_id=b.b_id 
		      WHERE a.dr_date>='$sdate'
				AND a.dr_date<='$edate'
				AND b.delivered=1
				AND b.client_id=1055";
	$qq_pps=mysql_query($ss_pps) or die(mysql_error());
	$rr_pps=mysql_fetch_assoc($qq_pps);
	
	//SALES ON ACCOUNT PPS
   $ss1_pps="SELECT SUM(a.dr_qty*a.b_amount) as pps_sales_on_account
			   FROM sales_bookings_details a
		      INNER JOIN sales_jo b
				 ON a.b_id=b.b_id 
			  WHERE a.dr_date>='$sdate'
				AND a.dr_date<='$edate'
				AND b.delivered=0
				AND b.client_id=1055";
	$qq1_pps=mysql_query($ss1_pps) or die(mysql_error());
	$rr1_pps=mysql_fetch_assoc($qq1_pps);
	
	
	//CASH SALES ALL----------------------------------------------------
	$ss="SELECT SUM(a.dr_qty*a.b_amount) as cash_sales
	     FROM sales_bookings_details a
		 INNER JOIN sales_jo b
			ON a.b_id=b.b_id 
		 WHERE a.dr_date>='$sdate'
			AND a.dr_date<='$edate'
			AND b.delivered=1
			AND a.bch!=''";
	$qq=mysql_query($ss) or die(mysql_error());
	$rr=mysql_fetch_assoc($qq);
	
	//SALES ON ACCOUNT ALL
	$ss1="SELECT SUM(a.dr_qty*a.b_amount) as sales_on_account
	      FROM sales_bookings_details a
		  INNER JOIN sales_jo b
			 ON a.b_id=b.b_id 
		  WHERE a.dr_date>='$sdate'
			AND a.dr_date<='$edate'
			AND b.delivered=0
			AND a.bch!=''";
	$qq1=mysql_query($ss1) or die(mysql_error());
	$rr1=mysql_fetch_assoc($qq1);
	
	
	
	
	
	
	
	
	
	echo "<table class='table' border='1'>
			<tr class='w3-green'>
				<td>BRANCH</td><td>SALES ON ACCOUNT</td><td>CASH SALES</td><td>TOTAL</td>
			</tr>";

			
		echo "<tr class='w3-hover-pale-red'>
				<td><b>MAIN</b></td>
				<td align='right'>".number_format($rr1_main['main_sales_on_account'],2)."</td>
				<td align='right'>".number_format($rr_main['main_cash_sales'],2)."</td>
				<td align='right'>".number_format(($rr_main['main_cash_sales']+$rr1_main['main_sales_on_account']),2)."</td>
			 </tr>";		
			
			
		echo "<tr class='w3-hover-pale-yellow'>
				<td><b>SM</b></td>
				<td align='right'>".number_format($rr1_sm['sm_sales_on_account'],2)."</td>
				<td align='right'>".number_format($rr_sm['sm_cash_sales'],2)."</td>
				<td align='right'>".number_format(($rr_sm['sm_cash_sales']+$rr1_sm['sm_sales_on_account']),2)."</td>
			 </tr>";		
			
			
		echo "<tr class='w3-hover-pale-green'>
				<td><b>SAN PEDRO</b></td>
				<td align='right'>".number_format($rr1_sp['sp_sales_on_account'],2)."</td>
				<td align='right'>".number_format($rr_sp['sp_cash_sales'],2)."</td>
				<td align='right'>".number_format(($rr_sp['sp_cash_sales']+$rr1_sp['sp_sales_on_account']),2)."</td>
			 </tr>";		
			
			
		echo "<tr class='w3-hover-pale-blue'>
				<td><b>SAN JOSE</b></td>
				<td align='right'>".number_format($rr1_sj['sj_sales_on_account'],2)."</td>
				<td align='right'>".number_format($rr_sj['sj_cash_sales'],2)."</td>
				<td align='right'>".number_format(($rr_sj['sj_cash_sales']+$rr1_sj['sj_sales_on_account']),2)."</td>
			 </tr>";
			 

		echo "<tr class='w3-hover-pale-blue'>
			 <td><b>RIZAL</b></td>
			 <td align='right'>" . number_format($rr1_rzl['rzl_sales_on_account'], 2) . "</td>
			 <td align='right'>" . number_format($rr_rzl['rzl_cash_sales'], 2) . "</td>
			 <td align='right'>" . number_format(($rr_rzl['rzl_cash_sales'] + $rr1_rzl['rzl_sales_on_account']), 2) . "</td>
		  </tr>";
		  
		  
		echo "<tr class='w3-hover-pale-blue'>
			 <td><b>ADPLUS</b></td>
			 <td align='right'>" . number_format($rr1_adpls['adpls_sales_on_account'], 2) . "</td>
			 <td align='right'>" . number_format($rr_adpls['adpls_cash_sales'], 2) . "</td>
			 <td align='right'>" . number_format(($rr_adpls['adpls_cash_sales'] + $rr1_adpls['adpls_sales_on_account']), 2) . "</td>
		  </tr>";
		  

		echo "<tr class='w3-hover-sand'>
				<td><b>PPS</b></td>
				<td align='right'>".number_format($rr1_pps['pps_sales_on_account'],2)."</td>
				<td align='right'>".number_format($rr_pps['pps_cash_sales'],2)."</td>
				<td align='right'>".number_format(($rr_pps['pps_cash_sales']+$rr1_pps['pps_sales_on_account']),2)."</td>
			 </tr>";	
			
		echo "<tr class='w3-hover-light-gray'>
				<td><b>TOTAL</b></td>
				<td align='right'><b>".number_format($rr1['sales_on_account'],2)."</b></td>
				<td align='right'><b>".number_format($rr['cash_sales'],2)."</b></td>
				<td align='right'><b>".number_format(($rr['cash_sales']+$rr1['sales_on_account']),2)."</b></td>
			 </tr>";	 
			 
	echo "</table>";
	echo "</div>";
}
?>