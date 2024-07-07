<!DOCTYPE html>

<?php
session_start();
$username = $_SESSION['username'];
require 'connection/conn.php';
$select_employee = mysql_query("SELECT * FROM employee WHERE e_employment_status = 'Regular' OR e_employment_status = 'Probationary' ORDER BY e_lname") or die(mysql_error($syshubconn));
$payroll_period = $_GET['pay-period'];
$select_adjustments = mysql_query("SELECT emp.e_no,ea.adjustment_amount,ea.remarks,ea.payroll_period,emp.e_lname,emp.e_fname,emp.e_mname FROM `employee_adjustments` AS ea JOIN employee AS emp ON emp.e_no = ea.e_no WHERE ea.payroll_period = '$payroll_period'");
$total = 0;

$year_month = date("Y-m", strtotime($payroll_period));
$first_cutoff_start = "$year_month-1";
$first_cutoff_end = "$year_month-15";
$second_cutoff_start = "$year_month-16";
$second_cutoff_end = "$year_month-31";

if (isset($_GET['set-filter'])) {
    $payroll_period = $_GET['pay-period'];
    header("location: script_adjustments_batch.php?pay-period=$payroll_period");
}

if (isset($_POST['submit-adj'])) {
    $e_no = $_POST['e-no'];
    $payroll_period = $_GET['pay-period'];
    $amount = $_POST['adj-amount'];
    $remarks = addslashes($_POST['adj-remarks']);
    $insert_adjusment = mysql_query("INSERT INTO employee_adjustments(e_no,adjustment_amount,remarks,payroll_period,date_encoded) 
        VALUES('$e_no',$amount,'$remarks','$payroll_period',NOW())") or die(mysql_error());
    header("location: script_adjustments_batch.php?pay-period=$payroll_period");
}

if (isset($_POST['delete'])) {
    $payroll_period = $_GET['pay-period'];
    $e_no = $_POST['e-no'];
    mysql_query("DELETE FROM employee_adjustments WHERE e_no = '$e_no' AND payroll_period = '$payroll_period'") or die(mysql_query());
    header("location: script_adjustments_batch.php?pay-period=$payroll_period");
}
?>
<html>

<head>
    <link rel="stylesheet" href="css/adjustments.css" />
    <link rel="stylesheet" href="css/font-awesome.min.css" />
</head>

<body>


    <?php if ($_GET['pay-period'] != '') : ?>
        <div class="container flex">
            <div class="data-container">
                <div class="center title"><?php echo "ADJUSTMENT/S FOR PAYROLL PERIOD: <span style='color: royalblue'>" . $_GET['pay-period'] . "</span>"; ?></div>
                <?php while ($result_employee = mysql_fetch_assoc($select_employee)) :
                    $fname = $result_employee['e_fname'];
                    $mname = $result_employee['e_mname'];
                    $lname = $result_employee['e_lname'];
                    $e_no = $result_employee['e_no'];
                    $name = "$lname, $fname $mname[0].";
                    ?>
                    <div class="flex data-row">
                        <div class="bold e-name"><?php echo $name; ?></div>
                        <div>
                            <form method="POST" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                                <input type="hidden" name="e-no" value="<?php echo $e_no; ?>" />
                                <input required type="number" min="1" name="adj-amount" step="any" placeholder="Amount" />
                                <input class="remarks" required type="text" name="adj-remarks" placeholder="Remarks" />
                                <input class="button" type="submit" name="submit-adj" value="Submit" />
                            </form>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>

            <div class="monitoring-container">
                <div class="flex">
                    <div class="title-head title-name">Name</div>
                    <div class="title-head title-adj">Adjustment Amount</div>
                    <div class="title-head title-rem">Remarks</div>
                    <div class="title-head"></div>
                </div>
                <?php while ($row_adjustments = mysql_fetch_assoc($select_adjustments)) :
                    $fname = $row_adjustments['e_fname'];
                    $mname = $row_adjustments['e_mname'];
                    $lname = $row_adjustments['e_lname'];
                    $name = "$lname, $fname $mname[0].";
                    $adjustment = $row_adjustments['adjustment_amount'];
                    $adjustment_remarks = $row_adjustments['remarks'];
                    $total += $adjustment;
                    $e_no = $row_adjustments['e_no'];

                    $select_payroll = mysql_query("SELECT * FROM payroll WHERE payroll_period >= '$first_cutoff_start' AND payroll_period <= '$first_cutoff_end' AND e_no='$e_no'") or die(mysql_error());
                    $result_payroll = mysql_fetch_assoc($select_payroll);
                    $step2 = $result_payroll['step2'];

                    ?>
                    <div class="flex details-cont">
                        <div class="adj-data adj-name"><?php echo $name; ?></div>
                        <div class="adj-data adj-amt"><?php echo "PHP " . number_format($adjustment, 2); ?></div>
                        <div class="adj-data adj-rem"><?php echo $adjustment_remarks; ?></div>
                        <div class="adj-data">
                            <?php if ($step2 != 1) : ?>
                                <form method="POST">
                                    <input type="hidden" name="e-no" value="<?php echo $e_no ?>" />
                                    <button class="button-del" name="delete"><i class="fa fa-trash"></i></button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endwhile; ?>
                <div class="flex">
                    <div class="title-foot foot-total">TOTAL</div>
                    <div class="title-foot foot-amount"><?php echo "PHP " . number_format($total, 2); ?></div>
                    <div class="title-foot foot-blank"></div>
                    <div class="title-foot"></div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</body>


</html>