<?php
include_once("inc/head.php");
include_once("inc/inc.php");

# поиск по сайту "Sea_R.Ch."
#################
# Configuration

$subpath = "./";
$min_length = 3;

$modules = array();
$modules['news'] = array(
							'file'=>"read_new.php?nid=@@@", 
							'table'=>"news", 
							'field_for_title'=>"title", 
							'field_for_search'=>"new_full", 
							'field_for_file'=>"id", 
							'title'=>'',
							'add_cond'=>""
						);
$modules['sobrs'] = array(
							'file'=>"sobr.php?act=read_info&sid=@@@", 
							'table'=>"sobr", 
							'field_for_title'=>"name", 
							'field_for_search'=>"members@@text", 
							'field_for_file'=>"id", 
							'title'=>'',
							'add_cond'=>""
						);
$modules['obsers'] = array(
							'file'=>"obser.php?act=read_info&sid=@@@", 
							'table'=>"obser", 
							'field_for_title'=>"name", 
							'field_for_search'=>"members@@text", 
							'field_for_file'=>"id", 
							'title'=>'',
							'add_cond'=>""
						);
$modules['about_club'] = array(
							'file'=>"about_club.php", 
							'table'=>"config", 
							'field_for_title'=>"value", 
							'field_for_search'=>"value", 
							'field_for_file'=>"what", 
							'title'=>"О клубе",
							'add_cond'=>"and what = 'about_text'"
						);
$modules['index_text'] = array(
							'file'=>"index.php", 
							'table'=>"config", 
							'field_for_title'=>"value", 
							'field_for_search'=>"value", 
							'field_for_file'=>"what", 
							'title'=>"Главная",
							'add_cond'=>"and what = 'index_text'"
						);
/*
$nosearch = array();
$nosearch[1] = "sektor.php";
$nosearch[2] = "sky_draw.php";
$nosearch[3] = "sky_draw2.php";
$nosearch[4] = "frame.php";
$nosearch[5] = "search.php";
$nosearch[6] = "news.php";
$nosearch[7] = "about_club.php";
$nosearch[8] = "full_image.php";
$nosearch[9] = "gal.php";
$nosearch[10] = "login.php";
$nosearch[11] = "logout.php";
$nosearch[12] = "members.php";
$nosearch[13] = "obj_info.php";
$nosearch[14] = "obser.php";
$nosearch[15] = "sobr.php";
$nosearch[16] = "phase.php";
$nosearch[17] = "read_new.php";
$nosearch[18] = "showpic.php";
$nosearch[19] = "userdo.php";
*/
/*
$file_titles = array(
						'calendar_select.php'=>"Небо над головой",
						'feed_back.php'=>"Обратная связь",
						'about_club.php'=>"О клубе"
					);
*/
#################
function ferrors($str) {
	print '
	<TABLE WIDTH=500 BORDER=0 CELLPADDING=0 CELLSPACING=0 align="center">
	<tr><td colspan=2><IMG SRC="images/sp1.jpg" WIDTH=580 HEIGHT=76 ALT=""></td></tr>
	<tr>
	<td valign="top" width="482"><div class="texthead">Результаты поиска</div></td>
	<td WIDTH=98 valign="top"><IMG SRC="images/sp2.jpg" WIDTH=98 HEIGHT=60 ALT=""></td>
	</tr>
	<tr><td colspan=2><IMG SRC="images/sp3.jpg" WIDTH=580 HEIGHT=24></td></tr>
	<tr><td colspan=2><div class="text">'.$str.'</div></td></tr>
	<tr><td colspan=2><IMG SRC="images/sp5.jpg" WIDTH=580 HEIGHT=9></td></tr>
	</table>';
	include_once("inc/foot.php");
	exit;
}

if(strlen($text)<$min_length) ferrors("Слишком короткое слово для поиска.");

error_reporting(E_ALL);
/*
function is_good($file) {
	if(eregi("(php|html|htm|php3|shtml|phtml)$", $file)) return true; else return false;
}
*/

//function tag_remove($str) {
/*
	$tags_close = array("script", "style");
	$tags_open = array("td", "tr", "table"); # , "a", "img", "div", "b", "i", "br", "form", "option", "select"
	
	while(strstr($str, "<?")) {
		$n3 = strpos($str, "<?");
		$n4 = strpos($str, "?", $n3);
		$tit = substr($str, $n3, $n4-$n3+2);
		$str = str_replace($tit, "", $str);
	}
	
	while(strstr($str, "</")) {
		$n1 = strpos($str, "</");
		$n2 = strpos($str, ">", $n1);
		$tit = substr($str, $n1, $n2-$n1+1);
		$str = str_replace($tit, "", $str);
	}
	
	foreach($tags_close as $tag) {
		while(eregi("<".$tag, $str)) {
			$n = strpos($str, "<".$tag);
			$n2 = strpos($str, "</".$tag.">", $n);
			$tit = substr($str, $n, $n2-$n+3+strlen($tag));
			$str = str_replace($tit, "", $str);
		}
	}
	
	foreach($tags_open as $tag) {
		while(eregi("<".$tag, $str)) {
			$n = strpos($str, "<".$tag);
			$n2 = strpos($str, ">", $n);
			$tit = substr($str, $n, $n2-$n+1);
			$str = str_replace($tit, "", $str);
		}
	}
	*/
	
	//$str = preg_replace("/<.+>/", "", $str);
	/*
	while(eregi("<input", $str)) {
		$n = strpos($str, "<input");
		$n2 = strpos($str, "\">", $n);
		$tit = substr($str, $n, $n2-$n+2);
		$str = str_replace($tit, "", $str);
	}
	*/
	
	#######################################################
	
	/*
	while(strstr($str, "<?")) {
		$n3 = strpos($str, "<?");
		$n4 = strpos($str, "?", $n3);
		$tit = substr($str, $n3, $n4-$n3+2);
		$str = str_replace($tit, "", $str);
	}
	while(strstr($str, "</")) {
		$n1 = strpos($str, "</");
		$n2 = strpos($str, ">", $n1);
		$tit = substr($str, $n1, $n2-$n1+1);
		$str = str_replace($tit, "", $str);
	}
	$str = strip_tags($str);
	$str2 = "";
	for($i=0;$i<strlen($str);$i++) {
		if(preg_match("/[абвгдеёжзийклмнопрстуфхцчшщъыьэюя-]/i", substr($str, $i, 1)) or substr($str, $i, 1) == " ") $str2 .= substr($str, $i, 1);
	}
	
	return $str2;
}
*/

//$files = array();
//$dirs = array();
$respart = array();
$restitle = array();

// searching in BD
foreach($modules as $mod) {
	$fields = explode("@@", $mod['field_for_search']);
	$query = "select ".$fields[0].", ".$mod['field_for_title'].", ".$mod['field_for_file']." from ".$mod['table']." where ";
	for($i=0;$i<count($fields);$i++) {
		if($i>0) $query .= " or ";
		$query .= $fields[$i]." like '%".$text."%'";
	}
	if($mod['add_cond']!="") $query .= " ".$mod['add_cond'];
	$sql = @mysql_query($query) or ferror(2);
	if(@mysql_num_rows($sql)>0) {
		while($row = @mysql_fetch_assoc($sql)) {
			if($mod['title']!="") $restitle[] = "<a href='".$subpath.str_replace("@@@", $row[$mod['field_for_file']], $mod['file'])."'>".$mod['title']."</a>";
			else $restitle[] = "<a href='".$subpath.str_replace("@@@", $row[$mod['field_for_file']], $mod['file'])."'>".$row[$mod['field_for_title']]."</a>";
			$respart[] = "...".substr($row[$fields[0]], 0, 300)."...";
		}
	}
}
//

// search in news
/*
$sql = @mysql_query("select title, id, new_full from news where new_full regexp '".$text."'") or ferror(2);
if(@mysql_num_rows($sql)>0) {
	while($row = @mysql_fetch_assoc($sql)) {
		$restitle[] = "<a href='read_new.php?nid=".$row['id']."'>".$row['title']."</a>";
		$respart[] = "...".substr($row['new_full'], 0, 300)."...";
	}
}
*/
//

// search in objects
$sql = @mysql_query("select id, ngc from objects where name like '%".$text."%' or ngc regexp '".$text."'") or ferror(2);
if(@mysql_num_rows($sql)>0) {
	while($row = @mysql_fetch_assoc($sql)) {
		if(substr($row['ngc'], 0, 1) == "I") {$pr = "IC"; $code = substr($row['ngc'], 1);}
		else {$pr = "NGC"; $code = $row['ngc'];}
		$qpid = @mysql_query("select id from gal where objid = ".$row['id']);
		if(mysql_num_rows($qpid)>0) {
			$phid = @mysql_result($qpid, 0, 'id');
			$restitle[] = "<a target='_blank' href='showpic.php?pid=".$phid."'>Фотография ".$pr.$code."</a>";
			$respart[] = "";
		}
		$restitle[] = "<a target='_blank' href='obj_info.php?obj=".$pr.$code."'>Информация об объекте ".$pr.$code."</a>";
		$respart[] = "";
	}
}
//



// searching in files
/*
$handle = @opendir($subpath) or ferror(8);
while(false !== ($file = readdir($handle))) {
		if($file != "." && $file != ".." && !array_search($file, $nosearch) && is_good($subpath.$file)) {
			if(is_dir($subpath.$file)) $dirs[] = $file;
			else $files[] = $file;
		}
	}
closedir($handle);
*/
/*
foreach($files as $file) {
	$fs0 = @file_get_contents($subpath.$file) or ferror(9);
	$fs = tag_remove($fs0);
	print "<br><br>".htmlspecialchars($fs);
	if(eregi($text, $fs)) {
		$respart[] = "...".substr($fs, 0, 200)."...";
		if(eregi("<title>", $fs0)) {
			$n = strpos($fs0, "<title>");
			$n2 = strpos($fs0, "</title>");
			$tit = substr($fs0, $n+7, $n2-$n-7);
			$restitle[] = "<a href='".$subpath.$file."'>".$tit."</a>";
		}
		elseif(isset($file_titles[$file])) $restitle[] = "<a href='".$subpath.$file."'>".$file_titles[$file]."</a>";
		else $restitle[] = "<a href='".$subpath.$file."'>".$file."</a>";
	}
}
*/



//
$num = count($restitle);
?>

<TABLE WIDTH=500 BORDER=0 CELLPADDING=0 CELLSPACING=0 align="center">
	<tr><td colspan=2><IMG SRC="images/sp1.jpg" WIDTH=580 HEIGHT=76 ALT=""></td></tr>
	<tr>
	<td valign="top" width="482"><div class="texthead">Результаты поиска</div></td>
	<td WIDTH=98 valign="top"><IMG SRC="images/sp2.jpg" WIDTH=98 HEIGHT=60 ALT=""></td>
	</tr>
	<tr><td colspan=2><IMG SRC="images/sp3.jpg" WIDTH=580 HEIGHT=24></td></tr>
	<tr><td colspan=2><div class="text">

<?php
print "Вы искали: ".$text."<br><br>";
if($num == 0) print "Ничего не найдено.";
else {
	print "Найдено совпадений: ".$num."<br><br>";
	for($i=0;$i<$num;$i++) {
		print $i+1 .") ".$restitle[$i]."<br>".$respart[$i]."<br><br>";
	}
}
?>

</div></td></tr>
	<tr><td colspan=2><IMG SRC="images/sp5.jpg" WIDTH=580 HEIGHT=9></td></tr>											
</table>

<?php
include_once("inc/foot.php");
?>
