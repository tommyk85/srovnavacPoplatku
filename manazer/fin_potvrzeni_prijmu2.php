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
  $set['Zdroj'] = 0;
  $set['Koment'] = "'" . mysql_real_escape_string($_POST['zdroj']) . "'";
  $set['Cisty_prijem'] = "'" . mysql_real_escape_string($_POST['prijem']) . "'";
  $set['Typ'] = "'1razovy'";
  $set['Ucet'] = "'" . mysql_real_escape_string($_POST['ucet']) . "'";


  $sql_ulozeni = "INSERT INTO prijem (" . implode(", ", array_keys($set)) . ") VALUES (" . implode(", ", $set) . ")";
  
  $id_vysledku = mysql_query($sql_ulozeni,$id_spojeni);
  if(!$id_vysledku)
  {
    echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
    die('Nepodaøilo se nám poslat SQL dotaz na vlozeni prijmu.');
  }
  
  
  Else
  {
  echo 'Prijem byl ulozen.<P>
  <a href="fin_prijem.php">Zadat novy prijem.</A><P>
  <a href="fin_platby.php">Na spravu plateb.</A><P>
  <a href="/manazer">Na uvodni stranku.</A><P>';
  }

$sql_stav_uctu = "SELECT Stav FROM moje_ucty WHERE idmoje_ucty = '".($_POST['ucet'])."'";
$stav_uctu = mysql_query($sql_stav_uctu, $id_spojeni);
if(!$stav_uctu)
  {
    echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
    die('Nepodaøilo se nám poslat SQL dotaz na stav uctu.');
  }
echo 'Dotaz na stav uctu byl odeslan.<BR>';

$radek_stav_uctu = mysql_result($stav_uctu, 0);

$navyseny_stav = $radek_stav_uctu + $_POST['prijem'];


$sql_navyseni_uctu = "UPDATE moje_ucty SET
  Stav = '$navyseny_stav'
  
  WHERE idmoje_ucty = '".$_POST['ucet']."'";
  
$navyseni_uctu = mysql_query($sql_navyseni_uctu, $id_spojeni);
if(!$navyseni_uctu)
  {
    echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
    die('Nepodaøilo se nám poslat SQL dotaz na navyseni zustatku uctu.');
  }
echo 'Stav uctu byl navysen.<BR>';





if($id_spojeni)
{
  mysql_close($id_spojeni);
  echo 'odpojeno<br>';
}

?>            






</font></center>
</body>
</html>
