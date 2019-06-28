<?php 

if($radek_ucty['ID'] == 7 || $radek_ucty['ID'] == 8 || $radek_ucty['ID'] == 9)   // osobni ucet CS od 07/01/2013 (vc.studenta a absolventa)
  {

$pomer_plateb_v_ramci_banky07 = round($radek_ucty['klientu'] / $klientu_celkem, 5);
$dom_prich_mimo_07 = $kod_banky <> '0800' && $kod_banky <> 'ruzne' && $kod_banky <> 'none' ? $prichozi : $prichozi - round($prichozi * $pomer_plateb_v_ramci_banky07);
$dom_odch_std_mimo_07 = $dom_odch_std - round($dom_odch_std * $pomer_plateb_v_ramci_banky07);
$dom_odch_tp_mimo_07 = $dom_odch_tp - round($dom_odch_tp * $pomer_plateb_v_ramci_banky07);  

$dom_prich_cs_07 = $kod_banky == '0800' ? $prichozi : $prichozi - $dom_prich_mimo_07;
$dom_odch_std_cs_07 = $dom_odch_std - $dom_odch_std_mimo_07;
$dom_odch_tp_cs_07 = $dom_odch_tp - $dom_odch_tp_mimo_07;


$banking_max07 = $banking07 = $radek_ucty['IB1'];
$banking_min07 = 0;
$banking_text07 = "-2- <U>na co si dát pozor</U> - za každé přihlášení ke službám SERVIS 24 <U><B>+ ".$radek_ucty['SMSpush1']." $mena</B></U> za přihlašovací SMS";

$vyhody_std['banking'] = $banking07;


$vypis07 = $vypis == 'papir' ? $radek_ucty['VypisMesPapir'] : $radek_ucty['VypisMesEl'];
$vypis_text07 = $vypis == 'papir' ? '- pouze poštovné, blíže nespecifikováno' : Null;


if($kod_banky == '0800')
{
$dom_prichozi07 = $prichozi * $radek_ucty['PrichoziTransakce1'];

$dom_prichozi_max07 = $dom_prichozi07;
$dom_prichozi_min07 = 0;
$dom_prich_mimo_07 = 0;

}

else
{
$dom_prichozi07 = ($dom_prich_mimo_07 * $radek_ucty['PrichoziTransakce2']) + ($dom_prich_cs_07 * $radek_ucty['PrichoziTransakce1']);

$dom_prichozi_max07 = $prichozi * $radek_ucty['PrichoziTransakce2'];
$dom_prichozi_min07 = $dom_prichozi_max07 - ($prichozi * $radek_ucty['PrichoziTransakce1']);

}


$dom_odchozi_std07 = ($dom_odch_std_mimo_07 * $radek_ucty['DomOdchozi2']) + ($dom_odch_std_cs_07 * $radek_ucty['DomOdchozi1']);
$dom_odchozi_tp07 = ($dom_odch_tp_mimo_07 * $radek_ucty['DomOdchoziTP2']) + ($dom_odch_tp_cs_07 * $radek_ucty['DomOdchoziTP1']);
$dom_odchozi07 = $dom_odchozi_std07 + $dom_odchozi_tp07;

$dom_odchozi_max07 = ($dom_odch_std * $radek_ucty['DomOdchozi2']) + ($dom_odch_tp * $radek_ucty['DomOdchoziTP2']);
$dom_odchozi_min07 = $dom_odchozi_max07 - (($dom_odch_std * $radek_ucty['DomOdchozi1']) + ($dom_odch_tp * ($radek_ucty['DomOdchoziTP1'])));


$vyhody_std['dom_trans'] = ($dom_prich_cs_07 * $radek_ucty['PrichoziTransakce1']) + ($dom_odch_std_cs_07 * $radek_ucty['DomOdchozi1']) + ($dom_odch_tp_cs_07 * $radek_ucty['DomOdchoziTP1']);

$vyhody_plus['dom_trans'] = $dom_prichozi_max07 + $dom_odchozi_max07;

$plus_test = $vyhody_plus['dom_trans'] - $vyhody_std['dom_trans'] > $radek_ucty['Vedeni6'] ? 1 : 0;


switch($karta)
{
case '1':
$karta_vedeni07 = $radek_ucty['KontaktVedeni1'] / 12;
$karta_vybery07 = $vybery * $radek_ucty['KontaktVyber2'];
$karta_max07 = $karta07 = $karta_vedeni07 + $karta_vybery07;
$karta_exc07 = $karta_max07 - ($karta_vedeni07 + ($vybery * $radek_ucty['KontaktVyber1']));
  
$karta_typ07 = 'Visa Classic';

break;

default:
$karta_vedeni07 = 0;
$karta_vybery07 = 0;
$karta_max07 = $karta07 = 0;
//$karta_exc07 = 0;
$karta_text07 = Null;
$karta_typ07 = Null;
}

$vyhody_std['karta_vedeni'] = $karta_vedeni07;
$vyhody_std['karta_vybery'] = $vybery * $radek_ucty['KontaktVyber2'];



switch($info)
{
case 'mail':
  $info_max07 = $info07 = $radek_ucty['EMAILpush'];
  $info_exc07 = 0;
  $info_text07 = '...';
  break;
  
case 'sms':
  $info_max07 = $info07 = $radek_ucty['SMSpush1'] * $transakce;
  $info_exc07 = 0;
  $info_text07 = "- zadáno celkem $transakce transakcí = cena odpovídá $transakce SMS.-0-";
break;
    
default:
  $info_max07 = $info07 = 0;
  $info_exc07 = 0;
  $info_text07 = Null;
}

$vyhody_std['info'] = $info07;

arsort($vyhody_std);
//print_r($vyhody_std);


$usetreno = 0;


for($i = 0; $i < count($vyhody_std); ++$i)
{

if(current($vyhody_std) == 0) 
break;

$usetreno += current($vyhody_std);

  switch (key($vyhody_std))
  {
  case 'banking': $banking_min07 = $banking07; $banking07 = 0; 
    $banking_pos = $i;
    break;
    
  case 'dom_trans': $dom_trans_cs_07 = 0; $online_platby_std = 0;
    $dom_odchozi07 = ($dom_odch_std_mimo_07 * $radek_ucty['DomOdchozi2']) + ($dom_odch_tp_mimo_07 * $radek_ucty['DomOdchoziTP2']);
    $dom_odchozi_min07 = $dom_odchozi_max07;
    $dom_prichozi_min07 = $dom_prichozi_max07;
    $dom_prichozi07 = $kod_banky == '0800' ? 0 : $dom_prich_mimo_07 * $radek_ucty['PrichoziTransakce2'];
    $dom_trans_pos = $i;
    break;
  
  case 'karta_vedeni': $karta_vedeni07 = 0;
    $karta_vedeni_pos = $i;
    break;
    
  case 'karta_vybery': $karta_exc07 = $karta_vybery07;
    $karta_vybery_pos = $i;
    break;
    
  case 'info': $info_exc07 = $info07; $info07 = 0;
    $info_pos = $i;
    break;
    
  default:
    break;
  }

if($i < 1){
$vedeni07 = $radek_ucty['Vedeni1'];
next($vyhody_std);
}

elseif($i <= 2){
  if ($vedeni07 + next($vyhody_std) < $radek_ucty['Vedeni2'] && $i == 2)
  break;
  else $vedeni07 = $radek_ucty['Vedeni2'];
}

elseif($i <= 5){
  if ($vedeni07 + next($vyhody_std) < $radek_ucty['Vedeni3'] && $i == 5)
  break;
  else $vedeni07 = $radek_ucty['Vedeni3'];
}

elseif($i <= 8){
  if ($vedeni07 + next($vyhody_std) < $radek_ucty['Vedeni4'] && $i == 8)
  break;
  else $vedeni07 = $radek_ucty['Vedeni4'];
}

elseif($i > 8){
  if ($vedeni07 + next($vyhody_std) < $vedeni07 + $radek_ucty['Vedeni5'])
  break;
  else $vedeni07 += $radek_ucty['Vedeni5'];
}
}


if($plus_test == 1)
{
$vyhody_std['dom_trans'] = 0;
$dom_odchozi07 = 0;
$dom_prichozi07 = 0;
$vedeni07 += $radek_ucty['Vedeni6'];
}


switch($radek_ucty['ID'])
{
case 7: $aktivita = $prichozi == 1 && $transakce >= 3 ? 1 : 0;
   if($aktivita == 1 && ($prijem >= 100000 || $zustatek >= 5000000))
   $vedeni07 = 0;
   elseif($aktivita == 1 && ($prijem >= 75000 || $zustatek >= 1000000))
   $vedeni07 *= 0.25;
   elseif($aktivita == 1 && ($prijem >= 50000 || $zustatek >= 500000))
   $vedeni07 *= 0.5;
   elseif($aktivita == 1 && ($prijem >= 25000 || $zustatek >= 300000))
   $vedeni07 *= 0.75;
   elseif($aktivita == 1)
   $vedeni07 *= 0.9;  
break;

case 9: $aktivita = $prichozi == 1 ? 1 : 0;
  if($aktivita == 1 && ($prijem >= 20000 || $zustatek >= 1000000))
   $vedeni07 = 0;
   elseif($aktivita == 1 && ($prijem >= 15000 || $zustatek >= 200000))
   $vedeni07 *= 0.25;
   elseif($aktivita == 1 && ($prijem >= 10000 || $zustatek >= 100000))
   $vedeni07 *= 0.5;
   elseif($aktivita == 1 && ($prijem >= 5000 || $zustatek >= 60000))
   $vedeni07 *= 0.75;
   elseif($aktivita == 1)
   $vedeni07 *= 0.9; 
break;

default: $aktivita = 0;
}


$uspora = $usetreno - $vedeni07 - $radek_ucty['Vedeni1'];

$vedeni_max07 = $radek_ucty['Vedeni1']; // ve skutecnosti 'min', pri nevybranem zadne sluzby z programu vyhod, vse ostatni se pocita na max
$vedeni_min07 = $vedeni07 - $vedeni_max07;

$karta07 = $karta_vedeni07 + $karta_vybery07;
$karta_min07 = $karta_max07;
                           
// ----- texty
$dom_prichozi_text07 = "- příchozí platby z účtu mimo ČS ($dom_prich_mimo_07/$prichozi): ".($plus_test == 0 ? number_format($dom_prich_mimo_07 * $radek_ucty['PrichoziTransakce2'], 2, '.', '') : '0.00')." $mena<BR>- příchozí platby v rámci ČS ($dom_prich_cs_07/$prichozi): ".(!isset($dom_trans_cs_07) || $plus_test == 0 ? number_format($dom_prich_cs_07 * $radek_ucty['PrichoziTransakce1'], 2, '.', '') : '0.00')." $mena";
 
$dom_odchozi_text07 = "- jednorázové platby mimo ČS ($dom_odch_std_mimo_07/".$dom_odch_std."): ".($plus_test == 0 ? number_format(($dom_odch_std_mimo_07 * $radek_ucty['DomOdchozi2']), 2, '.', '') : '0.00')." $mena<BR>- jednorázové platby v rámci ČS ($dom_odch_std_cs_07/".$dom_odch_std."): ".(!isset($dom_trans_cs_07) || $plus_test == 0 ? number_format(($dom_odch_std_cs_07 * $radek_ucty['DomOdchozi1']), 2, '.', '') : '0.00')." $mena<BR>
     - trvalé příkazy mimo ČS ($dom_odch_tp_mimo_07/".$dom_odch_tp."): ".number_format(($dom_odch_tp_mimo_07 * $radek_ucty['DomOdchoziTP2']), 2, '.', '')." $mena<BR>- trvalé příkazy v rámci ČS ($dom_odch_tp_cs_07/".$dom_odch_tp."): ".(!isset($dom_trans_cs_07) ? number_format(($dom_odch_tp_cs_07 * $radek_ucty['DomOdchoziTP1']), 2, '.', '') : '0.00')." $mena";

$dom_trans_text07 = '';     
$dom_trans_text07.= "Počítáno s ".($pomer_plateb_v_ramci_banky07 * 100)." % pravděpodobností plateb z/na cizí účet v České Spořitelně. "; 
$dom_trans_text07.= !isset($dom_trans_cs_07) || $plus_test == 0 ? "Za každou nezapočitanou odchozí platbu do České Spořitelny <U>- ".number_format($radek_ucty['DomOdchozi2'] - $radek_ucty['DomOdchozi1'], 2, '.', '')." $mena</U>" : "Za každou nezapočitanou jednorázovou odchozí platbu do České Spořitelny <U>- ".$radek_ucty['DomOdchozi2']." $mena</U>, trvalý příkaz do České Spořitelny <U>- ".$radek_ucty['DomOdchoziTP2']." $mena</U>";
$dom_trans_text07.= ($kod_banky == 'ruzne' || $kod_banky == 'none') && $plus_test == 0 ? ", příchozí platbu z České Spořitelny <U>- ".number_format($radek_ucty['PrichoziTransakce2'] - $radek_ucty['PrichoziTransakce1'], 2, '.', '')." $mena</U>" : Null;
$dom_trans_text07.= ($dom_odch_std_mimo_07 < $dom_odch_std || $dom_odch_tp_mimo_07 < $dom_odch_tp) && (!isset($dom_trans_cs_07) || $plus_test == 0) ? ", za navíc započitanou odchozí platbu do České Spořitelny <U>+ ".number_format($radek_ucty['DomOdchozi2'] - $radek_ucty['DomOdchozi1'], 2, '.', '')." $mena</U>" : Null;
$dom_trans_text07.= $plus_test == 0 && ($dom_prich_mimo_07 < $prichozi && ($kod_banky == 'ruzne' || $kod_banky == 'none')) ? ", příchozí platbu z České Spořitelny <U>+ ".number_format($radek_ucty['PrichoziTransakce2'] - $radek_ucty['PrichoziTransakce1'], 2, '.', '')." $mena</U>" : Null;
$dom_trans_text07.= "-0-";
$dom_trans_text07.= isset($online_platby_std) && $plus_test == 0 ? "-2- <U>na co si dát pozor</U> - ve výpočtu částky za odchozí transakce nejsou zahrnuty online platby (služba PLATBA 24) na účet mimo Českou Spořitelnu. Za každou takovou platbu <U><B>+ ".$radek_ucty['OnlinePlatba']." $mena</B></U>" : Null;


switch($karta)
{
case '1':
$karta_text07 = '';
$karta_text07.= "- vedení karty: ".number_format($karta_vedeni07, 2, '.', '')." $mena".($karta_vedeni07 > 0 ? ", účtováno ročně " &$radek_ucty['KontaktVedeni1'] & " $mena" : Null)." <BR>
                - zpoplatněné výběry z bankomatu ($vybery/$vybery): ".number_format($karta07 - $karta_vedeni07, 2, '.', '')." $mena.-0-";
$karta_text07.= $vybery > 1 ? "-1- <U>jak ušetřit <B>až ".number_format($karta_exc07, 2, '.', '')." $mena</B></U> - k výběrům hotovosti využívejte bankomatů České Spořitelny-1-" : Null;
$karta_text07.= $vybery == 1 ? "-1- <U>jak ušetřit <B>".number_format($karta_exc07, 2, '.', '')." $mena</B></U> - k výběrům hotovosti využívejte bankomatů České Spořitelny-1-" : Null;
$karta_text07.= "-2- <U>na co si dát pozor</U> - za každý dotaz na zůstatek z jiného bankomatu než od České Spořitelny <U><B>+ ".$radek_ucty['KontaktBankZustatek2']." $mena</B></U>";
break;

default:
$karta_text07 = Null;
}



   
$vyhody_text = '';
$vyhody_text.= "</CENTER><p style='text-align:left; background-color:powderblue'>";
$vyhody_text.= $radek_ucty['ID'] == 8 ? "Tento účet lze využívat maximálně 2 roky. " : Null;
$vyhody_text.= "K účtu se vztahují dva 'balíčky' s volitelnými produkty/službami za zvýhodněnou cenu, viz tabulky níže, a Program výhod, odměňující klienta za aktivitu na účtu. Zvolením vhodné kombinace služeb lze za účet výrazně ušetřit. V mém výpočtu je již obsažena nejideálnější kombinace na základě Vámi zadaných údajů (úspora v tomto konkrétním případě činí <U><B>".number_format($uspora, 2, '.', '')." CZK</B> za měsíc</U>). Tyto služby jsou níže zvýrazněny zeleným řádkem. Počet vybraných služeb a aktivita má pak vliv na výši poplatku za vedení účtu. Více o tomto programu na <a href='http://www.csas.cz/banka/nav/osobni-finance/program-vyhod/o-produktu-d00019399'  target='_blank'>webu České Spořitelny</a>.<br>";
$vyhody_text.= "<U>Legenda pro tabulky volitelných produktů/služeb</U>: <span style='color:green; font-weight:bold'>zelený řádek</span> = zahrnuto ve výpočtu a schváleno do ideální kombinace, <span style='color:red; font-weight:bold'>červený řádek</span> = zahrnuto ve výpočtu, ale neschváleno do ideální kombinace, ostatní řádky = nezahrnuto ve výpočtu</p>";
$vyhody_text.= "<TABLE width=600><TR><TH width=450 nowrap>Volitelný produkt/služba STANDARD</TH><TH nowrap>Plná cena (v CZK/měsíc)</TH></TR>";
$vyhody_text.= $radek_ucty['ID'] == 9 && $vek < 18 ? Null : "<TR><TD>Kontokorent</TD><TD class='detail_vyhody'>??</TD></TR>";
$vyhody_text.= "<TR><TD style='background-color: ".($barva = isset($karta_vedeni_pos) ? "greenyellow" : "#FFCC99")."'>Debetní karty</TD><TD class='detail_vyhody' style='background-color: $barva'>".number_format($vyhody_std['karta_vedeni'], 2, '.', '')."</TD></TR>";
$vyhody_text.= "<TR><TD style='background-color: ".($barva = isset($banking_pos) ? "greenyellow" : "#FFCC99")."'>SERVIS 24</TD><TD class='detail_vyhody' style='background-color: $barva'>".number_format($vyhody_std['banking'], 2, '.', '')."</TD></TR>";
$vyhody_text.= "<TR><TD style='background-color: ".($barva = isset($karta_vybery_pos) ? "greenyellow" : "#FFCC99")."'>Výběrová sada č.1 - Výběry z bankomatu České spořitelny zdarma</TD><TD class='detail_vyhody' style='background-color: $barva'>".number_format($vyhody_std['karta_vybery'], 2, '.', '')."</TD></TR>";
$vyhody_text.= "<TR><TD style='background-color: ".($barva = isset($info_pos) ? "greenyellow" : "#FFCC99")."'>Výběrová sada č.2 - Zůstatkové SMS zdarma</TD><TD class='detail_vyhody' style='background-color: $barva'>".number_format($vyhody_std['info'], 2, '.', '')."</TD></TR>";
$vyhody_text.= "<TR><TD style='background-color: ".($barva = isset($dom_trans_pos) && $plus_test == 0 ? "greenyellow" : "#FFCC99")."'>Výběrová sada č.3 - Platby v rámci České spořitelny zdarma</TD><TD class='detail_vyhody' style='background-color: $barva'>".number_format($vyhody_std['dom_trans'], 2, '.', '')."</TD><TD class='detail_vyhody'></TD></TR>";
$vyhody_text.= "</TABLE>";

$vyhody_text.= "<p><TABLE width=600><TR><TH width=450 nowrap>Volitelný produkt/služba PLUS</TH><TH nowrap>Plná cena (v CZK/měsíc)</TH></TR>";
$vyhody_text.= "<TR><TD style='background-color: ".($barva = $plus_test == 1 ? "greenyellow" : "#FFCC99")."'>Výběrová sada č.4 - Platby v rámci České republiky zdarma</TD><TD class='detail_vyhody' style='background-color: $barva'>".number_format($vyhody_plus['dom_trans'], 2, '.', '')."</TD></TR>";
$vyhody_text.= "<TR><TD>Visa Gold</TD><TD class='detail_vyhody'>??</TD></TR>";
$vyhody_text.= "<TR><TD>Spořící plán</TD><TD class='detail_vyhody'>??</TD></TR>";
$vyhody_text.= "</TABLE>";

$vyhody_text = htmlspecialchars($vyhody_text, ENT_QUOTES);


$naklady07 = $vedeni_max07 + $banking_max07 + $vypis07 + $dom_prichozi_max07 + $dom_odchozi_max07 + $karta_max07 + $info_max07; 
$naklady_exc07 = $naklady07 + $vedeni_min07 - $banking_min07 - $dom_prichozi_min07 - $dom_odchozi_min07 - $karta_min07 - $info_exc07;
//$naklady_exc07 = sum($vyhody_std) +
 

$sql_detail07 = "UPDATE poplatky_vysledek SET Vyhody_text = '$vyhody_text', Vedeni = $vedeni07, Banking = $banking07, Banking_text = '$banking_text07', Vypis = $vypis07, Vypis_text = '$vypis_text07', Dom_prichozi = $dom_prichozi07, Dom_prichozi_text = '$dom_prichozi_text07', Dom_odchozi = $dom_odchozi07, Dom_odchozi_text = '$dom_odchozi_text07', Dom_trans_text = '$dom_trans_text07', Karta = $karta07, Karta_text = '$karta_text07', Karta_typ = '$karta_typ07', Info = $info07, Info_text = '$info_text07', NakladyOd = $naklady_exc07, NakladyDo = $naklady07 WHERE ID = ".$radek_ucty['ID'];
$detail07 = mysql_query($sql_detail07, $id_spojeni);
if (!$detail07)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodařilo se poslat dotaz na detail 07,08 nebo 09.');
} 
//echo 'Dotaz na detail 07-09 - sporka, osobni ucty - odeslán.<br>';

  }
  
?>