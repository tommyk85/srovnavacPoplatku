<H2>Podrobná kalkulačka</H2>
<form name='kalk' method='POST' action='' onChange='javascript:rekalkul()'>


<div id='filtr' class="container text-sm-center">
    <div class="row justify-content-start">
        <div class="col-lg-3" id='filtr_klient'>Klient:
            <div class="row">
                <div class="col">
                    <label for="vek" class="form-label">věk</label>
                </div>
                <div class="col">
                    <input type="number" class="form-control" name="vek" value=<?php echo $vek; ?>>
                </div>
            </div>
        </div>

        <div class="col-lg-9 bg-info bg-opacity-50" id='filtr_odchozi_std'>Počet odchozích plateb zadaných jednorázově:
            <div class="row">
                <div class="col-lg-4 text-center">
                    <div class="row form-check">
                        <div class="col">
                            <input type="checkbox" class="form-check-input" checked disabled>
                        </div>
                        <div class="col text-lg-start">
                            <label for="m_banking" class="form-check-label">internetové bankovnictví</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="odch_std1" class="form-label">do <?php echo $banka; ?></label>
                        </div>
                        <div class="col">
                            <input type="number" class="form-control" name="odch_std1" value=0>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="odch_std2" class="form-label">do jiné banky</label>
                        </div>
                        <div class="col">
                            <input type="number" class="form-control" name="odch_std2" value=<?php echo $odch_std; ?>>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 text-center">
                    <div class="row form-check">
                        <div class="col">
                            <input type="checkbox" class="form-check-input" name="m_banking" 
                                value=0<?php echo (is_array($banking) && in_array('m', $banking) ? ' checked' : Null).($c_vedeni_mb == Null ? ' disabled' : Null); ?>
                            />
                        </div>
                        <div class="col text-lg-start">
                            <label for="m_banking" class="form-check-label">mobilní bankovnictví</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="mb_odch_std1" class="form-label">do <?php echo $banka; ?></label>
                        </div>
                        <div class="col">
                            <input type="number" class="form-control" name="mb_odch_std1" value=0>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="mb_odch_std2" class="form-label">do jiné banky</label>
                        </div>
                        <div class="col">
                            <input type="number" class="form-control" name="mb_odch_std2" value=0>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 text-center">
                    <div class="row form-check">
                        <div class="col">
                            <input type="checkbox" class="form-check-input" name="t_banking" 
                                value=0<?php echo (is_array($banking) && in_array('t', $banking) ? ' checked' : Null).($c_vedeni_tb == Null ? ' disabled' : Null); ?>
                            />
                        </div>
                        <div class="col text-lg-start">
                            <label for="m_banking" class="form-check-label">telefonní bankovnictví</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="tb_odch_std1" class="form-label">do <?php echo $banka; ?></label>
                        </div>
                        <div class="col">
                            <input type="number" class="form-control" name="tb_odch_std1" value=0>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="tb_odch_std2" class="form-label">do jiné banky</label>
                        </div>
                        <div class="col">
                            <input type="number" class="form-control" name="tb_odch_std2" value=0>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3" id='filtr_prichozi'>Počet příchozích plateb:
            <div class="row">
                <div class="col">
                    <label for="prich1" class="form-label">z <?php echo $banka; ?></label>
                </div>
                <div class="col">
                    <input type="number" class="form-control" name="prich1" value=0>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label for="prich2" class="form-label">z jiné banky</label>
                </div>
                <div class="col">
                    <input type="number" class="form-control" name="prich2" value=<?php echo $prich; ?>>
                </div>
            </div>
        </div>

        <div class="col-lg-3" id='filtr_odchozi_tp'>Počet odchozích plateb z trvalých příkazů:
            <div class="row">
                <div class="col">
                    <label for="odch_tp1" class="form-label">do <?php echo $banka; ?></label>
                </div>
                <div class="col">
                    <input type="number" class="form-control" name="odch_tp1" value=0>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label for="odch_tp2" class="form-label">do jiné banky</label>
                </div>
                <div class="col">
                    <input type="number" class="form-control" name="odch_tp2" value=<?php echo $odch_tp; ?>>
                </div>
            </div>
        </div>

        <div class="col-lg-auto" id='filtr_vypis'>Výpis:
            <div class="row form-check">
                <div class="col">
                    <input type="radio" class="form-check-input" name="vypis" 
                        value='e'<?php echo ($vypis == 'e' ? " checked" : ($c_vypis_e == Null ? " disabled" : "")); ?>
                    />
                </div>
                <div class="col text-lg-start">
                    <label for="vypis-e" class="form-check-label">elektronický</label>
                </div>
            </div>
            <div class="row form-check">
                <div class="col">
                    <input type="radio" class="form-check-input" name="vypis" 
                        value='p'<?php echo ($vypis == 'p' ? " checked" : ($c_vypis_p == Null ? " disabled" : "")); ?>
                    />
                </div>
                <div class="col text-lg-start">
                    <label for="vypis-p" class="form-check-label">papírový</label>
                </div>
            </div>
        </div>

        <div class="col-lg-auto bg-info bg-opacity-50" id='filtr_karta'>Debetní karta:
            <div class="row">
                <div class="col-lg-3 text-center">
                    <div class="row form-check">
                        <div class="col">
                            <input type="radio" class="form-check-input" name="karta" 
                                value=1<?php echo ($karta == 1 ? " checked" : ""); ?>
                            />
                        </div>
                        <div class="col text-lg-start">
                            <label for="karta-a" class="form-check-label">ano</label>
                        </div>
                    </div>
                    <div class="row form-check">
                        <div class="col">
                            <input type="radio" class="form-check-input" name="karta" 
                                value=0<?php echo ($karta == 0 ? " checked" : ""); ?>
                            />
                        </div>
                        <div class="col text-lg-start">
                            <label for="karta-n" class="form-check-label">ne</label>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 text-center">Typ karty:
                    <?php
                        $i = 0;
                        while($r_karta = mysqli_fetch_assoc($d_karta)){ ?>

                    <div class="row form-check">
                        <div class="col">
                            <input type="radio" class="form-check-input" name="karta_typ" id='<?php echo $r_karta['ID']; ?>'
                                value=<?php echo $r_karta['kartaH_vedeni'].($i == 0 ? " checked" : ""); ?>
                            />
                        </div>
                        <div class="col text-lg-start">
                            <label for="karta_typ<?php echo $i; ?>" class="form-check-label"><?php echo $r_karta['karta_nazev']
                                .($r_karta['karta_typ'] == 3 ? " - virtuální karta" : ($r_karta['karta_typ'] == 4 ? " - nálepka" : "")); ?>
                            </label>
                        </div>
                    </div>

                    <input type='hidden' name='01kartaH_vyber1' value=<?php echo $r_karta['kartaH_vyber1']; ?>>
                    <input type='hidden' name='01kartaH_vyber2' value=<?php echo $r_karta['kartaH_vyber2']; ?>>
                    <input type='hidden' name='01kartaH_vyber3' value=<?php echo $r_karta['kartaH_vyber3']; ?>>
                    <input type='hidden' name='01kartaH_vklad' value=<?php echo $r_karta['kartaH_vklad']; ?>>
                    <input type='hidden' name='01kartaH_cashback' value=<?php echo $r_karta['kartaH_cashback']; ?>>
                    <input type='hidden' name='01kartaH_vedeni' value=<?php echo $r_karta['kartaH_vedeni']; ?>>
                    
                    <?php 
                        $i++;
                        }
                    ?>
                </div>

                <div class="col-lg-3 text-center">Počet výběrů z bankomatu:
                    <div class="row">
                        <div class="col">
                            <label for="karta_vybery1" class="form-label"><?php echo $banka; ?></label>
                        </div>
                        <div class="col">
                            <input type="number" class="form-control" name="karta_vybery1" value=0>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="karta_vybery2" class="form-label">jiné banky</label>
                        </div>
                        <div class="col">
                            <input type="number" class="form-control" name="karta_vybery2" value=<?php echo $karta_vybery; ?>>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 text-center">Platby u obchodníka:
                    <div class="row">
                        <div class="col">
                            <label for="trans_karta" class="form-label">Počet plateb:</label>
                        </div>
                        <div class="col">
                            <input type="number" class="form-control" name="trans_karta" value=0>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id='pokr' class='col-lg-4'>
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
var filtr = document.getElementById('filtr').firstElementChild;

  for(var i=0; i<podminky1.length; i++){                       
  var podminky2 = podminky1[i].getElementsByTagName('li');

    for(var j=0; j<podminky2.length; j++){
    var node = podminky2[j].childNodes;
    var inputs = document.getElementsByTagName('input');
    var duplic = 0;
    
      for(var n=0; n<inputs.length; n++){
        if(inputs[n].type != "hidden" && inputs[n].name == node[1].name){
        duplic = 1;
        break;      
        }          
      }                   

    if(duplic == 1) {continue;}

    var blok = document.createElement("div");
    blok.setAttribute('class', 'col');
    var blok_radek = document.createElement("div");
    blok_radek.setAttribute('class', 'row');
    blok.appendChild(blok_radek);
    var div_label = document.createElement("div");
    div_label.setAttribute('class', 'col');
    var div_input = document.createElement("div");
    div_input.setAttribute('class', 'col');

    blok_radek.appendChild(div_label);
    blok_radek.appendChild(div_input);
    filtr.appendChild(blok);

    var label = document.createElement('label');
    label.setAttribute('for', node[1].name);
    label.setAttribute('class', 'form-label');
    var t = document.createTextNode(node[0].nodeValue + ":");
    label.appendChild(t);
    div_label.appendChild(label);

    var input = document.createElement('input');
    var type = node[3].value;
    input.setAttribute('type', type);
    input.setAttribute('name', node[1].name);
    input.setAttribute('value', 0);
    input.setAttribute('class', 'form-control');
    div_input.appendChild(input);
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