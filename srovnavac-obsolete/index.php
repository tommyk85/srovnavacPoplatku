<html>
<head>
<meta charset="utf-8">

<LINK rel="shortcut icon" href="..\favicon.ico" type="image/x-icon" />
<LINK rel="stylesheet" type="text/css" href="..\styly.css">
<title>Srovnávač poplatků bank</title>
</head>
<body bgcolor="#FFFFFF" text="#000000">
<?php include_once("analyticstracking.php") ?>
<center>

<TABLE style='width:100%; max-height:800;'>

<?php include "header.php";  ?>

<TR>

<TD bgcolor='red' colspan=2 height=20></TD>

<?php

if (isset($_POST['vysledek']) && $_POST['vysledek'] == 'Zobrazit výsledky')
{
?>
<TD class='nabidka'><A href='..\srovnavac\'>Zadat nové vstupní údaje</A></TD>
<TD class='nabidka'><B><U>Výsledky srovnání</U></B></TD>
<?php
}
elseif (isset($_POST['krok2']) || isset($_POST['krok3']) || isset($_POST['chyby']))
{
?>
<TD class='nabidka'><A href='..\srovnavac\'>Začít znovu</A></TD>
<TD class='nabidka'><B><U>Vstupní údaje</U></B></TD>
<?php
}
else
{
?>
<TD class='nabidka'><B><U>Vstupní údaje</U></B></TD>
<?php
}
?>

</TR>


<TR>
<TD colspan=4 align='left' valign='top'>


<BR>

<?php 

if ((isset($_POST['vysledek']) && ($_POST['vysledek'] == 'Zobrazit výsledky' || $_POST['vysledek'] == 'Rychlá volba')) || isset($_POST['zpet']))
include "souhrn.php"; 

elseif (isset($_POST['krok2']) && ($_POST['krok2'] == 'Pokračovat' || $_POST['krok2'] == 'Opravit' || $_POST['krok2'] == 'Zpět'))
include "vstup2.php"; 

elseif (isset($_POST['krok3']) && ($_POST['krok3'] == 'Pokračovat' || $_POST['krok3'] == 'Opravit'))
include "vstup3.php"; 

else
include "vstup1.php"; 

?>


</TD>
</TR>
</TABLE>
</center>

<div style='background-color:red; text-align:center; position:fixed; color:white; bottom:0px; width:100%; font-size:small'>&copy;2013, Nulovepoplatky.cz, Všechna práva vyhrazena. Optimalizováno pro Google Chrome (<a href='http://www.google.com/chrome' target='_blank'>zde</a> ke stažení) v rozlišení 1280 x 1024 px.</div>

</BODY>
</HTML>
