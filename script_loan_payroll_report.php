<?php
include 'connection/conn.php';
$select_payroll_dates = mysql_query( "SELECT * FROM payroll GROUP BY payroll_period ORDER BY payroll_period DESC") or die(mysql_error());

if (isset($_GET['payroll-period'])) {
    $payroll_period = $_GET['payroll-period'];
    $select_loan_schedule = mysql_query( "SELECT emp.e_company,emp.e_department,emp.e_fname,emp.e_mname,emp.e_lname,el.loan_code,el.loan_amount,el.loan_interest,els.loan_principal_payment, els.loan_interest_payment 
                                                        FROM employee_loan_schedule AS els 
                                                        LEFT JOIN employee_loan AS el USING(loan_code) 
                                                        LEFT JOIN employee AS emp ON el.e_no = emp.e_no 
                                                        WHERE loan_date_payment = '$payroll_period' 
                                                        AND els.loan_payment_status = 1 
                                                        AND el.loan_type = 'SL'
                                                        ORDER BY emp.e_company,emp.e_department,emp.e_lname ASC") or die(mysql_error());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LOAN PAYROLL REPORT</title>
    <link rel="stylesheet" href="css/loan_payroll_report.css" />
</head>

<body>
    <div class="main-container">
        <div class="table-container">
            <h3>Employee Salary Loan Principal & Interest Payment Schedule</h3>
            <h4>For Payroll Period: <?php if(isset($_GET['payroll-period'])) { echo $_GET['payroll-period']; }; ?></h4>

            <table>
                <thead>
                    <tr>
                        <th>Loan Code</th>
                        <th>Company</th>
                        <th>Department</th>
                        <th>Name</th>
                        <th>Principal</th>
                        <th>Interest Rate</th>
                        <th>Principal Payment</th>
                        <th>Interest Payment</th>
                        <th>Total</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (isset($_GET['payroll-period'])) :
                        while ($loan_row = mysql_fetch_assoc($select_loan_schedule)) : 
                        $date = $_POST['payroll-period'];
                        $loan_code = $loan_row['loan_code'];
                        $company = $loan_row['e_company'];
                        $department = $loan_row['e_department'];
                        $name = $loan_row['e_lname'] . ", " . $loan_row['e_fname'] . " " . $loan_row['e_mname'][0];
                        $principal = $loan_row['loan_amount'];
                        $interest = $loan_row['loan_interest'];
                        $principal_payment = $loan_row['loan_principal_payment'];
                        $interest_payment = $loan_row['loan_interest_payment'];
                        $total = $interest_payment + $principal_payment;
                        ?>
                            <tr>
                                <td><?php echo $loan_code; ?></td>
                                <td><?php echo $company; ?></td>
                                <td><?php echo $department; ?></td>
                                <td><?php echo $name; ?></td>
                                <td><?php echo number_format($principal,2); ?></td>
                                <td><?php echo number_format($interest,2) . "%"; ?></td>
                                <td><?php echo number_format($principal_payment,2); ?></td>
                                <td><?php echo number_format($interest_payment,2); ?></td>
                                <td><?php echo number_format($total,2); ?></td>
                            </tr>
                    <?php endwhile;
                    endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>