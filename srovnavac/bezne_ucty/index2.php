<html>
<head>
<meta charset="utf-8">

<LINK rel="shortcut icon" href="..\..\favicon.ico" type="image/x-icon" />
<LINK rel="stylesheet" type="text/css" href="..\..\styly.css">
<title>Srovnávač poplatků bank</title>
</head>
<body bgcolor="#FFFFFF" text="#000000">
<?php include_once("analyticstracking.php"); 
include "../../pripojeni_sql.php"; 

function vystup_sql($_sql)
{
global $id_spojeni;
$query = mysqli_query($_sql, $id_spojeni);
  if (!$query)
  {
    //echo mysqli_errno($id_spojeni).': '.mysqli_error($id_spojeni).'<br>';
    die("<span style='color:red; font-weight:bold'>Něco se nepovedlo. Jdi zpět a zkontroluj, jestli jsou údaje správně zapsané nebo nějaké nechybí. Pokud je vše zapsané v pořádku a problém přetrvává, pošli mi tyto 2 řádky:</span>
    <p style='color:red'>".mysqli_errno($id_spojeni).': '.mysqli_error($id_spojeni)."<BR><i>$_sql</U></i>");
  }
return $query;
}

function cena($_cislo)
{
return number_format($_cislo, 2, '.', '');
}
?>

<div style="text-align:right">Kontakt: <a href="mailto:info@nulovepoplatky.cz">info@nulovepoplatky.cz</a></div> 

<H1>Srovnání měsíčních poplatků - běžné účty</H1>
<TABLE border=0>
<TR>

<TD style='vertical-align:top; width:260; padding-right:10'>
<H2>Parametry</H2>
<form action='' method='post'>

<?php
$sql_table = "CREATE TEMPORARY TABLE vysledky (
  cena_id INT NOT NULL,
  ucet VARCHAR(45) NULL,
  banka VARCHAR(45) NULL,
  kod_banky CHAR(4) NULL,
  banking VARCHAR(20) NULL,
  vek VARCHAR(7) NULL,
  min DECIMAL(10,2) NULL,
  max DECIMAL(10,2) NULL,
  prich_min DECIMAL(10,2) NULL,
  prich_max DECIMAL(10,2) NULL,
  odch_min DECIMAL(10,2) NULL,
  odch_max DECIMAL(10,2) NULL,
  karta_min DECIMAL(10,2) NULL,
  karta_max DECIMAL(10,2) NULL,
  vedeni_min DECIMAL(10,2) NULL,
  vedeni_max DECIMAL(10,2) NULL,
  vypis_min DECIMAL(10,2) NULL,
  vypis_max DECIMAL(10,2) NULL,
  www VARCHAR(200) NULL,
  typ_uctu VARCHAR(45) NULL,
  platnost_od DATE NULL,
  koment_ucet TEXT,
  koment_JP TEXT,
  koment_PP TEXT,
  koment_trans TEXT,
  koment_karta TEXT,
  PRIMARY KEY (cena_id))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_czech_ci";

$table = vystup_sql($sql_table); 

include "vypocet.php"; 

$mena = 'CZK';

/*
$vek = isset($_POST['vek']) ? $_POST['vek'] : 20;
$vek_sql = "ucet_vek_od <= $vek and (ucet_vek_do >= $vek or ucet_vek_do is null) ";

$prich = isset($_POST['prich']) ? $_POST['prich'] : 1;
$odch_std = isset($_POST['odch_std']) ? $_POST['odch_std'] : 2;
$odch_tp = isset($_POST['odch_tp']) ? $_POST['odch_tp'] : 2;
$vypis = isset($_POST['vypis']) ? $_POST['vypis'] : 'e';
$karta = isset($_POST['karta']) ? $_POST['karta'] : 1;
$karta_vybery = isset($_POST['karta']) ? $_POST['karta_vybery'] : 1;
$cashback = isset($_POST['karta']) ? $_POST['cashback'] : 0;                   */

?>
<H3>.. k filtraci účtů</H3>
Zahrnuté typy účtu <?php echo "(v $mena)"; ?>: <select name='typ'>
<option value='vse'<?php echo isset($_POST['typ']) && $_POST['typ'] == 'vse' ? ' selected' : ''; ?>>všechny dle věku</option>
<option value='bezny'<?php echo isset($_POST['typ']) && $_POST['typ'] == 'bezny' ? ' selected' : ''; ?>>pro fyzické osoby nepodnikatele</option>
<option value='bezny-stu'<?php echo isset($_POST['typ']) && $_POST['typ'] == 'bezny-stu' ? ' selected' : ''; ?>>studentské</option>
<option value='bezny-det'<?php echo isset($_POST['typ']) && $_POST['typ'] == 'bezny-det' ? ' selected' : ''; ?>>dětské</option>
<option value='bezny-pod' disabled>podnikatelské (v plánu)</option>
</select> 
<div style='line-height:3px'><br></div>
Věk klienta: <input type='number' name='vek' style='width:40' value=<?php echo $vek; ?>>

<H3>.. k filtraci účtů a výpočtu poplatků</H3>
<TABLE border=1 style='width:260'>
<TR><TD colspan=2>Počet příchozích plateb:</TD><TD><input type='number' name='prich' style='width:40' value=<?php echo $prich; ?>></TD></TR>
<TR><TD colspan=2>Počet jednorázových odchozích plateb:</TD><TD><input type='number' name='odch_std' style='width:40' value=<?php echo $odch_std; ?>></TD></TR> 
<TR><TD colspan=2>Počet trvalých příkazů:</TD><TD><input type='number' name='odch_tp' style='width:40' value=<?php echo $odch_tp; ?>></TD></TR>
<TR><TD colspan=3>K účtu vyžaduji tyto bankovnictví:<br>
<div style='line-height:0.6'>
<input type='checkbox' name='banking[]' value='i' checked disabled> internetové<br>
<input type='hidden' name='banking[]' value='i'> 
<div style='text-indent:5'>
<input type='checkbox' name='banking[]' value='o'<?php echo (isset($_POST['banking']) && in_array('o', $_POST['banking']) ? ' checked' : Null) ?>> s možností plateb přímo u obchodníka (v e-shopech)</div><br> 
<input type='checkbox' name='banking[]' value='m'<?php echo (isset($_POST['banking']) && in_array('m', $_POST['banking']) ? ' checked' : Null) ?>> mobilní/smart<br> 
<input type='checkbox' name='banking[]' value='t'<?php echo (isset($_POST['banking']) && in_array('t', $_POST['banking']) ? ' checked' : Null) ?>> telefonní 
</div></TD></TR>
<TR><TD colspan=3>Výpis: 
<input type='radio' name='vypis' value='e'<?php echo ($vypis == 'e' ? " checked" : ""); ?>> elektronický
<input type='radio' name='vypis' value='p'<?php echo ($vypis == 'p' ? " checked" : ""); ?>> papírový
</TD></TR>

<TR><TD>Platební karta k účtu:</TD>
<TD style='background-color:silver'><input type='radio' name='karta' value=1<?php echo ($karta == 1 ? " checked" : ""); ?>> ano</TD>
<TD><input type='radio' name='karta' value=0<?php echo ($karta == 0 ? " checked" : ""); ?>> ne</TD></TR> 
<TR><TD colspan=2 style='background-color:silver'>Počet výběrů z bankomatu:</TD>
<TD style='background-color:silver'><input type='number' name='karta_vybery' value=<?php echo $karta_vybery; ?> style='width:45;background-color:lightgrey'></TD></TR>
<TR><TD style='background-color:silver'>Vyžaduji Cashback:</TD>
<TD style='background-color:silver'><input type='radio' name='cashback' value=1<?php echo ($cashback == 1 ? " checked" : ""); ?>> ano</TD>
<TD style='background-color:silver'><input type='radio' name='cashback' value=0<?php echo ($cashback == 0 ? " checked" : ""); ?>> ne</TD></TR>

<TR><TD colspan=3 style='padding:10;text-align:center'><input type='submit' value='Přepočítat výsledky' style='width:200; padding:3; letter-spacing:2'></TD></TR>
</TABLE>

<?php

/*
$sql_data = "SELECT *".
($karta == 1 ? ", (SELECT max(kartaH_vedeni + (kartaH_vyber3 * $karta_vybery)) AS karta_max FROM ceny_karty WHERE karta_cena_id = ucty_ceny.cena_id AND karta_typ <> 3".($cashback == 1 ? " AND not kartaH_cashback is null" : "").") AS karta_max, 
(SELECT min(kartaH_vedeni + (if(kartaH_vyber1 is null AND kartaH_vyber2 is null, kartaH_vyber3 * $karta_vybery, if(kartaH_vyber1 is null, kartaH_vyber2 * $karta_vybery, kartaH_vyber1 * $karta_vybery)))) AS karta_min FROM ceny_karty WHERE karta_cena_id = ucty_ceny.cena_id AND karta_typ <> 3".($cashback == 1 ? " AND not kartaH_cashback is null" : "").") AS karta_min" : ", 0 AS karta_max, 0 AS karta_min")."
FROM ucty
INNER JOIN banky ON ucty.ucet_kod_banky = banky.kod_banky 
INNER JOIN ucty_ceny ON ucty.ucet_id = ucty_ceny.cena_ucet_id 
INNER JOIN ceny_banking ON ucty_ceny.cena_id = ceny_banking.id
WHERE cena_platnost_od <= Current_date() AND ".
(isset($_POST['typ']) && $_POST['typ'] <> 'vse' ? "ucet_typ = '".$_POST['typ']."' " : $vek_sql).
($karta == 1 ? "AND cena_koment_karta <> 'bez karty' " : "").
(isset($_POST['vypis']) && $_POST['vypis'] == 'p' ? "AND not cena_vypis_p is null " : "")."
ORDER BY cena_vedeni ASC, cena_platnost_od ASC";                  // ÚKOL 1: zavést do tabulek i platnost do (nutný update v admin_page)
                                                                  // ÚKOL 2: nastavit výchozí hodnotu pole ucet_koment_karta na 'bez karty', kvůli filtrování účtů
$data = vystup_sql($sql_data);            */
?>                                                                                                       

</TD>
<TD style='vertical-align:top; padding-left:50'>

<TABLE border=1>
<TR>
<TH rowspan=2 style='background-color:#FFCC99'>Pořadí</TH>
<TH rowspan=2 style='background-color:#FFCC99'>Účet</TH>
<TH colspan=2 style='height:25;background-color:#FFCC99'>Měsíční poplatky</TH>
<TH rowspan=2 style='background-color:#FFCC99'>Detaily</TH>
</TR>
<TR>
<TH style='height:25;background-color:#FFCC99'>Cena min.</TH>
<TH style='height:25;background-color:#FFCC99'>Cena max.</TH>
</TR>
</form>
<?php

/*
while($r_data = mysqli_fetch_assoc($data)){              // r = řádek, v = výpočet, d = detail, c = cena
$cena_id = $r_data["cena_id"];
$ucet = $r_data["ucet_nazev"];
$www = $r_data["ucet_www"];
$banka = $r_data["nazev_banky"];
$kod_banky = $r_data["ucet_kod_banky"];
$banking = "IB".($r_data["cena_odchozi_online1"] != Null ? " (vč.PuO), " : ", ").($r_data["mb_Zrizeni"] != Null ? "MB, " : "").($r_data["tb_Zrizeni"] != Null ? "TB" : "");
$vek_rozmezi = $r_data["ucet_vek_od"]." - ".$r_data["ucet_vek_do"];  

switch ($r_data["ucet_typ"]){
  case 'bezny':
  $typ = 'Účet pro nepodnikatele';
  break;
  
  case 'bezny-stu':
  $typ = 'Studentský účet';
  break;
  
  case 'bezny-det':
  $typ = 'Dětský účet';
  break;
  
  default:
  $typ = $typ_filtr = '???';
}

$v_vedeni = $r_data["cena_vedeni"];
$v_vypis_min = $v_vypis_max = $v_vypis = $vypis == 'p' ? $r_data["cena_vypis_p"] : $r_data["cena_vypis_e"];

$v_prich_min = $prich * $r_data["cena_prichozi1"];
$v_prich_max = $prich * $r_data["cena_prichozi2"];
$v_tp_min = $odch_tp * $r_data["cena_odchozi_tp1"];
$v_tp_max = $odch_tp * $r_data["cena_odchozi_tp2"];
$v_odchozi_min_ib = $odch_std * $r_data["ib_Odchozi1"];
$v_odchozi_max_ib = $odch_std * $r_data["ib_Odchozi2"];

$v_vedeni = $v_vedeni + $r_data["ib_Vedeni"];

if(isset($_POST['banking']) && in_array('m', $_POST['banking'])){
$v_odchozi_min_mb = $odch_std * $r_data["mb_Odchozi1"];
$v_odchozi_max_mb = $odch_std * $r_data["mb_Odchozi2"];
$v_vedeni = $v_vedeni + $r_data["mb_Vedeni"];
}

if(isset($_POST['banking']) && in_array('t', $_POST['banking'])){
$v_odchozi_min_tb = $odch_std * $r_data["tb_Odchozi1"];
$v_odchozi_max_tb = $odch_std * $r_data["tb_Odchozi2"];
$v_vedeni = $v_vedeni + $r_data["tb_Vedeni"];
}

$v_vedeni_min = $v_vedeni_max = $v_vedeni; 

$v_karta_min = $r_data["karta_min"];
$v_karta_max = $r_data["karta_max"];




switch($r_data["cena_id"])                 // VÝJIMKY Z POPLATKŮ
{
case '62':    // MůjÚčet, KB
  $v_vedeni_min = 0;
  
  if($karta == 1){
  $sql_karta_min = "SELECT min(kartaH_vedeni) FROM ceny_karty WHERE karta_cena_id = ".$r_data["cena_id"]." AND karta_typ <> 3";
  $karta_min = vystup_sql($sql_karta_min);
  $v_karta_min = mysqli_result($karta_min, 0);}
  
  if($v_odchozi_min_ib + $v_tp_min >= $r_data["cena_trans_bal"]){
  $v_odchozi_min_ib = $r_data["cena_trans_bal"];
  $v_tp_min = 0;}
  
  if(isset($_POST['banking']) && in_array('m', $_POST['banking']) && $v_odchozi_min_mb + $v_tp_min >= $r_data["cena_trans_bal"]){
  $v_odchozi_min_mb = $r_data["cena_trans_bal"];
  $v_tp_min = 0;}
break;

case '63':    // Konto G2.2, KB
  $v_vedeni_max = $vek >= 26 ? 68 : 0;
  
  if($karta == 1){
  $sql_karta_min = "SELECT min(kartaH_vedeni) FROM ceny_karty WHERE karta_cena_id = ".$r_data["cena_id"]." AND karta_typ <> 3";
  $karta_min = vystup_sql($sql_karta_min);
  $v_karta_min = mysqli_result($karta_min, 0);}
    
    if($v_odchozi_min_ib + $v_tp_min >= $r_data["cena_trans_bal"] - ($vek < 26 ? 20 : 0)){
    $v_odchozi_min_ib = $r_data["cena_trans_bal"] - ($vek < 26 ? 20 : 0);
    $v_tp_min = 0;}
    
    if(isset($_POST['banking']) && in_array('m', $_POST['banking']) && $v_odchozi_min_mb + $v_tp_min >= $r_data["cena_trans_bal"] - ($vek < 26 ? 20 : 0)){
    $v_odchozi_min_mb = $r_data["cena_trans_bal"] - ($vek < 26 ? 20 : 0);
    $v_tp_min = 0;}
break;

case '64':    // Běžný účet, KB
  if($karta == 1){
  $sql_karta_min = "SELECT min(kartaH_vedeni) FROM ceny_karty WHERE karta_cena_id = ".$r_data["cena_id"]." AND karta_typ <> 3";
  $karta_min = vystup_sql($sql_karta_min);
  $v_karta_min = mysqli_result($karta_min, 0);}
break;

case '65':    // Dětské konto Beruška, KB
  $v_vypis_min = $v_vypis_max = $prich > 0 ? $v_vypis : 0;
  
  if($karta == 1){
  $v_karta_min = $vek >= 8 ? $v_karta_min : 0;
  $v_karta_max = $vek >= 8 ? $v_karta_max : 0;} 
break;

case '66':    // KB start konto, KB
  $v_prich_min = $v_prich_max = ($prich > 1 ? $prich - 1 : 0) * 5;
  $v_tp_min = $odch_tp * $r_data["cena_odchozi_tp1"];
  $v_tp_max = $odch_tp * $r_data["cena_odchozi_tp2"];
  $v_odchozi_min_ib = $v_odchozi_max_ib = $v_odchozi_min_mb = $v_odchozi_max_mb = ($odch_std > 1 ? $odch_std - 1 : 0) * 4;
  $v_odchozi_min_mb = $v_odchozi_max_mb = (isset($_POST['banking']) && in_array('m', $_POST['banking']) && $odch_std > 1 ? $odch_std - 1 : 0) * 4;
  $v_odchozi_min_tb = $v_odchozi_max_tb = (isset($_POST['banking']) && in_array('t', $_POST['banking']) && $odch_std > 1 ? $odch_std - 1 : 0) * 19;
  
  $v_odchozi_max_ib = $prich + $odch_std + $odch_tp > 1 ? $v_odchozi_max_ib + 2 : $v_odchozi_max_ib;

  if($karta == 1){
  $sql_karta_min = "SELECT min(kartaH_vedeni) FROM ceny_karty WHERE karta_cena_id = ".$r_data["cena_id"]." AND karta_typ <> 3";
  $karta_min = vystup_sql($sql_karta_min);
  $v_karta_min = mysqli_result($karta_min, 0);}
break;

case '67':    // TOP nabídka, KB
  $v_vedeni_min = 0;
  
  if($karta == 1){
  $sql_karta_min = "SELECT min(kartaH_vedeni) FROM ceny_karty WHERE karta_cena_id = ".$r_data["cena_id"]." AND karta_typ <> 3";
  $karta_min = vystup_sql($sql_karta_min);
  $v_karta_min = mysqli_result($karta_min, 0);}
break;

case '53':    // ČSOB konto, ČSOB
  $c_odch = 3;
  $v_odchozi_min_ib = $v_odchozi_max_ib = $v_odchozi_min_mb = $v_odchozi_max_mb = $odch_std + $odch_tp > 2 ? ($odch_std + $odch_tp - 2) * $c_odch : 0;

  if($karta == 1){
  $c_vyber = 6;
  $v_karta_min = $karta_vybery > 2 ? $r_data["karta_min"] + (($karta_vybery - 2) * $c_vyber) : $r_data["karta_min"];}
break;

case '54':    // ČSOB Aktivní konto, ČSOB
  $c_odch = 3;
  $v_odchozi_min_ib = $v_odchozi_max_ib = $v_odchozi_min_mb = $v_odchozi_max_mb = $odch_std + $odch_tp > 10 ? ($odch_std + $odch_tp - 10) * $c_odch : 0;

  if($karta == 1){
  $c_vyber = 6;
  $v_karta_min = $karta_vybery > 5 ? $r_data["karta_min"] + (($karta_vybery - 5) * $c_vyber) : $r_data["karta_min"];}
break;

case '52':    // konto PREMIUM, Unicredit
case '55':    // ČSOB Exkluzivní konto, ČSOB
  $v_vedeni_min = 0;
break;

case '57':    // ČSOB Dětské konto, ČSOB
  if($karta == 1){
  $c_vyber = 6;
  $v_karta_min = $karta_vybery > 4 ? $r_data["karta_min"] + (($karta_vybery - 4) * $c_vyber) : $r_data["karta_min"];}
break;

case '59':    // Era osobní účet, Poštovní spořitelna
  $v_vedeni_min = $vek <= 26 || $vek >= 58 ? 0 : ($odch_std > 0 ? 18 : 26);
  $v_odchozi_min_ib = $v_odchozi_min_mb = $v_tp_min = 0;
  
  if($karta == 1){
  $c_vyber = 5;
  $v_karta_min = $vek <= 26 && $karta_vybery > 2 ? ($karta_vybery - 2) * $c_vyber : ($vek <= 26 ? 0 : $karta_vybery * $c_vyber);}
break;

case '41':    // Genius Active, GE
case '60':    // Era online účet, Poštovní spořitelna
  $v_vedeni_min = 0;
break;

case '42':    // Genius Silver, GE                              
  $v_vedeni_min = 149;
break;

case '43':    // Genius Gold, GE
  $v_vedeni_min = 0;
  
  if($karta == 1){
  $c_vyber = 40;
  $v_karta_max = $karta_vybery > 3 ? $r_data["karta_max"] + (($karta_vybery - 3) * $c_vyber) : $r_data["karta_max"];}
break;

case '44':    // Genius Free&Flexi, GE
  $v_vedeni_max = 149;
  
  if($karta == 1){
  $c_vyber = 15;
  $v_karta_min = $karta_vybery > 4 ? $r_data["karta_min"] + (($karta_vybery - 4) * $c_vyber) : $r_data["karta_min"];}
break;

case '45':    // Genius bene+, GE
  $v_vedeni_max = 149;
    
  if($karta == 1){
  $v_vedeni_min = -50;
  $c_vyber = 15;
  $v_karta_min = $karta_vybery > 4 ? $r_data["karta_min"] + (($karta_vybery - 4) * $c_vyber) : $r_data["karta_min"];}
break;

case '30':    // Osobní účet II, Česká spořitelna
  $v_vedeni_min = $r_data["ib_Vedeni"];
  
  if($v_odchozi_min_ib + $v_tp_min >= $r_data["cena_trans_bal"]){
  $v_odchozi_min_ib = $r_data["cena_trans_bal"];
  $v_tp_min = 0;}
  
  if(isset($_POST['banking']) && in_array('m', $_POST['banking']) && $v_odchozi_min_mb + $v_tp_min >= $r_data["cena_trans_bal"]){
  $v_odchozi_min_mb = $r_data["cena_trans_bal"];
  $v_tp_min = 0;}
        
  if($karta == 1){
  $c_vyber = 5;
  $c_vybery_bal = 29;
  $v_karta_min = $karta_vybery > 2 ? $r_data["karta_min"] + (($karta_vybery - 2) * $c_vyber) : $r_data["karta_min"];
  $v_karta_min = $v_karta_min - $r_data["karta_min"] > $c_vybery_bal ? $c_vybery_bal : $v_karta_min;}
break;

case '35':    // Fio osobní účet, Fio
  $v_vypis_min = $vypis == 'p' ? $v_vypis_min + 15.73 : $v_vypis_min;
  $v_vypis_max = $vypis == 'p' ? $v_vypis_max + 71.39 : $v_vypis_max; 
  
  if($karta == 1){
  $c_vyber = 9;
  $v_karta_min = $karta_vybery > 10 ? $r_data["karta_min"] + (($karta_vybery - 10) * $c_vyber) : $r_data["karta_min"];}
break;

case '37':    // zuno účet plus, Zuno
  if($karta == 1)
  $v_karta_min = 0;
break;

case '51':    // U konto, Unicredit
  $v_vedeni_min = 0;
  $v_odchozi_min_ib = 0;
  $v_tp_min = 0;
  
  if($karta == 1)
  $v_karta_min = 0;
break;

case '73':    // konto 5 za 50, expobank
  $v_prich_min = 0;
  $v_tp_min = 0;
  $c_odch = 5;
  if($odch_std + $odch_tp <= 15)
  $v_odchozi_min_ib = 0;
  else
  $v_odchozi_min_ib = ($odch_std + $odch_tp - 15) * $c_odch;
  
  if($karta == 1){
  $c_vyber = 6.5;
  $v_karta_min = $karta_vybery * $c_vyber;}
break;

case '46':    // ekonto smart, raiffeisen bank
  $v_vedeni_max = 99;
  $v_tp_max = 50;
break;

case '47':    // ekonto komplet, raiffeisen bank
  $v_vedeni_max = 250;
break;

case '48':    // ekonto student, raiffeisen bank
  $v_vedeni_min = $vek < 18 && $karta == 0 ? 0 : $v_vedeni_min;
break;

case '32':    // běžný účet equa bank, equa bank
  $v_vedeni_max = 99;
break;

case '31':    // mkonto, mbank
  if($karta == 1){
  $c_vyber1 = 9;
  $c_vyber2 = 35;
  $v_karta_min = $karta_vybery > 3 ? ($karta_vybery - 3) * $c_vyber2 : 0;
  $v_karta_max = $karta_vybery > 3 ? (3 * $c_vyber1) + (($karta_vybery - 3) * $c_vyber2) : $karta_vybery * $c_vyber1;}
break;

case '69':    // fér konto plus, sberbank
  $c_odch = 5;
  $v_odchozi_max_ib = $odch_std > 3 ? ($odch_std - 3) * $c_odch : 0;
  $v_tp_max = $odch_std > 1 ? ($odch_std - 1) * $c_odch : 0;
  
  if($karta == 1){
  $c_vyber1 = 5;
  $c_vyber2 = 37;
  $v_karta_min = $karta_vybery > 3 ? $v_karta_min - (3 * $c_vyber1) : $v_karta_min - ($karta_vybery * $c_vyber1);
  $v_karta_max = $karta_vybery > 3 ? $v_karta_max - (3 * $c_vyber2) : $v_karta_max - ($karta_vybery * $c_vyber2);}
break;

default:

}


$ib_min = $v_odchozi_min_ib + $v_tp_min;
$ib_max = $v_odchozi_max_ib + $v_tp_max;

  if(isset($_POST['banking']) && in_array('m', $_POST['banking'])){
  $mb_min = $v_odchozi_min_mb + $v_tp_min;
  $mb_max = $v_odchozi_max_mb + $v_tp_max;}
  else
  $mb_min = $mb_max = -1;

  if(isset($_POST['banking']) && in_array('t', $_POST['banking'])){
  $tb_min = $v_odchozi_min_tb + $v_tp_min;
  $tb_max = $v_odchozi_max_tb + $v_tp_max;}
  else
  $tb_min = $tb_max = -1;
  
$odch_min = min($ib_min, ($mb_min >= 0 ? $mb_min : $ib_min), ($tb_min >= 0 ? $tb_min : $ib_min));
$odch_max = max($ib_max, ($mb_max >= 0 ? $mb_max : $ib_max), ($tb_max >= 0 ? $tb_max : $ib_max));
  
$v_min = $v_prich_min + $odch_min + $v_karta_min + $v_vedeni_min + $v_vypis_min;
$v_max = $v_prich_max + $odch_max + $v_karta_max + $v_vedeni_max + $v_vypis_max;

  
$platnost = $r_data["cena_platnost_od"];
$koment_ucet = $r_data["ucet_koment"];
$koment_JP = $r_data["cena_koment_JP"];
$koment_PP = $r_data["cena_koment_PP"];
$koment_trans = $r_data["cena_koment_trans"];
$koment_karta = $r_data["cena_koment_karta"];


$sql_vypocet = "INSERT INTO vysledky VALUES ($cena_id, '$ucet', '$banka', '$kod_banky', '$banking', '$vek_rozmezi', $v_min, $v_max, $v_prich_min, $v_prich_max, $odch_min, $odch_max, $v_karta_min, $v_karta_max, $v_vedeni_min, $v_vedeni_max, $v_vypis_min, $v_vypis_max, '$www', '$typ', '$platnost', '$koment_ucet', '$koment_JP', '$koment_PP', '$koment_trans', '$koment_karta')";
$vypocet = vystup_sql($sql_vypocet);
}                                                                    */


$list_order = isset($_POST['order']) ? $_POST['order'] : "min ASC, max ASC";
$list_filter = isset($_POST['banking']) && in_array('o', $_POST['banking']) ? "AND banking like '%PuO%'" : "";
$list_filter.= isset($_POST['banking']) && in_array('m', $_POST['banking']) ? " AND banking like '%mb%'" : "";
$list_filter.= isset($_POST['banking']) && in_array('t', $_POST['banking']) ? " AND banking like '%tb%'" : "";

$sql_list = "SELECT * FROM vysledky WHERE banking like 'ib%' $list_filter ORDER BY $list_order, platnost_od ASC";
$list = vystup_sql($sql_list);

$id = 0;
while($r_list = mysqli_fetch_assoc($list)){
++$id;
echo "<TR><FORM action='detail.php' method='POST' target='_blank'><input type='hidden' name='cena_id' value=".$r_list['cena_id'].">
<TD style='text-align:center'>$id.</TD>
<TD><a href='".$r_list['www']."' target='_blank'>".$r_list['ucet']."</a>
<br><span style='font-size:small'>".$r_list['typ_uctu']."<br>".$r_list['banka']."</span></TD>
<TD style='text-align:right; font-size:large; font-weight:bold'>".$r_list['min']."</TD>
<TD style='text-align:right".($r_list['min'] == $r_list['max'] ? ";font-weight:bold" : "")."'>".$r_list['max']."</TD>
<TD style='font-size:small'>Banking: ".$r_list['banking']."
<br>Věkové rozmezí: ".$r_list['vek']."
<br><div style='text-align:center'><input type='submit' name='ukaz_detail' value='Detail výpočtu ceny' style='font-size:x-small;letter-spacing:1'></div></TD>

<INPUT type='hidden' name='min' value='".$r_list['min']."'>
<INPUT type='hidden' name='max' value='".$r_list['max']."'>
<INPUT type='hidden' name='prich_min' value='".$r_list['prich_min']."'>
<INPUT type='hidden' name='prich_max' value='".$r_list['prich_max']."'>
<INPUT type='hidden' name='odch_min' value='".$r_list['odch_min']."'>
<INPUT type='hidden' name='odch_max' value='".$r_list['odch_max']."'>
<INPUT type='hidden' name='karta_min' value='".$r_list['karta_min']."'>
<INPUT type='hidden' name='karta_max' value='".$r_list['karta_max']."'>
<INPUT type='hidden' name='vedeni_min' value='".$r_list['vedeni_min']."'>
<INPUT type='hidden' name='vedeni_max' value='".$r_list['vedeni_max']."'>
<INPUT type='hidden' name='vypis_min' value='".$r_list['vypis_min']."'>
<INPUT type='hidden' name='vypis_max' value='".$r_list['vypis_max']."'>
<INPUT type='hidden' name='typ_uctu' value='".$r_list['typ_uctu']."'>

<INPUT type='hidden' name='prich' value='$prich'>
<INPUT type='hidden' name='odch_std' value='$odch_std'>
<INPUT type='hidden' name='odch_tp' value='$odch_tp'>
<INPUT type='hidden' name='banking' value='".(isset($_POST['banking']) ? implode(",", $_POST['banking']) : "i")."'>
<INPUT type='hidden' name='vypis' value='$vypis'>
<INPUT type='hidden' name='karta' value='$karta'>
<INPUT type='hidden' name='karta_vybery' value='$karta_vybery'>
<INPUT type='hidden' name='cashback' value='$cashback'>
</FORM></TR>";
}
?>

</TABLE>

</TD></TR>
</TABLE>
<br>

<?php
if($id_spojeni)
{
  mysqli_close($id_spojeni);
echo 'odpojeno <br>';
}
?>
 
<div style='background-color:red; text-align:center; position:fixed; color:white; bottom:0px; width:100%; font-size:small'>&copy;2013, Nulovepoplatky.cz, Všechna práva vyhrazena. Optimalizováno pro Google Chrome (<a href='http://www.google.com/chrome' target='_blank'>zde</a> ke stažení) v rozlišení 1280 x 1024 px.</div>

</BODY>
</HTML>
