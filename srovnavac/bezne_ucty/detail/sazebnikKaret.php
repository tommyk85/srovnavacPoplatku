<H2>Výpis ze sazebníku poplatků banky</H2>
Verze sazebníku od <?php echo $platnost_od; ?><BR>

        <a href="javascript:activateTab('page4')">Účet, bankovnictví a transakce</a> |
        <U>Platební karty</U>
        
      <H2>Debetní Karty</H2>
<U>Poznámky ke kartám obecně:</U> <?php echo $koment_karta == "bez karty" ? "-" : "<div style='text-indent:5;padding-bottom:20;padding-top:5'>$koment_karta</div>";

$i = 0;
$d_karta = vystup_sql($sql_d_karta);
while($r_karta = mysqli_fetch_assoc($d_karta)){

echo "<H3 name='karta_nazev'>".$r_karta['karta_nazev']."</H3>";
?>

<U>Hlavní karta</U>
<?php
echo "<div style='padding-bottom:20;padding-top:5'>
Vydání karty: ".$r_karta['kartaH_vydani']."<br>
Vedení karty (měsíčně): ".$r_karta['kartaH_vedeni']."<br>                                                   
".($r_karta['kartaH_vyber1'] != Null ? "Výběr z bankomatu banky $banka: ".$r_karta['kartaH_vyber1']."<br>" : "")
.($r_karta['kartaH_vyber2'] != Null && $r_karta['kartaH_vyber2'] <> $r_karta['kartaH_vyber3'] ? "Výběr z bankomatu jiné 'zpřátelené' banky: ".$r_karta['kartaH_vyber2']."<br>" : "")
.($r_karta['kartaH_vyber3'] != Null ? "Výběr z bankomatu jiné banky: ".$r_karta['kartaH_vyber3'] : "")."<br> 
".($r_karta['kartaH_cashback'] != Null ? "Výběr hotovosti u obchodníka (cashback): ".$r_karta['kartaH_cashback']."<br>" : "")
.($r_karta['kartaH_vklad'] != Null ? "Vklad hotovosti přes vkladomat: ".$r_karta['kartaH_vklad'] : "")."<br>
<U>Poznámky k Hlavní kartě:</U> ".($r_karta['kartaH_koment'] == "no comment" ? "-<BR>" : "<br><span style='text-indent:5;margin-bottom:20;padding-top:5'>".$r_karta['kartaH_koment']."</span>")."</div>"; ?>

<U>Dodatková karta:</U>
<?php
echo $r_karta['kartaD_vydani'] != Null ? "<div style='padding-bottom:20;padding-top:5'>
Vydání karty: ".$r_karta['kartaD_vydani']."<br>
Vedení karty (měsíčně): ".$r_karta['kartaD_vedeni']."<br>                                                   
".($r_karta['kartaD_vyber1'] != Null ? "Výběr z bankomatu banky $banka: ".$r_karta['kartaD_vyber1']."<br>" : "")
.($r_karta['kartaD_vyber2'] != Null && $r_karta['kartaD_vyber2'] <> $r_karta['kartaD_vyber3'] ? "Výběr z bankomatu jiné 'zpřátelené' banky: ".$r_karta['kartaD_vyber2']."<br>" : "") 
.($r_karta['kartaD_vyber3'] != Null ? "Výběr z bankomatu jiné banky: ".$r_karta['kartaD_vyber3'] : "")."<br>
".($r_karta['kartaD_cashback'] != Null ? "Výběr hotovosti u obchodníka (cashback): ".$r_karta['kartaD_cashback']."<br>" : "")
.($r_karta['kartaD_vklad'] != Null ? "Vklad hotovosti přes vkladomat: ".$r_karta['kartaD_vklad'] : "")."<br>
<U>Poznámky k Dodatkové kartě:</U> ".($r_karta['kartaD_koment'] == "no comment" ? "-" : "<br><span style='text-indent:5;padding-top:5'>".$r_karta['kartaD_koment']."</span>")."</div>" : "-<br>"; 
$i++;
} 
?>