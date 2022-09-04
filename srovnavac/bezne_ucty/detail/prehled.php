<H2>Detaily účtu</H2>
Typ účtu: <?php 
switch($typ_uctu){
  case 'bezny':
  echo 'běžný účet pro fyzické osoby nepodnikatele';
  break;
  
  case 'bezny-stu':
  echo 'studentský účet';
  break;
  
  case 'bezny-det':
  echo 'dětský účet';
  break;
  
  default:
  echo '???';
} ?>

<BR>
Měna účtu: CZK<BR>
Minimální zůstatkový limit účtu: <?php echo "$min_limit CZK"; ?><BR>
Úrok na účtu: <?php echo "$urok %"; ?><BR>                                    
Věk klienta: od <?php echo "$vek_od do $vek_do let"; ?><BR> 
Web: <?php echo "<a href='$www' target='_blank'>$www</a>"; ?><BR>
Poznámky k účtu: <?php echo $koment_ucet == "no comment" ? "-" : "<div style='text-indent:5;padding-top:5'>$koment_ucet</div>"; ?>
</div>
