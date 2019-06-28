<?php 

if($radek_ucty['ID'] == 10)             // iqkonto zdarma od 01/05/2012
  {

$pomer_plateb_v_ramci_banky10 = round($radek_ucty['klientu'] / $klientu_celkem, 5);
$placenych_dom_prich10 = $_POST['prichozi'] - round($_POST['prichozi'] * $pomer_plateb_v_ramci_banky10);
$placenych_dom_odch_std10 = $_POST['odch_std'] - round($_POST['odch_std'] * $pomer_plateb_v_ramci_banky10);
$placenych_dom_odch_tp10 = $_POST['odch_tp'] - round($_POST['odch_tp'] * $pomer_plateb_v_ramci_banky10);  


$vedeni10 = $radek_ucty['Vedeni1']; 

$banking10 = $radek_ucty['IB1'];

$vypis10 = $vypis == 'papir' ? $radek_ucty['VypisMesPapir'] : $radek_ucty['VypisMesEl'];


$dom_prichozi10 = $placenych_dom_prich10 * $radek_ucty['PrichoziTransakce2'];

$dom_prichozi_max10 = $placenych_dom_prich10 < $_POST['prichozi'] ? $dom_prichozi10 + (($_POST['prichozi'] - $placenych_dom_prich10) * ($radek_ucty['PrichoziTransakce2'] - $radek_ucty['PrichoziTransakce1'])) : $dom_prichozi10;
$dom_prichozi_min10 = $dom_prichozi_max10;

$dom_prichozi_text10 = "- zpoplatněné příchozí platby ($placenych_dom_prich10/".$_POST['prichozi']."): ".number_format($dom_prichozi10, 2, '.', '')." $mena";

$dom_odchozi_std10 = $placenych_dom_odch_std10 * $radek_ucty['DomOdchozi2'];
$dom_odchozi_tp10 = $placenych_dom_odch_tp10 * $radek_ucty['DomOdchoziTP2'];
$dom_odchozi10 = $dom_odchozi_std10 + $dom_odchozi_tp10;

$dom_odchozi_max10 = $placenych_dom_odch_std10 < $_POST['odch_std'] || $placenych_dom_odch_tp10 < $_POST['odch_tp'] ? $dom_odchozi10 + ((($_POST['odch_std'] - $placenych_dom_odch_std10) + ($_POST['odch_tp'] - $placenych_dom_odch_tp10)) * ($radek_ucty['DomOdchozi2'] - $radek_ucty['DomOdchozi1'])) : $dom_odchozi10;
$dom_odchozi_min10 = $dom_odchozi_max10;

$dom_odchozi_text10 = "- zpoplatněné jednorázové platby ($placenych_dom_odch_std10/".$_POST['odch_std']."): ".number_format($dom_odchozi_std10, 2, '.', '')." $mena<BR>
     - zpoplatněné trvalé příkazy ($placenych_dom_odch_tp10/".$_POST['odch_tp']."): ".number_format($dom_odchozi_tp10, 2, '.', '')." $mena";

$dom_trans_text10 = '';     
$dom_trans_text10.= "Počítáno s ".($pomer_plateb_v_ramci_banky10 * 100)." % pravděpodobností plateb z/na cizí účet v LBBW Bank. Za každou nezapočitanou odchozí platbu do LBBW Bank <U>- ".($radek_ucty['DomOdchozi2'] - $radek_ucty['DomOdchozi1'])." $mena</U>, příchozí platbu z LBBW Bank <U>- ".($radek_ucty['PrichoziTransakce2'] - $radek_ucty['PrichoziTransakce1'])." $mena</U>";
$dom_trans_text10.= $placenych_dom_prich10 < $_POST['prichozi'] || $placenych_dom_odch_std10 < $_POST['odch_std'] || $placenych_dom_odch_tp10 < $_POST['odch_tp'] ? ", za navíc započitanou odchozí platbu do LBBW Bank <U>+ ".($radek_ucty['DomOdchozi2'] - $radek_ucty['DomOdchozi1'])." $mena</U>, příchozí platbu z LBBW Bank <U>+ ".($radek_ucty['PrichoziTransakce2'] - $radek_ucty['PrichoziTransakce1'])." $mena</U>" : Null;
$dom_trans_text10.= "-0-";




switch($karta)
{
case '1':
$karta_vedeni10 = $radek_ucty['KontaktVedeni2'];
$karta10 = $karta_vedeni10 + ($vybery * $radek_ucty['KontaktVyber1']);
$karta_exc10 = $karta_vedeni10;
$karta_text10 = '';
$karta_text10.= "- vedení karty: ".$radek_ucty['KontaktVedeni2']." $mena<BR>
                - zpoplatněné výběry z bankomatu ($vybery/$vybery): ".number_format($karta10 - $radek_ucty['KontaktVedeni2'], 2, '.', '')." $mena.-0-";
$karta_text10.= "-1- <U>jak ušetřit <B> ".number_format($karta_exc10, 2, '.', '')." $mena</B></U> - vyberte si kartu <I>Maestro</I>-1-";
$karta_text10.= "-2- <U>na co si dát pozor</U> - za každý dotaz na zůstatek z jakéhokoli bankomatu <U><B>+ ".$radek_ucty['KontaktBankZustatek1']." $mena</B></U>";
  
$karta_typ10 = 'MasterCard Standard';
break;

default:

$karta10 = 0;
$karta_exc10 = 0;
$karta_text10 = Null;
$karta_typ10 = Null;
}


switch($info)
{
case 'sms':
  $info10 = $radek_ucty['SMSpush1'] * $transakce;
  $info_text10 = "- zadáno celkem $transakce transakcí = cena odpovídá $transakce SMS.-0-";
break;
    
default:
  $info10 = 0;
  $info_text10 = Null;
}


$naklady10 = $vedeni10 + $banking10 + $vypis10 + $dom_prichozi_max10 + $dom_odchozi_max10 + $karta10 + $info10; 
$naklady_exc10 = $naklady10 - $dom_prichozi_min10 - $dom_odchozi_min10 - $karta_exc10;


$sql_detail10 = "UPDATE poplatky_vysledek SET Vedeni = $vedeni10, Banking = $banking10, Vypis = $vypis10, Dom_prichozi = $dom_prichozi10, Dom_prichozi_text = '$dom_prichozi_text10', Dom_odchozi = $dom_odchozi10, Dom_odchozi_text = '$dom_odchozi_text10', Dom_trans_text = '$dom_trans_text10', Karta = $karta10, Karta_text = '$karta_text10', Karta_typ = '$karta_typ10', Info = $info10, Info_text = '$info_text10', NakladyOd = $naklady_exc10, NakladyDo = $naklady10 WHERE ID = 10";
$detail10 = mysql_query($sql_detail10, $id_spojeni);
if (!$detail10)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodařilo se nám poslat SQL dotaz na detail 10.');
} 
//echo 'Dotaz na detail 10 - lbbw, iqkonto zdarma - odeslán.<br>';

  }



elseif($radek_ucty['ID'] == 11)             // konto 5 za 50 od 01/05/2012
  {

$pomer_plateb_v_ramci_banky11 = round($radek_ucty['klientu'] / $klientu_celkem, 5);
$placenych_dom_prich11 = $_POST['prichozi'] - round($_POST['prichozi'] * $pomer_plateb_v_ramci_banky11);
$placenych_dom_odch_std11 = $_POST['odch_std'] - round($_POST['odch_std'] * $pomer_plateb_v_ramci_banky11);
$placenych_dom_odch_tp11 = $_POST['odch_tp'] - round($_POST['odch_tp'] * $pomer_plateb_v_ramci_banky11); 

// definice vyhod - vypis, domaci prichozi a odchozi, karta
$vyhody['banking'] = $radek_ucty['IB1'];

$vyhody['vypis'] = $vypis == 'papir' ? $radek_ucty['VypisMesPapir'] : $radek_ucty['VypisMesEl'];

$vyhody['prichozi'] = $placenych_dom_prich11 * $radek_ucty['PrichoziTransakce2'];

$vyhody['odchozi1'] = 0;
$vyhody['odchozi2'] = 0;
$vyhody['odchozi3'] = 0;
$pocet_trans1 = 0;
$pocet_trans2 = 0;
$pocet_trans3 = 0;

$pocet_trans = 0;
for($i = 0; $i < $placenych_dom_odch_std11 + $placenych_dom_odch_tp11; ++$i)
{
$pocet_trans++;

if($pocet_trans <= 5)
{
$vyhody['odchozi1'] += $radek_ucty['DomOdchozi2'];
$pocet_trans1 = $pocet_trans;
}
elseif($pocet_trans > 5 && $pocet_trans <= 10)
{
$vyhody['odchozi2'] += $radek_ucty['DomOdchozi2'];
$pocet_trans2 = $pocet_trans;
}
elseif($pocet_trans > 10 && $pocet_trans <= 15)
{
$vyhody['odchozi3'] += $radek_ucty['DomOdchozi2'];
$pocet_trans3 = $pocet_trans;
}
}

$vyhody['karta'] = $karta == 1 && $karta_celkem >= 5000 ? $radek_ucty['KontaktVedeni2'] : 0;
$vyhody['karta'] = $karta == 1 && $karta_celkem < 5000 ? $radek_ucty['KontaktVedeni1'] : $vyhody['karta'];    


function pouzite_vyhody($vyhoda)
{
  return ($vyhoda > 0);  
}


arsort($vyhody);
array_splice($vyhody, 5);
$vyhody = array_filter($vyhody, 'pouzite_vyhody');

$soucet_zvyh_odch_trans = array_key_exists('odchozi1', $vyhody) ? $pocet_trans1 : 0;
$soucet_zvyh_odch_trans = array_key_exists('odchozi2', $vyhody) ? $pocet_trans2 : $soucet_zvyh_odch_trans;
$soucet_zvyh_odch_trans = array_key_exists('odchozi3', $vyhody) ? $pocet_trans3 : $soucet_zvyh_odch_trans;

// konec definice vyhod



$vedeni11 = $radek_ucty['Vedeni1']; 

$banking11 = $radek_ucty['IB1'];

$vypis11 = $vypis == 'papir' ? $radek_ucty['VypisMesPapir'] : $radek_ucty['VypisMesEl'];
$vypis11 = array_key_exists('vypis', $vyhody) ? $vypis11 - $vyhody['vypis'] : $vypis11; 

$placenych_dom_prich11 = array_key_exists('prichozi', $vyhody) ? 0 : $placenych_dom_prich11;
$dom_prichozi11 = $placenych_dom_prich11 * $radek_ucty['PrichoziTransakce2'];
//$dom_prichozi11 = array_key_exists('prichozi', $vyhody) ? $dom_prichozi11 - $vyhody['prichozi'] : $dom_prichozi11;

if(array_key_exists('prichozi', $vyhody))
$dom_prichozi_max11 = 0;

else $dom_prichozi_max11 = $placenych_dom_prich11 < $_POST['prichozi'] ? $dom_prichozi11 + (($_POST['prichozi'] - $placenych_dom_prich11) * ($radek_ucty['PrichoziTransakce2'] - $radek_ucty['PrichoziTransakce1'])) : $dom_prichozi11;

$dom_prichozi_min11 = $dom_prichozi_max11;

$dom_prichozi_text11 = "- zpoplatněné příchozí platby ($placenych_dom_prich11/".$_POST['prichozi'].")";

/*
if($soucet_zvyh_odch_trans == $placenych_dom_odch_std11 + $placenych_dom_odch_tp11)
{
$placenych_dom_odch_std11 = 0;
$placenych_dom_odch_tp11 = 0;
}

else
{
  for($i = $soucet_zvyh_odch_trans; $i > 0; $i -= 2)
  {
  if($placenych_dom_odch_std11 == 0)
  break;
  $placenych_dom_odch_std11--;
  
  if($i - 1 <= 0 || ($placenych_dom_odch_tp11 - 1) < 0)
  break;
  $placenych_dom_odch_tp11--;
  }
}

echo $i;
echo $placenych_dom_odch_std11;
echo $placenych_dom_odch_tp11;

for($i; $i > 0; --$i)
{
  if($placenych_dom_odch_std11 > 0)
  $placenych_dom_odch_std11--;
  
  else break; 
}

for($i; $i > 0; --$i)
{
  if($placenych_dom_odch_tp11 > 0)
  $placenych_dom_odch_tp11--;
  
  else break; 
}
*/
$placenych_dom_odch11 = ($placenych_dom_odch_std11 + $placenych_dom_odch_tp11) - $soucet_zvyh_odch_trans;

$dom_odchozi11 = $placenych_dom_odch11 * $radek_ucty['DomOdchozi2'];

//$dom_odchozi11 = array_key_exists('odchozi1', $vyhody) ? $dom_odchozi11 - $vyhody['odchozi1'] : $dom_odchozi11;
//$dom_odchozi11 = array_key_exists('odchozi2', $vyhody) ? $dom_odchozi11 - $vyhody['odchozi2'] : $dom_odchozi11;
//$dom_odchozi11 = array_key_exists('odchozi3', $vyhody) ? $dom_odchozi11 - $vyhody['odchozi3'] : $dom_odchozi11;

if(array_key_exists('odchozi1', $vyhody))
$dom_odchozi_max11 = $placenych_dom_odch11 + $soucet_zvyh_odch_trans < $_POST['odch_std'] + $_POST['odch_tp'] ? $dom_odchozi11 + (($_POST['odch_std'] + $_POST['odch_tp']) - ($placenych_dom_odch11 + $soucet_zvyh_odch_trans)) * ($radek_ucty['DomOdchozi2'] - $radek_ucty['DomOdchozi1']) : $dom_odchozi11;

else $dom_odchozi_max11 = $placenych_dom_odch_std11 < $_POST['odch_std'] || $placenych_dom_odch_tp11 < $_POST['odch_tp'] ? $dom_odchozi11 + ((($_POST['odch_std'] - $placenych_dom_odch_std11) + ($_POST['odch_tp'] - $placenych_dom_odch_tp11)) * ($radek_ucty['DomOdchozi2'] - $radek_ucty['DomOdchozi1'])) : $dom_odchozi11;

$dom_odchozi_min11 = $dom_odchozi_max11;


$dom_odchozi_text11 = array_key_exists('odchozi1', $vyhody) ? "- zpoplatněné odchozí platby ($placenych_dom_odch11/".($_POST['odch_std']+$_POST['odch_tp']).")" : "- zpoplatněné platby ($placenych_dom_odch_std11/".$_POST['odch_std']."): ".number_format($dom_odchozi_std11, 2, '.', '')." $mena<BR>
     - zpoplatněné trvalé příkazy ($placenych_dom_odch_tp11/".$_POST['odch_tp']."): ".number_format($dom_odchozi_tp11, 2, '.', '')." $mena";

$dom_trans_text11 = '';     
$dom_trans_text11.= "Počítáno s ".($pomer_plateb_v_ramci_banky11 * 100)." % pravděpodobností plateb z/na cizí účet v LBBW Bank. Za každou nezapočitanou odchozí platbu do LBBW Bank <U>- ".($radek_ucty['DomOdchozi2'] - $radek_ucty['DomOdchozi1'])." $mena</U>, příchozí platbu z LBBW Bank <U>- ".($radek_ucty['PrichoziTransakce2'] - $radek_ucty['PrichoziTransakce1'])." $mena</U>";
$dom_trans_text11.= $placenych_dom_prich11 < $_POST['prichozi'] || $placenych_dom_odch_std11 < $_POST['odch_std'] || $placenych_dom_odch_tp11 < $_POST['odch_tp'] ? ", za navíc započitanou odchozí platbu do LBBW Bank <U>+ ".($radek_ucty['DomOdchozi2'] - $radek_ucty['DomOdchozi1'])." $mena</U>, příchozí platbu z LBBW Bank <U>+ ".($radek_ucty['PrichoziTransakce2'] - $radek_ucty['PrichoziTransakce1'])." $mena</U>" : Null;
$dom_trans_text11.= "-0-";




switch($karta)
{
case '1':
$karta_vedeni11 = $karta_celkem >= 5000 ? $radek_ucty['KontaktVedeni2'] : $radek_ucty['KontaktVedeni1'];
$karta_vedeni11 = array_key_exists('karta', $vyhody) ? $karta_vedeni11 - $vyhody['karta'] : $karta_vedeni11;

$karta11 = $karta_vedeni11 + ($vybery * $radek_ucty['KontaktVyber1']);
$karta_exc11 = !array_key_exists('karta', $vyhody) ? $karta_vedeni11 - $radek_ucty['KontaktVedeni1'] : 0;
        
$karta_text11 = '';
$karta_text11.= "- vedení karty: ".number_format($karta_vedeni11, 2, '.', '')." $mena<BR>
                - zpoplatněné výběry z bankomatu ($vybery/$vybery): ".number_format($karta11 - $karta_vedeni11, 2, '.', '')." $mena.-0-";
$karta_text11.= !array_key_exists('karta', $vyhody) ? "-1- <U>jak ušetřit <B> ".number_format($karta_exc11, 2, '.', '')." $mena</B></U> - vyberte si kartu <I>Maestro</I>-1-" : Null;
$karta_text11.= "-2- <U>na co si dát pozor</U> - za každý dotaz na zůstatek z jakéhokoli bankomatu <U><B>+ ".$radek_ucty['KontaktBankZustatek1']." $mena</B></U>";

$karta_typ11 = 'MasterCard Standard';  
$karta_typ11 = array_key_exists('karta', $vyhody) && $karta_celkem < 5000 ? 'Maestro' : $karta_typ11;
break;

default:

$karta11 = 0;
$karta_exc11 = 0;
$karta_text11 = Null;
$karta_typ11 = Null;
}



switch($info)
{
case 'sms':
  $info11 = $radek_ucty['SMSpush1'] * $transakce;
  $info_text11 = "- zadáno celkem $transakce transakcí = cena odpovídá $transakce SMS.-0-";
break;
    
default:
  $info11 = 0;
  $info_text11 = Null;
}



$vyhody_text = '';
$vyhody_text.= "</CENTER><p style='text-align:left; background-color:powderblue'>Součástí balíčku je vždy výběr 5 volitelných produktů/služeb z níže uvedené nabídky. ";
$vyhody_text.= count($vyhody) == 5 ? "Ve výpočtu maximálního poplatku už je zahrnuto 5 nejvýhodnějších produktů/služeb, které souvisí s Vámi zadanými parametry " : "Ve výpočtu maximálního poplatku jsou zahrnuty jen ".count($vyhody)." nejvýhodnější produkty/služby, které souvisí s Vámi zadanými parametry. Zbytek lze vybrat dle vlastní volby ";
$vyhody_text.= "(výsledná volba všech 5 možností je ale samozřejmě plně dle vlastních priorit). ";
$vyhody_text.= "<B>Za každou změnu 5 zvolených produktů/služeb po počátečním výběru <U>+ 20.00 $mena</U>.</B></P><CENTER>"; 
$vyhody_text.= "<TABLE><TR><TH nowrap>Volitelný produkt/služba</TH><TH nowrap>Zvýhodnění (v CZK)</TH><TH nowrap>Zvoleno do výpočtu</TH></TR>";
$vyhody_text.= "<TR><TD>Internetové bankovnictví (LBBW Direct)</TD><TD align = 'right'>$banking11</TD><TD align = 'right'>".(array_key_exists('banking', $vyhody) ? 'ano' : 'ne, nevyplatí se')."</TD></TR>";
$vyhody_text.= "<TR><TD>1 debetní platební karta MasterCard Standard nebo Maestro</TD><TD align = 'right'>".(array_key_exists('karta', $vyhody) ? $vyhody['karta'] : '0.00')."</TD><TD align = 'right'>".(array_key_exists('karta', $vyhody) ? "ano, karta $karta_typ11" : 'ne')."</TD></TR>";
$vyhody_text.= "<TR><TD>1 dodatková debetní platební karta dle volby</TD><TD align = 'right'>".($dodatkova = $karta_celkem < 5000 ? '0.00' : 'až 25.00')."</TD><TD align = 'right'>".($dodatkova == '0.00' ? 'ne, nevyplatí se' : 'ne')."</TD></TR>";
$vyhody_text.= "<TR><TD>Měsíční výpis dle volby</TD><TD align = 'right'>".(array_key_exists('vypis', $vyhody) ? $vyhody['vypis'] : '0.00')."</TD><TD align = 'right'>".(array_key_exists('vypis', $vyhody) ? 'ano' : 'ne, nevyplatí se')."</TD></TR>";
$vyhody_text.= "<TR><TD>Kontokorent (IQkredit)</TD><TD align = 'right'>15.00</TD><TD align = 'right'>ne</TD></TR>";
$vyhody_text.= "<TR><TD>Provedení prvních 5 odchozích plateb v Kč zadaných elektronicky v měsíci<BR> - jednorázové platby i trvalé příkazy, možno vybrat až 3-krát</TD><TD align = 'right'>".(array_key_exists('odchozi1', $vyhody) ? number_format($soucet_zvyh_odch_trans * $radek_ucty['DomOdchozi2'], 2, '.', '') : '0.00')."</TD><TD align = 'right'>".(array_key_exists('odchozi1', $vyhody) ? "ano, ".ceil($soucet_zvyh_odch_trans / 5)."-krát" : 'ne, nevyplatí se')."</TD></TR>";
$vyhody_text.= "<TR><TD>4 inkasa v Kč měsíčně</TD><TD align = 'right'>až 20.00</TD><TD align = 'right'>ne</TD></TR>";
$vyhody_text.= "<TR><TD>Tuzemské příchozí platby v Kč</TD><TD align = 'right'>".(array_key_exists('prichozi', $vyhody) ? number_format($vyhody['prichozi'], 2, '.', '') : number_format($dom_prichozi11, 2, '.', ''))."</TD><TD align = 'right'>".(array_key_exists('prichozi', $vyhody) ? 'ano' : 'ne, nevyplatí se')."</TD></TR>";
$vyhody_text.= "<TR><TD>Propojení s LBBW spořícím účtem založené na principu automatických převodů</TD><TD align = 'right'>??</TD><TD align = 'right'>ne</TD></TR>";
$vyhody_text.= "</TABLE>";

$vyhody_text = htmlspecialchars($vyhody_text, ENT_QUOTES);

 

$naklady11 = $vedeni11 + $banking11 + $vypis11 + $dom_prichozi_max11 + $dom_odchozi_max11 + $karta11 + $info11; 
$naklady_exc11 = $naklady11 - $dom_prichozi_min11 - $dom_odchozi_min11 - $karta_exc11;



$sql_detail11 = "UPDATE poplatky_vysledek SET Vyhody_text = '$vyhody_text', Vedeni = $vedeni11, Banking = $banking11, Vypis = $vypis11, Dom_prichozi = $dom_prichozi11, Dom_prichozi_text = '$dom_prichozi_text11', Dom_odchozi = $dom_odchozi11, Dom_odchozi_text = '$dom_odchozi_text11', Dom_trans_text = '$dom_trans_text11', Karta = $karta11, Karta_text = '$karta_text11', Karta_typ = '$karta_typ11', Info = $info11, Info_text = '$info_text11', NakladyOd = $naklady_exc11, NakladyDo = $naklady11 WHERE ID = 11";
$detail11 = mysql_query($sql_detail11, $id_spojeni);
if (!$detail11)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodařilo se nám poslat SQL dotaz na detail 11.');
} 
//echo 'Dotaz na detail 11 - lbbw, konto 5 za 50 - odeslán.<br>';

  }
  
  
  
  
  
elseif($radek_ucty['ID'] == 12)             // bezny ucet lbbw od 01/05/2012
  {
$pomer_plateb_v_ramci_banky12 = round($radek_ucty['klientu'] / $klientu_celkem, 5);
$placenych_dom_prich12 = $_POST['prichozi'] - round($_POST['prichozi'] * $pomer_plateb_v_ramci_banky12);
$placenych_dom_odch_std12 = $_POST['odch_std'] - round($_POST['odch_std'] * $pomer_plateb_v_ramci_banky12);
$placenych_dom_odch_tp12 = $_POST['odch_tp'] - round($_POST['odch_tp'] * $pomer_plateb_v_ramci_banky12); 

$vedeni12 = $radek_ucty['Vedeni1']; 

$banking12 = $radek_ucty['IB1'];

$vypis12 = $vypis == 'elektro' ? $radek_ucty['VypisMesEl'] : 0;


$dom_prichozi12 = $placenych_dom_prich12 * $radek_ucty['PrichoziTransakce2'];

$dom_prichozi_max12 = $placenych_dom_prich12 < $_POST['prichozi'] ? $dom_prichozi12 + (($_POST['prichozi'] - $placenych_dom_prich12) * ($radek_ucty['PrichoziTransakce2'] - $radek_ucty['PrichoziTransakce1'])) : $dom_prichozi12;
$dom_prichozi_min12 = $dom_prichozi_max12;

$dom_prichozi_text12 = "- zpoplatněné příchozí platby ($placenych_dom_prich12/".$_POST['prichozi']."): ".number_format($dom_prichozi12, 2, '.', '')." $mena";

$dom_odchozi_std12 = $placenych_dom_odch_std12 * $radek_ucty['DomOdchozi2'];
$dom_odchozi_tp12 = $placenych_dom_odch_tp12 * $radek_ucty['DomOdchoziTP2'];
$dom_odchozi12 = $dom_odchozi_std12 + $dom_odchozi_tp12;

$dom_odchozi_max12 = $placenych_dom_odch_std12 < $_POST['odch_std'] || $placenych_dom_odch_tp12 < $_POST['odch_tp'] ? $dom_odchozi12 + ((($_POST['odch_std'] - $placenych_dom_odch_std12) + ($_POST['odch_tp'] - $placenych_dom_odch_tp12)) * ($radek_ucty['DomOdchozi2'] - $radek_ucty['DomOdchozi1'])) : $dom_odchozi12;
$dom_odchozi_min12 = $dom_odchozi_max12;

$dom_odchozi_text12 = "- zpoplatněné jednorázové platby ($placenych_dom_odch_std12/".$_POST['odch_std']."): ".number_format($dom_odchozi_std12, 2, '.', '')." $mena<BR>
     - zpoplatněné trvalé příkazy ($placenych_dom_odch_tp12/".$_POST['odch_tp']."): ".number_format($dom_odchozi_tp12, 2, '.', '')." $mena";

$dom_trans_text12 = '';     
$dom_trans_text12.= "Počítáno s ".($pomer_plateb_v_ramci_banky12 * 100)." % pravděpodobností plateb z/na cizí účet v LBBW Bank. Za každou nezapočitanou odchozí platbu do LBBW Bank <U>- ".($radek_ucty['DomOdchozi2'] - $radek_ucty['DomOdchozi1'])." $mena</U>, příchozí platbu z LBBW Bank <U>- ".($radek_ucty['PrichoziTransakce2'] - $radek_ucty['PrichoziTransakce1'])." $mena</U>";
$dom_trans_text12.= $placenych_dom_prich12 < $_POST['prichozi'] || $placenych_dom_odch_std12 < $_POST['odch_std'] || $placenych_dom_odch_tp12 < $_POST['odch_tp'] ? ", za navíc započitanou odchozí platbu do LBBW Bank <U>+ ".($radek_ucty['DomOdchozi2'] - $radek_ucty['DomOdchozi1'])." $mena</U>, příchozí platbu z LBBW Bank <U>+ ".($radek_ucty['PrichoziTransakce2'] - $radek_ucty['PrichoziTransakce1'])." $mena</U>" : Null;
$dom_trans_text12.= "-0-";



switch($karta)
{
case '1':
$karta_vedeni12 = $radek_ucty['KontaktVedeni2'];
$karta12 = $karta_vedeni12 + ($vybery * $radek_ucty['KontaktVyber1']);
$karta_exc12 = $karta_vedeni12 - $radek_ucty['KontaktVedeni1'];
$karta_text12 = '';
$karta_text12.= "- vedení karty: $karta_vedeni12 $mena<BR>
                - zpoplatněné výběry z bankomatu ($vybery/$vybery): ".number_format($karta12 - $karta_vedeni12, 2, '.', '')." $mena.-0-";
$karta_text12.= "-1- <U>jak ušetřit <B> ".number_format($karta_exc12, 2, '.', '')." $mena</B></U> - vyberte si kartu <I>Maestro</I>-1-";
$karta_text12.= "-2- <U>na co si dát pozor</U> - za každý dotaz na zůstatek z jakéhokoli bankomatu <U><B>+ ".$radek_ucty['KontaktBankZustatek1']." $mena</B></U>";
  
$karta_typ12 = 'MasterCard Standard';
break;

default:

$karta12 = 0;
$karta_exc12 = 0;
$karta_text12 = Null;
$karta_typ12 = Null;
}



switch($info)
{
case 'sms':
  $info12 = $radek_ucty['SMSpush1'] * $transakce;
  $info_text12 = "- zadáno celkem $transakce transakcí = cena odpovídá $transakce SMS.-0-";
break;
    
default:
  $info12 = 0;
  $info_text12 = Null;
}


$naklady12 = $vedeni12 + $banking12 + $vypis12 + $dom_prichozi_max12 + $dom_odchozi_max12 + $karta12 + $info12;
$naklady_exc12 = $naklady12 - $dom_prichozi_min12 - $dom_odchozi_min12 - $karta_exc12;



$sql_detail12 = "UPDATE poplatky_vysledek SET Vedeni = $vedeni12, Banking = $banking12, Vypis = $vypis12, Dom_prichozi = $dom_prichozi12, Dom_prichozi_text = '$dom_prichozi_text12', Dom_odchozi = $dom_odchozi12, Dom_odchozi_text = '$dom_odchozi_text12', Dom_trans_text = '$dom_trans_text12', Karta = $karta12, Karta_text = '$karta_text12', Karta_typ = '$karta_typ12', Info = $info12, Info_text = '$info_text12', NakladyOd = $naklady_exc12, NakladyDo = $naklady12 WHERE ID = 12";
$detail12 = mysql_query($sql_detail12, $id_spojeni);
if (!$detail12)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodařilo se nám poslat SQL dotaz na detail 12.');
} 
//echo 'Dotaz na detail 12 - bezny ucet lbbw - odeslán.<br>';

  }
?>