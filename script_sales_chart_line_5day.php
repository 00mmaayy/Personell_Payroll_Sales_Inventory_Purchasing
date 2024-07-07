<!--JO CHART STARTS HERE-->
<br /><br />
<div class='container'>
	<table>
		<tr>
			<td>

				<?php
				//CURRENT DAY
				if ($r1['main_total_jo'] != '') {
					$jo_main1 = $r1['main_total_jo'];
				} else {
					$jo_main1 = 0;
				}

				if ($r1['sm_total_jo'] != '') {
					$jo_sm1 = $r1['sm_total_jo'];
				} else {
					$jo_sm1 = 0;
				}

				if ($r1['sp_total_jo'] != '') {
					$jo_sp1 = $r1['sp_total_jo'];
				} else {
					$jo_sp1 = 0;
				}

				if ($r1['sj_total_jo'] != '') {
					$jo_sj1 = $r1['sj_total_jo'];
				} else {
					$jo_sj1 = 0;
				}

				if ($r1['rzl_total_jo'] != '') {
					$jo_rzl1 = $r1['rzl_total_jo'];
				} else {
					$jo_rzl1 = 0;
				}
				
				if ($r1['adpls_total_jo'] != '') {
					$jo_adpls1 = $r1['adpls_total_jo'];
				} else {
					$jo_adpls1 = 0;
				}

				//1 DAY AGO JO
				if ($r2['main_total_jo'] != '') {
					$jo_main2 = $r2['main_total_jo'];
				} else {
					$jo_main2 = 0;
				}

				if ($r2['sm_total_jo'] != '') {
					$jo_sm2 = $r2['sm_total_jo'];
				} else {
					$jo_sm2 = 0;
				}

				if ($r2['sp_total_jo'] != '') {
					$jo_sp2 = $r2['sp_total_jo'];
				} else {
					$jo_sp2 = 0;
				}

				if ($r2['sj_total_jo'] != '') {
					$jo_sj2 = $r2['sj_total_jo'];
				} else {
					$jo_sj2 = 0;
				}

				if ($r2['rzl_total_jo'] != '') {
					$jo_rzl2 = $r2['rzl_total_jo'];
				} else {
					$jo_rzl2 = 0;
				}
				
				if ($r2['adpls_total_jo'] != '') {
					$jo_adpls2 = $r2['adpls_total_jo'];
				} else {
					$jo_adpls2 = 0;
				}

				//2 DAYS AGO JO
				if ($r3['main_total_jo'] != '') {
					$jo_main3 = $r3['main_total_jo'];
				} else {
					$jo_main3 = 0;
				}

				if ($r3['sm_total_jo'] != '') {
					$jo_sm3 = $r3['sm_total_jo'];
				} else {
					$jo_sm3 = 0;
				}

				if ($r3['sp_total_jo'] != '') {
					$jo_sp3 = $r3['sp_total_jo'];
				} else {
					$jo_sp3 = 0;
				}

				if ($r3['sj_total_jo'] != '') {
					$jo_sj3 = $r3['sj_total_jo'];
				} else {
					$jo_sj3 = 0;
				}

				if ($r3['rzl_total_jo'] != '') {
					$jo_rzl3 = $r3['rzl_total_jo'];
				} else {
					$jo_rzl3 = 0;
				}
				
				if ($r3['adpls_total_jo'] != '') {
					$jo_adpls3 = $r3['adpls_total_jo'];
				} else {
					$jo_adpls3 = 0;
				}

				//3 DAYS AGO JO
				if ($r4['main_total_jo'] != '') {
					$jo_main4 = $r4['main_total_jo'];
				} else {
					$jo_main4 = 0;
				}

				if ($r4['sm_total_jo'] != '') {
					$jo_sm4 = $r4['sm_total_jo'];
				} else {
					$jo_sm4 = 0;
				}

				if ($r4['sp_total_jo'] != '') {
					$jo_sp4 = $r4['sp_total_jo'];
				} else {
					$jo_sp4 = 0;
				}

				if ($r4['sj_total_jo'] != '') {
					$jo_sj4 = $r4['sj_total_jo'];
				} else {
					$jo_sj4 = 0;
				}

				if ($r4['rzl_total_jo'] != '') {
					$jo_rzl4 = $r4['rzl_total_jo'];
				} else {
					$jo_rzl4 = 0;
				}
				
				if ($r4['adpls_total_jo'] != '') {
					$jo_adpls4 = $r4['adpls_total_jo'];
				} else {
					$jo_adpls4 = 0;
				}
				
				//4 DAYS AGO JO
				if ($r5['main_total_jo'] != '') {
					$jo_main5 = $r5['main_total_jo'];
				} else {
					$jo_main5 = 0;
				}

				if ($r5['sm_total_jo'] != '') {
					$jo_sm5 = $r5['sm_total_jo'];
				} else {
					$jo_sm5 = 0;
				}

				if ($r5['sp_total_jo'] != '') {
					$jo_sp5 = $r5['sp_total_jo'];
				} else {
					$jo_sp5 = 0;
				}

				if ($r5['sj_total_jo'] != '') {
					$jo_sj5 = $r5['sj_total_jo'];
				} else {
					$jo_sj5 = 0;
				}

				if ($r5['rzl_total_jo'] != '') {
					$jo_rzl5 = $r5['rzl_total_jo'];
				} else {
					$jo_rzl5 = 0;
				}
				
				if ($r5['adpls_total_jo'] != '') {
					$jo_adpls5 = $r5['adpls_total_jo'];
				} else {
					$jo_adpls5 = 0;
				}

				?>



				<script type="text/javascript">
					google.charts.load('current', {
						'packages': ['line']
					});
					google.charts.setOnLoadCallback(drawChart);

					function drawChart() {

						var data = new google.visualization.DataTable();
						data.addColumn('number', 'JOB ORDERS');
						data.addColumn('number', 'MAIN   ***');
						data.addColumn('number', 'SM');
						data.addColumn('number', 'SP');
						data.addColumn('number', 'SJ');
						data.addColumn('number', 'RIZAL');
						data.addColumn('number', 'ADPLUS');

						data.addRows([
							[4, <?php echo $jo_main5; ?>, <?php echo $jo_sm5; ?>, <?php echo $jo_sp5; ?>, <?php echo $jo_sj5; ?>, <?php echo $jo_rzl5; ?>, <?php echo $jo_adpls5; ?>],
							[3, <?php echo $jo_main4; ?>, <?php echo $jo_sm4; ?>, <?php echo $jo_sp4; ?>, <?php echo $jo_sj4; ?>, <?php echo $jo_rzl4; ?>, <?php echo $jo_adpls4; ?>],
							[2, <?php echo $jo_main3; ?>, <?php echo $jo_sm3; ?>, <?php echo $jo_sp3; ?>, <?php echo $jo_sj3; ?>, <?php echo $jo_rzl3; ?>, <?php echo $jo_adpls3; ?>],
							[1, <?php echo $jo_main2; ?>, <?php echo $jo_sm2; ?>, <?php echo $jo_sp2; ?>, <?php echo $jo_sj2; ?>, <?php echo $jo_rzl2; ?>, <?php echo $jo_adpls2; ?>],
							[0, <?php echo $jo_main1; ?>, <?php echo $jo_sm1; ?>, <?php echo $jo_sp1; ?>, <?php echo $jo_sj1; ?>, <?php echo $jo_rzl1; ?>, <?php echo $jo_adpls1; ?>],
						]);

						var options = {

							width: 400,
							height: 250,
							axes: {
								x: {
									0: {
										side: 'top'
									}
								}
							}
						};

						var chart = new google.charts.Line(document.getElementById('line_top1_x'));
						chart.draw(data, google.charts.Line.convertOptions(options));
					}
				</script>
				</br>
				<div id="line_top1_x"></div>
				<!--JO CHART ENDS HERE-->

			</td>
			<td>&nbsp;&nbsp;&nbsp;</td>
			<td>

				<!--PAYMENT CHART STARTS HERE-->
				<?php
				//CURRENT DAY
				if ($r1['main_total_payment'] != '') {
					$payment_main1 = $r1['main_total_payment'];
				} else {
					$payment_main1 = 0;
				}

				if ($r1['sm_total_payment'] != '') {
					$payment_sm1 = $r1['sm_total_payment'];
				} else {
					$payment_sm1 = 0;
				}

				if ($r1['sp_total_payment'] != '') {
					$payment_sp1 = $r1['sp_total_payment'];
				} else {
					$payment_sp1 = 0;
				}

				if ($r1['sj_total_payment'] != '') {
					$payment_sj1 = $r1['sj_total_payment'];
				} else {
					$payment_sj1 = 0;
				}

				if ($r1['rzl_total_payment'] != '') {
					$payment_rzl1 = $r1['rzl_total_payment'];
				} else {
					$payment_rzl1 = 0;
				}
				
				if ($r1['adpls_total_payment'] != '') {
					$payment_adpls1 = $r1['adpls_total_payment'];
				} else {
					$payment_adpls1 = 0;
				}

				//1 DAY AGO PAYMENT
				if ($r2['main_total_payment'] != '') {
					$payment_main2 = $r2['main_total_payment'];
				} else {
					$payment_main2 = 0;
				}

				if ($r2['sm_total_payment'] != '') {
					$payment_sm2 = $r2['sm_total_payment'];
				} else {
					$payment_sm2 = 0;
				}

				if ($r2['sp_total_payment'] != '') {
					$payment_sp2 = $r2['sp_total_payment'];
				} else {
					$payment_sp2 = 0;
				}

				if ($r2['sj_total_payment'] != '') {
					$payment_sj2 = $r2['sj_total_payment'];
				} else {
					$payment_sj2 = 0;
				}

				if ($r2['rzl_total_payment'] != '') {
					$payment_rzl2 = $r2['rzl_total_payment'];
				} else {
					$payment_rzl2 = 0;
				}
				
				if ($r2['adpls_total_payment'] != '') {
					$payment_adpls2 = $r2['adpls_total_payment'];
				} else {
					$payment_adpls2 = 0;
				}
				

				//2 DAYS AGO PAYMENT
				if ($r3['main_total_payment'] != '') {
					$payment_main3 = $r3['main_total_payment'];
				} else {
					$payment_main3 = 0;
				}

				if ($r3['sm_total_payment'] != '') {
					$payment_sm3 = $r3['sm_total_payment'];
				} else {
					$payment_sm3 = 0;
				}

				if ($r3['sp_total_payment'] != '') {
					$payment_sp3 = $r3['sp_total_payment'];
				} else {
					$payment_sp3 = 0;
				}

				if ($r3['sj_total_payment'] != '') {
					$payment_sj3 = $r3['sj_total_payment'];
				} else {
					$payment_sj3 = 0;
				}

				if ($r3['rzl_total_payment'] != '') {
					$payment_rzl3 = $r3['rzl_total_payment'];
				} else {
					$payment_rzl3 = 0;
				}
				
				if ($r3['adpls_total_payment'] != '') {
					$payment_adpls3 = $r3['adpls_total_payment'];
				} else {
					$payment_adpls3 = 0;
				}

				//3 DAYS AGO PAYMENT
				if ($r4['main_total_payment'] != '') {
					$payment_main4 = $r4['main_total_payment'];
				} else {
					$payment_main4 = 0;
				}

				if ($r4['sm_total_payment'] != '') {
					$payment_sm4 = $r4['sm_total_payment'];
				} else {
					$payment_sm4 = 0;
				}

				if ($r4['sp_total_payment'] != '') {
					$payment_sp4 = $r4['sp_total_payment'];
				} else {
					$payment_sp4 = 0;
				}

				if ($r4['sj_total_payment'] != '') {
					$payment_sj4 = $r4['sj_total_payment'];
				} else {
					$payment_sj4 = 0;
				}

				if ($r4['rzl_total_payment'] != '') {
					$payment_rzl4 = $r4['rzl_total_payment'];
				} else {
					$payment_rzl4 = 0;
				}
				
				if ($r4['adpls_total_payment'] != '') {
					$payment_adpls4 = $r4['adpls_total_payment'];
				} else {
					$payment_adpls4 = 0;
				}

				//4 DAYS AGO payment
				if ($r5['main_total_payment'] != '') {
					$payment_main5 = $r5['main_total_payment'];
				} else {
					$payment_main5 = 0;
				}

				if ($r5['sm_total_payment'] != '') {
					$payment_sm5 = $r5['sm_total_payment'];
				} else {
					$payment_sm5 = 0;
				}

				if ($r5['sp_total_payment'] != '') {
					$payment_sp5 = $r5['sp_total_payment'];
				} else {
					$payment_sp5 = 0;
				}

				if ($r5['sj_total_payment'] != '') {
					$payment_sj5 = $r5['sj_total_payment'];
				} else {
					$payment_sj5 = 0;
				}

				if ($r5['rzl_total_payment'] != '') {
					$payment_rzl5 = $r5['rzl_total_payment'];
				} else {
					$payment_rzl5 = 0;
				}
				
				if ($r5['adpls_total_payment'] != '') {
					$payment_adpls5 = $r5['adpls_total_payment'];
				} else {
					$payment_adpls5 = 0;
				}

				?>



				<script type="text/javascript">
					google.charts.load('current', {
						'packages': ['line']
					});
					google.charts.setOnLoadCallback(drawChart);

					function drawChart() {

						var data = new google.visualization.DataTable();
						data.addColumn('number', 'PAYMENTS RECIEVED');
						data.addColumn('number', 'MAIN   ***');
						data.addColumn('number', 'SM');
						data.addColumn('number', 'SP');
						data.addColumn('number', 'SJ');
						data.addColumn('number', 'RIZAL');
						data.addColumn('number', 'ADPLUS');

						data.addRows([
							[4, <?php echo $payment_main5; ?>, <?php echo $payment_sm5; ?>, <?php echo $payment_sp5; ?>, <?php echo $payment_sj5; ?>, <?php echo $payment_rzl5; ?>, <?php echo $payment_adpls5; ?>],
							[3, <?php echo $payment_main4; ?>, <?php echo $payment_sm4; ?>, <?php echo $payment_sp4; ?>, <?php echo $payment_sj4; ?>, <?php echo $payment_rzl4; ?>, <?php echo $payment_adpls4; ?>],
							[2, <?php echo $payment_main3; ?>, <?php echo $payment_sm3; ?>, <?php echo $payment_sp3; ?>, <?php echo $payment_sj3; ?>, <?php echo $payment_rzl3; ?>, <?php echo $payment_adpls3; ?>],
							[1, <?php echo $payment_main2; ?>, <?php echo $payment_sm2; ?>, <?php echo $payment_sp2; ?>, <?php echo $payment_sj2; ?>, <?php echo $payment_rzl2; ?>, <?php echo $payment_adpls2; ?>],
							[0, <?php echo $payment_main1; ?>, <?php echo $payment_sm1; ?>, <?php echo $payment_sp1; ?>, <?php echo $payment_sj1; ?>, <?php echo $payment_rzl1; ?>, <?php echo $payment_adpls1; ?>],
						]);

						var options = {

							width: 400,
							height: 250,
							axes: {
								x: {
									0: {
										side: 'top'
									}
								}
							}
						};

						var chart = new google.charts.Line(document.getElementById('line_top2_x'));
						chart.draw(data, google.charts.Line.convertOptions(options));
					}
				</script>
				</br>
				<div id="line_top2_x"></div>
				<!--PAYMENT CHART ENDS HERE-->


			</td>
			<td>&nbsp;&nbsp;&nbsp;</td>
			<td>

				<!--DR CHART STARTS HERE-->
				<?php
				//CURRENT DAY
				if ($r1['main_total_dr'] != '') {
					$dr_main1 = $r1['main_total_dr'];
				} else {
					$dr_main1 = 0;
				}

				if ($r1['sm_total_dr'] != '') {
					$dr_sm1 = $r1['sm_total_dr'];
				} else {
					$dr_sm1 = 0;
				}

				if ($r1['sp_total_dr'] != '') {
					$dr_sp1 = $r1['sp_total_dr'];
				} else {
					$dr_sp1 = 0;
				}

				if ($r1['sj_total_dr'] != '') {
					$dr_sj1 = $r1['sj_total_dr'];
				} else {
					$dr_sj1 = 0;
				}
				
				if ($r1['rzl_total_dr'] != '') {
					$dr_rzl1 = $r1['rzl_total_dr'];
				} else {
					$dr_rzl1 = 0;
				}
				
				if ($r1['adpls_total_dr'] != '') {
					$dr_adpls1 = $r1['adpls_total_dr'];
				} else {
					$dr_adpls1 = 0;
				}

				//1 DAY AGO dr
				if ($r2['main_total_dr'] != '') {
					$dr_main2 = $r2['main_total_dr'];
				} else {
					$dr_main2 = 0;
				}

				if ($r2['sm_total_dr'] != '') {
					$dr_sm2 = $r2['sm_total_dr'];
				} else {
					$dr_sm2 = 0;
				}

				if ($r2['sp_total_dr'] != '') {
					$dr_sp2 = $r2['sp_total_dr'];
				} else {
					$dr_sp2 = 0;
				}

				if ($r2['sj_total_dr'] != '') {
					$dr_sj2 = $r2['sj_total_dr'];
				} else {
					$dr_sj2 = 0;
				}

				if ($r2['rzl_total_dr'] != '') {
					$dr_rzl2 = $r2['rzl_total_dr'];
				} else {
					$dr_rzl2 = 0;
				}
				
				if ($r2['adpls_total_dr'] != '') {
					$dr_adpls2 = $r2['adpls_total_dr'];
				} else {
					$dr_adpls2 = 0;
				}

				//2 DAYS AGO dr
				if ($r3['main_total_dr'] != '') {
					$dr_main3 = $r3['main_total_dr'];
				} else {
					$dr_main3 = 0;
				}

				if ($r3['sm_total_dr'] != '') {
					$dr_sm3 = $r3['sm_total_dr'];
				} else {
					$dr_sm3 = 0;
				}

				if ($r3['sp_total_dr'] != '') {
					$dr_sp3 = $r3['sp_total_dr'];
				} else {
					$dr_sp3 = 0;
				}

				if ($r3['sj_total_dr'] != '') {
					$dr_sj3 = $r3['sj_total_dr'];
				} else {
					$dr_sj3 = 0;
				}

				if ($r3['rzl_total_dr'] != '') {
					$dr_rzl3 = $r3['rzl_total_dr'];
				} else {
					$dr_rzl3 = 0;
				}
				
				if ($r3['adpls_total_dr'] != '') {
					$dr_adpls3 = $r3['adpls_total_dr'];
				} else {
					$dr_adpls3 = 0;
				}

				//3 DAYS AGO dr
				if ($r4['main_total_dr'] != '') {
					$dr_main4 = $r4['main_total_dr'];
				} else {
					$dr_main4 = 0;
				}

				if ($r4['sm_total_dr'] != '') {
					$dr_sm4 = $r4['sm_total_dr'];
				} else {
					$dr_sm4 = 0;
				}

				if ($r4['sp_total_dr'] != '') {
					$dr_sp4 = $r4['sp_total_dr'];
				} else {
					$dr_sp4 = 0;
				}

				if ($r4['sj_total_dr'] != '') {
					$dr_sj4 = $r4['sj_total_dr'];
				} else {
					$dr_sj4 = 0;
				}

				if ($r4['rzl_total_dr'] != '') {
					$dr_rzl4 = $r4['rzl_total_dr'];
				} else {
					$dr_rzl4 = 0;
				}
				
				if ($r4['adpls_total_dr'] != '') {
					$dr_adpls4 = $r4['adpls_total_dr'];
				} else {
					$dr_adpls4 = 0;
				}


				//4 DAYS AGO dr
				if ($r5['main_total_dr'] != '') {
					$dr_main5 = $r5['main_total_dr'];
				} else {
					$dr_main5 = 0;
				}

				if ($r5['sm_total_dr'] != '') {
					$dr_sm5 = $r5['sm_total_dr'];
				} else {
					$dr_sm5 = 0;
				}

				if ($r5['sp_total_dr'] != '') {
					$dr_sp5 = $r5['sp_total_dr'];
				} else {
					$dr_sp5 = 0;
				}

				if ($r5['sj_total_dr'] != '') {
					$dr_sj5 = $r5['sj_total_dr'];
				} else {
					$dr_sj5 = 0;
				}

				if ($r5['rzl_total_dr'] != '') {
					$dr_rzl5 = $r5['rzl_total_dr'];
				} else {
					$dr_rzl5 = 0;
				}

				if ($r5['adpls_total_dr'] != '') {
					$dr_adpls5 = $r5['adpls_total_dr'];
				} else {
					$dr_adpls5 = 0;
				}
				?>



				<script type="text/javascript">
					google.charts.load('current', {
						'packages': ['line']
					});
					google.charts.setOnLoadCallback(drawChart);

					function drawChart() {

						var data = new google.visualization.DataTable();
						data.addColumn('number', 'DELIVERY');
						data.addColumn('number', 'MAIN   ***');
						data.addColumn('number', 'SM');
						data.addColumn('number', 'SP');
						data.addColumn('number', 'SJ');
						data.addColumn('number', 'RIZAL');
						data.addColumn('number', 'ADPLUS');

						data.addRows([
							[4, <?php echo $dr_main5; ?>, <?php echo $dr_sm5; ?>, <?php echo $dr_sp5; ?>, <?php echo $dr_sj5; ?>, <?php echo $dr_rzl5; ?>, <?php echo $dr_adpls5; ?>],
							[3, <?php echo $dr_main4; ?>, <?php echo $dr_sm4; ?>, <?php echo $dr_sp4; ?>, <?php echo $dr_sj4; ?>, <?php echo $dr_rzl4; ?>, <?php echo $dr_adpls4; ?>],
							[2, <?php echo $dr_main3; ?>, <?php echo $dr_sm3; ?>, <?php echo $dr_sp3; ?>, <?php echo $dr_sj3; ?>, <?php echo $dr_rzl3; ?>, <?php echo $dr_adpls3; ?>],
							[1, <?php echo $dr_main2; ?>, <?php echo $dr_sm2; ?>, <?php echo $dr_sp2; ?>, <?php echo $dr_sj2; ?>, <?php echo $dr_rzl2; ?>, <?php echo $dr_adpls2; ?>],
							[0, <?php echo $dr_main1; ?>, <?php echo $dr_sm1; ?>, <?php echo $dr_sp1; ?>, <?php echo $dr_sj1; ?>, <?php echo $dr_rzl1; ?>, <?php echo $dr_adpls1; ?>],
						]);

						var options = {

							width: 400,
							height: 250,
							axes: {
								x: {
									0: {
										side: 'top'
									}
								}
							}
						};

						var chart = new google.charts.Line(document.getElementById('line_top3_x'));
						chart.draw(data, google.charts.Line.convertOptions(options));
					}
				</script>
				</br>
				<div id="line_top3_x"></div>
				<!--DR CHART ENDS HERE-->
			</td>
		</tr>
	</table>
</div>