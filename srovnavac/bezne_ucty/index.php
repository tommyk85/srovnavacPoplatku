<!doctype html>
<html>
<head>
<?php
    include_once("../../analyticstracking.php");
?>

<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-9069711509149803" 
    crossorigin="anonymous"></script>

<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

<LINK rel="shortcut icon" href="..\..\favicon.ico" type="image/x-icon" />
<title>Srovnávač poplatků bank</title>
</head>

<body bgcolor="#FFFFFF" text="#000000">
    <noscript>
        <style type="text/css">
            .pagecontainer {display:none;}
            .noscriptmsg {color:red;font-size:x-large; font-weight:bold;}
        </style>
        <div class="noscriptmsg">
            Podmínkou pro správné fungování stránek je mít v prohlížeči povolený JavaScript!!
        </div>
    </noscript>
  
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

    <script src="../../common/scripty.js"></script>
    <script src="../scripty/souhrn.js"></script>

    <script lang='javascript'>
        podporovany_browser();
    </script>

<?php
include "../../common/db/pripojeni_sql.php";
include "../../common/format.php";
include "../../common/db/query.php";

include '../header.php';

vytvor_temp_tabulku("vysledky");

include "vypocet.php";
?>

<H1>SROVNÁVAČ měsíčních poplatků - běžné účty</H1>

<p style='margin-bottom:50px;'>Změnou parametrů (a filtrů) se automaticky přepočítá a přefiltruje výsledný seznam účtů.</p>

<div class="row">
<div id='filtr' onChange='rekalkul()' class="col-3 ms-2">
<H2>Parametry</H2>

<form action='' method='post' id='f'>

<H3>.. k filtraci účtů</H3>
<div class="mb-3">
    <label for="typ" class="form-label">Zahrnuté typy účtu <?php echo "(v $mena)"; ?></label>
    <select name='typ' class="form-select">
        <option value='vse'<?php echo isset($_POST['typ']) && $_POST['typ'] == 'vse' ? ' selected' : ''; ?>>všechny dle věku</option>
        <option value='bezny'<?php echo isset($_POST['typ']) && $_POST['typ'] == 'bezny' ? ' selected' : ''; ?>>pro fyzické osoby nepodnikatele</option>
        <option value='bezny-stu'<?php echo isset($_POST['typ']) && $_POST['typ'] == 'bezny-stu' ? ' selected' : ''; ?>>studentské</option>
        <option value='bezny-det'<?php echo isset($_POST['typ']) && $_POST['typ'] == 'bezny-det' ? ' selected' : ''; ?>>dětské</option>
        <option value='bezny-pod' disabled>podnikatelské (v plánu)</option>
    </select>
</div>

<div class="row mb-2 justify-content-between">
    <div class="col">
        <label for="vek" class="form-label">Věk klienta</label>
    </div>
    <div class="col-lg-4">
        <input type="number" class="form-control" name="vek" value=<?php echo $vek; ?>>
    </div>
</div>

<H3>.. k filtraci účtů a výpočtu poplatků</H3>
<div class="row mb-2 justify-content-between">
    <div class="col">
        <label for="prich" class="form-label">Počet příchozích plateb</label>
    </div>
    <div class="col-lg-4">
        <input type="number" class="form-control" name="prich" value=<?php echo $prich; ?>>
    </div>
</div>
<div class="row mb-2 justify-content-between">
    <div class="col">
        <label for="odch_std" class="form-label">Počet příchozích plateb</label>
    </div>
    <div class="col-lg-4">
        <input type="number" class="form-control" name="odch_std" value=<?php echo $odch_std; ?>>
    </div>
</div>
<div class="row mb-2 justify-content-between">
    <div class="col">
        <label for="odch_tp" class="form-label">Počet příchozích plateb</label>
    </div>
    <div class="col-lg-4">
        <input type="number" class="form-control" name="odch_tp" value=<?php echo $odch_tp; ?>>
    </div>
</div>
<div class="mb-2">Bankovnictví:
    <div class="form-check">
        <input class="form-check-input" type="checkbox" value="i" name='banking[]' checked disabled>
        <input type='hidden' name='banking[]' value='i'>
        <label class="form-check-label" for="banking-i">
            internetové
        </label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" value="o" name="banking[]"<?php echo (in_array('o', $banking) ? ' checked' : Null) ?>>
        <label class="form-check-label" for="banking-o">
            internetové s možností plateb přímo u obchodníka (v e-shopech)
        </label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" value="m" name="banking[]"<?php echo (in_array('m', $banking) ? ' checked' : Null) ?>>
        <label class="form-check-label" for="banking-m">
            mobilní/smart
        </label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" value="t" name="banking[]"<?php echo (in_array('t', $banking) ? ' checked' : Null) ?>>
        <label class="form-check-label" for="banking-t">
            telefonní
        </label>
    </div>
</div>
<div class="mb-2">Výpis:
    <div class="form-check">
        <input class="form-check-input" type="radio" value="e" name='vypis'<?php echo ($vypis == 'e' ? " checked" : ""); ?>>
        <label class="form-check-label" for="vypis-e">
            elektronický
        </label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="radio" value="p" name="vypis"<?php echo ($vypis == 'p' ? " checked" : ""); ?>>
        <label class="form-check-label" for="vypis-p">
            papírový
        </label>
    </div>
</div>
<div class="mb-2">Debetní karta:
    <div class="form-check">
        <input class="form-check-input" type="radio" value=1 name='karta'<?php echo ($karta == 1 ? " checked" : ""); ?>>
        <label class="form-check-label" for="karta-ano">
            ano
        </label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="radio" value=0 name="karta"<?php echo ($karta == 0 ? " checked" : ""); ?>>
        <label class="form-check-label" for="karta-ne">
            ne
        </label>
    </div>
</div>
<div class="row mb-3 justify-content-between">
    <div class="col">
        <label for="karta_vybery" class="form-label">Počet výběrů z bankomatu</label>
    </div>
    <div class="col-lg-4">
        <input type="number" class="form-control" name="karta_vybery" value=<?php echo $karta_vybery; ?>>
    </div>
</div>

<div id='pokr' onChange='rekalkul()' class="mb-5">
<H3>Pokročilý filtr</H3>
    <div class="form-check">
        <input class="form-check-input" type='checkbox' name='disponent'
            <?php echo isset($_POST['disponent']) && $_POST['disponent'] != Null ? " checked" : ""; ?>>
        <label class="form-check-label" for="disponent"> pouze účty s možností disponenta</label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type='checkbox' name='vedeniBezPod'
            <?php echo isset($_POST['vedeniBezPod']) && $_POST['vedeniBezPod'] != Null ? " checked" : ""; ?>>
        <label class="form-check-label" for="vedeniBezPod"> pouze účty s vedením bez podmínek</label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type='checkbox' name='inkaso'
            <?php echo isset($_POST['inkaso']) && $_POST['inkaso'] != Null ? " checked" : ""; ?>>
        <label class="form-check-label" for="inkaso"> pouze účty s možností inkasa</label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type='checkbox' name='vkladomat'
            <?php echo isset($_POST['vkladomat']) && $_POST['vkladomat'] != Null ? " checked" : ""; ?>>
        <label class="form-check-label" for="vladomat"> pouze účty s vkladomaty</label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type='checkbox' name='cashback'
            <?php echo isset($_POST['cashback']) && $_POST['cashback'] != Null ? " checked" : ""; ?>>
        <label class="form-check-label" for="cashback"> pouze účty s možností cashback</label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type='checkbox' name='kontokorent'
            <?php echo isset($_POST['kontokorent']) && $_POST['kontokorent'] != Null ? " checked" : ""; ?>>
        <label class="form-check-label" for="kontokorent"> pouze účty s možností kontokorentu</label>
    </div>
    <div class="form-check">
        <input type='hidden' name='aktiv' value=0 />
        <input class="form-check-input"  type='checkbox' name='aktiv' value=1
            <?php echo !isset($_POST['aktiv']) || (isset($_POST['aktiv']) && $_POST['aktiv'] == 1) ? " checked" : ""; ?>>
        <label class="form-check-label" for="aktiv"> pouze účty v aktuální nabídce bank</label>
    </div>
</div>
</div>
</form>

<?php
$vys_pocet = mysqli_num_rows(vystup_sql('SELECT * FROM vysledky;'));

if ($vys_pocet > 0){
?>
<div id='vystup' class="col-8 ms-5">
<p style='margin-bottom:0px;'>
Zadaným parametrům vyhovuje <b><?php echo $vys_pocet; ?></b> účtů.
</p>
<TABLE name='vystup' class="table table-hover">
<thead>
    <TR>
        <TH rowspan=2>Pořadí</TH>
        <TH rowspan=2>Účet</TH>
        <TH colspan=2 style='height:25;'>Měsíční poplatky</TH>
        <TH rowspan=2>Detaily</TH>
    </TR>
    <TR>
        <TH style='height:25;'>Min.</TH>
        <TH style='height:25;'>Max.</TH>
    </TR>
</thead>

<?php

$sql_list = "SELECT * FROM vysledky ORDER BY min ASC, max ASC, platnost_od ASC";
$list = vystup_sql($sql_list);

$id = 0;
while($r_list = mysqli_fetch_assoc($list)){
++$id;
echo "<TR".($id <= 3 ? " style='background-color:#00FF66;'" : "").">
<TD style='text-align:center'>$id.</TD>
<TD><a href='".$r_list['www']."' target='_blank'>".$r_list['ucet']."</a>
<br /><span style='font-size:small'>".$r_list['typ_uctu']."<br>".$r_list['banka']."</span></TD>
<TD style='font-size:large; font-weight:bold'>".$r_list['min'].($r_list['vyj_id'] == 1 ? '*' : '')."</TD>
<TD ".($r_list['min'] == $r_list['max'] ? "style='font-weight:bold'" : "").">".$r_list['max']."</TD>
<TD style='font-size:small;vertical-align:center;'>
<div style='display:inline-block;padding-right:5px;'>
Banking: ".$r_list['banking']."
<br />Věkové rozmezí: ".$r_list['vek']."
</div>

<FORM action='detail.php' method='POST' target='_blank'>
<INPUT type='hidden' name='ucet_id' value=".$r_list['ucet_id'].">
<INPUT type='hidden' name='vek' value='$vek'>
<INPUT type='hidden' name='prich' value='$prich'>
<INPUT type='hidden' name='odch_std' value='$odch_std'>
<INPUT type='hidden' name='odch_tp' value='$odch_tp'>
<INPUT type='hidden' name='banking' value=".implode(',', $banking).">
<INPUT type='hidden' name='vypis' value='$vypis'>
<INPUT type='hidden' name='karta' value='$karta'>
<INPUT type='hidden' name='karta_vybery' value='$karta_vybery'>
<div style='display:inline-block;float:right'>
  <input type='submit' name='ukaz_detail' value='Detail výpočtu ceny >>' style='font-size:small;letter-spacing:1;min-height:30px;'>
</div>
</FORM>
</TD></TR>";
}
?>

</TABLE>

<p style='font-size:16px;'>
* minimální cena při splnění různých podmínek, přesnou cenu na míru spočítá podrobná <u>interaktivní kalkulačka</u> v detailech konkrétního účtu
</p>
</div>
</div>
 
<?php
} else {
?>

<div id='vystup' class="col-8 ms-5">
<p style='margin-bottom:0px;'>
Zadaným parametrům nevyhovuje žádný účet.
</p>
</div>
<?php
}

if($id_spojeni)
{
    mysqli_close($id_spojeni);
    //echo 'odpojeno <br />';
}

include '../../footer.php';
?>

</BODY>
</HTML>
