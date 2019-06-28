<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Overeni zadanych udaju</title>
</head>
<body bgcolor="#FFFFFF" text="#000000">
<center><font face="Arial CE, Arial" size="5">
<?php

If (!isset($_POST['next-pokracuj']) || $_POST['next-pokracuj'] != 'Pokracuj') 
die ('Neplatny pokus.');

include "pripojeni_sql_man.php";

date_default_timezone_set('Europe/Prague');

$datum = $_POST['rok']."-".$_POST['mesic']."-".$_POST['den'];


$sql_detail_uctu = "SELECT Mena FROM moje_ucty WHERE idmoje_ucty='".$_POST['ucet']."'";
$detail_uctu = mysql_query($sql_detail_uctu, $id_spojeni);
if (!$detail_uctu)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodařilo se nám poslat SQL dotaz na moje bankovni ucty.');
} 
echo 'Dotaz na detail uctu odeslan.<br>';

$radek_detail_uctu = mysql_result($detail_uctu, 0);

?>
<form action="fin_potvrzeni_prijmu2.php" method='POST'> 

<H1><B>Kontrola zadanych udaju k novemu prijmu</B></H1>

<TABLE border=1 width=500>

<TH>Zdroj prijmu</TH>
<TH>Datum prijeti</TH>
<TH>Prijem na ucet</TH>
<TH>Celkovy prijem</TH>

<TR>
<TD align='center'><?php echo $_POST['zdroj']; ?>
<INPUT type='hidden' name='zdroj' value='<?php echo $_POST['zdroj']; ?>'</TD>

<TD align='center'><?php echo $datum; ?>
<INPUT type='hidden' name='datum' value='<?php echo $datum; ?>'></TD>

<TD align='center'><?php echo $_POST['ucet']; ?>
<INPUT type='hidden' name='ucet' value='<?php echo $_POST['ucet']; ?>'>

<TD align='center'><?php echo $_POST['prijem']." $radek_detail_uctu"; ?>
<INPUT type='hidden' name='prijem' value='<?php echo $_POST['prijem']; ?>'</TD>
</TR>

</TABLE>



<P>
<INPUT type=button onclick="history.back()" value="Zpět">
<input type="submit" name="next-potvrzeni_prijmu" value="Potvrdit">


</form>
</font></center>
</body>
</html>
