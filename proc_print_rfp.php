<?php 
session_start();
include('connection/conn.php');
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); }
include("css.php");

$rfp_no=$_REQUEST['rfp_no'];
$s="select * from proc_rfp where rfp_no='$rfp_no'";
$q=mysql_query($s) or die(mysql_error());
$r=mysql_fetch_assoc($q);
$num=$r['rfp_amount'];
?>

<style>
img.proc_rfp { position: absolute; z-index: -1; }
div.request_type { position: absolute; left: 690px; top: 120px; z-index: -1; }

div.payment { position: absolute; left: 465px; top: 85px; z-index: -1; }
div.cash_advance { position: absolute; left: 465px; top: 120px; z-index: -1; }
div.reimbursement { position: absolute; left: 625px; top: 85px; z-index: -1; }

div.rfp_no { position: absolute; left: 680px; top: 120px; z-index: -1; }
div.amount_words { position: absolute; left: 130px; top: 98px; z-index: -1; }
div.amount { position: absolute; left: 150px; top: 137px; z-index: -1; }

div.rfp_date { position: absolute; left: 65px; top: 71px; z-index: -1; }
div.particular { position: absolute; left: 30px; top: 190px; z-index: -1; }
div.supplyandproc { position: absolute; left: 300px; top: 71px; z-index: -1; }
div.terms { position: absolute; left: 60px; top: 470px; z-index: -1; }
div.apple { position: absolute; left: 55px; top: 530px; z-index: -1; }
div.date_needed { position: absolute; left: 250px; top: 530px; z-index: -1; }
div.sharm { position: absolute; left: 380px; top: 530px; z-index: -1; }
div.gm { position: absolute; left: 580px; top: 530px; z-index: -1; }
</style>

<!--<img class='proc_rfp' src='img/proc_rfp.jpg'>-->
<div class='rfp_date w3-tiny'><b><?php echo date('m/d/Y h:i A',strtotime($r['add_date'])); ?></b></div>
<div class='supplyandproc w3-tiny'><b>SUPPLY AND PROCUREMENT</b></div>


	<b>
		<?php 
				if($r['request_type']=="PAYMENT"){ echo "<div class='payment w3-xlarge'>X</div>"; }
				if($r['request_type']=="CASH ADVANCE"){ echo "<div class='cash_advance w3-xlarge'>X</div>"; }
				if($r['request_type']=="REIMBURSEMENT"){ echo "<div class='reimbursement w3-xlarge'>X</div>"; }
		?>
	</b>


<div class='rfp_no w3-xlarge'><b><?php // echo $_REQUEST['rfp_no']; ?></b></div>
<div class='amount'><b>P &nbsp;<?php echo number_format($num,2); ?></b></div>

<div class='terms'>
<?php
$gs2=mysql_query("select b.terms_desc as terms_desc 
					from proc_rfp as a 
					inner join proc_terms as b 
					on a.rfp_terms=b.id 
					where a.rfp_no='$rfp_no'") or die(mysql_error());
					$gr2=mysql_fetch_assoc($gs2);
					echo "<b>".$gr2['terms_desc']."</b>";
?>
</div>

<div class='particular'>
<?php
$x1="select * from proc_po where rfp_no='$rfp_no'";
$y1=mysql_query($x1) or die(mysql_error());
$z1=mysql_fetch_assoc($y1);
do{
	echo "PO# ".$z1['po_no']
		."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".date('m/d/Y',strtotime($z1['add_date']))
		."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		  &nbsp;&nbsp;".number_format($z1['po_amount'],2)."<br/>";
}while($z1=mysql_fetch_assoc($y1));
echo "RR# ".$r['RR']."&nbsp;&nbsp;";
if($r['RR_date']!="0000-00-00"){ echo "(".date('m/d/Y',strtotime($r['RR_date'])).")"; }
echo "<br/>";
echo "SI# ".$r['SI']."&nbsp;&nbsp;";
if($r['SI_date']!="0000-00-00"){ echo "(".date('m/d/Y',strtotime($r['SI_date'])).")"; }
?>
</div>






<div class='apple w3-tiny'><b>CHERYL P. FERRER</b></div>
<div class='date_needed w3-tiny'><b><?php echo date('m/d/Y',strtotime($r['date_needed'])); ?></b></div>
<div class='sharm w3-tiny'><b>SHARMAINE L. MANLAPAZ</b></div>
<div class='gm w3-tiny'><b>MARIA ANGELA CARINA Y. CASTRO</b></div>
<?php
// AMOUNT IN WORDS START
function numberTowords($num)
{ 
$ones = array(
0 =>"ZERO", 
1 => "ONE", 
2 => "TWO", 
3 => "THREE", 
4 => "FOUR", 
5 => "FIVE", 
6 => "SIX", 
7 => "SEVEN", 
8 => "EIGHT", 
9 => "NINE", 
10 => "TEN", 
11 => "ELEVEN", 
12 => "TWELVE", 
13 => "THIRTEEN", 
14 => "FOURTEEN", 
15 => "FIFTEEN", 
16 => "SIXTEEN", 
17 => "SEVENTEEN", 
18 => "EIGHTEEN", 
19 => "NINETEEN",
"014" => "FOURTEEN" 
); 
$tens = array( 
0 => "ZERO",
1 => "TEN",
2 => "TWENTY",
3 => "THIRTY", 
4 => "FORTY", 
5 => "FIFTY", 
6 => "SIXTY", 
7 => "SEVENTY", 
8 => "EIGHTY", 
9 => "NINETY" 
); 
$hundreds = array( 
"HUNDRED", 
"THOUSAND", 
"MILLION", 
"BILLION", 
"TRILLION", 
"QUARDRILLION" 
); /*limit t quadrillion */
$num = number_format($num,2,".",","); 
$num_arr = explode(".",$num); 
$wholenum = $num_arr[0]; 
$decnum = $num_arr[1]; 
$whole_arr = array_reverse(explode(",",$wholenum)); 
krsort($whole_arr,1); 
$rettxt = ""; 
foreach($whole_arr as $key => $i){
	
while(substr($i,0,1)=="0")
		$i=substr($i,1,5);
if($i < 20){ 
/* echo "getting:".$i; */
$rettxt .= $ones[$i]; 
}elseif($i < 100){ 
if(substr($i,0,1)!="0")  $rettxt .= $tens[substr($i,0,1)]; 
if(substr($i,1,1)!="0") $rettxt .= " ".$ones[substr($i,1,1)]; 
}else{ 
if(substr($i,0,1)!="0") $rettxt .= $ones[substr($i,0,1)]." ".$hundreds[0]; 
if(substr($i,1,1)!="0")$rettxt .= " ".$tens[substr($i,1,1)]; 
if(substr($i,2,1)!="0")$rettxt .= " ".$ones[substr($i,2,1)]; 
} 
if($key > 0){ 
$rettxt .= " ".$hundreds[$key]." "; 
}
} 
if($decnum > 0){ 
$rettxt .= " and "; 
if($decnum < 20){ 
$rettxt .= $ones[$decnum]; 
}elseif($decnum < 100){ 
$rettxt .= $tens[substr($decnum,0,1)]; 
$rettxt .= " ".$ones[substr($decnum,1,1)]; 
} 
} 
return $rettxt; 
} 
echo "<div class='amount_words w3-tiny'>".wordwrap(numberTowords("$num"),100,"<br>\n")."</div>";
// AMOUNT IN WORDS END ?>
		
