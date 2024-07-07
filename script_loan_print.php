<!DOCTYPE html>

<?php 
	
    require 'connection/conn.php';

	session_start();	
	$current_user=$_SESSION['username'];
	$spas="select * from user_access where username='$current_user'";
	$qpas=mysql_query($spas) or die(mysql_error());
    $access=mysql_fetch_assoc($qpas);
    

    $firstcp_total = 0;
    $firstci_total = 0;
    $first_total = 0;
    $secondcp_total = 0;
    $secondci_total = 0;
    $second_total = 0;
    $total_principal = 0;
    $total_interest = 0;
    $totalpi = 0;
    $total_rp = 0;
    $total_ri = 0;
    $total_rem = 0;
    $total_loan_principal = 0;
    $total_loan_interest = 0;
    $total_loan = 0;
    $total_paid_principal = 0;
    $total_paid_interest = 0;
    $total_paid = 0;
    $total_rem_principal = 0;
    $total_rem_interest = 0;
    $total_rem_amount = 0;

    if(isset($_GET['print']))
    {
        $set_month = $_GET['month'];
        $set_year = $_GET['year'];
        $set_comp = $_GET['company']; 
        $selected_date = $set_year . "-" . $set_month . "-1";
        $cutoff_first = $set_year . "-" . $set_month . "-11";
        $cutoff_second = $set_year . "-" .$set_month . "-26";
        $select_loans = "SELECT emp.e_fname, emp.e_mname, emp.e_lname, els.loan_code 
        FROM employee AS emp JOIN employee_loan AS el ON emp.e_no = el.e_no
        JOIN employee_loan_schedule AS els ON el.loan_code = els.loan_code 
        WHERE els.loan_date_payment >= '$cutoff_first' AND els.loan_date_payment <= '$cutoff_second' AND (els.loan_payment_status = 1 OR els.loan_payment_status = 0) AND emp.e_company = '$set_comp' GROUP BY els.loan_code ORDER BY emp.e_lname";
        $query_loans = mysql_query($select_loans) or die(mysql_error());
    }
?>


<html>
    <head>
        <link type="text/css" rel="stylesheet" href="css/loan_all_style.css" />
        <link type="text/css" rel="stylesheet" href="css/font-awesome.min.css" />
    </head>

    <body>
       
        <div>
            <div class="date">
                <?php 
                    echo date('F',strtotime($selected_date)) . " " . $set_year . " --- " . $set_comp;
                ?>
            </div>

              
            <div class="monthly-container">
                <div class="title flex">
                    <div class="title-name">Name</div>
                    <div>1st Cutoff Principal</div>
                    <div>1st Cutoff Interest</div>
                    <div>Total</div>
                    <div>2nd Cutoff Principal</div>
                    <div>2nd Cutoff Interest</div>
                    <div>Total</div>
                    <div>Total Principal</div>
                    <div>Total Interest</div>
                    <div>Total</div>
                    <div>Total Remaining Principal</div>
                    <div>Total Remaining Interest</div>
                    <div>Total Remaining</div>
                    <div>Remaining Month/s</div>
                </div>
                <?php while($loan_row = mysql_fetch_assoc($query_loans)):?>
                    <div class="data flex">
                            <?php $loan_code = $loan_row['loan_code']; ?>
                            <div class="name"><?php echo $employee_name = $loan_row['e_lname'] . ", " . $loan_row['e_fname'] . " " . $loan_row['e_mname'][0] . "."; ?></div>
                            <?php 
                                //First Cutoff
                                $first_amount = "SELECT * FROM employee_loan_schedule WHERE loan_date_payment = '$cutoff_first' AND loan_code = '$loan_code'";
                                $first_query = mysql_query($first_amount) or die(mysql_error());
                                $first_result = mysql_fetch_assoc($first_query);

                                //Second Cutoff
                                $second_amount = "SELECT * FROM employee_loan_schedule WHERE loan_date_payment = '$cutoff_second' AND loan_code = '$loan_code'";
                                $second_query = mysql_query($second_amount) or die(mysql_error());
                                $second_result = mysql_fetch_assoc($second_query);

                                //Total Remaining
                                $select_rem = "SELECT SUM(loan_principal_payment) as rem_princ, SUM(loan_interest_payment) AS rem_int FROM employee_loan_schedule WHERE (loan_payment_status = 0 OR loan_payment_status = 2) AND loan_code = '$loan_code'";
                                $query_rem = mysql_query($select_rem) or die(mysql_error());
                                $result_rem = mysql_fetch_assoc($query_rem);

                                //Remaining Months
                                $select_rem_month = "SELECT * FROM employee_loan_schedule WHERE loan_code = '$loan_code' AND (loan_payment_status = 0 OR loan_payment_status = 2)";
                                $query_rem_month = mysql_query($select_rem_month) or die(myqli_error());
                            ?>
                            <div class="first-cp"><?php echo "PHP " . number_format($fp = $first_result['loan_principal_payment'],2) ?></div>
                            <div class="first-ci"><?php echo "PHP " . number_format($fi = $first_result['loan_interest_payment'],2) ?></div>
                            <div class="total-first"><?php echo "PHP " . number_format($ftotal = $fi + $fp,2) ?></div>
                            <div class="second-cp"><?php echo "PHP " . number_format($sp = $second_result['loan_principal_payment'],2) ?></div>
                            <div class="second-ci"><?php echo "PHP " . number_format($si = $second_result['loan_interest_payment'],2) ?></div>
                            <div class="total-second"><?php echo "PHP " . number_format($stotal = $si + $sp,2) ?></div>
                            <div class="total-p"><?php echo "PHP " . number_format($tp = ($fp+$sp),2) ?></div>
                            <div class="total-i"><?php echo "PHP " . number_format($ti = ($fi+$si),2) ?></div>
                            <div class="total"><?php echo "PHP " . number_format($tot = $tp+$ti,2) ?></div>
                            <div class="total-rp"><?php echo "PHP " . number_format($remp = $result_rem['rem_princ'],2) ?></div>
                            <div class="total-ri"><?php echo "PHP " . number_format($remi = $result_rem['rem_int'],2) ?></div>
                            <div class="total-rem"><?php echo "PHP " . number_format($remtot = $remp + $remi,2) ?></div>
                            <div class="rem-mon">
                                <?php
                                    $years = 0; 
                                    $remaining = mysql_num_rows($query_rem_month)/2; 
                                    if($remaining>=12)
                                    {
                                       while($remaining>=12)
                                       {
                                           $remaining -= 12;
                                           $years ++;
                                       }
                                    }
                                    
                                    if($years === 0)
                                    {
                                        echo $remaining . " month/s";
                                    }
                                    else
                                    {
                                        echo $years . " year/s " . $remaining . " month/s";
                                    }

                                ?>
                            </div>
                            
                            <?php $firstcp_total += $fp; 
                                    $firstci_total += $fi;
                                    $first_total += $ftotal;
                                    $secondcp_total += $sp;
                                    $secondci_total += $si;
                                    $second_total += $stotal;
                                    $total_principal += $tp;
                                    $total_interest += $ti;
                                    $totalpi += $tot;
                                    $total_rp += $remp;
                                    $total_ri += $remi;
                                    $total_rem += $remtot;
                            ?>
                    </div>
                <?php endwhile; ?>
                </div>

                <div class="monthly-summary">
                    <div class="month-header">Monthly Summary</div>
                        <div class="flex">
                            <div class="data-half flex">
                                <div class="monthly-titles">
                                    <div>1st Cutoff Principal Total</div>
                                    <div class="dashed">1st Cutoff Interest Total</div>
                                    <div class="first-total">1st Cutoff Total</div>
                                    <div>2nd Cutoff Principal Total</div>
                                    <div class="dashed">2nd Cutoff Interest Total</div>
                                    <div class="second-total">2nd Cutoff Total</div>
                                </div>
                                <div class="data-total">
                                        <div class="firstcp-total"><?php echo "PHP " . number_format($firstcp_total,2) ?></div>
                                        <div class="firstci-total dashed"><?php echo "PHP " . number_format($firstci_total,2) ?></div>
                                        <div class="first-total"><?php echo "PHP " . number_format($first_total,2) ?></div>
                                        <div class="secondcp-total"><?php echo "PHP " . number_format($secondcp_total,2) ?></div>
                                        <div class="secondci-total dashed"><?php echo "PHP " . number_format($secondci_total,2) ?></div>
                                        <div class="second-total"><?php echo "PHP " . number_format($second_total,2) ?></div>
                                </div>
                            </div>     
                            
                            <div class="data-half flex">
                                <div class="monthly-titles">
                                    <div>Monthly Principal Total</div>
                                    <div class="dashed">Monthly Interest Total</div>
                                    <div class="total-pi">Monthly Total</div>
                                    <div>Remaining Principal Total</div>
                                    <div class="dashed">Remaining Interest Total</div>
                                    <div class="total-rema">Remaining Total</div>
                                </div>
                                <div class="data-total">
                                        <div class="total-principal"><?php echo "PHP " . number_format($total_principal,2) ?></div>
                                        <div class="total-interest dashed"><?php echo "PHP " . number_format($total_interest,2) ?></div>
                                        <div class="total-pi"><?php echo "PHP " . number_format($totalpi,2) ?></div>
                                        <div class="total-remp"><?php echo "PHP " . number_format($total_rp,2) ?></div>
                                        <div class="total-remi dashed"><?php echo "PHP " . number_format($total_ri,2) ?></div>
                                        <div class="total-rema"><?php echo "PHP " . number_format($total_rem,2) ?></div>
                                </div>
                            </div>    
                        </div>
                    </div>
                </div>
        </div>
    
        
    </body>
</html>