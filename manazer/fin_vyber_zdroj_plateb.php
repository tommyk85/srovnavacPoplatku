<?php
include "pripojeni_sql_man.php";

$sql_platne_zdroje = "select * from zdroje where obsolete=0";
$platne_zdroje = vystup_sql($sql_platne_zdroje);

if (mysql_num_rows($platne_zdroje) == 1) {
  header("Location: fin_platby.php?zdrojUcet=".mysql_result($platne_zdroje, 0, 0)); /* Redirect browser */
  exit();
} else {
  echo "vyber zdrojovy ucet ze seznamu...";
}
?>