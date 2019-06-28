
V následujících třech jednoduchých krocích zadejte Vaše požadavky na běžný bankovní účet. Při zadávání mějte na vědomí, že výsledné srovnání účtů bude ušito na míru Vašemu zadání a sebemenší změna v zadání může mít vliv na konečné pořadí dostupných účtů. Proto své zadání raději nadsazujte oproti skutečným požadavkům/potřebám, i s ohledem na rezervy na neočekávané situace.<p>
<form action='' method='POST'>
<center>
<DIV class='dotaznik'>
<TABLE width=600>

<TR><TD colspan=2 style='font-size: large'><B>Krok číslo 1/3, Specifikace požadovaného účtu</B></TD></TR>

<TR><TD valign='top' style='font-weight: bold'>Typ účtu:</TD>
<TD>
<?php 
echo (isset($_POST['chyby']) && strpos($_POST['chyby'], "CHYBA-TYP") > 0 ? str_replace("[CHYBA-TYP]", "<span class='chyba'>", substr($_POST['chyby'], strpos($_POST['chyby'], "[CHYBA-TYP]"), strrpos($_POST['chyby'], "[/CHYBA-TYP]") - strrpos($_POST['chyby'], "[CHYBA-TYP]")))."</span><br>" : Null); 
?>
<INPUT type='radio' name='typ' value='bezny' checked <?php //echo (isset($_POST['typ']) && $_POST['typ'] == 'bezny' ? 'checked' : Null) ?>> běžný účet<BR>
<INPUT type='radio' name='typ' value='sporici' <?php echo (isset($_POST['typ']) && $_POST['typ'] == 'sporici' ? 'checked' : Null) ?> disabled> spořící účet <span class='help'>- zatím nezpracováno</span>
</TD></TR>

<TR><TD valign='top' style='font-weight: bold'>Měna účtu:</TD>
<TD>
<?php 
echo (isset($_POST['chyby']) && strpos($_POST['chyby'], "CHYBA-MENA") > 0 ? str_replace("[CHYBA-MENA]", "<span class='chyba'>", substr($_POST['chyby'], strpos($_POST['chyby'], "[CHYBA-MENA]"), strrpos($_POST['chyby'], "[/CHYBA-MENA]") - strrpos($_POST['chyby'], "[CHYBA-MENA]")))."</span><br>" : Null); 
?>
<INPUT type='radio' name='mena' value='CZK' checked <?php //echo (isset($_POST['mena']) && $_POST['mena'] == 'CZK' ? 'checked' : Null) ?>> CZK<BR>
<INPUT type='radio' name='mena' value='EUR' <?php echo (isset($_POST['mena']) && $_POST['mena'] == 'EUR' ? 'checked' : Null) ?> disabled> EUR <span class='help'>- zatím nezpracováno</span>
</TD></TR>

<TR>
<TD style='font-weight: bold'>Pravidelný zůstatek na účtu: </TD>
<TD>
<?php
include "../pripojeni_sql.php";

$sql_max_limit = "SELECT Max(MinLimit) FROM ucty WHERE TypUctu like 'bezny%'";

$max_limit = mysql_query($sql_max_limit,$id_spojeni);
if (!$max_limit)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  //die('Nepodařilo se nám poslat SQL dotaz na max limit.');
} 
//echo 'Dotaz na max limit byl odeslan.<br>';

$zustatek = mysql_result($max_limit, 0);

echo (isset($_POST['chyby']) && strpos($_POST['chyby'], "CHYBA-ZUSTATEK") > 0 ? str_replace("[CHYBA-ZUSTATEK]", "<span class='chyba'>", substr($_POST['chyby'], strpos($_POST['chyby'], "[CHYBA-ZUSTATEK]"), strrpos($_POST['chyby'], "[/CHYBA-ZUSTATEK]") - strrpos($_POST['chyby'], "[CHYBA-ZUSTATEK]")))."</span><br>" : Null);

if($id_spojeni)
{
  mysql_close($id_spojeni);
  //echo 'odpojeno<br>';
} 
?>
<INPUT type='text' name='zustatek' size=6 maxlength=8 value=<?php echo (isset($_POST['zustatek']) ? $_POST['zustatek'] : $zustatek) ?>>
</TD>
</TR>

<TR><TD valign='top' style='font-weight: bold'>Ovládání účtu přes: </TD>
<TD>
<?php 
echo (isset($_POST['chyby']) && strpos($_POST['chyby'], "CHYBA-BANKING") > 0 ? str_replace("[CHYBA-BANKING]", "<span class='chyba'>", substr($_POST['chyby'], strpos($_POST['chyby'], "[CHYBA-BANKING]"), strrpos($_POST['chyby'], "[/CHYBA-BANKING]") - strrpos($_POST['chyby'], "[CHYBA-BANKING]")))."</span><br>" : Null); 
?>
<INPUT type='checkbox' name='banking[]' value='ib' checked disabled> Internetové bankovnictví <BR>
<INPUT type='hidden' name='banking[]' value='ib'>
<INPUT type='checkbox' name='banking[]' value='mb' <?php echo (isset($_POST['banking']) && in_array('mb', explode(",", $_POST['banking'])) ? 'checked' : Null) ?>> Mobilní bankovnictví (včetně smartbanking)<BR>
<INPUT type='checkbox' name='banking[]' value='tb' <?php echo (isset($_POST['banking']) && in_array('tb', explode(",", $_POST['banking'])) ? 'checked' : Null) ?>> Telefonní bankovnictví
</TD></TR>

<TR><TD valign='top' style='font-weight: bold'>Info služby k transakcím: </TD>
<TD>
<?php 
echo (isset($_POST['chyby']) && strpos($_POST['chyby'], "CHYBA-INFO") > 0 ? str_replace("[CHYBA-INFO]", "<span class='chyba'>", substr($_POST['chyby'], strpos($_POST['chyby'], "[CHYBA-INFO]"), strrpos($_POST['chyby'], "[/CHYBA-INFO]") - strrpos($_POST['chyby'], "[CHYBA-INFO]")))."</span><br>" : Null); 
?>
<INPUT type='radio' name='info' value='ne' checked> Ne <BR>
<INPUT type='radio' name='info' value='mail' <?php echo (isset($_POST['info']) && $_POST['info'] == 'mail' ? 'checked' : Null) ?>> Ano - emailem<BR>
<INPUT type='radio' name='info' value='sms' <?php echo (isset($_POST['info']) && $_POST['info'] == 'sms' ? 'checked' : Null) ?>> Ano - SMS
</TD></TR>




<TR><TD valign='top' style='font-weight: bold'>Debetní karta k účtu: </TD>
<TD>
<?php 
echo (isset($_POST['chyby']) && strpos($_POST['chyby'], "CHYBA-KARTA") > 0 ? str_replace("[CHYBA-KARTA]", "<span class='chyba'>", substr($_POST['chyby'], strpos($_POST['chyby'], "[CHYBA-KARTA]"), strrpos($_POST['chyby'], "[/CHYBA-KARTA]") - strrpos($_POST['chyby'], "[CHYBA-KARTA]")))."</span><br>" : Null); 
?>
<INPUT type='radio' name='karta' value=0 checked> Ne
<INPUT type='radio' name='karta' value=1 <?php echo (isset($_POST['karta']) && $_POST['karta'] == 1 ? 'checked' : Null) ?>> Ano
</TD></TR>

                        
</TABLE>
</DIV>
<P>

<input type='hidden' name='vek' value='<?php echo (isset($_POST['vek']) ? $_POST['vek'] : '') ?>'>
<input type='hidden' name='zarazeni' value='<?php echo (isset($_POST['zarazeni']) ? $_POST['zarazeni'] : '') ?>'>
<input type='hidden' name='vzdelani' value='<?php echo (isset($_POST['vzdelani']) ? $_POST['vzdelani'] : '') ?>'>
<input type='hidden' name='vzdelani_rok' value='<?php echo (isset($_POST['vzdelani_rok']) ? $_POST['vzdelani_rok'] : '') ?>'>
<input type='hidden' name='vzdelani_forma' value='<?php echo (isset($_POST['vzdelani_forma']) ? $_POST['vzdelani_forma'] : '') ?>'>
<input type='hidden' name='kod_akt_banky' value='<?php echo (isset($_POST['kod_akt_banky']) ? $_POST['kod_akt_banky'] : '') ?>'>

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

<INPUT type='submit' name='krok2' value='Pokračovat'>
</center>
</FORM>




<form action='' method='post'>

<input type='hidden' name='typ' value='bezny'>
<input type='hidden' name='mena' value='CZK'>
<input type='hidden' name='zustatek' value='5000'>
<input type='hidden' name='banking' value='ib'>
<input type='hidden' name='info' value='sms'>
<input type='hidden' name='vypis' value='elektro'>
<input type='hidden' name='karta' value='1'>

<input type='hidden' name='vek' value='26'>
<input type='hidden' name='zarazeni' value='1'>
<input type='hidden' name='vzdelani' value=''>
<input type='hidden' name='vzdelani_rok' value=''>
<input type='hidden' name='vzdelani_forma' value=''>
<input type='hidden' name='kod_akt_banky' value='ne'>

<input type='hidden' name='prijem' value='22000'>
<input type='hidden' name='prichozi' value='1'>
<input type='hidden' name='kod_banky' value='ruzne'>
<input type='hidden' name='vydaje' value='20000'>
<input type='hidden' name='odch_std' value='4'>
<input type='hidden' name='odch_tp' value='8'>
<input type='hidden' name='karta_celkem' value='4000'>
<input type='hidden' name='vybery' value='2'>
<input type='hidden' name='cashback' value='ne'>

<INPUT type='submit' name='vysledek' value='Rychlá volba'>
</FORM>
