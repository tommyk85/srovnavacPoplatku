<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Moje finance-uprava existujiciho zdroje</title>
</head>
<body bgcolor="#FFFFFF" text="#000000">

<center><font face="Arial CE, Arial" size=4>

<FORM action='fin_detail_editace_zdroje.php' method='POST'>


<?php



If (!isset($_POST['Zmenit']) || $_POST['Zmenit'] != 'edit') 
die ('Neplatny pokus.');

IF (!isset($_POST['muj_zdroj']))
DIE ('Neni vybran zdroj.');

include "pripojeni_sql_man.php";

$sql_detaily_zdroje = "SELECT * FROM zdroje WHERE idzdroje = ". mysql_real_escape_string($_POST['muj_zdroj']);
$detaily_zdroje = mysql_query($sql_detaily_zdroje, $id_spojeni);
IF (!$detaily_zdroje)
{
  ECHO mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  DIE('Nepodaøilo se nám poslat SQL dotaz na aktualni detaily zdroje.');
} 
ECHO 'Dotaz na aktualni detaily zdroje odeslan.<br>';
$radek_detaily_zdroje = mysql_fetch_array($detaily_zdroje);


$sql_moje_ucty = "SELECT NazevUctu, idmoje_ucty FROM moje_ucty WHERE TypUctu In('sporici','bezny')";
$moje_ucty = mysql_query($sql_moje_ucty, $id_spojeni);
if (!$moje_ucty)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodaøilo se nám poslat SQL dotaz na moje ucty.');
} 
echo 'Dotaz na moje ucty odeslan.<br>';



If ($_POST['typ'] == 'aktivni')
{
?>

<TABLE BORDER=0 width=400>
<CAPTION><B>Editace existujiciho AKTIVNIHO zdroje</B></CAPTION>
<INPUT type='hidden' name='typ' value='aktivni'>
<TR><TD>Nazev zamestnavatele:</TD>
<TD><INPUT type='text' name='nazev' value='<?php ECHO $radek_detaily_zdroje['Nazev']; ?>' readonly /></TD></TR>


<TR><TD>Hlavni zdroj <SUP>*</SUP>:</TD>
<TD>
<INPUT type='radio' name='prefer' value=1 <?php if($radek_detaily_zdroje['Preferovany'] == 1){echo 'checked';} ?>> Ano
<INPUT type='radio' name='prefer' value=0 <?php if($radek_detaily_zdroje['Preferovany'] == 0){echo 'checked';} ?>> Ne
</TD></TR>

<TR><TD>Vyplata ke dni <SUP>*</SUP>:</TD>
<TD><INPUT type='text' name='den' size=1 maxlength=2 value='<?php echo $radek_detaily_zdroje['Den_vyplaty']; ?>'></TD></TR>

<TR><TD>Vyplata v mene:</TD>
<TD><?php echo $radek_detaily_zdroje['Mena']; ?></TD></TR>

<TR><TD>Hruba mesicni mzda:</TD>
<TD><INPUT type='text' name='mzda' size=8 maxlength=13 value='<?php if($radek_detaily_zdroje['Mzda'] > 0){echo $radek_detaily_zdroje['Mzda'];} else echo 0; ?>'></TD></TR>

<TR><TD>Vyplata na ucet <SUP>*</SUP>:</TD>
<TD><SELECT name='ucet'>

<?php
while($radek_moje_ucty = mysql_fetch_row($moje_ucty))
{
     echo "<OPTION value='$radek_moje_ucty[1]'";
     if($radek_moje_ucty[0] == $radek_detaily_zdroje['Ucet']){echo 'selected';}
     echo ">$radek_moje_ucty[0]</OPTION>";
}

?>
</SELECT>
</TD>
</TR>



</TABLE>



<?php
}
If ($_POST['typ'] == 'pasivni')
{
?>

<TABLE BORDER=0 width=400>
<CAPTION><B>Editace existujiciho PASIVNIHO zdroje</B></CAPTION>
<INPUT type='hidden' name='typ' value='pasivni'>
<TR><TD>Nazev zdroje:</TD>
<TD><?php echo "<U>$radek_detaily_zdroje[0]</U>"; ?>
<INPUT type='hidden' name='nazev' value='<?php ECHO $radek_detaily_zdroje[0]; ?>'></TD></TR>

<TR><TD>Typ zdroje <SUP>*</SUP>:</TD>
<TD><?php 
Switch ($radek_detaily_zdroje[6])
{
  case 'nemovitost':
    echo 'Pronajem nemovitosti';
  break;
  
  case 'auto':
    echo 'Pronajem auta';
  break;
  
  case 'jiny':
    echo 'Jiny typ';
  break;
  
  default:
    echo "<FONT color='red'>Neznamy typ</FONT>";
}?>
</TD></TR>

<TR><TD>Jmeno platce:</TD>
<TD><INPUT type='text' name='platce' size=32 maxlength=30 value='<?php ECHO $radek_detaily_zdroje[7]; ?>'></TD></TR>

<TR><TD>Prijem ke dni <SUP>*</SUP>:</TD>
<TD><INPUT type='text' name='den' size=1 maxlength=2 value='<?php ECHO $radek_detaily_zdroje[1]; ?>'></TD></TR>

<TR><TD>Prijem v mene:</TD>
<TD><?php echo $radek_detaily_zdroje[2]; ?></TD></TR>

<TR><TD>Mesicni prijem:</TD>
<TD><INPUT type='text' name='mzda' size=8 maxlength=13 value='<?php ECHO $radek_detaily_zdroje[5]; ?>'></TD></TR>

<TR><TD>Prijem na ucet <SUP>*</SUP>:</TD>
<TD><SELECT name='ucet'>

<?php
while($radek_moje_ucty = mysql_fetch_row($moje_ucty))
{
     echo "<OPTION value='$radek_moje_ucty[0]'";
     if($radek_moje_ucty[0] == $radek_detaily_zdroje[4]){echo 'selected';}
     echo ">$radek_moje_ucty[0]</OPTION>";
}

?>
</SELECT>
</TD>
</TR>



</TABLE>


<?php
}

if($id_spojeni)
{
  mysql_close($id_spojeni);
  echo 'odpojeno<br>';
}

?>            
<input type=button onclick='history.back()' value='Zpět'>
<INPUT type='submit' name='next-detail_editace_zdroje' value='Pokračuj'>

</FORM>



</font></center>
</body>
</html>
