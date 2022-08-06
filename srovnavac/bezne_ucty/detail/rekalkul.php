<script type="text/javascript">

function rekalkul(){
    var f = document.getElementById('filtr');
    var pozn = document.createElement('P');
    var c_total = document.getElementById('js');
    var urok = document.getElementById('urok');
    var vek_od = Number(<?php echo json_encode($vek_od); ?>);
    var vek_do = Number(<?php echo json_encode($vek_do); ?>);
    var p_prich1 = Number(document.getElementsByName('prich1')[0].value);
    var p_prich2 = Number(document.getElementsByName('prich2')[0].value);
    var c_prich1 = Number(<?php echo json_encode($c_prich1); ?>);
    var c_prich2 = Number(<?php echo json_encode($c_prich2); ?>);
    var p_odch_std1_ib = Number(document.getElementsByName('odch_std1')[0].value);
    var p_odch_std2_ib = Number(document.getElementsByName('odch_std2')[0].value);
    var p_odch_std1_mb = Number(document.getElementsByName('mb_odch_std1')[0].value);
    var p_odch_std2_mb = Number(document.getElementsByName('mb_odch_std2')[0].value);
    var p_odch_std1_tb = Number(document.getElementsByName('tb_odch_std1')[0].value);
    var p_odch_std2_tb = Number(document.getElementsByName('tb_odch_std2')[0].value);
    var c_odch_std1_ib = Number(<?php echo json_encode($c_odch_ib1); ?>);
    var c_odch_std2_ib = Number(<?php echo json_encode($c_odch_ib2); ?>);
    var c_odch_std1_mb = Number(<?php echo json_encode($c_odch_mb1); ?>);
    var c_odch_std2_mb = Number(<?php echo json_encode($c_odch_mb2); ?>);
    var c_odch_std1_tb = Number(<?php echo json_encode($c_odch_tb1); ?>);
    var c_odch_std2_tb = Number(<?php echo json_encode($c_odch_tb2); ?>);
    var p_odch_tp1 = Number(document.getElementsByName('odch_tp1')[0].value);
    var p_odch_tp2 = Number(document.getElementsByName('odch_tp2')[0].value);
    
    var p_prich = p_prich1 + p_prich2;
    document.getElementsByName('prich')[0].value = p_prich;
    var p_odch_ib = p_odch_std1_ib + p_odch_std2_ib;
    document.getElementsByName('odch_ib')[0].value = p_odch_ib;
    var p_odch_mb = p_odch_std1_mb + p_odch_std2_mb;
    document.getElementsByName('odch_mb')[0].value = p_odch_mb;
    var p_e_odch = p_odch_ib + p_odch_mb;
    document.getElementsByName('e-odch')[0].value = p_e_odch;
    var p_odch_tb = p_odch_std1_tb + p_odch_std2_tb;
    document.getElementsByName('odch_tb')[0].value = p_odch_tb;
    var p_odch_tp = p_odch_tp1 + p_odch_tp2;
    document.getElementsByName('odch_tp')[0].value = p_odch_tp;

    var p_odch = p_odch_ib + p_odch_mb + p_odch_tb + p_odch_tp; 
    document.getElementsByName('odch')[0].value = p_odch;

    var p_trans = p_prich + p_odch;
    document.getElementsByName('trans')[0].value = p_trans;

    var total = {};

    // prednastaveni pro vyjimky na cely balicek transakci
    total["c_prich"] = "";      
    total["c_odch_std"] = "";
    total["c_odch_tp"] = "";
    total["c_odch"] = "";
    total["c_trans"] = "";

    total["p_odch_std_vyj"] = 0;

    total["urok"] = Number(<?php echo json_encode($urok); ?>);
    total["c_vedeni"] = Number(<?php echo json_encode($c_vedeni); ?>);
    total["c_prich1"] = c_prich1;
    total["c_prich2"] = c_prich2;

    var p_check = document.getElementsByTagName('INPUT');
    for(var i = 0; i < p_check.length; i++){
      if(p_check[i].getAttribute('name') == 'vek'){
        if(p_check[i].value < vek_od && vek_od > 0){
        p_check[i].value = vek_od;
        alert('Účet je pro osoby od ' + vek_od + ' let věku.');
        }  

        else if(p_check[i].value > vek_do && vek_do < 99){
        p_check[i].value = vek_do;
        alert('Účet je pro osoby do ' + vek_do + ' let věku.');
        }
      }

      else if(p_check[i].getAttribute('type') == 'number' && (p_check[i].value < 0 || p_check[i].value == '')){
      p_check[i].value = 0;
      //alert('Hodnota musí být >= 0.');
      }
    }

        var vypis = document.getElementsByName('vypis');
    total["c_vypis"] = vypis[0].checked == true ? Number(<?php echo json_encode($c_vypis_e); ?>) : Number(<?php echo json_encode($c_vypis_p); ?>); 

    var m_banking = document.getElementsByName('m_banking');
    var t_banking = document.getElementsByName('t_banking');
    total["c_banking"] = Number(<?php echo json_encode($c_vedeni_ib); ?>);
    total["c_odch_std1_ib"] = c_odch_std1_ib;
    total["c_odch_std2_ib"] = c_odch_std2_ib;

    if(m_banking[0].checked == true){
    total["c_banking"] += Number(<?php echo json_encode($c_vedeni_mb); ?>);
    total["c_odch_std1_mb"] = c_odch_std1_mb;
    total["c_odch_std2_mb"] = c_odch_std2_mb;
    document.getElementById('mb').style.display = 'block';
    }
    else{
    total["c_odch_std1_mb"] = total["c_odch_std2_mb"] = 0;
    document.getElementById('mb').style.display = 'none';
    }

    if(t_banking[0].checked == true){
    total["c_banking"] += Number(<?php echo json_encode($c_vedeni_tb); ?>);
    total["c_odch_std1_tb"] = c_odch_std1_tb;
    total["c_odch_std2_tb"] = c_odch_std2_tb;
    document.getElementById('tb').style.display = 'block';
    }
    else{
    total["c_odch_std1_tb"] = total["c_odch_std2_tb"] = 0;
    document.getElementById('tb').style.display = 'none';
    }

    total["c_odch_tp1"] = Number(<?php echo json_encode($c_tp1); ?>);
    total["c_odch_tp2"] = Number(<?php echo json_encode($c_tp2); ?>);

    var karta = document.getElementsByName('karta');
    var karta_ano = document.getElementById('karta_ano');
    var karta_selected_id = 0;
    total["c_kartaH"] = 0;

    if(karta[0].checked == true && document.getElementsByName('karta_typ').length > 0){                     // = karta ano
    karta_ano.style.display = 'block';
    var k_typ = document.getElementsByName('karta_typ');
      for(var i = 0; i < k_typ.length; i++){
        if(k_typ[i].checked == true){
        karta_selected_id = k_typ[i].id;
        total["c_kartaH_vedeni"] = Number(k_typ[i].value);
        var p_kartaH_vyber1 = Number(document.getElementById('karta_vybery1').value);
        var p_kartaH_vyber2 = Number(document.getElementById('karta_vybery2').value);
        total["p_kartaH_vyber1_vyj"] = 0;
        total["p_kartaH_vyber2_vyj"] = 0;
        total["c_kartaH_vyber1"] = 0;

          if(document.getElementsByName('01kartaH_vyber1')[i].value == "" && document.getElementsByName('01kartaH_vyber2')[i].value != "" && 
            document.getElementsByName('01kartaH_vyber2')[i].value != document.getElementsByName('01kartaH_vyber3')[i].value){
          total["c_kartaH_vyber1"] = Number(document.getElementsByName('01kartaH_vyber2')[i].value);
          }
          else if(document.getElementsByName('01kartaH_vyber1')[i].value != ""){
          total["c_kartaH_vyber1"] = Number(document.getElementsByName('01kartaH_vyber1')[i].value);
          }
          else {                         // pokud neexistuje vlastni ani zprateleny bankomat
          document.getElementById('karta_vybery1').disabled = true;
          }

        total["c_kartaH_vyber2"] = Number(document.getElementsByName('01kartaH_vyber3')[i].value);
        var c_kartaH_vybery = (p_kartaH_vyber1 * total["c_kartaH_vyber1"]) + (p_kartaH_vyber2 * total["c_kartaH_vyber2"]);
        var c_kartaH_cashback = Number(document.getElementsByName('01kartaH_cashback')[i].value);

        total["c_kartaH"] = total["c_kartaH_vedeni"] + c_kartaH_vybery;      
        }
      }

    var p_karta_vybery = p_kartaH_vyber1 + p_kartaH_vyber2;
    var p_karta_trans = Number(document.getElementsByName('trans_karta')[0].value);
    document.getElementsByName('trans_karta_vse')[0].value = p_karta_vybery + p_karta_trans;
    }

    else if(karta[0].checked == true){
    karta_ano.style.display = 'none';
    alert('K účtu se nevydávají žádné karty.');
    pozn.textContent = 'K účtu se nevydávají žádné karty.';
    pozn.style.color = 'red';
    document.getElementById('vystup').appendChild(pozn);
    karta[1].checked = true;
    karta[0].disabled = true;
    }

    else{
    karta_ano.style.display = 'none';
    }

    var p = document.getElementById('pokr').getElementsByTagName('ul');

    for(var i = 0; i < p.length; i++){

      if(p[i].tagName == 'UL'){
      var p1 = p[i].children;              // ul -> li
      var counter = 0;

        for(var j = 0; j < p1.length; j++){
        inputs = document.getElementsByTagName('input');

          for(var n = 0; n < inputs.length; n++){
            if(inputs[n].type != 'hidden' && inputs[n].name == p1[j].childNodes[1].name){
              switch(inputs[n].type){                              // TODO, revize pokud bude podminka i na neco jineho nez karta (napr. typ karty..)             
                case 'radio':
                  if(inputs[n].checked == true){
                  var in_val = inputs[n].value;
                  }
                  else continue;
                break;

                case 'checkbox':                            
                  if(inputs[n].checked == true){
                  var in_val = 1;
                  }
                  else in_val = 0;
                break;            

                default:
                var in_val = inputs[n].value;
                break;
              }

              if(eval(in_val + p1[j].childNodes[1].value)){
              p1[j].style.color = '#00CC00';                  // zelena
              counter++;
              }

              else{
              p1[j].style.color = '#CC0000';                  // cervena
              }
            }
          }
        }

        if(p1.length == counter){                     // podminky splneny
        p[i].previousElementSibling.style.color = '#00CC00';
          if(p[i].previousElementSibling.parentElement.hasAttribute('class') == false ||
            (p[i].previousElementSibling.parentElement.hasAttribute('class') && p[i].previousElementSibling.parentElement.getAttribute('name') == karta_selected_id)){
          total[p[i].previousElementSibling.getAttribute('name')] = Number(p[i].previousElementSibling.getAttribute('cena_value'));
          }
        }

        else{
        p[i].previousElementSibling.style.color = '#CC0000';
        }

        if(p[i].previousElementSibling.parentElement.hasAttribute('class')){

          switch(p[i].previousElementSibling.parentElement.getAttribute('name')){
            case karta_selected_id:
            c_kartaH_vyber1 = p_kartaH_vyber1 > total["p_kartaH_vyber1_vyj"] ? ((p_kartaH_vyber1 - total["p_kartaH_vyber1_vyj"]) * total["c_kartaH_vyber1"]) : 0;
            c_kartaH_vyber2 = p_kartaH_vyber2 > total["p_kartaH_vyber2_vyj"] ? ((p_kartaH_vyber2 - total["p_kartaH_vyber2_vyj"]) * total["c_kartaH_vyber2"]) : 0;
            c_kartaH_vybery = total["c_kartaH_vybery"] != null ? total["c_kartaH_vybery"] : (c_kartaH_vyber1 + c_kartaH_vyber2);
            total["c_kartaH"] = Math.min(total["c_kartaH"],total["c_kartaH_vedeni"] + c_kartaH_vybery);

            console.log('p_kartaH_vyber2_vyj je ' + total["c_kartaH_vedeni"]);

            p[i].previousElementSibling.style.fontSize = '20px';
            p[i].style.fontSize = '15px';
            p[i].previousElementSibling.style.fontStyle = p[i].style.fontStyle = 'normal';

            break;

            default:
            p[i].previousElementSibling.style.fontSize = p[i].style.fontSize = '10px';
            p[i].previousElementSibling.style.fontStyle = p[i].style.fontStyle = 'italic';        
          }
        }    
      }
    }

    var c_kartaH = karta_ano.style.display == 'block' ? total["c_kartaH"] : 0;

    var c_prich = total["c_prich"].toString() != "" ? total["c_prich"] : (total["c_prich1"] * p_prich1) + (total["c_prich2"] * p_prich2);
    var c_odch_std = total["c_odch_std"].toString() != "" ? total["c_odch_std"] : (p_odch_std1_ib * total["c_odch_std1_ib"]) + (p_odch_std2_ib * total["c_odch_std2_ib"]) + (p_odch_std1_mb * total["c_odch_std1_mb"]) + (p_odch_std2_mb * total["c_odch_std2_mb"]) + (p_odch_std1_tb * total["c_odch_std1_tb"]) + (p_odch_std2_tb * total["c_odch_std2_tb"]) - (total["p_odch_std_vyj"] * total["c_odch_std1_ib"]);
    var c_odch_tp = total["c_odch_tp"].toString() != "" ? total["c_odch_tp"] : (p_odch_tp1 * total["c_odch_tp1"]) + (p_odch_tp2 * total["c_odch_tp2"]);

    var c_odch = total["c_odch"].toString() != "" ? total["c_odch"] : c_odch_std + c_odch_tp;
    var c_trans = total["c_trans"].toString() != "" ? total["c_trans"] : c_odch + c_prich;

    var c_prev_total = c_total.childNodes[0].nodeValue;

    c_total.textContent = (total["c_vedeni"] + total["c_banking"] + total["c_vypis"] + c_trans + c_kartaH).toFixed(2);  

    urok.textContent = total["urok"].toFixed(2);

    var c_rozdil = (c_total.childNodes[0].nodeValue - c_prev_total); 
    var t_rozdil = document.getElementById('rozdil');

      if(c_rozdil > 0){
      t_rozdil.textContent = '+' + (c_rozdil).toFixed(2);
      t_rozdil.parentElement.style.color = 'red';
      }

      else if(c_rozdil < 0){
      t_rozdil.textContent = (c_rozdil).toFixed(2);
      t_rozdil.parentElement.style.color = '#00CC00';
      }

      else{       // == 0 
      t_rozdil.textContent = '0.00';
      t_rozdil.parentElement.style.color = 'green';
      }
    }                                 

</script>