<?php
include_once("inc/inc.php");

if (isset($submit)) {
	$ans="";
	if (!empty($_COOKIE[recently])) $ans = "�� ���������� ��������� ������ ������ 5 ����� �����. ��� ������������ ��������� ���������� ������ �� ���� ������ ���� � 5 �����. �������� ��������� �� ����������.";
	else {
		if (empty($name) || $name == " ") $ans = "�� �� ����� ���.";
		if (empty($message)) $ans = "�� �� ����� ����� ������.";
		if (strlen($message)<10 || strlen($message)>1048576) $ans = "����� ��������� ������ ���� �� 10 �� 1048576 ��������.";
		if (!empty($email)) {
			if (!eregi("@", $email) || !eregi("\.", $email)) $ans = "E-mail ������ �������.";
			if (strlen($email)<6 || strlen($email)>60) $ans = "����� E-mail ������ ������ ���� �� 6 �� 60 ��������";
		}
		else $ans = "�� �� ����� E-mail.";
		if ($ans=="") {
			$finalmessage = "
			�����������: $name
			E-mail: $email
			���������: $message";
			$res = @mail($main_email, "����� �������� ����� � ����� ���������� �.���.", "$finalmessage", "Content-type: text/plain; charset=windows-1251");
			if ($res) {
				$ans = "������ ����������.";
				setcookie("recently", "1", time()+300);
			}
			else $ans = "��������� ������ ��� �������� ������. ����������, �������� ��� ��������������. �������� �� ����������.";
		}
	}
}

include_once("inc/head.php");
?>
<TABLE WIDTH=500 BORDER=0 CELLPADDING=0 CELLSPACING=0 align="center">
	<tr><td colspan=2><IMG SRC="images/sp1.jpg" WIDTH=580 HEIGHT=76 ALT=""></td></tr>
	<tr>
	<td valign="top" width="482"><div class="texthead">�������� �����</div></td>
	<td WIDTH=98 valign="top"><IMG SRC="images/sp2.jpg" WIDTH=98 HEIGHT=60 ALT=""></td>
	</tr>
	<tr><td colspan=2><IMG SRC="images/sp3.jpg" WIDTH=580 HEIGHT=24></td></tr>
	<tr><td colspan=2><div class="text">
<?php
if (!empty($ans)) echo "$ans<br><br>";
else {$name=""; $message=""; $email="";}
if(!$res) {
?>
		<form action="feed_back.php" method=post>
		<table class=text>
		<tr><td align="right">���� ���: </td><td><input type=text name=name value="<?=$name?>"></td></tr>
		<tr><td align="right">��� e-mail: </td><td><input type=text name=email value="<?=$email?>"></td></tr>
		<tr><td align="right" valign="top">������: </td><td><textarea name=message cols="45" rows="6"><?=$message?></textarea></td></tr>
		<tr><td align="right"><input type=submit name=submit value=���������></td><td><input type="Reset" value="��������"></td></tr>
		</table>
		</form>
		<?php } ?>
	</div></td></tr>
	<tr><td colspan=2><IMG SRC="images/sp5.jpg" WIDTH=580 HEIGHT=9></td></tr>											
</table>				
<?php
include_once("inc/foot.php");
?>