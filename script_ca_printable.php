<!DOCTYPE html>

<?php 
require ('connection/conn.php');
if(isset($_POST['generate']))
{
    $ca = $_POST['ca-trigger'];
    $p_period = $_POST['p_period'];
    $company = $_POST['company'];

    if($company==='ALL')
    {
        $ca_print_query = "SELECT e.e_no, e.e_lname, e.e_fname, e.e_mname, eca.ca_amount_first, eca.ca_amount_second FROM employee_cash_advance AS eca JOIN employee AS e ON e.e_no=eca.e_no WHERE ca_payroll_period='$p_period' ORDER BY e.e_lname ASC";
        $ca_print_result = mysql_query($ca_print_query) or die(mysql_error());
        $ca_total_query = "SELECT SUM(ca_amount_first) AS ca_first_total, SUM(ca_amount_second) AS ca_second_total FROM employee_cash_advance WHERE ca_payroll_period='$payroll_period'";
        $ca_total_result = mysql_query($ca_total_query) or die(mysql_error());
    }
    else
    {
        $ca_print_query = "SELECT e.e_no, e.e_lname, e.e_fname, e.e_mname, eca.ca_amount_first, eca.ca_amount_second FROM employee_cash_advance AS eca JOIN employee AS e ON e.e_no=eca.e_no WHERE ca_payroll_period='$p_period' AND e.e_company='$company' ORDER BY e.e_lname ASC";
        $ca_print_result = mysql_query($ca_print_query) or die(mysql_error());
        $ca_total_query = "SELECT SUM(ca_amount_first) AS ca_first_total, SUM(ca_amount_second) AS ca_second_total FROM employee_cash_advance JOIN employee ON employee.e_no=employee_cash_advance.e_no WHERE ca_payroll_period='$payroll_period' AND employee.e_company='$company'";
        $ca_total_result = mysql_query($ca_total_query) or die(mysql_error());
    }
    
}

?>

<html>
    <head>
        <title>ALC PRINTING HOUSE</title>
        <link rel="stylesheet" type="text/css" href="css/ca-print.css">
    </head>

    <body>
        <p><?php echo $company?></p>
        <span><?php echo " Payroll Period: " . $p_period ?> 
        <div class="container">
            <table class="ca-report" cellspacing="0">
                <thead>
                    <tr>
                        <td>Name</td>
                        <td class="border-right" style="display:<?php if($ca!='ALL'&&$ca!='CA1'){echo 'none';}?>">1<sup>st</sup> CA</td>
                        <td class="border-right" style="display:<?php if($ca!='ALL'&&$ca!='CA2'){echo 'none';}?>">2<sup>nd</sup> CA</td>
                        <td class="border-right" style="display:<?php if($ca!='ALL'){echo 'none';}?>">Total</td>
                        <td class="border-right">Signature</td>
                    </tr>
                </thead>
                    
                <tbody>
                    <?php while($ca_print_row = mysql_fetch_assoc($ca_print_result)): ?>
                    <tr>
                        <td class="report-name"><?php echo $ca_print_row['e_lname'] . ", " . $ca_print_row['e_fname'] . " " . $ca_print_row['e_mname'][0] . "."; ?></td>
                        <td style="display:<?php if($ca!='ALL'&&$ca!='CA1'){echo 'none';}?>"><?Php echo number_format($ca_print_row['ca_amount_first'],2) ?></td>
                        <td style="display:<?php if($ca!='ALL'&&$ca!='CA2'){echo 'none';}?>"><?Php echo number_format($ca_print_row['ca_amount_second'],2) ?></td>
                        <td style="display:<?php if($ca!='ALL'){echo 'none';}?>"><?Php echo number_format(($ca_print_row['ca_amount_first'] + $ca_print_row['ca_amount_second']),2) ?></td>
                        <td class="border-right"></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>

                <tfoot>
                </tfoot>
            </table>
        </div>
    </body>
</html>