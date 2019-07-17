<?php

function pocetKaretPoplatku($id_poplatku) {
  $req = "select * from ceny_karty where karta_cena_id=$id_poplatku";
  $res = vystup_sql($req);
  
  return mysql_num_rows($res);
} 

function prazdnyKartaObecnyKoment($_pocetKaret) {
  return $_pocetKaret > 0 ? 'no comment' : 'bez karty';  
}
?>