<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Moje finance-nastaveni noveho uctu</title>
</head>
<body bgcolor="#FFFFFF" text="#000000">
<center><font face="Arial CE, Arial" size="4">

<FORM action='fin_potvrzeni_editace_uctu.php' method='POST'>

<?php


If (!isset($_POST['next-detail_edit_uctu']) || $_POST['next-detail_edit_uctu'] != 'Pokracuj') 
die ('Neplatny pokus.');


if($_POST['typ_uctu'] == 'sporici' && !$_POST['trans_ucet']){die('<FONT color=red>Nezvolena zadna moznost transakcniho uctu.</FONT><P> 
<input type=button onclick="history.back()" value="Zpìt">');}

date_default_timezone_set('Europe/Prague');

//     DEFINICE PROMENNYCH
?>
<INPUT type='hidden' name='typ_uctu' value='<?php echo $typ_uctu = $_POST['typ_uctu']; ?>'>
<INPUT type='hidden' name='nazev_uctu' value='<?php echo $nazev_uctu = $_POST['nazev_uctu']; ?>'>
<INPUT type='hidden' name='ucet_predcisli' value='<?php echo $ucet_predcisli = $_POST['ucet_predcisli']; ?>'>
<INPUT type='hidden' name='ucet_cislo' value='<?php echo $ucet_cislo = $_POST['ucet_cislo']; ?>'>
<INPUT type='hidden' name='ucet_kod_banky' value='<?php echo $ucet_kod_banky = $_POST['ucet_kod_banky']; ?>'>
<INPUT type='hidden' name='ucet_www' value='<?php echo $ucet_www = $_POST['ucet_www']; ?>'>
<?php
if($_POST['typ_uctu'] == 'sporici' || $_POST['typ_uctu'] == 'bezny' || $_POST['typ_uctu'] == 'kreditni'){
?>
<INPUT type='hidden' name='min_zustatek' value='<?php echo $min_zustatek = $_POST['ucet_min_zustatek']; ?>'>
<INPUT type='hidden' name='urok' value='<?php echo $urok = $_POST['ucet_urok']; ?>'>
<INPUT type='hidden' name='urok_prevod' value='<?php echo $urok_prevod = $_POST['typ_uctu'] != 'kreditni' ? $_POST['ucet_prevod']: Null; ?>'>
<INPUT type='hidden' name='urok_ucet' value='<?php echo $urok_ucet = ($urok_prevod == 2) ? $_POST['ucet_muj'] : Null; ?>'>
<INPUT type='hidden' name='karta' value='<?php echo $karta = $_POST['typ_uctu'] == 'kreditni' ? 'Ano' : $_POST['ucet_karta']; ?>'>
<INPUT type='hidden' name='karta_nazev' value='<?php if($karta == 'Ano' && $_POST['typ_uctu'] != 'kreditni'){echo $karta_nazev = $_POST['ucet_karta_nazev'];} elseif($_POST['typ_uctu'] == 'kreditni'){echo $karta_nazev = $nazev_uctu;} else echo $karta_nazev = Null; ?>'>
<INPUT type='hidden' name='karta_cislo' value='<?php echo $karta_cislo = ($karta == 'Ano' || $_POST['typ_uctu'] == 'kreditni') ?  $_POST['ucet_karta_cislo'] : Null; ?>'>
<INPUT type='hidden' name='karta_limit' value='<?php echo $karta_limit = ($karta == 'Ano' || $_POST['typ_uctu'] == 'kreditni') ?  $_POST['ucet_karta_limit'] : 0; ?>'>
<INPUT type='hidden' name='vypis' value='<?php echo $vypis = $_POST['ucet_vypis']; ?>'>
<INPUT type='hidden' name='kontokorent' value='<?php echo $kontokorent = ($_POST['typ_uctu'] == 'bezny') ? $_POST['ucet_kontokorent'] : Null; ?>'>
<INPUT type='hidden' name='kontokorent_limit' value='<?php echo $kontokorent_limit = ($_POST['typ_uctu'] == 'bezny' && $kontokorent=='Ano') ? $_POST['ucet_kontokorent_limit'] : 0; ?>'>
<INPUT type='hidden' name='trans_ucet' value='<?php echo $trans_ucet = $_POST['typ_uctu'] == 'sporici' ? implode(",", $_POST['trans_ucet']) : Null; ?>'>
<INPUT type='hidden' name='min_splatka' value='<?php echo $min_splatka = $_POST['typ_uctu'] == 'kreditni' ? $_POST['ucet_min_splatka'] : 0; ?>'>

<INPUT type='hidden' name='karta_bezurok' value='<?php echo $karta_bezurok = $_POST['typ_uctu'] == 'kreditni' ? $_POST['karta_bezurok'] : 0; ?>'>

<?php
}
If ($_POST['typ_uctu'] == 'poj_zivotni' || $_POST['typ_uctu'] == 'poj_penzijni')
{
?>
<INPUT type='hidden' name='ucet_prispevek_platba' value='<?php echo $ucet_prispevek_platba = $_POST['ucet_prispevek_platba']; ?>'>
<INPUT type='hidden' name='ucet_prispevek_vlastni' value='<?php echo $ucet_prispevek_vlastni = $_POST['ucet_prispevek_vlastni']; ?>'>
<INPUT type='hidden' name='ucet_prispevek_zamestnavatel' value='<?php echo $ucet_prispevek_zamestnavatel = $ucet_prispevek_platba == 'Ano' ? $_POST['ucet_prispevek_zamestnavatel'] : 0; ?>'>
<INPUT type='hidden' name='ucet_prispevek_tretiOsoba' value='<?php echo $ucet_prispevek_tretiOsoba = $_POST['ucet_prispevek_tretiOsoba']; ?>'>
<INPUT type='hidden' name='ucet_prispevek_frekvence' value='<?php echo $ucet_prispevek_frekvence = $_POST['ucet_prispevek_frekvence']; ?>'>
<?php 
  if($_POST['typ_uctu'] == 'poj_zivotni'){
  $spor_vlastni = $_POST['spor_vlastni'];
  $spor_zam = $ucet_prispevek_platba == 'Ano' ? $_POST['spor_zam'] : 0;
  $spor_treti = $_POST['spor_treti'];
  echo "<INPUT type='hidden' name='spor_vlastni' value='$spor_vlastni'>";
  echo "<INPUT type='hidden' name='spor_zam' value='$spor_zam'>";
  echo "<INPUT type='hidden' name='spor_treti' value='$spor_treti'>";}
  
  elseif($_POST['typ_uctu'] == 'poj_penzijni'){
    $spor_vlastni = $ucet_prispevek_vlastni;
    $spor_zam = $ucet_prispevek_platba == 'Ano' ? $ucet_prispevek_zamestnavatel : 0;
    $spor_treti = $ucet_prispevek_tretiOsoba;
  echo "<INPUT type='hidden' name='spor_vlastni' value='$spor_vlastni'>";
  echo "<INPUT type='hidden' name='spor_zam' value='$spor_zam'>";
  echo "<INPUT type='hidden' name='spor_treti' value='$spor_treti'>";} ?>
  

<INPUT type='hidden' name='trans_ucet' value='<?php echo $trans_ucet = ($ucet_prispevek_platba == 'Ano') ? $_POST['trans_ucet'] : Null; ?>'>
<INPUT type='hidden' name='zalozeni_den' value='<?php echo $zalozeni_den = ($ucet_prispevek_platba == 'Ne') ? $_POST['ucet_zalozeni_den'] : Null; ?>'>
<INPUT type='hidden' name='zalozeni_mesic' value='<?php echo $zalozeni_mesic = $_POST['ucet_zalozeni_mesic']; ?>'>
<INPUT type='hidden' name='zalozeni_rok' value='<?php echo $zalozeni_rok = $_POST['ucet_zalozeni_rok']; ?>'>
<INPUT type='hidden' name='forma' value='<?php echo $forma = ($ucet_prispevek_platba == 'Ne') ? $_POST['prispevek_forma'] : Null; ?>'>
<INPUT type='hidden' name='cislo_smlouvy' value='<?php echo $cislo_smlouvy = $_POST['ucet_smlouva']; ?>'>
<INPUT type='hidden' name='varianta' value='<?php echo $varianta = $_POST['ucet_varianta']; ?>'>

<?php

}

//    KONTROLNI BODY
$check = array();
if($_POST['typ_uctu'] == 'sporici' || $_POST['typ_uctu'] == 'bezny' || $_POST['typ_uctu'] == 'kreditni'){
$check['min_zustatek1'] = !$min_zustatek && $min_zustatek != 0 ? 'Nezadany minimalni zustatek.<BR>' : Null;
$check['min_zustatek2'] = $min_zustatek < 0 ? 'Minimalni zustatek nesmi byt zaporne cislo.<BR>' : Null;
$check['urok1'] = !$urok && $urok != 0 ? 'Nezadana vyse uroku.<BR>' : Null;
$check['urok2'] = $urok < 0 ? 'Urok nesmi byt zaporne cislo.<BR>' : Null;
}
if($_POST['typ_uctu'] == 'sporici'){
$check['urok_ucet'] = $urok_prevod == 2 && !$urok_ucet ? 'Neni urceny ucet pro prebytecne prostredky.<BR>' : Null;
$check['urok_ucet'] = $urok_ucet && !in_array($urok_ucet, $_POST['trans_ucet']) ? 'Ucet urceny pro prebytecne prostredky neni zaroven uvedeny mezi transakcnimi ucty.<BR>' : Null;
$check['trans_ucet'] = in_array('zadne', $_POST['trans_ucet']) && Count($_POST['trans_ucet']) > 1 ? 'Neplatny zapis transakcnich uctu' : Null;
}


foreach ($check as $hodnota)
{
  echo $hodnota;
}
  if (implode("", ($check))!=Null)
  die ('<p>zopakovat zapis.'); 	
  


//    PRIPOJENI SQL
include "pripojeni_sql_man.php";

include "datumy.php";


if(($_POST['typ_uctu'] == 'poj_zivotni' || $_POST['typ_uctu'] == 'poj_penzijni') && $ucet_prispevek_platba == 'Ano')
{
$sql_detail_zdroje = "SELECT * FROM zdroje WHERE Nazev='$trans_ucet'";
$detail_zdroje = mysql_query($sql_detail_zdroje, $id_spojeni);
if (!$detail_zdroje)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodaøilo se nám poslat SQL dotaz na detail zdroje.');
} 
echo 'Dotaz na detail zdroje odeslan.<br>';

$radek_detail_zdroje = mysql_fetch_assoc($detail_zdroje); 

$zalozeni = "$zalozeni_rok-$zalozeni_mesic-".$radek_detail_zdroje['Den_vyplaty'];
$zalozeni = pracovni_den($zalozeni);
$zalozeni = Date('Y-m-d', $zalozeni);
echo "<INPUT type='hidden' name='zalozeni' value='$zalozeni'>";
}
elseif($_POST['typ_uctu'] == 'poj_zivotni' || $_POST['typ_uctu'] == 'poj_penzijni')
{
$zalozeni = "$zalozeni_rok-$zalozeni_mesic-$zalozeni_den";
$zalozeni = pracovni_den($zalozeni);
$zalozeni = Date('Y-m-d', $zalozeni);
echo "<INPUT type='hidden' name='zalozeni' value='$zalozeni'>";
}






//    DETEKCE ZMEN

$sql_aktual_ucet = "SELECT * FROM moje_ucty WHERE NazevUctu='$nazev_uctu'";
$aktual_ucet = mysql_query($sql_aktual_ucet, $id_spojeni);
if (!$aktual_ucet)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodaøilo se poslat SQL dotaz na aktualni ucet.');
} 
echo 'Dotaz na aktualni ucet odeslan.<br>';
$radek_aktual_ucet = mysql_fetch_array($aktual_ucet);

if($_POST['typ_uctu'] == 'bezny' || $_POST['typ_uctu'] == 'sporici'){
$sql_prebytek_novy_text = "SELECT CASE $urok_prevod WHEN 1 THEN 'Odecitat na budouci platby' WHEN 2 THEN 'Prevadet na sporici ucet' WHEN 3 THEN 'Nechavat na ucte' END";
                              $prebytek_novy_text = mysql_query($sql_prebytek_novy_text, $id_spojeni);
                              if (!$prebytek_novy_text)
                              {
                                echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
                                die('Nepodaøilo se nám poslat SQL dotaz na chovani prebytku.');
                              } 
                              echo 'Dotaz na nove chovani prebytku odeslan.<br>';
                              
                              $radek_prebytek_novy_text = mysql_result($prebytek_novy_text, 0);
                               
$sql_prebytek_akt_text = "SELECT CASE $radek_aktual_ucet[13] WHEN 1 THEN 'Odecitat na budouci platby' WHEN 2 THEN 'Prevadet na sporici ucet' WHEN 3 THEN 'Nechavat na ucte' END";
                              $prebytek_akt_text = mysql_query($sql_prebytek_akt_text, $id_spojeni);
                              if (!$prebytek_akt_text)
                              {
                                echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
                                die('Nepodaøilo se nám poslat SQL dotaz na chovani prebytku.');
                              } 
                              echo 'Dotaz na aktualni chovani prebytku odeslan.<br>';
                              
                              $radek_prebytek_akt_text = mysql_result($prebytek_akt_text, 0);                              
}
                             
$edit = array();
$edit['cislo_uctu1'] = ((($ucet_predcisli != $radek_aktual_ucet['Predcisli']) || $ucet_cislo != $radek_aktual_ucet['Cislo']) && $typ_uctu != 'kreditni') ? "<B>cislo uctu</B> z <U>".$radek_aktual_ucet['Predcisli']." - ".$radek_aktual_ucet['Cislo']." / $radek_aktual_ucet[5]</U> na <U>$ucet_predcisli - $ucet_cislo / $ucet_kod_banky</U><FONT color='red' size=3> - pozor, tato zmena bude nevratna !!!</FONT><BR>" : Null;
$edit['cislo_uctu2'] = ((($ucet_predcisli != $radek_aktual_ucet['Predcisli']) || $ucet_cislo != $radek_aktual_ucet['Cislo']) && $typ_uctu == 'kreditni') ? "<B>cislo uctu</B> z <U>".$radek_aktual_ucet['Predcisli']." - ".$radek_aktual_ucet['Cislo']." / $radek_aktual_ucet[5]</U> na <U>$ucet_predcisli - $ucet_cislo / $ucet_kod_banky</U><BR>" : Null;
//$edit['www'] = $ucet_www != $radek_aktual_ucet['Www'] ? "<B>Web adresa</B> z <U>".$radek_aktual_ucet['Www']."</U> na <U>$ucet_www</U><BR>" : Null;

if($_POST['typ_uctu'] == 'sporici' || $_POST['typ_uctu'] == 'bezny' || $_POST['typ_uctu'] == 'kreditni'){
$edit['min_zustatek'] = ($min_zustatek != $radek_aktual_ucet['MinZustatek']) ? "<B>minimalni zustatek</B> z <U>".$radek_aktual_ucet['MinZustatek']."</U> na <U>$min_zustatek</U><BR>" : Null;
//$edit['urok'] = ($urok != $radek_aktual_ucet['Urok']) ? "<B>Urok uctu</B> z <U>".$radek_aktual_ucet['Urok']."</U> na <U>$urok</U><BR>" : Null;
$edit['urok_prevod1'] = ($urok_prevod != $radek_aktual_ucet['Urok_prevod'] && $urok_prevod == 2) ? "<B>Nakladani s prebytkem</B> z <U>$radek_prebytek_akt_text</U> na <U>$radek_prebytek_novy_text - $urok_ucet</U><BR>" : Null;
$edit['urok_prevod2'] = ($urok_prevod != $radek_aktual_ucet['Urok_prevod'] && $urok_prevod != 2) ? "<B>Nakladani s prebytkem</B> z <U>$radek_prebytek_akt_text</U> na <U>$radek_prebytek_novy_text</U><BR>" : Null;
$edit['urok_ucet'] = ($urok_ucet != $radek_aktual_ucet['Urok_ucet'] && $urok_prevod == 2 && $edit['urok_prevod1'] == Null) ? "<B>Ucet pro prebytek</B> z <U>".$radek_aktual_ucet['Urok_ucet']."</U> na <U>$urok_ucet</U><BR>" : Null;
$edit['trans_ucet'] = ($trans_ucet != $radek_aktual_ucet['Trans_ucet']) ? "<B>Preddefinovane transakcni ucty</B> z <U>".$radek_aktual_ucet['Trans_ucet']."</U> na <U>$trans_ucet</U><BR>" : Null;
$edit['vypis'] = ($vypis != $radek_aktual_ucet['Vypis']) ? "<B>Vypis</B> z <U>".$radek_aktual_ucet['Vypis']."</U> na <U>$vypis</U><BR>" : Null;
  if($karta == 'Ano'){
$edit['karta'] = ($karta != $radek_aktual_ucet['Karta']) ? "<B>Debetni karta</B> z <U>".$radek_aktual_ucet['Karta']."</U> na <U>$karta</U>. Nazev karty <U>$karta_nazev</U>, cislo karty <U>$karta_cislo</U>, limit karty <U>$karta_limit</U>.<BR>" : Null;
$edit['karta_nazev'] = ($karta == $radek_aktual_ucet['Karta'] && $karta_nazev != $radek_aktual_ucet['Karta_nazev']) ? "<B>Nazev karty</B> z <U>".$radek_aktual_ucet['Karta_nazev']."</U> na <U>$karta_nazev</U><BR>" : Null;
$edit['karta_cislo'] = ($karta == $radek_aktual_ucet['Karta'] && $karta_cislo != $radek_aktual_ucet['Karta_cislo']) ? "<B>Cislo karty</B> z <U>".$radek_aktual_ucet['Karta_cislo']."</U> na <U>$karta_cislo</U><BR>" : Null;
$edit['karta_limit'] = ($karta == $radek_aktual_ucet['Karta'] && $karta_limit != $radek_aktual_ucet['Karta_limit']) ? "<B>Limit karty</B> z <U>".$radek_aktual_ucet['Karta_limit']."</U> na <U>$karta_limit</U><BR>" : Null;
  }
  else{
$edit['karta'] = ($karta != $radek_aktual_ucet['Karta']) ? "<B>Debetni karta</B> z <U>".$radek_aktual_ucet['Karta']."</U> na <U>$karta</U>.<BR>" : Null;  
  }


}
if($radek_aktual_ucet[1] == 'bezny'){
  if($kontokorent == 'Ano'){
$edit['kontokorent'] = ($kontokorent != $radek_aktual_ucet['Kontokorent']) ? "<B>Kontokorent</B> z <U>".$radek_aktual_ucet['Kontokorent']."</U> na <U>$kontokorent</U>. Limit $kontokorent_limit ".$radek_aktual_ucet['Mena'].".<BR>" : Null;
$edit['kontokorent_limit'] = ($kontokorent == $radek_aktual_ucet['Kontokorent'] && $kontokorent_limit != $radek_aktual_ucet['Kontokorent_limit']) ? "<B>Kontokorent limit</B> z <U>".$radek_aktual_ucet['Kontokorent_limit']."</U> na <U>$kontokorent_limit</U><BR>" : Null;  
  }
  else{
$edit['kontokorent'] = ($kontokorent != $radek_aktual_ucet['Kontokorent']) ? "<B>Kontokorent</B> z <U>".$radek_aktual_ucet['Kontokorent']."</U> na <U>$kontokorent</U><BR>" : Null;
  }
}

if($radek_aktual_ucet[1] == 'kreditni'){
//$edit['cislo_uctu1'] = ((!$radek_aktual_ucet[3] && $ucet_predcisli) || $ucet_cislo != $radek_aktual_ucet[4]) ? "<B>cislo uctu</B> z <U>$radek_aktual_ucet[4] / $radek_aktual_ucet[5]</U> na <U>$ucet_predcisli - $ucet_cislo / $ucet_kod_banky</U><BR>" : Null;

//$edit['cislo_uctu3'] = (!$ucet_predcisli && $radek_aktual_ucet[3]) || $ucet_cislo != $radek_aktual_ucet[4] ? "<B>cislo uctu</B> z <U>$radek_aktual_ucet[3] - $radek_aktual_ucet[4] / $radek_aktual_ucet[5]</U> na <U>$ucet_cislo / $ucet_kod_banky</U><BR>" : Null;
$edit['karta_bezurok'] = ($karta_bezurok != $radek_aktual_ucet['Karta_bezurok']) ? "<B>Bezurocne obdobi</B> z <U>".$radek_aktual_ucet['Karta_bezurok']."</U> na <U>$karta_bezurok</U><BR>" : Null;
}
If ($_POST['typ_uctu'] == 'poj_zivotni' || $_POST['typ_uctu'] == 'poj_penzijni')
{

$sql_detail_platby = "SELECT * FROM budouci_platby WHERE UcelTransakce='splatka pojisteni - ".$radek_aktual_ucet[2]."'";
$detail_platby = mysql_query($sql_detail_platby, $id_spojeni);
if (!$detail_platby)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodaøilo se nám poslat SQL dotaz na detail platby.');
} 
echo 'Dotaz na detail platby odeslan.<br>';

$radek_detail_platby = mysql_fetch_assoc($detail_platby);

$edit['prispevek_vlastni'] = ($ucet_prispevek_vlastni != $radek_aktual_ucet[25]) ? "<B>Vlastni celkovy prispevek</B> z <U>$radek_aktual_ucet[25]</U> na <U>$ucet_prispevek_vlastni</U><BR>" : Null;
$edit['prispevek_zam'] = ($ucet_prispevek_zamestnavatel != $radek_aktual_ucet[26]) ? "<B>Celkovy prispevek zamestnavatele</B> z <U>$radek_aktual_ucet[26]</U> na <U>$ucet_prispevek_zamestnavatel</U><BR>" : Null;
$edit['prispevek_treti'] = ($ucet_prispevek_tretiOsoba != $radek_aktual_ucet[27]) ? "<B>Celkovy prispevek treti osoby</B> z <U>$radek_aktual_ucet[27]</U> na <U>$ucet_prispevek_tretiOsoba</U><BR>" : Null;
$edit['spor_vlastni'] = ($spor_vlastni != $radek_aktual_ucet[31] && $_POST['typ_uctu'] == 'poj_zivotni') ? "<B>Vlastni prispevek na sporeni</B> z <U>$radek_aktual_ucet[31]</U> na <U>$spor_vlastni</U><BR>" : Null;
$edit['spor_zam'] = ($spor_zam != $radek_aktual_ucet[32] && $_POST['typ_uctu'] == 'poj_zivotni') ? "<B>Prispevek zamestnavatele na sporeni</B> z <U>$radek_aktual_ucet[32]</U> na <U>$spor_zam</U><BR>" : Null;
$edit['spor_treti'] = ($spor_treti != $radek_aktual_ucet[33] && $_POST['typ_uctu'] == 'poj_zivotni') ? "<B>Prispevek treti osoby na sporeni</B> z <U>$radek_aktual_ucet[33]</U> na <U>$spor_treti</U><BR>" : Null;
$edit['prispevek_frekvence'] = ($ucet_prispevek_frekvence != $radek_aktual_ucet[34]) ? "<B>Frekvence plateb</B> z <U>jednou za $radek_aktual_ucet[34] mesic(e)</U> na <U>jednou za $ucet_prispevek_frekvence mesic(e)</U><BR>" : Null;
$edit['cislo_smlouvy'] = ($cislo_smlouvy != $radek_aktual_ucet['Poj_cislo']) ? "<B>Cislo smlouvy</B> na <U>$cislo_smlouvy</U><FONT color='red' size=3> - pozor, tato zmena bude nevratna !!!</FONT><BR>" : Null;
  if($ucet_prispevek_platba == 'Ano'){
$edit['prispevek_platba'] = ($ucet_prispevek_platba != $radek_aktual_ucet[28]) ? "<B>Strhavani prispevku ze mzdy</B> z <U>$radek_aktual_ucet[28]</U> na <U>$ucet_prispevek_platba</U>. Strhavano od zamestnavatele <U>$trans_ucet</U>, prvni platba dne <U>$zalozeni</U>.<BR>" : Null;
$edit['trans_ucet'] = ($trans_ucet != $radek_aktual_ucet[21] && $ucet_prispevek_platba == $radek_aktual_ucet[28]) ? "<B>Strhavani od zamestnavatele</B> z <U>$radek_aktual_ucet[21]</U> na <U>$trans_ucet</U><BR>" : Null;
  }
  
  elseif($ucet_prispevek_platba == 'Ne'){

  SWITCH($forma)
{
  CASE 'TP':
    $forma_novy_text = 'Trvaly prikaz';
  break;
  
  CASE 'S':
    $forma_novy_text = 'Preddefinovana sablona';
  break;
  
  CASE 'JP':
    $forma_novy_text = 'Jednorazovy prikaz';
  break;
  
  CASE 'J':
    $forma_novy_text = 'Jiny prikaz';
  break;

  default:
    $forma_novy_text = 'Neznamy prikaz';
}




  SWITCH($radek_detail_platby['Forma'])
{
  CASE 'TP':
    $forma_akt_text = 'Trvaly prikaz';
  break;
  
  CASE 'S':
    $forma_akt_text = 'Preddefinovana sablona';
  break;
  
  CASE 'JP':
    $forma_akt_text = 'Jednorazovy prikaz';
  break;
  
  CASE 'J':
    $forma_akt_text = 'Jiny prikaz';
  break;

  default:
    $forma_akt_text = 'Neznamy prikaz';
}
  
$edit['prispevek_platba'] = ($ucet_prispevek_platba != $radek_aktual_ucet[28]) ? "<B>Strhavani prispevku ze mzdy</B> z <U>$radek_aktual_ucet[28]</U> na <U>$ucet_prispevek_platba</U>. Platby k $zalozeni_den. dni v mesici, forma - $forma_novy_text. Pocatecni platba dne <U>$zalozeni</U><BR>" : Null;
    if($ucet_prispevek_platba == $radek_aktual_ucet[28]){
$edit['zalozeni'] = ($zalozeni != $radek_detail_platby['Datum']) ? "<B>Nejblizsi platba</B> z <U>".$radek_detail_platby['Datum']."</U> na <U>$zalozeni</U><BR>" : Null;
$edit['platbakedni'] = ($zalozeni_den != $radek_detail_platby['PlatbaKeDni']) ? "<B>Platba ke dni</B> z <U>".$radek_detail_platby['PlatbaKeDni']."</U> na <U>$zalozeni_den</U><BR>" : Null;
$edit['forma'] = ($forma != $radek_detail_platby['Forma']) ? "<B>Forma platby</B> z <U>$forma_akt_text</U> na <U>$forma_novy_text</U><BR>" : Null;
  }

}
}

echo 'Prehled zmen:<P>';
foreach ($edit as $hodnota)
{
  echo $hodnota;
}
  if (implode("", ($edit))==Null)
  die ('<p>nebyla provedena zadna zmena.');








if($id_spojeni)
{
  mysql_close($id_spojeni);
  echo 'odpojeno<br>';
}

?>            

<P>
<input type=button onclick="history.back()" value="Zpìt"> 
<INPUT type='submit' name='next-edit_uctu' value='Potvrdit'>

</FORM>

</font></center>
</body>
</html>
