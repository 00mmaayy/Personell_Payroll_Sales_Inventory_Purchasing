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

<?php
$keyword=$_REQUEST['keyword'];
$sdate=$_REQUEST['sdate'];
$edate=$_REQUEST['edate'];
$s="select * from logbook where date>='$sdate' and date<='$edate' and  transaction like '%$keyword%' order by date desc, time desc";
$q=mysql_query($s) or die(mysql_error());
$r=mysql_fetch_assoc($q);

echo "<table border='1' class='table-hover'>
        <tr class='bg-primary' align='center'>
		  <td width='100'>Date</td>
		  <td width='100'>Time</td>
		  <td width='100'>Updated by</td>
		  <td width='100'>Transaction Details</td>
		</tr>";

do{

echo "<tr><td><small>".date('m-d-Y', strtotime($r['date']))."<small></td>
          <td><small>".$r['time']."<small></td>
		  <td><small>".$r['username']."<small></td>
		  <td><small>".$r['transaction']."</small></td>
		  </tr>";

 } while($r=mysql_fetch_assoc($q)); ?>
</table>