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

?>
<form action="fin_potvrzeni_prijmu3.php" method='POST'> 

<INPUT type='hidden' name='zdroj' value='<?php echo $_POST['zdroj']; ?>'>

<H1><B>Kontrola zadanych udaju novych uroku</B></H1>

<TABLE border=1 width=500>
<TR>
<TH>Datum prijeti</TH>
<TH>Celkovy prijem</TH>
</TR>


<TR>
<TD align='center'><?php echo $datum; ?>
<INPUT type='hidden' name='datum' value='<?php echo $datum; ?>'></TD>

</TR>

</TABLE>
<P>

<?php

echo implode("<BR>", $_POST['uroky']);

?>
<P>
<INPUT type=button onclick="history.back()" value="Zpět">
<input type="submit" name="next-potvrzeni_prijmu" value="Potvrdit">


</form>
</font></center>
</body>
</html>
