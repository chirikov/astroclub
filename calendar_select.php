<?php
include_once("inc/head.php");
include_once("inc/inc.php");

$query = @mysql_query("select id, name from goroda where id > 0") or ferror(2);
$ar = array("name"=>array(), "id"=>array());
for($i=115; $i>=0; $i--) {
	$ar["name"][] = @mysql_result($query, $i, 'name') or ferror(3);
	$ar["id"][] = @mysql_result($query, $i, 'id') or ferror(3);
}

?>
<TABLE BORDER=0 CELLPADDING=0 CELLSPACING=0 align="center">
	<tr><td colspan=2><IMG SRC="images/sp1.jpg" WIDTH=580 HEIGHT=76 ALT=""></td></tr>
	<tr>
	<td valign="top" width="482"><div class="texthead">Узнайте, что можно увидеть на небе.</div></td>
	<td WIDTH=98 valign="top"><IMG SRC="images/sp2.jpg" WIDTH=98 HEIGHT=60></td>
	</tr>
	<tr><td colspan=2><IMG SRC="images/sp3.jpg" WIDTH=580 HEIGHT=24></td></tr>
	<tr><td colspan=2><div class="text">
<form name="f1" action="calendar_main.php">
Укажите своё местоположение.<br><br>
<input type="Radio" name="opt" onclick="javascript: 
f1.city.disabled = false;
f1.shir_min.disabled = true;
f1.shir_deg.disabled = true;
f1.timezone.disabled = true;
f1.opt.value = 'city';
" value="city" checked> Выбрать город:
<select name="city">
<?php
for($i=0; $i<116; $i++) {
print "<option value='".$ar['id'][$i]."' "; if($ar['id'][$i] == 103) print " selected"; print ">".$ar['name'][$i];
}
?>
</select><br>
<input type="Radio" onclick="javascript: 
f1.city.disabled = true;
f1.shir_deg.disabled = false;
f1.shir_min.disabled = false;
f1.timezone.disabled = false;
f1.opt.value = 'shir';
" name="opt" value="shir"> Ввести широту и временную зону: <input disabled type="Text" maxlength="2" size="2" name="shir_deg"> градусов <input disabled size="2" maxlength="2" type="Text" name="shir_min"> минут (от 40 до 90 градусов северной широты). 
<br>Временная зона (разница в часах с Гринвичем минус один зимой, минус два летом): <input disabled type="Text" maxlength="2" size="2" name="timezone">
<br>
<input class="btn" type="Submit" value="Дальше" onclick="javascript:
if(f1.opt.value == 'shir') {
	if(f1.timezone.value < 1 || f1.timezone.value > 11) {alert('Неверная временная зона.'); return false;}
	if(f1.shir_deg.value < 0) {alert('Вы не ввели широту.'); return false;}
	if(f1.shir_deg.value > 90) {alert('Вы неверно ввели широту.'); return false;}
	if(f1.shir_min.value > 59) {alert('Вы неверно ввели широту.'); return false;}
	if(f1.shir_deg.value == 90 && f1.shir_min.value > 0) {alert('Вы неверно ввели широту.'); return false;}
	if(f1.shir_min.value < 0) {alert('Вы неверно ввели широту.'); return false;}
	if(f1.shir_deg.value < 40) {alert('Можно вводить лишь широты севернее 40 градусов северной широты.'); return false;}
}
">
</form>
	</div></td></tr>
	<tr><td colspan=2><IMG SRC="images/sp5.jpg" WIDTH=580 HEIGHT=9></td></tr>											
</table>				
<?php
include_once("inc/foot.php");
?>