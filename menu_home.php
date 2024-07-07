<!--Home Start-->
  <?php if(isset($_REQUEST['home'])) { ?>   
	<div class="w3-col">
      <div class="w3-container w3-blue w3-padding-15">
	    <div class="w3-left w3-xlarge"><i class="fa fa-home w3-xlarge"></i>  Home</div>
      </div>
	  <br>
	  
	  <style>
		/* latin */
		@font-face
		{
		font-family: 'Tangerine';
		font-style: normal;
		font-weight: 400;
		src: local('Tangerine Regular'), local('Tangerine-Regular'), url(https://fonts.gstatic.com/s/tangerine/v9/IurY6Y5j_oScZZow4VOxCZZM.woff2) format('woff2');
		unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
		}

		.w3-tangerine
		{
		font-family: "Tangerine", serif;
		}
	  </style>
	  
	  <style>
	  div.polaroid 
	  {
      width: 370px;
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
      text-align: center;
	  }
	  
	  h1 { text-shadow: 2px 2px 5px red; }
	  </style>
	  
	      <table>            
 			<tr align='center'> 
			  <td colspan='3'><div class='polaroid'><img src="img/<?php echo $r['company']; ?>.jpg" /></div><br><br></td>
			</tr>  
			
			<tr>
			     <td align='center' width='500'><h1><span class="w3-xxxlarge w3-tangerine">Our Mission:</span></h1></td>
				 <td width='50'></td>
				 <td align='center' width='500'><h1><span class="w3-xxxlarge w3-tangerine">Our Vision:</span></h1></td>
			</tr>
			
			<tr valign='top'>
				 <td align='center'><i>To provide a ONE STOP SHOP printing Services<br>to cater to the printing needs of clients.<br>To maintain customers guaranteeing customer satisfaction.</i></td>
				 <td></td>
				 <td align='center'><i>To be the number one printing company of Palawan in terms of facilities,<br>manpower and gross sales.</i></td>
			</tr>
		  </table>	 
		
			
    </div>
  <?php } ?>
  <!--Home End-->