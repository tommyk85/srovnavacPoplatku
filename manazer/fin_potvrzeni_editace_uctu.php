<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1250">
<title>Moje finance-nastaveni noveho uctu</title>
</head>
<body bgcolor="#FFFFFF" text="#000000">
<center><font face="Arial CE, Arial" size="4">



<?php


If (!isset($_POST['next-edit_uctu']) || $_POST['next-edit_uctu'] != 'Potvrdit') 
die ('Neplatny pokus.');

date_default_timezone_set('Europe/Prague');

if($_POST['typ_uctu'] == 'sporici' || $_POST['typ_uctu'] == 'bezny' || $_POST['typ_uctu'] == 'kreditni'){


//     DEFINICE PROMENNYCH
$min_zustatek = $_POST['min_zustatek'];
$urok = $_POST['urok'];
$nazev_uctu = $_POST['nazev_uctu'];
$urok_prevod = $_POST['urok_prevod'];
$urok_ucet = $_POST['urok_ucet'];
$karta = $_POST['karta'];
$karta_nazev = $_POST['karta_nazev'];
$karta_cislo = $_POST['karta_cislo'];
$karta_limit = $_POST['karta_limit'];
$karta_bezurok = $_POST['karta_bezurok'];
$vypis = $_POST['vypis'];
$kontokorent = $_POST['kontokorent'];
$kontokorent_limit = $_POST['kontokorent_limit'];
$trans_ucet = $_POST['trans_ucet'];
$min_splatka = $_POST['min_splatka'];
$ucet_predcisli = $_POST['ucet_predcisli'];
$ucet_cislo = $_POST['ucet_cislo'];
$ucet_www = $_POST['ucet_www'];


//    KONTROLNI BODY
$check = array();
$check['urok_prevod1'] = ($urok_prevod == 2 && $urok_ucet == Null) ? 'nevybran ucet pro prevod prebytku.' : Null;


foreach ($check as $hodnota)
{
  echo $hodnota;
}
  if (implode("", ($check))!=Null)
  die ('<p>zopakovat zapis.'); 	
  


//    PRIPOJENI SQL
include "pripojeni_sql.php";


//    HLAVNI CAST

  $sql_zmeny = "UPDATE moje_ucty SET 
  MinZustatek = '$min_zustatek', 
  Urok = '$urok', 
  Urok_prevod = '$urok_prevod',
  Urok_ucet = '$urok_ucet', 
  Karta = '$karta',
  Karta_nazev = '$karta_nazev',
  Karta_cislo = '$karta_cislo',
  Karta_limit = '$karta_limit',
  Kontokorent = '$kontokorent',
  Kontokorent_limit = '$kontokorent_limit',
  Vypis = '$vypis',
  Trans_ucet = '$trans_ucet',
  Mesicni_splatka = '$min_splatka',
  Predcisli = '$ucet_predcisli',
  Cislo = '$ucet_cislo',
  Karta_bezurok = '$karta_bezurok',
  Www = '$ucet_www'     
  
  WHERE NazevUctu='$nazev_uctu'";
  
  
  $id_vysledku = mysql_query($sql_zmeny,$id_spojeni);
  if (!$id_vysledku)
  {
    echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
    die('Nepodařilo se poslat SQL dotaz na zmenu uctu.');
  }  
  
echo '<p>zmeny uctu byly ulozeny.<P>'; 
   
}


            

If ($_POST['typ_uctu'] == 'poj_zivotni' || $_POST['typ_uctu'] == 'poj_penzijni')
{
 
//     DEFINICE PROMENNYCH
$nazev_uctu = $_POST['nazev_uctu'];
$ucet_predcisli = $_POST['ucet_predcisli'];
$ucet_cislo = $_POST['ucet_cislo'];
$ucet_prispevek_vlastni = $_POST['ucet_prispevek_vlastni'];
$ucet_prispevek_zamestnavatel = $_POST['ucet_prispevek_zamestnavatel'];
$ucet_prispevek_tretiOsoba = $_POST['ucet_prispevek_tretiOsoba'];
$ucet_prispevek_platba = $_POST['ucet_prispevek_platba'];
$spor_vlastni = $_POST['spor_vlastni'];
$spor_zam = $_POST['spor_zam'];
$spor_treti = $_POST['spor_treti'];
$trans_ucet = $_POST['trans_ucet'];
$ucet_www = $_POST['ucet_www'];
$zalozeni = $_POST['zalozeni'];
$frekvence = $_POST['ucet_prispevek_frekvence'];
$forma = $_POST['forma'];
$zalozeni_den = $_POST['zalozeni_den'];
$varianta = $_POST['varianta'];
$cislo_smlouvy = $_POST['cislo_smlouvy'];

//    KONTROLNI BODY
$check = array();
$check['prispevek_vlastni'] = ($ucet_prispevek_vlastni == Null) ? 'vlastni prispevek nebyl vyplnen.' : Null;


foreach ($check as $hodnota)
{
  echo $hodnota;
}
  if (implode("", ($check))!=Null)
  die ('<p>zopakovat zapis.'); 	
  


//    PRIPOJENI SQL
include "pripojeni_sql.php";


//    HLAVNI CAST

  $sql_zmeny = "UPDATE moje_ucty SET 
  Prispevek_vlastni = '$ucet_prispevek_vlastni',
  Prispevek_zam = '$ucet_prispevek_zamestnavatel',
  Prispevek_treti = '$ucet_prispevek_tretiOsoba',
  Prispevek_platba = '$ucet_prispevek_platba',
  Spor_vlastni = '$spor_vlastni',
  Spor_zam = '$spor_zam',
  Spor_treti = '$spor_treti',  
  Predcisli = '$ucet_predcisli',
  Cislo = '$ucet_cislo',
  Trans_ucet = '$trans_ucet',
  Www = '$ucet_www',
  Zalozeni = '$zalozeni',
  Prispevek_frekvence = '$frekvence',
  Poj_cislo = '$cislo_smlouvy'
  
  WHERE NazevUctu='$nazev_uctu'";
  
  
  $id_vysledku = mysql_query($sql_zmeny,$id_spojeni);
  if (!$id_vysledku)
  {
    echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
    die('Nepodařilo se poslat SQL dotaz na zmenu uctu.');
  }  
  
echo '<p>zmeny uctu byly ulozeny.<P>'; 



$sql_akt_platba = "SELECT * FROM budouci_platby WHERE UcelTransakce='splatka pojisteni - $nazev_uctu'";
$akt_platba = mysql_query($sql_akt_platba, $id_spojeni);
  if (!$akt_platba)
  {
    echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
    die('Nepodařilo se poslat SQL dotaz na aktualni platbu.');
  }  
echo '<p>Dotaz na aktualni platbu byl odeslan.<P>'; 



if(mysql_num_rows($akt_platba) > 0 && $ucet_prispevek_platba == 'Ano')
{
  $sql_smazani = "DELETE FROM budouci_platby WHERE UcelTransakce='splatka pojisteni - $nazev_uctu'";
  
  $smazani = mysql_query($sql_smazani,$id_spojeni);
  if (!$id_vysledku)
  {
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodařilo se nám poslat SQL dotaz na zruseni platby.');
  }
  
echo '<p>platba zrusena.<BR>'; 
}


elseif(mysql_num_rows($akt_platba) == 0 && $ucet_prispevek_platba == 'Ne')
{
$set = array();
$set['PlatbaKeDni'] = "'$zalozeni_den'";
$set['Forma'] = "'$forma'";
$set['Datum'] = "'$zalozeni'";
$set['CelkovaCastka'] = "'$ucet_prispevek_vlastni'";
$set['Prijemce'] = "'$varianta'";
$set['UcelTransakce'] = "'splatka pojisteni - $nazev_uctu'";
  
  $sql_ulozeni = "INSERT INTO budouci_platby (" . implode(", ", array_keys($set)) . ") VALUES (" . implode(", ", $set) . ")";
  
  $ulozeni = mysql_query($sql_ulozeni,$id_spojeni);
  if (!$ulozeni)
  {
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodařilo se nám poslat SQL dotaz na ulozeni nove platby.');
  }
  
echo '<p>nova platba zaregistrovana.<BR>'; 
}


elseif(mysql_num_rows($akt_platba) > 0 && $ucet_prispevek_platba == 'Ne')
{
  $sql_zmeny_platby = "UPDATE budouci_platby SET 
  PlatbaKeDni = '$zalozeni_den',
  Forma = '$forma',
  Datum = '$zalozeni'
  
  WHERE UcelTransakce='splatka pojisteni - $nazev_uctu'";
  
  
  $zmeny_platby = mysql_query($sql_zmeny_platby,$id_spojeni);
  if (!$zmeny_platby)
  {
    echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
    die('Nepodařilo se poslat SQL dotaz na zmenu platby.');
  }  
  
echo '<p>zmeny platby byly ulozeny.<BR>'; 
}
   
}




if($_POST['typ_uctu'] == 'jiny'){


//     DEFINICE PROMENNYCH

$nazev_uctu = $_POST['nazev_uctu'];
$ucet_predcisli = $_POST['ucet_predcisli'];
$ucet_cislo = $_POST['ucet_cislo'];
$ucet_www = $_POST['ucet_www'];


//    KONTROLNI BODY
$check = array();
$check['ucet_cislo'] = (!$ucet_cislo && $ucet_predcisli) ? 'vypleneno pouze predcisli, musi byt i samotne cislo.' : Null;


foreach ($check as $hodnota)
{
  echo $hodnota;
}
  if (implode("", ($check))!=Null)
  die ('<p>zopakovat zapis.'); 	
  


//    PRIPOJENI SQL
include "pripojeni_sql.php";


//    HLAVNI CAST

  $sql_zmeny = "UPDATE moje_ucty SET 
  Predcisli = '$ucet_predcisli',
  Cislo = '$ucet_cislo',
  Www = '$ucet_www'    
  
  WHERE NazevUctu='$nazev_uctu'";
  
  
  $id_vysledku = mysql_query($sql_zmeny,$id_spojeni);
  if (!$id_vysledku)
  {
    echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
    die('Nepodařilo se poslat SQL dotaz na zmenu uctu.');
  }  
  
echo "<p>zmeny uctu byly ulozeny.<P>"; 
      
}

echo "<a href='fin_ucty.php'>Na prehled uctu.</A><P>";

if($id_spojeni)
{
  mysql_close($id_spojeni);
  echo 'odpojeno<br>';
}

?>




</font></center>
</body>
</html>
