<?php
include "pripojeni_sql_man.php";

mysql_query("START TRANSACTION");

$req1 = mysql_query("update oper set os_castka=".$_GET['vklad']." where id=".$_GET['sporId']);

if ($req1) {
    mysql_query("COMMIT");
    
    $sql_sum_platby_os = "SELECT os_ucet, sum(os_castka) as castka 
      FROM oper 
      WHERE os_ucet like (SELECT os_ucet FROM oper WHERE id=".$_GET['sporId'].")
      GROUP BY os_ucet";
    $sum_platby_os = vystup_sql($sql_sum_platby_os);
    
    echo "success|".mysql_result($sum_platby_os, 0, 0)."|".mysql_result($sum_platby_os, 0, 1);
} else {        
    mysql_query("ROLLBACK");
    echo "failed";
}


?>