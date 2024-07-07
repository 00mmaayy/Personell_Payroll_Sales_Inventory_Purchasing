<?php $current_user=$_SESSION['username'];
	  $s9="select * from users where username='$current_user'";
	  $q9=mysql_query($s9) or die(mysql_error());
	  $r9=mysql_fetch_assoc($q9);
		 
	  $e_fname=$r9['first_name'];
	  $e_lname=$r9['last_name'];
	  $s91="select e_no from employee where e_fname='$e_fname' and e_lname='$e_lname'";
	  $q91=mysql_query($s91) or die(mysql_error());
	  $r91=mysql_fetch_assoc($q91);
		 
	  $spas="select * from user_access where username='$current_user'";
	  $qpas=mysql_query($spas) or die(mysql_error());
	  $access=mysql_fetch_assoc($qpas);
	  
	  $current_position=$r9['position'];
	  $s8="select * from user_positions where position='$current_position'";
	  $q8=mysql_query($s8) or die(mysql_error());
	  $r8=mysql_fetch_assoc($q8);
?>