<?php

# HTTP="true"
$pps_hostname = "localhost";
$pps_database = "pps";
$pps_username= "root";
$pps_password = "1342567890";
$ppsconn = mysql_connect($pps_hostname,$pps_username,$pps_password,true) or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_set_charset('utf8');
$ppsdb=mysql_select_db($pps_database) or die("I Couldn't select your database");
?>
