<?php
include_once("inc/inc.php");

if(isset($go)) {
	$next = 0;
	$query = @mysql_query("select id, pass from users where login = '".$_POST['login']."'") or ferror(2);
	$n = mysql_num_rows($query);
	if($n!=1) {$ans = "�� ����� �������������� �����."; $next = 1;}
	if($next == 0) {
		$pass0 = @mysql_result($query, 0, 'pass') or ferror(3);
		if($pass != $pass0) {$ans = "�� ����� ������������ ������."; $next = 2;}
	}
	if($next == 0) {
		$id = mysql_result($query, 0, 'id');
		setcookie("ufaastroclub_id", $id);
		setcookie("ufaastroclub_logged", 1);
		$userid = $id;
		$logged = 1;
	}
}

if($_COOKIE[ufaastroclub_id]!="") $userid = $_COOKIE[ufaastroclub_id];
if($_COOKIE[ufaastroclub_logged]!="") $logged = $_COOKIE[ufaastroclub_logged];

function authform() {
	print "
	<div align='center'>
	<form name='f1' method=post>
	<table class=text>
	<tr><td align='right'>�����: </td><td><input type=text maxlength=50 name=login></td></tr>
	<tr><td align='right'>������: </td><td><input type=Password maxlength=50 name=pass></td></tr>
	<tr><td colspan=2 align='center'><input type=submit value='&nbsp;&nbsp;&nbsp;Ok&nbsp;&nbsp;&nbsp;' name=go onclick=\"
	javascript: if(f1.login.value == '' || f1.login.value == ' ' || f1.login.value == '-') {alert('�� �� ����� �����.'); return false;}
	if(f1.pass.value == '' || f1.pass.value == ' ' || f1.pass.value == '-') {alert('�� �� ����� ������.'); return false;}
	\"></td></tr>
	</table>
	</form>
	</div>
	";
}

function menu($userid) {
	$query = mysql_query("select pravo from users where id = ".$userid);
	$pravo = mysql_result($query, 0, 'pravo');
	if($pravo!="") {
		print "<ul>";
		if(ereg("a", $pravo)) {
			print "<li><a href='userdo.php?act=addnew&uid=".$userid."'>�������� �������</a></li>";
		}
		if(ereg("f", $pravo)) {
			print "<li><a href='userdo.php?act=editnew&uid=".$userid."'>������������� �������</a></li>";
		}
		if(ereg("g", $pravo)) {
			print "<li><a href='userdo.php?act=delnew&uid=".$userid."'>������� �������</a></li>";
		}
		if(ereg("b", $pravo)) {
			print "<br><br><li><a href='userdo.php?act=changemydetails&uid=".$userid."'>�������� ���� ������</a></li>";
		}
		if(ereg("i", $pravo)) {
			print "<li><a href='userdo.php?act=myphoto&uid=".$userid."'>�������� ���� ����������</a></li>";
		}
		if(ereg("h", $pravo)) {
			print "<li><a href='userdo.php?act=changesettings&uid=".$userid."'>�������� ��������� �����</a></li>";
		}
		if(ereg("j", $pravo)) {
			print "<br><br><li><a href='userdo.php?act=addphoto&uid=".$userid."'>�������� ���������� � �����������</a></li>";
		}
		if(ereg("k", $pravo)) {
			print "<li><a href='userdo.php?act=addkat&uid=".$userid."'>�������� ������ �����������</a></li>";
		}
		if(ereg("l", $pravo)) {
			print "<li><a href='userdo.php?act=delkat&uid=".$userid."'>������� ������ �����������</a></li>";
		}
		if(ereg("e", $pravo)) {
			print "<br><br><li><a href='userdo.php?act=addmember&uid=".$userid."'>�������� ����� ����� �������</a></li>";
		}
		if(ereg("m", $pravo)) {
			print "<li><a href='userdo.php?act=confmember&uid=".$userid."'>�������� ����� ����� �� ������</a></li>";
		}
		if(ereg("c", $pravo)) {
			print "<li><a href='userdo.php?act=deleteuser&uid=".$userid."'>������� ����� �����</a></li>";
		}
		if(ereg("d", $pravo)) {
			print "<li><a href='userdo.php?act=setpravo&uid=".$userid."'>��������� �����</a></li>";
		}
		if(ereg("n", $pravo)) {
			print "<br><br><li><a href='userdo.php?act=addsobr&uid=".$userid."'>�������� ���������� � ��������</a></li>";
		}
		if(ereg("o", $pravo)) {
			print "<li><a href='userdo.php?act=addobser&uid=".$userid."'>�������� ���������� � ����������</a></li>";
		}
		print "<br><br><li><a href='logout.php'>����� �� ������ ����������</a></li>";
		print "</ul>";
	}
	else {print "�� ������ �� ������ ����� ������.";}
}

include_once("inc/head.php");

print "<TABLE WIDTH=500 BORDER=0 CELLPADDING=0 CELLSPACING=0 align=center>
	<tr><td colspan=2><IMG SRC=images/sp1.jpg WIDTH=580 HEIGHT=76 ALT=''></td></tr>";

if(isset($userid) && isset($logged) && $next!=1 && $next!=2) {
	$query = @mysql_query("select name, surname from users where id = ".$userid) or ferror(2);
	$name = @mysql_result($query, 0, 'name') or ferror(3);
	$surname = mysql_result($query, 0, 'surname') or ferror(3);
	$fullname = $name."&nbsp;".$surname;
	$heading = "����� ����������, ".$fullname.".";
	print "<tr>
	<td valign=top width=482><div class=texthead>".$heading."</div></td>
	<td WIDTH=98 valign=top><IMG SRC=images/sp2.jpg WIDTH=98 HEIGHT=60 ALT=''></td>
	</tr>
	<tr><td colspan=2><IMG SRC=images/sp3.jpg WIDTH=580 HEIGHT=24></td></tr>
	<tr><td colspan=2>
	<div class=text>";
	menu($userid);
	print "</div>
	</td></tr>";
}
elseif(isset($go) && $next != 0) {
	print "<tr>
	<td valign=top width=482><div class=texthead>$ans</div></td>
	<td WIDTH=98 valign=top><IMG SRC=images/sp2.jpg WIDTH=98 HEIGHT=60 ALT=''></td>
	</tr>
	<tr><td colspan=2><IMG SRC=images/sp3.jpg WIDTH=580 HEIGHT=24></td></tr>
	<tr><td colspan=2>
	<div class=text>";
	authform();
	print "</div>
	</td></tr>";
}
else {
	print "<tr>
	<td valign=top width=482><div class=texthead>������� ���� ����� � ������</div></td>
	<td WIDTH=98 valign=top><IMG SRC=images/sp2.jpg WIDTH=98 HEIGHT=60 ALT=''></td>
	</tr>
	<tr><td colspan=2><IMG SRC=images/sp3.jpg WIDTH=580 HEIGHT=24></td></tr>
	<tr><td colspan=2>
	<div class=text>";
	authform();
	print "</div>
	</td></tr>";
}
?>
	
	<tr><td colspan=2><IMG SRC="images/sp5.jpg" WIDTH=580 HEIGHT=9></td></tr>											
</table>				
<?php
include_once("inc/foot.php");
?>