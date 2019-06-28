<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1250">
<title>Overeni zadanych udaju</title>
</head>
<body bgcolor="#FFFFFF" text="#000000">
<center><font face="Arial CE, Arial" size="5">
<?php

If (!isset($_POST['next-pokracuj']) || $_POST['next-pokracuj'] != 'Pokracuj') 
die ('Neplatny pokus.');

date_default_timezone_set('Europe/Prague');





$datum = $_POST['rok']."-".$_POST['mesic']."-".$_POST['den'];



?>
<form action="fin_potvrzeni_prijmu.php" method='POST'> 

<H1>Kontrola zadanych udaju k prijmu od <U><?php echo $_POST['nazev']; ?></U></H1>

<TABLE border=1 width=500>

<TH>Datum prijeti</TH>
<TH>Cisty celkovy prijem</TH>
<?php
if($_POST['typ'] == 'aktivni')
{
?>
<TH>Srazky z prijmu</TH>
<TH>Cisty prijem na ucet</TH>
<?php
}
?>

<TR>
<TD align='center'><?php echo $datum; ?>
<INPUT type='hidden' name='datum' value='<?php echo $datum; ?>'></TD>

<TD align='center'><?php echo $_POST['mzda']; ?>
<INPUT type='hidden' name='cisty_prijem' value='<?php echo $_POST['mzda']; ?>'</TD>

<?php
if($_POST['typ'] == 'aktivni')
{
$srazky = $_POST['srazka1'] + $_POST['srazka2'] + $_POST['srazka3'] + $_POST['srazka4'] + $_POST['srazka5'];
$cisty_prijem = $_POST['mzda'] - $srazky;
?>
<TD align='center'><?php echo $srazky; ?>
<INPUT type='hidden' name='srazka1' value='<?php if($_POST['srazka1']){echo $_POST['srazka1'];} else echo 0; ?>'>
<INPUT type='hidden' name='srazka2' value='<?php if($_POST['srazka2']){echo $_POST['srazka2'];} else echo 0; ?>'>
<INPUT type='hidden' name='srazka3' value='<?php if($_POST['srazka3']){echo $_POST['srazka3'];} else echo 0; ?>'>
<INPUT type='hidden' name='srazka4' value='<?php if($_POST['srazka4']){echo $_POST['srazka4'];} else echo 0; ?>'>
<INPUT type='hidden' name='srazka5' value='<?php if($_POST['srazka5']){echo $_POST['srazka5'];} else echo 0; ?>'>
</TD>

<TD align='center'><?php echo $cisty_prijem; ?>
<INPUT type='hidden' name='cisty_prijem' value='<?php echo $cisty_prijem; ?>'></TD>

<?php
}

//$srazka_poj = array();
?>

<INPUT type='hidden' name='nazev' value='<?php echo $_POST['nazev']; ?>'>
<INPUT type='hidden' name='typ' value='<?php echo $_POST['typ']; ?>'>
<INPUT type='hidden' name='ucet' value='<?php echo $_POST['ucet']; ?>'>

<?php
if(isset($_POST['dalsi_datum1']))
{
$dalsi_datum1 = Date('Y-m-d', $_POST['dalsi_datum1']);
echo "<INPUT type='hidden' name='srazka_poj1' value='".$_POST['srazka_poj1']."'>";
echo "<INPUT type='hidden' name='dalsi_datum1' value=$dalsi_datum1>";
echo "<INPUT type='hidden' name='spor_poj1' value=".$_POST['spor_poj1'].">";
}

if(isset($_POST['dalsi_datum2']))
{
$dalsi_datum2 = Date('Y-m-d', $_POST['dalsi_datum2']);
echo "<INPUT type='hidden' name='srazka_poj2' value='".$_POST['srazka_poj2']."'>";
echo "<INPUT type='hidden' name='dalsi_datum2' value=$dalsi_datum2>";
echo "<INPUT type='hidden' name='spor_poj2' value=".$_POST['spor_poj2'].">";
}



// echo "datum1 = $dalsi_datum1, datum2 = $dalsi_datum2";
// $spor_poj = array();

 
?>


<INPUT type='hidden' name='dalsi_datum' value='<?php echo $dalsi_datum; ?>'>

</TR>

</TABLE>



<P>
<INPUT type=button onclick="history.back()" value="Zpět">
<input type="submit" name="next-potvrzeni_prijmu" value="Potvrdit">


</form>
</font></center>
</body>
</html>
