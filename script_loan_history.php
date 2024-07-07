<!DOCTYPE html>

<?php   require 'connection/conn.php';

        //Employee ID number and name variables
         $employee_number=$_GET['em_no'];
         $employee_name=$_GET['em_name'];

        //SELECT query for loan history
         $employee_loan_query = "SELECT el.loan_code,elt.loan_type,el.loan_amount,el.loan_release_date,el.loan_remarks FROM employee_loan AS el JOIN employee_loan_type as elt ON el.loan_type = elt.loan_type_code WHERE e_no=$employee_number ORDER BY el.loan_ID ASC";
         $employee_loan_result = mysql_query($employee_loan_query) or die(mysql_error());
?>   
<html>
    <head>
        <title>Loan</title>
        <link rel="stylesheet" type="text/css" href="./css/loan-style.css">
    </head>

    <body>
        <table cellspacing="0" cellpadding="0">
        <?php if(mysql_num_rows($employee_loan_result)>0): ?>
            <thead>
                <tr>
                    <th>Loan Code</th>
                    <th>Loan Type</th>
                    <th>Loan Amount</th>
                    <th>Release Date</th>
                    <th class="loan-remarks">Remarks</th>
                </tr>
            </thead>

            <tbody>
                
                <?php while($employee_loan_row = mysql_fetch_assoc($employee_loan_result)): ?>
                <tr>
                    <td><a href="loan-schedule.php?loan-code=<?php echo $employee_loan_row['loan_code']?>&em_no=<?php echo $employee_number?>&em_name=<?php echo $employee_name?>"><?php echo $employee_loan_row['loan_code'] ?></a></td>
                    <td><?php echo $employee_loan_row['loan_type']?></td>
                    <td><?php echo 'Php ' . number_format($employee_loan_row['loan_amount'],2)?></td>
                    <td><?php echo $employee_loan_row['loan_release_date']?></td>
                    <td class="loan-remarks"><?php echo $employee_loan_row['loan_remarks']?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        <?php else: echo "No Loans"; endif; ?>
        </table>
    </body>
</html>