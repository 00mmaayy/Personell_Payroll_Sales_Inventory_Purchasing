<?php


require 'connection/conn.php';
require 'script_queries.php';
session_start();
$username = $_SESSION['username'];
if (isset($_POST['submit'])) {
    //variables 
    //getting the last loan code number
    $loan_code = '';
    if (mysql_num_rows($last_row_result) > 0) {
        while ($last_row = mysql_fetch_assoc($last_row_result)) {
            $loan_code_ID = 1 + (int) substr($last_row['loan_code'], -5);
        }
    } else {
        $loan_code_ID = 1;
    };
    $payment_date = '';
    //values from user input
    $employee_ID = $_SESSION['employee-ID'];
    $loan_type = $_POST['loan-type'];
    $loan_code = $loan_type . date('Y') . sprintf("%05s", $loan_code_ID);
    $loan_amount = $_POST['loan-amount'];
    $loan_interest_percent = floatval($_POST['loan-interest']);
    $loan_term = $_POST['loan-term'];
    $loan_schedule = $_POST['loan-schedule'];
    $release_date = $_POST['release-date'];
    $loan_remarks = addslashes($_POST['remarks']);
    $loan_deduction_date = $_POST['deduction-date'];

    if ($loan_type == 'SL' || $loan_type == 'SCL') {
        $ammortization = $loan_amount / $loan_term;
        $balance = $loan_amount;
        $balance_co = $loan_amount;
        $balance_interest = $loan_amount;
        $interest_ttl = 0;
        $interest = 0;
        $loan_interest_amount = 0;
        $total_payment = 0;
        $total_interest = 0;
        if($loan_schedule === "ML")
        {
            for ($i = 1; $i <= ($loan_term); $i++) {
                $interest_ttl = $balance_interest * ($loan_interest_percent / 100);
                $balance_interest -= $ammortization;
                $total_interest += $interest_ttl;
            }
        }
        else {
            for ($i = 1; $i <= ($loan_term * 2); $i++) {
                $interest_ttl = ($balance_interest * ($loan_interest_percent / 100))/2;
                $balance_interest -= ($ammortization/2);
                $total_interest += $interest_ttl;
            }
        }

    //ORIGINAL SCRIPT REMOVED(08-14-19);
      /*   for ($i = 1; $i <= ($loan_term); $i++) {
            $interest_ttl = $balance_interest * ($loan_interest_percent / 100);
            $balance_interest -= $ammortization;
            $total_interest += $interest_ttl;
        } */

        $loan_obligation = $loan_amount + $total_interest;
        $ammortization_co = $ammortization / 2;

        $month = date('m', strtotime($release_date));
        $year = date('Y', strtotime($release_date));

        if ($loan_deduction_date == '') {
            $date = 26;
        } else {
            $month = date('m', strtotime($loan_deduction_date));
            $year = date('y', strtotime($loan_deduction_date));

            if (date('d', strtotime($loan_deduction_date)) <= 11) {
                $month -= 1;
                $date = 26;
            } else {
                $date = 11;
            }
        };

        //loan schedule algorithm
        //automatic configuration

        if ($loan_schedule === "CO") {
            $ammortization_co = $ammortization / 2;
            for ($i = 1; $i <= ($loan_term * 2); $i++) {
                $interest = ($balance * ($loan_interest_percent / 100))/2;
                $payment = $ammortization_co + $interest;
                $balance -= $ammortization_co;
                if ($date === 26) {
                    $month += 1;
                    $date = 11;
                } elseif ($date === 11) {
                    $date = 26;
                };
                if ($month > 12) {
                    $month = 1;
                    $year += 1;
                };

                $payment_date = $year . "-" . $month . "-" . $date;
                $insert_schedule = ("INSERT INTO employee_loan_schedule (loan_code,loan_principal_payment,loan_interest_payment,loan_payment,loan_balance,loan_date_payment) 
                                                            VALUES ('$loan_code',$ammortization_co,$interest,$payment,$balance,'$payment_date')");
                mysql_query($insert_schedule) or die(mysql_error());
            }
        } elseif ($loan_schedule === "ML") {
            for ($i = 1; $i <= ($loan_term); $i++) {

                $interest = $balance * ($loan_interest_percent / 100);
                $payment = $ammortization + $interest;
                $balance -= $ammortization;
                $ammortization_co = $ammortization / 2;
                if ($date === 26 || $date === 11) {
                    $date = 11;
                    $month += 1;
                }
                if ($month > 12) {
                    $month = 1;
                    $year += 1;
                };

                $payment_date = $year . "-" . $month . "-" . $date;
                $insert_schedule = ("INSERT INTO employee_loan_schedule 
                                            (loan_code,loan_principal_payment,loan_interest_payment,loan_payment,loan_balance,loan_date_payment) 
                                            VALUES ('$loan_code',$ammortization,$interest,$payment,$balance,'$payment_date')");
                mysql_query($insert_schedule) or die(mysql_error());
            }
        }

        // OLD FORMULA FOR CUTOFF AMORT
        /*  for ($i = 1; $i <= ($loan_term); $i++) {

                $interest = $balance * ($loan_interest_percent / 100);
                $payment = $ammortization + $interest;
                $balance -= $ammortization;
                $ammortization_co = $ammortization / 2;
                if ($loan_schedule === "CO") {
                    $payment_co = $payment / 2;
                    $interest_co = $interest / 2;
                    for ($j = 1; $j <= 2; $j++) {
                        $balance_co -= $ammortization_co;
                        if ($date === 26) {
                            $month += 1;
                            $date = 11;
                        } elseif ($date === 11) {
                            $date = 26;
                        };
                        if ($month > 12) {
                            $month = 1;
                            $year += 1;
                        };

                        $payment_date = $year . "-" . $month . "-" . $date;
                        $insert_schedule = ("INSERT INTO employee_loan_schedule (loan_code,loan_principal_payment,loan_interest_payment,loan_payment,loan_balance,loan_date_payment) 
                                                            VALUES ('$loan_code',$ammortization_co,$interest_co,$payment_co,$balance_co,'$payment_date')");
                        mysql_query($insert_schedule) or die(mysql_error());
                    }
                } elseif ($loan_schedule === "ML") {
                    if ($date === 26 || $date === 11) {
                        $date = 11;
                        $month += 1;
                    }
                    if ($month > 12) {
                        $month = 1;
                        $year += 1;
                    };

                    $payment_date = $year . "-" . $month . "-" . $date;
                    $insert_schedule = ("INSERT INTO employee_loan_schedule 
                                                    (loan_code,loan_principal_payment,loan_interest_payment,loan_payment,loan_balance,loan_date_payment) 
                                                    VALUES ('$loan_code',$ammortization,$interest,$payment,$balance,'$payment_date')");
                    mysql_query($insert_schedule) or die(mysql_error());
                }
            } */
    } elseif ($loan_type == 'SS') {
        /* if($loan_schedule == "CO")
        {
            
        }
        elseif($loan_schedule == "ML")
        {

        } */

        $interest = $loan_interest_percent / 100;
        $monthly_interest = $interest / (12);
        $factor = $monthly_interest / (1 - (pow((1 + $monthly_interest), -$loan_term)));
        $ammortization = $loan_amount * $factor;
        $balance = $loan_amount;
        $month = date('m', strtotime($release_date));
        $year = date('Y', strtotime($release_date));

        if ($loan_deduction_date == '') {
            $date = 26;
        } else {
            $month = date('m', strtotime($loan_deduction_date));
            $year = date('y', strtotime($loan_deduction_date));

            if (date('d', strtotime($loan_deduction_date)) <= 11) {
                $month -= 1;
                $date = 26;
            } else {
                $date = 11;
            }
        };

        for ($i = 0; $i < $loan_term; $i++) {
            $payment_interest = ($balance / 12) * $interest;
            $payment_principal = $ammortization - $payment_interest;
            $balance -= $payment_principal;

            if ($date == 26 || $date == 11) {
                $month += 1;
                $date = 11;
            }

            if ($month > 12) {
                $month = 1;
                $year += 1;
            }
            //echo "$loan_code ---- $payment_principal  ---- $payment_interest  ---- $ammortization  ---- $balance   ---- $payment_date </br>";
            $loan_obligation += $ammortization;
            $total_interest += $payment_interest;
            $payment_date = "$year-$month-$date";
            $insert_schedule = ("INSERT INTO employee_loan_schedule 
            (loan_code,loan_principal_payment,loan_interest_payment,loan_payment,loan_balance,loan_date_payment) 
            VALUES ('$loan_code',$payment_principal,$payment_interest,$ammortization,$balance,'$payment_date')");
            mysql_query($insert_schedule) or die(mysql_error());
        }
    } elseif ($loan_type == 'PL' || $loan_type == 'SSL') {

        $ammortization = $loan_amount;
        $loan_obligation = $ammortization * $loan_term;
        $balance = $loan_obligation;
        $loan_amount = 0;
        $loan_interest_percent = 0;
        $total_interest = 0;
        $month = date('m', strtotime($release_date));
        $year = date('Y', strtotime($release_date));

        if ($loan_deduction_date == '') {
            $date = 26;
        } else {
            $month = date('m', strtotime($loan_deduction_date));
            $year = date('y', strtotime($loan_deduction_date));

            if (date('d', strtotime($loan_deduction_date)) <= 11) {
                $month -= 1;
                $date = 11;
            } else {
                $month -= 1;
                $date = 26;
            }
        };
        for ($i = 0; $i < $loan_term; $i++) {

            if ($loan_schedule === "CO") {
                $payment = $ammortization / 2;

                for ($j = 1; $j <= 2; $j++) {
                    $balance -= $payment;
                    if ($date === 26) {
                        $date = 11;
                        $month += 1;
                    } elseif ($date === 11) {
                        $date = 26;
                    };
                    if ($month > 12) {
                        $month = 1;
                        $year += 1;
                    };

                    $payment_date = $year . "-" . $month . "-" . $date;
                    $insert_schedule = ("INSERT INTO employee_loan_schedule (loan_code,loan_principal_payment,loan_interest_payment,loan_payment,loan_balance,loan_date_payment) 
                                         VALUES ('$loan_code',0,0,round($payment,2),round($balance,2),'$payment_date')");
                    mysql_query($insert_schedule) or die(mysql_error());
                }
            } elseif ($loan_schedule === "ML") {
                $balance -= $ammortization;
                if ($date === 26) {
                    $date = 26;
                    $month += 1;
                } elseif ($date === 11) {
                    $date = 11;
                    $month += 1;
                }
                if ($month > 12) {
                    $month = 1;
                    $year += 1;
                };

                $payment_date = $year . "-" . $month . "-" . $date;
                $insert_schedule = ("INSERT INTO employee_loan_schedule 
                                    (loan_code,loan_principal_payment,loan_interest_payment,loan_payment,loan_balance,loan_date_payment) 
                                    VALUES ('$loan_code',0,0,round($ammortization,2),round($balance,2),'$payment_date')");
                mysql_query($insert_schedule) or die(mysql_error());
            }
        }
    }

    //insert query employee loan
    $insert_query = ("INSERT INTO employee_loan 
                           (loan_code,loan_type,e_no,loan_amount,loan_interest,loan_principal,loan_interest_amount,loan_term,loan_schedule,loan_release_date,loan_remarks,date_created) 
                            VALUES ('$loan_code','$loan_type','$employee_ID',$loan_amount,$loan_interest_percent,$loan_obligation,$total_interest,'$loan_term','$loan_schedule','$release_date','$loan_remarks',NOW())");
    mysql_query($insert_query) or die(mysql_error());

    $transaction = "CREATED NEW $loan_type LOAN FOR $employee_ID AMOUNTING TO $loan_amount WITH $loan_interest_percent % interest FOR $loan_term months";
    mysql_query("INSERT INTO logbook(date,time,username,transaction) VALUES(CURDATE(),CURTIME(),'$username','$transaction')") or die(mysql_error());
    header("Location: ./admin.php?personnel=1&e_no=" . $employee_ID . "&e_details=1&details_menu=loans");
}
        
         //straight loan computation
            //$loan_interest_amount = $loan_term*($loan_amount*($loan_interest_percent/100));
