<?php 
session_start();
include('connection/conn.php');
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); }
include("css.php");

$s="select * from user_access";
$q=mysql_query($s) or die(mysql_error());
$r=mysql_fetch_assoc($q);

echo "<table border='1'>
		<tr>
			<td>Name</td>
			<td>Username</td>
			<td>a1</td>
			<td>a2</td>
			<td>a3</td>
			<td>a4</td>
			<td>a5</td>
			<td>a6</td>
			<td>a7</td>
			<td>a8</td>
			<td>a9</td>
			<td>a10</td>
			<td>a11</td>
			<td>a12</td>
			<td>a13</td>
			<td>a14</td>
			<td>a15</td>
			<td>a16</td>
			<td>a17</td>
			<td>a18</td>
			<td>a19</td>
			<td>a20</td>
			<td>a21</td>
			<td>a22</td>
			<td>a23</td>
			<td>a24</td>
			<td>a25</td>
			<td>a26</td>
			<td>b1</td>
			<td>b2</td>
			<td>b3</td>
			<td>b4</td>
			<td>b5</td>
			<td>b6</td>
			<td>b7</td>
			<td>b8</td>
			<td>b9</td>
			<td>b10</td>
			<td>b11</td>
			<td>b12</td>
			<td>b13</td>
			<td>b14</td>
			<td>b15</td>
			<td>b16</td>
			<td>b17</td>
			<td>b18</td>
			<td>b19</td>
			<td>b20</td>
			<td>b21</td>
			<td>b22</td>
			<td>b23</td>
			<td>b24</td>
			<td>c1</td>
			<td>c2</td>
			<td>d1</td>
			<td>d2</td>
			<td>d3</td>
			<td>d4</td>
			<td>d5</td>
			<td>d6</td>
			<td>d7</td>
			<td>d8</td>
			<td>d9</td>
			<td>d10</td>
			<td>d11</td>
			<td>d12</td>
			<td>d13</td>
			<td>d14</td>
			<td>d15</td>
			<td>d16</td>
			<td>d17</td>
			<td>d18</td>
			<td>d19</td>
			<td>d20</td>
			<td>d21</td>
			<td>d22</td>
			<td>d23</td>
			<td>d24</td>
			<td>d25</td>
			<td>d26</td>
			<td>d27</td>
			<td>d28</td>
			<td>d29</td>
			<td>d30</td>
			<td>f1</td>
			<td>f2</td>
			<td>i1</td>
			<td>i2</td>
			<td>p1</td>
			<td>p2</td>
			<td>p3</td>
			<td>p4</td>
			<td>p5</td>
			<td>p6</td>
			<td>z1</td>
			<td>z2</td>
			<td>z3</td>
			<td>z4</td>
			<td>z5</td>
			<td>z6</td>
			<td>z7</td>
			<td>z8</td>
			<td>z9</td>
			<td>z10</td>
			<td>z11</td>
			<td>vip1</td>
		</tr>";
do{
	echo "<tr>
			<td></td>
			<td>".$r['username']."</td>";
						if($r['a1']==1){ echo "<td>".$r['a1']."</td>"; }else{ echo "<td></td>"; }
			if($r['a2']==1){ echo "<td>".$r['a2']."</td>"; }else{ echo "<td></td>"; }
			if($r['a3']==1){ echo "<td>".$r['a3']."</td>"; }else{ echo "<td></td>"; }
			if($r['a4']==1){ echo "<td>".$r['a4']."</td>"; }else{ echo "<td></td>"; }
			if($r['a5']==1){ echo "<td>".$r['a5']."</td>"; }else{ echo "<td></td>"; }
			if($r['a6']==1){ echo "<td>".$r['a6']."</td>"; }else{ echo "<td></td>"; }
			if($r['a7']==1){ echo "<td>".$r['a7']."</td>"; }else{ echo "<td></td>"; }
			if($r['a8']==1){ echo "<td>".$r['a8']."</td>"; }else{ echo "<td></td>"; }
			if($r['a9']==1){ echo "<td>".$r['a9']."</td>"; }else{ echo "<td></td>"; }
			if($r['a10']==1){ echo "<td>".$r['a10']."</td>"; }else{ echo "<td></td>"; }
			if($r['a11']==1){ echo "<td>".$r['a11']."</td>"; }else{ echo "<td></td>"; }
			if($r['a12']==1){ echo "<td>".$r['a12']."</td>"; }else{ echo "<td></td>"; }
			if($r['a13']==1){ echo "<td>".$r['a13']."</td>"; }else{ echo "<td></td>"; }
			if($r['a14']==1){ echo "<td>".$r['a14']."</td>"; }else{ echo "<td></td>"; }
			if($r['a15']==1){ echo "<td>".$r['a15']."</td>"; }else{ echo "<td></td>"; }
			if($r['a16']==1){ echo "<td>".$r['a16']."</td>"; }else{ echo "<td></td>"; }
			if($r['a17']==1){ echo "<td>".$r['a17']."</td>"; }else{ echo "<td></td>"; }
			if($r['a18']==1){ echo "<td>".$r['a18']."</td>"; }else{ echo "<td></td>"; }
			if($r['a19']==1){ echo "<td>".$r['a19']."</td>"; }else{ echo "<td></td>"; }
			if($r['a20']==1){ echo "<td>".$r['a20']."</td>"; }else{ echo "<td></td>"; }
			if($r['a21']==1){ echo "<td>".$r['a21']."</td>"; }else{ echo "<td></td>"; }
			if($r['a22']==1){ echo "<td>".$r['a22']."</td>"; }else{ echo "<td></td>"; }
			if($r['a23']==1){ echo "<td>".$r['a23']."</td>"; }else{ echo "<td></td>"; }
			if($r['a24']==1){ echo "<td>".$r['a24']."</td>"; }else{ echo "<td></td>"; }
			if($r['a25']==1){ echo "<td>".$r['a25']."</td>"; }else{ echo "<td></td>"; }
			if($r['a26']==1){ echo "<td>".$r['a26']."</td>"; }else{ echo "<td></td>"; }
			if($r['b1']==1){ echo "<td>".$r['b1']."</td>"; }else{ echo "<td></td>"; }
			if($r['b2']==1){ echo "<td>".$r['b2']."</td>"; }else{ echo "<td></td>"; }
			if($r['b3']==1){ echo "<td>".$r['b3']."</td>"; }else{ echo "<td></td>"; }
			if($r['b4']==1){ echo "<td>".$r['b4']."</td>"; }else{ echo "<td></td>"; }
			if($r['b5']==1){ echo "<td>".$r['b5']."</td>"; }else{ echo "<td></td>"; }
			if($r['b6']==1){ echo "<td>".$r['b6']."</td>"; }else{ echo "<td></td>"; }
			if($r['b7']==1){ echo "<td>".$r['b7']."</td>"; }else{ echo "<td></td>"; }
			if($r['b8']==1){ echo "<td>".$r['b8']."</td>"; }else{ echo "<td></td>"; }
			if($r['b9']==1){ echo "<td>".$r['b9']."</td>"; }else{ echo "<td></td>"; }
			if($r['b10']==1){ echo "<td>".$r['b10']."</td>"; }else{ echo "<td></td>"; }
			if($r['b11']==1){ echo "<td>".$r['b11']."</td>"; }else{ echo "<td></td>"; }
			if($r['b12']==1){ echo "<td>".$r['b12']."</td>"; }else{ echo "<td></td>"; }
			if($r['b13']==1){ echo "<td>".$r['b13']."</td>"; }else{ echo "<td></td>"; }
			if($r['b14']==1){ echo "<td>".$r['b14']."</td>"; }else{ echo "<td></td>"; }
			if($r['b15']==1){ echo "<td>".$r['b15']."</td>"; }else{ echo "<td></td>"; }
			if($r['b16']==1){ echo "<td>".$r['b16']."</td>"; }else{ echo "<td></td>"; }
			if($r['b17']==1){ echo "<td>".$r['b17']."</td>"; }else{ echo "<td></td>"; }
			if($r['b18']==1){ echo "<td>".$r['b18']."</td>"; }else{ echo "<td></td>"; }
			if($r['b19']==1){ echo "<td>".$r['b19']."</td>"; }else{ echo "<td></td>"; }
			if($r['b20']==1){ echo "<td>".$r['b20']."</td>"; }else{ echo "<td></td>"; }
			if($r['b21']==1){ echo "<td>".$r['b21']."</td>"; }else{ echo "<td></td>"; }
			if($r['b22']==1){ echo "<td>".$r['b22']."</td>"; }else{ echo "<td></td>"; }
			if($r['b23']==1){ echo "<td>".$r['b23']."</td>"; }else{ echo "<td></td>"; }
			if($r['b24']==1){ echo "<td>".$r['b24']."</td>"; }else{ echo "<td></td>"; }
			if($r['c1']==1){ echo "<td>".$r['c1']."</td>"; }else{ echo "<td></td>"; }
			if($r['c2']==1){ echo "<td>".$r['c2']."</td>"; }else{ echo "<td></td>"; }
			if($r['d1']==1){ echo "<td>".$r['d1']."</td>"; }else{ echo "<td></td>"; }
			if($r['d2']==1){ echo "<td>".$r['d2']."</td>"; }else{ echo "<td></td>"; }
			if($r['d3']==1){ echo "<td>".$r['d3']."</td>"; }else{ echo "<td></td>"; }
			if($r['d4']==1){ echo "<td>".$r['d4']."</td>"; }else{ echo "<td></td>"; }
			if($r['d5']==1){ echo "<td>".$r['d5']."</td>"; }else{ echo "<td></td>"; }
			if($r['d6']==1){ echo "<td>".$r['d6']."</td>"; }else{ echo "<td></td>"; }
			if($r['d7']==1){ echo "<td>".$r['d7']."</td>"; }else{ echo "<td></td>"; }
			if($r['d8']==1){ echo "<td>".$r['d8']."</td>"; }else{ echo "<td></td>"; }
			if($r['d9']==1){ echo "<td>".$r['d9']."</td>"; }else{ echo "<td></td>"; }
			if($r['d10']==1){ echo "<td>".$r['d10']."</td>"; }else{ echo "<td></td>"; }
			if($r['d11']==1){ echo "<td>".$r['d11']."</td>"; }else{ echo "<td></td>"; }
			if($r['d12']==1){ echo "<td>".$r['d12']."</td>"; }else{ echo "<td></td>"; }
			if($r['d13']==1){ echo "<td>".$r['d13']."</td>"; }else{ echo "<td></td>"; }
			if($r['d14']==1){ echo "<td>".$r['d14']."</td>"; }else{ echo "<td></td>"; }
			if($r['d15']==1){ echo "<td>".$r['d15']."</td>"; }else{ echo "<td></td>"; }
			if($r['d16']==1){ echo "<td>".$r['d16']."</td>"; }else{ echo "<td></td>"; }
			if($r['d17']==1){ echo "<td>".$r['d17']."</td>"; }else{ echo "<td></td>"; }
			if($r['d18']==1){ echo "<td>".$r['d18']."</td>"; }else{ echo "<td></td>"; }
			if($r['d19']==1){ echo "<td>".$r['d19']."</td>"; }else{ echo "<td></td>"; }
			if($r['d20']==1){ echo "<td>".$r['d20']."</td>"; }else{ echo "<td></td>"; }
			if($r['d21']==1){ echo "<td>".$r['d21']."</td>"; }else{ echo "<td></td>"; }
			if($r['d22']==1){ echo "<td>".$r['d22']."</td>"; }else{ echo "<td></td>"; }
			if($r['d23']==1){ echo "<td>".$r['d23']."</td>"; }else{ echo "<td></td>"; }
			if($r['d24']==1){ echo "<td>".$r['d24']."</td>"; }else{ echo "<td></td>"; }
			if($r['d25']==1){ echo "<td>".$r['d25']."</td>"; }else{ echo "<td></td>"; }
			if($r['d26']==1){ echo "<td>".$r['d26']."</td>"; }else{ echo "<td></td>"; }
			if($r['d27']==1){ echo "<td>".$r['d27']."</td>"; }else{ echo "<td></td>"; }
			if($r['d28']==1){ echo "<td>".$r['d28']."</td>"; }else{ echo "<td></td>"; }
			if($r['d29']==1){ echo "<td>".$r['d29']."</td>"; }else{ echo "<td></td>"; }
			if($r['d30']==1){ echo "<td>".$r['d30']."</td>"; }else{ echo "<td></td>"; }
			if($r['f1']==1){ echo "<td>".$r['f1']."</td>"; }else{ echo "<td></td>"; }
			if($r['f2']==1){ echo "<td>".$r['f2']."</td>"; }else{ echo "<td></td>"; }
			if($r['i1']==1){ echo "<td>".$r['i1']."</td>"; }else{ echo "<td></td>"; }
			if($r['i2']==1){ echo "<td>".$r['i2']."</td>"; }else{ echo "<td></td>"; }
			if($r['p1']==1){ echo "<td>".$r['p1']."</td>"; }else{ echo "<td></td>"; }
			if($r['p2']==1){ echo "<td>".$r['p2']."</td>"; }else{ echo "<td></td>"; }
			if($r['p3']==1){ echo "<td>".$r['p3']."</td>"; }else{ echo "<td></td>"; }
			if($r['p4']==1){ echo "<td>".$r['p4']."</td>"; }else{ echo "<td></td>"; }
			if($r['p5']==1){ echo "<td>".$r['p5']."</td>"; }else{ echo "<td></td>"; }
			if($r['p6']==1){ echo "<td>".$r['p6']."</td>"; }else{ echo "<td></td>"; }
			if($r['z1']==1){ echo "<td>".$r['z1']."</td>"; }else{ echo "<td></td>"; }
			if($r['z2']==1){ echo "<td>".$r['z2']."</td>"; }else{ echo "<td></td>"; }
			if($r['z3']==1){ echo "<td>".$r['z3']."</td>"; }else{ echo "<td></td>"; }
			if($r['z4']==1){ echo "<td>".$r['z4']."</td>"; }else{ echo "<td></td>"; }
			if($r['z5']==1){ echo "<td>".$r['z5']."</td>"; }else{ echo "<td></td>"; }
			if($r['z6']==1){ echo "<td>".$r['z6']."</td>"; }else{ echo "<td></td>"; }
			if($r['z7']==1){ echo "<td>".$r['z7']."</td>"; }else{ echo "<td></td>"; }
			if($r['z8']==1){ echo "<td>".$r['z8']."</td>"; }else{ echo "<td></td>"; }
			if($r['z9']==1){ echo "<td>".$r['z9']."</td>"; }else{ echo "<td></td>"; }
			if($r['z10']==1){ echo "<td>".$r['z10']."</td>"; }else{ echo "<td></td>"; }
			if($r['z11']==1){ echo "<td>".$r['z11']."</td>"; }else{ echo "<td></td>"; }
			if($r['vip1']==1){ echo "<td>".$r['vip1']."</td>"; }else{ echo "<td></td>"; }
		echo "</tr>";
}while($r=mysql_fetch_assoc($q));
?>