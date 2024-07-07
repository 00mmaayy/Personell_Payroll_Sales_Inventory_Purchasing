<?php 
session_start();
include('connection/conn.php');
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); } ?>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/bootstrap.min.css">

<style>
@page { size 8.5in 11in; margin: 2cm }
div.page { page-break-after: always }
.w3-tiny{font-size:10px!important}
.w3-small{font-size:12px!important}
.w3-hover-pale-red:hover{color:#000!important;background-color:#ffdddd!important}
</style>

<?php
$s="select * from company";
$q=mysql_query($s) or die(mysql_error());
$r=mysql_fetch_assoc($q);


echo "<div align='center'>ALC Group of Companies Schedule of Taxes withheld on Compensation<br/>";


//REVIEW PROCESS TO FINALIZE PAYROLL AREA Total Start Only -----------------------
if(isset($_REQUEST['review_final']))
{   
    echo $_REQUEST['payroll_period'];
	$payroll_period=$_REQUEST['payroll_period'];
}




//REPORTS ONLY SUMMARY ONLY------------------
else
{
	echo $_REQUEST['sdate']." &nbsp; ".$_REQUEST['edate'];
	$sdate=$_REQUEST['sdate'];
    $edate=$_REQUEST['edate'];
	
	$s1="SELECT
			( SELECT SUM(e_total_cuttoff_hours_final + e_overtime_final + e_restday_pay_final + e_restday_pay_overtime_final + e_nightshift_final + e_overtime_nightshift_final + e_regular_holiday_final + e_regular_holiday_overtime_final + e_special_holiday_final + e_special_holiday_overtime_final + e_sick_leave_final + e_vacation_leave_final + e_solo_parent_leave_final + e_allowance15 + e_allowance30 + e_add_allowance - e_lates_final - e_absences_final - e_undertime_final) FROM payroll WHERE payroll_period>='$sdate' AND payroll_period<='$edate' AND e_company='ALC') as alc_gross,
			( SELECT SUM(e_total_cuttoff_hours_final + e_overtime_final + e_restday_pay_final + e_restday_pay_overtime_final + e_nightshift_final + e_overtime_nightshift_final + e_regular_holiday_final + e_regular_holiday_overtime_final + e_special_holiday_final + e_special_holiday_overtime_final + e_sick_leave_final + e_vacation_leave_final + e_solo_parent_leave_final + e_allowance15 + e_allowance30 + e_add_allowance - e_lates_final - e_absences_final - e_undertime_final) FROM payroll WHERE payroll_period>='$sdate' AND payroll_period<='$edate' AND e_company='ALC' AND e_department LIKE '%SM%') as sm_gross,
			( SELECT SUM(e_total_cuttoff_hours_final + e_overtime_final + e_restday_pay_final + e_restday_pay_overtime_final + e_nightshift_final + e_overtime_nightshift_final + e_regular_holiday_final + e_regular_holiday_overtime_final + e_special_holiday_final + e_special_holiday_overtime_final + e_sick_leave_final + e_vacation_leave_final + e_solo_parent_leave_final + e_allowance15 + e_allowance30 + e_add_allowance - e_lates_final - e_absences_final - e_undertime_final) FROM payroll WHERE payroll_period>='$sdate' AND payroll_period<='$edate' AND e_company='ALC' AND e_department LIKE '%RIZAL%') as rzl_gross,
			( SELECT SUM(e_total_cuttoff_hours_final + e_overtime_final + e_restday_pay_final + e_restday_pay_overtime_final + e_nightshift_final + e_overtime_nightshift_final + e_regular_holiday_final + e_regular_holiday_overtime_final + e_special_holiday_final + e_special_holiday_overtime_final + e_sick_leave_final + e_vacation_leave_final + e_solo_parent_leave_final + e_allowance15 + e_allowance30 + e_add_allowance - e_lates_final - e_absences_final - e_undertime_final) FROM payroll WHERE payroll_period>='$sdate' AND payroll_period<='$edate' AND e_company='ALC' AND e_department LIKE '%SANPEDRO%') as sp_gross,
			( SELECT SUM(e_total_cuttoff_hours_final + e_overtime_final + e_restday_pay_final + e_restday_pay_overtime_final + e_nightshift_final + e_overtime_nightshift_final + e_regular_holiday_final + e_regular_holiday_overtime_final + e_special_holiday_final + e_special_holiday_overtime_final + e_sick_leave_final + e_vacation_leave_final + e_solo_parent_leave_final + e_allowance15 + e_allowance30 + e_add_allowance - e_lates_final - e_absences_final - e_undertime_final) FROM payroll WHERE payroll_period>='$sdate' AND payroll_period<='$edate' AND e_company='ALC' AND e_department LIKE '%SANJOSE%') as sj_gross,
			( SELECT SUM(e_total_cuttoff_hours_final + e_overtime_final + e_restday_pay_final + e_restday_pay_overtime_final + e_nightshift_final + e_overtime_nightshift_final + e_regular_holiday_final + e_regular_holiday_overtime_final + e_special_holiday_final + e_special_holiday_overtime_final + e_sick_leave_final + e_vacation_leave_final + e_solo_parent_leave_final + e_allowance15 + e_allowance30 + e_add_allowance - e_lates_final - e_absences_final - e_undertime_final) FROM payroll WHERE payroll_period>='$sdate' AND payroll_period<='$edate' AND e_company='CBI') as cbi_gross,
			( SELECT SUM(e_total_cuttoff_hours_final + e_overtime_final + e_restday_pay_final + e_restday_pay_overtime_final + e_nightshift_final + e_overtime_nightshift_final + e_regular_holiday_final + e_regular_holiday_overtime_final + e_special_holiday_final + e_special_holiday_overtime_final + e_sick_leave_final + e_vacation_leave_final + e_solo_parent_leave_final + e_allowance15 + e_allowance30 + e_add_allowance - e_lates_final - e_absences_final - e_undertime_final) FROM payroll WHERE payroll_period>='$sdate' AND payroll_period<='$edate' AND e_company='KAT') as kat_gross,
			( SELECT SUM(e_total_cuttoff_hours_final + e_overtime_final + e_restday_pay_final + e_restday_pay_overtime_final + e_nightshift_final + e_overtime_nightshift_final + e_regular_holiday_final + e_regular_holiday_overtime_final + e_special_holiday_final + e_special_holiday_overtime_final + e_sick_leave_final + e_vacation_leave_final + e_solo_parent_leave_final + e_allowance15 + e_allowance30 + e_add_allowance - e_lates_final - e_absences_final - e_undertime_final) FROM payroll WHERE payroll_period>='$sdate' AND payroll_period<='$edate' AND e_company='KAL') as kal_gross,
			( SELECT SUM(e_total_cuttoff_hours_final + e_overtime_final + e_restday_pay_final + e_restday_pay_overtime_final + e_nightshift_final + e_overtime_nightshift_final + e_regular_holiday_final + e_regular_holiday_overtime_final + e_special_holiday_final + e_special_holiday_overtime_final + e_sick_leave_final + e_vacation_leave_final + e_solo_parent_leave_final + e_allowance15 + e_allowance30 + e_add_allowance - e_lates_final - e_absences_final - e_undertime_final) FROM payroll WHERE payroll_period>='$sdate' AND payroll_period<='$edate' AND e_company='LH') as lh_gross,
			
			
			( SELECT SUM(e_total_cuttoff_hours_final + e_overtime_final + e_restday_pay_final + e_restday_pay_overtime_final + e_nightshift_final + e_overtime_nightshift_final + e_regular_holiday_final + e_regular_holiday_overtime_final + e_special_holiday_final + e_special_holiday_overtime_final + e_sick_leave_final + e_vacation_leave_final + e_solo_parent_leave_final + e_allowance15 + e_allowance30 + e_add_allowance - e_lates_final - e_absences_final - e_undertime_final) FROM payroll WHERE payroll_period>='$sdate' AND payroll_period<='$edate' AND e_company='ALC' AND e_basic_pay=320) as alc_mwe,
			( SELECT SUM(e_total_cuttoff_hours_final + e_overtime_final + e_restday_pay_final + e_restday_pay_overtime_final + e_nightshift_final + e_overtime_nightshift_final + e_regular_holiday_final + e_regular_holiday_overtime_final + e_special_holiday_final + e_special_holiday_overtime_final + e_sick_leave_final + e_vacation_leave_final + e_solo_parent_leave_final + e_allowance15 + e_allowance30 + e_add_allowance - e_lates_final - e_absences_final - e_undertime_final) FROM payroll WHERE payroll_period>='$sdate' AND payroll_period<='$edate' AND e_company='ALC' AND e_department LIKE '%SM%' AND e_basic_pay=320) as sm_mwe,
			( SELECT SUM(e_total_cuttoff_hours_final + e_overtime_final + e_restday_pay_final + e_restday_pay_overtime_final + e_nightshift_final + e_overtime_nightshift_final + e_regular_holiday_final + e_regular_holiday_overtime_final + e_special_holiday_final + e_special_holiday_overtime_final + e_sick_leave_final + e_vacation_leave_final + e_solo_parent_leave_final + e_allowance15 + e_allowance30 + e_add_allowance - e_lates_final - e_absences_final - e_undertime_final) FROM payroll WHERE payroll_period>='$sdate' AND payroll_period<='$edate' AND e_company='ALC' AND e_department LIKE '%RIZAL%' AND e_basic_pay=320) as rzl_mwe,
			( SELECT SUM(e_total_cuttoff_hours_final + e_overtime_final + e_restday_pay_final + e_restday_pay_overtime_final + e_nightshift_final + e_overtime_nightshift_final + e_regular_holiday_final + e_regular_holiday_overtime_final + e_special_holiday_final + e_special_holiday_overtime_final + e_sick_leave_final + e_vacation_leave_final + e_solo_parent_leave_final + e_allowance15 + e_allowance30 + e_add_allowance - e_lates_final - e_absences_final - e_undertime_final) FROM payroll WHERE payroll_period>='$sdate' AND payroll_period<='$edate' AND e_company='ALC' AND e_department LIKE '%SANPEDRO%' AND e_basic_pay=320) as sp_mwe,
			( SELECT SUM(e_total_cuttoff_hours_final + e_overtime_final + e_restday_pay_final + e_restday_pay_overtime_final + e_nightshift_final + e_overtime_nightshift_final + e_regular_holiday_final + e_regular_holiday_overtime_final + e_special_holiday_final + e_special_holiday_overtime_final + e_sick_leave_final + e_vacation_leave_final + e_solo_parent_leave_final + e_allowance15 + e_allowance30 + e_add_allowance - e_lates_final - e_absences_final - e_undertime_final) FROM payroll WHERE payroll_period>='$sdate' AND payroll_period<='$edate' AND e_company='ALC' AND e_department LIKE '%SANJOSE%' AND e_basic_pay=320) as sj_mwe,
			( SELECT SUM(e_total_cuttoff_hours_final + e_overtime_final + e_restday_pay_final + e_restday_pay_overtime_final + e_nightshift_final + e_overtime_nightshift_final + e_regular_holiday_final + e_regular_holiday_overtime_final + e_special_holiday_final + e_special_holiday_overtime_final + e_sick_leave_final + e_vacation_leave_final + e_solo_parent_leave_final + e_allowance15 + e_allowance30 + e_add_allowance - e_lates_final - e_absences_final - e_undertime_final) FROM payroll WHERE payroll_period>='$sdate' AND payroll_period<='$edate' AND e_company='CBI' AND e_basic_pay=320) as cbi_mwe,
			( SELECT SUM(e_total_cuttoff_hours_final + e_overtime_final + e_restday_pay_final + e_restday_pay_overtime_final + e_nightshift_final + e_overtime_nightshift_final + e_regular_holiday_final + e_regular_holiday_overtime_final + e_special_holiday_final + e_special_holiday_overtime_final + e_sick_leave_final + e_vacation_leave_final + e_solo_parent_leave_final + e_allowance15 + e_allowance30 + e_add_allowance - e_lates_final - e_absences_final - e_undertime_final) FROM payroll WHERE payroll_period>='$sdate' AND payroll_period<='$edate' AND e_company='KAT' AND e_basic_pay=320) as kat_mwe,
			( SELECT SUM(e_total_cuttoff_hours_final + e_overtime_final + e_restday_pay_final + e_restday_pay_overtime_final + e_nightshift_final + e_overtime_nightshift_final + e_regular_holiday_final + e_regular_holiday_overtime_final + e_special_holiday_final + e_special_holiday_overtime_final + e_sick_leave_final + e_vacation_leave_final + e_solo_parent_leave_final + e_allowance15 + e_allowance30 + e_add_allowance - e_lates_final - e_absences_final - e_undertime_final) FROM payroll WHERE payroll_period>='$sdate' AND payroll_period<='$edate' AND e_company='KAL' AND e_basic_pay=320) as kal_mwe,
			( SELECT SUM(e_total_cuttoff_hours_final + e_overtime_final + e_restday_pay_final + e_restday_pay_overtime_final + e_nightshift_final + e_overtime_nightshift_final + e_regular_holiday_final + e_regular_holiday_overtime_final + e_special_holiday_final + e_special_holiday_overtime_final + e_sick_leave_final + e_vacation_leave_final + e_solo_parent_leave_final + e_allowance15 + e_allowance30 + e_add_allowance - e_lates_final - e_absences_final - e_undertime_final) FROM payroll WHERE payroll_period>='$sdate' AND payroll_period<='$edate' AND e_company='LH' AND e_basic_pay=320) as lh_mwe,
			
			
			( SELECT SUM(e_overtime_final + e_restday_pay_final + e_restday_pay_overtime_final + e_nightshift_final + e_overtime_nightshift_final + e_regular_holiday_final + e_regular_holiday_overtime_final +e_special_holiday_final + e_special_holiday_overtime_final + e_sick_leave_final + e_vacation_leave_final + e_solo_parent_leave_final + e_allowance15 + e_allowance30 + e_add_allowance) FROM payroll WHERE payroll_period>='$sdate' AND payroll_period<='$edate' AND e_company='ALC' AND e_basic_pay=320) as alc_ot,
			( SELECT SUM(e_overtime_final + e_restday_pay_final + e_restday_pay_overtime_final + e_nightshift_final + e_overtime_nightshift_final + e_regular_holiday_final + e_regular_holiday_overtime_final +e_special_holiday_final + e_special_holiday_overtime_final + e_sick_leave_final + e_vacation_leave_final + e_solo_parent_leave_final + e_allowance15 + e_allowance30 + e_add_allowance) FROM payroll WHERE payroll_period>='$sdate' AND payroll_period<='$edate' AND e_company='ALC' AND e_department LIKE '%SM%' AND e_basic_pay=320) as sm_ot,
			( SELECT SUM(e_overtime_final + e_restday_pay_final + e_restday_pay_overtime_final + e_nightshift_final + e_overtime_nightshift_final + e_regular_holiday_final + e_regular_holiday_overtime_final +e_special_holiday_final + e_special_holiday_overtime_final + e_sick_leave_final + e_vacation_leave_final + e_solo_parent_leave_final + e_allowance15 + e_allowance30 + e_add_allowance) FROM payroll WHERE payroll_period>='$sdate' AND payroll_period<='$edate' AND e_company='ALC' AND e_department LIKE '%RIZAL%' AND e_basic_pay=320) as rzl_ot,
			( SELECT SUM(e_overtime_final + e_restday_pay_final + e_restday_pay_overtime_final + e_nightshift_final + e_overtime_nightshift_final + e_regular_holiday_final + e_regular_holiday_overtime_final +e_special_holiday_final + e_special_holiday_overtime_final + e_sick_leave_final + e_vacation_leave_final + e_solo_parent_leave_final + e_allowance15 + e_allowance30 + e_add_allowance) FROM payroll WHERE payroll_period>='$sdate' AND payroll_period<='$edate' AND e_company='ALC' AND e_department LIKE '%SANPEDRO%' AND e_basic_pay=320) as sp_ot,
			( SELECT SUM(e_overtime_final + e_restday_pay_final + e_restday_pay_overtime_final + e_nightshift_final + e_overtime_nightshift_final + e_regular_holiday_final + e_regular_holiday_overtime_final +e_special_holiday_final + e_special_holiday_overtime_final + e_sick_leave_final + e_vacation_leave_final + e_solo_parent_leave_final + e_allowance15 + e_allowance30 + e_add_allowance) FROM payroll WHERE payroll_period>='$sdate' AND payroll_period<='$edate' AND e_company='ALC' AND e_department LIKE '%SANJOSE%' AND e_basic_pay=320) as sj_ot,
			( SELECT SUM(e_overtime_final + e_restday_pay_final + e_restday_pay_overtime_final + e_nightshift_final + e_overtime_nightshift_final + e_regular_holiday_final + e_regular_holiday_overtime_final +e_special_holiday_final + e_special_holiday_overtime_final + e_sick_leave_final + e_vacation_leave_final + e_solo_parent_leave_final + e_allowance15 + e_allowance30 + e_add_allowance) FROM payroll WHERE payroll_period>='$sdate' AND payroll_period<='$edate' AND e_company='CBI' AND e_basic_pay=320) as cbi_ot,
			( SELECT SUM(e_overtime_final + e_restday_pay_final + e_restday_pay_overtime_final + e_nightshift_final + e_overtime_nightshift_final + e_regular_holiday_final + e_regular_holiday_overtime_final +e_special_holiday_final + e_special_holiday_overtime_final + e_sick_leave_final + e_vacation_leave_final + e_solo_parent_leave_final + e_allowance15 + e_allowance30 + e_add_allowance) FROM payroll WHERE payroll_period>='$sdate' AND payroll_period<='$edate' AND e_company='KAT' AND e_basic_pay=320) as kat_ot,
			( SELECT SUM(e_overtime_final + e_restday_pay_final + e_restday_pay_overtime_final + e_nightshift_final + e_overtime_nightshift_final + e_regular_holiday_final + e_regular_holiday_overtime_final +e_special_holiday_final + e_special_holiday_overtime_final + e_sick_leave_final + e_vacation_leave_final + e_solo_parent_leave_final + e_allowance15 + e_allowance30 + e_add_allowance) FROM payroll WHERE payroll_period>='$sdate' AND payroll_period<='$edate' AND e_company='KAL' AND e_basic_pay=320) as kal_ot,
			( SELECT SUM(e_overtime_final + e_restday_pay_final + e_restday_pay_overtime_final + e_nightshift_final + e_overtime_nightshift_final + e_regular_holiday_final + e_regular_holiday_overtime_final +e_special_holiday_final + e_special_holiday_overtime_final + e_sick_leave_final + e_vacation_leave_final + e_solo_parent_leave_final + e_allowance15 + e_allowance30 + e_add_allowance) FROM payroll WHERE payroll_period>='$sdate' AND payroll_period<='$edate' AND e_company='LH' AND e_basic_pay=320) as lh_ot,			
			
			
			( SELECT SUM(e_total_cuttoff_hours_final + e_overtime_final + e_restday_pay_final + e_restday_pay_overtime_final + e_nightshift_final + e_overtime_nightshift_final + e_regular_holiday_final + e_regular_holiday_overtime_final + e_special_holiday_final + e_special_holiday_overtime_final + e_sick_leave_final + e_vacation_leave_final + e_solo_parent_leave_final + e_allowance15 + e_allowance30 + e_add_allowance - e_lates_final - e_absences_final - e_undertime_final) FROM payroll WHERE payroll_period>='$sdate' AND payroll_period<='$edate' AND e_company='ALC' AND e_total_cuttoff_hours_final>10000 ) as alc_taxable,
			( SELECT SUM(e_total_cuttoff_hours_final + e_overtime_final + e_restday_pay_final + e_restday_pay_overtime_final + e_nightshift_final + e_overtime_nightshift_final + e_regular_holiday_final + e_regular_holiday_overtime_final + e_special_holiday_final + e_special_holiday_overtime_final + e_sick_leave_final + e_vacation_leave_final + e_solo_parent_leave_final + e_allowance15 + e_allowance30 + e_add_allowance - e_lates_final - e_absences_final - e_undertime_final) FROM payroll WHERE payroll_period>='$sdate' AND payroll_period<='$edate' AND e_company='ALC' AND e_department LIKE '%SM%' AND e_total_cuttoff_hours_final>10000) as sm_taxable,
			( SELECT SUM(e_total_cuttoff_hours_final + e_overtime_final + e_restday_pay_final + e_restday_pay_overtime_final + e_nightshift_final + e_overtime_nightshift_final + e_regular_holiday_final + e_regular_holiday_overtime_final + e_special_holiday_final + e_special_holiday_overtime_final + e_sick_leave_final + e_vacation_leave_final + e_solo_parent_leave_final + e_allowance15 + e_allowance30 + e_add_allowance - e_lates_final - e_absences_final - e_undertime_final) FROM payroll WHERE payroll_period>='$sdate' AND payroll_period<='$edate' AND e_company='ALC' AND e_department LIKE '%RIZAL%' AND e_total_cuttoff_hours_final>10000) as rzl_taxable,
			( SELECT SUM(e_total_cuttoff_hours_final + e_overtime_final + e_restday_pay_final + e_restday_pay_overtime_final + e_nightshift_final + e_overtime_nightshift_final + e_regular_holiday_final + e_regular_holiday_overtime_final + e_special_holiday_final + e_special_holiday_overtime_final + e_sick_leave_final + e_vacation_leave_final + e_solo_parent_leave_final + e_allowance15 + e_allowance30 + e_add_allowance - e_lates_final - e_absences_final - e_undertime_final) FROM payroll WHERE payroll_period>='$sdate' AND payroll_period<='$edate' AND e_company='ALC' AND e_department LIKE '%SANPEDRO%' AND e_total_cuttoff_hours_final>10000) as sp_taxable,
			( SELECT SUM(e_total_cuttoff_hours_final + e_overtime_final + e_restday_pay_final + e_restday_pay_overtime_final + e_nightshift_final + e_overtime_nightshift_final + e_regular_holiday_final + e_regular_holiday_overtime_final + e_special_holiday_final + e_special_holiday_overtime_final + e_sick_leave_final + e_vacation_leave_final + e_solo_parent_leave_final + e_allowance15 + e_allowance30 + e_add_allowance - e_lates_final - e_absences_final - e_undertime_final) FROM payroll WHERE payroll_period>='$sdate' AND payroll_period<='$edate' AND e_company='ALC' AND e_department LIKE '%SANJOSE%' AND e_total_cuttoff_hours_final>10000) as sj_taxable,
			( SELECT SUM(e_total_cuttoff_hours_final + e_overtime_final + e_restday_pay_final + e_restday_pay_overtime_final + e_nightshift_final + e_overtime_nightshift_final + e_regular_holiday_final + e_regular_holiday_overtime_final + e_special_holiday_final + e_special_holiday_overtime_final + e_sick_leave_final + e_vacation_leave_final + e_solo_parent_leave_final + e_allowance15 + e_allowance30 + e_add_allowance - e_lates_final - e_absences_final - e_undertime_final) FROM payroll WHERE payroll_period>='$sdate' AND payroll_period<='$edate' AND e_company='CBI' AND e_total_cuttoff_hours_final>10000) as cbi_taxable,
			( SELECT SUM(e_total_cuttoff_hours_final + e_overtime_final + e_restday_pay_final + e_restday_pay_overtime_final + e_nightshift_final + e_overtime_nightshift_final + e_regular_holiday_final + e_regular_holiday_overtime_final + e_special_holiday_final + e_special_holiday_overtime_final + e_sick_leave_final + e_vacation_leave_final + e_solo_parent_leave_final + e_allowance15 + e_allowance30 + e_add_allowance - e_lates_final - e_absences_final - e_undertime_final) FROM payroll WHERE payroll_period>='$sdate' AND payroll_period<='$edate' AND e_company='KAT' AND e_total_cuttoff_hours_final>10000) as kat_taxable,
			( SELECT SUM(e_total_cuttoff_hours_final + e_overtime_final + e_restday_pay_final + e_restday_pay_overtime_final + e_nightshift_final + e_overtime_nightshift_final + e_regular_holiday_final + e_regular_holiday_overtime_final + e_special_holiday_final + e_special_holiday_overtime_final + e_sick_leave_final + e_vacation_leave_final + e_solo_parent_leave_final + e_allowance15 + e_allowance30 + e_add_allowance - e_lates_final - e_absences_final - e_undertime_final) FROM payroll WHERE payroll_period>='$sdate' AND payroll_period<='$edate' AND e_company='KAL' AND e_total_cuttoff_hours_final>10000) as kal_taxable,
			( SELECT SUM(e_total_cuttoff_hours_final + e_overtime_final + e_restday_pay_final + e_restday_pay_overtime_final + e_nightshift_final + e_overtime_nightshift_final + e_regular_holiday_final + e_regular_holiday_overtime_final + e_special_holiday_final + e_special_holiday_overtime_final + e_sick_leave_final + e_vacation_leave_final + e_solo_parent_leave_final + e_allowance15 + e_allowance30 + e_add_allowance - e_lates_final - e_absences_final - e_undertime_final) FROM payroll WHERE payroll_period>='$sdate' AND payroll_period<='$edate' AND e_company='LH' AND e_total_cuttoff_hours_final>10000) as lh_taxable,
			
			
			( SELECT SUM(e_tax) FROM payroll WHERE payroll_period>='$sdate' AND payroll_period<='$edate' AND e_company='ALC' ) as alc_tax,
			( SELECT SUM(e_tax) FROM payroll WHERE payroll_period>='$sdate' AND payroll_period<='$edate' AND e_company='ALC' AND e_department LIKE '%SM%') as sm_tax,
			( SELECT SUM(e_tax) FROM payroll WHERE payroll_period>='$sdate' AND payroll_period<='$edate' AND e_company='ALC' AND e_department LIKE '%RIZAL%') as rzl_tax,
			( SELECT SUM(e_tax) FROM payroll WHERE payroll_period>='$sdate' AND payroll_period<='$edate' AND e_company='ALC' AND e_department LIKE '%SANPEDRO%') as sp_tax,
			( SELECT SUM(e_tax) FROM payroll WHERE payroll_period>='$sdate' AND payroll_period<='$edate' AND e_company='ALC' AND e_department LIKE '%SANJOSE%') as sj_tax,
			( SELECT SUM(e_tax) FROM payroll WHERE payroll_period>='$sdate' AND payroll_period<='$edate' AND e_company='CBI') as cbi_tax,
			( SELECT SUM(e_tax) FROM payroll WHERE payroll_period>='$sdate' AND payroll_period<='$edate' AND e_company='KAT') as kat_tax,
			( SELECT SUM(e_tax) FROM payroll WHERE payroll_period>='$sdate' AND payroll_period<='$edate' AND e_company='KAL') as kal_tax,
			( SELECT SUM(e_tax) FROM payroll WHERE payroll_period>='$sdate' AND payroll_period<='$edate' AND e_company='LH') as lh_tax
		";
}



	$q1=mysql_query($s1) or die(mysql_error());
	$r1=mysql_fetch_assoc($q1);

	$main_gross=$r1['alc_gross']-$r1['sm_gross']-$r1['sp_gross']-$r1['sj_gross']-$r1['rzl_gross'];
	$ot=$r1['alc_ot']-$r1['sm_ot']-$r1['sp_ot']-$r1['sj_ot']-$r1['rzl_ot'];
	$mwe=$r1['alc_mwe']-$r1['sm_mwe']-$r1['sp_mwe']-$r1['sj_mwe']-$r1['rzl_mwe'];
	
	$mwe_minus_ot=$mwe-$ot;
	
	
	$total=$main_gross-$ot-$mwe_minus_ot-$r1['alc_taxable'];
	
	//echo "<br/><br/>".$main_gross." - ".$ot." - ".$mwe_minus_ot." - ".$r1['alc_taxable']." = ".$total."<br/><br/>";
	
echo "<table border='1'>
		<tr align='center'><td colspan='2'></td><td colspan='4'>ALC</td><td colspan='4'>&nbsp;</td></tr>
		<tr align='center'><td colspan='2'></td><td>Main</td><td>San Pedro</td><td>San Jose</td><td>SM</td><td>LilyHill</td><td>Circon</td><td>Katrinka</td><td>Kalipayan</td></tr>
		<tr>
			<td colspan='2'>Total Amount of Compensation</td>
			<td>".number_format($main_gross,2)."</td>
			<td>".number_format($r1['sp_gross'],2)."</td>
			<td>".number_format($r1['sj_gross'],2)."</td>
			<td>".number_format($r1['sm_gross'],2)."</td>
			<td>".number_format($r1['rzl_gross'],2)."</td>
			<td>".number_format($r1['lh_gross'],2)."</td>
			<td>".number_format($r1['cbi_gross'],2)."</td>
			<td>".number_format($r1['kat_gross'],2)."</td>
			<td>".number_format($r1['kal_gross'],2)."</td>
		</tr>
		<tr>
			<td>Less:</td>
			<td>Non Taxable Compensation</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr align='right'>
			<td>&nbsp;</td>
			<td align='left'>Statutory Minimum Wage (MWEs)</td>
			<td>".number_format($mwe_minus_ot,2)."</td>
			<td>".number_format($r1['sp_mwe']-$r1['sp_ot'],2)."</td>
			<td>".number_format($r1['sj_mwe']-$r1['sj_ot'],2)."</td>
			<td>".number_format($r1['sm_mwe']-$r1['sm_ot'],2)."</td>
			<td>".number_format($r1['rzl_mwe']-$r1['rzl_ot'],2)."</td>
			<td>".number_format($r1['lh_mwe']-$r1['lh_ot'],2)."</td>
			<td>".number_format($r1['cbi_mwe']-$r1['cbi_ot'],2)."</td>
			<td>".number_format($r1['kat_mwe']-$r1['kat_ot'],2)."</td>
			<td>".number_format($r1['kal_mwe']-$r1['kal_ot'],2)."</td>
		</tr>
		<tr align='right'>
			<td>&nbsp;</td>
			<td align='left'>Holiday Pay, Overtime Pay, Night Shift Differential Pay,<br/>Hazard Pay (Minimm Wage Earner)</td>
			<td>".number_format($ot,2)."</td>
			<td>".number_format($r1['sp_ot'],2)."</td>
			<td>".number_format($r1['sj_ot'],2)."</td>
			<td>".number_format($r1['sm_ot'],2)."</td>
			<td>".number_format($r1['rzl_ot'],2)."</td>
			<td>".number_format($r1['lh_ot'],2)."</td>
			<td>".number_format($r1['cbi_ot'],2)."</td>
			<td>".number_format($r1['kat_ot'],2)."</td>
			<td>".number_format($r1['kal_ot'],2)."</td>
		</tr>
		<tr align='right'>
			<td>&nbsp;</td>
			<td align='left'>Other Non Taxable Compensation</td>
			<td>".number_format($total,2)."</td>
			<td>".number_format($r1['sp_gross']-$r1['sp_mwe']-$r1['sp_ot']+$r1['sp_ot'],2)."</td>
			<td>".number_format($r1['sj_gross']-$r1['sj_mwe']-$r1['sj_ot']+$r1['sj_ot'],2)."</td>
			<td>".number_format($r1['sm_gross']-$r1['sm_mwe']-$r1['sm_ot']+$r1['sm_ot'],2)."</td>
			<td>".number_format($r1['rzl_gross']-$r1['rzl_mwe']-$r1['rzl_ot']+$r1['rzl_ot'],2)."</td>
			<td>".number_format($r1['lh_gross']-$r1['lh_mwe']-$r1['lh_ot']+$r1['lh_ot'],2)."</td>
			<td>".number_format($r1['cbi_gross']-$r1['cbi_mwe']-$r1['cbi_ot']+$r1['cbi_ot'],2)."</td>
			<td>".number_format($r1['kat_gross']-$r1['kat_mwe']-$r1['kat_ot']+$r1['kat_ot'],2)."</td>
			<td>".number_format($r1['kal_gross']-$r1['kal_mwe']-$r1['kal_ot']+$r1['kal_ot'],2)."</td>
		</tr>
		<tr align='right'>
			<td colspan='2' align='left'>Taxable Compensation</td>
			<td>".number_format($r1['alc_taxable'],2)."</td>
			<td>".number_format($r1['sp_taxable'],2)."</td>
			<td>".number_format($r1['sj_taxable'],2)."</td>
			<td>".number_format($r1['sm_taxable'],2)."</td>
			<td>".number_format($r1['rzl_taxable'],2)."</td>
			<td>".number_format($r1['lh_taxable'],2)."</td>
			<td>".number_format($r1['cbi_taxable'],2)."</td>
			<td>".number_format($r1['kat_taxable'],2)."</td>
			<td>".number_format($r1['kal_taxable'],2)."</td>
		</tr>
		<tr align='right'>
			<td colspan='2' align='left'>Tax Due</td>
			<td>".number_format($r1['alc_tax'],2)."</td>
			<td>".number_format($r1['sp_tax'],2)."</td>
			<td>".number_format($r1['sj_tax'],2)."</td>
			<td>".number_format($r1['sm_tax'],2)."</td>
			<td>".number_format($r1['rzl_tax'],2)."</td>
			<td>".number_format($r1['lh_tax'],2)."</td>
			<td>".number_format($r1['cbi_tax'],2)."</td>
			<td>".number_format($r1['kat_tax'],2)."</td>
			<td>".number_format($r1['kal_tax'],2)."</td>
		</tr>
	 </table>";

?>
</div>