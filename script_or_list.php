<?php

include 'connection/conn.php';
include 'connection/pps_conn.php';

$start = $_GET['start'];
$end = $_GET['end'];

if (isset($_POST['or-cancel'])) {
    echo $or_no = $_POST['or-no'];
    mysql_query("INSERT INTO finance_or_cancelled(or_no,generated_date) VALUES($or_no,NOW())",$syshubconn) or die(mysql_error());
    header("location: script_or_list.php?start=$start&end=$end");
}


?>
<!DOCTYPE html>
<html>

<head>
    <title>OR Listing</title>
    <link rel="stylesheet" href="css/or_list.css" />
</head>

<body>
    <div>
        <div class="flex data-header-container">
            <div>OR #</div>
            <div class="header-client">Client Name</div>
            <div class="header-amount">OR Amount</div>
            <div class="header-hold">Witholding Amount</div>
            <div>JO #</div>
            <div>DR #</div>
            <div></div>
        </div>

        <?php for ($i = $start; $i <= $end; $i++) :
            $select_client_name = mysql_query("SELECT sales_clients.name FROM sales_jo_payments JOIN sales_clients ON sales_clients.client_id = sales_jo_payments.client_id WHERE or_no = $i", $syshubconn);
            $result_client_name = mysql_fetch_assoc($select_client_name);
            $client_name = $result_client_name['name'];

            $select_total_amount = mysql_query("SELECT SUM(payment) AS total_payment FROM sales_jo_payments WHERE or_no = $i AND pay_mode != '2307' AND pay_mode != '2306'", $syshubconn);
            $result_total_amount = mysql_fetch_assoc($select_total_amount);
            $total_amount = $result_total_amount['total_payment'];

            $select_total_hold = mysql_query("SELECT SUM(payment) AS total_withholding FROM sales_jo_payments WHERE or_no = $i AND (pay_mode = '2307' OR pay_mode = '2306')", $syshubconn);
            $result_total_hold = mysql_fetch_assoc($select_total_hold);
            $total_hold = $result_total_hold['total_withholding'];

            $select_jo = mysql_query("SELECT sales_jo.jo_actual FROM sales_jo_payments LEFT JOIN sales_jo ON sales_jo_payments.b_id = sales_jo.b_id WHERE or_no = $i GROUP BY sales_jo.jo_actual", $syshubconn);

            $select_dr = mysql_query("SELECT sales_bookings_details.dr_no FROM sales_jo_payments LEFT JOIN sales_bookings_details ON sales_jo_payments.b_id = sales_bookings_details.b_id WHERE or_no = $i GROUP BY sales_bookings_details.dr_no");

            $select_pps_jo = mysql_query("SELECT jo_actual FROM `dr_list` LEFT JOIN jo_list ON dr_list.jo_no = jo_list.jo_no WHERE dr_list.payment_or_no = $i", $ppsconn);

            $select_cancelled = mysql_query("SELECT or_no FROM finance_or_cancelled WHERE or_no = $i", $syshubconn);
            $result_cancelled = mysql_fetch_assoc($select_cancelled);
            $cancelled_or = $result_cancelled['or_no'];


            $select_pps_or = mysql_query("SELECT id FROM dr_list WHERE payment_or_no = $i", $ppsconn);
            $result_pps_or = mysql_fetch_assoc($select_pps_or);

            $select_name = mysql_query("SELECT trade_name.long_trade_name,branch.trade_name FROM dr_list LEFT JOIN branch ON dr_list.tin = branch.tin LEFT JOIN trade_name ON branch.trade_name = trade_name.trade_name WHERE dr_list.payment_or_no = $i", $ppsconn);
            $result_name = mysql_fetch_assoc($select_name);
            $pps_name = $result_name['long_trade_name'];
            $pps_sname = $result_name['trade_name'];

            $select_or_total = mysql_query("SELECT SUM(payment_amount) AS total_payment FROM dr_list WHERE payment_or_no = $i", $ppsconn);
            $result_or_total = mysql_fetch_assoc($select_or_total);
            $or_total_amount = $result_or_total['total_payment'];

            $select_or_hold_total = mysql_query("SELECT SUM(withheld_amount) AS total_payment FROM dr_list WHERE payment_or_no = $i", $ppsconn);
            $result_or_hold_total = mysql_fetch_assoc($select_or_hold_total);
            $or_total_hold_amount = $result_or_hold_total['total_payment'];

            ?>
            <div class="flex data-container">
                <?php if ($client_name == '' && $cancelled_or == '' && $result_pps_or == null) : ?>
                    <div style="background: #cc2306; padding: 5px; color: white">MISSING</div>
                <?php elseif ($client_name == '' && $cancelled_or != '') : ?>
                    <div style="background: #ec8703; padding: 5px; color: white">CANCELLED</div>
                <?php else : ?>
                    <div><?php echo $i; ?></div>
                <?php endif; ?>
                <div class="data-client">
                    <?php if ($client_name == '' && $pps_sname == '') {
                            echo '-';
                        } elseif ($result_pps_or != null) {
                            if ($pps_name == '') {
                                echo $pps_sname;
                            } else {
                                echo $pps_name;
                            }
                        } elseif ($client_name != '') {
                            echo $client_name;
                        }
                        ?>
                </div>
                <div class="data-amount">
                    <?php
                        if ($total_amount <= 0 && $result_pps_or == null) {
                            echo "-";
                        } elseif ($result_pps_or == null && $total_amount > 0) {
                            echo "PHP " . number_format($total_amount, 2);
                        } elseif ($result_pps_or != null && $total_amount <= 0) {
                            echo "PHP " . number_format($or_total_amount, 2);
                        } ?>
                </div>
                <div class="data-hold">
                    <?php
                        if ($total_hold <= 0 && $result_pps_or == null && $or_total_hold_amount <= 0) {
                            echo "-";
                        } elseif ($result_pps_or == null && $total_hold > 0) {
                            echo "PHP " . number_format($total_hold, 2);
                        } elseif ($result_pps_or != null && $total_hold <= 0) {
                            echo "PHP " . number_format($or_total_hold_amount, 2);
                        } ?>
                </div>
                <div class="data-jo">
                    <?php if ($result_pps_or == null) : ?>
                        <?php while ($jo_row = mysql_fetch_assoc($select_jo)) : ?>
                            <div><?php echo $jo_row['jo_actual']; ?></div>
                        <?php endwhile; ?>
                    <?php elseif ($result_pps_or != null) : ?>
                        <?php while ($jo_or_row = mysql_fetch_assoc($select_pps_jo)) : ?>
                            <div><?php echo $jo_or_row['jo_actual']; ?></div>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </div>
                <div class="data-dr">
                    <?php while ($dr_row = mysql_fetch_assoc($select_dr)) : ?>
                        <div><?php echo $dr_row['dr_no']; ?></div>
                    <?php endwhile; ?>
                </div>
                <div>
                    <?php if ($client_name != '' || $result_pps_or != null) : ?>
                        <?php echo '-'; ?>
                    <?php elseif ($client_name == '' && $cancelled_or == '' && $result_pps_or == null) : ?>
                        <form method="POST" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                            <input type="hidden" value="<?php echo $i; ?>" name="or-no" />
                            <input type="submit" name="or-cancel" value="CANCEL" />
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        <?php endfor; ?>
    </div>
</body>

</html>