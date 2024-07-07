<?php 
    include "connection/conn.php";
    $select_payroll_period = mysql_query( "SELECT payroll_period FROM `payroll` GROUP BY payroll_period ORDER BY `payroll_period`  DESC LIMIT 1");
    $result_payroll_period = mysql_fetch_assoc($select_payroll_period);

    $payroll_period = $result_payroll_period['payroll_period'];
    $period_date = date('d',strtotime($payroll_period));
    $period_month = date('m',strtotime($payroll_period));
    $period_year = date('Y',strtotime($payroll_period));

    
    if($period_date >= 1 && $period_date <= 15)
    {
        $cutoff_date = "$period_year-$period_month-11";
    } 
    elseif($period_date >= 16 && $period_date <= 31)
    {
        $cutoff_date = "$period_year-$period_month-26";
    }

    $select_leaves = mysql_query( "SELECT * FROM employee_leaves_payroll WHERE cutoff_date = '$cutoff_date'");


    while($result_leaves = mysql_fetch_assoc($select_leaves))
    {
        $e_no = $result_leaves['e_no'];
        $days_wpay = $result_leaves['days_wpay'];
        $hours_absent = $result_leaves['hours_absent'];
        $paid_amount = $result_leaves['amount_paid'];
        $absent_amount = $result_leaves['amount_absent'];
        $leave_type = $result_leaves['leave_type'];

        $select_absent = mysql_query("SELECT e_absences,e_absences_final FROM payroll WHERE payroll_period = '$payroll_period' AND e_no='$e_no'");
        $result_absent = mysql_fetch_assoc($select_absent);

        $final_absent_hours = $result_absent['e_absences'] + $hours_absent;
        $final_absent_amount = $result_absent['e_absences_final'] + $absent_amount;

        if($leave_type == "Vacation Leave" || $leave_type == "Paternity Leave")
        {
            $update_payroll = mysql_query( "UPDATE payroll SET e_vacation_leave = $days_wpay, e_vacation_leave_final = $paid_amount 
                                                            WHERE payroll_period = '$payroll_period' AND e_no = '$e_no'") or die(mysql_error());
        }
        elseif($leave_type == "Sick Leave")
        {
            $update_payroll = mysql_query( "UPDATE payroll SET e_sick_leave = $days_wpay, e_sick_leave_final = $paid_amount
                                                            WHERE payroll_period = '$payroll_period' AND e_no = '$e_no'") or die(mysql_error());
        }
        elseif($leave_type == "Solo Parent Leave")
        {
            $update_payroll = mysql_query( "UPDATE payroll SET e_solo_parent_leave = $days_wpay, e_solo_parent_leave_final = $paid_amount 
                                                            WHERE payroll_period = '$payroll_period' AND e_no = '$e_no'") or die(mysql_error());
        }

    }

     
    ?>