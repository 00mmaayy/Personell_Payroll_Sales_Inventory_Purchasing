<div align='center'>
<?php
/*
$jo_jan=$r_jan['main_total_jo']+$r_jan['sm_total_jo']+$r_jan['sp_total_jo']+$r_jan['sj_total_jo'];
$jo_feb=$r_feb['main_total_jo']+$r_feb['sm_total_jo']+$r_feb['sp_total_jo']+$r_feb['sj_total_jo'];
$jo_mar=$r_mar['main_total_jo']+$r_mar['sm_total_jo']+$r_mar['sp_total_jo']+$r_mar['sj_total_jo'];
$jo_apr=$r_apr['main_total_jo']+$r_apr['sm_total_jo']+$r_apr['sp_total_jo']+$r_apr['sj_total_jo'];
$jo_may=$r_may['main_total_jo']+$r_may['sm_total_jo']+$r_may['sp_total_jo']+$r_may['sj_total_jo'];
$jo_jun=$r_jun['main_total_jo']+$r_jun['sm_total_jo']+$r_jun['sp_total_jo']+$r_jun['sj_total_jo'];
$jo_jul=$r_jul['main_total_jo']+$r_jul['sm_total_jo']+$r_jul['sp_total_jo']+$r_jul['sj_total_jo'];
$jo_aug=$r_aug['main_total_jo']+$r_aug['sm_total_jo']+$r_aug['sp_total_jo']+$r_aug['sj_total_jo'];
$jo_sep=$r_sep['main_total_jo']+$r_sep['sm_total_jo']+$r_sep['sp_total_jo']+$r_sep['sj_total_jo'];
$jo_oct=$r_oct['main_total_jo']+$r_oct['sm_total_jo']+$r_oct['sp_total_jo']+$r_oct['sj_total_jo'];
$jo_nov=$r_nov['main_total_jo']+$r_nov['sm_total_jo']+$r_nov['sp_total_jo']+$r_nov['sj_total_jo'];
$jo_dec=$r_dec['main_total_jo']+$r_dec['sm_total_jo']+$r_dec['sp_total_jo']+$r_dec['sj_total_jo'];
*/

$jo_main=
$r_jan['main_total_jo']+
$r_feb['main_total_jo']+
$r_mar['main_total_jo']+
$r_apr['main_total_jo']+
$r_may['main_total_jo']+
$r_jun['main_total_jo']+
$r_jul['main_total_jo']+
$r_aug['main_total_jo']+
$r_sep['main_total_jo']+
$r_oct['main_total_jo']+
$r_nov['main_total_jo']+
$r_dec['main_total_jo'];

$jo_sm=
$r_jan['sm_total_jo']+
$r_feb['sm_total_jo']+
$r_mar['sm_total_jo']+
$r_apr['sm_total_jo']+
$r_may['sm_total_jo']+
$r_jun['sm_total_jo']+
$r_jul['sm_total_jo']+
$r_aug['sm_total_jo']+
$r_sep['sm_total_jo']+
$r_oct['sm_total_jo']+
$r_nov['sm_total_jo']+
$r_dec['sm_total_jo'];

$jo_sp=
$r_jan['sp_total_jo']+
$r_feb['sp_total_jo']+
$r_mar['sp_total_jo']+
$r_apr['sp_total_jo']+
$r_may['sp_total_jo']+
$r_jun['sp_total_jo']+
$r_jul['sp_total_jo']+
$r_aug['sp_total_jo']+
$r_sep['sp_total_jo']+
$r_oct['sp_total_jo']+
$r_nov['sp_total_jo']+
$r_dec['sp_total_jo'];

$jo_sj=
$r_jan['sj_total_jo']+
$r_feb['sj_total_jo']+
$r_mar['sj_total_jo']+
$r_apr['sj_total_jo']+
$r_may['sj_total_jo']+
$r_jun['sj_total_jo']+
$r_jul['sj_total_jo']+
$r_aug['sj_total_jo']+
$r_sep['sj_total_jo']+
$r_oct['sj_total_jo']+
$r_nov['sj_total_jo']+
$r_dec['sj_total_jo'];

$jo_rzl=
$r_jan['rzl_total_jo']+
$r_feb['rzl_total_jo']+
$r_mar['rzl_total_jo']+
$r_apr['rzl_total_jo']+
$r_may['rzl_total_jo']+
$r_jun['rzl_total_jo']+
$r_jul['rzl_total_jo']+
$r_aug['rzl_total_jo']+
$r_sep['rzl_total_jo']+
$r_oct['rzl_total_jo']+
$r_nov['rzl_total_jo']+
$r_dec['rzl_total_jo'];
?>
<script type="text/javascript">
// Load google charts
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

// Draw the chart and set the chart values
function drawChart() {
  var data = google.visualization.arrayToDataTable([
  ['Task', 'Performance'],
  ['ALC MAIN', <?php echo $jo_main; ?>],
  ['ALC SM', <?php echo $jo_sm; ?>],
  ['ALC SANPEDRO', <?php echo $jo_sp; ?>],
  ['ALC SANJOSE', <?php echo $jo_sj; ?>],
  ['ALC RIZAL', <?php echo $jo_rzl; ?>]
]);

  // Optional; add a title and set the width and height of the chart
  var options = {'title':'ALC YEAR <?php echo $year; ?> JOB ORDER PERFORMANCE', 'width':1000, 'height':900};

  // Display the chart inside the <div> element with id="piechart"
  var chart = new google.visualization.PieChart(document.getElementById('piechart'));
  chart.draw(data, options);
}
</script>	
<div id="piechart"></div>
</div>

<br/><br/>

<div align='center'>
<?php

$payment_main=
$r_jan['main_total_payment']+
$r_feb['main_total_payment']+
$r_mar['main_total_payment']+
$r_apr['main_total_payment']+
$r_may['main_total_payment']+
$r_jun['main_total_payment']+
$r_jul['main_total_payment']+
$r_aug['main_total_payment']+
$r_sep['main_total_payment']+
$r_oct['main_total_payment']+
$r_nov['main_total_payment']+
$r_dec['main_total_payment'];

$payment_sm=
$r_jan['sm_total_payment']+
$r_feb['sm_total_payment']+
$r_mar['sm_total_payment']+
$r_apr['sm_total_payment']+
$r_may['sm_total_payment']+
$r_jun['sm_total_payment']+
$r_jul['sm_total_payment']+
$r_aug['sm_total_payment']+
$r_sep['sm_total_payment']+
$r_oct['sm_total_payment']+
$r_nov['sm_total_payment']+
$r_dec['sm_total_payment'];

$payment_sp=
$r_jan['sp_total_payment']+
$r_feb['sp_total_payment']+
$r_mar['sp_total_payment']+
$r_apr['sp_total_payment']+
$r_may['sp_total_payment']+
$r_jun['sp_total_payment']+
$r_jul['sp_total_payment']+
$r_aug['sp_total_payment']+
$r_sep['sp_total_payment']+
$r_oct['sp_total_payment']+
$r_nov['sp_total_payment']+
$r_dec['sp_total_payment'];

$payment_sj=
$r_jan['sj_total_payment']+
$r_feb['sj_total_payment']+
$r_mar['sj_total_payment']+
$r_apr['sj_total_payment']+
$r_may['sj_total_payment']+
$r_jun['sj_total_payment']+
$r_jul['sj_total_payment']+
$r_aug['sj_total_payment']+
$r_sep['sj_total_payment']+
$r_oct['sj_total_payment']+
$r_nov['sj_total_payment']+
$r_dec['sj_total_payment'];


$payment_rzl=
$r_jan['rzl_total_payment']+
$r_feb['rzl_total_payment']+
$r_mar['rzl_total_payment']+
$r_apr['rzl_total_payment']+
$r_may['rzl_total_payment']+
$r_jun['rzl_total_payment']+
$r_jul['rzl_total_payment']+
$r_aug['rzl_total_payment']+
$r_sep['rzl_total_payment']+
$r_oct['rzl_total_payment']+
$r_nov['rzl_total_payment']+
$r_dec['rzl_total_payment'];

?>
<script type="text/javascript">
// Load google charts
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

// Draw the chart and set the chart values
function drawChart() {
  var data = google.visualization.arrayToDataTable([
  ['Task', 'Performance'],
  ['ALC MAIN', <?php echo $payment_main; ?>],
  ['ALC SM', <?php echo $payment_sm; ?>],
  ['ALC SANPEDRO', <?php echo $payment_sp; ?>],
  ['ALC SANJOSE', <?php echo $payment_sj; ?>],
  ['ALC RIZAL', <?php echo $payment_rzl; ?>]
]);

  // Optional; add a title and set the width and height of the chart
  var options = {'title':'ALC YEAR <?php echo $year; ?> PAYEMENTS RECIEVED PERFORMANCE', 'width':1000, 'height':900};

  // Display the chart inside the <div> element with id="piechart"
  var chart = new google.visualization.PieChart(document.getElementById('piechart1'));
  chart.draw(data, options);
}
</script>	
<div id="piechart1"></div>
</div>



<br/><br/>

<div align='center'>
<?php

$dr_main=
$r_jan['main_total_dr']+
$r_feb['main_total_dr']+
$r_mar['main_total_dr']+
$r_apr['main_total_dr']+
$r_may['main_total_dr']+
$r_jun['main_total_dr']+
$r_jul['main_total_dr']+
$r_aug['main_total_dr']+
$r_sep['main_total_dr']+
$r_oct['main_total_dr']+
$r_nov['main_total_dr']+
$r_dec['main_total_dr'];

$dr_sm=
$r_jan['sm_total_dr']+
$r_feb['sm_total_dr']+
$r_mar['sm_total_dr']+
$r_apr['sm_total_dr']+
$r_may['sm_total_dr']+
$r_jun['sm_total_dr']+
$r_jul['sm_total_dr']+
$r_aug['sm_total_dr']+
$r_sep['sm_total_dr']+
$r_oct['sm_total_dr']+
$r_nov['sm_total_dr']+
$r_dec['sm_total_dr'];

$dr_sp=
$r_jan['sp_total_dr']+
$r_feb['sp_total_dr']+
$r_mar['sp_total_dr']+
$r_apr['sp_total_dr']+
$r_may['sp_total_dr']+
$r_jun['sp_total_dr']+
$r_jul['sp_total_dr']+
$r_aug['sp_total_dr']+
$r_sep['sp_total_dr']+
$r_oct['sp_total_dr']+
$r_nov['sp_total_dr']+
$r_dec['sp_total_dr'];

$dr_sj=
$r_jan['sj_total_dr']+
$r_feb['sj_total_dr']+
$r_mar['sj_total_dr']+
$r_apr['sj_total_dr']+
$r_may['sj_total_dr']+
$r_jun['sj_total_dr']+
$r_jul['sj_total_dr']+
$r_aug['sj_total_dr']+
$r_sep['sj_total_dr']+
$r_oct['sj_total_dr']+
$r_nov['sj_total_dr']+
$r_dec['sj_total_dr'];

$dr_rzl=
$r_jan['rzl_total_dr']+
$r_feb['rzl_total_dr']+
$r_mar['rzl_total_dr']+
$r_apr['rzl_total_dr']+
$r_may['rzl_total_dr']+
$r_jun['rzl_total_dr']+
$r_jul['rzl_total_dr']+
$r_aug['rzl_total_dr']+
$r_sep['rzl_total_dr']+
$r_oct['rzl_total_dr']+
$r_nov['rzl_total_dr']+
$r_dec['rzl_total_dr'];

?>
<script type="text/javascript">
// Load google charts
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

// Draw the chart and set the chart values
function drawChart() {
  var data = google.visualization.arrayToDataTable([
  ['Task', 'Performance'],
  ['ALC MAIN', <?php echo $dr_main; ?>],
  ['ALC SM', <?php echo $dr_sm; ?>],
  ['ALC SANPEDRO', <?php echo $dr_sp; ?>],
  ['ALC SANJOSE', <?php echo $dr_sj; ?>],
  ['ALC RIZAL', <?php echo $dr_rzl; ?>]
]);

  // Optional; add a title and set the width and height of the chart
  var options = {'title':'ALC YEAR <?php echo $year; ?> DELIVERY PERFORMANCE', 'width':1000, 'height':900};

  // Display the chart inside the <div> element with id="piechart"
  var chart = new google.visualization.PieChart(document.getElementById('piechart2'));
  chart.draw(data, options);
}
</script>	
<div id="piechart2"></div>
</div>