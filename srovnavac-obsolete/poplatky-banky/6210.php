<?php 

if($radek_ucty['ID'] == 1)             // mkonto od 15/03/2012
  {

$vedeni1 = $radek_ucty['Vedeni1'];
$banking1 = $radek_ucty['IB1'];
$vypis1 = $vypis == 'papir' ? $radek_ucty['VypisMesPapir'] : $radek_ucty['VypisMesEl'];
$dom_prichozi1 = $radek_ucty['PrichoziTransakce1'];
$dom_odchozi1 = $radek_ucty['DomOdchozi1'] + $radek_ucty['DomOdchoziTP1'];

switch($info)
{
case 'mail':
  $info1 = $radek_ucty['EMAILpush'] * $transakce;
  $info_text1 = $radek_ucty['EMAILpush']." / mail";
break;
case 'sms':
  if($transakce >= 60){
  $info1 = $radek_ucty['SMSpush4'] + ($radek_ucty['SMSpush1'] * ($transakce - 60));
  $info_text1 = "- zadáno $transakce transakcí = $transakce SMS = aktivovat balíček 60 SMS za ".$radek_ucty['SMSpush4']." $mena + ".$radek_ucty['SMSpush1']." za každou další SMS";
  }
  elseif($transakce >= 40){
  $info1 = $radek_ucty['SMSpush3'] + ($radek_ucty['SMSpush1'] * ($transakce - 40));
  $info_text1 = "- zadáno $transakce transakcí = $transakce SMS = aktivovat balíček 40 SMS za ".$radek_ucty['SMSpush3']." $mena + ".$radek_ucty['SMSpush1']." $mena za každou další SMS";
  }
  elseif($transakce >= 20){
  $info1 = $radek_ucty['SMSpush2'] + ($radek_ucty['SMSpush1'] * ($transakce - 20));
  $info_text1 = "- zadáno $transakce transakcí = $transakce SMS = aktivovat balíček 20 SMS za ".$radek_ucty['SMSpush2']." $mena + ".$radek_ucty['SMSpush1']." $mena za každou další SMS";
  }
  else{
  $info1 = $radek_ucty['SMSpush1'] * $transakce;
  $info_text1 = "- zadáno $transakce transakcí = $transakce SMS = ".$radek_ucty['SMSpush1']." $mena za každou SMS";
  }
break;

default:
  $info1 = 0;
  $info_text1 = Null;
}                    
$naklady1 = $vedeni1 + $banking1 + $vypis1 + $dom_prichozi1 + $dom_odchozi1 + $info1;

$sql_detail1 = "UPDATE poplatky_vysledek SET Vedeni = $vedeni1, Banking = $banking1, Vypis = $vypis1, Dom_prichozi = $dom_prichozi1, Dom_odchozi = $dom_odchozi1, Info = $info1, Info_text = '$info_text1', NakladyDo = $naklady1 WHERE ID = 1";
$detail1 = mysql_query($sql_detail1, $id_spojeni);
if (!$detail1)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodařilo se nám poslat SQL dotaz na detail 1.');
} 
//echo 'Dotaz na detail 1 - mkonto - odeslán.<br>';

  }





elseif($radek_ucty['ID'] == 13)         // mkonto od 01/11/2012
  {
$vedeni13 = $radek_ucty['Vedeni1'];
$banking13 = $radek_ucty['IB1'];
$vypis13 = $vypis == 'papir' ? $radek_ucty['VypisMesPapir'] : $radek_ucty['VypisMesEl'];
$dom_prichozi13 = $radek_ucty['PrichoziTransakce1'];
$dom_odchozi13 = $radek_ucty['DomOdchozi1'] + $radek_ucty['DomOdchoziTP1'];


switch($karta)
{    
  case '1':
  
  $karta_vedeni13 = $radek_ucty['KontaktVedeni1'];
  $karta13 = $karta_vedeni13;
  
  $vybery_zdarma13 = 0;
  
  for($i = 0; $i < $vybery; ++$i)
  {
    if($karta_celkem < 2000 && $i <= 2)
    {
    $karta13 += $radek_ucty['KontaktVyber2'];
    }
    elseif($karta_celkem < 2000 && $i > 2)
    {
    $karta13 += $radek_ucty['KontaktVyber3'];
    }
    
    elseif($karta_celkem >= 2000 && $karta_celkem < 3000 && ($i == 1 || $i == 2))
    {
    $karta13 += $radek_ucty['KontaktVyber2'];
    }
    elseif($karta_celkem >= 2000 && $karta_celkem < 3000 && $i > 2)
    {
    $karta13 += $radek_ucty['KontaktVyber3'];
    }
    
    elseif($karta_celkem >= 3000 && $karta_celkem < 4000 && $i == 2)
    {
    $karta13 += $radek_ucty['KontaktVyber2'];
    }
    elseif($karta_celkem >= 3000 && $karta_celkem < 4000 && $i > 2)
    {
    $karta13 += $radek_ucty['KontaktVyber3'];
    }
    
    elseif($karta_celkem >= 4000 && $i > 2)
    {
    $karta13 += $radek_ucty['KontaktVyber3'];
    }
    else ++$vybery_zdarma13;    
  }
  $karta_text13 = "- vedení karty: $karta_vedeni13 $mena<BR>
                - zpoplatněné výběry z bankomatu (".($vybery - $vybery_zdarma13)."/$vybery): ".number_format($karta13 - $karta_vedeni13, 2, '.', '')." $mena-0-";
                
  $karta_typ13 = 'Visa Classic'; 
  break;
  
  
  case '2': 
  $karta_vedeni13 = $radek_ucty['KontaktVedeni1'];
  $karta13 = $karta_vedeni13;
  
  $vybery_zdarma13 = 0;
  
  for($i = 0; $i < $vybery; ++$i)
  {
    if($karta_celkem < 2000 && $i <= 2)
    {
    $karta13 += $radek_ucty['KontaktVyber2'];
    }
    elseif($karta_celkem < 2000 && $i > 2)
    {
    $karta13 += $radek_ucty['KontaktVyber3'];
    }
    
    elseif($karta_celkem >= 2000 && $karta_celkem < 3000 && ($i == 1 || $i == 2))
    {
    $karta13 += $radek_ucty['KontaktVyber2'];
    }
    elseif($karta_celkem >= 2000 && $karta_celkem < 3000 && $i > 2)
    {
    $karta13 += $radek_ucty['KontaktVyber3'];
    }
    
    elseif($karta_celkem >= 3000 && $karta_celkem < 4000 && $i == 2)
    {
    $karta13 += $radek_ucty['KontaktVyber2'];
    }
    elseif($karta_celkem >= 3000 && $karta_celkem < 4000 && $i > 2)
    {
    $karta13 += $radek_ucty['KontaktVyber3'];
    }
    
    elseif($karta_celkem >= 4000 && $i > 2)
    {
    $karta13 += $radek_ucty['KontaktVyber3'];
    }
    
    else ++$vybery_zdarma13;    
  }
  $karta_text13 = "- vedení karty: $karta_vedeni13 $mena<BR>
                - zpoplatněné výběry z bankomatu (".($vybery - $vybery_zdarma13)."/$vybery): ".number_format($karta13 - $karta_vedeni13, 2, '.', '')." $mena-0-";
                
  $karta_typ13 = 'Visa payWave';  
  break;
  
  default:
  $karta13 = 0;
  $karta_text13 = Null;
  $karta_typ13 = Null;
}




                     
switch($info)
{
case 'mail':
  $info13 = $radek_ucty['EMAILpush'] * $transakce;
  $info_text13 = $radek_ucty['EMAILpush']." / mail.-0-";
  $info_exc13[] = 0;
break;
case 'sms':
  $info13 = $radek_ucty['SMSpush1'] * $transakce;
    
//  if($info13 > $radek_ucty['SMSpush4']){
  $info_exc13[1] = $transakce < 20 && $info13 > $radek_ucty['SMSpush2'] ? $info13 - $radek_ucty['SMSpush2'] : 0;
  $info_exc13[2] = $transakce >= 20 ? $info13 - ($radek_ucty['SMSpush2'] + ($radek_ucty['SMSpush1'] * ($transakce - 20))) : 0;
  $info_exc13[3] = $transakce >= 40 ? $info13 - ($radek_ucty['SMSpush3'] + ($radek_ucty['SMSpush1'] * ($transakce - 40))) : $info13 - $radek_ucty['SMSpush3'];
  $info_exc13[4] = $transakce >= 60 ? $info13 - ($radek_ucty['SMSpush4'] + ($radek_ucty['SMSpush1'] * ($transakce - 60))) : $info13 - $radek_ucty['SMSpush4'];
  
  switch(array_search(max($info_exc13), $info_exc13))
  {
  case 1:
  case 2: $info_exc_text13 = "aktivujte balíček 20 SMS za ".$radek_ucty['SMSpush2']." $mena."; break;
  case 3: $info_exc_text13 = "aktivujte balíček 40 SMS za ".$radek_ucty['SMSpush3']." $mena."; break;
  case 4: $info_exc_text13 = "aktivujte balíček 60 SMS za ".$radek_ucty['SMSpush4']." $mena."; break;
    
  default: $info_exc_text13 = Null;
  }
  $info_text13 = '';
  $info_text13.= "- zadáno celkem $transakce transakcí = cena odpovídá $transakce SMS.-0-";
  $info_text13.= max($info_exc13) > 0 ? "-1- <U>jak ušetřit <B>".number_format(max($info_exc13), 2, '.', '')." $mena</B></U> - $info_exc_text13.-1-" : Null;
  
/*  }
  elseif($transakce >= 40){
  $info_exc13 = $info13 - ($radek_ucty['SMSpush3'] + ($radek_ucty['SMSpush1'] * ($transakce - 40)));
  $info_text13 = "- zadáno celkem $transakce transakcí = $transakce SMS.<BR>
                  - <U>jak ušetřit <B>".number_format($info_exc13, 2, '.', '')." $mena</B></U> - aktivujte balíček 40 SMS za ".$radek_ucty['SMSpush3']." $mena";
  }
  elseif($transakce >= 20){
  $info_exc13 = $info13 - ($radek_ucty['SMSpush2'] + ($radek_ucty['SMSpush1'] * ($transakce - 20)));
  $info_text13 = "- zadáno celkem $transakce transakcí = $transakce SMS.<BR>
                  - <U>jak ušetřit <B>".number_format($info_exc13, 2, '.', '')." $mena</B></U> - aktivujte balíček 20 SMS za ".$radek_ucty['SMSpush2']." $mena";
  }
  else{
  $info_text13 = "- zadáno celkem $transakce transakcí = $transakce SMS";
  }    */
break;

default:
  $info13 = 0;
  $info_text13 = Null;
  $info_exc13[] = 0;
}
  
$naklady13 = $vedeni13 + $banking13 + $vypis13 + $dom_prichozi13 + $dom_odchozi13 + $karta13 + $info13;
$naklady_exc13 = $naklady13 - max($info_exc13);

$sql_detail13 = "UPDATE poplatky_vysledek SET Vedeni = $vedeni13, Banking = $banking13, Vypis = $vypis13, Dom_prichozi = $dom_prichozi13, Dom_odchozi = $dom_odchozi13, Karta = $karta13, Karta_text = '$karta_text13', Karta_typ = '$karta_typ13', Info = $info13, Info_text = '$info_text13', NakladyOd = $naklady_exc13, NakladyDo = $naklady13 WHERE ID = 13";
$detail13 = mysql_query($sql_detail13, $id_spojeni);
if (!$detail13)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodařilo se nám poslat SQL dotaz na detail 13.');
} 
//echo 'Dotaz na detail 13 - mkonto - odeslán.<br>';
  }








?>