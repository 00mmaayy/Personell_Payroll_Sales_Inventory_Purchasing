<?php
include 'connection/conn.php';

$attendance_array = [];
$employee_rice_allowance = [];
$employee_with_rice = [];

$employee_adpls = [];
$employee_lyc = [];
$employee_mc = [];
$employee_hh = [];

$employee_alc = [];
$employee_lh = [];
$employee_kat = [];
$employee_kal = [];
$employee_cbi = [];

$daily = 0;
$hrs_total = 0;
$abs_total = 0;
$lte_total = 0;
$und_total = 0;
$att_total = 0;
$dys_total = 0;
$all_total = 0;
$rice_total = 0;

$select_emp_allowance = mysql_query("SELECT e_no,e_rice FROM employee WHERE e_rice != 0 ORDER BY  e_lname ASC");
while ($row_rice = mysql_fetch_assoc($select_emp_allowance)) {
    array_push($employee_with_rice, $row_rice['e_no']);
    $employee_rice_allowance[$row_rice['e_no']] = $row_rice['e_rice'];
}

if (isset($_POST['submit'])) {


    $f_cutoff = $_POST['f-cutoff'];
    $s_cutoff = $_POST['s-cutoff'];
    $print_company = $_POST['company'];
    $date = date('F', strtotime($f_cutoff)) . " 11, " . date('Y', strtotime($f_cutoff)) . " - " . date('F', strtotime($s_cutoff)) . " 10, " . date('Y', strtotime($s_cutoff));
    $select_special_holiday_f = mysql_query("SELECT e_special_holiday FROM payroll WHERE payroll_period = '$f_cutoff' AND e_special_holiday > 0 LIMIT 1");
    $select_special_holiday_s = mysql_query("SELECT e_special_holiday FROM payroll WHERE payroll_period = '$s_cutoff' AND e_special_holiday > 0 LIMIT 1");
    $result_sp_f = mysql_fetch_assoc($select_special_holiday_f);
    $result_sp_s = mysql_fetch_assoc($select_special_holiday_s);
    $sp_f = $result_sp_f['e_special_holiday'];
    $sp_s = $result_sp_s['e_special_holiday'];

    foreach ($employee_with_rice as $rice_employee) {
        $select_emp = mysql_query("SELECT e_lname,e_fname,e_mname,e_company,e_department FROM employee WHERE e_no = '$rice_employee' AND (e_employment_status = 'Regular' or e_employment_status = 'Probationary')");
        $select_attendance_first = mysql_query("SELECT e_total_cuttoff_hours,e_absences,e_lates,e_undertime,e_regular_holiday,e_special_holiday FROM payroll WHERE payroll_period = '$f_cutoff' AND e_no = '$rice_employee'");
        $select_attendance_second = mysql_query("SELECT e_total_cuttoff_hours,e_absences,e_lates,e_undertime,e_regular_holiday,e_special_holiday FROM payroll WHERE payroll_period = '$s_cutoff' AND e_no = '$rice_employee'");
        $result_attendance_first = mysql_fetch_assoc($select_attendance_first);
        $result_attendance_second = mysql_fetch_assoc($select_attendance_second);
        $result_emp = mysql_fetch_assoc($select_emp);
        $employee_name = $result_emp['e_lname'] . ", " . $result_emp['e_fname'] . " " . $result_emp['e_mname'][0] . ".";
        $company = $result_emp['e_company'];
        $department = $result_emp['e_department'];

        $first_hours = $result_attendance_first['e_total_cuttoff_hours'];
        $first_hours_holiday = $result_attendance_first['e_regular_holiday'];
        $first_special_holiday = $result_attendance_first['e_special_holiday'];
        $first_absences = $result_attendance_first['e_absences'];
        $first_lates = $result_attendance_first['e_lates'];
        $first_undertime = $result_attendance_first['e_undertime'];

        $sec_hours = $result_attendance_second['e_total_cuttoff_hours'];
        $sec_hours_holiday = $result_attendance_second['e_regular_holiday'];
        $sec_special_holiday = $result_attendance_second['e_special_holiday'];
        $sec_absences = $result_attendance_second['e_absences'];
        $sec_lates = $result_attendance_second['e_lates'];
        $sec_undertime = $result_attendance_second['e_undertime'];

        if ($sp_f > 0 && $company == 'ALC' && ($department == 'IT' || $department == 'FINANCE' || $department == 'ADMIN' || $department == 'SUPPLY AND PROCUREMENT')) {
            $first_special_holiday = 8;
        } elseif ($sp_f > 0 && ($employee_name == 'Bayona, Sharon C.' /* || $employee_name == 'Bayona, Archie P.' */)) {
            $first_special_holiday = 8;
        }

        if ($sp_s > 0 && $company == 'ALC' && ($department == 'IT' || $department == 'FINANCE' || $department == 'ADMIN' || $department == 'SUPPLY AND PROCUREMENT')) {
            $sec_special_holiday = 8;
        } elseif ($sp_s > 0 && ($employee_name == 'Bayona, Sharon C.' /* || $employee_name == 'Bayona, Archie P.' */)) {
            $first_special_holiday = 8;
        }

        if ($first_hours_holiday > 0) {
            $first_holiday = 8;
        }else { $first_holiday = 8; }

        if ($sec_hours_holiday > 0) {
            $sec_holiday = 8;
        }else { $sec_holiday = 8; }

        $total_hours = $first_hours + $sec_hours + $first_holiday + $sec_holiday + $first_special_holiday + $sec_special_holiday;
        $total_absences = $first_absences + $sec_absences;
        $total_lates = ($first_lates + $sec_lates) / 60;
        $total_undertime = ($first_undertime + $sec_undertime);

        $total_overall = $total_hours - ($total_absences + $total_lates + $total_undertime);

        $first_lates_hours = $first_lates / 60;
        $second_lates_hours = $sec_lates / 60;

        $first_total = ($first_hours + $first_holiday + $first_special_holiday) - ($first_absences + $first_lates_hours + $first_undertime);
        $second_total = ($sec_hours + $sec_holiday + $sec_special_holiday) - ($sec_absences + $second_lates_hours + $sec_undertime);

        $total_attendance = $first_total + $second_total;

        $total_days = $total_attendance / 8;

        $rice_daily = $employee_rice_allowance[$rice_employee] / 26;
        $total_allowance = $total_days * $rice_daily;
        $rice_allowance = $total_allowance  / 42;

        if ($total_attendance == 0) {
            continue;
        } else {

                  if ($company == "ALC") {
                array_push($employee_alc, array($employee_name, $rice_daily, $total_hours, $total_absences, $total_lates, $total_undertime, $total_overall, $total_days, $total_allowance, $rice_allowance));
            } elseif ($company == "LH") {
                array_push($employee_lh, array($employee_name, $rice_daily, $total_hours, $total_absences, $total_lates, $total_undertime, $total_overall, $total_days, $total_allowance, $rice_allowance));
            } elseif ($company == "KAT") {
                array_push($employee_kat, array($employee_name, $rice_daily, $total_hours, $total_absences, $total_lates, $total_undertime, $total_overall, $total_days, $total_allowance, $rice_allowance));
            } elseif ($company == "KAL") {
                array_push($employee_kal, array($employee_name, $rice_daily, $total_hours, $total_absences, $total_lates, $total_undertime, $total_overall, $total_days, $total_allowance, $rice_allowance));
            } elseif ($company == "CBI") {
                array_push($employee_cbi, array($employee_name, $rice_daily, $total_hours, $total_absences, $total_lates, $total_undertime, $total_overall, $total_days, $total_allowance, $rice_allowance));
            }
			  elseif ($company == "LYC") {
                array_push($employee_lyc, array($employee_name, $rice_daily, $total_hours, $total_absences, $total_lates, $total_undertime, $total_overall, $total_days, $total_allowance, $rice_allowance));
            } elseif ($company == "MC") {
                array_push($employee_mc, array($employee_name, $rice_daily, $total_hours, $total_absences, $total_lates, $total_undertime, $total_overall, $total_days, $total_allowance, $rice_allowance));
            } elseif ($company == "ADPLS") {
                array_push($employee_adpls, array($employee_name, $rice_daily, $total_hours, $total_absences, $total_lates, $total_undertime, $total_overall, $total_days, $total_allowance, $rice_allowance));
            } elseif ($company == "HH") {
                array_push($employee_hh, array($employee_name, $rice_daily, $total_hours, $total_absences, $total_lates, $total_undertime, $total_overall, $total_days, $total_allowance, $rice_allowance));
            }
            //echo "$company - $employee_name - " . $employee_rice_allowance[$rice_employee] . " - " . $total_days . " --- " . $rice_allowance . "<br />";
        }
    }
}


?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="css/rice-allowance.css" />
</head>

<body>

    <?php if ($print_company == 'ALC') : ?>
        <div class="alc-container-printed">
            <div class="alc-header">
                <div>ALC PRINTING HOUSE</div>
                <div>Rice Allowance</div>
                <div><?php echo $date; ?></div>
            </div>
            <div class="alc-title-printed flex">
                <div class="count">#</div>
                <div class="title-name">Employee</div>
                <div>Rice Allowance</div>
                <div></div>
            </div>

            <div class="data-container-printed">
                <?php for ($i = 0; $i < count($employee_alc); $i++) :
                        $emp_name = $employee_alc[$i][0];
                        $daily_allowance = $employee_alc[$i][1];
                        $hours = $employee_alc[$i][2];
                        $absent = $employee_alc[$i][3];
                        $lates = $employee_alc[$i][4];
                        $undertime = $employee_alc[$i][5];
                        $hours_total = $employee_alc[$i][6];
                        $days_total = $employee_alc[$i][7];
                        $allowance_total = $employee_alc[$i][8];
                        $allowance_rice = $employee_alc[$i][9];

                        $daily += $daily_allowance;
                        $hrs_total += $hours;
                        $abs_total += $absent;
                        $lte_total += $lates;
                        $und_total += $undertime;
                        $att_total += $hours_total;
                        $dys_total += $days_total;
                        $all_total += $allowance_total;
                        $rice_total += $allowance_rice;

                        $j = $i + 1;
                        ?>
                    <div class="data-content-printed flex">
                        <div class="count"><?php echo $j; ?></div>
                        <div class="data-name"><?php echo $emp_name; ?></div>
                        <div><?php echo number_format($allowance_rice, 2); ?></div>
                        <div></div>
                    </div>
                <?php endfor; ?>
                <div class="data-footer-printed flex">
                    <div class="count">#</div>
                    <div class="data-name">Total</div>
                    <div><?php echo number_format($rice_total, 2); ?></div>
                    <div>-</div>
                </div>

                <?php
                    $daily = 0;
                    $hrs_total = 0;
                    $abs_total = 0;
                    $lte_total = 0;
                    $und_total = 0;
                    $att_total = 0;
                    $dys_total = 0;
                    $all_total = 0;
                    $rice_total = 0;

                    ?>
            </div>
        </div>

    <?php elseif ($print_company == 'LH') : ?>
        <div class="lh-container-printed">
            <div class="lh-header">
                <div>LILYHILL TRADING</div>
                <div>Rice Allowance</div>
                <div><?php echo $date; ?></div>
            </div>
            <div class="lh-title-printed flex">
                <div class="title-name">Employee</div>
                <div>Rice Allowance</div>
                <div>Signature</div>
            </div>

            <div class="data-container-printed">
                <?php for ($i = 0; $i < count($employee_lh); $i++) :
                        $emp_name = $employee_lh[$i][0];
                        $daily_allowance = $employee_lh[$i][1];
                        $hours = $employee_lh[$i][2];
                        $absent = $employee_lh[$i][3];
                        $lates = $employee_lh[$i][4];
                        $undertime = $employee_lh[$i][5];
                        $hours_total = $employee_lh[$i][6];
                        $days_total = $employee_lh[$i][7];
                        $allowance_total = $employee_lh[$i][8];
                        $allowance_rice = $employee_lh[$i][9];


                        $daily += $daily_allowance;
                        $hrs_total += $hours;
                        $abs_total += $absent;
                        $lte_total += $lates;
                        $und_total += $undertime;
                        $att_total += $hours_total;
                        $dys_total += $days_total;
                        $all_total += $allowance_total;
                        $rice_total += $allowance_rice;
                        ?>
                    <div class="data-content-printed flex">
                        <div class="data-name"><?php echo $emp_name; ?></div>
                        <div><?php echo number_format($allowance_rice, 2); ?></div>
                        <div></div>
                    </div>
                <?php endfor; ?>
                <div class="data-footer-printed flex">
                    <div class="data-name">Total</div>
                    <div><?php echo number_format($rice_total, 2); ?></div>
                    <div>-</div>
                </div>

                <?php
                    $daily = 0;
                    $hrs_total = 0;
                    $abs_total = 0;
                    $lte_total = 0;
                    $und_total = 0;
                    $att_total = 0;
                    $dys_total = 0;
                    $all_total = 0;
                    $rice_total = 0;
                    ?>
            </div>
        </div>
        </div>

    <?php elseif ($print_company == 'CBI') : ?>
        <div class="cbi-container-printed">
            <div class="cbi-header">
                <div>CIRCON BUSINESSMAN'S INN</div>
                <div>Rice Allowance</div>
                <div><?php echo $date; ?></div>
            </div>
            <div class="cbi-title-printed flex">
                <div class="title-name">Employee</div>
                <div>Rice Allowance</div>
                <div>Signature</div>
            </div>

            <div class="data-container-printed">
                <?php for ($i = 0; $i < count($employee_cbi); $i++) :
                        $emp_name = $employee_cbi[$i][0];
                        $daily_allowance = $employee_cbi[$i][1];
                        $hours = $employee_cbi[$i][2];
                        $absent = $employee_cbi[$i][3];
                        $lates = $employee_cbi[$i][4];
                        $undertime = $employee_cbi[$i][5];
                        $hours_total = $employee_cbi[$i][6];
                        $days_total = $employee_cbi[$i][7];
                        $allowance_total = $employee_cbi[$i][8];
                        $allowance_rice = $employee_cbi[$i][9];

                        $daily += $daily_allowance;
                        $hrs_total += $hours;
                        $abs_total += $absent;
                        $lte_total += $lates;
                        $und_total += $undertime;
                        $att_total += $hours_total;
                        $dys_total += $days_total;
                        $all_total += $allowance_total;
                        $rice_total += $allowance_rice;
                        ?>
                    <div class="data-content-printed flex">
                        <div class="data-name"><?php echo $emp_name; ?></div>
                        <div><?php echo number_format($allowance_rice, 2); ?></div>
                        <div></div>
                    </div>
                <?php endfor; ?>

                <div class="data-footer-printed flex">
                    <div class="data-name">Total</div>
                    <div><?php echo number_format($rice_total, 2); ?></div>
                    <div>-</div>
                </div>

                <?php
                    $daily = 0;
                    $hrs_total = 0;
                    $abs_total = 0;
                    $lte_total = 0;
                    $und_total = 0;
                    $att_total = 0;
                    $dys_total = 0;
                    $all_total = 0;
                    $rice_total = 0;
                    ?>
            </div>
        </div>

    <?php elseif ($print_company == 'KAT') : ?>
        <div class="kat-container-printed">
            <div class="kat-header">
                <div>KATRINKAS KITCHEN</div>
                <div>Rice Allowance</div>
                <div><?php echo $date; ?></div>
            </div>
            <div class="kat-title-printed flex">
                <div class="title-name">Employee</div>
                <div>Rice Allowance</div>
                <div>Signature</div>
            </div>

            <div class="data-container-printed">
                <?php for ($i = 0; $i < count($employee_kat); $i++) :
                        $emp_name = $employee_kat[$i][0];
                        $daily_allowance = $employee_kat[$i][1];
                        $hours = $employee_kat[$i][2];
                        $absent = $employee_kat[$i][3];
                        $lates = $employee_kat[$i][4];
                        $undertime = $employee_kat[$i][5];
                        $hours_total = $employee_kat[$i][6];
                        $days_total = $employee_kat[$i][7];
                        $allowance_total = $employee_kat[$i][8];
                        $allowance_rice = $employee_kat[$i][9];

                        $daily += $daily_allowance;
                        $hrs_total += $hours;
                        $abs_total += $absent;
                        $lte_total += $lates;
                        $und_total += $undertime;
                        $att_total += $hours_total;
                        $dys_total += $days_total;
                        $all_total += $allowance_total;
                        $rice_total += $allowance_rice;
                        ?>
                    <div class="data-content-printed flex">
                        <div class="data-name"><?php echo $emp_name; ?></div>
                        <div><?php echo number_format($allowance_rice, 2); ?></div>
                        <div></div>
                    </div>
                <?php endfor; ?>

                <div class="data-footer-printed flex">
                    <div class="data-name">Total</div>
                    <div><?php echo number_format($rice_total, 2); ?></div>
                    <div>-</div>
                </div>

                <?php
                    $daily = 0;
                    $hrs_total = 0;
                    $abs_total = 0;
                    $lte_total = 0;
                    $und_total = 0;
                    $att_total = 0;
                    $dys_total = 0;
                    $all_total = 0;
                    $rice_total = 0;
                    ?>
            </div>
        </div>
		
		
	<!--- ------->

	 <?php elseif ($print_company == 'LYC') : ?>
        <div class="kat-container-printed">
            <div class="kat-header">
                <div>LUIS YC BUILDERS AND SUPPLY</div>
                <div>Rice Allowance</div>
                <div><?php echo $date; ?></div>
            </div>
            <div class="kat-title-printed flex">
                <div class="title-name">Employee</div>
                <div>Rice Allowance</div>
                <div>Signature</div>
            </div>

            <div class="data-container-printed">
                <?php for ($i = 0; $i < count($employee_lyc); $i++) :
                        $emp_name = $employee_lyc[$i][0];
                        $daily_allowance = $employee_lyc[$i][1];
                        $hours = $employee_lyc[$i][2];
                        $absent = $employee_lyc[$i][3];
                        $lates = $employee_lyc[$i][4];
                        $undertime = $employee_lyc[$i][5];
                        $hours_total = $employee_lyc[$i][6];
                        $days_total = $employee_lyc[$i][7];
                        $allowance_total = $employee_lyc[$i][8];
                        $allowance_rice = $employee_lyc[$i][9];

                        $daily += $daily_allowance;
                        $hrs_total += $hours;
                        $abs_total += $absent;
                        $lte_total += $lates;
                        $und_total += $undertime;
                        $att_total += $hours_total;
                        $dys_total += $days_total;
                        $all_total += $allowance_total;
                        $rice_total += $allowance_rice;
                        ?>
                    <div class="data-content-printed flex">
                        <div class="data-name"><?php echo $emp_name; ?></div>
                        <div><?php echo number_format($allowance_rice, 2); ?></div>
                        <div></div>
                    </div>
                <?php endfor; ?>

                <div class="data-footer-printed flex">
                    <div class="data-name">Total</div>
                    <div><?php echo number_format($rice_total, 2); ?></div>
                    <div>-</div>
                </div>

                <?php
                    $daily = 0;
                    $hrs_total = 0;
                    $abs_total = 0;
                    $lte_total = 0;
                    $und_total = 0;
                    $att_total = 0;
                    $dys_total = 0;
                    $all_total = 0;
                    $rice_total = 0;
                    ?>
            </div>
        </div>
		
		
		<?php elseif ($print_company == 'HH') : ?>
        <div class="kat-container-printed">
            <div class="kat-header">
                <div>HOUSEHOLD</div>
                <div>Rice Allowance</div>
                <div><?php echo $date; ?></div>
            </div>
            <div class="kat-title-printed flex">
                <div class="title-name">Employee</div>
                <div>Rice Allowance</div>
                <div>Signature</div>
            </div>

            <div class="data-container-printed">
                <?php for ($i = 0; $i < count($employee_hh); $i++) :
                        $emp_name = $employee_hh[$i][0];
                        $daily_allowance = $employee_hh[$i][1];
                        $hours = $employee_hh[$i][2];
                        $absent = $employee_hh[$i][3];
                        $lates = $employee_hh[$i][4];
                        $undertime = $employee_hh[$i][5];
                        $hours_total = $employee_hh[$i][6];
                        $days_total = $employee_hh[$i][7];
                        $allowance_total = $employee_hh[$i][8];
                        $allowance_rice = $employee_hh[$i][9];

                        $daily += $daily_allowance;
                        $hrs_total += $hours;
                        $abs_total += $absent;
                        $lte_total += $lates;
                        $und_total += $undertime;
                        $att_total += $hours_total;
                        $dys_total += $days_total;
                        $all_total += $allowance_total;
                        $rice_total += $allowance_rice;
                        ?>
                    <div class="data-content-printed flex">
                        <div class="data-name"><?php echo $emp_name; ?></div>
                        <div><?php echo number_format($allowance_rice, 2); ?></div>
                        <div></div>
                    </div>
                <?php endfor; ?>

                <div class="data-footer-printed flex">
                    <div class="data-name">Total</div>
                    <div><?php echo number_format($rice_total, 2); ?></div>
                    <div>-</div>
                </div>

                <?php
                    $daily = 0;
                    $hrs_total = 0;
                    $abs_total = 0;
                    $lte_total = 0;
                    $und_total = 0;
                    $att_total = 0;
                    $dys_total = 0;
                    $all_total = 0;
                    $rice_total = 0;
                    ?>
            </div>
        </div>
		
		 <?php elseif ($print_company == 'ADPLS') : ?>
        <div class="kat-container-printed">
            <div class="kat-header">
                <div>AdPlus</div>
                <div>Rice Allowance</div>
                <div><?php echo $date; ?></div>
            </div>
            <div class="kat-title-printed flex">
                <div class="title-name">Employee</div>
                <div>Rice Allowance</div>
                <div>Signature</div>
            </div>

            <div class="data-container-printed">
                <?php for ($i = 0; $i < count($employee_adpls); $i++) :
                        $emp_name = $employee_adpls[$i][0];
                        $daily_allowance = $employee_adpls[$i][1];
                        $hours = $employee_adpls[$i][2];
                        $absent = $employee_adpls[$i][3];
                        $lates = $employee_adpls[$i][4];
                        $undertime = $employee_adpls[$i][5];
                        $hours_total = $employee_adpls[$i][6];
                        $days_total = $employee_adpls[$i][7];
                        $allowance_total = $employee_adpls[$i][8];
                        $allowance_rice = $employee_adpls[$i][9];

                        $daily += $daily_allowance;
                        $hrs_total += $hours;
                        $abs_total += $absent;
                        $lte_total += $lates;
                        $und_total += $undertime;
                        $att_total += $hours_total;
                        $dys_total += $days_total;
                        $all_total += $allowance_total;
                        $rice_total += $allowance_rice;
                        ?>
                    <div class="data-content-printed flex">
                        <div class="data-name"><?php echo $emp_name; ?></div>
                        <div><?php echo number_format($allowance_rice, 2); ?></div>
                        <div></div>
                    </div>
                <?php endfor; ?>

                <div class="data-footer-printed flex">
                    <div class="data-name">Total</div>
                    <div><?php echo number_format($rice_total, 2); ?></div>
                    <div>-</div>
                </div>

                <?php
                    $daily = 0;
                    $hrs_total = 0;
                    $abs_total = 0;
                    $lte_total = 0;
                    $und_total = 0;
                    $att_total = 0;
                    $dys_total = 0;
                    $all_total = 0;
                    $rice_total = 0;
                    ?>
            </div>
        </div>
		
		
		<?php elseif ($print_company == 'MC') : ?>
        <div class="kat-container-printed">
            <div class="kat-header">
                <div>MACCOOLIT</div>
                <div>Rice Allowance</div>
                <div><?php echo $date; ?></div>
            </div>
            <div class="kat-title-printed flex">
                <div class="title-name">Employee</div>
                <div>Rice Allowance</div>
                <div>Signature</div>
            </div>

            <div class="data-container-printed">
                <?php for ($i = 0; $i < count($employee_mc); $i++) :
                        $emp_name = $employee_mc[$i][0];
                        $daily_allowance = $employee_mc[$i][1];
                        $hours = $employee_mc[$i][2];
                        $absent = $employee_mc[$i][3];
                        $lates = $employee_mc[$i][4];
                        $undertime = $employee_mc[$i][5];
                        $hours_total = $employee_mc[$i][6];
                        $days_total = $employee_mc[$i][7];
                        $allowance_total = $employee_mc[$i][8];
                        $allowance_rice = $employee_mc[$i][9];

                        $daily += $daily_allowance;
                        $hrs_total += $hours;
                        $abs_total += $absent;
                        $lte_total += $lates;
                        $und_total += $undertime;
                        $att_total += $hours_total;
                        $dys_total += $days_total;
                        $all_total += $allowance_total;
                        $rice_total += $allowance_rice;
                        ?>
                    <div class="data-content-printed flex">
                        <div class="data-name"><?php echo $emp_name; ?></div>
                        <div><?php echo number_format($allowance_rice, 2); ?></div>
                        <div></div>
                    </div>
                <?php endfor; ?>

                <div class="data-footer-printed flex">
                    <div class="data-name">Total</div>
                    <div><?php echo number_format($rice_total, 2); ?></div>
                    <div>-</div>
                </div>

                <?php
                    $daily = 0;
                    $hrs_total = 0;
                    $abs_total = 0;
                    $lte_total = 0;
                    $und_total = 0;
                    $att_total = 0;
                    $dys_total = 0;
                    $all_total = 0;
                    $rice_total = 0;
                    ?>
            </div>
        </div>
	

    <!---- -------->	
		
		

    <?php elseif ($print_company == 'KAL') : ?>
        <div class="kal-container-printed">
            <div class="kal-header">
                <div>KALIPAYAN TRAVEL AND TOURS</div>
                <div>Rice Allowance</div>
                <div><?php echo $date; ?></div>
            </div>
            <div class="kal-title-printed flex">
                <div class="title-name">Employee</div>
                <div>Rice Allowance</div>
                <div>Signature</div>
            </div>

            <div class="data-container-printed">
                <?php for ($i = 0; $i < count($employee_kal); $i++) :
                        $emp_name = $employee_kal[$i][0];
                        $daily_allowance = $employee_kal[$i][1];
                        $hours = $employee_kal[$i][2];
                        $absent = $employee_kal[$i][3];
                        $lates = $employee_kal[$i][4];
                        $undertime = $employee_kal[$i][5];
                        $hours_total = $employee_kal[$i][6];
                        $days_total = $employee_kal[$i][7];
                        $allowance_total = $employee_kal[$i][8];
                        $allowance_rice = $employee_kal[$i][9];

                        $daily += $daily_allowance;
                        $hrs_total += $hours;
                        $abs_total += $absent;
                        $lte_total += $lates;
                        $und_total += $undertime;
                        $att_total += $hours_total;
                        $dys_total += $days_total;
                        $all_total += $allowance_total;
                        $rice_total += $allowance_rice;
                        ?>
                    <div class="data-content-printed flex">
                        <div class="data-name"><?php echo $emp_name; ?></div>
                        <div><?php echo number_format($allowance_rice, 2); ?></div>
                        <div></div>
                    </div>
                <?php endfor; ?>

                <div class="data-footer-printed flex">
                    <div class="data-name">Total</div>
                    <div><?php echo number_format($rice_total, 2); ?></div>
                    <div>-</div>
                </div>

                <?php
                    $daily = 0;
                    $hrs_total = 0;
                    $abs_total = 0;
                    $lte_total = 0;
                    $und_total = 0;
                    $att_total = 0;
                    $dys_total = 0;
                    $all_total = 0;
                    $rice_total = 0;
                    ?>
            </div>
        </div>
        </div>
    <?php endif; ?>

    <div class="signatory-container">
        <div class="sign-title">PREPARED BY: </div>
        <div class="signatory"></div>
        <div class="signatory-title">_________________________________________________</div>
    </div>
</body>

</html>
