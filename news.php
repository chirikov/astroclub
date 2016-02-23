<?php
include_once("inc/head.php");
include_once("inc/inc.php");

if(!isset($page)) $page = 1;
$q = mysql_query("select id from news where 1");
$n = mysql_num_rows($q);
$pages = ceil($n/getconf("news_per_page"));
if($page>$pages) $page = $pages;
if($page<1) $page = 1;

function pages($page) {
	$q = mysql_query("select id from news where 1");
	$n = mysql_num_rows($q);
	$pages = ceil($n/getconf("news_per_page"));
	print "<div class=text align=center>Страницы: ";
	if($pages == 0) print $pages;
	else
	for($i=1;$i<=$pages;$i++) {
		if($i>1) print "&nbsp;|&nbsp;";
		if($i == $page) print "<b style='color: red;'>$i</b>";
		else print "<a href='news.php?page=".$i."'>$i</a>";
	}
	print "</div>";
}

function givepage($page) {
	$q = mysql_query("select id, new_short, title, author, date from news where 1 order by date desc limit ".($page-1)*getconf("news_per_page").", ".getconf("news_per_page"));
	print "<table class=text width='100%'>";
	while($row = mysql_fetch_assoc($q)) {
		$q2 = mysql_query("select name, surname from users where id = ".$row['author']);
		$r = mysql_fetch_assoc($q2);
		$author = $r[name]." ".$r[surname];
		print "<tr><td colspan=2 bgcolor='#EBE9DA'><b><a href='read_new.php?nid=".$row['id']."'>".stripslashes($row['title'])."</a></b></td></tr>
		<tr><td width=150 valign=top bgcolor='#EBE9DA'>Добавил: ".$author."<br>".date('d.m.Y', $row['date'])."</td><td valign=top>".stripslashes($row['new_short'])."</td></tr>
		";
	}
	print "</table>";
}

?>
<TABLE WIDTH=500 BORDER=0 CELLPADDING=0 CELLSPACING=0 align="center">
	<tr><td colspan=2><IMG SRC="images/sp1.jpg" WIDTH=580 HEIGHT=76 ALT=""></td></tr>
	<tr>
	<td valign="top" width="482"><div class="texthead">Новости</div></td>
	<td WIDTH=98 valign="top"><IMG SRC="images/sp2.jpg" WIDTH=98 HEIGHT=60 ALT=""></td>
	</tr>
	<tr><td colspan=2><IMG SRC="images/sp3.jpg" WIDTH=580 HEIGHT=24></td></tr>
	<tr><td colspan=2><div class="text">
	<br>
<?php
pages($page);
givepage($page);
pages($page);
?>
	<br>
	</div></td></tr>
	<tr><td colspan=2><IMG SRC="images/sp5.jpg" WIDTH=580 HEIGHT=9></td></tr>											
</table>				
<?php
include_once("inc/foot.php");
?>