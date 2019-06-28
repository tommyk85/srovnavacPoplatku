<?php

date_default_timezone_set('Europe/Prague');


function svatky() {
  $sql_svatky = "SELECT Datum FROM svatky";
  $svatky = mysql_query($sql_svatky, $id_spojeni);
  if(!$svatky)
  {
      echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
      die('Nepodarilo se poslat SQL dotaz na svatky.<br>');
  }
  echo 'Dotaz na svatky odeslan.<br>';

  $svatek = array();
  while($radek_svatky = mysql_fetch_row($svatky))
  {
    $svatek[] = strtotime($radek_svatky[0]);
  }
  
  return $svatek;
}

function pracovni_den($datum)   
{
$datum = strtotime($datum);

for($datum; $datum > 0; $datum = $datum - 86400)    //86400 = 1 den
{
$den_cislo = Date('w', $datum);

if($den_cislo > 0 && $den_cislo <= 5 && !in_array($datum, svatky()))
break;
}
return $datum;
}

function datumPosledniVyplaty() {
  $sql_res = vystup_sql("select max(datum) as datum from prijem where typ='aktivni'");
  return mysql_result($sql_res, 0);
}
?>