<?php
require 'connection/conn.php';
session_start();
$username = $_SESSION['username'];
if (isset($_POST['submit'])) {
    $employee_ID = $_POST['e-no'];
    $ca_amount = $_POST['cash-advance'];
    $release_date = $_COOKIE['release-date'];
    $payroll_period = $_COOKIE['payroll-period'];
    $ca_status_query = "SELECT * FROM employee_cash_advance WHERE e_no='$employee_ID' AND ca_payroll_period='$payroll_period'";
    $ca_status_result = mysql_query($ca_status_query) or die(mysql_error());

    if (mysql_num_rows($ca_status_result) > 0) {

        while ($ca_status_row = mysql_fetch_assoc($ca_status_result)) {
            if ($ca_status_row['ca_first_status'] === '1') {
                $ca_update = "UPDATE employee_cash_advance SET ca_amount_second=$ca_amount, ca_release_date_second='$release_date', ca_second_status=1 WHERE e_no='$employee_ID' AND ca_payroll_period='$payroll_period'";
                if (mysql_query($ca_update)) {
                    header("Location: script_ca.php");
                } else {
                    die(mysql_error());
                }
            }
        }
    } else {

        $ca_insert = "INSERT INTO employee_cash_advance(e_no,ca_amount_first,ca_release_date_first,ca_payroll_period,ca_first_status)
        VALUES ('$employee_ID','$ca_amount','$release_date','$payroll_period','1')";
        if (mysql_query($ca_insert)) {
            header("Location: script_ca.php");
        } else {
            die(mysql_error());
        }
    }
}
