<?php
include_once("inc/inc.php");

$error = "";
if(!isset($_COOKIE[ufaastroclub_id]) || !isset($_COOKIE[ufaastroclub_logged])) $error = "Вы неправильно зашли на данную страницу. Введите свой логин и пароль <a href='login.php'>здесь</a>.";
elseif(isset($_COOKIE[ufaastroclub_id]) && $uid != $_COOKIE[ufaastroclub_id]) $error = "Вы неправильно зашли на данную страницу. Введите свой логин и пароль <a href='login.php'>здесь</a>.";

////// functions start //
function menu($userid) {
	$query = mysql_query("select pravo from users where id = ".$userid);
	$pravo = mysql_result($query, 0, 'pravo');
	if($pravo!="") {
		print "<ul>";
		if(ereg("a", $pravo)) {
			print "<li><a href='userdo.php?act=addnew&uid=".$userid."'>Добавить новость</a></li>";
		}
		if(ereg("f", $pravo)) {
			print "<li><a href='userdo.php?act=editnew&uid=".$userid."'>Редактировать новость</a></li>";
		}
		if(ereg("g", $pravo)) {
			print "<li><a href='userdo.php?act=delnew&uid=".$userid."'>Удалить новость</a></li>";
		}
		if(ereg("b", $pravo)) {
			print "<br><br><li><a href='userdo.php?act=changemydetails&uid=".$userid."'>Изменить свои данные</a></li>";
		}
		if(ereg("i", $pravo)) {
			print "<li><a href='userdo.php?act=myphoto&uid=".$userid."'>Закачать свою фотографию</a></li>";
		}
		if(ereg("h", $pravo)) {
			print "<li><a href='userdo.php?act=changesettings&uid=".$userid."'>Изменить настройки сайта</a></li>";
		}
		if(ereg("j", $pravo)) {
			print "<br><br><li><a href='userdo.php?act=addphoto&uid=".$userid."'>Добавить фотографию в фотогалерею</a></li>";
		}
		if(ereg("k", $pravo)) {
			print "<li><a href='userdo.php?act=addkat&uid=".$userid."'>Добавить раздел фотогалереи</a></li>";
		}
		if(ereg("l", $pravo)) {
			print "<li><a href='userdo.php?act=delkat&uid=".$userid."'>Удалить раздел фотогалереи</a></li>";
		}
		if(ereg("e", $pravo)) {
			print "<br><br><li><a href='userdo.php?act=addmember&uid=".$userid."'>Добавить члена клуба вручную</a></li>";
		}
		if(ereg("m", $pravo)) {
			print "<li><a href='userdo.php?act=confmember&uid=".$userid."'>Добавить члена клуба по заявке</a></li>";
		}
		if(ereg("c", $pravo)) {
			print "<li><a href='userdo.php?act=deleteuser&uid=".$userid."'>Удалить члена клуба</a></li>";
		}
		if(ereg("d", $pravo)) {
			print "<li><a href='userdo.php?act=setpravo&uid=".$userid."'>Назначить права</a></li>";
		}
		if(ereg("n", $pravo)) {
			print "<br><br><li><a href='userdo.php?act=addsobr&uid=".$userid."'>Добавить информацию о собрании</a></li>";
		}
		if(ereg("o", $pravo)) {
			print "<li><a href='userdo.php?act=addobser&uid=".$userid."'>Добавить информацию о наблюдении</a></li>";
		}
		print "<br><br><li><a href='logout.php'>Выйти из Панели управления</a></li>";
		print "</ul>";
	}
	else {print "Вы ничего не имеете право делать.";}
}

function addnew_form($uid, $title, $kratko, $polno) {
	$query = mysql_query("select pravo, name, surname from users where id = ".$uid);
	$pravo = mysql_result($query, 0, 'pravo');
	if(!ereg("a", $pravo) && $error == "") {
		$error = "Вы не имеете права добавлять новости. Вернитесь в <a href='login.php'>Панель управления</a>.";
		print $error;
	}
	else {
		$name = mysql_result($query, 0, 'name');
		$surname = mysql_result($query, 0, 'surname');
		$auth = $name." ".$surname;
		print "
		<form name='addnew' action='userdo.php'>
		<input type=hidden name='act' value='addnew_done'>
		<input type=hidden name='uid' value='".$uid."'>
		<table class=text>
		<tr><td align=right>Заголовок: </td><td><input type=text name='zagolovok' value='".$title."' maxlength=100></td></tr>
		<tr><td align=right valign=top>Кратко: </td><td><textarea name='kratko' rows=4 cols=20>".$kratko."</textarea></td></tr>
		<tr><td align=right valign=top>Новость: </td><td><textarea name='polno' rows=7 cols=30>".$polno."</textarea></td></tr>
		<tr><td align=right>Автор: </td><td>$auth</td></tr>
		<tr><td align=right><input type=submit name='addnew_sub' value='Добавить' onclick=\"javascript: 
		if(addnew.zagolovok.value.length < 10) {alert('Заголовок слишком короткий.'); return false;}
		if(addnew.zagolovok.value.length > 512) {alert('Заголовок слишком длинный.'); return false;}
		if(addnew.kratko.value.length < 10) {alert('Краткое описание новости слишком маленькое.'); return false;}
		if(addnew.kratko.value.length > 1024) {alert('Краткое описание новости слишком большое.'); return false;}
		if(addnew.polno.value.length < 20) {alert('Новость слишком короткая.'); return false;}
		if(addnew.polno.value.length > 1048576) {alert('Новость слишком длинная.'); return false;}
		\"></td><td><input type=reset value='Очистить'></td></tr>
		</table>
		</form>";
	}
}

function changemydetails_form($uid) {
	$query = mysql_query("select pravo from users where id = ".$uid);
	$pravo = mysql_result($query, 0, 'pravo');
	if(!ereg("b", $pravo) && $error == "") {
		$error = "Вы не имеете права изменять свои данные. Вернитесь в <a href='login.php'>Панель управления</a>.";
		print $error;
	}
	else {
		$q = mysql_query("select * from users where id = ".$uid);
		$row = mysql_fetch_assoc($q);
		?>
		<form name='changemydetails' action='userdo.php'>
		<input type=hidden name='act' value='changemydetails_done'>
		<input type=hidden name='uid' value='<?=$uid?>'>
		<table class=text>
		<tr><td align="right">Логин: </td><td><input type="Text" name="login" maxlength="50" value="<?=$row[login]?>"></td></tr>
		<tr><td align="right">Фамилия: </td><td><input type="Text" name="surname" maxlength="50" value="<?=$row[surname]?>"></td></tr>
		<tr><td align="right">Имя: </td><td><input type="Text" name="name" maxlength="50" value="<?=$row[name]?>"></td></tr>
		<tr><td align="right">E-mail: </td><td><input type="Text" name="email" maxlength="50" value="<?=$row[email]?>"></td></tr>
		<tr><td align="right">Дата рождения (ddmmyyyy): </td><td><input type="Text" name="birthdate" maxlength="8" size="8" value="<?=$row[birthdate]?>"></td></tr>
		<tr><td align="right">Род деятельности: </td><td><input type="Text" name="rod" maxlength="100" value="<?=$row[rod]?>"></td></tr>
		<tr><td align="right">ICQ: </td><td><input type="Text" name="icq" maxlength="20" value="<?=$row[icq]?>"></td></tr>
		<tr><td align="right">URL: </td><td><input type="Text" name="webpage" maxlength="50" value="<?=$row[webpage]?>"></td></tr>
		<tr><td align="right">Телефон: </td><td><input type="Text" name="tel" maxlength="50" value="<?=$row[tel]?>"></td></tr>
		<tr><td align="right">Город: </td><td><input type="Text" name="city" maxlength="30" value="<?=$row[city]?>"></td></tr>
		<tr><td align="right" valign="top">Прочее: </td><td><textarea name="other" rows="7" cols="30"><?=$row[other]?></textarea></td></tr>
		<tr><td colspan="2">Если вы хотите изменить свой пароль, введите ниже два раза новый пароль.</td></tr>
		<tr><td align="right">Новый пароль: </td><td><input type="Text" name="pass1" maxlength="50"></td></tr>
		<tr><td align="right">Ещё раз новый пароль: </td><td><input type="Text" name="pass2" maxlength="50"></td></tr>
		<tr><td align="right" style="width: 30%;"><input type="Submit" name="changemydetails_sub" value="Отправить"></td><td><input type="reset" value="Очистить"></td></tr>
		</table>
		</form>
		<?php
	}
}

function addmember_form($uid) {
	$query = mysql_query("select pravo from users where id = ".$uid);
	$pravo = mysql_result($query, 0, 'pravo');
	if(!ereg("e", $pravo) && $error == "") {
		$error = "Вы не имеете права добавлять члена астроклуба. Вернитесь в <a href='login.php'>Панель управления</a>.";
		print $error;
	}
	else {
		?>
		<form name='addmember' action='userdo.php'>
		<input type=hidden name='act' value='addmember_done'>
		<input type=hidden name='uid' value='<?=$uid?>'>
		<table class=text align="center" width="100%">
		<tr><td align="right">Логин: </td><td><input type="Text" name="login" maxlength="50">*</td></tr>
		<tr><td align="right">Пароль: </td><td><input type="Text" name="pass" maxlength="50">*</td></tr>
		<tr><td align="right">Фамилия: </td><td><input type="Text" name="surname" maxlength="50">*</td></tr>
		<tr><td align="right">Имя: </td><td><input type="Text" name="name" maxlength="50">*</td></tr>
		<tr><td align="right">E-mail: </td><td><input type="Text" name="email" maxlength="50">*</td></tr>
		<tr><td align="right">Дата рождения (ddmmyyyy): </td><td><input type="Text" name="birthdate" maxlength="8" size="8"></td></tr>
		<tr><td align="right">Род деятельности: </td><td><input type="Text" name="rod" maxlength="100"></td></tr>
		<tr><td align="right">ICQ: </td><td><input type="Text" name="icq" maxlength="20"></td></tr>
		<tr><td align="right">URL: </td><td><input type="Text" name="webpage" maxlength="50"></td></tr>
		<tr><td align="right">Телефон: </td><td><input type="Text" name="tel" maxlength="50"></td></tr>
		<tr><td align="right">Город: </td><td><input type="Text" name="city" maxlength="30" value="Уфа"></td></tr>
		<tr><td align="right" valign="top">Прочее: </td><td><textarea name="other" rows="7" cols="30"></textarea></td></tr>
		<tr><td>Права человека:</td><td></td></tr>
		<tr><td><input type="Checkbox" name="canaddnew" value="1"> Добавлять новости</td><td></td></tr>
		<tr><td><input type="Checkbox" name="caneditnew" value="1"> Редактировать новости</td><td></td></tr>
		<tr><td><input type="Checkbox" name="candelnew" value="1"> Удалять новости<br><br></td><td></td></tr>
		<tr><td><input type="Checkbox" name="canchangedetails" value="1"> Изменять свои данные</td><td></td></tr>
		<tr><td nowrap><input type="Checkbox" name="canaddmyphoto" value="1"> Добавлять свою фотографию</td><td></td></tr>
		<tr><td><input type="Checkbox" name="canchangesettings" value="1"> Изменять настройки сайта<br><br></td><td></td></tr>
		<tr><td><input type="Checkbox" name="canaddphoto" value="1"> Добавлять фотографии</td><td></td></tr>
		<tr><td><input type="Checkbox" name="canaddkat" value="1"> Добавлять разделы галереи</td><td></td></tr>
		<tr><td><input type="Checkbox" name="candelkat" value="1"> Удалять разделы галереи<br><br></td><td></td></tr>
		<tr><td><input type="Checkbox" name="canaddmember" value="1"> Добавлять новых членов</td><td></td></tr>
		<tr><td><input type="Checkbox" name="candelmember" value="1"> Удалять членов</td><td></td></tr>
		<tr><td><input type="Checkbox" name="cansetpravo" value="1"> Назначать права<br><br></td><td></td></tr>
		<tr><td><input type="Checkbox" name="canaddsobr" value="1"> Добавлять собрания</td><td></td></tr>
		<tr><td><input type="Checkbox" name="canaddobser" value="1"> Добавлять наблюдения</td><td></td></tr>
		<tr><td align="right" style="width: 30%;"><input type="Submit" name="addmember_sub" value="Отправить"></td><td><input type="reset" value="Очистить"></td></tr>
		</table>
		</form>
		<?php
	}
}

function deleteuser_form($uid) {
	$query = mysql_query("select pravo from users where id = ".$uid);
	$pravo = mysql_result($query, 0, 'pravo');
	if(!ereg("c", $pravo) && $error == "") {
		$error = "Вы не имеете права удалять члена астроклуба. Вернитесь в <a href='login.php'>Панель управления</a>.";
		print $error;
	}
	else {
		$q = mysql_query("select id, name, surname, regdate from users where 1");
		print "<form name='deleteuser' action='userdo.php'>
		<input type=hidden name='act' value='deleteuser_done'>
		<input type=hidden name='uid' value='".$uid."'>
		<table class=text>
		<tr><td></td><td>Имя</td><td>Дата регистрации</td></tr>
		";
		while($row = mysql_fetch_assoc($q)) {
			print "<tr><td><input type='Checkbox' name='user".$row[id]."' value=1></td><td>".$row[name]." ".$row[surname]."</td><td>".date('d.m.Y H:i', $row[regdate])."</td></tr>";
		}
		print "
		<tr><td colspan=3><input type='Submit' value='Удалить' name='deleteuser_sub'></td></tr>
		</table></form>";
	}
}

function setpravo_form($uid) {
	$query = mysql_query("select pravo from users where id = ".$uid);
	$pravo = mysql_result($query, 0, 'pravo');
	if(!ereg("d", $pravo) && $error == "") {
		$error = "Вы не имеете права назначать права членам астроклуба. Вернитесь в <a href='login.php'>Панель управления</a>.";
		print $error;
	}
	else {
		print "<script language='JavaScript' type='text/javascript'>
		var prava = new Array ();";
		$q = mysql_query("select id, pravo from users where 1");
		while($row = mysql_fetch_assoc($q)) {
			print "prava[".$row[id]."] = '".$row[pravo]."';";
		}
		print "</script>";
		print "
		<form name='setpravo' action='userdo.php'>
		<input type=hidden name='act' value='setpravo_done'>
		<input type=hidden name='uid' value='".$uid."'>
		<table class=text>
		<tr><td valign=top><select name='users' onchange=\"javascript: 
		var pravo = prava[setpravo.users.value];
		if(pravo.search('a')!=-1) {setpravo.canaddnew.checked = true;} else {setpravo.canaddnew.checked = false;}
		if(pravo.search('f')!=-1) {setpravo.caneditnew.checked = true;} else {setpravo.caneditnew.checked = false;}
		if(pravo.search('g')!=-1) {setpravo.candelnew.checked = true;} else {setpravo.candelnew.checked = false;}
		
		if(pravo.search('b')!=-1) {setpravo.canchangedetails.checked = true;} else {setpravo.canchangedetails.checked = false;}
		if(pravo.search('i')!=-1) {setpravo.canaddmyphoto.checked = true;} else {setpravo.canaddmyphoto.checked = false;}
		if(pravo.search('h')!=-1) {setpravo.canchangesettings.checked = true;} else {setpravo.canchangesettings.checked = false;}
		
		if(pravo.search('j')!=-1) {setpravo.canaddphoto.checked = true;} else {setpravo.canaddphoto.checked = false;}
		if(pravo.search('k')!=-1) {setpravo.canaddkat.checked = true;} else {setpravo.canaddkat.checked = false;}
		if(pravo.search('l')!=-1) {setpravo.candelkat.checked = true;} else {setpravo.candelkat.checked = false;}
		
		if(pravo.search('e')!=-1) {setpravo.canaddmember.checked = true;} else {setpravo.canaddmember.checked = false;}
		if(pravo.search('c')!=-1) {setpravo.candelmember.checked = true;} else {setpravo.candelmember.checked = false;}
		if(pravo.search('d')!=-1) {setpravo.cansetpravo.checked = true;} else {setpravo.cansetpravo.checked = false;}
		
		if(pravo.search('n')!=-1) {setpravo.canaddsobr.checked = true;} else {setpravo.canaddsobr.checked = false;}
		if(pravo.search('o')!=-1) {setpravo.canaddobser.checked = true;} else {setpravo.canaddobser.checked = false;}
		\">";
		$q = mysql_query("select name, surname, id from users where 1");
		while($row = mysql_fetch_assoc($q)) {
			print "<option value='".$row[id]."'>".$row[name]." ".$row[surname];
		}
		print "
		</select></td><td>
		"; ?>
		<input type="Checkbox" name="canaddnew" value="1"> Добавлять новости<br>
		<input type="Checkbox" name="caneditnew" value="1"> Редактировать новости<br>
		<input type="Checkbox" name="candelnew" value="1"> Удалять новости<br>
		<input type="Checkbox" name="canchangedetails" value="1"> Изменять свои данные<br>
		<input type="Checkbox" name="canaddmyphoto" value="1"> Добавлять свою фотографию<br>
		<input type="Checkbox" name="canchangesettings" value="1"> Изменять настройки сайта<br>
		<input type="Checkbox" name="canaddphoto" value="1"> Добавлять фотографии<br>
		<input type="Checkbox" name="canaddkat" value="1"> Добавлять разделы галереи<br>
		<input type="Checkbox" name="candelkat" value="1"> Удалять разделы галереи<br>
		<input type="Checkbox" name="canaddmember" value="1"> Добавлять новых членов<br>
		<input type="Checkbox" name="candelmember" value="1"> Удалять членов<br>
		<input type="Checkbox" name="cansetpravo" value="1"> Назначать права<br>
		<input type="Checkbox" name="canaddsobr" value="1"> Добавлять собрания<br>
		<input type="Checkbox" name="canaddobser" value="1"> Добавлять наблюдения<br>
		<?php print "</td></tr>
		<tr><td colspan=2><input type=submit name='setpravo_sub' value='Назначить'></td></tr>
		</table>
		</form>
		<script language='JavaScript' type='text/javascript'>
		var pravo = prava[setpravo.users.value];
		if(pravo.search('a')!=-1) {setpravo.canaddnew.checked = true;} else {setpravo.canaddnew.checked = false;}
		if(pravo.search('f')!=-1) {setpravo.caneditnew.checked = true;} else {setpravo.caneditnew.checked = false;}
		if(pravo.search('g')!=-1) {setpravo.candelnew.checked = true;} else {setpravo.candelnew.checked = false;}
		
		if(pravo.search('b')!=-1) {setpravo.canchangedetails.checked = true;} else {setpravo.canchangedetails.checked = false;}
		if(pravo.search('i')!=-1) {setpravo.canaddmyphoto.checked = true;} else {setpravo.canaddmyphoto.checked = false;}
		if(pravo.search('h')!=-1) {setpravo.canchangesettings.checked = true;} else {setpravo.canchangesettings.checked = false;}
		
		if(pravo.search('j')!=-1) {setpravo.canaddphoto.checked = true;} else {setpravo.canaddphoto.checked = false;}
		if(pravo.search('k')!=-1) {setpravo.canaddkat.checked = true;} else {setpravo.canaddkat.checked = false;}
		if(pravo.search('l')!=-1) {setpravo.candelkat.checked = true;} else {setpravo.candelkat.checked = false;}
		
		if(pravo.search('e')!=-1) {setpravo.canaddmember.checked = true;} else {setpravo.canaddmember.checked = false;}
		if(pravo.search('c')!=-1) {setpravo.candelmember.checked = true;} else {setpravo.candelmember.checked = false;}
		if(pravo.search('d')!=-1) {setpravo.cansetpravo.checked = true;} else {setpravo.cansetpravo.checked = false;}
		
		if(pravo.search('n')!=-1) {setpravo.canaddsobr.checked = true;} else {setpravo.canaddsobr.checked = false;}
		if(pravo.search('o')!=-1) {setpravo.canaddobser.checked = true;} else {setpravo.canaddobser.checked = false;}
		</script>
		";
	}
}

function delnew_form($uid, $page) {
	$query = mysql_query("select pravo from users where id = ".$uid);
	$pravo = mysql_result($query, 0, 'pravo');
	if(!ereg("g", $pravo) && $error == "") {
		$error = "Вы не имеете права удалять новости. Вернитесь в <a href='login.php'>Панель управления</a>.";
		print $error;
	}
	else {
		function pages($uid, $page) {
			$q = mysql_query("select id from news where 1");
			$n = mysql_num_rows($q);
			$pages = ceil($n/getconf("news_per_page"));
			print "<div class=text align=center>Страницы: ";
			if($pages == 0) print $pages;
			else
			for($i=1;$i<=$pages;$i++) {
				if($i>1) print "&nbsp;|&nbsp;";
				if($i == $page) print "<b style='color: red;'>$i</b>";
				else print "<a href='userdo.php?uid=".$uid."&act=delnew&page=".$i."'>$i</a>";
			}
			print "</div>";
		}
		pages($uid, $page);
		$q = mysql_query("select * from news where 1 order by date desc limit ".($page-1)*getconf("news_per_page").", ".getconf("news_per_page"));
		if(mysql_num_rows($q)<1) print "<div class=text align=center><br>Новостей нет</div><br>";
		else {
			print "<form action='userdo.php'>
			<input type=hidden name='act' value='delnew_done'>
			<input type=hidden name='uid' value='".$uid."'>
			<input type=hidden name='delnew_sub' value=1>
			<table class=text width='100%'>";
			$ii=0;
			while($row = mysql_fetch_assoc($q)) {
				$ii++;
				$q2 = mysql_query("select name, surname from users where id = ".$row['author']);
				$r = mysql_fetch_assoc($q2);
				$author = $r[name]." ".$r[surname];
				print "<tr><td colspan=2 bgcolor='#EBE9DA'><b>".$row['title']."</b></td></tr>
				<tr><td width=150 valign=top bgcolor='#EBE9DA'>Добавил: ".$author."<br>".date('d.m.Y', $row['date'])."</td><td valign=top>".$row['new_short']."</td></tr>
				<tr><td colspan=2 align=right bgcolor='#EBE9DA' style='padding-right: 25px;'><a style='cursor: hand; text-decoration: underline;' onclick=\"javascript: document.getElementById('newfull".$ii."').style.display = 'block';\">Новость полностью</a></td></tr>
				<tr id='newfull".$ii."' style='display: none'><td colspan=2>".$row['new_full']."</td></tr>
				<tr><td colspan=2 align=right style='padding-right: 25px;'><input type=Submit value='Удалить' name='delnew_sub".$row['id']."'</td></tr>
				";
			}
			print "</table>";
		}
		pages($uid, $page);
	}
}

function editnew_form($uid, $page) {
	$query = mysql_query("select pravo from users where id = ".$uid);
	$pravo = mysql_result($query, 0, 'pravo');
	if(!ereg("f", $pravo) && $error == "") {
		$error = "Вы не имеете права редактировать новости. Вернитесь в <a href='login.php'>Панель управления</a>.";
		print $error;
	}
	else {
		function pages($uid, $page) {
			$q = mysql_query("select id from news where 1");
			$n = mysql_num_rows($q);
			$pages = ceil($n/getconf("news_per_page"));
			print "<div class=text align=center>Страницы: ";
			if($pages == 0) print $pages;
			else
			for($i=1;$i<=$pages;$i++) {
				if($i>1) print "&nbsp;|&nbsp;";
				if($i == $page) print "<b style='color: red;'>$i</b>";
				else print "<a href='userdo.php?uid=".$uid."&act=editnew&page=".$i."'>$i</a>";
			}
			print "</div>";
		}
		function addnew_form2($uid, $title, $kratko, $polno, $nid) {
			print "
			<table class=text>
			<tr><td align=right>Заголовок: </td><td><input type=text name='zagolovok".$nid."' value='".$title."' maxlength=100></td></tr>
			<tr><td align=right valign=top>Кратко: </td><td><textarea name='kratko".$nid."' rows=4 cols=20>".$kratko."</textarea></td></tr>
			<tr><td align=right valign=top>Новость: </td><td><textarea name='polno".$nid."' rows=7 cols=30>".$polno."</textarea></td></tr>
			<tr><td align=right><input type=submit name='editnew_sub".$nid."' value='Готово' onclick=\"javascript: 
			if(editnew.zagolovok".$nid.".value.length < 10) {alert('Заголовок слишком короткий.'); return false;}
			if(editnew.zagolovok".$nid.".value.length > 512) {alert('Заголовок слишком длинный.'); return false;}
			if(editnew.kratko".$nid.".value.length < 10) {alert('Краткое описание новости слишком маленькое.'); return false;}
			if(editnew.kratko".$nid.".value.length > 1024) {alert('Краткое описание новости слишком большое.'); return false;}
			if(editnew.polno".$nid.".value.length < 20) {alert('Новость слишком короткая.'); return false;}
			if(editnew.polno".$nid.".value.length > 1048576) {alert('Новость слишком длинная.'); return false;}
			\"></td><td><input type=reset value='Очистить'></td></tr>
			</table>";
		}
		pages($uid, $page);
		$q = mysql_query("select * from news where 1 order by date desc limit ".($page-1)*getconf("news_per_page") .", ".getconf("news_per_page"));
		if(mysql_num_rows($q)<1) print "<div class=text align=center><br>Новостей нет</div><br>";
		else {
			print "<form action='userdo.php' name='editnew'>
			<input type=hidden name='act' value='editnew_done'>
			<input type=hidden name='uid' value='".$uid."'>
			<input type=hidden name='editnew_sub' value=1>
			";
			$ii=0;
			while($row = mysql_fetch_assoc($q)) {
				$ii++;
				addnew_form2($uid, $row[title], $row[new_short], $row[new_full], $row[id]);
			}
			print "</form>";
		}
		pages($uid, $page);
	}
}

function changesettings_form($uid) {
	$query = mysql_query("select pravo from users where id = ".$uid);
	$pravo = mysql_result($query, 0, 'pravo');
	if(!ereg("h", $pravo) && $error == "") {
		$error = "Вы не имеете права изменять настройки сайта. Вернитесь в <a href='login.php'>Панель управления</a>.";
		print $error;
	}
	else {
		$q = mysql_query("select * from config where 1");
		print "
		<form name='changesettings' action='userdo.php'>
		<input type=hidden name='act' value='changesettings_done'>
		<input type=hidden name='uid' value='".$uid."'>
		<table class=text>";
		$russian = array(
			"about_text"=>"О клубе",
			"news_per_page"=>"Сколько новостей выводить на одной странице",
			"index_text"=>"Текст на главной странице",
			"sobr_per_page"=>"Сколько собраний выводить на одной странице",
			"obser_per_page"=>"Сколько наблюдений выводить на одной странице"
		);
		while($row = mysql_fetch_assoc($q)) {
			print "<tr><td align=right valign=top>".$russian[$row['what']].": </td><td><textarea rows=4 cols=20 name='".$row['what']."'>".$row['value']."</textarea></td></tr>";
		}
		print "
		<tr><td align=right><input type=submit name='changesettings_sub' value='Подтвердить'></td><td><input type=Reset value='Очистить'></td></tr>
		</table></form>";
	}
}

function myphoto_form($uid) {
	$query = mysql_query("select pravo from users where id = ".$uid);
	$pravo = mysql_result($query, 0, 'pravo');
	if(!ereg("i", $pravo) && $error == "") {
		$error = "Вы не имеете права закачивать свою фотографию. Вернитесь в <a href='login.php'>Панель управления</a>.";
		print $error;
	}
	else {
		$filec = "";
		if(file_exists("photos/small/user".$uid.".jpg")) $filec = "photos/small/user".$uid.".jpg";
		elseif(file_exists("photos/small/user".$uid.".jpeg")) $filec = "photos/small/user".$uid.".jpeg";
		elseif(file_exists("photos/small/user".$uid.".gif")) $filec = "photos/small/user".$uid.".gif";
		elseif(file_exists("photos/small/user".$uid.".png")) $filec = "photos/small/user".$uid.".png";
		if($filec != "") print "У вас уже есть фотография:&nbsp;&nbsp;&nbsp; <img src='".$filec."' border=0><br>";
		print "
		<form action='userdo.php' method=post enctype=multipart/form-data>
		<input type=hidden name='act' value='myphoto_done'>
		<input type=hidden name='uid' value='".$uid."'>
		Путь к файлу: <input type='File' name=file> <input type='Submit' value='Закачать' name='myphoto_sub'>
		</form>
		";
	}
}

function addphoto_form($uid) {
	$query = mysql_query("select pravo from users where id = ".$uid);
	$pravo = mysql_result($query, 0, 'pravo');
	if(!ereg("j", $pravo) && $error == "") {
		$error = "Вы не имеете права закачивать фотографии. Вернитесь в <a href='login.php'>Панель управления</a>.";
		print $error;
	}
	else {
		print "
		<form action='userdo.php' method=post enctype=multipart/form-data>
		<input type=hidden name='act' value='addphoto_done'>
		<input type=hidden name='uid' value='".$uid."'>
		<table class=text>
		<tr><td align=right>Комментарий: </td><td><input type=text name=comment></td></tr>
		<tr><td align=right>Автор: </td><td><input type=text name=author></td></tr>
		<tr><td colspan=2>Если фотография относится к объекту дальнего космоса, желательно указать его номер в каталоге: </td></tr>
		<tr><td align=right>Номер объекта по NGC (Только номер без ведущих нолей. Если номер по IC, то перед номером без пробела поставьте I): </td><td><input type=text name=ngcid></td></tr>
		<tr><td align=right>Номер объекта по каталогу Мессье (только номер): </td><td><input type=text name=mid></td></tr>
		<tr><td align=right>Раздел фотографии: </td><td><select name=kid>";
		$sql = mysql_query ("select * from gal_kats where 1 order by kat ASC");
		while ($row = mysql_fetch_array($sql)) {echo "<option value=$row[id]>$row[kat]";}
		echo
		"</select></td></tr>
		<tr><td align=right>Путь к файлу: </td><td><input type='File' name=file></td></tr>
		<tr><td colspan=2 align=center><input type='Submit' value='Закачать' name='addphoto_sub'></td></tr>
		</table>
		</form>
		";
	}
}

function addkat_form($uid) {
	$query = mysql_query("select pravo from users where id = ".$uid);
	$pravo = mysql_result($query, 0, 'pravo');
	if(!ereg("k", $pravo) && $error == "") {
		$error = "Вы не имеете права добавлять разделы фотогалереи. Вернитесь в <a href='login.php'>Панель управления</a>.";
		print $error;
	}
	else {
		print "
		<form action='userdo.php'>
		<input type=hidden name='act' value='addkat_done'>
		<input type=hidden name='uid' value='".$uid."'>
		Название раздела: <input type=text name=name><br>
		<input type=radio name='ins' value='sobr'> Раздел относится к собраниям<br>
		<input type=radio name='ins' value='obser'> Раздел относится к наблюдениям<br>
		<input type='Submit' value='Добавить' name='addkat_sub'>
		</form>
		";
	}
}

function delkat_form($uid) {
	$query = mysql_query("select pravo from users where id = ".$uid);
	$pravo = mysql_result($query, 0, 'pravo');
	if(!ereg("l", $pravo) && $error == "") {
		$error = "Вы не имеете права удалять разделы фотогалереи. Вернитесь в <a href='login.php'>Панель управления</a>.";
		print $error;
	}
	else {
		print "
		<script language=JavaScript type=text/javascript>
		var lastremovedi = 999999;
		var lastremovedvalue = '';
		var lastremovedtext = '';
		</script>
		<form action='userdo.php' name='delkat'>
		<input type=hidden name='act' value='delkat_done'>
		<input type=hidden name='uid' value='".$uid."'>
		Удалить раздел: <select name=name onchange=\"javascript: 
		var col = delkat.drraz.children;
		var i;
		if(lastremovedi != 999999) {
			var el = document.createElement('OPTION');
			el.value = lastremovedvalue;
			el.text = lastremovedtext;
			delkat.drraz.add(el, lastremovedi);
		}
		for(i=0; i<col.length; i++) {
			if(col[i].value == this.value) {lastremovedvalue = col[i].value; lastremovedtext = col[i].text; lastremovedi = i; delkat.drraz.remove(i);}
		}
		\">";
		$sql = mysql_query("select * from gal_kats where 1 order by kat ASC");
		while($row = mysql_fetch_array($sql)) {echo "<option value=$row[id]>$row[kat]";}
		print "</select><br><br>
		Что делать с имеющимися в разделе фотографиями:<br><br>
		<input type=Radio checked name=doing value='del' onclick=\"javascript: 
		if(this.checked == true) {delkat.drraz.disabled = true;}
		\"> Удалить<br>
		<input type=Radio name=doing value='move' onclick=\"javascript: 
		if(this.checked == true) {delkat.drraz.disabled = false;}
		\"> Переместить в другой раздел: <select name='drraz' disabled>";
		$sql = mysql_query("select * from gal_kats where 1 order by kat ASC");
		while($row = mysql_fetch_array($sql)) {echo "<option value=$row[id]>$row[kat]";}
		print "</select><br><br>
		<input type='Submit' value='Удалить' name='delkat_sub'>
		</form>
		<script language=JavaScript type=text/javascript>
		lastremovedi = 0;
		lastremovedvalue = delkat.drraz.children[0].value;
		lastremovedtext = delkat.drraz.children[0].text;
		delkat.drraz.remove(0);
		</script>
		";
	}
}

function confmember_form($uid) {
	$query = mysql_query("select pravo from users where id = ".$uid);
	$pravo = mysql_result($query, 0, 'pravo');
	if(!ereg("m", $pravo) && $error == "") {
		$error = "Вы не имеете права добавлять члена астроклуба по заявке. Вернитесь в <a href='login.php'>Панель управления</a>.";
		print $error;
	}
	else {
		$q00 = mysql_query("select id from zayavki where 1");
		if(mysql_num_rows($q00) == 0) {
			print "Заявок нет.";
		}
		else {
			print "
			<form action='userdo.php'>
			<input type=hidden name='uid' value='".$uid."'>
			<table align=center class=text style='border : 1px solid #EBE9DA;' cellpadding=0 cellspacing=0>
			<tr><td bgcolor='#EBE9DA'></td><td bgcolor='#EBE9DA'>Имя</td><td bgcolor='#EBE9DA'>Фамилия</td><td bgcolor='#EBE9DA'>Дата рождения</td></tr>";
			$q = mysql_query("select id, name, surname, birthdate from zayavki order by id asc");
			$i = 1;
			while($row = mysql_fetch_assoc($q)) {
				if($row['birthdate']=="") $age = "&nbsp;";
				else $age = substr($row["birthdate"], 0, 2).".".substr($row["birthdate"], 2, 2).".".substr($row["birthdate"], 4);
				print "<tr><td><input type=radio";
				if($i==1) print " checked";
				print " name=zid value=".$row['id']."></td><td>".$row['name']."</td><td>".$row['surname']."</td><td>".$age."</td></tr>";
				$i++;
			}
			print "<tr><td colspan=4>&nbsp;</td></tr>
			<tr><td><input type=Radio checked name=act value='confmember_info'></td><td colspan=3> Просмотреть заявку</td></tr>
			<tr><td><input type=Radio name=act value='confmember_add'></td><td colspan=3> Отредактировать и добавить члена клуба</td></tr>
			<tr><td><input type=Radio name=act value='confmember_del_done'></td><td colspan=3> Удалить заявку</td></tr>
			<tr><td colspan=4><input type=submit name='confmember_sub' value='Дальше'></td></tr>
			</table></form>";
		}
	}
}

function confmember_info_form($zid, $uid) {
	$query = mysql_query("select pravo from users where id = ".$uid);
	$pravo = mysql_result($query, 0, 'pravo');
	if(!ereg("m", $pravo) && $error == "") {
		$error = "Вы не имеете права добавлять члена астроклуба по заявке. Вернитесь в <a href='login.php'>Панель управления</a>.";
		print $error;
	}
	else {
		print "
		<form action='userdo.php'>
		<input type=hidden name='uid' value='".$uid."'>
		<input type=hidden name='zid' value='".$zid."'>
		<input type=hidden name='act' value='confmember_add'>
		<table align=center class=text>";
		$q = mysql_query("select * from zayavki where id = ".$zid);
		$row = mysql_fetch_assoc($q);
		print "
		<tr><td align=right>Фамилия: </td><td>".$row['surname']."</td></tr>
		<tr><td align=right>Имя: </td><td>".$row['name']."</td></tr>";
		if($row['otchestvo']!="") print "<tr><td align=right>Отчество: </td><td>".$row['otchestvo']."</td></tr>";
		print "<tr><td align=right>E-mail: </td><td>".$row['email']."</td></tr>";
		if($row['birthdate']!="") print "<tr><td align=right>Дата рождения: </td><td>".substr($row["birthdate"], 0, 2).".".substr($row["birthdate"], 2, 2).".".substr($row["birthdate"], 4)."</td></tr>";
		if($row['rod']!="") print "<tr><td align=right>Род деятельности: </td><td>".$row['rod']."</td></tr>";
		if($row['tel']!="") print "<tr><td align=right>Телефон: </td><td>".$row['tel']."</td></tr>";
		if($row['city']!="") print "<tr><td align=right>Город: </td><td>".$row['city']."</td></tr>";
		if($row['other']!="") print "<tr><td valign=top align=right>Прочее: </td><td>".$row['other']."</td></tr>";
		print "<tr><td colspan=2>&nbsp;</td></tr>
		<tr><td colspan=2 align=center><input type=Button value='Назад' onclick=\"javascript: 
		location = 'userdo.php?act=confmember&uid=".$uid."';
		\"><input type=submit name='confmember_info_sub' value='Добавить в члены клуба'></td></tr>
		</table></form>";
	}
}

function confmember_add_form($zid, $uid) {
	$query = mysql_query("select pravo from users where id = ".$uid);
	$pravo = mysql_result($query, 0, 'pravo');
	if(!ereg("m", $pravo) && $error == "") {
		$error = "Вы не имеете права добавлять члена астроклуба по заявке. Вернитесь в <a href='login.php'>Панель управления</a>.";
		print $error;
	}
	else {
		print "
		<form action='userdo.php'>
		<input type=hidden name='uid' value='".$uid."'>
		<input type=hidden name='zid' value='".$zid."'>
		<input type=hidden name='act' value='confmember_done'>
		<table align=center class=text>";
		$q = mysql_query("select * from zayavki where id = ".$zid);
		$row = mysql_fetch_assoc($q);
		print '
		<tr><td align="right">Логин: </td><td><input type="Text" name="login" maxlength="50">*</td></tr>
		<tr><td align="right">Пароль: </td><td><input type="Text" name="pass" maxlength="50">*</td></tr>
		<tr><td align="right">Фамилия: </td><td><input type="Text" name="surname" value="'.$row["surname"].'" maxlength="50">*</td></tr>
		<tr><td align="right">Имя: </td><td><input type="Text" name="name" value="'.$row["name"].'" maxlength="50">*</td></tr>
		<tr><td align="right">E-mail: </td><td><input type="Text" name="email" value="'.$row["email"].'" maxlength="50">*</td></tr>
		<tr><td align="right">Дата рождения (ddmmyyyy): </td><td><input type="Text" name="birthdate" value="'.$row["birthdate"].'" maxlength="8" size="8"></td></tr>
		<tr><td align="right">Род деятельности: </td><td><input type="Text" name="rod" value="'.$row["rod"].'" maxlength="100"></td></tr>
		<tr><td align="right">ICQ: </td><td><input type="Text" name="icq" maxlength="20"></td></tr>
		<tr><td align="right">URL: </td><td><input type="Text" name="webpage" maxlength="50"></td></tr>
		<tr><td align="right">Телефон: </td><td><input type="Text" name="tel" value="'.$row["tel"].'" maxlength="50"></td></tr>
		<tr><td align="right">Город: </td><td><input type="Text" name="city" maxlength="30" value="'.$row["city"].'"></td></tr>
		<tr><td align="right" valign="top">Прочее: </td><td><textarea name="other" rows="7" cols="30">'.$row["other"].'</textarea></td></tr>
		<tr><td>Права человека:</td><td></td></tr>
		<tr><td><input type="Checkbox" name="canaddnew" value="1"> Добавлять новости</td><td></td></tr>
		<tr><td><input type="Checkbox" name="caneditnew" value="1"> Редактировать новости</td><td></td></tr>
		<tr><td><input type="Checkbox" name="candelnew" value="1"> Удалять новости<br><br></td><td></td></tr>
		<tr><td><input type="Checkbox" name="canchangedetails" value="1"> Изменять свои данные</td><td></td></tr>
		<tr><td nowrap><input type="Checkbox" name="canaddmyphoto" value="1"> Добавлять свою фотографию</td><td></td></tr>
		<tr><td><input type="Checkbox" name="canchangesettings" value="1"> Изменять настройки сайта<br><br></td><td></td></tr>
		<tr><td><input type="Checkbox" name="canaddphoto" value="1"> Добавлять фотографии</td><td></td></tr>
		<tr><td><input type="Checkbox" name="canaddkat" value="1"> Добавлять разделы галереи</td><td></td></tr>
		<tr><td><input type="Checkbox" name="candelkat" value="1"> Удалять разделы галереи<br><br></td><td></td></tr>
		<tr><td><input type="Checkbox" name="canaddmember" value="1"> Добавлять новых членов</td><td></td></tr>
		<tr><td><input type="Checkbox" name="candelmember" value="1"> Удалять членов</td><td></td></tr>
		<tr><td><input type="Checkbox" name="cansetpravo" value="1"> Назначать права<br><br></td><td></td></tr>
		<tr><td><input type="Checkbox" name="canaddsobr" value="1"> Добавлять собрания</td><td></td></tr>
		<tr><td><input type="Checkbox" name="canaddobser" value="1"> Добавлять наблюдения</td><td></td></tr>
		';
		print "<tr><td colspan=2>&nbsp;</td></tr>
		<tr><td colspan=2 align=center><input type=Button value='Назад' onclick=\"javascript: 
		location = 'userdo.php?act=confmember&uid=".$uid."';
		\"><input type=submit name='confmember_add_sub' value='Готово'></td></tr>
		</table></form>";
	}
}

function addsobr_form($uid, $name="", $date="", $time="", $mesto="", $members="", $text="") {
	$query = mysql_query("select pravo from users where id = ".$uid);
	$pravo = mysql_result($query, 0, 'pravo');
	if(!ereg("n", $pravo) && $error == "") {
		$error = "Вы не имеете права добавлять информацию о собраниях астроклуба. Вернитесь в <a href='login.php'>Панель управления</a>.";
		print $error;
	}
	else {
		print "
		<script language=JavaScript type=text/javascript>
		var i = 1;
		</script>
		<form action='userdo.php' method=post enctype=multipart/form-data name='addsobr'>
		<input type=hidden name='uid' value='".$uid."'>
		<input type=hidden name='act' value='addsobr_done'>
		<input type=hidden name='photos' value=''>
		<table align=center class=text>";
		print '
		<tr><td colspan=2>Все поля обязательны для заполнения.<br><br></td></tr>
		<tr><td align="right">Заголовок: </td><td><input type="Text" name="name" maxlength="50" value="'.$name.'"></td></tr>
		<tr><td align="right">Дата (ddmmyyyy): </td><td><input type="Text" name="date" size="8" maxlength="8" value="'.$date.'"></td></tr>
		<tr><td align="right">Время начала (hhmm): </td><td><input type="Text" name="time" size="4" maxlength="4" value="'.$time.'"></td></tr>
		<tr><td align="right">Место проведения: </td><td><input type="Text" name="mesto" value="'.$mesto.'"></td></tr>
		<tr><td align="right">Принимали участие: </td><td><textarea name="members">'.$members.'</textarea></td></tr>
		<tr><td align="right" valign="top">Содержание: </td><td><textarea name="text" rows="7" cols="30">'.$text.'</textarea></td></tr>
		<tr><td>Вы можете добавить фотографии:</td><td></td></tr>';
		print "<tr><td colspan=2 id='td1'>
		<table class=text cellpadding=0 cellspacing=0 id='table1' style='display: none;'>
		<tr><td colspan=2><br></td></tr>
		<tr><td align=right>Комментарий: </td><td><input type=text name=comment1></td></tr>
		<tr><td align=right>Автор: </td><td><input type=text name=author1></td></tr>
		<tr><td align=right>Путь к файлу: </td><td><input type='File' name='file1'></td></tr>
		</table>
		<table class=text cellpadding=0 cellspacing=0 id='table2' style='display: none;'>
		<tr><td colspan=2><br></td></tr>
		<tr><td align=right>Комментарий: </td><td><input type=text name=comment2></td></tr>
		<tr><td align=right>Автор: </td><td><input type=text name=author2></td></tr>
		<tr><td align=right>Путь к файлу: </td><td><input type='File' name='file2'></td></tr>
		</table>
		<table class=text cellpadding=0 cellspacing=0 id='table3' style='display: none;'>
		<tr><td colspan=2><br></td></tr>
		<tr><td align=right>Комментарий: </td><td><input type=text name=comment3></td></tr>
		<tr><td align=right>Автор: </td><td><input type=text name=author3></td></tr>
		<tr><td align=right>Путь к файлу: </td><td><input type='File' name='file3'></td></tr>
		</table>
		<table class=text cellpadding=0 cellspacing=0 id='table4' style='display: none;'>
		<tr><td colspan=2><br></td></tr>
		<tr><td align=right>Комментарий: </td><td><input type=text name=comment4></td></tr>
		<tr><td align=right>Автор: </td><td><input type=text name=author4></td></tr>
		<tr><td align=right>Путь к файлу: </td><td><input type='File' name='file4'></td></tr>
		</table>
		<table class=text cellpadding=0 cellspacing=0 id='table5' style='display: none;'>
		<tr><td colspan=2><br></td></tr>
		<tr><td align=right>Комментарий: </td><td><input type=text name=comment5></td></tr>
		<tr><td align=right>Автор: </td><td><input type=text name=author5></td></tr>
		<tr><td align=right>Путь к файлу: </td><td><input type='File' name='file5'></td></tr>
		</table>
		</td></tr>
		<tr><td colspan=2 align=right><input type=Button name='more' value='Добавить фотографии' onclick=\"javascript: 
		document.getElementById('table'+i).style.display = 'block';
		addsobr.photos.value = i;
		this.value = 'Ещё фотография...';
		i++;
		if(i>5) {addsobr.more.disabled = true; alert('Если вы хотите добавить ещё фотографии, вы можете добавить их непосредственно в фотогалерею в раздел \''+addsobr.name.value+'\' в группе \'Собрания\'.');}
		\"></td></tr>
		";
		print "<tr><td colspan=2>&nbsp;</td></tr>
		<tr><td align=right><input type=reset value='Очистить'></td><td><input type=submit name='addsobr_sub' value='Готово'></td></tr>
		</table></form>";
	}
}

function addobser_form($uid, $name="", $date="", $time="", $mesto="", $members="", $text="") {
	$query = mysql_query("select pravo from users where id = ".$uid);
	$pravo = mysql_result($query, 0, 'pravo');
	if(!ereg("o", $pravo) && $error == "") {
		$error = "Вы не имеете права добавлять информацию о наблюдениях астроклуба. Вернитесь в <a href='login.php'>Панель управления</a>.";
		print $error;
	}
	else {
		print "
		<script language=JavaScript type=text/javascript>
		var i = 1;
		</script>
		<form action='userdo.php' method=post enctype=multipart/form-data name='addobser'>
		<input type=hidden name='uid' value='".$uid."'>
		<input type=hidden name='act' value='addobser_done'>
		<input type=hidden name='photos' value=''>
		<table align=center class=text>";
		print '
		<tr><td colspan=2>Все поля обязательны для заполнения.<br><br></td></tr>
		<tr><td align="right">Заголовок: </td><td><input type="Text" name="name" maxlength="50" value="'.$name.'"></td></tr>
		<tr><td align="right">Дата (ddmmyyyy): </td><td><input type="Text" name="date" size="8" maxlength="8" value="'.$date.'"></td></tr>
		<tr><td align="right">Время начала (hhmm): </td><td><input type="Text" name="time" size="4" maxlength="4" value="'.$time.'"></td></tr>
		<tr><td align="right">Место проведения: </td><td><input type="Text" name="mesto" value="'.$mesto.'"></td></tr>
		<tr><td align="right">Принимали участие: </td><td><textarea name="members">'.$members.'</textarea></td></tr>
		<tr><td align="right" valign="top">Содержание: </td><td><textarea name="text" rows="7" cols="30">'.$text.'</textarea></td></tr>
		<tr><td>Вы можете добавить фотографии:</td><td></td></tr>';
		print "<tr><td colspan=2 id='td1'>
		<table class=text cellpadding=0 cellspacing=0 id='table1' style='display: none;'>
		<tr><td colspan=2><br></td></tr>
		<tr><td align=right>Комментарий: </td><td><input type=text name=comment1></td></tr>
		<tr><td align=right>Автор: </td><td><input type=text name=author1></td></tr>
		<tr><td align=right>Путь к файлу: </td><td><input type='File' name='file1'></td></tr>
		</table>
		<table class=text cellpadding=0 cellspacing=0 id='table2' style='display: none;'>
		<tr><td colspan=2><br></td></tr>
		<tr><td align=right>Комментарий: </td><td><input type=text name=comment2></td></tr>
		<tr><td align=right>Автор: </td><td><input type=text name=author2></td></tr>
		<tr><td align=right>Путь к файлу: </td><td><input type='File' name='file2'></td></tr>
		</table>
		<table class=text cellpadding=0 cellspacing=0 id='table3' style='display: none;'>
		<tr><td colspan=2><br></td></tr>
		<tr><td align=right>Комментарий: </td><td><input type=text name=comment3></td></tr>
		<tr><td align=right>Автор: </td><td><input type=text name=author3></td></tr>
		<tr><td align=right>Путь к файлу: </td><td><input type='File' name='file3'></td></tr>
		</table>
		<table class=text cellpadding=0 cellspacing=0 id='table4' style='display: none;'>
		<tr><td colspan=2><br></td></tr>
		<tr><td align=right>Комментарий: </td><td><input type=text name=comment4></td></tr>
		<tr><td align=right>Автор: </td><td><input type=text name=author4></td></tr>
		<tr><td align=right>Путь к файлу: </td><td><input type='File' name='file4'></td></tr>
		</table>
		<table class=text cellpadding=0 cellspacing=0 id='table5' style='display: none;'>
		<tr><td colspan=2><br></td></tr>
		<tr><td align=right>Комментарий: </td><td><input type=text name=comment5></td></tr>
		<tr><td align=right>Автор: </td><td><input type=text name=author5></td></tr>
		<tr><td align=right>Путь к файлу: </td><td><input type='File' name='file5'></td></tr>
		</table>
		</td></tr>
		<tr><td colspan=2 align=right><input type=Button name='more' value='Добавить фотографии' onclick=\"javascript: 
		document.getElementById('table'+i).style.display = 'block';
		addobser.photos.value = i;
		this.value = 'Ещё фотография...';
		i++;
		if(i>5) {addobser.more.disabled = true; alert('Если вы хотите добавить ещё фотографии, вы можете добавить их непосредственно в фотогалерею в раздел \''+addobser.name.value+'\' в группе \'Наблюдения\'.');}
		\"></td></tr>
		";
		print "<tr><td colspan=2>&nbsp;</td></tr>
		<tr><td align=right><input type=reset value='Очистить'></td><td><input type=submit name='addobser_sub' value='Готово'></td></tr>
		</table></form>";
	}
}

////// functions end //

if(isset($addnew_sub)) {
	$result = 1;
	if(strlen($polno)<20) {$result = 0; $why = "Новость слишком короткая.";} else $polno = substr($polno, 0, 1048576);
	if(strlen($kratko)<10) {$result = 0; $why .= "<br>Краткое описание новости слишком маленькое.";} else $kratko = substr($kratko, 0, 1024);
	if(strlen($zagolovok)<10) {$result = 0; $why .= "<br>Заголовок слишком короткий.";} else $zagolovok = substr($zagolovok, 0, 512);
	$q = mysql_query("select id from news where title = '".$zagolovok."' and new_short = '".$kratko."' and new_full = '".$polno."'");
	if(mysql_num_rows($q)>0) {$result = 0; $why .= "Точно такая же новость уже содержится в базе данных.";}
	if($result!=0) @mysql_query("insert into news(new_full, new_short, title, author, date) values('".addslashes($polno)."', '".addslashes($kratko)."', '".addslashes($zagolovok)."', '".$uid."', '".time()."')") or $result = 0;
}
elseif(isset($delnew_sub)) {
	$result = 1;
	$q = mysql_query("select id from news where 1");
	while($r = mysql_fetch_assoc($q)) {
		$p = "delnew_sub".$r[id];
		if(isset($$p)) {$nidd = $r[id]; break;}
	}
	@mysql_query("delete from news where id = ".$nidd) or $result = 0;
}
elseif(isset($editnew_sub)) {
	$result = 1;
	$q = mysql_query("select id from news where 1");
	while($r = mysql_fetch_assoc($q)) {
		$p = "editnew_sub".$r[id];
		if(isset($$p)) {$nidd = $r[id]; break;}
	}
	$title2 = "zagolovok".$nidd;
	$kratko2 = "kratko".$nidd;
	$polno2 = "polno".$nidd;
	@mysql_query("update news set title = '".addslashes($$title2)."', new_short = '".addslashes($$kratko2)."', new_full = '".addslashes($$polno2)."' where id = ".$nidd) or $result = 0;
}
elseif(isset($changemydetails_sub)) {
	$result = 1;
	$qres = true;
	if($pass1!="" || $pass2!="") {
		if($pass1!=$pass2) {$result = 2; $why = "Введённые пароли не совпадают.";} else $result = 3;
	}
	if($result == 1) $qres = @mysql_query("update users set login='".$login."', surname='".$surname."', email='".$email."', name='".$name."', birthdate='".$birthdate."', city='".$city."', icq='".$icq."', webpage='".$webpage."', tel='".$tel."', other='".$other."', rod='".$rod."' where id = ".$uid);
	elseif($result == 3) $qres = @mysql_query("update users set login='".$login."', pass='".$pass1."', surname='".$surname."', email='".$email."', name='".$name."', birthdate='".$birthdate."', city='".$city."', icq='".$icq."', webpage='".$webpage."', tel='".$tel."', other='".$other."', rod='".$rod."' where id = ".$uid);
	if(!$qres) {$result = 0; $why = mysql_error();}
}
elseif(isset($addmember_sub)) {
	$result = 1;
	$q = mysql_query("select id from users where surname = '".$surname."' and name = '".$name."'");
	if(mysql_num_rows($q)>0) {$result = 0; $why = "Этот человек уже является членом клуба.";}
	$pravo = "";
	if($canaddnew==1) $pravo.="a";
	if($canchangedetails==1) $pravo.="b";
	if($canaddmember==1) $pravo.="e";
	if($result!=0) @mysql_query("insert into users(login, pass, email, name, surname, birthdate, regdate, city, icq, webpage, pravo, tel, other, rod) values('".$login."', '".$pass."', '".$email."', '".$name."', '".$surname."', '".$birthdate."', '".time()."', '".$city."', '".$icq."', '".$webpage."', '".$pravo."', '".$tel."', '".$other."', '".$rod."')") or $result = 0;
}
elseif(isset($deleteuser_sub)) {
	$result = 1;
	$q = mysql_query("select id from users where 1");
	$n = mysql_num_rows($q);
	for($i=1; $i<=$n; $i++) {
		$idd = mysql_result($q, $i-1, 'id');
		$u = "user".$idd;
		if(isset($$u)) @mysql_query("delete from users where id = ".$idd) or $result = 0;
	}
}
elseif(isset($setpravo_sub)) {
	$result = 1;
	$pravo = "";
	if($canaddnew==1) $pravo.="a";
	if($caneditnew==1) $pravo.="f";
	if($candelnew==1) $pravo.="g";
	
	if($canchangedetails==1) $pravo.="b";
	if($canaddmyphoto==1) $pravo.="i";
	if($canchangesettings==1) $pravo.="h";
	
	if($canaddphoto==1) $pravo.="j";
	if($canaddkat==1) $pravo.="k";
	if($candelkat==1) $pravo.="l";
	
	if($canaddmember==1) $pravo.="em";
	if($candelmember==1) $pravo.="c";
	if($cansetpravo==1) $pravo.="d";
	
	if($canaddsobr==1) $pravo.="n";
	if($canaddobser==1) $pravo.="o";
	@mysql_query("update users set pravo = '".$pravo."' where id = ".$users) or $result = 0;
}
elseif(isset($changesettings_sub)) {
	$result = 1;
	@mysql_query("delete from config where 1");
	@mysql_query("insert into config values('about_text', '".addslashes(strip_tags($about_text, "<b><i><a><p><br><img><h1><h2><h3><h4><h5><div><em><table><tr><td>"))."')") or $result = 0;
	@mysql_query("insert into config values('news_per_page', '".$news_per_page."')") or $result = 0;
	@mysql_query("insert into config values('index_text', '".addslashes($index_text)."')") or $result = 0;
	@mysql_query("insert into config values('sobr_per_page', '".$sobr_per_page."')") or $result = 0;
	@mysql_query("insert into config values('obser_per_page', '".$obser_per_page."')") or $result = 0;
}
elseif(isset($myphoto_sub)) {
	$result = 1;
	$ext0 = pathinfo($_FILES['file']['name']);
	$ext = $ext0['extension'];
	$ext = strtolower($ext);
	if(empty($_FILES['file']['name'])) {$result = 0; $why = "Вы не ввели путь к файлу.";}
	elseif($ext!="gif" && $ext!="png" && $ext!="jpg" && $ext!="jpeg") {$result = 0; $why = "Допустимые расширения фотографии - jpeg, gif, png";}
	elseif(!is_file($_FILES['file']['tmp_name'])) {$result = 0; $why = "Файл не существует.";}
	else {
		$fname = "user".$uid.".".$ext;
		if(file_exists("photos/small/user".$uid.".jpg")) unlink("photos/small/user".$uid.".jpg");
		elseif(file_exists("photos/small/user".$uid.".jpeg")) unlink("photos/small/user".$uid.".jpeg");
		elseif(file_exists("photos/small/user".$uid.".gif")) unlink("photos/small/user".$uid.".gif");
		elseif(file_exists("photos/small/user".$uid.".png")) unlink("photos/small/user".$uid.".png");
		if (!move_uploaded_file($_FILES['file']['tmp_name'], "photos/".$fname)) {$result = 0; $why = "Возникла ошибка при копировании файла.";}
		else {
			$sizes = getimagesize("photos/".$fname);
			if($sizes[0]>=$sizes[1]) {
				$nw = 200; $nh = 150;
				if($sizes[0]>$nw) {$w = $nw; $h = round($sizes[1]/($sizes[0]/$nw));}
				else {$w = $sizes[0]; $h = $sizes[1];}
				if($h>$nh) {$h = $nh; $w = round($w/($h/$nh));}
			}
			else {
				$nw = 150; $nh = 200;
				if($sizes[1]>$nh) {$h = $nh; $w = round($sizes[0]/($sizes[1]/$nh));}
				else {$h = $sizes[1]; $w = $sizes[0];}
				if($w>$nw) {$w = $nw; $h = round($h/($w/$nw));}
			}
			##### smalling
			if($ext == "jpg" or $ext == "jpeg") $im = imagecreatefromjpeg("photos/$fname");
			if($ext == "png") $im = imagecreatefrompng("photos/$fname");
			if($ext == "gif") $im = imagecreatefromgif("photos/$fname");
			$im2 = imagecreatetruecolor($w, $h);
			imagecopyresampled($im2, $im, 0, 0, 0, 0, $w, $h, imagesx($im), imagesy($im));
			imagedestroy($im);
			if($ext == "jpg" or $ext == "jpeg") imagejpeg($im2, "photos/small/".$fname);
			if($ext == "png") imagepng($im2, "photos/small/".$fname);
			if($ext == "gif") imagegif($im2, "photos/small/".$fname);
			imagedestroy($im2);
			#####
			unlink("photos/".$fname);
		}
	}
}
elseif(isset($addphoto_sub)) {
	$result = 1;
	$ext0 = pathinfo($_FILES['file']['name']);
	$ext = $ext0['extension'];
	$ext = strtolower($ext);
	if(empty($author)) {$result = 0; $why = "Вы не ввели автора.";}
	elseif(empty($comment)) {$result = 0; $why = "Вы не ввели комментарий.";}
	elseif(empty($_FILES['file']['name'])) {$result = 0; $why = "Вы не ввели путь к файлу.";}
	elseif($ext!="gif" && $ext!="png" && $ext!="jpg" && $ext!="jpeg") {$result = 0; $why = "Допустимые расширения фотографии - jpeg, gif, png";}
	elseif(!is_file($_FILES['file']['tmp_name'])) {$result = 0; $why = "Файл не существует.";}
	else {
		$sql = mysql_query ("select id from gal where 1 order by id desc limit 1");
		$row = mysql_fetch_array($sql);
		$idp = $row[id]+1;
		$fname = $idp.".".$ext;
		if (!move_uploaded_file($_FILES['file']['tmp_name'], "photos/".$fname)) {$result = 0; $why = "Возникла ошибка при копировании файла.";}
		else {
			$sizes = getimagesize("photos/".$fname);
			if($sizes[0]>=$sizes[1]) {
				$nw = 170; $nh = 128;
				if($sizes[0]>$nw) {$w = $nw; $h = round($sizes[1]/($sizes[0]/$nw));}
				else {$w = $sizes[0]; $h = $sizes[1];}
				if($h>$nh) {$h = $nh; $w = round($w/($h/$nh));}
			}
			else {
				$nw = 128; $nh = 170;
				if($sizes[1]>$nh) {$h = $nh; $w = round($sizes[0]/($sizes[1]/$nh));}
				else {$h = $sizes[1]; $w = $sizes[0];}
				if($w>$nw) {$w = $nw; $h = round($h/($w/$nw));}
			}
			##### smalling
			if($ext == "jpg" or $ext == "jpeg") $im = imagecreatefromjpeg("photos/$fname");
			if($ext == "png") $im = imagecreatefrompng("photos/$fname");
			if($ext == "gif") $im = imagecreatefromgif("photos/$fname");
			$im2 = imagecreatetruecolor($w, $h);
			imagecopyresampled($im2, $im, 0, 0, 0, 0, $w, $h, imagesx($im), imagesy($im));
			imagedestroy($im);
			if($ext == "jpg" or $ext == "jpeg") imagejpeg($im2, "photos/small/".$fname);
			if($ext == "png") imagepng($im2, "photos/small/".$fname);
			if($ext == "gif") imagegif($im2, "photos/small/".$fname);
			imagedestroy($im2);
			#####
			// learning object id
			if($mid == "" && $ngcid == "") $objid = "";
			elseif($ngcid != "" && $ngcid != " " && $ngcid != "-") $objid = @mysql_result(mysql_query("select id from objects where ngc = '".$ngcid."'"), 0, 'id') or $objid = "";
			elseif($mid != "" && $mid != " " && $mid != "-") $objid = @mysql_result(mysql_query("select id from objects where messier = '".$mid."'"), 0, 'id') or $objid = "";
			//
			$sql = mysql_query ("insert into gal (kid, photo, author, url, objid) values ('$kid', '$comment', '$author', '$fname', '$objid');");
		}
	}
}
elseif(isset($addkat_sub)) {
	$result = 1;
	if(!isset($ins)) $ins = "";
	@mysql_query("insert into gal_kats (kat, ins) values('".$name."', '".$ins."')") or $result = 0;
}
elseif(isset($delkat_sub)) {
	$result = 1;
	if($doing = "del") {
		$q1 = @mysql_query("select url from gal where kid = ".$name);
		while($row = @mysql_fetch_assoc($q1)) {
			@unlink("photos/".$row['url']);
			@unlink("photos/small/".$row['url']);
		}
		$q2 = @mysql_query("delete from gal where kid = ".$name);
	}
	else {
		$q1 = @mysql_query("update gal set kid = '".$drraz."' where kid = ".$name);
	}
	$qq = mysql_query("delete from gal_kats where id = ".$name);
}
elseif(isset($confmember_add_sub)) {
	$result = 1;
	$q = mysql_query("select id from users where surname = '".$surname."' and name = '".$name."'");
	if(mysql_num_rows($q)>0) {$result = 0; $why = "Этот человек уже является членом клуба.";}
	$pravo = "";
	if($canaddnew==1) $pravo.="a";
	if($caneditnew==1) $pravo.="f";
	if($candelnew==1) $pravo.="g";
	
	if($canchangedetails==1) $pravo.="b";
	if($canaddmyphoto==1) $pravo.="i";
	if($canchangesettings==1) $pravo.="h";
	
	if($canaddphoto==1) $pravo.="j";
	if($canaddkat==1) $pravo.="k";
	if($candelkat==1) $pravo.="l";
	
	if($canaddmember==1) $pravo.="em";
	if($candelmember==1) $pravo.="c";
	if($cansetpravo==1) $pravo.="d";
	
	if($canaddsobr==1) $pravo.="n";
	if($canaddobser==1) $pravo.="o";
	if($result!=0) @mysql_query("insert into users(login, pass, email, name, surname, birthdate, regdate, city, icq, webpage, pravo, tel, other, rod) values('".$login."', '".$pass."', '".$email."', '".$name."', '".$surname."', '".$birthdate."', '".time()."', '".$city."', '".$icq."', '".$webpage."', '".$pravo."', '".$tel."', '".$other."', '".$rod."')") or $result = 0;
	if($result!=0) @mysql_query("delete from zayavki where id = ".$zid) or $result = 0;
}
elseif(isset($confmember_sub) && $act == "confmember_del_done") {
	$result = 1;
	@mysql_query("delete from zayavki where id = ".$zid) or $result = 0;
}
elseif(isset($addsobr_sub)) {
	$result = 1;
	if($name == "") {$result = 0; $why = "Вы не ввели заголовок.";}
	elseif($date == "") {$result = 0; $why = "Вы не ввели дату.";}
	elseif($time == "") {$result = 0; $why = "Вы не ввели время.";}
	elseif($mesto == "") {$result = 0; $why = "Вы не ввели место.";}
	elseif($members == "") {$result = 0; $why = "Вы не написали, кто принимал участие.";}
	elseif($text == "") {$result = 0; $why = "Вы не ввели содержание.";}
	else {
		if($photos!="" && $photos!=0) {
			mysql_query("insert into gal_kats (kat, ins) values('".$name."', 'sobr')");
			$qid = mysql_query("select id from gal_kats where 1 order by id desc limit 1");
			$kid = mysql_result($qid, 0, 'id');
			for($i=1;$i<=$photos;$i++) {
				if($result == 1) {
					$ext0 = pathinfo($_FILES['file'.$i]['name']);
					$ext = $ext0['extension'];
					$ext = strtolower($ext);
					$author = "author".$i;
					$comment = "comment".$i;
					if(empty($$author)) {$result = 0; $why = "Вы не ввели автора для ".$i." фотографии.";}
					elseif(empty($$comment)) {$result = 0; $why = "Вы не ввели комментарий для ".$i." фотографии.";}
					elseif(empty($_FILES['file'.$i]['name'])) {$result = 0; $why = "Вы не ввели путь к ".$i." файлу.";}
					elseif($ext!="gif" && $ext!="png" && $ext!="jpg" && $ext!="jpeg") {$result = 0; $why = "Допустимые расширения фотографии - jpeg, gif, png (".$i." фотография).";}
					elseif(!is_file($_FILES['file'.$i]['tmp_name'])) {$result = 0; $why = "Файл ".$i." не существует.";}
					else {
						$sql = mysql_query ("select id from gal where 1 order by id desc limit 1");
						$row = mysql_fetch_array($sql);
						$idp = $row[id]+1;
						$fname = $idp.".".$ext;
						if (!move_uploaded_file($_FILES['file'.$i]['tmp_name'], "photos/".$fname)) {$result = 0; $why = "Возникла ошибка при копировании ".$i." файла.";}
						else {
							$sizes = getimagesize("photos/".$fname);
							if($sizes[0]>=$sizes[1]) {
								$nw = 170; $nh = 128;
								if($sizes[0]>$nw) {$w = $nw; $h = round($sizes[1]/($sizes[0]/$nw));}
								else {$w = $sizes[0]; $h = $sizes[1];}
								if($h>$nh) {$h = $nh; $w = round($w/($h/$nh));}
							}
							else {
								$nw = 128; $nh = 170;
								if($sizes[1]>$nh) {$h = $nh; $w = round($sizes[0]/($sizes[1]/$nh));}
								else {$h = $sizes[1]; $w = $sizes[0];}
								if($w>$nw) {$w = $nw; $h = round($h/($w/$nw));}
							}
							##### smalling
							if($ext == "jpg" or $ext == "jpeg") $im = imagecreatefromjpeg("photos/$fname");
							if($ext == "png") $im = imagecreatefrompng("photos/$fname");
							if($ext == "gif") $im = imagecreatefromgif("photos/$fname");
							$im2 = imagecreatetruecolor($w, $h);
							imagecopyresampled($im2, $im, 0, 0, 0, 0, $w, $h, imagesx($im), imagesy($im));
							imagedestroy($im);
							if($ext == "jpg" or $ext == "jpeg") imagejpeg($im2, "photos/small/".$fname);
							if($ext == "png") imagepng($im2, "photos/small/".$fname);
							if($ext == "gif") imagegif($im2, "photos/small/".$fname);
							imagedestroy($im2);
							#####
							$objid = "";
							$sql = mysql_query ("insert into gal (kid, photo, author, url, objid) values ('$kid', '".$$comment."', '".$$author."', '".$fname."', '".$objid."');");
						}
					}
				}
			}
		}
		else $kid = "";
		$h = substr($time, 0, 2);
		$m = substr($time, 2, 2);
		$d = substr($date, 0, 2);
		$mon = substr($date, 2, 2);
		$y = substr($date, 4, 4);
		$date2 = mktime($h, $m, 0, $mon, $d, $y);
		if($result == 1) @mysql_query("insert into sobr (name, date, mesto, members, text, gal_kat) values('$name', '$date2', '$mesto', '$members', '".addslashes($text)."', '$kid')") or $result = 0;
	}
}
elseif(isset($addobser_sub)) {
	$result = 1;
	if($name == "") {$result = 0; $why = "Вы не ввели заголовок.";}
	elseif($date == "") {$result = 0; $why = "Вы не ввели дату.";}
	elseif($time == "") {$result = 0; $why = "Вы не ввели время.";}
	elseif($mesto == "") {$result = 0; $why = "Вы не ввели место.";}
	elseif($members == "") {$result = 0; $why = "Вы не написали, кто принимал участие.";}
	elseif($text == "") {$result = 0; $why = "Вы не ввели содержание.";}
	else {
		if($photos!="" && $photos!=0) {
			mysql_query("insert into gal_kats (kat, ins) values('".$name."', 'obser')");
			$qid = mysql_query("select id from gal_kats where 1 order by id desc limit 1");
			$kid = mysql_result($qid, 0, 'id');
			for($i=1;$i<=$photos;$i++) {
				if($result == 1) {
					$ext0 = pathinfo($_FILES['file'.$i]['name']);
					$ext = $ext0['extension'];
					$ext = strtolower($ext);
					$author = "author".$i;
					$comment = "comment".$i;
					if(empty($$author)) {$result = 0; $why = "Вы не ввели автора для ".$i." фотографии.";}
					elseif(empty($$comment)) {$result = 0; $why = "Вы не ввели комментарий для ".$i." фотографии.";}
					elseif(empty($_FILES['file'.$i]['name'])) {$result = 0; $why = "Вы не ввели путь к ".$i." файлу.";}
					elseif($ext!="gif" && $ext!="png" && $ext!="jpg" && $ext!="jpeg") {$result = 0; $why = "Допустимые расширения фотографии - jpeg, gif, png (".$i." фотография).";}
					elseif(!is_file($_FILES['file'.$i]['tmp_name'])) {$result = 0; $why = "Файл ".$i." не существует.";}
					else {
						$sql = mysql_query ("select id from gal where 1 order by id desc limit 1");
						$row = mysql_fetch_array($sql);
						$idp = $row[id]+1;
						$fname = $idp.".".$ext;
						if (!move_uploaded_file($_FILES['file'.$i]['tmp_name'], "photos/".$fname)) {$result = 0; $why = "Возникла ошибка при копировании ".$i." файла.";}
						else {
							$sizes = getimagesize("photos/".$fname);
							if($sizes[0]>=$sizes[1]) {
								$nw = 170; $nh = 128;
								if($sizes[0]>$nw) {$w = $nw; $h = round($sizes[1]/($sizes[0]/$nw));}
								else {$w = $sizes[0]; $h = $sizes[1];}
								if($h>$nh) {$h = $nh; $w = round($w/($h/$nh));}
							}
							else {
								$nw = 128; $nh = 170;
								if($sizes[1]>$nh) {$h = $nh; $w = round($sizes[0]/($sizes[1]/$nh));}
								else {$h = $sizes[1]; $w = $sizes[0];}
								if($w>$nw) {$w = $nw; $h = round($h/($w/$nw));}
							}
							##### smalling
							if($ext == "jpg" or $ext == "jpeg") $im = imagecreatefromjpeg("photos/$fname");
							if($ext == "png") $im = imagecreatefrompng("photos/$fname");
							if($ext == "gif") $im = imagecreatefromgif("photos/$fname");
							$im2 = imagecreatetruecolor($w, $h);
							imagecopyresampled($im2, $im, 0, 0, 0, 0, $w, $h, imagesx($im), imagesy($im));
							imagedestroy($im);
							if($ext == "jpg" or $ext == "jpeg") imagejpeg($im2, "photos/small/".$fname);
							if($ext == "png") imagepng($im2, "photos/small/".$fname);
							if($ext == "gif") imagegif($im2, "photos/small/".$fname);
							imagedestroy($im2);
							#####
							$objid = "";
							$sql = mysql_query ("insert into gal (kid, photo, author, url, objid) values ('$kid', '".$$comment."', '".$$author."', '".$fname."', '".$objid."');");
						}
					}
				}
			}
		}
		else $kid = "";
		$h = substr($time, 0, 2);
		$m = substr($time, 2, 2);
		$d = substr($date, 0, 2);
		$mon = substr($date, 2, 2);
		$y = substr($date, 4, 4);
		$date2 = mktime($h, $m, 0, $mon, $d, $y);
		if($result == 1) @mysql_query("insert into obser (name, date, mesto, members, text, gal_kat) values('$name', '$date2', '$mesto', '$members', '".addslashes($text)."', '$kid')") or $result = 0;
	}
}

if($error!="") $heading = "Ошибка!";
else {
	switch($act) {
		case "addnew": $heading = "Добавить новость"; break;
		case "addnew_done": if($result == 1) $heading = "Новость добавлена"; else $heading = "Ошибка!"; break;
		case "delnew": $heading = "Удалить новость"; break;
		case "delnew_done": if($result == 1) $heading = "Новость удалена"; else $heading = "Ошибка!"; break;
		case "editnew": $heading = "Редактировать новость"; break;
		case "editnew_done": if($result == 1) $heading = "Новость отредактирована"; else $heading = "Ошибка!"; break;
		case "changemydetails": $heading = "Ваши данные"; break;
		case "changemydetails_done": if($result == 1 or $result == 3) $heading = "Информация обновлена"; else $heading = "Ошибка!"; break;
		case "myphoto": $heading = "Закачать фотографию"; break;
		case "myphoto_done": if($result == 1) $heading = "Фотография закачана"; else $heading = "Ошибка!"; break;
		case "changesettings": $heading = "Настройки сайта"; break;
		case "changesettings_done": if($result == 1) $heading = "Информация обновлена"; else $heading = "Ошибка!"; break;
		case "deleteuser": $heading = "Удаление члена астроклуба"; break;
		case "deleteuser_done": if($result == 1) $heading = "Удалён(ы)..."; else $heading = "Ошибка!"; break;
		case "setpravo": $heading = "Назначить права"; break;
		case "setpravo_done": if($result == 1) $heading = "Права назначены"; else $heading = "Ошибка!"; break;
		case "addmember": $heading = "Добавить члена клуба"; break;
		case "addmember_done": if($result == 1) $heading = "Человек добавлен"; else $heading = "Ошибка!"; break;
		case "confmember": $heading = "Текущие заявки"; break;
		case "confmember_done": if($result == 1) $heading = "Человек добавлен"; else $heading = "Ошибка!"; break;
		case "confmember_del_done": if($result == 1) $heading = "Заявка удалена"; else $heading = "Ошибка!"; break;
		case "confmember_info": $heading = "Просмотр заявки"; break;
		case "confmember_add": $heading = "Добавить члена клуба"; break;
		case "addphoto": $heading = "Добавить фотографию в фотогалерею"; break;
		case "addphoto_done": if($result == 1) $heading = "Фотография добавлена"; else $heading = "Ошибка!"; break;
		case "addkat": $heading = "Добавить раздел фотогалереи"; break;
		case "addkat_done": if($result == 1) $heading = "Раздел добавлен"; else $heading = "Ошибка!"; break;
		case "delkat": $heading = "Удалить раздел фотогалереи"; break;
		case "delkat_done": if($result == 1) $heading = "Раздел удалён"; else $heading = "Ошибка!"; break;
		case "addsobr": $heading = "Добавить информацию о собрании"; break;
		case "addsobr_done": if($result == 1) $heading = "Собрание добавлено"; else $heading = "Ошибка!"; break;
		case "addobser": $heading = "Добавить информацию о наблюдении"; break;
		case "addobser_done": if($result == 1) $heading = "Наблюдение добавлено"; else $heading = "Ошибка!"; break;
	}
}
include_once("inc/head.php");
?>
<TABLE WIDTH=500 BORDER=0 CELLPADDING=0 CELLSPACING=0 align="center">
	<tr><td colspan=2><IMG SRC="images/sp1.jpg" WIDTH=580 HEIGHT=76 ALT=""></td></tr>
	<tr>
	<td valign="top" width="482"><div class="texthead"><?=$heading?></div></td>
	<td WIDTH=98 valign="top"><IMG SRC="images/sp2.jpg" WIDTH=98 HEIGHT=60 ALT=""></td>
	</tr>
	<tr><td colspan=2><IMG SRC="images/sp3.jpg" WIDTH=580 HEIGHT=24></td></tr>
	<tr><td colspan=2><div class="text">
<?php
if($error!="") print $error;
else {
	switch($act) {
		case "addnew":
			addnew_form($uid, '', '', '');
		break;
		case "addnew_done":
			if($result!=1) print $why; else menu($uid);
		break;
		case "delnew":
			if(!isset($page)) $page = 1;
			delnew_form($uid, $page);
		break;
		case "delnew_done":
			if($result!=1) print $why; else menu($uid);
		break;
		case "editnew":
			if(!isset($page)) $page = 1;
			editnew_form($uid, $page);
		break;
		case "editnew_done":
			if($result!=1) print $why; else menu($uid);
		break;
		case "changemydetails":
			changemydetails_form($uid);
		break;
		case "changemydetails_done":
			if($result == 2) {print $why; changemydetails_form($uid);}
			elseif($result == 0 || $result == 2) print $why; else menu($uid);
		break;
		case "myphoto":
			myphoto_form($uid);
		break;
		case "myphoto_done":
			if($result!=1) {print $why; myphoto_form($uid);} else menu($uid);
		break;
		case "changesettings":
			changesettings_form($uid);
		break;
		case "changesettings_done":
			if($result!=1) print $why; else menu($uid);
		break;
		case "deleteuser":
			deleteuser_form($uid);
		break;
		case "deleteuser_done":
			if($result!=1) print $why; else menu($uid);
		break;
		case "setpravo":
			setpravo_form($uid);
		break;
		case "setpravo_done":
			if($result!=1) print $why; else menu($uid);
		break;
		case "addmember":
			addmember_form($uid);
		break;
		case "addmember_done":
			if($result!=1) print $why; else menu($uid);
		break;
		case "confmember":
			confmember_form($uid);
		break;
		case "confmember_done":
			if($result!=1) print $why; else menu($uid);
		break;
		case "confmember_del_done":
			if($result!=1) print $why; else menu($uid);
		break;
		case "confmember_info":
			confmember_info_form($zid, $uid);
		break;
		case "confmember_add":
			confmember_add_form($zid, $uid);
		break;
		case "addphoto":
			addphoto_form($uid);
		break;
		case "addphoto_done":
			if($result!=1) print $why; else menu($uid);
		break;
		case "addkat":
			addkat_form($uid);
		break;
		case "addkat_done":
			if($result!=1) print $why; else menu($uid);
		break;
		case "delkat":
			delkat_form($uid);
		break;
		case "delkat_done":
			if($result!=1) print $why; else menu($uid);
		break;
		case "addsobr":
			addsobr_form($uid, $name, $date, $time, $mesto, $members, $text);
		break;
		case "addsobr_done":
			if($result!=1) {print $why."<br><br>"; addsobr_form($uid, $name, $date, $time, $mesto, $members, $text);} else menu($uid);
		break;
		case "addobser":
			addobser_form($uid, $name, $date, $time, $mesto, $members, $text);
		break;
		case "addobser_done":
			if($result!=1) {print $why."<br><br>"; addobser_form($uid, $name, $date, $time, $mesto, $members, $text);} else menu($uid);
		break;
	}
}
?>
	</div></td></tr>
	<tr><td colspan=2><IMG SRC="images/sp5.jpg" WIDTH=580 HEIGHT=9></td></tr>											
</table>				
<?php
include_once("inc/foot.php");
?>