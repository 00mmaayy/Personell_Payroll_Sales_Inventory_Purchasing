<?php 
session_start();
include('connection/conn.php');
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); }

$lastname=$_REQUEST['s'];
$sql=mysql_query("select e_no,e_fname,e_lname from employee where e_lname like '%$lastname%' order by e_lname asc");
while ($row = mysql_fetch_array($sql))
{ 
	echo "&nbsp;&nbsp;<a href='inv_mr.php?e_no=".$row['e_no']."&e_lname=".$row['e_lname']."&e_fname=".$row['e_fname']."'>".$row['e_lname'].", ".$row['e_fname']."</a><br>";
} ?>
