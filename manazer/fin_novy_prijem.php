<HTML>
  <HEAD>
    <META HTTP-EQUIV="Content-Type" CONTENT="text/html;charset=utf-8">
    <TITLE>Moje finance - zadani noveho prijmu z registrovaneho zdroje</TITLE>
  </HEAD>
<BODY>

<?php 

If (!isset($_POST['next-zadani']) || $_POST['next-zadani'] != 'Zadat novy prijem z registrovaneho zdroje') 
die ('Neplatny pokus.');

include "pripojeni_sql_man.php";

include "datumy.php";

?>

<CENTER>

<H1>Zadani noveho prijmu od <U><?php echo $_POST['nazev']; ?></U></H1>

<?php
$sql_detail_zdroje = "SELECT *, get_work_date(date(concat(pristi_vyplata_termin,den_vyplaty))) as wd FROM zdroje WHERE idzdroje=".$_POST['nazev'];
$detail_zdroje = mysql_query($sql_detail_zdroje, $id_spojeni);
if(!$detail_zdroje)
{
    echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
    die('Nepodařilo se poslat SQL dotaz na detail zdroje.<br>');
}
echo 'Dotaz na detail zdroje odeslan.<br>';

$radek_detail_zdroje = mysql_fetch_assoc($detail_zdroje);


// $sql_posledni_prijem = "SELECT Month(Datum) AS Mesic, Year(Datum) AS Rok FROM prijem WHERE Zdroj='".$_POST['nazev']."' ORDER BY Datum DESC LIMIT 1";
// $posledni_prijem = mysql_query($sql_posledni_prijem, $id_spojeni);
// if(!$posledni_prijem)
// {
//     echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
//     die('Nepodaøilo se poslat SQL dotaz na posledni prijem zdroje.<br>');
// }
// echo 'Dotaz na posledni prijem zdroje odeslan.<br>'; 
// 
// $radek_posledni_prijem = mysql_fetch_row($posledni_prijem);








//$radek_svatky = mysql_fetch_row($svatky);

//echo implode(",", $radek_svatky);

//echo mysql_num_rows($svatky);

?>

<FORM action="fin_detail_prijmu.php" method='POST'>

<?php 
// $akt_rok = Date("Y", Time());
// $akt_mesic = Date("m", Time()); 
// if(!$radek_posledni_prijem || $radek_posledni_prijem[0] == 0)
// {
// $mesic = $akt_mesic;
// $rok = $akt_rok;
// } 
// elseif($radek_posledni_prijem[0] == 12)
// {
// $mesic = '01';
// $rok = $radek_posledni_prijem[1] + 1;
// }
// else 
// {
// $mesic = $radek_posledni_prijem[0] + 1;
// $rok = $radek_posledni_prijem[1]; 
// }

//echo $soft_datum = "$rok-$mesic-".$radek_detail_zdroje[1];
//$soft_datum = "$rok-$mesic-".$radek_detail_zdroje['Den_vyplaty'];

$datum = strtotime($radek_detail_zdroje['wd']);  //pracovni_den($soft_datum);

$den = Date("d", $datum);
$mesic = Date("m", $datum);
$rok = Date("Y", $datum);



$sql_poj_srazky = "SELECT * FROM moje_ucty WHERE TypUctu like 'poj%' and Trans_ucet = '".$_POST['nazev']."' and Zalozeni = '$rok-$mesic-$den'";
//$poj_srazky = array();
$poj_srazky = mysql_query($sql_poj_srazky, $id_spojeni);
if(!$poj_srazky)
{
    echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
    die('Nepodaøilo se poslat SQL dotaz na srazky k pojisteni.<br>');
}
echo 'Dotaz na srazky k pojisteni odeslan.<br>'; 


?>

<TABLE width=400>

<TR><TD>Prijeti na ucet:</TD>
<TD><?php echo $radek_detail_zdroje['Ucet']; ?>
<INPUT type='hidden' name='ucet' value='<?php echo $radek_detail_zdroje['Ucet']; ?>'>
</TD></TR>

<TR><TD>Datum prijeti <SUP>*</SUP>:</TD>
<TD>
<INPUT type='text' name='rok' size=3 maxlength=4 value='<?php echo $rok; ?>'> -
<INPUT type='text' name='mesic' size=1 maxlength=2 value='<?php echo $mesic; ?>'> - 
<INPUT type='text' name='den' size=1 maxlength=2 value='<?php echo $den; ?>'>
</TD></TR>

<TR><TD NOWRAP>Cisty celkovy prijem <SUP>*</SUP>:</TD>
<TD><INPUT type='text' name='mzda' size=8 maxlength=13 <?php if($radek_detail_zdroje['Typ'] == 'pasivni')echo "value='".$radek_detail_zdroje['Mzda']."'"; ?>> 
<?php echo $radek_detail_zdroje['Mena']; ?>
</TD></TR>

<?php 
if($radek_detail_zdroje['Typ'] == 'aktivni')
{
?>
<TR><TD>- srazka 1:</TD>
<TD NOWRAP>
<INPUT type='text' name='srazka1' size=6 maxlength=10 <?php 

if(mysql_num_rows($poj_srazky)>0)
{
$radek_poj_srazka1_nazev = mysql_result($poj_srazky, 0, 2);
$radek_poj_srazka1 = mysql_result($poj_srazky, 0, 25);
$radek_poj_spor1 = mysql_result($poj_srazky, 0, 31) + mysql_result($poj_srazky, 0, 32) + mysql_result($poj_srazky, 0, 33);
$radek_poj_frekvence1 = mysql_result($poj_srazky, 0, 34);
echo "value='$radek_poj_srazka1' readonly> ".$radek_detail_zdroje['Mena']."<FONT color='gray'>, srazka na pojisteni <U>$radek_poj_srazka1_nazev</U></FONT>";
echo "<INPUT type='hidden' name='srazka_poj1' value='$radek_poj_srazka1_nazev'>";
echo "<INPUT type='hidden' name='spor_poj1' value='$radek_poj_spor1'>";

  if($mesic == '12')
  {
  $dalsi_mesic1 = $radek_poj_frekvence1;
  $dalsi_rok1 = $rok + 1; 
  }
  elseif($mesic + $radek_poj_frekvence1 > '12')
  {
  $dalsi_mesic1 = abs($mesic + $radek_poj_frekvence1 - 12);
  $dalsi_rok1 = $rok + 1; 
  }
  else
  {
  $dalsi_mesic1 = $mesic + $radek_poj_frekvence1;
  $dalsi_rok1 = $rok;
  }
  
  $dalsi_soft_datum1 = "$dalsi_rok1-$dalsi_mesic1-$radek_detail_zdroje[1]";
  $dalsi_datum1 = pracovni_den($dalsi_soft_datum1);
  
echo "<INPUT type='hidden' name='dalsi_datum1' value=$dalsi_datum1>";
}
else {echo "> ".$radek_detail_zdroje['Mena'];} ?>
</TD></TR>
<TR><TD>- srazka 2:</TD>
<TD NOWRAP>
<INPUT type='text' name='srazka2' size=6 maxlength=10 <?php 

if(mysql_num_rows($poj_srazky)>1)
{
$radek_poj_srazka2_nazev = mysql_result($poj_srazky, 1, 2);
$radek_poj_srazka2 = mysql_result($poj_srazky, 1, 25);
$radek_poj_spor2 = mysql_result($poj_srazky, 1, 31) + mysql_result($poj_srazky, 1, 32) + mysql_result($poj_srazky, 1, 33);
$radek_poj_frekvence2 = mysql_result($poj_srazky, 1, 34);
echo "value='$radek_poj_srazka2' readonly> ".$radek_detail_zdroje['Mena']."<FONT color='gray'>, srazka na pojisteni <U>$radek_poj_srazka2_nazev</U></FONT>";
echo "<INPUT type='hidden' name='srazka_poj2' value='$radek_poj_srazka2_nazev'>";
echo "<INPUT type='hidden' name='spor_poj2' value='$radek_poj_spor2'>";

  if($mesic == '12')
  {
  $dalsi_mesic2 = $radek_poj_frekvence2;
  $dalsi_rok2 = $rok + 1; 
  }
  elseif($mesic + $radek_poj_frekvence2 > '12')
  {
  $dalsi_mesic2 = abs($mesic + $radek_poj_frekvence2 - 12);
  $dalsi_rok2 = $rok + 1; 
  }
  else
  {
  $dalsi_mesic2 = $mesic + $radek_poj_frekvence2;
  $dalsi_rok2 = $rok;
  }
  
  $dalsi_soft_datum2 = "$dalsi_rok2-$dalsi_mesic2-$radek_detail_zdroje[1]";
  $dalsi_datum2 = pracovni_den($dalsi_soft_datum2);
  
echo "<INPUT type='hidden' name='dalsi_datum2' value=$dalsi_datum2>";
}
else echo "> ".$radek_detail_zdroje['Mena']; ?>
</TD></TR>
<TR><TD>- srazka 3:</TD>
<TD NOWRAP><INPUT type='text' name='srazka3' size=6 maxlength=10> <?php echo $radek_detail_zdroje['Mena']; ?>
</TD></TR>
<TR><TD>- srazka 4:</TD>
<TD NOWRAP><INPUT type='text' name='srazka4' size=6 maxlength=10> <?php echo $radek_detail_zdroje['Mena']; ?>
</TD></TR>
<TR><TD>- srazka 5:</TD>
<TD NOWRAP><INPUT type='text' name='srazka5' size=6 maxlength=10> <?php echo $radek_detail_zdroje['Mena']; ?>
</TD></TR>
<?php
}



?>


<INPUT type='hidden' name='dalsi_datum' value='<?php echo pracovni_den($dalsi_soft_datum); ?>'>

<INPUT type='hidden' name='typ' value='<?php echo $radek_detail_zdroje['Typ']; ?>'>
<INPUT type='hidden' name='nazev' value='<?php echo $_POST['nazev']; ?>'>





</TABLE>
<P>
<INPUT type=button onclick="history.back()" value="Zpět">
<INPUT type='submit' name='next-pokracuj' value='Pokracuj'>

</FORM>

<?php
if($id_spojeni)
{
  mysql_close($id_spojeni);
  echo 'odpojeno<br>';
}

?>            


</CENTER>
</BODY>
</HTML>
