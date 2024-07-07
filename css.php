<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/font-awesome.min.css">
<link rel="stylesheet" href="css/w3.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="ajaxloader.js"></script>
<style>@media print{a[href]:after{content:none}}</style>
<style>
	.notification
	{
	color: white;
	text-decoration: none;
	position: relative;
	display: inline-block;
	}
	
	.notification .badge
	{
	position: absolute;
	top: -1px;
	right: -6px;
	padding: 2px 6px;
	border-radius: 50%;
	background-color: red;
	color: white;
	}
</style>
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
xmlhttp.open("GET","result.php?s="+s,true);
xmlhttp.send();
}
</script>