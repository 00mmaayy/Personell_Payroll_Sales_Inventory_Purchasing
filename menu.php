<?php if($access['a1']==1){ ?><a href="admin.php?payroll=1&payroll_processing=1" class="w3-padding" ><i class="fa fa-money fa-fw"></i>  Payroll</a><?php } ?>
<?php if($access['b1']==1){ ?><a href="admin.php?personnel=1" class="w3-padding" ><i class="fa fa-user fa-fw"></i>  Personnel</a><?php } ?>
<?php if($access['c1']==1){ ?><a href="admin_proc.php?procurement=1&po_list=1" class="w3-padding" ><i class="fa fa-cart-plus fa-fw"></i>  Supply & Procurement</a><?php } ?>
<?php if($access['i1']==1){ ?><a href="admin_inv.php?inventory=1" class="w3-padding" ><i class="fa fa-shopping-basket fa-fw"></i>  Inventory</a><?php } ?>
<?php if($access['f1']==1){ ?><a href="admin_acctg.php?accounting=1" class="w3-padding" ><i class="fa fa-list fa-fw"></i>  Accounting</a><?php } ?>
<?php if($access['p1']==1){ ?><a href="admin.php?or=1" class="w3-padding" ><i class="fa fa-cubes fa-fw"></i>  O.R. Monitoring</a><?php } ?>
<?php if($access['d1']==1){ ?><a href="admin_sales.php?sales=1" class="w3-padding" ><i class="fa fa-calculator fa-fw"></i>  Sales</a><?php } ?>

<!--memo central menu start -->
<?php if($access['m1']==1){ ?><a href="../memocentral/index.php?user=<?php echo $_SESSION['username']; ?>" target="_blank" class="w3-padding" >
									<i class="fa fa-sticky-note-o fa-fw"></i>  
										Memo Central  
										
										<?php
											//mysql_select_db("memocentral") or die("I Couldn't select your database");
											$date_now=date('Y-m-d');
											$smemo="select count(upload_datetime) as count_me from memocentral.memo_table where upload_datetime like '%$date_now%'";
											$qmemo=mysql_query($smemo) or die(mysql_error());
											$rmemo=mysql_fetch_assoc($qmemo);
										
										if($rmemo['count_me']==0){}
										else{ echo "<span class='w3-badge w3-red'>".$rmemo['count_me']."</span>"; } ?>
										
							  </a><?php } ?>
<!--memo central menu end-->

<?php if($access['z1']==1){ ?><a href="admin.php?settings=1" class="w3-padding" ><i class="fa fa-gear fa-fw"></i>  Settings</a><?php } ?>
<a href="index.php?logout=1" class="w3-padding" ><i class="fa fa-power-off fa-fw"></i>  Logout</a>