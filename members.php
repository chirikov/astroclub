<?php
include_once("inc/inc.php");

function memlist() {
	print "<table class=text>";
	$q = @mysql_query("select id, name, surname, webpage, email from users where 1 order by surname asc") or ferror(2);
	while($row = @mysql_fetch_assoc($q)) {
		print "<tr>";
		if($row[webpage]!="") print "<td><a href='".$row[webpage]."' target='_blank'><img src='images/home.gif' border=0></a></td>";
		else print "<td></td>";
		print "<td><a href='members.php?act=sendemail&mid=".$row[id]."'><img src='images/mail.gif' border=0></a></td>
		<td><a href='members.php?act=readinfo&mid=".$row[id]."'>".$row[name]." ".$row[surname]."</a></td>
		</tr>";
	}
	print "</table>";
}

function readinfo($mid) {
	print "<table align=center><tr><td align=center>";
	$file = "";
	if(file_exists("photos/small/user".$mid.".jpg")) $file = "photos/small/user".$mid.".jpg";
	elseif(file_exists("photos/small/user".$mid.".jpeg")) $file = "photos/small/user".$mid.".jpeg";
	elseif(file_exists("photos/small/user".$mid.".gif")) $file = "photos/small/user".$mid.".gif";
	elseif(file_exists("photos/small/user".$mid.".png")) $file = "photos/small/user".$mid.".png";
	if($file!="") print "<img src='".$file."'>";
	print "</td></tr><tr><td><table class=text align=center>";
	$q = mysql_query("select * from users where id = ".$mid);
	$row = mysql_fetch_assoc($q);
	print "
	<tr><td>���: </td><td>".$row[name]."</td></tr>
	<tr><td>�������: </td><td>".$row[surname]."</td></tr>
	<tr><td>���� ��������: </td><td>".substr($row[birthdate], 0, 2).".".substr($row[birthdate], 2, 2).".".substr($row[birthdate], 4)."</td></tr>
	<tr><td>���� �����������: </td><td>".date('d.m.Y', $row[regdate])."</td></tr>";
	if($row[rod]!="") print "<tr><td>��� ������������: </td><td>".$row[rod]."</td></tr>";
	if($row[city]!="") print "<tr><td>�����: </td><td>".$row[city]."</td></tr>";
	if($row[icq]!="") print "<tr><td>ICQ: </td><td>".$row[icq]."</td></tr>";
	if($row[webpage]!="") print "<tr><td>�������� ��������: </td><td><a target='_blank' href='".$row[webpage]."'>".$row[webpage]."</a></td></tr>";
	if($row[other]!="") print "<tr><td valign=top>������: </td><td>".$row[other]."</td></tr>";
	print "
	<tr><td colspan=2 align=center><br><input type=Button value='�������� ������' onclick=\"javascript: location = 'members.php?act=sendemail&mid=".$mid."'\"></td></tr>
	</table></td></tr></table>";
}

function sendemail_form($mid, $qtheme, $qname, $qemail, $qmessage) {
	$q = @mysql_query("select name, surname, email from users where id = ".$mid) or ferror(2);
	$name = @mysql_result($q, 0, 'name') or ferror(3);
	$surname = mysql_result($q, 0, 'surname');
	$email = mysql_result($q, 0, 'email');
	print "
	<form action='members.php' method=post name='sendemail'>
	<input type=Hidden name='mid' value=".$mid.">
	<input type=Hidden name=act value='sendemail_done'>
	<table class=text>
	<tr><td align=right>����: </td><td>".$name." ".$surname."</td></tr>
	<tr><td align=right>����: </td><td><input type=text name=theme maxlength=100 value='".$qtheme."'></td></tr>
	<tr><td align=right>���� ���: </td><td><input type=text name=name maxlength=40 value='".$qname."'></td></tr>
	<tr><td align=right>��� e-mail: </td><td><input type=text name=email maxlength=60 value='".$qemail."'></td></tr>
	<tr><td align=right valign=top>������: </td><td><textarea name=message cols=45 rows=6>".$qmessage."</textarea></td></tr>
	<tr><td align=right><input type=submit name=sendemail_sub value='���������' onclick=\"javascript: 
	if(sendemail.message.value.length > 1048576) {alert('������� ������� ������.'); return false;}
	\"></td><td><input type='Reset' value='��������'></td></tr>
	</table>
	</form>";
}

if(isset($sendemail_sub)) {
	$res = false;
	$ans="";
	if(empty($name) || $name == " ") $ans = "�� �� ����� ���.";
	if(empty($theme) || $theme == " ") $ans = "�� �� ����� ����.";
	if(empty($message)) $ans = "�� �� ����� ����� ������.";
	if(strlen($message)<10 || strlen($message)>1048576) $ans = "����� ��������� ������ ���� �� 10 �� 1048576 ��������.";
	if(!empty($email)) {
		if(!eregi("@", $email) || !eregi("\.", $email)) $ans = "E-mail ������ �������.";
		if(strlen($email)<6 || strlen($email)>60) $ans = "����� E-mail ������ ������ ���� �� 6 �� 60 ��������";
	}
	else $ans = "�� �� ����� E-mail.";
	if($ans=="") {
		$qq = @mysql_query("select email from users where id = ".$mid) or ferror(2);
		$emailto = @mysql_result($qq, 0, 'email') or ferror(3);
		$finalmessage = "
		�����������: $name
		��� E-mail: $email
		����: $theme
		���������: $message";
		$res = @mail($emailto, "������ � ����� ���������� �.���", "$finalmessage", "Content-type: text/plain; charset=windows-1251");
		if(!$res) $ans = "��������� ������ ��� �������� ������. ����������, �������� ��� ��������������. �������� �� ����������.";
	}
}

switch ($act) {
	case "sendemail":
	$header = "�������� ������ ����� �����";
	break;
	case "sendemail_done":
	if($res) $header = "������ ����������";
	else $header = "��������� ������ ��� �������� ������";
	break;
	case "readinfo":
	$header = "���������� � ����� �����";
	break;
	default:
	$header = "������ ���������� ������ ���";
}
include_once("inc/head.php");
?>
<TABLE WIDTH=500 BORDER=0 CELLPADDING=0 CELLSPACING=0 align="center">
	<tr><td colspan=2><IMG SRC="images/sp1.jpg" WIDTH=580 HEIGHT=76 ALT=""></td></tr>
	<tr>
	<td valign="top" width="482"><div class="texthead"><?=$header?></div></td>
	<td WIDTH=98 valign="top"><IMG SRC="images/sp2.jpg" WIDTH=98 HEIGHT=60 ALT=""></td>
	</tr>
	<tr><td colspan=2><IMG SRC="images/sp3.jpg" WIDTH=580 HEIGHT=24></td></tr>
	<tr><td colspan=2><div class="text">
	<?php
	switch ($act) {
		case "sendemail":
			sendemail_form($mid, '', '', '', '');
		break;
		case "sendemail_done":
			if($res) memlist();
			else {print $ans; sendemail_form($mid, $theme, $name, $email, $message);}
		break;
		case "readinfo":
			readinfo($mid);
		break;
		default:
			memlist();
	}
	?>
	</div></td></tr>
	<tr><td colspan=2><IMG SRC="images/sp5.jpg" WIDTH=580 HEIGHT=9></td></tr>											
</table>				
<?php
include_once("inc/foot.php");
?>