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
    <LINK rel="stylesheet" type="text/css" href="..\..\dstyly.css">
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
   
      <H2>Podrobná kalkulačka</H2>

<form name='kalk' method='POST' action='' onChange='javascript:rekalkul()'>
Věk klienta: <input type='number' name='vek' value=<?php echo $vek; ?> />
<div>
Počet příchozích plateb:
  <UL name='test'>
    <li> z <?php echo $banka; ?><input type='number' name='prich1' value=0></li>
    <li> z jiné banky <input type='number' name='prich2' value=<?php echo $prich; ?>></li>
  </UL>
<div class='suma'>Příchozích celkem <input type='number' name='prich' readonly /></div> 
</div>

<div>
<H4>Internetové bankovnictví:</H4>
<?php echo ($c_odch_online != Null ? '(možnost e-plateb přímo u obchodníka)<br />' : Null); ?> 
Počet zadaných jednorázových plateb:
  <UL>
    <li> do <?php echo $banka; ?><input type='number' name='odch_std1' value=0></li>
    <li> do jiné banky <input type='number' name='odch_std2' value=<?php echo $odch_std; ?>></li>
  </UL>
<div class='suma'>Odchozích přes IB celkem <input type='number' name='odch_ib' readonly /></div>
</div>


<div>
<H4><input type='checkbox' name='m_banking' value=0<?php echo (is_array($banking) && in_array('m', $banking) ? ' checked' : Null).($c_vedeni_mb == Null ? ' disabled' : Null); ?>> Mobilní/Smart bankovnictví:</H4>
  <div id='mb'>
  Počet zadaných jednorázových plateb:
    <UL>
      <li> do <?php echo $banka; ?><input type='number' name='mb_odch_std1' value=0></li>
      <li> do jiné banky <input type='number' name='mb_odch_std2' value=0></li>
    </UL>
    <div class='suma'>Odchozích přes MB celkem <input type='number' name='odch_mb' readonly /></div>
  </div>
</div>
<input type='hidden' name='e-odch' /> 

<div>
<H4><input type='checkbox' name='t_banking' value=0<?php echo (is_array($banking) && in_array('t', $banking) ? ' checked' : Null).($c_vedeni_tb == Null ? ' disabled' : Null); ?>> Telefonní bankovnictví:</H4> 
  <div id='tb'>
  Počet zadaných jednorázových plateb:
    <UL>
      <li> do <?php echo $banka; ?><input type='number' name='tb_odch_std1' value=0></li>
      <li> do jiné banky <input type='number' name='tb_odch_std2' value=0></li>
    </UL>
    <div class='suma'>Odchozích přes TB celkem <input type='number' name='odch_tb' readonly /></div>
  </div>
</div>
   
   
<div style='margin-top:20px;'>
Počet trvalých příkazů:
  <UL>
    <li> do <?php echo $banka; ?><input type='number' name='odch_tp1' value=0></li>
    <li> do jiné banky <input type='number' name='odch_tp2' value=<?php echo $odch_tp; ?>></li>
  </UL>
  <div class='suma'>Trvalých příkazů celkem <input type='number' name='odch_tp' readonly /></div>
</div>

<div class='suma'>Odchozích transakcí celkem <input type='number' name='odch' readonly /></div>
<div class='suma'>Transakcí celkem <input type='number' name='trans' readonly /></div>
   
<div>
Výpis: 
<input type='radio' name='vypis' value='e'<?php echo ($vypis == 'e' ? " checked" : ($c_vypis_e == Null ? " disabled" : "")); ?>> elektronický
<input type='radio' name='vypis' value='p'<?php echo ($vypis == 'p' ? " checked" : ($c_vypis_p == Null ? " disabled" : "")); ?>> papírový
</div>

<div id='karta'>Platební karta k účtu (debetní):
<input type='radio' name='karta' value=1<?php echo ($karta == 1 ? " checked" : ""); ?>> ano
<input type='radio' name='karta' value=0<?php echo ($karta == 0 ? " checked" : ""); ?>> ne 
  <div id='karta_ano'>
  Typ karty:<BR />
  <?php
  $i = 0;
  $d_karta = vystup_sql($sql_d_karta);
  while($r_karta = mysqli_fetch_assoc($d_karta)){
  echo "<input type='radio' name='karta_typ' id='".$r_karta['ID']."' value=".$r_karta['kartaH_vedeni'].($i == 0 ? " checked" : "")
  .($r_karta['karta_typ'] > 2 ? " disabled" : "").">".$r_karta['karta_nazev']
  .($r_karta['karta_typ'] == 3 ? " - virtuální karta" : "").($r_karta['karta_typ'] == 4 ? " - nálepka" : "")."
  <input type='hidden' name='01kartaH_vyber1' value=".$r_karta['kartaH_vyber1'].">
  <input type='hidden' name='01kartaH_vyber2' value=".$r_karta['kartaH_vyber2'].">
  <input type='hidden' name='01kartaH_vyber3' value=".$r_karta['kartaH_vyber3'].">
  <input type='hidden' name='01kartaH_vklad' value=".$r_karta['kartaH_vklad'].">    
  <input type='hidden' name='01kartaH_cashback' value=".$r_karta['kartaH_cashback'].">
  <input type='hidden' name='01kartaH_vedeni' value=".$r_karta['kartaH_vedeni']."><br />";
  $i++;
  }
  ?>
  Počet výběrů z bankomatu:
  <UL>
    <LI>z bankomatu <?php echo $banka; ?> <input type='number' id='karta_vybery1' value=0></LI>
    <LI>z bankomatu jiné banky <input type='number' id='karta_vybery2' value=<?php echo $karta_vybery; ?>></LI>
  </UL>
  Počet plateb kartou: <input type='number' name='trans_karta' value=0>
  <div class='suma'>Transakcí kartou celkem <input type='number' name='trans_karta_vse' readonly /></div>
  </div>
</div>                


</div>

<h3>Možnosti úspor s podmínkami</h3>

<?php
$podm_ar = array();

$sql_vyj = "SELECT * FROM vyjimky LEFT JOIN vyj_podminky ON pole=podm_id WHERE ucet_id=$id AND (cena_id=$cena_id or cena_id is null) AND karta_id is null";
$vyj = vystup_sql($sql_vyj);

$sql_vyj_karta = "SELECT * FROM vyjimky 
INNER JOIN vyj_podminky ON pole=podm_id 
INNER JOIN ceny_karty ON vyjimky.karta_id=ceny_karty.id
WHERE ucet_id=$id AND cena_id=$cena_id ORDER BY vyjimky.karta_id";
$vyj_karta = vystup_sql($sql_vyj_karta);

$sql_podm = "SELECT * FROM vyj_podminky";
$podm = vystup_sql($sql_podm);

if(mysqli_num_rows($vyj)==0){
echo "Poplatky za účet jsou bez výjimek.";
}

else{
$n = 0;

echo "<ol>";
while($r_vyj = mysqli_fetch_assoc($vyj)){
echo "<li name='".$r_vyj['pole']."' cena_value=".$r_vyj['vysledek'].">".$r_vyj['podm_popis']." ".$r_vyj['vysledek']." ".$r_vyj['podm_jedn']."</li>";
$vyj_podm_edit = explode(" AND ", $r_vyj['podminka']);
echo "<ul>";
//echo "<input type='hidden' name='vysledek' value='".$r_vyj[2]."' />";
  for($i=0; $i < count($vyj_podm_edit); ++$i){
  echo "<li>";
    for($j=0; $j < mysqli_num_rows($podm); $j++){
      if(substr($vyj_podm_edit[$i],0,strpos($vyj_podm_edit[$i]," ")) == mysqli_result($podm,$j,'podm_id')){
      echo mysqli_result($podm,$j,'podm_popis');
      
      echo "<input type='hidden' name='".mysqli_result($podm,$j,'podm_id')."'
      value='".($podm_podm = trim(substr($vyj_podm_edit[$i],strpos($vyj_podm_edit[$i]," ")+1)))."' />";
      echo "<input type='hidden' name='jedn' value='".mysqli_result($podm,$j,'podm_jedn')."' />";
      echo "<input type='hidden' name='type' value='".mysqli_result($podm,$j,'podm_type')."' />";
      
      echo "<span style='font-size:x-small;font-style:italic;'>".(substr($podm_podm, 0, 2) != '==' ? " ($podm_podm)" : 
        (mysqli_result($podm,$j,'podm_type') != 'checkbox' ? " (".substr($podm_podm, 3).")" : ""))."</span>";

      break;
      }
    }                                  

  echo "</li>";
  }
echo "</ul>";

}
echo "</ol>";


}


mysqli_data_seek($podm, 0);


  while($r_podm = mysqli_fetch_array($podm)){
  $podm_ar[] = $r_podm;
  }



$vyj_karta_ar = array();
while($r_vyj_karta = mysqli_fetch_array($vyj_karta)){
$vyj_karta_ar[] = $r_vyj_karta;
}



?>

</div>



<script language='javascript'>
var pokr = document.getElementById('pokr');
var vyj_karta = <?php echo json_encode($vyj_karta_ar); ?>;
var podm = <?php echo json_encode($podm_ar); ?>; 
//console.log(vyj_karta[0]['karta_id']);

if(vyj_karta.length > 0){
var pokr_karta = document.createElement('div'); 
var vyj_karta_head = document.createElement('H3');
var vyj_karta_head_text = document.createTextNode('Úspory ke kartám');

vyj_karta_head.appendChild(vyj_karta_head_text);
pokr_karta.appendChild(vyj_karta_head);

  for(var i = 0; i < vyj_karta.length; i++){                // i == header karty
    
    if(i == 0 || (i > 0 && vyj_karta[i]['karta_nazev'] != vyj_karta[i-1]['karta_nazev'])){
    var karta_nazev = document.createElement('h4');
    var karta_nazev_text = document.createTextNode(vyj_karta[i]['karta_nazev']);
    karta_nazev.appendChild(karta_nazev_text);
    pokr_karta.appendChild(karta_nazev); 
    
    var ol = document.createElement('ol');
    ol.setAttribute('name',vyj_karta[i]['karta_id']);
    ol.setAttribute('class','karta');
    }

  var karta_podm = vyj_karta[i]['podminka'].split(" AND ");    
  var ol_li = document.createElement('li');
  var ol_li_text = document.createTextNode(vyj_karta[i]['podm_popis']+ ' ' +vyj_karta[i]['vysledek']+ ' ' +vyj_karta[i]['podm_jedn']);
  ol_li.setAttribute('name',vyj_karta[i]['pole']);
  ol_li.setAttribute('cena_value',vyj_karta[i]['vysledek']);
  ol_li.appendChild(ol_li_text);
  ol.appendChild(ol_li);
    
  
  var ul = document.createElement('ul');
  
    for(var k = 0; k < karta_podm.length; k++){         // kar_pod == podminka
    var ul_li = document.createElement('li');
    var podm_id = karta_podm[k].slice(0, karta_podm[k].indexOf(' '));
    var podm_podm = karta_podm[k].slice(karta_podm[k].indexOf(' '),karta_podm[k].length).trim();

    console.log(vyj_karta[i]['podm_popis'] +' / '+ podm_id +' / ' + podm.length);                         
//    console.log(podm_podm+'podminka: '+karta_podm[k]+',mezera: '+karta_podm[k].indexOf(' ')+',delka: '+karta_podm[k].length);
      
      for(var p = 0; p < podm.length; p++){
      console.log(podm[p]['podm_id']);
      
        if(podm[p]['podm_id'] == podm_id){
        var podm_id_input = document.createElement('input');
        podm_id_input.setAttribute('type','hidden');
        podm_id_input.setAttribute('name',podm_id);
        podm_id_input.value = podm_podm;
        
        var podm_jedn_input = document.createElement('input');
        podm_jedn_input.setAttribute('type','hidden');
        podm_jedn_input.setAttribute('name','jedn');
        podm_jedn_input.value = podm[p]['podm_jedn'];
        
        var podm_type_input = document.createElement('input');
        podm_type_input.setAttribute('type','hidden');
        podm_type_input.setAttribute('name','type');
        podm_type_input.value = podm[p]['podm_type'];
   

        //console.log('popis: '+podm[p]['podm_popis']);
        var ul_li_text = document.createTextNode(podm[p]['podm_popis']);
        var ul_li_span = document.createElement('span');
        ul_li_span.style.fontSize = 'x-small';
        ul_li_span.style.fontStyle = 'italic';
        
          if(podm_podm.indexOf('==')==-1){
          var ul_li_podm = document.createTextNode(' ('+podm_podm.trim()+')');
          ul_li_span.appendChild(ul_li_podm);
          }
      
        break;
        }
      }


    ul_li.appendChild(ul_li_text);
    ul_li.appendChild(podm_id_input); 
    ul_li.appendChild(podm_jedn_input);
    ul_li.appendChild(podm_type_input);
    ul_li.appendChild(ul_li_span);
    
    ul.appendChild(ul_li);    
    }
  
  ol.appendChild(ul);
  pokr_karta.appendChild(ol);
  }


pokr.appendChild(pokr_karta);
}



var podminky1 = pokr.getElementsByTagName('ul');

if(podminky1.length > 0){
var div = document.createElement('div');
document.getElementsByName('kalk')[0].appendChild(div);
div.setAttribute('id','pokr2');
//console.log(podminky1.length);

  for(var i=0; i<podminky1.length; i++){                       
  var podminky2 = podminky1[i].getElementsByTagName('li');


    for(var j=0; j<podminky2.length; j++){
    var br = document.createElement('br');
    var node = podminky2[j].childNodes;
    var inputs = document.getElementsByTagName('input');
    var duplic = 0;
    
      for(var n=0; n<inputs.length; n++){
        if(inputs[n].type != "hidden" && inputs[n].name == node[1].name){
        //console.log(inputs[n].type + " - " + inputs[n].name + "==" + node[1].name);
        duplic = 1;
        break;      
        }          
      }                   

    if(duplic == 1) {continue;}

    var t = document.createTextNode(node[0].nodeValue + " ");
    div.appendChild(t);
    
    var input = document.createElement('input');
    var type = node[3].value;
    input.setAttribute('type', type);
    input.setAttribute('name', node[1].name);
    input.setAttribute('value', 0);
//    console.log(node[1].name);
    div.appendChild(input);
    div.appendChild(br);
    }
  }
}

</script>


</form>


<?php 
$sql_balicky = "SELECT * FROM balicky WHERE bal_cena_id = $cena_id";
$balicky = vystup_sql($sql_balicky);
?>      

<div id='bal'<?php echo (mysqli_num_rows($balicky) == 0 ? " style='display:none;'" : ""); ?>>
<H3>Balíčky výhod</H3>
<p>K účtu jsou nabízeny tyto výhodné balíčky, které zatím nejsou zahrnuty do výpočtu celkového měsíčního poplatku:</p>
<?php
$i = 0; 
while($r_balicky = mysqli_fetch_assoc($balicky)){
echo "<div style='margin:5px 1px 5px 1px;'>";
echo "<b>".++$i.". ".$r_balicky['bal_nazev']."</b> (".$r_balicky['bal_cena']." $mena)<br />".$r_balicky['bal_koment'];
echo "</div>";
} 
?>
</div>

</div>


<script type="text/javascript">
document.body.onload = rekalkul();
                          
//alert(document.getElementsByName('prijem')[0].value);

</script>    
      
      <div id="page2" style="display: none;padding-top:30;text-align:center">Rozpis MIN/MAX poplatků  

<CENTER>
  <TABLE border=1 width=500>
  <TR>
  <TH style='text-align:center'>MIN</TH>
  <TH class='popis'>Rozpis vypočtených poplatků</TH>
  <TH style='text-align:center'>MAX</TH></TR>

  <TR>
  <TD class='cena'><?php echo cena($v_vedeni_min + $v_vypis_min); ?></TD>
  <TD class='popis'>Vedení účtu</TD>
  <TD class='cena'><?php echo cena($v_vedeni_max + $v_vypis_max); ?></TD>
  </TR>
  <TR>
  <TD class='popis2' colspan=3>Vedení účtu zahrnuje kromě samotného vedení účtu i 
  vedení Vámi vybraného bankovnictví (IB<?php echo (is_array($banking) && in_array('o', $banking) ? '(vč.PuO)' : '').(is_array($banking) && in_array('m', $banking) ? '/MB' : '').(is_array($banking) && in_array('t', $banking) ? '/TB' : ''); ?>)
  a měsíční výpis z účtu (<?php echo ($vypis == 'e' ? 'elektronický' : 'papírový'); ?>).
  <?php echo ($v_vedeni_min + $v_vypis_min) <> ($v_vedeni_max + $v_vypis_max) ? "<BR>Min/Max poplatek je závislý na (ne)splnění daných podmínek." : ""; ?></TD>
  </TR>
    
  <TR>
  <TD class='cena'><?php echo cena($v_prich_min); ?></TD>
  <TD class='popis'>Příchozí platby <span class='popis2'>(<?php echo $prich; ?>)</span></TD>
  <TD class='cena'><?php echo cena($v_prich_max); ?></TD>
  </TR>
  <TR>
  <TD class='popis2' colspan=3>Min/Max je rozděleno na platby z účtu u banky <?php echo $banka; ?> a z jiné cizí banky.</TD>
  </TR>

  <TR>
  <TD class='cena'><?php echo cena($v_odch_min); ?></TD>
  <TD class='popis'>Odchozí platby <span class='popis2'>(<?php echo $odch_std+$odch_tp; ?>)</span></TD>
  <TD class='cena'><?php echo cena($v_odch_max); ?></TD>
  </TR>  
  <TR>
  <TD class='popis2' colspan=3>Zahrnuty jsou i platby vzniklé z trvalého příkazu, bez poplatku za jeho založení.<BR>
  Min/Max je rozděleno na platby na účet u banky <?php echo $banka; ?> a do jiné cizí banky (pouze ty zadané přes IB).</TD>
  </TR>

<?php
  if($karta == 1){    ?>
  <TR>
  <TD class='cena'><?php echo cena($v_karta_min); ?></TD>
  <TD class='popis'>Karetní poplatky</TD>
  <TD class='cena'><?php echo cena($v_karta_max); ?></TD>
  </TR>
  <TR>
  <TD class='popis2' colspan=3>Min/Max je rozděleno podle součtu poplatků za vedení karty a její poplatek za <?php echo "<span style='border-bottom:1px dashed black'>výběr z bankomatu ($karta_vybery)</span> banky $banka"; ?> a jiné cizí banky. <?php //echo $c_kartaH_cashback != Null ? "Banka ke kartám nabízí možnost využití <span style='border-bottom:1px dashed black'>Cashback za $c_kartaH_cashback CZK</span>." : ""; 
  //<BR> Nejlevnější varianta je <span class='oznac'>karta1</span>, nejdražší <span class='oznac'>karta2</span>.</TD> ?>
  </TR>  
<?php } ?>

  <TR>
  <TH class='cena'><?php echo cena($v_min); ?></TH>
  <TH class='popis'>Celkový poplatek</TH>
  <TH class='cena'><?php echo cena($v_max); ?></TH>
  </TR>  
  </TABLE>
</CENTER> 
</div>
      

           
      <div id="page4" style="display: none;padding-top:10;text-align:center">

<H2>Výpis ze sazebníku poplatků banky</H2>
Verze sazebníku od <?php echo $platnost_od; ?><BR>
        <U>Účet, bankovnictví a transakce</U> |
        <a href="javascript:activateTab('page3')">Platební karty</a>
<TABLE><TR><TD>
<H3>Poplatky za účet</H3>
Zřízení účtu: <?php echo $c_zrizeni; ?><BR>
Vedení účtu (měsíčně): <?php echo $c_vedeni; ?><BR>
Zrušení účtu: <?php echo $c_zruseni; ?><BR>

<H3>Poplatky za bankovnictví</H3>
<div style='font-size:small;padding-bottom:10'> IB = internetové, MB = mobilní/smart, TB = telefonické</div>
<TABLE border=1>
<TR><TD></TD><TH>IB</TH><TH>MB</TH><TH>TB</TH></TR>
<TR><TD style='text-align:left'>Zřízení bankovnictví</TD>
<TD class='cena'><?php echo $c_zrizeni_ib; 
echo "<TD class='cena'>$c_zrizeni_mb</TD>";
echo "<TD class='cena'>$c_zrizeni_tb</TD>"; ?></TD>
</TR>
<TR><TD style='text-align:left'>Vedení bankovnictví (měsíčně)</TD>
<TD class='cena'><?php echo $c_vedeni_ib;
echo "<TD class='cena'>$c_vedeni_mb</TD>";
echo "<TD class='cena'>$c_vedeni_tb</TD>"; ?></TD>
</TR>
</TABLE>

</TD>

<TD style='padding-left:50;max-width:400'>
<?php 
echo $koment_JP == "no comment" ? "" : "<div style='text-indent:5;padding:5;background-color:silver;max-width:400'>$koment_JP</div><br>";
echo $koment_PP == "no comment" ? "" : "<div style='text-indent:5;padding:5;background-color:silver;max-width:400'>$koment_PP</div>"; 
?>
</TD></TR>

<TR>
<TD style='padding-top:20'>
<H3>Transakční poplatky</H3>

Příchozí platba z účtu u banky <?php echo "$banka: $c_prich1"; ?><BR>
Příchozí platba z účtu v jiné české bance: <?php echo $c_prich2; ?>


<TABLE border=1 style='margin-top:10;margin-bottom:10'>
<TR><TD></TD><TH>IB</TH><TH>MB</TH><TH>TB</TH></TR>
<TR><TD style='text-align:left'>Zadání a provedení jednorázového příkazu k úhradě na účet v bance <?php echo $banka; ?></TD>
<TD class='cena'><?php echo $c_odch_ib1;
echo "<TD class='cena'>$c_odch_mb1</TD>";
echo "<TD class='cena'>$c_odch_tb1</TD>"; ?></TD>
</TR>
<TR><TD style='text-align:left'>Zadání a provedení jednorázového příkazu k úhradě na účet do jiné české banky</TD>
<TD class='cena'><?php echo $c_odch_ib2;
echo "<TD class='cena'>$c_odch_mb2</TD>";
echo "<TD class='cena'>$c_odch_tb2</TD>"; ?></TD>
</TR>
<TR><TD style='text-align:left'>Zřízení trvalého příkazu</TD>
<TD class='cena'><?php echo $c_tp_zrizeni_ib;
echo "<TD class='cena'>$c_tp_zrizeni_mb</TD>";
echo "<TD class='cena'>$c_tp_zrizeni_tb</TD>"; ?></TD>
</TR>
</TABLE>


Odchozí platba vzniklá z trvalého příkazu k úhradě na účet v bance <?php echo "$banka: $c_tp1"; ?><BR>
Odchozí platba vzniklá z trvalého příkazu k úhradě na účet do jiné české banky: <?php echo $c_tp2; ?><BR>

</TD>

<TD style='padding-left:50'>
<?php echo $koment_trans == "no comment" ? "" : "<div style='text-indent:5;padding:5;background-color:silver;max-width:400'>$koment_trans</div>"; ?>
</TD></TR>
</TABLE>
   </div>
   
  <div id="page3" style="display: none;padding-top:10;text-align:center">
<H2>Výpis ze sazebníku poplatků banky</H2>
Verze sazebníku od <?php echo $platnost_od; ?><BR>
 
        <a href="javascript:activateTab('page4')">Účet, bankovnictví a transakce</a> |
        <U>Platební karty</U>
        
      <H2>Debetní Karty</H2>
<U>Poznámky ke kartám obecně:</U> <?php echo $koment_karta == "bez karty" ? "-" : "<div style='text-indent:5;padding-bottom:20;padding-top:5'>$koment_karta</div>";

$i = 0;
$d_karta = vystup_sql($sql_d_karta);
while($r_karta = mysqli_fetch_assoc($d_karta)){

echo "<H3 name='karta_nazev'>".$r_karta['karta_nazev']."</H3>";
?>

<U>Hlavní karta</U>
<?php
echo "<div style='padding-bottom:20;padding-top:5'>
Vydání karty: ".$r_karta['kartaH_vydani']."<br>
Vedení karty (měsíčně): ".$r_karta['kartaH_vedeni']."<br>                                                   
".($r_karta['kartaH_vyber1'] != Null ? "Výběr z bankomatu banky $banka: ".$r_karta['kartaH_vyber1']."<br>" : "")
.($r_karta['kartaH_vyber2'] != Null && $r_karta['kartaH_vyber2'] <> $r_karta['kartaH_vyber3'] ? "Výběr z bankomatu jiné 'zpřátelené' banky: ".$r_karta['kartaH_vyber2']."<br>" : "")
.($r_karta['kartaH_vyber3'] != Null ? "Výběr z bankomatu jiné banky: ".$r_karta['kartaH_vyber3'] : "")."<br> 
".($r_karta['kartaH_cashback'] != Null ? "Výběr hotovosti u obchodníka (cashback): ".$r_karta['kartaH_cashback']."<br>" : "")
.($r_karta['kartaH_vklad'] != Null ? "Vklad hotovosti přes vkladomat: ".$r_karta['kartaH_vklad'] : "")."<br>
<U>Poznámky k Hlavní kartě:</U> ".($r_karta['kartaH_koment'] == "no comment" ? "-<BR>" : "<br><span style='text-indent:5;margin-bottom:20;padding-top:5'>".$r_karta['kartaH_koment']."</span>")."</div>"; ?>

<U>Dodatková karta:</U>
<?php
echo $r_karta['kartaD_vydani'] != Null ? "<div style='padding-bottom:20;padding-top:5'>
Vydání karty: ".$r_karta['kartaD_vydani']."<br>
Vedení karty (měsíčně): ".$r_karta['kartaD_vedeni']."<br>                                                   
".($r_karta['kartaD_vyber1'] != Null ? "Výběr z bankomatu banky $banka: ".$r_karta['kartaD_vyber1']."<br>" : "")
.($r_karta['kartaD_vyber2'] != Null && $r_karta['kartaD_vyber2'] <> $r_karta['kartaD_vyber3'] ? "Výběr z bankomatu jiné 'zpřátelené' banky: ".$r_karta['kartaD_vyber2']."<br>" : "") 
.($r_karta['kartaD_vyber3'] != Null ? "Výběr z bankomatu jiné banky: ".$r_karta['kartaD_vyber3'] : "")."<br>
".($r_karta['kartaD_cashback'] != Null ? "Výběr hotovosti u obchodníka (cashback): ".$r_karta['kartaD_cashback']."<br>" : "")
.($r_karta['kartaD_vklad'] != Null ? "Vklad hotovosti přes vkladomat: ".$r_karta['kartaD_vklad'] : "")."<br>
<U>Poznámky k Dodatkové kartě:</U> ".($r_karta['kartaD_koment'] == "no comment" ? "-" : "<br><span style='text-indent:5;padding-top:5'>".$r_karta['kartaD_koment']."</span>")."</div>" : "-<br>"; 
$i++;
} 
?>

  </div>
   
      
      
      <div id="page5" style="display: none;padding-top:10;text-align:center;line-height:1.2">
<H2>Detaily účtu</H2>
Typ účtu: <?php 
switch($typ_uctu){
  case 'bezny':
  echo 'běžný účet pro fyzické osoby nepodnikatele';
  break;
  
  case 'bezny-stu':
  echo 'studentský účet';
  break;
  
  case 'bezny-det':
  echo 'dětský účet';
  break;
  
  default:
  echo '???';
} ?>

<BR>
Měna účtu: CZK<BR>
Minimální zůstatkový limit účtu: <?php echo "$min_limit CZK"; ?><BR>
Úrok na účtu: <?php echo "$urok %"; ?><BR>                                    
Věk klienta: od <?php echo "$vek_od do $vek_do let"; ?><BR> 
Web: <?php echo "<a href='$www' target='_blank'>$www</a>"; ?><BR>
Poznámky k účtu: <?php echo $koment_ucet == "no comment" ? "-" : "<div style='text-indent:5;padding-top:5'>$koment_ucet</div>"; ?>
      </div>
      
</div>
 
<?php

$IDs = array(68,69,70,71);
in_array($id, $IDs);

include '../../../footer.php';
?>


</BODY>
</HTML>
