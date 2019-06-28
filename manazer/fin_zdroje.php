<HTML>
  <HEAD>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <TITLE>Moje finance - prehled zdroju prijmu</TITLE>
  </HEAD>
<BODY>
<CENTER><H1>Prehled mych zdroju prijmu</H1></CENTER>

<A HREF="/manazer">Zpet na uvodni stranku.</A><BR>

<?php

include "pripojeni_sql_man.php";

?>

<TABLE border=0>

<TR><TD valign='top' width=350 style='background-color: #FF6633'>

<H2 align='center'>Aktivni zdroj(e) ze zamestnani</H2>
<?php

$sql_aktivni_zdroje = "SELECT Nazev, Mzda, Mena, Preferovany, idzdroje FROM manazer.zdroje WHERE Typ='aktivni'";
if (!$sql_aktivni_zdroje)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodaøilo se nám poslat SQL dotaz na seznam aktivnich zdroju.');
} 
echo 'Dotaz na seznam aktivnich zdroju byl odeslan.<br>';

$aktivni_zdroje = mysql_query($sql_aktivni_zdroje, $id_spojeni);

?>
<FORM action='fin_edit_zdroj.php' method='POST'<?php if(Count($aktivni_zdroje)==0){echo "onsubmit='return false'";} ?>>

<input type='hidden' name='typ' value='aktivni'>

<?php

while($radek_aktivni_zdroje = mysql_fetch_row($aktivni_zdroje))
{
    echo "<B>$radek_aktivni_zdroje[0]</B>
    <input type='radio' name='muj_zdroj' value='$radek_aktivni_zdroje[4]'>";
    if($radek_aktivni_zdroje[3]==1){echo '<FONT size=1> hlavni zdroj</FONT>';}
    if($radek_aktivni_zdroje[1] > 0){echo "<BR>Aktualni hruba mesicni mzda je $radek_aktivni_zdroje[1] $radek_aktivni_zdroje[2]<BR>";}
    
echo '<P>';   
}

?>
<input type='submit' name='Zmenit' value='edit'>
</FORM>
</TD>

<TD valign='top' width=350 style='background-color: #CCFF66'>

<H2 align='center'>Pasivni zdroj(e)</H2>
<?php

$sql_spor_ucty = "SELECT NazevUctu, Urok FROM moje_ucty WHERE TypUctu = 'sporici'";
$spor_ucty = mysql_query($sql_spor_ucty, $id_spojeni);
if (!$spor_ucty)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodaøilo se nám poslat SQL dotaz na sporici ucty.');
} 
echo 'Dotaz na sporici ucty odeslan.<br>';

$sql_pasivni_zdroje = "SELECT Nazev, Mzda, Mena, idzdroje FROM zdroje WHERE Typ='pasivni'";
if (!$sql_pasivni_zdroje)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodaøilo se nám poslat SQL dotaz na seznam pasivnich zdroju.');
} 
echo 'Dotaz na seznam pasivnich zdroju byl odeslan.<br>';

$pasivni_zdroje = mysql_query($sql_pasivni_zdroje, $id_spojeni);

?>
<FORM action='fin_edit_zdroj.php' method='POST'<?php if(Count($pasivni_zdroje)==0){echo "onsubmit='return false'";} ?>>

<input type='hidden' name='typ' value='pasivni'>

<?php

while($radek_pasivni_zdroje = mysql_fetch_row($pasivni_zdroje))
{
    echo "<B>$radek_pasivni_zdroje[0]</B>
    <input type='radio' name='muj_zdroj' value='$radek_pasivni_zdroje[3]'><BR>";
    if($radek_pasivni_zdroje[1] > 0){echo "Aktualni mesicni prijem je $radek_pasivni_zdroje[1] $radek_pasivni_zdroje[2]<BR>";}
    
echo '<P>';   
}

?>
<input type='submit' name='Zmenit' value='edit'>
</FORM>
<P>
<HR>
<H3>Sporici ucty</H3>
<?php
while($radek_spor_ucty = mysql_fetch_row($spor_ucty))
{
    echo "<B>$radek_spor_ucty[0]</B> - $radek_spor_ucty[1] %, ";
}
?>

</TD>
</TR>
</TABLE>

<A HREF="fin_zdroje-novy.htm">Novy zdroj prijmu.</A><P>
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
