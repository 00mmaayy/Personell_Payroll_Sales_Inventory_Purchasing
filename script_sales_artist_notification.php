<?php 
	//ARTIST NOTIFICATION AREA START-----
	$artist=$r9['first_name'].", ".$r9['last_name'];
	$sxx="SELECT a.*,c.name AS client_id
		  FROM sales_jo_assign AS a 
		  INNER JOIN sales_jo AS s ON s.jo_no=a.jo_no
		  INNER JOIN sales_clients AS c ON s.client_id=c.client_id
		  WHERE s.completed_by=''
		  AND a.assign_to='$artist'
		  ORDER BY s.jo_no DESC";
	$qxx=mysql_query($sxx);
	$rxx=mysql_fetch_assoc($qxx);

	if($rxx['jo_no'])
	{
	echo "<table class='table'><tr class='w3-gray'><td>JO NO</td><td>CLIENT</td><td>ARTIST ASSIGNED</td><td>ASSIGN DATE</td></tr>";
	do { echo "<tr class='w3-hover-pale-red'><td>".$rxx['jo_no']."</td><td>".$rxx['client_id']."</td><td>".$rxx['assign_to']."</td><td>".date('F d, Y',strtotime($rxx['assign_date']))."</td></tr>"; } while($rxx=mysql_fetch_assoc($qxx));
	echo "</table>";
	}
	//ARTIST NOTIFICATION AREA END-----
?> 