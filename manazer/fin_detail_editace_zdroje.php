<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Moje finance-nastaveni noveho uctu</title>
</head>
<body bgcolor="#FFFFFF" text="#000000">
<center><font face="Arial CE, Arial" size="4">

<FORM action='fin_potvrzeni_editace_zdroje.php' method='POST'>

<?php


If (!isset($_POST['next-detail_editace_zdroje']) || $_POST['next-detail_editace_zdroje'] != 'Pokračuj') 
die ('Neplatny pokus.');

//     DEFINICE PROMENNYCH
?>
<INPUT type='hidden' name='typ' value='<?php echo $typ = $_POST['typ']; ?>'>
<INPUT type='hidden' name='nazev' value='<?php echo $nazev = $_POST['nazev']; ?>'>
<INPUT type='hidden' name='den' value='<?php echo $den = $_POST['den']; ?>'>
<INPUT type='hidden' name='mzda' value='<?php echo $mzda = $_POST['mzda']; ?>'>
<INPUT type='hidden' name='ucet' value='<?php echo $ucet = $_POST['ucet']; ?>'>
<?php
If($typ=='aktivni')
{
?>
<INPUT type='hidden' name='prefer' value='<?php echo $prefer = $_POST['prefer']; ?>'>
<?php
}
If($typ=='pasivni')
{
?>
<INPUT type='hidden' name='platce' value='<?php echo $platce = $_POST['platce']; ?>'>
<?php
}



//    KONTROLNI BODY
/*$check = array();
$check['den'] = ...


foreach ($check as $hodnota)
{
  echo $hodnota;
}
  if (implode("", ($check))!=Null)
  die ('<p>zopakovat zapis.'); 	
  
*/

//    PRIPOJENI SQL
include "pripojeni_sql_man.php";



//    DETEKCE ZMEN

$sql_aktual_zdroj = "SELECT z.* FROM zdroje as z WHERE z.Nazev='$nazev'";
$aktual_zdroj = mysql_query($sql_aktual_zdroj, $id_spojeni);
$radek_aktual_zdroj = mysql_fetch_array($aktual_zdroj);

$prefer_text_akt = ($radek_aktual_zdroj['Preferovany'] == 1) ? 'Ano' : 'Ne';
$prefer_text_novy = ($typ=='aktivni' && $prefer == 1) ? 'Ano' : 'Ne';
                             
$edit = array();
$edit['den'] = ($den != $radek_aktual_zdroj['Den_vyplaty']) ? "<B>Den vyplaty</B> z <U>".$radek_aktual_zdroj['Den_vyplaty']."</U> na <U>$den</U><BR>" : Null;
$edit['prefer'] = ($typ=='aktivni' && $prefer != $radek_aktual_zdroj['Preferovany']) ? "<B>Hlavni zdroj</B> z <U>$prefer_text_akt</U> na <U>$prefer_text_novy</U><BR>" : Null;
$edit['ucet'] = ($ucet != $radek_aktual_zdroj['Ucet']) ? "<B>Ucet pro vyplatu</B> z <U>".$radek_aktual_zdroj['Ucet']."</U> na <U>$ucet</U><BR>" : Null;
$edit['mzda1'] = ($mzda != $radek_aktual_zdroj['Mzda'] && $radek_aktual_zdroj['Mzda']>0) ? "<B>Vyse hrube mesicni mzdy</B> z <U>".$radek_aktual_zdroj['Mzda']."</U> na <U>$mzda</U><BR>" : Null;
$edit['mzda2'] = ($mzda > 0 && $radek_aktual_zdroj['Mzda']==0) ? "<B>Vyse hrube mesicni mzdy</B> na <U>$mzda</U><BR>" : Null;
if($_POST['typ']=='pasivni'){
$edit['platce'] = ($platce != $radek_aktual_zdroj['Pas_platce']) ? "<B>Platce</B> z <U>".$radek_aktual_zdroj['Pas_platce']."</U> na <U>$platce</U><BR>" : Null;
}



echo 'Prehled zmen:<P>';
foreach ($edit as $hodnota)
{
  echo $hodnota;
}
  if (implode("", ($edit))==Null)
  die ("<p>nebyla provedena zadna zmena.<BR>
  <input type=button onclick='history.back()'' value='Zpět'>");








if($id_spojeni)
{
  mysql_close($id_spojeni);
  echo 'odpojeno<br>';
}

?>            

<P>
<input type=button onclick="history.back()" value="Zpět"> 
<INPUT type='submit' name='next-edit_zdroje' value='Potvrdit'>

</FORM>

</font></center>
</body>
</html>
