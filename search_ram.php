<?php
$nosearch = array();
#################################################################################################
#	Скрипт : Rambex.SiteS версия 1.1											#
#	Автор : Роман Чириков (sokrat1988@mail.ru)										#
# (с) Роман Чириков, 2003 г.	http://www.rambex.h10.ru									#
#															#
# Вы имеете право вносить в скрипт любые изменения и распространять его при условии что первые 10 строк не удалены.		#
# Если у Вас есть вопросы или предложения, смело обращайтесь к автору.							#
#															#
#################################################################################################
#  Скрипт выводит на экран все строки файлов данной папки, содержащие							#
# введённое слово.													#
#															#
#	Установка:													#
# 1. Распакуйте архив. Поместите этот файл в папку, где должен производиться поиск.						#
# 2. Сделайте необходимые настройки (смотрите ниже).									#
# 3. Запускайте и радуйтесь жизни!												#
# 4. Следите за обновлениями на сайте www.rambex.h10.ru 									#
#															#
# А теперь к настройкам :													#
$yourname = "Rambex.h10"; # Название Вашего сайта (можно оставить пустым).							#
$len = 3; # Минимальная длина слова для поиска (число от 0 до 20).								#
$slovo = "Искать"; # Надпись на кнопке начала поиска.									#
$header = "head.php"; # Шапка страницы (например : "header.html"). Можно оставить пустым.						#
$footer = ""; # Концовка страницы (например : "footer.html"). Можно оставить пустым.						#
$color = "#355AC8"; # Значение цвета, которым будут выделены в результатах слова, введённые для поиска.				#
$ncolor = "red"; # Значение цвета, которым будет выделено количество результатов.						#
# А теперь Вы можете указать файлы, которые скрипт затрагивать не должен. Их может быть сколько угодно.			#
# Просто добавляйте новые строки вида: "$nosearch[] = "строка";", где строка - имя или расширение файла.				#
# Например, Вы не хотите, чтобы поиск производился в файле admin.php. В таком случае, добавьте строку : $nosearch[] = "admin"; .	#
# Ниже уже есть три строки, которые блокируют файлы с расширениями .gif, .jpg, .bmp.						#
$nosearch[] = ".gif";													#
$nosearch[] = ".jpg";													#
$nosearch[] = ".bmp";													#
# Конец настройки. Хватит. Теперь за работу!										#
#################################################################################################
$base = "./";
@include ("$header");
print "<br><br><blockquote><html><body><font face=Verdana>
<form action=search.php method=post>
<input type=text name='word' value='$word'>
<input type=submit name=go value=$slovo>
</form>";
if(isset($go)) {
$s = strlen($word);
if($s < $len) {
	if (substr($len, 0, 1) == 1) { $e = "-го символа"; };
    if (substr($len, 0, 1) > 1 && substr($len, 0, 1) < 5) { $e = "-х символов"; };
    if (substr($len, 0, 1) > 4) { $e = "-и символов";};
	if($s == 0) {$x = " ничего не ввели.";}
	if($s > 0) {$x = " ввели только $s.";}
	print "Ключевое слово должно содержать <i>не меньше $len$e</i>. Вы$x<br>";
	exit;
}
reset($nosearch);
$files = array();
print "<ul>";
$bas = opendir($base);
$results = array();
while ($file = readdir($bas)) {
	if($file != "." && $file != ".." && is_file($file)) {
		foreach($nosearch as $no){
			if(!strstr(basename($file), $no)){
				$files[] = basename($file);
			}
		}
	}
}
$files = array_unique($files);
foreach ($files as $file) {
	$strings = file($file);
	foreach ($strings as $str) {
		$str = strip_tags($str,"<b><i>");
		if(eregi($word, $str)) {
			$length = strlen($str);
			$str33 = strtolower($str);
			$word33 = strtolower($word);
			$pos = strpos($str33, $word33);
			$str1 = substr($str, 0, $pos);
			$str2 = substr($str, $pos, $s);
			$str3 = substr($str, $pos+$s, $length);
			$str2 = "<font color=$color><b>$str2</b></font>";
			$re =  "<li><a href=$file>".$str1.$str2.$str3."</a><br><br>";
			$results[] = $re;
		}
	}
}
$n = count($results);
if ($n == 0) {
	print "<H3>Результаты поиска по сайту $yourname.<br><br>Ни одного совпадения не найдено.</h3>\n";
	exit;
}
else {
	$w = 0;
	if ($n > 9 && $n < 100) {$w = 1;}
	if ($n >99 && $n < 1000) {$w = 2;}
	if (substr($n, $w, 1) == 1) { $e = "е:"; };
	if ($n > 10 && $n < 20) { $e = "й:";}
	else {
		if (substr($n, $w, 1) > 1 && substr($n, $w, 1) < 5) { $e = "я:"; }
		if (substr($n, $w, 1) > 4 || substr($n, $w, 1) == 0) { $e = "й:";}
	}
}
print "
<h3>Результаты поиска по сайту $yourname.</h3><br>Всего найдено <font color=$ncolor><b>$n</b></font> совпадени".$e."<br><br>";

foreach($results as $r) {print "$r";}
print "</ul>";
}//isset
@include ("$footer");
?></font></blockquote>
</td></tr></table>
</body>
</html>