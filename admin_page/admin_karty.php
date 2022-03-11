<html>
<head>
<meta charset="utf-8">

<LINK rel="shortcut icon" href="..\favicon.ico" type="image/x-icon" />
<LINK rel="stylesheet" type="text/css" href="..\styly.css">
<title>Srovnávač - administrace</title>

</head>
<body <?php echo (isset($_GET['oprava_karty']) && $_GET['oprava_karty'] <> "" && $_GET['oprava_karty'] <> "Potvrdit" ? "bgcolor=#FFF080" : "bgcolor=#FFFFFF"); ?> text="#000000">

<?php
include 'f_karty.php';
include 'sql_queries.php';

session_start(); 
if($_SESSION['login']!=true)
die ("neoprávněný přístup");  
?>


<a href='/srovnavacPoplatku/admin_page/admin.php' accesskey='r'>RESET</a>
| <a href='/srovnavacPoplatku/admin_page/admin.php?ucet=36&nazevUctu=mKonto&kodBanky=6210&r_cena_d=0&s_popl_karty=Spravovat+poplatky+karet+k+%C3%BA%C4%8Dtu+%282%29&id=81&ucet_vzor=0&platnostOd=2017-05-02&zrizeniUctu=0.00&zrizeniIB=0.00&zrizeniMB=0.00&zrizeniTB=0.00&zrizeniTP_IB=0.00&zrizeniTP_MB=0.00&zrizeniTP_TB=40.00&zruseniUctu=0.00&koment_JP=no+comment&vedeniUctu_podm=0&vedeniUctu=0.00&vedeniIB=0.00&vedeniMB=0.00&vedeniTB=0.00&vypisE=0.00&vypisP=50.00&koment_PP=no+comment&prichozi1=0.00&prichozi2=0.00&odchoziTP1=0.00&odchoziTP2=0.00&odchoziOn1=0.00&odchozi1_IB=0.00&odchozi1_MB=0.00&odchozi1_TB=40.00&odchozi2_IB=0.00&odchozi2_MB=0.00&odchozi2_TB=40.00&odchoziP=&koment_trans=no+comment&inkSvoleni=0.00&inkOdch=0.00&koment_ink=no+comment&kontZrizeni=0.00&kontVedeni=0.00&kontZruseni=0.00&koment_kont=no+comment'>TEST</a>                                     
| <a href='/srovnavacPoplatku/srovnavac/bezne_ucty'>SROVNÁVAČ</a>


<?php
include "../core/db/pripojeni_sql.php";

$footer = "<BR>
<div style='background-color:red; text-align:center; position:fixed; color:white; bottom:0px; width:100%; font-size:small'>&copy;2013+, Nulovepoplatky.cz, Všechna práva vyhrazena. Optimalizováno pro Google Chrome (<a href='http://www.google.com/chrome' target='_blank'>zde</a> ke stažení) v rozlišení 1280 x 1024 px.</div>";

?>
<H1>ADMINISTRACE</H1>

<?php

$note = isset($_GET['note']) ? $_GET['note'] : "";
echo "<p style='color:green; font-weight:bold; font-size:small'>$note</p>";
?>

<FORM name='karty_admin' method='GET' action=''>

<?php

$sql_karta_d = "SELECT * FROM ceny_karty INNER JOIN ucty_ceny ON ceny_karty.karta_cena_id = ucty_ceny.cena_id
WHERE karta_cena_ID = ".$_GET['id']." ORDER BY karta_id ASC";
$karta_d = vystup_sql($sql_karta_d);     

$pocet_karet = pocetKaretPoplatku($_GET['id']);

$smazano_karet = isset($_GET['oprava_karty']) && $_GET['oprava_karty'] <> "Potvrdit" && isset($_GET['pocet_karet']) ? $_GET['pocet_karet'] - $pocet_karet : 0;
echo ($smazano_karet > 0 ? "<span style='color:red; font-weight:bold'>Smazáno karet: $smazano_karet</span>" : Null);

  if(isset($_GET['s_popl_ucet']) && $_GET['s_popl_ucet']=='Spravovat poplatky účtu'){
  header("location:admin.php?kodBanky=".$_GET['kodBanky']."&ucet=".$_GET['ucet']."&ucetTyp=".$_GET['ucetTyp']."&nazevUctu=".$_GET['nazevUctu']."&id=".$_GET['id']."&r_cena_d=".$_GET['r_cena_d']);
  }
  
  elseif(isset($_GET['oprava_karty']) && $_GET['oprava_karty'] == "Přidat novou kartu"){
  $pocet_karet++;
  echo "<INPUT type='hidden' name='pocet_karet' value=$pocet_karet>";                 
  }
  
  elseif(isset($_GET['oprava_karty']) && $_GET['oprava_karty'] == "Potvrdit"){
    if($_GET['karty_vzor'] <> ''){
    $copyDetail = copyKarty($_GET['karty_vzor'], $_GET['id']);
    
    echo "<meta http-equiv='refresh' content='0;url=/srovnavacPoplatku/admin_page/admin_karty.php?kodBanky=".$_GET['kodBanky']."&ucet=".$_GET['ucet']."&ucetTyp=".$_GET['ucetTyp']."
    &nazevUctu=".$_GET['nazevUctu']."&r_cena_d=".$_GET['r_cena_d']."&id=".$_GET['id']."&oprava_karty=&note=Karty zkopírovány (".$copyDetail['pocetVyjimek']." výjimek).#karty'>";
    }
    else
    echo "<span style='color:red; font-weight:bold'>Akce se nezdařila, nebyl vybrán účet ke zkopírování karet.</span>";
  }
        
  elseif(isset($_GET['oprava_karty']) && $_GET['oprava_karty'] == "Uložit novou kartu"){
  $id = $_GET['pocet_karet'];
  $kartaID = $_GET["kartaID$id"];
  $nazevKarty = $_GET["nazevKarty$id"];
  $typKarty = $_GET["typKarty$id"];
  
  // POPLATKY HLAVNÍ KARTY
  $vydaniKartyH = $_GET["vydaniKartyH$id"];
  $vedeniKartyH = $_GET["vedeniKartyH$id"];
  $vyber1H = $_GET["vyber1H$id"];
  $vyber2H = $_GET["vyber2H$id"];
  $vyber3H = $_GET["vyber3H$id"];
  $cashbackH = $_GET["cashbackH$id"];
  $vkladH = $_GET["vkladH$id"];
  $komentH = $_GET["komentH$id"];
  $komentD = $_GET["komentD$id"];
  $komentOb = $_GET["komentOb"];
  
  $sql_ulozit_kartuH = "INSERT INTO ceny_karty (karta_cena_id, karta_ID, karta_nazev, karta_druh, karta_typ, kartaH_vydani, kartaH_vedeni, kartaH_vyber1, kartaH_vyber2, kartaH_vyber3, kartaH_cashback, kartaH_vklad, kartaH_koment, kartaD_koment)
  VALUES (".$_GET['id'].", $kartaID, '$nazevKarty', 'debet', $typKarty, 
  ".($vydaniKartyH=="" ? "Null" : $vydaniKartyH).", 
  ".($vedeniKartyH=="" ? "Null" : $vedeniKartyH).", 
  ".($vyber1H=="" ? "Null" : $vyber1H).", 
  ".($vyber2H=="" ? "Null" : $vyber2H).", 
  ".($vyber3H=="" ? "Null" : $vyber3H).", 
  ".($cashbackH=="" ? "Null" : $cashbackH).", 
  ".($vkladH=="" ? "Null" : $vkladH).", 
  '".htmlspecialchars($komentH, ENT_QUOTES)."',
  '".htmlspecialchars($komentD, ENT_QUOTES)."')";
  $ulozit_kartuH = vystup_sql($sql_ulozit_kartuH);
  
  $sql_karta_koment = "UPDATE ucty_ceny SET cena_koment_karta = '".htmlspecialchars($komentOb, ENT_QUOTES)."' WHERE cena_id = ".$_GET['id'];
  $karta_koment = vystup_sql($sql_karta_koment);
  
  // POPLATKY DODATKOVÉ KARTY..                                                 
  $vydaniKartyD = $_GET['hd'] == 1 ? $vydaniKartyH : $_GET["vydaniKartyD$id"];
  	if(is_numeric($vydaniKartyD) && $vydaniKartyD >= 0){
  	
  	$vedeniKartyD = $_GET['hd'] == 1 ? $vedeniKartyH : $_GET["vedeniKartyD$id"];	
  	$vyber1D = $_GET['hd'] == 1 ? $vyber1H : $_GET["vyber1D$id"];
  	$vyber2D = $_GET['hd'] == 1 ? $vyber2H : $_GET["vyber2D$id"];
  	$vyber3D = $_GET['hd'] == 1 ? $vyber3H : $_GET["vyber3D$id"];
  	$cashbackD = $_GET['hd'] == 1 ? $cashbackH :  $_GET["cashbackD$id"];
  	$vkladD = $_GET['hd'] == 1 ? $vkladH : $_GET["vkladD$id"];
    
  	
    $sql_ulozit_kartuD = "UPDATE ceny_karty SET kartaD_vydani = $vydaniKartyD,
    ".($vedeniKartyD == Null ? "kartaD_vedeni=Null" : "kartaD_vedeni = $vedeniKartyD").", 
    ".($vyber1D == Null ? "kartaD_vyber1=Null" : "kartaD_vyber1 = $vyber1D").", 
    ".($vyber2D == Null ? "kartaD_vyber2=Null" : "kartaD_vyber2 = $vyber2D").", 
    ".($vyber3D == Null ? "kartaD_vyber3=Null" : "kartaD_vyber3 = $vyber3D").", 
    ".($cashbackD == Null ? "kartaD_cashback=Null" : "kartaD_cashback = $cashbackD").", 
    ".($vkladD == Null ? "kartaD_vklad=Null" : "kartaD_vklad = $vkladD")."
    WHERE karta_cena_ID = ".$_GET['id']." AND karta_ID = $kartaID";
  	$ulozit_kartuD = vystup_sql($sql_ulozit_kartuD);	
    }
  
  echo "<meta http-equiv='refresh' content='0;url=/srovnavacPoplatku/admin_page/admin_karty.php?kodBanky=".$_GET['kodBanky']."&ucet=".$_GET['ucet']."&ucetTyp=".$_GET['ucetTyp']."&nazevUctu=".$_GET['nazevUctu']."&r_cena_d=".$_GET['r_cena_d']."&id=".$_GET['id']."&oprava_karty=&note=Nová karta uložena.#karty'>";
  }
?>

<H2>Kartové poplatky k účtu <U><?php echo $_GET['nazevUctu']; ?></U></H2>

<INPUT type='hidden' name='ucet' value=<?php echo $_GET['ucet']; ?>>
<INPUT type='hidden' name='ucetTyp' value=<?php echo $_GET['ucetTyp']; ?>>
<INPUT type='hidden' name='nazevUctu' value='<?php echo $_GET['nazevUctu']; ?>'>
<INPUT type='hidden' name='kodBanky' value='<?php echo $_GET['kodBanky']; ?>'>
<INPUT type='hidden' name='r_cena_d' value='<?php echo $_GET['r_cena_d']; ?>'>
ID poplatků: <INPUT type='text' name='id' value=<?php echo $_GET['id']; ?> size=2 readonly>

<?php
echo "<INPUT type='submit' name='oprava_karty' value='".(isset($_GET['oprava_karty']) && $_GET['oprava_karty'] == "Provést změny v kartách" ? "Uložit změny v kartách" : "Provést změny v kartách")."'".($pocet_karet == 0 || (isset($_GET['oprava_karty']) && $_GET['oprava_karty'] == "Přidat novou kartu") ? " disabled" : "").">"; 

$nova_karta = isset($_GET['oprava_karty']) && $_GET['oprava_karty'] == "Přidat novou kartu" ? "Uložit novou kartu" : "Přidat novou kartu";
echo " <INPUT type='submit' name='oprava_karty' value='$nova_karta'".(isset($_GET['oprava_karty']) && $_GET['oprava_karty'] == "Provést změny v kartách" ? " disabled" : "")." accesskey='n'>";

echo (isset($_GET['oprava_karty']) && $_GET['oprava_karty'] == "Přidat novou kartu" ? " <INPUT type='submit' name='s_popl_karty' value='Neukládat'>" : "");

echo "<span style='letter-spacing:50'> 
<INPUT type='submit' name='s_popl_ucet' value='Spravovat poplatky účtu'".
(isset($_GET['oprava_karty']) && ($_GET['oprava_karty'] == "Provést změny v kartách" || $_GET['oprava_karty'] == "Přidat novou kartu") ? " disabled" : "")."></span>";

  if($pocet_karet == 1 && isset($_GET['oprava_karty']) && $_GET['oprava_karty'] == "Přidat novou kartu"){
  
  $sql_karta_vzor = "SELECT cena_id, ucet_nazev, cena_platnost_od, count(ID) FROM ceny_karty 
  INNER JOIN ucty_ceny ON ceny_karty.karta_cena_id = ucty_ceny.cena_id 
  INNER JOIN ucty ON ucty_ceny.cena_ucet_id = ucty.ucet_ID
  WHERE ucty.ucet_kod_banky = ".$_GET['kodBanky']." GROUP BY cena_id ORDER BY cena_id DESC";
  $karta_vzor = vystup_sql($sql_karta_vzor);
     
  echo "<P style='text-indent:10'>Zkopírovat karty z účtu:
  <SELECT name='karty_vzor'>
  <OPTION value=''> nekopírovat</OPTION>";
   
    while($radek_karta_vzor = mysqli_fetch_row($karta_vzor))
    {
    echo "<OPTION value=".$radek_karta_vzor['0'].">".$radek_karta_vzor['0']." - ".$radek_karta_vzor['1']." - platnost od ".$radek_karta_vzor['2']." (".$radek_karta_vzor['3'].")</OPTION>";
    } 
  
  echo "</SELECT> <INPUT type='submit' name='oprava_karty' value='Potvrdit'></P>";  
  }

$komentOb = $pocet_karet > 0 && (!isset($_GET['oprava_karty']) || (isset($_GET['oprava_karty']) && ($_GET['oprava_karty'] <> "Přidat novou kartu" || ($_GET['oprava_karty'] == "Přidat novou kartu" && $pocet_karet > 1)))) ? mysqli_result($karta_d, 0, 'cena_koment_karta') : "bez karty";
echo "<p>Komentář ke kartám obecně: <BR><TEXTAREA name='komentOb' cols=80 rows=5".(!isset($_GET['oprava_karty']) || (isset($_GET['oprava_karty']) && $_GET['oprava_karty'] <> "Provést změny v kartách" && $_GET['oprava_karty'] <> "Přidat novou kartu") ? " readonly" : "").">$komentOb</TEXTAREA></p>"; 

if(isset($_GET['oprava_karty']) && $_GET['oprava_karty'] == "Provést změny v kartách"){
  for($i=1; $i<=$pocet_karet; ++$i){ 
  $sql_update_kartaID = "UPDATE ceny_karty SET karta_ID = $i WHERE ID = ".mysqli_result($karta_d, $i-1, 0);
  $update_kartaID = vystup_sql($sql_update_kartaID); 
  }
}

for($i=1; $i<=$pocet_karet; ++$i){ 

$radek = $i - 1;

  if($i == $pocet_karet && isset($_GET['oprava_karty']) && $_GET['oprava_karty'] == "Přidat novou kartu"){
  $kartaID = $nazevKarty = $typKarty = $vydaniKartyH = $vedeniKartyH = $vyber1H = $vyber2H = $vyber3H = $cashbackH = $vkladH = $vydaniKartyD = $vedeniKartyD = $vyber1D = $vyber2D = $vyber3D = $cashbackD = $vkladD = Null;
  $komentH = $komentD = "no comment";
  }
  
  else{
    
    if(isset($_GET['oprava_karty']) && $_GET['oprava_karty'] == "Uložit změny v kartách"){
                                                                        
    $sql_zmena_karta = "UPDATE ceny_karty SET 
    karta_nazev = '".$_GET["nazevKarty$i"]."', 
    karta_typ = ".$_GET["typKarty$i"]."
    ".($_GET["vydaniKartyH$i"] == Null ? "," : ", kartaH_vydani = ".$_GET["vydaniKartyH$i"].", ")."
    ".($_GET["vedeniKartyH$i"] == Null ? "kartaH_vedeni=Null" : "kartaH_vedeni = ".$_GET["vedeniKartyH$i"]).", 
    ".($_GET["vyber1H$i"] == Null ? "kartaH_vyber1=Null" : "kartaH_vyber1 = ".$_GET["vyber1H$i"]).", 
    ".($_GET["vyber2H$i"] == Null ? "kartaH_vyber2=Null" : "kartaH_vyber2 = ".$_GET["vyber2H$i"]).",
    ".($_GET["vyber3H$i"] == Null ? "kartaH_vyber3=Null" : "kartaH_vyber3 = ".$_GET["vyber3H$i"]).",
    ".($_GET["cashbackH$i"] == Null ? "kartaH_cashback=Null" : "kartaH_cashback = ".$_GET["cashbackH$i"]).", 
    ".($_GET["vkladH$i"] == Null ? "kartaH_vklad=Null" : "kartaH_vklad = ".$_GET["vkladH$i"]).",
    ".($_GET["komentH$i"] == Null ? "kartaH_koment='no comment'" : "kartaH_koment = '".htmlspecialchars($_GET["komentH$i"],ENT_QUOTES)."'").",
    ".($_GET["vydaniKartyD$i"] == Null ? "kartaD_vydani=Null" : "kartaD_vydani = ".$_GET["vydaniKartyD$i"]).",
    ".($_GET["vedeniKartyD$i"] == Null ? "kartaD_vedeni=Null" : "kartaD_vedeni = ".$_GET["vedeniKartyD$i"]).", 
    ".($_GET["vyber1D$i"] == Null ? "kartaD_vyber1=Null" : "kartaD_vyber1 = ".$_GET["vyber1D$i"]).", 
    ".($_GET["vyber2D$i"] == Null ? "kartaD_vyber2=Null" : "kartaD_vyber2 = ".$_GET["vyber2D$i"]).",
    ".($_GET["vyber3D$i"] == Null ? "kartaD_vyber3=Null" : "kartaD_vyber3 = ".$_GET["vyber3D$i"]).",
    ".($_GET["cashbackD$i"] == Null ? "kartaD_cashback=Null" : "kartaD_cashback = ".$_GET["cashbackD$i"]).", 
    ".($_GET["vkladD$i"] == Null ? "kartaD_vklad=Null" : "kartaD_vklad = ".$_GET["vkladD$i"]).",
    ".($_GET["komentD$i"] == Null ? "kartaD_koment='no comment'" : "kartaD_koment = '".htmlspecialchars($_GET["komentD$i"],ENT_QUOTES)."'")." 
    WHERE karta_cena_ID = ".$_GET['id']." AND karta_ID = ".$_GET["kartaID$i"];
    $zmena_karta = vystup_sql($sql_zmena_karta);                          
    
      if(isset($_GET["smazat_kartu$i"]) && $_GET["smazat_kartu$i"] == 1){
      $sql_smaz_kartu = "DELETE FROM ceny_karty WHERE karta_cena_ID = ".$_GET['id']." AND karta_ID = ".$_GET["kartaID$i"];
      $smaz_kartu = vystup_sql($sql_smaz_kartu);

      }
    
    $sql_zmena_karta_koment = "UPDATE ucty_ceny SET 
    ".($_GET["komentOb"] == Null || $_GET["komentOb"] == "" ? "cena_koment_karta='".prazdnyKartaObecnyKoment($pocet_karet)."'" : "cena_koment_karta = '".htmlspecialchars($_GET["komentOb"],ENT_QUOTES)."'")
    ." WHERE cena_id = ".$_GET['id'];
    $zmena_karta_koment = vystup_sql($sql_zmena_karta_koment); 
    
    }
    
    $kartaID = mysqli_result($karta_d, $radek, 'karta_ID');
    $nazevKarty = mysqli_result($karta_d, $radek, 'karta_nazev');
    $nazevDruh = mysqli_result($karta_d, $radek, 'karta_druh');
    $typKarty = mysqli_result($karta_d, $radek, 'karta_typ');
    $vedeniKartyH = mysqli_result($karta_d, $radek, 'kartaH_vedeni');
    $vyber1H = mysqli_result($karta_d, $radek, 'kartaH_vyber1');
    $vyber2H = mysqli_result($karta_d, $radek, 'kartaH_vyber2');
    $vyber3H = mysqli_result($karta_d, $radek, 'kartaH_vyber3');
    $cashbackH = mysqli_result($karta_d, $radek, 'kartaH_cashback');
    $vkladH = mysqli_result($karta_d, $radek, 'kartaH_vklad');
    $vedeniKartyD = mysqli_result($karta_d, $radek, 'kartaD_vedeni');
    $vyber1D = mysqli_result($karta_d, $radek, 'kartaD_vyber1');
    $vyber2D = mysqli_result($karta_d, $radek, 'kartaD_vyber2');
    $vyber3D = mysqli_result($karta_d, $radek, 'kartaD_vyber3');
    $cashbackD = mysqli_result($karta_d, $radek, 'kartaD_cashback');
    $vkladD = mysqli_result($karta_d, $radek, 'kartaD_vklad');
    $komentH = mysqli_result($karta_d, $radek, 'kartaH_koment');
    $komentD = mysqli_result($karta_d, $radek, 'kartaD_koment');
    $vydaniKartyH = mysqli_result($karta_d, $radek, 'kartaH_vydani');
    $vydaniKartyD = mysqli_result($karta_d, $radek, 'kartaD_vydani');
    $komentOb = mysqli_result($karta_d, $radek, 'cena_koment_karta');
    }

$karta_readonly = (!isset($_GET['oprava_karty']) || (isset($_GET['oprava_karty']) && $_GET['oprava_karty'] == "Přidat novou kartu" && $kartaID == $i) || isset($_GET['note']) ? " readonly" : "");
$chybi_podm2 = isset($_GET['oprava_karty']) && $_GET['oprava_karty'] == "Přidat novou kartu" && $i == $pocet_karet ? 1 : 0;

$vyj_url = "../admin_page/vyjimky.php?kodBanky=".$_GET['kodBanky']."&ucet=".$_GET['ucet']."&ucetTyp=".$_GET['ucetTyp']."&nazevUctu=".$_GET['nazevUctu']."&id=".$_GET['id']."&r_cena_d=0&vyber_id=&s_popl_karty=";

echo "<H3>Karta č.$i".($chybi_podm2 == 1 ? " - nová karta" : "")."</H3>
<INPUT type='hidden' name='kartaID$i' value='$i'>
<INPUT type='hidden' name='hd' value=0>
Název karty*: <INPUT ".($nazevKarty == "" ? "class='chybi' " : "")."type='text' name='nazevKarty$i' value='$nazevKarty' size=30 maxlength=55$karta_readonly>
".($chybi_podm2 == 1 ? "<input type='checkbox' name='hd' value=1> poplatky za dodatkovou kartu jsou stejné jako za hlavní" : "").
(isset($_GET['oprava_karty']) && $_GET['oprava_karty'] == "Provést změny v kartách" ? "<INPUT type='checkbox' name='smazat_kartu$i' value=1> SMAZAT" : "")."<BR>
Typ karty*: 
<INPUT type='radio' name='typKarty$i' value=1".($typKarty == 1 ? " checked" : "").(!isset($_GET['oprava_karty']) || (isset($_GET['oprava_karty']) && $_GET['oprava_karty'] == "Přidat novou kartu" && $kartaID == $i) || isset($_GET['note']) ? " disabled" : "").">Kontaktní
<INPUT type='radio' name='typKarty$i' value=2".($typKarty == 2 ? " checked" : "").(!isset($_GET['oprava_karty']) || (isset($_GET['oprava_karty']) && $_GET['oprava_karty'] == "Přidat novou kartu" && $kartaID == $i) || isset($_GET['note']) ? " disabled" : "").">Bezkontaktní
<INPUT type='radio' name='typKarty$i' value=3".($typKarty == 3 ? " checked" : "").(!isset($_GET['oprava_karty']) || (isset($_GET['oprava_karty']) && $_GET['oprava_karty'] == "Přidat novou kartu" && $kartaID == $i) || isset($_GET['note']) ? " disabled" : "").">Virtuální
<INPUT type='radio' name='typKarty$i' value=4".($typKarty == 4 ? " checked" : "").(!isset($_GET['oprava_karty']) || (isset($_GET['oprava_karty']) && $_GET['oprava_karty'] == "Přidat novou kartu" && $kartaID == $i) || isset($_GET['note']) ? " disabled" : "").">Nálepka<BR>
Vydání karty - hlavní: <INPUT ".($vydaniKartyH == "" ? "class='chybi' " : "")."type='number' name='vydaniKartyH$i' value='$vydaniKartyH' style='text-align:right; width:60'$karta_readonly>
- dodatkové: <INPUT ".($vydaniKartyD == "" ? "class='chybi' " : "")."type='number' name='vydaniKartyD$i' value='$vydaniKartyD' style='text-align:right; width:60'$karta_readonly> <span class='help'>(nech prázdné, pokud se dodatková nenabízí)</span><BR>
Vedení karty - hlavní: <INPUT ".($vedeniKartyH == "" ? "class='chybi' " : "")."type='number' name='vedeniKartyH$i' value='$vedeniKartyH' style='text-align:right; width:60'$karta_readonly>".($chybi_podm2 == 0 ? "<a href='$vyj_url&karta_id=".mysqli_result($karta_d, $radek, 'ID')."&vyj_pole=c_kartaH_vedeni&vyj_name=Vedení%20karty%20($nazevKarty)&vyj_puv=$vedeniKartyH#vyj' tabindex='-1'> [výjimka]</a>" : "")."
- dodatkové: <INPUT ".(($vydaniKartyD <> "" && $vedeniKartyD == "") || $chybi_podm2 == 1 ? "class='chybi' " : "")."type='number' name='vedeniKartyD$i' value='$vedeniKartyD' style='text-align:right; width:60'$karta_readonly><BR>
Výběr z bankomatu".($chybi_podm2 == 0 ? "<a href='$vyj_url&karta_id=".mysqli_result($karta_d, $radek, 'ID')."&vyj_pole=c_kartaH_vybery&vyj_name=Výběry kartou ($nazevKarty)&vyj_puv=$vyber1H/$vyber3H#vyj' tabindex='-1'> [výjimka]</a>" : "")."<BR />
<DIV style='text-indent:50'>
	- vlastní banky - hlavní kartou: <INPUT ".($vyber1H == "" && $typKarty <> 3 ? "class='chybi' " : "")."type='number' name='vyber1H$i' value='$vyber1H' style='text-align:right; width:60'$karta_readonly>".($chybi_podm2 == 0 ? "<a href='$vyj_url&karta_id=".mysqli_result($karta_d, $radek, 'ID')."&vyj_pole=c_kartaH_vyber1&vyj_name=Výběr z vlastního bankomatu ($nazevKarty)&vyj_puv=$vyber1H#vyj' tabindex='-1'> [výjimka]</a>
<a href='$vyj_url&karta_id=".mysqli_result($karta_d, $radek, 'ID')."&vyj_pole=p_kartaH_vyber1_vyj&vyj_name=Počet výběrů z vlastního bankomatu ($nazevKarty)&vyj_puv=$vyber1H#vyj' tabindex='-1'>[výjimka-počet]</a>" : "")."
- dodatkovou kartou: <INPUT ".(($vydaniKartyD <> "" && $vyber1D == "" && $typKarty <> 3) || $chybi_podm2 == 1 ? "class='chybi' " : "")."type='number' name='vyber1D$i' value='$vyber1D' style='text-align:right; width:60'$karta_readonly><BR>
</DIV>
<DIV style='text-indent:50'>
	- &#34;zpřátelené&#34; banky - hlavní kartou: <INPUT ".($vyber2H == "" && $typKarty <> 3 ? "class='chybi' " : "")."type='number' name='vyber2H$i' value='$vyber2H' style='text-align:right; width:60'$karta_readonly>
- dodatkovou kartou: <INPUT ".(($vydaniKartyD <> "" && $vyber2D == "" && $typKarty <> 3) || $chybi_podm2 == 1 ? "class='chybi' " : "")."type='number' name='vyber2D$i' value='$vyber2D' style='text-align:right; width:60'$karta_readonly><BR>
</DIV>
<DIV style='text-indent:50'>
	- cizí banky - hlavní kartou: <INPUT ".($vyber3H == "" && $typKarty <> 3 ? "class='chybi' " : "")."type='text' name='vyber3H$i' value='$vyber3H' style='text-align:right; width:60'$karta_readonly>".($chybi_podm2 == 0 ? "<a href='$vyj_url&karta_id=".mysqli_result($karta_d, $radek, 'ID')."&vyj_pole=c_kartaH_vyber2&vyj_name=Výběr z cizího bankomatu ($nazevKarty)&vyj_puv=$vyber3H#vyj' tabindex='-1'> [výjimka]</a>
<a href='$vyj_url&karta_id=".mysqli_result($karta_d, $radek, 'ID')."&vyj_pole=p_kartaH_vyber2_vyj&vyj_name=Počet výběrů z cizího bankomatu ($nazevKarty)&vyj_puv=$vyber3H#vyj' tabindex='-1'>[výjimka-počet]</a>" : "")."
- dodatkovou kartou: <INPUT ".(($vydaniKartyD <> "" && $vyber3D == "" && $typKarty <> 3) || $chybi_podm2 == 1 ? "class='chybi' " : "")."type='text' name='vyber3D$i' value='$vyber3D' style='text-align:right; width:60'$karta_readonly><BR>
</DIV>
Výběr u obchodníka (cashback) - hlavní kartou: <INPUT ".($cashbackH == "" && $typKarty <> 3 ? "class='chybi' " : "")."type='number' name='cashbackH$i' value='$cashbackH' style='text-align:right; width:60'$karta_readonly>
- dodatkovou kartou: <INPUT ".(($vydaniKartyD <> "" && $cashbackD == "" && $typKarty <> 3) || $chybi_podm2 == 1 ? "class='chybi' " : "")."type='number' name='cashbackD$i' value='$cashbackD' style='text-align:right; width:60'$karta_readonly><BR>
Vklad přes vkladomat - hlavní kartou: <INPUT ".($vkladH == "" && $typKarty <> 3 ? "class='chybi' " : "")."type='number' name='vkladH$i' value='$vkladH' style='text-align:right; width:60'$karta_readonly>
- dodatkovou kartou: <INPUT ".(($vydaniKartyD <> "" && $vkladD == "" && $typKarty <> 3) || $chybi_podm2 == 1 ? "class='chybi' " : "")."type='number' name='vkladD$i' value='$vkladD' style='text-align:right; width:60'$karta_readonly><BR>
Komentář k hlavní kartě: <BR><TEXTAREA name='komentH$i' cols=80 rows=5$karta_readonly>$komentH</TEXTAREA><BR>
Komentář k dodatkové kartě: <BR><TEXTAREA name='komentD$i' cols=80 rows=5$karta_readonly>$komentD</TEXTAREA>";
    }

echo "</form>";
 
echo (isset($_GET['oprava_karty']) && $_GET['oprava_karty'] == "Uložit změny v kartách") ? "<meta http-equiv='refresh' content='0;url=/srovnavacPoplatku/admin_page/admin_karty.php?kodBanky=".$_GET['kodBanky']."&ucet=".$_GET['ucet']."&ucetTyp=".$_GET['ucetTyp']."&nazevUctu=".$_GET['nazevUctu']."&r_cena_d=".$_GET['r_cena_d']."&id=".$_GET['id']."&oprava_karty=&pocet_karet=$pocet_karet&note=Změny v kartách uloženy.'>" : "";

if($id_spojeni)
{
  mysqli_close($id_spojeni);
//  echo 'odpojeno <br>';
} 
?>

<BR>

<?php echo $footer; ?>

</BODY>
</HTML>
