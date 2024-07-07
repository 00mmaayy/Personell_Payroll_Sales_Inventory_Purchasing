<?php 
session_start();
include('connection/conn.php');
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); }
date_default_timezone_set("Asia/Manila");
include("css.php");
?>

<style type="text/css" media="screen">
/* latin */
@font-face {
  font-family: 'Libre Barcode 39';
  font-style: normal;
  font-weight: 400;
  src: local('Libre Barcode 39 Regular'), local('LibreBarcode39-Regular'), url(fonts/barcode.woff2) format('woff2');
  unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
}
.barcode { font-family: 'Libre Barcode 39';font-size: 30px; }
</style>

<br/>
<div align="center"><a class='w3-button w3-blue' href="script_sales_fg_tagging.php?find=1" target="_blank">TABLET TAGGING</a></div>

<?php
	if($_REQUEST['bch']!="goc")
	{
		switch($_REQUEST['bch'])
		{
			case "main": $branch="SALES"; break;
			case "sm": $branch="SM SALES"; break;
			case "rzl": $branch="RIZAL SALES"; break;
			case "sp": $branch="SANPEDRO SALES"; break;
			case "sj": $branch="SANJOSE SALES"; break;
		}
		
		$s91="select a.*, b.name, b.vip, c.department
			  from sales_jo a
		      left join sales_clients b on a.client_id=b.client_id
			  left join users c on a.created_by=c.username
		      where a.production_status=1 and a.delivered=0 and c.department='$branch'
			  order by c.department asc, a.production_date desc";
			  
  $s91_total="select sum(jo_amount) as jo_amount_total
			  from sales_jo a
		      left join sales_clients b on a.client_id=b.client_id
			  left join users c on a.created_by=c.username
		      where a.production_status=1 and a.delivered=0 and c.department='$branch'";
	}
	else
	{
		if(isset($_REQUEST['branch']))
		{ 
			if($_REQUEST['branch']!="ALL")
			{
				$branch1=$_REQUEST['branch']; 
				$branch="and c.department='$branch1'"; 
			}else{ $branch=""; } 
		}else{ $branch=""; }
		
		$s91="select a.*, b.name, b.vip, c.department 
			  from sales_jo a
		      left join sales_clients b on a.client_id=b.client_id
			  left join users c on a.created_by=c.username
		      where a.production_status=1 and a.delivered=0 $branch
			  order by c.department asc, a.production_date desc";
			  
  $s91_total="select sum(jo_amount) as jo_amount_total
			  from sales_jo a
		      left join sales_clients b on a.client_id=b.client_id
			  left join users c on a.created_by=c.username
		      where a.production_status=1 and a.delivered=0 $branch";  
	}		

	
	$q91=mysql_query($s91) or die(mysql_error());
	$r91=mysql_fetch_assoc($q91);
	
	$q91_total=mysql_query($s91_total) or die(mysql_error());
	$r91_total=mysql_fetch_assoc($q91_total);
	
	echo "<div class='container'><br/>
		  <table class='table w3-tiny'>
			<tr>
				<td colspan='8'>
				<b>FINISH GOODS:</b>
				<br/>
				TOTAL: <b class='w3-text-red'> ".number_format($r91_total['jo_amount_total'],2)."</b>
				<br/>"; 
				
				
				if($_REQUEST['bch']=="goc")
				{
				?>
					<form>
						<input name='search' type='hidden' value='finish_goods'>
						<input name='bch' type='hidden' value='goc'>
						
						<select required name='branch'>
						<option><?php if($_REQUEST['branch']!=""){ echo $_REQUEST['branch'];} ?></option>
						<option></option>
						<option>ALL</option>
				  <?php $sa="select users.department as dept,count(department) from users inner join sales_jo on sales_jo.created_by=users.username group by users.department";
						$qa=mysql_query($sa);
						$ra=mysql_fetch_assoc($qa);
						do{
						echo "<option>".$ra['dept']."</option>"; 
						}while($ra=mysql_fetch_assoc($qa)); ?>
						</select>
					
						<input type='submit' value='FILTER' >
					</form>
			<?php
				}else{}
				
				
			echo "</td>
			</tr>
			<tr class='w3-green'>
				<td>BRANCH</td>
				<td>JO NO</td>
				<td>BOOKING NO</td>
				<td>BOOKING DATE</td>
				<td>JO ACTUAL</td>
				<td>JO ACTUAL DATE</td>
				<td>FG Date</td>
				<td>CLIENT</td>
				<td>BARCODE</td>
				<td align='right'>JO AMOUNT</td>
			</tr>";
		$x=1;	
	do{
		switch($r91['paid'])
				{ 	case 0: $paidd="<i class='w3-text-red'>".$x++.". Not</i> | "; break;
					case 1: $paidd="<i class='w3-text-blue'>".$x++.". Paid</i> | "; break; 
				}
		echo "<tr class='w3-hover-pale-red'>
				<td>$paidd".$r91['department']."</td>
				<td>".$r91['jo_no']."</td>
				<td>".$r91['bo_no']."</td>
				<td>".date('m/d/Y',strtotime($r91['bo_no_date']))."</td>
				<td>".$r91['jo_actual']."</td>
				<td>".date('m/d/Y',strtotime($r91['jo_actual_date']))."</td>
				
				<td>
					
					<b>".date('m/d/Y',strtotime($r91['production_date']))."</b><br/>";
					$fg_date_old = strtotime($r91['production_date']);
					$now1 = strtotime(date('Y-m-d'));
					$day1 = ((($now1-$fg_date_old)/3600)/24);
					
					if($day1>=1)
					{
					echo "<i class='w3-tiny w3-text-red'><b>".floor($day1)." Day/s on FG Room</b></i>";
					}else{}
				
				 echo "</td>";
				/*
0 = Cash
1 = VIP
2 = Government
3 = COD
4 = X-Deal
5 = Account
*/
				switch($r91['vip'])
				{
					case 0: $vip2="Cash"; break;
					case 1: $vip2="VIP"; break;
					case 2: $vip2="Government"; break;
					case 3: $vip2="COD"; break;
					case 4: $vip2="X-Deal"; break;
					case 5: $vip2="Account"; break;
				}
				
				
		  echo "<td><i class='w3-text-orange'>[$vip2]</i> <a href='admin_sales.php?client_id=".$r91['client_id']."&client=".$r91['name']."&sales=1&newjobs=1&create_quotation=1' target='_blank'>".$r91['name']."</a></td>";
			echo "<td class='barcode'>*".$r91['jo_no']."*</td>";	
		  echo "<td align='right' class='w3-text-red'><b>".number_format($r91['jo_amount'],2)."</b></td>
			  </tr>";
	}while($r91=mysql_fetch_assoc($q91));
	echo "</table>
		  </div>";

?>

<div align='center'>
<a class='w3-xlarge' href="javascript:window.open('','_self').close();">X</a>
</div>