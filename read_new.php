<?php
include_once("inc/head.php");
include_once("inc/inc.php");

$query = @mysql_query("select title, new_full, author, date from news where id = ".$nid) or ferror(2);
$author = @mysql_result($query, 0, 'author') or ferror(3);
$new = @mysql_result($query, 0, 'new_full');
$date = @mysql_result($query, 0, 'date');
$title = @mysql_result($query, 0, 'title');

$q2 = mysql_query("select name, surname from users where id = ".$author);
$r = mysql_fetch_assoc($q2);
$author = $r[name]." ".$r[surname];

?>
<TABLE WIDTH=500 BORDER=0 CELLPADDING=0 CELLSPACING=0 align="center">
	<tr><td colspan=2><IMG SRC="images/sp1.jpg" WIDTH=580 HEIGHT=76 ALT=""></td></tr>
	<tr>
	<td valign="top" width="482"><div class="texthead"><?=stripslashes($title)?></div></td>
	<td WIDTH=98 valign="top"><IMG SRC="images/sp2.jpg" WIDTH=98 HEIGHT=60 ALT=""></td>
	</tr>
	<tr><td colspan=2><IMG SRC="images/sp3.jpg" WIDTH=580 HEIGHT=24></td></tr>
	<tr><td colspan=2><div class="text">
	<?=date("d.m.Y", $date)?><br>
	Добавил: <?=$author?><br>
	<br>
	<?=stripslashes($new)?>
	</div></td></tr>
	<tr><td colspan=2><IMG SRC="images/sp5.jpg" WIDTH=580 HEIGHT=9></td></tr>											
</table>				
<?php
include_once("inc/foot.php");
?>
