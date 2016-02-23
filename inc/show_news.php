<?php
include_once("inc.php");

$query = mysql_query("select date, new_short, title, id from news where 1 order by date desc limit 0, 3");
if(mysql_num_rows($query)<1) print "<tr><td colspan=2><div class=text>Новостей нет</div></td></tr>";
else {
	$i=1;
	while($row = mysql_fetch_assoc($query)) {
		if($i>1 && $i<=3) print "<tr><td colspan=2><IMG SRC=images/l4.jpg WIDTH=200 HEIGHT=9></td></tr>";
		print "<tr><td colspan=2>
			<div class=text><div style='color:22355C'>".date('d.m.Y', $row['date'])."</div><br>".$row['title']."<br>".$row['new_short']."
			<br><a href='read_new.php?nid=".$row['id']."'>Читать полностью ></a></div>
			</td></tr>";
		$i++;
	}
	if(mysql_num_rows($query)>3) {
		print "<tr><td colspan=2><IMG SRC=images/l4.jpg WIDTH=200 HEIGHT=9></td></tr>";
		print "<tr><td colspan=2><div class=text><a href=news.php style='color:22355C'>Все новости ></a></div></td></tr>";
	}
}
?>