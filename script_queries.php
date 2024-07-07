<?php

    require 'connection/conn.php';
    $employee_query = "SELECT * FROM employee";
    $employee_result = mysql_query($employee_query) or die(mysql_error());
    $last_row_query = "SELECT * FROM employee_loan ORDER BY loan_ID DESC LIMIT 1";
    $last_row_result = mysql_query($last_row_query) or die(mysql_error());
    $ltype_query = "SELECT * FROM employee_loan_type";
    $ltype_result = mysql_query($ltype_query) or die(mysql_error());
?>