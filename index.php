<?php
include_once("inc/head.php");
include_once("inc/inc.php");
?>
<TABLE WIDTH=580 BORDER=0 CELLPADDING=0 CELLSPACING=0>
	<TR>
		<TD COLSPAN=4 ROWSPAN=3><IMG SRC="images/q15.jpg" WIDTH=245 HEIGHT=236 ALT=""></TD>
		<TD COLSPAN=4><IMG SRC="images/q16.jpg" WIDTH=161 HEIGHT=40 ALT=""></TD>
		<TD COLSPAN=3 ROWSPAN=3><IMG SRC="images/q17.jpg" WIDTH=174 HEIGHT=236 ALT=""></TD>
	</TR>
	<TR>
		<TD COLSPAN=4><IMG SRC="images/q19.jpg" WIDTH=161 HEIGHT=33 ALT=""></TD>
	</TR>
	<TR>
		<TD COLSPAN=4 background="images/q21.jpg" WIDTH=161 HEIGHT=163 valign="top">
		<div align="center" class="text" style="padding:0; font-size:11px; color:22355C">
		<br>
		<strong>Астрономия - это просто...</strong>
		</div>
		</TD>
	</TR>
	<TR>
		<TD><IMG SRC="images/q23.jpg" WIDTH=72 HEIGHT=125 ALT=""></TD>
		<TD COLSPAN=2 background="images/q24.jpg" WIDTH=118 HEIGHT=125>
		<div class="text" style="padding:0">
		<strong style="color:344E84">Собрания</strong>
		<br>Информация о предстоящих и последующих собраниях членов астроклуба.<br>
		<a href="sobr.php"><strong style="color:344E84">Смотреть ></strong></a><br>
		</div>
		</TD>
		
		
		<TD COLSPAN=2><IMG SRC="images/q25.jpg" WIDTH=62 HEIGHT=125 ALT=""></TD>
		<TD COLSPAN=2 background="images/q26.jpg" WIDTH=126 HEIGHT=125>
		<div class="text" style="padding:0">
		<strong style="color:344E84">Наблюдения</strong>
		<br>Информация о загородных и прочих наблюдениях астроклуба.<br>
		<a href="obser.php"><strong style="color:344E84">Смотреть ></strong></a><br>
		</div>
		</TD>
		
		
		<TD COLSPAN=2><IMG SRC="images/q27.jpg" WIDTH=62 HEIGHT=125 ALT=""></TD>
		<TD COLSPAN=2 background="images/q28.jpg" WIDTH=140 HEIGHT=125>
		<div class="text" style="padding:0">
		<strong style="color:344E84">Небо над головой</strong>
		<br>Здесь вы можете<br>увидеть небо в любое время в заданном месте.<br>
		<a href="calendar_select.php"><strong style="color:344E84">Смотреть ></strong></a><br>
		</div>
		</TD>
		
	</TR>
	<TR>
		<TD COLSPAN=2><a href="sobr.php"><IMG SRC="images/q32.jpg" WIDTH=116 HEIGHT=24 ALT="Собрания" border=0></a></TD>
		<TD><IMG SRC="images/q33.jpg" WIDTH=74 HEIGHT=24></TD>
		<TD COLSPAN=3><a href="obser.php"><IMG SRC="images/q34.jpg" WIDTH=111 HEIGHT=24 ALT="Наблюдения" border=0></a></TD>
		<TD><IMG SRC="images/q35.jpg" WIDTH=77 HEIGHT=24></TD>
		<TD COLSPAN=3><a href="calendar_select.php"><IMG SRC="images/q36.jpg" WIDTH=107 HEIGHT=24 ALT="Небо над головой" border=0></a></TD>
		<TD><IMG SRC="images/q37.jpg" WIDTH=95 HEIGHT=24 ALT=""></TD>
	</TR>
	<TR>
		<TD><IMG SRC="images/spacer.gif" WIDTH=72 HEIGHT=1></TD>
		<TD><IMG SRC="images/spacer.gif" WIDTH=44 HEIGHT=1></TD>
		<TD><IMG SRC="images/spacer.gif" WIDTH=74 HEIGHT=1></TD>
		<TD><IMG SRC="images/spacer.gif" WIDTH=55 HEIGHT=1></TD>
		<TD><IMG SRC="images/spacer.gif" WIDTH=7 HEIGHT=1></TD>
		<TD><IMG SRC="images/spacer.gif" WIDTH=49 HEIGHT=1></TD>
		<TD><IMG SRC="images/spacer.gif" WIDTH=77 HEIGHT=1></TD>
		<TD><IMG SRC="images/spacer.gif" WIDTH=28 HEIGHT=1></TD>
		<TD><IMG SRC="images/spacer.gif" WIDTH=34 HEIGHT=1></TD>
		<TD><IMG SRC="images/spacer.gif" WIDTH=45 HEIGHT=1></TD>
		<TD><IMG SRC="images/spacer.gif" WIDTH=95 HEIGHT=1></TD>
	</TR>
</TABLE>
<IMG SRC="images/r1.jpg" WIDTH=580 HEIGHT=31 border=0><br>
<div class="text">
<?php print stripslashes(getconf("index_text")) ?>
</div>
<?php
include_once("inc/foot.php");
?>