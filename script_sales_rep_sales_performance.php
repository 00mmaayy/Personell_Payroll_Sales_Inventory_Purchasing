<?php
if(isset($_REQUEST['search']) and $_REQUEST['search']=="sales_performance")
{	
	echo "<div align='center'>
	      <a href='script_sales_monitoring_list.php?sort3=&sdate=".$_REQUEST['sdate']."&edate=".$_REQUEST['edate']."&branch=".$_REQUEST['branch']."&search=sales_performance'>BASED ON SYSTEM JO</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	      <a href='script_sales_monitoring_list.php?sort3=&sdate=".$_REQUEST['sdate']."&edate=".$_REQUEST['edate']."&branch=".$_REQUEST['branch']."&search=sales_performance&actual_joxx=1'>BASED ON ACTUAL JO</a>
		 <br/><br/>";
		 
		 if(isset($_REQUEST['actual_joxx']))
		 { echo "<i class='w3-text-red'>* REPORT BASED ON ACTUAL JO DATE - Detailed Information can be seen on [JO LIST(Actual JO Date) + Date Range]) *</i>"; }
	 else{ echo "<i class='w3-text-red'>* REPORT BASED ON SYSTEM JO DATE *</i>"; }
	 
	echo "</div>";

	$time_start     ="00:00:00"; 		$time_end ="23:59:59";
	$january_start  ="2019-01-01"; 	$january_end  ="2019-01-31";
	$february_start ="2019-02-01"; 	$february_end ="2019-02-29";
	$march_start    ="2019-03-01"; 		$march_end="2019-03-31";
	$april_start    ="2019-04-01"; 		$april_end="2019-04-30";
	$may_start      ="2019-05-01"; 		$may_end  ="2019-05-31";
	$june_start     ="2019-06-01"; 		$june_end ="2019-06-30";
	$july_start     ="2019-07-01"; 		$july_end ="2019-07-31";
	$august_start   ="2019-08-01"; 	$august_end   ="2019-08-31";
	$september_start="2019-09-01"; 	$september_end="2019-09-30";
	$october_start  ="2019-10-01"; 	$october_end  ="2019-10-31";
	$november_start ="2019-11-01"; 	$november_end ="2019-11-30";
	$december_start ="2019-12-01"; 	$december_end ="2019-12-31";
	
	if(isset($_REQUEST['actual_joxx']))
	{
	$s_x="SELECT
	( SELECT COUNT(jo_no)   FROM sales_jo   WHERE jo_actual_date>='$january_start' AND jo_actual_date<='$january_end' AND jo_amount!=0 ) AS jo_count_mar,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SALES'          AND a.jo_actual_date>='$january_start' AND a.jo_actual_date<='$january_end' AND a.jo_amount!=0 ) AS jo_count_mar_main,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SM SALES'       AND a.jo_actual_date>='$january_start' AND a.jo_actual_date<='$january_end' AND a.jo_amount!=0 ) AS jo_count_mar_sm,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANPEDRO SALES' AND a.jo_actual_date>='$january_start' AND a.jo_actual_date<='$january_end' AND a.jo_amount!=0 ) AS jo_count_mar_sp,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANJOSE SALES'  AND a.jo_actual_date>='$january_start' AND a.jo_actual_date<='$january_end' AND a.jo_amount!=0 ) AS jo_count_mar_sj,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='RIZAL SALES'  AND a.jo_actual_date>='$january_start' AND a.jo_actual_date<='$january_end' AND a.jo_amount!=0 ) AS jo_count_mar_rzl,
	
	( SELECT COUNT(jo_no)   FROM sales_jo   WHERE jo_actual_date>='$february_start' AND jo_actual_date<='$february_end' AND jo_amount!=0 ) AS jo_count_feb,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SALES'          AND a.jo_actual_date>='$february_start' AND a.jo_actual_date<='$february_end' AND a.jo_amount!=0 ) AS jo_count_feb_main,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SM SALES'       AND a.jo_actual_date>='$february_start' AND a.jo_actual_date<='$february_end' AND a.jo_amount!=0 ) AS jo_count_feb_sm,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANPEDRO SALES' AND a.jo_actual_date>='$february_start' AND a.jo_actual_date<='$february_end' AND a.jo_amount!=0 ) AS jo_count_feb_sp,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANJOSE SALES'  AND a.jo_actual_date>='$february_start' AND a.jo_actual_date<='$february_end' AND a.jo_amount!=0 ) AS jo_count_feb_sj,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='RIZAL SALES'  AND a.jo_actual_date>='$february_start' AND a.jo_actual_date<='$february_end' AND a.jo_amount!=0 ) AS jo_count_feb_rzl,
	
	( SELECT COUNT(jo_no)   FROM sales_jo   WHERE jo_actual_date>='$march_start' AND jo_actual_date<='$march_end' AND jo_amount!=0 ) AS jo_count_mar,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SALES'          AND a.jo_actual_date>='$march_start' AND a.jo_actual_date<='$march_end' AND a.jo_amount!=0 ) AS jo_count_mar_main,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SM SALES'       AND a.jo_actual_date>='$march_start' AND a.jo_actual_date<='$march_end' AND a.jo_amount!=0 ) AS jo_count_mar_sm,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANPEDRO SALES' AND a.jo_actual_date>='$march_start' AND a.jo_actual_date<='$march_end' AND a.jo_amount!=0 ) AS jo_count_mar_sp,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANJOSE SALES'  AND a.jo_actual_date>='$march_start' AND a.jo_actual_date<='$march_end' AND a.jo_amount!=0 ) AS jo_count_mar_sj,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='RIZAL SALES'  AND a.jo_actual_date>='$march_start' AND a.jo_actual_date<='$march_end' AND a.jo_amount!=0 ) AS jo_count_mar_rzl,
	
	( SELECT COUNT(jo_no)   FROM sales_jo   WHERE jo_actual_date>='$april_start' AND jo_actual_date<='$april_end' AND jo_amount!=0 ) AS jo_count_apr,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SALES'          AND a.jo_actual_date>='$april_start' AND a.jo_actual_date<='$april_end' AND a.jo_amount!=0 ) AS jo_count_apr_main,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SM SALES'       AND a.jo_actual_date>='$april_start' AND a.jo_actual_date<='$april_end' AND a.jo_amount!=0 ) AS jo_count_apr_sm,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANPEDRO SALES' AND a.jo_actual_date>='$april_start' AND a.jo_actual_date<='$april_end' AND a.jo_amount!=0 ) AS jo_count_apr_sp,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANJOSE SALES'  AND a.jo_actual_date>='$april_start' AND a.jo_actual_date<='$april_end' AND a.jo_amount!=0 ) AS jo_count_apr_sj,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='RIZAL SALES'  AND a.jo_actual_date>='$april_start' AND a.jo_actual_date<='$april_end' AND a.jo_amount!=0 ) AS jo_count_apr_rzl,
	
	( SELECT COUNT(jo_no)   FROM sales_jo   WHERE jo_actual_date>='$may_start' AND jo_actual_date<='$may_end' AND jo_amount!=0 ) AS jo_count_may,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SALES'          AND a.jo_actual_date>='$may_start' AND a.jo_actual_date<='$may_end' AND a.jo_amount!=0 ) AS jo_count_may_main,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SM SALES'       AND a.jo_actual_date>='$may_start' AND a.jo_actual_date<='$may_end' AND a.jo_amount!=0 ) AS jo_count_may_sm,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANPEDRO SALES' AND a.jo_actual_date>='$may_start' AND a.jo_actual_date<='$may_end' AND a.jo_amount!=0 ) AS jo_count_may_sp,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANJOSE SALES'  AND a.jo_actual_date>='$may_start' AND a.jo_actual_date<='$may_end' AND a.jo_amount!=0 ) AS jo_count_may_sj,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='RIZAL SALES'  AND a.jo_actual_date>='$may_start' AND a.jo_actual_date<='$may_end' AND a.jo_amount!=0 ) AS jo_count_may_rzl,
	
	( SELECT COUNT(jo_no)   FROM sales_jo   WHERE jo_actual_date >= '$june_start' AND jo_actual_date <= '$june_end' AND jo_amount!=0 ) AS jo_count_jun,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SALES'          AND a.jo_actual_date>='$june_start' AND a.jo_actual_date<='$june_end' AND a.jo_amount!=0 ) AS jo_count_jun_main,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SM SALES'       AND a.jo_actual_date>='$june_start' AND a.jo_actual_date<='$june_end' AND a.jo_amount!=0 ) AS jo_count_jun_sm,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANPEDRO SALES' AND a.jo_actual_date>='$june_start' AND a.jo_actual_date<='$june_end' AND a.jo_amount!=0 ) AS jo_count_jun_sp,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANJOSE SALES'  AND a.jo_actual_date>='$june_start' AND a.jo_actual_date<='$june_end' AND a.jo_amount!=0 ) AS jo_count_jun_sj,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='RIZAL SALES'  AND a.jo_actual_date>='$june_start' AND a.jo_actual_date<='$june_end' AND a.jo_amount!=0 ) AS jo_count_jun_rzl,
	
	( SELECT COUNT(jo_no)   FROM sales_jo   WHERE jo_actual_date >= '$july_start' AND jo_actual_date <= '$july_end' AND jo_amount!=0 ) AS jo_count_jul,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SALES'          AND a.jo_actual_date>='$july_start' AND a.jo_actual_date<='$july_end' AND a.jo_amount!=0 ) AS jo_count_jul_main,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SM SALES'       AND a.jo_actual_date>='$july_start' AND a.jo_actual_date<='$july_end' AND a.jo_amount!=0 ) AS jo_count_jul_sm,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANPEDRO SALES' AND a.jo_actual_date>='$july_start' AND a.jo_actual_date<='$july_end' AND a.jo_amount!=0 ) AS jo_count_jul_sp,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANJOSE SALES'  AND a.jo_actual_date>='$july_start' AND a.jo_actual_date<='$july_end' AND a.jo_amount!=0 ) AS jo_count_jul_sj,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='RIZAL SALES'  AND a.jo_actual_date>='$july_start' AND a.jo_actual_date<='$july_end' AND a.jo_amount!=0 ) AS jo_count_jul_rzl,
	
	( SELECT COUNT(jo_no)   FROM sales_jo   WHERE jo_actual_date >= '$august_start' AND jo_actual_date <= '$august_end' AND jo_amount!=0 ) AS jo_count_aug,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SALES'          AND a.jo_actual_date>='$august_start' AND a.jo_actual_date<='$august_end' AND a.jo_amount!=0 ) AS jo_count_aug_main,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SM SALES'       AND a.jo_actual_date>='$august_start' AND a.jo_actual_date<='$august_end' AND a.jo_amount!=0 ) AS jo_count_aug_sm,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANPEDRO SALES' AND a.jo_actual_date>='$august_start' AND a.jo_actual_date<='$august_end' AND a.jo_amount!=0 ) AS jo_count_aug_sp,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANJOSE SALES'  AND a.jo_actual_date>='$august_start' AND a.jo_actual_date<='$august_end' AND a.jo_amount!=0 ) AS jo_count_aug_sj,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='RIZAL SALES'  AND a.jo_actual_date>='$august_start' AND a.jo_actual_date<='$august_end' AND a.jo_amount!=0 ) AS jo_count_aug_rzl,
	
	( SELECT COUNT(jo_no)   FROM sales_jo   WHERE jo_actual_date >= '$september_start' AND jo_actual_date <= '$september_end' AND jo_amount!=0 ) AS jo_count_sep,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SALES'          AND a.jo_actual_date>='$september_start' AND a.jo_actual_date<='$september_end' AND a.jo_amount!=0 ) AS jo_count_sep_main,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SM SALES'       AND a.jo_actual_date>='$september_start' AND a.jo_actual_date<='$september_end' AND a.jo_amount!=0 ) AS jo_count_sep_sm,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANPEDRO SALES' AND a.jo_actual_date>='$september_start' AND a.jo_actual_date<='$september_end' AND a.jo_amount!=0 ) AS jo_count_sep_sp,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANJOSE SALES'  AND a.jo_actual_date>='$september_start' AND a.jo_actual_date<='$september_end' AND a.jo_amount!=0 ) AS jo_count_sep_sj,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='RIZAL SALES'  AND a.jo_actual_date>='$september_start' AND a.jo_actual_date<='$september_end' AND a.jo_amount!=0 ) AS jo_count_sep_rzl,
	
	( SELECT COUNT(jo_no)   FROM sales_jo   WHERE jo_actual_date >= '$october_start' AND jo_actual_date <= '$october_end' AND jo_amount!=0 ) AS jo_count_oct,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SALES'          AND a.jo_actual_date>='$october_start' AND a.jo_actual_date<='$october_end' AND a.jo_amount!=0 ) AS jo_count_oct_main,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SM SALES'       AND a.jo_actual_date>='$october_start' AND a.jo_actual_date<='$october_end' AND a.jo_amount!=0 ) AS jo_count_oct_sm,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANPEDRO SALES' AND a.jo_actual_date>='$october_start' AND a.jo_actual_date<='$october_end' AND a.jo_amount!=0 ) AS jo_count_oct_sp,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANJOSE SALES'  AND a.jo_actual_date>='$october_start' AND a.jo_actual_date<='$october_end' AND a.jo_amount!=0 ) AS jo_count_oct_sj,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='RIZAL SALES'  AND a.jo_actual_date>='$october_start' AND a.jo_actual_date<='$october_end' AND a.jo_amount!=0 ) AS jo_count_oct_rzl,
	
	( SELECT COUNT(jo_no)   FROM sales_jo   WHERE jo_actual_date >= '$november_start' AND jo_actual_date <= '$november_end' AND jo_amount!=0 ) AS jo_count_nov,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SALES'          AND a.jo_actual_date>='$november_start' AND a.jo_actual_date<='$november_end' AND a.jo_amount!=0 ) AS jo_count_nov_main,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SM SALES'       AND a.jo_actual_date>='$november_start' AND a.jo_actual_date<='$november_end' AND a.jo_amount!=0 ) AS jo_count_nov_sm,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANPEDRO SALES' AND a.jo_actual_date>='$november_start' AND a.jo_actual_date<='$november_end' AND a.jo_amount!=0 ) AS jo_count_nov_sp,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANJOSE SALES'  AND a.jo_actual_date>='$november_start' AND a.jo_actual_date<='$november_end' AND a.jo_amount!=0 ) AS jo_count_nov_sj,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='RIZAL SALES'  AND a.jo_actual_date>='$november_start' AND a.jo_actual_date<='$november_end' AND a.jo_amount!=0 ) AS jo_count_nov_rzl,
	
	( SELECT COUNT(jo_no)   FROM sales_jo   WHERE jo_actual_date>='$december_start' AND jo_actual_date<='$december_end' AND jo_amount!=0 ) AS jo_count_dec,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SALES'          AND a.jo_actual_date>='$december_start' AND a.jo_actual_date<='$december_end' AND a.jo_amount!=0 ) AS jo_count_dec_main,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SM SALES'       AND a.jo_actual_date>='$december_start' AND a.jo_actual_date<='$december_end' AND a.jo_amount!=0 ) AS jo_count_dec_sm,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANPEDRO SALES' AND a.jo_actual_date>='$december_start' AND a.jo_actual_date<='$december_end' AND a.jo_amount!=0 ) AS jo_count_dec_sp,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANJOSE SALES'  AND a.jo_actual_date>='$december_start' AND a.jo_actual_date<='$december_end' AND a.jo_amount!=0 ) AS jo_count_dec_sj,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='RIZAL SALES'  AND a.jo_actual_date>='$december_start' AND a.jo_actual_date<='$december_end' AND a.jo_amount!=0 ) AS jo_count_dec_rzl,
	
	
	( SELECT SUM(jo_amount)   FROM sales_jo   WHERE jo_actual_date>='$january_start' AND jo_actual_date<='$january_end' AND jo_amount!=0 ) AS jo_amount_mar,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SALES'          AND a.jo_actual_date>='$january_start' AND a.jo_actual_date<='$january_end' AND a.jo_amount!=0 ) AS jo_amount_mar_main,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SM SALES'       AND a.jo_actual_date>='$january_start' AND a.jo_actual_date<='$january_end' AND a.jo_amount!=0 ) AS jo_amount_mar_sm,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANPEDRO SALES' AND a.jo_actual_date>='$january_start' AND a.jo_actual_date<='$january_end' AND a.jo_amount!=0 ) AS jo_amount_mar_sp,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANJOSE SALES'  AND a.jo_actual_date>='$january_start' AND a.jo_actual_date<='$january_end' AND a.jo_amount!=0 ) AS jo_amount_mar_sj,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='RIZAL SALES'  AND a.jo_actual_date>='$january_start' AND a.jo_actual_date<='$january_end' AND a.jo_amount!=0 ) AS jo_amount_mar_rzl,
	
	( SELECT SUM(jo_amount)   FROM sales_jo   WHERE jo_actual_date>='$february_start' AND jo_actual_date<='$february_end' AND jo_amount!=0 ) AS jo_amount_feb,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SALES'          AND a.jo_actual_date>='$february_start' AND a.jo_actual_date<='$february_end' AND a.jo_amount!=0 ) AS jo_amount_feb_main,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SM SALES'       AND a.jo_actual_date>='$february_start' AND a.jo_actual_date<='$february_end' AND a.jo_amount!=0 ) AS jo_amount_feb_sm,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANPEDRO SALES' AND a.jo_actual_date>='$february_start' AND a.jo_actual_date<='$february_end' AND a.jo_amount!=0 ) AS jo_amount_feb_sp,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANJOSE SALES'  AND a.jo_actual_date>='$february_start' AND a.jo_actual_date<='$february_end' AND a.jo_amount!=0 ) AS jo_amount_feb_sj,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='RIZAL SALES'  AND a.jo_actual_date>='$february_start' AND a.jo_actual_date<='$february_end' AND a.jo_amount!=0 ) AS jo_amount_feb_rzl,
	
	( SELECT SUM(jo_amount)   FROM sales_jo   WHERE jo_actual_date>='$march_start' AND jo_actual_date<='$march_end' AND jo_amount!=0 ) AS jo_amount_mar,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SALES'          AND a.jo_actual_date>='$march_start' AND a.jo_actual_date<='$march_end' AND a.jo_amount!=0 ) AS jo_amount_mar_main,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SM SALES'       AND a.jo_actual_date>='$march_start' AND a.jo_actual_date<='$march_end' AND a.jo_amount!=0 ) AS jo_amount_mar_sm,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANPEDRO SALES' AND a.jo_actual_date>='$march_start' AND a.jo_actual_date<='$march_end' AND a.jo_amount!=0 ) AS jo_amount_mar_sp,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANJOSE SALES'  AND a.jo_actual_date>='$march_start' AND a.jo_actual_date<='$march_end' AND a.jo_amount!=0 ) AS jo_amount_mar_sj,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='RIZAL SALES'  AND a.jo_actual_date>='$march_start' AND a.jo_actual_date<='$march_end' AND a.jo_amount!=0 ) AS jo_amount_mar_rzl,
	
	( SELECT SUM(jo_amount)   FROM sales_jo   WHERE jo_actual_date>='$april_start' AND jo_actual_date<='$april_end' AND jo_amount!=0 ) AS jo_amount_apr,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SALES'          AND a.jo_actual_date>='$april_start' AND a.jo_actual_date<='$april_end' AND a.jo_amount!=0 ) AS jo_amount_apr_main,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SM SALES'       AND a.jo_actual_date>='$april_start' AND a.jo_actual_date<='$april_end' AND a.jo_amount!=0 ) AS jo_amount_apr_sm,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANPEDRO SALES' AND a.jo_actual_date>='$april_start' AND a.jo_actual_date<='$april_end' AND a.jo_amount!=0 ) AS jo_amount_apr_sp,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANJOSE SALES'  AND a.jo_actual_date>='$april_start' AND a.jo_actual_date<='$april_end' AND a.jo_amount!=0 ) AS jo_amount_apr_sj,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='RIZAL SALES'  AND a.jo_actual_date>='$april_start' AND a.jo_actual_date<='$april_end' AND a.jo_amount!=0 ) AS jo_amount_apr_rzl,
	
	( SELECT SUM(jo_amount)   FROM sales_jo   WHERE jo_actual_date>='$may_start' AND jo_actual_date<='$may_end' AND jo_amount!=0 ) AS jo_amount_may,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SALES'          AND a.jo_actual_date>='$may_start' AND a.jo_actual_date<='$may_end' AND a.jo_amount!=0 ) AS jo_amount_may_main,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SM SALES'       AND a.jo_actual_date>='$may_start' AND a.jo_actual_date<='$may_end' AND a.jo_amount!=0 ) AS jo_amount_may_sm,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANPEDRO SALES' AND a.jo_actual_date>='$may_start' AND a.jo_actual_date<='$may_end' AND a.jo_amount!=0 ) AS jo_amount_may_sp,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANJOSE SALES'  AND a.jo_actual_date>='$may_start' AND a.jo_actual_date<='$may_end' AND a.jo_amount!=0 ) AS jo_amount_may_sj,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='RIZAL SALES'  AND a.jo_actual_date>='$may_start' AND a.jo_actual_date<='$may_end' AND a.jo_amount!=0 ) AS jo_amount_may_rzl,
	
	( SELECT SUM(jo_amount)   FROM sales_jo   WHERE jo_actual_date >= '$june_start' AND jo_actual_date <= '$june_end' AND jo_amount!=0 ) AS jo_amount_jun,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SALES'          AND a.jo_actual_date>='$june_start' AND a.jo_actual_date<='$june_end' AND a.jo_amount!=0 ) AS jo_amount_jun_main,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SM SALES'       AND a.jo_actual_date>='$june_start' AND a.jo_actual_date<='$june_end' AND a.jo_amount!=0 ) AS jo_amount_jun_sm,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANPEDRO SALES' AND a.jo_actual_date>='$june_start' AND a.jo_actual_date<='$june_end' AND a.jo_amount!=0 ) AS jo_amount_jun_sp,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANJOSE SALES'  AND a.jo_actual_date>='$june_start' AND a.jo_actual_date<='$june_end' AND a.jo_amount!=0 ) AS jo_amount_jun_sj,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='RIZAL SALES'  AND a.jo_actual_date>='$june_start' AND a.jo_actual_date<='$june_end' AND a.jo_amount!=0 ) AS jo_amount_jun_rzl,
	
	( SELECT SUM(jo_amount)   FROM sales_jo   WHERE jo_actual_date >= '$july_start' AND jo_actual_date <= '$july_end' AND jo_amount!=0 ) AS jo_amount_jul,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SALES'          AND a.jo_actual_date>='$july_start' AND a.jo_actual_date<='$july_end' AND a.jo_amount!=0 ) AS jo_amount_jul_main,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SM SALES'       AND a.jo_actual_date>='$july_start' AND a.jo_actual_date<='$july_end' AND a.jo_amount!=0 ) AS jo_amount_jul_sm,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANPEDRO SALES' AND a.jo_actual_date>='$july_start' AND a.jo_actual_date<='$july_end' AND a.jo_amount!=0 ) AS jo_amount_jul_sp,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANJOSE SALES'  AND a.jo_actual_date>='$july_start' AND a.jo_actual_date<='$july_end' AND a.jo_amount!=0 ) AS jo_amount_jul_sj,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='RIZAL SALES'  AND a.jo_actual_date>='$july_start' AND a.jo_actual_date<='$july_end' AND a.jo_amount!=0 ) AS jo_amount_jul_rzl,
	
	( SELECT SUM(jo_amount)   FROM sales_jo   WHERE jo_actual_date >= '$august_start' AND jo_actual_date <= '$august_end' AND jo_amount!=0 ) AS jo_amount_aug,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SALES'          AND a.jo_actual_date>='$august_start' AND a.jo_actual_date<='$august_end' AND a.jo_amount!=0 ) AS jo_amount_aug_main,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SM SALES'       AND a.jo_actual_date>='$august_start' AND a.jo_actual_date<='$august_end' AND a.jo_amount!=0 ) AS jo_amount_aug_sm,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANPEDRO SALES' AND a.jo_actual_date>='$august_start' AND a.jo_actual_date<='$august_end' AND a.jo_amount!=0 ) AS jo_amount_aug_sp,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANJOSE SALES'  AND a.jo_actual_date>='$august_start' AND a.jo_actual_date<='$august_end' AND a.jo_amount!=0 ) AS jo_amount_aug_sj,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='RIZAL SALES'  AND a.jo_actual_date>='$august_start' AND a.jo_actual_date<='$august_end' AND a.jo_amount!=0 ) AS jo_amount_aug_rzl,
	
	( SELECT SUM(jo_amount)   FROM sales_jo   WHERE jo_actual_date >= '$september_start' AND jo_actual_date <= '$september_end' AND jo_amount!=0 ) AS jo_amount_sep,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SALES'          AND a.jo_actual_date>='$september_start' AND a.jo_actual_date<='$september_end' AND a.jo_amount!=0 ) AS jo_amount_sep_main,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SM SALES'       AND a.jo_actual_date>='$september_start' AND a.jo_actual_date<='$september_end' AND a.jo_amount!=0 ) AS jo_amount_sep_sm,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANPEDRO SALES' AND a.jo_actual_date>='$september_start' AND a.jo_actual_date<='$september_end' AND a.jo_amount!=0 ) AS jo_amount_sep_sp,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANJOSE SALES'  AND a.jo_actual_date>='$september_start' AND a.jo_actual_date<='$september_end' AND a.jo_amount!=0 ) AS jo_amount_sep_sj,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='RIZAL SALES'  AND a.jo_actual_date>='$september_start' AND a.jo_actual_date<='$september_end' AND a.jo_amount!=0 ) AS jo_amount_sep_rzl,
	
	( SELECT SUM(jo_amount)   FROM sales_jo   WHERE jo_actual_date >= '$october_start' AND jo_actual_date <= '$october_end' AND jo_amount!=0 ) AS jo_amount_oct,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SALES'          AND a.jo_actual_date>='$october_start' AND a.jo_actual_date<='$october_end' AND a.jo_amount!=0 ) AS jo_amount_oct_main,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SM SALES'       AND a.jo_actual_date>='$october_start' AND a.jo_actual_date<='$october_end' AND a.jo_amount!=0 ) AS jo_amount_oct_sm,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANPEDRO SALES' AND a.jo_actual_date>='$october_start' AND a.jo_actual_date<='$october_end' AND a.jo_amount!=0 ) AS jo_amount_oct_sp,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANJOSE SALES'  AND a.jo_actual_date>='$october_start' AND a.jo_actual_date<='$october_end' AND a.jo_amount!=0 ) AS jo_amount_oct_sj,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='RIZAL SALES'  AND a.jo_actual_date>='$october_start' AND a.jo_actual_date<='$october_end' AND a.jo_amount!=0 ) AS jo_amount_oct_rzl,
	
	( SELECT SUM(jo_amount)   FROM sales_jo   WHERE jo_actual_date >= '$november_start' AND jo_actual_date <= '$november_end' AND jo_amount!=0 ) AS jo_amount_nov,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SALES'          AND a.jo_actual_date>='$november_start' AND a.jo_actual_date<='$november_end' AND a.jo_amount!=0 ) AS jo_amount_nov_main,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SM SALES'       AND a.jo_actual_date>='$november_start' AND a.jo_actual_date<='$november_end' AND a.jo_amount!=0 ) AS jo_amount_nov_sm,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANPEDRO SALES' AND a.jo_actual_date>='$november_start' AND a.jo_actual_date<='$november_end' AND a.jo_amount!=0 ) AS jo_amount_nov_sp,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANJOSE SALES'  AND a.jo_actual_date>='$november_start' AND a.jo_actual_date<='$november_end' AND a.jo_amount!=0 ) AS jo_amount_nov_sj,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='RIZAL SALES'  AND a.jo_actual_date>='$november_start' AND a.jo_actual_date<='$november_end' AND a.jo_amount!=0 ) AS jo_amount_nov_rzl,
	
	( SELECT SUM(jo_amount)   FROM sales_jo   WHERE jo_actual_date>='$december_start' AND jo_actual_date<='$december_end' AND jo_amount!=0 ) AS jo_amount_dec,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SALES'          AND a.jo_actual_date>='$december_start' AND a.jo_actual_date<='$december_end' AND a.jo_amount!=0 ) AS jo_amount_dec_main,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SM SALES'       AND a.jo_actual_date>='$december_start' AND a.jo_actual_date<='$december_end' AND a.jo_amount!=0 ) AS jo_amount_dec_sm,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANPEDRO SALES' AND a.jo_actual_date>='$december_start' AND a.jo_actual_date<='$december_end' AND a.jo_amount!=0 ) AS jo_amount_dec_sp,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANJOSE SALES'  AND a.jo_actual_date>='$december_start' AND a.jo_actual_date<='$december_end' AND a.jo_amount!=0 ) AS jo_amount_dec_sj,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='RIZAL SALES'  AND a.jo_actual_date>='$december_start' AND a.jo_actual_date<='$december_end' AND a.jo_amount!=0 ) AS jo_amount_dec_rzl
";
}
else
{	
$s_x="SELECT
	( SELECT COUNT(jo_no)   FROM sales_jo   WHERE created_datetime>='$january_start $time_start' AND created_datetime<='$january_end $time_end' AND jo_amount!=0 ) AS jo_count_mar,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SALES'          AND a.created_datetime>='$january_start $time_start' AND a.created_datetime<='$january_end $time_end' AND a.jo_amount!=0 ) AS jo_count_mar_main,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SM SALES'       AND a.created_datetime>='$january_start $time_start' AND a.created_datetime<='$january_end $time_end' AND a.jo_amount!=0 ) AS jo_count_mar_sm,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANPEDRO SALES' AND a.created_datetime>='$january_start $time_start' AND a.created_datetime<='$january_end $time_end' AND a.jo_amount!=0 ) AS jo_count_mar_sp,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANJOSE SALES'  AND a.created_datetime>='$january_start $time_start' AND a.created_datetime<='$january_end $time_end' AND a.jo_amount!=0 ) AS jo_count_mar_sj,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='RIZAL SALES'  AND a.created_datetime>='$january_start $time_start' AND a.created_datetime<='$january_end $time_end' AND a.jo_amount!=0 ) AS jo_count_mar_rzl,
	
	( SELECT COUNT(jo_no)   FROM sales_jo   WHERE created_datetime>='$february_start $time_start' AND created_datetime<='$february_end $time_end' AND jo_amount!=0 ) AS jo_count_feb,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SALES'          AND a.created_datetime>='$february_start $time_start' AND a.created_datetime<='$february_end $time_end' AND a.jo_amount!=0 ) AS jo_count_feb_main,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SM SALES'       AND a.created_datetime>='$february_start $time_start' AND a.created_datetime<='$february_end $time_end' AND a.jo_amount!=0 ) AS jo_count_feb_sm,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANPEDRO SALES' AND a.created_datetime>='$february_start $time_start' AND a.created_datetime<='$february_end $time_end' AND a.jo_amount!=0 ) AS jo_count_feb_sp,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANJOSE SALES'  AND a.created_datetime>='$february_start $time_start' AND a.created_datetime<='$february_end $time_end' AND a.jo_amount!=0 ) AS jo_count_feb_sj,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='RIZAL SALES'  AND a.created_datetime>='$february_start $time_start' AND a.created_datetime<='$february_end $time_end' AND a.jo_amount!=0 ) AS jo_count_feb_rzl,
	
	( SELECT COUNT(jo_no)   FROM sales_jo   WHERE created_datetime>='$march_start $time_start' AND created_datetime<='$march_end $time_end' AND jo_amount!=0 ) AS jo_count_mar,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SALES'          AND a.created_datetime>='$march_start $time_start' AND a.created_datetime<='$march_end $time_end' AND a.jo_amount!=0 ) AS jo_count_mar_main,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SM SALES'       AND a.created_datetime>='$march_start $time_start' AND a.created_datetime<='$march_end $time_end' AND a.jo_amount!=0 ) AS jo_count_mar_sm,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANPEDRO SALES' AND a.created_datetime>='$march_start $time_start' AND a.created_datetime<='$march_end $time_end' AND a.jo_amount!=0 ) AS jo_count_mar_sp,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANJOSE SALES'  AND a.created_datetime>='$march_start $time_start' AND a.created_datetime<='$march_end $time_end' AND a.jo_amount!=0 ) AS jo_count_mar_sj,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='RIZAL SALES'  AND a.created_datetime>='$march_start $time_start' AND a.created_datetime<='$march_end $time_end' AND a.jo_amount!=0 ) AS jo_count_mar_rzl,
	
	( SELECT COUNT(jo_no)   FROM sales_jo   WHERE created_datetime>='$april_start $time_start' AND created_datetime<='$april_end $time_end' AND jo_amount!=0 ) AS jo_count_apr,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SALES'          AND a.created_datetime>='$april_start $time_start' AND a.created_datetime<='$april_end $time_end' AND a.jo_amount!=0 ) AS jo_count_apr_main,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SM SALES'       AND a.created_datetime>='$april_start $time_start' AND a.created_datetime<='$april_end $time_end' AND a.jo_amount!=0 ) AS jo_count_apr_sm,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANPEDRO SALES' AND a.created_datetime>='$april_start $time_start' AND a.created_datetime<='$april_end $time_end' AND a.jo_amount!=0 ) AS jo_count_apr_sp,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANJOSE SALES'  AND a.created_datetime>='$april_start $time_start' AND a.created_datetime<='$april_end $time_end' AND a.jo_amount!=0 ) AS jo_count_apr_sj,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='RIZAL SALES'  AND a.created_datetime>='$april_start $time_start' AND a.created_datetime<='$april_end $time_end' AND a.jo_amount!=0 ) AS jo_count_apr_rzl,
	
	( SELECT COUNT(jo_no)   FROM sales_jo   WHERE created_datetime>='$may_start $time_start' AND created_datetime<='$may_end $time_end' AND jo_amount!=0 ) AS jo_count_may,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SALES'          AND a.created_datetime>='$may_start $time_start' AND a.created_datetime<='$may_end $time_end' AND a.jo_amount!=0 ) AS jo_count_may_main,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SM SALES'       AND a.created_datetime>='$may_start $time_start' AND a.created_datetime<='$may_end $time_end' AND a.jo_amount!=0 ) AS jo_count_may_sm,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANPEDRO SALES' AND a.created_datetime>='$may_start $time_start' AND a.created_datetime<='$may_end $time_end' AND a.jo_amount!=0 ) AS jo_count_may_sp,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANJOSE SALES'  AND a.created_datetime>='$may_start $time_start' AND a.created_datetime<='$may_end $time_end' AND a.jo_amount!=0 ) AS jo_count_may_sj,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='RIZAL SALES'  AND a.created_datetime>='$may_start $time_start' AND a.created_datetime<='$may_end $time_end' AND a.jo_amount!=0 ) AS jo_count_may_rzl,
	
	( SELECT COUNT(jo_no)   FROM sales_jo   WHERE created_datetime >= '$june_start $time_start' AND created_datetime <= '$june_end $time_end' AND jo_amount!=0 ) AS jo_count_jun,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SALES'          AND a.created_datetime>='$june_start $time_start' AND a.created_datetime<='$june_end $time_end' AND a.jo_amount!=0 ) AS jo_count_jun_main,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SM SALES'       AND a.created_datetime>='$june_start $time_start' AND a.created_datetime<='$june_end $time_end' AND a.jo_amount!=0 ) AS jo_count_jun_sm,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANPEDRO SALES' AND a.created_datetime>='$june_start $time_start' AND a.created_datetime<='$june_end $time_end' AND a.jo_amount!=0 ) AS jo_count_jun_sp,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANJOSE SALES'  AND a.created_datetime>='$june_start $time_start' AND a.created_datetime<='$june_end $time_end' AND a.jo_amount!=0 ) AS jo_count_jun_sj,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='RIZAL SALES'  AND a.created_datetime>='$june_start $time_start' AND a.created_datetime<='$june_end $time_end' AND a.jo_amount!=0 ) AS jo_count_jun_rzl,
	
	
	( SELECT COUNT(jo_no)   FROM sales_jo   WHERE created_datetime >= '$july_start $time_start' AND created_datetime <= '$july_end $time_end' AND jo_amount!=0 ) AS jo_count_jul,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SALES'          AND a.created_datetime>='$july_start $time_start' AND a.created_datetime<='$july_end $time_end' AND a.jo_amount!=0 ) AS jo_count_jul_main,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SM SALES'       AND a.created_datetime>='$july_start $time_start' AND a.created_datetime<='$july_end $time_end' AND a.jo_amount!=0 ) AS jo_count_jul_sm,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANPEDRO SALES' AND a.created_datetime>='$july_start $time_start' AND a.created_datetime<='$july_end $time_end' AND a.jo_amount!=0 ) AS jo_count_jul_sp,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANJOSE SALES'  AND a.created_datetime>='$july_start $time_start' AND a.created_datetime<='$july_end $time_end' AND a.jo_amount!=0 ) AS jo_count_jul_sj,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='RIZAL SALES'  AND a.created_datetime>='$july_start $time_start' AND a.created_datetime<='$july_end $time_end' AND a.jo_amount!=0 ) AS jo_count_jul_rzl,
	
	( SELECT COUNT(jo_no)   FROM sales_jo   WHERE created_datetime >= '$august_start $time_start' AND created_datetime <= '$august_end $time_end' AND jo_amount!=0 ) AS jo_count_aug,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SALES'          AND a.created_datetime>='$august_start $time_start' AND a.created_datetime<='$august_end $time_end' AND a.jo_amount!=0 ) AS jo_count_aug_main,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SM SALES'       AND a.created_datetime>='$august_start $time_start' AND a.created_datetime<='$august_end $time_end' AND a.jo_amount!=0 ) AS jo_count_aug_sm,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANPEDRO SALES' AND a.created_datetime>='$august_start $time_start' AND a.created_datetime<='$august_end $time_end' AND a.jo_amount!=0 ) AS jo_count_aug_sp,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANJOSE SALES'  AND a.created_datetime>='$august_start $time_start' AND a.created_datetime<='$august_end $time_end' AND a.jo_amount!=0 ) AS jo_count_aug_sj,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='RIZAL SALES'  AND a.created_datetime>='$august_start $time_start' AND a.created_datetime<='$august_end $time_end' AND a.jo_amount!=0 ) AS jo_count_aug_rzl,
	
	( SELECT COUNT(jo_no)   FROM sales_jo   WHERE created_datetime >= '$september_start $time_start' AND created_datetime <= '$september_end $time_end' AND jo_amount!=0 ) AS jo_count_sep,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SALES'          AND a.created_datetime>='$september_start $time_start' AND a.created_datetime<='$september_end $time_end' AND a.jo_amount!=0 ) AS jo_count_sep_main,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SM SALES'       AND a.created_datetime>='$september_start $time_start' AND a.created_datetime<='$september_end $time_end' AND a.jo_amount!=0 ) AS jo_count_sep_sm,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANPEDRO SALES' AND a.created_datetime>='$september_start $time_start' AND a.created_datetime<='$september_end $time_end' AND a.jo_amount!=0 ) AS jo_count_sep_sp,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANJOSE SALES'  AND a.created_datetime>='$september_start $time_start' AND a.created_datetime<='$september_end $time_end' AND a.jo_amount!=0 ) AS jo_count_sep_sj,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='RIZAL SALES'  AND a.created_datetime>='$september_start $time_start' AND a.created_datetime<='$september_end $time_end' AND a.jo_amount!=0 ) AS jo_count_sep_rzl,
	
	( SELECT COUNT(jo_no)   FROM sales_jo   WHERE created_datetime >= '$october_start $time_start' AND created_datetime <= '$october_end $time_end' AND jo_amount!=0 ) AS jo_count_oct,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SALES'          AND a.created_datetime>='$october_start $time_start' AND a.created_datetime<='$october_end $time_end' AND a.jo_amount!=0 ) AS jo_count_oct_main,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SM SALES'       AND a.created_datetime>='$october_start $time_start' AND a.created_datetime<='$october_end $time_end' AND a.jo_amount!=0 ) AS jo_count_oct_sm,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANPEDRO SALES' AND a.created_datetime>='$october_start $time_start' AND a.created_datetime<='$october_end $time_end' AND a.jo_amount!=0 ) AS jo_count_oct_sp,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANJOSE SALES'  AND a.created_datetime>='$october_start $time_start' AND a.created_datetime<='$october_end $time_end' AND a.jo_amount!=0 ) AS jo_count_oct_sj,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='RIZAL SALES'  AND a.created_datetime>='$october_start $time_start' AND a.created_datetime<='$october_end $time_end' AND a.jo_amount!=0 ) AS jo_count_oct_rzl,
	
	( SELECT COUNT(jo_no)   FROM sales_jo   WHERE created_datetime >= '$november_start $time_start' AND created_datetime <= '$november_end $time_end' AND jo_amount!=0 ) AS jo_count_nov,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SALES'          AND a.created_datetime>='$november_start $time_start' AND a.created_datetime<='$november_end $time_end' AND a.jo_amount!=0 ) AS jo_count_nov_main,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SM SALES'       AND a.created_datetime>='$november_start $time_start' AND a.created_datetime<='$november_end $time_end' AND a.jo_amount!=0 ) AS jo_count_nov_sm,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANPEDRO SALES' AND a.created_datetime>='$november_start $time_start' AND a.created_datetime<='$november_end $time_end' AND a.jo_amount!=0 ) AS jo_count_nov_sp,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANJOSE SALES'  AND a.created_datetime>='$november_start $time_start' AND a.created_datetime<='$november_end $time_end' AND a.jo_amount!=0 ) AS jo_count_nov_sj,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='RIZAL SALES'  AND a.created_datetime>='$november_start $time_start' AND a.created_datetime<='$november_end $time_end' AND a.jo_amount!=0 ) AS jo_count_nov_rzl,
	
	( SELECT COUNT(jo_no)   FROM sales_jo   WHERE created_datetime>='$december_start $time_start' AND created_datetime<='$december_end $time_end' AND jo_amount!=0 ) AS jo_count_dec,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SALES'          AND a.created_datetime>='$december_start $time_start' AND a.created_datetime<='$december_end $time_end' AND a.jo_amount!=0 ) AS jo_count_dec_main,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SM SALES'       AND a.created_datetime>='$december_start $time_start' AND a.created_datetime<='$december_end $time_end' AND a.jo_amount!=0 ) AS jo_count_dec_sm,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANPEDRO SALES' AND a.created_datetime>='$december_start $time_start' AND a.created_datetime<='$december_end $time_end' AND a.jo_amount!=0 ) AS jo_count_dec_sp,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANJOSE SALES'  AND a.created_datetime>='$december_start $time_start' AND a.created_datetime<='$december_end $time_end' AND a.jo_amount!=0 ) AS jo_count_dec_sj,
	( SELECT COUNT(a.jo_no) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='RIZAL SALES'  AND a.created_datetime>='$december_start $time_start' AND a.created_datetime<='$december_end $time_end' AND a.jo_amount!=0 ) AS jo_count_dec_rzl,
	
	
	( SELECT SUM(jo_amount)   FROM sales_jo   WHERE created_datetime>='$january_start $time_start' AND created_datetime<='$january_end $time_end' AND jo_amount!=0 ) AS jo_amount_mar,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SALES'          AND a.created_datetime>='$january_start $time_start' AND a.created_datetime<='$january_end $time_end' AND a.jo_amount!=0 ) AS jo_amount_mar_main,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SM SALES'       AND a.created_datetime>='$january_start $time_start' AND a.created_datetime<='$january_end $time_end' AND a.jo_amount!=0 ) AS jo_amount_mar_sm,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANPEDRO SALES' AND a.created_datetime>='$january_start $time_start' AND a.created_datetime<='$january_end $time_end' AND a.jo_amount!=0 ) AS jo_amount_mar_sp,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANJOSE SALES'  AND a.created_datetime>='$january_start $time_start' AND a.created_datetime<='$january_end $time_end' AND a.jo_amount!=0 ) AS jo_amount_mar_sj,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='RIZAL SALES'  AND a.created_datetime>='$january_start $time_start' AND a.created_datetime<='$january_end $time_end' AND a.jo_amount!=0 ) AS jo_amount_mar_rzl,
	
	( SELECT SUM(jo_amount)   FROM sales_jo   WHERE created_datetime>='$february_start $time_start' AND created_datetime<='$february_end $time_end' AND jo_amount!=0 ) AS jo_amount_feb,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SALES'          AND a.created_datetime>='$february_start $time_start' AND a.created_datetime<='$february_end $time_end' AND a.jo_amount!=0 ) AS jo_amount_feb_main,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SM SALES'       AND a.created_datetime>='$february_start $time_start' AND a.created_datetime<='$february_end $time_end' AND a.jo_amount!=0 ) AS jo_amount_feb_sm,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANPEDRO SALES' AND a.created_datetime>='$february_start $time_start' AND a.created_datetime<='$february_end $time_end' AND a.jo_amount!=0 ) AS jo_amount_feb_sp,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANJOSE SALES'  AND a.created_datetime>='$february_start $time_start' AND a.created_datetime<='$february_end $time_end' AND a.jo_amount!=0 ) AS jo_amount_feb_sj,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='RIZAL SALES'  AND a.created_datetime>='$february_start $time_start' AND a.created_datetime<='$february_end $time_end' AND a.jo_amount!=0 ) AS jo_amount_feb_rzl,
	
	( SELECT SUM(jo_amount)   FROM sales_jo   WHERE created_datetime>='$march_start $time_start' AND created_datetime<='$march_end $time_end' AND jo_amount!=0 ) AS jo_amount_mar,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SALES'          AND a.created_datetime>='$march_start $time_start' AND a.created_datetime<='$march_end $time_end' AND a.jo_amount!=0 ) AS jo_amount_mar_main,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SM SALES'       AND a.created_datetime>='$march_start $time_start' AND a.created_datetime<='$march_end $time_end' AND a.jo_amount!=0 ) AS jo_amount_mar_sm,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANPEDRO SALES' AND a.created_datetime>='$march_start $time_start' AND a.created_datetime<='$march_end $time_end' AND a.jo_amount!=0 ) AS jo_amount_mar_sp,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANJOSE SALES'  AND a.created_datetime>='$march_start $time_start' AND a.created_datetime<='$march_end $time_end' AND a.jo_amount!=0 ) AS jo_amount_mar_sj,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='RIZAL SALES'  AND a.created_datetime>='$march_start $time_start' AND a.created_datetime<='$march_end $time_end' AND a.jo_amount!=0 ) AS jo_amount_mar_rzl,
	
	( SELECT SUM(jo_amount)   FROM sales_jo   WHERE created_datetime>='$april_start $time_start' AND created_datetime<='$april_end $time_end' AND jo_amount!=0 ) AS jo_amount_apr,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SALES'          AND a.created_datetime>='$april_start $time_start' AND a.created_datetime<='$april_end $time_end' AND a.jo_amount!=0 ) AS jo_amount_apr_main,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SM SALES'       AND a.created_datetime>='$april_start $time_start' AND a.created_datetime<='$april_end $time_end' AND a.jo_amount!=0 ) AS jo_amount_apr_sm,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANPEDRO SALES' AND a.created_datetime>='$april_start $time_start' AND a.created_datetime<='$april_end $time_end' AND a.jo_amount!=0 ) AS jo_amount_apr_sp,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANJOSE SALES'  AND a.created_datetime>='$april_start $time_start' AND a.created_datetime<='$april_end $time_end' AND a.jo_amount!=0 ) AS jo_amount_apr_sj,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='RIZAL SALES'  AND a.created_datetime>='$april_start $time_start' AND a.created_datetime<='$april_end $time_end' AND a.jo_amount!=0 ) AS jo_amount_apr_rzl,
	
	( SELECT SUM(jo_amount)   FROM sales_jo   WHERE created_datetime>='$may_start $time_start' AND created_datetime<='$may_end $time_end' AND jo_amount!=0 ) AS jo_amount_may,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SALES'          AND a.created_datetime>='$may_start $time_start' AND a.created_datetime<='$may_end $time_end' AND a.jo_amount!=0 ) AS jo_amount_may_main,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SM SALES'       AND a.created_datetime>='$may_start $time_start' AND a.created_datetime<='$may_end $time_end' AND a.jo_amount!=0 ) AS jo_amount_may_sm,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANPEDRO SALES' AND a.created_datetime>='$may_start $time_start' AND a.created_datetime<='$may_end $time_end' AND a.jo_amount!=0 ) AS jo_amount_may_sp,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANJOSE SALES'  AND a.created_datetime>='$may_start $time_start' AND a.created_datetime<='$may_end $time_end' AND a.jo_amount!=0 ) AS jo_amount_may_sj,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='RIZAL SALES'  AND a.created_datetime>='$may_start $time_start' AND a.created_datetime<='$may_end $time_end' AND a.jo_amount!=0 ) AS jo_amount_may_rzl,
	
	( SELECT SUM(jo_amount)   FROM sales_jo   WHERE created_datetime >= '$june_start $time_start' AND created_datetime <= '$june_end $time_end' AND jo_amount!=0 ) AS jo_amount_jun,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SALES'          AND a.created_datetime>='$june_start $time_start' AND a.created_datetime<='$june_end $time_end' AND a.jo_amount!=0 ) AS jo_amount_jun_main,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SM SALES'       AND a.created_datetime>='$june_start $time_start' AND a.created_datetime<='$june_end $time_end' AND a.jo_amount!=0 ) AS jo_amount_jun_sm,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANPEDRO SALES' AND a.created_datetime>='$june_start $time_start' AND a.created_datetime<='$june_end $time_end' AND a.jo_amount!=0 ) AS jo_amount_jun_sp,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANJOSE SALES'  AND a.created_datetime>='$june_start $time_start' AND a.created_datetime<='$june_end $time_end' AND a.jo_amount!=0 ) AS jo_amount_jun_sj,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='RIZAL SALES'  AND a.created_datetime>='$june_start $time_start' AND a.created_datetime<='$june_end $time_end' AND a.jo_amount!=0 ) AS jo_amount_jun_rzl,
	
	( SELECT SUM(jo_amount)   FROM sales_jo   WHERE created_datetime >= '$july_start $time_start' AND created_datetime <= '$july_end $time_end' AND jo_amount!=0 ) AS jo_amount_jul,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SALES'          AND a.created_datetime>='$july_start $time_start' AND a.created_datetime<='$july_end $time_end' AND a.jo_amount!=0 ) AS jo_amount_jul_main,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SM SALES'       AND a.created_datetime>='$july_start $time_start' AND a.created_datetime<='$july_end $time_end' AND a.jo_amount!=0 ) AS jo_amount_jul_sm,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANPEDRO SALES' AND a.created_datetime>='$july_start $time_start' AND a.created_datetime<='$july_end $time_end' AND a.jo_amount!=0 ) AS jo_amount_jul_sp,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANJOSE SALES'  AND a.created_datetime>='$july_start $time_start' AND a.created_datetime<='$july_end $time_end' AND a.jo_amount!=0 ) AS jo_amount_jul_sj,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='RIZAL SALES'  AND a.created_datetime>='$july_start $time_start' AND a.created_datetime<='$july_end $time_end' AND a.jo_amount!=0 ) AS jo_amount_jul_rzl,
	
	( SELECT SUM(jo_amount)   FROM sales_jo   WHERE created_datetime >= '$august_start $time_start' AND created_datetime <= '$august_end $time_end' AND jo_amount!=0 ) AS jo_amount_aug,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SALES'          AND a.created_datetime>='$august_start $time_start' AND a.created_datetime<='$august_end $time_end' AND a.jo_amount!=0 ) AS jo_amount_aug_main,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SM SALES'       AND a.created_datetime>='$august_start $time_start' AND a.created_datetime<='$august_end $time_end' AND a.jo_amount!=0 ) AS jo_amount_aug_sm,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANPEDRO SALES' AND a.created_datetime>='$august_start $time_start' AND a.created_datetime<='$august_end $time_end' AND a.jo_amount!=0 ) AS jo_amount_aug_sp,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANJOSE SALES'  AND a.created_datetime>='$august_start $time_start' AND a.created_datetime<='$august_end $time_end' AND a.jo_amount!=0 ) AS jo_amount_aug_sj,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='RIZAL SALES'  AND a.created_datetime>='$august_start $time_start' AND a.created_datetime<='$august_end $time_end' AND a.jo_amount!=0 ) AS jo_amount_aug_rzl,
	
	( SELECT SUM(jo_amount)   FROM sales_jo   WHERE created_datetime >= '$september_start $time_start' AND created_datetime <= '$september_end $time_end' AND jo_amount!=0 ) AS jo_amount_sep,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SALES'          AND a.created_datetime>='$september_start $time_start' AND a.created_datetime<='$september_end $time_end' AND a.jo_amount!=0 ) AS jo_amount_sep_main,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SM SALES'       AND a.created_datetime>='$september_start $time_start' AND a.created_datetime<='$september_end $time_end' AND a.jo_amount!=0 ) AS jo_amount_sep_sm,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANPEDRO SALES' AND a.created_datetime>='$september_start $time_start' AND a.created_datetime<='$september_end $time_end' AND a.jo_amount!=0 ) AS jo_amount_sep_sp,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANJOSE SALES'  AND a.created_datetime>='$september_start $time_start' AND a.created_datetime<='$september_end $time_end' AND a.jo_amount!=0 ) AS jo_amount_sep_sj,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='RIZAL SALES'  AND a.created_datetime>='$september_start $time_start' AND a.created_datetime<='$september_end $time_end' AND a.jo_amount!=0 ) AS jo_amount_sep_rzl,
	
	( SELECT SUM(jo_amount)   FROM sales_jo   WHERE created_datetime >= '$october_start $time_start' AND created_datetime <= '$october_end $time_end' AND jo_amount!=0 ) AS jo_amount_oct,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SALES'          AND a.created_datetime>='$october_start $time_start' AND a.created_datetime<='$october_end $time_end' AND a.jo_amount!=0 ) AS jo_amount_oct_main,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SM SALES'       AND a.created_datetime>='$october_start $time_start' AND a.created_datetime<='$october_end $time_end' AND a.jo_amount!=0 ) AS jo_amount_oct_sm,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANPEDRO SALES' AND a.created_datetime>='$october_start $time_start' AND a.created_datetime<='$october_end $time_end' AND a.jo_amount!=0 ) AS jo_amount_oct_sp,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANJOSE SALES'  AND a.created_datetime>='$october_start $time_start' AND a.created_datetime<='$october_end $time_end' AND a.jo_amount!=0 ) AS jo_amount_oct_sj,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='RIZAL SALES'  AND a.created_datetime>='$october_start $time_start' AND a.created_datetime<='$october_end $time_end' AND a.jo_amount!=0 ) AS jo_amount_oct_rzl,
	
	( SELECT SUM(jo_amount)   FROM sales_jo   WHERE created_datetime >= '$november_start $time_start' AND created_datetime <= '$november_end $time_end' AND jo_amount!=0 ) AS jo_amount_nov,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SALES'          AND a.created_datetime>='$november_start $time_start' AND a.created_datetime<='$november_end $time_end' AND a.jo_amount!=0 ) AS jo_amount_nov_main,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SM SALES'       AND a.created_datetime>='$november_start $time_start' AND a.created_datetime<='$november_end $time_end' AND a.jo_amount!=0 ) AS jo_amount_nov_sm,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANPEDRO SALES' AND a.created_datetime>='$november_start $time_start' AND a.created_datetime<='$november_end $time_end' AND a.jo_amount!=0 ) AS jo_amount_nov_sp,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANJOSE SALES'  AND a.created_datetime>='$november_start $time_start' AND a.created_datetime<='$november_end $time_end' AND a.jo_amount!=0 ) AS jo_amount_nov_sj,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='RIZAL SALES'  AND a.created_datetime>='$november_start $time_start' AND a.created_datetime<='$november_end $time_end' AND a.jo_amount!=0 ) AS jo_amount_nov_rzl,
	
	( SELECT SUM(jo_amount)   FROM sales_jo   WHERE created_datetime>='$december_start $time_start' AND created_datetime<='$december_end $time_end' AND jo_amount!=0 ) AS jo_amount_dec,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SALES'          AND a.created_datetime>='$december_start $time_start' AND a.created_datetime<='$december_end $time_end' AND a.jo_amount!=0 ) AS jo_amount_dec_main,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SM SALES'       AND a.created_datetime>='$december_start $time_start' AND a.created_datetime<='$december_end $time_end' AND a.jo_amount!=0 ) AS jo_amount_dec_sm,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANPEDRO SALES' AND a.created_datetime>='$december_start $time_start' AND a.created_datetime<='$december_end $time_end' AND a.jo_amount!=0 ) AS jo_amount_dec_sp,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='SANJOSE SALES'  AND a.created_datetime>='$december_start $time_start' AND a.created_datetime<='$december_end $time_end' AND a.jo_amount!=0 ) AS jo_amount_dec_sj,
	( SELECT SUM(a.jo_amount) FROM sales_jo a INNER JOIN users b ON a.created_by=b.username WHERE b.department='RIZAL SALES'  AND a.created_datetime>='$december_start $time_start' AND a.created_datetime<='$december_end $time_end' AND a.jo_amount!=0 ) AS jo_amount_dec_rzl
";
} 
	$q_x=mysql_query($s_x) or die(mysql_error());
	$r_x=mysql_fetch_assoc($q_x);
	
echo "<br/><div class='container'>
	  <table class='table' border='1'>
		<tr class='w3-green'>
			<td>MONTH</td>
			<td>JO COUNT</td>
			<td>JO AMOUNT</td>
		</tr>";
/*		
echo "<tr><td>JANUARY</td>
					<td>
						<table class='table w3-small' border='1'>
								<tr><td>MAIN</td><td>".$r_x['jo_count_jan_main']."</td></tr>
								<tr><td>SM</td><td>".$r_x['jo_count_jan_sm']."</td></tr>
								<tr><td>SP</td><td>".$r_x['jo_count_jan_sp']."</td></tr>
								<tr><td>SJ</td><td>".$r_x['jo_count_jan_sj']."</td></tr>
								<tr class='w3-large w3-text-indigo'><td>TOTAL</td><td>".$r_x['jo_count_jan']."</td></tr>
						</table> 
					</td>
					<td>
						<table class='table w3-small' border='1'>
								<tr><td>MAIN</td><td>".number_format($r_x['jo_amount_jan_main'],2)."</td></tr>
								<tr><td>SM</td><td>".number_format($r_x['jo_amount_jan_sm'],2)."</td></tr>
								<tr><td>SP</td><td>".number_format($r_x['jo_amount_jan_sp'],2)."</td></tr>
								<tr><td>SJ</td><td>".number_format($r_x['jo_amount_jan_sj'],2)."</td></tr>
								<tr class='w3-large w3-text-red'><td>TOTAL</td><td>".number_format($r_x['jo_amount_jan'],2)."</td></tr>
						</table>		
					</td>
	  </tr>";
*/
	  
echo "<tr><td>FEBRUARY</td>
					<td>
						<table class='table w3-small' border='1'>
								<tr><td>MAIN</td><td>".$r_x['jo_count_feb_main']."</td></tr>
								<tr><td>SM</td><td>".$r_x['jo_count_feb_sm']."</td></tr>
								<tr><td>SP</td><td>".$r_x['jo_count_feb_sp']."</td></tr>
								<tr><td>SJ</td><td>".$r_x['jo_count_feb_sj']."</td></tr>
								<tr><td>RIZAL</td><td>".$r_x['jo_count_feb_rzl']."</td></tr>
								<tr class='w3-large w3-text-indigo'><td>TOTAL</td><td>".$r_x['jo_count_feb']."</td></tr>
						</table> 
					</td>
					<td>
						<table class='table w3-small' border='1'>
								<tr><td>MAIN</td><td>".number_format($r_x['jo_amount_feb_main'],2)."</td></tr>
								<tr><td>SM</td><td>".number_format($r_x['jo_amount_feb_sm'],2)."</td></tr>
								<tr><td>SP</td><td>".number_format($r_x['jo_amount_feb_sp'],2)."</td></tr>
								<tr><td>SJ</td><td>".number_format($r_x['jo_amount_feb_sj'],2)."</td></tr>
								<tr><td>RIZAL</td><td>".number_format($r_x['jo_amount_feb_rzl'],2)."</td></tr>
								<tr class='w3-large w3-text-red'><td>TOTAL</td><td>".number_format($r_x['jo_amount_feb'],2)."</td></tr>
						</table>		
					</td>
	  </tr>";
	  
echo "<tr><td>MARCH</td>
					<td>
						<table class='table w3-small' border='1'>
								<tr><td>MAIN</td><td>".$r_x['jo_count_mar_main']."</td></tr>
								<tr><td>SM</td><td>".$r_x['jo_count_mar_sm']."</td></tr>
								<tr><td>SP</td><td>".$r_x['jo_count_mar_sp']."</td></tr>
								<tr><td>SJ</td><td>".$r_x['jo_count_mar_sj']."</td></tr>
								<tr><td>RIZAL</td><td>".$r_x['jo_count_mar_rzl']."</td></tr>
								<tr class='w3-large w3-text-indigo'><td>TOTAL</td><td>".$r_x['jo_count_mar']."</td></tr>
						</table> 
					</td>
					<td>
						<table class='table w3-small' border='1'>
								<tr><td>MAIN</td><td>".number_format($r_x['jo_amount_mar_main'],2)."</td></tr>
								<tr><td>SM</td><td>".number_format($r_x['jo_amount_mar_sm'],2)."</td></tr>
								<tr><td>SP</td><td>".number_format($r_x['jo_amount_mar_sp'],2)."</td></tr>
								<tr><td>SJ</td><td>".number_format($r_x['jo_amount_mar_sj'],2)."</td></tr>
								<tr><td>RIZAL</td><td>".number_format($r_x['jo_amount_mar_rzl'],2)."</td></tr>
								<tr class='w3-large w3-text-red'><td>TOTAL</td><td>".number_format($r_x['jo_amount_mar'],2)."</td></tr>
						</table>		
					</td>
	  </tr>";
	  
echo "<tr><td>APRIL</td>
					<td>
						<table class='table w3-small' border='1'>
								<tr><td>MAIN</td><td>".$r_x['jo_count_apr_main']."</td></tr>
								<tr><td>SM</td><td>".$r_x['jo_count_apr_sm']."</td></tr>
								<tr><td>SP</td><td>".$r_x['jo_count_apr_sp']."</td></tr>
								<tr><td>SJ</td><td>".$r_x['jo_count_apr_sj']."</td></tr>
								<tr><td>RIZAL</td><td>".$r_x['jo_count_apr_rzl']."</td></tr>
								<tr class='w3-large w3-text-indigo'><td>TOTAL</td><td>".$r_x['jo_count_apr']."</td></tr>
						</table> 
					</td>
					<td>
						<table class='table w3-small' border='1'>
								<tr><td>MAIN</td><td>".number_format($r_x['jo_amount_apr_main'],2)."</td></tr>
								<tr><td>SM</td><td>".number_format($r_x['jo_amount_apr_sm'],2)."</td></tr>
								<tr><td>SP</td><td>".number_format($r_x['jo_amount_apr_sp'],2)."</td></tr>
								<tr><td>SJ</td><td>".number_format($r_x['jo_amount_apr_sj'],2)."</td></tr>
								<tr><td>RIZAL</td><td>".number_format($r_x['jo_amount_apr_rzl'],2)."</td></tr>
								<tr class='w3-large w3-text-red'><td>TOTAL</td><td>".number_format($r_x['jo_amount_apr'],2)."</td></tr>
						</table>		
					</td>
	  </tr>";
							
echo "<tr><td>MAY</td>
					<td>
						<table class='table w3-small' border='1'>
								<tr><td>MAIN</td><td>".$r_x['jo_count_may_main']."</td></tr>
								<tr><td>SM</td><td>".$r_x['jo_count_may_sm']."</td></tr>
								<tr><td>SP</td><td>".$r_x['jo_count_may_sp']."</td></tr>
								<tr><td>SJ</td><td>".$r_x['jo_count_may_sj']."</td></tr>
								<tr><td>RIZAL</td><td>".$r_x['jo_count_may_rzl']."</td></tr>
								<tr class='w3-large w3-text-indigo'><td>TOTAL</td><td>".$r_x['jo_count_may']."</td></tr>
						</table> 
					</td>
					<td>
						<table class='table w3-small' border='1'>
								<tr><td>MAIN</td><td>".number_format($r_x['jo_amount_may_main'],2)."</td></tr>
								<tr><td>SM</td><td>".number_format($r_x['jo_amount_may_sm'],2)."</td></tr>
								<tr><td>SP</td><td>".number_format($r_x['jo_amount_may_sp'],2)."</td></tr>
								<tr><td>SJ</td><td>".number_format($r_x['jo_amount_may_sj'],2)."</td></tr>
								<tr><td>RIZAL</td><td>".number_format($r_x['jo_amount_may_rzl'],2)."</td></tr>
								<tr class='w3-large w3-text-red'><td>TOTAL</td><td>".number_format($r_x['jo_amount_may'],2)."</td></tr>
						</table>		
					</td>
	  </tr>";
	  
echo "<tr><td>JUNE</td>
					<td>
						<table class='table w3-small' border='1'>
								<tr><td>MAIN</td><td>".$r_x['jo_count_jun_main']."</td></tr>
								<tr><td>SM</td><td>".$r_x['jo_count_jun_sm']."</td></tr>
								<tr><td>SP</td><td>".$r_x['jo_count_jun_sp']."</td></tr>
								<tr><td>SJ</td><td>".$r_x['jo_count_jun_sj']."</td></tr>
								<tr><td>RIZAL</td><td>".$r_x['jo_count_jun_rzl']."</td></tr>
								<tr class='w3-large w3-text-indigo'><td>TOTAL</td><td>".$r_x['jo_count_jun']."</td></tr>
						</table> 
					</td>
					<td>
						<table class='table w3-small' border='1'>
								<tr><td>MAIN</td><td>".number_format($r_x['jo_amount_jun_main'],2)."</td></tr>
								<tr><td>SM</td><td>".number_format($r_x['jo_amount_jun_sm'],2)."</td></tr>
								<tr><td>SP</td><td>".number_format($r_x['jo_amount_jun_sp'],2)."</td></tr>
								<tr><td>SJ</td><td>".number_format($r_x['jo_amount_jun_sj'],2)."</td></tr>
								<tr><td>RIZAL</td><td>".number_format($r_x['jo_amount_jun_rzl'],2)."</td></tr>
								<tr class='w3-large w3-text-red'><td>TOTAL</td><td>".number_format($r_x['jo_amount_jun'],2)."</td></tr>
						</table>		
					</td>
	  </tr>";
	  
	  echo "<tr><td>JULY</td>
	  <td>
		  <table class='table w3-small' border='1'>
				  <tr><td>MAIN</td><td>".$r_x['jo_count_jul_main']."</td></tr>
				  <tr><td>SM</td><td>".$r_x['jo_count_jul_sm']."</td></tr>
				  <tr><td>SP</td><td>".$r_x['jo_count_jul_sp']."</td></tr>
				  <tr><td>SJ</td><td>".$r_x['jo_count_jul_sj']."</td></tr>
				  <tr><td>RIZAL</td><td>".$r_x['jo_count_jul_rzl']."</td></tr>
				  <tr class='w3-large w3-text-indigo'><td>TOTAL</td><td>".$r_x['jo_count_jul']."</td></tr>
		  </table> 
	  </td>
	  <td>
		  <table class='table w3-small' border='1'>
				  <tr><td>MAIN</td><td>".number_format($r_x['jo_amount_jul_main'],2)."</td></tr>
				  <tr><td>SM</td><td>".number_format($r_x['jo_amount_jul_sm'],2)."</td></tr>
				  <tr><td>SP</td><td>".number_format($r_x['jo_amount_jul_sp'],2)."</td></tr>
				  <tr><td>SJ</td><td>".number_format($r_x['jo_amount_jul_sj'],2)."</td></tr>
				  <tr><td>RIZAL</td><td>".number_format($r_x['jo_amount_jul_rzl'],2)."</td></tr>
				  <tr class='w3-large w3-text-red'><td>TOTAL</td><td>".number_format($r_x['jo_amount_jul'],2)."</td></tr>
		  </table>		
	  </td>
</tr>";


echo "<tr><td>AUGUST</td>
	  <td>
		  <table class='table w3-small' border='1'>
				  <tr><td>MAIN</td><td>".$r_x['jo_count_aug_main']."</td></tr>
				  <tr><td>SM</td><td>".$r_x['jo_count_aug_sm']."</td></tr>
				  <tr><td>SP</td><td>".$r_x['jo_count_aug_sp']."</td></tr>
				  <tr><td>SJ</td><td>".$r_x['jo_count_aug_sj']."</td></tr>
				  <tr><td>RIZAL</td><td>".$r_x['jo_count_aug_rzl']."</td></tr>
				  <tr class='w3-large w3-text-indigo'><td>TOTAL</td><td>".$r_x['jo_count_aug']."</td></tr>
		  </table> 
	  </td>
	  <td>
		  <table class='table w3-small' border='1'>
				  <tr><td>MAIN</td><td>".number_format($r_x['jo_amount_aug_main'],2)."</td></tr>
				  <tr><td>SM</td><td>".number_format($r_x['jo_amount_aug_sm'],2)."</td></tr>
				  <tr><td>SP</td><td>".number_format($r_x['jo_amount_aug_sp'],2)."</td></tr>
				  <tr><td>SJ</td><td>".number_format($r_x['jo_amount_aug_sj'],2)."</td></tr>
				  <tr><td>RIZAL</td><td>".number_format($r_x['jo_amount_aug_rzl'],2)."</td></tr>
				  <tr class='w3-large w3-text-red'><td>TOTAL</td><td>".number_format($r_x['jo_amount_aug'],2)."</td></tr>
		  </table>		
	  </td>
</tr>";

echo "<tr><td>SEPTEMBER</td>
	  <td>
		  <table class='table w3-small' border='1'>
				  <tr><td>MAIN</td><td>".$r_x['jo_count_sep_main']."</td></tr>
				  <tr><td>SM</td><td>".$r_x['jo_count_sep_sm']."</td></tr>
				  <tr><td>SP</td><td>".$r_x['jo_count_sep_sp']."</td></tr>
				  <tr><td>SJ</td><td>".$r_x['jo_count_sep_sj']."</td></tr>
				  <tr><td>RIZAL</td><td>".$r_x['jo_count_sep_rzl']."</td></tr>
				  <tr class='w3-large w3-text-indigo'><td>TOTAL</td><td>".$r_x['jo_count_sep']."</td></tr>
		  </table> 
	  </td>
	  <td>
		  <table class='table w3-small' border='1'>
				  <tr><td>MAIN</td><td>".number_format($r_x['jo_amount_sep_main'],2)."</td></tr>
				  <tr><td>SM</td><td>".number_format($r_x['jo_amount_sep_sm'],2)."</td></tr>
				  <tr><td>SP</td><td>".number_format($r_x['jo_amount_sep_sp'],2)."</td></tr>
				  <tr><td>SJ</td><td>".number_format($r_x['jo_amount_sep_sj'],2)."</td></tr>
				  <tr><td>RIZAL</td><td>".number_format($r_x['jo_amount_sep_rzl'],2)."</td></tr>
				  <tr class='w3-large w3-text-red'><td>TOTAL</td><td>".number_format($r_x['jo_amount_sep'],2)."</td></tr>
		  </table>		
	  </td>
</tr>";

echo "<tr><td>OCTOBER</td>
	  <td>
		  <table class='table w3-small' border='1'>
				  <tr><td>MAIN</td><td>".$r_x['jo_count_oct_main']."</td></tr>
				  <tr><td>SM</td><td>".$r_x['jo_count_oct_sm']."</td></tr>
				  <tr><td>SP</td><td>".$r_x['jo_count_oct_sp']."</td></tr>
				  <tr><td>SJ</td><td>".$r_x['jo_count_oct_sj']."</td></tr>
				  <tr><td>RIZAL</td><td>".$r_x['jo_count_oct_rzl']."</td></tr>
				  <tr class='w3-large w3-text-indigo'><td>TOTAL</td><td>".$r_x['jo_count_oct']."</td></tr>
		  </table> 
	  </td>
	  <td>
		  <table class='table w3-small' border='1'>
				  <tr><td>MAIN</td><td>".number_format($r_x['jo_amount_oct_main'],2)."</td></tr>
				  <tr><td>SM</td><td>".number_format($r_x['jo_amount_oct_sm'],2)."</td></tr>
				  <tr><td>SP</td><td>".number_format($r_x['jo_amount_oct_sp'],2)."</td></tr>
				  <tr><td>SJ</td><td>".number_format($r_x['jo_amount_oct_sj'],2)."</td></tr>
				  <tr><td>RIZAL</td><td>".number_format($r_x['jo_amount_oct_rzl'],2)."</td></tr>
				  <tr class='w3-large w3-text-red'><td>TOTAL</td><td>".number_format($r_x['jo_amount_oct'],2)."</td></tr>
		  </table>		
	  </td>
</tr>";

echo "<tr><td>NOVEMBER</td>
	  <td>
		  <table class='table w3-small' border='1'>
				  <tr><td>MAIN</td><td>".$r_x['jo_count_nov_main']."</td></tr>
				  <tr><td>SM</td><td>".$r_x['jo_count_nov_sm']."</td></tr>
				  <tr><td>SP</td><td>".$r_x['jo_count_nov_sp']."</td></tr>
				  <tr><td>SJ</td><td>".$r_x['jo_count_nov_sj']."</td></tr>
				  <tr><td>RIZAL</td><td>".$r_x['jo_count_nov_rzl']."</td></tr>
				  <tr class='w3-large w3-text-indigo'><td>TOTAL</td><td>".$r_x['jo_count_nov']."</td></tr>
		  </table> 
	  </td>
	  <td>
		  <table class='table w3-small' border='1'>
				  <tr><td>MAIN</td><td>".number_format($r_x['jo_amount_nov_main'],2)."</td></tr>
				  <tr><td>SM</td><td>".number_format($r_x['jo_amount_nov_sm'],2)."</td></tr>
				  <tr><td>SP</td><td>".number_format($r_x['jo_amount_nov_sp'],2)."</td></tr>
				  <tr><td>SJ</td><td>".number_format($r_x['jo_amount_nov_sj'],2)."</td></tr>
				  <tr><td>RIZAL</td><td>".number_format($r_x['jo_amount_nov_rzl'],2)."</td></tr>
				  <tr class='w3-large w3-text-red'><td>TOTAL</td><td>".number_format($r_x['jo_amount_nov'],2)."</td></tr>
		  </table>		
	  </td>
</tr>";

echo "<tr><td>DECEMBER</td>
	  <td>
		  <table class='table w3-small' border='1'>
				  <tr><td>MAIN</td><td>".$r_x['jo_count_dec_main']."</td></tr>
				  <tr><td>SM</td><td>".$r_x['jo_count_dec_sm']."</td></tr>
				  <tr><td>SP</td><td>".$r_x['jo_count_dec_sp']."</td></tr>
				  <tr><td>SJ</td><td>".$r_x['jo_count_dec_sj']."</td></tr>
				  <tr><td>RIZAL</td><td>".$r_x['jo_count_dec_rzl']."</td></tr>
				  <tr class='w3-large w3-text-indigo'><td>TOTAL</td><td>".$r_x['jo_count_dec']."</td></tr>
		  </table> 
	  </td>
	  <td>
		  <table class='table w3-small' border='1'>
				  <tr><td>MAIN</td><td>".number_format($r_x['jo_amount_dec_main'],2)."</td></tr>
				  <tr><td>SM</td><td>".number_format($r_x['jo_amount_dec_sm'],2)."</td></tr>
				  <tr><td>SP</td><td>".number_format($r_x['jo_amount_dec_sp'],2)."</td></tr>
				  <tr><td>SJ</td><td>".number_format($r_x['jo_amount_dec_sj'],2)."</td></tr>
				  <tr><td>RIZAL</td><td>".number_format($r_x['jo_amount_dec_rzl'],2)."</td></tr>
				  <tr class='w3-large w3-text-red'><td>TOTAL</td><td>".number_format($r_x['jo_amount_dec'],2)."</td></tr>
		  </table>		
	  </td>
</tr>";


echo "</table>
</div>";

}
?>