<!DOCTYPE html>
<?php
    require 'connection/conn.php';
    session_start();
    $username = $_SESSION['username'];
    $reset=0;
    $release_date = '';
    $p_period = '';
    $total = 0;
    $disabled = 0;
    $edit = 0;

    //Update CA
    if(isset($_GET['edit']))
    {
        $edit = 1;
    }
    elseif(isset($_GET['update']))
    {
       $edit = 0;
       $ca_f_date = $_GET['ca_f_date'];
       $ca_s_date = $_GET['ca_s_date'];
       $ca_f_amt = $_GET['ca_f_amt'];
       $ca_s_amt = $_GET['ca_s_amt'];
       $pay_period = $_COOKIE['payroll-period'];
       $e_no = $_GET['ID'];

       if($_GET['disabler'] === '0')
       {
        $update_query = "UPDATE employee_cash_advance SET ca_amount_first=$ca_f_amt,ca_release_date_first='$ca_f_date' WHERE ca_payroll_period='$pay_period' AND e_no='$e_no'";
       }
       else
       {
            $update_query = "UPDATE employee_cash_advance SET ca_amount_first=$ca_f_amt,ca_amount_second=$ca_s_amt,ca_release_date_first='$ca_f_date',ca_release_date_second='$ca_s_date' WHERE ca_payroll_period='$pay_period' AND e_no='$e_no'";
       }
       
       mysql_query($update_query) or die(mysql_error());
       header("location: script_ca.php");
    }

    //Set Release Date and Payroll Period
    if(isset($_POST['set']))
    {
        $release_date = $_POST['release-date'];
        if(date("d",strtotime($release_date))<=10)
        {
           $payroll_period = date("Y",strtotime($release_date)) . "-" . date("m",strtotime($release_date)) . "-" . "11";
           setcookie('payroll-period',$payroll_period, time() + "43200",'/');
        }
        elseif(date("d",strtotime($release_date))<=25)
        {
           $payroll_period = date("Y",strtotime($release_date)) . "-" . date("m",strtotime($release_date)) . "-" . "26";
           setcookie('payroll-period',$payroll_period, time() + "43200",'/');
        }
        elseif(date("d",strtotime($release_date))<=31)
        {
            if(date("m",strtotime($release_date)) == 12)
            {
                $year = (int)(date("Y",strtotime($release_date))) + 1;
                $month = "01";
                $payroll_period = $year . "-" . $month . "-" . "11";
                setcookie('payroll-period',$payroll_period, time() + "43200",'/');
            }
            else
            {
                $month = (int)(date("m",strtotime($release_date))) + 1;
                $payroll_period = date("Y",strtotime($release_date)) . "-" . $month . "-" . "11";
                setcookie('payroll-period',$payroll_period, time() + "43200",'/');
            }
           
        };
        setcookie('release-date',$release_date, time() + "43200","/"); 
        echo "<meta http-equiv='refresh' content='0'>";
    }

    //Reset Release Date
    if(isset($_POST['reset']))
    {
        $reset=1;
    }

    //Set company cookie
    if(isset($_POST['compset']))
    {
        $company = $_POST['company'];
        setcookie('company',$company, time() + "43200",'/');
        echo "<meta http-equiv='refresh' content='0'>";
    }

    //Set Query based on company cookie
    switch($_COOKIE['company'])
        {
            case "ALL":
            $cash_advance_query = "SELECT * FROM employee WHERE e_employment_status='Regular' OR e_employment_status='Probationary'";
            $cash_advance_result = mysql_query($cash_advance_query) or die(mysql_error());
            break;
            case "ALC":
            $cash_advance_query = "SELECT * FROM employee WHERE e_company='ALC' AND (e_employment_status='Regular' OR e_employment_status='Probationary')";
            $cash_advance_result = mysql_query($cash_advance_query) or die(mysql_error());
            break;
            case "CBI":
            $cash_advance_query = "SELECT * FROM employee WHERE e_company='CBI' AND (e_employment_status='Regular' OR e_employment_status='Probationary')";
            $cash_advance_result = mysql_query($cash_advance_query) or die(mysql_error());
            break;
            case "KAL":
            $cash_advance_query = "SELECT * FROM employee WHERE e_company='KAL' AND (e_employment_status='Regular' OR e_employment_status='Probationary')";
            $cash_advance_result = mysql_query($cash_advance_query) or die(mysql_error());
            break;
            case "KAT":
            $cash_advance_query = "SELECT * FROM employee WHERE e_company='KAT' AND (e_employment_status='Regular' OR e_employment_status='Probationary')";
            $cash_advance_result = mysql_query($cash_advance_query) or die(mysql_error());
            break;
            case "LH":
            $cash_advance_query = "SELECT * FROM employee WHERE e_company='LH' AND (e_employment_status='Regular' OR e_employment_status='Probationary')";
            $cash_advance_result = mysql_query($cash_advance_query) or die(mysql_error());
            break;
        }


    $company_query = "SELECT company, company_name FROM company";
    $company_result = mysql_query($company_query) or die(mysql_error());
?>


<html>
    <head>
        <title>ALC PRINTING HOUSE</title>
        <link rel="stylesheet" type="text/css" href="css/ca-style.css">
        <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
        <script src="js/javascript.js" type="text/javascript"></script>
    </head>

    <body>
           <!-- Setting the date -->
            <?php if(!isset($_COOKIE['release-date'])||$reset===1):?>
               <div class="set-date-container center">
                    <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
                        <span>Current Release Date</span><br />
                        <span class="span-date"><?php if(!isset($_COOKIE['payroll-period'])){echo '----/--/--';}else{echo $_COOKIE['release-date'];} ?></span><br />
                        <span>Release Date</span><br />
                        <input required type="date" name="release-date">
                        <br />
                        <input class="set-button" type="submit" name="set" value="Set" >
                    </form>
                </div>

            <!-- Adding cash advance -->
            <div class="cash-advance-main">
                <?php elseif(isset($_COOKIE['release-date'])&&$reset===0): ?>
                    <div class="ca-header"><span>Cash Advance</span></div>
                    <div class="date-table">
                        <table cellspacing="0">
                            <tr class="date-table-header">
                                <td><span class="date-header">Release Date: </span><span><?php echo $_COOKIE['release-date']?></span><br /></td>
                                <td><span class="date-header">Payroll Period: </span><span><?php echo $p_period = $_COOKIE['payroll-period'] ?></span></td>
                                <td>
                                    <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
                                        <input type="submit" name="reset" value="Reset">
                                    </form>
                                </td>
                                <td>
                                    <form action="script_ca_report.php">
                                        <input type="submit" value="View Report" formtarget="_blank">
                                    </form>
                                </td>
                                <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                                    <td><span class="date-header">Company:</span><br /></td>
                                    <td>
                                        <select name="company">
                                            <option value="ALL" <?php if($_COOKIE['company']=='ALL'){echo 'selected';}?>>ALL</option>
                                            <?php while($company_row = mysql_fetch_assoc($company_result)): ?>
                                                <option value="<?php echo $company_row['company']?>" <?php if($_COOKIE['company']==$company_row['company']){echo 'selected';}?>><?php echo $company_row['company_name'] ?></option>
                                            <?php endwhile; ?>
                                        </select>
                                    </td>
                                    <td><input type="submit" name="compset" value="Set"></td>
                                </form>
                            </tr>
                            <tr>
                                <td><p></p></td>
                                <td><p></p></td>
                                
                                
                            </tr>
                        </table>

                        
                    </div>
                    
                    <!-- CA Input -->
                    
                <div class="cash-advance-data">         
                                <!-- Input cash advance -->
                                <div>
                                <?php if(mysql_num_rows($cash_advance_result)): ?>
                                    <table class="table-header">
                                        <thead>
                                            <th>
                                            <th>
                                            <th>Release Date</th>
                                            <th>First CA</th>
                                            <th>Release Date</th>
                                            <th>Second CA</th>
                                            <th>Total</th>
                                        </thead>
                                    </table>
                                    <table class="ca-table">
                                       
                                        <?php while($cash_advance_row = mysql_fetch_assoc($cash_advance_result)): ?>
                                        
                                        <tbody>
                                            <tr>
                                                <td class="ca-input">

                                                <form action="script_cash_advance_data.php" method="POST">
                                                  <input type="hidden" name="e-no" value="<?php echo $employee_ID = $cash_advance_row['e_no']?>">
                                                    <table class="ca-table-input">
                                                            <tr>
                                                                <td><?php echo $cash_advance_row['e_fname'] . " " . $cash_advance_row['e_mname'][0] . ". " . $cash_advance_row['e_lname'];?></td>
                                                            </tr>
                                                                <?php $ca_verify_query = "SELECT * FROM employee_cash_advance WHERE e_no='$employee_ID' AND ca_payroll_period='$p_period'";
                                                                    $ca_status_query = "SELECT e_no,ca_second_status FROM employee_cash_advance WHERE e_no='$employee_ID' AND ca_payroll_period='$p_period'"; 
                                                                    $ca_verify_result = mysql_query($ca_verify_query) or die(mysql_error());
                                                                    $ca_status_result = mysql_query($ca_status_query) or die(mysql_error());
                                                                        if($ca_status_row = mysql_fetch_assoc($ca_status_result))
                                                                        {
                                                                            if($ca_status_row['ca_second_status']==='1'&&$ca_status_row['e_no']===$employee_ID)
                                                                            {
                                                                                $disabled = 1;
                                                                            }
                                                                            else
                                                                            {
                                                                                $disabled = 0;
                                                                            }
                                                                        }
                                                                        else
                                                                        {
                                                                            $disabled = 0;
                                                                        }
                                                                    
                                                                ?>
                                                            <tr>
                                                                    <td><input required type="number" min="0" max="3000" name="cash-advance" <?php if($disabled===1){echo 'disabled';}?>></td>
                                                                    <td><input class="button" type="submit" name="submit" value="Submit" <?php if($disabled===1){echo 'disabled';}?>></td>
                                                            </tr>
                                                    </table>    
                                                </form>
                                                </td>

                                                <td class="ca-data">
                                                    <table class="ca-table-data">
                                                        <tbody>
                                                            <tr>
                                                            <?php while($ca_verify_row = mysql_fetch_assoc($ca_verify_result)): ?>
                                                                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="GET">    
                                                                    <?php $ID = $ca_verify_row['e_no'] ?>
                                                                    <td class="ca-date">
                                                                        <?php if($edit===0 || $ID != $_GET['ID']): ?>
                                                                            <?php echo $ca_verify_row['ca_release_date_first']?>
                                                                        <?php elseif($edit===1 && $ID === $_GET['ID']): ?>
                                                                             <input type="date" name="ca_f_date" value="<?php echo $ca_verify_row['ca_release_date_first']?>">   
                                                                        <?php endif; ?>
                                                                    </td>
                                                                    <td class="ca-amount">
                                                                        <?php if($edit===0 || $ID != $_GET['ID']): ?>
                                                                            <?php echo 'Php ' . number_format($ca_verify_row['ca_amount_first'],2) ?>
                                                                        <?php elseif($edit===1 && $ID === $_GET['ID']): ?>
                                                                             <input type="number" min="0" max="3000" name="ca_f_amt" value="<?php echo $ca_verify_row['ca_amount_first']?>">   
                                                                        <?php endif; ?>
                                                                    </td>
                                                                    <td class="ca-date">
                                                                        <?php if($edit===0 || $ID != $_GET['ID']): ?>
                                                                            <?php echo $ca_verify_row['ca_release_date_second']?>
                                                                        <?php elseif($edit===1 && $ID === $_GET['ID']): ?>
                                                                             <input <?php if($ca_verify_row['ca_released_date_second'] === NULL){ echo 'required';}?> <?php if($ca_verify_row['ca_second_status']==='0'){ echo 'disabled';} ?> type="date" name="ca_s_date" value="<?php echo $ca_verify_row['ca_release_date_second']?>">   
                                                                        <?php endif; ?>
                                                                    </td>
                                                                    <td class="ca-amount">             
                                                                        <?php if($edit===0 || $ID != $_GET['ID']): ?>
                                                                            <?php echo 'Php ' . number_format($ca_verify_row['ca_amount_second'],2)?>
                                                                        <?php elseif($edit===1 && $ID === $_GET['ID']): ?>
                                                                             <input  <?php if($ca_verify_row['ca_second_status']==='0'){ echo 'disabled';} ?> type="number" min="0" max="3000" name="ca_s_amt" value="<?php echo $ca_verify_row['ca_amount_second']?>">   
                                                                        <?php endif; ?></td>  
                                                                    <td class="ca-total"><?php echo 'Php ' . number_format(($ca_verify_row['ca_amount_first'] + $ca_verify_row['ca_amount_second']),2); ?></td>
                                                                    <td class="ca-edit">
                                                                            <input type="hidden" name="disabler" value="<?php echo $ca_verify_row['ca_second_status']?>">
                                                                            <input type="hidden" name="ID" value="<?php echo $ca_verify_row['e_no']?>">
                                                                            <?php if($edit===0 || $ID != $_GET['ID']): ?>
                                                                                <button class="btn" name="edit" value="edit"><i class="fa fa-edit"></i></button>
                                                                            <?php elseif($edit===1 && $ID === $_GET['ID']): ?>
                                                                                <button class="btn" name="update" value="update"><i class="fa fa-refresh"></i></button>
                                                                            <?php endif; ?>

                                                                    </td>
                                                                </form>
                                                            <?php endwhile; ?>
                                                                
                                                            </tr>
                                                        
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <?php endwhile;?>
                                    </table>     
                                <?php endif;?>
                                </div>
                </div>  
                <?php endif; ?>
            </div>     
       </div>
    </body>

</html>

