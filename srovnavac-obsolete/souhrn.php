 
Všechny níže uvedené <SPAN style='background-color:#D0E0FF'>ceny se vztahují pouze k operacím prováděným přes Internetové bankovnictví.</SPAN> Rozšíření na ostatní možnosti ovládání účtu je v plánu po zpracování poplatků všech účtů za Internetové bankovnictví. Do té doby slouží výběr Ovládání účtu v kroku 1 pouze k odfiltrování účtů splňujících Vaše požadavky. 



<?php

if($_POST['typ'] == 'bezny')
{
?>

<form action='' method='post'>

<input type='hidden' name='typ' value='<?php echo $typ = $_POST['typ']; ?>'>
<input type='hidden' name='mena' value='<?php echo $mena = $_POST['mena']; ?>'>
<input type='hidden' name='zustatek' value='<?php echo $zustatek = $_POST['zustatek']; ?>'>
<input type='hidden' name='banking' value='<?php echo $banking = $_POST['banking']; ?>'>
<?php $banking = explode(',', $_POST['banking']); ?>
<input type='hidden' name='info' value='<?php echo $info = $_POST['info']; ?>'>
<input type='hidden' name='karta' value='<?php echo $karta = $_POST['karta']; ?>'>

<input type='hidden' name='vek' value='<?php echo $vek = $_POST['vek']; ?>'>
<input type='hidden' name='zarazeni' value='<?php echo $zarazeni = $_POST['zarazeni']; ?>'>
<input type='hidden' name='vzdelani' value='<?php echo $vzdelani = $_POST['vzdelani']; ?>'>
<input type='hidden' name='vzdelani_rok' value='<?php echo $vzdelani_rok = $_POST['vzdelani_rok']; ?>'>
<input type='hidden' name='vzdelani_forma' value='<?php echo $vzdelani_forma = $_POST['vzdelani_forma']; ?>'>
<input type='hidden' name='kod_akt_banky' value='<?php echo $kod_akt_banky = $_POST['kod_akt_banky']; ?>'>

<?php

//    DEFINICE PROMENNYCH ZE VSTUPU 3
$prijem = $_POST['prijem'] != Null ? str_replace(' ','',Trim($_POST['prijem'])) : '10000';
$prichozi = $_POST['prichozi'] != Null ? str_replace(' ','',Trim($_POST['prichozi'])) : '1';
$vydaje = $_POST['vydaje'] != Null ? str_replace(' ','',Trim($_POST['vydaje'])) : '0';
$odchozi = str_replace(' ','',Trim($_POST['odch_std']));
$odch_tp = $_POST['vydaje'] != Null ? str_replace(' ','',Trim($_POST['odch_tp'])) : '0';
if ($karta > 0){
$karta_celkem = str_replace(' ','',Trim($_POST['karta_celkem']));
$vybery = str_replace(' ','',Trim($_POST['vybery']));
$cashback = isset($_POST['cashback']) ? $_POST['cashback'] : Null;}
else {
$karta_celkem = 0;
$vybery = 0;
$cashback = Null;}

$vypis = isset($_POST['vypis']) ? $_POST['vypis'] : Null;


//    KONTROLA VSTUPNICH DAT
$check = array();
$check['prijem'] = !ctype_digit($prijem) && $prijem ? '[CHYBA-PRIJEM] Celkový příjem musí být celé, kladné číslo, bez dalších znaků.[/CHYBA-PRIJEM]' : Null;
$check['prichozi'] = !ctype_digit($prichozi) && $prichozi ? '[CHYBA-PRICHOZI] Počet příchozích transakcí musí být celé, kladné číslo, bez dalších znaků.[/CHYBA-PRICHOZI]' : Null;
$check['vydaje'] = !ctype_digit($vydaje) && $vydaje ? '[CHYBA-VYDAJE] Celkové výdaje musí být celé, kladné číslo, bez dalších znaků.[/CHYBA-VYDAJE]' : Null;
$check['odchozi'] = $odchozi == Null ? '[CHYBA-ODCHOZI] Zadejte celkový počet odchozích plateb.[/CHYBA-ODCHOZI]' : Null;
$check['odchozi'] = !ctype_digit($odchozi) && $odchozi ? '[CHYBA-ODCHOZI] Počet odchozích plateb musí být celé, kladné číslo, bez dalších znaků.[/CHYBA-ODCHOZI]' : $check['odchozi'];
$check['odch_tp'] = $odch_tp == Null ? '[CHYBA-ODCH_TP] Zadejte počet odchozích trvalých příkazů.[/CHYBA-ODCH_TP]' : Null;
$check['odch_tp'] = $odchozi != Null && $odch_tp > $odchozi ? '[CHYBA-ODCH_TP] Počet odchozích trvalých příkazů nesmí být větší než celkový počet odchozích plateb.[/CHYBA-ODCH_TP]' : $check['odch_tp'];
$check['odch_tp'] = !ctype_digit($odch_tp) && $odch_tp ? '[CHYBA-ODCH_TP] Počet odchozích trvalých příkazů musí být celé, kladné číslo, bez dalších znaků.[/CHYBA-ODCH_TP]' : $check['odch_tp'];
$check['karta_celkem'] = !ctype_digit($karta_celkem) && $karta_celkem ? '[CHYBA-KARTA_CELKEM] Celková hodnota transakcí musí být celé, kladné číslo, bez dalších znaků.[/CHYBA-KARTA_CELKEM]' : Null;
$check['vybery'] = !ctype_digit($vybery) && $vybery ? '[CHYBA-VYBERY] Počet výběrů musí být celé, kladné číslo, bez dalších znaků.[/CHYBA-VYBERY]' : Null;
$check['cashback'] = $karta > 0 && $cashback == Null ? '[CHYBA-CASHBACK] Vyberte možnost služby Cashback.[/CHYBA-CASHBACK]' : Null;
$check['vypis'] = !$vypis ? '[CHYBA-VYPIS] Vyberte formu výpisu k účtu.[/CHYBA-VYPIS]' : Null;
?>


<input type='hidden' name='prijem' value='<?php echo $prijem; ?>'>
<input type='hidden' name='prichozi' value='<?php echo $prichozi; ?>'>
<input type='hidden' name='kod_banky' value='<?php echo $kod_banky = $_POST['kod_banky']; ?>'>
<input type='hidden' name='vydaje' value='<?php echo $vydaje; ?>'>
<input type='hidden' name='odchozi' value='<?php echo $odchozi; ?>'>
<input type='hidden' name='odch_tp' value='<?php echo $odch_tp; ?>'>
<input type='hidden' name='odch_std' value='<?php echo $odch_std = $odchozi - $odch_tp; ?>'>
<input type='hidden' name='karta_celkem' value='<?php echo $karta_celkem; ?>'>
<input type='hidden' name='vybery' value='<?php echo $vybery; ?>'>
<input type='hidden' name='cashback' value='<?php echo $cashback; ?>'>
<input type='hidden' name='vypis' value='<?php echo $vypis; ?>'>

<input type='hidden' name='chyby' value='<?php echo implode(",", $check); ?>'>  
                                     


<?php


if (implode("", ($check)) != Null)
 // die ("<span style='color:red'>Chybné, nebo neúplné zadání - </span><INPUT type='submit' name='krok3' value='Opravit'></form>");
?>



<?php


include '../pripojeni_sql.php';

date_default_timezone_set('Europe/Prague');



$vek_sql = "if(not VekDo is Null, VekOd <= $vek AND $vek <= VekDo, VekOd <= $vek)";
$typ_uctu_sql = '';
$typ_uctu_sql.= $zarazeni <= 2 ? "TypUctu in ('bezny', 'bezny-student')" : Null;
$typ_uctu_sql.= $zarazeni == 3 ? "TypUctu in ('bezny', 'bezny-absolvent')" : Null;
$typ_uctu_sql.= $zarazeni == 4 ? "TypUctu in ('bezny-podnikatel')" : Null;

$mena_sql = "Mena = '$mena'";
$zustatek_sql = "MinLimit <= $zustatek"; 

$banking_exc = '';
$banking_exc.= in_array('mb', $banking) ? "AND not MB1 is null" : '';
$banking_exc.= in_array('tb', $banking) ? " AND not TB is null" : '';
$info_exc = $info == 'mail' ? "AND not EMAILpush is null" : '';
$vypis_exc = $vypis == 'papir' ? "AND not VypisMesPapir is null" : "AND not VypisMesEl is null";

$karta_exc = $karta > 0 ? "AND not Vydani is null" : ''; 
$cashback_exc = $cashback == 'ano' ? "AND not VyberCashBack is null" : '';


$urok_def = "(case 
when ucty_detail.ID between 7 and 9 then if($zustatek >= 5000000, Urok3, if($zustatek >= 1000000, Urok2, Urok1))
when ucty_detail.ID = 21 then if($zustatek >= 1000000, Urok3, if($zustatek >= 500000, Urok2, Urok1)) else Urok1 end) as Urok";



//    odchylky v (ne)zobrazeni konkretnich uctu 

$odch_KB = ($vek >= 20 && $vek <= 30 && $zarazeni == 2) || ($zarazeni > 2 && $vzdelani <> 'VS') ? " AND VariantaUctu <> 'G2.2' " : '';

$odch_CS = $zarazeni > 2 && (Date("Y", Time()) - $vzdelani_rok > 1 || $vzdelani_forma <> 'denni') ? " AND VariantaUctu <> 'Osobni ucet CS Absolvent' " : '';

$odch_airbank = $odchozi > 100 ? " AND ucty_detail.ID <> 33 " : '';

$odch_ge = $zarazeni > 1 ? ' AND ucty_detail.ID <> 47 ' : '';

$odch_csob = $vek > 20 && $zarazeni > 2 && $vzdelani <> 'VS' && $vzdelani <> 'VO' && Date("Y", Time()) - $vzdelani_rok > 1 ? ' AND ucty_detail.ID <> 31 ' : '';

$odch_rb = $zarazeni > 1 ? ' AND ucty_detail.ID <> 53 ' : '';

//    konec odchylek


//echo "ZADANI: vek - $vek, zarazeni - $zarazeni, vzdelani - $vzdelani, $vzdelani_rok, $vzdelani_forma, vypis - $vypis, ovladani pres ".implode(',', $banking).", karta - $karta, info - $info, cashback - $cashback<P>";



$sql_tab_vysledek = "CREATE TEMPORARY TABLE poplatky_vysledek (
ID int(3) unsigned NOT NULL,
Nazev varchar(55) NOT NULL,
Banka varchar(55) NOT NULL,
NakladyOd decimal(10,2) unsigned DEFAULT NULL,
NakladyDo decimal(10,2) unsigned DEFAULT NULL,
MinLimit int(10) unsigned NOT NULL,
Urok decimal(10,2) unsigned NOT NULL,
PlatnostOd date NOT NULL,
PlatnostDo date,
LastNaklady decimal(10,2) unsigned,
Vedeni decimal(10,2) unsigned,
Vedeni_text text,
Banking decimal(10,2) unsigned,
Banking_text text,
Vypis decimal(10,2) unsigned,
Vypis_text text,
Dom_prichozi decimal(10,2) unsigned,
Dom_prichozi_text text,
Dom_odchozi decimal(10,2) unsigned,
Dom_odchozi_text text,
Dom_trans decimal(10,2) unsigned,
Dom_trans_text text,
Info decimal(10,2) unsigned,
Info_text text,
Karta decimal(10,2) unsigned,
Karta_text text,
Karta_typ text,
Vyber decimal(10,2) unsigned,
Vyhody_text text,
Mena char(3),
Zruseni_text text DEFAULT NULL)";

$tab_vysledek = mysql_query($sql_tab_vysledek, $id_spojeni);
if (!$tab_vysledek)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodařilo se poslat dotaz na vytvoreni tabulky.');
} 
//echo 'Dotaz na vytvoreni tabulky odeslán.<br>';

$sql_poplatky = "INSERT INTO poplatky_vysledek (ID, Nazev, Banka, MinLimit, Urok, PlatnostOd, Mena)
SELECT ucty_detail.ID, VariantaUctu, nazev_banky, MinLimit, $urok_def, ucty_detail.PlatnostOd, Mena 

FROM (((ucty INNER JOIN banky ON ucty.KodBanky=banky.kod_banky)
INNER JOIN ucty_detail ON ucty.ucetID=ucty_detail.ucetID)
INNER JOIN ucty_uroky ON ucty_detail.ucetID=ucty_uroky.ucetID)
LEFT JOIN karty ON karty.ID=ucty_detail.ID 

WHERE ucty_uroky.PlatnostDo is null AND $typ_uctu_sql AND $mena_sql AND $vek_sql AND $zustatek_sql $banking_exc $info_exc $vypis_exc $karta_exc $cashback_exc $odch_KB $odch_CS $odch_airbank $odch_ge $odch_csob $odch_rb";


$poplatky = mysql_query($sql_poplatky, $id_spojeni);
if (!$poplatky)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodařilo se nám poslat SQL dotaz na poplatky.');
} 
//echo 'Dotaz na poplatky odeslán.<br>';



include "detail.php";



$sql_tab_last_naklady = "CREATE TEMPORARY TABLE posledni_naklady (
Nazev varchar(55) NOT NULL,
Datum date,
Naklady int(10) DEFAULT NULL)";

$tab_last_naklady = mysql_query($sql_tab_last_naklady, $id_spojeni);
if (!$tab_last_naklady)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodařilo se poslat dotaz na vytvoreni tabulky posledni naklady.');
} 
//echo 'Dotaz na vytvoreni tabulky posledni naklady odeslán.<br>';


$sql_last_naklady = "INSERT INTO posledni_naklady (Nazev, Datum, Naklady)
SELECT Nazev, PlatnostOd, NakladyDo FROM poplatky_vysledek ORDER BY PlatnostOd DESC";

$last_naklady = mysql_query($sql_last_naklady, $id_spojeni);
if (!$last_naklady)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodařilo se nám poslat SQL dotaz na posledni naklady.');
} 
//echo 'Dotaz na posledni naklady odeslán.<br>';


$sql_last_naklady_do_vysledek = "UPDATE poplatky_vysledek INNER JOIN posledni_naklady ON poplatky_vysledek.Nazev = posledni_naklady.Nazev SET poplatky_vysledek.LastNaklady = posledni_naklady.Naklady";

$last_naklady_do_vysledek = mysql_query($sql_last_naklady_do_vysledek, $id_spojeni);
if (!$last_naklady_do_vysledek)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodařilo se nám poslat SQL dotaz na update poslednich nakladu.');
} 
//echo 'Dotaz na update poslednich nakladu odeslán.<br>';

$kody = "'6210','6100','6800','4000','3030','2700','2310','2010','0800','0600','0300','5500','0100'";

$sql_vysledek = "SELECT poplatky_vysledek.*, ucty_detail.*, ucty.*,
Min(poplatky_vysledek.PlatnostOd) AS platnost_od, 
if(Not ucty_detail.PlatnostDo Is Null AND poplatky_vysledek.NakladyDo = poplatky_vysledek.LastNaklady, '', ucty_detail.PlatnostDo) AS platnost_do, 
(case $karta when '1' then ucty_detail.KontaktVydani when '2' then ucty_detail.BezKontaktVydani else 0 end) AS karta_vydani

FROM (poplatky_vysledek LEFT JOIN ucty_detail ON poplatky_vysledek.ID = ucty_detail.ID)
INNER JOIN ucty ON ucty.ucetID=ucty_detail.ucetID

WHERE KodBanky IN ($kody) and (ucty_detail.PlatnostDo Is Null or ucty_detail.PlatnostDo > Current_date())

GROUP BY poplatky_vysledek.Nazev

ORDER BY NakladyDo, NakladyOd, ucty.MinLimit, Urok DESC, ucty_detail.PlatnostOd";


$vysledek = mysql_query($sql_vysledek, $id_spojeni);
if (!$vysledek)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodařilo se nám poslat SQL dotaz na poplatky.');
} 
//echo 'Dotaz na vysledek odeslán.<br>';

echo "<P>Počet účtů vyhovujících Vašemu zadání - <b>".(mysql_num_rows($vysledek))."</b> - ";
?>

<INPUT type='submit' name='krok1' value='Změnit zadání'>
</FORM>





<CENTER>

<TABLE width=1200 border=0>
<TR>
<TH rowspan=2 nowrap>Název účtu</TH>
<TH rowspan=2 nowrap>Banka</TH>
<TH colspan=2>Náklady</TH>
<TH rowspan=2>Min. zůstatek</TH>
<TH rowspan=2>Úrok (%)</TH>
<TH rowspan=2><FONT size=3>Verze sazebníku <BR>s platností od..</FONT></TH>
<TH rowspan=2>Platnost do <BR><FONT size=1>(pokud existuje nový sazebník s jinou výslednou cenou)</FONT></TH>
<TH></TH></TR>

<TR>
<TD align='center'>min</TD>
<TD align='center'>max</TD>
</TR>
<?php

$i = 1;

while($radek_vysledek = mysql_fetch_assoc($vysledek))
{
     echo "<TR><FORM action='detail.php' method='post' target='_blank'>
     <INPUT type='hidden' name='vedeni[".$radek_vysledek['ID']."]' value='".$radek_vysledek['Vedeni']."'>
     <INPUT type='hidden' name='banking[".$radek_vysledek['ID']."]' value='".$radek_vysledek['Banking']."'>
     <INPUT type='hidden' name='banking_text[".$radek_vysledek['ID']."]' value='".$radek_vysledek['Banking_text']."'>
     <INPUT type='hidden' name='vypis[".$radek_vysledek['ID']."]' value='".$radek_vysledek['Vypis']."'>
     <INPUT type='hidden' name='vypis_text[".$radek_vysledek['ID']."]' value='".$radek_vysledek['Vypis_text']."'>
     <INPUT type='hidden' name='dom_prichozi[".$radek_vysledek['ID']."]' value='".$radek_vysledek['Dom_prichozi']."'>
     <INPUT type='hidden' name='dom_prichozi_text[".$radek_vysledek['ID']."]' value='".$radek_vysledek['Dom_prichozi_text']."'>
     <INPUT type='hidden' name='dom_odchozi[".$radek_vysledek['ID']."]' value='".$radek_vysledek['Dom_odchozi']."'>
     <INPUT type='hidden' name='dom_odchozi_text[".$radek_vysledek['ID']."]' value='".$radek_vysledek['Dom_odchozi_text']."'>
     <INPUT type='hidden' name='dom_trans[".$radek_vysledek['ID']."]' value='".$radek_vysledek['Dom_trans']."'>
     <INPUT type='hidden' name='dom_trans_text[".$radek_vysledek['ID']."]' value='".$radek_vysledek['Dom_trans_text']."'>
     <INPUT type='hidden' name='info[".$radek_vysledek['ID']."]' value='".$radek_vysledek['Info']."'>
     <INPUT type='hidden' name='info_text[".$radek_vysledek['ID']."]' value='".$radek_vysledek['Info_text']."'>
     <INPUT type='hidden' name='mena[".$radek_vysledek['ID']."]' value='".$radek_vysledek['Mena']."'>
     <INPUT type='hidden' name='karta[".$radek_vysledek['ID']."]' value='".$radek_vysledek['Karta']."'>
     <INPUT type='hidden' name='karta_text[".$radek_vysledek['ID']."]' value='".$radek_vysledek['Karta_text']."'>
     <INPUT type='hidden' name='zrizeni[".$radek_vysledek['ID']."]' value='".$radek_vysledek['Zrizeni']."'>
     <INPUT type='hidden' name='zruseni[".$radek_vysledek['ID']."]' value='".$radek_vysledek['Zruseni1']."'>
     <INPUT type='hidden' name='karta_vydani[".$radek_vysledek['ID']."]' value='".$radek_vysledek['karta_vydani']."'>
     <INPUT type='hidden' name='karta_blok[".$radek_vysledek['ID']."]' value='".$radek_vysledek['KontaktBlokace']."'>
     <INPUT type='hidden' name='vedeni_text[".$radek_vysledek['ID']."]' value='".$radek_vysledek['Vedeni_text']."'>
     <INPUT type='hidden' name='karta_typ[".$radek_vysledek['ID']."]' value='".$radek_vysledek['Karta_typ']."'>
     <INPUT type='hidden' name='vyhody_text[".$radek_vysledek['ID']."]' value='".$radek_vysledek['Vyhody_text']."'>
     <INPUT type='hidden' name='zruseni_text[".$radek_vysledek['ID']."]' value='".$radek_vysledek['Zruseni_text']."'>
     <INPUT type='hidden' name='www[".$radek_vysledek['ID']."]' value='".$radek_vysledek['Www']."'>";
          
     if ($i++ % 2 == 0){
//      if($radek_vysledek['Nazev'] == $kod_akt_banky)
      echo "<div style='font-weight:bold'>";
     echo "<TD class='souhrn_radek' nowrap>
        <INPUT type='hidden' name='nazev[".$radek_vysledek['ID']."]' value='".$radek_vysledek['Nazev']."'>".($radek_vysledek['Nazev'] == $kod_akt_banky ? '<b>'.$radek_vysledek['Nazev'].'</b>' : $radek_vysledek['Nazev'])."</TD>
     <TD class='souhrn_radek' nowrap>".($radek_vysledek['Nazev'] == $kod_akt_banky ? '<b>'.$radek_vysledek['Banka'].'</b>' : $radek_vysledek['Banka'])."</TD>
     <TD class='souhrn_radek' align='right'>".($radek_vysledek['Nazev'] == $kod_akt_banky ? '<b>'.$radek_vysledek['NakladyOd'].'</b>' : $radek_vysledek['NakladyOd'])."</TD> 
     <TD class='souhrn_radek' align='right'>
        <INPUT type='hidden' name='naklady[".$radek_vysledek['ID']."]' value='".$radek_vysledek['NakladyDo']."'>".($radek_vysledek['Nazev'] == $kod_akt_banky ? '<b>'.$radek_vysledek['NakladyDo'].'</b>' : $radek_vysledek['NakladyDo'])."</TD>
     <TD class='souhrn_radek' align='right'>".($radek_vysledek['Nazev'] == $kod_akt_banky ? '<b>'.$radek_vysledek['MinLimit'].'</b>' : $radek_vysledek['MinLimit'])."</TD>
     <TD class='souhrn_radek' align='right'>".($radek_vysledek['Nazev'] == $kod_akt_banky ? '<b>'.$radek_vysledek['Urok'].'</b>' : $radek_vysledek['Urok'])."</TD>
     <TD class='souhrn_radek' width=180 align='center'>".($radek_vysledek['Nazev'] == $kod_akt_banky ? '<b>'.Date('d/m/Y', strtotime($radek_vysledek['platnost_od'])).'</b>' : Date('d/m/Y', strtotime($radek_vysledek['platnost_od'])))."</TD>
     <TD class='souhrn_radek' width=180 align='center'>
        <INPUT type='hidden' name='platnostDo[".$radek_vysledek['ID']."]' value='".$radek_vysledek['platnost_do']."'>".($radek_vysledek['platnost_do'] != Null ? Date('d/m/Y', strtotime($radek_vysledek['platnost_do'])) : Null)."</TD>
     <TD class='souhrn_radek'><INPUT type='submit' name='ukaz' value='Podrobný rozpis'></FORM></TD></TR>";}
     
     else {
     echo "<TD nowrap>
        <INPUT type='hidden' name='nazev[".$radek_vysledek['ID']."]' value='".$radek_vysledek['Nazev']."'>".($radek_vysledek['Nazev']==$kod_akt_banky ? '<b>'.$radek_vysledek['Nazev'].'</b>' : $radek_vysledek['Nazev'])."</TD>
     <TD nowrap>".($radek_vysledek['Nazev'] == $kod_akt_banky ? '<b>'.$radek_vysledek['Banka'].'</b>' : $radek_vysledek['Banka'])."</TD>
     <TD align='right'>".($radek_vysledek['Nazev'] == $kod_akt_banky ? '<b>'.$radek_vysledek['NakladyOd'].'</b>' : $radek_vysledek['NakladyOd'])."</TD> 
     <TD class='souhrn_radek' align='right'>
        <INPUT type='hidden' name='naklady[".$radek_vysledek['ID']."]' value='".$radek_vysledek['NakladyDo']."'>".($radek_vysledek['Nazev'] == $kod_akt_banky ? '<b>'.$radek_vysledek['NakladyDo'].'</b>' : $radek_vysledek['NakladyDo'])."</TD>
     <TD align='right'>".($radek_vysledek['Nazev'] == $kod_akt_banky ? '<b>'.$radek_vysledek['MinLimit'].'</b>' : $radek_vysledek['MinLimit'])."</TD>
     <TD align='right'>".($radek_vysledek['Nazev'] == $kod_akt_banky ? '<b>'.$radek_vysledek['Urok'].'</b>' : $radek_vysledek['Urok'])."</TD>
     <TD width=180 align='center'>".($radek_vysledek['Nazev'] == $kod_akt_banky ? '<b>'.Date('d/m/Y', strtotime($radek_vysledek['platnost_od'])).'</b>' : Date('d/m/Y', strtotime($radek_vysledek['platnost_od'])))."</TD>
     <TD width=180 align='center'>
        <INPUT type='hidden' name='platnostDo[".$radek_vysledek['ID']."]' value='".$radek_vysledek['platnost_do']."'>".($radek_vysledek['platnost_do'] != Null ? Date('d/m/Y', strtotime($radek_vysledek['platnost_do'])) : Null)."</TD>
     <TD><INPUT type='submit' name='ukaz' value='Podrobný rozpis'></FORM></TD></TR>";}
   echo "</div>";  
}

?>



</TABLE>
</CENTER>
<HR>
<P style='height:100'>
Hledáte konkrétní účet, ale nenašli jste jej v seznamu výše? Může to mít jeden z těchto důvodů - (1.)účet nesplňuje Vámi zadaná kritéria, nebo (2.)byl vydán nový sazebník, který jsem ještě nestihl implementovat, nebo (3.)účet nebyl vůbec zahrnut do výpočtu - <a href="..\ucty.php">zde</a> si můžete zkontrolovat účty již zahrnuté a připravované.</p>


<?php
}
if($id_spojeni)
{
  mysql_close($id_spojeni);
//  echo 'odpojeno <br>';
} 
?>

