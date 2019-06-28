
<?php

//    DEFINICE PROMENNYCH ZE VSTUPU 2
$vek = $_POST['vek'];
$zarazeni = isset($_POST['zarazeni']) ? $_POST['zarazeni'] : Null;
$vzdelani = isset($_POST['vzdelani']) ? $_POST['vzdelani'] : Null;
$vzdelani = $zarazeni > 2 ? $vzdelani : Null;
$vzdelani_rok = str_replace(' ','',Trim($_POST['vzdelani_rok']));
$vzdelani_rok = $zarazeni > 2 ? $vzdelani_rok : Null;
$vzdelani_forma = isset($_POST['vzdelani_forma']) ? $_POST['vzdelani_forma'] : Null;
$vzdelani_forma = $zarazeni > 2 ? $vzdelani_forma : Null;
$kod_akt_banky = $_POST['kod_akt_banky'] <> '' ? $_POST['kod_akt_banky'] : 'ne';


//    KONTROLA VSTUPNICH DAT
$check = array();
$check['zarazeni'] = !$zarazeni ? '[CHYBA-ZARAZENI] Vyberte Vaše zařazení.[/CHYBA-ZARAZENI]' : Null;
$check['vzdelani'] = $zarazeni > 2 && $vzdelani == Null ? '[CHYBA-VZDELANI] Vyberte nejvyšší dosažené vzdělání.[/CHYBA-VZDELANI]' : Null;
$check['vzdelani_rok'] = $zarazeni > 2 && $vzdelani_rok == Null ? '[CHYBA-VZDELANI_ROK] Zadejte rok dosažení výše uvedeného vzdělání.[/CHYBA-VZDELANI_ROK]' : Null; 
$check['vzdelani_rok'] = !ctype_digit($vzdelani_rok) && $vzdelani_rok ? '[CHYBA-VZDELANI_ROK] Rok dosažení výše uvedeného vzdělání musí být celé, kladné číslo, bez dalších znaků.[/CHYBA-VZDELANI_ROK]' : $check['vzdelani_rok']; 
$check['vzdelani_forma'] = $zarazeni > 2 && $vzdelani_forma == Null ? '[CHYBA-VZDELANI_FORMA] Vyberte způsob, formu, dosažení výše uvedeného vzdělání.[/CHYBA-VZDELANI_FORMA]' : Null;

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
<input type='hidden' name='zustatek' value='<?php echo $_POST['zustatek']; ?>'>
<input type='hidden' name='banking' value='<?php echo $_POST['banking']; ?>'>
<input type='hidden' name='info' value='<?php echo $_POST['info']; ?>'>
<input type='hidden' name='karta' value='<?php echo $_POST['karta']; ?>'>

<input type='hidden' name='vek' value='<?php echo $vek; ?>'>
<input type='hidden' name='zarazeni' value='<?php echo $zarazeni; ?>'>
<input type='hidden' name='vzdelani' value='<?php echo $vzdelani; ?>'>
<input type='hidden' name='vzdelani_rok' value='<?php echo $vzdelani_rok; ?>'>
<input type='hidden' name='vzdelani_forma' value='<?php echo $vzdelani_forma; ?>'>
<input type='hidden' name='kod_akt_banky' value='<?php echo $kod_akt_banky; ?>'>


<input type='hidden' name='chyby' value='<?php echo implode(",", $check); ?>'>


<?php

  if (implode("", ($check))!=Null)
  {
die ("<span style='color:red'>Chybné, nebo neúplné zadání - </span>
<INPUT type='submit' name='krok2' value='Opravit'></form>");

//  die ("<input type=button onclick='history.back()' value='Zpět'>"); 	
  }

//   KONEC KONTROLY VSTUPNICH DAT


 
include "../pripojeni_sql.php";
?>

<center>
<DIV class='dotaznik'>
<TABLE width=600>

<TR><TD colspan=2 style='font-size: large'> <B>Krok číslo 3/3, měsíční tuzemské, pravidelné, transakce</B> <FONT size=2>(ve zvolené měně účtu)</FONT></TD></TR>
<TR>
<TD>Celkový příjem: <span class='help'>(bez příjmů z vlastních účtů, nepovinný údaj)</span></TD>
<TD>
<?php 
echo (isset($_POST['chyby']) && strpos($_POST['chyby'], "CHYBA-PRIJEM]") > 0 ? str_replace("[CHYBA-PRIJEM]", "<span class='chyba'>", substr($_POST['chyby'], strpos($_POST['chyby'], "[CHYBA-PRIJEM]"), strrpos($_POST['chyby'], "[/CHYBA-PRIJEM]") - strrpos($_POST['chyby'], "[CHYBA-PRIJEM]")))."</span><br>" : Null); 
?>
<INPUT type='text' name='prijem' size=6 maxlength=8 value='<?php echo ($_POST['prijem'] != Null ? $_POST['prijem'] : Null) ?>'>
</TD>
</TR>

<TR>
<TD>Počet příchozích plateb: <span class='help'>(nepovinný údaj)</span></TD>
<TD>
<?php 
echo (isset($_POST['chyby']) && strpos($_POST['chyby'], "CHYBA-PRICHOZI]") > 0 ? str_replace("[CHYBA-PRICHOZI]", "<span class='chyba'>", substr($_POST['chyby'], strpos($_POST['chyby'], "[CHYBA-PRICHOZI]"), strrpos($_POST['chyby'], "[/CHYBA-PRICHOZI]") - strrpos($_POST['chyby'], "[CHYBA-PRICHOZI]")))."</span><br>" : Null); 
?>
<INPUT type='text' name='prichozi' size=2 maxlength=2 value='<?php echo ($_POST['prichozi'] != Null ? $_POST['prichozi'] : Null) ?>'>
</TD>
</TR>

<TR>
<TD valign='top'>Banka, odkud platby přichází: </TD>
<TD>
<?php 
echo (isset($_POST['chyby']) && strpos($_POST['chyby'], "CHYBA-KOD_BANKY]") > 0 ? str_replace("[CHYBA-KOD_BANKY]", "<span class='chyba'>", substr($_POST['chyby'], strpos($_POST['chyby'], "[CHYBA-KOD_BANKY]"), strrpos($_POST['chyby'], "[/CHYBA-KOD_BANKY]") - strrpos($_POST['chyby'], "[CHYBA-KOD_BANKY]")))."</span><br>" : Null); 
?>
<SELECT name='kod_banky'>
<OPTION value='ruzne'>...různé</OPTION>
<?php

$sql_id_banky = "SELECT * FROM banky ORDER BY kod_banky ASC";

$id_banky = mysql_query($sql_id_banky,$id_spojeni);
if (!$id_banky)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodařilo se nám poslat SQL dotaz na kody bank.');
} 
echo 'Dotaz na kody bank byl odeslan.<br>';

while($radek_id_banky = mysql_fetch_row($id_banky))
{

     echo "<OPTION value='". $radek_id_banky[0]."' ".(isset($_POST['kod_banky']) && $_POST['kod_banky'] == $radek_id_banky[0] ? 'selected' : Null) .">". $radek_id_banky[0] ." - ". $radek_id_banky[1] ."</OPTION>";
    
}

?>
<OPTION value='none' <?php echo (isset($_POST['kod_banky']) && $_POST['kod_banky'] == 'none' ? 'selected' : Null) ?>>...není v seznamu
</OPTION>
</SELECT>
</TD>
</TR>


<TR>
<TD>Celkové výdaje: <span class='help'>(bez transakcí kartou, nepovinný údaj)</span></TD>
<TD>
<?php 
echo (isset($_POST['chyby']) && strpos($_POST['chyby'], "CHYBA-VYDAJE]") > 0 ? str_replace("[CHYBA-VYDAJE]", "<span class='chyba'>", substr($_POST['chyby'], strpos($_POST['chyby'], "[CHYBA-VYDAJE]"), strrpos($_POST['chyby'], "[/CHYBA-VYDAJE]") - strrpos($_POST['chyby'], "[CHYBA-VYDAJE]")))."</span><br>" : Null); 
?>
<INPUT type='text' name='vydaje' size=6 maxlength=8 value='<?php echo ($_POST['vydaje'] != Null ? $_POST['vydaje'] : Null) ?>'>
</TD>
</TR>

<TR>
<TD style="vertical-align:top; font-weight: bold">Počet odchozích plateb <br><span class='help'>(mimo online plateb přímo u obchodníka)</span></TD>
<TD>
<?php 
echo (isset($_POST['chyby']) && strpos($_POST['chyby'], "CHYBA-ODCHOZI]") > 0 ? str_replace("[CHYBA-ODCHOZI]", "<span class='chyba'>", substr($_POST['chyby'], strpos($_POST['chyby'], "[CHYBA-ODCHOZI]"), strrpos($_POST['chyby'], "[/CHYBA-ODCHOZI]") - strrpos($_POST['chyby'], "[CHYBA-ODCHOZI]")))."</span><br>" : Null); 
echo (isset($_POST['chyby']) && strpos($_POST['chyby'], "CHYBA-ODCH_TP]") > 0 ? str_replace("[CHYBA-ODCH_TP]", "<span class='chyba'>", substr($_POST['chyby'], strpos($_POST['chyby'], "[CHYBA-ODCH_TP]"), strrpos($_POST['chyby'], "[/CHYBA-ODCH_TP]") - strrpos($_POST['chyby'], "[CHYBA-ODCH_TP]")))."</span><br>" : Null); 
?>
celkem:<INPUT type='text' name='odchozi' size=2 maxlength=3 value='<?php echo ($_POST['odchozi'] != Null ? $_POST['odchozi'] : Null) ?>'>, z toho trvalých příkazů:

<INPUT type='text' name='odch_tp' size=2 maxlength=3 value='<?php echo ($_POST['odch_tp'] != Null ? $_POST['odch_tp'] : 0) ?>'></TD>
</TR>

<TR><TD valign='top' style='font-weight: bold'>Forma měsíčního výpisu: </TD>
<TD>
<?php 
echo (isset($_POST['chyby']) && strpos($_POST['chyby'], "CHYBA-VYPIS") > 0 ? str_replace("[CHYBA-VYPIS]", "<span class='chyba'>", substr($_POST['chyby'], strpos($_POST['chyby'], "[CHYBA-VYPIS]"), strrpos($_POST['chyby'], "[/CHYBA-VYPIS]") - strrpos($_POST['chyby'], "[CHYBA-VYPIS]")))."</span><br>" : Null); 
?>
<INPUT type='radio' name='vypis' value='elektro' <?php echo (isset($_POST['vypis']) && $_POST['vypis'] == 'elektro' ? 'checked' : Null) ?>> Elektronický<BR>
<INPUT type='radio' name='vypis' value='papir' <?php echo (isset($_POST['vypis']) && $_POST['vypis'] == 'papir' ? 'checked' : Null) ?>> Papírový
</TD></TR>


<?php
if ($_POST['karta'] > 0)
{
?>

<TR><TD colspan=2> <B>- transakce debetní kartou:</B> </TD></TR>

<TR>
<TD>Celková hodnota transakcí: </TD>
<TD>
<?php 
echo (isset($_POST['chyby']) && strpos($_POST['chyby'], "CHYBA-KARTA_CELKEM]") > 0 ? str_replace("[CHYBA-KARTA_CELKEM]", "<span class='chyba'>", substr($_POST['chyby'], strpos($_POST['chyby'], "[CHYBA-KARTA_CELKEM]"), strrpos($_POST['chyby'], "[/CHYBA-KARTA_CELKEM]") - strrpos($_POST['chyby'], "[CHYBA-KARTA_CELKEM]")))."</span><br>" : Null); 
?>
<INPUT type='text' name='karta_celkem' size=4 maxlength=6 value='<?php echo (isset($_POST['karta_celkem']) ? $_POST['karta_celkem'] : Null) ?>'></TD>
</TR>

<TR>
<TD>Počet výběrů z bankomatu: </TD>
<TD>
<?php 
echo (isset($_POST['chyby']) && strpos($_POST['chyby'], "CHYBA-VYBERY]") > 0 ? str_replace("[CHYBA-VYBERY]", "<span class='chyba'>", substr($_POST['chyby'], strpos($_POST['chyby'], "[CHYBA-VYBERY]"), strrpos($_POST['chyby'], "[/CHYBA-VYBERY]") - strrpos($_POST['chyby'], "[CHYBA-VYBERY]")))."</span><br>" : Null); 
?>
<INPUT type='text' name='vybery' size=2 maxlength=2 value='<?php echo (isset($_POST['vybery']) ? $_POST['vybery'] : Null) ?>'></TD>
</TR>

<TR>
<TD valign='top' style='font-weight: bold'>Cashback: </TD>
<TD>
<?php 
echo (isset($_POST['chyby']) && strpos($_POST['chyby'], "CHYBA-CASHBACK]") > 0 ? str_replace("[CHYBA-CASHBACK]", "<span class='chyba'>", substr($_POST['chyby'], strpos($_POST['chyby'], "[CHYBA-CASHBACK]"), strrpos($_POST['chyby'], "[/CHYBA-CASHBACK]") - strrpos($_POST['chyby'], "[CHYBA-CASHBACK]")))."</span><br>" : Null); 
?>
<INPUT type='radio' name='cashback' value='ne' checked> Ne
<INPUT type='radio' name='cashback' value='ano' <?php echo (isset($_POST['cashback']) && $_POST['cashback'] == 'ano' ? 'checked' : Null) ?>> Ano
</TD>
</TR>
<?php
}
?>




</TABLE>
</DIV>
<P>
<INPUT type='submit' name='krok2' value='Zpět'>
<INPUT type='submit' name='vysledek' value='Zobrazit výsledky'>
</center>


</FORM>


<?php
if($id_spojeni)
{
  mysql_close($id_spojeni);
  //echo 'odpojeno<br>';
}
?>
