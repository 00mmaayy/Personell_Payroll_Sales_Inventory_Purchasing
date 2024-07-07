<!DOCTYPE html>

<?php  require 'connection/conn.php';


        $period = 0;
        $condition = 0;
        //$employee_no = $_GET['em_no'];
        $loan_code = $_GET['loan-code'];
        $employee_name = $_GET['em_name'];
         //loan schedule query
            $loan_query = "SELECT * FROM employee_loan_schedule WHERE loan_code='$loan_code'";
            $result = mysql_query($loan_query) or die(mysql_error());

         //loan details query
            $details_query = "SELECT elt.loan_type, el.loan_amount, el.loan_interest, el.loan_principal, el.loan_term, el.loan_schedule, el.loan_release_date 
                                FROM employee_loan AS el JOIN employee_loan_type AS elt ON el.loan_type=elt.loan_type_code WHERE loan_code='$loan_code'";
            $details_result = mysql_query($details_query) or die(mysql_error());
          
         //loan balance  
            $balance_query = "SELECT SUM(loan_payment) AS balance, SUM(loan_principal_payment) AS payment_balance FROM employee_loan_schedule WHERE loan_payment_status=0 AND loan_code='$loan_code'";
            $balance_result = mysql_query($balance_query) or die(mysql_error());

        //hold balance
            $hold_query = "SELECT SUM(loan_payment) AS balance, SUM(loan_principal_payment) AS hold_balance FROM employee_loan_schedule WHERE loan_payment_status=2 AND loan_code='$loan_code'";
            $hold_result = mysql_query($hold_query) or die(mysql_error());

        //total paid
            $paid_query = "SELECT SUM(loan_payment) AS paid, SUM(loan_principal_payment) AS princ_paid FROM employee_loan_schedule WHERE loan_payment_status=1 AND loan_code='$loan_code'";
            $paid_result = mysql_query($paid_query) or die(mysql_error());

        //cleared
            $cleared_query = "SELECT SUM(loan_payment) AS cleared, SUM(loan_principal_payment) AS princ_cleared FROM employee_loan_schedule WHERE loan_payment_status=3 AND loan_code='$loan_code'";
            $cleared_result = mysql_query($cleared_query) or die(mysql_error());

?>

<html>

    <head>
        <title>Loan</title>
        <link rel="stylesheet" type="text/css" href="./css/loan-style.css">
    </head>

    <body>
        <div class="container">
        <!-- table details -->
            <div>
                <table cellspacing="0" class="table-details">
                    <thead>
                        <tr>
                            <th>
                                <?php echo $employee_name ?>
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if(mysql_num_rows($details_result)>0):
                                while($details_row = mysql_fetch_assoc($details_result)): ?>
                            <tr>
                                <td>
                                    Loan Amount <br />
                                    <span><?php echo 'Php ' . number_format($details_row['loan_amount'],2); ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Loan Interest <br />
                                    <span><?php echo number_format($details_row['loan_interest'],2); ?>%</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Total Obligation <br />
                                    <span><?php echo 'Php ' . number_format($details_row['loan_principal'],2); ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Loan Type <br />
                                    <span><?php echo $details_row['loan_type']; ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Loan Term <br />
                                    <span><?php echo $details_row['loan_term']; ?> Months</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Loan Schedule <br />
                                    <span><?php if($details_row['loan_schedule']==='CO'){ echo 'Every cut-off';}elseif($details_row['loan_schedule']==='ML'){echo 'Monthly';}?></span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Release Date <br />
                                    <span><?php echo $details_row['loan_release_date']; ?></span>
                                </td>
                            </tr>
                            <?php while ($balance_row = mysql_fetch_assoc($balance_result)): ?>
                                <tr>
                                    <td>
                                        Loan Balance <br />
                                        <span style="color: red"><?php echo 'Php ' . number_format($balance_row['payment_balance'],2);?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Obligation Balance <br />
                                        <span style="color: red"><?php echo 'Php ' . number_format($balance_row['balance'],2);?></span>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                            <?php while ($hold_row = mysql_fetch_assoc($hold_result)): ?>
                                <tr>
                                    <td>
                                        Loan Balance on Hold <br />
                                        <span style="color: blue"><?php echo 'Php ' . number_format($hold_row['hold_balance'],2);?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Obligation Balance on Hold <br />
                                        <span style="color: blue"><?php echo 'Php ' . number_format($hold_row['balance'],2);?></span>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                            <?php while ($paid_row = mysql_fetch_assoc($paid_result)): ?>
                                <tr>
                                    <td>
                                        Paid<br />
                                        <span style="color: green"><?php echo 'Php ' . number_format($paid_row['princ_paid'],2);?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Paid Obligation <br />
                                        <span style="color: green"><?php echo 'Php ' . number_format($paid_row['paid'],2);?></span>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                            <?php while ($cleared_row = mysql_fetch_assoc($cleared_result)): ?>
                                <tr>
                                    <td>
                                        Cleared Payment<br />
                                        <span style="color: orange"><?php echo 'Php ' . number_format($cleared_row['princ_cleared'],2);?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Cleared Obligation Payment<br />
                                        <span style="color: orange"><?php echo 'Php ' . number_format($cleared_row['cleared'],2);?></span>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php endwhile; endif; ?>
                    </tbody>
                </table>
            </div>

        <!-- table schedule -->
            <div>
                <table cellspacing="0" class="table-schedule">
                    <thead id="sched" class="thead-schedule">
                        <tr>
                            <th class="period">Payment Period</th>
                            <th>Date</th>
                            <th>Principal</th>
                            <th>Interest</th>
                            <th>Payment</th>
                            <th>Balance</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php 
                            if(mysql_num_rows($result)>0):
                            while($row = mysql_fetch_assoc($result)): 
                            $period += 1;
                        ?>
                            <tr>
                                <td class="period"><?php echo $period ?></td>
                                <td><?php echo $row['loan_date_payment'] ?></td>
                                <td><?php echo number_format(round($row['loan_principal_payment'],2),2)?></td>
                                <td><?php echo number_format($row['loan_interest_payment'],2)?></td>
                                <td><?php echo number_format(round($row['loan_payment'],2),2)?></td>
                                <td><?php echo number_format(round($row['loan_balance'],2),2)?></td>
                                <td style="color:<?php if($row['loan_payment_status']==='0') { echo "red";} elseif($row['loan_payment_status']==='1') { echo "green";}elseif($row['loan_payment_status']==='2') { echo "blue";}elseif($row['loan_payment_status']==='3') { echo "orange";}?>"><?php if($row['loan_payment_status']==='0') { echo "UNPAID";} elseif($row['loan_payment_status']==='1') { echo "PAID";}elseif($row['loan_payment_status']==='2') { echo "HOLD";}elseif($row['loan_payment_status']==='3') { echo "CLEARED";}?></td>
                            </tr>  
                            <?php  endwhile; endif;  mysql_close($syshubconn);  ?>
                    </tbody>
                </table>
            </div>
        </div>
        

        
    </body>
</html>