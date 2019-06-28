<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Moje finance-nastaveni noveho uctu</title>
</head>
<body bgcolor="#FFFFFF" text="#000000">
<center><font face="Arial CE, Arial" size="4">



<?php


If (!isset($_POST['next-edit_zdroje']) || $_POST['next-edit_zdroje'] != 'Potvrdit') 
die ('Neplatny pokus.');


//     DEFINICE PROMENNYCH
$nazev = $_POST['nazev'];
$den = $_POST['den'];
$mzda = $_POST['mzda'];
$ucet = $_POST['ucet'];
$prefer = ($_POST['typ'] == 'aktivni') ? $_POST['prefer'] : 0;
$platce = ($_POST['typ'] == 'pasivni') ? $_POST['platce'] : Null;



//    KONTROLNI BODY
/*$check = array();
$check['urok_prevod1'] = ($urok_prevod == 2 && $urok_ucet == Null) ? 'nevybran ucet pro prevod prebytku.' : Null;


foreach ($check as $hodnota)
{
  echo $hodnota;
}
  if (implode("", ($check))!=Null)
  die ('<p>zopakovat zapis.'); 	
*/  


//    PRIPOJENI SQL
include "pripojeni_sql_man.php";


//    HLAVNI CAST

if($_POST['typ'] == 'aktivni' && $prefer == 1)
{
$sql_priprava = "UPDATE zdroje SET
  Preferovany = 0";

$id_priprava = mysql_query($sql_priprava, $id_spojeni);
if(!$id_priprava)
  {
    echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
    die('Nepodařilo se poslat SQL dotaz na update preference.');
  } 
}


  $sql_zmeny = "UPDATE zdroje SET 
  Den_vyplaty = '$den', 
  Mzda = '$mzda', 
  Ucet = '$ucet',
  Pas_platce = '$platce',
  Preferovany = '$prefer'   
  
  WHERE Nazev='$nazev'";
  
  
  $id_vysledku = mysql_query($sql_zmeny,$id_spojeni);
  if (!$id_vysledku)
  {
    echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
    die('Nepodařilo se poslat SQL dotaz na zmenu zdroje.');
  }  
  
echo "<p>zmeny zdroje <B>$nazev</B> byly ulozeny.<BR>"; 



echo "<a href='fin_zdroje.php'>Na prehled zdroju.</A><P>";

if($id_spojeni)
{
  mysql_close($id_spojeni);
  echo 'odpojeno<br>';
}

?>




</font></center>
</body>
</html>
