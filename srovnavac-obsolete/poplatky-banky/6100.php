<?php 

if($radek_ucty['ID'] == 34)             // bezny ucet equabank od 13/09/2012
  {
$vedeni34 = $prijem >= 10000 || $zustatek >= 100000 ? $radek_ucty['Vedeni1'] : $radek_ucty['Vedeni2']; 
$vedeni_text34 = $vedeni34 == $radek_ucty['Vedeni2'] ? "- účet je brán jako neaktivní" : Null;
$banking34 = $radek_ucty['IB1'];
$vypis34 = $vypis == 'papir' ? $radek_ucty['VypisMesPapir'] : $radek_ucty['VypisMesEl'];
$dom_prichozi34 = $radek_ucty['PrichoziTransakce1'];
$dom_odchozi34 = $radek_ucty['DomOdchozi1'] + $radek_ucty['DomOdchoziTP1'];


$karta34 = $radek_ucty['KontaktVedeni1'] + $radek_ucty['KontaktVyber1'];
$karta_text34 = $karta <> '3' ? '...' : Null;      // bez poznamky, jen podminka pro zobrazeni radku karty v detailu uctu
$karta_typ34 = 'MasterCard';


switch($info)
{
case 'mail':
  $info34 = $radek_ucty['EMAILpush'] * $transakce;
  $info_text34 = $radek_ucty['EMAILpush']." / mail-0-";
break;

case 'sms':
  $info34 = $radek_ucty['SMSpush1'] * $transakce;
  $info_text34 = "- zadáno celkem $transakce transakcí = cena odpovídá $transakce SMS.-0-";
break;
    
default:
  $info34 = 0;
  $info_text34 = Null;
}

$naklady34 = $vedeni34 + $banking34 + $vypis34 + $dom_prichozi34 + $dom_odchozi34 + $karta34 + $info34; 
$naklady_exc34 = $naklady34;


$sql_detail34 = "UPDATE poplatky_vysledek SET Vedeni = $vedeni34, Vedeni_text = '$vedeni_text34', Banking = $banking34, Vypis = $vypis34, Dom_prichozi = $dom_prichozi34, Dom_odchozi = $dom_odchozi34, Karta = $karta34, Karta_text = '$karta_text34', Karta_typ = '$karta_typ34', Info = $info34, Info_text = '$info_text34', NakladyOd = $naklady_exc34, NakladyDo = $naklady34 WHERE ID = 34";
$detail34 = mysql_query($sql_detail34, $id_spojeni);
if (!$detail34)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodařilo se nám poslat SQL dotaz na detail 34.');
} 
//echo 'Dotaz na detail 34 - bezny ucet equabank - odeslán.<br>';

  }
   

?>