<?php
include_once("inc/head.php");
include_once("inc/inc.php");

if(!isset($kid)) $kid = 2;
if(!isset($nomer)) $nomer = 1;
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
function listing($nomer, $kid) {
	$query = mysql_query("select id from gal where kid = ".$kid);
	$kol = mysql_num_rows($query);
	$kol_str = ceil($kol/15);
	if($kol_str>1) {
		print "<div class=text>Страницы:&nbsp;";
		for($i=1; $i<=$kol_str; $i++) {
			if($i == $nomer)
			print "<span style='color: #CD1717'><B>$i</B></span>";
			else print "<a href='gal.php?kid=$kid&nomer=$i'>$i</a>";
			if($i<$kol_str) print "&nbsp;|&nbsp;";
		}
		print "</div>";
	}
}
function givepage($nomer, $kid) {
	if($nomer < 1) $nomer = 1;
	if($kid < 1) $kid = 1;
	$kat_name = @mysql_result(mysql_query("select kat from gal_kats where id = ".$kid), 0, 'kat') or ferror(3);
	print "<TABLE BORDER=0 CELLPADDING=0 CELLSPACING=0 align='center'>
	<tr><td colspan=2><IMG SRC='images/sp1.jpg' WIDTH=580 HEIGHT=76 ALT=''></td></tr>
	<tr>
	<td valign='top' width='482'><div class='text'><strong><font size='+1' color='#22355C'>Фотогалерея</font></strong>
	<br><br><br>";
	photomenu($kid);
	print "</div></td>
	<td WIDTH=98 valign='top'><IMG SRC='images/sp2.jpg' WIDTH=98 HEIGHT=60></td>
	</tr>
	<tr><td colspan=2><IMG SRC='images/sp3.jpg' WIDTH=580 HEIGHT=24></td></tr>
	<tr>
	<td align=center colspan=2 class=text><h3 style='text-align: center;'>".$kat_name."</h3>";
	listing($nomer, $kid);
	print "</td></tr>";
	$query = mysql_query("select id, url, photo, objid from gal where kid = ".$kid." order by id desc limit ". ($nomer-1)*15 .", 15");
	$numrows = mysql_num_rows($query);
	if($numrows<1)
	print "<tr><td align='center' colspan=2><div class=text>В данном разделе фотографий нет.</div></td></tr></table>";
	else {
		print "<tr><td colspan=2><table cellpadding=7 cellspacing=7>";
		$i = 0;
		while($row = mysql_fetch_array($query)) {
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
			}
			if($i == 0 or $i%3 == 0) print "<tr>";
			print "<td align=center valign=top><a href='showpic.php?kid=$kid&pid=".$row['id']."'><img border=0 width='170' height='128' src='photos/small/".$row['url']."' alt='".$row['photo']."'><br><div class=text>".$row['photo']."<br>".$poyasn."</div></a></td>";
			if($i == 2 or $i%3 == 2 or $i == $numrows-1) print "</tr>";
			$poyasn = "";
			$i++;
		}
		print "</table></tr>
		<tr><td colspan=2 align=center>";
		listing($nomer, $kid);
		print "</td></tr></table>";
	}
}
givepage($_GET['nomer'], $_GET['kid']);
?>

<?php
include_once("inc/foot.php");
?>