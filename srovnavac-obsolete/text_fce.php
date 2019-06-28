<?php 

function text_exc(&$_text, $_typ){            
switch($_typ){
case 0:                                                                                                  // neutrální text
  return "<div style='color:grey; font-size:small; text-align:left'>$_text</div>";                        
  break;                               
case 1:                                                                                                  // jak ušetřit
  return "<div style='font-size:small; text-align:left; background-color:yellowgreen'>$_text</div>";      
  break;                               
case 2:                                                                                                  // na co si dát pozor
  return "<div style='font-size:small; text-align:left; background-color:#F00000; color: white'>$_text</div>"; 
  break;                           
default: echo "neplatné zadání typu poznámky";
}}


function cena($_cena){
global $mena;
return number_format($_cena, 2, '.', '')." $mena";}


//   text k transakcím
function text_trans(&$_banka, &$_cena_odch_std, &$_cena_odch_tp, &$_pomer_plateb_v_ramci_banky = Null, $_pocet_prichozi_v_ramci_banky = Null, $_cena_prichozi_v_ramci_banky = Null, $_pocet_prichozi_mimo_ramec_banky = Null, $_cena_prichozi_mimo_ramec_banky = Null, $_pocet_odch_std_v_ramci_banky = Null, $_cena_odch_std_v_ramci_banky = Null, $_pocet_odch_std_mimo_ramec_banky = Null, $_cena_odch_std_mimo_ramec_banky = Null, $_pocet_odch_tp_v_ramci_banky = Null, $_cena_odch_tp_v_ramci_banky = Null, $_pocet_odch_tp_mimo_ramec_banky = Null, $_cena_odch_tp_mimo_ramec_banky = Null, $_zvyh_std = Null, $_zvyh_tp = Null){

global $dom_prichozi, $kod_banky, $dom_odchozi, $mena, $prichozi, $placene_prichozi, $dom_odch_std, $dom_odch_tp, $placene_odch_std, $placene_odch_tp, $rozdil_ceny_prich, $rozdil_ceny_odch_std, $rozdil_ceny_odch_tp;


$in = "<div style='text-align:left; font-size:small; text-indent:20;'>Příchozí transakce celkem: ".cena($dom_prichozi)."</div>";
$in_detail = isset($_pocet_prichozi_v_ramci_banky) ? "- příchozí platby v rámci banky $_banka ($_pocet_prichozi_v_ramci_banky/$prichozi): ".cena($_cena_prichozi_v_ramci_banky)."<br>- příchozí platby mimo rámec banky $_banka ($_pocet_prichozi_mimo_ramec_banky/$prichozi): ".cena($_cena_prichozi_mimo_ramec_banky) : "- placené příchozí platby ($placene_prichozi/$prichozi)".($placene_prichozi > 0 ? ": ".cena($dom_prichozi) : Null); 
$in_detail = text_exc($in_detail, 0);

$out = "<div style='text-align:left; font-size:small; text-indent:20;'>Odchozí transakce celkem: ".cena($dom_odchozi)."</div>";
$out_detail = '';
  if(isset($_pocet_odch_std_v_ramci_banky)){
$out_detail.= "- jednorázové platby v rámci banky $_banka ($_pocet_odch_std_v_ramci_banky/$dom_odch_std): ".cena($_cena_odch_std_v_ramci_banky)."<BR>";
$out_detail.= "- jednorázové platby mimo rámec banky $_banka ($_pocet_odch_std_mimo_ramec_banky/$dom_odch_std): ".cena($_cena_odch_std_mimo_ramec_banky)."<br>";}
  else{
$out_detail.= "- placené jednorázové platby ($placene_odch_std/$dom_odch_std): ".cena($_cena_odch_std)."<br>";}
  
  if(isset($_pocet_odch_tp_v_ramci_banky)){
$out_detail.= "- trvalé příkazy v rámci banky $_banka ($_pocet_odch_tp_v_ramci_banky/$dom_odch_tp): ".cena($_cena_odch_tp_v_ramci_banky)."<br>";
$out_detail.= "- trvalé příkazy mimo rámec banky $_banka ($_pocet_odch_tp_mimo_ramec_banky/$dom_odch_tp): ".cena($_cena_odch_tp_mimo_ramec_banky);}
  else{
$out_detail.= "- placené trvalé příkazy ($placene_odch_tp/$dom_odch_tp): ".cena($_cena_odch_tp);}
$out_detail = text_exc($out_detail, 0);

$vse = '';
if(isset($_pomer_plateb_v_ramci_banky)){
$vse.= "Počítáno s $_pomer_plateb_v_ramci_banky % pravděpodobností plateb na cizí účet v rámci banky $_banka.";

$vse.= $rozdil_ceny_prich > 0 && ($kod_banky == 'ruzne' || $kod_banky == 'none') && $_pocet_prichozi_mimo_ramec_banky == $prichozi ? "Za každou nezapočitanou příchozí platbu v rámci banky $_banka <U>- ".cena($rozdil_ceny_prich)."</U>" : Null;
$vse.= $rozdil_ceny_prich > 0 && ($kod_banky == 'ruzne' || $kod_banky == 'none') && $_pocet_prichozi_mimo_ramec_banky < $prichozi ? "Za každou nezapočitanou příchozí platbu v rámci banky $_banka <U>- ".cena($rozdil_ceny_prich)."</U>, za každou navíc <U>+ ".cena($rozdil_ceny_prich)."</U>" : Null;

$vse.= $_pocet_odch_std_mimo_ramec_banky > 0 && $rozdil_ceny_odch_std > 0 ? "<br>Za každou nezapočitanou jednorázovou platbu v rámci banky $_banka <U>- ".cena($rozdil_ceny_odch_std)."</U>" : Null;
$vse.= $_pocet_odch_std_v_ramci_banky < $dom_odch_std && $rozdil_ceny_odch_std > 0 ? ", za každou navíc <U>+ ".cena($rozdil_ceny_odch_std)."</U>" : Null;

$vse.= $_pocet_odch_tp_mimo_ramec_banky > 0 && $rozdil_ceny_odch_tp > 0 ? "<br>Za každý nezapočitaný trvalý příkaz v rámci banky $_banka <U>- ".cena($rozdil_ceny_odch_tp)."</U>" : Null;
$vse.= $_pocet_odch_tp_v_ramci_banky < $dom_odch_tp && $rozdil_ceny_odch_tp > 0 ? ", za každou navíc <U>+ ".cena($rozdil_ceny_odch_tp)."</U>" : Null;}
$vse = text_exc($vse, 0);

return htmlspecialchars($in . $in_detail . $out . $out_detail . "<p>" . $vse, ENT_QUOTES);
}



//   text ke kartám
function text_karta($_banka, &$_total, &$_nazev, &$_hlavni, &$_karta_exc = 0, &$_text_exc = Null, $_banka2 = Null, &$_karta_exc2 = 0){

global $karta_vydani, $karta_vedeni, $mena, $placene_vybery, $vybery, $karta_vybery, $karta_dotaz1, $karta_dotaz2;

$karta_text0 = "<div style='text-align:left; font-size:small; text-indent:10; line-height:1.8;'>Karta <B>$_nazev</B> - ".($_hlavni == 1 ? 'hlavní (pro majitele účtu)' : 'dodatková (pro třetí osobu)')." - za vydání $karta_vydani $mena - měsíčně celkem ".cena($_total)."</div>";

$karta_text1 = "- vedení karty: $karta_vedeni $mena<BR>
                - zpoplatněné výběry z bankomatu ($placene_vybery/$vybery): ".cena($karta_vybery);
$karta_text1 = text_exc($karta_text1, 0); 

$karta_text2 = $_text_exc;

$karta_text3 = $placene_vybery == 1 && $_karta_exc > 0 ? "- <U>jak ušetřit <B>".cena($_karta_exc)."</B></U> - k výběrům hotovosti využívejte bankomatů banky <i>$_banka</i>".($_banka2 != Null ? ", <U><B>".cena($_karta_exc2)."</B></U> při využívání bankomatů banky <i>$_banka2</i>" : Null) : Null;
$karta_text3 = $placene_vybery > 1 && $_karta_exc > 0 ? "- <U>jak ušetřit <B>až ".cena($_karta_exc)."</B></U> - k výběrům hotovosti využívejte bankomatů banky <i>$_banka</i>".($_karta_exc2 > 0 ? ", <U>až <B>".cena($_karta_exc2)."</B></U> při využívání bankomatů banky <i>$_banka2</i>" : Null) : $karta_text3;
$karta_text3 = text_exc($karta_text3, 1);

$karta_text4 = '';
$karta_text4.= $karta_dotaz2 != Null ? "- <U>na co si dát pozor</U> - za každý dotaz na zůstatek z jiného bankomatu než od banky <i>$_banka</i> <U><B>+ $karta_dotaz2 $mena</B></U>" : Null;
$karta_text4.= $karta_dotaz1 != Null && $karta_dotaz1 > 0 ? ", za každý dotaz na zůstatek z bankomatu od banky <i>$_banka</i> <U><B>+ $karta_dotaz1 $mena</B></U>" : Null;
$karta_text4 = text_exc($karta_text4, 2);

return htmlspecialchars($karta_text0 . $karta_text1 . $karta_text2 . $karta_text3 . $karta_text4, ENT_QUOTES);
}

/*
function karta_ulozit($id, $poradi, $karta_celkem, $karta_exc, $karta_text){
global $id_spojeni;
$sql_karta_ulozit = "INSERT INTO poplatky_karty (ID, Karta, Karta_exc, Karta_text) VALUES ($id, $karta_celkem, $karta_exc, $karta_text)";
$karta_ulozit = mysql_query($sql_karta_ulozit, $id_spojeni);
if (!$karta_ulozit)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodařilo se poslat dotaz na detail era.');
}                                                               
//echo 'Dotaz na detail - era - odeslán.<br>';

return 0;
} 
*/

?>