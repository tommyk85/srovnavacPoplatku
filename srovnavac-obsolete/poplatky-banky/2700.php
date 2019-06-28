<?php 


if($radek_ucty['ID'] == 55)             // konto pro mlade od 01/12/2012
  {

$pomer_plateb_v_ramci_banky55 = round($radek_ucty['klientu'] / $klientu_celkem, 5);
$placenych_dom_odch_std55 = $_POST['odch_std'] - round($_POST['odch_std'] * $pomer_plateb_v_ramci_banky55);
$placenych_dom_odch_tp55 = $_POST['odch_tp'] - round($_POST['odch_tp'] * $pomer_plateb_v_ramci_banky55);  


$vedeni55 = $radek_ucty['Vedeni1']; 

$tb55 = in_array('tb', $banking) ? $radek_ucty['TB'] : number_format(0, 2);
$banking55 = $radek_ucty['IB1'] + $tb55;
$banking_text55 = $tb55 > 0 ? "- pouze za telefonní bankovniství-0-" : Null;

$vypis55 = $vypis == 'elektro' ? $radek_ucty['VypisMesEl'] : 0;

$dom_prichozi55 = $radek_ucty['PrichoziTransakce1'];

$dom_odchozi_std55 = $placenych_dom_odch_std55 * $radek_ucty['DomOdchozi2'];
$dom_odchozi_tp55 = $placenych_dom_odch_tp55 * $radek_ucty['DomOdchoziTP2'];
$dom_odchozi55 = $dom_odchozi_std55 + $dom_odchozi_tp55;

$dom_odchozi_max55 = $placenych_dom_odch_std55 < $_POST['odch_std'] || $placenych_dom_odch_tp55 < $_POST['odch_tp'] ? $dom_odchozi55 + ((($_POST['odch_std'] - $placenych_dom_odch_std55) + ($_POST['odch_tp'] - $placenych_dom_odch_tp55)) * ($radek_ucty['DomOdchozi2'] - $radek_ucty['DomOdchozi1'])) : $dom_odchozi55;
$dom_odchozi_min55 = $dom_odchozi_max55;

$dom_odchozi_text55 = "- zpoplatněné jednorázové platby ($placenych_dom_odch_std55/".$_POST['odch_std']."): ".number_format($dom_odchozi_std55, 2, '.', '')." $mena<BR>
     - zpoplatněné trvalé příkazy ($placenych_dom_odch_tp55/".$_POST['odch_tp']."): ".number_format($dom_odchozi_tp55, 2, '.', '')." $mena";

$dom_trans_text55 = '';     
$dom_trans_text55.= "Počítáno s ".($pomer_plateb_v_ramci_banky55 * 100)." % pravděpodobností plateb na cizí účet v UniCredit Bank. Za každou nezapočitanou odchozí platbu do UniCredit Bank <U>- ".($radek_ucty['DomOdchozi2'] - $radek_ucty['DomOdchozi1'])." $mena</U>";
$dom_trans_text55.= $placenych_dom_odch_std55 < $_POST['odch_std'] || $placenych_dom_odch_tp55 < $_POST['odch_tp'] ? ", za navíc započitanou odchozí platbu do UniCredit Bank <U>+ ".($radek_ucty['DomOdchozi2'] - $radek_ucty['DomOdchozi1'])." $mena</U>" : Null;
$dom_trans_text55.= "<BR>Zadáno celkem $dom_odch_std jednorázových transakcí, které je nutné vždy autorizovat pomocí SMS mobilního bezpečnostího klíče (".$radek_ucty['SMSautorizacePlatby']." $mena za sadu 100 SMS - 1 sada vychází na celé ".floor(100 / $dom_odch_std)." měsíce), nebo bezpečnostího klíče ve formě malé kalkulačky (490.00 CZK jednorázově).";
$dom_trans_text55.= "-0-";



switch($karta)
{
case '1':
$karta_vedeni55 = $radek_ucty['KontaktVedeni1'];
$karta_vybery55 = $vybery > 1 ? $vybery - 1 : 0;
$karta55 = $karta_vedeni55 + ($karta_vybery55 * $radek_ucty['KontaktVyber2']);
$karta_exc55 = $karta55 - ($karta_vybery55 * $radek_ucty['KontaktVyber1']);
$karta_text55 = '';
$karta_text55.= "- vedení karty: ".$radek_ucty['KontaktVedeni1']." $mena<BR>
                - zpoplatněné výběry z bankomatu ($karta_vybery55/$vybery): ".number_format($karta55 - $radek_ucty['KontaktVedeni1'], 2, '.', '')." $mena.-0-";
$karta_text55.= $vybery == 2 ? "-1- <U>jak ušetřit <B> ".number_format($karta_exc55, 2, '.', '')." $mena</B></U> - k výběrům hotovosti využívejte bankomatů UniCredit Bank-1-" : Null;
$karta_text55.= $vybery > 2 ? "-1- <U>jak ušetřit <B>až ".number_format($karta_exc55, 2, '.', '')." $mena</B></U> - k výběrům hotovosti využívejte bankomatů UniCredit Bank-1-" : Null;
  
$karta_typ55 = 'Maestro, Visa Electron';
break;

default:

$karta55 = 0;
$karta_exc55 = 0;
$karta_text55 = Null;
$karta_typ55 = Null;
}


switch($info)
{
case 'mail':
  $info55 = $radek_ucty['EMAILpush'];
  $info_text55 = '...';
  break;
  
case 'sms':
  $trans_plac55 = $transakce > 10 ? $transakce - 10 : 0; 
  $info55 = $radek_ucty['SMSpush1'] * $trans_plac55;
  $info_text55 = "- zadáno celkem $transakce transakcí = cena odpovídá $trans_plac55 SMS (až 10 SMS je v měsíci zdarma).-0-";
break;
    
default:
  $info55 = 0;
  $info_text55 = Null;
}


$naklady55 = $vedeni55 + $banking55 + $vypis55 + $dom_prichozi55 + $dom_odchozi_max55 + $karta55 + $info55;  
$naklady_exc55 = $naklady55 - $dom_odchozi_min55 - $karta_exc55;



$sql_detail55 = "UPDATE poplatky_vysledek SET Vedeni = $vedeni55, Banking = $banking55, Banking_text = '$banking_text55', Vypis = $vypis55, Dom_prichozi = $dom_prichozi55, Dom_odchozi = $dom_odchozi55, Dom_odchozi_text = '$dom_odchozi_text55', Dom_trans_text = '$dom_trans_text55', Karta = $karta55, Karta_text = '$karta_text55', Karta_typ = '$karta_typ55', Info = $info55, Info_text = '$info_text55', NakladyOd = $naklady_exc55, NakladyDo = $naklady55 WHERE ID = 55";
$detail55 = mysql_query($sql_detail55, $id_spojeni);
if (!$detail55)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodařilo se nám poslat SQL dotaz na detail 55.');
} 
//echo 'Dotaz na detail 55 - unicredit, konto pro mlade - odeslán.<br>';

  }


   
elseif($radek_ucty['ID'] == 57)             // expresni konto od 01/12/2012
  {
$aktivni_konto = $prichozi > 0 && $dom_odch_std + $dom_odch_tp > 0 && $karta_celkem > 0 ? true : false;

$vedeni57 = $aktivni_konto && ($obrat >= 15000 || $zustatek >= 50000) ? $radek_ucty['Vedeni2'] : $radek_ucty['Vedeni1'];
$vedeni_max57 = $radek_ucty['Vedeni1'];
$vedeni_min57 = $vedeni57 == $vedeni_max57 ? 0 : $vedeni_max57;
$vedeni_text57 = $vedeni57 == $radek_ucty['Vedeni2'] ? "-2- <U>na co si dát pozor</U> - první transakce kartou musí být provedena vždy do 20. dne v měsíci, jinak vedení účtu <B><U>+ ".$radek_ucty['Vedeni1']." $mena</U></B>" : Null;
  
$tb57 = in_array('tb', $banking) ? $radek_ucty['TB'] : number_format(0, 2);
$banking57 = $radek_ucty['IB1'] + $tb57;
$banking_text57 = $tb57 > 0 ? "- pouze za telefonní bankovniství-0-" : Null;

$vypis57 = $vypis == 'elektro' ? $radek_ucty['VypisMesEl'] : 0;


$pomer_plateb_v_ramci_banky57 = round($radek_ucty['klientu'] / $klientu_celkem, 5);
$placenych_dom_prich57 = $_POST['kod_banky'] == '2700' ? 0 : $_POST['prichozi'] - round($_POST['prichozi'] * $pomer_plateb_v_ramci_banky57);
$placenych_dom_odch_std57 = $_POST['odch_std'] - round($_POST['odch_std'] * $pomer_plateb_v_ramci_banky57);
$placenych_dom_odch_tp57 = $_POST['odch_tp'] - round($_POST['odch_tp'] * $pomer_plateb_v_ramci_banky57); 

$dom_prichozi57 = $placenych_dom_prich57 * $radek_ucty['PrichoziTransakce2'];

$dom_prichozi_max57 = $placenych_dom_prich57 < $_POST['prichozi'] ? $dom_prichozi57 + (($_POST['prichozi'] - $placenych_dom_prich57) * ($radek_ucty['PrichoziTransakce2'] - $radek_ucty['PrichoziTransakce1'])) : $dom_prichozi57;
$dom_prichozi_min57 = $dom_prichozi_max57;

$dom_prichozi_text57 = "- zpoplatněné příchozí platby ($placenych_dom_prich57/".$_POST['prichozi'].")";

$dom_odchozi_std57 = $placenych_dom_odch_std57 * $radek_ucty['DomOdchozi2'];
$dom_odchozi_tp57 = $placenych_dom_odch_tp57 * $radek_ucty['DomOdchoziTP2'];
$dom_odchozi57 = $dom_odchozi_std57 + $dom_odchozi_tp57;

$dom_odchozi_max57 = $placenych_dom_odch_std57 < $_POST['odch_std'] || $placenych_dom_odch_tp57 < $_POST['odch_tp'] ? $dom_odchozi57 + ((($_POST['odch_std'] - $placenych_dom_odch_std57) + ($_POST['odch_tp'] - $placenych_dom_odch_tp57)) * ($radek_ucty['DomOdchozi2'] - $radek_ucty['DomOdchozi1'])) : $dom_odchozi57;
$dom_odchozi_min57 = $dom_odchozi_max57;

$dom_odchozi_text57 = "- zpoplatněné jednorázové platby ($placenych_dom_odch_std57/".$_POST['odch_std']."): ".number_format($dom_odchozi_std57, 2, '.', '')." $mena<BR>
     - zpoplatněné trvalé příkazy ($placenych_dom_odch_tp57/".$_POST['odch_tp']."): ".number_format($dom_odchozi_tp57, 2, '.', '')." $mena";
     
$dom_trans_text57 = '';
$dom_trans_text57 = "Počítáno s ".($pomer_plateb_v_ramci_banky57 * 100)." % pravděpodobností plateb z/na cizí účet v UniCredit Bank.";
$dom_trans_text57.= ($_POST['kod_banky'] == 'ruzne' || $_POST['kod_banky'] == 'none') && $placenych_dom_prich57 == $_POST['prichozi'] ? "Za každou nezapočitanou příchozí platbu z UniCredit Bank <U>- ".$radek_ucty['PrichoziTransakce2']." $mena</U>. " : Null;
$dom_trans_text57.= ($_POST['kod_banky'] == 'ruzne' || $_POST['kod_banky'] == 'none')&& $placenych_dom_prich57 < $_POST['prichozi'] ? "Za každou nezapočitanou příchozí platbu z UniCredit Bank <U>- ".$radek_ucty['PrichoziTransakce2']." $mena</U>, za každou navíc započitanou příchozí platbu z UniCredit Bank <U>+ ".$radek_ucty['PrichoziTransakce2']." $mena</U>. " : Null;
$dom_trans_text57.= " Za každou nezapočitanou odchozí platbu do UniCredit Bank <U>- ".number_format($radek_ucty['DomOdchozi2'] - $radek_ucty['DomOdchozi1'], 2, '.', '')." $mena</U>";
$dom_trans_text57.= $placenych_dom_odch_std57 < $_POST['odch_std'] || $placenych_dom_odch_tp57 < $_POST['odch_tp'] ? ", za navíc započitanou odchozí platbu do UniCredit Bank <U>+ ".number_format($radek_ucty['DomOdchozi2'] - $radek_ucty['DomOdchozi1'], 2, '.', '')." $mena</U>" : Null;
$dom_trans_text57.= "<BR>Zadáno celkem $dom_odch_std jednorázových transakcí, které je nutné vždy autorizovat pomocí SMS mobilního bezpečnostího klíče (".$radek_ucty['SMSautorizacePlatby']." $mena za sadu 100 SMS - 1 sada vychází na celé ".floor(100 / $dom_odch_std)." měsíce), nebo bezpečnostího klíče ve formě malé kalkulačky (490.00 CZK jednorázově).";
$dom_trans_text57.= "-0-";

switch($karta)
{
case '1':
$karta57 = $radek_ucty['KontaktVedeni1'] + ($vybery * $radek_ucty['KontaktVyber2']);
$karta_exc57 = $karta57 - ($vybery * $radek_ucty['KontaktVyber1']);
$karta_text57 = '';
$karta_text57.= "- vedení karty: ".$radek_ucty['KontaktVedeni1']." $mena<BR>
                - zpoplatněné výběry z bankomatu ($vybery/$vybery): ".number_format($karta57 - $radek_ucty['KontaktVedeni1'], 2, '.', '')." $mena-0-";
$karta_text57.= $vybery == 1 ? "-1- <U>jak ušetřit <B>".number_format($karta_exc57, 2, '.', '')." $mena</B></U> - k výběrům hotovosti využívejte bankomatů UniCredit Bank-1-" : Null;
$karta_text57.= $vybery > 1 ? "-1- <U>jak ušetřit <B>až ".number_format($karta_exc57, 2, '.', '')." $mena</B></U> - k výběrům hotovosti využívejte bankomatů UniCredit Bank-1-" : Null;
  
$karta_typ57 = 'Visa (Karta Expres)';
break;

default:

$karta57 = 0;
$karta_exc57 = 0;
$karta_text57 = Null;
$karta_typ57 = Null;
}



switch($info)
{
case 'mail':
  $info57 = $radek_ucty['EMAILpush'];
  $info_text57 = '...';
  break;
  
case 'sms':
  $info57 = $radek_ucty['SMSpush1'] * $transakce;
  $info_text57 = "- zadáno celkem $transakce transakcí = cena odpovídá $transakce SMS.-0-";
break;
    
default:
  $info57 = 0;
  $info_text57 = Null;
}


$naklady57 = $vedeni_max57 + $banking57 + $vypis57 + $dom_prichozi_max57 + $dom_odchozi_max57 + $karta57 + $info57;
$naklady_exc57 = $naklady57 - $vedeni_min57 - $dom_prichozi_min57 - $dom_odchozi_min57 - $karta_exc57;



$sql_detail57 = "UPDATE poplatky_vysledek SET Vedeni = $vedeni57, Vedeni_text = '$vedeni_text57', Banking = $banking57, Banking_text = '$banking_text57', Vypis = $vypis57, Dom_prichozi = $dom_prichozi57, Dom_prichozi_text = '$dom_prichozi_text57', Dom_odchozi = $dom_odchozi57, Dom_odchozi_text = '$dom_odchozi_text57', Dom_trans_text = '$dom_trans_text57', Karta = $karta57, Karta_text = '$karta_text57', Karta_typ = '$karta_typ57', Info = $info57, Info_text = '$info_text57', NakladyOd = $naklady_exc57, NakladyDo = $naklady57 WHERE ID = 57";
$detail57 = mysql_query($sql_detail57, $id_spojeni);
if (!$detail57)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodařilo se nám poslat SQL dotaz na detail 57.');
} 
//echo 'Dotaz na detail 57 - unicredit, expresni konto - odeslán.<br>';

  }
  


  
elseif($radek_ucty['ID'] == 59)             // aktivni konto - od 01/12/2012
  {
$aktivni_konto = $prichozi > 0 && $dom_odch_std + $dom_odch_tp > 0 && $karta_celkem > 0 ? true : false;

$vedeni59 = $aktivni_konto && ($obrat >= 20000 || $zustatek >= 100000) ? $radek_ucty['Vedeni2'] : $radek_ucty['Vedeni1'];
$vedeni_max59 = $radek_ucty['Vedeni1'];
$vedeni_min59 = $vedeni59 == $vedeni_max59 ? 0 : $vedeni_max59;
$vedeni_text59 = $vedeni59 == $radek_ucty['Vedeni2'] ? "-2- <U>na co si dát pozor</U> - první transakce debetní kartou musí být provedena vždy do 20. dne v měsíci, jinak vedení účtu <B><U>+ ".$radek_ucty['Vedeni1']." $mena</U></B>" : Null;

$tb59 = in_array('tb', $banking) ? $radek_ucty['TB'] : number_format(0, 2);
$banking59 = $radek_ucty['IB1'] + $tb59;
$banking_text59 = $tb59 > 0 ? "- pouze za telefonní bankovniství-0-" : Null;

$vypis59 = $vypis == 'elektro' ? $radek_ucty['VypisMesEl'] : 0;

$pomer_plateb_v_ramci_banky59 = round($radek_ucty['klientu'] / $klientu_celkem, 5);
$placenych_dom_prich59 = $_POST['kod_banky'] == '2700' ? 0 : $_POST['prichozi'] - round($_POST['prichozi'] * $pomer_plateb_v_ramci_banky59);
$placenych_dom_odch_std59 = $_POST['odch_std'] - round($_POST['odch_std'] * $pomer_plateb_v_ramci_banky59);

$placenych_transakci59 = $placenych_dom_prich59 + $placenych_dom_odch_std59 <= 10 ? 0 : ($placenych_dom_prich59 + $placenych_dom_odch_std59) - 10;

if($placenych_transakci59 == 0)
{
$dom_prichozi59 = 0;
$dom_odchozi59 = 0;
$dom_trans_celkem59 = 0;
$dom_prichozi_zdarma59 = 0;
$dom_odchozi_zdarma59 = 0;
}

else
{
$dom_trans_test59['odch'] = $placenych_dom_odch_std59 * $radek_ucty['DomOdchozi2'];
$dom_trans_test59['prich'] = $placenych_dom_prich59 * $radek_ucty['PrichoziTransakce2'];

//$dom_trans_test59['odch'] = $_POST['odch_std'] <= 10 ? 0 : ($_POST['odch_std'] - 10) * $radek_ucty['DomOdchozi2'];
//$dom_trans_test59['prich'] = $_POST['prichozi'] <= 10 ? 0 : ($_POST['prichozi'] - 10) * $radek_ucty['PrichoziTransakce2'];


  switch (array_search(max($dom_trans_test59), $dom_trans_test59))
  {
  case 'odch':
  $dom_odchozi59 = $placenych_dom_odch_std59 > 10 ? ($placenych_dom_odch_std59 - 10) * $radek_ucty['DomOdchozi2'] : 0;
  $dom_odchozi_zdarma59 = $placenych_dom_odch_std59 >= 10 ? 10 : (10 - $placenych_dom_odch_std59);
  $dom_prichozi59 = $dom_odchozi59 == 0 && $placenych_dom_prich59 >= (10 - $placenych_dom_odch_std59) ? ($placenych_dom_prich59 - (10 - $placenych_dom_odch_std59)) * $radek_ucty['PrichoziTransakce2'] : $placenych_dom_prich59 * $radek_ucty['PrichoziTransakce2'];
  $dom_prichozi_zdarma59 = $dom_odchozi_zdarma59 == 10 ? 0 : ($placenych_dom_prich59 - $dom_odchozi_zdarma59);
  break;
  
  case 'prich':
  $dom_prichozi59 = $placenych_dom_prich59 > 10 ? ($placenych_dom_prich59 - 10) * $radek_ucty['PrichoziTransakce2'] : 0;
  $dom_prichozi_zdarma59 = $placenych_dom_prich59 >= 10 ? 10 : (10 - $placenych_dom_prich59);
  $dom_odchozi59 = $dom_prichozi59 == 0 && $placenych_dom_odch_std59 >= (10 - $placenych_dom_prich59) ? ($placenych_dom_odch_std59 - (10 - $placenych_dom_prich59)) * $radek_ucty['DomOdchozi2'] : $placenych_dom_odch_std59 * $radek_ucty['DomOdchozi2'];
  $dom_odchozi_zdarma59 = $dom_prichozi_zdarma59 == 10 ? 0 : ($placenych_dom_odch_std59 - $dom_prichozi_zdarma59);
  break;
  
  default:
  $dom_prichozi59 = 0;
  $dom_prichozi_zdarma59 = 0;
  $dom_odchozi59 = 0;
  $dom_odchozi_zdarma59 = 0;
  }

}


$dom_prichozi_max59 = $placenych_dom_prich59 < $_POST['prichozi'] ? $dom_prichozi59 + (($_POST['prichozi'] - $placenych_dom_prich59) * ($radek_ucty['PrichoziTransakce2'] - $radek_ucty['PrichoziTransakce1'])) : $dom_prichozi59;
$dom_prichozi_min59 = $dom_prichozi_max59;

$dom_prichozi_text59 = "- zpoplatněné příchozí platby (".($placenych_dom_prich59 - $dom_prichozi_zdarma59)."/".$_POST['prichozi'].")";

$dom_odchozi_max59 = $placenych_dom_odch_std59 < $_POST['odch_std'] ? $dom_odchozi59 + (($_POST['odch_std'] - $placenych_dom_odch_std59) * ($radek_ucty['DomOdchozi2'] - $radek_ucty['DomOdchozi1'])) : $dom_odchozi59;
$dom_odchozi_min59 = $dom_odchozi_max59;

$dom_odchozi_text59 = "- zpoplatněné jednorázové platby (".($placenych_dom_odch_std59 - $dom_odchozi_zdarma59)."/".$_POST['odch_std']."): ".number_format($dom_odchozi59, 2, '.', '')." $mena<BR>
     - zpoplatněné trvalé příkazy (0/".$_POST['odch_tp']."): ".number_format(0, 2)." $mena";

$dom_trans_text59 = '';
$dom_trans_text59.= "Počítáno s ".($pomer_plateb_v_ramci_banky59 * 100)." % pravděpodobností plateb z/na cizí účet v UniCredit Bank. ";
$dom_trans_text59.= ($_POST['kod_banky'] == 'ruzne' || $_POST['kod_banky'] == 'none') && $placenych_dom_prich59 == $_POST['prichozi'] ? "Za každou nezapočitanou příchozí platbu z UniCredit Bank <U>- ".$radek_ucty['PrichoziTransakce2']." $mena</U>. " : Null;
$dom_trans_text59.= ($_POST['kod_banky'] == 'ruzne' || $_POST['kod_banky'] == 'none') && $placenych_dom_prich59 < $_POST['prichozi'] ? "Za každou nezapočitanou příchozí platbu z UniCredit Bank <U>- ".$radek_ucty['PrichoziTransakce2']." $mena</U>, za každou navíc započitanou příchozí platbu z UniCredit Bank <U>+ ".$radek_ucty['PrichoziTransakce2']." $mena</U>, maximálně ale + ".(($_POST['prichozi'] - $placenych_dom_prich59) * $radek_ucty['PrichoziTransakce2'])." $mena. " : Null;
$dom_trans_text59.= " Za každou nezapočitanou jednorázovou platbu do UniCredit Bank <U>- ".($radek_ucty['DomOdchozi2'] - $radek_ucty['DomOdchozi1'])." $mena</U>";
$dom_trans_text59.= $placenych_dom_odch_std59 < $_POST['odch_std'] ? ", za navíc započitanou jednorázovou platbu do UniCredit Bank <U>+ ".($radek_ucty['DomOdchozi2'] - $radek_ucty['DomOdchozi1'])." $mena</U>, maximálně ale + ".(($_POST['odch_std'] - $placenych_dom_odch_std59) * ($radek_ucty['DomOdchozi2'] - $radek_ucty['DomOdchozi1']))." $mena" : Null;
$dom_trans_text59.= "<BR>Zadáno celkem $dom_odch_std jednorázových transakcí, které je nutné vždy autorizovat pomocí SMS mobilního bezpečnostího klíče (".$radek_ucty['SMSautorizacePlatby']." $mena za sadu 100 SMS - 1 sada vychází na celé ".floor(100 / $dom_odch_std)." měsíce), nebo bezpečnostího klíče ve formě malé kalkulačky (490.00 CZK jednorázově).";
$dom_trans_text59.= "<BR>Na celkové výši poplatku za odchozí i příchozí transakce záleží na pořadí zaúčtování transakcí (* pouze domněnka, banka v sazebníku uvádí pouze celkem 10 transakcí zdarma, ale blíže nespecifikuje)";
$dom_trans_text59.= "-0-";


switch($karta)
{
case '1':
$karta_vedeni59 = $radek_ucty['KontaktVedeni1'];
$karta_vybery59 = $vybery > 1 ? $vybery - 1 : 0;
$karta59 = $karta_vedeni59 + ($karta_vybery59 * $radek_ucty['KontaktVyber2']);
$karta_exc59 = $karta59 - ($karta_vybery59 * $radek_ucty['KontaktVyber1']);
$karta_text59 = '';
$karta_text59.= "- vedení karty: ".$radek_ucty['KontaktVedeni1']." $mena<BR>
                - zpoplatněné výběry z bankomatu ($karta_vybery59/$vybery): ".number_format($karta59 - $radek_ucty['KontaktVedeni1'], 2, '.', '')." $mena-0-";
$karta_text59.= $vybery == 2 ? "-1- <U>jak ušetřit <B>".number_format($karta_exc59, 2, '.', '')." $mena</B></U> - k výběrům hotovosti využívejte bankomatů UniCredit Bank-1-" : Null;
$karta_text59.= $vybery > 2 ? "-1- <U>jak ušetřit <B>až ".number_format($karta_exc59, 2, '.', '')." $mena</B></U> - k výběrům hotovosti využívejte bankomatů UniCredit Bank-1-" : Null;
  
$karta_typ59 = 'Visa Basic';
break;

default:

$karta59 = 0;
$karta_exc59 = 0;
$karta_text59 = Null;
$karta_typ59 = Null;

}



switch($info)
{
case 'mail':
  $info59 = $radek_ucty['EMAILpush'];
  $info_text59 = '...';
  break;
  
case 'sms':
  $info59 = $radek_ucty['SMSpush1'] * $transakce;
  $info_text59 = "- zadáno celkem $transakce transakcí = cena odpovídá $transakce SMS.-0-";
break;
    
default:
  $info59 = 0;
  $info_text59 = Null;
}


$naklady59 = $vedeni_max59 + $banking59 + $vypis59 + $dom_prichozi_max59 + $dom_odchozi_max59 + $karta59 + $info59; 
$naklady_exc59 = $naklady59 - $vedeni_min59 - $dom_prichozi_min59 - $dom_odchozi_min59 - $karta_exc59;



$sql_detail59 = "UPDATE poplatky_vysledek SET Vedeni = $vedeni59, Vedeni_text = '$vedeni_text59', Banking = $banking59, Banking_text = '$banking_text59', Vypis = $vypis59, Dom_prichozi = $dom_prichozi59, Dom_prichozi_text = '$dom_prichozi_text59', Dom_odchozi = $dom_odchozi59, Dom_odchozi_text = '$dom_odchozi_text59', Dom_trans_text = '$dom_trans_text59', Karta = $karta59, Karta_text = '$karta_text59', Karta_typ = '$karta_typ59', Info = $info59, Info_text = '$info_text59', NakladyOd = $naklady_exc59, NakladyDo = $naklady59 WHERE ID = 59";
$detail59 = mysql_query($sql_detail59, $id_spojeni);
if (!$detail59)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodařilo se nám poslat SQL dotaz na detail 59.');
} 
//echo 'Dotaz na detail 59 - unicredit, aktivni konto - odeslán.<br>';

  }
  
  
  

elseif($radek_ucty['ID'] == 61)             // perfektni konto od 01/12/2012
  {
$aktivni_konto = $prichozi > 0 && $dom_odch_std + $dom_odch_tp > 0 && $karta_celkem > 0 ? true : false;

$vedeni61 = $aktivni_konto && ($obrat >= 50000 || $zustatek >= 150000) ? $radek_ucty['Vedeni2'] : $radek_ucty['Vedeni1'];
$vedeni_max61 = $radek_ucty['Vedeni1'];
$vedeni_min61 = $vedeni61 == $vedeni_max61 ? 0 : $vedeni_max61;
$vedeni_text61 = $vedeni61 == $radek_ucty['Vedeni2'] ? "-2- <U>na co si dát pozor</U> - první transakce debetní kartou musí být provedena vždy do 20. dne v měsíci, jinak vedení účtu <B><U>+ ".$radek_ucty['Vedeni1']." $mena</U></B>" : Null;

$tb61 = in_array('tb', $banking) ? $radek_ucty['TB'] : number_format(0, 2);
$banking61 = $radek_ucty['IB1'] + $tb61;
$banking_text61 = $tb61 > 0 ? "- pouze za telefonní bankovniství-0-" : Null;
                              
$vypis61 = $vypis == 'elektro' ? $radek_ucty['VypisMesEl'] : 0;

$dom_prichozi61 = $radek_ucty['PrichoziTransakce1'];

$dom_odchozi61 = $radek_ucty['DomOdchozi1'];



switch($karta)
{
case '1':
$karta_vedeni61 = $radek_ucty['KontaktVedeni1'];
$karta_vybery61 = $vybery > 1 ? $vybery - 1 : 0;
$karta61 = $karta_vedeni61 + ($karta_vybery61 * $radek_ucty['KontaktVyber2']);
$karta_exc61 = $karta61 - ($karta_vybery61 * $radek_ucty['KontaktVyber1']);
$karta_text61 = '';
$karta_text61.= "- vedení karty: ".$radek_ucty['KontaktVedeni1']." $mena<BR>
                - zpoplatněné výběry z bankomatu ($karta_vybery61/$vybery): ".number_format($karta61 - $radek_ucty['KontaktVedeni1'], 2, '.', '')." $mena-0-";
$karta_text61.= $vybery == 2 ? "-1- <U>jak ušetřit <B> ".number_format($karta_exc61, 2, '.', '')." $mena</B></U> - k výběrům hotovosti využívejte bankomatů UniCredit Bank-1-" : Null;
$karta_text61.= $vybery > 2 ? "-1- <U>jak ušetřit <B>až ".number_format($karta_exc61, 2, '.', '')." $mena</B></U> - k výběrům hotovosti využívejte bankomatů UniCredit Bank-1-" : Null;
  
$karta_typ61 = 'MasterCard Standard, Visa Classic';
break;

default:

$karta61 = 0;
$karta_exc61 = 0;
$karta_text61 = Null;
$karta_typ61 = Null;
}


switch($info)
{
case 'mail':
  $info61 = $radek_ucty['EMAILpush'];
  $info_text61 = '...';
  break;
  
case 'sms':
  $trans_plac61 = $transakce > 15 ? $transakce - 15 : 0;
  $info61 = $radek_ucty['SMSpush1'] * $trans_plac61;
  $info_text61 = "- zadáno celkem $transakce transakcí = cena odpovídá $trans_plac61 SMS (až 15 SMS je v měsíci zdarma).-0-";
break;
    
default:
  $info61 = 0;
  $info_text61 = Null;
}


$naklady61 = $vedeni_max61 + $banking61 + $vypis61 + $dom_prichozi61 + $dom_odchozi61 + $karta61 + $info61;  
$naklady_exc61 = $naklady61 - $vedeni_min61 - $karta_exc61;



$sql_detail61 = "UPDATE poplatky_vysledek SET Vedeni = $vedeni61, Vedeni_text = '$vedeni_text61', Banking = $banking61, Banking_text = '$banking_text61', Vypis = $vypis61, Dom_prichozi = $dom_prichozi61, Dom_odchozi = $dom_odchozi61, Karta = $karta61, Karta_text = '$karta_text61', Karta_typ = '$karta_typ61', Info = $info61, Info_text = '$info_text61', NakladyOd = $naklady_exc61, NakladyDo = $naklady61 WHERE ID = 61";
$detail61 = mysql_query($sql_detail61, $id_spojeni);
if (!$detail61)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodařilo se nám poslat SQL dotaz na detail 61.');
} 
//echo 'Dotaz na detail 61 - unicredit, perfektni konto - odeslán.<br>';

  }


   
elseif($radek_ucty['ID'] == 63)             // konto premium od 01/12/2012
  {
$aktivni_konto = $prichozi > 0 && $dom_odch_std + $dom_odch_tp > 0 && $karta_celkem > 0 ? true : false;

$vedeni63 = $aktivni_konto && ($obrat >= 75000 || $prostredky >= 1000000) ? $radek_ucty['Vedeni2'] : $radek_ucty['Vedeni1'];
$vedeni_max63 = $radek_ucty['Vedeni1'];
$vedeni_min63 = $vedeni63 == $vedeni_max63 ? 0 : $vedeni_max63;
$vedeni_text63 = '';
//$vedeni_text63.= $aktivni_konto && $vedeni63 == $radek_ucty['Vedeni1'] ? "- pokud bude celkový objem uložených vkladů u UniCredit Bank alespoň 1000000.00 $mena, pak vedení konta <U>- ".$radek_ucty['Vedeni1']." $mena</U>-0-" : Null;
$vedeni_text63.= $vedeni63 == $radek_ucty['Vedeni2'] ? "-2- <U>na co si dát pozor</U> - první transakce debetní kartou musí být provedena vždy do 20. dne v měsíci, jinak vedení účtu <B><U>+ ".$radek_ucty['Vedeni1']." $mena</U></B>" : Null;


$tb63 = in_array('tb', $banking) ? $radek_ucty['TB'] : number_format(0, 2);
$banking63 = $radek_ucty['IB1'] + $tb63;
$banking_text63 = $tb63 > 0 ? "- pouze za telefonní bankovniství-0-" : Null;
$vypis63 = $vypis == 'papir' ? $radek_ucty['VypisMesPapir'] : $radek_ucty['VypisMesEl'];

$dom_prichozi63 = $radek_ucty['PrichoziTransakce1'];

$dom_odchozi63 = $radek_ucty['DomOdchozi1'];



switch($karta)
{
case '1':
$karta_vedeni63 = $radek_ucty['KontaktVedeni1'];
$karta_vybery63 = $vybery > 4 ? $vybery - 4 : 0;
$karta63 = $karta_vedeni63 + ($karta_vybery63 * $radek_ucty['KontaktVyber2']);
$karta_exc63 = $karta63 - ($karta_vybery63 * $radek_ucty['KontaktVyber1']);
$karta_text63 = '';
$karta_text63.= "- vedení karty: ".$radek_ucty['KontaktVedeni1']." $mena<BR>
                - zpoplatněné výběry z bankomatu ($karta_vybery63/$vybery): ".number_format($karta63 - $radek_ucty['KontaktVedeni1'], 2, '.', '')." $mena-0-";
$karta_text63.= $vybery == 5 ? "-1- <U>jak ušetřit <B> ".number_format($karta_exc63, 2, '.', '')." $mena</B></U> - k výběrům hotovosti využívejte bankomatů UniCredit Bank-1-" : Null;
$karta_text63.= $vybery > 5 ? "-1- <U>jak ušetřit <B>až ".number_format($karta_exc63, 2, '.', '')." $mena</B></U> - k výběrům hotovosti využívejte bankomatů UniCredit Bank-1-" : Null;
  
$karta_typ63 = 'MasterCard Standard, Visa Classic';
break;

default:

$karta63 = 0;
$karta_exc63 = 0;
$karta_text63 = Null;
$karta_typ63 = Null;
}


switch($info)
{
case 'mail':
  $info63 = $radek_ucty['EMAILpush'];
  $info_text63 = '...';
  break;
  
case 'sms':
  $trans_plac63 = $transakce > 25 ? $transakce - 25 : 0;
  $info63 = $radek_ucty['SMSpush1'] * $trans_plac63;
  $info_text63 = "- zadáno celkem $transakce transakcí = cena odpovídá $trans_plac63 SMS (až 25 SMS je v měsíci zdarma).-0-";
break;
    
default:
  $info63 = 0;
  $info_text63 = Null;
}


$naklady63 = $vedeni_max63 + $banking63 + $vypis63 + $dom_prichozi63 + $dom_odchozi63 + $karta63 + $info63;
$naklady_exc63 = $naklady63 - $vedeni_min63 - $karta_exc63;



$sql_detail63 = "UPDATE poplatky_vysledek SET Vedeni = $vedeni63, Vedeni_text = '$vedeni_text63', Banking = $banking63, Banking_text = '$banking_text63', Vypis = $vypis63, Dom_prichozi = $dom_prichozi63, Dom_odchozi = $dom_odchozi63, Karta = $karta63, Karta_text = '$karta_text63', Karta_typ = '$karta_typ63', Info = $info63, Info_text = '$info_text63', NakladyOd = $naklady_exc63, NakladyDo = $naklady63 WHERE ID = 63";
$detail63 = mysql_query($sql_detail63, $id_spojeni);
if (!$detail63)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodařilo se nám poslat SQL dotaz na detail 63.');
} 
//echo 'Dotaz na detail 63 - unicredit, konto premium - odeslán.<br>';

  }
  


  
elseif($radek_ucty['ID'] == 65)             // bezny ucet unicredit - od 01/12/2012
  {
$mb65 = in_array('mb', $banking) ? $radek_ucty['MB1'] : number_format(0, 2);
$tb65 = in_array('tb', $banking) ? $radek_ucty['TB'] : number_format(0, 2);

$vedeni65 = $radek_ucty['Vedeni1']; 
$banking65 = $radek_ucty['IB1'] + $tb65 + $mb65;
$banking_text65 = '';
$banking_text65.= $mb65 > 0 || $tb65 > 0 ? "- internetové bankovnictví: ".$radek_ucty['IB1']." $mena" : "- pouze za       internetové bankovnictví";
$banking_text65.= $mb65 > 0 ? "<BR>- mobilní (smart) banking: $mb65 $mena" : Null;
$banking_text65.= $tb65 > 0 ? "<BR>- telefonní bankovnictví: $tb65 $mena" : Null;
$banking_text65.= "-0-";

$vypis65 = $vypis == 'papir' ? $radek_ucty['VypisMesPapir'] : $radek_ucty['VypisMesEl'];

$pomer_plateb_v_ramci_banky65 = round($radek_ucty['klientu'] / $klientu_celkem, 5);
$placenych_dom_prich65 = $_POST['kod_banky'] == '2700' ? 0 : $_POST['prichozi'] - round($_POST['prichozi'] * $pomer_plateb_v_ramci_banky65);
$placenych_dom_odch_std65 = $_POST['odch_std'] - round($_POST['odch_std'] * $pomer_plateb_v_ramci_banky65);
$placenych_dom_odch_tp65 = $_POST['odch_tp'] - round($_POST['odch_tp'] * $pomer_plateb_v_ramci_banky65); 

$dom_prichozi65 = $placenych_dom_prich65 * $radek_ucty['PrichoziTransakce2'];

$dom_prichozi_max65 = $placenych_dom_prich65 < $_POST['prichozi'] ? $dom_prichozi65 + (($_POST['prichozi'] - $placenych_dom_prich65) * ($radek_ucty['PrichoziTransakce2'] - $radek_ucty['PrichoziTransakce1'])) : $dom_prichozi65;
$dom_prichozi_min65 = $dom_prichozi_max65;

$dom_prichozi_text65 = "- zpoplatněné příchozí platby ($placenych_dom_prich65/".$_POST['prichozi'].")";

$dom_odchozi_std65 = $placenych_dom_odch_std65 * $radek_ucty['DomOdchozi2'];
$dom_odchozi_tp65 = $placenych_dom_odch_tp65 * $radek_ucty['DomOdchoziTP2'];
$dom_odchozi65 = $dom_odchozi_std65 + $dom_odchozi_tp65;

$dom_odchozi_max65 = $placenych_dom_odch_std65 < $_POST['odch_std'] || $placenych_dom_odch_tp65 < $_POST['odch_tp'] ? $dom_odchozi65 + ((($_POST['odch_std'] - $placenych_dom_odch_std65) + ($_POST['odch_tp'] - $placenych_dom_odch_tp65)) * ($radek_ucty['DomOdchozi2'] - $radek_ucty['DomOdchozi1'])) : $dom_odchozi65;
$dom_odchozi_min65 = $dom_odchozi_max65;

$dom_odchozi_text65 = "- zpoplatněné jednorázové platby ($placenych_dom_odch_std65/".$_POST['odch_std']."): ".number_format($dom_odchozi_std65, 2, '.', '')." $mena<BR>
     - zpoplatněné trvalé příkazy ($placenych_dom_odch_tp65/".$_POST['odch_tp']."): ".number_format($dom_odchozi_tp65, 2, '.', '')." $mena";

$dom_trans_text65 = '';     
$dom_trans_text65.= "Počítáno s ".($pomer_plateb_v_ramci_banky65 * 100)." % pravděpodobností plateb z/na cizí účet v UniCredit Bank. ";
$dom_trans_text65.= ($_POST['kod_banky'] == 'ruzne' || $_POST['kod_banky'] == 'none') && $placenych_dom_prich65 == $_POST['prichozi'] ? "Za každou nezapočitanou příchozí platbu z UniCredit Bank <U>- ".$radek_ucty['PrichoziTransakce2']." $mena</U>. " : Null;
$dom_trans_text65.= ($_POST['kod_banky'] == 'ruzne' || $_POST['kod_banky'] == 'none') && $placenych_dom_prich65 < $_POST['prichozi'] ? "Za každou nezapočitanou příchozí platbu z UniCredit Bank <U>- ".$radek_ucty['PrichoziTransakce2']." $mena</U>, za každou navíc započitanou příchozí platbu z UniCredit Bank <U>+ ".$radek_ucty['PrichoziTransakce2']." $mena</U>. " : Null;
$dom_trans_text65.= "Za každou nezapočitanou odchozí platbu do UniCredit Bank <U>- ".number_format($radek_ucty['DomOdchozi2'] - $radek_ucty['DomOdchozi1'], 2, '.', '')." $mena</U>";
$dom_trans_text65.= $placenych_dom_odch_std65 < $_POST['odch_std'] || $placenych_dom_odch_tp65 < $_POST['odch_tp'] ? ", za každou navíc započitanou odchozí platbu do UniCredit Bank <U>+ ".number_format($radek_ucty['DomOdchozi2'] - $radek_ucty['DomOdchozi1'], 2, '.', '')." $mena</U>" : Null;
$dom_trans_text65.= "<BR>Zadáno celkem $dom_odch_std jednorázových transakcí, které je nutné vždy autorizovat pomocí SMS mobilního bezpečnostího klíče (".$radek_ucty['SMSautorizacePlatby']." $mena za sadu 100 SMS - 1 sada vychází na celé ".floor(100 / $dom_odch_std)." měsíce), nebo bezpečnostího klíče ve formě malé kalkulačky (490.00 CZK jednorázově).";
$dom_trans_text65.= "-0-";

switch($karta)
{
case '1':
$karta_vedeni65 = $radek_ucty['KontaktVedeni1'] / 12;
$karta_vybery65 = $vybery;
$karta65 = $karta_vedeni65 + ($karta_vybery65 * $radek_ucty['KontaktVyber2']);
$karta_exc65 = $karta65 - $karta_vedeni65;
$karta_text65 = '';
$karta_text65.= "- vedení karty: ".number_format($karta_vedeni65, 2, '.', '')." $mena, účtováno ročně ".$radek_ucty['KontaktVedeni1']." $mena<BR>
                - zpoplatněné výběry z bankomatu ($karta_vybery65/$vybery): ".number_format($karta65 - $karta_vedeni65, 2, '.', '')." $mena-0-";
$karta_text65.= $vybery == 1 ? "-1- <U>jak ušetřit <B>".number_format($karta_exc65, 2, '.', '')." $mena</B></U> - k výběrům hotovosti využívejte bankomatů UniCredit Bank-1-" : Null;
$karta_text65.= $vybery > 1 ? "-1- <U>jak ušetřit <B>až ".number_format($karta_exc65, 2, '.', '')." $mena</B></U> - k výběrům hotovosti využívejte bankomatů UniCredit Bank-1-" : Null;
  
$karta_typ65 = 'MasterCard Standard, Visa Classic';
break;

default:

$karta65 = 0;
$karta_exc65 = 0;
$karta_text65 = Null;
$karta_typ65 = Null;
}




switch($info)
{
case 'mail':
  $info65 = $radek_ucty['EMAILpush'];
  $info_text65 = '...';
  break;
  
case 'sms':
  $info65 = $radek_ucty['SMSpush1'] * $transakce;
  $info_text65 = "- zadáno celkem $transakce transakcí = cena odpovídá $transakce SMS.-0-";
break;
    
default:
  $info65 = 0;
  $info_text65 = Null;
}


$naklady65 = $vedeni65 + $banking65 + $vypis65 + $dom_prichozi_max65 + $dom_odchozi_max65 + $karta65 + $info65;
$naklady_exc65 = $naklady65 - $dom_prichozi_min65 - $dom_odchozi_min65 - $karta_exc65;



$sql_detail65 = "UPDATE poplatky_vysledek SET Vedeni = $vedeni65, Banking = $banking65, Banking_text = '$banking_text65', Vypis = $vypis65, Dom_prichozi = $dom_prichozi65, Dom_prichozi_text = '$dom_prichozi_text65', Dom_odchozi = $dom_odchozi65, Dom_odchozi_text = '$dom_odchozi_text65', Dom_trans_text = '$dom_trans_text65', Karta = $karta65, Karta_text = '$karta_text65', Karta_typ = '$karta_typ65', Info = $info65, Info_text = '$info_text65', NakladyOd = $naklady_exc65, NakladyDo = $naklady65 WHERE ID = 65";
$detail65 = mysql_query($sql_detail65, $id_spojeni);
if (!$detail65)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodařilo se nám poslat SQL dotaz na detail 65.');
} 
//echo 'Dotaz na detail 65 - bezny ucet unicredit - odeslán.<br>';
                              
  }
?>