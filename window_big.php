<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
 <meta http-equiv="content-type" content="text/html; charset=windows-1251">
<style type="text/css"><!--
.text {font-family:Tahoma,sans-serif; font-size: 11px; color:#000000; padding-left:20; padding-right:10 }
a:link{text-decoration: none; color:#22355c}
a:visited{text-decoration: none; color: #22355c}
a:hover{text-decoration: underline; color: #22355c}
a:active{text-decoration: none; color: #22355c}
-->
</style>
<?php

include_once("inc/inc.php");

$opt = $_GET['opt'];
$city = $_GET['city'];

// ����������� ������.
if($opt == 'city') {
$query = @mysql_query("select * from goroda where id=".$city) or ferror(2);
$shir_deg = @mysql_result($query, 0, 'shirota_deg') or ferror(3);
$shir_min = mysql_result($query, 0, 'shirota_min');
$timezone = mysql_result($query, 0, 'timezone');
$city_name = mysql_result($query, 0, 'name');
}
elseif($opt != 'shir') ferror(4);
$shirota = round($shir_deg + $shir_min/60, 2);
if($shirota>90 || $shirota < 40) ferror(5);
elseif($timezone>11 || $timezone < 1) ferror(6);
///////
if($shir_min == '') $shir_min = 0;
if($opt == 'city' && $error == "") $title = $city_name." (".$shir_deg."&deg; ".$shir_min."'); ��������� ����: ".$timezone;
elseif($opt == 'shir' && $error == "") $title = "������ ".$shir_deg."&deg; ".$shir_min."'; ��������� ����: ".$timezone;
?>
	<title>���� ��� ������� - �����������</title>
	<script language="JavaScript" type="text/javascript">
	var w = window.screen.availHeight-200;
	</script>
</head>
<body>
<table cellpadding="0" cellspacing="0" class="text" border="0">
<tr>
<td colspan="2"><?=$title?></td>
</tr>
<tr>
<td rowspan="5" id="div1" valign="top" align="left" bgcolor="#ffffff">&nbsp;
<?php
if(!isset($day)) $day = date("j");
if(!isset($month)) $month = date("m");
if(!isset($hour)) $hour = 0;
if(!isset($minute)) $minute = 0;

// unused option 
?>

</td>
<td style="width: 151; height: 200;" align="left">�������:<br>
<img src="images/cal_gal.gif" border="0" width="13" height="9"> ���������<br>
<img src="images/cal_neb.gif" border="0" width="13" height="9"> ����������<br>
<img src="images/cal_oc.gif" border="0" width="13" height="9"> ��������� ���������<br>
<img src="images/cal_gb.gif" border="0" width="13" height="9"> ������� ���������<br>
<img src="images/cal_cpn.gif" border="0" width="13" height="9"> ��. �����. � �����������<br>
<img src="images/cal_moon.gif" border="0" width="13" height="9"> ����<br>
<img src="images/cal_pole.gif" border="0" width="13" height="9"> �������� �����<br>
<img src="images/cal_ekv.gif" border="0" width="13" height="9"> �������� �������<br><br>
��� ��������� �������������� ����������, �� ������ �������� �� �������.<BR><br>
<!-- ����� �� ������ ��������� ����� ������� ����, ������� ��� ������������ ������� ����. --><BR><BR><BR>
</td>
</tr>
<tr>
<td style="height:100;" id="tdt" valign="top" align="center"></td>
</tr>
		<tr><td>���� ����:<br><img id="moon" src="phase.php?day=<?=$day?>&month=<?=$month?>"></td></tr>
<tr><td>
<table cellpadding="0" cellspacing="0" class="text"><tr><td>&nbsp;
<div id="cursor"><table class=text><tr><td align=right valign=top>������� �������:&nbsp;</td><td>������: 0&deg;, ������: 0&deg;<br>������ �����������: 0 �., ���������: 0&deg;</td></tr></table></div><br>
<form name="f2">
<b>������� � ����:</b> <input type="Text" name="day" maxlength="2" size="2" value="<?=$day?>">&nbsp;<select name="month">
<option value="01" <?php if($month == "01") print "selected" ?>>������
<option value="02" <?php if($month == "02") print "selected" ?>>�������
<option value="03" <?php if($month == "03") print "selected" ?>>����
<option value="04" <?php if($month == "04") print "selected" ?>>������
<option value="05" <?php if($month == "05") print "selected" ?>>���
<option value="06" <?php if($month == "06") print "selected" ?>>����
<option value="07" <?php if($month == "07") print "selected" ?>>����
<option value="08" <?php if($month == "08") print "selected" ?>>������
<option value="09" <?php if($month == "09") print "selected" ?>>��������
<option value="10" <?php if($month == "10") print "selected" ?>>�������
<option value="11" <?php if($month == "11") print "selected" ?>>������
<option value="12" <?php if($month == "12") print "selected" ?>>�������
</select><br><b>�����:</b> <input type="Text" maxlength="2" size="2" name="hour" value="<?=$hour?>">:<input type="Text" maxlength="2" size="2" name="minute" value="<?=$minute?>">&nbsp;<input type="Submit" value="�������" name="goto" onclick="javascript:
var str = '';
if(f1.vstars.checked == false) str += '&no_stars=1';
if(f1.vgal.checked == false) str += '&no_gx=1';
if(f1.vneb.checked == false) str += '&no_nb=1';
if(f1.vscl.checked == false) str += '&no_gb=1';
if(f1.vocl.checked == false) str += '&no_oc=1';
if(f1.vcpn.checked == false) str += '&no_cpn=1';
if(f1.vconst.checked == false) str += '&no_const=1';
if(f1.vnames.checked == false) str += '&no_names=1';
else {
str += '&lang='+f1.lang.value;
str += '&fsize='+f1.fsize.value;
}

if(f1.mag_max_stars.value != <?php if(isset($mag_max_stars)) print $mag_max_stars; else print '4.2' ?>) str += '&mag_max_stars='+f1.mag_max_stars.value;
if(f1.mag_max_obj.value != <?php if(isset($mag_max_obj)) print $mag_max_obj; else print '9' ?>) str += '&mag_max_obj='+f1.mag_max_obj.value;

var max_days;
if(f2.month.value == '02') max_days = 28;
else {
	if(f2.month.value == '04' || f2.month.value == '06' || f2.month.value == '09' || f2.month.value == '11') max_days = 30;
	else {
		max_days = 31;
	}
}

if(f2.day.value<=max_days && f2.hour.value<24 && f2.minute.value<=59 && f1.fsize.value <= 30) {
document.getElementById('iframe').src = 'frame.php?w='+w+'&shirota=<?=$shirota?>&timezone=<?=$timezone?>&day='+f2.day.value+'&month='+f2.month.value+'&hour='+f2.hour.value+'&minute='+f2.minute.value+str;
return false;
} else return false;
">
</form>

</td></tr><tr><td height="100%">
<b>���������:</b>
<form name="f1">
<table cellspacing="0" cellpadding="0" class="text">
<tr><td rowspan="8" align="right" valign="top" class="cont">����������: </td><td class="cont" style="padding-bottom: 0px;"><input type="Checkbox" name="vstars" value="1" onclick="javascript: if(f1.vstars.checked == false) {f1.mag_max_stars.disabled = true;} else {f1.mag_max_stars.disabled = false;}" checked> �����</td></tr>
<tr><td class="cont" style="padding-bottom: 0px;"><input type="Checkbox" name="vconst" value="1" onclick="javascript: if(f1.vconst.checked == false) {f1.vnames.checked = false; f1.lang.disabled = true; f1.fsize.disabled = true;}" checked> ���������</td></tr>
<tr><td class="cont" style="padding-bottom: 0px;">&nbsp;&nbsp;&nbsp;<input type="Checkbox" name="vnames" value="1" onclick="javascript: f1.vconst.checked = true; if(f1.vnames.checked == false) {f1.lang.disabled = true; f1.fsize.disabled = true;} else {f1.lang.disabled = false; f1.fsize.disabled = false;}" checked> ����������� ���������<br>&nbsp;&nbsp;&nbsp;<select class="btn" name="lang"><option selected value="eng">��������� ������������<option value="rus">������� ��������</select><br>&nbsp;&nbsp;&nbsp;������ ������: <input type="Text" size="2" maxlength="2" name="fsize" value="10"></td></tr>
<tr><td class="cont" style="padding-bottom: 0px;"><input type="Checkbox" name="vgal" value="1" checked> ���������</td></tr>
<tr><td class="cont" style="padding-bottom: 0px;"><input type="Checkbox" name="vneb" value="1" checked> ����������</td></tr>
<tr><td class="cont" style="padding-bottom: 0px;"><input type="Checkbox" name="vscl" value="1" checked> ������� ���������</td></tr>
<tr><td class="cont" style="padding-bottom: 0px;"><input type="Checkbox" name="vocl" value="1" checked> ��������� ���������</td></tr>
<tr><td class="cont" style="padding-bottom: 0px;"><input type="Checkbox" name="vcpn" value="1" checked> ��. �����. � �����������</td></tr>
<tr><td align="right" class="cont">���������� ����� ��: </td><td><input type="Text" maxlength="6" size="6" name="mag_max_stars" value="<?php if(isset($mag_max_stars)) print $mag_max_stars; else print '4.2' ?>"</td></tr>
<tr><td align="right" class="cont">���������� ������� ��: </td><td><input type="Text" maxlength="6" size="6" name="mag_max_obj" value="<?php if(isset($mag_max_obj)) print $mag_max_obj; else print '9' ?>"</td></tr>
<tr><td>&nbsp;</td><td><input type="Submit" name="go_main" value="���������" onclick="javascript:
var str = '';
if(f1.vstars.checked == false) str += '&no_stars=1';
if(f1.vgal.checked == false) str += '&no_gx=1';
if(f1.vneb.checked == false) str += '&no_nb=1';
if(f1.vscl.checked == false) str += '&no_gb=1';
if(f1.vocl.checked == false) str += '&no_oc=1';
if(f1.vcpn.checked == false) str += '&no_cpn=1';
if(f1.vconst.checked == false) str += '&no_const=1';
if(f1.vnames.checked == false) str += '&no_names=1';
else {
str += '&lang='+f1.lang.value;
str += '&fsize='+f1.fsize.value;
}

if(f1.mag_max_stars.value != <?php if(isset($mag_max_stars)) print $mag_max_stars; else print '4.2' ?>) str += '&mag_max_stars='+f1.mag_max_stars.value;
if(f1.mag_max_obj.value != <?php if(isset($mag_max_obj)) print $mag_max_obj; else print '9' ?>) str += '&mag_max_obj='+f1.mag_max_obj.value;

var max_days;
if(f2.month.value == '02') max_days = 28;
else {
	if(f2.month.value == '04' || f2.month.value == '06' || f2.month.value == '09' || f2.month.value == '11') max_days = 30;
	else {
		max_days = 31;
	}
}

if(f2.day.value<=max_days && f2.hour.value<24 && f2.minute.value<=59 && f1.fsize.value <= 30) {
document.getElementById('iframe').src = 'frame.php?w='+w+'&shirota=<?=$shirota?>&timezone=<?=$timezone?>&day='+f2.day.value+'&month='+f2.month.value+'&hour='+f2.hour.value+'&minute='+f2.minute.value+str;
return false;
} else return false;
"></td></tr>
</table>
</form>
</td>
</tr>
</table>
</td></tr>
<script language="JavaScript" type="text/javascript">
document.getElementById('div1').style.height = w;
document.getElementById('div1').style.width = w;

var iframe = document.createElement('IFRAME');
iframe.id = 'iframe';
iframe.src = "frame.php?w="+w+"&shirota=<?=$shirota?>&timezone=<?=$timezone?>";
iframe.width = window.screen.availHeight-200;
iframe.height = window.screen.availHeight-200;
iframe.scrolling = "No";
iframe.frameBorder = "0";
iframe.marginheight="0";
iframe.marginwidth="0";
//iframe.style.position = "relative";
//iframe.style.top = document.getElementById('div1').style.top;
document.getElementById('div1').appendChild(iframe);
</script>
</table>
</body>
</html>
