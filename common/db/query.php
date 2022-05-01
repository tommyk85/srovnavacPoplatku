<?php

function vytvor_temp_tabulku($nazev)
{
    $sql = "CREATE TEMPORARY TABLE $nazev (
        cena_id INT NOT NULL,
        ucet_id INT NOT NULL,
        ucet VARCHAR(45) NULL,
        banka VARCHAR(45) NULL,
        kod_banky CHAR(4) NULL,
        banking VARCHAR(20) NULL,
        vek VARCHAR(7) NULL,
        min DECIMAL(10,2) NULL,
        max DECIMAL(10,2) NULL,
        prich_min DECIMAL(10,2) NULL,
        prich_max DECIMAL(10,2) NULL,
        odch_min DECIMAL(10,2) NULL,
        odch_max DECIMAL(10,2) NULL,
        karta_min DECIMAL(10,2) NULL,
        karta_max DECIMAL(10,2) NULL,
        vedeni_min DECIMAL(10,2) NULL,
        vedeni_max DECIMAL(10,2) NULL,
        vypis_min DECIMAL(10,2) NULL,
        vypis_max DECIMAL(10,2) NULL,
        www VARCHAR(200) NULL,                                  
        typ_uctu VARCHAR(45) NULL,
        platnost_od DATE NULL,
        koment_ucet TEXT,
        koment_JP TEXT,
        koment_PP TEXT,
        koment_trans TEXT,
        koment_karta TEXT,
        vyj_id INT NULL,  
    PRIMARY KEY (ucet_id))
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8
    COLLATE = utf8_czech_ci";

return vystup_sql($sql);
}

?>