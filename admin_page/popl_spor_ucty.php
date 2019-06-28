
<FORM name='ceny_admin' method='GET' action='<?php echo (isset($_GET['nove_popl']) ? "../admin_page/?id=0#poplatky" : ""); ?>'>
<INPUT type='hidden' name='ucet' value=<?php echo $_GET['ucet']; ?>>
<INPUT type='hidden' name='ucetTyp' value=<?php echo $_GET['ucetTyp']; ?>>
<INPUT type='hidden' name='nazevUctu' value='<?php echo $_GET['nazevUctu']; ?>'>
<INPUT type='hidden' name='kodBanky' value='<?php echo $_GET['kodBanky']; ?>'>
<?php
$sql_cena_d = "SELECT *, count(ceny_karty.id) as pocet_karet FROM ucty_ceny
LEFT JOIN ceny_banking ON ucty_ceny.cena_id = ceny_banking.ID
LEFT JOIN ceny_karty ON ucty_ceny.cena_id = ceny_karty.karta_cena_id
WHERE cena_ucet_ID = ".$_GET['ucet']."
GROUP BY cena_id
ORDER BY cena_platnost_od DESC";
$cena_d = vystup_sql($sql_cena_d);

$pocet_zaznamu_cena_d = mysql_num_rows($cena_d);
$radek = !isset($_GET['r_cena_d']) ? 0 : $_GET['r_cena_d'];

if(isset($_GET['vyber_id']) && $_GET['vyber_id'] == '>')
++$radek;
elseif(isset($_GET['vyber_id']) && $_GET['vyber_id'] == '<')
--$radek;

//echo $radek;
echo "<INPUT type='hidden' name='r_cena_d' value=$radek>";

//-- ZADÁNÍ POPLATKŮ

$ib_sql = isset($_GET['zrizeniIB']) && is_numeric($_GET['zrizeniIB']) ? "ib_Zrizeni = ".$_GET['zrizeniIB'].", 
".($_GET['vedeniIB'] == Null ? "ib_Vedeni=Null" : "ib_Vedeni = ".$_GET['vedeniIB']).", 
".($_GET['odchozi1_IB'] == Null ? "ib_Odchozi1=Null" : "ib_Odchozi1 = ".$_GET['odchozi1_IB']).", 
".($_GET['odchozi2_IB'] == Null ? "ib_Odchozi2=Null" : "ib_Odchozi2 = ".$_GET['odchozi2_IB']).", 
".($_GET['zrizeniTP_IB'] == Null ? "ib_ZrizeniTP=Null" : "ib_ZrizeniTP = ".$_GET['zrizeniTP_IB']).", " : "ib_Zrizeni=Null, ";

$mb_sql = isset($_GET['zrizeniMB']) && is_numeric($_GET['zrizeniMB']) ? "mb_Zrizeni = ".$_GET['zrizeniMB'].", 
".($_GET['vedeniMB'] == Null ? "mb_Vedeni=Null" : "mb_Vedeni = ".$_GET['vedeniMB']).", 
".($_GET['odchozi1_MB'] == Null ? "mb_Odchozi1=Null" : "mb_Odchozi1 = ".$_GET['odchozi1_MB']).", 
".($_GET['odchozi2_MB'] == Null ? "mb_Odchozi2=Null" : "mb_Odchozi2 = ".$_GET['odchozi2_MB']).", 
".($_GET['zrizeniTP_MB'] == Null ? "mb_ZrizeniTP=Null" : "mb_ZrizeniTP = ".$_GET['zrizeniTP_MB']).", " : "mb_Zrizeni=Null, ";

$tb_sql = isset($_GET['zrizeniTB']) && is_numeric($_GET['zrizeniTB']) ? "tb_Zrizeni = ".$_GET['zrizeniTB'].", 
".($_GET['vedeniTB'] == Null ? "tb_Vedeni=Null" : "tb_Vedeni = ".$_GET['vedeniTB']).", 
".($_GET['odchozi1_TB'] == Null ? "tb_Odchozi1=Null" : "tb_Odchozi1 = ".$_GET['odchozi1_TB']).", 
".($_GET['odchozi2_TB'] == Null ? "tb_Odchozi2=Null" : "tb_Odchozi2 = ".$_GET['odchozi2_TB']).", 
".($_GET['zrizeniTP_TB'] == Null ? "tb_ZrizeniTP=Null" : "tb_ZrizeniTP = ".$_GET['zrizeniTP_TB']) : "tb_Zrizeni=Null";


if(isset($_GET['vlozeni_popl'])){                                         //   VLOZENI NOVYCH POPLATKU
$sql_vlozit_hlavni = "INSERT INTO ucty_ceny
(cena_ucet_id, cena_platnost_od, cena_zrizeni, cena_zruseni, cena_vedeni, cena_vedeni_podm, cena_vypis_e, cena_vypis_p, cena_prichozi1, cena_prichozi2, cena_odchozi_tp1, cena_odchozi_tp2, cena_odchozi_online1, cena_odchozi_priorita, cena_inkaso_svoleni, cena_inkaso_odchozi, cena_koment_JP, cena_koment_PP, cena_koment_trans, cena_koment_inkaso, cena_koment_karta)
VALUES (".$_GET['ucet'].", '".$_GET['platnostOd']."', 
".($_GET['zrizeniUctu'] == "" ? "Null, " : $_GET['zrizeniUctu'].", ") 
.($_GET['zruseniUctu'] == "" ? "Null, " : $_GET['zruseniUctu'].", ")
.($_GET['vedeniUctu'] == "" ? "Null, " : $_GET['vedeniUctu'].", ")
.($_GET['vedeniUctu_podm'] == "" ? "Null, " : $_GET['vedeniUctu_podm'].", ")
.($_GET['vypisE'] == "" ? "Null, " : $_GET['vypisE'].", ")
.($_GET['vypisP'] == "" ? "Null, " : $_GET['vypisP'].", ") 
.($_GET['prichozi1'] == "" ? "Null, " : $_GET['prichozi1'].", ")
.($_GET['prichozi2'] == "" ? "Null, " : $_GET['prichozi2'].", ")
.($_GET['odchoziTP1'] == "" ? "Null, " : $_GET['odchoziTP1'].", ")
.($_GET['odchoziTP2'] == "" ? "Null, " : $_GET['odchoziTP2'].", ")
.($_GET['odchoziOn1'] == "" ? "Null, " : $_GET['odchoziOn1'].", ")
.($_GET['odchoziP'] == "" ? "Null, " : $_GET['odchoziP'].", ")
.($_GET['inkSvoleni'] == "" ? "Null, " : $_GET['inkSvoleni'].", ")
.($_GET['inkOdch'] == "" ? "Null, " : $_GET['inkOdch'].", ")
."'".(htmlspecialchars($_GET['koment_JP'], ENT_QUOTES))."', '".(htmlspecialchars($_GET['koment_PP'], ENT_QUOTES))."', '".(htmlspecialchars($_GET['koment_trans'], ENT_QUOTES))."', '".(htmlspecialchars($_GET['koment_ink'], ENT_QUOTES))."', 'bez karty')";
$vlozit_hlavni = vystup_sql($sql_vlozit_hlavni);

$sql_hlavni_id = "SELECT max(cena_id) FROM ucty_ceny";
$hlavni_id = vystup_sql($sql_hlavni_id);
$max_id = mysql_result($hlavni_id, 0, 0);

$sql_vlozit_banking = "INSERT INTO ceny_banking (ID) VALUES ($max_id)";
$vlozit_banking = vystup_sql($sql_vlozit_banking);

if($ib_sql <> "" || $mb_sql <> "" || $tb_sql <> ""){
$sql_ulozit_banking = "UPDATE ceny_banking SET $ib_sql $mb_sql $tb_sql WHERE ID = $max_id";
$ulozit_banking = vystup_sql($sql_ulozit_banking);}


if(isset($_GET['vloz_popl_vc_vyj']) && $_GET['vloz_popl_vc_vyj'] == 1){
echo $sql_kopie_vyjimek = "INSERT INTO vyjimky (`ucet_id`,`cena_id`,`pole`,`podminka`,`vysledek`,`koment`)
SELECT ucet_id, $max_id as cena_id, pole, podminka, vysledek, koment FROM vyjimky WHERE cena_id=".$_GET['ucet_vzor']." and karta_id is null;
";
$kopie_vyjimek = vystup_sql($sql_kopie_vyjimek);
}


echo "<meta http-equiv='refresh' content='0;url=/admin_page/admin.php?kodBanky=".$_GET['kodBanky']."&ucet=".$_GET['ucet']."&ucetTyp=".$_GET['ucetTyp']."&nazevUctu=".$_GET['nazevUctu']."&id=$max_id&r_cena_d=".$_GET['r_cena_d']."&note=Poplatky vloženy - ID $max_id. Můžeš vložit první kartu.#poplatky'>";
}

if(isset($_GET['ulozeni_popl'])){                      // ULOZENÍ ZMEN POPLATKu

$sql_ulozit_poplatky = "UPDATE ucty_ceny 
SET cena_platnost_od = '".$_GET['platnostOd']."', 
".($_GET['zrizeniUctu'] == Null ? "cena_zrizeni=Null, " : "cena_zrizeni=".$_GET['zrizeniUctu'].", ")
.($_GET['zruseniUctu'] == Null ? "cena_zruseni=Null, " : "cena_zruseni=".$_GET['zruseniUctu'].", ")
.($_GET['vedeniUctu'] == Null ? "cena_vedeni=Null, " : "cena_vedeni=".$_GET['vedeniUctu'].", ")  
.($_GET['vedeniUctu_podm'] == Null ? "cena_vedeni_podm=Null, " : "cena_vedeni_podm=".$_GET['vedeniUctu_podm'].", ")
.($_GET['vypisE'] == Null ? "cena_vypis_e=Null, " : "cena_vypis_e=".$_GET['vypisE'].", ")
.($_GET['vypisP'] == Null ? "cena_vypis_p=Null, " : "cena_vypis_p=".$_GET['vypisP'].", ")
.($_GET['prichozi1'] == Null ? "cena_prichozi1=Null, " : "cena_prichozi1=".$_GET['prichozi1'].", ")
.($_GET['prichozi2'] == Null ? "cena_prichozi2=Null, " : "cena_prichozi2=".$_GET['prichozi2'].", ")
.($_GET['odchoziTP1'] == Null ? "cena_odchozi_tp1=Null, " : "cena_odchozi_tp1=".$_GET['odchoziTP1'].", ")
.($_GET['odchoziTP2'] == Null ? "cena_odchozi_tp2=Null, " : "cena_odchozi_tp2=".$_GET['odchoziTP2'].", ")
.($_GET['odchoziOn1'] == Null ? "cena_odchozi_online1=Null, " : "cena_odchozi_online1=".$_GET['odchoziOn1'].", ")
.($_GET['odchoziOn2'] == Null ? "cena_odchozi_online2=Null, " : "cena_odchozi_online2=".$_GET['odchoziOn2'].", ")
.($_GET['odchoziP'] == Null ? "cena_odchozi_priorita=Null, " : "cena_odchozi_priorita=".$_GET['odchoziP'].", ")
.($_GET['balicek'] == Null ? "cena_trans_bal=Null, " : "cena_trans_bal=".$_GET['balicek'].", ") 
.($_GET['balicekTyp'] == Null ? "cena_trans_bal_typ=Null, " : "cena_trans_bal_typ=".$_GET['balicekTyp'].", ")
.($_GET['inkSvoleni'] == Null ? "cena_inkaso_svoleni=Null, " : "cena_inkaso_svoleni=".$_GET['inkSvoleni'].", ")
.($_GET['inkOdch'] == Null ? "cena_inkaso_odchozi=Null, " : "cena_inkaso_odchozi=".$_GET['inkOdch'].", ")
."cena_koment_JP = '".(htmlspecialchars($_GET['koment_JP'], ENT_QUOTES))."', 
cena_koment_PP = '".(htmlspecialchars($_GET['koment_PP'], ENT_QUOTES))."', 
cena_koment_trans = '".(htmlspecialchars($_GET['koment_trans'], ENT_QUOTES))."',
cena_koment_inkaso = '".(htmlspecialchars($_GET['koment_ink'], ENT_QUOTES))."'                                                       
WHERE cena_id = ".$_GET['id'];
$ulozit_poplatky = vystup_sql($sql_ulozit_poplatky);


$sql_ulozit_banking = "UPDATE ceny_banking SET $ib_sql $mb_sql $tb_sql WHERE ID = ".$_GET['id'];
$ulozit_banking = vystup_sql($sql_ulozit_banking);


echo "<meta http-equiv='refresh' content='0;url=/admin_page/admin.php?kodBanky=".$_GET['kodBanky']."&ucet=".$_GET['ucet']."&ucetTyp=".$_GET['ucetTyp']."&nazevUctu=".$_GET['nazevUctu']."&id=".$_GET['id']."&r_cena_d=".$_GET['r_cena_d']."&note=Změny v poplatcích uloženy.#poplatky'>";
}


if($_GET['id'] > 0)
{
$platnostOd = mysql_result($cena_d, $radek, 'cena_platnost_od');
$zrizeniUctu = mysql_result($cena_d, $radek, 'cena_zrizeni');
$zruseniUctu = mysql_result($cena_d, $radek, 'cena_zruseni');
$vedeniUctu = mysql_result($cena_d, $radek, 'cena_vedeni');
$vedeniUctu_podm = mysql_result($cena_d, $radek, 'cena_vedeni_podm');
$vypisE = mysql_result($cena_d, $radek, 'cena_vypis_e');
$vypisP = mysql_result($cena_d, $radek, 'cena_vypis_p');
$prichozi1 = mysql_result($cena_d, $radek, 'cena_prichozi1');
$prichozi2 = mysql_result($cena_d, $radek, 'cena_prichozi2');
$odchoziTP1 = mysql_result($cena_d, $radek, 'cena_odchozi_tp1');
$odchoziTP2 = mysql_result($cena_d, $radek, 'cena_odchozi_tp2');
$odchoziOn1 = mysql_result($cena_d, $radek, 'cena_odchozi_online1');
$odchoziOn2 = mysql_result($cena_d, $radek, 'cena_odchozi_online2');
$balicek = mysql_result($cena_d, $radek, 'cena_trans_bal');
$balicekTyp = mysql_result($cena_d, $radek, 'cena_trans_bal_typ');
$koment_JP = mysql_result($cena_d, $radek, 'cena_koment_JP');
$koment_PP = mysql_result($cena_d, $radek, 'cena_koment_PP');
$koment_trans = mysql_result($cena_d, $radek, 'cena_koment_trans');
$zrizeniIB = mysql_result($cena_d, $radek, 'ib_Zrizeni');
$vedeniIB = mysql_result($cena_d, $radek, 'ib_Vedeni');
$odchozi1_IB = mysql_result($cena_d, $radek, 'ib_Odchozi1');
$odchozi2_IB = mysql_result($cena_d, $radek, 'ib_Odchozi2');
$zrizeniTP_IB = mysql_result($cena_d, $radek, 'ib_ZrizeniTP');
$zrizeniMB = mysql_result($cena_d, $radek, 'mb_Zrizeni');
$vedeniMB = mysql_result($cena_d, $radek, 'mb_Vedeni');
$odchozi1_MB = mysql_result($cena_d, $radek, 'mb_Odchozi1');
$odchozi2_MB = mysql_result($cena_d, $radek, 'mb_Odchozi2');
$zrizeniTP_MB = mysql_result($cena_d, $radek, 'mb_ZrizeniTP');
$zrizeniTB = mysql_result($cena_d, $radek, 'tb_Zrizeni');
$vedeniTB = mysql_result($cena_d, $radek, 'tb_Vedeni');
$odchozi1_TB = mysql_result($cena_d, $radek, 'tb_Odchozi1');
$odchozi2_TB = mysql_result($cena_d, $radek, 'tb_Odchozi2');
$zrizeniTP_TB = mysql_result($cena_d, $radek, 'tb_ZrizeniTP');
$odchoziP = mysql_result($cena_d, $radek, 'cena_odchozi_priorita');
$inkSvoleni = mysql_result($cena_d, $radek, 'cena_inkaso_svoleni');
$inkOdch = mysql_result($cena_d, $radek, 'cena_inkaso_odchozi');
$koment_ink = mysql_result($cena_d, $radek, 'cena_koment_inkaso');
}

elseif(isset($_GET['rychla_volba']))
{
$platnostOd = "2014-10-01";
$zrizeniUctu = rand(0,50);
$zruseniUctu = 0;
$vedeniUctu = rand(0,500);
$vedeniUctu_podm = rand(0,1);
$vypisE = rand(0,20);
$vypisP = rand(10,50);
$prichozi1 = rand(0,10);
$prichozi2 = rand(0,20);
$odchoziTP1 = rand(0,10);
$odchoziTP2 = rand(0,20);
$odchoziOn1 = rand(0,5);
$odchoziOn2 = rand(0,10);
$balicek = rand(0,100);
$balicekTyp = rand(0,4);
$zrizeniIB = rand(0,20);
$zrizeniMB = rand(0,20);
$zrizeniTB = rand(0,20);
$zrizeniTP_IB = rand(0,10);
$zrizeniTP_MB = rand(0,10);
$zrizeniTP_TB = rand(0,10);
$vedeniIB = rand(0,50);
$odchozi1_IB = rand(0,10);
$odchozi2_IB = rand(0,10);
$vedeniMB = rand(0,50);
$odchozi1_MB = rand(0,10);
$odchozi2_MB = rand(0,10);
$vedeniTB = rand(0,50);
$odchozi1_TB = rand(0,10);
$odchozi2_TB = rand(0,10);
$koment_JP = "no comment";
$koment_PP = "no comment";
$koment_trans = "no comment";
$odchoziP = rand(0,10);
$inkSvoleni = rand(0,10);
$inkOdch = rand(0,10);
$koment_ink = "no comment";
}

else
{   
$platnostOd = Null;
$zrizeniUctu = $zruseniUctu = $vedeniUctu = $vedeniUctu_podm = $vypisE = $vypisP = $prichozi1 = $prichozi2 = $odchoziTP1 = $odchoziTP2 = $odchoziOn1 = $odchoziOn2 = $balicek = $balicekTyp = $zrizeniIB = $zrizeniMB = $zrizeniTB = $zrizeniTP_IB = $zrizeniTP_MB = $zrizeniTP_TB = $vedeniIB = $odchozi1_IB = $odchozi2_IB = $vedeniMB = $odchozi1_MB = $odchozi2_MB = $vedeniTB = $odchozi1_TB = $odchozi2_TB = $odchoziP = $inkSvoleni = $inkOdch = "";
$koment_JP = $koment_PP = $koment_trans = $koment_ink = "no comment";
}


$popl_read_only = $_GET['id'] > 0 && !isset($_GET['oprava_popl']) ? " readonly" : "";


//$note = isset($_GET['note']) ? $_GET['note'] : "";
//echo "<span style='color:green; font-weight:bold; font-size:small'>$note</span>";
echo $pocet_zaznamu_cena_d == 0 ? "První zadání. K tomuto účtu zatím nebyly vloženy žádné poplatky." : "";
?>

<H2><?php echo ($_GET['id'] > 0 ? "Výpis poplatků ke spořícímu účtu <U>".$_GET['nazevUctu']."</U>" : "Vložení nových poplatků pro spořící účet <U>".$_GET['nazevUctu']."</U>"); ?></H2>
<?php 

  if(isset($_GET['oprava_popl'])){
  //echo "<INPUT type='hidden' name='vyber_ucet' value=''>";
  echo "<INPUT type='submit' name='ulozeni_popl' value='Uložit změny v poplatcích'>";
  }
  elseif($_GET['id'] > 0){
  //echo "<INPUT type='hidden' name='vyber_ucet' value=''>";
  echo "<INPUT type='submit' name='oprava_popl' value='Provést změny v poplatcích'>
   <INPUT type='submit' name='s_popl_karty' value='Spravovat poplatky karet k účtu (".mysql_result($cena_d, $radek, 'pocet_karet').")'>";
  echo "<span style='letter-spacing:50'> <INPUT type='submit' name='s_ucet' value='Spravovat účet'></span>
  <BR><a href='../admin_page/admin.php?kodBanky=".$_GET['kodBanky']."&ucet=".$_GET['ucet']."&ucetTyp=".$_GET['ucetTyp']."&nazevUctu=".$_GET['nazevUctu']."&id=0&vyber_id='>Zadat nové poplatky</a>";
  }
  else {
  echo "<INPUT type='submit' name='vlozeni_popl' value='Vložit poplatky'".(!isset($_GET['ucet_vzor']) ? " disabled" : "").">";
  echo "<INPUT type='checkbox' name='vloz_popl_vc_vyj' value=1 />Vložit včetně výjimek ze vzoru";
  }

/*if($_GET['id'] == 0) 
echo "<INPUT type='submit' name='rychla_volba' value='Vyplnit testovací ceny'".(!isset($_GET['ucet_vzor']) ? " disabled" : "").">"; */
 

?>
<P>
ID poplatků: <INPUT type='text' name='id' value=<?php echo ($_GET['id'] > 0 && !isset($_GET['nove_popl']) ? mysql_result($cena_d, $radek, 0) : 0); ?> size=2 readonly>
<?php    
/*
for($i = 0; $i < $pocet_zaznamu_cena_d; $i++)
    {
    echo "<OPTION value=".mysql_result($cena_d, $i, 0).(mysql_result($cena_d, $i, 0) == $_GET['id'] ? " selected" : "").">".mysql_result($cena_d, $i, 0)." - platnost od ".mysql_result($cena_d, $i, 2)."</OPTION>";
    }
echo "<OPTION value=0".($_GET['id'] == 0 ? " selected" : "")." disabled>0 - nové poplatky</OPTION></SELECT>";   */
?>

<INPUT type='submit' name='vyber_id' value='<'<?php echo ($radek == 0 || $_GET['id'] == 0 || isset($_GET['oprava_popl']) ? " disabled" : ""); ?>>
<INPUT type='submit' name='vyber_id' value='>'<?php echo ($radek == $pocet_zaznamu_cena_d - 1 || $_GET['id'] == 0 || isset($_GET['oprava_popl']) ? " disabled" : ""); ?>>
<BR>
Vzorové ceny ID:
<?php
//echo $cena_ID;
if($_GET['id'] == 0 && !isset($_GET['ucet_vzor'])){
//$vzor_cenaID = isset($_GET['ucet_vzor']) && $_GET['ucet_vzor'] > 0 ? "AND cena_id = ".$_GET['ucet_vzor'] : "";

$sql_vzory = "SELECT * FROM ucty 
INNER JOIN ucty_ceny ON ucty.ucet_ID = ucty_ceny.cena_ucet_ID
WHERE ucet_kod_banky = ".$_GET['kodBanky']." ORDER BY cena_platnost_od DESC";
$vzory = vystup_sql($sql_vzory);

echo "<SELECT name='ucet_vzor'><OPTION value=0>0 - žádný</OPTION>";
  while($radek_vzory = mysql_fetch_assoc($vzory)){
  echo "<OPTION value=".$radek_vzory['cena_id'].">".$radek_vzory['cena_id']." - ".$radek_vzory['ucet_nazev']." - platnost od ".$radek_vzory['cena_platnost_od']."</OPTION>";
  }
echo "</SELECT>";
die (" <INPUT type='submit' name='vyber_ucet' value='Potvrdit'>");
}                                                                           
elseif(isset($_GET['ucet_vzor']) && $_GET['ucet_vzor'] > 0){
echo "<INPUT type='hidden' name='ucet_vzor' value=".$_GET['ucet_vzor'].">";
$sql_vzor = "SELECT * FROM ucty_ceny
INNER JOIN ceny_banking ON ucty_ceny.cena_id = ceny_banking.ID
INNER JOIN ucty ON ucty_ceny.cena_ucet_id = ucty.ucet_ID
WHERE cena_id = ".$_GET['ucet_vzor'];
$vzor = vystup_sql($sql_vzor);

echo mysql_result($vzor, 0, 0)."<span class='help'> - ".mysql_result($vzor, 0, 'ucet_nazev').", platnost od ".mysql_result($vzor, 0, 2)."</span>";

//$platnostOd_vzor = mysql_result($vzor, 0, 2);
$zrizeniUctu_vzor = $zrizeniUctu = mysql_result($vzor, 0, 'cena_zrizeni');
$zruseniUctu_vzor = $zruseniUctu = mysql_result($vzor, 0, 'cena_zruseni');

$vedeniUctu = mysql_result($vzor, 0, 'cena_vedeni');
$vedeniUctu_podm = mysql_result($vzor, 0, 'cena_vedeni_podm');
$vedeniUctu_vzor = "$vedeniUctu, podmínka $vedeniUctu_podm";

$vypisE = mysql_result($vzor, 0, 'cena_vypis_e');
$vypisP = mysql_result($vzor, 0, 'cena_vypis_p');
$vypis_vzor = "<span class='help'>Výpis E: $vypisE, P: $vypisP</span><BR>";

$prichozi1_vzor = $prichozi1 = mysql_result($vzor, 0, 'cena_prichozi1');
$prichozi2_vzor = $prichozi2 = mysql_result($vzor, 0, 'cena_prichozi2');
$odchoziTP1_vzor = $odchoziTP1 = mysql_result($vzor, 0, 'cena_odchozi_tp1');
$odchoziTP2_vzor = $odchoziTP2 = mysql_result($vzor, 0, 'cena_odchozi_tp2');
$odchoziOn1_vzor = $odchoziOn1 = mysql_result($vzor, 0, 'cena_odchozi_online1');
$odchoziOn2_vzor = $odchoziOn2 = mysql_result($vzor, 0, 'cena_odchozi_online2');
$odchoziP_vzor = $odchoziP = mysql_result($vzor, 0, 'cena_odchozi_priorita');
$inkSvoleni_vzor = $inkSvoleni = mysql_result($vzor, 0, 'cena_inkaso_svoleni');
$inkOdch_vzor = $inkOdch = mysql_result($vzor, 0, 'cena_inkaso_odchozi');
$koment_ink_vzor = $koment_ink = mysql_result($vzor, 0, 'cena_koment_inkaso');
//$balicek_vzor = $balicek = "<span class='help'>Balíček: ".mysql_result($vzor, 0, 'cena_trans_bal').", typ ".mysql_result($vzor, 0, 'cena_trans_bal_typ')."</span><BR>";
//$balicekTyp = mysql_result($vzor, 0, 24);
$koment_JP_vzor = $koment_JP = mysql_result($vzor, 0, 'cena_koment_JP');
$koment_PP_vzor = $koment_PP = mysql_result($vzor, 0, 'cena_koment_PP');
$koment_trans_vzor = $koment_trans = mysql_result($vzor, 0, 'cena_koment_trans');

$zrizeniIB = mysql_result($vzor, 0, 'ib_Zrizeni');
$zrizeniMB = mysql_result($vzor, 0, 'mb_Zrizeni');
$zrizeniTB = mysql_result($vzor, 0, 'tb_Zrizeni');
$zrizeni_banking_vzor = "Zřízení IB: $zrizeniIB, MB: $zrizeniMB, TB: $zrizeniTB<BR />";

$vedeniIB = mysql_result($vzor, 0, 'ib_Vedeni');
$vedeniMB = mysql_result($vzor, 0, 'mb_Vedeni');
$vedeniTB = mysql_result($vzor, 0, 'tb_Vedeni');
$vedeni_banking_vzor = "<span class='help'>Vedení IB: $vedeniIB, MB: $vedeniMB, TB: $vedeniTB</span><BR>";

$odchozi1_IB = mysql_result($vzor, 0, 'ib_Odchozi1');
$odchozi1_MB = mysql_result($vzor, 0, 'mb_Odchozi1'); 
$odchozi1_TB = mysql_result($vzor, 0, 'tb_Odchozi1');  
$odchozi1_vzor = "<span class='help'>Odchozí1 přes IB: $odchozi1_IB, MB: $odchozi1_MB, TB: $odchozi1_TB</span><BR>";

$odchozi2_IB = mysql_result($vzor, 0, 'ib_Odchozi2');
$odchozi2_MB = mysql_result($vzor, 0, 'mb_Odchozi2'); 
$odchozi2_TB = mysql_result($vzor, 0, 'tb_Odchozi2');  
$odchozi2_vzor = "<span class='help'>Odchozí2 přes IB: $odchozi2_IB, MB: $odchozi2_MB, TB: $odchozi2_TB</span><BR>";

$zrizeniTP_IB = mysql_result($vzor, 0, 'ib_ZrizeniTP');
$zrizeniTP_MB = mysql_result($vzor, 0, 'mb_ZrizeniTP'); 
$zrizeniTP_TB = mysql_result($vzor, 0, 'tb_ZrizeniTP');  
$zrizeniTP_vzor = $zrizeniTP = "<span class='help'>Zřízení TP přes IB: $zrizeniTP_IB, MB: $zrizeniTP_MB, TB: $zrizeniTP_TB</span><BR>";

}

else{
echo "<INPUT type='hidden' name='ucet_vzor' value=0>";
echo "bez vzoru";
$zrizeniUctu_vzor = $zruseniUctu_vzor = $vedeniUctu_vzor = $vypis_vzor = $prichozi1_vzor = $prichozi2_vzor = $odchoziTP1_vzor = $odchoziTP2_vzor = $odchoziOn1_vzor = $odchoziOn2_vzor = $balicek_vzor = $koment_JP_vzor = $koment_PP_vzor = $koment_trans_vzor = $zrizeni_banking_vzor = $vedeni_banking_vzor = $odchozi1_vzor = $odchozi2_vzor = $zrizeniTP_vzor = $odchoziP_vzor = $inkSvoleni_vzor = $inkOdch_vzor = $koment_ink_vzor = Null;
}
?>
<BR>
Platnost Od* <span class='help'>(RRRR-MM-DD)</span>: <INPUT <?php echo ($_GET['id'] == 0 ? "class='chybi' " : ""); ?>type='text' name='platnostOd' value="<?php echo $platnostOd; ?>" size=8 style="text-align:right"<?php echo $popl_read_only; ?>>


<?php

$banka = $_GET['kodBanky'];
$ucetID = $_GET['ucet'];

$vyj_url = "../admin_page/vyjimky.php?kodBanky=$banka&ucet=$ucetID&ucetTyp=".$_GET['ucetTyp']."&nazevUctu=".$_GET['nazevUctu']."&id=".$_GET['id']."&vyber_id="; 
?>

<H3>Jednorázové poplatky</H3>
Zřízení účtu: <INPUT <?php echo ($zrizeniUctu == "" ? "class='chybi' " : ""); ?>type="number" name="zrizeniUctu" value="<?php echo $zrizeniUctu; ?>" style="text-align:right; width:60"<?php echo $popl_read_only; ?>>
<?php echo "<span class='help'>$zrizeniUctu_vzor</span>"; ?>
<BR>
Zřízení bankovnictví - internetové: <INPUT <?php echo ($zrizeniIB == "" ? "class='chybi' " : ""); ?>type="number" name="zrizeniIB" value="<?php echo $zrizeniIB; ?>" style="text-align:right; width:60"<?php echo $popl_read_only; ?>>
- mobilní: <INPUT <?php echo ($zrizeniMB == "" ? "class='chybi' " : ""); ?>type="number" name="zrizeniMB" value="<?php echo $zrizeniMB; ?>" style="text-align:right; width:60"<?php echo $popl_read_only; ?>>
- telefonické: <INPUT <?php echo ($zrizeniTB == "" ? "class='chybi' " : ""); ?>type="number" name="zrizeniTB" value="<?php echo $zrizeniTB; ?>" style="text-align:right; width:60"<?php echo $popl_read_only; ?>><BR>
<span class='help'><?php echo $zrizeni_banking_vzor; ?> (nech zřízení bankovnictví prázdné, pokud ho banka k účtu nenabízí)</span><BR>
Zřízení trvalého příkazu - přes IB: <INPUT <?php echo (($zrizeniIB <> "" && $zrizeniTP_IB == "") || $_GET['id'] == 0 ? "class='chybi' " : ""); ?>type="number" name="zrizeniTP_IB" value="<?php echo $zrizeniTP_IB; ?>" style="text-align:right; width:60"<?php echo $popl_read_only; ?>>
- přes MB: <INPUT <?php echo (($zrizeniMB <> "" && $zrizeniTP_MB == "") || $_GET['id'] == 0 ? "class='chybi' " : ""); ?>type="number" name="zrizeniTP_MB" value="<?php echo $zrizeniTP_MB; ?>" style="text-align:right; width:60"<?php echo $popl_read_only; ?>>
- přes TB: <INPUT <?php echo (($zrizeniTB <> "" && $zrizeniTP_TB == "") || $_GET['id'] == 0 ? "class='chybi' " : ""); ?>type="number" name="zrizeniTP_TB" value="<?php echo $zrizeniTP_TB; ?>" style="text-align:right; width:60"<?php echo $popl_read_only; ?>><BR>
<?php echo "$zrizeniTP_vzor"; ?>
Zrušení účtu: <INPUT <?php echo ($zruseniUctu == "" ? "class='chybi' " : ""); ?>type="number" name="zruseniUctu" value="<?php echo $zruseniUctu; ?>" style="text-align:right; width:60"<?php echo $popl_read_only; ?>>
<?php echo "<span class='help'>$zruseniUctu_vzor</span>"; ?><BR>
Komentář: <TEXTAREA name="koment_JP" cols=80 rows=6<?php echo $popl_read_only; ?>><?php echo $koment_JP; ?></TEXTAREA>
<?php echo "<br><span class='help'>$koment_JP_vzor</span>"; ?>

<H3>Pravidelné měsíční poplatky</H3>
Vedení účtu:
<INPUT type="hidden" name="vedeniUctu_podm" value=0> 
<INPUT type="checkbox" name="vedeniUctu_podm" value=1<?php echo ($vedeniUctu_podm == 1 ? " checked" : "").($_GET['id'] > 0 && !isset($_GET['oprava_popl']) ? " disabled" : ""); ?>>
<INPUT <?php echo ($vedeniUctu == "" ? "class='chybi' " : ""); ?>type="number" name="vedeniUctu" value="<?php echo $vedeniUctu; ?>" style="text-align:right; width:60"<?php echo $popl_read_only; ?>>
<?php echo "<span class='help'>$vedeniUctu_vzor</span>"; 
echo ($_GET['id'] > 0 ? "<a href='$vyj_url&vyj_pole=c_vedeni&vyj_name=vedení_účtu&vyj_puv=$vedeniUctu#vyj' tabindex='-1'>[výjimka]</a>" : ""); ?><BR>
Vedení - IB:
<INPUT <?php echo (($zrizeniIB <> "" && $vedeniIB == "") || $_GET['id'] == 0 ? "class='chybi' " : ""); ?>type="number" name="vedeniIB" value="<?php echo $vedeniIB; ?>" style="text-align:right; width:60"<?php echo $popl_read_only; ?>>
<?php echo ($_GET['id'] > 0 ? "<a href='$vyj_url&vyj_pole=ib_vedeni&vyj_name=vedení_bankingu&vyj_puv=$vedeniIB#vyj' tabindex='-1'>[výjimka]</a>" : ""); ?>
- MB: 
<INPUT <?php echo (($zrizeniMB <> "" && $vedeniMB == "") || $_GET['id'] == 0 ? "class='chybi' " : ""); ?>type="number" name="vedeniMB" value="<?php echo $vedeniMB; ?>" style="text-align:right; width:60"<?php echo $popl_read_only; ?>>
- TB: 
<INPUT <?php echo (($zrizeniTB <> "" && $vedeniTB == "") || $_GET['id'] == 0 ? "class='chybi' " : ""); ?>type="number" name="vedeniTB" value="<?php echo $vedeniTB; ?>" style="text-align:right; width:60"<?php echo $popl_read_only; ?>><BR>
<?php echo $vedeni_banking_vzor; ?>
Výpis - elektronický: <INPUT <?php echo ($vypisE == "" ? "class='chybi' " : ""); ?>type="number" name="vypisE" value="<?php echo $vypisE; ?>" style="text-align:right; width:60"<?php echo $popl_read_only; ?>>
- papírový <span class='help'>(poštou)</span>: <INPUT <?php echo ($vypisP == "" ? "class='chybi' " : ""); ?>type="number" name="vypisP" value="<?php echo $vypisP; ?>" style="text-align:right; width:60"<?php echo $popl_read_only; ?>><BR>
<?php echo $vypis_vzor; ?>
Komentář: <TEXTAREA name="koment_PP" cols=80 rows=6<?php echo $popl_read_only; ?>><?php echo $koment_PP; ?></TEXTAREA>
<?php echo "<br><span class='help'>$koment_PP_vzor</span>"; ?>

<H3>Transakční poplatky - tuzemské</H3>
Příchozí1: <INPUT <?php echo ($prichozi1 == "" ? "class='chybi' " : ""); ?>type="number" name="prichozi1" value="<?php echo $prichozi1; ?>" style="text-align:right; width:60"<?php echo $popl_read_only; ?>>
<?php echo "<span class='help'>$prichozi1_vzor</span>"; ?><BR>
Příchozí2: <INPUT <?php echo ($prichozi2 == "" ? "class='chybi' " : ""); ?>type="number" name="prichozi2" value="<?php echo $prichozi2; ?>" style="text-align:right; width:60"<?php echo $popl_read_only; ?>>
<?php echo "<span class='help'>$prichozi2_vzor</span>"; ?>
<?php echo ($_GET['id'] > 0 ? "<a href='$vyj_url&vyj_pole=c_prich&vyj_name=tuzemské_příchozí_platby&vyj_puv=$prichozi2#vyj' tabindex='-1'>[výjimka]</a>" : "") ?><BR>
Odchozí TP1: <INPUT <?php echo ($odchoziTP1 == "" ? "class='chybi' " : ""); ?>type="number" name="odchoziTP1" value="<?php echo $odchoziTP1; ?>" style="text-align:right; width:60"<?php echo $popl_read_only; ?>>
<?php echo "<span class='help'>$odchoziTP1_vzor</span>"; ?><BR>
Odchozí TP2: <INPUT <?php echo ($odchoziTP2 == "" ? "class='chybi' " : ""); ?>type="number" name="odchoziTP2" value="<?php echo $odchoziTP2; ?>" style="text-align:right; width:60"<?php echo $popl_read_only; ?>>
<?php echo "<span class='help'>$odchoziTP2_vzor</span>"; ?>
<?php echo ($_GET['id'] > 0 ? "<a href='$vyj_url&vyj_pole=odchozi_tp2&vyj_name=odchozí_TP&vyj_puv=$odchoziTP2#vyj' tabindex='-1'>[výjimka]</a>" : "") ?><BR>
Odchozí Online: <INPUT <?php echo ($odchoziOn1 == "" ? "class='chybi' " : ""); ?>type="number" name="odchoziOn1" value="<?php echo $odchoziOn1; ?>" style="text-align:right; width:60"<?php echo $popl_read_only; ?>>
<?php echo "<span class='help'>$odchoziOn1_vzor</span>"; ?><BR>
<!-- Odchozí Online2: <INPUT <?php //echo ($odchoziOn2 == "" ? "class='chybi' " : ""); ?>type="number" name="odchoziOn2" value="<?php echo $odchoziOn2; ?>" style="text-align:right; width:60"<?php echo $popl_read_only; ?>>                 
<?php echo "<span class='help'>$odchoziOn2_vzor</span>"; ?><span class='help' style='color:red'>(má to smysl? rozlišují to banky? zjistit..)
</span><BR> -->
Odchozí1 - přes IB: <INPUT <?php echo (($zrizeniIB <> "" && $odchozi1_IB == "") || $_GET['id'] == 0 ? "class='chybi' " : ""); ?>type="number" name="odchozi1_IB" value="<?php echo $odchozi1_IB; ?>" style="text-align:right; width:60"<?php echo $popl_read_only; ?>>
<?php
echo ($_GET['id'] > 0 ? "<a href='$vyj_url&vyj_pole=p_odch_std_vyj&vyj_name=odchozí_jednorázové&vyj_puv=$odchozi2_IB#vyj' tabindex='-1'>[výjimka-počet]</a>" : ""); ?>
- přes MB: <INPUT <?php echo (($zrizeniMB <> "" && $odchozi1_MB == "") || $_GET['id'] == 0 ? "class='chybi' " : ""); ?>type="number" name="odchozi1_MB" value="<?php echo $odchozi1_MB; ?>" style="text-align:right; width:60"<?php echo $popl_read_only; ?>>
- přes TB: <INPUT <?php echo (($zrizeniTB <> "" && $odchozi1_TB == "") || $_GET['id'] == 0 ? "class='chybi' " : ""); ?>type="number" name="odchozi1_TB" value="<?php echo $odchozi1_TB; ?>" style="text-align:right; width:60"<?php echo $popl_read_only; ?>><BR>
<?php echo $odchozi1_vzor; ?>
Odchozí2 - přes IB: <INPUT <?php echo (($zrizeniIB <> "" && $odchozi2_IB == "") || $_GET['id'] == 0 ? "class='chybi' " : ""); ?>type="number" name="odchozi2_IB" value="<?php echo $odchozi2_IB; ?>" style="text-align:right; width:60"<?php echo $popl_read_only; ?>>
<?php 
echo ($_GET['id'] > 0 ? "<a href='$vyj_url&vyj_pole=c_odch&vyj_name=odchozí_jednorázové&vyj_puv=$odchozi2_IB#vyj' tabindex='-1'>[výjimka]</a>" : "");
echo ($_GET['id'] > 0 ? "<a href='$vyj_url&vyj_pole=p_odch_std_vyj&vyj_name=odchozí_jednorázové&vyj_puv=$odchozi2_IB#vyj' tabindex='-1'>[výjimka-počet]</a>" : ""); ?>
- přes MB: <INPUT <?php echo (($zrizeniMB <> "" && $odchozi2_MB == "") || $_GET['id'] == 0 ? "class='chybi' " : ""); ?>type="number" name="odchozi2_MB" value="<?php echo $odchozi2_MB; ?>" style="text-align:right; width:60"<?php echo $popl_read_only; ?>>
- přes TB: <INPUT <?php echo (($zrizeniTB <> "" && $odchozi2_TB == "") || $_GET['id'] == 0 ? "class='chybi' " : ""); ?>type="number" name="odchozi2_TB" value="<?php echo $odchozi2_TB; ?>" style="text-align:right; width:60"<?php echo $popl_read_only; ?>><BR>
<?php echo $odchozi2_vzor; ?>
Prioritní odchozí: <INPUT <?php echo ($odchoziP == "" ? "class='chybi' " : ""); ?>type="number" name="odchoziP" value="<?php echo $odchoziP; ?>" style="text-align:right; width:60"<?php echo $popl_read_only; ?>><?php echo "<span class='help'>$odchoziP_vzor</span>"; ?><br />


<!-- Balíček transakcí: <INPUT <?php echo ($balicek == "" && $balicekTyp > 0 ? "class='chybi' " : ""); ?>type="number" name="balicek" value="<?php echo $balicek; ?>"  style="text-align:right; width:60"<?php echo $popl_read_only; ?>>
Typ balíčku:
<SELECT name="balicekTyp" <?php echo ($_GET['id'] > 0 && !isset($_GET['oprava_popl']) ? " disabled" : ""); ?>>
<OPTION value=0>0 - žádný</OPTION>
<OPTION value=1<?php echo ($balicekTyp == 1 ? " selected" : ""); ?>>1 - zahrnuje všechny transakce</OPTION>
<OPTION value=2<?php echo ($balicekTyp == 2 ? " selected" : ""); ?>>2 - zahrnuje pouze odchozí, včetne TP</OPTION>
<OPTION value=3<?php echo ($balicekTyp == 3 ? " selected" : ""); ?>>3 - zahrnuje pouze odchozí, bez TP</OPTION>
<OPTION value=4<?php echo ($balicekTyp == 4 ? " selected" : ""); ?>>4 - zahrnuje pouze příchozí</OPTION>
</SELECT>                                                                    
<a href="<?php echo $vyj_url; ?>&vyj_pole=trans_bal_typ&vyj_name=odchozí_platby&vyj_puv=<?php echo $balicek; ?>#vyj" tabindex='-1'>[výjimka]</a><BR>
<?php echo $balicek_vzor; ?>                                                  -->
Komentář: <TEXTAREA name="koment_trans" cols=80 rows=6<?php echo $popl_read_only; ?>><?php echo $koment_trans; ?></TEXTAREA> 
<?php echo "<br><span class='help'>$koment_trans_vzor</span>"; ?>            

<H4>Poplatky za inkaso/SIPO</H4>
Svolení k inkasu: <INPUT <?php echo ($inkSvoleni == "" ? "class='chybi' " : ""); ?>type="number" name="inkSvoleni" value="<?php echo $inkSvoleni; ?>" style="text-align:right; width:60"<?php echo $popl_read_only; ?>>
<?php echo "<span class='help'>$inkSvoleni_vzor</span>"; ?>
Odchozí: <INPUT <?php echo ($inkOdch == "" ? "class='chybi' " : ""); ?>type="number" name="inkOdch" value="<?php echo $inkOdch; ?>" style="text-align:right; width:60"<?php echo $popl_read_only; ?>>
<?php echo "<span class='help'>$inkOdch_vzor</span>"; ?><BR>
Komentář: <TEXTAREA name="koment_ink" cols=80 rows=6<?php echo $popl_read_only; ?>><?php echo $koment_ink; ?></TEXTAREA> 
<?php echo "<br><span class='help'>$koment_ink_vzor</span>"; ?>

</FORM>

<hr />
<H3>Balíčky výhod</H3>
<?php
if($_GET['id'] == 0){
echo "Možno zadat až k uloženým základním poplatkům.";}

else {
?>



<form name='bal' method='post'>
<div style='margin-bottom:40px;'>
Název nového balíčku: <input type='text' name='novy_bal_nazev' size=40<?php echo $popl_read_only; ?> /><br />
Cena nového balíčku: <input type='number' name='novy_bal_cena'<?php echo $popl_read_only; ?> /><br />
Popis balíčku: <TEXTAREA name="novy_bal_koment" cols=80 rows=6<?php echo $popl_read_only; ?>></TEXTAREA><br /> 
<input type='submit' name='novy_bal' value='Přidat nový balíček'<?php echo $_GET['id'] > 0 && !isset($_GET['oprava_popl']) ? " disabled" : ""; ?> />
</div>

<input type='submit' name='zmena_bal' value='Uložit změny v balíčcích'<?php echo $_GET['id'] > 0 && !isset($_GET['oprava_popl']) ? " disabled" : ""; ?> />
<br />
<?php
if(isset($_POST['novy_bal'])){
vystup_sql("INSERT INTO balicky (bal_cena_id, bal_nazev, bal_cena, bal_koment) VALUES (".$_GET['id'].", '".$_POST['novy_bal_nazev']."', ".$_POST['novy_bal_cena'].", '".$_POST['novy_bal_koment']."')");
echo "<meta http-equiv='refresh' content='0;url=/admin_page/admin.php?kodBanky=".$_GET['kodBanky']."&ucet=".$_GET['ucet']."&ucetTyp=".$_GET['ucetTyp']."&nazevUctu=".$_GET['nazevUctu']."&id=".$_GET['id']."&r_cena_d=".$_GET['r_cena_d']."&note=Balíček ".$_POST['novy_bal_nazev']." přidán.#poplatky'>";
}


$sql_balicky = "SELECT * FROM balicky WHERE bal_cena_id = ".$_GET['id'];
$balicky = vystup_sql($sql_balicky);
while($r_balicky = mysql_fetch_assoc($balicky)){ 

$id = $r_balicky['bal_id'];

if(isset($_POST['zmena_bal'])){
vystup_sql("UPDATE balicky SET bal_nazev='".$_POST["bal_nazev$id"]."', bal_cena=".$_POST["bal_cena$id"].", bal_polozek=".$_POST["bal_limit$id"].", bal_volitelny=".$_POST["bal_vol$id"]." WHERE bal_id=".$r_balicky['bal_id']);
}
?>

<div style='margin:5px 10px 50px 10px; display:inline-block; border:1px dashed black; padding:5px;'>
Název balíčku: <input type='text' name='bal_nazev<?php echo $id; ?>' style='font-size:large; border-color:transparent;' value='<?php echo $r_balicky['bal_nazev']; ?>' /><br />
Volitelný: <input type='hidden' name='bal_vol<?php echo $id; ?>' value=0 />
    <input type='checkbox' name='bal_vol<?php echo $id; ?>' value=1<?php echo ($r_balicky['bal_volitelny'] == 1 ? " checked" : ""); ?> /><br />
Kolik položek je možno si vybrat: <input type='number' name='bal_limit<?php echo $id; ?>' value='<?php echo $r_balicky['bal_polozek']; ?>' />
<span class='help'>0 = bez omezení</span><br />
Poplatek za balíček: <input type='number' name='bal_cena<?php echo $id; ?>' value='<?php echo $r_balicky['bal_cena']; ?>' /><br />
Popis balíčku: <TEXTAREA name="bal_koment" cols=80 rows=6<?php echo $popl_read_only; ?>><?php echo $r_balicky['bal_koment']; ?></TEXTAREA><br /> 

<H4>Položky v balíčku</H4>

<?php

echo "<p style='text-indent:0px; background-color:#CCFFFF; padding:2px;'>";
echo "Pole nové pol.: <input type='text' name='bal_pol_pole$id' /><br/>";
echo "Popis nové pol.: <input type='text' name='bal_pol_popis$id' /><br/>";
echo "Počet transakcí nové pol.: <input type='number' name='bal_pol_pocet$id' value=1 /><br/>";
echo "Možností na výběr nové pol.: <input type='number' name='bal_pol_vyber$id' value=1 /><br/>";
echo "Podmínka pro výběr: <input type='text' name='bal_pol_vyber_podm$id' value='' /><br/>";
?>
<span class='help'>příklad zadání podmínky: `obrat >= 5000 AND karta_nazev == `Visa``</span><br />
<input type='submit' name='nova_polozka<?php echo $id; ?>' value='Přidat novou položku do balíčku <?php echo $r_balicky['bal_nazev']; ?>' />
<?php
echo "</p>";


if(isset($_POST["nova_polozka$id"])){
vystup_sql("INSERT INTO bal_polozky (bal_id, bal_pole, bal_popis, bal_pocet_trans, bal_pocet_vyber, bal_podm_vyber) VALUES (".$r_balicky['bal_id'].", '".$_POST["bal_pol_pole$id"]."', '".$_POST["bal_pol_popis$id"]."', ".$_POST["bal_pol_pocet$id"].", ".$_POST["bal_pol_vyber$id"].", '".$_POST["bal_pol_vyber_podm$id"]."')");
echo "<meta http-equiv='refresh' content='0;url=/admin_page/admin.php?kodBanky=".$_GET['kodBanky']."&ucet=".$_GET['ucet']."&ucetTyp=".$_GET['ucetTyp']."&nazevUctu=".$_GET['nazevUctu']."&id=".$_GET['id']."&r_cena_d=".$_GET['r_cena_d']."&note=Nová položka do balíčku ".$r_balicky['bal_nazev']." přidána.#poplatky'>";
}


$sql_bal_polozky = "SELECT * FROM bal_polozky WHERE bal_id = ".$r_balicky['bal_id'];
$bal_polozky = vystup_sql($sql_bal_polozky);
$i = 1;
while($r_bal_polozky = mysql_fetch_assoc($bal_polozky)){

$id = $id."_".$i;

  if(isset($_POST['zmena_bal'])){
  vystup_sql("UPDATE bal_polozky SET
  bal_pole='".$_POST["bal_pol_pole$id"]."',
  bal_popis='".$_POST["bal_pol_popis$id"]."', 
  bal_pocet_trans=".$_POST["bal_pol_trans$id"].", 
  bal_pocet_vyber=".$_POST["bal_pol_vyber$id"].", 
  bal_podm_vyber='".$_POST["bal_pol_vyber_podm$id"]."' WHERE bal_polozka_id=".$r_bal_polozky['bal_polozka_id']);
  }
  
  else{
  echo "<div style='margin:5px 5px 20px 5px; padding:5px;'><span style='font-weight:bold;'>Položka č.$i</span><br />";
  echo "Pole: <input type='text' name='bal_pol_pole$id' value='".$r_bal_polozky['bal_pole']."' /><br/>";
  echo "Popis: <input type='text' name='bal_pol_popis$id' value='".$r_bal_polozky['bal_popis']."' /><br/>";
  echo "Počet transakcí: <input type='number' name='bal_pol_trans$id' value='".$r_bal_polozky['bal_pocet_trans']."' /><br/>";
  echo "Počet možností na výběr: <input type='number' name='bal_pol_vyber$id' value='".$r_bal_polozky['bal_pocet_vyber']."' /><br/>";
  echo "Podmínka pro výběr: <input type='text' name='bal_pol_vyber_podm$id' value='".$r_bal_polozky['bal_podm_vyber']."' /><br/>";
  echo "</div>";
  }
 
$i++;
}
?>
  
</div>

<?php
}

if(isset($_POST['zmena_bal'])){
echo "<meta http-equiv='refresh' content='0;url=/admin_page/admin.php?kodBanky=".$_GET['kodBanky']."&ucet=".$_GET['ucet']."&ucetTyp=".$_GET['ucetTyp']."&nazevUctu=".$_GET['nazevUctu']."&id=".$_GET['id']."&r_cena_d=".$_GET['r_cena_d']."&note=Změny v balíčcích provedeny.#poplatky'>";
}

?>
</form>

<?php
}