<?php 

if($radek_ucty['ID'] == 35)             // bezny ucet zuno od 06/08/2012
  {

$vedeni35 = $radek_ucty['Vedeni1'];
$banking35 = $radek_ucty['IB1'];
$vypis35 = $vypis == 'papir' ? $radek_ucty['VypisMesPapir'] : $radek_ucty['VypisMesEl'];
$dom_prichozi35 = $radek_ucty['PrichoziTransakce1'];
$dom_odchozi35 = $radek_ucty['DomOdchozi1'] + $radek_ucty['DomOdchoziTP1'];


switch($karta)
{
case '1':
$karta_vedeni35 = $radek_ucty['KontaktVedeni1'];
$karta35 = $karta_vedeni35 + ($vybery * $radek_ucty['KontaktVyber2']);
  if($vybery <= 1)
  {$karta_exc35 = $karta35 - $radek_ucty['KontaktVyber1'];}
  
  elseif($vybery > 1)
  {$karta_exc35 = $karta35 - (($vybery - 1) * $radek_ucty['KontaktVyber3']);}


$karta_text35 = '';
$karta_text35.= "- vedení karty: $karta_vedeni35 $mena<BR>
                - zpoplatněné výběry z bankomatu ($vybery/$vybery): ".number_format($karta35 - $karta_vedeni35, 2, '.', '')." $mena-0-";
$karta_text35.= $karta35 > 0 && $vybery > 1 ? "-1- <U>jak ušetřit <B>až ".number_format($karta_exc35, 2, '.', '')." $mena</B></U> - k výběrům hotovosti využívejte bankomatů Raiffeisenbank-1-" : Null;
$karta_text35.= $karta35 > 0 && $vybery == 1 ? "-1- <U>jak ušetřit <B>".number_format($karta_exc35, 2, '.', '')." $mena</B></U> - k výběrům hotovosti využívejte bankomatů Raiffeisenbank-1-" : Null;

$karta_typ35 = 'Visa Classic';
break;

default:

$karta35 = 0;
$karta_exc35 = 0;
$karta_text35 = Null;
$karta_typ35 = Null;
}


switch($info)
{
case 'sms':
$info35 = $radek_ucty['SMSpush2']; 
$info_text35 = '- k úplnému přehledu nad platbami nutno aktivovat službu SMS plus-0-';
break;

default:
$info35 = 0; 
$info_text35 = Null;
}

  
$naklady35 = $vedeni35 + $banking35 + $vypis35 + $dom_prichozi35 + $dom_odchozi35 + $karta35 + $info35;
$naklady_exc35 = $naklady35 - $karta_exc35;

 

$sql_detail35 = "UPDATE poplatky_vysledek SET Vedeni = $vedeni35, Banking = $banking35, Vypis = $vypis35, Dom_prichozi = $dom_prichozi35, Dom_odchozi = $dom_odchozi35, Karta = $karta35, Karta_text = '$karta_text35', Karta_typ = '$karta_typ35', Info = $info35, Info_text = '$info_text35', NakladyOd = $naklady_exc35, NakladyDo = $naklady35 WHERE ID = 35";
$detail35 = mysql_query($sql_detail35, $id_spojeni);
if (!$detail35)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodařilo se nám poslat SQL dotaz na detail 35.');
} 
//echo 'Dotaz na detail 35 - zuno - odeslán.<br>';

  }





elseif($radek_ucty['ID'] == 36)         // bezny ucet zuno plus od 06/08/2012
  {
$vedeni36 = $karta_celkem >= 5000 || $zustatek >= 200000 ? $radek_ucty['Vedeni2'] : $radek_ucty['Vedeni1'];
$banking36 = $radek_ucty['IB1'];
$vypis36 = $vypis == 'papir' ? $radek_ucty['VypisMesPapir'] : $radek_ucty['VypisMesEl'];
$dom_prichozi36 = $radek_ucty['PrichoziTransakce1'];
$dom_odchozi36 = $radek_ucty['DomOdchozi1'] + $radek_ucty['DomOdchoziTP1'];


switch($karta)
{
case '1':
$karta_vedeni36 = $radek_ucty['KontaktVedeni1'];
$karta36 = $karta_vedeni36 + ($vybery * $radek_ucty['KontaktVyber2']);

$karta_exc_test36 = floor($karta_celkem / 1000) - $vybery;
$karta_exc36[] = $karta_exc_test36 >= 0 ? $karta36 : 0;
$karta_exc36[] = $karta_exc_test36 < 0 ? $karta36 - (-$karta_exc_test36 * $radek_ucty['KontaktVyber3']) : 0;

$karta_text36 = '';
$karta_text36.= "- vedení karty: $karta_vedeni36 $mena<BR>
                - zpoplatněné výběry z bankomatu ($vybery/$vybery): ".number_format($karta36 - $karta_vedeni36, 2, '.', '')." $mena-0-";
$karta_text36.= floor($karta_celkem / 1000) < 1 && $vybery == 1 ? "-1- <U>jak ušetřit <B>".number_format(max($karta_exc36), 2, '.', '')." $mena</B></U> - k výběrům hotovosti využívejte bankomatů Raiffeisenbank-1-" : Null;
$karta_text36.= floor($karta_celkem / 1000) >= 1 && $vybery == 1 ? "-1- <U>jak ušetřit <B>".number_format(max($karta_exc36), 2, '.', '')." $mena</B></U> - k výběrům hotovosti využívejte bankomatů Raiffeisenbank a zároveň dodržujte minimální výši výběru 1000.00 $mena-1-" : Null;
$karta_text36.= floor($karta_celkem / 1000) < 1 && $vybery > 1 ? "-1- <U>jak ušetřit <B>až ".number_format(max($karta_exc36), 2, '.', '')." $mena</B></U> - k výběrům hotovosti využívejte bankomatů Raiffeisenbank-1-" : Null;
$karta_text36.= floor($karta_celkem / 1000) >= 1 && $vybery > 1 ? "-1- <U>jak ušetřit <B>až ".number_format(max($karta_exc36), 2, '.', '')." $mena</B></U> - k výběrům hotovosti využívejte bankomatů Raiffeisenbank a zároveň dodržujte minimální výši každého výběru 1000.00 $mena-1-" : Null;



$karta_typ36 = 'Visa Classic';
break;

default:
$karta36 = 0;
$karta_exc36[] = 0;
$karta_text36 = Null;
$karta_typ36 = Null;
}


switch($info)
{
case 'sms':
$info36 = $radek_ucty['SMSpush1']; 
$info_text36 = '...';
break;

default:
$info36 = 0; 
$info_text36 = Null;
}

  
$naklady36 = $vedeni36 + $banking36 + $vypis36 + $dom_prichozi36 + $dom_odchozi36 + $karta36 + $info36;
$naklady_exc36 = $naklady36 - max($karta_exc36);



$sql_detail36 = "UPDATE poplatky_vysledek SET Vedeni = $vedeni36, Banking = $banking36, Vypis = $vypis36, Dom_prichozi = $dom_prichozi36, Dom_odchozi = $dom_odchozi36, Karta = $karta36, Karta_text = '$karta_text36', Karta_typ = '$karta_typ36', Info = $info36, Info_text = '$info_text36', NakladyOd = $naklady_exc36, NakladyDo = $naklady36 WHERE ID = 36";
$detail36 = mysql_query($sql_detail36, $id_spojeni);
if (!$detail36)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodařilo se nám poslat SQL dotaz na detail 36.');
} 
//echo 'Dotaz na detail 36 - zuno plus - odeslán.<br>';
  }








?>