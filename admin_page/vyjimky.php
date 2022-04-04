<html>
<head>
<meta charset="utf-8">

<LINK rel="shortcut icon" href="..\favicon.ico" type="image/x-icon" />
<LINK rel="stylesheet" type="text/css" href="..\styly.css">
<title>Srovnávač - administrace</title>

</head>
<body text="#000000">

<?php
session_start(); 
if($_SESSION['login']!=true)
die ("neoprávněný přístup");  
?>

<a href='/srovnavacPoplatku/admin_page/admin.php' accesskey='r'>RESET</a>
| <a href='/srovnavacPoplatku/admin_page/admin.php?ucet=36&nazevUctu=mKonto&kodBanky=6210&r_cena_d=0&s_popl_karty=Spravovat+poplatky+karet+k+%C3%BA%C4%8Dtu+%282%29&id=81&ucet_vzor=0&platnostOd=2017-05-02&zrizeniUctu=0.00&zrizeniIB=0.00&zrizeniMB=0.00&zrizeniTB=0.00&zrizeniTP_IB=0.00&zrizeniTP_MB=0.00&zrizeniTP_TB=40.00&zruseniUctu=0.00&koment_JP=no+comment&vedeniUctu_podm=0&vedeniUctu=0.00&vedeniIB=0.00&vedeniMB=0.00&vedeniTB=0.00&vypisE=0.00&vypisP=50.00&koment_PP=no+comment&prichozi1=0.00&prichozi2=0.00&odchoziTP1=0.00&odchoziTP2=0.00&odchoziOn1=0.00&odchozi1_IB=0.00&odchozi1_MB=0.00&odchozi1_TB=40.00&odchozi2_IB=0.00&odchozi2_MB=0.00&odchozi2_TB=40.00&odchoziP=&koment_trans=no+comment&inkSvoleni=0.00&inkOdch=0.00&koment_ink=no+comment&kontZrizeni=0.00&kontVedeni=0.00&kontZruseni=0.00&koment_kont=no+comment'>TEST</a>                                     
| <a href='/srovnavacPoplatku/srovnavac/bezne_ucty'>SROVNÁVAČ</a>

<?php
include "../pripojeni_sql.php";

$footer = "<BR>
<div style='background-color:red; text-align:center; position:fixed; color:white; bottom:0px; width:100%; font-size:small'>&copy;2013+, Nulovepoplatky.cz, Všechna práva vyhrazena. Optimalizováno pro Google Chrome (<a href='http://www.google.com/chrome' target='_blank'>zde</a> ke stažení) v rozlišení 1280 x 1024 px.</div>";
?>

<H1>ADMINISTRACE</H1>

<?php

$note = isset($_GET['note']) ? $_GET['note'] : "";
echo "<p style='color:green; font-weight:bold; font-size:small'>$note</p>";


//    V Ý J I M K Y

if(isset($_GET['ucet']) && $_GET['ucet'] <> "" && isset($_GET['vyj_name']))
{
  $vyj_url = isset($_GET['s_popl_karty'])
    ? "admin_karty.php?kodBanky=".$_GET['kodBanky']."&ucet=".$_GET['ucet']."&ucetTyp=".$_GET['ucetTyp']."&nazevUctu=".$_GET['nazevUctu']."&id=".$_GET['id']."&r_cena_d=0&vyber_id=&s_popl_karty=" 
    : (isset($_GET['vyber_id'])
        ? "admin.php?kodBanky=".$_GET['kodBanky']."&ucet=".$_GET['ucet']."&ucetTyp=".$_GET['ucetTyp']."&nazevUctu=".$_GET['nazevUctu']."&id=".$_GET['id']."&vyber_id="
        : "admin.php?kodBanky=".$_GET['kodBanky']."&ucet=".$_GET['ucet']."&ucetTyp=".$_GET['ucetTyp']);
?>

<hr>
<div id='vyj' style='text-align:right;padding-top:5'><a href='<?php echo $vyj_url; ?>'>zpět</a></div>
<div style='font-size:x-large;padding:20 0 20 0;font-variant:small-caps'>VÝJIMKY pro kalkulačku</div>

<p style='color:red; font-style:italic;text-align:right;'>DŮLEŽITÉ:<br />
Výjimka musí být vždy za výhodnější cenu než je ta původní (za položku).<br /> Při více podmínkách řadit podmínky sestupně od méně výhodných k těm nejvýhodnějším.<br />Neplést výjimky s jinými výhodami a speciálními nabídkami.<br />U výjimek na počet transakcí se nezadává výsledná cena, ale počet transakcí zdarma.
</p>

<form name='vyj_form' method='GET' action=''>
<input type="hidden" name="banka" value="<?php echo $_GET['kodBanky']; ?>">
<input type="hidden" name="kodBanky" value="<?php echo $_GET['kodBanky']; ?>">
<input type="hidden" name="ucet" value="<?php echo $_GET['ucet']; ?>">
<input type="hidden" name="ucetTyp" value="<?php echo $_GET['ucetTyp']; ?>">
<?php 
if(isset($_GET['id'])){
echo "<input type='hidden' name='id' value=".$_GET['id'].">
      <input type='hidden' name='vyber_id' value='".$_GET['id']."'>";

echo isset($_GET['karta_id']) ? "<input type='hidden' name='karta_id' value='".$_GET['karta_id']."'>
<input type='hidden' name='s_popl_karty'>" : "";
}
?>

<input type="hidden" name="nazevUctu" value="<?php echo (isset($_GET['nazevUctu']) ? $_GET['nazevUctu'] : ""); ?>">

<input type="text" name="vyj_name" value="<?php echo $_GET['vyj_name']; ?>" readonly style="border-style:none;font-size:x-large;font-family:Times New Roman, serif;padding-bottom:10;text-transform:capitalize;text-indent:5; width:60%;">

<?php
$vyj_note = isset($_GET['vyj_note']) ? $_GET['vyj_note'] : "";
echo "<p style='color:green; font-weight:bold; font-size:small'>$vyj_note</p>";
?>

Název hodnoty ve výpočtu: <input type="text" name="vyj_pole" value="<?php echo $_GET['vyj_pole']; ?>" readonly style="border-style:none;text-decoration:underline;font-size:large;width:300"><br>
Standardní hodnota: <input type="text" name="vyj_puv" value="<?php echo $_GET['vyj_puv']; ?>" readonly style="border-style:none;text-decoration:underline;padding-bottom:20"><br>

<?php

$podm = array('>=', '<=', '==', '<', '>', '<>');
$sql_vyj_podm_vypis = "SELECT * FROM vyj_podminky WHERE podm_parametr = 1 ORDER BY podm_popis ASC";

$sql_vyj_list = "SELECT * FROM vyjimky WHERE ucet_id=".$_GET['ucet']." AND pole='".$_GET['vyj_pole']."'".(isset($_GET['id']) ? " AND cena_id=".$_GET['id'] : "").(isset($_GET['karta_id']) ? " AND karta_id=".$_GET['karta_id'] : "");
$vyj_list = vystup_sql($sql_vyj_list);
                  
$y = 0;
$vyj_pocet = mysqli_num_rows($vyj_list);
$vyj_novy = 0;
  
while($y<3 + $vyj_pocet)                                     // ŘÁDKY
{

$vyj_id = $y<$vyj_pocet ? mysqli_result($vyj_list,$y,0) : 0;

echo "<div style='padding:3".($y<$vyj_pocet ? ";background-color:lightskyblue" : ";background-color:#F4F4F4")."'>"; 
echo "<span style='font-size:20;font-weight:bold'>".($y+1) .".</span>".($y<$vyj_pocet ? " (".($r = $vyj_id).") " : " (".($r = 0).") ");

  if($y<$vyj_pocet){
  $vyj_podm_edit = explode(" AND ", mysqli_result($vyj_list,$y,'podminka'));
  $vyj_vysl_edit = mysqli_result($vyj_list,$y,'vysledek');
  $vyj_koment_edit = mysqli_result($vyj_list,$y,'koment');
  
        $vyj_podm1 = $vyj_podm2 = $vyj_hodn = array();

        for($i=0; $i < count($vyj_podm_edit); ++$i){
        $vyj_podm1[$i] = substr($vyj_podm_edit[$i],0,strpos($vyj_podm_edit[$i]," "));
        $vyj_podm2[$i] = trim(substr($vyj_podm_edit[$i],strpos($vyj_podm_edit[$i]," ")+1,2));
        $vyj_hodn[$i] = substr($vyj_podm_edit[$i],strrpos($vyj_podm_edit[$i]," ")+1);
        }
  }   

  for($x=0; $x<4; ++$x)                                        // SLOUPCE
  {
  
  $vyj_podm_vypis = vystup_sql($sql_vyj_podm_vypis);
 
  echo "<div style='text-indent:".($x * 200)."'>"; 
  echo "<select name='vyj$y$x'><option value=0></option>";

  while($r_vyj_podm_vypis = mysqli_fetch_row($vyj_podm_vypis)){          // podminky
        
    if($y<$vyj_pocet){
    echo "<option value='".$r_vyj_podm_vypis[0]."'";  
    echo (isset($vyj_podm1[$x]) && $vyj_podm1[$x] == $r_vyj_podm_vypis[0] ? " selected" : "").">".$r_vyj_podm_vypis[1]."</option>";
    }
    else
  echo "<option value='".$r_vyj_podm_vypis[0]."'>".$r_vyj_podm_vypis[1]." (".$r_vyj_podm_vypis[3].")</option>";
  }
  echo "</select>";

  echo "<select name='vyj_podm$y$x'><option value=0></option>";       // znamenko
  
  reset($podm);  
  foreach($podm as $p)
  echo "<option value='$p'".($y<$vyj_pocet && isset($vyj_podm2[$x]) && $vyj_podm2[$x] == $p ? " selected" : "")."> $p </option>";
  
  echo "</select>";
  
                                                                      // hodnota
  echo "<input type='text' name='vyj_hodnota$y$x' size=5".(isset($vyj_hodn[$x]) && $y<$vyj_pocet ? " value=".$vyj_hodn[$x] : "").">";
  echo $x<3 ? " A " : "<br /><span style='word-spacing:20;font-variant:small-caps;font-weight:bold'>". $_GET['vyj_name'] ."</span> při splnění podmínek: <input type='text' name='vyj_novy$y' size=5".($y<$vyj_pocet ? " value=".$vyj_vysl_edit : "").">
  <div style='vertical-align:top;text-indent:5'>Popis <textarea name='vyj_koment$y' cols=160 rows=2>".($y<$vyj_pocet ? $vyj_koment_edit : "")."</textarea></div>";
      
  echo "</div>";
  }

$vyj_podm = "";

if(isset($_GET['vyj_uloz']) || isset($_GET['vyj_edit'])){ 

$_GET["vyj".$y."0"]<>'0' ? ++$vyj_novy : "";

$vyj_podm = $_GET["vyj".$y."0"]<>'0' ? $_GET["vyj".$y."0"]." ".$_GET["vyj_podm".$y."0"]." ".$_GET["vyj_hodnota".$y."0"] : "";
$vyj_podm.= $_GET["vyj".$y."0"]<>'0' && $_GET["vyj".$y."1"]<>'0' ? " AND ".$_GET["vyj".$y."1"]." ".$_GET["vyj_podm".$y."1"]." ".$_GET["vyj_hodnota".$y."1"] : "";
$vyj_podm.= $_GET["vyj".$y."1"]<>'0' && $_GET["vyj".$y."2"]<>'0' ? " AND ".$_GET["vyj".$y."2"]." ".$_GET["vyj_podm".$y."2"]." ".$_GET["vyj_hodnota".$y."2"] : "";
$vyj_podm.= $_GET["vyj".$y."2"]<>'0' && $_GET["vyj".$y."3"]<>'0' ? " AND ".$_GET["vyj".$y."3"]." ".$_GET["vyj_podm".$y."3"]." ".$_GET["vyj_hodnota".$y."3"] : "";

  if($r > 0 && mysqli_result($vyj_list,$y,'podminka').$vyj_vysl_edit.$vyj_koment_edit <> $vyj_podm.$_GET["vyj_novy$y"].$_GET["vyj_koment$y"]){
  $sql_vyj_urok_edit = "UPDATE vyjimky SET podminka='$vyj_podm', vysledek=".$_GET["vyj_novy$y"].", koment='".htmlspecialchars($_GET["vyj_koment$y"], ENT_QUOTES)."' WHERE vyj_id=$vyj_id";
  vystup_sql($sql_vyj_urok_edit);
  }
}                                                         

if(isset($_GET['vyj_uloz']) && $_GET["vyj".$y."0"]<>'0' && $r == 0){
                                                                                           
$sql_uloz = "INSERT INTO vyjimky (".($_GET['id'] <> "" ? "cena_id, " : "")."ucet_id, ".($_GET['karta_id'] <> "" ? "karta_id, " : "")."pole, podminka, vysledek, koment)
VALUES (".(isset($_GET['id']) ? $_GET['id'].", " : "").$_GET['ucet'].", ".($_GET['karta_id'] <> "" ? $_GET['karta_id'].", " : "")." '".$_GET['vyj_pole']."', '$vyj_podm', ".$_GET["vyj_novy$y"].", '".htmlspecialchars($_GET["vyj_koment$y"], ENT_QUOTES)."')";
vystup_sql($sql_uloz);
}

echo "</div>";
echo $y==$vyj_pocet - 1 ? "<div style='text-indent:600;margin:10 0 40 0'><input type='submit' name='vyj_edit' value='ULOŽIT (pouze změny)' style='font-size:large;padding:10 100 10 100;letter-spacing:3'></div> <div style='text-indent:20;font-weight:bold;font-size:large;margin-bottom:10'>NOVÉ VÝJIMKY</div>" : "";
echo $y<2 + $vyj_pocet && $y<>$vyj_pocet - 1 ? "<p style='text-indent:50'>NEBO</p>" : ""; 
$y++; 
}


  $vyj_url_edit = "vyjimky.php?kodBanky=".$_GET['kodBanky']."&ucet=".$_GET['ucet']."&ucetTyp=".$_GET['ucetTyp']."&";
  $vyj_url_edit.= isset($_GET['s_popl_karty']) ? "nazevUctu=".$_GET['nazevUctu']."&id=".$_GET['id']."&r_cena_d=0&vyber_id=&s_popl_karty=" :
    (isset($_GET['vyber_id']) ? "nazevUctu=".$_GET['nazevUctu']."&id=".$_GET['id']."&vyber_id=" : "");
//echo $vyj_novy."...";
echo (isset($_GET['vyj_uloz']) && $vyj_novy > 0) || isset($_GET['vyj_edit']) ? "<meta http-equiv='refresh' content='0;url=$vyj_url_edit&vyj_name=".$_GET['vyj_name']."&vyj_pole=". $_GET['vyj_pole'] ."&vyj_puv=".$_GET['vyj_puv']."&".($_GET['karta_id'] <> "" ? "karta_id=".$_GET['karta_id']."&" : "")."vyj_note=Výjimky uloženy.#vyj'>" : "";
?>
<div style="text-indent:200"><input type="submit" name="vyj_uloz" value="ULOŽIT VŠECHNO" style="font-size:large;padding:10 200 10 200;letter-spacing:5"></div>
</form>

<?php
}

else echo "chybí data k zobrazeni (ucet nebo vyj_name)";

if($id_spojeni)
{
  mysqli_close($id_spojeni);
//  echo 'odpojeno <br>';
} 

echo "<BR/>$footer";
?>  
                                                                       
</BODY>
</HTML>
