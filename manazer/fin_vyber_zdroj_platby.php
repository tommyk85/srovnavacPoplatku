<?php
include "pripojeni_sql_man.php";

$sql_platne_zdroje = "select * from zdroje where obsolete=0";
vystup_sql($sql_platne_zdroje);
?>