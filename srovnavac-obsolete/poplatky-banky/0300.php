<?php 

if($radek_ucty['ID'] == 15 || $radek_ucty['ID'] == 17)              // era osobni, era online od 01/03/2013
  {

switch ($radek_ucty['ID']){
  case 15:
    if($vek < 26)             {$vedeni = $vedeni_max = $vedeni_min = $radek_ucty['Vedeni3']; $vedeni_text = Null;}
    elseif($vek >= 58)        {$vedeni = $vedeni_max = $vedeni_min = $radek_ucty['Vedeni4']; $vedeni_text = Null;}
    else{ 
      $vedeni = $dom_odch_std > 0 ? $radek_ucty['Vedeni2'] : $radek_ucty['Vedeni1']; 
      $vedeni_max = $radek_ucty['Vedeni1'];
      $vedeni_min = $dom_odch_std == 0 ? 0 : $radek_ucty['Vedeni1'] - $radek_ucty['Vedeni2'];
      $vedeni_text = "-2- <U>na co si dát pozor</U> - pokud v měsíci neproběhne žádná odchozí transakce, pak vedení účtu <U><B>+ ".number_format($radek_ucty['Vedeni1'] - $radek_ucty['Vedeni2'], 2, '.', '')." $mena</B></U>";}
    //else                      {$vedeni = $vedeni_max = $vedeni_min = $radek_ucty['Vedeni1']; $vedeni_text = Null;}
  break;
  
  case 17:
    $vedeni = $zustatek >= 15000 ? $radek_ucty['Vedeni2'] : $radek_ucty['Vedeni1'];
    $vedeni_max = $radek_ucty['Vedeni1'];
    $vedeni_min = $zustatek >= 15000 ? $radek_ucty['Vedeni1'] : $radek_ucty['Vedeni2'];
    $vedeni_text = $zustatek >= 15000 ? "-2- <U>na co si dát pozor</U> - pokud průměrný měsíční zůstatek klesne pod 15 000 CZK, pak vedení účtu v příštím měsíci <U><B>+ ".$radek_ucty['Vedeni1']." $mena</B></U>" : Null;
  break;
  
  default:      
    $vedeni = $vedeni_max = $vedeni_min = 0;
    $vedeni_text = Null; 
}
  
$banking_ps = $radek_ucty['IB1'];

$vypis_ps = $vypis == 'papir' ? $radek_ucty['VypisMesPapir'] : $radek_ucty['VypisMesEl'];


$dom_prichozi = $prichozi * $radek_ucty['PrichoziTransakce1'];
$dom_prichozi_text = "- zpoplatněné příchozí platby (0/$prichozi)";

$dom_odch_std_ps = $dom_odch_std * $radek_ucty['DomOdchozi1'];
$dom_odch_tp_ps = $dom_odch_tp * $radek_ucty['DomOdchoziTP1'];
$dom_odchozi = $dom_odch_std_ps + $dom_odch_tp_ps;

$dom_odchozi_text = "- zpoplatněné jednorázové platby (".($radek_ucty['ID'] == 15 ? $dom_odch_std : 0)."/$dom_odch_std): ".number_format($dom_odch_std_ps, 2, '.', '')." $mena<BR>- zpoplatněné trvalé příkazy (".($radek_ucty['ID'] == 15 ? $dom_odch_tp : 0)."/$dom_odch_tp): ".number_format($dom_odch_tp_ps, 2, '.', '')." $mena";

$dom_trans_text = $radek_ucty['ID'] == 15 ? "- platby do elektronické peněženky PaySec jsou zdarma-0-" : Null;
                             

include "poplatky-banky/0300k.php";


switch($info)
{
case 'sms':
  $info_ps = $radek_ucty['SMSpush1'] * $transakce;
  $info_text = "- zadáno celkem $transakce transakcí = cena odpovídá $transakce SMS-0-";
break;

case 'mail':
  $info_ps = $radek_ucty['EMAILpush'] * $transakce;
  $info_text = $radek_ucty['EMAILpush']." / mail-0-";
break;
    
default:
  $info_ps = 0;
  $info_text = Null;
}

$zruseni_text = "- při zrušení do 12 měsíců od založení je účtován poplatek <U>".$radek_ucty['Zruseni2']." $mena</U>";

 
$naklady = $vedeni_max + $banking_ps + $vypis_ps + $dom_prichozi + $dom_odchozi + $karta_max + $info_ps; 
$naklady_exc = $naklady - $vedeni_min - $karta_min;


                                                                                                   
$sql_detail = "UPDATE poplatky_vysledek SET Vedeni = $vedeni, Vedeni_text = '$vedeni_text', Banking = $banking_ps, Vypis = $vypis_ps, Dom_prichozi = $dom_prichozi, Dom_prichozi_text = '$dom_prichozi_text', Dom_odchozi = $dom_odchozi, Dom_odchozi_text = '$dom_odchozi_text', Dom_trans_text = '$dom_trans_text', Karta = $karta_max, Karta_text = '$karta_text', Karta_typ = '$karta_typ', Info = $info_ps, Info_text = '$info_text', NakladyOd = $naklady_exc, NakladyDo = $naklady, Zruseni_text = '$zruseni_text' WHERE ID = ".$radek_ucty['ID'];
$detail = mysql_query($sql_detail, $id_spojeni);
if (!$detail)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodařilo se poslat dotaz na detail era.');
}                                                               
//echo 'Dotaz na detail - era - odeslán.<br>';
//$zruseni_text = Null;
  }
  


elseif($radek_ucty['ID'] == 25 || $radek_ucty['ID'] == 27 || $radek_ucty['ID'] == 29 || $radek_ucty['ID'] == 31)                  
// csob konto, aktivni konto, exkluziv a student od 01/11/2012
  {

switch ($radek_ucty['ID']){
  case 25:
  case 27:
  case 31:
    $vedeni = $vedeni_max = $vypis == 'elektro' ? $radek_ucty['Vedeni2'] : $radek_ucty['Vedeni1'];
    $vedeni_min = 0;
    $vedeni_text = Null;
  break;
  
  case 29:
    $vedeni = $prostredky >= 1000000 ? $radek_ucty['Vedeni2'] : $radek_ucty['Vedeni1'];
    $vedeni_max = $radek_ucty['Vedeni1'];
    $vedeni_min = $prostredky >= 1000000 ? $radek_ucty['Vedeni1'] : $radek_ucty['Vedeni2'];
    $vedeni_text = $prostredky >= 1000000 ? "-2- <U>na co si dát pozor</U> - pokud klesne celkový objem vkladů u ČSOB pod 1 000 000 CZK, pak vedení účtu <U><B>+ ".$radek_ucty['Vedeni1']." $mena</B></U>" : Null;
  break;
  
  default:      
    $vedeni = $radek_ucty['Vedeni1'];
} 

$banking_csob = $radek_ucty['IB1'];

$vypis_csob = $vypis == 'papir' ? $radek_ucty['VypisMesPapir'] : $radek_ucty['VypisMesEl'];


switch ($radek_ucty['ID']){
  case 25:
    $dom_prichozi = $prichozi >= 2 ? ($prichozi - 2) * $radek_ucty['PrichoziTransakce2'] : $radek_ucty['PrichoziTransakce1'];
    $dom_prichozi_text = "- zpoplatněné příchozí platby (".($prichozi >= 2 ? ($prichozi - 2) : 0)."/$prichozi)";
    
    $dom_odch_std_csob = $dom_odch_std >= 2 ? ($dom_odch_std - 2) * $radek_ucty['DomOdchozi2'] : $radek_ucty['DomOdchozi1'];
    $dom_odch_tp_csob = $dom_odch_tp * $radek_ucty['DomOdchoziTP1'];
    $dom_odchozi_text = "- zpoplatněné jednorázové platby (".($dom_odch_std >= 2 ? $dom_odch_std - 2 : 0)."/$dom_odch_std): ".number_format($dom_odch_std_csob, 2, '.', '')." $mena<BR>- zpoplatněné trvalé příkazy ($dom_odch_tp/$dom_odch_tp): ".number_format($dom_odch_tp_csob, 2, '.', '')." $mena"; 
  break;
  
  case 27:
    $dom_prichozi = $prichozi >= 5 ? ($prichozi - 5) * $radek_ucty['PrichoziTransakce2'] : $radek_ucty['PrichoziTransakce1'];
    $dom_prichozi_text = "- zpoplatněné příchozí platby (".($prichozi >= 5 ? ($prichozi - 5) : 0)."/$prichozi)";
    
    $dom_odch_std_csob = $dom_odch_std >= 10 ? ($dom_odch_std - 10) * $radek_ucty['DomOdchozi2'] : $radek_ucty['DomOdchozi1'];
    $dom_odch_tp_csob = $dom_odch_tp * $radek_ucty['DomOdchoziTP1'];
    $dom_odchozi_text = "- zpoplatněné jednorázové platby (".($dom_odch_std >= 10 ? $dom_odch_std - 10 : 0)."/$dom_odch_std): ".number_format($dom_odch_std_csob, 2, '.', '')." $mena<BR>- zpoplatněné trvalé příkazy ($dom_odch_tp/$dom_odch_tp): ".number_format($dom_odch_tp_csob, 2, '.', '')." $mena"; 
  break;
  
  case 29:
  case 31:
    $dom_prichozi = $prichozi * $radek_ucty['PrichoziTransakce1'];
    $dom_prichozi_text = "- zpoplatněné příchozí platby (0/$prichozi)";
    
    $dom_odch_std_csob = $dom_odch_std * $radek_ucty['DomOdchozi1'];
    $dom_odch_tp_csob = $dom_odch_tp * $radek_ucty['DomOdchoziTP1'];
    $dom_odchozi_text = "- zpoplatněné jednorázové platby (0/$dom_odch_std): ".number_format($dom_odch_std_csob, 2, '.', '')." $mena<BR>- zpoplatněné trvalé příkazy ($dom_odch_tp/$dom_odch_tp): ".number_format($dom_odch_tp_csob, 2, '.', '')." $mena"; 
  break;
  
  default:
    $dom_prichozi = 0;
    $dom_prichozi_text = Null;
    $dom_odch_std_csob = 0;
    $dom_odch_tp_csob = 0;
    $dom_odchozi_text = Null;
}

$dom_odchozi = $dom_odch_std_csob + $dom_odch_tp_csob;

$dom_trans_text = $dom_odch_tp > 0 ? "-2- <U>na co si dát pozor</U> - za každou změnu trvalého příkazu <U><B>+ ".$radek_ucty['TP2']." $mena</B></U>" : Null;


switch($karta)
{
case '1':
$karta_vedeni = $radek_ucty['KontaktVedeni1'];

  if($radek_ucty['ID'] == 25){
  $placene_vybery = $vybery > 2 ? ($vybery - 2) : 0;
  }
  if($radek_ucty['ID'] == 27){
  $placene_vybery = $vybery > 5 ? ($vybery - 5) : 0;
  }  
  else{
  $placene_vybery = $vybery;
  }

$karta_vybery = $placene_vybery * $radek_ucty['KontaktVyber2'];
$karta_csob = $karta_vedeni + $karta_vybery;

$karta_exc = $karta_vybery - ($placene_vybery * $radek_ucty['KontaktVyber1']);

$karta_text = '';
$karta_text.= "- vedení karty: $karta_vedeni $mena<BR>
                - zpoplatněné výběry z bankomatu ($placene_vybery/$vybery): ".number_format($karta_vybery, 2, '.', '')." $mena-0-";
$karta_text.= $placene_vybery == 1 ? "-1- <U>jak ušetřit <B>".number_format($karta_exc, 2, '.', '')." $mena</B></U> - k výběrům hotovosti využívejte bankomatů ČSOB-1-" : Null;
$karta_text.= $placene_vybery > 1 ? "-1- <U>jak ušetřit <B>až ".number_format($karta_exc, 2, '.', '')." $mena</B></U> - k výběrům hotovosti využívejte bankomatů ČSOB-1-" : Null;

$karta_text.= "-2- <U>na co si dát pozor</U> - za každý dotaz na zůstatek z jiného bankomatu než od ČSOB <U><B>+ ".$radek_ucty['KontaktBankZustatek2']." $mena</B></U>";
  
$karta_typ = 'MasterCard Standard';
break;

default:
$karta_csob = 0;
$karta_exc = 0;
$karta_text = Null;
$karta_typ = Null;
}


switch($info)
{
case 'sms':
  switch($radek_ucty['ID']){
  case 27:
  $info_csob = $transakce > 5 ? $radek_ucty['SMSpush2'] * ($transakce - 5) : 0;
  $info_text = "- zadáno celkem $transakce transakcí, prvních 5 SMS v měsíci je zdarma = cena odpovídá ".($transakce - 5)." SMS-0-";
  break;
  
  case 29:
  $info_csob = $transakce > 10 ? $radek_ucty['SMSpush2'] * ($transakce - 10) : 0;
  $info_text = "- zadáno celkem $transakce transakcí, prvních 10 SMS v měsíci je zdarma = cena odpovídá ".($transakce - 10)." SMS-0-";
  break;
  
  default:
  $info_csob = $radek_ucty['SMSpush1'] * $transakce;
  $info_text = "- zadáno celkem $transakce transakcí = cena odpovídá $transakce SMS-0-";
  }
break;

case 'mail':
  $info_csob = $radek_ucty['EMAILpush'] * $transakce;
  $info_text = "...-0-";
break;
    
default:
  $info_csob = 0;
  $info_text = Null;
}



$naklady = $vedeni_max + $banking_csob + $vypis_csob + $dom_prichozi + $dom_odchozi + $karta_csob + $info_csob; //; 
$naklady_exc = $naklady - $vedeni_min - $karta_exc;

                                                                                                   
$sql_detail = "UPDATE poplatky_vysledek SET Vedeni = $vedeni, Vedeni_text = '$vedeni_text', Banking = $banking_csob, Vypis = $vypis_csob, Dom_prichozi = $dom_prichozi, Dom_prichozi_text = '$dom_prichozi_text', Dom_odchozi = $dom_odchozi, Dom_odchozi_text = '$dom_odchozi_text', Dom_trans_text = '$dom_trans_text', Karta = $karta_csob, Karta_text = '$karta_text', Karta_typ = '$karta_typ', Info = $info_csob, Info_text = '$info_text', NakladyOd = $naklady_exc, NakladyDo = $naklady WHERE ID = ".$radek_ucty['ID'];
$detail = mysql_query($sql_detail, $id_spojeni);
if (!$detail)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodařilo se poslat dotaz na detail csob.');
}                                                               
//echo 'Dotaz na detail - csob - odeslán.<br>';                 
  }
?>