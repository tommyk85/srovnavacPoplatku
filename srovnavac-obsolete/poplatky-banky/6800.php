<?php 

if($radek_ucty['ID'] == 19)             // bezny ucet volksbank od 03/10/2012
  {
$tb19 = in_array('tb', $banking) ? $radek_ucty['TB'] : number_format(0, 2, '.', '');

$pomer_plateb_v_ramci_banky19 = round($radek_ucty['klientu'] / $klientu_celkem, 5);
$placenych_dom_odch_std19 = $_POST['odch_std'] - round($_POST['odch_std'] * $pomer_plateb_v_ramci_banky19);
$placenych_dom_odch_tp19 = $_POST['odch_tp'] - round($_POST['odch_tp'] * $pomer_plateb_v_ramci_banky19);  

$vedeni19 = $radek_ucty['Vedeni1']; 
$banking19 = $radek_ucty['IB1'] + $tb19;
$banking_text19 = '';
$banking_text19.= $tb19 > 0 ? "- internetové bankovnictví: ".$radek_ucty['IB1']." $mena<BR>
                              - telefonní bankovnictví: $tb19 $mena" : Null;
$banking_text19.= $tb19 == 0 ? "- pouze za internetové bankovnictví" : Null;
$banking_text19.= "-0-";

$vypis19 = $vypis == 'papir' ? $radek_ucty['VypisMesPapir'] : $radek_ucty['VypisMesEl'];
$dom_prichozi19 = $radek_ucty['PrichoziTransakce1'];

$dom_odchozi_std19 = $placenych_dom_odch_std19 * $radek_ucty['DomOdchozi2'];
$dom_odchozi_tp19 = $placenych_dom_odch_tp19 * $radek_ucty['DomOdchoziTP2'];
$dom_odchozi19 = $dom_odchozi_std19 + $dom_odchozi_tp19;

$dom_odchozi_std_max19 = $placenych_dom_odch_std19 < $_POST['odch_std'] ? $dom_odchozi_std19 + (($_POST['odch_std'] - $placenych_dom_odch_std19) * ($radek_ucty['DomOdchozi2'] - $radek_ucty['DomOdchozi1'])) : $dom_odchozi_std19;
$dom_odchozi_std_min19 = $dom_odchozi_std_max19;

$dom_odchozi_max19 = $placenych_dom_odch_tp19 < $_POST['odch_tp'] ? $dom_odchozi_std_max19 + (($_POST['odch_tp'] - $placenych_dom_odch_tp19) * ($radek_ucty['DomOdchoziTP2'] - $radek_ucty['DomOdchoziTP1'])) : $dom_odchozi_std_max19 + $dom_odchozi_tp19;
$dom_odchozi_min19 = $dom_odchozi_max19;

$dom_odchozi_text19 = "- zpoplatněné jednorázové platby ($placenych_dom_odch_std19/".$_POST['odch_std']."): ".number_format($dom_odchozi_std19, 2, '.', '')." $mena<BR>
     - zpoplatněné trvalé příkazy ($placenych_dom_odch_tp19/".$_POST['odch_tp']."): ".number_format($dom_odchozi_tp19, 2, '.', '')." $mena";

$dom_trans_text19 = '';
$dom_trans_text19.= "Počítáno s ".($pomer_plateb_v_ramci_banky19 * 100)." % pravděpodobností plateb na cizí účet ve Volksbank. Za každou nezapočitanou jednorázovou platbu do Volksbank <U>- ".$radek_ucty['DomOdchozi2']." $mena</U>, trvalý příkaz <U>- ".$radek_ucty['DomOdchoziTP2']." $mena</U>";
$dom_trans_text19.= $placenych_dom_odch_std19 < $_POST['odch_std'] || $placenych_dom_odch_tp19 < $_POST['odch_tp'] ? ", za navíc započitanou jednorázovou platbu do Volksbank <U>+ ".$radek_ucty['DomOdchozi2']." $mena</U>, trvalý příkaz <U>+ ".$radek_ucty['DomOdchoziTP2']." $mena</U>" : Null;
$dom_trans_text19.= "-0-";


switch($karta)
{
case '1':
$karta19 = $radek_ucty['KontaktVedeni1'] + ($vybery * $radek_ucty['KontaktVyber3']);
$karta_exc19 = $karta19 - ($vybery * $radek_ucty['KontaktVyber1']);
$karta_max19 = $karta19 + ($radek_ucty['KontaktVedeni2'] - $radek_ucty['KontaktVedeni1']);
$karta_min19 = $karta_max19 - ($vybery * $radek_ucty['KontaktVyber1']);
$karta_text19 = '';
$karta_text19.= "- vedení karty: ".$radek_ucty['KontaktVedeni1']." $mena<BR>
                - zpoplatněné výběry z bankomatu ($vybery/$vybery): ".number_format($karta19 - $radek_ucty['KontaktVedeni1'], 2, '.', '')." $mena<BR>
                Při výběru karty <I>MasterCard Standard</I> nebo <I>Visa Classic</I> vedení karty <U>+ ".number_format($radek_ucty['KontaktVedeni2'] - $radek_ucty['KontaktVedeni1'], 2, '.', '')." $mena</U>.-0-";
$karta_text19.= $vybery == 1 ? "-1- <U>jak ušetřit <B>".number_format($karta_exc19, 2, '.', '')." $mena</B></U> - k výběrům hotovosti využívejte bankomatů Volksbank, nebo <U><B>".number_format($karta19 - ($vybery * $radek_ucty['KontaktVyber2']), 2, '.', '')." $mena</B></U> při výběrech z bankomatů ČSOB-1-" : Null;
$karta_text19.= $vybery > 1 ? "-1- <U>jak ušetřit <B>až ".number_format($karta_exc19, 2, '.', '')." $mena</B></U> - k výběrům hotovosti využívejte bankomatů Volksbank, nebo <U><B>až ".number_format($karta19 - ($vybery * $radek_ucty['KontaktVyber2']), 2, '.', '')." $mena</B></U> při výběrech z bankomatů ČSOB-1-" : Null;

$karta_typ19 = 'Maestro, Visa Electron';
break;

default:

$karta19 = 0;
$karta_exc19 = 0;
$karta_max19 = 0;
$karta_min19 = 0;
$karta_text19 = Null;
$karta_typ19 = Null;
}


switch($info)
{
case 'mail':
  $info19 = $radek_ucty['EMAILpush'];
  $info_text19 = '...';
  break;
  
case 'sms':
  $info19 = $radek_ucty['SMSpush1'] * $transakce;
  $info_text19 = "- zadáno celkem $transakce transakcí = cena odpovídá $transakce SMS.-0-";
break;
    
default:
  $info19 = 0;
  $info_text19 = Null;
}


$naklady19 = $vedeni19 + $banking19 + $vypis19 + $dom_prichozi19 + $dom_odchozi_max19 + $karta_max19 + $info19;  
$naklady_exc19 = $naklady19 - $dom_odchozi_min19 - $karta_min19;



$sql_detail19 = "UPDATE poplatky_vysledek SET Vedeni = $vedeni19, Banking = $banking19, Banking_text = '$banking_text19', Vypis = $vypis19, Dom_prichozi = $dom_prichozi19, Dom_odchozi = $dom_odchozi19, Dom_odchozi_text = '$dom_odchozi_text19', Dom_trans_text = '$dom_trans_text19', Karta = $karta19, Karta_text = '$karta_text19', Karta_typ = '$karta_typ19', Info = $info19, Info_text = '$info_text19', NakladyOd = $naklady_exc19, NakladyDo = $naklady19 WHERE ID = 19";
$detail19 = mysql_query($sql_detail19, $id_spojeni);
if (!$detail19)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodařilo se nám poslat SQL dotaz na detail 19.');
} 
//echo 'Dotaz na detail 19 - bezny ucet volksbank - odeslán.<br>';

  }


   
elseif($radek_ucty['ID'] == 21)             // volksbank - program Exclusive od 03/10/2012
  {
$pomer_plateb_v_ramci_banky21 = round($radek_ucty['klientu'] / $klientu_celkem, 5);
$placenych_dom_odch_std21 = $_POST['odch_std'] - round($_POST['odch_std'] * $pomer_plateb_v_ramci_banky21);
$placenych_dom_odch_tp21 = $_POST['odch_tp'] - round($_POST['odch_tp'] * $pomer_plateb_v_ramci_banky21);    
  
$vedeni21 = $radek_ucty['Vedeni1']; 
$banking21 = $radek_ucty['IB1'];
$vypis21 = $vypis == 'papir' ? $radek_ucty['VypisMesPapir'] : $radek_ucty['VypisMesEl'];
$dom_prichozi21 = $radek_ucty['PrichoziTransakce1'];
$dom_odchozi_std21 = $placenych_dom_odch_std21 * $radek_ucty['DomOdchozi2'];
$dom_odchozi_tp21 = $placenych_dom_odch_tp21 * $radek_ucty['DomOdchoziTP2'];
$dom_odchozi21 = $dom_odchozi_std21 + $dom_odchozi_tp21;

$dom_odchozi_std_max21 = $placenych_dom_odch_std21 < $_POST['odch_std'] ? $dom_odchozi_std21 + (($_POST['odch_std'] - $placenych_dom_odch_std21) * ($radek_ucty['DomOdchozi2'] - $radek_ucty['DomOdchozi1'])) : $dom_odchozi_std21;
$dom_odchozi_std_min21 = $dom_odchozi_std_max21;

$dom_odchozi_max21 = $placenych_dom_odch_tp21 < $_POST['odch_tp'] ? $dom_odchozi_std_max21 + (($_POST['odch_tp'] - $placenych_dom_odch_tp21) * ($radek_ucty['DomOdchoziTP2'] - $radek_ucty['DomOdchoziTP1'])) : $dom_odchozi_std_max21 + $dom_odchozi_tp21;
$dom_odchozi_min21 = $dom_odchozi_max21;

$dom_odchozi_text21 = "- zpoplatněné jednorázové platby ($placenych_dom_odch_std21/".$_POST['odch_std']."): ".number_format($dom_odchozi_std21, 2, '.', '')." $mena<BR>
     - zpoplatněné trvalé příkazy ($placenych_dom_odch_tp21/".$_POST['odch_tp']."): ".number_format($dom_odchozi_tp21, 2, '.', '')." $mena";
     
$dom_trans_text21 = '';
$dom_trans_text21.= "Počítáno s ".($pomer_plateb_v_ramci_banky21 * 100)." % pravděpodobností plateb na cizí účet ve Volksbank. Za každou nezapočitanou jednorázovou platbu do Volksbank <U>- ".$radek_ucty['DomOdchozi2']." $mena</U>, trvalý příkaz <U>- ".$radek_ucty['DomOdchoziTP2']." $mena</U>.";
$dom_trans_text21.= $placenych_dom_odch_std21 < $_POST['odch_std'] || $placenych_dom_odch_tp21 < $_POST['odch_tp'] ? ", za navíc započitanou jednorázovou platbu do Volksbank <U>+ ".$radek_ucty['DomOdchozi2']." $mena</U>, trvalý příkaz <U>+ ".$radek_ucty['DomOdchoziTP2']." $mena</U>" : Null;
$dom_trans_text21.= "-0-";


switch($karta)
{
case '1':
$karta21 = $radek_ucty['KontaktVedeni1'] + ($vybery * $radek_ucty['KontaktVyber3']);
$karta_exc21 = $karta21 - ($vybery * $radek_ucty['KontaktVyber1']);
$karta_text21 = '';
$karta_text21.= "- vedení karty: ".$radek_ucty['KontaktVedeni1']." $mena<BR>
                - zpoplatněné výběry z bankomatu ($vybery/$vybery): ".number_format($karta21 - $radek_ucty['KontaktVedeni1'], 2, '.', '')." $mena-0-";
$karta_text21.= $vybery == 1 ? "-1- <U>jak ušetřit <B>".number_format($karta_exc21, 2, '.', '')." $mena</B></U> - k výběrům hotovosti využívejte bankomatů Volksbank, nebo <U><B>".number_format($karta21 - ($vybery * $radek_ucty['KontaktVyber2']), 2, '.', '')." $mena</B></U> při výběrech z bankomatů ČSOB-1-" : Null;
$karta_text21.= $vybery > 1 ? "-1- <U>jak ušetřit <B>až ".number_format($karta_exc21, 2, '.', '')." $mena</B></U> - k výběrům hotovosti využívejte bankomatů Volksbank, nebo <U><B>až ".number_format($karta21 - ($vybery * $radek_ucty['KontaktVyber2']), 2, '.', '')." $mena</B></U> při výběrech z bankomatů ČSOB-1-" : Null;
  
$karta_typ21 = 'MasterCard Standard, Visa Classic';
break;

default:

$karta21 = 0;
$karta_exc21 = 0;
$karta_text21 = Null;
$karta_typ21 = Null;
}



switch($info)
{
case 'mail':
  $info21 = $radek_ucty['EMAILpush'];
  $info_text21 = '...';
  break;
  
case 'sms':
  $info21 = $radek_ucty['SMSpush1'] * $transakce;
  $info_text21 = "- zadáno celkem $transakce transakcí = cena odpovídá $transakce SMS.-0-";
break;
    
default:
  $info21 = 0;
  $info_text21 = Null;
}


$naklady21 = $vedeni21 + $banking21 + $vypis21 + $dom_prichozi21 + $dom_odchozi_max21 + $karta21 + $info21;
$naklady_exc21 = $naklady21 - $karta_exc21 - $dom_odchozi_min21;



$sql_detail21 = "UPDATE poplatky_vysledek SET Vedeni = $vedeni21, Banking = $banking21, Vypis = $vypis21, Dom_prichozi = $dom_prichozi21, Dom_odchozi = $dom_odchozi21, Dom_odchozi_text = '$dom_odchozi_text21', Dom_trans_text = '$dom_trans_text21', Karta = $karta21, Karta_text = '$karta_text21', Karta_typ = '$karta_typ21', Info = $info21, Info_text = '$info_text21', NakladyOd = $naklady_exc21, NakladyDo = $naklady21 WHERE ID = 21";
$detail21 = mysql_query($sql_detail21, $id_spojeni);
if (!$detail21)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodařilo se nám poslat SQL dotaz na detail 21.');
} 
//echo 'Dotaz na detail 21 - volksbank - program Exclusive - odeslán.<br>';

  }
  


  
elseif($radek_ucty['ID'] == 23)             // studentske free konto od volksbank - od 03/10/2012
  {
$pomer_plateb_v_ramci_banky23 = round($radek_ucty['klientu'] / $klientu_celkem, 5);
$placenych_dom_odch_std23 = $_POST['odch_std'] - round($_POST['odch_std'] * $pomer_plateb_v_ramci_banky23);
$placenych_dom_odch_tp23 = $_POST['odch_tp'] - round($_POST['odch_tp'] * $pomer_plateb_v_ramci_banky23); 

$vedeni23 = $radek_ucty['Vedeni1']; 
$banking23 = $radek_ucty['IB1'];
$vypis23 = $vypis == 'papir' ? $radek_ucty['VypisMesPapir'] : $radek_ucty['VypisMesEl'];

$dom_prichozi23 = $radek_ucty['PrichoziTransakce1'];
$dom_odchozi_std23 = $placenych_dom_odch_std23 * $radek_ucty['DomOdchozi2'];
$dom_odchozi_tp23 = $placenych_dom_odch_tp23 * $radek_ucty['DomOdchoziTP2'];
$dom_odchozi23 = $dom_odchozi_std23 + $dom_odchozi_tp23;

$dom_odchozi_std_max23 = $placenych_dom_odch_std23 < $_POST['odch_std'] ? $dom_odchozi_std23 + (($_POST['odch_std'] - $placenych_dom_odch_std23) * ($radek_ucty['DomOdchozi2'] - $radek_ucty['DomOdchozi1'])) : $dom_odchozi_std23;
$dom_odchozi_std_min23 = $dom_odchozi_std_max23;

$dom_odchozi_max23 = $placenych_dom_odch_tp23 < $_POST['odch_tp'] ? $dom_odchozi_std_max23 + (($_POST['odch_tp'] - $placenych_dom_odch_tp23) * ($radek_ucty['DomOdchoziTP2'] - $radek_ucty['DomOdchoziTP1'])) : $dom_odchozi_std_max23 + $dom_odchozi_tp23;
$dom_odchozi_min23 = $dom_odchozi_max23;


$dom_odchozi_text23 = "- zpoplatněné jednorázové platby ($placenych_dom_odch_std23/".$_POST['odch_std']."): ".number_format($dom_odchozi_std23, 2, '.', '')." $mena<BR>
     - zpoplatněné trvalé příkazy ($placenych_dom_odch_tp23/".$_POST['odch_tp']."): ".number_format($dom_odchozi_tp23, 2, '.', '')." $mena";
     
$dom_trans_text23 = '';
$dom_trans_text23.= "Počítáno s ".($pomer_plateb_v_ramci_banky23 * 100)." % pravděpodobností plateb na cizí účet ve Volksbank. Za každou nezapočitanou jednorázovou platbu do Volksbank <U>- ".$radek_ucty['DomOdchozi2']." $mena</U>, trvalý příkaz <U>- ".$radek_ucty['DomOdchoziTP2']." $mena</U>.";
$dom_trans_text23.= $placenych_dom_odch_std23 < $_POST['odch_std'] || $placenych_dom_odch_tp23 < $_POST['odch_tp'] ? ", za navíc započitanou jednorázovou platbu do Volksbank <U>+ ".$radek_ucty['DomOdchozi2']." $mena</U>, trvalý příkaz <U>+ ".$radek_ucty['DomOdchoziTP2']." $mena</U>" : Null;
$dom_trans_text23.= "-0-";


switch($karta)
{
case '1':
$karta23 = $radek_ucty['KontaktVedeni1'] + ($vybery * $radek_ucty['KontaktVyber3']);
$karta_exc23 = $karta23 - ($vybery * $radek_ucty['KontaktVyber1']);
$karta_max23 = $karta23 + ($radek_ucty['KontaktVedeni2'] - $radek_ucty['KontaktVedeni1']);
$karta_min23 = $karta_max23 - ($vybery * $radek_ucty['KontaktVyber1']);
$karta_text23 = '';
$karta_text23.= "- vedení karty: ".$radek_ucty['KontaktVedeni1']." $mena<BR>
                - zpoplatněné výběry z bankomatu ($vybery/$vybery): ".number_format($karta23 - $radek_ucty['KontaktVedeni1'], 2, '.', '')." $mena<BR>
                Při výběru karty <I>MasterCard Standard</I> nebo <I>Visa Classic</I> vedení karty <U>+ ".$radek_ucty['KontaktVedeni2']." $mena</U>.-0-";
$karta_text23.= $vybery == 1 ? "-1- <U>jak ušetřit <B>".number_format($karta_exc23, 2, '.', '')." $mena</B></U> - k výběrům hotovosti využívejte bankomatů Volksbank, nebo <U><B>".number_format($karta23 - ($vybery * $radek_ucty['KontaktVyber2']), 2, '.', '')." $mena</B></U> při výběrech z bankomatů ČSOB-1-" : Null;
$karta_text23.= $vybery > 1 ? "-1- <U>jak ušetřit <B>až ".number_format($karta_exc23, 2, '.', '')." $mena</B></U> - k výběrům hotovosti využívejte bankomatů Volksbank, nebo <U><B>až ".number_format($karta23 - ($vybery * $radek_ucty['KontaktVyber2']), 2, '.', '')." $mena</B></U> při výběrech z bankomatů ČSOB-1-" : Null;
  
$karta_typ23 = 'Maestro, Visa Electron';
break;

default:

$karta23 = 0;
$karta_exc23 = 0;
$karta_max23 = 0;
$karta_min23 = 0;
$karta_text23 = Null;
$karta_typ23 = Null;
}




switch($info)
{
case 'mail':
  $info23 = $radek_ucty['EMAILpush'];
  $info_text23 = '...';
  break;
  
case 'sms':
  $info23 = $radek_ucty['SMSpush1'] * $transakce;
  $info_text23 = "- zadáno celkem $transakce transakcí = cena odpovídá $transakce SMS.-0-";
break;
    
default:
  $info23 = 0;
  $info_text23 = Null;
}


$naklady23 = $vedeni23 + $banking23 + $vypis23 + $dom_prichozi23 + $dom_odchozi_max23 + $karta_max23 + $info23; 
$naklady_exc23 = $naklady23 - $karta_min23 - $dom_odchozi_min23;



$sql_detail23 = "UPDATE poplatky_vysledek SET Vedeni = $vedeni23, Banking = $banking23, Vypis = $vypis23, Dom_prichozi = $dom_prichozi23, Dom_odchozi = $dom_odchozi23, Dom_odchozi_text = '$dom_odchozi_text23', Dom_trans_text = '$dom_trans_text23', Karta = $karta23, Karta_text = '$karta_text23', Karta_typ = '$karta_typ23', Info = $info23, Info_text = '$info_text23', NakladyOd = $naklady_exc23, NakladyDo = $naklady23 WHERE ID = 23";
$detail23 = mysql_query($sql_detail23, $id_spojeni);
if (!$detail23)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodařilo se nám poslat SQL dotaz na detail 23.');
} 
//echo 'Dotaz na detail 23 - studentske free konto od volksbank - odeslán.<br>';

  }
  
elseif($radek_ucty['ID'] >= 66 && $radek_ucty['ID'] <= 69){             // sperbank fer start, plus, extra a bezny od 08/04/2013

$pomer_plateb_v_ramci_banky = round($radek_ucty['klientu'] / $klientu_celkem, 3);

$pocet_dom_odch_std_v_sb = round($dom_odch_std * $pomer_plateb_v_ramci_banky);
$pocet_dom_odch_std_mimo_sb = $dom_odch_std - $pocet_dom_odch_std_v_sb;
$pocet_dom_odch_tp_v_sb = round($dom_odch_tp * $pomer_plateb_v_ramci_banky);
$pocet_dom_odch_tp_mimo_sb = $dom_odch_tp - $pocet_dom_odch_tp_v_sb; 

$vedeni = $radek_ucty['Vedeni1'];
$banking_sb = $radek_ucty['IB1'];
$vypis_sb = $vypis == 'papir' ? $radek_ucty['VypisMesPapir'] : $radek_ucty['VypisMesEl'];

$placene_prichozi = $radek_ucty['PrichoziTransakce1'] > 0 ? $prichozi : 0;
$dom_prichozi = $placene_prichozi * $radek_ucty['PrichoziTransakce1'];
//$dom_prichozi_text = "- placené příchozí platby (0/$prichozi): ".number_format($dom_prichozi, 2, '.', '')." $mena";
//$dom_prichozi_text = text_exc($dom_prichozi_text, 0);



$rozdil_ceny_prich = $radek_ucty['PrichoziTransakce2'] != Null ? $radek_ucty['PrichoziTransakce2'] - $radek_ucty['PrichoziTransakce1'] : 0;
$rozdil_ceny_odch_std = $radek_ucty['DomOdchozi2'] != Null ? $radek_ucty['DomOdchozi2'] - $radek_ucty['DomOdchozi1'] : 0;
$rozdil_ceny_odch_tp = $radek_ucty['DomOdchoziTP2'] != Null ? $radek_ucty['DomOdchoziTP2'] - $radek_ucty['DomOdchoziTP1'] : 0;

switch($radek_ucty['ID']){
case 66:
case 69:
  $placene_odch_std = $radek_ucty['DomOdchozi1'] > 0 ? $pocet_dom_odch_std_v_sb : 0;
  $placene_odch_std+= $radek_ucty['DomOdchozi2'] > 0 ? $pocet_dom_odch_std_mimo_sb : 0;
  $placene_odch_tp = $radek_ucty['DomOdchoziTP1'] > 0 ? $pocet_dom_odch_tp_v_sb : 0;
  $placene_odch_tp+= $radek_ucty['DomOdchoziTP2'] > 0 ? $pocet_dom_odch_tp_mimo_sb : 0;
  
  $dom_odch_std_v_sb = $pocet_dom_odch_std_v_sb * $radek_ucty['DomOdchozi1'];
  $dom_odch_std_mimo_sb = $pocet_dom_odch_std_mimo_sb * $radek_ucty['DomOdchozi2'];
  $dom_odch_std_sb_celkem = $dom_odch_std_v_sb + $dom_odch_std_mimo_sb;
  
  $dom_odch_tp_v_sb = $pocet_dom_odch_tp_v_sb * $radek_ucty['DomOdchoziTP1'];
  $dom_odch_tp_mimo_sb = $pocet_dom_odch_tp_mimo_sb * $radek_ucty['DomOdchoziTP2'];
  $dom_odch_tp_sb_celkem = $dom_odch_tp_v_sb + $dom_odch_tp_mimo_sb; 
  
  $dom_odchozi = $dom_odch_std_sb_celkem + $dom_odch_tp_sb_celkem;
  
  $dom_trans_text = text_trans($radek_ucty['nazev_banky'], $dom_odch_std_sb_celkem, $dom_odch_tp_sb_celkem, $pomer_plateb_v_ramci_banky, Null, Null, Null, Null, $pocet_dom_odch_std_v_sb, $dom_odch_std_v_sb, $pocet_dom_odch_std_mimo_sb, $dom_odch_std_mimo_sb, $pocet_dom_odch_tp_v_sb, $dom_odch_tp_v_sb, $pocet_dom_odch_tp_mimo_sb, $dom_odch_tp_mimo_sb);     // dodelat funkci
break;

case 67:
  $std_zvyh = 3;
    if($pocet_dom_odch_std_mimo_sb > $std_zvyh){
  $placene_odch_std = $radek_ucty['DomOdchozi1'] > 0 ? $pocet_dom_odch_std_v_sb + $std_zvyh : 0;
  $placene_odch_std+= $radek_ucty['DomOdchozi2'] > 0 ? $pocet_dom_odch_std_mimo_sb - $std_zvyh : 0;
    
  $dom_odch_std_v_sb = ($pocet_dom_odch_std_v_sb + $std_zvyh) * $radek_ucty['DomOdchozi1'];
  $dom_odch_std_mimo_sb = ($pocet_dom_odch_std_mimo_sb - $std_zvyh) * $radek_ucty['DomOdchozi2'];
  //$text = "- počet jednorázových plateb mimo banku se zvýhodněnou cenou jako v rámci banky: $std_zvyh";
  }
    else{
  $placene_odch_std = $radek_ucty['DomOdchozi1'] > 0 ? $pocet_dom_odch_std_v_sb + $pocet_dom_odch_std_mimo_sb : 0;
    
  $dom_odch_std_v_sb = ($pocet_dom_odch_std_v_sb + $pocet_dom_odch_std_mimo_sb) * $radek_ucty['DomOdchozi1'];
  $dom_odch_std_mimo_sb = 0;}
  $dom_odch_std_sb_celkem = $dom_odch_std_v_sb + $dom_odch_std_mimo_sb;
  
  $tp_zvyh = 1;
    if($pocet_dom_odch_tp_mimo_sb > $tp_zvyh){
  $placene_odch_tp = $radek_ucty['DomOdchoziTP1'] > 0 ? $pocet_dom_odch_tp_v_sb + $tp_zvyh : 0;
  $placene_odch_tp+= $radek_ucty['DomOdchoziTP2'] > 0 ? $pocet_dom_odch_tp_mimo_sb - $tp_zvyh : 0;
  
  $dom_odch_tp_v_sb = ($pocet_dom_odch_tp_v_sb + $tp_zvyh) * $radek_ucty['DomOdchoziTP1'];
  $dom_odch_tp_mimo_sb = ($pocet_dom_odch_tp_mimo_sb - $tp_zvyh) * $radek_ucty['DomOdchoziTP2'];}
    else{
  $placene_odch_tp = $radek_ucty['DomOdchoziTP1'] > 0 ? $pocet_dom_odch_tp_v_sb + $pocet_dom_odch_tp_mimo_sb : 0;
  
  $dom_odch_tp_v_sb = ($pocet_dom_odch_tp_v_sb + $pocet_dom_odch_tp_mimo_sb) * $radek_ucty['DomOdchoziTP1'];
  $dom_odch_tp_mimo_sb = 0;}
  $dom_odch_tp_sb_celkem = $dom_odch_tp_v_sb + $dom_odch_tp_mimo_sb;
  
  $dom_odchozi = $dom_odch_std_sb_celkem + $dom_odch_tp_sb_celkem;
  
  $dom_trans_text = text_trans($radek_ucty['nazev_banky'], $dom_odch_std_sb_celkem, $dom_odch_tp_sb_celkem, $pomer_plateb_v_ramci_banky, Null, Null, Null, Null, $pocet_dom_odch_std_v_sb, $dom_odch_std_v_sb, $pocet_dom_odch_std_mimo_sb, $dom_odch_std_mimo_sb, $pocet_dom_odch_tp_v_sb, $dom_odch_tp_v_sb, $pocet_dom_odch_tp_mimo_sb, $dom_odch_tp_mimo_sb, $std_zvyh, $tp_zvyh);     // dodelat funkci
break;
  
case 68:
  $placene_odch_std = $radek_ucty['DomOdchozi1'] > 0 ? $pocet_dom_odch_std_v_sb : 0;
  $placene_odch_std+= $radek_ucty['DomOdchozi2'] > 0 ? $pocet_dom_odch_std_mimo_sb : 0;
  $placene_odch_tp = $radek_ucty['DomOdchoziTP1'] > 0 ? $pocet_dom_odch_tp_v_sb : 0;
  $placene_odch_tp+= $radek_ucty['DomOdchoziTP2'] > 0 ? $pocet_dom_odch_tp_mimo_sb : 0;
  
  $dom_odch_std_sb = $placene_odch_std * $radek_ucty['DomOdchozi1'];
  $dom_odch_tp_sb = $placene_odch_tp * $radek_ucty['DomOdchoziTP1'];
  $dom_odchozi = $dom_odch_std_sb + $dom_odch_tp_sb;
  $dom_trans_text = text_trans($radek_ucty['nazev_banky'], $dom_odch_std_sb, $dom_odch_tp_sb);     // dodelat funkci
break;

default:
  $dom_trans_text = Null;
}

$dom_trans = $dom_prichozi + $dom_odchozi;


include "poplatky-banky/6800k.php";

echo $karta_max."/".$karta_min."<br>";
 
$naklady = $vedeni + $banking_sb + $vypis_sb + $dom_trans + $karta_max; // $info_sb; 
$naklady_exc = $naklady - $karta_min;

// Info = $info_sb, Info_text = '$info_text',  

$sql_detail = "UPDATE poplatky_vysledek SET Vedeni = $vedeni, Banking = $banking_sb, Vypis = $vypis_sb, Dom_trans = $dom_trans, Dom_trans_text = '$dom_trans_text', Karta = $karta_max, Karta_text = '$karta_text', NakladyOd = $naklady_exc, NakladyDo = $naklady WHERE ID = ".$radek_ucty['ID'];
$detail = mysql_query($sql_detail, $id_spojeni);
if (!$detail)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodařilo se poslat dotaz na detail sperbank.');
}                                                               
//echo 'Dotaz na detail 66-69 odeslán.<br>';
//$zruseni_text = Null;
  }
?>