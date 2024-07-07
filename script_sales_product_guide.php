<?php // Product Code Guide Start --->
	  if($access['d1']==1)
	    { 
	      if(isset($_REQUEST['guides'])) 
	        { 
		      $qcode=mysql_query("select * from sales_codes order by code_set asc, code_name asc") or die(mysql_error());
			  $rcode=mysql_fetch_assoc($qcode);
			  
			  if(isset($_REQUEST['success'])){ echo "<b class='w3-text-green'>Add Code Success!</b>"; }
			  
			  if($access['d24']==1)
			        { 
			   echo "<table class='table'>";
			   
			   echo "<tr class='w3-small'>
					  <form method='get' action='script_sales_add_product.php'>
					    <td>Code Tag
							<input required class='form-control' name='code_tag' type='text' placeholder='Code Color: D=1 O=2 P=3 S=4'>
					    </td>
					    <td>Code Set
							<input required class='form-control' name='code_set' type='text' placeholder='Ex. D3'>
					    </td>
					    <td>Code Name
							<input required class='form-control' name='code_name' type='text' placeholder='Ex DIGITAL'>
					    </td>
							
					    <td>Code Description
							<input required class='form-control' name='code_descriptions' type='text' placeholder='Ex. Riso Printing'>
					    </td>
					   
					    <td>Code Products
							<input required class='form-control' name='code_products' type='text' placeholder='Code Products'>
					    </td>
					   
					    <td>"; ?><br>
							<input class='btn btn-danger' name='add_product' type='submit' value='ADD CODE' onclick='return confirm("ADD NEW PRODUCT NOW??")'>
			<?php echo "</td>
					   </form>
					 </tr>
				  </table>";
			        }	
					
					
					
					
			echo "<table class='table'>
					<tr align='center' class='w3-dark-gray w3-small'>
					   <td>CODE</td>
					   <td width='300'>NAME</td>
					   <td>DESCRIPTION</td>
					   <td>PRODUCTS</td>
					 </tr>";
			  do{
				 
                 if($rcode['code_tag']==1){ echo "<tr class='w3-hover-pale-red w3-text-indigo'>"; }
				 if($rcode['code_tag']==2){ echo "<tr class='w3-hover-pale-red w3-text-teal'>"; }
				 if($rcode['code_tag']==3){ echo "<tr class='w3-hover-pale-red w3-text-gray'>"; }
				 if($rcode['code_tag']==4){ echo "<tr class='w3-hover-pale-red w3-text-amber'>"; }
				 if($rcode['code_tag']==5){ echo "<tr class='w3-hover-pale-red w3-text-cyan'>"; }
				 if($rcode['code_tag']==6){ echo "<tr class='w3-hover-pale-red w3-text-red'>"; }
				 if($rcode['code_tag']==7){ echo "<tr class='w3-hover-pale-red w3-text-green'>"; }
				 if($rcode['code_tag']==8){ echo "<tr class='w3-hover-pale-red w3-text-brown'>"; }
				 if($rcode['code_tag']==9){ echo "<tr class='w3-hover-pale-red w3-text-purple'>"; }
				 
					 echo "<td><b>".$rcode['code_set']."</b></td>
							 <td>".$rcode['code_name']."</td>
							 <td>".$rcode['code_desc']."</td>
							 <td class='w3-tiny'>".$rcode['code_products']."</td>
						   </tr>";
					 
			    } while($rcode=mysql_fetch_assoc($qcode));
				echo "</table>";
			} 
	    } 
		// Product Code Guide End --->
?>