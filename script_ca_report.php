<!DOCTYPE html>
<?php

  
  require ('connection/conn.php');
  $payroll_period_query = "SELECT ca_payroll_period FROM employee_cash_advance GROUP BY ca_payroll_period ASC";
  $payroll_period_result = mysql_query($payroll_period_query) or die(mysql_error());
  $modal_payroll_period_result = mysql_query($payroll_period_query) or die(mysql_error());

  $company_query = "SELECT company, company_name FROM company";
  $company_result = mysql_query($company_query) or die(mysql_error());
  $modal_company_result = mysql_query($company_query) or die(mysql_error());

  if(isset($_POST['submit']))
  {
      $payroll_period = $_POST['p-period'];
      setcookie('p-period',$payroll_period, time() + "43200",'/');
      $ca_report_query = "SELECT e.e_no, e.e_lname, e.e_fname, e.e_mname, eca.ca_amount_first, eca.ca_amount_second FROM employee_cash_advance AS eca JOIN employee AS e ON e.e_no=eca.e_no WHERE ca_payroll_period='$payroll_period' ORDER BY e.e_lname ASC";
      $ca_report_result = mysql_query($ca_report_query) or die(mysql_error());
      $ca_total_query = "SELECT SUM(ca_amount_first) AS ca_first_total, SUM(ca_amount_second) AS ca_second_total FROM employee_cash_advance WHERE ca_payroll_period='$payroll_period'";
      $ca_total_result = mysql_query($ca_total_query) or die(mysql_error());
  }

  if(isset($_GET['sort']))
  {
      $company = $_GET['company'];
      $payroll_period = $_COOKIE['p-period'];
      if($company==='ALL')
      {
        $ca_report_query = "SELECT e.e_no, e.e_lname, e.e_fname, e.e_mname, eca.ca_amount_first, eca.ca_amount_second FROM employee_cash_advance AS eca JOIN employee AS e ON e.e_no=eca.e_no WHERE ca_payroll_period='$payroll_period' ORDER BY e.e_lname ASC";
        $ca_report_result = mysql_query($ca_report_query) or die(mysql_error());
        $ca_total_query = "SELECT SUM(ca_amount_first) AS ca_first_total, SUM(ca_amount_second) AS ca_second_total FROM employee_cash_advance WHERE ca_payroll_period='$payroll_period'";
        $ca_total_result = mysql_query($ca_total_query) or die(mysql_error());
      }
      else
      {
        $ca_report_query = "SELECT e.e_no, e.e_lname, e.e_fname, e.e_mname, eca.ca_amount_first, eca.ca_amount_second FROM employee_cash_advance AS eca JOIN employee AS e ON e.e_no=eca.e_no WHERE ca_payroll_period='$payroll_period' AND e.e_company='$company' ORDER BY e.e_lname ASC";
        $ca_report_result = mysql_query($ca_report_query) or die(mysql_error());
        $ca_total_query = "SELECT SUM(ca_amount_first) AS ca_first_total, SUM(ca_amount_second) AS ca_second_total FROM employee_cash_advance JOIN employee ON employee.e_no=employee_cash_advance.e_no WHERE ca_payroll_period='$payroll_period' AND employee.e_company='$company'";
        $ca_total_result = mysql_query($ca_total_query) or die(mysql_error());
      }
      
  }

  

?>

<html>
    <head>
        <title>ALC PRINTING HOUSE</title>
        <link rel="stylesheet" type="text/css" href="css/ca-report.css">
        <link rel="stylesheet" type="text/css" href="css/ca-style.css">
        <script src="js/javascript.js" type="text/javascript"></script>
    </head>

    <body>

        <div class="ca-header-report"><div><span>Cash Advance Report</span></div></div>
            <div class="ca-report-main">     
                <div class="report-dates">
                <h3>Payroll Period</h3>
                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']?>">
                        <div>
                            <?php while($payroll_period_row = mysql_fetch_assoc($payroll_period_result)): ?>
                                <label class="rdocont"><input require id="radio-dates" type="radio" name="p-period" value="<?php echo $payroll_period_row['ca_payroll_period']?>"><span class="radiobtn"></span><?php echo date("F d, Y",strtotime($payroll_period_row['ca_payroll_period']))?></label>
                            <?php endwhile; ?>
                        </div>          
                        <input class="report-sbmt" type="submit" name="submit" value="Submit">
                    </form>
                </div>

                <div class="report-container">
                    <div>
                    <table class="sort-table">
                        
                                <tr>
                                    <form method="GET" action="<?php echo $_SERVER['PHP_SELF']?>">
                                        <td>
                                            <span>Company</span><br />
                                            <select name="company">
                                                <option value="ALL" <?php if($_GET['company']==='ALL'){echo 'selected';}?>>All</option>
                                                <?php while($company_row = mysql_fetch_assoc($company_result)): ?>
                                                    <option value="<?php echo $company_row['company']?>" <?php if($_GET['company']==$company_row['company']){echo 'selected';}?>><?php echo $company_row['company_name'] ?></option>
                                                <?php endwhile; ?>
                                            </select>
                                        </td>

                                        <td>
                                            <br />
                                                <input type="submit" name="sort" value="Set">
                                        </td>
                                        </form>

                                        <td>
                                            <br />
                                            <button class="printable" type="submit" name="print" onclick="openPrintModal()">Print</button>  
                                        </td>

                                </tr>
                        
                        </table>
                    </div>
                    
                    <table class="ca-report" cellspacing="0">
                        <thead>
                            <tr>
                                <td>Employee</td>
                                <td>1st CA</td>
                                <td>2nd CA</td>
                                <td class="border-right">Total</td>
                            </tr>  
                        </thead>

                        <tbody>
                            <?php while($ca_report_row = mysql_fetch_assoc($ca_report_result)): ?>
                                <tr>
                                    <td class="e-name"><?php echo  $ca_report_row['e_lname'] . ", " . $ca_report_row['e_fname'] . " " . $ca_report_row['e_mname'][0] . "."; ?></td>
                                    <td><?Php echo number_format($ca_report_row['ca_amount_first'],2) ?></td>
                                    <td <?php if($_GET['CA']==='ALL'){echo 'selected';}?>><?Php echo number_format($ca_report_row['ca_amount_second'],2) ?></td>
                                    <td class="border-right ca-ttl"><?Php echo number_format(($ca_report_row['ca_amount_first'] + $ca_report_row['ca_amount_second']),2) ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>

                        <tfoot>
                            <?php while($ca_total_row = mysql_fetch_assoc($ca_total_result)): ?>
                                    <tr>
                                        <td></td>
                                        <td class="ft-total"><?php echo number_format($ca_total_row['ca_first_total'],2) ?></td>
                                        <td class="ft-total"><?php echo number_format($ca_total_row['ca_second_total'],2) ?></td>
                                        <td class="border-right ft-total"><?php echo number_format(($ca_total_row['ca_first_total']+$ca_total_row['ca_second_total']),2) ?></td>
                                <?php endwhile; ?>
                        </tfoot>
                    </table>
                </div>      
        </div> 

         
        <!-- Modal -->
        <div id="printModal" class="modal">
            <div class="modal-container">
                <span class="close">&times</span><br />
                <form method="POST" action="script_ca_printable.php">
                    <span>Payroll Period</span><br />
                    <select name="p_period">
                        <?php while($modal_payroll_period_row = mysql_fetch_assoc($modal_payroll_period_result)): ?>
                            <option value="<?php echo $modal_payroll_period_row['ca_payroll_period']?>"><?php echo date("F d, Y",strtotime($modal_payroll_period_row['ca_payroll_period']))?></option>
                        <?php endwhile; ?>
                    </select><br />
                    <span>Company</span><br />
                    <select name="company">
                        <option value="ALL">All</option>
                        <?php while($modal_company_row = mysql_fetch_assoc($modal_company_result)): ?>
                            <option value="<?php echo $modal_company_row['company']?>"><?php echo $modal_company_row['company_name'] ?></option>
                        <?php endwhile; ?>
                    </select><br />
                    <span>Cash Advance</span><br />
                    <select name="ca-trigger">
                        <option value="ALL">All</option>
                        <option value="CA1">First Cash Advance</option>
                        <option value="CA2">Second Cash Advance</option>
                    </select><br />

                    <input type="submit" name="generate" value="Generate Printable">
                </form>
            </div>
        </div>
        <script type="text/javascript" src="js/script.js"></script>   
    </body>

</html>

