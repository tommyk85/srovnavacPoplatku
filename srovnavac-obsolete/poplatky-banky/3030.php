<?php 

if($radek_ucty['ID'] == 32)             // bezny ucet air bank - maly tarif - od 05/08/2011
  {
$pomer_plateb_v_ramci_banky32 = round($radek_ucty['klientu'] / $klientu_celkem, 5);
$placenych_dom_odch_std32 = $_POST['odch_std'] - round($_POST['odch_std'] * $pomer_plateb_v_ramci_banky32);
$placenych_dom_odch_tp32 = $_POST['odch_tp'] - round($_POST['odch_tp'] * $pomer_plateb_v_ramci_banky32);  

$vedeni32 = $radek_ucty['Vedeni1']; 
$banking32 = $radek_ucty['IB1'];
$vypis32 = $vypis == 'papir' ? $radek_ucty['VypisMesPapir'] : $radek_ucty['VypisMesEl'];
$dom_prichozi32 = $radek_ucty['PrichoziTransakce1'];
$dom_odchozi_std32 = $placenych_dom_odch_std32 * $radek_ucty['DomOdchozi2'];
$dom_odchozi_tp32 = $placenych_dom_odch_tp32 * $radek_ucty['DomOdchoziTP2'];
$dom_odchozi32 = $dom_odchozi_std32 + $dom_odchozi_tp32;

$dom_odchozi_max32 = $placenych_dom_odch_std32 < $_POST['odch_std'] || $placenych_dom_odch_tp32 < $_POST['odch_tp'] ? $dom_odchozi32 + ((($_POST['odch_std'] - $placenych_dom_odch_std32) + ($_POST['odch_tp'] - $placenych_dom_odch_tp32)) * ($radek_ucty['DomOdchozi2'] - $radek_ucty['DomOdchozi1'])) : $dom_odchozi32;
$dom_odchozi_min32 = $dom_odchozi_max32;

$dom_odchozi_text32 = "- zpoplatněné jednorázové platby ($placenych_dom_odch_std32/".$_POST['odch_std']."): ".number_format($dom_odchozi_std32, 2, '.', '')." $mena<BR>
     - zpoplatněné trvalé příkazy ($placenych_dom_odch_tp32/".$_POST['odch_tp']."): ".number_format($dom_odchozi_tp32, 2, '.', '')." $mena";
     
$dom_trans_text32 = '';
$dom_trans_text32.= "Počítáno s ".($pomer_plateb_v_ramci_banky32 * 100)." % pravděpodobností plateb na cizí účet v Air bank. Za každou nezapočitanou platbu do Air bank <U>- ".$radek_ucty['DomOdchozi2']." $mena</U>";
$dom_trans_text32.= $placenych_dom_odch_std32 < $_POST['odch_std'] || $placenych_dom_odch_tp32 < $_POST['odch_tp'] ? ", za navíc započitanou platbu do Air bank <U>+ ".$radek_ucty['DomOdchozi2']." $mena</U>" : Null;
$dom_trans_text32.= "-0-";


switch($karta)
{
case '1':
$karta_vedeni32 = $radek_ucty['KontaktVedeni1'];
$karta32 = $karta_vedeni32 + ($vybery * $radek_ucty['KontaktVyber2']);

$karta_exc32 = $karta32 - $radek_ucty['KontaktVyber1'];
  
$karta_text32 = '';
$karta_text32.= "- vedení karty: $karta_vedeni32 $mena<BR>
                - zpoplatněné výběry z bankomatu ($vybery/$vybery): ".number_format($karta32 - $karta_vedeni32, 2, '.', '')." $mena-0-";
$karta_text32.= $vybery == 1 ? "-1- <U>jak ušetřit <B>".number_format($karta_exc32, 2, '.', '')." $mena</B></U> - k výběrům hotovosti využívejte bankomatů Air bank-1-" : Null;
$karta_text32.= $vybery > 1 ? "-1- <U>jak ušetřit <B>až ".number_format($karta_exc32, 2, '.', '')." $mena</B></U> - k výběrům hotovosti využívejte bankomatů Air bank-1-" : Null;

$karta_typ32 = 'MasterCard';
break;

default:

$karta32 = 0;
$karta_exc32 = 0;
$karta_text32 = Null;
$karta_typ32 = Null;
}


switch($info)
{
case 'sms':
  $info_trans_test32 = $transakce / 5;
  $info_trans_test32 = $transakce % 5 == 0 ? $transakce / 5 : ceil($transakce / 5);
  
  $info32 = $radek_ucty['SMSpush1'] * $info_trans_test32;
  $info_text32 = "- zadáno celkem $transakce transakcí = cena odpovídá $info_trans_test32 x 5 SMS.-0-";
break;
    
default:
  $info32 = 0;
  $info_text32 = Null;
}


$naklady32 = $vedeni32 + $banking32 + $vypis32 + $dom_prichozi32 + $dom_odchozi_max32 + $karta32 + $info32; 
$naklady_exc32 = $naklady32 - $karta_exc32 - $dom_odchozi_min32;



$sql_detail32 = "UPDATE poplatky_vysledek SET Vedeni = $vedeni32, Banking = $banking32, Vypis = $vypis32, Dom_prichozi = $dom_prichozi32, Dom_odchozi = $dom_odchozi32, Dom_odchozi_text = '$dom_odchozi_text32', Dom_trans_text = '$dom_trans_text32', Karta = $karta32, Karta_text = '$karta_text32', Karta_typ = '$karta_typ32', Info = $info32, Info_text = '$info_text32', NakladyOd = $naklady_exc32, NakladyDo = $naklady32 WHERE ID = 32";
$detail32 = mysql_query($sql_detail32, $id_spojeni);
if (!$detail32)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodařilo se nám poslat SQL dotaz na detail 32.');
} 
//echo 'Dotaz na detail 32 - bezny ucet air bank, maly tarif - odeslán.<br>';

  }


   
elseif($radek_ucty['ID'] == 33)             // bezny ucet air bank - velky tarif - od 05/08/2011
  {
$vedeni33 = $radek_ucty['Vedeni1']; 
$banking33 = $radek_ucty['IB1'];
$vypis33 = $vypis == 'papir' ? $radek_ucty['VypisMesPapir'] : $radek_ucty['VypisMesEl'];
$dom_prichozi33 = $radek_ucty['PrichoziTransakce1'];
$dom_odchozi33 = $radek_ucty['DomOdchozi1'] + $radek_ucty['DomOdchoziTP1'];

switch($karta)
{
case '1':
$karta33 = $radek_ucty['KontaktVedeni1'] + $radek_ucty['KontaktVyber1'];
$karta_text33 = '';
$karta_text33.= $vybery <= 10 ? '...' : Null;  
$karta_text33.= $vybery > 10 ? '-2- <U>na co si dát pozor</U> - pokud nebudete k výběrům využívat bankomatů Air bank, banka přepne účet na Malý tarif.' : Null;    
$karta_typ33 = 'MasterCard';
break;

default:

$karta33 = 0;
$karta_text33 = Null;
$karta_typ33 = Null;
}




switch($info)
{

case 'sms':
  $info33 = $radek_ucty['SMSpush1'];
  $info_text33 = '...';
break;
    
default:
  $info33 = 0;
  $info_text33 = Null;
}


$naklady33 = $vedeni33 + $banking33 + $vypis33 + $dom_prichozi33 + $dom_odchozi33 + $karta33 + $info33; 
$naklady_exc33 = $naklady33;



$sql_detail33 = "UPDATE poplatky_vysledek SET Vedeni = $vedeni33, Banking = $banking33, Vypis = $vypis33, Dom_prichozi = $dom_prichozi33, Dom_odchozi = $dom_odchozi33, Karta = $karta33, Karta_text = '$karta_text33', Karta_typ = '$karta_typ33', Info = $info33, Info_text = '$info_text33', NakladyOd = $naklady_exc33, NakladyDo = $naklady33 WHERE ID = 33";
$detail33 = mysql_query($sql_detail33, $id_spojeni);
if (!$detail33)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodařilo se nám poslat SQL dotaz na detail 33.');
} 
//echo 'Dotaz na detail 33 - bezny ucet air bank, velky tarif - odeslán.<br>';

  }
?>