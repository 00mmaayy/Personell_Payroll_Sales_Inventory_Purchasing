<?php // Clients Start --->
	  if($access['d19']==1)
	    { 
	      if(isset($_REQUEST['clients'])) 
	        { ?> 
		      <table class='table'>
				<tr class='w3-dark-gray w3-tiny'><td colspan='8'>ADD CLIENT AREA &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class='w3-text-khaki' target='_blank' href='script_sales_client_list.php?sort=all'>Printable Client List</a></td></tr>
					<?php if(isset($_REQUEST['add_success'])){ echo "<b class='w3-large w3-text-green'>Add Client Success!</b>"; } ?>
					<form method='get' action='script_sales_addclient.php'>
			    <tr>
					<td><i class='w3-tiny'>Client Name</i><br/><input class='form-control' required name='newclient' type='text' placeholder='New Client Name'></td>
					<td><i class='w3-tiny'>TIN</i><br/><input class='form-control' required name='tin' type='text' placeholder='TIN' value='N/A'></td>
					<td><i class='w3-tiny'>Mobile</i><br/><input class='form-control' required name='cp' type='text' placeholder='Mobile' value='N/A'></td>
					<td><i class='w3-tiny'>Email</i><br/><input class='form-control' required name='email' type='text' placeholder='Email' value='N/A'></td>
					<td><i class='w3-tiny'>Tel No.</i><br/><input class='form-control' name='telno' type='text' placeholder='Tel No.' value='N/A'></td>
					<td><i class='w3-tiny'>Address</i><br/><input class='form-control' name='clientaddr' type='text' placeholder='Address' value='N/A'></td>
					<td><i class='w3-tiny'>Contact Person</i><br/><input class='form-control' name='contact_person' type='text' placeholder='Contact Person' value='N/A'></td>
					<td><i class='w3-tiny'>&nbsp;</i><br/><input class='btn btn-danger' name='addclient' type='submit' value='ADD CLIENT' onclick='return confirm("ADD CLIENTS NOW?")'></td>
					</form>
				</tr>	
			  
			  <!---Ajax Search Start--->
		        <script src="js/ajaxloader.js"></script>
		        <script>
				function showHint(str)
				{
				var s=document.getElementById("search").value;
				var xmlhttp;


				if (window.XMLHttpRequest)
				  {// code for IE7+, Firefox, Chrome, Opera, Safari
				  xmlhttp=new XMLHttpRequest();
				  }
				else
				  {// code for IE6, IE5
				  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
				  }
				xmlhttp.onreadystatechange=function()
				  {
				  if (xmlhttp.readyState==4 && xmlhttp.status==200)
					{
					document.getElementById("view_result").innerHTML=xmlhttp.responseText;
					}
				  }
				xmlhttp.open("GET","script_sales_clients.php?s="+s,true);
				xmlhttp.send();
				}
				</script>
			    <br>
				<table width='100%'>
				  <tr><td class='w3-text-red w3-tiny'><b>CLIENT SEARCH (hit ENTER to show query)</b></td></tr>
				  <tr valign='top'><td><input class='form-control' type="text" placeholder='Input Client Name' id="search" name="search" onkeyup="showHint('x')"/>&nbsp;&nbsp;</td></tr>
				  <tr><td><div id="view_result"></div></td></tr>
			    </table>             
				<!---Ajax Search End--->
	
	  <?php }	   
        } // Clients End --->
?>