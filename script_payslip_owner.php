<title>PaySlip</title>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/w3.css">
<link rel="stylesheet" href="css/font-awesome.min.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>

<style>
@page { size 8.5in 11in; margin: 2cm }
div.page { page-break-after: always }
</style>



 <table width='380' border="1">
 <tr height="50">
   <td colspan="2" align="center">
     <table>
	   <tr>
	     <td>
		  <img src="img/KAT.jpg" height="35" width="80"/>
		 </td>
		 <td align="center">
          <div class='w3-tiny'><strong>Katrinka's Kitchen</strong><br>Valencia Street Puerto Princesa City</div>
         </td>
	   </tr>
	 </table>      
   </td>
 </tr>
 
 <tr align='center'>
   <td colspan='2'><span class='w3-tiny'>DEPT:</span> <small><strong>MANAGEMENT</strong></small></td>
 </tr>
 <tr>
   <td><small>&nbsp;ID No. <strong></strong></small></td>
   <td><small>&nbsp;<strong>Castro, Maria Angela Carina Y.</strong></small></td>
 </tr>
 
 <tr>
   <td><small>&nbsp;Payroll Period: <strong><?php echo date('m/d/Y',strtotime($_REQUEST['payroll_period'])); ?></strong></small></td>
   <td><small>&nbsp;Rate/Day: <strong></strong></small></td>
 </tr>
 
 <tr align='center' class='w3-tiny'>
   <td>EARNINGS</td><td>DEDUCTIONS</td>
 </tr>
 
 <tr>
   <td>
   
	   <table width='190' border='0'>
	   <tr align='center'>
	   <td>&nbsp;</td>
	   <td class='w3-tiny'>Hours&nbsp;</td>
	   <td class='w3-tiny'>Amount</td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Basic Pay</td>
	   <td align='center'><small>104</small></td>
	   <td align='right'><small>50,000.00&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Overtime</td>
	   <td align='center'><small>0.00</small></td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Day Off</td>
	   <td align='center'><small>0.00</small></td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Day Off OT</td>
	   <td align='center'><small>0.00</small></td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Night Diff</td>
	   <td align='center'><small>0.00</small></td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Night Diff OT</td>
	   <td align='center'><small>0.00</small></td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Reg Holiday</td>
	   <td align='center'><small>0.00</small></td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Reg Holiday OT</td>
	   <td align='center'><small>0.00</small></td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Special Holiday</td>
	   <td align='center'><small>0.00</small></td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Spec. Holiday OT</td>
	   <td align='center'><small>0.00</small></td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Sick Leave</td>
	   <td align='center'><small>0.00</small></td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Vacation Leave</td>
	   <td align='center'><small>0.00</small></td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Solo Parent Leave</td>
	   <td align='center'><small>0.00</small></td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Lates</td>
	   <td align='center' class='w3-tiny'>(0 min)</td>
	   <td align='right' class='w3-tiny'>(0.00)&nbsp;</td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Absences</td>
	   <td align='center' class='w3-tiny'>(0.00)</td>
	   <td align='right' class='w3-tiny'>(0.00)&nbsp;</td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Undertime</td>
	   <td align='center' class='w3-tiny'>(0.00)</td>
	   <td align='right' class='w3-tiny'>(0.00)&nbsp;</td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Meal Allowance</td>
	   <td></td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Allowance 15th</td>
	   <td></td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Allowance 30th</td>
	   <td></td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Adjustment</td>
	   <td></td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'><strong>&nbsp;GROSS PAY</strong></td>
	   <td></td>
	   <td align='right'><small><strong>50,000.00&nbsp;</strong></small></td>
	   </tr>
	   </table>
   
   </td>
   
   <td>
   
	   <table width='190' border='0'>
	   <tr align='center'>
	   <td>&nbsp;</td>
	   <td class='w3-tiny'>Amount</td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;W-Tax</td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;SSS</td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;SSS Loan</td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;Pag-Ibig</td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;Pag-Ibig Loan</td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;Pag-Ibig Calamity Loan</td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;PhilHealth</td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;Salary Loan</td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;Cash Advance</td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;Veterans Loan</td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;Charges</td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;Over in Previous Pay</td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   
	   <tr><td class='w3-tiny'>&nbsp;</td></tr>
	   <tr><td class='w3-tiny'>&nbsp;</td></tr>
	   <tr><td class='w3-tiny'>&nbsp;</td></tr>
	   <tr><td class='w3-tiny'>&nbsp;</td></tr>
	   <tr><td class='w3-tiny'>&nbsp;</td></tr>
	   <tr><td class='w3-tiny'>&nbsp;</td></tr>
	   <tr><td class='w3-tiny'>&nbsp;</td></tr>
	   <tr><td class='w3-tiny'>&nbsp;</td></tr>
	   <tr><td class='w3-tiny'>&nbsp;</td></tr>
	   <tr><td class='w3-tiny'><strong>&nbsp;TOTAL DEDUCTIONS</strong></td>
	   <td align='right'><strong><small>0.00&nbsp;</small></strong></td>
	   </tr>
	   </table>
   
   </td>
 </tr>
 
 <tr>
	<td colspan='2' align='center'><strong><br><span class='w3-small'>NET PAY:</span>&nbsp;&nbsp;&nbsp;<span class='w3-large'>50,000.00</span></strong><br><br></td>
 </tr> 
 <tr>
	<td colspan='2' align='center'><br><span class='w3-tiny'>I acknowledge that ALL DEDUCTIONS herein are with my<br>PRIOR CONSENT and are therefore AUTHORIZED.</span>
	<br><br>
	<small><strong>Castro, Maria Angela Carina Y.</strong></small>
	</td>
 </tr> 
 <tr>
	<td colspan='2' align='center'>
	<span class='w3-tiny'>SIGNATURE OVER PRINTED NAME</span>
	<br><br>
	</td>
 </tr>
 
</table>



<br/><br/>



<table width='380' border="1">
 <tr height="50">
   <td colspan="2" align="center">
     <table>
	   <tr>
	     <td>
		  <img src="img/ALC.jpg" height="35" width="80"/>
		 </td>
		 <td align="center">
          <div class='w3-tiny'><strong>Alc Printing House</strong><br>Valencia Street Puerto Princesa City</div>
         </td>
	   </tr>
	 </table>      
   </td>
 </tr>
 
 <tr align='center'>
   <td colspan='2'><span class='w3-tiny'>DEPT:</span> <small><strong>MANAGEMENT</strong></small></td>
 </tr>
 <tr>
   <td><small>&nbsp;ID No. <strong></strong></small></td>
   <td><small>&nbsp;<strong>Castro, Alex Cesar L.</strong></small></td>
 </tr>
 
 <tr>
   <td><small>&nbsp;Payroll Period: <strong><?php echo date('m/d/Y',strtotime($_REQUEST['payroll_period'])); ?></strong></small></td>
   <td><small>&nbsp;Rate/Day: <strong></strong></small></td>
 </tr>
 
 <tr align='center' class='w3-tiny'>
   <td>EARNINGS</td><td>DEDUCTIONS</td>
 </tr>
 
 <tr>
   <td>
   
	   <table width='190' border='0'>
	   <tr align='center'>
	   <td>&nbsp;</td>
	   <td class='w3-tiny'>Hours&nbsp;</td>
	   <td class='w3-tiny'>Amount</td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Basic Pay</td>
	   <td align='center'><small>104</small></td>
	   <td align='right'><small>50,000.00&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Overtime</td>
	   <td align='center'><small>0.00</small></td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Day Off</td>
	   <td align='center'><small>0.00</small></td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Day Off OT</td>
	   <td align='center'><small>0.00</small></td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Night Diff</td>
	   <td align='center'><small>0.00</small></td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Night Diff OT</td>
	   <td align='center'><small>0.00</small></td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Reg Holiday</td>
	   <td align='center'><small>0.00</small></td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Reg Holiday OT</td>
	   <td align='center'><small>0.00</small></td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Special Holiday</td>
	   <td align='center'><small>0.00</small></td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Spec. Holiday OT</td>
	   <td align='center'><small>0.00</small></td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Sick Leave</td>
	   <td align='center'><small>0.00</small></td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Vacation Leave</td>
	   <td align='center'><small>0.00</small></td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Solo Parent Leave</td>
	   <td align='center'><small>0.00</small></td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Lates</td>
	   <td align='center' class='w3-tiny'>(0 min)</td>
	   <td align='right' class='w3-tiny'>(0.00)&nbsp;</td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Absences</td>
	   <td align='center' class='w3-tiny'>(0.00)</td>
	   <td align='right' class='w3-tiny'>(0.00)&nbsp;</td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Undertime</td>
	   <td align='center' class='w3-tiny'>(0.00)</td>
	   <td align='right' class='w3-tiny'>(0.00)&nbsp;</td>
	   </tr>
	   
	    <tr>
	   <td class='w3-tiny'>&nbsp;Meal Allowance</td>
	   <td></td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Allowance 15th</td>
	   <td></td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Allowance 30th</td>
	   <td></td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Adjustment</td>
	   <td></td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'><strong>&nbsp;GROSS PAY</strong></td>
	   <td></td>
	   <td align='right'><small><strong>50,000.00&nbsp;</strong></small></td>
	   </tr>
	   </table>
   
   </td>
   
   <td>
   
	   <table width='190' border='0'>
	   <tr align='center'>
	   <td>&nbsp;</td>
	   <td class='w3-tiny'>Amount</td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;W-Tax</td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;SSS</td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;SSS Loan</td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;Pag-Ibig</td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;Pag-Ibig Loan</td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;Pag-Ibig Calamity Loan</td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;PhilHealth</td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;Salary Loan</td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;Cash Advance</td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;Veterans Loan</td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;Charges</td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;Over in Previous Pay</td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   
	   <tr><td class='w3-tiny'>&nbsp;</td></tr>
	   <tr><td class='w3-tiny'>&nbsp;</td></tr>
	   <tr><td class='w3-tiny'>&nbsp;</td></tr>
	   <tr><td class='w3-tiny'>&nbsp;</td></tr>
	   <tr><td class='w3-tiny'>&nbsp;</td></tr>
	   <tr><td class='w3-tiny'>&nbsp;</td></tr>
	   <tr><td class='w3-tiny'>&nbsp;</td></tr>
	   <tr><td class='w3-tiny'>&nbsp;</td></tr>
	   <tr><td class='w3-tiny'>&nbsp;</td></tr>
	   <tr><td class='w3-tiny'><strong>&nbsp;TOTAL DEDUCTIONS</strong></td>
	   <td align='right'><strong><small>0.00&nbsp;</small></strong></td>
	   </tr>
	   </table>
   
   </td>
 </tr>
 
 <tr>
	<td colspan='2' align='center'><strong><br><span class='w3-small'>NET PAY:</span>&nbsp;&nbsp;&nbsp;<span class='w3-large'>50,000.00</span></strong><br><br></td>
 </tr> 
 <tr>
	<td colspan='2' align='center'><br><span class='w3-tiny'>I acknowledge that ALL DEDUCTIONS herein are with my<br>PRIOR CONSENT and are therefore AUTHORIZED.</span>
	<br><br>
	<small><strong>Castro, Alex Cesar L.</strong></small>
	</td>
 </tr> 
 <tr>
	<td colspan='2' align='center'>
	<span class='w3-tiny'>SIGNATURE OVER PRINTED NAME</span>
	<br><br>
	</td>
 </tr>
 
</table>


<br/><br/>



<table width='380' border="1">
 <tr height="50">
   <td colspan="2" align="center">
     <table>
	   <tr>
	     <td>
		  <img src="img/ALC.jpg" height="35" width="80"/>
		 </td>
		 <td align="center">
          <div class='w3-tiny'><strong>Alc Printing House</strong><br>Valencia Street Puerto Princesa City</div>
         </td>
	   </tr>
	 </table>      
   </td>
 </tr>
 
 <tr align='center'>
   <td colspan='2'><span class='w3-tiny'>DEPT:</span> <small><strong>MANAGEMENT</strong></small></td>
 </tr>
 <tr>
   <td><small>&nbsp;ID No. <strong></strong></small></td>
   <td><small>&nbsp;<strong>Castro, Maria Angela Carina Y.</strong></small></td>
 </tr>
 
 <tr>
   <td><small>&nbsp;Payroll Period: <strong><?php echo date('m/d/Y',strtotime($_REQUEST['payroll_period'])); ?></strong></small></td>
   <td><small>&nbsp;Rate/Day: <strong></strong></small></td>
 </tr>
 
 <tr align='center' class='w3-tiny'>
   <td>EARNINGS</td><td>DEDUCTIONS</td>
 </tr>
 
 <tr>
   <td>
   
	   <table width='190' border='0'>
	   <tr align='center'>
	   <td>&nbsp;</td>
	   <td class='w3-tiny'>Hours&nbsp;</td>
	   <td class='w3-tiny'>Amount</td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Basic Pay</td>
	   <td align='center'><small>104</small></td>
	   <td align='right'><small>50,000.00&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Overtime</td>
	   <td align='center'><small>0.00</small></td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Day Off</td>
	   <td align='center'><small>0.00</small></td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Day Off OT</td>
	   <td align='center'><small>0.00</small></td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Night Diff</td>
	   <td align='center'><small>0.00</small></td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Night Diff OT</td>
	   <td align='center'><small>0.00</small></td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Reg Holiday</td>
	   <td align='center'><small>0.00</small></td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Reg Holiday OT</td>
	   <td align='center'><small>0.00</small></td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Special Holiday</td>
	   <td align='center'><small>0.00</small></td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Spec. Holiday OT</td>
	   <td align='center'><small>0.00</small></td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Sick Leave</td>
	   <td align='center'><small>0.00</small></td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Vacation Leave</td>
	   <td align='center'><small>0.00</small></td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Solo Parent Leave</td>
	   <td align='center'><small>0.00</small></td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Lates</td>
	   <td align='center' class='w3-tiny'>(0 min)</td>
	   <td align='right' class='w3-tiny'>(0.00)&nbsp;</td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Absences</td>
	   <td align='center' class='w3-tiny'>(0.00)</td>
	   <td align='right' class='w3-tiny'>(0.00)&nbsp;</td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Undertime</td>
	   <td align='center' class='w3-tiny'>(0.00)</td>
	   <td align='right' class='w3-tiny'>(0.00)&nbsp;</td>
	   </tr>
	   
	    <tr>
	   <td class='w3-tiny'>&nbsp;Meal Allowance</td>
	   <td></td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Allowance 15th</td>
	   <td></td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Allowance 30th</td>
	   <td></td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Adjustment</td>
	   <td></td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'><strong>&nbsp;GROSS PAY</strong></td>
	   <td></td>
	   <td align='right'><small><strong>50,000.00&nbsp;</strong></small></td>
	   </tr>
	   </table>
   
   </td>
   
   <td>
   
	   <table width='190' border='0'>
	   <tr align='center'>
	   <td>&nbsp;</td>
	   <td class='w3-tiny'>Amount</td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;W-Tax</td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;SSS</td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;SSS Loan</td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;Pag-Ibig</td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;Pag-Ibig Loan</td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;Pag-Ibig Calamity Loan</td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;PhilHealth</td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;Salary Loan</td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;Cash Advance</td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;Veterans Loan</td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;Charges</td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;Over in Previous Pay</td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   
	   <tr><td class='w3-tiny'>&nbsp;</td></tr>
	   <tr><td class='w3-tiny'>&nbsp;</td></tr>
	   <tr><td class='w3-tiny'>&nbsp;</td></tr>
	   <tr><td class='w3-tiny'>&nbsp;</td></tr>
	   <tr><td class='w3-tiny'>&nbsp;</td></tr>
	   <tr><td class='w3-tiny'>&nbsp;</td></tr>
	   <tr><td class='w3-tiny'>&nbsp;</td></tr>
	   <tr><td class='w3-tiny'>&nbsp;</td></tr>
	   <tr><td class='w3-tiny'>&nbsp;</td></tr>
	   <tr><td class='w3-tiny'><strong>&nbsp;TOTAL DEDUCTIONS</strong></td>
	   <td align='right'><strong><small>0.00&nbsp;</small></strong></td>
	   </tr>
	   </table>
   
   </td>
 </tr>
 
 <tr>
	<td colspan='2' align='center'><strong><br><span class='w3-small'>NET PAY:</span>&nbsp;&nbsp;&nbsp;<span class='w3-large'>50,000.00</span></strong><br><br></td>
 </tr> 
 <tr>
	<td colspan='2' align='center'><br><span class='w3-tiny'>I acknowledge that ALL DEDUCTIONS herein are with my<br>PRIOR CONSENT and are therefore AUTHORIZED.</span>
	<br><br>
	<small><strong>Castro, Maria Angela Carina Y.</strong></small>
	</td>
 </tr> 
 <tr>
	<td colspan='2' align='center'>
	<span class='w3-tiny'>SIGNATURE OVER PRINTED NAME</span>
	<br><br>
	</td>
 </tr>
 
</table>



<br/><br/>



<table width='380' border="1">

 <tr height="50">
   <td colspan="2" align="center">
     <table>
	   <tr>
	     <td>
		  <img src="img/KAT.jpg" height="35" width="80"/>
		 </td>
		 <td align="center">
          <div class='w3-tiny'><strong>Katrinka's Kitchen</strong><br>Valencia Street Puerto Princesa City</div>
         </td>
	   </tr>
	 </table>      
   </td>
 </tr>
 
 <tr align='center'>
   <td colspan='2'><span class='w3-tiny'>DEPT:</span> <small><strong>MANAGEMENT</strong></small></td>
 </tr>
 <tr>
   <td><small>&nbsp;ID No. <strong></strong></small></td>
   <td><small>&nbsp;<strong>Castro, Alex Cesar L.</strong></small></td>
 </tr>
 
 <tr>
   <td><small>&nbsp;Payroll Period: <strong><?php echo date('m/d/Y',strtotime($_REQUEST['payroll_period'])); ?></strong></small></td>
   <td><small>&nbsp;Rate/Day: <strong></strong></small></td>
 </tr>
 
 <tr align='center' class='w3-tiny'>
   <td>EARNINGS</td><td>DEDUCTIONS</td>
 </tr>
 
 <tr>
   <td>
   
	   <table width='190' border='0'>
	   <tr align='center'>
	   <td>&nbsp;</td>
	   <td class='w3-tiny'>Hours&nbsp;</td>
	   <td class='w3-tiny'>Amount</td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Basic Pay</td>
	   <td align='center'><small>104</small></td>
	   <td align='right'><small>50,000.00&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Overtime</td>
	   <td align='center'><small>0.00</small></td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Day Off</td>
	   <td align='center'><small>0.00</small></td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Day Off OT</td>
	   <td align='center'><small>0.00</small></td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Night Diff</td>
	   <td align='center'><small>0.00</small></td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Night Diff OT</td>
	   <td align='center'><small>0.00</small></td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Reg Holiday</td>
	   <td align='center'><small>0.00</small></td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Reg Holiday OT</td>
	   <td align='center'><small>0.00</small></td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Special Holiday</td>
	   <td align='center'><small>0.00</small></td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Spec. Holiday OT</td>
	   <td align='center'><small>0.00</small></td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Sick Leave</td>
	   <td align='center'><small>0.00</small></td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Vacation Leave</td>
	   <td align='center'><small>0.00</small></td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Solo Parent Leave</td>
	   <td align='center'><small>0.00</small></td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Lates</td>
	   <td align='center' class='w3-tiny'>(0 min)</td>
	   <td align='right' class='w3-tiny'>(0.00)&nbsp;</td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Absences</td>
	   <td align='center' class='w3-tiny'>(0.00)</td>
	   <td align='right' class='w3-tiny'>(0.00)&nbsp;</td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Undertime</td>
	   <td align='center' class='w3-tiny'>(0.00)</td>
	   <td align='right' class='w3-tiny'>(0.00)&nbsp;</td>
	   </tr>
	   
	    <tr>
	   <td class='w3-tiny'>&nbsp;Meal Allowance</td>
	   <td></td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Allowance 15th</td>
	   <td></td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Allowance 30th</td>
	   <td></td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'>&nbsp;Adjustment</td>
	   <td></td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   
	   <tr>
	   <td class='w3-tiny'><strong>&nbsp;GROSS PAY</strong></td>
	   <td></td>
	   <td align='right'><small><strong>50,000.00&nbsp;</strong></small></td>
	   </tr>
	   </table>
   
   </td>
   
   <td>
   
	   <table width='190' border='0'>
	   <tr align='center'>
	   <td>&nbsp;</td>
	   <td class='w3-tiny'>Amount</td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;W-Tax</td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;SSS</td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;SSS Loan</td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;Pag-Ibig</td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;Pag-Ibig Loan</td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;Pag-Ibig Calamity Loan</td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;PhilHealth</td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;Salary Loan</td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;Cash Advance</td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;Veterans Loan</td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;Charges</td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   <tr>
	   <td class='w3-tiny'>&nbsp;Over in Previous Pay</td>
	   <td align='right'><small>0.00&nbsp;</small></td>
	   </tr>
	   
	   <tr><td class='w3-tiny'>&nbsp;</td></tr>
	   <tr><td class='w3-tiny'>&nbsp;</td></tr>
	   <tr><td class='w3-tiny'>&nbsp;</td></tr>
	   <tr><td class='w3-tiny'>&nbsp;</td></tr>
	   <tr><td class='w3-tiny'>&nbsp;</td></tr>
	   <tr><td class='w3-tiny'>&nbsp;</td></tr>
	   <tr><td class='w3-tiny'>&nbsp;</td></tr>
	   <tr><td class='w3-tiny'>&nbsp;</td></tr>
	   <tr><td class='w3-tiny'>&nbsp;</td></tr>
	   <tr><td class='w3-tiny'><strong>&nbsp;TOTAL DEDUCTIONS</strong></td>
	   <td align='right'><strong><small>0.00&nbsp;</small></strong></td>
	   </tr>
	   </table>
   
   </td>
 </tr>
 
 <tr>
	<td colspan='2' align='center'><strong><br><span class='w3-small'>NET PAY:</span>&nbsp;&nbsp;&nbsp;<span class='w3-large'>50,000.00</span></strong><br><br></td>
 </tr> 
 <tr>
	<td colspan='2' align='center'><br><span class='w3-tiny'>I acknowledge that ALL DEDUCTIONS herein are with my<br>PRIOR CONSENT and are therefore AUTHORIZED.</span>
	<br><br>
	<small><strong>Castro, Alex Cesar L.</strong></small>
	</td>
 </tr> 
 <tr>
	<td colspan='2' align='center'>
	<span class='w3-tiny'>SIGNATURE OVER PRINTED NAME</span>
	<br><br>
	</td>
 </tr>
 
</table>