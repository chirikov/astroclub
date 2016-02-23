<?php
function ferror($num) {
	include_once("inc/errors.php");
	print "<br><div class='text'>".$errors[$num]."</div>";
	include_once("inc/foot.php");
	exit;
}
function getconf($what) {
	$query = @mysql_query("select value from config where what = '".$what."'");
	$res = @mysql_result($query, 0, 'value');
	return $res;
}
?>