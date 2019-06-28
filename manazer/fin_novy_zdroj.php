<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Moje finance-nastaveni noveho zdroje</title>
</head>
<body bgcolor="#FFFFFF" text="#000000">

<center><font face="Arial CE, Arial" size=4>

<FORM action='fin_detail_zdroje.php' method='POST'>


<?php



If (!isset($_POST['next-novy_zdroj']) || $_POST['next-novy_zdroj'] != 'Pokracuj') 
die ('Neplatny pokus.');



include "pripojeni_sql_man.php";


$sql_moje_ucty = "SELECT idmoje_ucty, NazevUctu FROM moje_ucty WHERE TypUctu In('sporici','bezny')";
$moje_ucty = mysql_query($sql_moje_ucty, $id_spojeni);
if (!$moje_ucty)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodaøilo se nám poslat SQL dotaz na moje ucty.');
} 
echo 'Dotaz na moje ucty odeslan.<br>';



If ($_POST['zdroj_typ'] == 'aktivni')
{
?>

<INPUT type='hidden' name='zdroj_typ' value='aktivni'>
<TABLE BORDER=0 width=500>
<CAPTION><B>Zadani noveho AKTIVNIHO zdroje</B></CAPTION>

<TR><TD>Nazev zamestnavatele <SUP>*</SUP>:</TD>
<TD COLSPAN=2><INPUT type='text' name='zdroj_nazev' size=32 maxlength=30></TD></TR>

<TR><TD>Hlavni zdroj <SUP>*</SUP>:</TD>
<TD><INPUT type='radio' name='zdroj_prefer' value=1> Ano
<INPUT type='radio' name='zdroj_prefer' value=0> Ne</TD></TR>

<TR><TD>Vyplata ke dni <SUP>*</SUP>:</TD>
<TD COLSPAN=2><INPUT type='text' name='zdroj_den' size=1 maxlength=2></TD></TR>

<TR><TD>Vyplata v mene <SUP>*</SUP>:</TD>
<TD><SELECT name='zdroj_mena'>
<OPTION value='CZK'>CZK</OPTION>
</SELECT></TD></TR>

<TR><TD>Hruba mesicni mzda:</TD>
<TD COLSPAN=2><INPUT type='text' name='zdroj_mzda' size=8 maxlength=13></TD></TR>

<TR><TD>Vyplata na ucet <SUP>*</SUP>:</TD>
<TD><SELECT name='zdroj_ucet'>
<OPTION value=''></OPTION>

<?php
while($radek_moje_ucty = mysql_fetch_row($moje_ucty))
{
   
     echo '<OPTION value='. $radek_moje_ucty[0] .'>'. $radek_moje_ucty[1] .'</OPTION>';
    
}

?>
</SELECT>
</TD>
</TR>



</TABLE>


<?php
}

If ($_POST['zdroj_typ'] == 'pasivni')
{
?>

<INPUT type='hidden' name='zdroj_typ' value='pasivni'>
<TABLE BORDER=0 width=600>
<CAPTION><B>Zadani noveho PASIVNIHO zdroje</B></CAPTION>

<TR><TD>Nazev zdroje <SUP>*</SUP>:</TD>
<TD COLSPAN=2><INPUT type='text' name='zdroj_nazev' size=32 maxlength=30></TD></TR>

<TR><TD valign='top'>Typ zdroje <SUP>*</SUP>:</TD>
<TD><INPUT type='radio' name='zdroj_varianta' value='nemovitost'> Pronajem nemovitost<BR>
<INPUT type='radio' name='zdroj_varianta' value='auto'> Pronajem auta<BR>
<INPUT type='radio' name='zdroj_varianta' value='jiny'> Jiny typ..</TD></TR>

<TR><TD>Jmeno platce:</TD>
<TD COLSPAN=2><INPUT type='text' name='zdroj_platce' size=32 maxlength=30></TD></TR>

<TR><TD>Prijem ke dni <SUP>*</SUP>:</TD>
<TD COLSPAN=2><INPUT type='text' name='zdroj_den' size=1 maxlength=2></TD></TR>

<TR><TD>Prijem v mene <SUP>*</SUP>:</TD>
<TD><SELECT name='zdroj_mena'>
<OPTION value='CZK'>CZK</OPTION>
</SELECT></TD></TR>

<TR><TD>Mesicni prijem:</TD>
<TD COLSPAN=2><INPUT type='text' name='zdroj_mzda' size=8 maxlength=13></TD></TR>

<TR><TD>Prijem na ucet <SUP>*</SUP>:</TD>
<TD><SELECT name='zdroj_ucet'>
<OPTION value=''></OPTION>

<?php
while($radek_moje_ucty = mysql_fetch_row($moje_ucty))
{
   
     echo '<OPTION value='. $radek_moje_ucty[0] .'>'. $radek_moje_ucty[0] .'</OPTION>';
    
}

?>
</SELECT>
</TD>
</TR>



</TABLE>

<?php
}


if($id_spojeni)
{
  mysql_close($id_spojeni);
  echo 'odpojeno<br>';
}

?>            
<input type=button onclick='history.back()' value='Zpět'>
<INPUT type='submit' name='next-detail_zdroje' value='Pokracuj'>

</FORM>



</font></center>
</body>
</html>
