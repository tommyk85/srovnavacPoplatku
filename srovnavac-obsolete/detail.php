<?php

if(isset($_POST['ukaz']))
{

$vedeni_text = implode(',', $_POST['vedeni_text']);

$vedeni_text0 = substr($vedeni_text, 0, strrpos($vedeni_text, "-0-"));
$vedeni_text1 = strpos($vedeni_text, "-1-") === false ? Null : substr($vedeni_text, strpos($vedeni_text, "-1-") +2, strrpos($vedeni_text, "-1-") - (strpos($vedeni_text, "-1-") +2));
$vedeni_text2 = strpos($vedeni_text, "-2-") === false ? Null : substr($vedeni_text, strpos($vedeni_text, "-2-") +2);


$karta_text = implode(',', $_POST['karta_text']);
/*
$karta_text0 = substr($karta_text, 0, strrpos($karta_text, "-0-")); 
$karta_text1 = strpos($karta_text, "-1-") === false ? Null : substr($karta_text, strpos($karta_text, "-1-") +2, strrpos($karta_text, "-1-") - (strpos($karta_text, "-1-") +2));
$karta_text2 = strpos($karta_text, "-2-") === false ? Null : substr($karta_text, strpos($karta_text, "-2-") +2);
*/

$info_text = implode(',', $_POST['info_text']);

$info_text0 = substr($info_text, 0, strrpos($info_text, "-0-")); 
$info_text1 = strpos($info_text, "-1-") > 0 ? substr($info_text, strpos($info_text, "-1-") +2, strrpos($info_text, "-1-") - (strpos($info_text, "-1-") +2)) : Null;
$info_text2 = strpos($info_text, "-2-") > 0 ? substr($info_text, strpos($info_text, "-2-") +2) : Null;


$banking_text = implode(',', $_POST['banking_text']);

$banking_text0 = substr($banking_text, 0, strrpos($banking_text, "-0-"));
$banking_text1 = strpos($banking_text, "-1-") === false ? Null : substr($banking_text, strpos($banking_text, "-1-") +2, strrpos($banking_text, "-1-") - (strpos($banking_text, "-1-") +2));
$banking_text2 = strpos($banking_text, "-2-") === false ? Null : substr($banking_text, strpos($banking_text, "-2-") +2);


$dom_trans_text = implode(',', $_POST['dom_trans_text']);

$dom_trans_text0 = substr($dom_trans_text, 0, strrpos($dom_trans_text, "-0-"));
$dom_trans_text1 = strpos($dom_trans_text, "-1-") === false ? Null : substr($dom_trans_text, strpos($dom_trans_text, "-1-") +2, strrpos($dom_trans_text, "-1-") - (strpos($dom_trans_text, "-1-") +2));
$dom_trans_text2 = strpos($dom_trans_text, "-2-") === false ? Null : substr($dom_trans_text, strpos($dom_trans_text, "-2-") +2);


$vypis_text = implode(',', $_POST['vypis_text']);


//$prichozi = implode(',', $_POST['dom_prichozi']);
$dom_trans = implode(',', $_POST['dom_trans']);

$naklady_max = implode(',', $_POST['vedeni']) + implode(',', $_POST['banking']) + implode(',', $_POST['vypis']) + $dom_trans + implode(',', $_POST['karta']) + implode(',', $_POST['info']);


?>

<html>
<head>
<meta charset="utf-8">

<LINK rel="shortcut icon" href="..\favicon.ico" type="image/x-icon" />
<LINK rel="stylesheet" type="text/css" href="..\styly.css">

<title>Detail k účtu "<?php echo implode(',', $_POST['nazev']) ?>"</title>

</head>
<body bgcolor="#FFFFFF" text="#000000">
<?php include_once("analyticstracking.php") ?>
<TABLE width=1200>

<?php include "header.php";  ?>

<TR>

<TD bgcolor='red' colspan=3></TD>


<TD class='nabidka'><B><U>Detail účtu</U></B></TD>

</TR>

<TR><TD colspan=4>
<br>
<center>

<H2>Podrobný rozpis poplatků - dle zadání - k účtu <U><B><?php echo implode(',', $_POST['nazev'])."</B> (v ".implode(',', $_POST['mena']).")</U>";
if(implode(',', $_POST['platnostDo']) != ''){echo " - s platností do ".implode(',', $_POST['platnostDo']);} ?></H2>

</td></tr>

<tr><td colspan=2 align='center'>

<TABLE width=650 border=1>
<CAPTION>Měsíční náklady</CAPTION>
<TR>
<TD nowrap>Vedení účtu:</TD>
<TD align='right' width=60><?php echo implode(',', $_POST['vedeni']); ?></TD>
</TR>
<?php
if(implode(',', $_POST['vedeni']) > 0 && $vedeni_text0 != Null)
{
echo "<TR><TD colspan=2><FONT color='grey' size=2>$vedeni_text0</FONT></TD></TR>";
}

if($vedeni_text1 != Null)
{
echo "<TR><TD colspan=2 style='background-color: yellowgreen'><FONT size=2>$vedeni_text1</FONT></TD></TR>";
}

if($vedeni_text2 != Null)
{
echo "<TR><TD colspan=2 style='background-color: #F00000; color: white'><FONT size=2>$vedeni_text2</FONT></TD></TR>";
}
?>
<TR>
<TD nowrap>Ovládání účtu:</TD>
<TD align='right'><?php echo implode(',', $_POST['banking']); ?></TD>
</TR>
<?php
if(implode(',', $_POST['banking']) > 0 && $banking_text0 != Null)
{
echo "<TR><TD colspan=2><FONT color='grey' size=2>$banking_text0</FONT></TD></TR>";
}

if($banking_text1 != Null)
{
echo "<TR><TD colspan=2 style='background-color: yellowgreen'><FONT size=2>$banking_text1</FONT></TD></TR>";
}

if($banking_text2 != Null)
{
echo "<TR><TD colspan=2 style='background-color: #F00000; color: white'><FONT size=2>$banking_text2</FONT></TD></TR>";
}
?>
<TR>
<TD nowrap>Výpis z účtu:</TD>
<TD align='right'><?php echo implode(',', $_POST['vypis']); ?></TD>
</TR>

<?php
if($vypis_text != Null)
{
echo "<TR><TD colspan=2><FONT color='grey' size=2>$vypis_text</FONT></TD></TR>";
}
?>

<TR>
<TD nowrap>Tuzemské transakce:</TD>
<TD align='right'><?php echo number_format($dom_trans, 2, '.', ''); ?></TD>
</TR>
<?php 

if($dom_trans > 0)
{
?>
<TR>
<TD colspan=2><?php echo "$dom_trans_text </TD><TR>";} ?>





<?php 

/*

echo "<BR><FONT color='grey' size=2>".implode(',', $_POST['dom_prichozi_text'])."</FONT></UL>";

</TD></TR>

<TR>
<TD colspan=2><UL>Odchozí platby: <?php echo $odchozi; 


echo "<BR><FONT color='grey' size=2>".implode(',', $_POST['dom_odchozi_text'])."</UL>";

echo $dom_trans_text0;

echo "</FONT></TD></TR>";

if($dom_trans_text1 != Null)
{
echo "<TR><TD colspan=2 style='background-color: yellowgreen'><FONT size=2>$dom_trans_text1</FONT></TD></TR>";
}

if($dom_trans_text2 != Null)
{
echo "<TR><TD colspan=2 style='background-color: #F00000; color: white'><FONT size=2>$dom_trans_text2</FONT></TD></TR>";
}
} */




if($karta_text != Null)
{

echo "<TR><TD colspan=2>Debetní karty dostupné k účtu:$karta_text</TD></TR>";

}




if(implode(',', $_POST['info_text']) != Null)
{
?>

<TR>
<TD nowrap>Info služby:</TD>
<TD align='right'><?php echo implode(',', $_POST['info']); ?></TD></TR>
<?php
if(implode(',', $_POST['info']) > 0)
{
echo "<TR><TD colspan=2><FONT color='grey' size=2>$info_text0</FONT></TD></TR>";
}

if($info_text1 != Null)
{
echo "<TR><TD colspan=2 style='background-color: yellowgreen'><FONT size=2>$info_text1</FONT></TD></TR>";
}

if($info_text2 != Null)
{
echo "<TR><TD colspan=2 style='background-color: #F00000; color: white'><FONT size=2>$info_text2</FONT></TD></TR>";
}
}

?>
<TR>
<TD style="border-top-style: solid"><B>Maximální <?php echo $naklady_max < implode(',', $_POST['naklady']) ? "'reálné'" : ''; ?> měsíční náklady celkem:</B></TD>
<TD align='right' style="border-top-style: solid"><B><?php echo number_format($naklady_max, 2, '.', ''); ?></B></TD>
</TR>


<?php
if($naklady_max < implode(',', $_POST['naklady']))
{
echo "<TR>
<TD style='font-size: small'>Opravdu maximální možné měsíční náklady - zahrnuté ve výpočtu - celkem:</TD>
<TD align='right' style='font-size: small'>".implode(',', $_POST['naklady'])."</TD></TR>";
}

?>
</TABLE>

</td>
<td colspan=2 style='vertical-align:top' align='center'>
<TABLE width=400 border=1>
<CAPTION>Jednorázové náklady</CAPTION>
<TR>
<TD nowrap>Zřízení účtu:</TD>
<TD align='right' width=60><?php echo implode(',', $_POST['zrizeni']); ?></TD>
</TR>
<?php
if(implode(',', $_POST['karta_text']) != Null)
{
?>
<TR>
<TD nowrap>Vydání karty <?php echo implode(',', $_POST['karta_typ']) != Null ? "<I><FONT size=2>".implode(',', $_POST['karta_typ'])."</FONT></I>" : Null; ?>:</TD>
<TD align='right' width=60><?php echo implode(',', $_POST['karta_vydani']); ?></TD>
</TR>
<TR>
<TD nowrap>Blokace karty:</TD>
<TD align='right' width=60><?php echo implode(',', $_POST['karta_blok']); ?></TD>
</TR>
<?php
}
?>
<TR>
<TD nowrap>Zrušení účtu:</TD>
<TD align='right' width=60><?php echo implode(',', $_POST['zruseni']); ?></TD>
</TR>
<?php
if(implode(',', $_POST['zruseni_text']) != Null)
{
?>
<TR>
<TD style='background-color:red; color:white' colspan=2><?php echo implode(',', $_POST['zruseni_text']); ?></TD>
</TR>
<?php
}
?>
</TABLE>

<p style='font-size:large; line-height:5'>

Bližší info k tomuto účtu přímo na <a href="<?php echo implode(',', $_POST['www']) ?>" target='_blank'>webových stránkách banky</a>
</p>

<p>

Máte pochybnosti o správnosti výsledku, nebo Vám není něco jasné? Dejte mi o tom, prosím, vědět na <a href="https://www.facebook.com/NulovePoplatky" target='_blank'>facebookových stránkách projektu</a> nebo <a href="mailto:info@nulovepoplatky.cz">emailem</a>.

</td></tr>

<tr><td colspan=4 align='center'>
<br>

<?php

if(implode('', $_POST['vyhody_text']) != Null)
{
echo implode('', $_POST['vyhody_text']);
}

?>

</TD></TR></TABLE> 

<div style='background-color:red; text-align:center; position:fixed; color:white; bottom:0px; width:100%; font-size:small'>&copy;2013, Nulovepoplatky.cz, Všechna práva vyhrazena. Optimalizováno pro Google Chrome (<a href='http://www.google.com/chrome' target='_blank'>zde</a> ke stažení) v rozlišení 1280 x 1024 px.</div>



<?php
}


else
{

$sql_ucty = "SELECT ucty_detail.*, banky.*, ucty.*
FROM (ucty INNER JOIN banky ON ucty.KodBanky = banky.kod_banky)
INNER JOIN ucty_detail ON ucty.ucetID=ucty_detail.ucetID
WHERE exists (SELECT ID FROM poplatky_vysledek WHERE poplatky_vysledek.ID = ucty_detail.ID) ORDER BY ucty_detail.ID ASC";
$ucty = mysql_query($sql_ucty, $id_spojeni);
if (!$ucty)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodařilo se poslat dotaz na ucty.');
} 
//echo 'Dotaz na ucty odeslán.<br>';


if($karta == '1' || $karta == '2'){

$sql_karty = "SELECT karty.*
FROM karty
WHERE exists (SELECT ID FROM poplatky_vysledek WHERE poplatky_vysledek.ID = karty.ID)
ORDER BY ID ASC, Hlavni DESC, Vedeni1 ASC";
$karty = mysql_query($sql_karty, $id_spojeni);
  if (!$karty)
  {
    echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
    die('Nepodařilo se poslat dotaz na karty.');
  } 
  //echo 'Dotaz na karty odeslán.<br>';
}

$transakce = $prichozi + $odchozi;
$obrat = $_POST['prijem'] + $_POST['vydaje'] + $karta_celkem;
 
$sql_banky = "SELECT * FROM banky";
$banky = mysql_query($sql_banky, $id_spojeni);
if (!$banky)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodařilo se poslat dotaz na banky.');
} 
//echo 'Dotaz na banky odeslán.<br>';



$klientu_celkem = 0;

while($radek_banky = mysql_fetch_assoc($banky))
{
$klientu_celkem += $radek_banky['klientu'];
}



/*
$detail = array(

echo explode($radek_ucty);

while($radek_ucty = mysql_fetch_array($ucty))
{

//  array(
//  for($i = 0; $i < 80; $i++){
  
  
  echo explode($radek_ucty);
  
//)
     

}

)


echo $radek_ucty[2][0];
*/





/*
$IDs = array();
while($radek_ucty)
{
$IDs[] = $radek_ucty['ID'];
}
*/

/*
$sql_tab_naklady = "CREATE TEMPORARY TABLE naklady (
ID int(3) unsigned NOT NULL,
Naklady int(10) unsigned NOT NULL,
Vedeni int(10) unsigned,
Banking int(10) unsigned,
Vypis int(10) unsigned,
Dom_prichozi int(10) unsigned,
Dom_odchozi int(10) unsigned,
Info int(10) unsigned)";




//   -----------      docasne naklady je na test.......

$tab_naklady = mysql_query($sql_tab_naklady, $id_spojeni);
if (!$tab_naklady)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodařilo se nám poslat SQL dotaz na vytvoreni tabulky nakladu.');
} 
echo 'Dotaz na vytvoreni tabulky nakladu odeslán.<br>';


$sql_naklady = "INSERT INTO naklady (ID, Naklady)
SELECT ID, Vedeni1
FROM ucty_detail";
$naklady = mysql_query($sql_naklady, $id_spojeni);
if (!$naklady)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodařilo se nám poslat SQL dotaz na vlozeni do tabulky nakladu.');
} 
echo 'Dotaz na vlozeni do tabulky nakladu odeslán.<br>';

//  ------------      konec docasnych nakladu na test.....

*/

include "text_fce.php";


while($radek_ucty = mysql_fetch_assoc($ucty))
{

 
include "poplatky-banky/0100.php";
include "poplatky-banky/0300.php";
include "poplatky-banky/0600.php";
include "poplatky-banky/0800.php";
include "poplatky-banky/2010.php";
include "poplatky-banky/2310.php";
include "poplatky-banky/2600.php";
include "poplatky-banky/2700.php";
include "poplatky-banky/3030.php";
include "poplatky-banky/4000.php";
include "poplatky-banky/5500.php";
include "poplatky-banky/6100.php";
include "poplatky-banky/6210.php";
include "poplatky-banky/6800.php";
  
}


/*
$sql_karty = "SELECT karty.*
FROM karty LEFT JOIN poplatky_vysledek ON karty.ID = poplatky_vysledek.ID
ORDER BY karty.ID ASC";
$karty = mysql_query($sql_karty, $id_spojeni);
if (!$karty)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodařilo se poslat dotaz na karty.');
} 
//echo 'Dotaz na karty odeslán.<br>';

while($radek_karty = mysql_fetch_assoc($karty))
{

#include "poplatky-banky/0100k.php";
include "poplatky-banky/0300k.php";
#include "poplatky-banky/0600k.php";
#include "poplatky-banky/0800k.php";
#include "poplatky-banky/2010k.php";
#include "poplatky-banky/2310k.php";
#include "poplatky-banky/2600k.php";
#include "poplatky-banky/2700k.php";
#include "poplatky-banky/3030k.php";
#include "poplatky-banky/4000k.php";
#include "poplatky-banky/5500k.php";
#include "poplatky-banky/6100k.php";
#include "poplatky-banky/6210k.php";
#include "poplatky-banky/6800k.php";
  
}         */
}
/*

$sql_naklady_do_tab_vysledek = "UPDATE poplatky_vysledek INNER JOIN naklady ON poplatky_vysledek.ID = naklady.ID SET poplatky_vysledek.Naklady = naklady.Naklady";

$naklady_do_tab_vysledek = mysql_query($sql_naklady_do_tab_vysledek, $id_spojeni);
if (!$naklady_do_tab_vysledek)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodařilo se nám poslat SQL dotaz na update nakladu.');
} 
echo 'Dotaz na update nakladu odeslán.<br>';
*/

?>

