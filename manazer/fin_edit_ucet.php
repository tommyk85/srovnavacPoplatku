<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=utf-8">
<TITLE>Moje finance - editace uctu</TITLE>
</HEAD>
<BODY bgcolor="#FFFFFF" text="#000000">
<CENTER><FONT face="Arial CE, Arial" size=4>

<FORM action='fin_detail_editace_uctu.php' method='POST'>


<?php



IF (!ISSET($_POST['Zmenit']) || $_POST['Zmenit'] != 'edit') 
DIE ('Neplatny pokus.');

IF (!isset($_POST['muj_ucet']))
DIE ('Neni vybrany ucet.');

INCLUDE "pripojeni_sql_man.php";

date_default_timezone_set('Europe/Prague');

$sql_detaily_uctu = "SELECT * FROM manazer.moje_ucty INNER JOIN poplatky.ucty ON moje_ucty.ucet_varianta=ucty.ucet_id WHERE idmoje_ucty = ". ($_POST['muj_ucet']);
$detaily_uctu = mysql_query($sql_detaily_uctu, $id_spojeni);
IF (!$detaily_uctu)
{
  ECHO mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  DIE('Nepodaøilo se nám poslat SQL dotaz na aktualni detaily uctu.');
} 
ECHO 'Dotaz na aktualni detaily uctu odeslan.<br>';
$radek_detaily_uctu = mysql_fetch_array($detaily_uctu);




IF($_POST['typ_uctu'] == 'bezny' || $_POST['typ_uctu'] == 'sporici'){

/*
$sql_pocet_spor_uctu = "SELECT Count(*) FROM moje_ucty WHERE TypUctu='sporici'";
$pocet_spor_uctu = mysql_query($sql_pocet_spor_uctu, $id_spojeni);
if (!$pocet_spor_uctu)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodaøilo se nám poslat SQL dotaz na pocet spor uctu.');
} 
echo 'Dotaz na pocet spor uctu odeslan.<br>';

$radek_pocet_spor_uctu = mysql_result($pocet_spor_uctu, 0);
*/

$sql_moje_spor_ucty = "SELECT idmoje_ucty FROM moje_ucty WHERE TypUctu='sporici' and idmoje_ucty != ".$radek_detaily_uctu['idmoje_ucty'];
$moje_spor_ucty = mysql_query($sql_moje_spor_ucty, $id_spojeni);
IF (!$moje_spor_ucty)
{
  ECHO mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  DIE('Nepodaøilo se nám poslat SQL dotaz na pocet uctu.');
} 
ECHO 'Dotaz na moje sporici ucty odeslan.<br>';

}





IF ($_POST['typ_uctu'] == 'bezny')
{

?>
<INPUT type='hidden' name='typ_uctu' value='bezny'>
<TABLE BORDER=0 width=600>
<CAPTION><B>Editace existujiciho BEZNEHO uctu</B></CAPTION>

<TR><TD>Nazev uctu:</TD>
<TD COLSPAN=2>
<INPUT type='text' name='nazev_uctu' value='<?php ECHO $radek_detaily_uctu['NazevUctu']; ?>' readonly /></TD></TR>

<TR><TD>Cislo uctu:</TD>
<?php IF($radek_detaily_uctu['Cislo'] != NULL){ ?>
<TD COLSPAN=2>
<INPUT type='text' name='ucet_predcisli' value='<?php ECHO $radek_detaily_uctu['Predcisli']; ?>' size=6 readonly />
 -
<INPUT type='text' name='ucet_cislo' value='<?php ECHO $radek_detaily_uctu['Cislo']; ?>' size=10 readonly />
 /
<?php }
ELSE { ?>
<TD><INPUT type='text' name='ucet_predcisli' size=4 maxlength=6 value=''>
 -
<INPUT type='text' name='ucet_cislo' size=9 maxlength=10 value=''>
 /
<?php } ?>
<INPUT type='text ' name='ucet_kod_banky' value='<?php ECHO $radek_detaily_uctu['KodBanky']; ?>' size=4 readonly /></TD></TR>
</TD></TR>

<TR><TD>Varianta uctu:</TD>
<TD COLSPAN=2><?php ECHO $radek_detaily_uctu['Ucet_varianta']." - ".$radek_detaily_uctu['ucet_nazev']; ?></TD></TR>

<TR><TD>Web adresa:</TD>
<TD><?php ECHO $radek_detaily_uctu['ucet_www']; ?></TD></TR>

<TR><TD>Mena uctu:</TD>
<TD><?php ECHO $radek_detaily_uctu['ucet_mena']; ?></TD></TR>

<TR><TD>Datum zalozeni uctu:</TD>
<TD><?php ECHO $radek_detaily_uctu['Zalozeni']; ?></TD></TR>

<TR><TD>Stav uctu:</TD>
<TD><?php ECHO $radek_detaily_uctu['Stav']; ?></TD></TR>

<TR><TD>Minimalni zustatek <SUP>*</SUP>:<BR><FONT size=1> pro automaticke planovani plateb a platby kartou</FONT></TD>
<TD><INPUT type='text' name='ucet_min_zustatek' size=8 value='<?php ECHO $radek_detaily_uctu['MinZustatek']; ?>'></TD></TR>

<TR><TD>Vyse uroku:</TD>
<TD><?php ECHO $radek_detaily_uctu['ucet_urok']; ?>%</TD></TR>




<TR><TD rowspan=3 valign='top'>Prebytecne prostredky <SUP>*</SUP>:<BR><FONT size=1>nad minimalni zustatek</FONT></TD>
<TD>
<INPUT type='radio' name='ucet_prevod' value=1 <?php IF($radek_detaily_uctu['Urok_prevod']==1){ECHO 'checked';} ?> > Odecitat na budouci platby</TD></TR>
<TR><TD>
<INPUT type='radio' name='ucet_prevod' value=2 <?php IF($radek_detaily_uctu['Urok_prevod']==2){ECHO 'checked';} ?> 
<?php

IF (mysql_num_rows($moje_spor_ucty) == 0)
{

echo "disabled><FONT color='silver'> Prevadet na sporici ucet..</FONT>";

}
ELSE
{
ECHO '> Prevadet na sporici ucet..';



?>



<SELECT name='ucet_muj'>

<OPTION value=''></OPTION>

<?php
WHILE($radek_moje_spor_ucty = mysql_fetch_array($moje_spor_ucty))
{
   
     ECHO '<OPTION value='. $radek_moje_spor_ucty[0];
     IF($radek_detaily_uctu['Urok_ucet']==$radek_moje_spor_ucty[0]){ECHO ' selected';}
     ECHO '>'. $radek_moje_spor_ucty[0] .'</OPTION>';
   
}

}
?>

</TD>
</TR>

<TR><TD>
<INPUT type='radio' name='ucet_prevod' value=3 <?php IF($radek_detaily_uctu['Urok_prevod']==3){ECHO 'checked';} ?> > Nechavat</TD></TR>

<TR><TD>Debetni karta <SUP>*</SUP>:</TD>
<TD>
<INPUT type='radio' name='ucet_karta' value='Ano' <?php IF($radek_detaily_uctu['Karta']=='Ano'){ECHO 'checked';} ?>> Ano
<INPUT type='radio' name='ucet_karta' value='Ne' <?php IF($radek_detaily_uctu['Karta']=='Ne'){ECHO 'checked';} ?>> Ne
</TD>
</TR>

<TR><TD>- nazev karty:</TD>
<TD><INPUT type='text' name='ucet_karta_nazev' size=32 maxlength=30 value='<?php ECHO $radek_detaily_uctu['Karta_nazev']; ?>'></TD></TR>

<TR><TD>- posledni 4-cisli karty:<BR><FONT size=1> pro identifikaci plateb z uctenek</FONT></TD>
<TD><INPUT type='text' name='ucet_karta_cislo' size=4 maxlength=4 value='<?php ECHO $radek_detaily_uctu['Karta_cislo']; ?>'></TD></TR>

<TR><TD>- mesicni limit karty:<BR><FONT size=1> orientacni castka, kterou nechci prekrocit</FONT></TD>
<TD><INPUT type='text' name='ucet_karta_limit' size=6 value='<?php ECHO $radek_detaily_uctu['Karta_limit']; ?>'></TD></TR>


<TR><TD>Kontokorent <SUP>*</SUP>:</TD>
<TD>
<INPUT type='radio' name='ucet_kontokorent' value='Ano' <?php IF($radek_detaily_uctu['Kontokorent']=='Ano'){ECHO 'checked';} ?>> Ano
<INPUT type='radio' name='ucet_kontokorent' value='Ne' <?php IF($radek_detaily_uctu['Kontokorent']=='Ne'){ECHO 'checked';} ?>> Ne</TD></TR>

<TR><TD>- pokud ano, kolik:</TD>
<TD><INPUT type='text' name='ucet_kontokorent_limit' size=6 value='<?php ECHO $radek_detaily_uctu['Kontokorent_limit']; ?>'></TD></TR>

<TR><TD rowspan=2 valign='top'>Vypis z uctu <SUP>*</SUP>:</TD>
<TD>
<INPUT type='radio' name='ucet_vypis' value='Elektronicky' <?php IF($radek_detaily_uctu['Vypis']=='Elektronicky'){ECHO 'checked';} ?> > Elektronicky</TD></TR>
<TR><TD>
<INPUT type='radio' name='ucet_vypis' value='Papirovy' <?php IF($radek_detaily_uctu['Vypis']=='Papirovy'){ECHO 'checked';} ?>> Papirovy</TD></TR>

</TABLE>












<?php
}

ELSEIF ($_POST['typ_uctu'] == 'sporici')
{
$sql_moje_bank_ucty = "SELECT NazevUctu FROM moje_ucty WHERE TypUctu IN ('sporici', 'bezny', 'kreditni') AND NazevUctu!='".$radek_detaily_uctu['NazevUctu']."' ORDER BY NazevUctu ASC";
$moje_bank_ucty = mysql_query($sql_moje_bank_ucty, $id_spojeni);
IF (!$moje_bank_ucty)
{
  ECHO mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  DIE('Nepodaøilo se nám poslat SQL dotaz na moje bankovni ucty.');
} 
ECHO 'Dotaz na moje bankovni ucty odeslan.<br>';


?>
<INPUT type='hidden' name='typ_uctu' value='sporici'>
<TABLE BORDER=0 width=600>
<CAPTION><B>Editace existujiciho SPORICIHO uctu</B></CAPTION>
<TR><TD>Nazev uctu:</TD>
<TD COLSPAN=2><U><?php ECHO $radek_detaily_uctu['NazevUctu']; ?></U></TD></TR>
<INPUT type='hidden' name='nazev_uctu' value='<?php ECHO $radek_detaily_uctu['NazevUctu']; ?>'>

<TR><TD>Cislo uctu:</TD>
<?php IF($radek_detaily_uctu['Cislo'] != NULL){ ?>
<TD COLSPAN=2><?php ECHO $radek_detaily_uctu['Predcisli']; ?>
<INPUT type='hidden' name='ucet_predcisli' value='<?php ECHO $radek_detaily_uctu['Predcisli']; ?>'>
 -
<?php ECHO $radek_detaily_uctu[4]; ?>
<INPUT type='hidden' name='ucet_cislo' value='<?php ECHO $radek_detaily_uctu['Cislo']; ?>'>
 /
<?php }
ELSE { ?>
<TD><INPUT type='text' name='ucet_predcisli' size=4 maxlength=6 value='<?php ECHO $radek_detaily_uctu['Predcisli']; ?>'>
 -
<INPUT type='text' name='ucet_cislo' size=9 maxlength=10 value='<?php ECHO $radek_detaily_uctu['Cislo']; ?>'>
 /
<?php }
ECHO $radek_detaily_uctu['KodBanky']; ?></TD></TR>
<INPUT type='hidden' name='ucet_kod_banky' value='<?php ECHO $radek_detaily_uctu['KodBanky']; ?>'></TD></TR>

<TR><TD>Varianta uctu:</TD>
<TD COLSPAN=2><?php ECHO $radek_detaily_uctu['Ucet_varianta']; ?></TD></TR>

<TR><TD>Web adresa:</TD>
<TD><INPUT type='text' name='ucet_www' size=32 value='<?php ECHO $radek_detaily_uctu['Www']; ?>'></TD></TR>

<TR><TD>Mena uctu:</TD>
<TD><?php ECHO $radek_detaily_uctu['Mena']; ?></TD></TR>

<TR><TD>Datum zalozeni uctu:</TD>
<TD><?php ECHO $radek_detaily_uctu['Zalozeni']; ?></TD></TR>

<TR><TD>Stav uctu:</TD>
<TD><?php ECHO $radek_detaily_uctu['Stav']; ?></TD></TR>

<TR><TD>Minimalni zustatek <SUP>*</SUP>:<BR><FONT size=1> pro automaticke planovani plateb a platby kartou</FONT></TD>
<TD><INPUT type='text' name='ucet_min_zustatek' size=8 value='<?php ECHO $radek_detaily_uctu['MinZustatek']; ?>'></TD></TR>

<TR><TD>Vyse uroku <SUP>*</SUP>:</TD>
<TD><INPUT type='text' name='ucet_urok' size=6 value='<?php ECHO $radek_detaily_uctu['Urok']; ?>'>%</TD></TR>

<TR><TD rowspan=3 valign='top'>Prebytecne prostredky:<BR><FONT size=1>nad minimalni zustatek</FONT></TD>
<TD>
<INPUT type='radio' name='ucet_prevod' value=1 <?php IF($radek_detaily_uctu['Urok_prevod']==1){ECHO 'checked';} ?> > Odecitat na budouci platby</TD></TR>
<TR><TD>
<INPUT type='radio' name='ucet_prevod' value=2 <?php IF($radek_detaily_uctu['Urok_prevod']==2){ECHO 'checked';} ?> 
<?php

IF (mysql_num_rows($moje_spor_ucty) == 0)
{

echo "disabled><FONT color='silver'> Prevadet na sporici ucet..</FONT>";

}
ELSE
{
ECHO '> Prevadet na jiny sporici ucet..';


?>



<SELECT name='ucet_muj'>

<OPTION value=''></OPTION>
<?php
WHILE($radek_moje_spor_ucty = mysql_fetch_array($moje_spor_ucty))
{
   
     ECHO '<OPTION value='. $radek_moje_spor_ucty[0];
     IF($radek_detaily_uctu[20]==$radek_moje_spor_ucty[0]){ECHO ' selected';}
     ECHO '>'. $radek_moje_spor_ucty[0] .'</OPTION>';
   
}

}
?>

</TD>
</TR>

<TR><TD>
<INPUT type='radio' name='ucet_prevod' value=3 <?php IF($radek_detaily_uctu['Urok_prevod']==3){ECHO 'checked';} ?> > Nechavat</TD></TR>

<TR><TD valign='top'>Preddefinovane transakcni ucty <SUP>*</SUP>:</TD>
<TD>
<?php

$trans_ucet = ARRAY();

WHILE($radek_moje_bank_ucty = mysql_fetch_row($moje_bank_ucty))
{
      ECHO "<INPUT type='checkbox' name='trans_ucet[]' value=$radek_moje_bank_ucty[0]";
      IF(in_array($radek_moje_bank_ucty[0], explode(",", $radek_detaily_uctu['Urok_ucet']))){ECHO ' checked';}
      ECHO '>'. $radek_moje_bank_ucty[0] .'<BR>';
}
?>
<INPUT type='checkbox' name='trans_ucet[]' value=0 <?php IF(in_array(0, explode(",", $radek_detaily_uctu['Urok_ucet']))){ECHO ' checked';} ?> > zadny z uvedenych
</TD>
</TR>

<TR><TD>Debetni karta <SUP>*</SUP>:</TD>
<TD>
<INPUT type='radio' name='ucet_karta' value='Ano' <?php IF($radek_detaily_uctu['Karta']=='Ano'){ECHO 'checked';} ?>> Ano
<INPUT type='radio' name='ucet_karta' value='Ne' <?php IF($radek_detaily_uctu['Karta']=='Ne'){ECHO 'checked';} ?>> Ne
</TD>
</TR>

<TR><TD>- nazev karty:</TD>
<TD><INPUT type='text' name='ucet_karta_nazev' size=32 maxlength=30 value='<?php ECHO $radek_detaily_uctu['Karta_nazev']; ?>'></TD></TR>

<TR><TD>- posledni 4-cisli karty:<BR><FONT size=1> pro identifikaci plateb z uctenek</FONT></TD>
<TD><INPUT type='text' name='ucet_karta_cislo' size=4 maxlength=4 value='<?php ECHO $radek_detaily_uctu['Karta_cislo']; ?>'></TD></TR>

<TR><TD>- mesicni limit karty:<BR><FONT size=1> orientacni castka, kterou nechci prekrocit</FONT></TD>
<TD><INPUT type='text' name='ucet_karta_limit' size=6 value='<?php ECHO $radek_detaily_uctu['Karta_limit']; ?>'></TD></TR>


<TR><TD rowspan=2 valign='top'>Vypis z uctu <SUP>*</SUP>:</TD>
<TD>
<INPUT type='radio' name='ucet_vypis' value='Elektronicky' <?php IF($radek_detaily_uctu[Vypis]=='Elektronicky'){ECHO 'checked';} ?> > Elektronicky</TD></TR>
<TR><TD>
<INPUT type='radio' name='ucet_vypis' value='Papirovy' <?php IF($radek_detaily_uctu[Vypis]=='Papirovy'){ECHO 'checked';} ?>> Papirovy</TD></TR>


</TABLE>




<?php
}

ELSEIF ($_POST['typ_uctu'] == 'kreditni')
{
?>
<INPUT type='hidden' name='typ_uctu' value='kreditni'>
<TABLE BORDER=0 width=600>
<CAPTION><B>Editace existujici KREDITNI karty</B></CAPTION>
<TR><TD>Nazev karty:</TD>
<TD><U><?php ECHO $radek_detaily_uctu[2]; ?></U>
<INPUT type='hidden' name='nazev_uctu' value='<?php ECHO $radek_detaily_uctu[2]; ?>'></TD></TR>

<TR><TD>Cislo karty:</TD>
<TD COLSPAN=2><?php ECHO "xxxx xxxx xxxx $radek_detaily_uctu[18]"; ?>
<INPUT type='hidden' name='ucet_karta_cislo' value='<?php ECHO $radek_detaily_uctu[18]; ?>'></TD></TR>

<TR><TD>Cislo uctu na splatky <SUP>*</SUP>:</TD>
<TD><INPUT type='text' name='ucet_predcisli' size=4 maxlength=6 value='<?php ECHO $radek_detaily_uctu[3]; ?>'>
 -
<INPUT type='text' name='ucet_cislo' size=9 maxlength=10 value='<?php ECHO $radek_detaily_uctu[4]; ?>'>
 /
<?php ECHO $radek_detaily_uctu[5]; ?></TD></TR>
<INPUT type='hidden' name='ucet_kod_banky' value='<?php ECHO $radek_detaily_uctu[5]; ?>'></TD></TR>

<TR><TD>Varianta karty:</TD>
<TD COLSPAN=2><?php ECHO $radek_detaily_uctu[7]; ?></TD></TR>

<TR><TD>Web adresa:</TD>
<TD><INPUT type='text' name='ucet_www' size=32 value='<?php ECHO $radek_detaily_uctu[29]; ?>'></TD></TR>

<TR><TD>Mena uctu:</TD>
<TD><?php ECHO $radek_detaily_uctu[8]; ?></TD></TR>

<TR><TD>Datum aktivace karty:<BR></TD>
<TD><?php ECHO $radek_detaily_uctu[9]; ?></TD></TR>

<TR><TD>Bezurocne obdobi az <SUP>*</SUP>:</TD>
<TD><INPUT type='text' name='karta_bezurok' size=1 maxlength=2 value='<?php ECHO $radek_detaily_uctu[24]; ?>'> dni</TD></TR>

<TR><TD>Aktualne vycerpano:</TD>
<TD><?php ECHO $radek_detaily_uctu[10]; ?></TD></TR>

<TR><TD>Limit karty <SUP>*</SUP>:</TD>
<TD><INPUT type='text' name='ucet_karta_limit' size=6 value='<?php ECHO $radek_detaily_uctu[22]; ?>'></TD></TR>

<TR><TD>Mesicni urok <SUP>*</SUP>:</TD>
<TD><INPUT type='text' name='ucet_urok' size=6 value='<?php ECHO $radek_detaily_uctu[12]; ?>'>%</TD></TR>

<TR><TD>Minimalni mesicni splatka <SUP>*</SUP>:</TD>
<TD><INPUT type='text' name='ucet_min_splatka' size=6 value='<?php ECHO $radek_detaily_uctu[23]; ?>'>%</TD></TR>

<TR><TD>Limit cerpani:<BR><FONT size=1> orientacni castka, kterou nechci prekrocit</FONT></TD>
<TD><INPUT type='text' name='ucet_min_zustatek' size=8 value='<?php ECHO $radek_detaily_uctu[11]; ?>'></TD></TR>


<TR><TD rowspan=2 valign='top'>Vypis z uctu <SUP>*</SUP>:</TD>
<TD>
<INPUT type='radio' name='ucet_vypis' value='Elektronicky' <?php IF($radek_detaily_uctu[16]=='Elektronicky'){ECHO 'checked';} ?> > Elektronicky</TD></TR>
<TR><TD>
<INPUT type='radio' name='ucet_vypis' value='Papirovy' <?php IF($radek_detaily_uctu[16]=='Papirovy'){ECHO 'checked';} ?>> Papirovy</TD></TR>


</TABLE>

<?php
}
ELSEIF ($_POST['typ_uctu'] == 'poj_zivotni' || $_POST['typ_uctu'] == 'poj_penzijni')
{

$sql_aktivni_zdroje = "SELECT Nazev FROM zdroje WHERE not exists(SELECT * FROM moje_ucty WHERE zdroje.Nazev = moje_ucty.Trans_ucet and moje_ucty.TypUctu = '".$_POST['typ_uctu']."') and Typ = 'aktivni' UNION SELECT Trans_ucet FROM moje_ucty WHERE NazevUctu = '".$_POST['muj_ucet']."'";
$aktivni_zdroje = mysql_query($sql_aktivni_zdroje, $id_spojeni);
if (!$aktivni_zdroje)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodaøilo se nám poslat SQL dotaz na aktivni zdroje.');
} 
echo 'Dotaz na aktivni zdroje odeslan.<br>';


$sql_detail_platby = "SELECT * FROM budouci_platby WHERE UcelTransakce='splatka pojisteni - ".$radek_detaily_uctu[2]."'";
$detail_platby = mysql_query($sql_detail_platby, $id_spojeni);
if(!$detail_platby)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodaøilo se nám poslat SQL dotaz na detail platby.');
} 
echo 'Dotaz na detail platby odeslan.<br>';

$radek_detail_platby = mysql_fetch_assoc($detail_platby);

?>
<INPUT type='hidden' name='typ_uctu' value='<?php ECHO $_POST['typ_uctu']; ?>'>
<TABLE BORDER=0>
<CAPTION><B>Editace existujiciho <U>
<?php IF($_POST['typ_uctu'] == 'poj_zivotni'){ECHO 'INVESTICNIHO ZIVOTNIHO</U> ';} 
ELSEIF($_POST['typ_uctu'] == 'poj_penzijni'){ECHO 'PENZIJNIHO</U> PRI';} ?>POJISTENI</B></CAPTION>

<TR><TD>Nazev pojisteni:</TD>
<TD><U><?php ECHO $radek_detaily_uctu[2]; ?></U>
<INPUT type='hidden' name='nazev_uctu' value='<?php ECHO $radek_detaily_uctu[2]; ?>'></TD></TR>

<TR><TD>Cislo smlouvy:</TD>
<?php IF($radek_detaily_uctu[35] != NULL){ ?>
<TD COLSPAN=2><?php ECHO $radek_detaily_uctu[35]; ?>
<INPUT type='hidden' name='ucet_smlouva' value='<?php ECHO $radek_detaily_uctu[35]; ?>'></TD>
<?php }
ELSE { ?>
<TD><INPUT type='text' name='ucet_smlouva' size=9 maxlength=10></TD>
<?php 
}
?>
</TR>

<TR><TD>Cislo uctu:</TD>
<?php IF($radek_detaily_uctu[4] != NULL){ ?>
<TD COLSPAN=2><?php ECHO $radek_detaily_uctu[3]; ?>
<INPUT type='hidden' name='ucet_predcisli' value='<?php ECHO $radek_detaily_uctu[3]; ?>'>
 -
<?php ECHO $radek_detaily_uctu[4]; ?>
<INPUT type='hidden' name='ucet_cislo' value='<?php ECHO $radek_detaily_uctu[4]; ?>'>
 /
<?php }
ELSE { ?>
<TD><INPUT type='text' name='ucet_predcisli' size=4 maxlength=6 value='<?php ECHO $radek_detaily_uctu[3]; ?>'>
 -
<INPUT type='text' name='ucet_cislo' size=9 maxlength=10 value='<?php ECHO $radek_detaily_uctu[4]; ?>'>
 /
<?php }
ECHO $radek_detaily_uctu[5]; ?></TD></TR>
<INPUT type='hidden' name='ucet_kod_banky' value='<?php ECHO $radek_detaily_uctu[5]; ?>'></TD></TR>

<TR><TD>Varianta pojisteni:</TD>
<TD COLSPAN=2><?php ECHO $radek_detaily_uctu[7]; ?>
<INPUT type='hidden' name='ucet_varianta' value='<?php ECHO $radek_detaily_uctu[7]; ?>'></TD></TR>

<TR><TD>Web adresa:</TD>
<TD><INPUT type='text' name='ucet_www' size=32 value='<?php ECHO $radek_detaily_uctu[29]; ?>'></TD></TR>

<TR><TD>Mena uctu:</TD>
<TD><?php ECHO $radek_detaily_uctu[8]; ?></TD></TR>

<TR><TD>Aktualni stav:</TD>
<TD><?php ECHO $radek_detaily_uctu[10]; ?></TD></TR>


<TR><TD>Prispevky:</TD></TR>
<TR><TD>- vlastni <SUP>*</SUP>:</TD>
<TD><INPUT type='text' name='ucet_prispevek_vlastni' size=8 value='<?php ECHO $radek_detaily_uctu[25]; ?>'>
<?php
if($_POST['typ_uctu'] == 'poj_zivotni')
{
?>, z toho <INPUT type='text' name='spor_vlastni' size=8 value='<?php ECHO $radek_detaily_uctu[31]; ?>'> na sporeni.
<?php
}
?>
</TD></TR>

<TR><TD>- zamestnavatel:</TD>
<TD><INPUT type='text' name='ucet_prispevek_zamestnavatel' size=8 value='<?php ECHO $radek_detaily_uctu[26]; ?>'>
<?php
if($_POST['typ_uctu'] == 'poj_zivotni')
{
?>, z toho <INPUT type='text' name='spor_zam' size=8 value='<?php ECHO $radek_detaily_uctu[32]; ?>'> na sporeni.
<?php
}
?>
</TD></TR>

<TR><TD>-- strhavano z vyplaty:</TD>
<TD>

<INPUT type='radio' name='ucet_prispevek_platba' value='Ano'<?php IF($radek_detaily_uctu[28]=='Ano'){ECHO 'checked';} ?>> Ano, z vyplaty od 
<SELECT name='trans_ucet'>
<OPTION value=''></OPTION>
<?php
while($radek_aktivni_zdroje = mysql_fetch_row($aktivni_zdroje)){
echo "<OPTION value='$radek_aktivni_zdroje[0]'";
IF($radek_detaily_uctu[21]==$radek_aktivni_zdroje[0] && $radek_detaily_uctu[28]=='Ano'){ECHO 'selected';} 
echo ">$radek_aktivni_zdroje[0]</OPTION>";
}

$zalozeni = strtotime($radek_detaily_uctu[9]);
$zalozeni_rok = Date("Y", $zalozeni);
$zalozeni_mesic = Date("m", $zalozeni);
//$zalozeni_den = Date("d", $zalozeni);

?>
</SELECT>
<BR>

<INPUT type='radio' name='ucet_prispevek_platba' value='Ne' <?php IF($radek_detaily_uctu[28]=='Ne'){ECHO 'checked';} ?>> 
Ne, platby k <INPUT type='text' name='ucet_zalozeni_den' value='<?php echo $radek_detail_platby['PlatbaKeDni']; ?>' size=1 maxlength=2>. dni v mesici formou <SELECT name='prispevek_forma'>
<OPTION value=''></OPTION>
<OPTION value='TP' <?php if($radek_detail_platby['Forma'] == 'TP'){echo 'selected';} ?>>trvaleho prikazu</OPTION>
<OPTION value='S' <?php if($radek_detail_platby['Forma'] == 'S'){echo 'selected';} ?>>preddefinovane sablony</OPTION>
<OPTION value='JP' <?php if($radek_detail_platby['Forma'] == 'JP'){echo 'selected';} ?>>jednorazoveho prikazu</OPTION>
<OPTION value='J' <?php if($radek_detail_platby['Forma'] == 'J'){echo 'selected';} ?>>jineho prikazu</OPTION>
</SELECT>


</TD></TR>                                

<TR><TD>- treti osoba:</TD>
<TD><INPUT type='text' name='ucet_prispevek_tretiOsoba' size=8 value='<?php ECHO $radek_detaily_uctu[27]; ?>'>
<?php
if($_POST['typ_uctu'] == 'poj_zivotni')
{
?>, z toho <INPUT type='text' name='spor_treti' size=8 value='<?php ECHO $radek_detaily_uctu[33]; ?>'> na sporeni.
<?php
}
?>
</TD></TR>

<TR><TD>Rok a mesic nejblizsi platby <SUP>*</SUP>:</TD>
<TD>
<INPUT type='text' name='ucet_zalozeni_rok' value='<?php echo $zalozeni_rok; ?>' size=3 maxlength=4> -
<INPUT type='text' name='ucet_zalozeni_mesic' value='<?php echo $zalozeni_mesic; ?>' size=1 maxlength=2><FONT size=2 color=gray>(RRRR-MM)</FONT><BR>
</TD></TR>

<TR><TD>Frekvence plateb <SUP>*</SUP>:</TD>
<TD>jednou za <INPUT type='text' name='ucet_prispevek_frekvence' value='<?php echo $radek_detaily_uctu[34]; ?>' size=1 maxlength=2> mesic(e) 
</TD></TR>


</TABLE>

<?php
}

ELSEIF ($_POST['typ_uctu'] == 'jiny')
{
?>
<INPUT type='hidden' name='typ_uctu' value='jiny'>
<TABLE BORDER=0 width=400>
<CAPTION><B>Editace existujiciho JINEHO typu uctu </B></CAPTION>

<TR><TD>Nazev uctu:</TD>
<TD><U><?php ECHO $radek_detaily_uctu[2]; ?></U>
<INPUT type='hidden' name='nazev_uctu' value='<?php ECHO $radek_detaily_uctu[2]; ?>'></TD></TR>

<TR><TD>Cislo uctu:</TD>
<?php IF($radek_detaily_uctu[4] != NULL){ ?>
<TD COLSPAN=2><?php ECHO $radek_detaily_uctu[3]; ?>
<INPUT type='hidden' name='ucet_predcisli' value='<?php ECHO $radek_detaily_uctu[3]; ?>'>
 -
<?php ECHO $radek_detaily_uctu[4]; ?>
<INPUT type='hidden' name='ucet_cislo' value='<?php ECHO $radek_detaily_uctu[4]; ?>'>
 /
<?php }
ELSE { ?>
<TD><INPUT type='text' name='ucet_predcisli' size=4 maxlength=6 value='<?php ECHO $radek_detaily_uctu[3]; ?>'>
 -
<INPUT type='text' name='ucet_cislo' size=9 maxlength=10 value='<?php ECHO $radek_detaily_uctu[4]; ?>'>
 /
<?php }
ECHO $radek_detaily_uctu[5]; ?></TD></TR>
<INPUT type='hidden' name='ucet_kod_banky' value='<?php ECHO $radek_detaily_uctu[5]; ?>'></TD></TR>

<TR><TD>Web adresa:</TD>
<TD><INPUT type='text' name='ucet_www' size=32 value='<?php ECHO $radek_detaily_uctu[29]; ?>'></TD></TR>

<TR><TD>Mena uctu:</TD>
<TD><?php ECHO $radek_detaily_uctu[8]; ?></TD></TR>

<TR><TD>Aktualni stav:</TD>
<TD><?php ECHO $radek_detaily_uctu[10]; ?></TD></TR>

<TR><TD rowspan=4 valign='top'>Specifikace uctu:</TD>
<TD><?php IF($radek_detaily_uctu[7] == 'sazky'){ECHO 'Sazkarsky ucet';}
ELSEIF($radek_detaily_uctu[7] == 'penezenka'){ECHO 'Elektronicka penezenka';}
ELSEIF($radek_detaily_uctu[7] == 'none'){ECHO 'Nespecifikovano';}
ELSE ECHO $radek_detaily_uctu[7]; ?>
</TD></TR>


</TABLE>

<?php 
} 

IF($id_spojeni)
{
  mysql_close($id_spojeni);
  ECHO 'odpojeno<br>';
}

?>            

<INPUT type=button onclick="history.back()" value="Zpět"> 
<INPUT type='submit' name='next-detail_edit_uctu' value='Pokracuj'>

</FORM>



</FONT></CENTER>
</BODY>
</HTML>