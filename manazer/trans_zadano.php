<?php
include "pripojeni_sql_man.php";

mysql_query("START TRANSACTION");

$a1 = mysql_query("update trans_historie set platba_status='hotovo' where platba_id=".$_GET['pid']);
$a2 = mysql_query("call nova_prav_trans(".$_GET['pid'].");");

if ($a1 and $a2) {
    mysql_query("COMMIT");
    echo "success";
} else {        
    mysql_query("ROLLBACK");
    echo "failed";
}


?>