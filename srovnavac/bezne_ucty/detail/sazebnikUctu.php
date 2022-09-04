<H2>Výpis ze sazebníku poplatků banky</H2>
Verze sazebníku od <?php echo $platnost_od; ?><BR>
        <U>Účet, bankovnictví a transakce</U> |
        <a href="javascript:activateTab('page3')">Platební karty</a>
<TABLE><TR><TD>
<H3>Poplatky za účet</H3>
Zřízení účtu: <?php echo $c_zrizeni; ?><BR>
Vedení účtu (měsíčně): <?php echo $c_vedeni; ?><BR>
Zrušení účtu: <?php echo $c_zruseni; ?><BR>

<H3>Poplatky za bankovnictví</H3>
<div style='font-size:small;padding-bottom:10'> IB = internetové, MB = mobilní/smart, TB = telefonické</div>
<TABLE border=1>
<TR><TD></TD><TH>IB</TH><TH>MB</TH><TH>TB</TH></TR>
<TR><TD style='text-align:left'>Zřízení bankovnictví</TD>
<TD class='cena'><?php echo $c_zrizeni_ib; 
echo "<TD class='cena'>$c_zrizeni_mb</TD>";
echo "<TD class='cena'>$c_zrizeni_tb</TD>"; ?></TD>
</TR>
<TR><TD style='text-align:left'>Vedení bankovnictví (měsíčně)</TD>
<TD class='cena'><?php echo $c_vedeni_ib;
echo "<TD class='cena'>$c_vedeni_mb</TD>";
echo "<TD class='cena'>$c_vedeni_tb</TD>"; ?></TD>
</TR>
</TABLE>

</TD>

<TD style='padding-left:50;max-width:400'>
<?php 
echo $koment_JP == "no comment" ? "" : "<div style='text-indent:5;padding:5;background-color:silver;max-width:400'>$koment_JP</div><br>";
echo $koment_PP == "no comment" ? "" : "<div style='text-indent:5;padding:5;background-color:silver;max-width:400'>$koment_PP</div>"; 
?>
</TD></TR>

<TR>
<TD style='padding-top:20'>
<H3>Transakční poplatky</H3>

Příchozí platba z účtu u banky <?php echo "$banka: $c_prich1"; ?><BR>
Příchozí platba z účtu v jiné české bance: <?php echo $c_prich2; ?>


<TABLE border=1 style='margin-top:10;margin-bottom:10'>
<TR><TD></TD><TH>IB</TH><TH>MB</TH><TH>TB</TH></TR>
<TR><TD style='text-align:left'>Zadání a provedení jednorázového příkazu k úhradě na účet v bance <?php echo $banka; ?></TD>
<TD class='cena'><?php echo $c_odch_ib1;
echo "<TD class='cena'>$c_odch_mb1</TD>";
echo "<TD class='cena'>$c_odch_tb1</TD>"; ?></TD>
</TR>
<TR><TD style='text-align:left'>Zadání a provedení jednorázového příkazu k úhradě na účet do jiné české banky</TD>
<TD class='cena'><?php echo $c_odch_ib2;
echo "<TD class='cena'>$c_odch_mb2</TD>";
echo "<TD class='cena'>$c_odch_tb2</TD>"; ?></TD>
</TR>
<TR><TD style='text-align:left'>Zřízení trvalého příkazu</TD>
<TD class='cena'><?php echo $c_tp_zrizeni_ib;
echo "<TD class='cena'>$c_tp_zrizeni_mb</TD>";
echo "<TD class='cena'>$c_tp_zrizeni_tb</TD>"; ?></TD>
</TR>
</TABLE>


Odchozí platba vzniklá z trvalého příkazu k úhradě na účet v bance <?php echo "$banka: $c_tp1"; ?><BR>
Odchozí platba vzniklá z trvalého příkazu k úhradě na účet do jiné české banky: <?php echo $c_tp2; ?><BR>

</TD>

<TD style='padding-left:50'>
<?php echo $koment_trans == "no comment" ? "" : "<div style='text-indent:5;padding:5;background-color:silver;max-width:400'>$koment_trans</div>"; ?>
</TD></TR>
</TABLE>