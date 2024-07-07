<?php include 'connection/conn.php';

$select_loans = "SELECT el.loan_interest,el.loan_interest_amount,el.loan_term,el.loan_code,emp.e_fname,emp.e_mname,emp.e_lname,el.loan_amount,el.loan_release_date FROM employee_loan AS el LEFT JOIN employee AS emp USING (e_no) WHERE loan_type = 'PL'";
$result_loans = mysql_query($select_loans);


?>
<!DOCTYPE html>

<body>
    <table border='1'>
        <thead>
            <th>Name</th>
            <th>Loan Date</th>
            <th>Loan Term</th>
            <th>Start of Deduction</th>
            <th>Maturity Date</th>
            <th>Loan Amount</th>
            <th>Loan Interest</th>
            <th>Interest Amount</th>
            <th>Total</th>
            <th>Paid</th>
            <th>Remaining</th>
        </thead>

        <tbody>
            <?php while ($row = mysql_fetch_assoc($result_loans)) : 
                $loan_code = $row['loan_code'];
                $loan_term = $row['loan_term'];
                $interest = $row['loan_interest'];
                $interest_amount = $row['loan_interest_amount'];
                $fname = $row['e_fname'];
                $mname = $row['e_mname'];
                $lname = $row['e_lname'];
                $firstname = "$lname, $fname $mname[0].";
                $loan_amount = $row['loan_amount'];
                $loan_date = $row['loan_release_date'];

                $start_date = mysql_query("SELECT loan_date_payment FROM employee_loan_schedule WHERE loan_code = '$loan_code' ORDER BY loan_date_payment ASC LIMIT 1");
                $end_date = mysql_query("SELECT loan_date_payment FROM employee_loan_schedule WHERE loan_code = '$loan_code' ORDER BY loan_date_payment DESC LIMIT 1");
                $start_day = mysql_fetch_assoc($start_date);
                $end_day = mysql_fetch_assoc($end_date);

                $paid = mysql_query("SELECT SUM(loan_payment) AS payment FROM employee_loan_schedule WHERE loan_code = '$loan_code' AND loan_payment_status = 1");
                $pay = mysql_fetch_assoc($paid);
                $total = mysql_query("SELECT SUM(loan_payment) AS total FROM employee_loan_schedule WHERE loan_code = '$loan_code'");
                $ttl = mysql_fetch_assoc($total);
                $o_ttl = $ttl['total'];
                ?>
                <tr>
                    <td><?php echo $firstname; ?></td>
                    <td><?php echo $loan_date; ?></td>
                    <td><?php echo $loan_term . " months"; ?></td>
                    <td><?php echo $start_day['loan_date_payment']; ?></td>
                    <td><?php echo $end_day['loan_date_payment']; ?></td>
                    <td><?php echo "PHP " . number_format($loan_amount,2); ?></td>
                    <td><?php echo $interest . "%"; ?></td>
                    <td><?php echo "PHP " . number_format($interest_amount,2); ?></td>
                    <td><?php echo "PHP " . number_format($o_ttl,2); ?></td>
                    <td><?php $payment = $pay['payment']; echo "PHP " . number_format($payment,2); ?></td>
                    <td><?php $remaining = $o_ttl - $payment; echo "PHP " . number_format($remaining,2);?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>

</html>