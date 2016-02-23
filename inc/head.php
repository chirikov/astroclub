<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE>Астроклуб г.Уфы</TITLE>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=windows-1251">
<meta http-equiv="Description" content="Сайт астроклуба города Уфы.">
<meta http-equiv="Keywords" content="Астроклуб, астрономия, клуб, хобби, телескоп, наблюдения, небо, звёзды, планеты">
<style type="text/css"><!--
.header {font-family:Tahoma, sans-serif; font-size: 12px; COLOR:#2FFFFF; padding-left:10; padding-right:5; font-weight:900 }
.text {font-family:Tahoma,sans-serif; font-size: 11px; color:#000000; padding-left:20; padding-right:10 }
.texthead {font-family:Tahoma,sans-serif; font-size: 15px; color:#22355c; padding-left:20; padding-right:10; font-weight : bold;}
.text2 {font-family:Tahoma,sans-serif; font-size: 11px; color:#000000; padding-left:20; padding-right:10; font-weight:100; }
.news {font-family:Arial, sans-serif; font-size: 9px; color:#ffffff; padding-left:10; padding-right:5; font-weight:900; }
a:link{text-decoration: none; color:#22355c}
a:visited{text-decoration: none; color: #22355c}
a:hover{text-decoration: underline; color: #22355c}
a:active{text-decoration: none; color: #22355c}
li {
list-style : url(images/pic.jpg);
}
--></style>
</HEAD>
<BODY BGCOLOR=#FFFFFF LEFTMARGIN=0 TOPMARGIN=0 MARGINWIDTH=0 MARGINHEIGHT=0 rightmargin="0">
<TABLE WIDTH=780 BORDER=0 CELLPADDING=0 CELLSPACING=0 align="center" height="100%">
	<TR>
		<td bgcolor=#000000 rowspan=100><img src="images/spacer.gif" with=1></td>
		<TD ROWSPAN=3 WIDTH=191 HEIGHT=73><a href="index.php"><IMG SRC="images/logo.gif" WIDTH=191 HEIGHT=73 ALT="Астроклуб города Уфы" border="0"></a></TD>
		<TD COLSPAN=12  WIDTH=589 HEIGHT=13><IMG SRC="images/2.jpg" WIDTH=589 HEIGHT=13></TD>
		<td bgcolor=#000000 rowspan=100><img src="images/spacer.gif" with=1></td>			
	</TR>
	<TR>
		<TD COLSPAN=2 ROWSPAN=2 WIDTH=25 HEIGHT=60><IMG SRC="images/3.jpg" WIDTH=25 HEIGHT=60></TD>
		<TD background="images/4.jpg" WIDTH=100 HEIGHT=24>
		<div class="text" style="font-family:Verdana; padding-right:0"><a href="sobr.php" style="color:000000">Собрания</a></div>
		</TD>
		<TD COLSPAN=3 background="images/5.jpg" WIDTH=107 HEIGHT=24>
		<div class="text" style="font-family:Verdana; padding-right:0"><a href="obser.php" style="color:000000">Наблюдения</a></div>
		</TD>
		<TD background="images/6.jpg" WIDTH=107 HEIGHT=24>
		<div class="text" style="font-family:Verdana; padding-right:0; padding-left:30"><a href="members.php" style="color:000000">Члены клуба</a></div>
		</TD>
		<TD COLSPAN=2 WIDTH=54 HEIGHT=24><IMG SRC="images/7.jpg" WIDTH=54 HEIGHT=24></TD>
		<TD COLSPAN=3 background="images/8.jpg" WIDTH=196 HEIGHT=24>
		<div class="text" style="font-family:Verdana; padding-right:0; padding-left:30"><a href=login.php style='color:000000'><strong>Панель управления</strong></a></div>
		</TD>
	</TR>
	<TR>
		<td colspan="10" background="images/9.jpg">
		<table align="center" cellpadding="0" cellspacing="0"><tr>
		<TD background="images/9.jpg" HEIGHT=36><Div class="text" style="padding:5" align="right"><strong>Поиск по сайту:</strong></DIV></TD>
		<TD background="images/10.jpg" WIDTH=130 HEIGHT=36><form action="search.php"><input type="text" name="text" style="width:120"></TD>
		<TD WIDTH=80 HEIGHT=36><input type="Image" SRC="images/search.gif" WIDTH=80 HEIGHT=36 ALT="Поиск" border="0"></TD></form>
		</tr></table>
		</td>
	</TR>
	<TR>
		<TD COLSPAN=2 valign="top" height="100%" background="images/lbg.jpg">
		<!-- left text-->
		<TABLE WIDTH=200 BORDER=0 CELLPADDING=0 CELLSPACING=0 align="center">
		<tr><td colspan=2><IMG SRC="images/l1.jpg" WIDTH=200 HEIGHT=23 ALT=""></td></tr>
		<tr><td colspan=2 background="images/l2.jpg" WIDTH=200 HEIGHT=25>
		<div class="text"><strong><a href="about_club.php" style="color:22355C">О клубе</a></strong></div>
		</td></tr>
		<tr><td colspan=2 background="images/l2.jpg" WIDTH=200 HEIGHT=25>
		<div class="text"><strong><a href="zayavka.php" style="color:22355C">Я хочу вступить</a></strong></div>
		</td></tr>
		<tr><td colspan=2 background="images/l2.jpg" WIDTH=200 HEIGHT=25>
		<div class="text"><strong><a href="calendar_main.php?opt=city&city=103" style="color:22355C">Небо над головой</a></strong></div>
		</td></tr>
		<tr><td colspan=2 background="images/l2.jpg" WIDTH=200 HEIGHT=25>
		<div class="text"><strong><a href="gal.php" style="color:22355C">Фотогалерея</a></strong></div>
		</td></tr>
		<tr><td colspan=2 background="images/l2.jpg" WIDTH=200 HEIGHT=25>
		<div class="text"><strong><a href="feed_back.php" style="color:22355C">Обратная связь</a></strong></div>
		</td></tr>
		<tr><td colspan=2><IMG SRC="images/l3.jpg" WIDTH=200 HEIGHT=28></td></tr>
		
<?php include "show_news.php" ?>
		
		<tr><td colspan=2><IMG SRC="images/l5.jpg" WIDTH=200 HEIGHT=25></td></tr>
		</table>
		<!-- left text-->
		</TD>
		<TD COLSPAN=11 valign="top" height="100%">