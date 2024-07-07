<!DOCTYPE html>
<?php
require 'connection/conn.php';
session_start();
$username = $_SESSION['username'];
$select_employee = mysql_query("SELECT * FROM employee WHERE e_employment_status != 'Resigned' 
    AND e_employment_status != 'NotConnected' AND e_employment_status !='Agency' ORDER BY e_lname ASC");


if (isset($_POST['add-leave'])) {

    //VARIABLES
    $leave_available = 0;
    $basic_pay = $_POST['emp-pay'];
    $e_no = $_POST['emp-no'];
    $name = $_POST['emp-nme'];
    $leave_type = $_POST['leave-type'];
    $pay_status = $_POST['pay-status'];
    $days_number = $_POST['days-number'];
    $leave_reason = $_POST['leave-reason'];
    $leave_start = $_POST['leave-start'];
    $leave_end = $_POST['leave-end'];
    $days_number_date = ((strtotime($leave_end) - strtotime($leave_start)) / 86400) + 1;
    $date_sunday = '';
    $r_vl = $_POST['rem-vl'];
    $r_sl = $_POST['rem-sl'];
    $r_spl = $_POST['rem-spl'];
    $r_mpl = $_POST['rem-mpl'];
    $date = '';
    $start = $leave_start;
    $count_days = 0;
    $sundays = 0;
    $cutoff = array();
    $leaves = array();
    $date_start = strtotime($leave_start);
    $date_end = strtotime($leave_end);
    $wopay_co = 0;
    $wpay_co = 0;
    $daily_rate = $basic_pay / 26;
    $hourly_rate = $daily_rate / 8;
    $days_number_temp = $days_number;
    $days_number_sec_temp = $days_number;

    //LEAVE REMAINING BASED ON LEAVE TYPE (VARIABLE)
    if ($pay_status == 'withpay') {
        switch ($leave_type) {
            case "Vacation Leave":
                $leave_remaining = $r_vl;
                break;
            case "Sick Leave":
                $leave_remaining = $r_sl;
                break;
            case "Solo Parent Leave":
                $leave_remaining = $r_spl;
                break;
            case "Paternity Leave":
                $leave_remaining = $r_mpl;
                break;
            default:
                $leave_remaining = 0;
                break;
        }
    } else {
        $leave_remaining = 0;
    }

    //SEPARATE LEAVE DATES WPAY AND WOPAY (VARIABLES)
    $count_rem = $leave_remaining;
    if (($days_number > $leave_remaining) && $pay_status == 'withpay') {
        while ($count_rem > 0) {
            if (date("D", strtotime($start)) == 'Sun') {
                $start = date('Y-m-d', strtotime($start . "+ 1 days"));
                $sundays = 1;
                continue;
            }
            $count_days++;
            $count_rem--;
            $start = date('Y-m-d', strtotime($start . "+ 1 days"));
        }

        if ($sundays == 0) {
            $count_days--;
        }
        $start = $leave_start;
        $date_wpay_end = date("Y-m-d", strtotime($start . "+ $count_days days"));
        if (date('D', strtotime($date_wpay_end . "+ 1 days")) == 'Sun') {
            $date_wopay_start = date("Y-m-d", strtotime($date_wpay_end . "+ 2 days"));
        } else {
            $date_wopay_start = date("Y-m-d", strtotime($date_wpay_end . "+ 1 days"));
        }

        //SEPARATE DAYS WPAY AND WOPAY (VARIABLES)        
        $wpay = $leave_remaining;
        $wopay = $days_number - $leave_remaining;
        $days_number = $wpay;
        $leave_date_start = $leave_start;
        $leave_date_end = $date_wpay_end;

        //INSERT ALL VARIABLES TO LEAVE TABLE
        for ($i = 0; $i < 2; $i++) {
            $insert_leave = mysql_query("INSERT INTO employee_leaves(e_no,type,days,remarks,sdate,edate,apply_date,pay_status) 
                                            VALUES('$e_no','$leave_type',$days_number,'$leave_reason','$leave_date_start','$leave_date_end',NOW(),'$pay_status')")
                or die(mysql_error());

            $days_number = $wopay;
            $leave_date_start = $date_wopay_start;
            $leave_date_end = $leave_end;
            $pay_status = 'nopay';
        }
    } else {
        $insert_leave = mysql_query("INSERT INTO employee_leaves(e_no,type,days,remarks,sdate,edate,apply_date,pay_status) 
                VALUES('$e_no','$leave_type',$days_number,'$leave_reason','$leave_start','$leave_end',NOW(),'$pay_status')")
            or die(mysql_error());
    }

    //PUSH ALL CUTOFF DATE IN AN ARRAY
    $start = $leave_start;
    while (strtotime($start) <= $date_end) {
        $year = date('Y', strtotime($start));
        $date = date('d', strtotime($start));
        $month = date('m', strtotime($start));

        if ($date >= 1 && $date <= 10) {
            $cutoff_date = "$year-$month-11";
        } elseif ($date >= 26 && $date <= 31) {
            $month += 1;
            if ($month < 10) {
                $month = "0" . $month;
            }
            if ($month > 12) {
                $month = 1;
                $year += 1;
            }
            $cutoff_date = "$year-$month-11";
        } elseif ($date >= 11 && $date <= 25) {
            $cutoff_date = "$year-$month-26";
        }
        if (!in_array($cutoff_date, $cutoff)) {
            array_push($cutoff, $cutoff_date);
        }
        $start = date('Y-m-d', strtotime($start . "+ 1 days"));
    }

    //GET NUMBER OF DAYS WITHIN EACH CUTOFF
    $start = $leave_start;
    while (strtotime($start) <= $date_end) {
        $year = date('Y', strtotime($start));
        $date = date('d', strtotime($start));
        $month = date('m', strtotime($start));
        if (date('D', strtotime($start)) != 'Sun') {
            if ($date >= 1 && $date <= 10) {
                $cutoff_date = "$year-$month-11";
                if (!array_key_exists($cutoff_date, $leaves)) {
                    $num_of_days = 0;
                }
                $num_of_days += 1;
                $leaves[$cutoff_date] = $num_of_days;
            } elseif ($date >= 26 && $date <= 31) {
                $month += 1;
                if ($month < 10) {
                    $month = "0" . $month;
                }
                if ($month > 12) {
                    $month = 1;
                    $year += 1;
                }
                $cutoff_date = "$year-$month-11";
                if (!array_key_exists($cutoff_date, $leaves)) {
                    $num_of_days = 0;
                }
                $num_of_days += 1;
                $leaves[$cutoff_date] = $num_of_days;
            } elseif ($date >= 11 && $date <= 25) {
                $cutoff_date = "$year-$month-26";
                if (!array_key_exists($cutoff_date, $leaves)) {
                    $num_of_days = 0;
                }
                $num_of_days += 1;
                $leaves[$cutoff_date] = $num_of_days;
            }
        }
        $start = date('Y-m-d', strtotime($start . "+ 1 days"));
    }

    //SEPARATING LEAVE DAYS WPAY AND WOPAY PER CUTOFF
    for ($i = 0; $i < count($cutoff); $i++) {
        $select_leave = mysql_query("SELECT * FROM employee_leaves_payroll WHERE cutoff_date = '$cutoff[$i]' AND e_no = '$e_no' AND leave_type = '$leave_type'");
        $result_leave = mysql_fetch_assoc($select_leave);

        if ($leave_remaining >= $days_number_sec_temp && $leaves[$cutoff[$i]] >= $days_number_sec_temp) {
            $wpay_co = $days_number_sec_temp;
            $leave_remaining -= $days_number_sec_temp;
        } elseif ($leave_remaining >= $days_number_sec_temp && $leaves[$cutoff[$i]] < $days_number_sec_temp) {
            $wpay_co = $leaves[$cutoff[$i]];
            $leave_remaining -= $leaves[$cutoff[$i]];
        } else {
            if ($leave_remaining > 0) {
                $wpay_co = $leave_remaining;
            } else {
                $wpay_co = 0;
            }
            $wopay_co = $days_number_sec_temp - $leave_remaining;
            $leave_remaining -= $leave_remaining;
        }


        if ($days_number_temp > $leaves[$cutoff[$i]]) {
            $days_absent = $leaves[$cutoff[$i]];
            $days_number_temp -= $leaves[$cutoff[$i]];
        } else {
            $days_absent = $days_number_temp;
        }
        $hours_absent = $days_absent * 8;
        $amount = $wpay_co * $daily_rate;
        $amount_absent = $days_absent * $daily_rate;

        $days_absent;
        if ($result_leave == NULL) {
            mysql_query("INSERT INTO employee_leaves_payroll(e_no,cutoff_date,days_wpay,days_wopay,days_absent,hours_absent,amount_paid,amount_absent,leave_type) 
                VALUES('$e_no','$cutoff[$i]',$wpay_co,$wopay_co,$days_absent,$hours_absent,$amount,$amount_absent,'$leave_type')") or die(mysql_error());
        } else {
            $add_wpay = $result_leave['days_wpay'];
            $add_wopay = $result_leave['days_wopay'];
            $add_absent = $result_leave['days_absent'];
            $add_hours_absent = $result_leave['hours_absent'];
            $add_amount_paid = $result_leave['amount_paid'];
            $add_amount_absent = $result_leave['amount_absent'];

            $updt_wpay = $wpay_co + $add_wpay;
            $updt_wopay = $wopay_co + $add_wopay;
            $updt_absent = $days_absent + $add_absent;
            $updt_hours_absent = $hours_absent + $add_hours_absent;
            $updt_amount_paid = $amount + $add_amount_paid;
            $updt_amount_absent = $amount_absent + $add_amount_absent;
            mysql_query("UPDATE employee_leaves_payroll SET days_wpay = $updt_wpay, days_wopay = $updt_wopay, days_absent = $updt_absent,
                                                    hours_absent = $updt_hours_absent, amount_paid = $updt_amount_paid, amount_absent = $updt_amount_absent 
                                                    WHERE cutoff_date = '$cutoff[$i]' AND e_no = '$e_no' AND leave_type = '$leave_type'") or die(mysql_error());
        }
    }

    header("location: script_leaves_batch_entry.php");
}
?>

    <html>

    <head>
        <link rel="stylesheet" type="text/css" href="css/leave_entry.css" />
    </head>

    <body>
        <table>
            <thead>
                <tr>
                    <th class="name-td">Name</th>
                    <th>Leave Type</th>
                    <th>Pay Status</th>
                    <th>Number of Days</th>
                    <th>Reason/Remarks</th>
                    <th>Leave Start</th>
                    <th>Leave End</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php while ($result_employee = mysql_fetch_assoc($select_employee)) :
                    $e_no = $result_employee['e_no'];
                    $fname = $result_employee['e_fname'];
                    $mname = $result_employee['e_mname'];
                    $lname = $result_employee['e_lname'];
                    $hired = $result_employee['e_entry_date'];
                    $gender = $result_employee['e_gender'];
                    $basic_pay = $result_employee['e_basic_pay'];
                    $year_start = date('Y') . '-01-01';
                    $year_end = date('Y') . '-12-31';

                    $hired_year = date('Y', strtotime($hired));
                    $number_year = ((int) date('Y')) - $hired_year;
                    if ($number_year > 4) {
                        $loyalty = floor($number_year / 5);
                    } else {
                        $loyalty = 0;
                    }

                    $date_hired = strtotime($hired);
                    $date_today = strtotime(date('Y-m-d'));
                    $total_year = ($date_today - $date_hired) / 31536000;
                    if ($total_year >= 1) {
                        $VL = 5 + $loyalty;
                        $SL = 5;
                        $SPL = 7;
                    } else {
                        $VL = 0;
                        $SL = 0;
                        $SPL = 0;
                    }


                    $select_vl = mysql_query("SELECT sum(days) AS vl_total FROM employee_leaves WHERE e_no='$e_no' AND type='Vacation Leave' AND pay_status='withpay' AND sdate>='$year_start' AND sdate<='$year_end'");
                    $result_vl = mysql_fetch_assoc($select_vl);
                    $select_sl = mysql_query("SELECT sum(days) AS sl_total FROM employee_leaves WHERE e_no='$e_no' AND type='Sick Leave' AND pay_status='withpay' AND sdate>='$year_start' AND sdate<='$year_end'");
                    $result_sl = mysql_fetch_assoc($select_sl);
                    $select_spl = mysql_query("SELECT sum(days) AS spl_total FROM employee_leaves WHERE e_no='$e_no' AND type='Solo Parent Leave' AND pay_status='withpay' AND sdate>='$year_start' AND sdate<='$year_end'");
                    $result_spl = mysql_fetch_assoc($select_spl);
                    if ($gender === 'Male') {
                        $select_mpl = mysql_query("SELECT sum(days) AS mpl_total FROM employee_leaves WHERE e_no='$e_no' AND type='Paternity Leave' AND pay_status='withpay' AND sdate>='$year_start' AND sdate<='$year_end'");
                        $result_mpl = mysql_fetch_assoc($select_mpl);
                    } elseif ($gender === 'Female') {
                        $select_mpl = mysql_query("SELECT sum(days) AS mpl_total FROM employee_leaves WHERE e_no='$e_no' AND type='Maternity Leave' AND pay_status='withpay' AND sdate>='$year_start' AND sdate<='$year_end'");
                        $result_mpl = mysql_fetch_assoc($select_mpl);
                    }

                    $vl_total = $result_vl['vl_total'];
                    $sl_total = $result_sl['sl_total'];
                    $spl_total = $result_spl['spl_total'];
                    $mpl_total = $result_mpl['mpl_total'];

                    ?>
                    <form method="POST" action=<?php echo $_SERVER['REQUEST_URI'] ?>>
                        <tr>
                            <td class="emp-name name-td">
                                <input type="hidden" value="<?php echo $basic_pay; ?>" name="emp-pay" />
                                <input type="hidden" value="<?php echo $e_no; ?>" name="emp-no" />
                                <input type="hidden" value="<?php echo "$lname, $fname $mname[0]."; ?>" name="emp-nme" />
                                <span class="name"><?php echo "$lname, $fname $mname[0]." ?></span><br />
                                <span>
                                    VL: <span class="leave"><?php echo  $rem_vl = $VL - $vl_total; ?></span> -
                                    SL: <span class="leave"><?php echo  $rem_sl = $SL - $sl_total; ?></span> -
                                    <?php if ($gender == 'Female') : ?>SPL: <span class="leave"><?php echo $rem_spl = $SPL - $spl_total; ?></span> -<?php endif; ?>
                                    <?php if ($gender == 'Male') {
                                            echo 'PL:   ';
                                            $MPL = 7;
                                        } else {
                                            echo 'ML:   ';
                                            $MPL = 60;
                                        }
                                        ?>
                                    <span class="leave"><?php echo $rem_mpl = $MPL - $mpl_total; ?></span>
                                </span>
                                <input type="hidden" name="rem-vl" value="<?php echo $rem_vl; ?>" />
                                <input type="hidden" name="rem-sl" value="<?php echo $rem_sl; ?>" />
                                <input type="hidden" name="rem-spl" value="<?php echo $rem_spl; ?>" />
                                <input type="hidden" name="rem-mpl" value="<?php echo $rem_mpl; ?>" />
                            <td>
                                <select required name="leave-type">
                                    <option selected disabled></option>
                                    <option value="Vacation Leave">Vacation Leave</option>
                                    <option value="Sick Leave">Sick Leave</option>
                                    <option value="Solo Parent Leave">Solo Parent Leave</option>
                                    <?php if ($gender == 'Male') : ?>
                                        <option value="Paternity Leave">Paternity Leave</option>
                                    <?php elseif ($gender == 'Female') : ?>
                                        <option value="Maternity Leave">Maternity Leave</option>
                                    <?php endif; ?>
                                    <option value="Emergency Leave">Emergency Leave</option>
                                    <option value="Others">Others</option>
                                </select>
                            </td>
                            <td>
                                <select required name="pay-status">
                                    <option selected disabled></option>
                                    <option value="withpay">With Pay</option>
                                    <option value="nopay">Without Pay</option>
                                </select>
                            </td>
                            <td>
                                <input required name="days-number" type="number" min="0.5" step="any" />
                            </td>
                            <td>
                                <input required type="text" name="leave-reason" />
                            </td>
                            <td>
                                <input required type="date" name="leave-start" />
                            </td>
                            <td>
                                <input required type="date" name="leave-end" />
                            </td>
                            <td>
                                <input name="add-leave" type="submit" value="Add" />
                            </td>
                        </tr>
                    </form>
                <?php endwhile; ?>
            </tbody>
        </table>
    </body>

    </html>
