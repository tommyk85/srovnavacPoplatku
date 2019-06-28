<html>
<head>
<meta charset="utf-8">

<LINK rel="shortcut icon" href="..\..\favicon.ico" type="image/x-icon" />
<LINK rel="stylesheet" type="text/css" href="..\..\styly.css">
<title>Srovnávač poplatků bank</title>
</head>
<body bgcolor="#FFFFFF" text="#000000">
<?php 
if(!isset($_POST['ukaz_detail']))
die("nepovolený přístup");

include_once("analyticstracking.php"); 
include "../../pripojeni_sql.php"; 

function vystup_sql($_sql)
{
global $id_spojeni;
$query = mysql_query($_sql, $id_spojeni);
  if (!$query)
  {
    //echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
    die("<span style='color:red; font-weight:bold'>Něco se nepovedlo. Jdi zpět a zkontroluj, jestli jsou údaje správně zapsané nebo nějaké nechybí. Pokud je vše zapsané v pořádku a problém přetrvává, pošli mi tyto 2 řádky:</span>
    <p style='color:red'>".mysql_errno($id_spojeni).': '.mysql_error($id_spojeni)."<BR><i>$_sql</U></i>");
  }
return $query;
}

function cena($_cislo)
{
return number_format($_cislo, 2, '.', '');
}


$id = $_POST['cena_id'];
?>

<H1><?php echo $_POST['ucet']." <span style='font-size:medium'>(".$_POST['banka'].")</span>"; ?></H1>
<H2>Účet</H2>
Poznámky k účtu: <BR><TEXTAREA name="koment_ucet" cols=80 rows=6 readonly><?php echo $_POST['koment_ucet']; ?></TEXTAREA><BR>

<H2>Transakce a Bankovnictví</H2>
Poznámky k Jednorázovým poplatkům: <BR><TEXTAREA name="koment_JP" cols=80 rows=6 readonly><?php echo $_POST['koment_JP']; ?></TEXTAREA><BR>
Poznámky k Pravidelným měsíčním poplatkům: <BR><TEXTAREA name="koment_PP" cols=80 rows=6 readonly><?php echo $_POST['koment_PP']; ?></TEXTAREA><BR>
Poznámky k Transakčním poplatkům: <BR><TEXTAREA name="koment_trans" cols=80 rows=6 readonly><?php echo $_POST['koment_trans']; ?></TEXTAREA><BR>

<H2>Karty</H2>
Poznámky ke kartám obecně: <BR><TEXTAREA name="koment_karty" cols=80 rows=6 readonly><?php echo $_POST['koment_karta']; ?></TEXTAREA><BR>
<?php 
$sql_d_karta = "SELECT * FROM ceny_karty WHERE karta_cena_id = $id ORDER BY id ASC";
$d_karta = vystup_sql($sql_d_karta);
while($r_karta = mysql_fetch_assoc($d_karta)){
?>
<H3><?php echo $r_karta['karta_nazev']; ?></H3>
Poznámky k Hlavní kartě: <BR><TEXTAREA name="komentH" cols=80 rows=6 readonly><?php echo $r_karta['kartaH_koment']; ?></TEXTAREA><BR>
Poznámky k Dodatkové kartě: <BR><TEXTAREA name="komentD" cols=80 rows=6 readonly><?php echo $r_karta['kartaD_koment']; ?></TEXTAREA><BR>
<?php
}

$IDs = array(30);

echo in_array($id, $IDs);

?>

<br>
<div style='background-color:red; text-align:center; position:fixed; color:white; bottom:0px; width:100%; font-size:small'>&copy;2013, Nulovepoplatky.cz, Všechna práva vyhrazena. Optimalizováno pro Google Chrome (<a href='http://www.google.com/chrome' target='_blank'>zde</a> ke stažení) v rozlišení 1280 x 1024 px.</div>

</BODY>
</HTML>
