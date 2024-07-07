<?php

//STEP 2 Actual Script Process---
if(isset($_REQUEST['deductions']))
{
    $s1="select * from employee";
    $q1=mysql_query($s1) or die(mysql_error());
    $r1=mysql_fetch_assoc($q1);
    
    
  //1st cut off process---  
  if(date('d')>=$z3['c1'] && date('d')<=$z3['c11'])
    {
       do {
            $e_no=$r1['e_no'];
            $e_allowance15=$r1['e_allowance15'];
            $basic_pay=$r1['e_basic_pay'];
            $payroll_period=$_REQUEST['payroll_period']; 
			 
            if($r1['e_employment_status']!="OnCall")	 	   
            {
                //PhilHealth
				if($basic_pay<=10000.00){$ph=500;}
				
                elseif($basic_pay>=10000.001 && $basic_pay<=99999.99)
						{$ph=$basic_pay*0.05/2;} //NEW PH FOR 2024
                
				elseif($basic_pay>=100000.00){$ph=5000.00;}
                
				else{$ph=0;}
                
                //PAG-IBIG VALUE
                $pagibig=200;
            }
            
            else 
            { 
             //PhilHealth
             $ph=0; 
             
             //Pagibigg
             $pagibig=0;
            }
             
            $e_no=$r1['e_no'];		   
            $payroll_period=$_REQUEST['payroll_period'];
            
			
			/*
			if($r1['e_tax']!=0){
			/*---------------------------------------------------------- 
				$basic_pay1 = $basic_pay - $ph - $pagibig - $e_allowance15;
				
				if($basic_pay1>=20834 && $basic_pay1<=33333)
				{ $tax="tax 2"; 
				  $over_cl=$basic_pay1-20833;
				  $wtax=$over_cl*.15;
				  $e_tax=$wtax/2;
				}	
				
				if($basic_pay1>=33334 && $basic_pay1<=66666)
				{ $tax="tax 3"; 
				  $over_cl=$basic_pay1-33333;
				  $wtax=(($over_cl*.20)+(22500/12));
				  $e_tax=$wtax/2;
				}

				if($basic_pay1>=66667 && $basic_pay1<=166666)
				{ $tax="tax 4"; 
				  $over_cl=$basic_pay1-66667;
				  $wtax=(($over_cl*.25)+(102500/12));
				  $e_tax=$wtax/2;
				}

				if($basic_pay1>=166667 && $basic_pay1<=666666)
				{ $tax="tax 5"; 
				  $over_cl=$basic_pay1-166667;
				  $wtax=(($over_cl*.30)+(40250/12));
				  $e_tax=$wtax/2;
				}

				if($basic_pay1>=666667 && $basic_pay1<=9999999)
				{ $tax="tax 6"; 
				  $over_cl=$basic_pay1-666667;
				  $wtax=(($over_cl*.35)+(2202500/12));
				  $e_tax=$wtax/2;
				}
					
			}else{ $e_tax=0; } */
			
			mysql_query("update payroll set step2=1, e_philhealth=$ph, e_pagibig=$pagibig, e_allowance15=$e_allowance15 where e_no='$e_no' and payroll_period='$payroll_period'");			   
            
            //For Dudy Abdua Only
            mysql_query("update payroll set e_philhealth=0 where e_no='60000012' and payroll_period='$payroll_period'");			   
            
            
         } while ($r1=mysql_fetch_assoc($q1));
    
        $username=$_SESSION['username'];
        $trans="add ".$z3['c1']."th and e_philhealth=$ph e_pagibig=$pagibig status allowance15 $payroll_period";
        $log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
        $log_query=mysql_query($log_sql) or die(mysql_error());
     }
    
    
  //2nd Cut off process---  
  if(date('d')>=$z3['c2'] && date('d')<=$z3['c22'])
    {
       do{
    
            $e_no=$r1['e_no'];	
            $e_allowance30=$r1['e_allowance30'];
            $basic_pay=$r1['e_basic_pay'];
            $payroll_period=$_REQUEST['payroll_period'];
			
			 if($r1['e_employment_status']!="OnCall")	   
            {
            $sss_s="select * from sssmatrix where erange>=$basic_pay order by ee asc";
            $sss_q=mysql_query($sss_s) or die(mysql_error());
            $sss_r=mysql_fetch_assoc($sss_q);
            $sss=$sss_r['ee'] + $sss_r['provee']; //SSS VALUE Personal
            $sss_c=$sss_r['er'] + $sss_r['prover']; //SSS VALUE Company
            }
            else
            { $sss=0; $sss_c=0;  }
            
			/*
			if($r1['e_tax']!=0){
			/*---------------------------------------------------------- 
				$ph=0;
				$pagibig=0;
				$basic_pay1 = $basic_pay - $ph - $pagibig - $sss - $e_allowance30;
				
				if($basic_pay1>=20834 && $basic_pay1<=33333)
				{ $tax="tax 2"; 
				  $over_cl=$basic_pay1-20833;
				  $wtax=$over_cl*.15;
				  $e_tax=$wtax/2;
				}	
				
				if($basic_pay1>=33334 && $basic_pay1<=66666)
				{ $tax="tax 3"; 
				  $over_cl=$basic_pay1-33333;
				  $wtax=(($over_cl*.20)+(22500/12));
				  $e_tax=$wtax/2;
				}

				if($basic_pay1>=66667 && $basic_pay1<=166666)
				{ $tax="tax 4"; 
				  $over_cl=$basic_pay1-66667;
				  $wtax=(($over_cl*.25)+(102500/12));
				  $e_tax=$wtax/2;
				}

				if($basic_pay1>=166667 && $basic_pay1<=666666)
				{ $tax="tax 5"; 
				  $over_cl=$basic_pay1-166667;
				  $wtax=(($over_cl*.30)+(40250/12));
				  $e_tax=$wtax/2;
				}

				if($basic_pay1>=666667 && $basic_pay1<=9999999)
				{ $tax="tax 6"; 
				  $over_cl=$basic_pay1-666667;
				  $wtax=(($over_cl*.35)+(2202500/12));
				  $e_tax=$wtax/2;
				}
						
	/*---------------------------------------------------------
			}else{ $e_tax=0; } */
	
            
            mysql_query("update payroll set step2=1, e_sss=$sss, ec_sss=$sss_c, e_allowance30=$e_allowance30 where e_no='$e_no' and payroll_period='$payroll_period'");
            
         }while ($r1=mysql_fetch_assoc($q1));
    
        $username=$_SESSION['username'];
        $trans="add ".$z3['c2']."th deductions tax sss pgibig phealth and add allowance30 $payroll_period add allowance";
        $log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
        $log_query=mysql_query($log_sql) or die(mysql_error());
    }  
 
 //CASH ADVANCE
 $ca_select_query = "SELECT * FROM employee_cash_advance WHERE ca_payroll_period='$cutoff_period'";
 $ca_select_result = mysql_query($ca_select_query) or die(mysql_error());

 while($ca_select_row = mysql_fetch_assoc($ca_select_result))
 {
     $ca = $ca_select_row['ca_amount_first'] + $ca_select_row['ca_amount_second'];
     $e_no = $ca_select_row['e_no'];
     $update_ca_payroll = "UPDATE payroll SET e_ca=$ca WHERE e_no='$e_no' AND payroll_period='$payroll_period'";
     mysql_query($update_ca_payroll) or die(mysql_error());
 }

    include 'script_leave_payroll.php';
    include 'script_adjustments_addition.php';
    include 'script_negative_payroll.php';
    include 'script_charges_deduction.php';
    echo '<script> location.replace("admin.php?payroll=1&payroll_processing=1"); </script>';
    //header('Location: admin.php?payroll=1&payroll_processing=1');
}
