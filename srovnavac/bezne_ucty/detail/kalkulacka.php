<H2>Podrobná kalkulačka</H2>
<div class="row align-items-start">
    <div class='col-3'>filtr</div>
    <div class='col'>vystup</div>
    <div class='col-3'>pokr</div>
</div>

<form name='kalk' method='POST' action='' onChange='javascript:rekalkul()'>
<div id='filtr'>
Věk klienta: <input type='number' name='vek' value=<?php echo $vek; ?> />
<div class="row mb-2 justify-content-between">
    <div class="col">
        <label for="vek" class="form-label">Věk klienta</label>
    </div>
    <div class="col-lg-4">
        <input type="number" class="form-control" name="vek" value=<?php echo $vek; ?>>
    </div>
</div>
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

<div id='pokr' class='col-4'>
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


<div id='vystup' class='col-4'>
Předpokládaný <u>měsíční poplatek</u> je <br />
<span style='font-size:60;margin:5'><?php echo "<span id='js' style='font-size:80'>0</span> $mena"; ?></span>
<br />
<span style='color:gray'>Předpokládaný roční úrok je <?php echo "<span id='urok'>$urok</span> %"; ?></span><br />
<!-- <span style='color:blue'>JS výpočet <?php //echo "<span id='js'>".cena($v_max)."</span> $mena"; ?></span><br /> -->

<div style="padding-top:10px;font-size:small;"><span id='rozdil' style='font-size:x-large'>0</span><br />hodnota poslední změny</div>
</div>    

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

<script type="text/javascript">
    document.body.onload = rekalkul();
</script>