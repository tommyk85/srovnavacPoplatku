<?php                                        

function copyKarty($_cenaIdVzor, $_cenaIdNove) {
  $sql_karty_copy = "INSERT INTO ceny_karty (karta_cena_id, karta_ID, karta_nazev, karta_druh, karta_typ, kartaH_vedeni, kartaH_vyber1, kartaH_vyber2, kartaH_vyber3, kartaH_cashback, kartaH_vklad, kartaD_vedeni, kartaD_vyber1, kartaD_vyber2, kartaD_vyber3, kartaD_cashback, kartaD_vklad, kartaH_koment, kartaD_koment, kartaH_vydani, kartaD_vydani, karta_original_id) 
    SELECT $_cenaIdNove, karta_ID, karta_nazev, karta_druh, karta_typ, kartaH_vedeni, kartaH_vyber1, kartaH_vyber2, kartaH_vyber3, kartaH_cashback, kartaH_vklad, kartaD_vedeni, kartaD_vyber1, kartaD_vyber2, kartaD_vyber3, kartaD_cashback, kartaD_vklad, kartaH_koment, kartaD_koment, kartaH_vydani, kartaD_vydani, id
    FROM ceny_karty WHERE karta_cena_id = $_cenaIdVzor";
    $karty_copy = vystup_sql($sql_karty_copy);
    
  $sql_vzor_karty_koment = "SELECT cena_koment_karta FROM ucty_ceny WHERE cena_id = $_cenaIdVzor";
  $vzor_karty_koment = vystup_sql($sql_vzor_karty_koment);
        
  $sql_karty_koment = "UPDATE ucty_ceny SET cena_koment_karta = '".(mysqli_result($vzor_karty_koment, 0))."' WHERE cena_id = $_cenaIdNove";
  $karty_koment = vystup_sql($sql_karty_koment);
    
  $sql_vyj_k_pocet = "SELECT * FROM vyjimky WHERE cena_id=$_cenaIdVzor and not karta_id is null";
  $vyj_k_pocet = mysqli_num_rows(vystup_sql($sql_vyj_k_pocet));
  
  if($vyj_k_pocet > 0) {
    copyVyjimky($_cenaIdVzor, $_cenaIdNove, 'karta');
  }
  
  return array("pocetVyjimek" => $vyj_k_pocet);
}

function copyVyjimky($_cenaIdVzor, $_cenaIdNove, $_vyjTyp) {
  switch($_vyjTyp) {
    case 'karta':
    $sql_kopie_vyjimek = "INSERT INTO vyjimky (`ucet_id`,`cena_id`,`karta_id`,`pole`,`podminka`,`vysledek`,`koment`)
      SELECT ".getUcetId($_cenaIdVzor).", ck.karta_original_id, ck.id, vyjimky.pole, vyjimky.podminka, vyjimky.vysledek, vyjimky.koment 
      FROM vyjimky INNER JOIN ceny_karty ck ON vyjimky.karta_id=ck.karta_original_id 
      WHERE cena_id=$_cenaIdVzor";
    break;

    case 'cena':
    $sql_kopie_vyjimek = "INSERT INTO vyjimky (`ucet_id`,`cena_id`,`pole`,`podminka`,`vysledek`,`koment`)
      SELECT ucet_id, $_cenaIdNove as cena_id, pole, podminka, vysledek, koment FROM vyjimky WHERE cena_id=$_cenaIdVzor and karta_id is null";
    break;

    default:
      $sql_kopie_vyjimek = "";
  }

  vystup_sql($sql_kopie_vyjimek);
}

function copyBalicky($_cenaIdVzor, $_cenaIdNove) {
  $balicky = vystup_sql("SELECT * FROM balicky WHERE bal_cena_id=$_cenaIdVzor");
  while($r_balicky = mysqli_fetch_assoc($balicky)) {
    vystup_sql("INSERT INTO balicky (bal_cena_id, bal_nazev, bal_polozek, bal_cena, bal_koment, bal_volitelny)
      SELECT $_cenaIdNove, bal_nazev, bal_polozek, bal_cena, bal_koment, bal_volitelny FROM balicky WHERE bal_id=".$r_balicky['bal_id']);

    $nove_bal_id = mysqli_result(vystup_sql("SELECT max(bal_id) FROM balicky"), 0, 0);
    vystup_sql("INSERT INTO bal_polozky (bal_id, bal_pole, bal_popis, bal_pocet_trans, bal_pocet_vyber, bal_podm_vyber)
      SELECT $nove_bal_id, bal_pole, bal_popis, bal_pocet_trans, bal_pocet_vyber, bal_podm_vyber FROM bal_polozky WHERE bal_id=".$r_balicky['bal_id']);
  }
}

function getUcetId($_cenaId) {
  $ucet = vystup_sql("SELECT DISTINCT cena_ucet_id FROM ucty_ceny WHERE cena_id=$_cenaId");
  return mysqli_result($ucet, 0, 0);
}

function existujiVyjimkyCen($_cenaId) {
  $vyjimky = vystup_sql("SELECT count(*) FROM vyjimky WHERE cena_id=$_cenaId and karta_id is null");
  return mysqli_result($vyjimky, 0, 0) > 0;
}

function existujiKarty($_cenaId) {
  $karty = vystup_sql("SELECT count(*) FROM ceny_karty WHERE karta_cena_id=$_cenaId");
  return mysqli_result($karty, 0, 0) > 0;
}

function existujiBalicky($_cenaId) {
  $balicky = vystup_sql("SELECT count(*) FROM balicky WHERE bal_cena_id=$_cenaId");
  return mysqli_result($balicky, 0, 0) > 0;
}

?>