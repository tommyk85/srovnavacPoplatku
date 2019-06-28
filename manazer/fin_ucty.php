<HTML>
  <HEAD>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <TITLE>Moje finance - prehled uctu</TITLE>
  </HEAD>
<BODY>
<CENTER><H1>Prehled mych financnich produktu</H1></CENTER>

<A HREF="/manazer">Zpet na uvodni stranku.</A><BR>

<?php

include "pripojeni_sql_man.php";

?>

<TABLE border=0>

<TR><TD valign='top' width=400 style='background-color: #F0B000'>

<H2 align='center'>Bezne ucty</H2>
<?php

$sql_bezne_ucty = "SELECT NazevUctu, CONCAT(Predcisli,'-',Cislo,'/',KodBanky) AS CisloU, Stav, Mena, Www, idmoje_ucty FROM moje_ucty WHERE TypUctu='bezny' ORDER BY NazevUctu ASC";
if (!$sql_bezne_ucty)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodařilo se nám poslat SQL dotaz na seznam beznych uctu.');
} 
echo 'Dotaz na seznam beznych uctu byl odeslan.<br>';

$bezne_ucty = mysql_query($sql_bezne_ucty, $id_spojeni);

?>
<FORM action='fin_edit_ucet.php' method='POST'<?php if(Count($bezne_ucty)==0){echo "onsubmit='return false'";} ?>>

<input type='hidden' name='typ_uctu' value='bezny'>

<?php

while($radek_bezne_ucty = mysql_fetch_row($bezne_ucty))
{
    echo "<B>".$radek_bezne_ucty[0]."</B>
    <input type='radio' name='muj_ucet' value='".$radek_bezne_ucty[5]."'><BR>";
    echo "$radek_bezne_ucty[1] ... stav $radek_bezne_ucty[2] $radek_bezne_ucty[3]<BR>";
    if($radek_bezne_ucty[4]!=Null && $radek_bezne_ucty[4]!='http://') echo "<A HREF='$radek_bezne_ucty[4]' target='_blank'>$radek_bezne_ucty[4]</A>";

echo '<P>';   
}

?>
<input type='submit' name='Zmenit' value='edit'>
</FORM>


<TD valign='top' width=400 style='background-color: #00C4FF'>
<H2 align='center'>Kreditni karty</H2>
<?php
$sql_kreditky = "SELECT NazevUctu, Karta_cislo, Stav, Mena, Karta_limit, Www FROM moje_ucty WHERE TypUctu='kreditni' ORDER BY NazevUctu ASC";
if (!$sql_kreditky)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodařilo se nám poslat SQL dotaz na seznam kreditek.');
} 
echo 'Dotaz na seznam kreditek byl odeslan.<br>';

$kreditky = mysql_query($sql_kreditky, $id_spojeni);
?>
<FORM action='fin_edit_ucet.php' method='POST'<?php if(Count($kreditky)==0){echo "onsubmit='return false'";} ?>>

<input type='hidden' name='typ_uctu' value='kreditni'>

<?php

while($radek_kreditky = mysql_fetch_row($kreditky))
{
    
     echo "<B>".$radek_kreditky[0]."</B>
     <input type='radio' name='muj_ucet' value='".$radek_kreditky[0]."'><BR>";
     echo "xxxx xxxx xxxx $radek_kreditky[1] ... cerpano $radek_kreditky[2] z $radek_kreditky[4] $radek_kreditky[3]<BR>";
     if($radek_kreditky[5]!=Null && $radek_kreditky[5]!='http://') echo "<A HREF='$radek_kreditky[5]' target='_blank'>$radek_kreditky[5]</A>";
    

echo '<P>';   
}

?>

<input type='submit' name='Zmenit' value='edit'>
</FORM>
</TD>

<TD valign='top' width=400 rowspan=2 style='background-color: darkgray'>
<H2 align='center'>Jine ucty</H2>

<?php
$sql_jine ="SELECT NazevUctu, CONCAT(Predcisli,'-',Cislo,'/',KodBanky) AS CisloU, Stav, Mena, Ucet_varianta, Cislo, Www FROM moje_ucty WHERE TypUctu='jiny' ORDER BY NazevUctu ASC";
if (!$sql_jine)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodařilo se nám poslat SQL dotaz na seznam pojisteni.');
} 
echo 'Dotaz na seznam jinych uctu byl odeslan.<br>';

$jine = mysql_query($sql_jine, $id_spojeni);
?>

<FORM action='fin_edit_ucet.php' method='POST'<?php if(Count($jine)==0){echo "onsubmit='return false'";} ?>>
<input type='hidden' name='typ_uctu' value='jiny'>

<?php
while($radek_jine = mysql_fetch_row($jine))
{
    echo "<B>$radek_jine[0]</B><FONT size=2> ($radek_jine[4])</FONT>";
    echo "<input type='radio' name='muj_ucet' value='$radek_jine[0]'><BR>";
    echo "$radek_jine[1] ... stav $radek_jine[2] $radek_jine[3]<BR>";
    if($radek_jine[6]!=Null && $radek_jine[6]!='http://') echo "<A HREF='$radek_jine[6]' target='_blank'>$radek_jine[6]</A>";
    echo "<P><input type='hidden' name='ucet_varianta' value='$radek_jine[4]'>";
}
 
?>

<input type='submit' name='Zmenit' value='edit'>

</FORM>
</TD></TR>



<TR><TD valign='top' style='background-color: #40D000'>
<H2 align='center'>Sporici ucty</H2>
<?php
$sql_spor_ucty = "SELECT NazevUctu, CONCAT(Predcisli,'-',Cislo,'/',KodBanky) AS CisloU, Stav, Mena, Www, idmoje_ucty FROM moje_ucty WHERE TypUctu='sporici' ORDER BY NazevUctu ASC";
if (!$sql_spor_ucty)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodařilo se nám poslat SQL dotaz na seznam sporicich uctu.');
} 
echo 'Dotaz na seznam sporicich uctu byl odeslan.<br>';

$spor_ucty = mysql_query($sql_spor_ucty, $id_spojeni);
?>
<FORM action='fin_edit_ucet.php' method='POST'<?php if(Count($spor_ucty)==0){echo "onsubmit='return false'";} ?>>

<input type='hidden' name='typ_uctu' value='sporici'>

<?php


while($radek_spor_ucty = mysql_fetch_row($spor_ucty))
{
    echo "<B>".$radek_spor_ucty[0]."</B>
     <input type='radio' name='muj_ucet' value='".$radek_spor_ucty[5]."'><BR>";
    echo "$radek_spor_ucty[1] ... stav $radek_spor_ucty[2] $radek_spor_ucty[3]<BR>";
    if($radek_spor_ucty[4]!=Null && $radek_spor_ucty[4]!='http://') echo "<A HREF='$radek_spor_ucty[4]' target='_blank'>$radek_spor_ucty[4]</A>";
echo '<P>';
}

?>

<input type='submit' name='Zmenit' value='edit'>
</FORM>
</TD>

<TD valign='top' style='background-color: #F03000'>

<H2 align='center'>Investicni pojisteni</H2>

<H3>Zivotni pojisteni</H3>

<?php
$sql_ziv_pojisteni = "SELECT NazevUctu, CONCAT(Predcisli,'-',Cislo,'/',KodBanky) AS CisloU, TypUctu, Stav, Mena, Www FROM moje_ucty WHERE TypUctu = 'poj_zivotni' ORDER BY NazevUctu ASC";
if (!$sql_ziv_pojisteni)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodařilo se nám poslat SQL dotaz na seznam pojisteni.');
} 
echo 'Dotaz na seznam zivotnich pojisteni byl odeslan.<br>';

$ziv_pojisteni = mysql_query($sql_ziv_pojisteni, $id_spojeni);
?>

<FORM action='fin_edit_ucet.php' method='POST'<?php if(Count($ziv_pojisteni)==0){echo "onsubmit='return false'";} ?>>

<?php
while($radek_ziv_pojisteni = mysql_fetch_row($ziv_pojisteni))
{
    echo "<B>".$radek_ziv_pojisteni[0]."</B>
     <input type='radio' name='muj_ucet' value='".$radek_ziv_pojisteni[0]."'><BR>";
    echo "$radek_ziv_pojisteni[1] ... stav $radek_ziv_pojisteni[3] $radek_ziv_pojisteni[4]<BR>";
    if($radek_ziv_pojisteni[5]!=Null && $radek_ziv_pojisteni[5]!='http://') echo "<A HREF='$radek_ziv_pojisteni[5]' target='_blank'>$radek_ziv_pojisteni[5]</A><P>";
}   
?>
<input type='hidden' name='typ_uctu' value='poj_zivotni'>
<input type='submit' name='Zmenit' value='edit'>
</FORM>

<H3>Penzijni pripojisteni</H3>
<?php
$sql_pen_pojisteni = "SELECT NazevUctu, CONCAT(Predcisli,'-',Cislo,'/',KodBanky) AS CisloU, TypUctu, Stav, Mena, Www FROM moje_ucty WHERE TypUctu = 'poj_penzijni' ORDER BY NazevUctu ASC";
if (!$sql_pen_pojisteni)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodařilo se nám poslat SQL dotaz na seznam pojisteni.');
} 
echo 'Dotaz na seznam penzijnich pripojisteni byl odeslan.<br>';

$pen_pojisteni = mysql_query($sql_pen_pojisteni, $id_spojeni);
?>

<FORM action='fin_edit_ucet.php' method='POST'<?php if(Count($pen_pojisteni)==0){echo "onsubmit='return false'";} ?>>

<?php
while($radek_pen_pojisteni = mysql_fetch_row($pen_pojisteni))
{
    echo "<B>".$radek_pen_pojisteni[0]."</B>
     <input type='radio' name='muj_ucet' value='".$radek_pen_pojisteni[0]."'><BR>";
    echo "$radek_pen_pojisteni[1] ... stav $radek_pen_pojisteni[3] $radek_pen_pojisteni[4]<BR>";
    if($radek_pen_pojisteni[5]!=Null && $radek_pen_pojisteni[5]!='http://') echo "<A HREF='$radek_pen_pojisteni[5]' target='_blank'>$radek_pen_pojisteni[5]</A><P>";
}   
?>
<input type='hidden' name='typ_uctu' value='poj_penzijni'>
<input type='submit' name='Zmenit' value='edit'>
</FORM>
</TD></TR>
</TABLE>




<A HREF="fin_ucty-novy.htm">Vytvorit novy ucet.</A><P>
<A HREF="/manazer">Zpet na uvodni stranku.</A>

<?php

if($id_spojeni)
{
  mysql_close($id_spojeni);
  echo 'odpojeno <br>';
} 
?>

</BODY>
</HTML>
