<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Moje finance-nastaveni noveho uctu</title>
</head>
<body bgcolor="#FFFFFF" text="#000000">
<center><font face="Arial CE, Arial" size="4">



<?php

If (!isset($_POST['next-potvrzeni_zdroje']) || $_POST['next-potvrzeni_zdroje'] != 'Pokracuj') 
die ('Neplatny pokus.');

include "pripojeni_sql_man.php";


  $set = array();
  $set['Nazev'] = "'" . mysql_real_escape_string($_POST['nazev']) . "'";
  $set['Den_vyplaty'] = "'" . mysql_real_escape_string($_POST['den']) . "'";
  $set['Mena'] = "'" . mysql_real_escape_string($_POST['mena']) . "'";
  $set['Typ'] = "'" . mysql_real_escape_string($_POST['typ']) . "'";
  $set['Ucet'] = "'" . mysql_real_escape_string($_POST['ucet']) . "'";
  $set['Mzda'] = "'" . mysql_real_escape_string($_POST['mzda']) . "'";
If ($_POST['typ'] == 'aktivni')
{
  $set['Preferovany'] = "'" . mysql_real_escape_string($_POST['prefer']) . "'";
}  
If ($_POST['typ'] == 'pasivni')
{
  $set['Pas_platce'] = "'" . mysql_real_escape_string($_POST['platce']) . "'";
  $set['Pas_varianta'] = "'" . mysql_real_escape_string($_POST['varianta']) . "'";
}  

  $sql_ulozeni = "INSERT INTO zdroje (" . implode(", ", array_keys($set)) . ") VALUES (" . implode(", ", $set) . ")";
  
  $id_vysledku = mysql_query($sql_ulozeni,$id_spojeni);
  if(!$id_vysledku)
  {
    if(mysql_errno($id_spojeni) == '1062')
    {
    echo('Zdroj s nazvem '.$_POST["nazev"].' jiz existuje.<br>');
    echo('<input type=button onclick="history.back()" value="Zpìt"><br>');
    }
    
    ElseIf(mysql_errno($id_spojeni) <> '1062')
    {
    echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
    die('Nepodařilo se nám poslat SQL dotaz na vlozeni zdroje.');
    }
  }  
  
  Else
  {
  echo 'Novy zdroj <B>'.$_POST['nazev'].'</B> byl ulozen.<P>
  <a href="fin_zdroje.php">Na prehled zdroju.</A><P>';
  }
  
If($_POST['typ'] == 'aktivni' && $_POST['prefer'] == 1)
{
$sql_prefer = "UPDATE zdroje SET
  Preferovany = 0
  WHERE Nazev != '".$_POST['nazev']."'";
$vysledek = mysql_query($sql_prefer, $id_spojeni);
if(!$vysledek)
  {
    echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
    die('Nepodařilo se nám poslat SQL dotaz na update preference.');
  }
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
