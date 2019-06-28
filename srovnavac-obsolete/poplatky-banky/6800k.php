
<?php

switch($radek_ucty['ID']){
case 66:
case 67:
case 68:
  $karta_max = $karta_min = 0;
  $karta_text = '';  
  
  while($radek_karty = mysql_fetch_assoc($karty)){
  if($radek_karty['ID'] == $radek_ucty['ID']){
  $karta_vydani = $radek_karty['Vydani'];
  $karta_vedeni = $radek_karty['Vedeni1'];
  $karta_dotaz1 = $radek_karty['BankZustatek1'];
  $karta_dotaz2 = $radek_karty['BankZustatek2'];
  
  $placene_vybery = $radek_karty['Vyber1'] > 0 ? $vybery : 0;
  
  $karta_vybery = $radek_karty['Vyber2'] != Null ? $placene_vybery * $radek_karty['Vyber2'] : $placene_vybery * $radek_karty['Vyber1'];
  
  $karta_sb = $karta_vedeni + $karta_vybery;
  $karta_min_local = $karta_vedeni + ($placene_vybery * $radek_karty['Vyber1']);
  $karta_min_local2 = $radek_karty['Vyber3'] != Null ? $karta_vedeni + ($placene_vybery * $radek_karty['Vyber3']) : Null;   
  $karta_exc_local = $karta_sb - $karta_min_local;
  $karta_exc_local2 = $karta_min_local2 != Null ? $karta_sb - $karta_min_local2 : Null;      
  echo $karta_max = $karta_sb > $karta_max && $radek_karty['Hlavni'] == 1 ? $karta_sb : $karta_max;
  
  $karta_exc = $karta_max - $karta_min_local; 
  echo $karta_min = $karta_exc > $karta_min && $radek_karty['Hlavni'] == 1 ? $karta_exc : $karta_min; 
  
  $text_exc = $radek_karty['Vedeni2'] > 0 ? "- za každou 3. a další vydanou debetní kartu je poplatek za vedení ".$radek_karty['Vedeni2']." $mena" : Null;
  $text_exc = text_exc($text_exc, 0);
  $karta_text.= text_karta($radek_ucty['nazev_banky'], $karta_sb, $radek_karty['Nazev'], $radek_karty['Hlavni'], $karta_exc_local, $text_exc, 'ČSOB', $karta_exc_local2);
  } elseif ($radek_karty['ID'] > $radek_ucty['ID']) break;}
break;

case 69:
  while($radek_karty = mysql_fetch_assoc($karty)){
  if($radek_karty['ID'] == $radek_ucty['ID']){
  $karta_sb = $karta_max = $karta_min = 0;
  $karta_text = '69';
  } elseif ($radek_karty['ID'] > $radek_ucty['ID']) break;}
break;
  
default:
  $karta_sb = $karta_max = $karta_min = 0;
  $karta_text = 'smula';
}

?>

