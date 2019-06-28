<HTML>
  <HEAD>
    <META HTTP-EQUIV="Content-Type" CONTENT="text/html;charset=utf-8">
    <TITLE>Moje finance - zadani noveho jednorazoveho prijmu</TITLE>
  </HEAD>
<BODY>

<?php 

include "pripojeni_sql_man.php";

date_default_timezone_set('Europe/Prague');


?>

<CENTER>

<H1>Zadani novych uroku</H1>

<?php

$sql_moje_bank_ucty = "SELECT NazevUctu, Mena, TypUctu, idmoje_ucty FROM moje_ucty WHERE TypUctu IN ('sporici', 'bezny') AND Urok > 0 ORDER BY NazevUctu ASC";
$moje_bank_ucty = mysql_query($sql_moje_bank_ucty, $id_spojeni);
if (!$moje_bank_ucty)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodaøilo se nám poslat SQL dotaz na moje bankovni ucty.');
} 
echo 'Dotaz na moje bankovni ucty odeslan.<br>';



$sql_posledni_uroky = "SELECT max(Datum) FROM prijem WHERE Koment = 'urok'";
$posledni_uroky = mysql_query($sql_posledni_uroky, $id_spojeni);
if (!$posledni_uroky)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodaøilo se nám poslat SQL dotaz na posledni uroky.');
} 
echo 'Dotaz na posledni uroky odeslan.<br>';




?>

<FORM action="fin_detail_prijmu3.php" method='POST'>


<INPUT type='hidden' name='zdroj' value='urok'>


<?php 

$akt_datum = Date("Y-m", Time());


if(mysql_num_rows($posledni_uroky) == 0)
{
$den = '01';
$mesic = Date("m", strtotime($akt_datum));
$rok = Date("Y", strtotime($akt_datum));
}

?>

<TABLE width=800>

<TR><TD>Rok a mesic prijeti <SUP>*</SUP>:</TD>
<TD>
<INPUT type='text' name='rok' size=3 maxlength=4 value='<?php echo $rok; ?>'> -
<INPUT type='text' name='mesic' size=1 maxlength=2 value='<?php echo $mesic; ?>'>
<INPUT type='hidden' name='den' size=1 maxlength=2 value='<?php echo $den; ?>'>
</TD></TR>

<TR><TD>Uroky podle uctu:</TD>
</TR>


<?php 

$uroky = array();

while($radek_moje_bank_ucty = mysql_fetch_row($moje_bank_ucty))
{
echo "<TR><TD align='right'>$radek_moje_bank_ucty[0]:</TD><TD><INPUT type='text' name='$radek_moje_bank_ucty[3]' size=8> $radek_moje_bank_ucty[1], z toho srazkova dan <INPUT type='text' name='dan_$radek_moje_bank_ucty[3]' size=6> $radek_moje_bank_ucty[1]</TD></TR>";

echo "<INPUT type='hidden' name='uroky[]' value='$radek_moje_bank_ucty[3]'>";

}

?>



</TABLE>
<P>
<INPUT type=button onclick="history.back()" value="Zpět">
<INPUT type='submit' name='next-pokracuj' value='Pokracuj'>

</FORM>

<?php
if($id_spojeni)
{
  mysql_close($id_spojeni);
  echo 'odpojeno<br>';
}

?>            


</CENTER>
</BODY>
</HTML>
