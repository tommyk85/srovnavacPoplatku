<?php 

if($radek_ucty['ID'] == 49 || $radek_ucty['ID'] == 51 || $radek_ucty['ID'] == 53)       // eKonto, bezny a Student ucet RB od 01/11/2012
  {

switch ($radek_ucty['ID']){
  case 49:
  $extra = $prijem >= 20000 || ($prijem >= 15000 && $prostredky >= 100000) ? 1 : 0;
  $premium = $prijem >= 25000 || $prostredky >= 500000 ? 1 : 0;
    
    if($premium == 1){
    $vedeni = $radek_ucty['Vedeni3'];
    $vedeni_max = $radek_ucty['Vedeni1'];
    $vedeni_min = $vedeni_max - $vedeni;
    
    $banking_rb = $radek_ucty['IB3'];
    $banking_max = $radek_ucty['IB1'];
    $banking_min = $banking_max - $banking_rb;}
    
    elseif($extra == 1){
    $vedeni = $radek_ucty['Vedeni2'];
    $vedeni_max = $radek_ucty['Vedeni1'];
    $vedeni_min = $vedeni_max - $vedeni;
    
    $banking_rb = $radek_ucty['IB2'];
    $banking_max = $radek_ucty['IB1'];
    $banking_min = $banking_max - $banking_rb;}
    
    else{ 
    $vedeni = $vedeni_max = $radek_ucty['Vedeni1'];
    $vedeni_min = 0;
    
    $banking_rb = $banking_max = $radek_ucty['IB1'];
    $banking_min = 0;}
  
    
  switch($karta){
      case '1':
      $karta_vybery = $vybery * $radek_ucty['KontaktVyber3'];
      $placene_vybery = $vybery > 2 ? $vybery - 2 : 0;    // plati pouze pro vybery z bankomatu RB
      
      if($premium == 1) $karta_vedeni = $radek_ucty['KontaktVedeni3'];
      elseif($extra == 1) $karta_vedeni = $radek_ucty['KontaktVedeni2'];
      else $karta_vedeni = $radek_ucty['KontaktVedeni1'];
        
      $karta_rb = $karta_vedeni + $karta_vybery;
      $karta_max = $radek_ucty['KontaktVedeni1'] + $karta_vybery;
      $karta_exc = $karta_vybery - ($placene_vybery * $radek_ucty['KontaktVyber2']);
      $karta_min = $karta_max - ($karta_vedeni + $karta_exc);
      
      $karta_text = '';
      $karta_text.= "- vedení karty: $karta_vedeni $mena<BR>
                      - zpoplatněné výběry z bankomatu ($vybery/$vybery): ".number_format($karta_vybery, 2, '.', '')." $mena-0-";
      $karta_text.= $vybery == 1 || $placene_vybery == 1 ? "-1- <U>jak ušetřit <B>".number_format($karta_exc, 2, '.', '')." $mena</B></U> - k výběrům hotovosti využívejte bankomatů Raiffeisenbank, první 2 výběry v měsíci jsou zdarma-1-" : Null;
      $karta_text.= $vybery == 2 || $placene_vybery > 1 ? "-1- <U>jak ušetřit až <B>".number_format($karta_exc, 2, '.', '')." $mena</B></U> - k výběrům hotovosti využívejte bankomatů Raiffeisenbank, první 2 výběry v měsíci jsou zdarma-1-" : Null;
      
      $karta_typ = 'MasterCard Standard, Visa Classic';
      break;
      
      default:
      $karta_max = $karta_min = $karta_rb = 0;
      $karta_text = $karta_typ = Null;}   
  break;
    
  case 51:
  case 53:
  $vedeni = $vedeni_max = $radek_ucty['Vedeni1'];
  $vedeni_min = 0;
  
  $banking_rb = $banking_max = $radek_ucty['IB1'];
  $banking_min = 0;
  
  switch($karta){
      case '1':
      $karta_vybery = $vybery * $radek_ucty['KontaktVyber3'];
      $placene_vybery = $vybery > 2 ? $vybery - 2 : 0;    // plati pouze pro vybery z bankomatu RB
      
      $karta_vedeni = $radek_ucty['KontaktVedeni1'];
      $karta_rb = $karta_max = $karta_vedeni + $karta_vybery;
      $karta_exc = $karta_vybery - ($placene_vybery * $radek_ucty['KontaktVyber2']);
      $karta_min = $karta_max - ($karta_vedeni + $karta_exc);
      
      $karta_text = '';
      $karta_text.= "- vedení karty: $karta_vedeni $mena<BR>
                      - zpoplatněné výběry z bankomatu ($vybery/$vybery): ".number_format($karta_vybery, 2, '.', '')." $mena-0-";
      $karta_text.= $vybery == 1 ? "-1- <U>jak ušetřit <B>".number_format($karta_exc, 2, '.', '')." $mena</B></U> - k výběrům hotovosti využívejte bankomatů Raiffeisenbank-1-" : Null;
      $karta_text.= $vybery == 2 || $placene_vybery >= 1 ? "-1- <U>jak ušetřit až <B>".number_format($karta_exc, 2, '.', '')." $mena</B></U> - k výběrům hotovosti využívejte bankomatů Raiffeisenbank, první 2 výběry v měsíci jsou zdarma-1-" : Null;
      
      $karta_typ = 'MasterCard Standard, Visa Classic';
      break;
      
      default:
      $karta_max = $karta_min = $karta_rb = 0;
      $karta_text = $karta_typ = Null;} 
  break;
  
  default:
  $vedeni = $vedeni_max = $vedeni_min = 0;
  $banking_rb = $banking_max = $banking_min = 0;
  $karta_max = $karta_min = $karta_rb = 0;
  $karta_text = $karta_typ = Null;
}

$vypis_rb = $vypis == 'papir' ? $radek_ucty['VypisMesPapir'] : $radek_ucty['VypisMesEl'];

switch ($radek_ucty['ID']){
  case 51:
  $vedeni_text = Null;
  
  $pomer_plateb_v_ramci_rb = round($radek_ucty['klientu'] / $klientu_celkem, 5);
  $dom_prich_mimo_rb = $kod_banky <> '5500' && $kod_banky <> 'ruzne' && $kod_banky <> 'none' ? $prichozi : $prichozi - round($prichozi *      $pomer_plateb_v_ramci_rb);
  $dom_prich_mimo_rb = $kod_banky == '5500' ? 0 : $dom_prich_mimo_rb;
  $dom_odch_std_mimo_rb = $dom_odch_std - round($dom_odch_std * $pomer_plateb_v_ramci_rb);
  
  $dom_prichozi = ($dom_prich_mimo_rb * $radek_ucty['PrichoziTransakce2']) + (($prichozi - $dom_prich_mimo_rb) * $radek_ucty['PrichoziTransakce1']);
  $dom_prichozi_text = "- příchozí platby z účtu mimo Raiffeisenbank ($dom_prich_mimo_rb/$prichozi): ".number_format($dom_prich_mimo_rb * $radek_ucty['PrichoziTransakce2'], 2, '.', '')." $mena<BR>- příchozí platby v rámci Raiffeisenbank (".($prichozi - $dom_prich_mimo_rb)."/$prichozi): ".number_format(($prichozi - $dom_prich_mimo_rb) * $radek_ucty['PrichoziTransakce1'], 2, '.', '')." $mena"; 
  
  $dom_odchozi_std = ($dom_odch_std_mimo_rb * $radek_ucty['DomOdchozi2']) + (($dom_odch_std - $dom_odch_std_mimo_rb) * $radek_ucty['DomOdchozi1']);
  $dom_odchozi_tp = $dom_odch_tp * $radek_ucty['DomOdchoziTP1'];
  $dom_odchozi = $dom_odchozi_std + $dom_odchozi_tp;
  $dom_odchozi_text = "- jednorázové platby mimo Raiffeisenbank ($dom_odch_std_mimo_rb/".$dom_odch_std."): ".number_format(($dom_odch_std_mimo_rb * $radek_ucty['DomOdchozi2']), 2, '.', '')." $mena<BR>- jednorázové platby v rámci Raiffeisenbank (".($dom_odch_std - $dom_odch_std_mimo_rb)."/$dom_odch_std): ".number_format((($dom_odch_std - $dom_odch_std_mimo_rb) * $radek_ucty['DomOdchozi1']), 2, '.', '')." $mena<BR>
     - zpoplatněné trvalé příkazy ($dom_odch_tp/$dom_odch_tp): ".number_format($dom_odchozi_tp, 2, '.', '')." $mena";
  break;
  
  case 49:
  case 53:
  $vedeni_text = "- Raiffeisenbank k bezpečnému přístupu na účet nabízí Mobilní Elektronický klíč (0.00 CZK), Osobní Elektronický klíč (89.00 CZK měsíčně) nebo Internetový Elektronický klíč (200.00 CZK ročně). Více o těchto možnostech <a href='http://www.rb.cz/osobni-finance/bezne-ucty/prime-bankovnictvi/internetove-bankovnictvi/bezpecnost-internetoveho-bankovnictvi/' target='_blank'>zde</a>-0-";
  $vedeni_text = htmlspecialchars($vedeni_text, ENT_QUOTES);
  
  $dom_prichozi = $prichozi * $radek_ucty['PrichoziTransakce1'];
  $dom_prichozi_text = "- zpoplatněné příchozí platby (0/$prichozi)";
  
  $dom_odchozi = ($dom_odch_std * $radek_ucty['DomOdchozi1']) + ($dom_odch_tp * $radek_ucty['DomOdchoziTP1']);
  $dom_odchozi_text = "- zpoplatněné jednorázové platby ($dom_odch_std/$dom_odch_std): ".number_format($dom_odch_std * $radek_ucty['DomOdchozi1'], 2, '.', '')." $mena<BR>- zpoplatněné trvalé příkazy ($dom_odch_tp/$dom_odch_tp): ".number_format($dom_odch_tp * $radek_ucty['DomOdchoziTP1'], 2, '.', '')." $mena";  
  break;
  
  default:
  $dom_prichozi = $dom_odchozi = 0;
  $vedeni_text = $dom_prichozi_text = $dom_odchozi_text = Null;
}

if($radek_ucty['ID'] == 51){
$dom_trans_text = '';     
$dom_trans_text.= "Počítáno s ".($pomer_plateb_v_ramci_rb * 100)." % pravděpodobností plateb z/na cizí účet v Raiffeisenbank. "; 
$dom_trans_text.= ($_POST['kod_banky'] == 'ruzne' || $_POST['kod_banky'] == 'none') && $dom_prich_mimo_rb == $prichozi ? "Za každou nezapočitanou příchozí platbu z Raiffeisenbank <U>- ".number_format($radek_ucty['PrichoziTransakce2'] - $radek_ucty['PrichoziTransakce1'], 2, '.', '')." $mena</U>. " : Null;
$dom_trans_text.= ($_POST['kod_banky'] == 'ruzne' || $_POST['kod_banky'] == 'none') && $dom_prich_mimo_rb < $prichozi ? "Za každou nezapočitanou příchozí platbu z Raiffeisenbank <U>- ".number_format($radek_ucty['PrichoziTransakce2'] - $radek_ucty['PrichoziTransakce2'], 2, '.', '')." $mena</U>, za každou navíc započitanou příchozí platbu z Raiffeisenbank <U>+ ".number_format($radek_ucty['PrichoziTransakce2'] - $radek_ucty['PrichoziTransakce1'], 2, '.', '')." $mena</U>. " : Null;
$dom_trans_text.= $dom_odch_std_mimo_rb == $dom_odch_std ? "Za každou nezapočitanou odchozí platbu do Raiffeisenbank <U>- ".number_format($radek_ucty['DomOdchozi2'] - $radek_ucty['DomOdchozi1'], 2, '.', '')." $mena</U>" : Null;
$dom_trans_text.= $dom_odch_std_mimo_rb < $dom_odch_std ? "Za každou nezapočitanou odchozí platbu do Raiffeisenbank <U>- ".number_format($radek_ucty['DomOdchozi2'] - $radek_ucty['DomOdchozi1'], 2, '.', '')." $mena</U>, za každou navíc započitanou odchozí platbu do Raiffeisenbank <U>+ ".number_format($radek_ucty['DomOdchozi2'] - $radek_ucty['DomOdchozi1'], 2, '.', '')." $mena</U>" : Null;
$dom_trans_text.= "-0-";}

else $dom_trans_text = Null;


switch($info)
{
case 'sms':
  $info_rb = $radek_ucty['SMSpush1'] * $transakce;
  $info_text = "- zadáno celkem $transakce transakcí = cena odpovídá $transakce SMS-0-";
break;

case 'mail':
  $info_rb = $radek_ucty['EMAILpush'] * $transakce;
  $info_text = $radek_ucty['EMAILpush']." / mail-0-";
break;
    
default:
  $info_rb = 0;
  $info_text = Null;
}

if($radek_ucty['ID'] == 49){
$vyhody_text = '';
$vyhody_text.= "<p style='text-align:left'>K účtu se vztahují programy Věrnostních výhod 'Extra výhody' a 'Prémiové výhody'. ";
  if($prijem >= 25000 || $prostredky >= 500000){
$vyhody_text.= "Dle Vašeho zadání <u>splňujete požadavky pro program 'Prémiové výhody'</u>, jehož výhody jsou již zahrnuty ve výpočtu výše. Tyto požadavky je nutné plnit každý měsíc. Při nesplnění podmínek programu 'Prémiové výhody' lze stále splnit podmínky pro program 'Extra výhody'. Níže jsou uvedeny obě možné varianty.</p><div style='text-align:left'><U>Podmínky programu Prémiové výhody</U><LI>Měsíční příjem minimálně 25 000 CZK, nebo <LI> Objem vkladů a investic u Raiffeisenbank k předposlednímu dni v měsíci minimálně 500 000 CZK</div><P><div style='text-align:left'><U>Podmínky programu Extra výhody</U><LI>Měsíční příjem minimálně 20 000 CZK, nebo <LI> Měsíční příjem minimálně 15 000 CZK a zároveň objem vkladů a investic u Raiffeisenbank k předposlednímu dni v měsíci minimálně 100 000 CZK</div><p><table><tr><td style='text-align:left; background-color:red; color:white; width:500'>Při splnění podmínek pouze programu 'Extra výhody' vzrostou náklady za účet celkem o <U><B>+ ".($karta <> '3' ? number_format($radek_ucty['Vedeni2'] + $radek_ucty['IB2'] + $radek_ucty['KontaktVedeni2'], 2, '.', '') : number_format($radek_ucty['Vedeni2'] + $radek_ucty['IB2'], 2, '.', ''))." $mena</B></U>, viz rozpis níže.<UL><LI> vedení účtu <U><B>+ ".$radek_ucty['Vedeni2']." $mena</B></U><LI> ovládání účtu <U><B>+ ".$radek_ucty['IB2']." $mena</B></U>";
$vyhody_text.= $karta <> '3' ? "<LI> vedení karty <U><B>+ ".$radek_ucty['KontaktVedeni2']." $mena</B></U> (tj. ".number_format($radek_ucty['KontaktVedeni2'] + $karta_vybery, 2, '.', '')." $mena)" : Null;
$vyhody_text.= "</UL></td><td style='text-align:center; vertical-align:center; width:50'>nebo</td><td style='text-align:left; background-color:red; color:white; width:500'>Při nesplnění podmínek programu 'Prémiové výhody' ani 'Extra výhody' vzrostou náklady za účet celkem o <U><B>+ ".($karta <> '3' ? number_format($vedeni_max + $banking_max + ($karta_max - $karta_rb), 2, '.', '') : number_format($vedeni_max + $banking_max, 2, '.', ''))." $mena</B></U>, viz rozpis níže.<UL><LI> vedení účtu <U><B>+ ".number_format($vedeni_max, 2, '.', '')." $mena</B></U><LI> ovládání účtu <U><B>+ ".number_format($banking_max, 2, '.', '')." $mena</B></U>";
$vyhody_text.= $karta <> '3' ? "<LI> vedení karty <U><B>+ ".number_format($karta_max - $karta_rb, 2, '.', '')." $mena</B></U> (tj. ".number_format($karta_max, 2, '.', '')." $mena)" : Null;
$vyhody_text.= "</UL></td></tr></table>";}
  elseif($prijem >= 20000 || ($prijem >= 15000 && $prostredky >= 100000)){
$vyhody_text.= "Dle Vašeho zadání <u>splňujete požadavky pro program 'Extra výhody'</u>, jehož výhody jsou již zahrnuty ve výpočtu výše. Tyto požadavky je nutné plnit každý měsíc. Při nesplnění budou účtovány poplatky podle pravidel níže.</p><div style='text-align:left'><U>Podmínky programu Extra výhody</U><LI>Měsíční příjem minimálně 20 000 CZK, nebo <LI> Měsíční příjem minimálně 15 000 CZK a zároveň objem vkladů a investic u Raiffeisenbank k předposlednímu dni v měsíci minimálně 100 000 CZK</div><p><div style='text-align:left; background-color:red; color:white; width:600'>Při nesplnění těchto podmínek vzrostou náklady za účet celkem o <U><B>+ ".($karta <> '3' ? number_format($vedeni_min + $banking_min + $karta_min, 2, '.', '') : number_format($banking_min + $vedeni_min, 2, '.', ''))." $mena</B></U>, viz rozpis níže.<UL><LI> vedení účtu <U><B>+ ".number_format($vedeni_min, 2, '.', '')." $mena</B></U> (tj. ".$radek_ucty['Vedeni1']." $mena)<LI> ovládání účtu <U><B>+ ".number_format($banking_min, 2, '.', '')." $mena</B></U> (tj. ".$radek_ucty['IB1']." $mena)";
$vyhody_text.= $karta <> '3' ? "<LI> vedení karty <U><B>+ ".number_format($karta_min, 2, '.', '')." $mena</B></U> (tj. ".number_format($karta_rb + $karta_min, 2, '.', '')." $mena)" : Null;
$vyhody_text.= "</ul></div>";}
  else{
$vyhody_text.= "Dle Vašeho zadání nesplňujete požadavky k uplatnění ani jednoho z těchto 2 programů.";}

$vyhody_text = htmlspecialchars($vyhody_text, ENT_QUOTES);}

else $vyhody_text = Null;
 
  
$naklady = $vedeni_max + $banking_max + $vypis_rb + $dom_prichozi + $dom_odchozi + $karta_rb + $info_rb; 
$naklady_exc = $naklady - $vedeni_min - $banking_min - $karta_exc;
 
                                                                                                   
$sql_detail = "UPDATE poplatky_vysledek SET Vedeni = $vedeni, Vedeni_text = '$vedeni_text', Banking = $banking_rb, Vypis = $vypis_rb, Vyhody_text = '$vyhody_text', Dom_prichozi = $dom_prichozi, Dom_prichozi_text = '$dom_prichozi_text', Dom_odchozi = $dom_odchozi, Dom_odchozi_text = '$dom_odchozi_text', Dom_trans_text = '$dom_trans_text', Karta = $karta_rb, Karta_text = '$karta_text', Karta_typ = '$karta_typ', Info = $info_rb, Info_text = '$info_text', NakladyOd = $naklady_exc, NakladyDo = $naklady WHERE ID = ".$radek_ucty['ID'];
$detail = mysql_query($sql_detail, $id_spojeni);
if (!$detail)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodařilo se poslat dotaz na detaily Raifky.');
}                                                               
//echo 'Dotaz na detaily - RB - odeslán.<br>';
  
}
  
?>