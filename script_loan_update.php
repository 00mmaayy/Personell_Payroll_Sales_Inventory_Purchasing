<?php

    require 'connection/conn.php';
   
    var_dump($_POST['submit']);
    $range1 = strtotime((date('Y') . "-" . date('m') . '-1'));
    $range2 = strtotime((date('Y') . "-" . date('m') . '-15'));
    $range3 = strtotime((date('Y') . "-" . date('m') . '-16'));
    $range4 = strtotime((date('Y') . "-" . date('m') . '-30'));
    
    $payroll_period = '';
        $period_query = "SELECT p.payroll_period FROM payroll AS p ORDER BY payroll_period DESC LIMIT 1";
        $period_result = mysql_query($period_query) or die(mysql_error());
        while($period = mysql_fetch_assoc($period_result))
        {
            $payroll_period = $period['payroll_period'];
        }
    
   
    
    $cutoff_period = '';
        if(isset($_POST['submit']))
        {        
            echo 'hello';
            if(strtotime($payroll_period)>=$range1 && strtotime($payroll_period)<=$range2) {
                $cutoff_period = date('Y') . "-" . date('m') . '-11';
            }
            elseif(strtotime($payroll_period)>=$range3 && strtotime($payroll_period)<=$range4)
            {
                $cutoff_period = date('Y') . "-" . date('m') . '-26';
            }
        }
    echo $payroll_period;
    echo $cutoff_period;
    /*
    //update loan schedule table
    $update_query = "UPDATE employee_loan_schedule SET loan_payment_status = 1 WHERE loan_date_payment = '$cutoff_period' AND loan_payment_status = 0";

    //insert to payroll
        $loan_type = '';
        $loan_update_query = '';
        $data_query = "SELECT p.e_no,el.loan_type,els.loan_payment,els.loan_code,els.loan_date_payment
                        FROM payroll AS p 
                        JOIN employee_loan AS el ON el.e_no=p.e_no 
                        JOIN employee_loan_schedule AS els 
                        ON el.loan_code=els.loan_code AND els.loan_date_payment='$cutoff_period'";
        
        $res = mysql_query($data_query) or die(mysql_error());
        while($row = mysql_fetch_assoc($res))
        {
            $loan_type = $row['loan_type'];
            $loan_payment = $row['loan_payment'];
            $employee_id = $row['e_no'];
            switch($loan_type)
            {
                case 'SL';
                    $loan_update_query = "UPDATE payroll SET e_salary_loan=$loan_payment WHERE payroll_period='$payroll_period' AND e_no='$employee_id'";
                    break;
                case 'VL';
                    $loan_update_query = "UPDATE payroll SET e_veterans_loan=$loan_payment WHERE payroll_period='$payroll_period' AND e_no='$employee_id'";
                    break;
                case 'PL';
                    $loan_update_query = "UPDATE payroll SET e_pagibig_loan=$loan_payment WHERE payroll_period='$payroll_period' AND e_no='$employee_id'";
                    break;
                case 'PCL';
                    $loan_update_query = "UPDATE payroll SET e_pagibig_loan_calamity=$loan_payment WHERE payroll_period='$payroll_period' AND e_no='$employee_id'";
                    break;
                case 'SSSL';
                    $loan_update_query = "UPDATE payroll SET e_sss_loan=$loan_payment WHERE payroll_period='$payroll_period' AND e_no='$employee_id'";
                    break;    
            }


            if(mysql_query($loan_update_query) && mysql_query($update_query))
            {
                mysql_close($conn);
                header("Location: ./index.php");
                
            }
            else
            {
                die(mysql_error());
            }
            
        }
        */
 
    
    
?>