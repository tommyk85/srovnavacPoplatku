<?php 


if($radek_ucty['ID'] == 37)         // bezny ucet fio bank od 29/08/2012
  {
$vedeni37 = $radek_ucty['Vedeni1'];
$banking37 = $radek_ucty['IB1'];
$vypis37 = $vypis == 'papir' ? $radek_ucty['VypisMesPapir'] : $radek_ucty['VypisMesEl'];
$dom_prichozi37 = $radek_ucty['PrichoziTransakce1'];
$dom_odchozi37 = $radek_ucty['DomOdchozi1'] + $radek_ucty['DomOdchoziTP1'];


switch($karta)
{
case '1':
$karta_vedeni37 = $radek_ucty['KontaktVedeni1'];

$vybery_zdarma37 = floor($karta_celkem / 4000) <= 5 ? floor($karta_celkem / 4000) : 5;
$vybery_zdarma37 = $vybery_zdarma37 >= $vybery ? $vybery : $vybery_zdarma37;                      

$karta37 = $karta_vedeni37 + (($vybery * $radek_ucty['KontaktVyber2']) - ($vybery_zdarma37 * $radek_ucty['KontaktVyber2']));

$karta_exc37 = $karta37 - (10 + $vybery_zdarma37 >= $vybery ? 0 : ($vybery - (10 + $vybery_zdarma37)) * $radek_ucty['KontaktVyber1']);

$karta_text37 = '';
$karta_text37.= "- vedení karty: $karta_vedeni37 $mena<BR>                                      
                - zpoplatněné výběry z bankomatu (".($vybery - $vybery_zdarma37)."/$vybery): ".number_format($karta37 - $karta_vedeni37, 2, '.', '')." $mena-0-";
$karta_text37.= $karta37 > 0 && ($vybery - $vybery_zdarma37) > 1 ? "-1- <U>jak ušetřit <B>až ".number_format($karta_exc37, 2, '.', '')." $mena</B></U> - k výběrům hotovosti využívejte bankomatů Fio banky-1-" : Null;
$karta_text37.= $karta37 > 0 && ($vybery - $vybery_zdarma37) == 1 ? "-1- <U>jak ušetřit <B>".number_format($karta_exc37, 2, '.', '')." $mena</B></U> - k výběrům hotovosti využívejte bankomatů Fio banky-1-" : Null;
$karta_text37.= "-2- <U>na co si dát pozor</U> - za každý dotaz na zůstatek z jiného bankomatu než od Fio <U><B>+ ".$radek_ucty['KontaktBankZustatek2']." $mena</B></U>";

$karta_typ37 = 'Maestro, MasterCard Standard';
break;

case '2':
$karta_vedeni37 = $radek_ucty['BezKontaktVedeni'];                      

$vybery_zdarma37 = floor($karta_celkem / 4000) <= 5 ? floor($karta_celkem / 4000) : 5;
$vybery_zdarma37 = $vybery_zdarma37 >= $vybery ? $vybery : $vybery_zdarma37;                      

$karta37 = $karta_vedeni37 + (($vybery * $radek_ucty['BezKontaktVyber2']) - ($vybery_zdarma37 * $radek_ucty['BezKontaktVyber2']));

$karta_exc37 = $karta37 - (10 + $vybery_zdarma37 >= $vybery ? 0 : ($vybery - (10 + $vybery_zdarma37)) * $radek_ucty['BezKontaktVyber1']);

$karta_text37 = '';
$karta_text37.= "- vedení karty: $karta_vedeni37 $mena<BR>                                      
                - zpoplatněné výběry z bankomatu (".($vybery - $vybery_zdarma37)."): ".number_format($karta37 - $karta_vedeni37, 2, '.', '')." $mena-0-";                
$karta_text37.= ($vybery - $vybery_zdarma37) > 1 ? "-1- <U>jak ušetřit <B>až ".number_format($karta_exc37, 2, '.', '')." $mena</B></U> - k výběrům hotovosti využívejte bankomatů Fio banky-1-" : Null;
$karta_text37.= ($vybery - $vybery_zdarma37) == 1 ? "-1- <U>jak ušetřit <B>".number_format($karta_exc37, 2, '.', '')." $mena</B></U> - k výběrům hotovosti využívejte bankomatů Fio banky-1-" : Null;
$karta_text37.= "-2- <U>na co si dát pozor</U> - za každý dotaz na zůstatek z jiného bankomatu než od Fio <U><B>+ ".$radek_ucty['BezKontaktBankZustatek2']." $mena</B></U>";

$karta_typ37 = 'MasterCard Standard PayPass';
break;

default:
$karta37 = 0;
$karta_exc37 = 0;
$karta_text37 = Null;
$karta_typ37 = Null;
}


switch($info)
{
case 'sms':
  $info37 = $radek_ucty['SMSpush1'] * $transakce;
  $info_text37 = "- zadáno celkem $transakce transakcí = cena odpovídá $transakce SMS.-0-";
break;
    
default:
  $info37 = 0;
  $info_text37 = Null;
}


  
$naklady37 = $vedeni37 + $banking37 + $vypis37 + $dom_prichozi37 + $dom_odchozi37 + $karta37 + $info37;
$naklady_exc37 = $naklady37 - $karta_exc37;




$sql_detail37 = "UPDATE poplatky_vysledek SET Vedeni = $vedeni37, Banking = $banking37, Vypis = $vypis37, Dom_prichozi = $dom_prichozi37, Dom_odchozi = $dom_odchozi37, Karta = $karta37, Karta_text = '$karta_text37', Karta_typ = '$karta_typ37', Info = $info37, Info_text = '$info_text37', NakladyOd = $naklady_exc37, NakladyDo = $naklady37 WHERE ID = 37";
$detail37 = mysql_query($sql_detail37, $id_spojeni);
if (!$detail37)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodařilo se nám poslat SQL dotaz na detail 37.');
} 
//echo 'Dotaz na detail 37 - bezny ucet fio - odeslán.<br>';
  }








?>