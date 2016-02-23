<?php
include_once("inc/head.php");
include_once("inc/inc.php");

$pid = $_GET['pid'];
$q0 = @mysql_query("select kid from gal where id = ".$pid) or ferror(2);
$kid = @mysql_result($q0, 0, 'kid') or ferror(3);
?>

<script language="JavaScript" type="text/javascript">
<!--//
var urls = new Array ();
var photos = new Array ();
var author = new Array ();
var maxi;
<?php
$query = mysql_query("select photo, url, id, objid, author from gal where kid = ".$kid." order by id asc");
$kolvo = mysql_num_rows($query);
$i = 0;
while($row = mysql_fetch_array($query)) {
	if($row['id'] == $pid) print "var cur = ".$i.";";
	if($row['objid'] != 0) {
				$qq2 = mysql_query("select ngc, messier, name from objects where id = '".$row['objid']."'");
				$messier = mysql_result($qq2, 0, 'messier');
				$ngc = mysql_result($qq2, 0, 'ngc');
				$name = mysql_result($qq2, 0, 'name');
				$poyasn = " (";
				if($name != "") $poyasn .= $name;
				if($name != "" && $messier != "") $poyasn .= ", ";
				if($messier != "") $poyasn .= "M".$messier;
				if($messier != "" && $ngc != "") $poyasn .= ", ";
				if($ngc != "") {
					if(substr($ngc, 0, 1) == "I") $poyasn .= "IC".substr($ngc, 1);
					else $poyasn .= "NGC ".$ngc;
				}
				$poyasn .= ")";
				print "photos[".$i."] = '".$row['photo']."<br>".$poyasn."';";
	}
	else print "photos[".$i."] = '".$row['photo']."';";
	print "urls[".$i."] = '".$row['url']."';";
	print "author[".$i."] = '".$row['author']."';";
	$poyasn = "";
	$i++;
}
$i--;
$maxi = $i;
print "maxi = ".$maxi;
?>


function bigshow(i, maxi, urls, photos) {
document.getElementById("scene").src = "photos/"+urls[i];
document.getElementById("div_main").innerHTML = "<h2 style='text-align: center;'>"+photos[i]+"</h2>";
document.getElementById("dop_main").value = urls[i];
if(author[i] != "-" && author[i] != "") document.getElementById("opis").innerHTML = "Автор: "+author[i];
else document.getElementById("opis").innerHTML = "";

function setpic(urls, photos, no, i) {
if(urls[i] == undefined) document.getElementById("th"+no).src = "images/empty.gif";
else document.getElementById("th"+no).src = "photos/small/"+urls[i];
if(photos[i] == undefined) {document.getElementById("div"+no).innerHTML = "Пусто"; document.getElementById("href"+no).href = "#";}
else {document.getElementById("div"+no).innerHTML = photos[i]; document.getElementById("href"+no).href = "javascript: bigshow(document.getElementById('dop"+no+"').value, maxi, urls, photos);";}
document.getElementById("dop"+no).value = i;
}

if(i==0) {
setpic(urls, photos, 1, i+1);
setpic(urls, photos, 2, i+2);
setpic(urls, photos, 3, i+3);
setpic(urls, photos, 4, i+4);
}
if(i==1) {
setpic(urls, photos, 1, i-1);
setpic(urls, photos, 2, i+1);
setpic(urls, photos, 3, i+2);
setpic(urls, photos, 4, i+3);
}
if(i==maxi) {
setpic(urls, photos, 1, i-4);
setpic(urls, photos, 2, i-3);
setpic(urls, photos, 3, i-2);
setpic(urls, photos, 4, i-1);
}
if(i==maxi-1) {
setpic(urls, photos, 1, i-3);
setpic(urls, photos, 2, i-2);
setpic(urls, photos, 3, i-1);
setpic(urls, photos, 4, i+1);
}
if(i==maxi-2) {
setpic(urls, photos, 1, i-2);
setpic(urls, photos, 2, i-1);
setpic(urls, photos, 3, i+1);
setpic(urls, photos, 4, i+2);
}
if (i!=0 && i!=1 && i!=maxi && i!=maxi-1 && i!=maxi-2) {
setpic(urls, photos, 1, i-2);
setpic(urls, photos, 2, i-1);
setpic(urls, photos, 3, i+1);
setpic(urls, photos, 4, i+2);
}
}
//-->
</script>

<TABLE BORDER=0 CELLPADDING=0 CELLSPACING=0 align="center">
	<tr><td colspan=2><IMG SRC="images/sp1.jpg" WIDTH=580 HEIGHT=76 ALT=""></td></tr>
	<tr>
	<td valign="top" width="482"><div class="text"><strong><font size="+1" color="#22355C"><a href="gal.php">Фотогалерея</a></font></strong></div></td>
	<td WIDTH=98 valign="top"><IMG SRC="images/sp2.jpg" WIDTH=98 HEIGHT=60></td>
	</tr>
	<tr><td colspan=2>
<?php
function photomenu($kid) {
	$sql = mysql_query ("select * from gal_kats where 1 order by kat asc");
	$s2 = mysql_query("select ins from gal_kats where id = ".$kid);
	$ins = mysql_result($s2, 0, 'ins');
	print "<div class=text><b>Разделы галереи:</b><ul>";
	$sobrs = array("id"=>array(), "kat"=>array());
	$obsers = array("id"=>array(), "kat"=>array());
	while ($row = mysql_fetch_array($sql)) {
		if($row['ins']!="sobr" && $row['ins']!="obser") {
			if($row['id'] == $kid) print "<li><b>$row[kat]</b></li>";
			else echo "<li><a style='color: 22355c;' href='gal.php?kid=$row[id]'>$row[kat]</a></li>";
		}
		elseif($row['ins']=="sobr") {$sobrs['id'][] = $row['id']; $sobrs['kat'][] = $row['kat'];}
		elseif($row['ins']=="obser") {$obsers['id'][] = $row['id']; $obsers['kat'][] = $row['kat'];}
	}
	if(count($sobrs['id'])>0) {
		print "<li><a style='color: 22355c;' href='#' onclick=\"javascript: document.getElementById('ulsobr').style.display = 'block'; return false;\">Собрания &gt;</a></li>
		<ul id='ulsobr'"; if($ins!="sobr") print " style='display: none;'>"; else print ">";
		for($i=0;$i<count($sobrs['id']);$i++) {
			if($sobrs['id'][$i] == $kid) print "<li><b>".$sobrs['kat'][$i]."</b></li>";
			 else print "<li><a style='color: 22355c;' href='gal.php?kid=".$sobrs['id'][$i]."'>".$sobrs['kat'][$i]."</a></li>";
		}
		print "</ul>";
	}
	if(count($obsers['id'])>0) {
		print "<li><a style='color: 22355c;' href='#' onclick=\"javascript: document.getElementById('ulobser').style.display = 'block'; return false;\">Наблюдения &gt;</a></li>
		<ul id='ulobser'"; if($ins!="obser") print " style='display: none;'>"; else print ">";
		for($i=0;$i<count($obsers['id']);$i++) {
			if($obsers['id'][$i] == $kid) print "<li><b>".$obsers['kat'][$i]."</b></li>";
			 else print "<li><a style='color: 22355c;' href='gal.php?kid=".$obsers['id'][$i]."'>".$obsers['kat'][$i]."</a></li>";
		}
		print "</ul>";
	}
	print "</ul></div>";
}
photomenu($kid);
?>
	</td></tr>
	<tr><td colspan=2><IMG SRC="images/sp3.jpg" WIDTH=580 HEIGHT=24></td></tr>
	<tr><td colspan=2>


          <table width=100% cellspacing=3 cellpadding=5 class=text>
           <tr>
            <td align=center colspan=4><div id="div_main"></div><div id="dop_main" style="display: none;"></div><a style="cursor: hand;" onclick="javascript: window.open('full_image.php?im='+document.getElementById('dop_main').value, '', 'resizable=1, scrollbars=1, menubar=0, status=0, location=0, toolbar=0');"><img id="scene" width="520" alt="Показать в натуральную величину"></a><br><div id="opis"></div></td>
           </tr>
           <tr>
            <td align=center colspan=4><h3>Другие фотографии из галлереи:</h3></td>
           </tr>
           <tr>
            <td style="padding-left : 0px; padding-right : 0px;" align=center valign="top" id="pl1"><a id="href1" href="javascript: bigshow(document.getElementById('dop1').value, maxi, urls, photos);"><img width=140 id="th1" border="0" src=empty.gif><br><div id="div1"></div><div id="dop1" style="display: none;"></div></a></td>
            <td style="padding-left : 0px; padding-right : 0px;" align=center valign="top" id="pl2"><a id="href2" href="javascript: bigshow(document.getElementById('dop2').value, maxi, urls, photos);"><img width=140 id="th2" border="0" src=empty.gif><br><div id="div2"></div><div id="dop2" style="display: none;"></div></a></td>
            <td style="padding-left : 0px; padding-right : 0px;" align=center valign="top" id="pl3"><a id="href3" href="javascript: bigshow(document.getElementById('dop3').value, maxi, urls, photos);"><img width=140 id="th3" border="0" src=empty.gif><br><div id="div3"></div><div id="dop3" style="display: none;"></div></a></td>
            <td style="padding-left : 0px; padding-right : 0px;" align=center valign="top" id="pl4"><a id="href4" href="javascript: bigshow(document.getElementById('dop4').value, maxi, urls, photos);"><img width=140 id="th4" border="0" src=empty.gif><br><div id="div4"></div><div id="dop4" style="display: none;"></div></a></td>
           </tr>
          </table>
		  <script language="JavaScript" type="text/javascript">
		  <!--//
		  bigshow(cur, maxi, urls, photos);
		  //-->
		  </script>

         </td>
        </tr>
       </table>

<?php
include_once("inc/foot.php");
?>
