<!DOCTYPE html>

<?php
require 'connection/conn.php';

session_start();
$current_user = $_SESSION['username'];
$spas = "select * from user_access where username='$current_user'";
$qpas = mysql_query($spas) or die(mysql_error());
$access = mysql_fetch_assoc($qpas);

$hold = 1;
$onhold = 0;
$unhold = 0;
$cutoff_date = '';
$current = 0;
$full_loan = 1;
$monthly_loan = 0;
$set_month = '';
$set_year = '';
$company = 'all';
$set_comp = 'ALL';
$active = 1;
$selected_date = '';

//TOTAL VARIABLES
$firstcp_total = 0;
$firstci_total = 0;
$first_total = 0;
$secondcp_total = 0;
$secondci_total = 0;
$second_total = 0;
$total_principal = 0;
$total_interest = 0;
$totalpi = 0;
$total_rp = 0;
$total_ri = 0;
$total_rem = 0;
$total_loan_principal = 0;
$total_loan_interest = 0;
$total_loan = 0;
$total_paid_principal = 0;
$total_paid_interest = 0;
$total_paid = 0;
$total_rem_principal = 0;
$total_rem_interest = 0;
$total_rem_amount = 0;

$total_loan_principal_sl = 0;
$total_loan_interest_sl = 0;
$total_loan_sl = 0;
$total_paid_principal_sl = 0;
$total_paid_interest_sl = 0;
$total_paid_sl = 0;
$total_rem_principal_sl = 0;
$total_rem_interest_sl = 0;
$total_rem_amount_sl = 0;

$total_loan_principal_ss = 0;
$total_loan_interest_ss = 0;
$total_loan_ss = 0;
$total_paid_principal_ss = 0;
$total_paid_interest_ss = 0;
$total_paid_ss = 0;
$total_rem_principal_ss = 0;
$total_rem_interest_ss = 0;
$total_rem_amount_ss = 0;

$total_loan_principal_pl = 0;
$total_loan_interest_pl = 0;
$total_loan_pl = 0;
$total_paid_principal_pl = 0;
$total_paid_interest_pl = 0;
$total_paid_pl = 0;
$total_rem_principal_pl = 0;
$total_rem_interest_pl = 0;
$total_rem_amount_pl = 0;

$lp_pl = 0;
$li_pl = 0;
$lt_pl = 0;
$pp_pl = 0;
$pi_pl = 0;
$pt_pl = 0;
$rp_pl = 0;
$ri_pl = 0;
$tr_pl = 0;


$select_company = "SELECT * FROM company";
$company_result = mysql_query($select_company) or die(mysql_error());


$sl_query = "SELECT emp.e_title, emp.e_fname, emp.e_mname, emp.e_lname, el.loan_code, el.loan_principal, el.loan_release_date, el.loan_remarks, elt.loan_type 
                    FROM employee AS emp JOIN employee_loan AS el ON el.e_no = emp.e_no 
                    JOIN employee_loan_schedule AS els ON els.loan_code=el.loan_code 
                    JOIN employee_loan_type AS elt ON el.loan_type = elt.loan_type_code 
                    WHERE els.loan_balance = 0 AND els.loan_payment_status = 0 AND el.loan_type = 'SL' ORDER BY emp.e_lname ASC";
$sl_result = mysql_query($sl_query) or die(mysql_error());

$ss_query = "SELECT emp.e_title, emp.e_fname, emp.e_mname, emp.e_lname, el.loan_code, el.loan_principal, el.loan_release_date, el.loan_remarks, elt.loan_type 
    FROM employee AS emp JOIN employee_loan AS el ON el.e_no = emp.e_no 
    JOIN employee_loan_schedule AS els ON els.loan_code=el.loan_code 
    JOIN employee_loan_type AS elt ON el.loan_type = elt.loan_type_code 
    WHERE els.loan_balance = 0 AND els.loan_payment_status = 0 AND el.loan_type = 'SS' ORDER BY emp.e_lname ASC";
$ss_result = mysql_query($ss_query) or die(mysql_error());

$pl_query = "SELECT emp.e_title, emp.e_fname, emp.e_mname, emp.e_lname, el.loan_code, el.loan_principal, el.loan_release_date, el.loan_remarks, elt.loan_type 
    FROM employee AS emp JOIN employee_loan AS el ON el.e_no = emp.e_no 
    JOIN employee_loan_schedule AS els ON els.loan_code=el.loan_code 
    JOIN employee_loan_type AS elt ON el.loan_type = elt.loan_type_code 
    WHERE els.loan_balance = 0 AND els.loan_payment_status = 0 AND el.loan_type = 'PL' ORDER BY emp.e_lname ASC";
$pl_result = mysql_query($pl_query) or die(mysql_error());

if (isset($_GET['active'])) {
    $full_loan = 1;
    $monthly_loan = 0;

    if (isset($_POST['company-submit'])) {
        $company = $_POST['set-comp'];
        if ($company != 'ALL') {
            $sl_query = "SELECT emp.e_title, emp.e_fname, emp.e_mname, emp.e_lname, el.loan_code, el.loan_principal, el.loan_release_date, el.loan_remarks, elt.loan_type 
                FROM employee AS emp JOIN employee_loan AS el ON el.e_no = emp.e_no 
                JOIN employee_loan_schedule AS els ON els.loan_code=el.loan_code 
                JOIN employee_loan_type AS elt ON el.loan_type = elt.loan_type_code 
                WHERE els.loan_balance = 0 AND els.loan_payment_status = 0 AND emp.e_company = '$company' AND el.loan_type = 'SL' ORDER BY emp.e_lname ASC";
            $sl_result = mysql_query($sl_query) or die(mysql_error());

            $ss_query = "SELECT emp.e_title, emp.e_fname, emp.e_mname, emp.e_lname, el.loan_code, el.loan_principal, el.loan_release_date, el.loan_remarks, elt.loan_type 
                FROM employee AS emp JOIN employee_loan AS el ON el.e_no = emp.e_no 
                JOIN employee_loan_schedule AS els ON els.loan_code=el.loan_code 
                JOIN employee_loan_type AS elt ON el.loan_type = elt.loan_type_code 
                WHERE els.loan_balance = 0 AND els.loan_payment_status = 0 AND emp.e_company = '$company' AND el.loan_type = 'SS' ORDER BY emp.e_lname ASC";
            $ss_result = mysql_query($ss_query) or die(mysql_error());

            $pl_query = "SELECT emp.e_title, emp.e_fname, emp.e_mname, emp.e_lname, el.loan_code, el.loan_principal, el.loan_release_date, el.loan_remarks, elt.loan_type 
                FROM employee AS emp JOIN employee_loan AS el ON el.e_no = emp.e_no 
                JOIN employee_loan_schedule AS els ON els.loan_code=el.loan_code 
                JOIN employee_loan_type AS elt ON el.loan_type = elt.loan_type_code 
                WHERE els.loan_balance = 0 AND els.loan_payment_status = 0 AND emp.e_company = '$company' AND el.loan_type = 'PL' ORDER BY emp.e_lname ASC";
            $pl_result = mysql_query($pl_query) or die(mysql_error());
        }
    } else {
        $sl_query = "SELECT emp.e_title, emp.e_fname, emp.e_mname, emp.e_lname, el.loan_code, el.loan_principal, el.loan_release_date, el.loan_remarks, elt.loan_type FROM employee AS emp JOIN employee_loan AS el ON el.e_no = emp.e_no JOIN employee_loan_schedule AS els ON els.loan_code=el.loan_code JOIN employee_loan_type AS elt ON el.loan_type = elt.loan_type_code WHERE els.loan_balance = 0 AND els.loan_payment_status = 0 AND el.loan_type = 'SL' ORDER BY emp.e_lname ASC";
        $sl_result = mysql_query($sl_query) or die(mysql_error());

        $ss_query = "SELECT emp.e_title, emp.e_fname, emp.e_mname, emp.e_lname, el.loan_code, el.loan_principal, el.loan_release_date, el.loan_remarks, elt.loan_type FROM employee AS emp JOIN employee_loan AS el ON el.e_no = emp.e_no JOIN employee_loan_schedule AS els ON els.loan_code=el.loan_code JOIN employee_loan_type AS elt ON el.loan_type = elt.loan_type_code WHERE els.loan_balance = 0 AND els.loan_payment_status = 0 AND el.loan_type = 'SS' ORDER BY emp.e_lname ASC";
        $ss_result = mysql_query($ss_query) or die(mysql_error());

        $pl_query = "SELECT emp.e_title, emp.e_fname, emp.e_mname, emp.e_lname, el.loan_code, el.loan_principal, el.loan_release_date, el.loan_remarks, elt.loan_type FROM employee AS emp JOIN employee_loan AS el ON el.e_no = emp.e_no JOIN employee_loan_schedule AS els ON els.loan_code=el.loan_code JOIN employee_loan_type AS elt ON el.loan_type = elt.loan_type_code WHERE els.loan_balance = 0 AND els.loan_payment_status = 0 AND el.loan_type = 'PL' ORDER BY emp.e_lname ASC";
        $pl_result = mysql_query($pl_query) or die(mysql_error());
    }
} elseif (isset($_GET['paid'])) {
    $full_loan = 1;
    $monthly_loan = 0;
    $hold = 0;

    if (isset($_POST['company-submit'])) {
        $company = $_POST['set-comp'];
        if ($company != 'ALL') {
            $sl_query = "SELECT emp.e_title, emp.e_fname, emp.e_mname, emp.e_lname, el.loan_code, el.loan_principal, el.loan_release_date, el.loan_remarks, elt.loan_type 
                FROM employee AS emp JOIN employee_loan AS el ON el.e_no = emp.e_no 
                JOIN employee_loan_schedule AS els ON els.loan_code=el.loan_code 
                JOIN employee_loan_type AS elt ON el.loan_type = elt.loan_type_code 
                WHERE els.loan_balance = 0 AND els.loan_payment_status = 1 AND emp.e_company = '$company' AND el.loan_type = 'SL' ORDER BY emp.e_lname ASC";
            $sl_result = mysql_query($sl_query) or die(mysql_error());

            $ss_query = "SELECT emp.e_title, emp.e_fname, emp.e_mname, emp.e_lname, el.loan_code, el.loan_principal, el.loan_release_date, el.loan_remarks, elt.loan_type 
                FROM employee AS emp JOIN employee_loan AS el ON el.e_no = emp.e_no 
                JOIN employee_loan_schedule AS els ON els.loan_code=el.loan_code 
                JOIN employee_loan_type AS elt ON el.loan_type = elt.loan_type_code 
                WHERE els.loan_balance = 0 AND els.loan_payment_status = 1 AND emp.e_company = '$company' AND el.loan_type = 'SS' ORDER BY emp.e_lname ASC";
            $ss_result = mysql_query($ss_query) or die(mysql_error());

            $pl_query = "SELECT emp.e_title, emp.e_fname, emp.e_mname, emp.e_lname, el.loan_code, el.loan_principal, el.loan_release_date, el.loan_remarks, elt.loan_type 
                FROM employee AS emp JOIN employee_loan AS el ON el.e_no = emp.e_no 
                JOIN employee_loan_schedule AS els ON els.loan_code=el.loan_code 
                JOIN employee_loan_type AS elt ON el.loan_type = elt.loan_type_code 
                WHERE els.loan_balance = 0 AND els.loan_payment_status = 1 AND emp.e_company = '$company' AND el.loan_type = 'PL' ORDER BY emp.e_lname ASC";
            $pl_result = mysql_query($pl_query) or die(mysql_error());
        } else {
            $sl_query = "SELECT emp.e_title, emp.e_fname, emp.e_mname, emp.e_lname, el.loan_code, el.loan_principal, el.loan_release_date, el.loan_remarks, elt.loan_type 
                FROM employee AS emp JOIN employee_loan AS el ON el.e_no = emp.e_no 
                JOIN employee_loan_schedule AS els ON els.loan_code=el.loan_code 
                JOIN employee_loan_type AS elt ON el.loan_type = elt.loan_type_code 
                WHERE els.loan_balance = 0 AND els.loan_payment_status = 1 AND el.loan_type = 'SL' ORDER BY  emp.e_lname ASC";
            $sl_result = mysql_query($sl_query) or die(mysql_error());

            $ss_query = "SELECT emp.e_title, emp.e_fname, emp.e_mname, emp.e_lname, el.loan_code, el.loan_principal, el.loan_release_date, el.loan_remarks, elt.loan_type 
                FROM employee AS emp JOIN employee_loan AS el ON el.e_no = emp.e_no 
                JOIN employee_loan_schedule AS els ON els.loan_code=el.loan_code 
                JOIN employee_loan_type AS elt ON el.loan_type = elt.loan_type_code 
                WHERE els.loan_balance = 0 AND els.loan_payment_status = 1 AND el.loan_type = 'SS' ORDER BY emp.e_lname ASC";
            $ss_result = mysql_query($ss_query) or die(mysql_error());

            $pl_query = "SELECT emp.e_title, emp.e_fname, emp.e_mname, emp.e_lname, el.loan_code, el.loan_principal, el.loan_release_date, el.loan_remarks, elt.loan_type 
                FROM employee AS emp JOIN employee_loan AS el ON el.e_no = emp.e_no 
                JOIN employee_loan_schedule AS els ON els.loan_code=el.loan_code 
                JOIN employee_loan_type AS elt ON el.loan_type = elt.loan_type_code 
                WHERE els.loan_balance = 0 AND els.loan_payment_status = 1 AND el.loan_type = 'PL' ORDER BY emp.e_lname ASC";
            $pl_result = mysql_query($pl_query) or die(mysql_error());
        }
    } else {
        $sl_query = "SELECT emp.e_title, emp.e_fname, emp.e_mname, emp.e_lname, el.loan_code, el.loan_principal, el.loan_release_date, el.loan_remarks, elt.loan_type 
            FROM employee AS emp JOIN employee_loan AS el ON el.e_no = emp.e_no 
            JOIN employee_loan_schedule AS els ON els.loan_code=el.loan_code 
            JOIN employee_loan_type AS elt ON el.loan_type = elt.loan_type_code 
            WHERE els.loan_balance = 0 AND els.loan_payment_status = 1 AND el.loan_type = 'SL' ORDER BY emp.e_lname ASC";
        $sl_result = mysql_query($sl_query) or die(mysql_error());

        $ss_query = "SELECT emp.e_title, emp.e_fname, emp.e_mname, emp.e_lname, el.loan_code, el.loan_principal, el.loan_release_date, el.loan_remarks, elt.loan_type 
            FROM employee AS emp JOIN employee_loan AS el ON el.e_no = emp.e_no 
            JOIN employee_loan_schedule AS els ON els.loan_code=el.loan_code 
            JOIN employee_loan_type AS elt ON el.loan_type = elt.loan_type_code 
            WHERE els.loan_balance = 0 AND els.loan_payment_status = 1 AND el.loan_type = 'SS' ORDER BY emp.e_lname ASC";
        $ss_result = mysql_query($ss_query) or die(mysql_error());

        $pl_query = "SELECT emp.e_title, emp.e_fname, emp.e_mname, emp.e_lname, el.loan_code, el.loan_principal, el.loan_release_date, el.loan_remarks, elt.loan_type 
            FROM employee AS emp JOIN employee_loan AS el ON el.e_no = emp.e_no 
            JOIN employee_loan_schedule AS els ON els.loan_code=el.loan_code 
            JOIN employee_loan_type AS elt ON el.loan_type = elt.loan_type_code 
            WHERE els.loan_balance = 0 AND els.loan_payment_status = 1 AND el.loan_type = 'PL' ORDER BY emp.e_lname ASC";
        $pl_result = mysql_query($pl_query) or die(mysql_error());
    }
} elseif (isset($_GET['hold'])) {
    $full_loan = 1;
    $monthly_loan = 0;
    $hold = 0;
    $unhold = 1;
    if (isset($_POST['company-submit'])) {
        $company = $_POST['set-comp'];
        if ($company != 'ALL') {
            $sl_query = "SELECT emp.e_title, emp.e_fname, emp.e_mname, emp.e_lname, el.loan_code, el.loan_principal, el.loan_release_date, el.loan_remarks, elt.loan_type 
                FROM employee AS emp JOIN employee_loan AS el ON el.e_no = emp.e_no 
                JOIN employee_loan_schedule AS els ON els.loan_code=el.loan_code 
                JOIN employee_loan_type AS elt ON el.loan_type = elt.loan_type_code 
                WHERE els.loan_balance = 0 and els.loan_payment_status = 2 AND emp.e_company = '$company' AND el.loan_type = 'SL' ORDER BY emp.e_lname ASC";
            $sl_result = mysql_query($sl_query) or die(mysql_error());

            $ss_query = "SELECT emp.e_title, emp.e_fname, emp.e_mname, emp.e_lname, el.loan_code, el.loan_principal, el.loan_release_date, el.loan_remarks, elt.loan_type 
                FROM employee AS emp JOIN employee_loan AS el ON el.e_no = emp.e_no 
                JOIN employee_loan_schedule AS els ON els.loan_code=el.loan_code 
                JOIN employee_loan_type AS elt ON el.loan_type = elt.loan_type_code 
                WHERE els.loan_balance = 0 and els.loan_payment_status = 2 AND emp.e_company = '$company' AND el.loan_type = 'SS' ORDER BY emp.e_lname ASC";
            $ss_result = mysql_query($ss_query) or die(mysql_error());

            $pl_query = "SELECT emp.e_title, emp.e_fname, emp.e_mname, emp.e_lname, el.loan_code, el.loan_principal, el.loan_release_date, el.loan_remarks, elt.loan_type 
                FROM employee AS emp JOIN employee_loan AS el ON el.e_no = emp.e_no 
                JOIN employee_loan_schedule AS els ON els.loan_code=el.loan_code 
                JOIN employee_loan_type AS elt ON el.loan_type = elt.loan_type_code 
                WHERE els.loan_balance = 0 and els.loan_payment_status = 2 AND emp.e_company = '$company'AND el.loan_type = 'PL' ORDER BY emp.e_lname ASC";
            $pl_result = mysql_query($pl_query) or die(mysql_error());
        } else {
            $sl_query = "SELECT emp.e_title, emp.e_fname, emp.e_mname, emp.e_lname, el.loan_code, el.loan_principal, el.loan_release_date, el.loan_remarks, elt.loan_type 
                FROM employee AS emp JOIN employee_loan AS el ON el.e_no = emp.e_no 
                JOIN employee_loan_schedule AS els ON els.loan_code=el.loan_code 
                JOIN employee_loan_type AS elt ON el.loan_type = elt.loan_type_code 
                WHERE els.loan_balance = 0 and els.loan_payment_status = 2 AND el.loan_type = 'SL' ORDER BY emp.e_lname ASC";
            $sl_result = mysql_query($sl_query) or die(mysql_error());

            $ss_query = "SELECT emp.e_title, emp.e_fname, emp.e_mname, emp.e_lname, el.loan_code, el.loan_principal, el.loan_release_date, el.loan_remarks, elt.loan_type 
                FROM employee AS emp JOIN employee_loan AS el ON el.e_no = emp.e_no 
                JOIN employee_loan_schedule AS els ON els.loan_code=el.loan_code 
                JOIN employee_loan_type AS elt ON el.loan_type = elt.loan_type_code 
                WHERE els.loan_balance = 0 and els.loan_payment_status = 2 AND el.loan_type = 'SS' ORDER BY emp.e_lname ASC";
            $ss_result = mysql_query($ss_query) or die(mysql_error());

            $pl_query = "SELECT emp.e_title, emp.e_fname, emp.e_mname, emp.e_lname, el.loan_code, el.loan_principal, el.loan_release_date, el.loan_remarks, elt.loan_type 
                FROM employee AS emp JOIN employee_loan AS el ON el.e_no = emp.e_no 
                JOIN employee_loan_schedule AS els ON els.loan_code=el.loan_code 
                JOIN employee_loan_type AS elt ON el.loan_type = elt.loan_type_code 
                WHERE els.loan_balance = 0 and els.loan_payment_status = 2 AND el.loan_type = 'PL' ORDER BY emp.e_lname ASC";
            $pl_result = mysql_query($pl_query) or die(mysql_error());
        }
    } else {
        $sl_query = "SELECT emp.e_title, emp.e_fname, emp.e_mname, emp.e_lname, el.loan_code, el.loan_principal, el.loan_release_date, el.loan_remarks, elt.loan_type 
                FROM employee AS emp JOIN employee_loan AS el ON el.e_no = emp.e_no 
                JOIN employee_loan_schedule AS els ON els.loan_code=el.loan_code 
                JOIN employee_loan_type AS elt ON el.loan_type = elt.loan_type_code 
                WHERE els.loan_balance = 0 and els.loan_payment_status = 2 AND el.loan_type = 'SL' ORDER BY emp.e_lname ASC";
        $sl_result = mysql_query($sl_query) or die(mysql_error());

        $ss_query = "SELECT emp.e_title, emp.e_fname, emp.e_mname, emp.e_lname, el.loan_code, el.loan_principal, el.loan_release_date, el.loan_remarks, elt.loan_type 
                FROM employee AS emp JOIN employee_loan AS el ON el.e_no = emp.e_no 
                JOIN employee_loan_schedule AS els ON els.loan_code=el.loan_code 
                JOIN employee_loan_type AS elt ON el.loan_type = elt.loan_type_code 
                WHERE els.loan_balance = 0 and els.loan_payment_status = 2 AND el.loan_type = 'SS' ORDER BY emp.e_lname ASC";
        $ss_result = mysql_query($ss_query) or die(mysql_error());

        $pl_query = "SELECT emp.e_title, emp.e_fname, emp.e_mname, emp.e_lname, el.loan_code, el.loan_principal, el.loan_release_date, el.loan_remarks, elt.loan_type 
                FROM employee AS emp JOIN employee_loan AS el ON el.e_no = emp.e_no 
                JOIN employee_loan_schedule AS els ON els.loan_code=el.loan_code 
                JOIN employee_loan_type AS elt ON el.loan_type = elt.loan_type_code 
                WHERE els.loan_balance = 0 and els.loan_payment_status = 2 AND el.loan_type = 'PL' ORDER BY emp.e_lname ASC";
        $pl_result = mysql_query($pl_query) or die(mysql_error());
    }
} elseif (isset($_GET['special'])) {
    $full_loan = 1;
    $monthly_loan = 0;
    $hold = 0;
    $unhold = 0;

    if (isset($_POST['company-submit'])) {
        $company = $_POST['set-comp'];
        if ($company != 'ALL') {
            $sl_query = "SELECT emp.e_title, emp.e_fname, emp.e_mname, emp.e_lname, el.loan_code, el.loan_principal, el.loan_release_date, el.loan_remarks, elt.loan_type 
                FROM employee AS emp JOIN employee_loan AS el ON el.e_no = emp.e_no 
                JOIN employee_loan_schedule AS els ON els.loan_code=el.loan_code 
                JOIN employee_loan_type AS elt ON el.loan_type = elt.loan_type_code 
                WHERE els.loan_balance = 0 and els.loan_payment_status = 3 AND emp.e_company = '$company' AND el.loan_type = 'SL' ORDER BY emp.e_lname ASC";
            $sl_result = mysql_query($sl_query) or die(mysql_error());

            $ss_query = "SELECT emp.e_title, emp.e_fname, emp.e_mname, emp.e_lname, el.loan_code, el.loan_principal, el.loan_release_date, el.loan_remarks, elt.loan_type 
                FROM employee AS emp JOIN employee_loan AS el ON el.e_no = emp.e_no 
                JOIN employee_loan_schedule AS els ON els.loan_code=el.loan_code 
                JOIN employee_loan_type AS elt ON el.loan_type = elt.loan_type_code 
                WHERE els.loan_balance = 0 and els.loan_payment_status = 3 AND emp.e_company = '$company' AND el.loan_type = 'SS' ORDER BY emp.e_lname ASC";
            $ss_result = mysql_query($ss_query) or die(mysql_error());

            $pl_query = "SELECT emp.e_title, emp.e_fname, emp.e_mname, emp.e_lname, el.loan_code, el.loan_principal, el.loan_release_date, el.loan_remarks, elt.loan_type 
                FROM employee AS emp JOIN employee_loan AS el ON el.e_no = emp.e_no 
                JOIN employee_loan_schedule AS els ON els.loan_code=el.loan_code 
                JOIN employee_loan_type AS elt ON el.loan_type = elt.loan_type_code 
                WHERE els.loan_balance = 0 and els.loan_payment_status = 3 AND emp.e_company = '$company' AND el.loan_type = 'PL' ORDER BY emp.e_lname ASC";
            $pl_result = mysql_query($pl_query) or die(mysql_error());
        } else {
            $sl_query = "SELECT emp.e_title, emp.e_fname, emp.e_mname, emp.e_lname, el.loan_code, el.loan_principal, el.loan_release_date, el.loan_remarks, elt.loan_type 
                FROM employee AS emp JOIN employee_loan AS el ON el.e_no = emp.e_no 
                JOIN employee_loan_schedule AS els ON els.loan_code=el.loan_code 
                JOIN employee_loan_type AS elt ON el.loan_type = elt.loan_type_code 
                WHERE els.loan_balance = 0 and els.loan_payment_status = 3 AND el.loan_type = 'SL' ORDER BY emp.e_lname ASC";
            $sl_result = mysql_query($sl_query) or die(mysql_error());

            $ss_query = "SELECT emp.e_title, emp.e_fname, emp.e_mname, emp.e_lname, el.loan_code, el.loan_principal, el.loan_release_date, el.loan_remarks, elt.loan_type 
                FROM employee AS emp JOIN employee_loan AS el ON el.e_no = emp.e_no 
                JOIN employee_loan_schedule AS els ON els.loan_code=el.loan_code 
                JOIN employee_loan_type AS elt ON el.loan_type = elt.loan_type_code 
                WHERE els.loan_balance = 0 and els.loan_payment_status = 3 AND el.loan_type = 'SS' ORDER BY emp.e_lname ASC";
            $ss_result = mysql_query($ss_query) or die(mysql_error());

            $pl_query = "SELECT emp.e_title, emp.e_fname, emp.e_mname, emp.e_lname, el.loan_code, el.loan_principal, el.loan_release_date, el.loan_remarks, elt.loan_type 
                FROM employee AS emp JOIN employee_loan AS el ON el.e_no = emp.e_no 
                JOIN employee_loan_schedule AS els ON els.loan_code=el.loan_code 
                JOIN employee_loan_type AS elt ON el.loan_type = elt.loan_type_code 
                WHERE els.loan_balance = 0 and els.loan_payment_status = 3 AND el.loan_type = 'PL' ORDER BY emp.e_lname ASC";
            $pl_result = mysql_query($pl_query) or die(mysql_error());
        }
    } else {
        $sl_query = "SELECT emp.e_title, emp.e_fname, emp.e_mname, emp.e_lname, el.loan_code, el.loan_principal, el.loan_release_date, el.loan_remarks, elt.loan_type 
            FROM employee AS emp JOIN employee_loan AS el ON el.e_no = emp.e_no 
            JOIN employee_loan_schedule AS els ON els.loan_code=el.loan_code 
            JOIN employee_loan_type AS elt ON el.loan_type = elt.loan_type_code 
            WHERE els.loan_balance = 0 and els.loan_payment_status = 3 AND el.loan_type = 'SL' ORDER BY emp.e_lname ASC";
        $sl_result = mysql_query($sl_query) or die(mysql_error());

        $ss_query = "SELECT emp.e_title, emp.e_fname, emp.e_mname, emp.e_lname, el.loan_code, el.loan_principal, el.loan_release_date, el.loan_remarks, elt.loan_type 
            FROM employee AS emp JOIN employee_loan AS el ON el.e_no = emp.e_no 
            JOIN employee_loan_schedule AS els ON els.loan_code=el.loan_code 
            JOIN employee_loan_type AS elt ON el.loan_type = elt.loan_type_code 
            WHERE els.loan_balance = 0 and els.loan_payment_status = 3 AND el.loan_type = 'SS' ORDER BY emp.e_lname ASC";
        $ss_result = mysql_query($ss_query) or die(mysql_error());

        $pl_query = "SELECT emp.e_title, emp.e_fname, emp.e_mname, emp.e_lname, el.loan_code, el.loan_principal, el.loan_release_date, el.loan_remarks, elt.loan_type 
            FROM employee AS emp JOIN employee_loan AS el ON el.e_no = emp.e_no 
            JOIN employee_loan_schedule AS els ON els.loan_code=el.loan_code 
            JOIN employee_loan_type AS elt ON el.loan_type = elt.loan_type_code 
            WHERE els.loan_balance = 0 and els.loan_payment_status = 3 AND el.loan_type = 'PL' ORDER BY emp.e_lname ASC";
        $pl_result = mysql_query($pl_query) or die(mysql_error());
    }
} elseif (isset($_GET['monthly'])) {
    $full_loan = 0;
    $monthly_loan = 1;
}


if (isset($_POST['tohold'])) {
    $l_code = $_POST['l_code'];
    $hold_query = "UPDATE employee_loan_schedule SET loan_payment_status=2 WHERE loan_code='$l_code' AND loan_payment_status = 0";
    mysql_query($hold_query) or die(mysql_error());
    echo "<meta http-equiv='refresh' content='0'>";
} elseif (isset($_POST['release'])) {
    $date_d = 26;
    $date_m = date("m");
    $date_y = date("Y");
    $l_code = $_POST['l_code'];
    $loan_ID = array();
    $select_id = "SELECT * FROM employee_loan_schedule WHERE loan_code='$l_code' AND loan_payment_status=2";
    $select_id_result = mysql_query($select_id) or die(mysql_error());

    while ($select_id_row = mysql_fetch_assoc($select_id_result)) {
        array_push($loan_ID, $select_id_row['transaction_ID']);
    }

    foreach ($loan_ID as $id) {
        if ($date_d < 15) {
            $cutoff_date = $date_y . "-" . $date_m . "-11";
            $date_d = 24;
        } elseif ($date_d < 25) {
            $cutoff_date = $date_y . "-" . $date_m . "-26";
            $date_d = 11;
            $date_m += 1;
            if ($date_m > 12) {
                $date_m = 1;
                $date_y += 1;
            }
        } elseif ($date_d > 24) {
            $date_m += 1;
            if ($date_m > 12) {
                $date_m = 1;
                $date_y += 1;
            }
            $date_d = 24;
            $cutoff_date = $date_y . "-" . $date_m . "-11";
            echo '<br />';
        }


        $release_query = "UPDATE employee_loan_schedule SET loan_payment_status=0, loan_date_payment = '$cutoff_date' WHERE transaction_ID=$id AND loan_payment_status = 2";
        mysql_query($release_query) or die(mysql_error());
        echo "<meta http-equiv='refresh' content='0'>";
    }
}

if (isset($_POST['set-month'])) {
    $set_month = $_POST['month'];
    $set_year = $_POST['year'];
    $set_comp = $_POST['company'];
    $full_loan = 0;
    $monthly_loan = 1;
    $selected_date = $set_year . "-" . $set_month . "-1";
    $cutoff_first = $set_year . "-" . $set_month . "-11";
    $cutoff_second = $set_year . "-" . $set_month . "-26";
    $sl_mon_loans = "SELECT emp.e_fname, emp.e_mname, emp.e_lname, els.loan_code 
        FROM employee AS emp JOIN employee_loan AS el ON emp.e_no = el.e_no
        JOIN employee_loan_schedule AS els ON el.loan_code = els.loan_code 
        WHERE els.loan_date_payment >= '$cutoff_first' AND els.loan_code LIKE '%SL%' AND els.loan_date_payment <= '$cutoff_second' AND (els.loan_payment_status = 1 OR els.loan_payment_status = 0) AND emp.e_company = '$set_comp' GROUP BY els.loan_code ORDER BY emp.e_lname";
    $sl_mon_query_loans = mysql_query($sl_mon_loans) or die(mysql_error());

    $ss_mon_loans = "SELECT emp.e_fname, emp.e_mname, emp.e_lname, els.loan_code 
    FROM employee AS emp JOIN employee_loan AS el ON emp.e_no = el.e_no
    JOIN employee_loan_schedule AS els ON el.loan_code = els.loan_code 
    WHERE els.loan_date_payment >= '$cutoff_first' AND els.loan_code LIKE '%SS%' AND els.loan_date_payment <= '$cutoff_second' AND (els.loan_payment_status = 1 OR els.loan_payment_status = 0) AND emp.e_company = '$set_comp' GROUP BY els.loan_code ORDER BY emp.e_lname";
    $ss_mon_query_loans = mysql_query($ss_mon_loans) or die(mysql_error());

    $pl_mon_loans = "SELECT emp.e_fname, emp.e_mname, emp.e_lname, els.loan_code 
    FROM employee AS emp JOIN employee_loan AS el ON emp.e_no = el.e_no
    JOIN employee_loan_schedule AS els ON el.loan_code = els.loan_code 
    WHERE els.loan_date_payment >= '$cutoff_first' AND els.loan_code LIKE '%PL%' AND els.loan_date_payment <= '$cutoff_second' AND (els.loan_payment_status = 1 OR els.loan_payment_status = 0) AND emp.e_company = '$set_comp' GROUP BY els.loan_code ORDER BY emp.e_lname";
    $pl_mon_query_loans = mysql_query($pl_mon_loans) or die(mysql_error());
} elseif (isset($_POST['print'])) {
    $set_month = $_POST['month'];
    $set_year = $_POST['year'];
    $set_comp = $_POST['company'];
    header("location: script_loan_print.php?month=$set_month&year=$set_year&company=$set_comp&print=1");
}

?>


<html>

<head>
    <link type="text/css" rel="stylesheet" href="css/loan_all_style.css" />
    <link type="text/css" rel="stylesheet" href="css/font-awesome.min.css" />
</head>

<body>
    <div>
        <div class="comp">
            <?php if ($full_loan === 1) : ?>
                <form method="POST" action="<?php echo $_SERVER['REQUEST_URI'] ?>">
                    <label>Company: </label>
                    <select name="set-comp">
                        <option value="ALL">ALL</option>
                        <?php while ($company_row = mysql_fetch_assoc($company_result)) : ?>
                            <option value="<?php echo $company_row['company'] ?>" <?php if ($company == $company_row['company']) {
                                                                                                echo 'selected';
                                                                                            } ?>><?php echo $company_row['company_name'] ?></option>
                        <?php endwhile; ?>
                    </select>
                    <input type="submit" name="company-submit" value="Set" />
                </form>
                <form target="_blank" action="../alc-companion-module/loan-feature.php">
                    <input type="submit" value="New Loans" />
                </form>
            <?php endif; ?>
        </div>

        <!-- TABLE TO SHOW -->
        <div class="header">
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="GET">
                <button name="active" value='1'>Active Loans</button>
                <button name="paid" value='1'>Paid Loans</button>
                <button name="hold" value='1'>Loans on hold</button>
                <button name="special" value='1'>Special Cases</button>
                <button name="monthly" value='1'>Monthly Report</button>
            </form>
        </div>

        <?php if ($full_loan === 1) : ?>
            <div id="salary-loan">
                <div class="month-header">SALARY LOAN</div>
                <div class="data-table">

                    <table>
                        <thead>
                            <tr>
                                <th></th>
                                <th>Employee</th>
				<th>Loan Code</th>
                                <th>Release Date</th>
                                <th>Loan Principal Amount</th>
                                <th>Loan Interest Amount</th>
                                <th>Loan Total</th>
                                <th>Paid Principal</th>
                                <th>Paid Interest</th>
                                <th>Total Amount Paid</th>
                                <th>Remaining Principal</th>
                                <th>Remaining Interest</th>
                                <th>Cleared</th>
                                <th>Total Remaining</th>
                                <th>Remaining Month/s</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (mysql_num_rows($sl_result) > 0) : ?>
                                <?php while ($sl_row = mysql_fetch_assoc($sl_result)) :
                                            $sl_employee_name = $sl_row['e_lname'] . ", " . $sl_row['e_fname'] . " " . $sl_row['e_mname'][0] . ".";
                                            $sl_release_date = $sl_row['loan_release_date'];
                                            $sl_loan_code = $sl_row['loan_code'];
                                            ?>
                                    <tr>
                                        <td>
                                            <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                                                <?php if ($hold === 1) : ?>


                                                    <?php if ($access['b3'] == 1) { ?><button name="tohold"><i class="fa fa-ban">Hold</i></button><?php } ?>
                                                    <input type="hidden" name="l_code" value="<?php echo $sl_loan_code ?>">
                                                <?php elseif ($unhold === 1) : ?>

                                                    <?php if ($access['b3'] == 1) { ?><button style="color: green" name="release"><i class="fa fa-circle">Release</i></button><?php } ?>
                                                    <input type="hidden" name="l_code" value="<?php echo $sl_loan_code ?>">
                                                <?php endif; ?>
                                            </form>
                                        </td>
                                        <td><a href="script_loan_schedule.php?tcode=<?php echo $sl_loan_code ?>&em_name=<?php echo $sl_employee_name ?>" target="_blank"><?php echo $sl_employee_name ?></a></td>
					<td><?php echo $sl_loan_code; ?></td>
                                        <td>

                                            <?php echo $sl_release_date ?>

                                        </td>
                                        <?php
                                                    //SELECT EMPLOYEE LOAN
                                                    $select_emp_loan_sl = "SELECT * FROM employee_loan WHERE loan_code = '$sl_loan_code'";
                                                    $query_emp_loan_sl = mysql_query($select_emp_loan_sl) or die(mysql_error());
                                                    $result_emp_loan_sl = mysql_fetch_assoc($query_emp_loan_sl);

                                                    //GET PAID AMOUNT
                                                    $select_emp_paid_sl = "SELECT SUM(loan_principal_payment) AS paid_principal, SUM(loan_interest_payment) AS paid_interest, SUM(loan_payment) AS paid_total 
                                                                            FROM employee_loan_schedule WHERE loan_code = '$sl_loan_code' AND loan_payment_status = 1";
                                                    $query_emp_paid_sl = mysql_query($select_emp_paid_sl) or die(mysql_error());
                                                    $result_emp_paid_sl = mysql_fetch_assoc($query_emp_paid_sl);

                                                    //GET REMAINING
                                                    $select_emp_rem_sl = "SELECT SUM(loan_principal_payment) AS rem_principal, SUM(loan_interest_payment) AS rem_interest, SUM(loan_payment) AS rem_total 
                                                                            FROM employee_loan_schedule WHERE loan_code = '$sl_loan_code' AND loan_payment_status = 0";
                                                    $query_emp_rem_sl = mysql_query($select_emp_rem_sl) or die(mysql_error());
                                                    $result_emp_rem_sl = mysql_fetch_assoc($query_emp_rem_sl);

                                                    //GET CLEARED AMOUNT
                                                    $select_emp_cleared_sl = "SELECT SUM(loan_payment) AS cleared_amount
                                                                            FROM employee_loan_schedule WHERE loan_code = '$sl_loan_code' AND loan_payment_status = 3";
                                                    $query_emp_cleared_sl = mysql_query($select_emp_cleared_sl) or die(mysql_error());
                                                    $result_emp_cleared_sl = mysql_fetch_assoc($query_emp_cleared_sl);

                                                    //GET MONTHS REMAINING
                                                    $select_emp_mon_sl = "SELECT * FROM employee_loan_schedule WHERE loan_code = '$sl_loan_code' AND loan_payment_status = 0";
                                                    $query_emp_mon_sl = mysql_query($select_emp_mon_sl) or die(mysql_error());

                                                    ?>
                                        <td><?php echo number_format($lp_sl = $result_emp_loan_sl['loan_amount'], 2) ?></td>
                                        <td><?php echo number_format($li_sl = $result_emp_loan_sl['loan_interest_amount'], 2) ?></td>
                                        <td><?php echo number_format($lt_sl = $result_emp_loan_sl['loan_principal'], 2) ?></td>
                                        <td><?php echo number_format($pp_sl = $result_emp_paid_sl['paid_principal'], 2) ?></td>
                                        <td><?php echo number_format($pi_sl = $result_emp_paid_sl['paid_interest'], 2) ?></td>
                                        <td><?php echo number_format($pt_sl = $result_emp_paid_sl['paid_total'], 2) ?></td>
                                        <td><?php echo number_format($rp_sl = $result_emp_rem_sl['rem_principal'], 2); ?></td>
                                        <td><?php echo number_format($ri_sl = $result_emp_rem_sl['rem_interest'], 2); ?></td>
                                        <td><?php echo number_format($result_emp_cleared_sl['cleared_amount'], 2); ?></td>
                                        <td><?php echo number_format($tr_sl = $result_emp_rem_sl['rem_total'], 2); ?></td>
                                        <td>
                                            <?php
                                                        $rem_years_sl = 0;
                                                        $rem_month_sl = mysql_num_rows($query_emp_mon_sl) / 2;
                                                        if ($rem_month_sl >= 12) {
                                                            while ($rem_month_sl >= 12) {
                                                                $rem_years_sl++;
                                                                $rem_month_sl -= 12;
                                                            }
                                                        }
                                                        if ($rem_years_sl === 0) {
                                                            echo $rem_month_sl . " month/s";
                                                        } else {
                                                            echo $rem_years_sl . " year/s " . $rem_month_sl . " month/s";
                                                        }


                                                        ?>
                                        </td>
                                        <?php
                                                    $total_loan_principal_sl += $lp_sl;
                                                    $total_loan_interest_sl += $li_sl;
                                                    $total_loan_sl += $lt_sl;
                                                    $total_paid_principal_sl += $pp_sl;
                                                    $total_paid_interest_sl += $pi_sl;
                                                    $total_paid_sl += $pt_sl;
                                                    $total_rem_principal_sl += $rp_sl;
                                                    $total_rem_interest_sl += $ri_sl;
                                                    $total_rem_amount_sl += $tr_sl;
                                                    ?>
                                    </tr>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </tbody>


                    </table>

                    <div class="summary">
                        <div class="month-header">Summary</div>
                        <div class="flex">
                            <div class="data-half flex">
                                <div class="monthly-titles">
                                    <div>Total Loan Principal Amount</div>
                                    <div class="dashed">Total Loan Interest Amount</div>
                                    <div class="total-loan">Total Amount</div>
                                    <div>Total Paid Principal Amount</div>
                                    <div class="dashed">Total Paid Interest</div>
                                    <div class="total-paid">Total Amount</div>
                                </div>
                                <div class="data-total">
                                    <div><?php echo "PHP " . number_format($total_loan_principal_sl, 2) ?></div>
                                    <div class="dashed"><?php echo "PHP " . number_format($total_loan_interest_sl, 2) ?></div>
                                    <div class="total-loan"><?php echo "PHP " . number_format($total_loan_sl, 2) ?></div>
                                    <div><?php echo "PHP " . number_format($total_paid_principal_sl, 2) ?></div>
                                    <div class="dashed"><?php echo "PHP " . number_format($total_paid_interest_sl, 2) ?></div>
                                    <div class="total-paid"><?php echo "PHP " . number_format($total_paid_sl, 2) ?></div>
                                </div>
                            </div>

                            <div class="data-half flex">
                                <div class="monthly-titles">
                                    <div>Total Remaining Principal Amount</div>
                                    <div class="dashed">Total Remaining Interest Amount</div>
                                    <div class="total-remaining">Total Amount</div>
                                </div>
                                <div class="data-total">
                                    <div><?php echo "PHP " . number_format($total_rem_principal_sl, 2) ?></div>
                                    <div class="dashed"><?php echo "PHP " . number_format($total_rem_interest_sl, 2) ?></div>
                                    <div class="total-remaining"><?php echo "PHP " . number_format($total_rem_amount_sl, 2) ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                </div>

                <div id="sss-loan">
                    <div class="month-header">SSS LOAN</div>

                    <table>
                        <thead>
                            <tr>
                                <th></th>
                                <th>Employee</th>
<th>Loan Code</th>
                                <th>Release Date</th>
                                <th>Loan Principal Amount</th>
                                <th>Loan Interest Amount</th>
                                <th>Loan Total</th>
                                <th>Paid Principal</th>
                                <th>Paid Interest</th>
                                <th>Total Amount Paid</th>
                                <th>Remaining Principal</th>
                                <th>Remaining Interest</th>
                                <th>Total Remaining</th>
                                <th>Remaining Month/s</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (mysql_num_rows($ss_result) > 0) : ?>
                                <?php while ($ss_row = mysql_fetch_assoc($ss_result)) :
                                            $ss_employee_name = $ss_row['e_lname'] . ", " . $ss_row['e_fname'] . " " . $ss_row['e_mname'][0] . ".";
                                            $ss_release_date = $ss_row['loan_release_date'];
                                            $ss_loan_code = $ss_row['loan_code'];
                                            ?>
                                    <tr>
                                        <td>
                                            <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                                                <?php if ($hold === 1) : ?>


                                                    <?php if ($access['b3'] == 1) { ?><button name="tohold"><i class="fa fa-ban">Hold</i></button><?php } ?>
                                                    <input type="hidden" name="l_code" value="<?php echo $ss_loan_code ?>">
                                                <?php elseif ($unhold === 1) : ?>

                                                    <?php if ($access['b3'] == 1) { ?><button style="color: green" name="release"><i class="fa fa-circle">Release</i></button><?php } ?>
                                                    <input type="hidden" name="l_code" value="<?php echo $ss_loan_code ?>">
                                                <?php endif; ?>
                                            </form>

                                        </td>
                                        <td><a href="script_loan_schedule.php?loan-code=<?php echo $ss_loan_code ?>&em_name=<?php echo $ss_employee_name ?>" target="_blank"><?php echo $ss_employee_name ?></a></td>
<td><?php echo $ss_loan_code; ?></td>
                                        <td>
                                                <?php echo $ss_release_date ?>
                                        </td>
                                        <?php
                                                    //SELECT EMPLOYEE LOAN
                                                    $select_emp_loan_ss = "SELECT * FROM employee_loan WHERE loan_code = '$ss_loan_code'";
                                                    $query_emp_loan_ss = mysql_query($select_emp_loan_ss) or die(mysql_error());
                                                    $result_emp_loan_ss = mysql_fetch_assoc($query_emp_loan_ss);

                                                    //GET PAID AMOUNT
                                                    $select_emp_paid_ss = "SELECT SUM(loan_principal_payment) AS paid_principal, SUM(loan_interest_payment) AS paid_interest, SUM(loan_payment) AS paid_total 
                                                         FROM employee_loan_schedule WHERE loan_code = '$ss_loan_code' AND loan_payment_status = 1";
                                                    $query_emp_paid_ss = mysql_query($select_emp_paid_ss) or die(mysql_error());
                                                    $result_emp_paid_ss = mysql_fetch_assoc($query_emp_paid_ss);

                                                    //GET REMAINING
                                                    $select_emp_rem_ss = "SELECT SUM(loan_principal_payment) AS rem_principal, SUM(loan_interest_payment) AS rem_interest, SUM(loan_payment) AS rem_total 
                                                        FROM employee_loan_schedule WHERE loan_code = '$ss_loan_code' AND loan_payment_status = 0";
                                                    $query_emp_rem_ss = mysql_query($select_emp_rem_ss) or die(mysql_error());
                                                    $result_emp_rem_ss = mysql_fetch_assoc($query_emp_rem_ss);

                                                    //GET MONTHS REMAINING
                                                    $select_emp_mon_ss = "SELECT * FROM employee_loan_schedule WHERE loan_code = '$ss_loan_code' AND loan_payment_status = 0";
                                                    $query_emp_mon_ss = mysql_query($select_emp_mon_ss) or die(mysql_error());

                                                    ?>
                                        <td><?php echo number_format($lp_ss = $result_emp_loan_ss['loan_amount'], 2) ?></td>
                                        <td><?php echo number_format($li_ss = $result_emp_loan_ss['loan_interest_amount'], 2) ?></td>
                                        <td><?php echo number_format($lt_ss = $result_emp_loan_ss['loan_principal'], 2) ?></td>
                                        <td><?php echo number_format($pp_ss = $result_emp_paid_ss['paid_principal'], 2) ?></td>
                                        <td><?php echo number_format($pi_ss = $result_emp_paid_ss['paid_interest'], 2) ?></td>
                                        <td><?php echo number_format($pt_ss = $result_emp_paid_ss['paid_total'], 2) ?></td>
                                        <td><?php echo number_format($rp_ss = $result_emp_rem_ss['rem_principal'], 2); ?></td>
                                        <td><?php echo number_format($ri_ss = $result_emp_rem_ss['rem_interest'], 2); ?></td>
                                        <td><?php echo number_format($tr_ss = $result_emp_rem_ss['rem_total'], 2); ?></td>
                                        <td>
                                            <?php
                                                        $rem_years_ss = 0;
                                                        $rem_month_ss = mysql_num_rows($query_emp_mon_ss) / 2;
                                                        if ($rem_month_ss >= 12) {
                                                            while ($rem_month_ss >= 12) {
                                                                $rem_years_ss++;
                                                                $rem_month_ss -= 12;
                                                            }
                                                        }
                                                        if ($rem_years_ss === 0) {
                                                            echo $rem_month_ss . " month/s";
                                                        } else {
                                                            echo $rem_years_ss . " year/s " . $rem_month_ss . " month/s";
                                                        }
                                                        ?>
                                        </td>
                                        <?php
                                                    $total_loan_principal_ss += $lp_ss;
                                                    $total_loan_interest_ss += $li_ss;
                                                    $total_loan_ss += $lt_ss;
                                                    $total_paid_principal_ss += $pp_ss;
                                                    $total_paid_interest_ss += $pi_ss;
                                                    $total_paid_ss += $pt_ss;
                                                    $total_rem_principal_ss += $rp_ss;
                                                    $total_rem_interest_ss += $ri_ss;
                                                    $total_rem_amount_ss += $tr_ss;
                                                    ?>
                                    </tr>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>

                    <div class="summary">
                        <div class="month-header">Summary</div>
                        <div class="flex">
                            <div class="data-half flex">
                                <div class="monthly-titles">
                                    <div>Total Loan Principal Amount</div>
                                    <div class="dashed">Total Loan Interest Amount</div>
                                    <div class="total-loan">Total Amount</div>
                                    <div>Total Paid Principal Amount</div>
                                    <div class="dashed">Total Paid Interest</div>
                                    <div class="total-paid">Total Amount</div>
                                </div>
                                <div class="data-total">
                                    <div><?php echo "PHP " . number_format($total_loan_principal_ss, 2) ?></div>
                                    <div class="dashed"><?php echo "PHP " . number_format($total_loan_interest_ss, 2) ?></div>
                                    <div class="total-loan"><?php echo "PHP " . number_format($total_loan_ss, 2) ?></div>
                                    <div><?php echo "PHP " . number_format($total_paid_principal_ss, 2) ?></div>
                                    <div class="dashed"><?php echo "PHP " . number_format($total_paid_interest_ss, 2) ?></div>
                                    <div class="total-paid"><?php echo "PHP " . number_format($total_paid_ss, 2) ?></div>
                                </div>
                            </div>

                            <div class="data-half flex">
                                <div class="monthly-titles">
                                    <div>Total Remaining Principal Amount</div>
                                    <div class="dashed">Total Remaining Interest Amount</div>
                                    <div class="total-remaining">Total Amount</div>
                                </div>
                                <div class="data-total">
                                    <div><?php echo "PHP " . number_format($total_rem_principal_ss, 2) ?></div>
                                    <div class="dashed"><?php echo "PHP " . number_format($total_rem_interest_ss, 2) ?></div>
                                    <div class="total-remaining"><?php echo "PHP " . number_format($total_rem_amount_ss, 2) ?></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                    </div>

                    <div id="pagibig-loan">
                        <div class="month-header">PAG-IBIG LOAN</div>

                        <table>
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Employee</th>
					<th>Loan Code</th>
                                    <th>Release Date</th>
                                    <th>Loan Principal Amount</th>
                                    <th>Loan Interest Amount</th>
                                    <th>Loan Total</th>
                                    <th>Paid Principal</th>
                                    <th>Paid Interest</th>
                                    <th>Total Amount Paid</th>
                                    <th>Remaining Principal</th>
                                    <th>Remaining Interest</th>
                                    <th>Total Remaining</th>
                                    <th>Remaining Month/s</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php if (mysql_num_rows($pl_result) > 0) : ?>
                                    <?php while ($pl_row = mysql_fetch_assoc($pl_result)) : ?>
                                        <?php
                                                    $pl_employee_name = $pl_row['e_lname'] . ", " . $pl_row['e_fname'] . " " . $pl_row['e_mname'][0] . ".";
                                                    $pl_release_date = $pl_row['loan_release_date'];
                                                    $pl_loan_code = $pl_row['loan_code'];
                                                    ?>
                                        <tr>
                                            <td>
                                                <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                                                    <?php if ($hold === 1) : ?>
                                                        <?php if ($access['b3'] == 1) { ?><button name="tohold"><i class="fa fa-ban">Hold</i></button><?php } ?>
                                                        <input type="hidden" name="l_code" value="<?php echo $pl_loan_code ?>">
                                                    <?php elseif ($unhold === 1) : ?>

                                                        <?php if ($access['b3'] == 1) { ?><button style="color: green" name="release"><i class="fa fa-circle">Release</i></button><?php } ?>
                                                        <input type="hidden" name="l_code" value="<?php echo $pl_loan_code ?>">
                                                    <?php endif; ?>
                                                </form>

                                            </td>
                                            <td><a href="script_loan_schedule.php?loan-code=<?php echo $pl_loan_code ?>&em_name=<?php echo $pl_employee_name ?>" target="_blank"><?php echo $pl_employee_name ?></a></td>
<td><?php echo $pl_loan_code; ?></td>
                                            <td>
                                                    <?php echo $pl_release_date ?>
                                            </td>
                                            <?php
                                                        //SELECT EMPLOYEE LOAN
                                                        $select_emp_loan_pl = "SELECT * FROM employee_loan WHERE loan_code = '$pl_loan_code'";
                                                        $query_emp_loan_pl = mysql_query($select_emp_loan_pl) or die(mysql_error());
                                                        $result_emp_loan_pl = mysql_fetch_assoc($query_emp_loan_pl);

                                                        //GET PAID AMOUNT
                                                        $select_emp_paid_pl = "SELECT SUM(loan_principal_payment) AS paid_principal, SUM(loan_interest_payment) AS paid_interest, SUM(loan_payment) AS paid_total 
                                                        FROM employee_loan_schedule WHERE loan_code = '$pl_loan_code' AND loan_payment_status = 1";
                                                        $query_emp_paid_pl = mysql_query($select_emp_paid_pl) or die(mysql_error());
                                                        $result_emp_paid_pl = mysql_fetch_assoc($query_emp_paid_pl);

                                                        //GET REMAINING
                                                        $select_emp_rem_pl = "SELECT SUM(loan_principal_payment) AS rem_principal, SUM(loan_interest_payment) AS rem_interest, SUM(loan_payment) AS rem_total 
                                                        FROM employee_loan_schedule WHERE loan_code = '$pl_loan_code' AND loan_payment_status = 0";
                                                        $query_emp_rem_pl = mysql_query($select_emp_rem_pl) or die(mysql_error());
                                                        $result_emp_rem_pl = mysql_fetch_assoc($query_emp_rem_pl);

                                                        //GET MONTHS REMAINING
                                                        $select_emp_mon_pl = "SELECT * FROM employee_loan_schedule WHERE loan_code = '$pl_loan_code' AND loan_payment_status = 0";
                                                        $query_emp_mon_pl = mysql_query($select_emp_mon_pl) or die(mysql_error());


                                                        ?>
                                            <td><?php echo number_format($lp_pl = $result_emp_loan_pl['loan_amount'], 2) ?></td>
                                            <td><?php echo number_format($li_pl = $result_emp_loan_pl['loan_interest_amount'], 2) ?></td>
                                            <td><?php echo number_format($lt_pl = $result_emp_loan_pl['loan_principal'], 2) ?></td>
                                            <td><?php echo number_format($pp_pl = $result_emp_paid_pl['paid_principal'], 2) ?></td>
                                            <td><?php echo number_format($pi_ss = $result_emp_paid_pl['paid_interest'], 2) ?></td>
                                            <td><?php echo number_format($pt_ss = $result_emp_paid_pl['paid_total'], 2) ?></td>
                                            <td><?php echo number_format($rp_ss = $result_emp_rem_pl['rem_principal'], 2); ?></td>
                                            <td><?php echo number_format($ri_ss = $result_emp_rem_pl['rem_interest'], 2); ?></td>
                                            <td><?php echo number_format($tr_ss = $result_emp_rem_pl['rem_total'], 2); ?></td>
                                            <td>
                                                <?php
                                                            $rem_years_pl = 0;
                                                            $rem_month_pl = mysql_num_rows($query_emp_mon_pl) / 2;
                                                            if ($rem_month_pl >= 12) {
                                                                while ($rem_month_pl >= 12) {
                                                                    $rem_years_pl++;
                                                                    $rem_month_pl -= 12;
                                                                }
                                                            }
                                                            if ($rem_years_pl === 0) {
                                                                echo $rem_month_pl . " month/s";
                                                            } else {
                                                                echo $rem_years_pl . " year/s " . $rem_month_pl . " month/s";
                                                            }
                                                            ?>
                                            </td>
                                            <?php
                                                        $total_loan_principal_pl += $lp_pl;
                                                        $total_loan_interest_pl += $li_pl;
                                                        $total_loan_pl += $lt_pl;
                                                        $total_paid_principal_pl += $pp_pl;
                                                        $total_paid_interest_pl += $pi_pl;
                                                        $total_paid_pl += $pt_pl;
                                                        $total_rem_principal_pl += $rp_pl;
                                                        $total_rem_interest_pl += $ri_pl;
                                                        $total_rem_amount_pl += $tr_pl;
                                                        ?>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>

                        <div class="summary">
                            <div class="month-header">Summary</div>
                            <div class="flex">
                                <div class="data-half flex">
                                    <div class="monthly-titles">
                                        <div>Total Loan Principal Amount</div>
                                        <div class="dashed">Total Loan Interest Amount</div>
                                        <div class="total-loan">Total Amount</div>
                                        <div>Total Paid Principal Amount</div>
                                        <div class="dashed">Total Paid Interest</div>
                                        <div class="total-paid">Total Amount</div>
                                    </div>
                                    <div class="data-total">
                                        <div><?php echo "PHP " . number_format($total_loan_principal_pl, 2) ?></div>
                                        <div class="dashed"><?php echo "PHP " . number_format($total_loan_interest_pl, 2) ?></div>
                                        <div class="total-loan"><?php echo "PHP " . number_format($total_loan_pl, 2) ?></div>
                                        <div><?php echo "PHP " . number_format($total_paid_principal_pl, 2) ?></div>
                                        <div class="dashed"><?php echo "PHP " . number_format($total_paid_interest_pl, 2) ?></div>
                                        <div class="total-paid"><?php echo "PHP " . number_format($total_paid_pl, 2) ?></div>
                                    </div>
                                </div>

                                <div class="data-half flex">
                                    <div class="monthly-titles">
                                        <div>Total Remaining Principal Amount</div>
                                        <div class="dashed">Total Remaining Interest Amount</div>
                                        <div class="total-remaining">Total Amount</div>
                                    </div>
                                    <div class="data-total">
                                        <div><?php echo "PHP " . number_format($total_rem_principal_pl, 2) ?></div>
                                        <div class="dashed"><?php echo "PHP " . number_format($total_rem_interest_pl, 2) ?></div>
                                        <div class="total-remaining"><?php echo "PHP " . number_format($total_rem_amount_pl, 2) ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                        </div>

                    <?php elseif ($monthly_loan === 1) : ?>
                        <div>
                            <div class="sort">
                                <form method="POST" action="<?php echo $_SERVER['REQUEST_URI'] ?>">
                                    <select required name="month">
                                        <option value="01" <?php if ($set_month == "01") {
                                                                    echo 'selected';
                                                                } ?>>January</option>
                                        <option value="02" <?php if ($set_month == "02") {
                                                                    echo 'selected';
                                                                } ?>>February</option>
                                        <option value="03" <?php if ($set_month == "03") {
                                                                    echo 'selected';
                                                                } ?>>March</option>
                                        <option value="04" <?php if ($set_month == "04") {
                                                                    echo 'selected';
                                                                } ?>>April</option>
                                        <option value="05" <?php if ($set_month == "05") {
                                                                    echo 'selected';
                                                                } ?>>May</option>
                                        <option value="06" <?php if ($set_month == "06") {
                                                                    echo 'selected';
                                                                } ?>>June</option>
                                        <option value="07" <?php if ($set_month == "07") {
                                                                    echo 'selected';
                                                                } ?>>July</option>
                                        <option value="08" <?php if ($set_month == "08") {
                                                                    echo 'selected';
                                                                } ?>>August</option>
                                        <option value="09" <?php if ($set_month == "09") {
                                                                    echo 'selected';
                                                                } ?>>September</option>
                                        <option value="10" <?php if ($set_month == "10") {
                                                                    echo 'selected';
                                                                } ?>>October</option>
                                        <option value="11" <?php if ($set_month == "11") {
                                                                    echo 'selected';
                                                                } ?>>November</option>
                                        <option value="12" <?php if ($set_month == "12") {
                                                                    echo 'selected';
                                                                } ?>>December</option>
                                    </select>

                                    <select required name="year">
                                        <?php for ($year = 2010; $year <= date('Y'); $year++) : ?>
                                            <option value="<?php echo $year ?>" <?php if ($year == $set_year) {
                                                                                            echo 'selected';
                                                                                        } ?>><?php echo $year ?></option>
                                        <?php endfor; ?>
                                    </select>

                                    <select required name="company">
                                        <?php while ($company_row = mysql_fetch_assoc($company_result)) : ?>
                                            <option value="<?php echo $company_row['company']; ?>" <?php if ($company_row['company'] == $set_comp) {
                                                                                                                echo 'selected';
                                                                                                            } ?>><?php echo $company_row['company_name']; ?></option>
                                        <?php endwhile; ?>
                                    </select>

                                    <input type="submit" name="set-month" value="Set" />
                                    <input type="submit" name="print" value="Print" />
                                </form>
                                <div class="loan-payroll-report">
                                    <a href="script_loan_payroll_report.php">VIEW LOAN PAYROLL REPORT</a>
                                </div>
                            </div>

                            <div class="date">
                                <?php
                                    echo date('F', strtotime($selected_date)) . " " . $set_year . " --- " . $set_comp;
                                    ?>
                            </div>

                            <div id="sl">
                                <div class="month-header">SALARY LOAN</div>
                                <div class="monthly-container">
                                    <div class="title flex">
                                        <div class="title-name">Name</div>
                                        <div>Loan Code</div>
                                        <div>1st Cutoff Principal</div>
                                        <div>1st Cutoff Interest</div>
                                        <div>Total</div>
                                        <div>2nd Cutoff Principal</div>
                                        <div>2nd Cutoff Interest</div>
                                        <div>Total</div>
                                        <div>Total Principal</div>
                                        <div>Total Interest</div>
                                        <div>Total</div>
                                        <div>Total Remaining Principal</div>
                                        <div>Total Remaining Interest</div>
                                        <div>Total Remaining</div>
                                        <div>Remaining Month/s</div>
                                    </div>
                                    <?php while ($sl_loan_row = mysql_fetch_assoc($sl_mon_query_loans)) : ?>
                                        <div class="data flex">
                                            <?php $sl_loan_code = $sl_loan_row['loan_code']; ?>
                                            <div class="name"><?php echo $sl_employee_name = $sl_loan_row['e_lname'] . ", " . $sl_loan_row['e_fname'] . " " . $sl_loan_row['e_mname'][0] . "."; ?></div>
                                            <div><?php echo $sl_loan_code; ?></div>
                                            <?php
                                                    //First Cutoff
                                                    $sl_first_amount = "SELECT * FROM employee_loan_schedule WHERE loan_date_payment = '$cutoff_first' AND loan_code = '$sl_loan_code' AND loan_payment_status = 1";
                                                    $sl_first_query = mysql_query($sl_first_amount) or die(mysql_error());
                                                    $sl_first_result = mysql_fetch_assoc($sl_first_query);

                                                    //Second Cutoff
                                                    $sl_second_amount = "SELECT * FROM employee_loan_schedule WHERE loan_date_payment = '$cutoff_second' AND loan_code = '$sl_loan_code' AND loan_payment_status = 1";
                                                    $sl_second_query = mysql_query($sl_second_amount) or die(mysql_error());
                                                    $sl_second_result = mysql_fetch_assoc($sl_second_query);

                                                    //Total Remaining
                                                    $sl_select_rem = "SELECT SUM(loan_principal_payment) as rem_princ, SUM(loan_interest_payment) AS rem_int FROM employee_loan_schedule WHERE (loan_payment_status = 0 OR loan_payment_status = 2) AND loan_code = '$sl_loan_code'";
                                                    $sl_query_rem = mysql_query($sl_select_rem) or die(mysql_error());
                                                    $sl_result_rem = mysql_fetch_assoc($sl_query_rem);

                                                    //Remaining Months
                                                    $sl_select_rem_month = "SELECT * FROM employee_loan_schedule WHERE loan_code = '$sl_loan_code' AND (loan_payment_status = 0 OR loan_payment_status = 2)";
                                                    $sl_query_rem_month = mysql_query($sl_select_rem_month) or die(mysql_error());
                                                    ?>
                                            <div class="first-cp"><?php echo "PHP " . number_format($sl_fp = $sl_first_result['loan_principal_payment'], 2) ?></div>
                                            <div class="first-ci"><?php echo "PHP " . number_format($sl_fi = $sl_first_result['loan_interest_payment'], 2) ?></div>
                                            <div class="total-first"><?php echo "PHP " . number_format($sl_ftotal = $sl_fi + $sl_fp, 2) ?></div>
                                            <div class="second-cp"><?php echo "PHP " . number_format($sl_sp = $sl_second_result['loan_principal_payment'], 2) ?></div>
                                            <div class="second-ci"><?php echo "PHP " . number_format($sl_si = $sl_second_result['loan_interest_payment'], 2) ?></div>
                                            <div class="total-second"><?php echo "PHP " . number_format($sl_stotal = $sl_si + $sl_sp, 2) ?></div>
                                            <div class="total-p"><?php echo "PHP " . number_format($sl_tp = ($sl_fp + $sl_sp), 2) ?></div>
                                            <div class="total-i"><?php echo "PHP " . number_format($sl_ti = ($sl_fi + $sl_si), 2) ?></div>
                                            <div class="total"><?php echo "PHP " . number_format($sl_tot = $sl_tp + $sl_ti, 2) ?></div>
                                            <div class="total-rp"><?php echo "PHP " . number_format($sl_remp = $sl_result_rem['rem_princ'], 2) ?></div>
                                            <div class="total-ri"><?php echo "PHP " . number_format($sl_remi = $sl_result_rem['rem_int'], 2) ?></div>
                                            <div class="total-rem"><?php echo "PHP " . number_format($sl_remtot = $sl_remp + $sl_remi, 2) ?></div>
                                            <div class="rem-mon">
                                                <?php
                                                        $sl_years = 0;
                                                        $sl_remaining = mysql_num_rows($sl_query_rem_month) / 2;
                                                        if ($sl_remaining >= 12) {
                                                            while ($sl_remaining >= 12) {
                                                                $sl_remaining -= 12;
                                                                $sl_years++;
                                                            }
                                                        }

                                                        if ($sl_years === 0) {
                                                            echo $sl_remaining . " month/s";
                                                        } else {
                                                            echo $sl_years . " year/s " . $sl_remaining . " month/s";
                                                        }

                                                        ?>
                                            </div>

                                            <?php $sl_firstcp_total += $sl_fp;
                                                    $sl_firstci_total += $sl_fi;
                                                    $sl_first_total += $sl_ftotal;
                                                    $sl_secondcp_total += $sl_sp;
                                                    $sl_secondci_total += $sl_si;
                                                    $sl_second_total += $sl_stotal;
                                                    $sl_total_principal += $sl_tp;
                                                    $sl_total_interest += $sl_ti;
                                                    $sl_totalpi += $sl_tot;
                                                    $sl_total_rp += $sl_remp;
                                                    $sl_total_ri += $sl_remi;
                                                    $sl_total_rem += $sl_remtot;
                                                    ?>
                                        </div>
                                    <?php endwhile; ?>
                                </div>

                                <div class="monthly-summary">
                                    <div class="month-header">Monthly Summary</div>
                                    <div class="flex">
                                        <div class="data-half flex">
                                            <div class="monthly-titles">
                                                <div>1st Cutoff Principal Total</div>
                                                <div class="dashed">1st Cutoff Interest Total</div>
                                                <div class="first-total">1st Cutoff Total</div>
                                                <div>2nd Cutoff Principal Total</div>
                                                <div class="dashed">2nd Cutoff Interest Total</div>
                                                <div class="second-total">2nd Cutoff Total</div>
                                            </div>
                                            <div class="data-total">
                                                <div class="firstcp-total"><?php echo "PHP " . number_format($sl_firstcp_total, 2) ?></div>
                                                <div class="firstci-total dashed"><?php echo "PHP " . number_format($sl_firstci_total, 2) ?></div>
                                                <div class="first-total"><?php echo "PHP " . number_format($sl_first_total, 2) ?></div>
                                                <div class="secondcp-total"><?php echo "PHP " . number_format($sl_secondcp_total, 2) ?></div>
                                                <div class="secondci-total dashed"><?php echo "PHP " . number_format($sl_secondci_total, 2) ?></div>
                                                <div class="second-total"><?php echo "PHP " . number_format($sl_second_total, 2) ?></div>
                                            </div>
                                        </div>

                                        <div class="data-half flex">
                                            <div class="monthly-titles">
                                                <div>Monthly Principal Total</div>
                                                <div class="dashed">Monthly Interest Total</div>
                                                <div class="total-pi">Monthly Total</div>
                                                <div>Remaining Principal Total</div>
                                                <div class="dashed">Remaining Interest Total</div>
                                                <div class="total-rema">Remaining Total</div>
                                            </div>
                                            <div class="data-total">
                                                <div class="total-principal"><?php echo "PHP " . number_format($sl_total_principal, 2) ?></div>
                                                <div class="total-interest dashed"><?php echo "PHP " . number_format($sl_total_interest, 2) ?></div>
                                                <div class="total-pi"><?php echo "PHP " . number_format($sl_totalpi, 2) ?></div>
                                                <div class="total-remp"><?php echo "PHP " . number_format($sl_total_rp, 2) ?></div>
                                                <div class="total-remi dashed"><?php echo "PHP " . number_format($sl_total_ri, 2) ?></div>
                                                <div class="total-rema"><?php echo "PHP " . number_format($sl_total_rem, 2) ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="ss">
                                <div class="month-header">SSS LOAN</div>
                                <div class="monthly-container">
                                    <div class="title flex">
                                        <div class="title-name">Name</div>
                                        <div>Loan Code</div>
                                        <div>1st Cutoff Principal</div>
                                        <div>1st Cutoff Interest</div>
                                        <div>Total</div>
                                        <div>2nd Cutoff Principal</div>
                                        <div>2nd Cutoff Interest</div>
                                        <div>Total</div>
                                        <div>Total Principal</div>
                                        <div>Total Interest</div>
                                        <div>Total</div>
                                        <div>Total Remaining Principal</div>
                                        <div>Total Remaining Interest</div>
                                        <div>Total Remaining</div>
                                        <div>Remaining Month/s</div>
                                    </div>
                                    <?php while ($ss_loan_row = mysql_fetch_assoc($ss_mon_query_loans)) : ?>
                                        <div class="data flex">
                                            <?php $ss_loan_code = $ss_loan_row['loan_code']; ?>
                                            <div class="name"><?php echo $ss_employee_name = $ss_loan_row['e_lname'] . ", " . $ss_loan_row['e_fname'] . " " . $ss_loan_row['e_mname'][0] . "."; ?></div>
                                            <div><?php echo $ss_loan_code; ?></div>
                                            <?php
                                                    //First Cutoff
                                                    $ss_first_amount = "SELECT * FROM employee_loan_schedule WHERE loan_date_payment = '$cutoff_first' AND loan_code = '$ss_loan_code' AND loan_payment_status = 1";
                                                    $ss_first_query = mysql_query($ss_first_amount) or die(mysql_error());
                                                    $ss_first_result = mysql_fetch_assoc($ss_first_query);

                                                    //Second Cutoff
                                                    $ss_second_amount = "SELECT * FROM employee_loan_schedule WHERE loan_date_payment = '$cutoff_second' AND loan_code = '$ss_loan_code' AND loan_payment_status = 1";
                                                    $ss_second_query = mysql_query($ss_second_amount) or die(mysql_error());
                                                    $ss_second_result = mysql_fetch_assoc($ss_second_query);

                                                    //Total Remaining
                                                    $ss_select_rem = "SELECT SUM(loan_principal_payment) as rem_princ, SUM(loan_interest_payment) AS rem_int FROM employee_loan_schedule WHERE (loan_payment_status = 0 OR loan_payment_status = 2) AND loan_code = '$ss_loan_code'";
                                                    $ss_query_rem = mysql_query($ss_select_rem) or die(mysql_error());
                                                    $ss_result_rem = mysql_fetch_assoc($ss_query_rem);

                                                    //Remaining Months
                                                    $ss_select_rem_month = "SELECT * FROM employee_loan_schedule WHERE loan_code = '$ss_loan_code' AND (loan_payment_status = 0 OR loan_payment_status = 2)";
                                                    $ss_query_rem_month = mysql_query($ss_select_rem_month) or die(mysql_error());
                                                    ?>
                                            <div class="first-cp"><?php echo "PHP " . number_format($ss_fp = $ss_first_result['loan_principal_payment'], 2) ?></div>
                                            <div class="first-ci"><?php echo "PHP " . number_format($ss_fi = $ss_first_result['loan_interest_payment'], 2) ?></div>
                                            <div class="total-first"><?php echo "PHP " . number_format($ss_ftotal = $ss_fi + $ss_fp, 2) ?></div>
                                            <div class="second-cp"><?php echo "PHP " . number_format($ss_sp = $ss_second_result['loan_principal_payment'], 2) ?></div>
                                            <div class="second-ci"><?php echo "PHP " . number_format($ss_si = $ss_second_result['loan_interest_payment'], 2) ?></div>
                                            <div class="total-second"><?php echo "PHP " . number_format($ss_stotal = $ss_si + $ss_sp, 2) ?></div>
                                            <div class="total-p"><?php echo "PHP " . number_format($ss_tp = ($ss_fp + $ss_sp), 2) ?></div>
                                            <div class="total-i"><?php echo "PHP " . number_format($ss_ti = ($ss_fi + $ss_si), 2) ?></div>
                                            <div class="total"><?php echo "PHP " . number_format($ss_tot = $ss_tp + $ss_ti, 2) ?></div>
                                            <div class="total-rp"><?php echo "PHP " . number_format($ss_remp = $ss_result_rem['rem_princ'], 2) ?></div>
                                            <div class="total-ri"><?php echo "PHP " . number_format($ss_remi = $ss_result_rem['rem_int'], 2) ?></div>
                                            <div class="total-rem"><?php echo "PHP " . number_format($ss_remtot = $ss_remp + $ss_remi, 2) ?></div>
                                            <div class="rem-mon">
                                                <?php
                                                        $ss_years = 0;
                                                        $ss_remaining = mysql_num_rows($ss_query_rem_month) / 2;
                                                        if ($ss_remaining >= 12) {
                                                            while ($ss_remaining >= 12) {
                                                                $ss_remaining -= 12;
                                                                $ss_years++;
                                                            }
                                                        }

                                                        if ($ss_years === 0) {
                                                            echo $ss_remaining . " month/s";
                                                        } else {
                                                            echo $ss_years . " year/s " . $ss_remaining . " month/s";
                                                        }

                                                        ?>
                                            </div>

                                            <?php $ss_firstcp_total += $ss_fp;
                                                    $ss_firstci_total += $ss_fi;
                                                    $ss_first_total += $ss_ftotal;
                                                    $ss_secondcp_total += $ss_sp;
                                                    $ss_secondci_total += $ss_si;
                                                    $ss_second_total += $ss_stotal;
                                                    $ss_total_principal += $ss_tp;
                                                    $ss_total_interest += $ss_ti;
                                                    $ss_totalpi += $ss_tot;
                                                    $ss_total_rp += $ss_remp;
                                                    $ss_total_ri += $ss_remi;
                                                    $ss_total_rem += $ss_remtot;
                                                    ?>
                                        </div>
                                    <?php endwhile; ?>
                                </div>

                                <div class="monthly-summary">
                                    <div class="month-header">Monthly Summary</div>
                                    <div class="flex">
                                        <div class="data-half flex">
                                            <div class="monthly-titles">
                                                <div>1st Cutoff Principal Total</div>
                                                <div class="dashed">1st Cutoff Interest Total</div>
                                                <div class="first-total">1st Cutoff Total</div>
                                                <div>2nd Cutoff Principal Total</div>
                                                <div class="dashed">2nd Cutoff Interest Total</div>
                                                <div class="second-total">2nd Cutoff Total</div>
                                            </div>
                                            <div class="data-total">
                                                <div class="firstcp-total"><?php echo "PHP " . number_format($ss_firstcp_total, 2) ?></div>
                                                <div class="firstci-total dashed"><?php echo "PHP " . number_format($ss_firstci_total, 2) ?></div>
                                                <div class="first-total"><?php echo "PHP " . number_format($ss_first_total, 2) ?></div>
                                                <div class="secondcp-total"><?php echo "PHP " . number_format($ss_secondcp_total, 2) ?></div>
                                                <div class="secondci-total dashed"><?php echo "PHP " . number_format($ss_secondci_total, 2) ?></div>
                                                <div class="second-total"><?php echo "PHP " . number_format($ss_second_total, 2) ?></div>
                                            </div>
                                        </div>

                                        <div class="data-half flex">
                                            <div class="monthly-titles">
                                                <div>Monthly Principal Total</div>
                                                <div class="dashed">Monthly Interest Total</div>
                                                <div class="total-pi">Monthly Total</div>
                                                <div>Remaining Principal Total</div>
                                                <div class="dashed">Remaining Interest Total</div>
                                                <div class="total-rema">Remaining Total</div>
                                            </div>
                                            <div class="data-total">
                                                <div class="total-principal"><?php echo "PHP " . number_format($ss_total_principal, 2) ?></div>
                                                <div class="total-interest dashed"><?php echo "PHP " . number_format($ss_total_interest, 2) ?></div>
                                                <div class="total-pi"><?php echo "PHP " . number_format($ss_totalpi, 2) ?></div>
                                                <div class="total-remp"><?php echo "PHP " . number_format($ss_total_rp, 2) ?></div>
                                                <div class="total-remi dashed"><?php echo "PHP " . number_format($ss_total_ri, 2) ?></div>
                                                <div class="total-rema"><?php echo "PHP " . number_format($ss_total_rem, 2) ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div id="pl">
                                <div class="month-header">PAG-IBIG LOAN</div>
                                <div class="monthly-container">
                                    <div class="title flex">
                                        <div class="title-name">Name</div>
                                        <div>Loan Code</div>
                                        <div>1st Cutoff Principal</div>
                                        <div>1st Cutoff Interest</div>
                                        <div>Total</div>
                                        <div>2nd Cutoff Principal</div>
                                        <div>2nd Cutoff Interest</div>
                                        <div>Total</div>
                                        <div>Total Principal</div>
                                        <div>Total Interest</div>
                                        <div>Total</div>
                                        <div>Total Remaining Principal</div>
                                        <div>Total Remaining Interest</div>
                                        <div>Total Remaining</div>
                                        <div>Remaining Month/s</div>
                                    </div>
                                    <?php while ($pl_loan_row = mysql_fetch_assoc($pl_mon_query_loans)) : ?>
                                        <div class="data flex">
                                            <?php $pl_loan_code = $pl_loan_row['loan_code']; ?>
                                            <div class="name"><?php echo $pl_employee_name = $pl_loan_row['e_lname'] . ", " . $pl_loan_row['e_fname'] . " " . $pl_loan_row['e_mname'][0] . "."; ?></div>
                                            <div><?php echo $pl_loan_code; ?></div>
                                            <?php
                                                    //First Cutoff
                                                    $pl_first_amount = "SELECT * FROM employee_loan_schedule WHERE loan_date_payment = '$cutoff_first' AND loan_code = '$pl_loan_code' AND loan_payment_status = 1";
                                                    $pl_first_query = mysql_query($pl_first_amount) or die(mysql_error());
                                                    $pl_first_result = mysql_fetch_assoc($pl_first_query);

                                                    //Second Cutoff
                                                    $pl_second_amount = "SELECT * FROM employee_loan_schedule WHERE loan_date_payment = '$cutoff_second' AND loan_code = '$pl_loan_code' AND loan_payment_status = 1";
                                                    $pl_second_query = mysql_query($pl_second_amount) or die(mysql_error());
                                                    $pl_second_result = mysql_fetch_assoc($pl_second_query);

                                                    //Total Remaining
                                                    $pl_select_rem = "SELECT SUM(loan_principal_payment) as rem_princ, SUM(loan_interest_payment) AS rem_int FROM employee_loan_schedule WHERE (loan_payment_status = 0 OR loan_payment_status = 2) AND loan_code = '$pl_loan_code'";
                                                    $pl_query_rem = mysql_query($pl_select_rem) or die(mysql_error());
                                                    $pl_result_rem = mysql_fetch_assoc($pl_query_rem);

                                                    //Remaining Months
                                                    $pl_select_rem_month = "SELECT * FROM employee_loan_schedule WHERE loan_code = '$pl_loan_code' AND (loan_payment_status = 0 OR loan_payment_status = 2)";
                                                    $pl_query_rem_month = mysql_query($pl_select_rem_month) or die(mysql_error());
                                                    ?>
                                            <div class="first-cp"><?php echo "PHP " . number_format($pl_fp = $pl_first_result['loan_principal_payment'], 2) ?></div>
                                            <div class="first-ci"><?php echo "PHP " . number_format($pl_fi = $pl_first_result['loan_interest_payment'], 2) ?></div>
                                            <div class="total-first"><?php echo "PHP " . number_format($pl_ftotal = $pl_fi + $pl_fp, 2) ?></div>
                                            <div class="second-cp"><?php echo "PHP " . number_format($pl_sp = $pl_second_result['loan_principal_payment'], 2) ?></div>
                                            <div class="second-ci"><?php echo "PHP " . number_format($pl_si = $pl_second_result['loan_interest_payment'], 2) ?></div>
                                            <div class="total-second"><?php echo "PHP " . number_format($pl_stotal = $pl_si + $pl_sp, 2) ?></div>
                                            <div class="total-p"><?php echo "PHP " . number_format($pl_tp = ($pl_fp + $pl_sp), 2) ?></div>
                                            <div class="total-i"><?php echo "PHP " . number_format($pl_ti = ($pl_fi + $pl_si), 2) ?></div>
                                            <div class="total"><?php echo "PHP " . number_format($pl_tot = $pl_tp + $pl_ti, 2) ?></div>
                                            <div class="total-rp"><?php echo "PHP " . number_format($pl_remp = $pl_result_rem['rem_princ'], 2) ?></div>
                                            <div class="total-ri"><?php echo "PHP " . number_format($pl_remi = $pl_result_rem['rem_int'], 2) ?></div>
                                            <div class="total-rem"><?php echo "PHP " . number_format($pl_remtot = $pl_remp + $pl_remi, 2) ?></div>
                                            <div class="rem-mon">
                                                <?php
                                                        $pl_years = 0;
                                                        $pl_remaining = mysql_num_rows($pl_query_rem_month) / 2;
                                                        if ($pl_remaining >= 12) {
                                                            while ($pl_remaining >= 12) {
                                                                $pl_remaining -= 12;
                                                                $pl_years++;
                                                            }
                                                        }

                                                        if ($pl_years === 0) {
                                                            echo $pl_remaining . " month/s";
                                                        } else {
                                                            echo $pl_years . " year/s " . $pl_remaining . " month/s";
                                                        }

                                                        ?>
                                            </div>

                                            <?php $pl_firstcp_total += $pl_fp;
                                                    $pl_firstci_total += $pl_fi;
                                                    $pl_first_total += $pl_ftotal;
                                                    $pl_secondcp_total += $pl_sp;
                                                    $pl_secondci_total += $pl_si;
                                                    $pl_second_total += $pl_stotal;
                                                    $pl_total_principal += $pl_tp;
                                                    $pl_total_interest += $pl_ti;
                                                    $pl_totalpi += $pl_tot;
                                                    $pl_total_rp += $pl_remp;
                                                    $pl_total_ri += $pl_remi;
                                                    $pl_total_rem += $pl_remtot;
                                                    ?>
                                        </div>
                                    <?php endwhile; ?>
                                </div>

                                <div class="monthly-summary">
                                    <div class="month-header">Monthly Summary</div>
                                    <div class="flex">
                                        <div class="data-half flex">
                                            <div class="monthly-titles">
                                                <div>1st Cutoff Principal Total</div>
                                                <div class="dashed">1st Cutoff Interest Total</div>
                                                <div class="first-total">1st Cutoff Total</div>
                                                <div>2nd Cutoff Principal Total</div>
                                                <div class="dashed">2nd Cutoff Interest Total</div>
                                                <div class="second-total">2nd Cutoff Total</div>
                                            </div>
                                            <div class="data-total">
                                                <div class="firstcp-total"><?php echo "PHP " . number_format($pl_firstcp_total, 2) ?></div>
                                                <div class="firstci-total dashed"><?php echo "PHP " . number_format($pl_firstci_total, 2) ?></div>
                                                <div class="first-total"><?php echo "PHP " . number_format($pl_first_total, 2) ?></div>
                                                <div class="secondcp-total"><?php echo "PHP " . number_format($pl_secondcp_total, 2) ?></div>
                                                <div class="secondci-total dashed"><?php echo "PHP " . number_format($pl_secondci_total, 2) ?></div>
                                                <div class="second-total"><?php echo "PHP " . number_format($pl_second_total, 2) ?></div>
                                            </div>
                                        </div>

                                        <div class="data-half flex">
                                            <div class="monthly-titles">
                                                <div>Monthly Principal Total</div>
                                                <div class="dashed">Monthly Interest Total</div>
                                                <div class="total-pi">Monthly Total</div>
                                                <div>Remaining Principal Total</div>
                                                <div class="dashed">Remaining Interest Total</div>
                                                <div class="total-rema">Remaining Total</div>
                                            </div>
                                            <div class="data-total">
                                                <div class="total-principal"><?php echo "PHP " . number_format($pl_total_principal, 2) ?></div>
                                                <div class="total-interest dashed"><?php echo "PHP " . number_format($pl_total_interest, 2) ?></div>
                                                <div class="total-pi"><?php echo "PHP " . number_format($pl_totalpi, 2) ?></div>
                                                <div class="total-remp"><?php echo "PHP " . number_format($pl_total_rp, 2) ?></div>
                                                <div class="total-remi dashed"><?php echo "PHP " . number_format($pl_total_ri, 2) ?></div>
                                                <div class="total-rema"><?php echo "PHP " . number_format($pl_total_rem, 2) ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    <?php endif; ?>


                    </div>


</body>

</html>
