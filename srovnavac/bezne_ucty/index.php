<!doctype html>
<html>
<head>

<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

<LINK rel="shortcut icon" href="..\..\favicon.ico" type="image/x-icon" />
<LINK rel="stylesheet" type="text/css" href="..\..\styly.css">
<title>Srovnávač poplatků bank</title>
</head>

<body bgcolor="#FFFFFF" text="#000000">

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

    <script src="../../core/scripty.js"></script>
    <script src="../scripty/souhrn.js"></script>

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

        var browser=get_browser_info();

        if(browser.name != "Chrome" && browser.name != "Firefox"){

            var b_text = "Vámi používaný prohlížeč (" + browser.name + browser.version + ") není plně podporován, může tak docházet k nesprávnému formátování stránky, v horším případě i nepřesným výpočtům. K dosažení požadovaného výsledku doporučuji použít Google Chrome (odkaz ke stažení v zápatí).";

            //alert(b_text);
            document.write("<span style='color:red;font-style:italic;'>"+b_text+"</span>");
        }
    
    </script>

<?php
include_once("analyticstracking.php");
include "../../core/db/pripojeni_sql.php";
include "../../common/format.php";

include '../header.php';
?>

<H1>SROVNÁVAČ měsíčních poplatků - běžné účty</H1>

<p style='margin-bottom:50px;'>Změnou parametrů (a filtrů) se automaticky přepočítá a přefiltruje výsledný seznam účtů. </p>


<?php
$sql_table = "CREATE TEMPORARY TABLE vysledky (
  cena_id INT NOT NULL,
  ucet_id INT NOT NULL,
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
  vyj_id INT NULL,  
  PRIMARY KEY (ucet_id))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_czech_ci";

$table = vystup_sql($sql_table); 

include "vypocet.php"; 


?>

<div id='filtr' onChange='rekalkul()'>
<H2>Parametry</H2>
<form action='' method='post' id='f'>

                                                 

<H3>.. k filtraci účtů</H3>
Zahrnuté typy účtu <?php echo "(v $mena)"; ?>: <select name='typ'>
<option value='vse'<?php echo isset($_POST['typ']) && $_POST['typ'] == 'vse' ? ' selected' : ''; ?>>všechny dle věku</option>
<option value='bezny'<?php echo isset($_POST['typ']) && $_POST['typ'] == 'bezny' ? ' selected' : ''; ?>>pro fyzické osoby nepodnikatele</option>
<option value='bezny-stu'<?php echo isset($_POST['typ']) && $_POST['typ'] == 'bezny-stu' ? ' selected' : ''; ?>>studentské</option>
<option value='bezny-det'<?php echo isset($_POST['typ']) && $_POST['typ'] == 'bezny-det' ? ' selected' : ''; ?>>dětské</option>
<option value='bezny-pod' disabled>podnikatelské (v plánu)</option>
</select> 
<br />
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
<input type='checkbox' name='banking[]' value='o'<?php echo (in_array('o', $banking) ? ' checked' : Null) ?>> s možností plateb přímo u obchodníka (v e-shopech)</div><br> 
<input type='checkbox' name='banking[]' value='m'<?php echo (in_array('m', $banking) ? ' checked' : Null) ?>> mobilní/smart<br> 
<input type='checkbox' name='banking[]' value='t'<?php echo (in_array('t', $banking) ? ' checked' : Null) ?>> telefonní 
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

<!--
<TR><TD colspan=3 style='padding:10;text-align:center'><input type='submit' value='Přepočítat výsledky' style='width:200; padding:3; letter-spacing:2'></TD></TR>
-->
</TABLE>

</div>

<div id='pokr' onChange='rekalkul()'>

<H3>Pokročilý filtr</H3>
<input type='checkbox' name='disponent'
<?php echo isset($_POST['disponent']) && $_POST['disponent'] != Null ? " checked" : ""; ?>><label> pouze účty s možností disponenta</label><br />
<input type='checkbox' name='vedeniBezPod'
<?php echo isset($_POST['vedeniBezPod']) && $_POST['vedeniBezPod'] != Null ? " checked" : ""; ?>><label> pouze účty s vedením bez podmínek</label><br />
<input type='checkbox' name='inkaso'
<?php echo isset($_POST['inkaso']) && $_POST['inkaso'] != Null ? " checked" : ""; ?>><label> pouze účty s možností inkasa</label><br />
<input type='checkbox' name='vkladomat'
<?php echo isset($_POST['vkladomat']) && $_POST['vkladomat'] != Null ? " checked" : ""; ?>><label> pouze účty s vkladomaty</label><br />
<input type='checkbox' name='cashback'
<?php echo isset($_POST['cashback']) && $_POST['cashback'] != Null ? " checked" : ""; ?>><label> pouze účty s možností cashback</label><br />
<input type='checkbox' name='kontokorent'
<?php echo isset($_POST['kontokorent']) && $_POST['kontokorent'] != Null ? " checked" : ""; ?>><label> pouze účty s možností kontokorentu</label><br />
<input type='hidden' name='aktiv' value=0 />
<input type='checkbox' name='aktiv' value=1
<?php echo !isset($_POST['aktiv']) || (isset($_POST['aktiv']) && $_POST['aktiv'] == 1) ? " checked" : ""; ?>><label> pouze účty v aktuální nabídce bank</label><br />
</div>
</form>
<?php //echo $_POST['aktiv']; ?>

<p style='margin-bottom:50px;'>
Zadaným parametrům vyhovuje <b><?php echo $vys_pocet = mysqli_num_rows(vystup_sql('SELECT * FROM vysledky;')); ?></b> účtů.
</p>

<?php

if ($vys_pocet > 0){
?>
<div id='vystup'>

<TABLE name='vystup'> 
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
<?php


$list_order = isset($_POST['order']) ? $_POST['order'] : "min ASC, max ASC";


$sql_list = "SELECT * FROM vysledky ORDER BY $list_order, platnost_od ASC";
$list = vystup_sql($sql_list);

$id = 0;
while($r_list = mysqli_fetch_assoc($list)){
++$id;
echo "<TR".($id <= 3 ? " style='background-color:#00FF66;'" : "")."><FORM action='detail.php' method='POST' target='_blank'><input type='hidden' name='ucet_id' value=".$r_list['ucet_id'].">
<TD style='text-align:center'>$id.</TD>
<TD><a href='".$r_list['www']."' target='_blank'>".$r_list['ucet']."</a>
<br><span style='font-size:small'>".$r_list['typ_uctu']."<br>".$r_list['banka']."</span></TD>
<TD style='text-align:right; font-size:large; font-weight:bold'>".$r_list['min'].($r_list['vyj_id'] == 1 ? '*' : '')."</TD>
<TD style='text-align:right".($r_list['min'] == $r_list['max'] ? ";font-weight:bold" : "")."'>".$r_list['max']."</TD>
<TD style='font-size:small;vertical-align:center;'>
<div style='display:inline-block;padding-right:5px;'>
Banking: ".$r_list['banking']."
<br>Věkové rozmezí: ".$r_list['vek']."
</div>
<div style='display:inline-block;float:right'>
  <input type='submit' name='ukaz_detail' value='Detail výpočtu ceny >>' style='font-size:small;letter-spacing:1;min-height:30px;'>
</div>
</TD>

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

<INPUT type='hidden' name='vek' value='$vek'>
<INPUT type='hidden' name='prich' value='$prich'>
<INPUT type='hidden' name='odch_std' value='$odch_std'>
<INPUT type='hidden' name='odch_tp' value='$odch_tp'>
<INPUT type='hidden' name='banking' value=".implode(',', $banking).">
<INPUT type='hidden' name='vypis' value='$vypis'>
<INPUT type='hidden' name='karta' value='$karta'>
<INPUT type='hidden' name='karta_vybery' value='$karta_vybery'>
</FORM></TR>";
}
?>


</TD></TR>
</TABLE>

<p style='font-size:16px;'>
* minimální cena při splnění různých podmínek, přesnou cenu na míru spočítá podrobná <u>interaktivní kalkulačka</u> v detailech konkrétního účtu
</p>
</div>


 
<?php
}


if($id_spojeni)
{
  mysqli_close($id_spojeni);
echo 'odpojeno <br>';
}

include '../../footer.php';
?>


</BODY>
</HTML>
