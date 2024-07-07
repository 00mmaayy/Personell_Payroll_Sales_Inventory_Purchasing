<?php

    require 'connection/conn.php';
    session_start();
    $username = $_SESSION['username'];

    if(isset($_POST['clear']))
    {
        $_SESSION['name'];
        $_SESSION['status'];
        $_SESSION['employee-ID'];
        $loan_code = $_POST['loan_code'];
        $update_query = "UPDATE employee_loan_schedule SET loan_payment_status=3 WHERE loan_code='$loan_code' AND loan_payment_status = 0";
        mysql_query($update_query) or die(mysql_error());
        header("Location: ./script_loan.php?e_no=" . $_SESSION['employee-ID'] . "&name=" . $_SESSION['name'] . "&add_loans=ADD+LOANS");    

    }
?>