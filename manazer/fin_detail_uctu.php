<html>
<head>
<meta charset="utf-8">
<title>Moje finance-overeni zadanych udaju</title>
</head>
<body bgcolor="#FFFFFF" text="#000000">
<center><font face="Arial CE, Arial" size=4>

  
                                     
<?php
                                        
If (!isset($_POST['next-detail_uctu']) || $_POST['next-detail_uctu'] != 'Pokracuj') 
die ('Neplatny pokus.');

//   DEFINICE PROMENNYCH

date_default_timezone_set('Europe/Prague');

$nazev = str_replace(' ','_',Trim($_POST['ucet_nazev']));
$predcisli = str_replace(' ', '',$_POST['ucet_predcisli']);
$cislo = str_replace(' ', '', $_POST['ucet_cislo']);
$kod_banky = $_POST['ucet_kod_banky'];
$mena = $_POST['ucet_mena'];
$stav = str_replace(' ', '', $_POST['ucet_stav']);
$www = $_POST['ucet_www'];

if($_POST['typ_uctu'] == 'sporici' || $_POST['typ_uctu'] == 'bezny' || $_POST['typ_uctu'] == 'kreditni'){
$zalozeni_datum = Date($_POST['ucet_zalozeni_rok']."/".$_POST['ucet_zalozeni_mesic']."/".$_POST['ucet_zalozeni_den']);
$min_zustatek = str_replace(' ', '', $_POST['ucet_min_zustatek']);
$urok = str_replace(' ', '', $_POST['ucet_urok']);
$karta = $_POST['typ_uctu'] == 'kreditni' ? 'Ano' : $_POST['ucet_karta'];
  if($karta == 'Ano' && $_POST['typ_uctu'] != 'kreditni'){
$karta_nazev = str_replace(' ','_',Trim($_POST['ucet_karta_nazev']));  
  }
  elseif($_POST['typ_uctu'] == 'kreditni'){
$karta_nazev = $nazev;  
  }
  else{$karta_nazev = Null;}
  
$karta_cislo = ($karta == 'Ano') || $_POST['typ_uctu'] == 'kreditni' ?  str_replace(' ', '', $_POST['ucet_karta_cislo']) : Null;
$karta_limit = ($karta == 'Ano') || $_POST['typ_uctu'] == 'kreditni' ?  str_replace(' ', '', $_POST['ucet_karta_limit']) : 0;
$vypis = $_POST['ucet_vypis'];
$prebytek_prevod = $_POST['typ_uctu'] != 'kreditni' ? $_POST['ucet_prevod'] : Null;
$spor_ucet = $prebytek_prevod == 2 ? $_POST['ucet_muj'] : 0;
}

if($_POST['typ_uctu'] == 'bezny'){
$kontokorent = $_POST['ucet_kontokorent'];
$kontokorent_limit = ($kontokorent=='Ano') ? str_replace(' ', '', $_POST['ucet_kontokorent_limit']) : 0;
}

if($_POST['typ_uctu'] == 'kreditni'){
$min_splatka = str_replace(' ', '', $_POST['ucet_min_splatka']);
$karta_bezurok = str_replace(' ', '', $_POST['karta_bezurok']);
}

if($_POST['typ_uctu'] == 'poj_zivotni' || $_POST['typ_uctu'] == 'poj_penzijni'){
$prispevek_vlastni = $_POST['ucet_prispevek_vlastni'];
$prispevek_zam = ($_POST['ucet_prispevek_zamestnavatel'] != Null) ? $_POST['ucet_prispevek_zamestnavatel'] : 0;
$prispevek_treti = ($_POST['ucet_prispevek_tretiOsoba'] != Null) ? $_POST['ucet_prispevek_tretiOsoba'] : 0;
$spor_vlastni = $_POST['typ_uctu'] == 'poj_zivotni' ? $_POST['ucet_vlastni_spor'] : $prispevek_vlastni;
  if($_POST['typ_uctu'] == 'poj_zivotni')
  {
  $spor_zam = $_POST['ucet_zam_spor'] != Null ? $_POST['ucet_zam_spor'] : 0;
  $spor_treti = $_POST['ucet_treti_spor'] != Null ? $_POST['ucet_treti_spor'] : 0;
  }
  elseif($_POST['typ_uctu'] == 'poj_penzijni')
  {
  $spor_zam = $prispevek_zam;
  $spor_treti = $prispevek_treti;
  }
$trans_ucet = ($_POST['ucet_prispevek_platba'] == 'Ano') ? $_POST['trans_ucet'] : Null;
$frekvence = str_replace(' ', '', $_POST['ucet_prispevek_frekvence']);
$forma = ($_POST['ucet_prispevek_platba'] == 'Ne') ? $_POST['prispevek_forma'] : Null;
$cislo_smlouvy = str_replace(' ', '', $_POST['ucet_smlouva']);
}

if($_POST['typ_uctu'] == 'jiny'){
$ucet_varianta = $_POST['ucet_varianta'];
$ucet_var_spec = str_replace(' ','_',Trim($_POST['ucet_var_spec']));
}


$cislo_uctu = "$predcisli - $cislo / $kod_banky";


//ElseIf ($_POST['typ_uctu'] == 'bezny' && (!$_POST['ucet_nazev'] || !$_POST['ucet_kod_banky']))
//die ('Nejsou vyplneny povinne udaje');

//   KONTROLNI BODY

if($_POST['typ_uctu'] == 'sporici' && !$_POST['trans_ucet']){die('<FONT color=red>Nezvolena zadna moznost transakcniho uctu.</FONT><P> 
<input type=button onclick="history.back()" value="Zpìt">');}

$check = array();
$check['nazev1'] = (!$nazev) ? 'nezadany nazev uctu. <br>' : Null;
$check['nazev2'] = preg_match('/[^\w]/', $nazev) ? 'nepovolene znaky v nazvu uctu. <br>' : Null;
//$check['nazev3'] = $nazev == 'mKonto' ? 'ucet s nazvem mKonto jiz existuje. <br>' : Null;           
$check['predcisli'] = (!ctype_digit($predcisli)) && $predcisli ? 'predcisli musi byt cele cislo. <br>' : Null; 
$check['cislo1'] = $predcisli && !$cislo ? 'pri vyplneni predcisli musi byt vyplneno i cislo uctu. <br>' : Null; 
$check['cislo2'] = (!ctype_digit($cislo)) && $cislo ? 'cislo uctu musi byt cele cislo. <br>' : Null;
$check['kod_banky'] = !$kod_banky ? 'nezvoleny kod banky. <br>' : Null;
$check['mena'] = !$mena ? 'nezvolena mena uctu. <br>' : Null;
//$check['zalozeni_datum'] = $zalozeni_datum && !preg_match('/0?[1-9]|[12][0-9]|3[01]\/ ?0?[1-9]|1[0-2]\/ ?20[0-9]{2}/', $zalozeni_datum) ? 'spatny format datumu zalozeni uctu' : Null;

if($_POST['typ_uctu'] == 'sporici' || $_POST['typ_uctu'] == 'bezny' || $_POST['typ_uctu'] == 'kreditni'){
$check['min_zustatek1'] = !$min_zustatek && $min_zustatek != 0 ? 'Nezadany minimalni zustatek.<BR>' : Null;
$check['min_zustatek2'] = $min_zustatek < 0 ? 'Minimalni zustatek nesmi byt zaporne cislo.<BR>' : Null;
$check['urok1'] = !$urok && $urok != 0 ? 'Nezadana vyse uroku.<BR>' : Null;
$check['urok2'] = $urok < 0 ? 'Urok nesmi byt zaporne cislo.<BR>' : Null;
$check['karta_nazev1'] = ($karta == 'Ano' && !$karta_nazev) ? 'nezadany nazev karty. <br>' : Null;
$check['karta_nazev2'] = ($karta == 'Ano' && preg_match('/[^\w]/', $karta_nazev)) ? 'nepovolene znaky v nazvu karty. <br>' : Null;
$check['karta_cislo1'] = ($karta == 'Ano' && !$karta_cislo) ? 'nezadane cislo karty. <br>' : Null;
$check['karta_cislo2'] = ($karta == 'Ano' && $karta_cislo && !ctype_digit($karta_cislo)) ? 'cislo karty musi byt cele cislo. <br>' : Null;
}

if($_POST['typ_uctu'] == 'sporici'){
$check['spor_ucet1'] = $prebytek_prevod == 2 && !$_POST['ucet_muj'] ? 'Neni urceny ucet pro prebytecne prostredky.<BR>' : Null;
$check['spor_ucet2'] = $spor_ucet && !in_array($spor_ucet, $_POST['trans_ucet']) ? 'Ucet urceny pro prebytecne prostredky neni zaroven uvedeny mezi transakcnimi ucty.<BR>' : Null;
$check['trans_ucet'] = in_array('zadne', $_POST['trans_ucet']) && Count($_POST['trans_ucet']) > 1 ? 'Neplatny zapis transakcnich uctu' : Null;
}




foreach ($check as $hodnota)
{
  echo $hodnota;
}
  if (implode("", ($check))!=Null)
  {
  die ('<p>zopakovat zapis.<P>
  <input type=button onclick="history.back()" value="Zpìt">'); 	
  }


include "pripojeni_sql_man.php";




$sql_id_banky = "SELECT nazev_banky FROM poplatky.banky WHERE kod_banky=" . mysql_real_escape_string($_POST['ucet_kod_banky']);

$id_banky = mysql_query($sql_id_banky,$id_spojeni);
if (!$id_banky)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodařilo se nám poslat SQL dotaz na nazev banky.');
} 
echo 'Dotaz na nazev banky odeslán.<br>';

$sql_varianta_uctu = "SELECT ucet_id, ucet_nazev FROM poplatky.ucty INNER JOIN poplatky.banky ON ucet_Kod_Banky = kod_banky WHERE kod_banky='". $_POST['ucet_kod_banky'] ."' AND ucet_typ like '". $_POST['typ_uctu'] ."%'";

$varianta_uctu = mysql_query($sql_varianta_uctu, $id_spojeni);
if (!$varianta_uctu)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodaøilo se nám poslat SQL dotaz na nazev banky.');
} 
echo 'Dotaz na varianty uctu odeslán.<br>';


/*$sql_pocet_variant_uctu = "SELECT Count(VariantaUctu) FROM poplatky INNER JOIN banky ON poplatky.KodBanky = banky.kod_banky WHERE kod_banky=" . mysql_real_escape_string($_POST['ucet_kod_banky']);

$pocet_variant_uctu = mysql_query($sql_pocet_variant_uctu, $id_spojeni);
if (!$pocet_variant_uctu)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodaøilo se nám poslat SQL dotaz na nazev banky.');
} 
echo 'Dotaz na pocet variant uctu odeslán.<br>';

$pocet_variant_uctu = mysql_result($pocet_variant_uctu, 0); */

//$varianta_uctu = mysql_result($varianta_uctu, 0);




If ($_POST['typ_uctu'] == 'bezny')
{

//str_replace(' ', '',$_POST['ucet_predcisli']).' - '.str_replace(' ', '',$_POST['ucet_cislo']).' / '.$_POST['ucet_kod_banky'];
?>
<form action='fin_potvrzeni_uctu.php' method='POST'>
<TABLE WIDTH=800 BORDER=1>

<CAPTION><B>Kontrola vstupnich dat noveho BEZNEHO uctu</B></CAPTION>
<TR>
<TH>Nazev uctu</TH>
<TH>Cislo uctu</TH>
<TH>Nazev banky</TH>
<TH>Varianta uctu</TH>
<TH>Web adresa</TH>
<TH>Mena uctu</TH>
<TH>Datum zalozeni</TH>
<TH>Stav uctu</TH>
<TH>Min. zustatek</TH>
<TH>Urok na uctu</TH>

</TR>


<TR><TD ALIGN='CENTER' NOWRAP><?php echo $nazev; ?></TD>
    
    <TD ALIGN='CENTER' NOWRAP><?php echo $cislo_uctu; ?></TD>
    
    <TD ALIGN='CENTER' NOWRAP>

<?php

$nazevBanky = mysql_result($id_banky, 0); 
echo $nazevBanky; 

?>

</TD>

    <TD ALIGN='CENTER' NOWRAP style='border-style: solid; border-width: 3; border-color: red; background-color: red'>
    <SELECT name='ucet_varianta'>

<?php
while ($radek_varianta_uctu = mysql_fetch_row($varianta_uctu))
{

   echo '<OPTION value='. $radek_varianta_uctu[0] .'>'. $radek_varianta_uctu[1] .'</OPTION>';
  
}
//echo "$varianta_uctu";
//

?>

</SELECT></TD>

    <TD ALIGN='CENTER' NOWRAP><A HREF=<?php echo "'$www' target='_blank'>$www</A>"; ?></TD>
    <TD ALIGN='CENTER' NOWRAP><?php echo $mena; ?></TD>
    <TD ALIGN='CENTER' NOWRAP><?php echo $zalozeni_datum; ?></TD>
    <TD ALIGN='CENTER' NOWRAP><?php echo $stav; ?></TD>
    <TD ALIGN='CENTER' NOWRAP><?php echo $min_zustatek; ?></TD>
    <TD ALIGN='CENTER' NOWRAP><?php echo $urok; ?></TD>

</TR>
</TABLE>


<BR>


<TABLE WIDTH=800 BORDER=1>
<TH>Prebytek</TH>
<?php if($prebytek_prevod == 2)
{
?>
<TH>Ucet pro prebytek</TH>
<?php 
}
?>

<TH>Debetni karta</TH>
<?php
if($karta=='Ano')
{
?>
<TH>Nazev karty</TH>
<TH>Posledni 4-cisli karty</TH>
<TH>Mesicni limit karty</TH>
<?php
}
?>
<TH>Kontokorent</TH>
<?php
if($kontokorent=='Ano')
{
?>
<TH>Limit kontokorentu</TH>
<?php
}
?>
<TH>Vypis z uctu</TH></TR>



<TR><TD ALIGN='CENTER' NOWRAP><?php 
                              $sql_prebytek_text = "SELECT CASE $prebytek_prevod WHEN 1 THEN 'Odecitat na budouci platby' WHEN 2                    THEN 'Prevadet na sporici ucet' WHEN 3 THEN 'Nechavat na ucte' END";
                              $prebytek_text = mysql_query($sql_prebytek_text, $id_spojeni);
                              if (!$prebytek_text)
                              {
                                echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
                                die('Nepodaøilo se nám poslat SQL dotaz na chovani prebytku.');
                              } 
                              echo 'Dotaz na chovani prebytku odeslan.<br>';
                              
                              $radek_prebytek_text = mysql_result($prebytek_text, 0);
                              echo $radek_prebytek_text; ?></TD>
                              
<?php if($prebytek_prevod == 2)
{
?>    
    <TD ALIGN='CENTER' NOWRAP><?php echo $spor_ucet; ?></TD>
<?php
}
?>    
    
    
    <TD ALIGN='CENTER' NOWRAP><?php echo $karta; ?></TD>

<?php 
if($karta=='Ano')
{
echo "
    <TD ALIGN='CENTER' NOWRAP>$karta_nazev</TD>
    <TD ALIGN='CENTER' NOWRAP>$karta_cislo</TD>
    <TD ALIGN='CENTER' NOWRAP>$karta_limit</TD>";
}
?>
    
    <TD ALIGN='CENTER' NOWRAP><?php echo $kontokorent; ?></TD>

<?php 
if($kontokorent=='Ano')
{
echo "
    <TD ALIGN='CENTER' NOWRAP>$kontokorent_limit</TD>";
}
?>
    
    <TD ALIGN='CENTER' NOWRAP><?php echo $vypis; ?></TD></TR>
</TABLE>

<?php
echo "
<INPUT type='hidden' name='typUctu' value=".$_POST['typ_uctu'].">
<INPUT type='hidden' name='nazevUctu' value=$nazev>
<INPUT type='hidden' name='predcisli' value=$predcisli>
<INPUT type='hidden' name='cislo' value=$cislo>
<INPUT type='hidden' name='kodBanky' value='$kod_banky'>
<INPUT type='hidden' name='nazevBanky' value='$nazevBanky'>
<INPUT type='hidden' name='mena' value=$mena>
<INPUT type='hidden' name='zalozeni' value=$zalozeni_datum>
<INPUT type='hidden' name='stav' value=$stav>
<INPUT type='hidden' name='minZustatek' value=$min_zustatek>
<INPUT type='hidden' name='urok' value=$urok>
<INPUT type='hidden' name='urok_prevod' value='$prebytek_prevod'>
<INPUT type='hidden' name='karta' value=$karta>
<INPUT type='hidden' name='kontokorent' value=$kontokorent>
<INPUT type='hidden' name='vypis' value=$vypis>
<INPUT type='hidden' name='karta_nazev' value=$karta_nazev>
<INPUT type='hidden' name='karta_cislo' value=$karta_cislo>
<INPUT type='hidden' name='karta_limit' value=$karta_limit>
<INPUT type='hidden' name='kontokorent_limit' value=$kontokorent_limit>
<INPUT type='hidden' name='spor_ucet' value=$spor_ucet>
<INPUT type='hidden' name='www' value=$www>";
?>




<BR>





<?php
}

If ($_POST['typ_uctu'] == 'sporici')
{

//str_replace(' ', '',$_POST['ucet_predcisli']).' - '.str_replace(' ', '',$_POST['ucet_cislo']).' / '.$_POST['ucet_kod_banky'];
?>
<form action='fin_potvrzeni_uctu.php' method='POST'>
<TABLE WIDTH=800 BORDER=1>

<CAPTION><B>Kontrola vstupnich dat noveho SPORICIHO uctu</B></CAPTION>
<TR>
<TH>Nazev uctu</TH>
<TH>Cislo uctu</TH>
<TH>Nazev banky</TH>
<TH>Varianta uctu</TH>
<TH>Web adresa</TH>
<TH>Mena uctu</TH>
<TH>Datum zalozeni</TH>
<TH>Stav uctu</TH>
<TH>Min. zustatek</TH>
<TH>Urok na uctu</TH>

</TR>


<TR><TD ALIGN='CENTER' NOWRAP><?php echo $nazev; ?></TD>
     
    <TD ALIGN='CENTER' NOWRAP><?php echo $cislo_uctu; ?></TD>
    
    <TD ALIGN='CENTER' NOWRAP>

<?php

$nazevBanky = mysql_result($id_banky, 0); 
echo $nazevBanky; 

?>

</TD>

    <TD ALIGN='CENTER' NOWRAP style='border-style: solid; border-width: 3; border-color: red; background-color: red'>
    <SELECT name='ucet_varianta'>

<?php
while ($radek_varianta_uctu = mysql_fetch_row($varianta_uctu))
{
 
   echo '<OPTION value='. $radek_varianta_uctu[0] .'>'. $radek_varianta_uctu[0] .'</OPTION>';
 
}
//echo "$varianta_uctu";
//

?>

</SELECT></TD>

    <TD ALIGN='CENTER' NOWRAP><A HREF=<?php echo "'$www' target='_blank'>$www</A>"; ?></TD>
    <TD ALIGN='CENTER' NOWRAP><?php echo $mena; ?></TD>
    <TD ALIGN='CENTER' NOWRAP><?php echo $zalozeni_datum; ?></TD>
    <TD ALIGN='CENTER' NOWRAP><?php echo $stav; ?></TD>
    <TD ALIGN='CENTER' NOWRAP><?php echo $min_zustatek; ?></TD>
    <TD ALIGN='CENTER' NOWRAP><?php echo $urok; ?></TD>

</TR>
</TABLE>


<BR>


<TABLE WIDTH=800 BORDER=1>
<TH>Prebytek</TH>
<?php if($prebytek_prevod == 2)
{
?>
<TH>Ucet pro prebytek</TH>
<?php 
}
?>

<TH>Transakcni ucty</TH>

<TH>Debetni karta</TH>
<?php
if($karta=='Ano')
{
?>
<TH>Nazev karty</TH>
<TH>Posledni 4-cisli karty</TH>
<TH>Limit karty</TH>
<?php
}
?>

<TH>Vypis z uctu</TH></TR>



<TR><TD ALIGN='CENTER' NOWRAP><?php 
                              $sql_prebytek_text = "SELECT CASE $prebytek_prevod WHEN 1 THEN 'Odecitat na budouci platby' WHEN 2                    THEN 'Prevadet na sporici ucet' WHEN 3 THEN 'Nechavat na ucte' END";
                              $prebytek_text = mysql_query($sql_prebytek_text, $id_spojeni);
                              if (!$prebytek_text)
                              {
                                echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
                                die('Nepodaøilo se nám poslat SQL dotaz na chovani prebytku.');
                              } 
                              echo 'Dotaz na chovani prebytku odeslan.<br>';
                              
                              $radek_prebytek_text = mysql_result($prebytek_text, 0);
                              echo $radek_prebytek_text; ?></TD>
                              
<?php if($prebytek_prevod == 2)
{
?>    
    <TD ALIGN='CENTER' NOWRAP><?php echo $spor_ucet; ?></TD>
<?php
}

?>    


    <TD ALIGN='CENTER'><?php 
    $trans_ucet = implode(",", $_POST['trans_ucet']);
    echo "$trans_ucet"; ?></TD>

    
    
    <TD ALIGN='CENTER' NOWRAP><?php echo $karta; ?></TD>

<?php 
if($karta=='Ano')
{
echo "
    <TD ALIGN='CENTER' NOWRAP>$karta_nazev</TD>
    <TD ALIGN='CENTER' NOWRAP>$karta_cislo</TD>
    <TD ALIGN='CENTER' NOWRAP>$karta_limit</TD>";
}
?>
    

    
    <TD ALIGN='CENTER' NOWRAP><?php echo $vypis; ?></TD></TR>
</TABLE>

<?php
echo "
<INPUT type='hidden' name='typUctu' value=".$_POST['typ_uctu'].">
<INPUT type='hidden' name='nazevUctu' value=$nazev>
<INPUT type='hidden' name='predcisli' value=$predcisli>
<INPUT type='hidden' name='cislo' value=$cislo>
<INPUT type='hidden' name='kodBanky' value='$kod_banky'>
<INPUT type='hidden' name='nazevBanky' value='$nazevBanky'>
<INPUT type='hidden' name='mena' value=$mena>
<INPUT type='hidden' name='zalozeni' value=$zalozeni_datum>
<INPUT type='hidden' name='stav' value=$stav>
<INPUT type='hidden' name='minZustatek' value=$min_zustatek>
<INPUT type='hidden' name='urok' value=$urok>
<INPUT type='hidden' name='urok_prevod' value='$prebytek_prevod'>
<INPUT type='hidden' name='karta' value=$karta>
<INPUT type='hidden' name='vypis' value=$vypis>
<INPUT type='hidden' name='karta_nazev' value=$karta_nazev>
<INPUT type='hidden' name='karta_cislo' value=$karta_cislo>
<INPUT type='hidden' name='karta_limit' value=$karta_limit>
<INPUT type='hidden' name='spor_ucet' value=$spor_ucet>
<INPUT type='hidden' name='trans_ucet' value=$trans_ucet>
<INPUT type='hidden' name='www' value=$www>";

}

If ($_POST['typ_uctu'] == 'kreditni')
{
?>


<form action='fin_potvrzeni_uctu.php' method='POST'>

<input type='hidden' name='typUctu' value='kreditni'>
<input type='hidden' name='karta' value='Ano'>
<input type='hidden' name='karta_nazev' value='<?php echo $karta_nazev; ?>'>


<TABLE WIDTH=800 BORDER=1>
<CAPTION><B>Kontrola vstupnich dat nove KREDITNI karty</B></CAPTION>
<TR>
<TH>Nazev karty</TH>
<TH>Cislo karty</TH>
<TH>Cislo uctu</TH>
<TH>Nazev banky</TH>
<TH>Varianta karty</TH>
<TH>Web adresa</TH>
<TH>Mena uctu</TH>
<TH>Datum aktivace karty</TH>
<TH>Bezurocne obdobi az</TH>
<TH>Aktualne cerpano</TH>
<TH>Limit karty</TH>
<TH>Mesicni urok</TH>
<TH>Min. mes. splatka</TH>
<TH>Limit cerpani</TH>
<TH>Vypis</TH>
</TR>

<TR>
<TD ALIGN='CENTER' NOWRAP><?php echo $nazev; ?>
<input type='hidden' name='nazevUctu' value='<?php echo $nazev; ?>'></TD>

<TD ALIGN='CENTER' NOWRAP><?php echo "xxxx xxxx xxxx $karta_cislo"; ?>
<input type='hidden' name='karta_cislo' value='<?php echo $karta_cislo; ?>'></TD>

<TD ALIGN='CENTER' NOWRAP><?php echo $cislo_uctu; ?>
<INPUT type='hidden' name='predcisli' value='<?php echo $predcisli; ?>'>
<INPUT type='hidden' name='cislo' value='<?php echo $cislo; ?>'>
<INPUT type='hidden' name='kodBanky' value='<?php echo $kod_banky; ?>'></TD>

<TD ALIGN='CENTER' NOWRAP>

<?php

echo $nazevBanky = mysql_result($id_banky, 0); 

?>
<INPUT type='hidden' name='nazevBanky' value='<?php echo $nazevBanky; ?>'>
</TD>

<TD ALIGN='CENTER' NOWRAP style='border-style: solid; border-width: 3; border-color: red; background-color: red'>
    <SELECT name='ucet_varianta'>
  <OPTION value=''></OPTION>
<?php
while ($radek_varianta_uctu = mysql_fetch_row($varianta_uctu))
{
 
   echo "<OPTION value='$radek_varianta_uctu[0]'>". $radek_varianta_uctu[0] ."</OPTION>";
 
}
//echo "$varianta_uctu";
//

?>
    </SELECT>
</TD>

<TD ALIGN='CENTER' NOWRAP><A HREF=<?php echo "'$www' target='_blank'>$www</A>"; ?>
<input type='hidden' name='www' value='<?php echo $www; ?>'></TD>

<TD ALIGN='CENTER' NOWRAP><?php echo $mena; ?>
<input type='hidden' name='mena' value='<?php echo $mena; ?>'></TD>

<TD ALIGN='CENTER' NOWRAP><?php echo $zalozeni_datum; ?>
<input type='hidden' name='zalozeni' value='<?php echo $zalozeni_datum; ?>'></TD>

<TD ALIGN='CENTER' NOWRAP><?php echo $karta_bezurok; ?> dni
<input type='hidden' name='karta_bezurok' value='<?php echo $karta_bezurok; ?>'></TD>

<TD ALIGN='CENTER' NOWRAP><?php echo $stav; ?>
<input type='hidden' name='stav' value='<?php echo $stav; ?>'></TD>

<TD ALIGN='CENTER' NOWRAP><?php echo $karta_limit; ?>
<input type='hidden' name='karta_limit' value='<?php echo $karta_limit; ?>'></TD>

<TD ALIGN='CENTER' NOWRAP><?php echo $urok; ?>
<input type='hidden' name='urok' value='<?php echo $urok; ?>'></TD>

<TD ALIGN='CENTER' NOWRAP><?php echo $min_splatka; ?>
<input type='hidden' name='min_splatka' value='<?php echo $min_splatka; ?>'></TD>

<TD ALIGN='CENTER' NOWRAP><?php echo $min_zustatek; ?>
<input type='hidden' name='minZustatek' value='<?php echo $min_zustatek; ?>'></TD>

<TD ALIGN='CENTER' NOWRAP><?php echo $vypis; ?>
<input type='hidden' name='vypis' value='<?php echo $vypis; ?>'></TD>

</TR>

</TABLE>


<?php
}

if($_POST['typ_uctu'] == 'poj_zivotni' || $_POST['typ_uctu'] == 'poj_penzijni')
{
  if($_POST['ucet_prispevek_platba'] == 'Ano')
  {
  $sql_detail_zdroje = "SELECT * FROM zdroje WHERE Nazev ='".$_POST['trans_ucet']."'";
  $detail_zdroje = mysql_query($sql_detail_zdroje, $id_spojeni);
  if(!$detail_zdroje)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodaøilo se nám poslat SQL dotaz na detaily zdroje.');
} 
echo 'Dotaz na detaily zdroje odeslan.<br>';
  
  $radek_detail_zdroje = mysql_fetch_assoc($detail_zdroje);
  }


?>


<form action='fin_potvrzeni_uctu.php' method='POST'>

<?php
$prispevek_platba = $_POST['ucet_prispevek_platba'];
  if($_POST['ucet_prispevek_platba'] == 'Ano')
  {
  $zalozeni_datum = $_POST['ucet_zalozeni_rok']."/".$_POST['ucet_zalozeni_mesic']."/".$radek_detail_zdroje['Den_vyplaty'];
  echo "<INPUT type='hidden' name='platba_den' value='".$radek_detail_zdroje['Den_vyplaty']."'>";
  }
  elseif($_POST['ucet_prispevek_platba'] == 'Ne')
  {
  $zalozeni_datum = $_POST['ucet_zalozeni_rok']."/".$_POST['ucet_zalozeni_mesic']."/".$_POST['ucet_zalozeni_den'];
  echo "<INPUT type='hidden' name='platba_den' value='".$_POST['ucet_zalozeni_den']."'>";
  }
include "datumy.php";



$zalozeni_datum = Date("Y-m-d", pracovni_den($zalozeni_datum));


?>


<input type='hidden' name='typUctu' value='<?php echo $_POST['typ_uctu']; ?>'>
<input type='hidden' name='vypis' value='Papirovy'>

<TABLE BORDER=1>
<CAPTION><B>Kontrola vstupnich dat noveho <U>
<?php if($_POST['typ_uctu'] == 'poj_zivotni'){echo 'INVESTICNIHO ZIVOTNIHO</U> ';} 
elseif($_POST['typ_uctu'] == 'poj_penzijni'){echo 'PENZIJNIHO</U> PRI';} ?>POJISTENI</B></CAPTION>
<TR>
<TH>Nazev pojisteni</TH>
<TH>Cislo smlouvy</TH>
<TH>Cislo uctu</TH>
<TH>Nazev banky</TH>
<TH>Varianta pojisteni</TH>
<TH>Web adresa</TH>
<TH>Mena uctu</TH>
<TH>Aktualni stav</TH>
<TH>Frekvence prispevku (v mesicich)</TH>
</TR>

<TR>

<TD ALIGN='CENTER' NOWRAP><?php echo $nazev; ?>
<input type='hidden' name='nazevUctu' value='<?php echo $nazev; ?>'></TD>

<TD ALIGN='CENTER' NOWRAP><?php echo $cislo_smlouvy != Null ? $cislo_smlouvy : '-'; ?>
<input type='hidden' name='cislo_smlouvy' value='<?php echo $cislo_smlouvy; ?>'></TD>

<TD ALIGN='CENTER' NOWRAP><?php echo $cislo_uctu; ?>
<INPUT type='hidden' name='predcisli' value='<?php echo $predcisli; ?>'>
<INPUT type='hidden' name='cislo' value='<?php echo $cislo; ?>'>
<INPUT type='hidden' name='kodBanky' value='<?php echo $kod_banky; ?>'></TD>

<TD ALIGN='CENTER' NOWRAP>

<?php

echo $nazevBanky = mysql_result($id_banky, 0); 

?>
<INPUT type='hidden' name='nazevBanky' value='<?php echo $nazevBanky; ?>'>
</TD>

<TD ALIGN='CENTER' NOWRAP style='border-style: solid; border-width: 3; border-color: red; background-color: red'>
    <SELECT name='ucet_varianta'>
<?php
while ($radek_varianta_uctu = mysql_fetch_row($varianta_uctu))
{
 
   echo "<OPTION value='$radek_varianta_uctu[0]'>". $radek_varianta_uctu[0] ."</OPTION>";
 
}
//echo "$varianta_uctu";
//

?>
    </SELECT>
</TD>

<TD ALIGN='CENTER' NOWRAP><A HREF=<?php echo "'$www' target='_blank'>$www</A>"; ?>
<input type='hidden' name='www' value='<?php echo $www; ?>'></TD>

<TD ALIGN='CENTER' NOWRAP><?php echo $mena; ?>
<input type='hidden' name='mena' value='<?php echo $mena; ?>'></TD>

<TD ALIGN='CENTER' NOWRAP><?php echo $stav; ?>
<input type='hidden' name='stav' value='<?php echo $stav; ?>'></TD>




<TD ALIGN='CENTER' NOWRAP><?php echo $frekvence; ?>
<input type='hidden' name='frekvence' value='<?php echo $frekvence; ?>'></TD>


</TR>


</TABLE>

<BR>

<TABLE BORDER=1>
<TR>
<TH>Vlastni prispevek</TH>
<TH>Prispevek zamestnavatele</TH>
<TH>Prispevek strhavan z vyplaty</TH>
<?php 
if($prispevek_platba == 'Ano'){echo "<TH>Nazev prispivajiciho zamestnavatele</TH>";}
?>
<TH>Prispevek treti osoby</TH>
<TH>Datum nejblizsi platby</TH>
<?php 
if($prispevek_platba == 'Ne'){echo "<TH>Forma uhrady</TH>";}
?>

</TR>

<TR>
<TD ALIGN='CENTER' NOWRAP><?php echo $prispevek_vlastni;
  if($spor_vlastni > 0 && $_POST['typ_uctu'] == 'poj_zivotni'){echo "<BR><FONT size=2 color='gray'>na sporeni $spor_vlastni</FONT>";} ?>
<input type='hidden' name='prispevekVlastni' value='<?php echo $prispevek_vlastni; ?>'>
<input type='hidden' name='spor_vlastni' value='<?php echo $spor_vlastni; ?>'></TD>

<TD ALIGN='CENTER' NOWRAP><?php echo $prispevek_zam;
  if($spor_zam > 0 && $_POST['typ_uctu'] == 'poj_zivotni'){echo "<BR><FONT size=2 color='gray'>na sporeni $spor_zam</FONT>";} ?>
<input type='hidden' name='prispevekZam' value='<?php echo $prispevek_zam; ?>'>
<input type='hidden' name='spor_zam' value='<?php echo $spor_zam; ?>'></TD>

<TD ALIGN='CENTER' NOWRAP><?php echo $prispevek_platba; ?>
<input type='hidden' name='prispevekPlatba' value='<?php echo $prispevek_platba; ?>'></TD>

<?php 
if($prispevek_platba == 'Ano'){echo "<TD ALIGN='CENTER' NOWRAP> $trans_ucet";}
?>

<input type='hidden' name='trans_ucet' value='<?php echo $trans_ucet; ?>'>
<input type='hidden' name='zalozeni' value='<?php echo $zalozeni_datum; ?>'>
<input type='hidden' name='prispevek_platba' value='<?php echo $prispevek_platba; ?>'></TD>

<TD ALIGN='CENTER' NOWRAP><?php echo $prispevek_treti;
  if($spor_treti > 0 && $_POST['typ_uctu'] == 'poj_zivotni'){echo "<BR><FONT size=2 color='gray'>na sporeni $spor_treti</FONT>";} ?>
<input type='hidden' name='prispevekTreti' value='<?php echo $prispevek_treti; ?>'>
<input type='hidden' name='spor_treti' value='<?php echo $spor_treti; ?>'></TD>

<TD ALIGN='CENTER' NOWRAP><?php echo $zalozeni_datum; ?>
<input type='hidden' name='zalozeni_datum' value='<?php echo $zalozeni_datum; ?>'></TD>

<?php 
if($prispevek_platba == 'Ne')
{
SWITCH($forma)
{
  CASE 'TP':
    echo "<TD ALIGN='CENTER' NOWRAP>Trvaly prikaz</TD>
    <INPUT type='hidden' name='forma' value='$forma'>";
  break;
  
  CASE 'S':
    echo "<TD ALIGN='CENTER' NOWRAP>Preddefinovana sablona</TD>
    <INPUT type='hidden' name='forma' value='$forma'>";
  break;
  
  CASE 'JP':
    echo "<TD ALIGN='CENTER' NOWRAP>Jednorazovy prikaz</TD>
    <INPUT type='hidden' name='forma' value='$forma'>";
  break;
  
  CASE 'J':
    echo "<TD ALIGN='CENTER' NOWRAP>Jiny prikaz</TD>
    <INPUT type='hidden' name='forma' value='$forma'>";
  break;

  default:
  echo "<TD ALIGN='CENTER' NOWRAP><FONT color='red'><B>Neznamy prikaz</B></FONT></TD>";
}
}
?>
</TR>




</TABLE>

<BR>

<?php
}

if($_POST['typ_uctu'] == 'jiny')
{
?>

<form action='fin_potvrzeni_uctu.php' method='POST'>

<input type='hidden' name='typUctu' value='jiny'>
<input type='hidden' name='ucet_varianta' value='<?php if($ucet_varianta == 'jine'){echo "$ucet_varianta-$ucet_var_spec";}
else echo $ucet_varianta; ?>'>
<input type='hidden' name='vypis' value='Zadny'>

<TABLE WIDTH=600 BORDER=1>
<CAPTION><B>Kontrola vstupnich dat 
<?php if($ucet_varianta == 'penezenka'){echo 'nove <U>ELEKTRONICKE PENEZENKY</U> ';} 
elseif($ucet_varianta == 'sazky'){echo 'noveho <U>SAZKARSKEHO</U> uctu';}
elseif($ucet_varianta == 'jine'){echo "noveho uctu JINEHO typu - <U>$ucet_var_spec</U>";}
elseif($ucet_varianta == 'none'){echo 'noveho <U>nespecifikovaneho</U> uctu';} ?></B></CAPTION>
<TR>
<TH>Nazev uctu</TH>
<TH>Cislo uctu</TH>
<TH>Nazev banky</TH>
<TH>Web adresa</TH>
<TH>Mena uctu</TH>
<TH>Aktualni stav</TH>
</TR>

<TD ALIGN='CENTER' NOWRAP><?php echo $nazev; ?>
<input type='hidden' name='nazevUctu' value='<?php echo $nazev; ?>'></TD>

<TD ALIGN='CENTER' NOWRAP><?php echo $cislo_uctu; ?>
<INPUT type='hidden' name='predcisli' value='<?php echo $predcisli; ?>'>
<INPUT type='hidden' name='cislo' value='<?php echo $cislo; ?>'>
<INPUT type='hidden' name='kodBanky' value='<?php echo $kod_banky; ?>'></TD>

<TD ALIGN='CENTER' NOWRAP>

<?php

echo $nazevBanky = mysql_result($id_banky, 0); 

?>
<INPUT type='hidden' name='nazevBanky' value='<?php echo $nazevBanky; ?>'>
</TD>

<TD ALIGN='CENTER' NOWRAP><A HREF=<?php echo "'$www' target='_blank'>$www</A>"; ?>
<input type='hidden' name='www' value='<?php echo $www; ?>'></TD>

<TD ALIGN='CENTER' NOWRAP><?php echo $mena; ?>
<input type='hidden' name='mena' value='<?php echo $mena; ?>'></TD>

<TD ALIGN='CENTER' NOWRAP><?php echo $stav; ?>
<input type='hidden' name='stav' value='<?php echo $stav; ?>'></TD>



</TABLE>

<BR>

<?php
}

if($id_spojeni)
{
  mysql_close($id_spojeni);
  echo 'odpojeno <br>';
} 
?>

<input type=button onclick="history.back()" value="Zpět"> 
<input type='submit' name='next-potvrzeni_uctu' value='Pokracuj'>


</FORM>
</font></center>
</body>
</html>