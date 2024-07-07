<?php 
session_start();
include('connection/conn.php');
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); } ?>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/w3.css">
<link rel="stylesheet" href="css/font-awesome.min.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>

<body>
<?php
//$s="select * from employee where e_basic_pay>=12767 order by e_no asc"; Old Tax Policy
$s="select * from employee where e_basic_pay>=20834 order by e_no asc"; // Tax Policy of 2018
$q=mysql_query($s) or die(mysql_error());
$r=mysql_fetch_assoc($q);

	 
echo "<table class='table-hover' border='1'>
       <tr class='w3-blue' align='center'><td>ID No.</td><td>Name</td><td>Basic</td><td>Tax Level</td><td>W-Tax</td></tr>";
do{ 
    $basic_pay=$r['e_basic_pay'];
	
	if($basic_pay>=20834 && $basic_pay<=33333)
	{ $tax="tax 2"; 
      $over_cl=$basic_pay-20833;
	  $wtax=$over_cl*.15;
	}	
	
	if($basic_pay>=33334 && $basic_pay<=66666)
	{ $tax="tax 3"; 
      $over_cl=$basic_pay-33333;
	  $wtax=(($over_cl*.20)+(22500/12));
	}

    if($basic_pay>=66667 && $basic_pay<=166666)
	{ $tax="tax 4"; 
      $over_cl=$basic_pay-66667;
	  $wtax=(($over_cl*.25)+(102500/12));
	}

    if($basic_pay>=166667 && $basic_pay<=666666)
	{ $tax="tax 5"; 
      $over_cl=$basic_pay-166667;
	  $wtax=(($over_cl*.30)+(40250/12));
	}

    if($basic_pay>=666667 && $basic_pay<=9999999)
	{ $tax="tax 6"; 
      $over_cl=$basic_pay-666667;
	  $wtax=(($over_cl*.35)+(2202500/12));
	}
	
	//OLD TAX TABLE
	//if($basic_pay>=20834 && $basic_pay<=33333)
	//{ $tax="tax 2"; 
      //$over_cl=$basic_pay-20833;
	  //$wtax=$over_cl*.20;
	//}	
	
	//if($basic_pay>=33334 && $basic_pay<=66666)
	//{ $tax="tax 3"; 
      //$over_cl=$basic_pay-33333;
	  //$wtax=$over_cl*.25+2500;
	//}

    //if($basic_pay>=66667 && $basic_pay<=166666)
	//{ $tax="tax 4"; 
      //$over_cl=$basic_pay-66667;
	  //$wtax=$over_cl*.30+10833.33;
	//}

    //if($basic_pay>=166667 && $basic_pay<=666666)
	//{ $tax="tax 5"; 
      //$over_cl=$basic_pay-166667;
	 // $wtax=$over_cl*.32+40833.33;
	//}

    //if($basic_pay>=666667 && $basic_pay<=9999999)
	//{ $tax="tax 6"; 
      //$over_cl=$basic_pay-666667;
	 // $wtax=$over_cl*.35+200833.33;
	//}
	
	
	
	echo "<tr><td>".$r['e_no']."&nbsp;&nbsp;</td>
	          <td>".$r['e_lname'].", ".$r['e_fname']."</td>
	          <td align='right'>".number_format($basic_pay,2)."</td>
			  <td align='center'>&nbsp;$tax&nbsp;</td>
			  <td>&nbsp;".number_format($wtax,2)."&nbsp;</td>
	     <tr>";
     
	 $e_no=$r['e_no'];
	 $tax_q="update employee set e_tax=$wtax where e_no='$e_no'";
	 mysql_query($tax_q); 
	 
	 
}while($r=mysql_fetch_assoc($q));
echo "</table>";

//$sa="update employee set e_tax=0 where e_basic_pay<=12766"; Old Tax Policy
$sa="update employee set e_tax=0 where e_basic_pay<=20833"; // New Tax Policy of 2018
$qa=mysql_query($sa) or die(mysql_error());

$username=$_SESSION['username'];
$trans="Run Withholding Tax Update";
$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
$log_query=mysql_query($log_sql) or die(mysql_error());

?>
</body>