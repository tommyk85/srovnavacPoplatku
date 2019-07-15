<html>
<head>
<meta charset="utf-8">

<LINK rel="shortcut icon" href="..\favicon.ico" type="image/x-icon" />
<LINK rel="stylesheet" type="text/css" href="..\styly.css">
<title>Srovnávač - administrace</title>

<script langauge=javascript>

function showSporInput(){
var ucetTyp = document.getElementsByName('ucetTyp')[1];
var fsSpor = document.getElementById('fs_spor');
//console.log(ucetTyp.children.length);
  
  for(var i = 0; i < ucetTyp.children.length; i++){
    if(ucetTyp[i].value == 'sporici' && ucetTyp[i].selected === true){
    fsSpor.style.display = 'block';
    }
    
    else{
    fsSpor.style.display = 'none';
    }
  }
}

</script>

</head>
<body <?php echo (isset($_GET['oprava_popl']) || isset($_GET['oprava_ucet']) || (isset($_GET['oprava_karty']) && $_GET['oprava_karty'] <> "" && $_GET['oprava_karty'] <> "Potvrdit") ? "bgcolor=#FFF080" : "bgcolor=#FFFFFF"); ?> 
text="#000000" onLoad='javascript:showSporInput()'>

<?php
session_start(); 
if($_SESSION['login']!=true)
die ("neoprávněný přístup");  
?>


<!-- ÚKOLY
- při zápisu nových cen zavést kontrolu již vložených datumů, aby se nevyskytoval jeden datum k účtu dvakrát
- ke každému účtu v administraci zobrazit datum posledního a platného vloženého ceníku
-->


<a href='/srovnavacPoplatku/admin_page/admin.php' accesskey='r'>RESET</a>
| <a href='/srovnavacPoplatku/admin_page/admin.php?ucet=36&nazevUctu=mKonto&kodBanky=6210&r_cena_d=0&s_popl_karty=Spravovat+poplatky+karet+k+%C3%BA%C4%8Dtu+%282%29&id=81&ucet_vzor=0&platnostOd=2017-05-02&zrizeniUctu=0.00&zrizeniIB=0.00&zrizeniMB=0.00&zrizeniTB=0.00&zrizeniTP_IB=0.00&zrizeniTP_MB=0.00&zrizeniTP_TB=40.00&zruseniUctu=0.00&koment_JP=no+comment&vedeniUctu_podm=0&vedeniUctu=0.00&vedeniIB=0.00&vedeniMB=0.00&vedeniTB=0.00&vypisE=0.00&vypisP=50.00&koment_PP=no+comment&prichozi1=0.00&prichozi2=0.00&odchoziTP1=0.00&odchoziTP2=0.00&odchoziOn1=0.00&odchozi1_IB=0.00&odchozi1_MB=0.00&odchozi1_TB=40.00&odchozi2_IB=0.00&odchozi2_MB=0.00&odchozi2_TB=40.00&odchoziP=&koment_trans=no+comment&inkSvoleni=0.00&inkOdch=0.00&koment_ink=no+comment&kontZrizeni=0.00&kontVedeni=0.00&kontZruseni=0.00&koment_kont=no+comment'>TEST</a>                                     
| <a href='/srovnavacPoplatku/srovnavac/bezne_ucty'>SROVNÁVAČ</a>


<?php
include "../pripojeni_sql.php";
include "../sql_queries.php";

$footer = "<BR>
<div style='background-color:red; text-align:center; position:fixed; color:white; bottom:0px; width:100%; font-size:small'>&copy;2013+, Nulovepoplatky.cz, Všechna práva vyhrazena. Optimalizováno pro Google Chrome (<a href='http://www.google.com/chrome' target='_blank'>zde</a> ke stažení) v rozlišení 1280 x 1024 px.</div>";



//-- NASTAVENÍ BANKY A DETAILŮ ÚČTU

$sql_banky = "SELECT kod_banky, nazev_banky, count(ucet_ID) as pocet_uctu FROM banky LEFT JOIN ucty ON banky.kod_banky = ucty.ucet_kod_banky
WHERE banky.active=1 
GROUP BY kod_banky 
ORDER BY nazev_banky ASC";
$banky = vystup_sql($sql_banky);

?>
<H1>ADMINISTRACE</H1>

<?php

$note = isset($_GET['note']) ? $_GET['note'] : "";
echo "<p style='color:green; font-weight:bold; font-size:small'>$note</p>";


if((isset($_GET['oprava_ucet'])) || isset($_GET['s_ucet']) || !(isset($_GET['r_cena_d']) || isset($_GET['vyber_id']) || isset($_GET['s_popl_ucet'])) || (isset($_GET['ucet']) && $_GET['ucet'] == "new")){



?>
<H2>Seznam účtů</H2>
<FORM name="ucty_admin" method="GET" action="">

Vyber banku: <SELECT name="banka"<?php echo (isset($_GET['banka']) && $_GET['banka'] <> "") || isset($_GET['ucet']) ? " disabled" : ""; ?>>
<OPTION value=""></OPTION>
<?php
$banka = isset($_GET['banka']) ? $_GET['banka'] : (isset($_GET['kodBanky']) ? $_GET['kodBanky'] : Null);
while($radek_banky = mysql_fetch_assoc($banky))
{
     echo "<OPTION value=".$radek_banky['kod_banky'].($radek_banky['kod_banky'] == $banka ? ' selected' : '').">".$radek_banky['nazev_banky'].($radek_banky['pocet_uctu'] > 0 ? " (".$radek_banky['pocet_uctu'].")" : "")."</OPTION>";
}
?>                                                                    
</SELECT>

<INPUT type="submit" name="vyber_banku" value="Vybrat"<?php echo (isset($_GET['banka']) && $_GET['banka'] <> "") || isset($_GET['ucet']) ? " disabled" : ""; ?>>

<?php

if((!isset($_GET['kodBanky']) && !isset($_GET['banka'])) || (isset($_GET['banka']) && $_GET['banka'] == ""))
die("</FORM>$footer");

$sql_ucty_banky = "SELECT *, count(cena_id) as pocet_cen, max(cena_platnost_od) as posl_cena FROM ucty LEFT JOIN ucty_ceny ON ucty.ucet_ID = ucty_ceny.cena_ucet_id
WHERE ucet_kod_banky = $banka 
GROUP BY ucet_ID
ORDER BY ucet_typ ASC, ucet_active ASC, ucet_nazev ASC";
$ucty_banky = vystup_sql($sql_ucty_banky);

?>                              
<BR>
Vyber účet: 
<INPUT type='hidden' name='banka' value='<?php echo $banka; ?>'>
<span style='font-weight:bold;'>aktivní</span>, <span style='color:red;font-style:italic;'>aktivně nenabízený</span>, <span style='color:silver;font-style:italic;'>neaktivní</span><br />
<SELECT name="ucet">
<OPTION value=""<?php echo (isset($_GET['vyber_banku']) && isset($_GET['ucet']) && $_GET['ucet'] <> "" ? " selected" : Null); ?>></OPTION>

<?php
$ub_typ = '';
while($radek_ucty_banky = mysql_fetch_assoc($ucty_banky))
{
  if($ub_typ != $radek_ucty_banky['ucet_typ']){echo "<optgroup label='".strtoupper($radek_ucty_banky['ucet_typ'])."' />";} 
    
    echo "<OPTION value='".$radek_ucty_banky['ucet_ID']."'".(isset($_GET['ucet']) && $_GET['ucet'] == $radek_ucty_banky['ucet_ID'] ? ' selected' : '').($radek_ucty_banky['ucet_active'] == 2 ? 
    " style='color:red;font-style:italic;'" : ($radek_ucty_banky['ucet_active'] == 0 ? " style='color:silver;font-style:italic;'" : " style='font-weight:bold;'")).">".
    $radek_ucty_banky['ucet_nazev'].($radek_ucty_banky['pocet_cen'] > 0 ? " (".$radek_ucty_banky['pocet_cen'].") <span style='font-style:italic;'>- last update ".$radek_ucty_banky['posl_cena'].
    "</span>" : "")."</OPTION>";
    
    $ub_typ = $radek_ucty_banky['ucet_typ'];
}
?>
<OPTION value="new" <?php echo(isset($_GET['ucet']) && $_GET['ucet'] == "new" ? "selected" : ""); ?>>VYTVOŘIT NOVÝ ÚČET</OPTION>
</SELECT>
<INPUT type="submit" name="vyber_ucet" value="Vybrat">
<a href='/srovnavacPoplatku/admin_page/admin.php?banka=<?php echo isset($_GET['kodBanky']) ? $_GET['kodBanky'] : $_GET['banka']; ?>&vyber_banku=Vybrat'>vybrat jiný</a>
<?php

if(!isset($_GET['ucet']) || $_GET['ucet'] == "" || isset($_GET['vyber_banku']))
die("</FORM>$footer");


elseif(isset($_GET['zalozeni']))
{
//echo 'ucet zalozit';
$ucetID = $_GET['ucet'];
//$cena_ID = Null;
$kodBanky = $_GET['kodBanky'];
$nazevUctu = $_GET['nazevUctu'];
$ucetTyp = $_GET['ucetTyp'];
$mena = $_GET['mena'];
$minLimit = $_GET['minLimit'];
$urokUcet = $_GET['urokUcet'];
$vekOd = $_GET['vekOd'];
$vekDo = $_GET['vekDo'] == Null ? 99 : $_GET['vekDo'];
$www = $_GET['www'];
$koment_ucet = $_GET['koment_ucet'] == "" ? "no comment" : $_GET['koment_ucet'];
$aktiv = $_GET['aktiv'];
$sporPovBez = $_GET['pov_bezny'];
$sporOdchLimit = $_GET['odch_limit'];
}

elseif($_GET['ucet'] == "new")
{
//echo 'ucet new';
$ucetID = 0;
//$kodBanky = $banka;
$nazevUctu = Null;
$ucetTyp = Null;
$mena = Null;
$minLimit = "";
$urokUcet = "";                                                                     
$vekOd = "";
$vekDo = "";
$www = "http://";
$koment_ucet = "no comment";
$aktiv = 1;
$sporPovBez = "";
$sporOdchLimit = "";
}

elseif(isset($_GET['ulozit_ucet'])){               // ZMENA NASTAVENI UCTU
//echo 'ucet ulozit';
$vekDo = $_GET['vekDo'] == Null ? 99 : $_GET['vekDo'];

$sql_zmena_uctu = "UPDATE ucty SET ucet_nazev='".$_GET['nazevUctu']."', 
ucet_typ='".$_GET['ucetTyp']."', 
ucet_mena='".$_GET['mena']."', 
".($_GET['minLimit'] == Null ? "ucet_min_limit=Null, " : "ucet_min_limit=".$_GET['minLimit'].", ")."
".($_GET['urokUcet'] == Null ? "ucet_urok=Null, " : "ucet_urok=".$_GET['urokUcet'].", ")."  
".($_GET['vekOd'] == Null ? "ucet_vek_od=Null, ucet_vek_do=Null, " : "ucet_vek_od=".$_GET['vekOd'].", ucet_vek_do=$vekDo, ")."  
ucet_www='".$_GET['www']."', 
".($_GET['koment_ucet'] == Null ? "ucet_koment='no comment'" : "ucet_koment='".$_GET['koment_ucet']."'").",
ucet_active = ".$_GET['aktiv'].",  
".($_GET['ucetTyp'] == 'sporici' && $_GET['pov_bezny'] == Null ? "ucet_spor_pov_bezny=0" : "ucet_spor_pov_bezny='".$_GET['pov_bezny']."'").",
".($_GET['ucetTyp'] == 'sporici' && $_GET['odch_limit'] == Null ? "ucet_spor_odch_limit=0" : "ucet_spor_odch_limit='".$_GET['odch_limit']."'")."
WHERE ucet_ID=".$_GET['ucet'];
$zmena_uctu = vystup_sql($sql_zmena_uctu);

echo "<meta http-equiv='refresh' content='0;url=/srovnavacPoplatku/admin_page/admin.php?banka=".$_GET['kodBanky']."&ucet=".$_GET['ucet']."&note=Změny účtu uloženy.'>";
}

else{
//echo 'ucet else';
$ucetID = $_GET['ucet'];  
$cenaID_htm = isset($_GET['id']) && $_GET['id'] > 0 ? "&id=".$_GET['id'] : "";

$sql_ucet_d = "SELECT * FROM ucty 
LEFT JOIN ucty_ceny ON ucty.ucet_ID = ucty_ceny.cena_ucet_ID
WHERE ucet_ID = $ucetID ORDER BY cena_platnost_od DESC";
$ucet_d = vystup_sql($sql_ucet_d);

$ucetID = mysql_result($ucet_d, 0, 0);
$banka = mysql_result($ucet_d, 0, 1);
$nazevUctu = mysql_result($ucet_d, 0, 2); // isset($_GET['kodBanky']) ? $_GET['kodBanky'] : Null;
// = isset($_GET['nazevUctu']) ? $_GET['nazevUctu'] : Null;
$ucetTyp = mysql_result($ucet_d, 0, 3);
$mena = mysql_result($ucet_d, 0, 4);
$minLimit = mysql_result($ucet_d, 0, 5);
$urokUcet = mysql_result($ucet_d, 0, 6);
$vekOd = mysql_result($ucet_d, 0, 7);
$vekDo = mysql_result($ucet_d, 0, 8);
$www = mysql_result($ucet_d, 0, 9);
$koment_ucet = mysql_result($ucet_d, 0, 10);
$aktiv = mysql_result($ucet_d, 0, 11);
$sporOdchLimit = mysql_result($ucet_d, 0, 12);
$sporPovBez = mysql_result($ucet_d, 0, 13);
}

$ucet_readonly = !isset($_GET['oprava_ucet']) && $_GET['ucet'] <> "new" ? " readonly" : "";
$vyj_url = "/srovnavacPoplatku/admin_page/vyjimky.php?kodBanky=$banka&ucet=$ucetID";
?>

<H3>Detaily účtu</H3>
Aktivní účet: 
<INPUT type='radio' name='aktiv' value=0<?php echo ($aktiv == 0 ? ' checked' : '').(!isset($_GET['oprava_ucet']) && $_GET['ucet'] <> "new" ? " disabled" : ""); ?> /> neaktivní
<INPUT type='radio' name='aktiv' value=1<?php echo ($aktiv == 1 ? ' checked' : '').(!isset($_GET['oprava_ucet']) && $_GET['ucet'] <> "new" ? " disabled" : ""); ?> /> aktivní
<INPUT type='radio' name='aktiv' value=2<?php echo ($aktiv == 2 ? ' checked' : '').(!isset($_GET['oprava_ucet']) && $_GET['ucet'] <> "new" ? " disabled" : ""); ?> /> aktivní, ale nenabízený<br />

Kód banky*: <INPUT type="text" name="kodBanky" value="<?php echo "$banka";?>" size=4 style="text-align:right" readonly>
ID účtu: <INPUT type="text" name="ucet" value="<?php echo $ucetID; ?>" size=3 style="text-align:right" readonly><BR>
Název účtu*: <INPUT type="text" name="nazevUctu" value="<?php echo $nazevUctu; ?>" size=20 maxlength=55<?php echo $ucet_readonly;
echo ($_GET['ucet'] == "new" ? " class='chybi' " : ""); ?>><BR>
Typ účtu*:
<INPUT type='hidden' name="ucetTyp" value='<?php echo $ucetTyp; ?>' />
<SELECT name="ucetTyp"<?php echo (!isset($_GET['oprava_ucet']) && $_GET['ucet'] <> "new" ? " disabled" : "");
echo ($_GET['ucet'] == "new" ? " class='chybi' " : ""); ?> onChange = showSporInput();>
<OPTION value=""></OPTION>
<OPTION value="bezny"<?php echo ($ucetTyp == "bezny" ? " selected" : ""); ?>>běžný účet</OPTION>
<OPTION value="bezny-stu"<?php echo ($ucetTyp == "bezny-stu" ? " selected" : ""); ?>>studentský účet</OPTION>
<OPTION value="bezny-det"<?php echo ($ucetTyp == "bezny-det" ? " selected" : ""); ?>>dětský účet</OPTION>
<OPTION value="bezny-pod"<?php echo ($ucetTyp == "bezny-pod" ? " selected" : ""); ?>>podnikatelský účet</OPTION>
<OPTION value="sporici"<?php echo ($ucetTyp == "sporici" ? " selected" : ""); ?>>spořící účet</OPTION>
</SELECT>

<fieldset id='fs_spor' style='display:none;' <?php echo (!isset($_GET['oprava_ucet']) && $_GET['ucet'] <> "new" ? " disabled" : "");?>>
<legend>Parametry spořícího účtu</legend>
Povinný běžný účet:
<input type='checkbox' name='pov_bezny' value=1 <?php echo ($sporPovBez == 1 ? " checked" : ""); ?> />

<br />
Omezení odchozích plateb:
<select name='odch_limit'>
<option value=0 <?php echo ($sporOdchLimit == 0 ? " selected" : ""); ?> /> Bez omezení
<option value=1 <?php echo ($sporOdchLimit == 1 ? " selected" : ""); ?> /> Jen v rámci banky a účtů klienta
<option value=2 <?php echo ($sporOdchLimit == 2 ? " selected" : ""); ?> /> Jen na klientem předem definované účty
</select>
</fieldset><br />

Měna účtu*: <SELECT name='mena'<?php echo (!isset($_GET['oprava_ucet']) && $_GET['ucet'] <> "new" ? " disabled" : ""); ?>>
<OPTION value='CZK'<?php echo ($mena == "CZK" ? " selected" : ""); ?>>CZK</OPTION>
<OPTION value='EUR'<?php echo ($mena == "EUR" ? " selected" : ""); ?>>EUR</OPTION>
</SELECT><BR>
Minimální zůstatkový limit: <INPUT type="number" name="minLimit" value="<?php echo $minLimit; ?>" style="text-align:right; width:65"<?php echo $ucet_readonly;
echo ($minLimit == "" ? " class='chybi'" : ""); ?>><BR>
Úrok na účtu: <INPUT type="text" name="urokUcet" value="<?php echo $urokUcet; ?>" maxlength=5 style="text-align:right; width:60"<?php echo $ucet_readonly;
echo ($urokUcet == "" ? " class='chybi'" : ""); ?>>% <?php echo ($_GET['ucet'] <> "new" ? "<a href='$vyj_url&vyj_pole=urok&vyj_name=úrok&vyj_puv=$urokUcet#vyj' tabindex='-1'>[výjimka]</a>" : ""); ?><BR />
Věk od: <INPUT type="number" name="vekOd" value="<?php echo $vekOd; ?>" maxlength=3 style="text-align:right; width:60"<?php echo $ucet_readonly;
echo ($vekOd == "" ? " class='chybi'" : ""); ?>>
do: <INPUT type="number" name="vekDo" value="<?php echo $vekDo; ?>" maxlength=3 style="text-align:right; width:60"<?php echo $ucet_readonly;
echo ($vekDo == "" ? " class='chybi'" : ""); ?>><BR> 
WWW: <?php echo (!isset($_GET['oprava_ucet']) && $_GET['ucet'] <> "new" ? "<a href='$www' target='_blank'>$www</a>" : "<INPUT type='text' name='www' value='$www' size=80 $ucet_readonly".($_GET['ucet'] == "new" ? " class='chybi' " : "")." />"); ?><BR />
Komentář: <BR><TEXTAREA name="koment_ucet" cols=80 rows=6<?php echo $ucet_readonly; ?>><?php echo $koment_ucet; ?></TEXTAREA><BR>

<INPUT type="submit" name="zalozeni" value="Založit nový účet"<?php 

if(isset($_GET['zalozeni']))                 // ZALOZENI NOVEHO UCTU
{
$sql_zal_ucet = "INSERT INTO ucty (ucet_kod_banky, ucet_nazev, ucet_typ, ucet_mena, ucet_min_limit, ucet_urok, ucet_vek_od, ucet_vek_do, ucet_www, ucet_koment".
($_GET['ucetTyp'] == 'sporici' ? ", ucet_spor_pov_bezny, ucet_spor_odch_limit" : "").")
VALUES ('$kodBanky', '$nazevUctu', '$ucetTyp', '$mena', ".($minLimit=="" ? 'Null' : $minLimit).", ".($urokUcet=="" ? 'Null' : $urokUcet).", ".($vekOd=="" ? "Null, Null" : "$vekOd, $vekDo").", '$www', '$koment_ucet'".
($_GET['ucetTyp'] == 'sporici' ? ", $sporPovBez, $sporOdchLimit" : "").")";
$zal_ucet = vystup_sql($sql_zal_ucet);

echo " disabled>";

$sql_max_id = "SELECT max(ucet_ID) FROM ucty";
$max_id = vystup_sql($sql_max_id);
$ucetID = mysql_result($max_id, 0, 0);
echo "<meta http-equiv='refresh' content='0;url=/srovnavacPoplatku/admin_page/admin.php?banka=".$_GET['kodBanky']."&ucet=$ucetID&note=Účet založen.#poplatky'>";
}

elseif($_GET['ucet'] == "new")
die("></FORM>$footer");

else
echo " disabled>";

  if(!isset($_GET['oprava_ucet'])){
  echo "<INPUT type='submit' name='oprava_ucet' value='Upravit účet'>";
  echo "<INPUT type='submit' name='vyber_id' value='Zobrazit poplatky' accesskey='z'>";
  echo "<A href='../srovnavac/bezne_ucty/detail.php?id=".$_GET['ucet']."'' tartet='_blank'> Zobrazit detail ve srovnávači</A>";
  }  
  
  else
  die ("<INPUT type='submit' name='ulozit_ucet' value='Uložit změny účtu'>");
/*echo "<BR><SELECT name='id'>";
echo "<OPTION value=".mysql_result($ucet_d, 0, 9).">".mysql_result($ucet_d, 0, 9)." - platnost od ".mysql_result($ucet_d, 0, 11)."</OPTION>";
while($radek_ucet_d = mysql_fetch_assoc($ucet_d)){
echo "<OPTION value=".$radek_ucet_d['cena_id'].">".$radek_ucet_d['cena_id']." - platnost od ".$radek_ucet_d['cena_platnost_od']."</OPTION>";
}
echo "<OPTION value=0>0 - založit nové poplatky</OPTION>";
echo "</SELECT>";       */
echo "<INPUT type='hidden' name='id' value=".(mysql_result($ucet_d, 0, 16) != Null ? mysql_result($ucet_d, 0, 16) : 0).">";
echo "<INPUT type='hidden' name='r_cena_d' value=0>";

echo "</FORM>";
}

elseif(!(isset($_GET['s_popl_karty']) || isset($_GET['oprava_karty'])) && $_GET['ucetTyp']=='sporici'){include('popl_spor_ucty.php');}

elseif(!(isset($_GET['s_popl_karty']) || isset($_GET['oprava_karty']))){include('popl_bezne_ucty.php');}

elseif(isset($_GET['s_popl_karty']) || isset($_GET['oprava_karty'])){
header("location:admin_karty.php?kodBanky=".$_GET['kodBanky']."&ucet=".$_GET['ucet']."&nazevUctu=".$_GET['nazevUctu']."&id=".$_GET['id']."&r_cena_d=".$_GET['r_cena_d']);}

else
echo "neznámý odkaz";





if($id_spojeni)
{
  mysql_close($id_spojeni);
//  echo 'odpojeno <br>';
} 
?>

<BR>

<?php echo $footer; ?>
                                                                
                                                                       
</BODY>
</HTML>
