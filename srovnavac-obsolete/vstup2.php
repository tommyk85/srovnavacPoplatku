
<?php


//    DEFINICE PROMENNYCH ZE VSTUPU 1
$zustatek = str_replace(' ','',Trim($_POST['zustatek']));
$banking = isset($_POST['banking']) ? $_POST['banking'] : Null;
$banking = $_POST['krok2'] == 'Pokračovat' && isset($_POST['banking']) ? implode(",", $_POST['banking']) : $banking;


//    KONTROLA VSTUPNICH DAT
$check = array();
$check['typ'] = !isset($_POST['typ']) ? '[CHYBA-TYP] Vyberte typ požadovaného účtu.[/CHYBA-TYP]' : Null;
$check['mena'] = !isset($_POST['mena']) ? '[CHYBA-MENA] Vyberte požadovanou měnu účtu.[/CHYBA-MENA]' : Null;
$check['zustatek'] = $zustatek == Null ? '[CHYBA-ZUSTATEK] Zadejte pravidelný zůstatek na účtu.[/CHYBA-ZUSTATEK]' : Null;
$check['zustatek'] = !ctype_digit($zustatek) && $zustatek ? '[CHYBA-ZUSTATEK] Pravidelný zůstatek na účtu musí být celé, kladné číslo, bez dalších znaků.[/CHYBA-ZUSTATEK]' : $check['zustatek']; 
$check['banking'] = $banking == Null ? '[CHYBA-BANKING] Vyberte možnost ovládání účtu.[/CHYBA-BANKING]' : Null;
$check['info'] = !isset($_POST['info']) ? '[CHYBA-INFO] Vyberte možnost info služeb k transakcím z účtu.[/CHYBA-INFO]' : Null;
$check['karta'] = !isset($_POST['karta']) ? '[CHYBA-KARTA] Vyberte možnost debetní karty k účtu.[/CHYBA-KARTA]' : Null;

/*
foreach ($check as $hodnota)
{
  echo "<span class='chyba'>$hodnota</span>";
}
*/

?>



<form action='' method='post'>

<input type='hidden' name='typ' value='<?php echo $_POST['typ']; ?>'>
<input type='hidden' name='mena' value='<?php echo $_POST['mena']; ?>'>
<input type='hidden' name='zustatek' value='<?php echo $zustatek; ?>'>
<input type='hidden' name='banking' value='<?php echo $banking; ?>'>
<input type='hidden' name='info' value='<?php echo $_POST['info']; ?>'>
<input type='hidden' name='karta' value='<?php echo $_POST['karta']; ?>'>

<input type='hidden' name='chyby' value='<?php echo implode(",", $check); ?>'>

<input type='hidden' name='prijem' value='<?php echo (isset($_POST['prijem']) ? $_POST['prijem'] : ''); ?>'>
<input type='hidden' name='prichozi' value='<?php echo (isset($_POST['prichozi']) ? $_POST['prichozi'] : ''); ?>'>
<input type='hidden' name='kod_banky' value='<?php echo (isset($_POST['kod_banky']) ? $_POST['kod_banky'] : ''); ?>'>
<input type='hidden' name='vydaje' value='<?php echo (isset($_POST['vydaje']) ? $_POST['vydaje'] : ''); ?>'>
<input type='hidden' name='odchozi' value='<?php echo (isset($_POST['odchozi']) ? $_POST['odchozi'] : ''); ?>'>
<input type='hidden' name='odch_tp' value='<?php echo (isset($_POST['odch_tp']) ? $_POST['odch_tp'] : ''); ?>'>
<input type='hidden' name='vypis' value='<?php echo (isset($_POST['vypis']) ? $_POST['vypis'] : ''); ?>'>
<input type='hidden' name='karta_celkem' value='<?php echo (isset($_POST['karta_celkem']) ? $_POST['karta_celkem'] : ''); ?>'>
<input type='hidden' name='vybery' value='<?php echo (isset($_POST['vybery']) ? $_POST['vybery'] : ''); ?>'>
<input type='hidden' name='cashback' value='<?php echo (isset($_POST['cashback']) ? $_POST['cashback'] : ''); ?>'>


<?php

  if (implode("", ($check))!=Null)
  {
die ("<span style='color:red'>Chybné, nebo neúplné zadání - </span>
<INPUT type='submit' name='krok1' value='Opravit'></form>");

//  die ("<input type=button onclick='history.back()' value='Zpět'>"); 	
  }

//   KONEC KONTROLY VSTUPNICH DAT







include "../pripojeni_sql.php";

?>
<BR>

<center>
<DIV class='dotaznik'>
<TABLE width=600>

<TR><TD colspan=2 style='font-size: large'> <B>Krok číslo 2/3, základní osobní údaje</B> <FONT size=2>(nutné k odfiltrování Vám dostupných účtů)</FONT></TD></TR>

<TR><TD style='font-weight: bold'>Váš věk: </TD>
<TD>

<SELECT name='vek'>
<OPTION value=14 <?php echo (isset($_POST['vek']) && $_POST['vek'] == 14 ? 'selected' : Null) ?>>10-14</OPTION>
<OPTION value=17 <?php echo (isset($_POST['vek']) && $_POST['vek'] == 17 ? 'selected' : Null) ?>>15-17</OPTION>
<OPTION value=25 <?php echo ((isset($_POST['vek']) && $_POST['vek'] == 25) || $_POST['vek'] == Null ? 'selected' : Null) ?>>18-25</OPTION>
<OPTION value=26 <?php echo (isset($_POST['vek']) && $_POST['vek'] == 26 ? 'selected' : Null) ?>>26</OPTION>
<OPTION value=27 <?php echo (isset($_POST['vek']) && $_POST['vek'] == 27 ? 'selected' : Null) ?>>27</OPTION>
<OPTION value=30 <?php echo (isset($_POST['vek']) && $_POST['vek'] == 30 ? 'selected' : Null) ?>>28-30</OPTION>
<OPTION value=31 <?php echo (isset($_POST['vek']) && $_POST['vek'] == 31 ? 'selected' : Null) ?>>31+</OPTION>
</SELECT>
</TD></TR>

<TR><TD valign='top' style='font-weight: bold'>Zařazení: </TD>
<TD valign='top'>
<?php 
echo (isset($_POST['chyby']) && strpos($_POST['chyby'], "CHYBA-ZARAZENI") > 0 ? str_replace("[CHYBA-ZARAZENI]", "<span class='chyba'>", substr($_POST['chyby'], strpos($_POST['chyby'], "[CHYBA-ZARAZENI]"), strrpos($_POST['chyby'], "[/CHYBA-ZARAZENI]") - strrpos($_POST['chyby'], "[CHYBA-ZARAZENI]")))."</span><br>" : Null); 
?>
<INPUT type='radio' name='zarazeni' value=1 <?php echo (isset($_POST['zarazeni']) && $_POST['zarazeni'] == 1 ? 'checked' : Null) ?>> student - prezenčně<BR>
<INPUT type='radio' name='zarazeni' value=2 <?php echo (isset($_POST['zarazeni']) && $_POST['zarazeni'] == 2 ? 'checked' : Null) ?>> student - dálkově<BR>
<INPUT type='radio' name='zarazeni' value=3 <?php echo (isset($_POST['zarazeni']) && $_POST['zarazeni'] == 3 ? 'checked' : Null) ?>> fyzická osoba nepodnikatel<BR>
<INPUT type='radio' name='zarazeni' value=4 <?php echo (isset($_POST['zarazeni']) && $_POST['zarazeni'] == 4 ? 'checked' : Null) ?> disabled> fyzická osoba podnikatel <span class='help'>- zatím nezpracováno</span>
</TD></TR>                                

<TR><TD style="vertical-align:top" rowspan=3>Nejvyšší dosažené vzdělání: <BR><span class='help'>(povinné údaje, pokud již nejste student)</span></TD>
<TD>
<?php 
echo (isset($_POST['chyby']) && strpos($_POST['chyby'], "CHYBA-VZDELANI]") > 0 ? str_replace("[CHYBA-VZDELANI]", "<span class='chyba'>", substr($_POST['chyby'], strpos($_POST['chyby'], "[CHYBA-VZDELANI]"), strrpos($_POST['chyby'], "[/CHYBA-VZDELANI]") - strrpos($_POST['chyby'], "[CHYBA-VZDELANI]")))."</span><br>" : Null); 
?>
<INPUT type='radio' name='vzdelani' value='ZS' <?php echo (isset($_POST['vzdelani']) && $_POST['vzdelani'] == 'ZS' ? 'checked' : Null) ?>> Základní škola<BR>
<INPUT type='radio' name='vzdelani' value='SS' <?php echo (isset($_POST['vzdelani']) && $_POST['vzdelani'] == 'SS' ? 'checked' : Null) ?>> Střední škola<BR>
<INPUT type='radio' name='vzdelani' value='SO' <?php echo (isset($_POST['vzdelani']) && $_POST['vzdelani'] == 'SO' ? 'checked' : Null) ?>> Střední odborná škola nebo učiliště<BR>                     
<INPUT type='radio' name='vzdelani' value='VS' <?php echo (isset($_POST['vzdelani']) && $_POST['vzdelani'] == 'VS' ? 'checked' : Null) ?>> Vysoká škola<BR>
<INPUT type='radio' name='vzdelani' value='VO' <?php echo (isset($_POST['vzdelani']) && $_POST['vzdelani'] == 'VO' ? 'checked' : Null) ?>> Vyšší odborná škola
</TD>
</TR>

<TR>
<TD>
<?php 
echo (isset($_POST['chyby']) && strpos($_POST['chyby'], "CHYBA-VZDELANI_ROK") > 0 ? str_replace("[CHYBA-VZDELANI_ROK]", "<span class='chyba'>", substr($_POST['chyby'], strpos($_POST['chyby'], "[CHYBA-VZDELANI_ROK]"), strrpos($_POST['chyby'], "[/CHYBA-VZDELANI_ROK]") - strrpos($_POST['chyby'], "[CHYBA-VZDELANI_ROK]")))."</span><br>" : Null); 
?>
- v roce: <INPUT type='text' name='vzdelani_rok' size=4 maxlength=4 value='<?php echo (isset($_POST['vzdelani_rok']) ? $_POST['vzdelani_rok'] : Null) ?>'>
</TD>
</TR>

<TR>
<TD>
<?php 
echo (isset($_POST['chyby']) && strpos($_POST['chyby'], "CHYBA-VZDELANI_FORMA") > 0 ? str_replace("[CHYBA-VZDELANI_FORMA]", "<span class='chyba'>", substr($_POST['chyby'], strpos($_POST['chyby'], "[CHYBA-VZDELANI_FORMA]"), strrpos($_POST['chyby'], "[/CHYBA-VZDELANI_FORMA]") - strrpos($_POST['chyby'], "[CHYBA-VZDELANI_FORMA]")))."</span><br>" : Null); 
?>
- formou studia:
<INPUT type='radio' name='vzdelani_forma' value='denni' <?php echo (isset($_POST['vzdelani_forma']) && $_POST['vzdelani_forma'] == 'denni' ? 'checked' : Null) ?>> prezenčně 
<INPUT type='radio' name='vzdelani_forma' value='dalkove' <?php echo (isset($_POST['vzdelani_forma']) && $_POST['vzdelani_forma'] == 'dalkove' ? 'checked' : Null) ?>> dálkově
</TD>
</TR>


<TR><TD valign='top'>Současný účet: </TD>
<TD>

<SELECT name='kod_akt_banky'>
<OPTION value='ne' <?php echo (isset($_POST['kod_akt_banky']) && $_POST['kod_akt_banky'] == 'ne' ? 'selected' : Null) ?>>...nemám, nebo nechci uvádět</OPTION>
<?php

$sql_id_uctu = "SELECT VariantaUctu, nazev_banky FROM ucty INNER JOIN banky ON ucty.KodBanky = banky.kod_banky WHERE TypUctu like 'bezny%' ORDER BY VariantaUctu ASC";

$id_uctu = mysql_query($sql_id_uctu,$id_spojeni);
if (!$id_uctu)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodařilo se nám poslat SQL dotaz na kody bank.');
} 
echo 'Dotaz na kody bank byl odeslan.<br>';

while($radek_id_uctu = mysql_fetch_row($id_uctu))
{

     echo "<OPTION value='".$radek_id_uctu[0]."' ".(isset($_POST['kod_akt_banky']) && $_POST['kod_akt_banky'] == $radek_id_uctu[0] ? 'selected' : Null).">". $radek_id_uctu[0] .", ". $radek_id_uctu[1] ."</OPTION>";
    
}

?>
<OPTION value='none' <?php echo (isset($_POST['kod_akt_banky']) && $_POST['kod_akt_banky'] == 'none' ? 'selected' : Null) ?>>...žádný z uvedených</OPTION>
</SELECT>

</TD>
</TR> 

</TABLE>
</DIV>
<P>
<INPUT type='submit' name='krok1' value='Zpět'>
<INPUT type='submit' name='krok3' value='Pokračovat'>
</center>
</FORM>


<?php
if($id_spojeni)
{
  mysql_close($id_spojeni);
  //echo 'odpojeno<br>';
}
?>
