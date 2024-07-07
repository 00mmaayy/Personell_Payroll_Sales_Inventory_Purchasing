<!DOCTYPE html>
<html>

<?php require 'script_queries.php';
    require 'connection/conn.php';
    session_start();
    if(!isset($_SESSION['username']))
            {
                $loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
                header($loc); 
            }

    $_SESSION['employee-ID'] = $_GET['e_no'];
    $employee_ID = $_GET['e_no'];
    $employee_name= $_GET['name'];
    //$status = $GET['add_loans'];
    $_SESSION['name'] = $employee_name;
    //$_SESASSION['status'] = $status;
    $new_loan_hidden = 1;
    $button_hidden = 0;
    $add_loan_hidden = 1;
    //SELECT query for loan history
        $employee_loan_query = "SELECT el.loan_code,elt.loan_type,el.loan_principal,el.loan_release_date,el.loan_remarks FROM employee_loan AS el JOIN employee_loan_type as elt ON el.loan_type = elt.loan_type_code WHERE e_no='$employee_ID' ORDER BY el.loan_ID ASC";
        $employee_loan_result = mysql_query($employee_loan_query) or die(mysql_error());
        $employee_loan_exist_query = "SELECT loan_code, loan_amount, loan_release_date FROM employee_loan WHERE e_no='$employee_ID'";
        $employee_loan_exist_result = mysql_query($employee_loan_exist_query) or die(mysql_error());
    if(isset($_POST['new-loan']))
    {
        $button_hidden = 1;
        $new_loan_hidden = 0;
        $add_loan_hidden = 1;
    }
    elseif(isset($_POST['addtn-loan']))
    {
        $button_hidden = 1;
        $new_loan_hidden = 1;
        $add_loan_hidden = 0;
    }
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Loans</title>
    <link rel="stylesheet" type="text/css" href="./css/loan-style.css">
</head>

<!-- Insert Loans to DB -->
    <?php if(isset($_REQUEST['add_loans'])): ?>
        <body class="add-loan-body">  
            <div>
                <div class="employee-details"><?php echo $employee_name?></div>
                
                    <div class="loan-form">

                        <form action="script_loan_data.php" method="POST">
                    
                            <div class="detail-header">LOAN DETAILS</div>
                            <span>LOAN TYPE</span><br />
                                <select required name="loan-type">
                                    <option value="">--Select One--</option>
                                        <?php if(mysql_num_rows($ltype_result)> 0): 
                                            while($ltype_row = mysql_fetch_assoc($ltype_result)): ?>
                                        <option value="<?php echo $ltype_row["loan_type_code"] ?>"><?php echo $ltype_row["loan_type"] ?></option>
                                        <?php endwhile; endif; ?>
                                </select>
                            <br />

                            <span>LOAN AMOUNT</span><br />
                                <input required type="number" step="any" name="loan-amount">
                            <br />
                            
                            <span>LOAN INTEREST</span><br />
                                <select required name="loan-interest">
                                    <option value="">--Select One--</option>
                                    <option value="1">1%</option>
                                    <option value="1.5">1.5%</option>
                                    <option value="2">2%</option>
                                    <option value="2.5">2.5%</option>
                                    <option value="3">3%</option>
                                    <option value="3.5">3.5%</option>
                                    <option value="4">4%</option>
                                    <option value="4.5">4.5%</option>
                                    <option value="5">5%</option>
                                    <option value="5.5">5.5%</option>
                                    <option value="6">6%</option>
                                    <option value="6.5">6.5%</option>
                                    <option value="7">7%</option>
                                    <option value="7.5">7.5%</option>
                                    <option value="8">8%</option>
                                    <option value="8.5">8.5%</option>
                                    <option value="9">9%</option>
                                    <option value="9.5">9.5%</option>
                                    <option value="10">10%</option>
                                </select>
                            <br />

                            <span>LOAN TERM (Months)</span><br />
                                <input type="number" name="loan-term">
                                <!--<select required name="loan-term">
                                    <option value="">--Select One--</option>
                                    <option value="3">3 months</option>
                                    <option value="6">6 months</option>
                                    <option value="9">9 months</option>
                                    <option value="12">12 months</option>
                                    <option value="24">24 months</option>
                                    <option value="36">36 months</option>
                                    <option value="47">47 months</option>
                                    <option value="48">48 months</option>
                                </select>-->
                            <br />

                            <span>LOAN SCHEDULE</span><br />
                                <select required name="loan-schedule">
                                    <option value="">--Select One--</option>
                                    <option value="ML">Monthly</option>
                                    <option value="CO">Per cutoff</option>
                                </select>
                            <br />

                            <span>FIRST DEDUCTION (default: next month first cutoff)</span><br />
                                <input type="date" name="deduction-date">
                            <br /> 

                            <span>RELEASE DATE</span><br />
                                <input required type="date" name="release-date">
                            <br />     

                            <span>REMARKS</span><br />
                                <textarea rows="4" cols="50" name="remarks"></textarea>    
                            <br />  
                            
                            <input class="button" type="submit" name="submit"> 
                        </form>

                    </div>
                
                </div>
            </div>


            <div class="loan-exist">
                <p>Existing Loan/s</p>
                <table cellspacing='0' class='loan-exist-table'>
                    <thead>
                       <tr>
                        <th>Loan Code</th>
                        <th>Loan Amount</th>
                        <th>Loan Date</th>
                        <th>Loan End</th>
                        <th>Status</th>
                        <th>Payment Balance</th>
                        <th>Obligation Balance</th>
                        <th></th>
                       </tr>
                    </thead>

                    <tbody>
                        <?php while($ele_row = mysql_fetch_assoc($employee_loan_exist_result)): ?>
                          <tr>
                            <td><?php echo $loan_codes = $ele_row['loan_code']?></td>
                            <td><?php echo 'Php ' . number_format($ele_row['loan_amount'],2)?></td>
                            <td><?php echo $ele_row['loan_release_date']?></td>
                            <td>    
                                <?php $loan_end_query = "SELECT loan_date_payment FROM employee_loan_schedule WHERE loan_balance=0 AND loan_code='$loan_codes'";
                                  $loan_end_result = mysql_query($loan_end_query) or die(mysql_error());
                                  if($loan_end_row = mysql_fetch_assoc($loan_end_result))
                                  {
                                      echo $loan_end_row['loan_date_payment'];
                                  };
                                ?>
                            </td>
                            <?php $status_query="SELECT loan_payment_status FROM employee_loan_schedule WHERE loan_balance=0 AND loan_code='$loan_codes'"; 
                                $status_result=mysql_query($status_query) or die(mysql_error());
                                if($status_row = mysql_fetch_assoc($status_result)):
                                ?>
                                <td style="color:<?php if($status_row['loan_payment_status']==0) {echo 'red';} elseif($status_row['loan_payment_status']==1) {echo 'green';} elseif($status_row['loan_payment_status']==2){echo 'royalblue';} elseif($status_row['loan_payment_status']==3){echo 'orange';}?>">
                                    <?php if($status_row['loan_payment_status']==0) {echo 'On-going';} elseif($status_row['loan_payment_status']==1) {echo 'Paid';} elseif($status_row['loan_payment_status']==2){echo 'Hold';} elseif($status_row['loan_payment_status']==3){echo 'Cleared';}?>
                                </td> 
                            <?php endif; ?>

                            <?php $loan_balance_query="SELECT SUM(loan_principal_payment) AS payment_balance, SUM(loan_payment) AS balance FROM employee_loan_schedule WHERE loan_code='$loan_codes' AND loan_payment_status=0"; 
                                    $loan_balance_result=mysql_query($loan_balance_query) or die(mysql_error());
                                    if($loan_balance_row=mysql_fetch_assoc($loan_balance_result)):
                            ?>
                                <td><?php echo 'Php ' . number_format($loan_balance_row['payment_balance'],2);?></td>
                                <td><?php echo 'Php ' . number_format($loan_balance_row['balance'],2);?></td>
                                <td>
                                    <form method="POST" action="script_loan_clear.php" target="_blank">
                                        <input type="hidden" name="loan_code" value="<?php echo $loan_codes ?>" />
                                        <input class="clear-btn" type="submit" name="clear" value="clear" />
                                    </form>
                                </td>
                            <?php endif; ?>
                          </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </body>

<!-- Loan History Data -->
    <?php elseif(isset($_REQUEST['loan_histories'])): ?>
        <body>
            <table cellspacing="0" cellpadding="0">
            <?php if(mysql_num_rows($employee_loan_result)>0): ?>
                <thead>
                    <tr>
                        <th>Loan Code</th>
                        <th>Loan Type</th>
                        <th>Loan Amount</th>
                        <th>Loan Balance</th>
                        <th>Release Date</th>
                        <th class="loan-remarks">Remarks</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody> 
                    <?php while($employee_loan_row = mysql_fetch_assoc($employee_loan_result)): ?>
                    <tr>
                        <td><a href="script_loan_schedule.php?loan-code=<?php echo $loan_code = $employee_loan_row['loan_code']?>&em_name=<?php echo $employee_name?>"><?php echo $employee_loan_row['loan_code'] ?></a></td>
                        <td><?php echo $employee_loan_row['loan_type']?></td>
                        <td><?php echo 'Php ' . number_format($employee_loan_row['loan_principal'],2)?></td>
                        <?php $el_loan_balance = "SELECT SUM(loan_payment) AS loan_payment FROM employee_loan_schedule WHERE loan_code ='$loan_code' AND loan_payment_status = 0"; 
                                $el_loan_balance_result = mysql_query($el_loan_balance) or die(mysql_error());
                                $el_loan_balance_row = mysql_fetch_assoc($el_loan_balance_result);
                        ?>
                        <td><?php echo 'Php ' . number_format($el_loan_balance_row['loan_payment'],2)?></td>
                        <td><?php echo $employee_loan_row['loan_release_date']?></td>
                        <td class="loan-remarks"><?php echo $employee_loan_row['loan_remarks']?></td>
                        
                        <!-- loan status query -->
                        <?php $el_status_query = "SELECT loan_payment_status, loan_balance FROM employee_loan_schedule WHERE loan_code='$loan_code' AND loan_balance=0";
                                $el_status_result = mysql_query($el_status_query) or die(mysql_error());
                                $el_status_row = mysql_fetch_assoc($el_status_result);
                        ?>
                        <td style="color:<?php if((float)$el_status_row['loan_balance']===0.00&&(int)$el_status_row['loan_payment_status']===1){echo 'Green';} elseif((float)$el_status_row['loan_balance']===0.00&&(int)$el_status_row['loan_payment_status']===0){echo 'Red';} elseif((float)$el_status_row['loan_balance']===0.00&&(int)$el_status_row['loan_payment_status']===2){echo 'royalblue';} elseif((float)$el_status_row['loan_balance']===0.00&&(int)$el_status_row['loan_payment_status']===3){echo 'orange';}?>"><?php if((float)$el_status_row['loan_balance']===0.00&&(int)$el_status_row['loan_payment_status']===1){echo 'Paid';} elseif((float)$el_status_row['loan_balance']===0.00&&(int)$el_status_row['loan_payment_status']===0){echo 'On-going';} elseif((float)$el_status_row['loan_balance']===0.00&&(int)$el_status_row['loan_payment_status']===2){echo 'Hold';} elseif((float)$el_status_row['loan_balance']===0.00&&(int)$el_status_row['loan_payment_status']===3){echo 'Cleared';}?></td>                       
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            <?php else: echo "No Loans"; endif; ?>
            </table>
        </body>
    <?php endif; ?>

</html>