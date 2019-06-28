<?php
$id_spojeni = mysql_connect('localhost','root','zlato');
if(!$id_spojeni)
echo 'spojení k serveru se nezdařilo<br>';

$id_cteni_poplatky = mysql_select_db('poplatky',$id_spojeni);
if (!$id_cteni_poplatky)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodařilo se nám otevrit db.');
}
echo 'databáze s poplatky načtena<br>';


function vystup_sql($_sql)
{
global $id_spojeni;
$query = mysql_query($_sql, $id_spojeni);
  if (!$query)
  {
    //echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
    die("<span style='color:red; font-weight:bold'>Něco se nepovedlo. Jdi zpět a zkontroluj, jestli jsou údaje správně zapsané nebo nějaké nechybí. Pokud je vše zapsané v pořádku a problém přetrvává, pošli mi tyto 2 řádky:</span>
    <p style='color:red'>".mysql_errno($id_spojeni).': '.mysql_error($id_spojeni)."<BR><i>$_sql</U></i>");
  }
return $query;
}

mysql_query("SET NAMES 'utf8'");
?>
