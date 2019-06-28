<HTML>
  <HEAD>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <TITLE>Moje finance - prehled plateb</TITLE>
  </HEAD>
<BODY>
<script type='text/javascript'>

function xhttpReq(httpMetoda, req){
  var xhttp = new XMLHttpRequest();
  var resp = "";
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
     // document.getElementById("demo").innerHTML = this.responseText;
    resp = this.responseText;
     
    if (resp.search("success") >= 0){
    console.log("ok - "+resp);
    document.activeElement.disabled = true;}
    else
    console.log(resp);
    }
  };
  xhttp.open(httpMetoda, req, true);
  xhttp.send();

}

function platba(pid){
  xhttpReq("GET", "trans_zadano.php?pid="+pid);
}

function prepocitatNasporeno() {
  var vklad = document.activeElement;
  var nasporeno = vklad.parentElement.nextElementSibling;
  var novyZustatek = nasporeno.nextElementSibling;
   
  novyZustatek.innerText = Number(nasporeno.innerText) + Number(vklad.value);
  
  document.getElementsByName("tlRekalk")[0].disabled = false;  
  //console.log(Number(vklad) + 1)
}

function operRekalkul() {
  var tabOperSpor = document.getElementById("t3");
  var operSporPolozky = t3.getElementsByTagName("TR");
  
  for (var i=1; i < operSporPolozky.length; i++) {
    var vklad = Number(operSporPolozky[i].children[1].children[0].value);
    var sporID = operSporPolozky[i].children[0].getAttribute("sporID");
    
    xhttpReq("GET", "operRekalkul.php?sporId="+sporID+"&vklad="+vklad);    
  }
  
  location.reload();
}

</script>
<CENTER><H1>Prehled budoucich nevyrizenych plateb</H1>

<A HREF="/manazer">Zpet na uvodni stranku.</A><BR>

<?php

include "pripojeni_sql_man.php";
include "datumy.php";
include "../sql_queries.php";

$detailUctu = zustatekNaUctu($_GET["zdrojUcet"]);
$disponZustatek = $detailUctu["stav"] - $detailUctu["sporeni"] - $detailUctu["min"];
echo "<p name='zustatek' value=$disponZustatek>disponibilni zustatek na uctu je $disponZustatek<br />
(min. zustatek = ".$detailUctu["min"]."; na oper. sporeni = ".$detailUctu["sporeni"].")</p>";

$sql_platby = "SELECT trans_historie.* FROM trans_historie, zdroje
WHERE platba_status = 'cekajici' and preferovany=1 and platba_datum<date(concat(pristi_vyplata_termin,den_vyplaty)) ORDER BY platba_datum ASC";
$platby = mysql_query($sql_platby, $id_spojeni);
if(!$platby)
{
  echo mysql_errno($id_spojeni).': '.mysql_error($id_spojeni).'<br>';
  die('Nepodařilo se nám poslat SQL dotaz na detaily pojisteni.');
} 
echo 'Dotaz na platby odeslan.<br>';

?>

<TABLE border=1><legend>Tab2</legend>
<TR>
<TH>Datum platby</TH>
<TH>Ucel transakce</TH>
<TH>Prijemce</TH>
<TH>Castka</TH>
<TH>Poplatek</TH>
<TH>Typ transakce</TH>
<TH>Kód oper. spoř.</TH>
<TH>Částka z OS</TH>
<TH>VS</TH>
<TH>SS</TH>
<TH>KS</TH>
<TH>Zpráva pro příjemce</TH>
<TH></TH>
</TR>


<?php
$soucetT2 = 0;
while($radek_platby = mysql_fetch_assoc($platby))
{
$soucetT2 += $radek_platby['platba_castka'];
echo "<TR><TD>".$radek_platby['platba_datum']."</TD>
<TD>".$radek_platby['platba_ucel']."</TD>
<TD>".$radek_platby['platba_prijemce']."</TD>
<TD style='text-align:right;'>".$radek_platby['platba_castka']."</TD>
<TD style='text-align:right;'>".$radek_platby['platba_poplatek']."</TD>
<TD>".$radek_platby['platba_typ']."</TD>
<TD>".$radek_platby['platba_zdroj_oper']."</TD>
<TD>".$radek_platby['platba_os_castka']."</TD>
<TD>".$radek_platby['platba_vs']."</TD>
<TD>".$radek_platby['platba_ss']."</TD>
<TD>".$radek_platby['platba_ks']."</TD>
<TD>".$radek_platby['platba_zprava']."</TD>
<TD><button onClick='javascript:platba(".$radek_platby['platba_id'].")' ".(
$soucetT2 > $disponZustatek ? 'disabled' : '')." />Hotovo</button></TD>
</TR>";
}

echo "</TABLE>";
echo "<p name='suma' id='sumT2' value=$soucetT2>tab2 celkem = $soucetT2</p>";


$platby_os = vytvorKopiiOperSporVcetneDat();

?>
<TABLE border=1 id='t3'><caption>Tab3</caption>
<TR>
<TH>Kód spoření</TH>
<TH>Vkládaná částka</TH>
<TH>Aktuálně naspořeno</TH>
<TH>Naspořeno+nový vklad</TH>
<TH>Cílová částka</TH>
<TH>Cílový účet</TH>
</TR>

<?php
while($radek_platby_os = mysql_fetch_assoc($platby_os))
{
echo "<TR>
<TD sporID=".$radek_platby_os['id'].">".$radek_platby_os['os_kod']."</TD>
<TD name='vklad'><input type='number' name='vkladano' value=".$radek_platby_os['os_castka']." onChange='prepocitatNasporeno()' /></TD>
<TD>".$radek_platby_os['os_stav']."</TD>
<TD id='nove_celkem'>".number_format($radek_platby_os['os_stav'] + $radek_platby_os['os_castka'], 2)."</TD>
<TD>".$radek_platby_os['os_cilova_castka']."</TD>
<TD>".$radek_platby_os['os_ucet']."</TD>
</TR>";
}

echo "</TABLE>";
echo "<button name='tlRekalk' onClick='operRekalkul()' disabled />Uložit a přepočítat Tab1</button>"
?>
</form>

<TABLE border=1><caption>Tab1</caption>
<TR>
<TH>Datum platby</TH>
<TH>Ucel transakce</TH>
<TH>Castka</TH>
<TH>Poplatek</TH>
<TH>Cílový účet</TH>
<TH></TH>
</TR>


<?php
// mysql_data_seek($platby_os, 0);
$sql_sum_platby_os = "SELECT sum(os_castka) as castka, os_ucet FROM oper GROUP BY os_ucet";
$sum_platby_os = vystup_sql($sql_sum_platby_os);

$soucetT1 = 0;
while($radek_sum_platby_os = mysql_fetch_assoc($sum_platby_os))
{
$soucetT1 += $radek_sum_platby_os['castka'];
echo "<TR><TD>".datumPosledniVyplaty()."</TD>
<TD>operativní spoření</TD>
<TD>".$radek_sum_platby_os['castka']."</TD>
<TD style='text-align:right;'>".$radek_sum_platby_os['platba_poplatek']."</TD>
<TD>".$radek_sum_platby_os['os_ucet']."</TD>
<TD><button onClick='javascript:platba(".$radek_sum_platby_os['os_ucet'].")' ".(
$soucetT2 + $soucetT1 > $disponZustatek ? 'disabled' : '')." />Hotovo</button></TD>
</TR>";
}
echo "</TABLE>";
echo "<p name='suma' id='sumT1' value=$soucetT1>tab1 celkem = $soucetT1</p>";

$balance = $disponZustatek - ($soucetT1+$soucetT2);
echo "<p style='position:absolute; top:100px;left:10%;'>
Balance: <span style='color:".($balance < 0 ? 'red' : 'green')."'>$balance</span>
</p>";
?>

<A HREF="fin_nova_platba.php">Zalozit novou platbu.</A><P>
<A HREF="/manazer">Zpet na uvodni stranku.</A>

<?php

if($id_spojeni)
{
  mysql_close($id_spojeni);
  echo 'odpojeno <br>';
} 
?>


</CENTER>
</BODY>
</HTML>
