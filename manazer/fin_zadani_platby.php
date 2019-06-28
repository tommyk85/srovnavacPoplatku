<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Moje finance-nastaveni nove platby</title>
</head>
<body bgcolor="#FFFFFF" text="#000000">
<center><font face="Arial CE, Arial" size="5">

<?php

include "pripojeni_sql_man.php";

                                                                      
if ($_POST["typPlatby"] == 'tp' || $_POST["typPlatby"] == 'js'){                                                                      
$set = array();
$set["PlatbaKeDni"] = "'" . mysql_real_escape_string($_POST["platbaKeDni"]) . "'";
$set["UcelTransakce"] = "'" . mysql_real_escape_string($_POST["ucelTransakce"]) . "'";
$set["Prijemce"] = "'" . mysql_real_escape_string($_POST["prijemce"]) . "'";
$set["CelkovaCastka"] = "'" . mysql_real_escape_string($_POST["castka"]) . "'";
$set["FrekvencePlateb"] = "'" . mysql_real_escape_string($_POST["frekvence"]) . "'";
$set["TypPlatby"] = "'" . mysql_real_escape_string($_POST["typPlatby"]) . "'";
$set["DatumPristiPlatby"] = "'" . mysql_real_escape_string($_POST["datumPrvniPlatby"]) . "'";
$set["VarSymbol"] = "'" . mysql_real_escape_string($_POST["vs"]) . "'";
$set["SpecSymbol"] = "'" . mysql_real_escape_string($_POST["ss"]) . "'";
$set["KonstSymbol"] = "'" . mysql_real_escape_string($_POST["ks"]) . "'";
$set["PrijZprava"] = "'" . mysql_real_escape_string($_POST["zprava"]) . "'";
$set["UcetPrijemce"] = "'" . mysql_real_escape_string($_POST["prijemceUcetPredC"]."-".$_POST["prijemceUcetCislo"]."/".$_POST["prijemceBanka"]) . "'";
// a další spolu s případným ošetřením hodnot
$sql = "INSERT INTO pravidelne_platby (" . implode(", ", array_keys($set)) . ") VALUES (" . implode(", ", $set) . ")";


$id_vysledku = mysql_query($sql,$id_spojeni);
  if (!$id_vysledku)
  {
    echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
    die('Nepodařilo se nám poslat SQL dotaz do databáze.');
  } 
echo 'Dotaz na vložení byl poslán do databáze.<br>';

$sql = "SELECT * FROM pravidelne_platby ORDER BY idprav_platby DESC LIMIT 1";
$id_vysledku = mysql_query($sql,$id_spojeni);
  if (!$id_vysledku)
  {
    echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
    die('Nepodařilo se nám poslat SQL dotaz do databáze.');
  } 
echo 'Dotaz na zobrazení byl poslán do databáze.<br>';
}

else if ($_POST["typPlatby"] == 'jp') {
$set = array();
$set["platba_id"] = 0;
$set["platba_ucel"] = "'" . mysql_real_escape_string($_POST["ucelTransakce"]) . "'";
$set["platba_prijemce"] = "'" . mysql_real_escape_string($_POST["prijemce"]) . "'";
$set["platba_castka"] = "'" . mysql_real_escape_string($_POST["castka"]) . "'";
$set["platba_typ"] = "'" . mysql_real_escape_string($_POST["typPlatby"]) . "'";
$set["platba_datum"] = "get_work_date('" . mysql_real_escape_string($_POST["datumPrvniPlatby"].date('d',$_POST["platbaKeDni"])) . "')";
$set["platba_vs"] = "'" . mysql_real_escape_string($_POST["vs"]) . "'";
$set["platba_ss"] = "'" . mysql_real_escape_string($_POST["ss"]) . "'";
$set["platba_ks"] = "'" . mysql_real_escape_string($_POST["ks"]) . "'";
$set["platba_zprava"] = "'" . mysql_real_escape_string($_POST["zprava"]) . "'";
$set["platba_cil_ucet"] = "'" . mysql_real_escape_string($_POST["prijemceUcetPredC"]."-".$_POST["prijemceUcetCislo"]."/".$_POST["prijemceBanka"]) . "'";

// a další spolu s případným ošetřením hodnot
$sql = "INSERT INTO trans_historie (" . implode(", ", array_keys($set)) . ") VALUES (" . implode(", ", $set) . ")";

$id_vysledku = mysql_query($sql,$id_spojeni);
  if (!$id_vysledku)
  {
    echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
    die('Nepodařilo se nám poslat SQL dotaz do databáze.');
  } 
echo 'Dotaz na vložení byl poslán do databáze.<br>';

$sql = "SELECT platba_id,".$_POST["platbaKeDni"].", platba_ucel, platba_prijemce, platba_castka, 0, platba_typ, platba_datum, platba_vs, platba_ss, platba_ks, platba_zprava, 
platba_cil_ucet FROM trans_historie ORDER BY platba_zadano_datum DESC LIMIT 1";
$id_vysledku = mysql_query($sql,$id_spojeni);
  if (!$id_vysledku)
  {
    echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
    die('Nepodařilo se nám poslat SQL dotaz do databáze.');
  } 
echo 'Dotaz na zobrazení byl poslán do databáze.<br>';
}        	
     
     
else {
echo "neznamy typ platby!!";
}


echo '<table border=1>
<tr>
<th>Platba ke dni</th>
<th>Ucel</th>
<th>Prijemce</th>
<th>Castka</th>
<th>Frekvence</th>
<th>Typ platby</th>
<th>Datum první platby</th>
<th>VS</th>
<th>SS</th>
<th>KS</th>
<th>Zpráva pro příjemce</th>
<th>Číslo účtu příjemce</th>
</tr>';


while($radek = mysql_fetch_row($id_vysledku))
{
   echo '<TR>';
   
    for ($i=1; $i<=12; ++$i)
    {
     echo '<TD>', $radek[$i], '</TD>';
    }
   
   echo '</TR>';
} 

echo'</table>';


if($id_spojeni)
{
  mysql_close($id_spojeni);
  echo 'odpojeno<br />';
}
?>


<a href="/manazer">Na uvodni stranku.</A>

</font></center>
</body>
</html>
