<?php 

    include 'connection/conn.php';
   //STEP 1 Actual Script Process ---
   if(isset($_REQUEST['set_payroll_period']))
   {
       $s1="select * from employee where e_employment_status!='Resigned' and e_employment_status!='NotConnected' and e_employment_status!='Agency'";
       $q1=mysql_query($s1) or die(mysql_error());
       $r1=mysql_fetch_assoc($q1);
       
       do{
           $e_lname=$r1['e_lname'];
		   
		   if($r1['e_department']=="HH") { $e_basic_pay=$r1['e_basic_pay']/30; }
									else { $e_basic_pay=$r1['e_basic_pay']/26; }
           
		   
		   $e_no=$r1['e_no'];	   
           $e_company=$r1['e_company'];
           $e_department=$r1['e_department'];
           
           if($r1['e_salary_sched']=="Monthly")
           {
           $monthly_hours=104;
           $monthly_amount=$e_basic_pay*13;
           $head=1;
           }
           else
           {
		   if($_REQUEST['cut_days']==0) { $monthly_hours=0; $cut_days=0; }
		   
		   /*
		   if($_REQUEST['cut_days']==80) { $monthly_hours=80; $cut_days=10; }
		   if($_REQUEST['cut_days']==88) { $monthly_hours=88; $cut_days=11; }	    
           if($_REQUEST['cut_days']==96) { $monthly_hours=96; $cut_days=12; }
           if($_REQUEST['cut_days']==104){ $monthly_hours=104; $cut_days=13; }
           if($_REQUEST['cut_days']==112){ $monthly_hours=112; $cut_days=14; }
           */
		   
		   $monthly_amount=$e_basic_pay*$cut_days;
           $head=0;
           }				   
           
           $payroll_period=$_REQUEST['payroll_period'];
           mysql_query("insert into payroll (e_company,e_department,e_no,e_lname,head,payroll_period,e_basic_pay,e_total_cuttoff_hours,e_total_cuttoff_hours_final,step1) values ('$e_company','$e_department','$e_no','$e_lname',$head,'$payroll_period',$e_basic_pay,$monthly_hours,$monthly_amount,1)");
           
         } while ($r1=mysql_fetch_assoc($q1));
       
       $username=$_SESSION['username'];
       $trans="add payroll period $payroll_period";
       $log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
       $log_query=mysql_query($log_sql) or die(mysql_error());
       
       echo '<script> location.replace("admin.php?payroll=1&payroll_processing=1"); </script>';
       header('Location: admin.php?payroll=1&payroll_processing=1');
   }

?>