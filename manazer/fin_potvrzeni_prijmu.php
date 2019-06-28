<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Moje finance-nastaveni noveho uctu</title>
</head>
<body bgcolor="#FFFFFF" text="#000000">
<center><font face="Arial CE, Arial" size="4">



<?php

If (!isset($_POST['next-potvrzeni_prijmu']) || $_POST['next-potvrzeni_prijmu'] != 'Potvrdit') 
die ('Neplatny pokus.');

include "pripojeni_sql_man.php";

date_default_timezone_set('Europe/Prague');

  $set = array();
  $set['Vlozeno'] = "'" . mysql_real_escape_string(Date("Y-m-j H:i.s", Time())) . "'";
  $set['Datum'] = "'" . mysql_real_escape_string($_POST['datum']) . "'";
  $set['Zdroj'] = "'" . mysql_real_escape_string($_POST['nazev']) . "'";
  $set['Cisty_prijem'] = "'" . mysql_real_escape_string($_POST['cisty_prijem']) . "'";
  $set['Typ'] = "'" . mysql_real_escape_string($_POST['typ']) . "'";
  $set['Ucet'] = "'" . mysql_real_escape_string($_POST['ucet']) . "'";
If ($_POST['typ'] == 'aktivni')
{
  $set['Srazka1'] = "'" . mysql_real_escape_string($_POST['srazka1']) . "'";
  $set['Srazka2'] = "'" . mysql_real_escape_string($_POST['srazka2']) . "'";
  $set['Srazka3'] = "'" . mysql_real_escape_string($_POST['srazka3']) . "'";
  $set['Srazka4'] = "'" . mysql_real_escape_string($_POST['srazka4']) . "'";
  $set['Srazka5'] = "'" . mysql_real_escape_string($_POST['srazka5']) . "'";
}  
 

  $sql_ulozeni = "INSERT INTO prijem (" . implode(", ", array_keys($set)) . ") VALUES (" . implode(", ", $set) . ")";
  
  $id_vysledku = mysql_query($sql_ulozeni,$id_spojeni);
  if(!$id_vysledku)
  {
    echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
    die('Nepodarilo se nám poslat SQL dotaz na vlozeni prijmu.');
  }
  
  
  Else
  {
  echo 'Prijem od <B>'.$_POST['nazev'].'</B> byl ulozen.<P>
  <a href="fin_prijem.php">Zadat novy prijem.</A><P>
  <a href="fin_platby.php">Na spravu plateb.</A><P>
  <a href="/manazer">Na uvodni stranku.</A><P>';
  }

$sql_stav_uctu = "SELECT Stav FROM moje_ucty WHERE NazevUctu = '".($_POST['ucet'])."'";
$stav_uctu = mysql_query($sql_stav_uctu, $id_spojeni);
if(!$stav_uctu)
  {
    echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
    die('Nepodarilo se nám poslat SQL dotaz na stav uctu.');
  }
echo 'Dotaz na stav uctu byl odeslan.<BR>';

$radek_stav_uctu = mysql_result($stav_uctu, 0);

$navyseny_stav = $radek_stav_uctu + $_POST['cisty_prijem'];


$sql_navyseni_uctu = "UPDATE moje_ucty SET
  Stav = '$navyseny_stav'
  
  WHERE idmoje_ucty = '".$_POST['ucet']."'";
  
$navyseni_uctu = mysql_query($sql_navyseni_uctu, $id_spojeni);
if(!$navyseni_uctu)
  {
    echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
    die('Nepodarilo se nám poslat SQL dotaz na navyseni zustatku uctu.');
  }
echo 'Stav uctu byl navysen.<BR>';





//echo $_POST['srazka_poj1'].", ".$_POST['srazka_poj2'];


$srazka_poj = array();
if(isset($_POST['srazka_poj1']))
$srazka_poj['1'] = "'".$_POST['srazka_poj1']."'";

if(isset($_POST['srazka_poj2']))
$srazka_poj['2'] = "'".$_POST['srazka_poj2']."'";

//$dalsi_datum = $_POST['dalsi_datum'];

//echo $_POST['spor_poj1']." tady";

//echo implode(',', $srazka_poj);

$sql_stav_pojisteni = "SELECT Stav, Mena, Zalozeni FROM moje_ucty WHERE NazevUctu in(".implode(',', $srazka_poj).")";
$stav_pojisteni = mysql_query($sql_stav_pojisteni, $id_spojeni);
if(!$stav_pojisteni)
  {
    echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
    die('Nepodarilo se nám poslat SQL dotaz na stav pojisteni.');
  }
echo 'Dotaz na stav pojisteni byl odeslan.<BR>';

//echo mysql_num_rows($stav_pojisteni);
if(mysql_num_rows($stav_pojisteni)>0)
{
$stav_poj1 = mysql_result($stav_pojisteni,0,0);
$mena_poj1 = mysql_result($stav_pojisteni,0,1);
$navyseni_poj1 = $stav_poj1 + $_POST['spor_poj1'];
$sql_navyseni_pojisteni1 = "UPDATE moje_ucty SET
  Stav = '$navyseni_poj1',
  Zalozeni = '".$_POST['dalsi_datum1']."'
  
  WHERE NazevUctu = '".$_POST['srazka_poj1']."'";
  
$navyseni_pojisteni1 = mysql_query($sql_navyseni_pojisteni1, $id_spojeni);
if(!$navyseni_pojisteni1)
  {
    echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
    die('Nepodarilo se nám poslat SQL dotaz na navyseni pojisteni 1.');
  }
echo "Pojisteni <U>".$_POST['srazka_poj1']."</U> navyseno o <U>".$_POST['spor_poj1']." $mena_poj1</U> <FONT size=2 color='gray'>(aktualne celkem $navyseni_poj1 $mena_poj1)</FONT><BR>";
}




if(mysql_num_rows($stav_pojisteni)>1)
{
$stav_poj2 = mysql_result($stav_pojisteni,1,0);
$mena_poj2 = mysql_result($stav_pojisteni,1,1);
$navyseni_poj2 = $stav_poj2 + $_POST['spor_poj2'];
$sql_navyseni_pojisteni2 = "UPDATE moje_ucty SET
  Stav = '$navyseni_poj2',
  Zalozeni = '".$_POST['dalsi_datum2']."'
  
  WHERE NazevUctu = '".$_POST['srazka_poj2']."'";
  
$navyseni_pojisteni2 = mysql_query($sql_navyseni_pojisteni2, $id_spojeni);
if(!$navyseni_pojisteni2)
  {
    echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
    die('Nepodarilo se nám poslat SQL dotaz na navyseni pojisteni 2.');
  }
echo "Pojisteni <U>".$_POST['srazka_poj2']."</U> navyseno o <U>".$_POST['spor_poj2']." $mena_poj2</U> <FONT size=2 color='gray'>(aktualne celkem $navyseni_poj2 $mena_poj2)</FONT><BR>";
}

//echo $_POST['spor_poj1'];






//  implode(',', $_POST['spor_poj']) + implode(',', $stav_pojisteni);

//echo $navyseni_poj; 



/*$sql_navyseni_pojisteni1 = "UPDATE moje_ucty SET
  Stav = "
  */




if($id_spojeni)
{
  mysql_close($id_spojeni);
  echo 'odpojeno<br>';
}

?>            






</font></center>
</body>
</html>
