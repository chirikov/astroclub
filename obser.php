<?php
include_once("inc/inc.php");

function listpage($page) {
	function pages($page) {
		$q = @mysql_query("select id from obser where 1") or ferror(2);
		$n = @mysql_num_rows($q) or ferror(3);
		$pages = ceil($n/getconf("obser_per_page"));
		print "<div class=text align=center>Страницы: ";
		if($pages == 0) print $pages;
		else
		for($i=1;$i<=$pages;$i++) {
			if($i>1) print "&nbsp;|&nbsp;";
			if($i == $page) print "<b style='color: red;'>$i</b>";
			else print "<a href='obser.php?page=".$i."'>$i</a>";
		}
		print "</div>";
	}
	
	$q00 = mysql_query("select id from obser where 1");
	if(mysql_num_rows($q00) == 0) {
		print "<br>Наблюдений в базе данных нет.";
	}
	else {
		pages($page);
		print "<br><br>";
		$q = mysql_query("select id, date, name from obser where 1 order by date desc limit ". ($page-1)*getconf("obser_per_page") .", ".getconf("obser_per_page"));
		print "<table class=text align=center cellspacing=0 width='100%'>";
		$q2 = mysql_query("select id from obser where date > ".time());
		if(mysql_num_rows($q2)>0) print "<tr><td colspan=2>Планируются наблюдения: <br><br></td></tr>";
		$printed_theprev = 0;
		while($row = mysql_fetch_assoc($q)) {
			if($row['date']>time()) print "<tr><td bgcolor='#B4D5FA'>".date('d.m.Y, H:i', $row['date'])."</td><td width='100%' style='border : 1px solid #B4D5FA;'>".$row['name']."</td></tr>";
			else {
				if($printed_theprev==0) {
					print "<tr><td colspan=2><br><br>Прошедшие наблюдения: <br><br></td></tr>";
					$printed_theprev = 1;
				}
				print "<tr><td bgcolor='#EBE9DA'>".date('d.m.Y, H:i', $row['date'])."</td><td width='100%' style='border : 1px solid #EBE9DA;'><a href='obser.php?act=read_info&sid=".$row['id']."'>".$row['name']."</a></td></tr>";
			}
		}
		print "</table>";
		print "<br><br>";
		pages($page);
	}
}

function read_info($sid) {
	$q = mysql_query("select * from obser where id = ".$sid);
	$row = mysql_fetch_assoc($q);
	print "<div class=texthead>".$row['name']."</div><br>
	Дата: ".date('d.m.Y H:i', $row['date'])."<br>
	Место проведения: ".$row['mesto']."<br>
	Принимали участие: ".$row['members']."<br>";
	if($row['gal_kat']!="" && $row['gal_kat']!=0) print "Фотографии: <a href='gal.php?kid=".$row['gal_kat']."'>есть</a><br>";
	print "<br>".stripslashes($row['text']);
}

switch ($act) {
	default: $heading = "Наблюдения астроклуба"; break;
	case "read_info": $heading = "Подробности наблюдения"; break;
}

include_once("inc/head.php");
?>
<TABLE WIDTH=500 BORDER=0 CELLPADDING=0 CELLSPACING=0 align="center">
	<tr><td colspan=2><IMG SRC="images/sp1.jpg" WIDTH=580 HEIGHT=76 ALT=""></td></tr>
	<tr>
	<td valign="top" width="482"><div class="texthead"><?=$heading?></div></td>
	<td WIDTH=98 valign="top"><IMG SRC="images/sp2.jpg" WIDTH=98 HEIGHT=60 ALT=""></td>
	</tr>
	<tr><td colspan=2><IMG SRC="images/sp3.jpg" WIDTH=580 HEIGHT=24></td></tr>
	<tr><td colspan=2 class="text">
	<?php
	if(!isset($page)) $page = 1;
	if(!isset($sid)) {
		$qq = @mysql_query("select id from obser where 1 order by date desc limit 0, 1");
		$sid = @mysql_result($qq, 0, 'id');
	}
	switch ($act) {
		default: listpage($page); break;
		case "read_info": read_info($sid); break;
	}
	?>
	</td></tr>
	<tr><td colspan=2><IMG SRC="images/sp5.jpg" WIDTH=580 HEIGHT=9></td></tr>
</table>
<?php
include_once("inc/foot.php");
?>