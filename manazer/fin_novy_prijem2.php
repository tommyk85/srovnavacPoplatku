<HTML>
  <HEAD>
    <META HTTP-EQUIV="Content-Type" CONTENT="text/html;charset=utf-8">
    <TITLE>Moje finance - zadani noveho jednorazoveho prijmu</TITLE>
  </HEAD>
<BODY>

<?php 

include "pripojeni_sql_man.php";

include "datumy.php";


?>

<CENTER>

<H1>Zadani noveho prijmu</H1>

<?php

$sql_moje_bank_ucty = "SELECT NazevUctu, Mena, idmoje_ucty FROM moje_ucty WHERE TypUctu IN ('sporici', 'bezny', 'kreditni') ORDER BY NazevUctu ASC";
$moje_bank_ucty = mysql_query($sql_moje_bank_ucty, $id_spojeni);
if (!$moje_bank_ucty)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodaøilo se nám poslat SQL dotaz na moje bankovni ucty.');
} 
echo 'Dotaz na moje bankovni ucty odeslan.<br>';


/*
$sql_svatky = "SELECT Datum FROM svatky";
$svatky = mysql_query($sql_svatky, $id_spojeni);
if(!$svatky)
{
    echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
    die('Nepodaøilo se poslat SQL dotaz na svatky.<br>');
}
echo 'Dotaz na svatky odeslan.<br>';
*/
//$radek_svatky = mysql_fetch_row($svatky);

//echo implode(",", $radek_svatky);

//echo mysql_num_rows($svatky);

?>

<FORM action="fin_detail_prijmu2.php" method='POST'>

<?php 

$akt_datum = Date("Y-m-d", Time());
//$akt_datum = strtotime($akt_datum);

//echo pracovni_den($akt_datum);

/*
$svatek = array();
while($radek_svatky = mysql_fetch_row($svatky))
{
$svatek[] = strtotime($radek_svatky[0]);
}


for($akt_datum; $akt_datum > 0; $akt_datum = $akt_datum - 86400)    //86400 = 1 den
{
$datum = $akt_datum;
$den_cislo = Date('w', $datum);

if($den_cislo > 0 && $den_cislo <= 5 && !in_array($datum, $svatek))
break;

}
*/
$den = Date("d", pracovni_den($akt_datum));
$mesic = Date("m", pracovni_den($akt_datum));
$rok = Date("Y", pracovni_den($akt_datum));


?>

<TABLE width=400>

<TR><TD NOWRAP>Zdroj prijmu:</TD>
<TD><INPUT type='text' name='zdroj' size=32 maxlength=30>
</TD></TR>

<TR><TD>Datum prijeti <SUP>*</SUP>:</TD>
<TD>
<INPUT type='text' name='rok' size=3 maxlength=4 value='<?php echo $rok; ?>'> -
<INPUT type='text' name='mesic' size=1 maxlength=2 value='<?php echo $mesic; ?>'> - 
<INPUT type='text' name='den' size=1 maxlength=2 value='<?php echo $den; ?>'>
</TD></TR>

<TR><TD>Prijeti na ucet <SUP>*</SUP>:</TD>
<TD><SELECT name='ucet'>
<OPTION value=''></OPTION>
<?php 

while($radek_moje_bank_ucty = mysql_fetch_row($moje_bank_ucty))
{
echo "<OPTION value='$radek_moje_bank_ucty[2]'> $radek_moje_bank_ucty[0] ($radek_moje_bank_ucty[1])</OPTION>";
}

?>


</SELECT>
</TD></TR>



<TR><TD NOWRAP>Celkova castka <SUP>*</SUP>:<BR><FONT size=1>v mene uctu</FONT></TD>
<TD><INPUT type='text' name='prijem' size=8 maxlength=13>
</TD></TR>








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
