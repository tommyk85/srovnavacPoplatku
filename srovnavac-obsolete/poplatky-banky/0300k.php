
<?php

switch($radek_ucty['ID']){
case 15:
  $karta_max = $karta_min = 0;
  $karta_text = '';
  
  while($radek_karty = mysql_fetch_assoc($karty)){
  if($radek_karty['ID'] == $radek_ucty['ID']){ 
  $karta_vydani = $radek_karty['Vydani'];
  $karta_vedeni = $radek_karty['Vedeni1'];
  $karta_dotaz1 = $radek_karty['BankZustatek1'];
  $karta_dotaz2 = $radek_karty['BankZustatek2'];
  
    if($vek < 26){$placene_vybery = $vybery > 2 ? ($vybery - 2) : 0;}  
    else{$placene_vybery = $vybery;}
  
  $karta_vybery = $placene_vybery * $radek_karty['Vyber2'];
  
  $karta_ps = ($karta_vedeni + $karta_vybery);   
  $karta_exc_local = $karta_ps - ($karta_vedeni + ($placene_vybery * $radek_karty['Vyber1']));        
  $karta_max = $karta_ps > $karta_max && $radek_karty['Hlavni'] == 1 ? $karta_ps : $karta_max;
  
  $karta_exc = $karta_max - ($karta_vedeni + ($placene_vybery * $radek_karty['Vyber1'])); 
  $karta_min = $karta_exc > $karta_min && $radek_karty['Hlavni'] == 1 ? $karta_exc : $karta_min;              
                                                                                                                             
  $text_exc = $radek_karty['Hlavni'] == 1 ? "- za jakoukoli 2. a další vydanou debetní kartu je poplatek za vydání 350.00 $mena" : Null;
  $text_exc = text_exc($text_exc, 0);
  $karta_text.= text_karta($radek_ucty['nazev_banky'], $karta_ps, $radek_karty['Nazev'], $radek_karty['Hlavni'], $karta_exc_local);
  } elseif ($radek_karty['ID'] > $radek_ucty['ID']) break;}
break; 

case 17:
  $karta_max = $karta_min = 0;
  $karta_text = '';
    
  while($radek_karty = mysql_fetch_assoc($karty)){
  if($radek_karty['ID'] == $radek_ucty['ID']){
  $karta_vydani = $radek_karty['Vydani'];
  $karta_vedeni = $radek_karty['Vedeni1'];
  $karta_dotaz1 = $radek_karty['BankZustatek1'];
  $karta_dotaz2 = $radek_karty['BankZustatek2'];
  
  $placene_vybery = $vybery;
  
  $karta_vybery = $placene_vybery * $radek_karty['Vyber2'];
  
  $karta_ps = ($karta_vedeni + $karta_vybery);
  $karta_exc_local = $karta_ps - ($karta_vedeni + ($placene_vybery * $radek_karty['Vyber1']));           
  $karta_max = $karta_ps > $karta_max && $radek_karty['Hlavni'] == 1 ? $karta_ps : $karta_max;
    
  $karta_exc = $karta_max - ($karta_vedeni + ($placene_vybery * $radek_karty['Vyber1']));  
  $karta_min = $karta_exc > $karta_min && $radek_karty['Hlavni'] == 1 ? $karta_exc : $karta_min;
  
  $text_exc = $radek_karty['Hlavni'] == 1 ? "- za jakoukoli 2. a další vydanou debetní kartu je poplatek za vydání 350.00 $mena" : Null;
  $text_exc = text_exc($text_exc, 0);
  $karta_text.= text_karta($radek_ucty['nazev_banky'], $karta_ps, $radek_karty['Nazev'], $radek_karty['Hlavni'], $karta_exc_local, $text_exc);
  } elseif ($radek_karty['ID'] > $radek_ucty['ID']) break;}
break;

default:
$karta_ps = 0;
$karta_max = $karta_exc = $karta_min = 0;
$karta_text = Null;
}

?>

