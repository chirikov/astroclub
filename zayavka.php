<?php
include_once("inc/head.php");
include_once("inc/inc.php");

if(isset($go)) {
	$res = false;
	$ans="";
	if($surname == "" || $surname == " ") $ans = "�� �� ����� �������.";
	if($name == "" || $name == " ") $ans .= "<br>�� �� ����� ���.";
	if($email == "" || $email == " ") $ans .= "<br>�� �� ����� e-mail.";
	if(!eregi("@", $email) || !eregi("\.", $email)) $ans .= "<br>�������� e-mail.";
	if(substr($birthdate, 0, 2)>31) $ans .= "<br>�������� �������";
	elseif(substr($birthdate, 2, 2)>12) $ans .= "<br>�������� �������";
	elseif(substr($birthdate, 4, 4)>2000) $ans .= "<br>�������� �������";
	$q = @mysql_query("select id from zayavki where email = '".$email."' and surname = '".$surname."' and name = '".$name."'") or ferror(2);
	if(mysql_num_rows($q)>0) {$ans = "���� ������ ��� ���� � ������."; $res = 2;}
	if($ans=="") {
		$qq = @mysql_query("insert into zayavki (surname, name, otchestvo, email, birthdate, rod, tel, city, other) values('".$surname."', '".$name."', '".$otchestvo."', '".$email."', '".$birthdate."', '".$rod."', '".$tel."', '".$city."', '".$other."')") or $ans = "������ ��� ���������� ������ � ���� ������.";
		if($qq) {$res = true; $ans = "���� ������ ���������. ��� ����� ���������� � ��������� �����. �� � ���� ��������. �������.";}
	}
}

?>
<TABLE WIDTH=500 BORDER=0 CELLPADDING=0 CELLSPACING=0 align="center">
	<tr><td colspan=2><IMG SRC="images/sp1.jpg" WIDTH=580 HEIGHT=76 ALT=""></td></tr>
	<tr>
	<td valign="top" width="482"><div class="texthead">������ �� ���������� � ���������</div></td>
	<td WIDTH=98 valign="top"><IMG SRC="images/sp2.jpg" WIDTH=98 HEIGHT=60 ALT=""></td>
	</tr>
	<tr><td colspan=2><IMG SRC="images/sp3.jpg" WIDTH=580 HEIGHT=24></td></tr>
	<tr><td colspan=2><div class="text">
	<?php
	if($ans!="") print $ans;
	else {$surname=""; $name=""; $otchestvo=""; $email=""; $birthdate=""; $rod=""; $tel=""; $city=""; $other="";}
	if(!$res && $res!=2) {
	?>
	<br><br>������������ ��� ���������� ���� �������� ��������� (*).<br><br>
	<form name="f1">
	<table class="text">
	<tr><td align="right">�������: </td><td><input type="Text" name="surname" maxlength="50" value="<?php print $surname ?>">*</td></tr>
	<tr><td align="right">���: </td><td><input type="Text" name="name" maxlength="50" value="<?php print $name?>">*</td></tr>
	<tr><td align="right">��������:</td><td><input type="Text" name="otchestvo" maxlength="50" value="<?php print $otchestvo?>"></td></tr>
	<tr><td align="right">E-mail: </td><td><input type="Text" name="email" maxlength="50" value="<?php print $email?>">*</td></tr>
	<tr><td align="right">���� �������� (ddmmyyyy): </td><td><input type="Text" name="birthdate" maxlength="8" size="8" value="<?php print $birthdate?>"></td></tr>
	<tr><td align="right">��� ������������: </td><td><input type="Text" name="rod" maxlength="100" value="<?php print $rod?>"></td></tr>
	<tr><td align="right">�������: </td><td><input type="Text" name="tel" maxlength="50" value="<?php print $tel?>"></td></tr>
	<tr><td align="right">�����: </td><td><input type="Text" name="city" maxlength="30" value="<?php if($city!="") print $city; else print "���"; ?>"></td></tr>
	<tr><td align="right" valign="top">������:<br>(��� ����� �����������, ��������� ������������, ������ ��������� � �.�.)</td><td><textarea name="other" rows="7" cols="30"><?php print $other?></textarea></td></tr>
	<tr><td align="right" style="width: 30%;"><input type="Submit" name="go" value="���������" onclick="javascript:
	if(f1.surname.value == '') {alert('�� �� ����� �������.'); return false;}
	if(f1.name.value == '') {alert('�� �� ����� ���.'); return false;}
	if(f1.email.value == '') {alert('�� �� ����� e-mail.'); return false;}
	"></td><td><input type="button" value="��������" name="res" onclick="javascript: 
	var i;
	for(i=0; i<f1.elements.length; i++) {
		if(f1.elements(i).name != 'go' && f1.elements(i).name != 'res') f1.elements(i).value = '';
	}
	return false;
	"></td></tr>
	</table>
	</form>
	<?php } ?>
	</div></td></tr>
	<tr><td colspan=2><IMG SRC="images/sp5.jpg" WIDTH=580 HEIGHT=9></td></tr>											
</table>				
<?php
include_once("inc/foot.php");
?>