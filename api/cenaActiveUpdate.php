<?php

include '../common/db/pripojeni_sql.php';

vystup_sql("START TRANSACTION");

$a1 = vystup_sql("UPDATE ucty_ceny SET ucty_ceny.cena_active=0");
$a2 = vystup_sql("UPDATE ucty_ceny uc inner join (select uc2.cena_ucet_id, max(uc2.cena_platnost_od) max_od from ucty_ceny uc2 where uc2.cena_platnost_od <= current_date group by uc2.cena_ucet_id) max_id 
		ON max_id.cena_ucet_id=uc.cena_ucet_id and max_id.max_od=uc.cena_platnost_od SET uc.cena_active=1");

if ($a1 and $a2) {
    vystup_sql("COMMIT");
} else {        
    vystup_sql("ROLLBACK");
}

?>