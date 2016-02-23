<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "password";
$main_email = "sokrat1988@mail.ru";

$mysql = @mysql_connect($dbhost, $dbuser, $dbpass) or ferror(0);
@mysql_select_db("astroclub") or ferror(1);

return $mysql;
?>
