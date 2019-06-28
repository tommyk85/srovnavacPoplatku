<?php 

if($radek_ucty['ID'] == 39 || $radek_ucty['ID'] == 41 || $radek_ucty['ID'] == 43 || $radek_ucty['ID'] == 45 || $radek_ucty['ID'] == 47)                  // ge start, active, optimal, gold a student od 01/10/2012
  {

switch ($radek_ucty['ID']){
  case 41:
    $vedeni = $zustatek >= 250000 ? $radek_ucty['Vedeni2'] : $radek_ucty['Vedeni1'];
    $vedeni_max = $radek_ucty['Vedeni1'];
    $vedeni_min = $zustatek >= 250000 ? $radek_ucty['Vedeni1'] : $radek_ucty['Vedeni2'];
    $vedeni_text = $zustatek >= 250000 ? "-2- <U>na co si dát pozor</U> - pokud průměrný zůstatek na účtu za dané zůčtovací období klesne pod 250 000 CZK, pak vedení účtu <U><B>+ ".$radek_ucty['Vedeni1']." $mena</B></U>" : Null;
  break;
  
  case 45:
    $vedeni = $prostredky >= 1000000 ? $radek_ucty['Vedeni2'] : $radek_ucty['Vedeni1'];
    $vedeni_max = $radek_ucty['Vedeni1'];
    $vedeni_min = $prostredky >= 1000000 ? $radek_ucty['Vedeni1'] : $radek_ucty['Vedeni2'];
    $vedeni_text = $prostredky >= 1000000 ? "-2- <U>na co si dát pozor</U> - pokud klesne celkový objem vkladů u GE Money Bank k 20. dni daného měsíce pod 1 000 000 CZK, pak vedení účtu <U><B>+ ".$radek_ucty['Vedeni1']." $mena</B></U>" : Null;
  break;
  
  default: 
    $vedeni = $vedeni_max = $radek_ucty['Vedeni1']; 
    $vedeni_min = 0; 
    $vedeni_text = Null;
}
    
$mb = in_array('mb', $banking) ? $radek_ucty['MB1'] : number_format(0, 2, '.', '');
$tb = in_array('tb', $banking) ? $radek_ucty['TB'] : number_format(0, 2, '.', '');
$banking_ge = $radek_ucty['IB1'] + $tb + $mb;

$vypis_ge = $vypis == 'papir' ? $radek_ucty['VypisMesPapir'] : $radek_ucty['VypisMesEl'];


$dom_prichozi = $prichozi * $radek_ucty['PrichoziTransakce1'];
$dom_prichozi_text = $radek_ucty['ID'] == 39 ? "- zpoplatněné příchozí platby ($prichozi/$prichozi)" : "- zpoplatněné příchozí platby (0/$prichozi)";

$dom_odch_std_ge = $dom_odch_std * $radek_ucty['DomOdchozi1'];
$dom_odch_tp_ge = $dom_odch_tp * $radek_ucty['DomOdchoziTP1'];
$dom_odchozi = $dom_odch_std_ge + $dom_odch_tp_ge;

$dom_odchozi_text = "- zpoplatněné jednorázové platby ($dom_odch_std/$dom_odch_std): ".number_format($dom_odch_std_ge, 2, '.', '')." $mena<BR>
     - zpoplatněné trvalé příkazy ($dom_odch_tp/$dom_odch_tp): ".number_format($dom_odch_tp_ge, 2, '.', '')." $mena";

if($radek_ucty['ID'] == 39 && $radek_ucty['PrichoziTransakce2'] < ($dom_prichozi + $dom_odchozi)){
$dom_trans_exc = $dom_prichozi + $dom_odchozi - $radek_ucty['PrichoziTransakce2'];
$dom_trans_text = "-1- <U>jak ušetřit <B> ".number_format($dom_trans_exc, 2, '.', '')." $mena</B></U> - aktivujte si Transakční balíček – příchozí a odchozí transakce za ".$radek_ucty['PrichoziTransakce2']." $mena-1-";
}
else{
$dom_trans_exc = 0;
$dom_trans_text = Null;
}

switch($karta)
{
case '1':
$karta_vedeni = $radek_ucty['KontaktVedeni1'];

  if($radek_ucty['ID'] == 45){
  $placene_vybery = $vybery > 3 ? ($vybery - 3) : 0;
  }  
  else{
  $placene_vybery = $vybery;
  }

$karta_vybery = $placene_vybery * $radek_ucty['KontaktVyber2'];
$karta_ge = $karta_vedeni + $karta_vybery;

  if($radek_ucty['ID'] == 39 && $radek_ucty['KontaktVyber3'] < $karta_vybery){
  $karta_exc = $vybery > 1 ? $karta_vybery - $radek_ucty['KontaktVyber3'] : $karta_vybery - $radek_ucty['KontaktVyber1'];
  }
  else{
  $karta_exc = $karta_vybery;
  }

$karta_text = '';
$karta_text.= "- vedení karty: ".$radek_ucty['KontaktVedeni1']." $mena<BR>
                - zpoplatněné výběry z bankomatu ($placene_vybery/$vybery): ".number_format($karta_vybery, 2, '.', '')." $mena-0-";
  if($radek_ucty['ID'] == 39){
$karta_text.= $placene_vybery == 1 ? "-1- <U>jak ušetřit <B>".number_format($karta_exc, 2, '.', '')." $mena</B></U> - k výběrům hotovosti využívejte bankomatů GE Money Bank-1-" : Null;
$karta_text.= $placene_vybery > 1 ? "-1- <U>jak ušetřit <B>".number_format($karta_exc, 2, '.', '')." $mena</B></U> - aktivujte si Transakční balíček – neomezený výběr z bankomatů GE Money Bank v ČR za ".$radek_ucty['KontaktVyber3']." $mena a k výběrům hotovosti využívejte bankomatů GE Money Bank-1-" : Null;}
  else{
$karta_text.= $placene_vybery == 1 ? "-1- <U>jak ušetřit <B>".number_format($karta_exc, 2, '.', '')." $mena</B></U> - k výběrům hotovosti využívejte bankomatů GE Money Bank-1-" : Null;
$karta_text.= $placene_vybery > 1 ? "-1- <U>jak ušetřit <B>až ".number_format($karta_exc, 2, '.', '')." $mena</B></U> - k výběrům hotovosti využívejte bankomatů GE Money Bank-1-" : Null;}

$karta_text.= "-2- <U>na co si dát pozor</U> - za každý dotaz na zůstatek z jiného bankomatu než od GE Money Bank <U><B>+ ".$radek_ucty['KontaktBankZustatek2']." $mena</B></U>";
  
$karta_typ = 'MasterCard Standard';
break;

default:
$karta_ge = 0;
$karta_exc = 0;
$karta_text = Null;
$karta_typ = Null;
}

switch($info)
{
case 'sms':
  if(($radek_ucty['ID'] == 41 || $radek_ucty['ID'] == 43) && $transakce > 50){
  $info_ge = $radek_ucty['SMSpush2'] * ($transakce - 50);
  $info_text = "- zadáno celkem $transakce transakcí, prvních 50 SMS v měsíci je zdarma = cena odpovídá ".($transakce - 50)." SMS-0-";}
  else{
  $info_ge = $radek_ucty['SMSpush1'] * $transakce;
  $info_text = "- zadáno celkem $transakce transakcí = cena odpovídá $transakce SMS-0-";}
break;
    
default:
  $info_ge = 0;
  $info_text = Null;
}


  
$naklady = $vedeni_max + $banking_ge + $vypis_ge + $dom_prichozi + $dom_odchozi + $karta_ge + $info_ge; 
$naklady_exc = $naklady - $vedeni_min - $dom_trans_exc - $karta_exc;
                                                                                                    
$sql_detail = "UPDATE poplatky_vysledek SET Vedeni = $vedeni, Vedeni_text = '$vedeni_text', Banking = $banking_ge, Vypis = $vypis_ge, Dom_prichozi = $dom_prichozi, Dom_prichozi_text = '$dom_prichozi_text', Dom_odchozi = $dom_odchozi, Dom_odchozi_text = '$dom_odchozi_text', Dom_trans_text = '$dom_trans_text', Karta = $karta_ge, Karta_text = '$karta_text', Karta_typ = '$karta_typ', Info = $info_ge, Info_text = '$info_text', NakladyOd = $naklady_exc, NakladyDo = $naklady WHERE ID = ".$radek_ucty['ID'];
$detail = mysql_query($sql_detail, $id_spojeni);
if (!$detail)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodařilo se poslat dotaz na detail 39, 41, 43, 45 nebo 47.');
} 
//echo 'Dotaz na detail 39 - ge start - odeslán.<br>';
  }
  

?>