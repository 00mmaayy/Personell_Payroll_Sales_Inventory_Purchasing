<!DOCTYPE html>

<?php
session_start();
$username = $_SESSION['username'];
include 'connection/conn.php';

//VARIABLES
$previous_period = $_GET['prev-period'];
$payroll_period = $_GET['pay-period'];
$user = $_SESSION['username'];
$prev_array = array();
$total = 0;

// QUERY FOR GETTING THE LATEST DATE IN TABLE
$latest_period = mysql_query("SELECT * FROM employee_negative ORDER BY payroll_period DESC LIMIT 1");
if ($latest_row = mysql_fetch_assoc($latest_period)) {
    $period_latest = $latest_row['payroll_period'];
} else {
    $period_latest = '';
}

// DATA QUERY
$select_all_previous = mysql_query("SELECT e.e_fname,e.e_mname,e.e_lname,en.* FROM employee_negative AS en LEFT JOIN employee AS e USING(e_no)");
$select_previous = mysql_query("SELECT e.e_no,e.e_fname,e.e_mname,e.e_lname,p.e_netpay 
                                                FROM payroll AS p JOIN employee AS e 
                                                USING(e_NO) 
                                                WHERE p.payroll_period = '$previous_period' AND p.e_netpay < 0");

//INSERT TO DB
if (isset($_POST['generate'])) {
    $array = $_POST['prev-array'];
    $prev_array = unserialize(base64_decode($array));
    foreach ($prev_array as $prev) {
        $e_no = $prev[0];
        $netpay = $prev[1] * -1;

        mysql_query("INSERT INTO employee_negative(e_no,amount,payroll_period,date_generated,generated_by) 
                                    VALUES('$e_no',$netpay,'$payroll_period',NOW(),'$user')");

    }
    header("location: script_previous_pay.php?prev-period=$previous_period&pay-period=$payroll_period");
}

?>

<html>

<head>
    <link rel="stylesheet" href="./css/prev_pay.css" />
</head>

<body>
    <div class="flex">
        <!-- PREVIOUS PAYROLL -->
        <div class="current-container">
            <div>Previous over pay</div>
            <div class="current-header flex">
                <div class="header-name">Name</div>
                <div class="header-amount">Over from previous pay</div>
            </div>

            <?php while ($prev_row = mysql_fetch_assoc($select_previous)) :
                $e_no = $prev_row['e_no'];
                $fname = $prev_row['e_fname'];
                $mname = $prev_row['e_mname'];
                $lname = $prev_row['e_lname'];
                $net_pay = $prev_row['e_netpay'];
                $total += $net_pay;
                array_push($prev_array, [$e_no, $net_pay]);
                ?>
                <div class="current-data flex">
                    <div class="data-name"><?php echo "$lname, $fname $mname[0]."; ?></div>
                    <div class="data-amount"><?php echo "PHP " . number_format($net_pay, 2); ?></div>
                </div>
            <?php endwhile; ?>
            <div class="total flex">
                <div class="total-name">Total</div>
                <div class="total-amount"><?php echo "PHP " . number_format($total, 2); ?></div>
            </div>
            <form method="POST" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                <input type="hidden" name="prev-array" value="<?php print base64_encode(serialize($prev_array)); ?>" />
                <input type="submit" name="generate" value="Generate" <?php if ($period_latest == $payroll_period) {
                                                                            echo 'disabled';
                                                                        } ?> />
            </form>
        </div>


        <!-- ALL PREVIOUS PAY ON RECORD -->
        <div>
            Previous over pay record
            <div class="flex">
                <div>Employee Number</div>
                <div>Employee Name</div>
                <div>Charge Amount</div>
                <div>Payroll Period</div>
                <div>Pay Status</div>
            </div>
            <?php while ($all_prev_row = mysql_fetch_assoc($select_all_previous)) :
                $e_no = $all_prev_row['e_no'];
                $fname = $all_prev_row['e_fname'];
                $mname = $all_prev_row['e_mname'];
                $lname = $all_prev_row['e_lname'];
                $amount = $all_prev_row['amount'];
                $period = $all_prev_row['payroll_period'];
                $pay_status = $all_prev_row['pay_status'];
                ?>
                <div class="flex">
                    <div><?php echo $e_no; ?></div>
                    <div><?php echo "$lname, $fname $mname[0]."; ?></div>
                    <div><?php echo $amount ?></div>
                    <div><?php echo $period; ?></div>
                    <div><?php echo $pay_status; ?></div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>

</html>