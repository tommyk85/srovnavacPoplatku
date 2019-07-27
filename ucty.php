<HTML>

<HEAD>

<META charset='UTF-8'>

<LINK rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
<LINK rel="stylesheet" type="text/css" href="styly.css">

<TITLE>Nulové poplatky</TITLE>

</HEAD>

<BODY>


<CENTER>

<TABLE width=1200>

<?php include "header.php";  ?>

<TR>

<TD bgcolor='red'></TD>

<TD class='nabidka'><B><U>Již zahrnuté účty</U></B></TD>

<TD class='nabidka'><A href="aplikace.php">Aplikace</A></TD>

<TD class='nabidka'><A href="projekt.php">O projektu</A></TD>

</TR>



<TR>

<TD colspan=4>
<?php

include "pripojeni_sql.php";

?>
<BR>
Na této stránce získáte přehled o účtech a základních informacích k bankám, které jsou zahrnuté ve výpočtech aplikace Srovnávač poplatků bank, nebo budou zahrnuty v nejbližší době. Pokud v seznamu chybí některý účet nebo banka, kterou by jste rád porovnal s ostatními, nebo se Vám již zpracovaný účet nezobrazuje ve výsledcích Srovnávače, dejte mi o tom prosím vědět na kontaktní email, viz sekce <A href="projekt.php">O projektu</A>, rád odpovím v co nejkratším termínu.<BR>

<DIV class='tab'>
<H1>Běžné účty - již připravené:</H1> 
<TABLE>
<TR>
<TH width=250>Název účtu</TH>
<TH width=200>Název banky</TH>
<TH width=200>Aktuální sazebník</TH>
<TH width=50>Www</TH>
</TR>

<?php

$sql_ucty = "SELECT ucet_nazev, nazev_banky, cena_platnost_od, ucet_www
FROM ucty
INNER JOIN banky ON ucty.ucet_kod_banky = banky.kod_banky
LEFT JOIN ucty_ceny ON ucty_ceny.cena_ucet_id=ucty.ucet_id
WHERE ucet_typ like 'bezny%' AND cena_active=1
ORDER BY nazev_banky ASC, ucet_nazev ASC";
$ucty = mysql_query($sql_ucty, $id_spojeni);
if (!$ucty)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodařilo se nám poslat SQL dotaz na poplatky.');
} 
//echo 'Dotaz na vysledek odeslán.<br>';

while($radek_ucty = mysql_fetch_assoc($ucty))
{
     echo "<TR>     
     <TD nowrap>".$radek_ucty['ucet_nazev']."</TD>
     <TD nowrap>".$radek_ucty['nazev_banky']."</TD>
     <TD nowrap>".$radek_ucty['cena_platnost_od']."</TD>
     <TD nowrap><a href='".$radek_ucty['ucet_www']."' target='_blank'>link</a></TD></TR>";
}
?>

</TABLE>
<BR>

<H2>Běžné účty - připravované:</H2>
<TABLE>
<TR>
<TH width=250>Název účtu</TH>
<TH width=200>Název banky</TH>
</TR>
<?php
$sql_ucty2 = "SELECT ucet_nazev, nazev_banky
FROM ucty
INNER JOIN banky ON ucty.ucet_kod_banky = banky.kod_banky
LEFT JOIN ucty_ceny ON ucty_ceny.cena_ucet_id=ucty.ucet_id
WHERE ucet_typ like 'bezny%' AND cena_id IS NULL
ORDER BY nazev_banky ASC, ucet_nazev ASC";
$ucty2 = mysql_query($sql_ucty2, $id_spojeni);
if (!$ucty2)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodařilo se nám poslat SQL dotaz na poplatky.');
} 
//echo 'Dotaz na vysledek odeslán.<br>';

while($radek_ucty2 = mysql_fetch_assoc($ucty2))
{
     echo "<TR>     
     <TD nowrap>".$radek_ucty2['ucet_nazev']."</TD>
     <TD nowrap>".$radek_ucty2['nazev_banky']."</TD></TR>";
}
?>
</TABLE>
<BR>

<H3>Základní info o bankách:</H3> 
<TABLE>
<TR>
<TH width=200>Název banky</TH>
<TH width=50>Kód banky</TH>
<TH width=100>Počet klientů *</TH>
<TH width=50>Počet vlastních bankomatů</TH>
<TH width=400>Poznámka</TH>
</TR>

<?php
$sql_banky = "SELECT DISTINCT banky.* FROM banky
INNER JOIN ucty ON ucty.ucet_kod_banky = banky.kod_banky WHERE ucet_typ like 'bezny%' ORDER BY nazev_banky ASC";
$banky = mysql_query($sql_banky, $id_spojeni);
if (!$banky)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodařilo se nám poslat SQL dotaz na poplatky.');
} 
//echo 'Dotaz na vysledek odeslán.<br>';

while($radek_banky = mysql_fetch_assoc($banky))
{
     echo "<TR>     
     <TD nowrap>".$radek_banky['nazev_banky']."</TD>
     <TD style='text-align:center'>".$radek_banky['kod_banky']."</TD>
     <TD style='text-align:right'>".$radek_banky['klientu']."</TD>
     <TD style='text-align:right'>".$radek_banky['bankomaty']."</TD>
     <TD style='text-indent:10'>".
     ($radek_banky['kod_banky'] == '6210' || $radek_banky['kod_banky'] == '6100' || $radek_banky['kod_banky'] == '4000' ? 'nerozlišuje mezi bankomaty jiných bank' : ''),
     ($radek_banky['kod_banky'] == '2310' ? 'využívá bankomaty Raiffeisen bank jako vlastní' : ''),
     ($radek_banky['kod_banky'] == '7940' ? '+ využívá bankomaty ČSOB jako vlastní' : '')
     ."</TD></TR>";
}


?>


</TABLE>
</DIV>     
<HR>
* nemusí být aktuální, tento údaj slouží k výpočtu přibližné pravděpodobnosti plateb z/na účet stejné nebo cizí banky

<?php
if($id_spojeni)
{
  mysql_close($id_spojeni);
  //echo 'odpojeno<br>';
}
?>

</TD>
</TR>

</TABLE>



</CENTER>

<?php include 'footer.php'; ?>
</BODY>
</HTML>