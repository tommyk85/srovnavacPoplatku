<html>
<head>
<meta charset="utf-8">
<title>Moje finance-nastaveni noveho uctu</title>
</head>
<body bgcolor="#FFFFFF" text="#000000">

<center><font face="Arial CE, Arial" size=4>

<FORM action='fin_detail_uctu.php' method='POST'>


<?php



If (!isset($_POST['next-novy_ucet']) || $_POST['next-novy_ucet'] != 'Pokracuj') 
die ('Neplatny pokus.');



include "pripojeni_sql_man.php";






if($_POST['ucet_typ'] == 'bezny' || $_POST['ucet_typ'] == 'sporici')
{
/*
$sql_pocet_spor_uctu = "SELECT Count(NazevUctu) FROM moje_ucty WHERE TypUctu='sporici'";
$pocet_spor_uctu = mysql_query($sql_pocet_spor_uctu, $id_spojeni);
if (!$pocet_spor_uctu)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodařilo se nám poslat SQL dotaz na pocet uctu.');
} 
echo 'Dotaz na pocet uctu odeslan.<br>';

$radek_pocet_spor_uctu = mysql_result($pocet_spor_uctu, 0);
*/

$sql_moje_spor_ucty = "SELECT idmoje_ucty, nazevuctu FROM moje_ucty WHERE TypUctu='sporici'";
$moje_spor_ucty = mysql_query($sql_moje_spor_ucty, $id_spojeni);
if (!$moje_spor_ucty)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodařilo se nám poslat SQL dotaz na moje sporici ucty.');
} 
echo 'Dotaz na moje sporici ucty odeslan.<br>';



}



If ($_POST['ucet_typ'] == 'bezny')
{
$sql_id_banky = "SELECT * FROM poplatky.banky WHERE exists(SELECT * FROM poplatky.ucty WHERE ucet_kod_banky = banky.kod_banky AND ucet_typ like '".$_POST['ucet_typ']."%') ORDER BY kod_banky ASC";

$id_banky = mysql_query($sql_id_banky,$id_spojeni);
if (!$id_banky)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodařilo se nám poslat SQL dotaz na kody bank.');
} 
echo 'Dotaz na kody bank byl odeslan.<br>';
?>

<INPUT type='hidden' name='typ_uctu' value='bezny'>
<TABLE BORDER=0 width=800>
<CAPTION><B>Zadani noveho BEZNEHO uctu</B></CAPTION>

<TR><TD>Nazev uctu <SUP>*</SUP>:</TD>
<TD COLSPAN=2><INPUT type='text' name='ucet_nazev' size=32 maxlength=30></TD></TR>

<TR><TD>Cislo uctu:</TD>
<TD COLSPAN=2><INPUT type='text' name='ucet_predcisli' size=4 maxlength=6>
-
<INPUT type='text' name='ucet_cislo' size=9 maxlength=10></TD></TR>


<TR><TD>Kod banky <SUP>*</SUP>:</TD>
<TD COLSPAN=2><SELECT name='ucet_kod_banky'>
<OPTION value=''></OPTION>
<?php
while($radek_id_banky = mysql_fetch_row($id_banky))
{

     echo "<OPTION value=". $radek_id_banky[0] .">". $radek_id_banky[0] ." - ". $radek_id_banky[1] ."</OPTION>";

    
}
?>
</SELECT></TD></TR>

<TR><TD>Web adresa:</TD>
<TD><INPUT type='text' name='ucet_www' size=32 maxlength=40 value='http://'></TD></TR> 

<TR><TD>Mena uctu <SUP>*</SUP>:</TD>
<TD><SELECT name='ucet_mena'>
<OPTION value=''></OPTION>
<OPTION value='CZK'>CZK</OPTION>
<OPTION value='EUR'>EUR</OPTION>
<OPTION value='USD'>USD</OPTION>
</SELECT></TD></TR>

<TR><TD>Datum zalozeni uctu <SUP>*</SUP>:<BR><FONT size=1>kvuli startovacim poplatkum</FONT></TD>
<TD><INPUT type='text' name='ucet_zalozeni_rok' size=3 maxlength=4> -
<INPUT type='text' name='ucet_zalozeni_mesic' size=1 maxlength=2> -
<INPUT type='text' name='ucet_zalozeni_den' size=1 maxlength=2> <FONT size=2 color=grey>(RRRR-MM-DD)</FONT><BR></TD></TR>

<TR><TD>Stav uctu <SUP>*</SUP>:</TD>
<TD><INPUT type='text' name='ucet_stav' size=8></TD></TR>

<TR><TD>Minimalni zustatek <SUP>*</SUP>:<BR><FONT size=1> pro automaticke planovani plateb a platby kartou</FONT></TD>
<TD><INPUT type='text' name='ucet_min_zustatek' size=8></TD></TR>

<TR><TD>Mesicni urok <SUP>*</SUP>:</TD>
<TD><INPUT type='text' name='ucet_urok' size=6>%</TD></TR>




<TR><TD rowspan=3 valign='top'>Prebytecne prostredky <SUP>*</SUP>:<BR><FONT size=1>nad minimalni zustatek</FONT></TD>
<TD>
<INPUT type='radio' name='ucet_prevod' value=1 checked> Odecitat na budouci platby</TD></TR>
<TR><TD>
<INPUT type='radio' name='ucet_prevod' value=2  
<?php

if (mysql_num_rows($moje_spor_ucty) == 0)
{
?>
disabled><FONT color='silver'> Prevadet na sporici ucet..</FONT>

<?php
}
else
{
echo '> Prevadet na sporici ucet..';

?>



<SELECT name='ucet_muj'>
<OPTION value=0></OPTION>

<?php
while($radek_moje_spor_ucty = mysql_fetch_array($moje_spor_ucty))
{
   
     echo "<OPTION value=". $radek_moje_spor_ucty[0] .">". $radek_moje_spor_ucty[1] ."</OPTION>";
    
}

}


?>
</SELECT>
</TD>
</TR>

<TR><TD>
<INPUT type='radio' name='ucet_prevod' value=3> Nechavat</TD></TR>

<TR><TD>Debetni karta <SUP>*</SUP>:</TD>
<TD>
<INPUT type='radio' name='ucet_karta' value='Ano'> Ano
<INPUT type='radio' name='ucet_karta' value='Ne' checked> Ne
</TD>
</TR>

<TR><TD>- nazev karty:</TD>
<TD><INPUT type='text' name='ucet_karta_nazev' size=32 maxlength=30></TD></TR>

<TR><TD>- posledni 4-cisli karty:<BR><FONT size=1> pro identifikaci plateb z uctenek</FONT></TD>
<TD><INPUT type='text' name='ucet_karta_cislo' size=4 maxlength=4></TD></TR>

<TR><TD>- mesicni limit karty:<BR><FONT size=1> orientacni castka, kterou nechci prekrocit</FONT></TD>
<TD><INPUT type='text' name='ucet_karta_limit' size=6></TD></TR>


<TR><TD>Kontokorent <SUP>*</SUP>:</TD>
<TD>
<INPUT type='radio' name='ucet_kontokorent' value='Ano'> Ano
<INPUT type='radio' name='ucet_kontokorent' value='Ne' checked> Ne</TD></TR>

<TR><TD>- pokud ano, kolik:</TD>
<TD><INPUT type='text' name='ucet_kontokorent_limit' size=6></TD></TR>

<TR><TD rowspan=2 valign='top'>Vypis z uctu <SUP>*</SUP>:</TD>
<TD>
<INPUT type='radio' name='ucet_vypis' value='Elektronicky' checked> Elektronicky</TD></TR>
<TR><TD>
<INPUT type='radio' name='ucet_vypis' value='Papirovy'> Papirovy</TD></TR>

</TABLE>












<?php
}

ElseIf ($_POST['ucet_typ'] == 'sporici')
{
$sql_id_banky = "SELECT * FROM poplatky.banky WHERE exists(SELECT * FROM poplatky.ucty WHERE ucty.ucet_kod_banky = banky.kod_banky AND ucet_Typ = '".$_POST['ucet_typ']."') ORDER BY kod_banky ASC";

$id_banky = mysql_query($sql_id_banky,$id_spojeni);
if (!$id_banky)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodařilo se nám poslat SQL dotaz na kody bank.');
} 
echo 'Dotaz na kody bank byl odeslan.<br>';


$sql_moje_bank_ucty = "SELECT NazevUctu FROM moje_ucty WHERE TypUctu IN ('sporici', 'bezny', 'kreditni') ORDER BY NazevUctu ASC";
$moje_bank_ucty = mysql_query($sql_moje_bank_ucty, $id_spojeni);
if (!$moje_bank_ucty)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodařilo se nám poslat SQL dotaz na moje bankovni ucty.');
} 
echo 'Dotaz na moje bankovni ucty odeslan.<br>';


?>
<INPUT type='hidden' name='typ_uctu' value='sporici'>
<TABLE BORDER=0 width=800>
<CAPTION><B>Zadani noveho SPORICIHO uctu</B></CAPTION>
<TR><TD>Nazev uctu <SUP>*</SUP>:</TD>
<TD COLSPAN=2><INPUT type='text' name='ucet_nazev' size=32 maxlength=30></TD></TR>

<TR><TD>Cislo uctu:</TD>
<TD COLSPAN=2><INPUT type='text' name='ucet_predcisli' size=4 maxlength=6>
-
<INPUT type='text' name='ucet_cislo' size=9 maxlength=10></TD></TR>

<TR><TD>Kod banky <SUP>*</SUP>:</TD>
<TD COLSPAN=2><SELECT name='ucet_kod_banky'>
<OPTION value=''></OPTION>
<?php
while($radek_id_banky = mysql_fetch_row($id_banky))
{

     echo '<OPTION value='. $radek_id_banky[0] .'>'. $radek_id_banky[0] .' - '. $radek_id_banky[1] .'</OPTION>';
    
}
?>
</SELECT></TD></TR>

<TR><TD>Web adresa:</TD>
<TD><INPUT type='text' name='ucet_www' size=32 maxlength=40 value='http://'></TD></TR> 

<TR><TD>Mena uctu <SUP>*</SUP>:</TD>
<TD><SELECT name='ucet_mena'>
<OPTION value=''></OPTION>
<OPTION value='CZK'>CZK</OPTION>
<OPTION value='EUR'>EUR</OPTION>
<OPTION value='USD'>USD</OPTION>
</SELECT></TD></TR>

<TR><TD>Datum zalozeni uctu <SUP>*</SUP>:<BR><FONT size=1>kvuli startovacim poplatkum</FONT></TD>
<TD><INPUT type='text' name='ucet_zalozeni_rok' size=3 maxlength=4> -
<INPUT type='text' name='ucet_zalozeni_mesic' size=1 maxlength=2> -
<INPUT type='text' name='ucet_zalozeni_den' size=1 maxlength=2> <FONT size=2 color=grey>(RRRR-MM-DD)</FONT><BR></TD></TR>

<TR><TD>Stav uctu <SUP>*</SUP>:</TD>
<TD><INPUT type='text' name='ucet_stav' size=8></TD></TR>

<TR><TD>Minimalni zustatek <SUP>*</SUP>:<BR><FONT size=1> pro automaticke planovani plateb a platby kartou</FONT></TD>
<TD><INPUT type='text' name='ucet_min_zustatek' size=8></TD></TR>

<TR><TD>Mesicni urok <SUP>*</SUP>:</TD>
<TD><INPUT type='text' name='ucet_urok' size=6>%</TD></TR>




<TR><TD rowspan=3 valign='top'>Prebytecne prostredky <SUP>*</SUP>:<BR><FONT size=1>nad minimalni zustatek</FONT></TD>
<TD>
<INPUT type='radio' name='ucet_prevod' value=1 checked> Odecitat na budouci platby</TD></TR>
<TR><TD>
<INPUT type='radio' name='ucet_prevod' value=2  
<?php

if (mysql_num_rows($moje_spor_ucty) == 0)
{
?>
disabled><FONT color='silver'> Prevadet na sporici ucet..</FONT>

<?php
}
else
{
echo '> Prevadet na jiny sporici ucet..';

?>



<SELECT name='ucet_muj'>
<OPTION value=''></OPTION>

<?php
while($radek_moje_spor_ucty = mysql_fetch_array($moje_spor_ucty))
{
      echo '<OPTION value='. $radek_moje_spor_ucty[0] .'>'. $radek_moje_spor_ucty[0] .'</OPTION>';
}
}
?>

</TD>
</TR>

<TR><TD>
<INPUT type='radio' name='ucet_prevod' value=3> Nechavat</TD></TR>


<TR><TD valign='top'>Preddefinovane transakcni ucty <SUP>*</SUP>:</TD>
<TD>
<?php

$trans_ucet = array();

while($radek_moje_bank_ucty = mysql_fetch_row($moje_bank_ucty))
{
      echo "<INPUT type='checkbox' name='trans_ucet[]' value=$radek_moje_bank_ucty[0]> $radek_moje_bank_ucty[0] <BR>";
}
?>
<INPUT type='checkbox' name='trans_ucet[]' value=0> zadny z uvedenych
</TD>
</TR>

<TR><TD>Debetni karta <SUP>*</SUP>:</TD>
<TD>
<INPUT type='radio' name='ucet_karta' value='Ano'> Ano
<INPUT type='radio' name='ucet_karta' value='Ne' checked> Ne
</TD>
</TR>

<TR><TD>- nazev karty:</TD>
<TD><INPUT type='text' name='ucet_karta_nazev' size=32 maxlength=30></TD></TR>

<TR><TD>- posledni 4-cisli karty:<BR><FONT size=1> pro identifikaci plateb z uctenek</FONT></TD>
<TD><INPUT type='text' name='ucet_karta_cislo' size=4 maxlength=4></TD></TR>

<TR><TD>- mesicni limit karty:<BR><FONT size=1> orientacni castka, kterou nechci prekrocit</FONT></TD>
<TD><INPUT type='text' name='ucet_karta_limit' size=6></TD></TR>


<TR><TD rowspan=2 valign='top'>Vypis z uctu <SUP>*</SUP>:</TD>
<TD>
<INPUT type='radio' name='ucet_vypis' value='Elektronicky' checked> Elektronicky</TD></TR>
<TR><TD>
<INPUT type='radio' name='ucet_vypis' value='Papirovy'> Papirovy</TD></TR>

</TABLE>




<?php
}

ElseIf ($_POST['ucet_typ'] == 'kreditni')
{
$sql_id_banky = "SELECT * FROM poplatky.banky WHERE exists(SELECT * FROM poplatky.ucty WHERE ucty.ucet_kod_banky = banky.kod_banky AND ucet_Typ = '".$_POST['ucet_typ']."') ORDER BY kod_banky ASC";

$id_banky = mysql_query($sql_id_banky,$id_spojeni);
if (!$id_banky)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodařilo se nám poslat SQL dotaz na kody bank.');
} 
echo 'Dotaz na kody bank byl odeslan.<br>';
?>
<INPUT type='hidden' name='typ_uctu' value='kreditni'>
<TABLE width=800>
<CAPTION><B>Zadani nove KREDITNI karty</B></CAPTION>
<TR><TD>Nazev karty <SUP>*</SUP>:</TD>
<TD COLSPAN=2><INPUT type='text' name='ucet_nazev' size=32 maxlength=30></TD></TR>
<TR><TD>Posledni 4-cisli karty <SUP>*</SUP>:</TD>
<TD COLSPAN=2><INPUT type='text' name='ucet_karta_cislo' size=3 maxlength=4></TD></TR>

<TR><TD>Cislo uctu na splatky <SUP>*</SUP>:</TD>
<TD COLSPAN=2><INPUT type='text' name='ucet_predcisli' size=4 maxlength=6>
-
<INPUT type='text' name='ucet_cislo' size=9 maxlength=10></TD></TR>

<TR><TD>Kod banky uctu <SUP>*</SUP>:</TD>
<TD COLSPAN=2><SELECT name='ucet_kod_banky'>
<OPTION value=''></OPTION>
<?php
while($radek_id_banky = mysql_fetch_row($id_banky))
{

     echo "<OPTION value=". $radek_id_banky[0] .">". $radek_id_banky[0] ." - ". $radek_id_banky[1] ."</OPTION>";
    
}
?>
</SELECT></TD></TR>

<TR><TD>Web adresa:</TD>
<TD><INPUT type='text' name='ucet_www' size=32 maxlength=40 value='http://'></TD></TR> 

<TR><TD>Mena uctu <SUP>*</SUP>:</TD>
<TD><SELECT name='ucet_mena'>
<OPTION value=''></OPTION>
<OPTION value='CZK'>CZK</OPTION>
<OPTION value='EUR'>EUR</OPTION>
<OPTION value='USD'>USD</OPTION>
</SELECT></TD></TR>

<TR><TD>Datum aktivace karty <SUP>*</SUP>:<BR><FONT size=1>kvuli startovacim poplatkum a vypisum</FONT></TD>
<TD><INPUT type='text' name='ucet_zalozeni_rok' size=3 maxlength=4> -
<INPUT type='text' name='ucet_zalozeni_mesic' size=1 maxlength=2> -
<INPUT type='text' name='ucet_zalozeni_den' size=1 maxlength=2> <FONT size=2 color=grey>(RRRR-MM-DD)</FONT><BR></TD></TR>

<TR><TD>Bezurocne obdobi az <SUP>*</SUP>:</TD>
<TD><INPUT type='text' name='karta_bezurok' size=1 maxlength=2> dni</TD></TR>

<TR><TD>Aktualne vycerpano <SUP>*</SUP>:</TD>
<TD><INPUT type='text' name='ucet_stav' size=8></TD></TR>

<TR><TD>Limit karty <SUP>*</SUP>:</TD>
<TD><INPUT type='text' name='ucet_karta_limit' size=8></TD></TR>

<TR><TD>Mesicni urok <SUP>*</SUP>:</TD>
<TD><INPUT type='text' name='ucet_urok' size=6>%</TD></TR>

<TR><TD>Minimalni mesicni splatka <SUP>*</SUP>:</TD>
<TD><INPUT type='text' name='ucet_min_splatka' size=6>%</TD></TR>

<TR><TD>Limit cerpani:<BR><FONT size=1> orientacni castka, kterou nechci prekrocit</FONT></TD>
<TD><INPUT type='text' name='ucet_min_zustatek' size=8></TD></TR>


<TR><TD rowspan=2 valign='top'>Vypis z uctu <SUP>*</SUP>:</TD>
<TD>
<INPUT type='radio' name='ucet_vypis' value='Elektronicky' checked> Elektronicky</TD></TR>
<TR><TD>
<INPUT type='radio' name='ucet_vypis' value='Papirovy'> Papirovy</TD></TR>


</TABLE>




<?php
}

ElseIf ($_POST['ucet_typ'] == 'poj_zivotni' || $_POST['ucet_typ'] == 'poj_penzijni')
{
$sql_id_banky = "SELECT * FROM poplatky.banky ORDER BY kod_banky ASC";

$id_banky = mysql_query($sql_id_banky,$id_spojeni);
if (!$id_banky)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodařilo se nám poslat SQL dotaz na kody bank.');
} 
echo 'Dotaz na kody bank byl odeslan.<br>';


$sql_aktivni_zdroje = "SELECT Nazev FROM zdroje WHERE not exists(SELECT * FROM moje_ucty WHERE zdroje.Nazev = moje_ucty.Trans_ucet and moje_ucty.TypUctu = '".$_POST['ucet_typ']."') and Typ = 'aktivni'";
$aktivni_zdroje = mysql_query($sql_aktivni_zdroje, $id_spojeni);
if (!$aktivni_zdroje)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodařilo se nám poslat SQL dotaz na aktivni zdroje.');
} 
echo 'Dotaz na aktivni zdroje odeslan.<br>';

?>

<INPUT type='hidden' name='typ_uctu' value='<?php echo $_POST['ucet_typ']; ?>'>

<TABLE>
<CAPTION><B>Zadani noveho <?php if($_POST['ucet_typ'] == 'poj_zivotni'){echo 'INVESTICNIHO ZIVOTNIHO POJISTENI';} 
elseif($_POST['ucet_typ'] == 'poj_penzijni'){echo 'PENZIJNIHO PRIPOJISTENI';} ?></B></CAPTION>

<TR><TD>Nazev pojisteni <SUP>*</SUP>:</TD>
<TD COLSPAN=2><INPUT type='text' name='ucet_nazev' size=32 maxlength=30></TD></TR>

<TR><TD>Cislo smlouvy:</TD>
<TD COLSPAN=2><INPUT type='text' name='ucet_smlouva' size=9 maxlength=10></TD></TR>

<TR><TD>Cislo uctu:</TD>
<TD COLSPAN=2><INPUT type='text' name='ucet_predcisli' size=4 maxlength=6>
-
<INPUT type='text' name='ucet_cislo' size=9 maxlength=10></TD></TR>

<TR><TD>Kod banky <SUP>*</SUP>:</TD>
<TD COLSPAN=2><SELECT name='ucet_kod_banky'>
<OPTION value=''></OPTION>
<?php
while($radek_id_banky = mysql_fetch_row($id_banky))
{

     echo '<OPTION value='. $radek_id_banky[0] .'>'. $radek_id_banky[0] .' - '. $radek_id_banky[1] .'</OPTION>';
    
}
?>
</SELECT></TD></TR>

<TR><TD>Web adresa:</TD>
<TD><INPUT type='text' name='ucet_www' size=32 maxlength=40 value='http://'></TD></TR> 

<TR><TD>Mena uctu <SUP>*</SUP>:</TD>
<TD><SELECT name='ucet_mena'>
<OPTION value=''></OPTION>
<OPTION value='CZK'>CZK</OPTION>
<OPTION value='EUR'>EUR</OPTION>
<OPTION value='USD'>USD</OPTION>
</SELECT></TD></TR>

<TR><TD>Stav uctu <SUP>*</SUP>:</TD>
<TD><INPUT type='text' name='ucet_stav' size=8></TD></TR>


<TR><TD>Prispevky:</TD></TR>
<TR><TD>- vlastni <SUP>*</SUP>:</TD>
<TD><INPUT type='text' name='ucet_prispevek_vlastni' size=8>
<?php
if($_POST['ucet_typ'] == 'poj_zivotni')
{
?>, z toho <INPUT type='text' name='ucet_vlastni_spor' size=8> na sporeni.
<?php
}
?>
</TD></TR>
<TR><TD>- zamestnavatel:</TD>
<TD><INPUT type='text' name='ucet_prispevek_zamestnavatel' size=8>
<?php
if($_POST['ucet_typ'] == 'poj_zivotni')
{
?>, z toho <INPUT type='text' name='ucet_zam_spor' size=8> na sporeni.
<?php
}
?>
</TD></TR>

<TR><TD valign='top'>-- strhavano z vyplaty <SUP>*</SUP>:</TD>
<TD>
<INPUT type='radio' name='ucet_prispevek_platba' value='Ano'> Ano, z vyplaty od 
<SELECT name='trans_ucet'>
<OPTION value=''></OPTION>
<?php

while($radek_aktivni_zdroje = mysql_fetch_row($aktivni_zdroje))
{

     echo "<OPTION value='$radek_aktivni_zdroje[0]'> $radek_aktivni_zdroje[0]</OPTION>";
    
}

?>
</SELECT>
<BR>
<INPUT type='radio' name='ucet_prispevek_platba' value='Ne'> Ne, platby k <INPUT type='text' name='ucet_zalozeni_den' size=1 maxlength=2>. dni v mesici formou <SELECT name='prispevek_forma'>
<OPTION value=''></OPTION>
<OPTION value='TP'>trvaleho prikazu</OPTION>
<OPTION value='S'>preddefinovane sablony</OPTION>
<OPTION value='JP'>jednorazoveho prikazu</OPTION>
<OPTION value='J'>jineho prikazu</OPTION>
</SELECT>

</TD></TR>                                

<TR><TD>- treti osoba:</TD>
<TD><INPUT type='text' name='ucet_prispevek_tretiOsoba' size=8>
<?php
if($_POST['ucet_typ'] == 'poj_zivotni')
{
?>, z toho <INPUT type='text' name='ucet_treti_spor' size=8> na sporeni.
<?php
}
?>
</TD></TR>

<TR><TD>Rok a mesic nejblizsi platby <SUP>*</SUP>:</TD>
<TD>
<INPUT type='text' name='ucet_zalozeni_rok' size=3 maxlength=4> -
<INPUT type='text' name='ucet_zalozeni_mesic' size=1 maxlength=2><FONT size=2 color=gray>(RRRR-MM)</FONT><BR>
</TD></TR>

<TR><TD>Frekvence plateb <SUP>*</SUP>:</TD>
<TD>jednou za <INPUT type='text' name='ucet_prispevek_frekvence' value='1' size=1 maxlength=2> mesic(e)
</TD></TR>






</TABLE>


<?php
}

ElseIf ($_POST['ucet_typ'] == 'jiny')
{
$sql_id_banky = "SELECT * FROM poplatky.banky ORDER BY kod_banky ASC";

$id_banky = mysql_query($sql_id_banky,$id_spojeni);
if (!$id_banky)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodařilo se nám poslat SQL dotaz na kody bank.');
} 
echo 'Dotaz na kody bank byl odeslan.<br>';
?>
<INPUT type='hidden' name='typ_uctu' value='jiny'>
<TABLE border=0 width=600>
<CAPTION><B>Zadani noveho JINEHO typu uctu</B></CAPTION>

<TR><TD>Nazev uctu <SUP>*</SUP>:</TD>
<TD><INPUT type='text' name='ucet_nazev' size=32 maxlength=30></TD></TR>

<TR><TD>Cislo uctu:</TD>
<TD><INPUT type='text' name='ucet_predcisli' size=4 maxlength=6>
-
<INPUT type='text' name='ucet_cislo' size=9 maxlength=10></TD></TR>

<TR><TD>Kod banky <SUP>*</SUP>:</TD>
<TD><SELECT name='ucet_kod_banky'>
<OPTION value=''></OPTION>
<?php
while($radek_id_banky = mysql_fetch_row($id_banky))
{

     echo '<OPTION value='. $radek_id_banky[0] .'>'. $radek_id_banky[0] .' - '. $radek_id_banky[1] .'</OPTION>';
    
}
?>
</SELECT></TD></TR>

<TR><TD>Web adresa:</TD>
<TD><INPUT type='text' name='ucet_www' size=32 maxlength=40 value='http://'></TD></TR> 

<TR><TD>Mena uctu <SUP>*</SUP>:</TD>
<TD><SELECT name='ucet_mena'>
<OPTION value=''></OPTION>
<OPTION value='CZK'>CZK</OPTION>
<OPTION value='EUR'>EUR</OPTION>
<OPTION value='USD'>USD</OPTION>
</SELECT></TD></TR>

<TR><TD>Stav uctu <SUP>*</SUP>:</TD>
<TD><INPUT type='text' name='ucet_stav' size=8></TD></TR>

<TR><TD rowspan=4 valign='top'>Specifikace uctu:</TD>
<TD><INPUT type='radio' name='ucet_varianta' value='penezenka'> Elektronicka penezenka</TD></TR>
<TD><INPUT type='radio' name='ucet_varianta' value='sazky'> Sazkarsky ucet</TD></TR>
<TD><INPUT type='radio' name='ucet_varianta' value='jine'> Jiny.. <INPUT type='text' name='ucet_var_spec' size=22 maxlength=20></TD></TR>
<TD><INPUT type='radio' name='ucet_varianta' value='none'> Nechci uvadet</TD></TR>


</TABLE>  




<?php
}



if($id_spojeni)
{
  mysql_close($id_spojeni);
  echo 'odpojeno<br>';
}

?>            
<input type=button onclick='history.back()' value="Zpět">
<INPUT type='submit' name='next-detail_uctu' value='Pokracuj'>

</FORM>



</font></center>
</body>
</html>
