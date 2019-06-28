<?php

$mena = 'CZK';
$vek = isset($_POST['vek']) ? $_POST['vek'] : 20;
$vek_sql = "ucet_vek_od <= $vek and (ucet_vek_do >= $vek or ucet_vek_do is null) ";

$prich = isset($_POST['prich']) ? $_POST['prich'] : 1;
$odch_std = isset($_POST['odch_std']) ? $_POST['odch_std'] : 2;
$odch_tp = isset($_POST['odch_tp']) ? $_POST['odch_tp'] : 2;
$vypis = isset($_POST['vypis']) ? $_POST['vypis'] : 'e';
$karta = isset($_POST['karta']) ? $_POST['karta'] : 1;
$karta_vybery = isset($_POST['karta']) ? $_POST['karta_vybery'] : 1;
//$cashback = isset($_POST['karta']) && isset($_POST['cashback']) ? $_POST['cashback'] : 0;

//$banking = array();
//echo implode(",", $_POST['banking']);
$banking = isset($_POST['banking']) && is_array($_POST['banking']) ? $_POST['banking'] : (isset($_POST['banking']) ? explode(',', $_POST['banking']) : array('i'));
/*
echo "banking obsahuje - ".implode(",", $banking)."<br>";
echo "je banking pole? ".(is_array($banking) ? 'ano' : 'ne')."<br>";
echo " obsahuje banking 'm'? ".(in_array('m', $banking) ? 'ano' : 'ne');        */
//isset($_POST['banking']) ? explode(",", $_POST['banking']) : 'i';


//$id_join_sql = "INNER JOIN (SELECT max(cena_platnost_od) as platnost, cena_ucet_id FROM ucty_ceny WHERE cena_platnost_od <= Current_date() GROUP BY cena_ucet_id) as p ON p.platnost=ucty_ceny.cena_platnost_od AND p.cena_ucet_id=ucty_ceny.cena_ucet_id";

$vyj_disponent_sql = isset($_POST['disponent']) && $_POST['disponent'] != Null ? "AND exists(SELECT * FROM ceny_karty WHERE karta_cena_id = ucty_ceny.cena_id and not kartaD_vedeni is null) " : "";
$vyj_vedeni_sql = isset($_POST['vedeniBezPod']) && $_POST['vedeniBezPod'] != Null ? "AND cena_vedeni_podm = 0 " : "";
$vyj_inkaso_sql = isset($_POST['inkaso']) && $_POST['inkaso'] != Null ? "AND not cena_inkaso_svoleni is null " : "";
$vyj_vkladomat_sql = isset($_POST['vkladomat']) && $_POST['vkladomat'] != Null ? "AND exists(SELECT * FROM ceny_karty WHERE karta_cena_id = ucty_ceny.cena_id and not kartaH_vklad is null) " : ""; 
$vyj_cashback_sql = isset($_POST['cashback']) && $_POST['cashback'] != Null ? "AND exists(SELECT * FROM ceny_karty WHERE karta_cena_id = ucty_ceny.cena_id and not kartaH_cashback is null) " : "";
$vyj_kontokorent_sql = isset($_POST['kontokorent']) && $_POST['kontokorent'] != Null ? "AND not cena_kontokorent_vedeni is null " : "";
$vyj_aktiv_sql = !isset($_POST['aktiv']) || $_POST['aktiv'] == 1 ? "AND ucet_active = 1 " : "AND ucet_active > 0 "; 

$list_filter = in_array('o', $banking) ? "AND not cena_odchozi_online1 is null " : "";
$list_filter.= in_array('m', $banking) ? "AND not mb_Vedeni is null " : "";
$list_filter.= in_array('t', $banking) ? "AND not tb_Vedeni is null " : "";



$sql_data = "SELECT * FROM ucty
INNER JOIN banky ON ucty.ucet_kod_banky = banky.kod_banky 
INNER JOIN ucty_ceny ON ucty.ucet_id = ucty_ceny.cena_ucet_id 
INNER JOIN ceny_banking ON ucty_ceny.cena_id = ceny_banking.id

WHERE banky.active=1 AND ucty_ceny.cena_active=1 AND ";
if(!(isset($_POST['ukaz_detail']) || isset($_GET['id']))){
$sql_data.= (isset($_POST['typ']) && $_POST['typ'] <> 'vse' ? "ucet_typ = '".$_POST['typ']."' " : $vek_sql).
($karta == 1 ? "AND cena_koment_karta <> 'bez karty' " : "").
(isset($_POST['vypis']) && $_POST['vypis'] == 'p' ? "AND not cena_vypis_p is null " : "").
$vyj_disponent_sql.$vyj_vedeni_sql.$vyj_inkaso_sql.$vyj_vkladomat_sql.$vyj_cashback_sql.$vyj_kontokorent_sql.$vyj_aktiv_sql.$list_filter;
}
else
$sql_data.= "ucty_ceny.cena_ucet_id = $id";                  


$data = vystup_sql($sql_data);

//echo mysql_num_rows($data); 
$sql_data;

$sql_data_vyj = "CREATE TEMPORARY TABLE `vyj_temp` (
  `vyj_id` int(11) NOT NULL,
  `cena_id` int(11) NOT NULL,
  `karta_id` int(11) DEFAULT NULL,
  `vyj_pole` varchar(45) COLLATE utf8_czech_ci NOT NULL,
  `vyj_vysl` decimal(10,2) NOT NULL,
  `pole_group` varchar(45) COLLATE utf8_czech_ci DEFAULT NULL,
  `nova_cena` int(11) DEFAULT NULL,
  PRIMARY KEY (`vyj_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;
";
$data_vyj = vystup_sql($sql_data_vyj);


while($r_data = mysql_fetch_assoc($data)){              // r = řádek, v = výpočet, d = detail, c = cena, p = popis
$vyj_yn = 0;
$cena_id = $r_data["cena_id"];
$ucet_id = $r_data["ucet_ID"];
$ucet = $r_data["ucet_nazev"];
$www = $r_data["ucet_www"];
$banka = $r_data["nazev_banky"];
$kod_banky = $r_data["ucet_kod_banky"];
$p_banking = "IB".($r_data["cena_odchozi_online1"] != Null ? " (vč.PuO), " : ", ").($r_data["mb_Zrizeni"] != Null ? "MB, " : "").($r_data["tb_Zrizeni"] != Null ? "TB" : "");
$vek_rozmezi = $r_data["ucet_vek_od"]." - ".$r_data["ucet_vek_do"];  

switch ($r_data["ucet_typ"]){
  case 'bezny':
  $typ = 'Účet pro nepodnikatele';
  break;
  
  case 'bezny-stu':
  $typ = 'Studentský účet';
  break;
  
  case 'bezny-det':
  $typ = 'Dětský účet';
  break;
  
  default:
  $typ = $typ_filtr = '???';
}

// vypocet vyjimek
$sql_cena_vyj_ins = "insert into vyj_temp(vyj_id,cena_id,karta_id,vyj_pole,vyj_vysl)
SELECT vyjimky.vyj_id,vyjimky.cena_id,karta_id,pole vyj_pole,vysledek vyj_vysl FROM vyjimky WHERE vyjimky.cena_id=$cena_id";
$cena_vyj_ins = vystup_sql($sql_cena_vyj_ins);

$sql_cena_vyj = "select cena_id,vyj_pole, min(vyj_vysl) min_vysl, max(vyj_vysl) max_vysl from vyj_temp WHERE karta_id is null GROUP BY vyj_pole";
$cena_vyj = vystup_sql($sql_cena_vyj);

/* aktivni podminky vyjimek k cene uctu 
c_vedeni
c_odch
c_prich
p_odch_std_vyj
*/

  // definice vychozich hodnot promennych vyjimek
$vedeni_min = Null; 
$p_odch_vyj = 0;

  // prirazeni hodnot vyjimek
while($r_cena_vyj = mysql_fetch_assoc($cena_vyj)){
$vyj_yn = 1;
//$cena_id = $r_cena_vyj['cena_id'];
$vyj_pole = $r_cena_vyj['vyj_pole'];
$vyj_vysl_c = $r_cena_vyj['min_vysl'];         // vyj cena
$vyj_vysl_p = $r_cena_vyj['max_vysl'];         // vyj pocet (transakci apod)

  switch($vyj_pole){
    case 'c_vedeni':
    $vedeni_min = $vyj_vysl_c;
    //echo "$cena_id - vedeni $vyj_vysl, ";
    break;
    
    case 'c_odch':
    $r_data["ib_Odchozi1"] = $r_data["cena_odchozi_tp1"] = $vyj_vysl_c; 
    //echo "$cena_id - cena odchozi $vyj_vysl_c, ";
    break;
    
    case 'c_prich':
    $r_data["cena_prichozi1"] = $vyj_vysl_c;
    //echo "$cena_id - cena prichozi $vyj_vysl_c, ";
    break;
    
    case 'p_odch_std_vyj':
    $p_odch_vyj = $vyj_vysl_p;
    //echo "$cena_id - pocet odchozich zdarma $vyj_vysl_p, ";
    break;
    
    default:
    echo "<i>$cena_id - neznama podminka ($vyj_pole), </i>";
  }
}


// vypocet vysledneho poplatku
$v_vedeni = $r_data["cena_vedeni"];
$v_vypis_min = $v_vypis_max = $v_vypis = $vypis == 'p' ? $r_data["cena_vypis_p"] : $r_data["cena_vypis_e"];

$v_prich_min = $prich * $r_data["cena_prichozi1"];
$v_prich_max = $prich * $r_data["cena_prichozi2"];
$v_tp_min = $odch_tp * $r_data["cena_odchozi_tp1"];
$v_tp_max = $odch_tp * $r_data["cena_odchozi_tp2"];
$v_odchozi_min_ib = max($odch_std - $p_odch_vyj, 0) * $r_data["ib_Odchozi1"]; 
$v_odchozi_max_ib = $odch_std * $r_data["ib_Odchozi2"];



// vedeni uctu
$v_vedeni = $v_vedeni + $r_data["ib_Vedeni"];

if(is_array($banking) && in_array('m', $banking)){
$v_odchozi_min_mb = $odch_std * $r_data["mb_Odchozi1"];
$v_odchozi_max_mb = $odch_std * $r_data["mb_Odchozi2"];
$v_vedeni = $v_vedeni + $r_data["mb_Vedeni"];
}

if(is_array($banking) && in_array('t', $banking)){
$v_odchozi_min_tb = $odch_std * $r_data["tb_Odchozi1"];
$v_odchozi_max_tb = $odch_std * $r_data["tb_Odchozi2"];
$v_vedeni = $v_vedeni + $r_data["tb_Vedeni"];
}

//echo "$cena_id: $vedeni_min, ";
$v_vedeni_min = $vedeni_min != Null ? $vedeni_min : $v_vedeni;  
$v_vedeni_max = $v_vedeni; 



// karty

/* aktivni podminky vyjimek k cene karty
c_kartaH_vedeni
p_kartaH_vyber2_vyj
p_kartaH_vyber1_vyj
c_kartaH_vybery
c_kartaH_vyber1
c_kartaH_vyber2
*/

$v_karta_min = $v_karta_max = 0;


if($karta == 1){
$sql_karta_data = "SELECT * FROM ceny_karty WHERE karta_cena_id = $cena_id";
$karta_data = vystup_sql($sql_karta_data);

$min_ar = array(); 
$min_ar[] = 99999;

$max_ar = array();
$max_ar[] = 0;

                                        
while($r_k_data = mysql_fetch_assoc($karta_data)){

  // vychozi hodnoty vyjimek
//$karta_max = 
$p_vyber1_vyj = $p_vyber2_vyj = $p_vybery_vyj = 0;
$vybery_vyj = 99999; 
$k_vedeni = $k_vedeni_min = $r_k_data['kartaH_vedeni'];
$vyber2 = $vyber2_min = $r_k_data['kartaH_vyber3'];
  // vyjimky karet
  
  $sql_k_cena_vyj = "select cena_id,karta_id,vyj_pole, min(vyj_vysl) min_vysl, max(vyj_vysl) max_vysl from vyj_temp WHERE karta_id=".$r_k_data['ID']." GROUP BY vyj_pole ORDER BY karta_id";
  $k_cena_vyj = vystup_sql($sql_k_cena_vyj);

  //echo mysql_num_rows($k_cena_vyj);
  while($r_k_vyj = mysql_fetch_assoc($k_cena_vyj)){
  $vyj_yn = 1;
  $vyj_pole = $r_k_vyj['vyj_pole'];
  $vyj_vysl_c = $r_k_vyj['min_vysl'];
  $vyj_vysl_p = $r_k_vyj['max_vysl'];
  
    switch($vyj_pole){
    case 'c_kartaH_vedeni':
    $k_vedeni_min = $vyj_vysl_c;
    //echo "$cena_id - vedeni karty $vyj_vysl_c, ";
    break;
    
    case 'c_kartaH_vybery':
    $vybery_vyj = $vyj_vysl_c;
    //echo "$cena_id - celkem za vybery $vyj_vysl_c, ";
    break;
    
    case 'c_kartaH_vyber1':
    $r_k_data['kartaH_vyber1'] = $vyj_vysl_c;
    //echo "$cena_id - vybery z vlastnich bankomatu $vyj_vysl_c, ";
    break;
    
    case 'c_kartaH_vyber2':
    $vyber2_min = $vyj_vysl_c;
    //echo "$cena_id - vybery z cizich bankomatu $vyj_vysl_c, ";
    break;

    case 'p_kartaH_vyber1_vyj':
    $p_vyber1_vyj = $vyj_vysl_p;
    //echo "$cena_id - pocet vyberu z vlastnich bankomatu zdarma $vyj_vysl_p, ";
    break;
    
    case 'p_kartaH_vyber2_vyj':
    $p_vyber2_vyj = $vyj_vysl_p;
    //echo "$cena_id - pocet vyberu z cizich bankomatu zdarma $vyj_vysl_p, ";
    break;
        
    default:
    echo "$cena_id neznama vyjimka ($vyj_pole), ";
    }
  }  


$vyber1 = $r_k_data['kartaH_vyber1'] == 'Null' && $r_k_data['kartaH_vyber2'] == 'Null' ? $r_k_data['kartaH_vyber3'] : 
($r_k_data['kartaH_vyber1'] == 'Null' ? $r_k_data['kartaH_vyber2'] : $r_k_data['kartaH_vyber1']);
//$vyber2 = $r_k_data['kartaH_vyber3'];


$min_ar[] = $k_vedeni_min + min($vyber1 * max($karta_vybery - $p_vyber1_vyj, 0), $vyber2_min * max($karta_vybery - $p_vyber2_vyj, 0), $vybery_vyj);
$max_ar[] = $k_vedeni + ($vyber2 * $karta_vybery);

//$min_ar[]." is ".is_numeric($min_ar[]);
//$min_ar[] = $karta_min;
//$max_ar[] = number($karta_max);
}

$v_karta_min = min($min_ar);
$v_karta_max = max($max_ar);

}

$sql_vyj_trun = "TRUNCATE table vyj_temp";
$vyj_trun = vystup_sql($sql_vyj_trun); 
                                       

// odchozi vse
$ib_min = $v_odchozi_min_ib + $v_tp_min;
$ib_max = $v_odchozi_max_ib + $v_tp_max;

  if(is_array($banking) && in_array('m', $banking)){
  $mb_min = $v_odchozi_min_mb + $v_tp_min;
  $mb_max = $v_odchozi_max_mb + $v_tp_max;}
  else
  $mb_min = $mb_max = -1;

  if(is_array($banking) && in_array('t', $banking)){
  $tb_min = $v_odchozi_min_tb + $v_tp_min;
  $tb_max = $v_odchozi_max_tb + $v_tp_max;}
  else
  $tb_min = $tb_max = -1;
  
$v_odch_min = min($ib_min, ($mb_min >= 0 ? $mb_min : $ib_min), ($tb_min >= 0 ? $tb_min : $ib_min));
$v_odch_max = max($ib_max, ($mb_max >= 0 ? $mb_max : $ib_max), ($tb_max >= 0 ? $tb_max : $ib_max));
  
  
  // min/max celkem
//echo "$cena_id: $v_vedeni_min/$v_vedeni_max, ";
$v_min = $v_prich_min + $v_odch_min + $v_karta_min + $v_vedeni_min + $v_vypis_min;
$v_max = $v_prich_max + $v_odch_max + $v_karta_max + $v_vedeni_max + $v_vypis_max;

  
$platnost = $r_data["cena_platnost_od"];
$koment_ucet = $r_data["ucet_koment"];
$koment_JP = $r_data["cena_koment_JP"];
$koment_PP = $r_data["cena_koment_PP"];
$koment_trans = $r_data["cena_koment_trans"];
$koment_karta = $r_data["cena_koment_karta"];
//$vyj_yn = $r_data["vyj_id"] ? 1 : 'Null';


// vystup do tabulky srovnavace
if(!isset($_POST['ukaz_detail']) && !isset($_GET['id'])){
$sql_vypocet = "INSERT INTO vysledky VALUES ($cena_id, $ucet_id, '$ucet', '$banka', '$kod_banky', '$p_banking', '$vek_rozmezi', $v_min, $v_max, $v_prich_min, $v_prich_max, $v_odch_min, $v_odch_max, 
$v_karta_min, $v_karta_max, $v_vedeni_min, $v_vedeni_max, $v_vypis_min, $v_vypis_max, '$www', '$typ', '$platnost', '$koment_ucet', '$koment_JP', '$koment_PP', '$koment_trans', '$koment_karta', $vyj_yn)";
$vypocet = vystup_sql($sql_vypocet);
  
}


} // konec r_data loop
?>