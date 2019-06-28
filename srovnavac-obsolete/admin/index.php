<html>
<head>
<meta charset="utf-8">

<LINK rel="shortcut icon" href="..\..\favicon.ico" type="image/x-icon" />
<LINK rel="stylesheet" type="text/css" href="..\..\styly.css">
<title>Srovnávač poplatků bank - administrace</title>
</head>
<body bgcolor="#FFFFFF" text="#000000">
<center>

<TABLE border=1 style='width:1200; max-height:800;'>

<?php include "header.php"; ?>

<TR>

<TD bgcolor='red' colspan=2 height=20></TD>



<TD class='nabidka'><B><U>Úvod administrace</U></B></TD>

</TR>
<TR>
<TD colspan=3>
<?php include "../../pripojeni_sql.php"; ?>
<br>

<form action='' method='get'>

Vyber účet:
<select name='ucet'>
<option value=''></OPTION>
<?php
$sql_id_uctu = "SELECT ucty.ucetID, VariantaUctu, nazev_banky, TypUctu, PlatnostOd FROM ((ucty INNER JOIN banky ON ucty.KodBanky = banky.kod_banky) INNER JOIN ucty_detail ON ucty.ucetID = ucty_detail.ucetID) WHERE PlatnostDo is null ORDER BY VariantaUctu ASC";

$id_uctu = mysql_query($sql_id_uctu,$id_spojeni);
if (!$id_uctu)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodařilo se nám poslat SQL dotaz na kody bank.');
} 
echo 'Dotaz na kody bank byl odeslan.<br>';

while($radek_id_uctu = mysql_fetch_row($id_uctu))
{
echo "<OPTION value='".$radek_id_uctu[0]."'>". $radek_id_uctu[1] .", ". $radek_id_uctu[2] ." (". $radek_id_uctu[3] .") od ". $radek_id_uctu[4] ."</OPTION>";
}

?>

</select>
</form>

</TD>
</TR>
 



</TABLE>
</center>

<div style='background-color:red; text-align:center; position:fixed; color:white; bottom:0px; width:100%; font-size:small'>&copy;2013, Nulovepoplatky.cz, Všechna práva vyhrazena. Optimalizováno pro Google Chrome (<a href='http://www.google.com/chrome' target='_blank'>zde</a> ke stažení) v rozlišení 1280 x 1024 px.</div>

</BODY>
</HTML>