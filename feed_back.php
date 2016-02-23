<?php
include_once("inc/inc.php");

if (isset($submit)) {
	$ans="";
	if (!empty($_COOKIE[recently])) $ans = "Вы отправляли последнее письмо меньше 5 минут назад. Для безопасности разрешено отправлять письма не чаще одного раза в 5 минут. Приносим извинения за неудобства.";
	else {
		if (empty($name) || $name == " ") $ans = "Вы не ввели имя.";
		if (empty($message)) $ans = "Вы не ввели текст письма.";
		if (strlen($message)<10 || strlen($message)>1048576) $ans = "Длина сообщения должна быть от 10 до 1048576 символов.";
		if (!empty($email)) {
			if (!eregi("@", $email) || !eregi("\.", $email)) $ans = "E-mail введен неверно.";
			if (strlen($email)<6 || strlen($email)>60) $ans = "Длина E-mail адреса должна быть от 6 до 60 символов";
		}
		else $ans = "Вы не ввели E-mail.";
		if ($ans=="") {
			$finalmessage = "
			Отправитель: $name
			E-mail: $email
			Сообщение: $message";
			$res = @mail($main_email, "Форма обратной связи с сайта астроклуба г.Уфы.", "$finalmessage", "Content-type: text/plain; charset=windows-1251");
			if ($res) {
				$ans = "Письмо отправлено.";
				setcookie("recently", "1", time()+300);
			}
			else $ans = "Произошла ошибка при отправке письма. Пожалуйста, сообщите это администратору. Извините за неудобства.";
		}
	}
}

include_once("inc/head.php");
?>
<TABLE WIDTH=500 BORDER=0 CELLPADDING=0 CELLSPACING=0 align="center">
	<tr><td colspan=2><IMG SRC="images/sp1.jpg" WIDTH=580 HEIGHT=76 ALT=""></td></tr>
	<tr>
	<td valign="top" width="482"><div class="texthead">Обратная связь</div></td>
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
		<tr><td align="right">Ваше имя: </td><td><input type=text name=name value="<?=$name?>"></td></tr>
		<tr><td align="right">Ваш e-mail: </td><td><input type=text name=email value="<?=$email?>"></td></tr>
		<tr><td align="right" valign="top">Письмо: </td><td><textarea name=message cols="45" rows="6"><?=$message?></textarea></td></tr>
		<tr><td align="right"><input type=submit name=submit value=Отправить></td><td><input type="Reset" value="Очистить"></td></tr>
		</table>
		</form>
		<?php } ?>
	</div></td></tr>
	<tr><td colspan=2><IMG SRC="images/sp5.jpg" WIDTH=580 HEIGHT=9></td></tr>											
</table>				
<?php
include_once("inc/foot.php");
?>