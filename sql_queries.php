<?php                                        

function vytvorKopiiOperSporVcetneDat() {

  //$drop = mysql_query("DROP TABLE IF EXISTS oper");
  $vytvoreni = mysql_query("CREATE TABLE `oper` (
  `id` int(11) NOT NULL,
  `os_kod` char(2) COLLATE utf8_czech_ci NOT NULL,
  `os_popis` varchar(45) COLLATE utf8_czech_ci NOT NULL,
  `os_castka` int(11) NOT NULL DEFAULT '0',
  `os_stav` decimal(10,2) DEFAULT '0.00',
  `os_ucet` int(11) NOT NULL,
  `os_cilova_castka` int(11) DEFAULT NULL,
  `os_active` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `os_kod_UNIQUE` (`os_kod`),
  UNIQUE KEY `os_popis_UNIQUE` (`os_popis`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;");

  $sql_platby_os = "SELECT os.* FROM operativni_sporeni as os
    INNER JOIN moje_ucty as mu on os.os_ucet=mu.idmoje_ucty WHERE os_active=1";
  $vlozeniDat = mysql_query("INSERT INTO oper (id, os_kod, os_popis, os_castka, os_stav, os_ucet, os_cilova_castka, os_active) $sql_platby_os");
  
  return vystup_sql("SELECT * FROM oper");
}

function zustatekNaUctu($_ucetId) {
  $res = vystup_sql("select stav, minZustatek from moje_ucty where idmoje_ucty=$_ucetId");
  $ucet = array("stav" => mysql_result($res, 0, 0), "min" => mysql_result($res, 0, 1), "sporeni" => operSporeniNaUctu($_ucetId));
  
  return $ucet;
}

function operSporeniNaUctu($_ucetId) {
  $res = vystup_sql("select sum(os_stav) from operativni_sporeni where os_ucet=$_ucetId");
  return mysql_result($res, 0, 0);
}

function copyKarty($_cenaIdVzor, $_cenaIdNove) {
  $sql_karty_copy = "INSERT INTO ceny_karty (karta_cena_id, karta_ID, karta_nazev, karta_druh, karta_typ, kartaH_vedeni, kartaH_vyber1, kartaH_vyber2, kartaH_vyber3, kartaH_cashback, kartaH_vklad, kartaD_vedeni, kartaD_vyber1, kartaD_vyber2, kartaD_vyber3, kartaD_cashback, kartaD_vklad, kartaH_koment, kartaD_koment, kartaH_vydani, kartaD_vydani, karta_original_id) 
    SELECT $_cenaIdNove, karta_ID, karta_nazev, karta_druh, karta_typ, kartaH_vedeni, kartaH_vyber1, kartaH_vyber2, kartaH_vyber3, kartaH_cashback, kartaH_vklad, kartaD_vedeni, kartaD_vyber1, kartaD_vyber2, kartaD_vyber3, kartaD_cashback, kartaD_vklad, kartaH_koment, kartaD_koment, kartaH_vydani, kartaD_vydani, id
    FROM ceny_karty WHERE karta_cena_id = $_cenaIdVzor";
    $karty_copy = vystup_sql($sql_karty_copy);
    
  $sql_vzor_karty_koment = "SELECT cena_koment_karta FROM ucty_ceny WHERE cena_id = $_cenaIdVzor";
  $vzor_karty_koment = vystup_sql($sql_vzor_karty_koment);
        
  $sql_karty_koment = "UPDATE ucty_ceny SET cena_koment_karta = '".(mysql_result($vzor_karty_koment, 0))."' WHERE cena_id = $_cenaIdNove";
  $karty_koment = vystup_sql($sql_karty_koment);
    
  $sql_vyj_k_pocet = "SELECT * FROM vyjimky WHERE cena_id=$_cenaIdVzor and not karta_id is null";
  $vyj_k_pocet = mysql_num_rows(vystup_sql($sql_vyj_k_pocet));
  
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
      SELECT ucet_id, $max_id as cena_id, pole, podminka, vysledek, koment FROM vyjimky WHERE cena_id=".$_GET['ucet_vzor']." and karta_id is null";
    break;

    default:
      $sql_kopie_vyjimek = "";
  }

  vystup_sql($sql_kopie_vyjimek);
}

function copyBalicky($_cenaIdVzor, $_cenaIdNove) {
  $balicky = vystup_sql("SELECT * FROM balicky WHERE bal_cena_id=$_cenaIdVzor");
  while($r_balicky = mysql_fetch_row($balicky)) {
    vystup_sql("INSERT INTO balicky (bal_cena_id, bal_nazev, bal_polozek, bal_cena, bal_koment, bal_volitelny)
      SELECT $_cenaIdNove, bal_nazev, bal_polozek, bal_cena, bal_koment, bal_volitelny FROM balicky WHERE bal_cena_id=$_cenaIdVzor");

    $nove_bal_id = mysql_result(vystup_sql("SELECT max(bal_id) FROM balicky"), 0, 0);
    vystup_sql("INSERT INTO bal_polozky (bal_id, bal_pole, bal_popis, bal_pocet_trans, bal_pocet_vyber, bal_podm_vyber)
      SELECT $nove_bal_id, bal_pole, bal_popis, bal_pocet_trans, bal_pocet_vyber, bal_podm_vyber FROM bal_polozky WHERE bal_id=".$r_balicky['bal_id']);
  }
}

function getUcetId($_cenaId) {
  $ucet = vystup_sql("SELECT DISTINCT cena_ucet_id FROM ucty_ceny WHERE cena_id=$_cenaId");
  return mysql_result($ucet, 0, 0);
}
?>