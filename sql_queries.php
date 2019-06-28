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
?>