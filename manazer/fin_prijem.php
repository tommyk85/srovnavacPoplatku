<HTML>
  <HEAD>
    <META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
    <TITLE>Moje finance - novy prijem</TITLE>
  </HEAD>
<BODY>

<CENTER><H1>Prehled mych prijmu</H1></CENTER>

<FORM action='fin_novy_prijem.php' method='POST'>

<?php 
//    PRIPOJENI SQL
include "pripojeni_sql_man.php";

$sql_aktiv_zdroje = "SELECT * FROM zdroje WHERE typ='aktivni'";
$aktiv_zdroje = mysql_query($sql_aktiv_zdroje, $id_spojeni);
if(!$aktiv_zdroje)
{
    echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
    die('Nepodaøilo se poslat SQL dotaz na aktivni zdroje.<br>');
}
echo 'Dotaz na aktivni zdroje odeslan.<br>';

$sql_pasiv_zdroje = "SELECT * FROM zdroje WHERE typ='pasivni'";
$pasiv_zdroje = mysql_query($sql_pasiv_zdroje, $id_spojeni);
if(!$pasiv_zdroje)
{
    echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
    die('Nepodaøilo se poslat SQL dotaz na pasivni zdroje.<br>');
}
echo 'Dotaz na pasivni zdroje odeslan.<br>';
?>

<TABLE>
<TR><TD width=300>
<?php
echo '<B>Aktivni zdroje</B><BR>';
while($radek_aktiv_zdroje = mysql_fetch_row($aktiv_zdroje))
{
  echo "<INPUT type='radio' name='nazev' value='$radek_aktiv_zdroje[0]'";
  if($radek_aktiv_zdroje[9] == 1){echo 'checked';}
  echo "> $radek_aktiv_zdroje[1]<BR>";
}

echo '<B>Pasivni zdroje</B><BR>';
while($radek_pasiv_zdroje = mysql_fetch_row($pasiv_zdroje))
{
  echo "<INPUT type='radio' name='nazev' value='$radek_pasiv_zdroje[0]'> $radek_pasiv_zdroje[0]<BR>";
}
?>
</TD>
<TD valign='center'>
<INPUT type='submit' name='next-zadani' value='Zadat novy prijem z registrovaneho zdroje'>
</TD></TR>
</TABLE>
</FORM>
<P>
<A HREF="fin_novy_prijem2.php">Zadat novy jednorazovy prijem.</A>
<P>
<A HREF="fin_novy_prijem3.php">Zadat nove uroky.</A>
<P>
<INPUT type=button onclick="history.back()" value="Zpět">
</BODY>
</HTML>
