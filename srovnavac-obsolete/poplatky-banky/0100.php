<?php

if($radek_ucty['ID'] >= 2 && $radek_ucty['ID'] <= 6)       // mujucet, g2.2, bezny ucet, top nabidka a start konto KB od 01/06/2013
  {

switch ($radek_ucty['ID']){             // vedeni + banking
  case 2:
  $vedeni = $vedeni_max = $vedeni_min = $radek_ucty['Vedeni1'];
  $bonus = $prichozi > 0 ? $radek_ucty['Vedeni1'] * 0.25 : 0;
  $bonus += $prostredky >= 250000 ? $radek_ucty['Vedeni1'] * 0.25 : 0;
  $vedeni -= $bonus;
  
  $banking_kb = $radek_ucty['IB1'];
  break;
  
  case 3:
    if($vek <= 25){
    $vedeni = $vedeni_max = $vedeni_min = $radek_ucty['Vedeni1'];}
    else{
    $vedeni = $vedeni_max = $vedeni_min = $radek_ucty['Vedeni2'];
    $bonus = $prichozi > 0 ? $radek_ucty['Vedeni2'] * 0.5 : 0;
    $bonus += $prostredky >= 125000 ? $radek_ucty['Vedeni2'] * 0.5 : 0;
    $vedeni -= $bonus;}
  
  $banking_kb = $radek_ucty['IB1'];
  break;
  
  case 4:
  case 6:
  $vedeni = $vedeni_max = $radek_ucty['Vedeni1'];
  $vedeni_min = 0;
  
  $tb = in_array('tb', $banking) ? $radek_ucty['TB'] : 0;
  $banking_kb = $radek_ucty['IB1'] + $tb;
  break;
  
  case 5:
    if($prostredky >= 8000000){
    $vedeni = $radek_ucty['Vedeni3'];
    $vedeni_min = $radek_ucty['Vedeni1'];}
    
    elseif($prostredky >= 3000000){
    $vedeni = $vedeni_min = $radek_ucty['Vedeni2'];}
    else{
    $vedeni = $radek_ucty['Vedeni1'];
    $vedeni_min = 0;}
    
  $vedeni_max = $radek_ucty['Vedeni1'];
    
  $banking_kb = $radek_ucty['IB1'];
  break;
     
  default:
  $vedeni = $vedeni_max = $vedeni_min = 0;
  $banking_kb = 0;
}

$vypis_kb = $vypis == 'papir' ? $radek_ucty['VypisMesPapir'] : $radek_ucty['VypisMesEl'];

switch ($radek_ucty['ID']){             // transakce
  case 2:
  case 3:
  $dom_prichozi = $radek_ucty['PrichoziTransakce1'];
  
  $dom_odchozi_std = $dom_odch_std * $radek_ucty['DomOdchozi1'];
  $dom_odchozi_tp = $dom_odch_tp * $radek_ucty['DomOdchoziTP1'];
  $dom_odchozi = $dom_odchozi_max = $dom_odchozi_std + $dom_odchozi_tp;
  
  $dom_odchozi_exc = ($radek_ucty['ID'] == 2 || ($radek_ucty['ID'] == 3 && $vek > 25)) && $dom_odchozi > $radek_ucty['DomOdchozi2'] ? $dom_odchozi - $radek_ucty['DomOdchozi2'] : 0;
  $dom_odchozi_exc = $radek_ucty['ID'] == 3 && $vek <= 25 && $dom_odchozi > $radek_ucty['DomOdchozi3'] ? $dom_odchozi - $radek_ucty['DomOdchozi3'] : $dom_odchozi_exc;

  break;
  
  case 4:
  case 5:
  $pomer_plateb_v_ramci_kb = round($radek_ucty['klientu'] / $klientu_celkem, 5);
  $dom_odch_std_mimo_kb = $dom_odch_std - round($dom_odch_std * $pomer_plateb_v_ramci_kb);
  $dom_odch_tp_mimo_kb = $dom_odch_tp - round($dom_odch_tp * $pomer_plateb_v_ramci_kb);  

  $dom_prichozi = $prichozi * $radek_ucty['PrichoziTransakce1'];
   
  $dom_odchozi_std = (($dom_odch_std - $dom_odch_std_mimo_kb) * $radek_ucty['DomOdchozi1']) + ($dom_odch_std_mimo_kb * $radek_ucty['DomOdchozi2']);
  $dom_odchozi_tp = $radek_ucty['ID'] == 4 ? (($dom_odch_tp - $dom_odch_tp_mimo_kb) * $radek_ucty['DomOdchoziTP1']) + ($dom_odch_tp_mimo_kb * $radek_ucty['DomOdchoziTP2']) : $dom_odch_tp * $radek_ucty['DomOdchoziTP1'];
  $dom_odchozi = $dom_odchozi_std + $dom_odchozi_tp;
  
  $dom_odchozi_max = $radek_ucty['ID'] == 4 ? ($dom_odch_tp * $radek_ucty['DomOdchoziTP2']) + ($dom_odch_std * $radek_ucty['DomOdchozi2']) : $dom_odch_std * $radek_ucty['DomOdchozi2'];
  $dom_odchozi_exc = $radek_ucty['ID'] == 4 ? $dom_odchozi_max - ($dom_odch_tp * $radek_ucty['DomOdchoziTP1']) + ($dom_odch_std * $radek_ucty['DomOdchozi1']) : $dom_odchozi_max - ($dom_odch_std * $radek_ucty['DomOdchozi1']);

  break;
  
  case 6:
  $pomer_plateb_v_ramci_kb = round($radek_ucty['klientu'] / $klientu_celkem, 5);
  $dom_odch_std_mimo_kb = $dom_odch_std - round($dom_odch_std * $pomer_plateb_v_ramci_kb);
    
  $placene_prichozi = $prichozi > 1 ? $prichozi - 1 : 0;
  $dom_prichozi = $placene_prichozi * $radek_ucty['PrichoziTransakce2'];
   
  $dom_odchozi_std = (($dom_odch_std - $dom_odch_std_mimo_kb) * $radek_ucty['DomOdchozi1']) + ($dom_odch_std_mimo_kb * $radek_ucty['DomOdchozi2']);
  $dom_odchozi_tp = $dom_odch_tp * $radek_ucty['DomOdchoziTP1'];
  $dom_odchozi = $dom_odchozi_std + $dom_odchozi_tp;
  
  $dom_odchozi_max = ($dom_odch_tp * $radek_ucty['DomOdchoziTP1']) + ($dom_odch_std * $radek_ucty['DomOdchozi2']);
  $dom_odchozi_exc = $dom_odchozi_max - (($dom_odch_tp * $radek_ucty['DomOdchoziTP1']) + ($dom_odch_std * $radek_ucty['DomOdchozi1']));
    
  break;
  
  default:
  $dom_prichozi = $dom_odchozi = $dom_odchozi_exc = 0;
}


switch($karta)
{
case '1':
$karta_vedeni = round($radek_ucty['KontaktVedeni1'] / 12, 2);
$karta_vybery = $vybery * $radek_ucty['KontaktVyber2'];
$karta_kb = $karta_vedeni + $karta_vybery;

$karta_exc = $karta_vybery - ($vybery * $radek_ucty['KontaktVyber1']);

$karta_typ = $radek_ucty['ID'] == 4 ? 'VISA Electron nebo Maestro' : 'Embosovaná VISA nebo MasterCard';
break;

default:
$karta_kb = $karta_exc = 0;
}

switch($info)
{
case 'sms':
  $info_kb = $radek_ucty['SMSpush1'] * $transakce;
break;

case 'mail':
  $info_kb = $radek_ucty['EMAILpush'] * $transakce;
break;
    
default:
  $info_kb = 0;
}


$naklady = $vedeni_max + $banking_kb + $vypis_kb + $dom_prichozi + $dom_odchozi_max + $karta_kb + $info_kb; 
$naklady_exc = $naklady - $vedeni_min - $dom_odchozi_exc - $karta_exc;

                                                                                                   
$sql_detail = "UPDATE poplatky_vysledek SET NakladyOd = $naklady_exc, NakladyDo = $naklady WHERE ID = ".$radek_ucty['ID'];
$detail = mysql_query($sql_detail, $id_spojeni);
if (!$detail)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodařilo se poslat dotaz na detaily KB.');
}                                                               
//echo 'Dotaz na detaily - KB - odeslán.<br>';
  }
?>