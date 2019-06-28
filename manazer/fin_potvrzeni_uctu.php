<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Moje finance-nastaveni noveho uctu</title>
</head>
<body bgcolor="#FFFFFF" text="#000000">
<center><font face="Arial CE, Arial" size="4">



<?php

If (!isset($_POST['next-potvrzeni_uctu']) || $_POST['next-potvrzeni_uctu'] != 'Pokracuj') 
die ('Neplatny pokus.');

include "pripojeni_sql_man.php";

//echo "ucet: ".$_POST['spor_ucet'];

date_default_timezone_set('Europe/Prague');

  $set = array();
//  $set['ID'] = 'Null';
  $set['Vytvoreno'] = "'" . mysql_real_escape_string(Date("Y-m-j H:i.s", Time())) . "'";
  $set['TypUctu'] = "'" . mysql_real_escape_string($_POST['typUctu']) . "'";
  $set['NazevUctu'] = "'" . mysql_real_escape_string($_POST['nazevUctu']) . "'";
  $set['Predcisli'] = "'" . mysql_real_escape_string($_POST['predcisli']) . "'";
  $set['Cislo'] = "'" . mysql_real_escape_string($_POST['cislo']) . "'";
  $set['KodBanky'] = "'" . mysql_real_escape_string($_POST['kodBanky']) . "'";
//  $set['NazevBanky'] = "'" . mysql_real_escape_string($_POST['nazevBanky']) . "'";
  $set['Ucet_varianta'] = "'" . mysql_real_escape_string($_POST['ucet_varianta']) . "'";
  $set['Mena'] = "'" . mysql_real_escape_string($_POST['mena']) . "'";
  $set['Stav'] = "'" . mysql_real_escape_string($_POST['stav']) . "'";
  $set['Vypis'] = "'" . mysql_real_escape_string($_POST['vypis']) . "'";
  $set['Www'] = "'" . mysql_real_escape_string($_POST['www']) . "'";
  
if($_POST['typUctu'] == 'sporici' || $_POST['typUctu'] == 'bezny' || $_POST['typUctu'] == 'kreditni'){ 
  $set['Zalozeni'] = "'" . mysql_real_escape_string($_POST['zalozeni']) . "'";
  $set['MinZustatek'] = "'" . mysql_real_escape_string($_POST['minZustatek']) . "'";
  $set['Urok'] = "'" . mysql_real_escape_string($_POST['urok']) . "'";
  $set['Karta'] = "'" . mysql_real_escape_string($_POST['karta']) . "'";
  $set['Karta_nazev'] = "'" . mysql_real_escape_string($_POST['karta_nazev']) . "'";
  $set['Karta_cislo'] = "'" . mysql_real_escape_string($_POST['karta_cislo']) . "'";
  $set['Karta_limit'] = "'" . mysql_real_escape_string($_POST['karta_limit']) . "'";
  }
if($_POST['typUctu'] == 'bezny'){                                                   
  $set['Urok_prevod'] = "'" . mysql_real_escape_string($_POST['urok_prevod']) . "'";
  $set['Kontokorent'] = "'" . mysql_real_escape_string($_POST['kontokorent']) . "'";
  $set['Kontokorent_limit'] = "'" . mysql_real_escape_string($_POST['kontokorent_limit']) . "'";
  $set['Urok_ucet'] = "'" . mysql_real_escape_string($_POST['spor_ucet']) . "'";      
  }
if($_POST['typUctu'] == 'sporici'){
  $set['Urok_prevod'] = "'" . mysql_real_escape_string($_POST['urok_prevod']) . "'";
  $set['Trans_ucet'] = "'" . mysql_real_escape_string($_POST['trans_ucet']) . "'";
  $set['Urok_ucet'] = "'" . mysql_real_escape_string($_POST['spor_ucet']) . "'";
  }
if($_POST['typUctu'] == 'kreditni'){
  $set['Mesicni_splatka'] = "'" . mysql_real_escape_string($_POST['min_splatka']) . "'";
  $set['Karta_bezurok'] = "'" . mysql_real_escape_string($_POST['karta_bezurok']) . "'";
  }
if($_POST['typUctu'] == 'poj_zivotni' || $_POST['typUctu'] == 'poj_penzijni'){
  $set['Prispevek_vlastni'] = "'" . mysql_real_escape_string($_POST['prispevekVlastni']) . "'";
  $set['Prispevek_zam'] = "'" . mysql_real_escape_string($_POST['prispevekZam']) . "'";
  $set['Prispevek_treti'] = "'" . mysql_real_escape_string($_POST['prispevekTreti']) . "'";
  $set['Prispevek_platba'] = "'" . mysql_real_escape_string($_POST['prispevekPlatba']) . "'";
  $set['Spor_vlastni'] = "'" . mysql_real_escape_string($_POST['spor_vlastni']) . "'";
  $set['Spor_zam'] = "'" . mysql_real_escape_string($_POST['spor_zam']) . "'";
  $set['Spor_treti'] = "'" . mysql_real_escape_string($_POST['spor_treti']) . "'";
  $set['Zalozeni'] = "'" . mysql_real_escape_string($_POST['zalozeni']) . "'";
  $set['Trans_ucet'] = "'" . mysql_real_escape_string($_POST['trans_ucet']) . "'";
  $set['Prispevek_frekvence'] = "'" . mysql_real_escape_string($_POST['frekvence']) . "'";
  $set['Poj_cislo'] = "'" . mysql_real_escape_string($_POST['cislo_smlouvy']) . "'";
}

  
  $sql_ulozeni = "INSERT INTO moje_ucty (" . implode(", ", array_keys($set)) . ") VALUES (" . implode(", ", $set) . ")";
  
  $id_vysledku = mysql_query($sql_ulozeni,$id_spojeni);
  if (!$id_vysledku)
  {
    if(mysql_errno($id_spojeni) == '1062')
    {
    echo('Ucet s nazvem '.$_POST["nazevUctu"].' jiz existuje.<br>');
    }
    
    ElseIf(mysql_errno($id_spojeni) <> '1062')
    {
    echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
    die('Nepodaøilo se nám poslat SQL dotaz na ulozeni uctu.');
    }
  }  
  
  Else
  {
  echo 'Novy ucet <B>'.$_POST['nazevUctu'].'</B> byl ulozen.<P>
  <a href="fin_ucty.php">Na prehled uctu.</A><P>';
  }




if(($_POST['typUctu'] == 'poj_zivotni' || $_POST['typUctu'] == 'poj_penzijni') && $_POST['prispevekPlatba'] == 'Ne')
{
$set_platba = array();
$set_platba['PlatbaKeDni'] = "'" . mysql_real_escape_string($_POST['platba_den']) . "'";
$set_platba['CelkovaCastka'] = "'" . mysql_real_escape_string($_POST['prispevekVlastni']) . "'";
$set_platba['Prijemce'] = "'" . mysql_real_escape_string($_POST['ucet_varianta']) . "'";
$set_platba['UcelTransakce'] = "'splatka pojisteni - " . mysql_real_escape_string($_POST['nazevUctu']) . "'";
$set_platba['Datum'] = "'" . mysql_real_escape_string($_POST['zalozeni']) . "'";
$set_platba['Forma'] = "'" . mysql_real_escape_string($_POST['forma']) . "'";



  
$sql_ulozeni_platby = "INSERT INTO budouci_platby (" . implode(", ", array_keys($set_platba)) . ") VALUES (" . implode(", ", $set_platba) . ")";
  
  $ulozeni_platby = mysql_query($sql_ulozeni_platby,$id_spojeni);
  if (!$ulozeni_platby)
  {
    echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
    die('Nepodaøilo se nám poslat SQL dotaz na ulozeni platby.');
  }  
echo 'Nova platba byla zaregistrovana.<P>
<a href="fin_platby.php">Na prehled budoucich plateb.</A><P>';
  


}


if($id_spojeni)
{
  mysql_close($id_spojeni);
  echo 'odpojeno<br>';
}

?>            






</font></center>
</body>
</html>
