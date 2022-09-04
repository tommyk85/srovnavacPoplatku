<H2>Rozpis MIN/MAX poplatků</H2>
<CENTER>
  <TABLE border=1 width=500>
  <TR>
  <TH style='text-align:center'>MIN</TH>
  <TH class='popis'>Rozpis vypočtených poplatků</TH>
  <TH style='text-align:center'>MAX</TH></TR>

  <TR>
  <TD class='cena'><?php echo cena($v_vedeni_min + $v_vypis_min); ?></TD>
  <TD class='popis'>Vedení účtu</TD>
  <TD class='cena'><?php echo cena($v_vedeni_max + $v_vypis_max); ?></TD>
  </TR>
  <TR>
  <TD class='popis2' colspan=3>Vedení účtu zahrnuje kromě samotného vedení účtu i 
  vedení Vámi vybraného bankovnictví (IB<?php echo (is_array($banking) && in_array('o', $banking) ? '(vč.PuO)' : '').(is_array($banking) && in_array('m', $banking) ? '/MB' : '').(is_array($banking) && in_array('t', $banking) ? '/TB' : ''); ?>)
  a měsíční výpis z účtu (<?php echo ($vypis == 'e' ? 'elektronický' : 'papírový'); ?>).
  <?php echo ($v_vedeni_min + $v_vypis_min) <> ($v_vedeni_max + $v_vypis_max) ? "<BR>Min/Max poplatek je závislý na (ne)splnění daných podmínek." : ""; ?></TD>
  </TR>
    
  <TR>
  <TD class='cena'><?php echo cena($v_prich_min); ?></TD>
  <TD class='popis'>Příchozí platby <span class='popis2'>(<?php echo $prich; ?>)</span></TD>
  <TD class='cena'><?php echo cena($v_prich_max); ?></TD>
  </TR>
  <TR>
  <TD class='popis2' colspan=3>Min/Max je rozděleno na platby z účtu u banky <?php echo $banka; ?> a z jiné cizí banky.</TD>
  </TR>

  <TR>
  <TD class='cena'><?php echo cena($v_odch_min); ?></TD>
  <TD class='popis'>Odchozí platby <span class='popis2'>(<?php echo $odch_std+$odch_tp; ?>)</span></TD>
  <TD class='cena'><?php echo cena($v_odch_max); ?></TD>
  </TR>  
  <TR>
  <TD class='popis2' colspan=3>Zahrnuty jsou i platby vzniklé z trvalého příkazu, bez poplatku za jeho založení.<BR>
  Min/Max je rozděleno na platby na účet u banky <?php echo $banka; ?> a do jiné cizí banky (pouze ty zadané přes IB).</TD>
  </TR>

<?php
  if($karta == 1){    ?>
  <TR>
  <TD class='cena'><?php echo cena($v_karta_min); ?></TD>
  <TD class='popis'>Karetní poplatky</TD>
  <TD class='cena'><?php echo cena($v_karta_max); ?></TD>
  </TR>
  <TR>
  <TD class='popis2' colspan=3>Min/Max je rozděleno podle součtu poplatků za vedení karty a její poplatek za <?php echo "<span style='border-bottom:1px dashed black'>výběr z bankomatu ($karta_vybery)</span> banky $banka"; ?> a jiné cizí banky. <?php //echo $c_kartaH_cashback != Null ? "Banka ke kartám nabízí možnost využití <span style='border-bottom:1px dashed black'>Cashback za $c_kartaH_cashback CZK</span>." : ""; 
  //<BR> Nejlevnější varianta je <span class='oznac'>karta1</span>, nejdražší <span class='oznac'>karta2</span>.</TD> ?>
  </TR>  
<?php } ?>

  <TR>
  <TH class='cena'><?php echo cena($v_min); ?></TH>
  <TH class='popis'>Celkový poplatek</TH>
  <TH class='cena'><?php echo cena($v_max); ?></TH>
  </TR>  
  </TABLE>
</CENTER> 