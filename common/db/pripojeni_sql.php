<?php

$id_spojeni = mysqli_connect('localhost', 'root');

if (!$id_spojeni) {
    echo 'spojení k serveru se nezdařilo<br>';
}

$id_cteni_poplatky = mysqli_select_db($id_spojeni, 'poplatky');
if (!$id_cteni_poplatky) {
    echo mysqli_errno($id_spojeni).': '.mysqli_error($id_spojeni).'<br>';
    die('Nepodařilo se nám otevrit db.');
}
echo 'databáze s poplatky načtena<br>';

function vystup_sql($_sql)
{
    global $id_spojeni;
    $query = mysqli_query($id_spojeni, $_sql);
    if (!$query) {
        //echo mysqli_errno($id_spojeni).': '.mysqli_error($id_spojeni).'<br>';
        die(
            "<span style='color:red; font-weight:bold'>Něco se nepovedlo. " .
            "Jdi zpět a zkontroluj, jestli jsou údaje správně zapsané nebo " .
            "nějaké nechybí. Pokud je vše zapsané v pořádku a problém přetrvává, " .
            "pošli mi tyto 2 řádky:</span><p style='color:red'>"
            .mysqli_errno($id_spojeni).': '.mysqli_error($id_spojeni).
            "<BR><i>$_sql</U></i>"
        );
    }
    
    return $query;
}

mysqli_query($id_spojeni, "SET NAMES 'utf8'");

function mysqli_result($res, $row, $field=0)
{
    $res->data_seek($row);
    $datarow = $res->fetch_array();
    return $datarow[$field];
}
?>
