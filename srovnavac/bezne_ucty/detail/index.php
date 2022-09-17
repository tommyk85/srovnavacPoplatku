<!doctype html>
<html>
<head>
<?php
    include_once("../../../analyticstracking.php"); 
?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    
    <LINK rel="shortcut icon" href="..\..\..\favicon.ico" type="image/x-icon" />
    <!--<LINK rel="stylesheet" type="text/css" href="..\..\dstyly.css">-->
    <title>Srovnávač poplatků bank</title>
</head>
<body bgcolor="#FFFFFF" text="#000000">
    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

    <script src="../../../common/scripty.js"></script>
    <script src="scripty.js"></script>

    <noscript>
        <style type="text/css">
            .pagecontainer {display:none;}
            .noscriptmsg {color:red;font-size:x-large; font-weight:bold;}
        </style>
        <div class="noscriptmsg">
        Podmínkou pro správné fungování stránek je mít v prohlížeči povolený JavaScript!!
        </div>
    </noscript>

    <script lang='javascript'>

        podporovany_browser();

    </script>

<?php 
if(!isset($_POST['ukaz_detail']) && !isset($_GET['id']))
die("nepovolený přístup");

include "../../../common/db/pripojeni_sql.php"; 
include "../../../common/format.php";

include '../../header.php';

$id = isset($_POST['ucet_id']) ? $_POST['ucet_id'] : $_GET['id'];

include "../vypocet.php"; 
  
$sql_d_ucet = "SELECT * FROM ucty
INNER JOIN banky ON ucty.ucet_kod_banky = banky.kod_banky 
INNER JOIN ucty_ceny ON ucty.ucet_id = ucty_ceny.cena_ucet_id 
INNER JOIN ceny_banking ON ucty_ceny.cena_id = ceny_banking.id
WHERE ucet_id = $id AND ucty_ceny.cena_active=1";                 
$d_ucet = vystup_sql($sql_d_ucet);

$cena_id = mysqli_result($d_ucet, 0, "cena_id"); 

$sql_d_karta = "SELECT * FROM ceny_karty WHERE karta_cena_id = $cena_id ORDER BY id ASC";
$d_karta = vystup_sql($sql_d_karta);

$ucet = mysqli_result($d_ucet, 0, "ucet_nazev");
$typ_uctu = mysqli_result($d_ucet, 0, "ucet_typ");
$banka = mysqli_result($d_ucet, 0, "nazev_banky");
$kod_banky = mysqli_result($d_ucet, 0, "kod_banky");
$platnost_od = mysqli_result($d_ucet, 0, "cena_platnost_od");
$min_limit = mysqli_result($d_ucet, 0, "ucet_min_limit");
$urok = mysqli_result($d_ucet, 0, "ucet_urok");
$vek_od = mysqli_result($d_ucet, 0, "ucet_vek_od");
$vek_do = mysqli_result($d_ucet, 0, "ucet_vek_do");
$www = mysqli_result($d_ucet, 0, "ucet_www");
$koment_ucet = mysqli_result($d_ucet, 0, "ucet_koment");
$koment_karta = mysqli_result($d_ucet, 0, "cena_koment_karta");
$koment_JP = mysqli_result($d_ucet, 0, "cena_koment_JP");
$koment_PP = mysqli_result($d_ucet, 0, "cena_koment_PP");
$koment_trans = mysqli_result($d_ucet, 0, "cena_koment_trans");
$c_prich1 = mysqli_result($d_ucet, 0, "cena_prichozi1");
$c_prich2 = mysqli_result($d_ucet, 0, "cena_prichozi2");
$c_vedeni = mysqli_result($d_ucet, 0, "cena_vedeni");
$c_zrizeni = mysqli_result($d_ucet, 0, "cena_zrizeni");
$c_zruseni = mysqli_result($d_ucet, 0, "cena_zruseni");
$c_vypis_e = mysqli_result($d_ucet, 0, "cena_vypis_e");
$c_vypis_p = mysqli_result($d_ucet, 0, "cena_vypis_p");
$c_vypis = $vypis == 'e' ? $c_vypis_e : $c_vypis_p;
$c_odch_ib1 = mysqli_result($d_ucet, 0, "ib_Odchozi1");
$c_odch_ib2 = mysqli_result($d_ucet, 0, "ib_Odchozi2");
$c_odch_mb1 = mysqli_result($d_ucet, 0, "mb_Odchozi1");
$c_odch_mb2 = mysqli_result($d_ucet, 0, "mb_Odchozi2");
$c_odch_tb1 = mysqli_result($d_ucet, 0, "tb_Odchozi1");
$c_odch_tb2 = mysqli_result($d_ucet, 0, "tb_Odchozi2");
$c_odch_online = mysqli_result($d_ucet, 0, "cena_odchozi_online1");
$c_tp1 = mysqli_result($d_ucet, 0, "cena_odchozi_tp1");
$c_tp2 = mysqli_result($d_ucet, 0, "cena_odchozi_tp2");
$c_tp_zrizeni_ib = mysqli_result($d_ucet, 0, "ib_ZrizeniTP");
$c_tp_zrizeni_mb = mysqli_result($d_ucet, 0, "mb_ZrizeniTP");
$c_tp_zrizeni_tb = mysqli_result($d_ucet, 0, "tb_ZrizeniTP");
$c_zrizeni_ib = mysqli_result($d_ucet, 0, "ib_Zrizeni");
$c_zrizeni_mb = mysqli_result($d_ucet, 0, "mb_Zrizeni");
$c_zrizeni_tb = mysqli_result($d_ucet, 0, "tb_Zrizeni");
$c_vedeni_ib = mysqli_result($d_ucet, 0, "ib_Vedeni");
$c_vedeni_mb = mysqli_result($d_ucet, 0, "mb_Vedeni");
$c_vedeni_tb = mysqli_result($d_ucet, 0, "tb_Vedeni");

?>

<script type="text/javascript">
document.write("Poslední aktualizace: " + document.lastModified);
var ucetId = <?php echo json_encode($id); ?>;
var cenaId = <?php echo json_encode($cena_id); ?>;
console.log('ucet id = ' + ucetId + '\ncena id = ' + cenaId);
</script> 

<?php include "rekalkul.php"; ?>

<H1><?php echo "$ucet <span style='font-size:medium'>($mena - $banka - $kod_banky)</span>"; ?></H1>

<STYLE>
.popis {text-align:center;max-width:300;letter-spacing:1;height:30;text-transform:uppercase}
.cena {text-align:right;padding-left:10;padding-right:10}
.oznac {text-align:left;text-indent:5;color:red}
.popis2 {padding:5;font-size:small;padding-bottom:10}
</STYLE>

        <a href="javascript:activateTab('page1')">Podrobná kalkulačka</a> |
        <a href="javascript:activateTab('page2')">Min/Max</a> |
        <a href="javascript:activateTab('page3')">Platební karty</a> |
        <a href="javascript:activateTab('page4')">Výpis ze sazebníku</a> |
        <a href="javascript:activateTab('page5')">Detaily účtu</a>

<div id="tabCtrl">

    <div id="page1" style="display: block;padding-top:30;text-align:center">
        <?php include "kalkulacka.php"; ?>
    </div>

    <div id="page2" style="display: none;padding-top:30;text-align:center">
        <?php include "minMax.php"; ?>
    </div>

    <div id="page4" style="display: none;padding-top:10;text-align:center">
        <?php include "sazebnikUctu.php"; ?>
    </div>
    
    <div id="page3" style="display: none;padding-top:10;text-align:center">
        <?php include "sazebnikKaret.php"; ?>
    </div>
    
    <div id="page5" style="display: none;padding-top:10;text-align:center;line-height:1.2">
        <?php include "prehled.php"; ?>
    </div>
</div>

<?php
    include '../../../footer.php';
?>

</BODY>
</HTML>